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
$nip = $_SESSION['nip'];


// Lanjutkan dengan konten halaman indexUser.php
// ...
?>

<br>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta content="width=device-width, initial-scale=1.0" name="viewport" />

  <title>Permintaan Barang - SMART</title>
  <meta content="" name="description" />
  <meta content="" name="keywords" />

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

</head>

<style>

  .products {
    width: 50%;
    align-self: center;
    height: 10%;
    display: flex;
    justify-content: center;
    flex-wrap: wrap;
    gap: 40px;
  }

  .product {
    position: relative;
    background-color: var(--sectionBack);
    width: 350px;
    height: 100%;
    box-shadow: 0 5px 20px rgba(0, 0, 0, .3);
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    padding: 20px 20px 40px;
    border-radius: 10px;
    transition: .3s;
  }

  .product:hover {
    transform: translateY(-15px);
    box-shadow: 0 5px 10px rgba(0, 0, 0, .2);
  }

  .image {
    width: 100%;
    height: 60%;
    display: grid;
    place-content: center;
  }

  .image img {
    width: 240px;
  }

  .namePrice {
    width: 100%;
    display: flex;
    justify-content: space-between;
  }

  .namePrice h3 {
    font-size: 1;
    text-transform: capitalize;
    color: var(--textColor);
  }

  .namePrice span {
    font-size: 1.5;
    color: var(--starColor);
  }

  .product p {
    font-size: 12px;
    line-height: 25px;
  }

  .bay {
    position: absolute;
    bottom: 20px;
    right: 20px;
  }

  .bay button {
    padding: 10px 10px;
    border-radius: 7px;
    border: none;
    background-color: var(--textColor);
    color: var(--sectionBack);
    font-size: 10px;
    text-transform: capitalize;
    cursor: pointer;
    transition: .5s;
  }

  .bay button:hover {
    transform: scale(1.1);
  }

  .header {
    background-color: #892641;
  }

  .sidebar {
    background-color: #892641;
  }

  .tbsmart {
    font-size: 12px;
    margin-bottom: 0;
    font-weight: 600;
    color: #ffffff;
  }

  .pengumuman {
    font-size: 40px;
    font-weight: 700;
    color: #fff;
    font-family: "Nunito", sans-serif;
    text-align: center;
    padding-top: 100px;
  }

  .c-item {
    height: 100px;
  }

  .c-img {
    height: 100%;
    object-fit: cover;
    filter: brightness(0.6);
  }

  .img {
    height: 50%;
    /* Mengurangi lebar gambar menjadi 50% dari ukuran aslinya */
    width: auto;
    /* Menjaga rasio aspek gambar */
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
  }

  .product-list li img {
    width: 85px;
    height: 85px;
    object-fit: cover;
    border-radius: 5px;
    margin-right: 14px;
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
    font-size: 24px;
    margin-right: 18px;
    font-weight: bold;
    color: #892641;

  }

  .mini-button {
    padding: 4px 8px;
    font-size: 12px;
    border: none;
    background-color: #eaeaea;
    cursor: pointer;
    margin-right: 5px;
  }

  .delete-button {
    padding: 4px 8px;
    font-size: 12px;
    border: none;
    background-color: #ff0000;
    color: #ffffff;
    cursor: pointer;
    margin-right: 5px;
  }

  .product-image img {
    width: 90px;
    height: 90px;
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
              <a class="dropdown-item d-flex align-items-center" href="userprofilUser.php">
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
                <span>Keluar</span>
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
        <a class="nav-link " href="indexUser.php">
          <i class="bi bi-grid"></i>
          <span>Buat Permintaan</span>
        </a>
      </li><!-- End Beranda Sidebar -->

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

      <li class="nav-item">
        <a class="nav-link collapsed" href="laporan.php">
          <i class="bi bi-bar-chart"></i>
          <span>Laporan</span>
        </a>
      </li><!-- End Laporan Nav -->

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
      <h1>Permintaan Barang</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="indexUser.php">Pesan</a></li>
          <li class="breadcrumb-item active">Permintaan Barang</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <!-- Daftar Pesanan -->

    <?php
    require_once 'koneksi.php';

    // Pastikan session "cart" telah diatur sebelumnya
    if (!isset($_SESSION["cart"])) {
      $_SESSION["cart"] = array();
    }

    // Menghubungkan ke database
    $con = db_connect();

    echo '<div class="card-body pb-0">';
    echo '  <div class="row gx-5 justify-content-center bg-white">';
    echo '    <div class="col-md-12 py-4">';
    echo '      <div class="heading">';
    echo '        <h1 class="h5 fw-normal" style="color: #892641;">Keranjang Permintaan</h1>';
    echo '        <hr>';
    echo '      </div>';
    echo '';

    echo '                    <form action="hapusCart.php" method="post">';
    echo '                      <button type="submit" name="hapus_cart" class="btn btn-danger rounded-pill px-4 float-end">Kosongkan Keranjang</button>';
    echo '                    </form>';

    echo '      <div class="row">';
    echo '        <div class="col-md-12">';
    echo '          <div class="row">';
    echo '            <div class="col-md">';
    echo '';
    echo '             <form action="prosesCart.php" method="POST">';
    echo '                <table class="table table-hover table-borderless">';
    echo '                  <thead>';
    echo '                    <tr>';
    echo '                      <th scope="col">No</th>';
    echo '                      <th scope="col" >Kode Barang</th>';
    echo '                      <th scope="col" >Gambar</th>';
    echo '                      <th scope="col" >Nama Barang</th>';
    echo '                      <th scope="col" >Kategori</th>';
    echo '                      <th scope="col">Jumlah Barang</th>';
    echo '                    </tr>';
    echo '                  </thead>';
    echo '';

    //echo "<div class='card mt-4'>";
    //echo "<h3 class='card-title'>Cart</h3>";
    //echo "<h5>Username: " . $cartItem["username"] . "</h5>";
    // echo "<p>ID User: " . $cartItem["id_user"] . "</p>";
    // echo "<p>ID Barang: " . $cartItem["id_barang"] . "</p>";
    //echo "<p>Nama: " . $cartItem["nama"] . "</p>";

    $no = 1;
    foreach ($_SESSION["cart"] as $cartItem) {
      if (isset($cartItem["id_barang"])) {
        $idBarang = $cartItem["id_barang"];
        $query = "SELECT gambar, nama_sub_kategori FROM tb_barang WHERE id_barang = '$idBarang'";
        $result = mysqli_query($con, $query);
        $row = mysqli_fetch_assoc($result);
        /*
    echo "<div class='product-image'>";
    echo "<img src='$gambar' alt='Gambar Produk'>";
    echo "</div>";
    echo '<p>' . $namaKategori . '</p>';
    echo '<form action="prosesCart.php" method="POST">';
    echo '<div class="col-sm-1">';
    echo '<input type="number" class="form-control" name="jumlah_minta_' . $cartItem["id_barang"] . '" value="' . $cartItem["jumlah_minta"] . '">';
    echo '</div>';
    echo '<button type="submit" class="btn btn-primary">Proses Cart</button>';
    echo '</form>';
    echo '<form action="hapusCart.php" method="post">';
    echo '<button type="submit" name="hapus_cart" class="btn btn-danger">Hapus Cart</button>';
    echo '</form>';
    echo "<br>";
    echo "</div>";
    */
        if ($row) {
          $gambar = $row["gambar"];
          $namaKategori = $row["nama_sub_kategori"];

          // Tampilkan data produk ke dalam tabel
          echo '                    <tr>';
          echo '                      <td scope="row">' . $no . '</td>';
          echo '                      <td>';
          echo '                        <p>' . $cartItem["id_barang"] . '</p>';
          echo '                      </td>';
          echo '                      <td>';
          echo '                        <img src="' . $gambar . '" width="50" class="img-fluid rounded-start" alt="Gambar Produk">';
          echo '                      </td>';
          echo '                      <td>';
          echo '                        <p>' . $cartItem["nama"] . '</p>';
          echo '                      </td>';
          echo '                      <td>';
          echo '                        <p>' . $namaKategori . '</p>';
          echo '                      </td>';
          echo '                      <td>';
          echo '                        <div class="d-flex flex-wrap">';
          echo '                          <input type="number" class="form-control" name="jumlah_minta[' . $cartItem["id_barang"] . ']" value="' . ($cartItem['jumlah_minta'] > 0 ? $cartItem['jumlah_minta'] : 1) . '" min="1" style="width: 75px;" required>';
          echo '                        </div>';
          echo '                      </td>';
          echo '                    </tr>';
          $no++;
        }
      }
    }


    echo '                  </tbody>';
    echo '                </table>';
    echo '';
    echo '                <div class="row">';
    echo '                  <div class="col-md d-flex justify-content-start">';
    echo '                    <a href="indexUser.php" class="btn btn-danger rounded-pill px-4 me-0 me-xl-3">Kembali</a>';
    echo '<form id="pesanForm" action="prosesCart.php" method="POST" onsubmit="return validateForm(event);">';
    echo '<button type="submit" name="pesan" class="btn btn-primary rounded-pill px-4 me-3">Pesan</button>';
    echo '</form>';

    echo '                  </div>';
    echo '                </div>';
    echo '             </form>';

    echo '<br>';

    echo '           </div>';
    echo '          </div>';
    echo '        </div>';
    echo '      </div>';
    echo '    </div>';
    echo '  </div>';
    echo '</div>';

    // Close database connection
    db_disconnect($con);
    ?>
  </main>

  <!-- End #main -->

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

  <!-- Template Main JS File -->
  <script src="assets/js/main.js"></script>

  <script>
    if (currentValue > 1) {
      jumlahInput.value = currentValue - 1;
    }

    tambahBtn.addEvedocument.addEventListener('DOMContentLoaded', function() {
      var kurangBtn = document.querySelector('.btn-kurang-'.$cartItem["id_barang"]);
      var tambahBtn = document.querySelector('.btn-tambah-'.$cartItem["id_barang"]);
      var jumlahInput = document.querySelector('input[name="jumlah_minta"]'.$cartItem["id_barang"]);

      // Set nilai awal form control menjadi 1
      jumlahInput.value = 1;

      kurangBtn.addEventListener('click', function() {
        var currentValue = parseInt(jumlahInput.value);
        ntListener('click', function() {
          var currentValue = parseInt(jumlahInput.value);
          jumlahInput.value = currentValue + 1;
        });
      });
    });
  </script>

<script>
function validateForm(event) {
  event.preventDefault(); // Prevent the default form submission

  var inputs = document.querySelectorAll('input[type="number"]');

  // Loop through all input elements of type number
  for (var i = 0; i < inputs.length; i++) {
    var inputValue = inputs[i].value;

    if (inputValue === "" || inputValue == 0) {
      alert("Jumlah minta tidak boleh kosong / lebih dari 0");
      return false; // Stop the form submission
    }
  }

  // If validation passes, submit the form programmatically
  document.getElementById("pesanForm").submit();
}
</script>
</body>

</html>