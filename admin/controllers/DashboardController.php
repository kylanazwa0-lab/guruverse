<?php
// controllers/DashboardController.php
require_once __DIR__ . '/../../database/config.php';
function dashboard_stats($conn) {
    $stats = [];
    $stats['total_member']     = $conn->query("SELECT COUNT(*) c FROM members")->fetch_assoc()['c'] ?? 0;
    $stats['total_kelas']      = $conn->query("SELECT COUNT(*) c FROM gb_courses")->fetch_assoc()['c'] ?? 0;
    $stats['total_modul']      = $conn->query("SELECT COUNT(*) c FROM gb_modules")->fetch_assoc()['c'] ?? 0;
    $stats['total_sertifikat'] = $conn->query("SELECT COUNT(*) c FROM gb_certificates")->fetch_assoc()['c'] ?? 0;
    $stats['total_diskusi']    = $conn->query("SELECT COUNT(*) c FROM gb_discussions")->fetch_assoc()['c'] ?? 0;
    $stats['new_today']        = $conn->query("SELECT COUNT(*) c FROM members WHERE DATE(joined_at)=CURDATE()")->fetch_assoc()['c'] ?? 0;
    
    // Guru Mengajar Stats
    try {
        $stats['total_jam_mengajar'] = $conn->query("SELECT SUM(jam_mengajar) c FROM gb_mengajar_stats")->fetch_assoc()['c'] ?? 0;
        $stats['total_xp_mengajar']  = $conn->query("SELECT SUM(total_xp) c FROM gb_mengajar_stats")->fetch_assoc()['c'] ?? 0;
    } catch (Exception $e) {
        $stats['total_jam_mengajar'] = 0;
        $stats['total_xp_mengajar']  = 0;
    }

    // Guru Inspira Stats
    try {
        $stats['total_cerita'] = $conn->query("SELECT COUNT(*) c FROM gb_inspira_cerita")->fetch_assoc()['c'] ?? 0;
    } catch (Exception $e) {
        $stats['total_cerita'] = 0;
    }

    // Recent 5 members
    $stats['recent_members'] = [];
    $res = $conn->query("SELECT id,full_name,institution,joined_at as created_at FROM members ORDER BY joined_at DESC LIMIT 5");
    while ($r = $res->fetch_assoc()) $stats['recent_members'][] = $r;
    
    // Recent 5 kelas
    $stats['recent_kelas'] = [];
    $res = $conn->query("SELECT id,title,category,status,created_at FROM gb_courses ORDER BY created_at DESC LIMIT 5");
    while ($r = $res->fetch_assoc()) $stats['recent_kelas'][] = $r;
    
    return $stats;
}
