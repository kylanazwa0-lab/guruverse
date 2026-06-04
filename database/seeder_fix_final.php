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
    
    // 2. Clear existing enrollments
    $db->query("SET FOREIGN_KEY_CHECKS = 0");
    $db->query("TRUNCATE TABLE gb_enrollments");
    $db->query("TRUNCATE TABLE gb_certificates");
    $db->query("SET FOREIGN_KEY_CHECKS = 1");

    // 3. Get all courses
    $course_ids = [];
    $res = $db->query("SELECT id, total_modules FROM gb_courses");
    $courses = [];
    while($r = $res->fetch_assoc()) {
        $courses[] = $r;
    }
    
    // 4. Get all member ids
    $member_ids = [];
    $res = $db->query("SELECT id FROM members WHERE role='member'");
    while($r = $res->fetch_assoc()) {
        $member_ids[] = $r['id'];
    }
    
    // 5. Generate enrollments for ALL members
    $stmt_e = $db->prepare("INSERT INTO gb_enrollments (user_id, course_id, status, completed_modules, progress_percent) VALUES (?, ?, ?, ?, ?)");
    
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
    
    foreach ($member_ids as $m_id) {
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
    
    $db->commit();
    echo "Fix enrollments berhasil dijalankan!";
} catch (Exception $e) {
    $db->rollback();
    echo "Error: " . $e->getMessage();
}
$db->close();
