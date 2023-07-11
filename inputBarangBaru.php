<?php
session_start();

// Periksa apakah pengguna masuk atau memiliki peran yang sesuai
if (!isset($_SESSION['masuk']) || ($_SESSION['masuk'] !== true) || ($_SESSION['role'] !== 'supervisor')) {
    header("Location: login.php");
    exit();
}

// Mendapatkan username dan id_user dari session
$username = $_SESSION['username'];
$idUser = $_SESSION['id_user'];
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>INPUT BARANG BARU - SMART</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="assets/img/logo2.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="assets/vendor/quill/quill.snow.css" rel="stylesheet">
  <link href="assets/vendor/quill/quill.bubble.css" rel="stylesheet">
  <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="assets/vendor/simple-datatables/style.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.2.0/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">
  

  <!-- Template Main CSS File -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/css/style.css" rel="stylesheet">
  <link href="assets/css/bootstrap.min.css" rel="stylesheet">

</head>

<style>
  .header {
    background-color: #892641;
  }
  .sidebar{
      background-color: #892641;
    }
  .tbsmart{
    font-size: 12px;
    margin-bottom: 0;
    font-weight: 600;
    color: #ffffff;
  }
  .pengumuman{
    font-size: 40px;
    font-weight: 700;
    color: #fff;
    font-family: "Nunito", sans-serif;
    text-align: center;
    padding-top: 100px;
  }
    .c-item {
  height: 360px;
  }
  .c-img {
  height: 100%;
  object-fit: cover;
  filter: brightness(0.6);
  }
  .img {
  height: 50%; /* Mengurangi lebar gambar menjadi 50% dari ukuran aslinya */
  width: auto; /* Menjaga rasio aspek gambar */
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
.editKategoriPopup {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    z-index: 9999;
}
                
.editKategoriPopup-content {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    background-color: #fff;
    padding: 20px;
    border-radius: 5px;
    width: 600px;
}
                
.close {
    position: absolute;
    top: 10px;
    right: 10px;
    cursor: pointer;
}

.table-bordered{
  color: white;
  border-color: #892641;
}
</style>



<body>

  <!-- ======= Header ======= -->
  <header id="header" class="header fixed-top d-flex align-items-center">

    <div class="d-flex align-items-center justify-content-between">
      <a href="index.html" class="logo d-flex align-items-center">
        <img src="assets/img/logo2.png" alt="">
        <span class="htsimpan">SMART<br>
          <tb class="tbsmart">Sistem Informasi Manajemen Pengelolaan</tb></span>
      </a>
      <i class="bi bi-list toggle-sidebar-btn"></i>
    </div><!-- End Logo -->

    <div class="search-bar">
      <form class="search-form d-flex align-items-center" method="POST" action="#">
        <input type="text" name="query" placeholder="Cari barang" title="Enter search keyword">
        <button type="submit" title="Search"><i class="bi bi-search"></i></button>
      </form>
    </div><!-- End Search Bar -->

    <nav class="header-nav ms-auto">
      
      <ul class="d-flex align-items-center">

        <li class="nav-item d-block d-lg-none">
          <a class="nav-link nav-icon search-bar-toggle " href="#">
            <i class="bi bi-search"></i>
          </a>
        </li><!-- End Search Icon-->

        <li class="nav-item dropdown">

          <a class="nav-link nav-icon" href="#" data-bs-toggle="dropdown">
            <i class="bi bi-bell"></i>
            <span class="badge bg-primary badge-number">4</span>
          </a><!-- End Notification Icon -->

          <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow notifications">
            <li class="dropdown-header">
              Notifikasi Terbaru
              <a href="#"><span class="badge rounded-pill bg-primary p-2 ms-2">Lihat Semua</span></a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li class="notification-item">
              <i class="bi bi-exclamation-circle text-warning"></i>
              <div>
                <h4>Peringatan</h4>
                <p>Stok barang berkurang</p>
                <p>30 min. ago</p>
              </div>
            </li>

            <li>
              <hr class="dropdown-divider">
            </li>

            <li class="notification-item">
              <i class="bi bi-x-circle text-danger"></i>
              <div>
                <h4>Stok Habis</h4>
                <p>Barang persediaan ini di gudang sudah habis</p>
                <p>1 hr. ago</p>
              </div>
            </li>

            <li>
              <hr class="dropdown-divider">
            </li>

            <li class="notification-item">
              <i class="bi bi-check-circle text-success"></i>
              <div>
                <h4>Barang sudah diambil</h4>
                <p>Barang telah siap dan sudah diambil dari gudang</p>
                <p>2 hrs. ago</p>
              </div>
            </li>

            <li>
              <hr class="dropdown-divider">
            </li>

            <li class="notification-item">
              <i class="bi bi-info-circle text-primary"></i>
              <div>
                <h4>Informasi update</h4>
                <p>Stok barang ini telah diperbarui</p>
                <p>4 hrs. ago</p>
              </div>
            </li>

            <li>
              <hr class="dropdown-divider">
            </li>
            <li class="dropdown-footer">
              <a href="#">Lihat semua notifikasi</a>
            </li>

          </ul><!-- End Notification Dropdown Items -->

        </li><!-- End Notification Nav -->

        <li class="nav-item dropdown">

          <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow messages">
            <li class="dropdown-header">
              You have 3 new messages
              <a href="#"><span class="badge rounded-pill bg-primary p-2 ms-2">View all</span></a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li class="message-item">
              <a href="#">
                <img src="assets/img/messages-1.jpg" alt="" class="rounded-circle">
                <div>
                  <h4>Maria Hudson</h4>
                  <p>Velit asperiores et ducimus soluta repudiandae labore officia est ut...</p>
                  <p>4 hrs. ago</p>
                </div>
              </a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li class="message-item">
              <a href="#">
                <img src="assets/img/messages-2.jpg" alt="" class="rounded-circle">
                <div>
                  <h4>Anna Nelson</h4>
                  <p>Velit asperiores et ducimus soluta repudiandae labore officia est ut...</p>
                  <p>6 hrs. ago</p>
                </div>
              </a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li class="message-item">
              <a href="#">
                <img src="assets/img/messages-3.jpg" alt="" class="rounded-circle">
                <div>
                  <h4>David Muldon</h4>
                  <p>Velit asperiores et ducimus soluta repudiandae labore officia est ut...</p>
                  <p>8 hrs. ago</p>
                </div>
              </a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li class="dropdown-footer">
              <a href="#">Show all messages</a>
            </li>

          </ul><!-- End Messages Dropdown Items -->

        </li><!-- End Messages Nav -->

        <li class="nav-item dropdown pe-3">

          <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
            <img src="assets/img/profile-img.jpg" alt="Profile" class="rounded-circle">
            <span class="d-none d-md-block dropdown-toggle ps-2"><?php echo $username; ?></span>
          </a><!-- End Profile Iamge Icon -->

          <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
            <li class="dropdown-header">
              <h6><?php echo $username; ?></h6>
              <span><?php echo $idUser; ?></span>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li>
              <a class="dropdown-item d-flex align-items-center" href="profil.html.html">
                <i class="bi bi-person"></i>
                <span>Profile</span>
              </a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>


            <li>
              <hr class="dropdown-divider">
            </li>

            <li>
              <a class="dropdown-item d-flex align-items-center" href="#">
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

  <li class="nav-item">
    <a class="nav-link " href="index.php">
      <i class="bi bi-grid"></i>
      <span>Beranda</span>
    </a>
  </li><!-- End Beranda Sidebar -->

  <a class="nav-link collapsed" data-bs-target="#tables-nav" data-bs-toggle="collapse" href="#">
    <i class="bi bi-bar-chart"></i><span></span>Kelola Data</span><i class="bi bi-chevron-down ms-auto"></i>
  </a>
  <ul id="tables-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
    <li>
      <a href="kelolaKategori.php">
        <i class="bi bi-circle"></i><span>Kelola Kategori</span>
      </a>
    </li>
    <li>
      <a href="inputBarangBaru.php">
        <i class="bi bi-circle"></i><span>Input Barang Baru</span>
      </a>
    </li>
    <li>
      <a href="inputStok.php">
        <i class="bi bi-circle"></i><span>Input Stok</span>
      </a>
    </li>
    <li>
      <a href="kelolaUser.php">
        <i class="bi bi-circle"></i><span>Kelola User</span>
      </a>
    </li>
  </ul>
</li><!-- End Kelola Data Sidebar -->

  <li class="nav-item">
    <a class="nav-link collapsed" href="kelolaPermintaan.php">
      <i class="bi bi-clipboard-check"></i><span>Kelola Permintaan</span>
    </a>
  </li><!-- End Kelola Permintaan Data Sidebar -->

  <li class="nav-item">
    <a class="nav-link collapsed" data-bs-target="#forms-nav" data-bs-toggle="collapse" href="#">
      <i class="bi bi-journal-text"></i><span>Laporan</span><i class="bi bi-chevron-down ms-auto"></i>
    </a>
    <ul id="forms-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
      <li>
        <a href="laporanUser.php">
          <i class="bi bi-circle"></i><span>Laporan Permintaan User</span>
        </a>
      </li>
      <li>
        <a href="laporanMutasi.php">
          <i class="bi bi-circle"></i><span>Laporan Mutasi Barang Persediaan</span>
        </a>
      </li>
      <li>
        <a href="laporanBuku.php">
          <i class="bi bi-circle"></i><span>Laporan Buku Persediaan</span>
        </a>
      </li>
      <li>
        <a href="laporanPersediaan.php">
          <i class="bi bi-circle"></i><span>Laporan Persediaan Masuk</span>
        </a>
      </li>
    </ul>
  </li><!-- End Laporan Sidebar -->



  <li class="nav-item">
    <a class="nav-link collapsed" href="profil.php">
      <i class="bi bi-person"></i>
      <span>Profil</span>
    </a>
  </li><!-- End Profil Sidebar -->

</ul>

</aside>
<!-- End Sidebar-->


  <main id="main" class="main">

    <div class="pagetitle">
      <h1>Input Barang Baru</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.html">Kelola Data</a></li>
          <li class="breadcrumb-item active">Input Barang Baru</li>
        </ol>
    </nav>
    </div><!-- End Page Title -->


    <section class="section">
      <div class="row">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Input Jenis Barang Baru</h5>
              <!-- Input Data Barang -->

                        <form id="inputBarangForm" action="InputBarang.php" method="POST" enctype="multipart/form-data">
            <div class="row mb-3">
              <label for="kodeBarang" class="col-sm-2 col-form-label">Kode Barang</label>
              <div class="col-sm-10">
                <input class="form-control" type="number" id="kodeBarang" name="kode_barang" required>
              </div>
            </div>
              
            <div class="row mb-3">
              <label for="namaKategori" class="col-sm-2 col-form-label">Nama Kategori</label>
              <div class="col-sm-10">
                <select class="form-select" id="namaKategori" name="nama_kategori" onchange="loadSubKategori()">
                  <option value="">Pilih Kategori</option>
                  <?php
                  require_once 'koneksi.php';
                  $con = db_connect();

                  $query = "SELECT DISTINCT nama_kategori FROM tb_kategori";
                  $result = mysqli_query($con, $query);

                  while ($row = mysqli_fetch_assoc($result)) {
                    echo "<option value='" . $row['nama_kategori'] . "'>" . $row['nama_kategori'] . "</option>";
                  }

                  db_disconnect($con);
                  ?>
                </select>
              </div>
            </div>

            <div class="row mb-3">
              <label for="namaSubKategori" class="col-sm-2 col-form-label">Nama Sub Kategori</label>
              <div class="col-sm-10">
                <select class="form-select" id="namaSubKategori" name="namaSubKategori" onchange="setKategori()">
                  <option value="">Pilih Sub Kategori</option>
                  <?php
                  require_once 'koneksi.php';
                  $con = db_connect();

                  $query = "SELECT id_kategori, nama_kategori, nama_sub_kategori FROM tb_kategori";
                  $result = mysqli_query($con, $query);

                  while ($row = mysqli_fetch_assoc($result)) {
                    echo "<option value='" . $row['nama_sub_kategori'] . "' data-id-kategori='" . $row['id_kategori'] . "' data-nama-kategori='" . $row['nama_kategori'] . "'>" . $row['nama_sub_kategori'] . "</option>";
                  }

                  db_disconnect($con);
                  ?>
                </select>
              </div>
            </div>

            <div class="row mb-3">
              <label for="nama" class="col-sm-2 col-form-label">Nama Barang </label>
              <div class="col-sm-10">
                <input class="form-control" type="text" name="nama" id="nama" required>
              </div>
            </div>

            <div class="row mb-3">
              <label for="deskripsi" class="col-sm-2 col-form-label">Deskripsi</label>
              <div class="col-sm-10">
                <textarea class="form-control" style="height: 100px" name="deskripsi" id="deskripsi"></textarea>
              </div>
            </div>

            <div class="row mb-3">
              <label for="gambar" class="col-sm-2 col-form-label">File Upload</label>
              <div class="col-sm-10">
                <input class="form-control" type="file" name="gambar" id="gambar" required>
              </div>
            </div>

            <div class="row mb-3">
              <label for="inputDate" class="col-sm-2 col-form-label">Tanggal Masuk</label>
              <div class="col-sm-10">
                <input type="date" class="form-control">
              </div>
            </div>

            <input type="hidden" id="idKategori" name="idKategori">
              
            <div class="row mb-3">
              <div class="col-sm-10">
                <button type="submit" class="btn btn-primary">Input</button>
              </div>
            </div>
          </form>

              <!-- End Input Barang -->

            </div>
          </div>


        </div>


  </main><!-- End #main -->

  <!-- ======= Footer ======= -->
  <footer id="footer" class="footer">
    <div class="copyright">
      SMART <strong><span>Sistem Informasi Manajemen Pengelolaan</span></strong>
    </div>
    <div class="credits">
      Made by <a href="https://bootstrapmade.com/">Tim Efektif</a>
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
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

  <script>
    $(document).ready(function () {
    $('#example').DataTable();
    });

function getKategori() {
  var dropdown = document.getElementById("namaSubKategori");
  var selectedOption = dropdown.options[dropdown.selectedIndex];
  var idKategori = selectedOption.value;
  var namaKategori = selectedOption.getAttribute("data-nama-kategori");
  
  document.getElementById("idKategori").value = idKategori;
  document.getElementById("namaKategori").value = namaKategori;
}
</script>


  </script>

</body>

</html>


