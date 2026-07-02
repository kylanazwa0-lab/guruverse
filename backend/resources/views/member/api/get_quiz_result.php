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

$course_id = isset($_GET['course_id']) ? (int)$_GET['course_id'] : 0;
$module_number = isset($_GET['module_number']) ? (int)$_GET['module_number'] : 0;

if (!$course_id || !$module_number) {
    echo json_encode(['success' => false, 'message' => 'Invalid parameters']);
    exit;
}

// Get latest result
$stmt = $conn->prepare("SELECT score, answers_json FROM gb_quiz_results WHERE user_id = ? AND course_id = ? AND module_number = ? ORDER BY created_at DESC LIMIT 1");
$stmt->bind_param("iii", $user_id, $course_id, $module_number);
$stmt->execute();
$res = $stmt->get_result();

if ($row = $res->fetch_assoc()) {
    echo json_encode([
        'success' => true,
        'score' => (int)$row['score'],
        'answers' => json_decode($row['answers_json'], true)
    ]);
} else {
    echo json_encode(['success' => false, 'message' => 'Result not found']);
}
?>
