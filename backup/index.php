<?php
require 'koneksi.php';

$sql = "SELECT * FROM files";
$result = $conn->query($sql);

$filesByCategory = array();
while ($row = $result->fetch_assoc()) {
  $category = $row['category'];
  if (!array_key_exists($category, $filesByCategory)) {
    $filesByCategory[$category] = array();
  }
  $filesByCategory[$category][] = $row;
}

// Fungsi untuk memeriksa apakah pengunjung adalah pengunjung baru atau sudah pernah berkunjung
function isVisitorNew()
{
  if (!isset($_SESSION['visited'])) {
    $_SESSION['visited'] = true;
    return true;
  }
  return false;
}

if (isVisitorNew()) {
  // Mendapatkan alamat IP pengunjung
  $ip_address = $_SERVER['REMOTE_ADDR'];

  // Menyimpan informasi kunjungan ke dalam database
  $sql = "INSERT INTO visitors (ip_address, visit_time) VALUES ('$ip_address', NOW())";

  if ($conn->query($sql) !== true) {
    echo "Error: " . $sql . "<br>" . $conn;
  }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Cloud Storage v2</title>
  <!-- Favicon -->
  <link rel="icon" href="admin/assets/img/favicon.ico">
  <!-- Tailwind CSS CDN -->
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
  <!-- CSS Custom -->
  <link rel="stylesheet" href="assets/css/style.css">
  <!-- Icon -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
  <!-- JQuery -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <!-- Navbar -->
  <script src="assets/js/navbar.js"></script>
  <script src="https://unpkg.com/flowbite@1.4.1/dist/flowbite.js"></script>
  <!-- Animasi -->
  <link href="https://cdn.jsdelivr.net/npm/animate.css@4.1.1/animate.min.css" rel="stylesheet">

  <script async defer src="https://buttons.github.io/buttons.js"></script>
</head>

<body class="bg-gray-100 font-sans">

  <div id="loading" class="fixed inset-0 flex justify-center items-center h-screen bg-white z-50">
    <div class="animate-pulse flex space-x-4">
      <div class="bg-blue-500 h-6 w-6 rounded-full"></div>
      <div class="bg-blue-500 h-6 w-6 rounded-full"></div>
      <div class="bg-blue-500 h-6 w-6 rounded-full"></div>
    </div>
  </div>

  <script>
    setTimeout(function () {
      document.getElementById('loading').style.display = 'none';
      document.getElementById('pageContent').style.display = 'block';
      document.getElementById('navbar').style.display = 'block';
    }, 1000);
  </script>

  <div class="hidden" id="navbar">
    <!--
    <header class="bg-blue-500 fixed py-4 top-0 w-full z-50">
      <div class="container mx-auto">
        <div class="flex items-center justify-between px-4">
          <div class="flex items-center navbar">
            <img src="assets/img/server.png" alt="Server" class="w-10 h-10 mr-2">
            <h2 class="font-bold text-white text-2xl">Cloud Storage v2</h2>
          </div>
          <a href="auth/login.php"
            class="mr-2 bg-gray-100 text-gray-800 rounded-full py-2 px-5 inline-block hover:bg-gray-200 focus:outline-none focus:ring focus:ring-gray-300">
            Log In
          </a>
        </div>
      </div>
    </header>
    -->

    <header class="fixed w-full z-50 animate__animated animate__fadeIn animate__delay-0.5s">
      <nav class="bg-white border-gray-200 py-2.5 dark:bg-gray-900 shadow-sm" id="mainNav">
        <div class="container-nav flex flex-wrap items-center justify-between max-w-screen-xl px-4 mx-auto">
          <a href="#" class="flex items-center">
            <img src="assets/img/server.png" class="w-10 h-10 mr-2.5" alt="Logo" />
            <span class="self-center text-xl font-bold whitespace-nowrap dark:text-white">Cloud Storage v2</span>
          </a>
          <div class="flex items-center lg:order-2">
            <a href="auth/login.php"
              class="hidden sm:flex bg-blue-500 text-white dark:text-white hover:bg-blue-600 focus:ring-4 focus:ring-gray-300 font-medium rounded-lg text-xs px-3 lg:px-4 py-1.5 lg:py-2 sm:mr-2 dark:hover:bg-gray-700 focus:outline-none dark:focus:ring-gray-800">
              Log In
            </a>
            <button data-collapse-toggle="mobile-menu-2" type="button"
              class="inline-flex items-center p-2 ml-1 text-sm text-gray-500 rounded-lg lg:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600"
              aria-controls="mobile-menu-2" aria-expanded="false">
              <span class="sr-only">Open main menu</span>
              <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd"
                  d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z"
                  clip-rule="evenodd"></path>
              </svg>
              <svg class="hidden w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd"
                  d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                  clip-rule="evenodd"></path>
              </svg>
            </button>
          </div>
          <div class="items-center justify-between hidden w-full lg:flex lg:w-auto lg:order-1" id="mobile-menu-2">
            <ul class="flex flex-col mt-4 font-medium lg:flex-row lg:space-x-8 lg:mt-0 lg:mr-20">
              <li>
                <a href="#home"
                  class="scroll-link block py-2 pl-3 pr-4 text-gray-700 border-b border-gray-100 hover:bg-gray-50 lg:hover:bg-transparent lg:border-0 lg:hover:text-blue-500 lg:p-0 dark:text-gray-400 lg:dark:hover:text-white dark:hover:bg-gray-700 dark:hover:text-white lg:dark:hover:bg-transparent dark:border-gray-700"
                  aria-current="page">Home</a>
              </li>
              <li>
                <a href="coming_soon.php"
                  class="block py-2 pl-3 pr-4 text-gray-700 border-b border-gray-100 hover:bg-gray-50 lg:hover:bg-transparent lg:border-0 lg:hover:text-blue-500 lg:p-0 dark:text-gray-400 lg:dark:hover:text-white dark:hover:bg-gray-700 dark:hover:text-white lg:dark:hover:bg-transparent dark:border-gray-700">About</a>
              </li>
              <li>
                <a href="coming_soon.php"
                  class="block py-2 pl-3 pr-4 text-gray-700 border-b border-gray-100 hover:bg-gray-50 lg:hover:bg-transparent lg:border-0 lg:hover:text-blue-500 lg:p-0 dark:text-gray-400 lg:dark:hover:text-white dark:hover:bg-gray-700 dark:hover:text-white lg:dark:hover:bg-transparent dark:border-gray-700">Service</a>
              </li>
              <li>
                <a href="#contact"
                  class="block py-2 pl-3 pr-4 text-gray-700 border-b border-gray-100 hover:bg-gray-50 lg:hover:bg-transparent lg:border-0 lg:hover:text-blue-500 lg:p-0 dark:text-gray-400 lg:dark:hover:text-white dark:hover:bg-gray-700 dark:hover:text-white lg:dark:hover:bg-transparent dark:border-gray-700">Contact</a>
              </li>
              <li>
                <a href="#blog"
                  class="scroll-link block py-2 pl-3 pr-4 text-gray-700 border-b border-gray-100 hover:bg-gray-50 lg:hover:bg-transparent lg:border-0 lg:hover:text-blue-500 lg:p-0 dark:text-gray-400 lg:dark:hover:text-white dark:hover:bg-gray-700 dark:hover:text-white lg:dark:hover:bg-transparent dark:border-gray-700"
                  onclick="showAlert()">Blog</a>
              </li>
              <li>
                <a href="auth/login.php"
                  class="md:hidden lg:hidden ml-3 mt-2 mb-2 sm:ml-0 sm:flex bg-blue-500 text-white dark:text-white hover:bg-blue-600 focus:ring-4 focus:ring-gray-300 font-semibold rounded-lg text-md px-5 block text-center lg:px-4 py-2 lg:py-2 dark:hover:bg-gray-700 focus:outline-none dark:focus:ring-gray-800">
                  Log In
                </a>
              </li>
            </ul>
          </div>
        </div>
      </nav>
    </header>
  </div>

  <!-- Popup alert -->
  <div id="custom-alert" class="fixed inset-0 flex items-center justify-center z-50 hidden">
    <div class="bg-red-500 rounded-lg p-3 sm:p-6 md:p-8 animate__animated animate__fadeIn" data-delay="500ms">
      <div class="flex justify-end">
        <button class="text-white hover:text-gray-200 focus:outline-none" onclick="closeAlert()">
          <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
          </svg>
        </button>
      </div>
      <p class="text-base sm:text-lg md:text-xl font-semibold text-white">Segera Hadir</p>
      <p class="text-xs sm:text-sm md:text-base text-white">Kami sedang dalam pengembangan dan segera akan hadir dengan
        berbagai konten menarik. Terima kasih atas kesabaran Anda!</p>
    </div>
  </div>

  <script>
    // Fungsi untuk menampilkan popup alert
    function showAlert() {
      const customAlert = document.getElementById("custom-alert");
      customAlert.classList.remove("hidden");
    }

    // Fungsi untuk menutup popup alert
    function closeAlert() {
      const customAlert = document.getElementById("custom-alert");
      customAlert.classList.add("hidden");
    }
  </script>

  <br id="home">

  <div class="p-5 sm:p-10 md:p-16 lg:p-20 xl:p-24 hidden animate__animated animate__fadeIn animate__delay-0.5s"
    id="pageContent">
    <div class="container mx-auto px-4 mt-10 mb-10">
      <div id="message"
        class="bg-gradient-to-br from-blue-400 to-purple-600 border border-gray-300 rounded-lg p-6 md:p-8 shadow-lg transform scale-100 hover:scale-105 transition-transform duration-300">
        <button id="closeMessage"
          class="absolute top-0 right-0 mt-4 mr-4 text-white hover:text-gray-200 focus:outline-none">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
          </svg>
        </button>
        <div class="flex flex-col md:flex-row items-center mb-6">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 md:h-16 md:w-16 text-white mr-4" fill="none"
            viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
          </svg>
          <h1 class="text-xl md:text-2xl font-semibold text-white">Halo, Selamat Datang!</h1>
        </div>
        <p class="text-sm text-white">Kami senang Anda memilih layanan penyimpanan awan (cloud storage) kami. Jika Anda
          ingin
          mengunggah file, <a href="auth/login.php" class="text-gray-200 underline hover:text-white">silakan login
            terlebih
            dahulu</a>.</p>
        <p class="text-xs text-gray-200 mt-2">Terima kasih atas kunjungan Anda.</p>
      </div>
    </div>

    <script>
      document.getElementById("closeMessage").addEventListener("click", function () {
        var message = this.parentElement;
        message.style.display = "none";
      });
    </script>

    <!-- Daftar File -->
    <div class="bg-white p-6 rounded shadow-md">
      <h2 class="text-2xl mb-4 font-bold">Daftar File</h2>
      <div class="border-t border-blue-500 my-4 w-16 mb-5"></div>
      <div class="space-y-4 md:flex md:space-y-0 md:space-x-4">
        <div class="w-full md:w-1/2">
          <?php foreach ($filesByCategory as $category => $files): ?>
            <div class="category-container mb-4">
              <div class="flex items-center cursor-pointer" onclick="toggleCategory('<?php echo $category; ?>')">
                <i class="fas fa-folder text-blue-500 mr-2"></i>
                <h3 class="category-title text-md font-semibold">
                  <?php echo $category; ?>
                </h3>
              </div>
              <ul id="<?php echo $category; ?>" class="file-list hidden mt-2 space-y-2 pl-6">
                <?php
                $keteranganFolders = array();
                foreach ($files as $file) {
                  $uploader = $file['username'];
                  $keterangan = $file['keterangan'];
                  if (!in_array($keterangan, $keteranganFolders)) {
                    $keteranganFolders[] = $keterangan;
                  }
                }
                foreach ($keteranganFolders as $keterangan): ?>
                  <li class="file-list-item flex justify-between items-center">
                    <div class="flex flex-col">
                      <div class="flex items-center cursor-pointer"
                        onclick="toggleKeterangan('<?php echo $category . '_' . $keterangan; ?>')">
                        <i class="fas fa-folder text-blue-500 mr-2"></i>
                        <p class="text-black text-sm">
                          <?php echo $keterangan; ?>
                        </p>
                      </div>
                    </div>
                  </li>
                  <ul id="<?php echo $category . '_' . $keterangan; ?>" class="file-list hidden mt-2 space-y-2 pl-6">
                    <?php foreach ($files as $file) {
                      if ($file['keterangan'] === $keterangan) {
                        $filePath = "uploads/" . $category . "/" . $keterangan . "/" . $file['filename']; ?>
                        <li class="file-list-item flex justify-between items-center">
                          <div class="flex flex-col">
                            <a class="file-link text-blue-500 hover:underline" href="<?php echo $filePath; ?>"
                              target="_blank"><?php echo $file['filename']; ?></a>
                            <p class="text-grey-400 text-xs">
                              Diupload oleh:
                              <?php echo $uploader; ?>
                            </p>
                          </div>
                          <div class="flex">
                            <a class="file-preview ml-2 text-gray-500" href="javascript:void(0);"
                              onclick="openPreview('<?php echo $file['filename']; ?>', '<?php echo $category; ?>', '<?php echo $keterangan; ?>')"
                              title="Preview"><i class="fas fa-eye"></i></a>
                            <a class="file-download ml-2 text-gray-500"
                              href="download.php?filename=<?php echo $file['filename']; ?>&category=<?php echo $category; ?>&keterangan=<?php echo $keterangan; ?>"
                              title="Download"><i class="fas fa-download"></i></a>
                          </div>
                        </li>
                      <?php }
                    } ?>
                  </ul>
                <?php endforeach; ?>
              </ul>
            </div>
          <?php endforeach; ?>
        </div>
        <div class="w-full md:w-1/2">
          <div id="filePreview" class="bg-gray-100 p-4 rounded-md">
            <!--<h2 class="text-xl mb-4">Tampilan Pratinjau</h2>-->
            <iframe id="previewFrame" src="" frameborder="0" style="width: 100%; height: 400px;"></iframe>
          </div>
        </div>
      </div>
    </div>

    <script>
      function toggleCategory(category) {
        var categoryList = document.getElementById(category);
        categoryList.classList.toggle("hidden");
      }

      function toggleKeterangan(keterangan) {
        var keteranganList = document.getElementById(keterangan);
        keteranganList.classList.toggle("hidden");
      }

      function openPreview(filename, category, keterangan) {
        var previewFrame = document.getElementById("previewFrame");
        previewFrame.src = "view.php?filename=" + filename + "&category=" + category + "&keterangan=" + keterangan;
      }
    </script>

    <!-- Contact -->
    <div class="bg-white p-8 rounded shadow-md mt-10">
      <h2 class="text-2xl mb-4 font-bold text-center">Hubungi Kami</h2>
      <div class="border-t border-blue-500 mx-auto my-4 w-16 mb-4"></div>
      <div id="alertMessage" class="hidden p-4 mt-4 mb-4 rounded text-white">
        <!-- Alert content will be displayed here -->
      </div>
      <form action="process_form.php" method="post" id="contactForm">
        <div class="mb-4">
          <label for="name" class="block text-sm font-medium text-gray-700">Nama</label>
          <input type="text" id="name" name="name" class="mt-1 p-2 w-full border rounded-md" placeholder="Masukkan Nama"
            required>
        </div>
        <div class="mb-4">
          <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
          <input type="email" id="email" name="email" class="mt-1 p-2 w-full border rounded-md"
            placeholder="Masukkan Email" required>
        </div>
        <div class="mb-4">
          <label for="message" class="block text-sm font-medium text-gray-700">Pesan</label>
          <textarea id="message" name="message" rows="4" class="mt-1 p-2 w-full border rounded-md"
            placeholder="Tulis Pesan Anda" required></textarea>
        </div>
        <button type="button" id="submitButton"
          class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded flex items-center">
          Kirim <i class="ml-2 fas fa-paper-plane"></i>
        </button>
      </form>
    </div>
  </div>

  <script>
    document.addEventListener("DOMContentLoaded", function () {
      const form = document.getElementById("contactForm");
      const alertMessage = document.getElementById("alertMessage");
      const submitButton = document.getElementById("submitButton");

      submitButton.addEventListener("click", function () {
        const formData = new FormData(form);

        if (!formData.get("name") || !formData.get("email") || !formData.get("message")) {
          showAlert("Harap lengkapi semua field.", "bg-red-500");
          return;
        }

        fetch("process_form.php", {
          method: "POST",
          body: formData,
        })
          .then(response => response.text())
          .then(data => {
            if (data === "success") {
              showAlert("Pesan berhasil terkirim.", "bg-green-500");
              form.reset();
            } else if (data === "error") {
              showAlert("Terjadi kesalahan saat mengirim pesan.", "bg-red-500");
            }
          })
          .catch(error => {
            console.error("Error:", error);
          });
      });

      function showAlert(message, bgColor) {
        alertMessage.textContent = message;
        alertMessage.classList.remove("hidden");
        alertMessage.classList.add(bgColor);

        setTimeout(() => {
          alertMessage.classList.add("hidden");
          alertMessage.classList.remove(bgColor);
        }, 3000);
      }
    });
  </script>

  <footer class="bg-gray-800 py-4 text-center text-white mt-10">
    <div class="container mx-auto px-4">
      <div class="flex justify-center items-center gap-4 mb-4 mt-2">
        <ul class="flex space-x-4">
          <li>
            <a href="https://wa.me/+62895364527280" target="_blank"
              class="text-black bg-white p-2 rounded-full w-8 h-8 flex items-center justify-center hover:text-white hover:bg-black transition-colors duration-300">
              <i class="fab fa-whatsapp"></i>
            </a>
          </li>
          <li>
            <a href="https://www.linkedin.com/in/azharangga-kusuma-9a30911a0" target="_blank"
              class="text-black bg-white p-2 rounded-full w-8 h-8 flex items-center justify-center hover:text-white hover:bg-black transition-colors duration-300">
              <i class="fab fa-linkedin"></i>
            </a>
          </li>
          <li>
            <a href="https://www.github.com/azharanggakusuma" target="_blank"
              class="text-black bg-white p-2 rounded-full w-8 h-8 flex items-center justify-center hover:text-white hover:bg-black transition-colors duration-300">
              <i class="fab fa-github"></i>
            </a>
          </li>
          <li>
            <a href="https://instagram.com/azharangga_kusuma" target="_blank"
              class="text-black bg-white p-2 rounded-full w-8 h-8 flex items-center justify-center hover:text-white hover:bg-black transition-colors duration-300">
              <i class="fab fa-instagram"></i>
            </a>
          </li>
          <li>
            <a href="https://youtube.com/channel/UCnKjszzhKbvQ9zqbo9kKjpg" target="_blank"
              class="text-black bg-white p-2 rounded-full w-8 h-8 flex items-center justify-center hover:text-white hover:bg-black transition-colors duration-300">
              <i class="fab fa-youtube"></i>
            </a>
          </li>
        </ul>
      </div>
      <p class="text-gray-400 mb-2">©
        <?php echo date('Y'); ?> <a href="https://kusuma-azharangga.my.id"
          class="text-blue-300 hover:text-blue-500 underline">Azharangga Kusuma</a>. All rights reserved.
      </p>
    </div>
  </footer>

  <script>
    // Fungsi untuk mengatur animasi scroll ke elemen target
    function scrollToTarget(event) {
      event.preventDefault();
      const targetElement = document.querySelector(event.target.getAttribute('href'));
      const offsetTop = targetElement.getBoundingClientRect().top + window.scrollY;

      window.scrollTo({
        top: offsetTop,
        behavior: 'smooth', // Animasi scroll
      });
    }

    // Menambahkan event listener ke setiap elemen tautan dengan kelas 'scroll-link'
    const scrollLinks = document.querySelectorAll('.scroll-link');
    scrollLinks.forEach(link => {
      link.addEventListener('click', scrollToTarget);
    });
  </script>
</body>

</html>