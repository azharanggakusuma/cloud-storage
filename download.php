<?php
if (isset($_GET['filename']) && isset($_GET['category']) && isset($_GET['keterangan'])) {
  $filename = $_GET['filename'];
  $category = $_GET['category'];
  $keterangan = $_GET['keterangan'];
  $file_path = "uploads/" . $category . "/" . $keterangan . "/" . $filename;

  if (file_exists($file_path)) {
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename="' . $filename . '"');
    header('Content-Length: ' . filesize($file_path));
    readfile($file_path);
  } else {
    echo "File not found.";
  }
} else {
  echo "Invalid request.";
}
?>