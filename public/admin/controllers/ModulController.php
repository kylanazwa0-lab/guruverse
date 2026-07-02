<?php
// controllers/ModulController.php - CRUD gb_modules + file upload
require_once __DIR__ . '/../../database/config.php';

define('UPLOAD_DIR', __DIR__ . '/../../asset/uploads/modul/');

// Helper: get actual columns of gb_modules once
function _modul_cols($conn) {
    static $cols = null;
    if ($cols === null) {
        $cols = [];
        $cr = $conn->query("SHOW COLUMNS FROM gb_modules");
        while ($col = $cr->fetch_assoc()) $cols[] = $col['Field'];
    }
    return $cols;
}

function modul_get_all($conn, $course_id = null) {
    $where = $course_id ? "WHERE m.course_id=" . (int)$course_id : '';
    $cols  = _modul_cols($conn);
    // Use order_index if it exists, else fall back to id
    $sort  = in_array('order_index', $cols) ? 'm.order_index' : 'm.id';
    $res   = $conn->query("SELECT m.*, c.title as course_title 
                           FROM gb_modules m 
                           LEFT JOIN gb_courses c ON m.course_id = c.id 
                           $where ORDER BY m.course_id, $sort");
    $rows  = [];
    if ($res) while ($r = $res->fetch_assoc()) $rows[] = $r;
    return $rows;
}

function modul_create($conn, $data, $file = null) {
    $cols        = _modul_cols($conn);
    $course_id   = (int)($data['course_id'] ?? 0);
    $title       = $conn->real_escape_string($data['title'] ?? '');
    $description = $conn->real_escape_string($data['description'] ?? '');
    $type        = in_array($data['type'] ?? '', ['video','pdf','text','quiz']) ? $data['type'] : 'text';
    $file_url    = '';

    // Handle file upload
    if ($file && $file['error'] === UPLOAD_ERR_OK) {
        if (!is_dir(UPLOAD_DIR)) mkdir(UPLOAD_DIR, 0755, true);
        $ext      = pathinfo($file['name'], PATHINFO_EXTENSION);
        $filename = 'modul_' . time() . '_' . rand(100, 999) . '.' . $ext;
        $dest     = UPLOAD_DIR . $filename;
        if (move_uploaded_file($file['tmp_name'], $dest)) {
            $file_url = '/guruverse/asset/uploads/modul/' . $filename;
        }
    } elseif (!empty($data['video_url'])) {
        $file_url = $conn->real_escape_string($data['video_url']);
    }

    $file_url_esc = $conn->real_escape_string($file_url);

    // Build INSERT dynamically based on existing columns
    $fields = "course_id,title,file_url,created_at";
    $values = "$course_id,'$title','$file_url_esc',NOW()";

    if (in_array('description', $cols)) {
        $fields .= ",description";
        $values .= ",'$description'";
    }

    if (in_array('type', $cols)) {
        $fields .= ",type";
        $values .= ",'$type'";
    }

    if (in_array('order_index', $cols)) {
        $order_index = (int)($data['order_index'] ?? 1);
        $fields .= ",order_index";
        $values .= ",$order_index";
    }

    $conn->query("INSERT INTO gb_modules ($fields) VALUES ($values)");
    return $conn->insert_id;
}

function modul_update($conn, $id, $data) {
    $cols        = _modul_cols($conn);
    $id          = (int)$id;
    $title       = $conn->real_escape_string($data['title'] ?? '');
    $description = $conn->real_escape_string($data['description'] ?? '');
    $type        = in_array($data['type'] ?? '', ['video','pdf','text','quiz']) ? $data['type'] : 'text';
    $content     = $conn->real_escape_string($data['content'] ?? '');
    $video_url   = $conn->real_escape_string($data['video_url'] ?? '');
    $duration    = (int)($data['duration_minutes'] ?? 0);
    $module_num  = (int)($data['module_number'] ?? 0);

    $set = "title='$title'";
    $set .= ",content='$content'";
    $set .= ",video_url='$video_url'";
    $set .= ",duration_minutes=$duration";
    if ($module_num > 0) $set .= ",module_number=$module_num";

    if (in_array('description', $cols)) {
        $set .= ",description='$description'";
    }
    if (in_array('type', $cols)) {
        $set .= ",type='$type'";
    }
    if (in_array('order_index', $cols)) {
        $order_index = (int)($data['order_index'] ?? 1);
        $set .= ",order_index=$order_index";
    }

    // Save quiz_data as JSON
    if (in_array('quiz_data', $cols)) {
        $quiz_raw = $data['quiz_data'] ?? '';
        if (!empty($quiz_raw)) {
            $quiz_decoded = json_decode($quiz_raw, true);
            if (json_last_error() === JSON_ERROR_NONE) {
                $quiz_escaped = $conn->real_escape_string($quiz_raw);
                $set .= ",quiz_data='$quiz_escaped'";
            }
        } else {
            $set .= ",quiz_data=NULL";
        }
    }

    $conn->query("UPDATE gb_modules SET $set WHERE id=$id");
    return $conn->affected_rows;
}

function modul_delete($conn, $id) {
    $id = (int)$id;
    $conn->query("DELETE FROM gb_modules WHERE id=$id");
    return $conn->affected_rows;
}
