<?php
require_once __DIR__ . '/../../../database/config.php';
$conn = getConnection();

if (session_status() === PHP_SESSION_NONE) {
    ini_set('session.cookie_path', '/');
    ini_set('session.cookie_samesite', 'Lax');
    session_start();
}

header('Content-Type: application/json');

$user_id = $_SESSION['member_int_id'] ?? null;
if (!$user_id) {
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit;
}

$course_id = isset($_POST['course_id']) ? (int)$_POST['course_id'] : 0;
$module_number = isset($_POST['module_number']) ? (int)$_POST['module_number'] : 0;
$score = isset($_POST['score']) ? (int)$_POST['score'] : 100;
$answers_json = isset($_POST['answers_json']) ? $_POST['answers_json'] : '{}';

if (!$course_id || !$module_number) {
    echo json_encode(['success' => false, 'message' => 'Invalid parameters']);
    exit;
}

// Save quiz result
$stmtRes = $conn->prepare("INSERT INTO gb_quiz_results (user_id, course_id, module_number, score, answers_json) VALUES (?, ?, ?, ?, ?) ON DUPLICATE KEY UPDATE score = VALUES(score), answers_json = VALUES(answers_json)");
// Oh wait, I don't have UNIQUE index for ON DUPLICATE KEY UPDATE in gb_quiz_results. Let's just INSERT normally, we can have multiple attempts.
$stmtRes = $conn->prepare("INSERT INTO gb_quiz_results (user_id, course_id, module_number, score, answers_json) VALUES (?, ?, ?, ?, ?)");
$stmtRes->bind_param("iiiis", $user_id, $course_id, $module_number, $score, $answers_json);
$stmtRes->execute();

// Get current progress
$stmt = $conn->prepare("SELECT completed_modules FROM gb_enrollments WHERE course_id = ? AND user_id = ?");
$stmt->bind_param("ii", $course_id, $user_id);
$stmt->execute();
$res = $stmt->get_result();

if ($row = $res->fetch_assoc()) {
    $current = (int)$row['completed_modules'];
    
    // Only update if they completed a new module AND they scored 75
    if ($module_number > $current && $score >= 75) {
        // Cek total_modules dari kelas ini untuk progress
        $stmtCourse = $conn->prepare("SELECT title, total_modules, cert_template, cert_name_y, cert_config FROM gb_courses WHERE id = ?");
        $stmtCourse->bind_param("i", $course_id);
        $stmtCourse->execute();
        $courseInfo = $stmtCourse->get_result()->fetch_assoc();
        
        $total_mod = (int)($courseInfo['total_modules'] ?? 6);
        $progress = min(100, round(($module_number / $total_mod) * 100));
        
        $stmtUpdate = $conn->prepare("UPDATE gb_enrollments SET completed_modules = ?, progress_percent = ? WHERE course_id = ? AND user_id = ?");
        $stmtUpdate->bind_param("iiii", $module_number, $progress, $course_id, $user_id);
        $stmtUpdate->execute();
        
        // Cek apakah ini modul terakhir
        
        if ($courseInfo && $module_number >= (int)$courseInfo['total_modules']) {
            // Lulus kelas! Update status enrollment
            $stmtComplete = $conn->prepare("UPDATE gb_enrollments SET status = 'completed', progress_percent = 100 WHERE course_id = ? AND user_id = ?");
            $stmtComplete->bind_param("ii", $course_id, $user_id);
            $stmtComplete->execute();

            // Cek apakah sudah punya sertifikat
            $stmtCheckCert = $conn->prepare("SELECT id FROM gb_certificates WHERE user_id = ? AND course_id = ?");
            $stmtCheckCert->bind_param("ii", $user_id, $course_id);
            $stmtCheckCert->execute();
            if ($stmtCheckCert->get_result()->num_rows === 0) {
                // Generate Sertifikat
                $stmtMember = $conn->prepare("SELECT full_name FROM members WHERE id = ?");
                $stmtMember->bind_param("i", $user_id);
                $stmtMember->execute();
                $memberInfo = $stmtMember->get_result()->fetch_assoc();
                
                $member_name = $memberInfo['full_name'] ?? 'Peserta';
                $course_title = $courseInfo['title'];
                $cert_template = $courseInfo['cert_template'];
                $y_pos = (int)($courseInfo['cert_name_y'] ?? 500);
                $cert_config = $courseInfo['cert_config'];
                
                $cert_number = 'GV-' . date('Ymd') . '-' . sprintf('%04d', $user_id) . '-' . sprintf('%04d', $course_id);
                
                $pdf_path = null;
                if (!empty($cert_template)) {
                    $template_path = __DIR__ . '/../../../../uploads/cert_templates/' . $cert_template;
                    if (file_exists($template_path)) {
                        require_once __DIR__ . '/generate_certificate.php';
                        $output_filename = 'cert_' . $cert_number . '.jpg';
                        $output_path = __DIR__ . '/../../../../uploads/certificates/' . $output_filename;
                        
                        $date_str = date('d F Y');
                        if (generateCertificate($member_name, $course_title, $cert_number, $date_str, $template_path, $output_path, $y_pos, $cert_config)) {
                            $pdf_path = $output_filename;
                        }
                    }
                }
                
                // Simpan ke database
                $stmtSaveCert = $conn->prepare("INSERT INTO gb_certificates (user_id, course_id, certificate_number, pdf_path) VALUES (?, ?, ?, ?)");
                $stmtSaveCert->bind_param("iiss", $user_id, $course_id, $cert_number, $pdf_path);
                $stmtSaveCert->execute();
            }
        }
    }
    
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'Course enrollment not found']);
}
?>
