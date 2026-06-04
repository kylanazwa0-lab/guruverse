<?php
require 'config.php';
$c = getConnection();
$user_id = 8;
$enrollments = [];
$stmt_enroll = $c->prepare("SELECT e.id, e.course_id, e.status, e.enrolled_at, e.progress_percent, e.completed_modules, e.current_module, c.title, c.category, c.duration_hours, c.total_modules, c.mentor_name, c.rating, c.total_reviews, c.is_free FROM gb_enrollments e JOIN gb_courses c ON e.course_id = c.id WHERE e.user_id = ? ORDER BY e.enrolled_at DESC");
$stmt_enroll->bind_param('i', $user_id);
$stmt_enroll->execute();
$res_enroll = $stmt_enroll->get_result();
while ($row = $res_enroll->fetch_assoc()) $enrollments[] = $row;
print_r($enrollments[0]);
?>
