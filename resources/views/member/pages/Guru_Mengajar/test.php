<?php
$_SERVER['REQUEST_METHOD'] = 'GET';
$_GET['action'] = 'get_batches';
$_GET['pelatihan_id'] = 1;
$_SESSION['member_int_id'] = 3;
include 'api_pelatihan.php';
