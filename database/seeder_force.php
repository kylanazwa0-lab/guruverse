<?php
require_once __DIR__ . '/config.php';
$db = getConnection();

try {
    $db->begin_transaction();
    
    // Insert dummy members for IDs 1 to 10 if they don't exist
    $pw = '$2y$10$TSEjv7njhh41e/0yfbBh8u7vi1lj6D9TapE/WcYEdri3wY7z3tGk.';
    $stmt = $db->prepare("INSERT IGNORE INTO members (id, member_id, full_name, email, username, institution, subject, password, role, phone) VALUES (?, ?, ?, ?, ?, 'Sekolah', 'Guru', ?, 'member', '0811')");
    
    for ($i = 1; $i <= 10; $i++) {
        // Only if it doesn't exist
        $res = $db->query("SELECT id FROM members WHERE id=$i");
        if ($res->num_rows == 0) {
            $mid = "00$i-FIX";
            $fn = "Guru $i";
            $em = "guru$i@gv.id";
            $un = "guru_dummy_$i";
            $stmt->bind_param("isssss", $i, $mid, $fn, $em, $un, $pw);
            $stmt->execute();
        }
    }
    
    // Make sure Gamification stats exist for 1 to 10
    for ($i = 1; $i <= 10; $i++) {
        $db->query("INSERT IGNORE INTO gb_mengajar_stats (member_id, jam_mengajar, siswa_terbantu, total_xp, level_saat_ini, hari_streak) VALUES ($i, 100, 200, 3000, 3, 5)");
    }
    
    // Fetch all courses
    $course_ids = [];
    $res = $db->query("SELECT id, total_modules FROM gb_courses");
    $courses = [];
    while($r = $res->fetch_assoc()) $courses[] = $r;
    
    // Insert enrollments and certificates for IDs 1 to 10
    $stmt_e = $db->prepare("INSERT IGNORE INTO gb_enrollments (user_id, course_id, status, completed_modules, progress_percent) VALUES (?, ?, ?, ?, ?)");
    
    $res_cert = $db->query("SHOW COLUMNS FROM gb_certificates LIKE 'certificate_url'");
    $has_cert_url = ($res_cert->num_rows > 0);
    $res_file = $db->query("SHOW COLUMNS FROM gb_certificates LIKE 'file_url'");
    $has_file_url = ($res_file->num_rows > 0);
    
    if ($has_cert_url) {
        $stmt_cert = $db->prepare("INSERT IGNORE INTO gb_certificates (user_id, course_id, certificate_url) VALUES (?, ?, 'dummy_cert.pdf')");
    } else if ($has_file_url) {
        $stmt_cert = $db->prepare("INSERT IGNORE INTO gb_certificates (user_id, course_id, file_url) VALUES (?, ?, 'dummy_cert.pdf')");
    } else {
        $stmt_cert = $db->prepare("INSERT IGNORE INTO gb_certificates (user_id, course_id) VALUES (?, ?)");
    }

    for ($m_id = 1; $m_id <= 10; $m_id++) {
        foreach ($courses as $c) {
            $c_id = $c['id'];
            $total_m = (int)$c['total_modules'];
            if ($total_m == 0) $total_m = 5;
            
            $completed = rand(1, $total_m);
            $pct = round(($completed / $total_m) * 100);
            $status = ($completed == $total_m) ? 'completed' : 'in_progress';
            
            $stmt_e->bind_param("iisii", $m_id, $c_id, $status, $completed, $pct);
            $stmt_e->execute();
            
            if ($status == 'completed') {
                $stmt_cert->bind_param("ii", $m_id, $c_id);
                $stmt_cert->execute();
            }
        }
    }
    
    $db->commit();
    echo "ID 1-10 dijamin memiliki enrollments!";
} catch (Exception $e) {
    $db->rollback();
    echo "Error: " . $e->getMessage();
}
$db->close();
