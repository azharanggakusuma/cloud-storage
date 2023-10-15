<?php
session_start();

require '../koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $nama_lengkap = $_POST['nama_lengkap'];
  $username = $_POST['username'];
  $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

  $sql = "INSERT INTO users (nama_lengkap, username, password) VALUES ('$nama_lengkap', '$username', '$password')";
  if ($conn->query($sql) === TRUE) {
    $_SESSION['registration_success'] = true;
    $success_message = "Registrasi berhasil. Anda akan dialihkan ke halaman login.";
  } else {
    $error_message = "Gagal melakukan registrasi.";
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Register</title>
  <!-- Tailwind CSS CDN -->
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
  <!-- CSS Custom -->
  <link rel="stylesheet" href="../assets/css/style.css">
  <!-- Icon -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
  <!-- Favicon -->
  <link rel="icon" href="../admin/assets/img/favicon.ico">
</head>

<body class="bg-gray-100">
  <div class="flex justify-center items-center h-screen">
    <div class="bg-white p-8 rounded shadow-md w-96">
      <h1 class="text-2xl mb-4 font-semibold text-center">Register</h1>
      <?php if (isset($error_message)): ?>
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-5 mt-5" role="alert">
          <strong class="font-bold">Error!</strong>
          <span class="block sm:inline">
            <?php echo $error_message; ?>
          </span>
        </div>
      <?php endif; ?>
      <?php if (isset($success_message)): ?>
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-5 mt-5"
          role="alert">
          <strong class="font-bold">Success!</strong>
          <span class="block sm:inline">
            <?php echo $success_message; ?>
          </span>
        </div>
        <script>
          setTimeout(function () {
            window.location.href = "login.php";
          }, 1000);
        </script>
      <?php endif; ?>

      <form method="post" id="registerForm">
        <div class="mb-4">
          <label class="block text-gray-700 text-sm font-medium mb-2" for="username">Nama Lengkap:</label>
          <input
            class="appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
            id="nama_lengkap" name="nama_lengkap" type="text" required>
        </div>
        <div class="mb-4">
          <label class="block text-gray-700 text-sm font-medium mb-2" for="username">Username:</label>
          <input
            class="appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
            id="username" name="username" type="text" required>
        </div>
        <div class="mb-4">
          <label class="block text-gray-700 text-sm font-medium mb-2" for="password">Password:</label>
          <input
            class="appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
            id="password" name="password" type="password" required>
        </div>
        <button
          class="bg-blue-500 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded focus:outline-none focus:shadow-outline w-full"
          type="submit">Register</button>
      </form>
      <p class="mt-4 text-center">
        Sudah punya akun? <a class="text-blue-500 hover:underline" href="login.php">Login sekarang</a>
      </p>
    </div>
  </div>
</body>

</html>