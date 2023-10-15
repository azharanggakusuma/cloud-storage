<?php
session_start();

// Hapus semua data sesi
session_unset();

// Hapus sesi
session_destroy();

// Redirect ke halaman login
header("Location: login.php");
exit();
?>