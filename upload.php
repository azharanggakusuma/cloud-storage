<?php
session_start();
if (!isset($_SESSION['username'])) {
  header('Location: auth/login.php');
  exit();
}
require 'koneksi.php';

$username = $_SESSION['username'];

if (isset($_POST['submit'])) {
  $category = $_POST['category'];
  $keterangan = $_POST['keterangan'];

  // Membuat subfolder jika belum ada
  $subfolderPath = "uploads/$category/$keterangan";
  if (!is_dir($subfolderPath)) {
    mkdir($subfolderPath, 0755, true);
  }

  $targetDir = $subfolderPath . "/";
  $fileName = basename($_FILES["fileToUpload"]["name"]);
  $targetFile = $targetDir . $fileName;
  $uploadOk = 1;
  $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));


  // Cek apakah file sudah ada
  if (file_exists($targetFile)) {
    echo "Maaf, file sudah ada.";
    $uploadOk = 0;
  }

  // Cek ukuran file
  if ($_FILES["fileToUpload"]["size"] > 5000000) { // 5 MB
    echo "Maaf, ukuran file terlalu besar.";
    $uploadOk = 0;
  }

  // Hanya izinkan format file tertentu
  if ($imageFileType != "pdf" && $imageFileType != "docx" && $imageFileType != "png" && $imageFileType != "jpg") {
    echo "Maaf, hanya file PDF, DOCX, PNG dan JPG yang diizinkan.";
    $uploadOk = 0;
  }

  if ($uploadOk == 0) {
    echo "Maaf, file Anda tidak dapat diunggah.";
  } else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $targetFile)) {
      // File berhasil diunggah, simpan informasi di database
      $sql = "INSERT INTO files (username, filename, category, keterangan) VALUES ('$username', '$fileName', '$category', '$keterangan')";
      if ($conn->query($sql) === TRUE) {
        header('Location: user.php');
        exit();
      } else {
        echo "Error: " . $sql . "<br>" . $conn;
      }
    } else {
      echo "Maaf, terjadi kesalahan saat mengunggah file Anda.";
    }
  }
}
?>