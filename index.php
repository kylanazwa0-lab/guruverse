<?php
// ✅ PERFORMANCE FIX: Removed 302 redirect
// Changed from: header("Location: guru-belajar/Dashboard/index.php");
// Now directly including dashboard to eliminate extra HTTP roundtrip

require_once 'guru-belajar/Dashboard/index.php';
?>
