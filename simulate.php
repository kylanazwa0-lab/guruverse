<?php
require_once __DIR__ . '/database/config.php';
$conn = getConnection();

$user_id = 8; // Intan Lestari
$course_id = 1; // Strategi
$module_number = 5; // Modul 5 (terakhir)
$score = 90;

// 1. Pastikan template sudah diatur di database
$conn->query("UPDATE gb_courses SET cert_template = '1780037748_Wave Elegant Certificate of Appreciation (3).png', cert_name_y = 500 WHERE id = $course_id");

// 2. Hapus sertifikat lama jika ada agar sistem mau men-generate yang baru
$conn->query("DELETE FROM gb_certificates WHERE user_id = $user_id AND course_id = $course_id");

// 3. Masukkan hasil kuis untuk modul 1-5 (simulasi sudah selesai semua kuis)
for ($i=1; $i<=5; $i++) {
    $conn->query("INSERT INTO gb_quiz_results (user_id, course_id, module_number, score, answers_json) VALUES ($user_id, $course_id, $i, 90, '{}')");
}

// 4. Update enrollments completed_modules
$conn->query("UPDATE gb_enrollments SET completed_modules = 5 WHERE user_id = $user_id AND course_id = $course_id");

// 5. Generate sertifikat (Logic yang sama seperti di complete_module.php)
$stmtCourse = $conn->prepare("SELECT title, total_modules, cert_template, cert_name_y, cert_config FROM gb_courses WHERE id = ?");
$stmtCourse->bind_param("i", $course_id);
$stmtCourse->execute();
$courseInfo = $stmtCourse->get_result()->fetch_assoc();

$stmtMember = $conn->prepare("SELECT full_name FROM members WHERE id = ?");
$stmtMember->bind_param("i", $user_id);
$stmtMember->execute();
$memberInfo = $stmtMember->get_result()->fetch_assoc();

$member_name = $memberInfo['full_name'];
$course_title = $courseInfo['title'];
$cert_template = $courseInfo['cert_template'];
$y_pos = (int)($courseInfo['cert_name_y']);
$cert_config = $courseInfo['cert_config'];

$cert_number = 'GV-' . date('Ymd') . '-' . sprintf('%04d', $user_id) . '-' . sprintf('%04d', $course_id);
$pdf_path = null;

if (!empty($cert_template)) {
    $template_path = __DIR__ . '/uploads/cert_templates/' . $cert_template;
    if (file_exists($template_path)) {
        require_once __DIR__ . '/guru-belajar/member/api/generate_certificate.php';
        $output_filename = 'cert_' . $cert_number . '.jpg';
        $output_path = __DIR__ . '/uploads/certificates/' . $output_filename;
        
        $date_str = date('d F Y');
        
        // Debugging
        $result = generateCertificate($member_name, $course_title, $cert_number, $date_str, $template_path, $output_path, $y_pos, $cert_config);
        var_dump("generateCertificate Result:", $result);
        
        if ($result) {
            $pdf_path = $output_filename;
        }
    } else {
        echo "Template file not found at $template_path\n";
    }
} else {
    echo "cert_template is empty in DB\n";
}

$stmtSaveCert = $conn->prepare("INSERT INTO gb_certificates (user_id, course_id, certificate_number, pdf_path) VALUES (?, ?, ?, ?)");
$stmtSaveCert->bind_param("iiss", $user_id, $course_id, $cert_number, $pdf_path);
$stmtSaveCert->execute();

echo "Done! Certificate generated for $member_name. PDF Path: $pdf_path";
?>
