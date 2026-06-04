<?php
// ============================================
// api/get_members.php
// ============================================
ini_set('session.cookie_path', '/');
ini_set('session.cookie_samesite', 'Lax');
session_start();
header('Content-Type: application/json; charset=utf-8');

if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    http_response_code(401);
    echo json_encode(['success' => false, 'message' => 'Unauthorized.']);
    exit;
}

require_once '../database/config.php';
$conn = getConnection();

// Stats
$today = date('Y-m-d');
$month = date('Y-m');

$stTotal = $conn->query("SELECT COUNT(*) AS c FROM members")->fetch_assoc()['c'];
$stToday = $conn->query("SELECT COUNT(*) AS c FROM members WHERE DATE(joined_at) = '$today'")->fetch_assoc()['c'];
$stMonth = $conn->query("SELECT COUNT(*) AS c FROM members WHERE DATE_FORMAT(joined_at,'%Y-%m') = '$month'")->fetch_assoc()['c'];

// Members
$result = $conn->query("SELECT * FROM members ORDER BY joined_at DESC, id DESC");
$members = [];

while ($row = $result->fetch_assoc()) {
    // Kirim foto sebagai URL relatif atau base64
    $photoUrl = null;
    if (!empty($row['photo'])) {
        $absPath = '../' . $row['photo'];
        if (file_exists($absPath)) {
            // Kirim sebagai base64 agar bisa ditampilkan dari mana saja
            $photoUrl = 'data:image/jpeg;base64,' . base64_encode(file_get_contents($absPath));
        }
    }

    $members[] = [
        'memberId'    => $row['member_id'],
        'fullName'    => $row['full_name'],
        'email'       => $row['email'],
        'institution' => $row['institution'],
        'phone'       => $row['phone'],
        'photo'       => $photoUrl,
        'joinedAt'    => $row['joined_at'],
    ];
}

$conn->close();

echo json_encode([
    'success' => true,
    'members' => $members,
    'stats'   => [
        'total' => (int)$stTotal,
        'today' => (int)$stToday,
        'month' => (int)$stMonth,
    ],
]);