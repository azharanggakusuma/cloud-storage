<?php
if (isset($_GET['filename']) && isset($_GET['category']) && isset($_GET['keterangan'])) {
  $filename = $_GET['filename'];
  $category = $_GET['category'];
  $keterangan = $_GET['keterangan'];
  $file_path = "uploads/" . $category . "/" . $keterangan . "/" . $filename;

  if (file_exists($file_path)) {
    $file_extension = pathinfo($file_path, PATHINFO_EXTENSION);

    if (in_array($file_extension, ['jpg', 'jpeg', 'png', 'gif', 'pdf'])) {
      if (in_array($file_extension, ['jpg', 'jpeg', 'png', 'gif'])) {
        echo '<img src="' . $file_path . '" alt="Preview" class="max-w-full h-auto">';
      } elseif ($file_extension === 'pdf') {
        echo '<embed src="' . $file_path . '" type="application/pdf" width="100%" height="600px">';
      }
    } else {
      echo 'Tampilan pratinjau tidak tersedia untuk jenis file ini.';
    }
  }
}
?>