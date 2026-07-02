<?php
/**
 * API endpoint for gamification activities
 * Supports actions:
 *  - get: return JSON of a single activity (id param required)
 *  - list: return JSON array of all activities
 */
require_once __DIR__ . '/../services/GamificationService.php';
header('Content-Type: application/json');
$service = new \Admin\Services\GamificationService();
$action = $_GET['action'] ?? 'list';
if ($action === 'get') {
    $id = $_GET['id'] ?? '';
    $activity = $service->getActivityById($id);
    echo json_encode(['success' => $activity !== null, 'activity' => $activity]);
} else { // list
    $activities = $service->getAllActivities();
    echo json_encode(['success' => true, 'activities' => $activities]);
}
?>
