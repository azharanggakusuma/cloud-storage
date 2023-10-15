<?php
$hostname = "sql212.epizy.com";
$database = "epiz_33082833_db_cloud_storage";
$username = "epiz_33082833";
$password = "7rhQF0wJsEQtpU";

// Buat koneksi
$conn = mysqli_connect($hostname, $username, $password, $database);

// Periksa koneksi
if (!$conn) {
    die("Koneksi Tidak Berhasil: " . mysqli_connect_error());
}
?>