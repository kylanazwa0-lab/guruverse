<?php
// controllers/KelasController.php - CRUD gb_courses
require_once __DIR__ . '/../../database/config.php';

function kelas_get_all($conn, $search = '') {
    $where = $search ? "WHERE title LIKE '%" . $conn->real_escape_string($search) . "%' OR category LIKE '%" . $conn->real_escape_string($search) . "%'" : '';
    $res = $conn->query("SELECT * FROM gb_courses $where ORDER BY created_at DESC");
    $rows = [];
    while ($r = $res->fetch_assoc()) $rows[] = $r;
    return $rows;
}

function kelas_create($conn, $data) {
    $upload_dir = __DIR__ . '/../../uploads/cert_templates/';
    if (!is_dir($upload_dir)) mkdir($upload_dir, 0777, true);
    
    $cert_template = '';
    if (isset($_FILES['cert_template']) && $_FILES['cert_template']['error'] === UPLOAD_ERR_OK) {
        $filename = time() . '_' . basename($_FILES['cert_template']['name']);
        if (move_uploaded_file($_FILES['cert_template']['tmp_name'], $upload_dir . $filename)) {
            $cert_template = $filename;
        }
    }
    
    $title        = $conn->real_escape_string($data['title'] ?? '');
    $category     = $conn->real_escape_string($data['category'] ?? '');
    $description  = $conn->real_escape_string($data['description'] ?? '');
    $mentor       = $conn->real_escape_string($data['mentor_name'] ?? '');
    $duration     = (int)($data['duration_hours'] ?? 0);
    $status       = in_array($data['status'] ?? '', ['active','draft','archived']) ? $data['status'] : 'draft';
    $is_free      = (isset($data['is_paid']) && $data['is_paid'] == '1') ? 0 : 1;
    $payment_link = $conn->real_escape_string($data['payment_link'] ?? '');
    $cert_name_y  = (int)($data['cert_name_y'] ?? 500);
    $cert_config  = $conn->real_escape_string($data['cert_config'] ?? '');
    
    $conn->query("INSERT INTO gb_courses (title,category,description,mentor_name,duration_hours,status,is_free,payment_link,cert_template,cert_name_y,cert_config,created_at) 
                  VALUES ('$title','$category','$description','$mentor',$duration,'$status',$is_free,'$payment_link','$cert_template',$cert_name_y,'$cert_config',NOW())");
    return $conn->insert_id;
}

function kelas_update($conn, $id, $data) {
    $id           = (int)$id;
    
    $upload_dir = __DIR__ . '/../../uploads/cert_templates/';
    if (!is_dir($upload_dir)) mkdir($upload_dir, 0777, true);
    
    $cert_template_sql = "";
    if (isset($_FILES['cert_template']) && $_FILES['cert_template']['error'] === UPLOAD_ERR_OK) {
        $filename = time() . '_' . basename($_FILES['cert_template']['name']);
        if (move_uploaded_file($_FILES['cert_template']['tmp_name'], $upload_dir . $filename)) {
            $cert_template_sql = ", cert_template='" . $conn->real_escape_string($filename) . "'";
        }
    }
    
    $title        = $conn->real_escape_string($data['title'] ?? '');
    $category     = $conn->real_escape_string($data['category'] ?? '');
    $description  = $conn->real_escape_string($data['description'] ?? '');
    $mentor       = $conn->real_escape_string($data['mentor_name'] ?? '');
    $duration     = (int)($data['duration_hours'] ?? 0);
    $status       = in_array($data['status'] ?? '', ['active','draft','archived']) ? $data['status'] : 'draft';
    $is_free      = (isset($data['is_paid']) && $data['is_paid'] == '1') ? 0 : 1;
    $payment_link = $conn->real_escape_string($data['payment_link'] ?? '');
    $cert_name_y  = (int)($data['cert_name_y'] ?? 500);
    $cert_config  = $conn->real_escape_string($data['cert_config'] ?? '');
    
    $conn->query("UPDATE gb_courses SET title='$title',category='$category',description='$description',
                  mentor_name='$mentor',duration_hours=$duration,status='$status',is_free=$is_free, payment_link='$payment_link', cert_name_y=$cert_name_y, cert_config='$cert_config' $cert_template_sql WHERE id=$id");
    return $conn->affected_rows;
}

function kelas_delete($conn, $id) {
    $id = (int)$id;
    $conn->query("DELETE FROM gb_courses WHERE id=$id");
    return $conn->affected_rows;
}
