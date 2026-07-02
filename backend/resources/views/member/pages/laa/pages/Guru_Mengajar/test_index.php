<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
session_start();
$_SESSION['member_int_id'] = 3;
require 'index.php';
?>
