<?php
require_once __DIR__ . '/config.php';
$db = getConnection();

try {
    // 1. Alter gb_enrollments to add completed_modules if it doesn't exist
    $res = $db->query("SHOW COLUMNS FROM gb_enrollments LIKE 'completed_modules'");
    if ($res->num_rows == 0) {
        $db->query("ALTER TABLE gb_enrollments ADD COLUMN completed_modules INT DEFAULT 0");
    }

    $db->begin_transaction();
    
    // 2. Force ID 3 and 4 to exist so active sessions don't break
    $stmt = $db->prepare("INSERT IGNORE INTO members (id, member_id, full_name, email, username, institution, subject, password, role, phone) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    
    $pw = '$2y$10$TSEjv7njhh41e/0yfbBh8u7vi1lj6D9TapE/WcYEdri3wY7z3tGk.';
    $id3 = 3; $mid3 = '003-GV-2026'; $fn3 = 'Intan Lestari, S.Pd'; $em3 = 'intan@guruverse.id'; $un3 = 'intan';
    $inst3 = 'SDN 1 Jakarta'; $subj3 = 'Guru Kelas'; $role = 'member'; $phone = '081234567890';
    $stmt->bind_param("isssssssss", $id3, $mid3, $fn3, $em3, $un3, $inst3, $subj3, $pw, $role, $phone);
    $stmt->execute();
    
    $id4 = 4; $mid4 = '004-GV-2026'; $fn4 = 'Test User'; $em4 = 'test@guruverse.id'; $un4 = 'test';
    $inst4 = 'SDN 2 Jakarta'; $subj4 = 'Guru Kelas';
    $stmt->bind_param("isssssssss", $id4, $mid4, $fn4, $em4, $un4, $inst4, $subj4, $pw, $role, $phone);
    $stmt->execute();
    
    // 3. Clear existing enrollments
    $db->query("TRUNCATE TABLE gb_enrollments");
    $db->query("TRUNCATE TABLE gb_certificates");

    // 4. Get all courses
    $course_ids = [];
    $res = $db->query("SELECT id, total_modules FROM gb_courses");
    $courses = [];
    while($r = $res->fetch_assoc()) {
        $courses[] = $r;
    }
    
    // 5. Generate enrollments for ID 3 and 4
    $stmt_e = $db->prepare("INSERT INTO gb_enrollments (user_id, course_id, status, completed_modules, progress_percent) VALUES (?, ?, ?, ?, ?)");
    
    // Check what the column is for certificate
    $res_cert = $db->query("SHOW COLUMNS FROM gb_certificates LIKE 'certificate_url'");
    $has_cert_url = ($res_cert->num_rows > 0);
    $res_file = $db->query("SHOW COLUMNS FROM gb_certificates LIKE 'file_url'");
    $has_file_url = ($res_file->num_rows > 0);
    
    if ($has_cert_url) {
        $stmt_cert = $db->prepare("INSERT INTO gb_certificates (user_id, course_id, certificate_url) VALUES (?, ?, 'dummy_cert.pdf')");
    } else if ($has_file_url) {
        $stmt_cert = $db->prepare("INSERT INTO gb_certificates (user_id, course_id, file_url) VALUES (?, ?, 'dummy_cert.pdf')");
    } else {
        $stmt_cert = $db->prepare("INSERT INTO gb_certificates (user_id, course_id) VALUES (?, ?)");
    }
    
    $target_ids = [3, 4];
    foreach ($target_ids as $m_id) {
        foreach ($courses as $c) {
            $c_id = $c['id'];
            $total_m = (int)$c['total_modules'];
            if ($total_m == 0) $total_m = 5; // fallback
            
            $completed = rand(1, $total_m);
            $pct = round(($completed / $total_m) * 100);
            $status = ($completed == $total_m) ? 'completed' : 'in_progress';
            
            $stmt_e->bind_param("iisii", $m_id, $c_id, $status, $completed, $pct);
            $stmt_e->execute();
            
            if ($status == 'completed') {
                if ($has_cert_url || $has_file_url) {
                    $stmt_cert->bind_param("ii", $m_id, $c_id);
                } else {
                    $stmt_cert->bind_param("ii", $m_id, $c_id);
                }
                $stmt_cert->execute();
            }
        }
    }
    
    // 6. Ensure gamification stats exist for id 3 and 4
    $stmt_stat = $db->prepare("INSERT IGNORE INTO gb_mengajar_stats (member_id, jam_mengajar, siswa_terbantu, total_xp, level_saat_ini, hari_streak) VALUES (?, 120, 250, 4500, 5, 12)");
    $stmt_stat->bind_param("i", $id3); $stmt_stat->execute();
    $stmt_stat->bind_param("i", $id4); $stmt_stat->execute();
    
    $db->commit();
    echo "Fix seeder berhasil dijalankan dan kolom completed_modules ditambahkan!";
} catch (Exception $e) {
    $db->rollback();
    echo "Error: " . $e->getMessage();
}
$db->close();
