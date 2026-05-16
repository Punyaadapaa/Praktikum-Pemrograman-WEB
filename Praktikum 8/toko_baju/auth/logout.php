<?php
// Mulai session untuk akses data session
session_start();

// Hapus semua data session
$_SESSION = array();
session_destroy();

// Hapus cookie username
setcookie("username", "", time() - 3600, "/");

// Redirect ke halaman login
header("Location: login.php");
exit();
