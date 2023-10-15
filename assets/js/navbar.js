document.addEventListener("DOMContentLoaded", function () {
  // Function untuk menambahkan kelas 'active' pada tautan menu yang sesuai dengan bagian (section) yang sedang aktif
  function setActiveMenuItem() {
    var currentPosition = window.scrollY + 100; // Menambahkan offset 100 untuk menyesuaikan dengan posisi bagian

    // Iterasi melalui setiap bagian (section) untuk menemukan bagian mana yang sedang aktif
    document.querySelectorAll("section").forEach(function (section) {
      var top = section.offsetTop;
      var bottom = top + section.offsetHeight;

      if (currentPosition >= top && currentPosition <= bottom) {
        // Menghapus kelas 'active' dari semua tautan menu
        document.querySelectorAll("nav a.scroll-link").forEach(function (link) {
          link.classList.remove("active");
        });

        // Menambahkan kelas 'active' pada tautan menu yang sesuai dengan bagian (section) yang sedang aktif
        var targetLink = document.querySelector(
          'a.scroll-link[href="#' + section.id + '"]'
        );
        if (targetLink) {
          targetLink.classList.add("active");
        }
      }
    });
  }

  // Memanggil fungsi setActiveMenuItem() saat halaman dimuat
  setActiveMenuItem();

  // Memanggil fungsi setActiveMenuItem() saat pengguna menggulir halaman
  document.addEventListener("scroll", setActiveMenuItem);

  // Memanggil fungsi setActiveMenuItem() saat pengguna mengklik tautan menu
  document.querySelectorAll("nav a.scroll-link").forEach(function (link) {
    link.addEventListener("click", function (event) {
      event.preventDefault();

      // Memilih target (elemen tujuan dari tautan menu yang diklik)
      var target = document.querySelector(link.getAttribute("href"));

      // Scroll ke elemen target dengan efek smooth scroll
      target.scrollIntoView({
        behavior: "smooth",
        block: "start",
      });

      // Tambahkan kelas 'active' pada tautan menu yang diklik
      document.querySelectorAll("nav a.scroll-link").forEach(function (link) {
        link.classList.remove("active");
      });
      link.classList.add("active");
    });
  });
});

const mobileMenuButton = document.querySelector(
  '[data-collapse-toggle="mobile-menu-2"]'
);
const mobileMenu = document.getElementById("mobile-menu-2");

mobileMenuButton.addEventListener("click", () => {
  mobileMenu.classList.toggle("hidden");
});
