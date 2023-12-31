<?php
session_start();

// Periksa apakah pengguna masuk atau memiliki peran yang sesuai
if (!isset($_SESSION['masuk']) || ($_SESSION['masuk'] !== true) || ($_SESSION['role'] !== 'user')) {
  header("Location: login.php");
  exit();
}


// Mendapatkan username dan id_user dari session
$username = $_SESSION['username'];
$id_user = $_SESSION['id_user'];
$nama_lengkap = $_SESSION['nama_lengkap'];
$foto_user = $_SESSION['foto_user'];
$tipe_akun = $_SESSION['tipe_akun'];

$keyword = isset($_GET['keyword']) ? $_GET['keyword'] : '';

if (isset($_POST['cari'])) {
  $keyword = $_POST['keyword'];
            // Memanggil fungsi cariBarang dengan keyword yang dimasukkan pengguna
            //$barangArray = cariBarang($keyword);
}

// Lanjutkan dengan konten halaman indexUser.php
// ...
?>

<br>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta content="width=device-width, initial-scale=1.0" name="viewport" />

  <title>Buat Permintaan - SMART</title>
  <meta content="" name="description" />
  <meta content="" name="keywords" />
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- Favicons -->
  <link href="assets/img/logo2.png" rel="icon" />
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon" />

  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect" />
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,500,500i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet" />

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet" />
  <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet" />
  <link href="assets/vendor/quill/quill.snow.css" rel="stylesheet" />
  <link href="assets/vendor/quill/quill.bubble.css" rel="stylesheet" />
  <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet" />
  <link href="assets/vendor/simple-datatables/style.css" rel="stylesheet" />

  <!-- Template Main CSS File -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet" />
  <link href="assets/css/style.css" rel="stylesheet" />
  <link href="assets/css/bootstrap.min.css" rel="stylesheet" />

  <!-- =======================================================
  * Template Name: NiceAdmin
  * Updated: May 30 2023 with Bootstrap v5.3.0
  * Template URL: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<style>
  .sidebar {
    background-color: #892641;
  }

  .container {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 70vh;
  }

  .content {
    text-align: center;
  }

  .header {
    background-color: #892641;
  }

  .tbsmart {
    font-size: 12px;
    margin-bottom: 0;
    font-weight: 600;
    color: #ffffff;
  }

  /*** Category ***/
  .cat-item div {
    background: #ffffff;
    transition: 0.5s;
  }

  .cat-item:hover div {
    background: gray;
    border-color: transparent;
  }

  .cat-item div * {
    transition: 0.5s;
  }

  .cat-item:hover div * {
    color: #892641 !important;
  }

  .dropdown {
    display: flex;
    justify-content: space-around;
    align-items: center;
    height: 40px;
    padding: 32px 0;
  }

  .dropdown-btn {
    display: inline-block;
    height: 40px;
    font-size: 14px;
    font-weight: 600;
    background-color: #892641;
    border: 1px solid #892641;
    color: #fff;
    transition: 0.2s;
    cursor: pointer;
    outline: none;
    padding: 8px 16px;
    border-radius: 24px;
  }

  .dropdown-btn:hover {
    background-color: #fff;
    border: 1px solid #892641;
    color: #892641;
  }

  .dropdown-content {
    display: none;
    position: absolute;
    top: 100%;
    left: 0;
    width: 100%;
    background-color: #f9f9f9;
    z-index: 1;
    margin-top: 10px;
    padding: 10px;
    box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
  }

  .subcategories {
    display: grid;
    grid-template-columns: repeat(6, 1fr);
    grid-gap: 10px;
    max-height: 200px;
    /* Atur ketinggian maksimum jika perlu */
    overflow-y: auto;
    /* Aktifkan pengguliran jika perlu */
  }

  .subcategories a {
    display: block;
    padding: 5px;
    text-decoration: none;
    color: #333;
  }

  /*** Product ***/
  .product-container {
    padding: 24px;
  }

  .product-grid {
    display: grid;
    grid-template-columns: repeat(6, 1fr);
    gap: 20px;
  }

  .product-card {
    text-align: center;
  }

  .product-image {
    height: 150px;
    width: 100%;
    background-color: #ccc;
    margin-bottom: 10px;
    margin-top: 50px;
  }

  .product-image img {
    object-fit: cover;
    height: 150px;
    width: 100%;
  }

  .product-title {
    font-size: 14px;
    font-weight: bold;
    margin-top: 5px;
    margin-bottom: 10px;
  }

  .product-button {
    display: inline-block;
    font-size: 14px;
    padding: 4px 8px;
    background-color: #f9f9f9;
    border: 1px solid #ccc;
    border-radius: 4px;
    text-decoration: none;
    color: #333;
    font-weight: bold;
    cursor: pointer;
    transition: 0.2s;
    margin-top: auto;
    /* Menempatkan tombol di bagian bawah */
  }

  .product-button:hover {
    background-color: #892641;
    color: #fff;
  }

  .button-container2 {
    position: fixed;
    bottom: 50px;
    right: 20px;
  }

  .button-container2 .btn {
    background-color: transparent;
    border: none;
  }

  .title2 {
    text-align: center;
    color: inherit;
    font-weight: bold;
    font-size: 24px;
    color: #892641;
    background-color: transparent;
    border: none;
  }

  .search-bar {
    display: flex;
    justify-content: space-evenly;
    align-items: center;
    height: 48px;
    margin-top: 12px;
  }

  .search-bar form {
    margin: 0;
    height: 100%;
    width: 90%;
    display: flex;
    align-items: center;
    justify-content: space-evenly;
  }

  .search-bar input {
    height: 100%;
    width: 85%;
    background: #fff;
    border: 1px solid #892641;
    border-radius: 36px;
    box-sizing: border-box;
    font-size: 16px;
    color: #892641;
    padding-left: 16px;
  }

  .search-bar input::placeholder {
    opacity: 100;
    color: #892641;
  }

  /* Dashboard */
  .dashboard .card {
    padding: 24px 16px;
  }

  .pagination {
    display: flex;
    justify-content: center;
    margin-top: 20px;
  }

  .pagination-wrapper {
    display: flex;
    justify-content: center;
    align-items: center;
  }

  .pagination-link {
    margin: 0 5px;
    text-decoration: none;
    color: #333;
    transition: 0.2s;
  }

  .pagination-link:hover {
    color: #892641;
  }

  .pagination-link.active {
    color: #892641;
    font-weight: bold;
  }

  .view-options {
    display: flex;
    justify-content: flex-end;
    align-items: center;
    margin-bottom: 10px;
  }

  .view-options-label {
    margin-right: 10px;
  }

  .view-options-select {
    margin-right: 10px;
  }

  .dropdown-menu {
    min-width: 400px;
    max-width: 400px;
  }

  .product-list {
    list-style: none;
    padding: 0;
    margin: 0;
  }

  .product-list li {
    display: flex;
    align-items: center;
    margin-bottom: 10px;
    margin-left: 15px;
  }

  .product-list li img {
    width: 90px;
    height: 90px;
    object-fit: cover;
    border-radius: 7px;
    margin-right: 18px;
  }

  .product-info h4 {
    margin: 0;
    font-size: 18px;
  }

  .product-info p {
    margin: 0;
    font-size: 14px;
    color: #888;
  }

  .product-number {
    font-size: 20px;
    margin-right: 18px;
    color: #892641;
    position: relative;
    top: -10px;
  }

  .delete-button {
    padding: 4px 8px;
    font-size: 12px;
    border: none;
    background-color: #ff0000;
    color: #ffffff;
    cursor: pointer;
    margin-top: 10px;
    margin-right: 5px;
  }

  button.btn-success {
    display: block;
    margin: 0 auto;
    margin-top: 30px;
    margin-bottom: 10px;
  }
  body {
  color: white; /* Warna teks putih */
  font-size: 20px; /* Ukuran teks */
}

.running-text {
  width: 100%; /* Lebar running text */
  overflow: hidden; /* Agar teks yang melewati lebar div tersembunyi */
  white-space: nowrap; /* Agar teks berjalan dalam satu baris */
}

.text {
  display: inline-block; /* Agar teks berjalan secara horizontal (tidak melompat) */
  padding: 5px; /* Jarak antara teks dengan pinggir div */
}
</style>




<body>

  <!-- ======= Header ======= -->
  <header id="header" class="header fixed-top d-flex align-items-center">

    <div class="d-flex align-items-center justify-content-between">
      <a href="indexUser.php" class="logo d-flex align-items-center">
        <img src="assets/img/logo2.png" alt="">
        <span class="htsimpan">SMART<br>
          <tb class="tbsmart">Sistem Manajemen dan Pelayanan Permintaan Barang Persediaan Terpadu</tb>
        </span>
      </a>
      <i class="bi bi-list toggle-sidebar-btn"></i>
    </div><!-- End Logo -->

    <div class="running-text">
        <marquee behavior="scroll" direction="left" onmouseover="this.stop();" onmouseout="this.start();">
          <span class="text">Harap Mengambil Barang di Gudang Setelah Barang Sudah Siap Diambil</span>
        </marquee>
      </div>

    <nav class="header-nav ms-auto">

      <ul class="d-flex align-items-center">



        <li class="nav-item dropdown">
          <a class="nav-link nav-icon" href="permintaanBarang.php">
            <i class="bi bi-bag"></i>
            <span class="badge bg-primary badge-number"></span>
          </a><!-- End Cart Icon -->
        </li>

        <li class="nav-item dropdown pe-3">

          <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
          <img src="<?php echo $foto_user; ?>" alt="Profile" class="rounded-circle foto-profil" />
            <span class="d-none d-md-block dropdown-toggle ps-2"><?php echo $nama_lengkap; ?></span> </a>
          </a><!-- End Profile Iamge Icon -->

          <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
            <li class="dropdown-header">
              <h6><?php echo $username; ?></h6>
              <span><?php echo $id_user; ?></span>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li>
              <a class="dropdown-item d-flex align-items-center" href="profilUser.php">
                <i class="bi bi-person"></i>
                <span>Profil</span>
              </a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>


            <li>
              <hr class="dropdown-divider">
            </li>

            <li>
              <a class="dropdown-item d-flex align-items-center" href="logout.php">
                <i class="bi bi-box-arrow-right"></i>
                <span>Sign Out</span>
              </a>
            </li>

          </ul><!-- End Profile Dropdown Items -->
        </li><!-- End Profile Nav -->

      </ul>
    </nav><!-- End Icons Navigation -->

  </header><!-- End Header -->

  <!-- ======= Sidebar ======= -->

  <aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

      <ul class="sidebar-nav" id="sidebar-nav">

        <li class="nav-item">
          <a class="nav-link" href="indexUser.php">
            <i class="bi bi-grid"></i>
            <span>Buat Permintaan</span>
          </a>
        </li><!-- End Dashboard Nav -->

        <li class="nav-item">
          <a class="nav-link collapsed" data-bs-target="#tables-nav" data-bs-toggle="collapse" href="#">
            <i class="bi bi-clipboard-check"></i><span>Kelola Permintaan</span><i class="bi bi-chevron-down ms-auto"></i>
          </a>
          <ul id="tables-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
            <li>
              <a href="permintaanBarang.php">
                <i class="bi"></i><span>Keranjang Permintaan</span>
              </a>
            </li>
            <li>
              <a href="statusPermintaan.php">
                <i class="bi"></i><span>Status Permintaan</span>
              </a>
            </li>
          </ul>
        </li><!-- End Tables Nav -->

        <li class="nav-item">
          <a class="nav-link collapsed" href="laporan.php">
            <i class="bi bi-journal-text"></i><span>Laporan</span>
          </a>
        </li><!-- End Tables Nav -->

        <li class="nav-item">
          <a class="nav-link collapsed" href="profilUser.php">
            <i class="bi bi-person"></i>
            <span>Profil</span>
          </a>
        </li><!-- End Profil Sidebar -->

      </ul>

  </aside>
  <!-- End Sidebar-->


  <main id="main" class="main">

    <div class="pagetitle">
      <h1>Buat Permintaan</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="indexUser.php">Home</a></li>
          <li class="breadcrumb-item active">Buat Permintaan</li>
        </ol>


        <!-- Start Search Bar -->
        <!-- Start Search Bar -->
        <!-- LETAK CODING LAMA BUAT SEARCH -->
	    <!-- End Search Bar -->
      <div class="search-bar">
          <form class="search-form d-flex align-items-center" method="POST" action="#">
            <input type="text" id="keyword" name="keyword" autofocus placeholder="Cari barang disini..." autocomplete="off" value="<?=$keyword;?>">
            <button type="submit" name="cari" class="btn btn-primary rounded-pill px-4 me-3" style="height: 100%;">Cari</button>          
          </form>
        </div>
        <!-- End Search Bar -->
      </nav>
    </div><!-- End Page Title -->

    <div class="dropdown">
<?php
require_once 'koneksi.php';
$conn = db_connect();

$sql = "SELECT nama_kategori FROM tb_kategori";
$result = mysqli_query($conn, $sql);

$kategoriArray = array();

if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
    $namaKategori = $row["nama_kategori"];
    if (!in_array($namaKategori, $kategoriArray)) {
        $kategoriArray[] = $namaKategori;
        $dropdownContentId = strtolower(str_replace(" ", "", $namaKategori));

        $querySubkategori = "SELECT nama_sub_kategori FROM tb_kategori WHERE nama_kategori = '$namaKategori'";
        $resultSubkategori = mysqli_query($conn, $querySubkategori);

        echo '<button class="dropdown-btn" data="' . $dropdownContentId . '">' . $namaKategori . '</button>';
        echo '<div class="dropdown-content" id="' . $dropdownContentId . '">';
        echo '    <div class="subcategories">';
        while ($rowSubkategori = mysqli_fetch_assoc($resultSubkategori)) {
        $namaSubkategori = $rowSubkategori["nama_sub_kategori"];
        echo '        <a href="indexUser.php?nama_sub_kategori=' . urlencode($namaSubkategori) . '" class="subkategori-link">' . $namaSubkategori . '</a>';
        }
        echo '    </div>';
        echo '</div>';
    }
    }
} else {
    echo "Tidak ada data kategori.";
}

//db_disconnect($conn);
?>
    </div>

    <div class="row">
      <div class="col-12">
        <div class="card top-selling overflow-auto product-container">
          <div class="view-options">
            <label for="view-options-select" class="view-options-label">Show</label>
            <select id="view-options-select" class="view-options-select" onchange="changeLimit(this.value)">
              <option value="12">12</option>
              <option value="24">24</option>
              <option value="48">48</option>
              <option value="96">96</option>
            </select>
          </div>

          <?php
          require_once 'koneksi.php';
          $con = db_connect();

          $limit = isset($_GET['limit']) ? intval($_GET['limit']) : 18;
          $namaSubkategori = isset($_GET['nama_sub_kategori']) ? $_GET['nama_sub_kategori'] : '';
          $idKategori = isset($_GET['id_kategori']) ? $_GET['id_kategori'] : '';
          $keyword = isset($_GET['keyword']) ? $_GET['keyword'] : '';

          if (isset($_POST['cari'])) {
            $keyword = $_POST['keyword'];
                      // Memanggil fungsi cariBarang dengan keyword yang dimasukkan pengguna
                      //$barangArray = cariBarang($keyword);
          }

          if ($namaSubkategori !== '') {
              $query = "SELECT tb_barang.* FROM tb_barang
                  JOIN tb_kategori ON tb_barang.nama_sub_kategori = tb_kategori.nama_sub_kategori
                  WHERE tb_kategori.nama_sub_kategori = '$namaSubkategori'
                  LIMIT $limit";
            $result = mysqli_query($con, $query);
          } else if ($keyword !== ''){
            $query = "SELECT * FROM tb_barang WHERE nama LIKE '%$keyword%'";
            $result = mysqli_query($conn, $query);
          }else{
              $query = "SELECT * FROM tb_barang LIMIT $limit";
            $result = mysqli_query($con, $query);
          }

          //$result = mysqli_query($con, $query);

          $count = 0;

          echo '<div id="product-grid" class="product-grid">';


          while ($row = mysqli_fetch_assoc($result)) {
            echo '<div class="product-card">';
            echo '<div class="product-image">';
            echo '<img src="' . $row['gambar'] . '" alt="' . $row['nama'] . '">';
            echo '</div>';
            echo '<div class="product-title">' . $row['nama'] . '</div>';
            echo '<form action="tambahCart.php" method="POST">';
            echo '<input type="hidden" name="username" value="' . $_SESSION['username'] . '">';
            echo '<input type="hidden" name="id_user" value="' . $_SESSION['id_user'] . '">';
            echo '<input type="hidden" name="id_barang" value="' . $row['id_barang'] . '">';
            echo '<input type="hidden" name="nama" value="' . $row['nama'] . '">';
            echo '<button type="submit" class="product-button">Tambahkan</button>';
            echo '</form>';
            echo '</div>';

            $count++;

            // Membuat baris baru setelah 6 kolom terpenuhi
            if ($count % 6 === 0) {
              echo '</div>';
              echo '<div class="product-grid">';
            }
          }

          echo '</div>';

          // Menampilkan opsi "Next Page"
          echo '<div class="pagination">';
          echo '<div class="pagination-wrapper">';
          echo '<a href="?limit=12" class="pagination-link">1</a>';
          echo '<a href="?limit=24" class="pagination-link">2</a>';
          echo '<a href="?limit=48" class="pagination-link">3</a>';
          echo '<a href="?limit=72" class="pagination-link">4</a>';
          echo '<a href="?limit=96" class="pagination-link">5</a>';
          echo '<a href="?limit=all" class="pagination-link active">All</a>';
          echo '</div>';
          echo '</div>';

          // Menutup koneksi
          db_disconnect($con);
          ?>
        </div>
      </div>
    </div>
  </main>
  <!-- ======= Footer ======= -->
  <footer id="footer" class="footer">
    <div class="copyright">
      <strong> SMART - </strong> <span>Sistem Manajemen dan Pelayanan Permintaan Barang Persediaan Terpadu</span>
    </div>
    <div class="credits">
      Made by <a>Tim Efektif</a>
    </div>
  </footer><!-- End Footer -->
  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="assets/vendor/apexcharts/apexcharts.min.js"></script>
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/chart.js/chart.umd.js"></script>
  <script src="assets/vendor/echarts/echarts.min.js"></script>
  <script src="assets/vendor/quill/quill.min.js"></script>
  <script src="assets/vendor/simple-datatables/simple-datatables.js"></script>
  <script src="assets/vendor/tinymce/tinymce.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>
  <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
  <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>

  <!-- Template Main JS File -->
  <script src="assets/js/main.js"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

  <script>
    $(document).ready(function() {
      $('#example').DataTable();
    });

  const marqueeElement = document.querySelector('.running-text marquee');
  const step = 6; // Ubah nilai ini untuk mengatur kecepatan langkah
  marqueeElement.setAttribute('scrollamount', step);

  // Fungsi untuk mengatur ukuran langkah (step)
  function setStep(stepValue) {
    marqueeElement.setAttribute('scrollamount', stepValue);
  }

    // Tampilkan dropdown content saat tombol dropdown di klik
    var dropdownButtons = document.querySelectorAll('.dropdown-btn');
    dropdownButtons.forEach(function(button) {
      button.addEventListener('click', function() {
        var dropdownContentId = button.getAttribute('data');
        var dropdownContent = document.getElementById(dropdownContentId);
        dropdownContent.style.display = dropdownContent.style.display === 'block' ? 'none' : 'block';
      });
    });

    // Sembunyikan dropdown content saat klik di luar dropdown
    window.addEventListener('click', function(event) {
      if (!event.target.matches('.dropdown-btn')) {
        var dropdowns = document.getElementsByClassName('dropdown-content');
        for (var i = 0; i < dropdowns.length; i++) {
          var dropdown = dropdowns[i];
          if (dropdown.style.display === 'block') {
            dropdown.style.display = 'none';
          }
        }
      }
    });

    function changeLimit(limit) {
      window.location.href = "?limit=" + limit;
    }
  </script>

</body>

</html>