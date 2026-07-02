<?php
ini_set('display_errors', 0);
error_reporting(E_ALL);
ob_start();

if (session_status() === PHP_SESSION_NONE) {
    ini_set('session.cookie_path', '/');
    ini_set('session.cookie_samesite', 'Lax');
    session_start();
}
header('Content-Type: application/json; charset=utf-8');

function sendJsonResponse($success, $message = '', $data = [], $httpCode = 200) {
    if (ob_get_length()) ob_clean();
    http_response_code($httpCode);
    echo json_encode(array_merge(['success' => $success, 'message' => $message], $data));
    exit;
}

$user_id = $_SESSION['member_int_id'] ?? null;
if (!$user_id || empty($_SESSION['member_logged_in'])) {
    sendJsonResponse(false, 'Unauthorized', [], 401);
}

$configPath = __DIR__ . '/../../../database/config.php';
if (!file_exists($configPath)) {
    sendJsonResponse(false, 'DB Config not found');
}
require_once $configPath;

try {
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    $conn = getConnection();
} catch (Exception $e) {
    sendJsonResponse(false, 'DB Connection failed');
}

$course_id = isset($_GET['course_id']) ? (int)$_GET['course_id'] : 0;

if ($course_id === 0) {
    // get latest active course
    $stmt = $conn->prepare("SELECT course_id FROM gb_enrollments WHERE user_id = ? ORDER BY enrolled_at DESC LIMIT 1");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $res = $stmt->get_result();
    if ($row = $res->fetch_assoc()) {
        $course_id = $row['course_id'];
    }
    $stmt->close();
}

if ($course_id === 0) {
    sendJsonResponse(false, 'No active course found');
}

// Fetch Course Info
$course = null;
$stmt = $conn->prepare("SELECT c.*, e.progress_percent, e.completed_modules, e.status as enrollment_status FROM gb_courses c JOIN gb_enrollments e ON c.id = e.course_id WHERE c.id = ? AND e.user_id = ?");
$stmt->bind_param("ii", $course_id, $user_id);
$stmt->execute();
$res = $stmt->get_result();
if ($row = $res->fetch_assoc()) {
    $course = $row;
}
$stmt->close();

if (!$course) {
    sendJsonResponse(false, 'Course not found or not enrolled');
}

// Fetch Modules
$modules = [];
$stmt = $conn->prepare("SELECT * FROM gb_modules WHERE course_id = ? ORDER BY module_number ASC");
$stmt->bind_param("i", $course_id);
$stmt->execute();
$res = $stmt->get_result();
while ($row = $res->fetch_assoc()) {
    if (!empty($row['quiz_data'])) {
        $row['quiz_data'] = json_decode($row['quiz_data'], true);
    } else {
        $row['quiz_data'] = null;
    }
    $modules[] = $row;
}
$stmt->close();

// Fetch Quiz Results for this user & course
$quiz_results = [];
$stmt = $conn->prepare("SELECT module_number, score FROM gb_quiz_results WHERE course_id = ? AND user_id = ?");
$stmt->bind_param("ii", $course_id, $user_id);
$stmt->execute();
$res = $stmt->get_result();
while ($row = $res->fetch_assoc()) {
    $quiz_results[$row['module_number']] = (int)$row['score'];
}
$stmt->close();

// Enforce TANDUR structure
$tandur_names = [
    1 => 'Tumbuhkan - Pertemuan ke 1 (Pendahuluan)',
    2 => 'Alami - Pertemuan Ke 2 (Konsep Dasar)',
    3 => 'Namai - Pertemuan ke 3 (Strategi Penerapan)',
    4 => 'Demonstrasikan - Studi Kasus',
    5 => 'Ulangi - Evaluasi',
    6 => 'Rayakan - Penutup'
];

$tandur_modules = [];
for ($i = 1; $i <= 6; $i++) {
    // Find matching module by number, or use placeholder
    $mod = null;
    foreach ($modules as $m) {
        if ((int)$m['module_number'] === $i) {
            $mod = $m;
            break;
        }
    }
    
    if (!$mod && isset($modules[$i-1])) {
       // fallback to index
       $mod = $modules[$i-1];
    }
    
        if ($mod) {
        $mod['tandur_name'] = $tandur_names[$i];
        
        // Fetch score if exists
        $mod['user_score'] = isset($quiz_results[$i]) ? $quiz_results[$i] : null;
        $hasTakenQuiz = ($mod['user_score'] !== null);
        
        // Check progress
        // A module is completed if it's <= completed_modules OR if the user has taken the quiz (even if they failed)
        $mod['is_completed'] = ($i <= (int)$course['completed_modules']) || $hasTakenQuiz;
        $mod['is_locked'] = ($i > (int)$course['completed_modules'] + 1);
        
        // MOCK QUIZ DATA IF EMPTY
        if (empty($mod['quiz_data'])) {
            $mod['quiz_data'] = [
                [
                    "id" => "q1",
                    "question" => "Apa prinsip utama dari tahap " . $tandur_names[$i] . "?",
                    "options" => [
                        ["id" => "a", "text" => "Menghafal materi tanpa praktik"],
                        ["id" => "b", "text" => "Menerapkan pembelajaran bermakna bagi siswa"],
                        ["id" => "c", "text" => "Mengerjakan tugas administratif"],
                        ["id" => "d", "text" => "Memberikan nilai instan"]
                    ],
                    "answer" => "b"
                ],
                [
                    "id" => "q2",
                    "question" => "Bagaimana cara terbaik mengevaluasi pemahaman siswa di tahap ini?",
                    "options" => [
                        ["id" => "a", "text" => "Asesmen Formatif yang berkesinambungan"],
                        ["id" => "b", "text" => "Ujian dadakan yang sulit"],
                        ["id" => "c", "text" => "Memberikan hukuman"],
                        ["id" => "d", "text" => "Hanya menggunakan nilai akhir"]
                    ],
                    "answer" => "a"
                ]
            ];
        }

        $tandur_modules[] = $mod;
    } else {
        // Placeholder
        $tandur_modules[] = [
            'id' => 0,
            'course_id' => $course_id,
            'module_number' => $i,
            'title' => $tandur_names[$i] . ' (Coming Soon)',
            'tandur_name' => $tandur_names[$i],
            'duration_minutes' => 0,
            'video_url' => '',
            'content' => '<p>Selamat datang di tahap <b>' . $tandur_names[$i] . '</b>.</p><p>Materi ini didesain khusus agar Anda dapat memahami konsep secara mendalam. Jangan lupa untuk mencatat poin-poin penting menggunakan fitur Catatan di bawah ini, dan kerjakan Quiz setelah Anda selesai membaca materi ini untuk mengukur pemahaman Anda.</p>',
            'user_score' => isset($quiz_results[$i]) ? $quiz_results[$i] : null,
            'is_locked' => ($i > (int)$course['completed_modules'] + 1),
            'is_completed' => ($i <= (int)$course['completed_modules']) || isset($quiz_results[$i]),
            'quiz_data' => [
                [
                    "id" => "q1",
                    "question" => "Apa prinsip utama dari tahap " . $tandur_names[$i] . "?",
                    "options" => [
                        ["id" => "a", "text" => "Menghafal materi tanpa praktik"],
                        ["id" => "b", "text" => "Menerapkan pembelajaran bermakna bagi siswa"],
                        ["id" => "c", "text" => "Mengerjakan tugas administratif"],
                        ["id" => "d", "text" => "Memberikan nilai instan"]
                    ],
                    "answer" => "b"
                ]
            ]
        ];
    }
}

sendJsonResponse(true, 'OK', [
    'course' => $course,
    'modules' => $tandur_modules
]);
