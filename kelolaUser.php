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
$namaLengkap = $_SESSION['nama_lengkap'];
?>

<br>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>KELOLA USER - SMART</title>
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
.popup-card {
  display: none;
  position: fixed;
  z-index: 9999;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  width: 400px;
  max-width: 90%;
  background-color: #fff;
  border-radius: 5px;
  padding: 20px;
  box-shadow: 0 2px 5px rgba(0, 0, 0, 0.3);
}

.popup-card .close {
  position: absolute;
  top: 10px;
  right: 10px;
  cursor: pointer;
}

.popup-card h2 {
  margin-top: 0;
}

.popup-card form label {
  display: block;
  margin-bottom: 5px;
}

.popup-card form input[type="text"],
.popup-card form input[type="email"],
.popup-card form input[type="password"] {
  width: 100%;
  padding: 8px;
  margin-bottom: 10px;
  border: 1px solid #ccc;
  border-radius: 4px;
  box-sizing: border-box;
}

.popup-card form input[type="submit"] {
  background-color: #4CAF50;
  color: white;
  padding: 10px 15px;
  border: none;
  border-radius: 4px;
  cursor: pointer;
}

.popup-overlay {
  display: none;
  position: fixed;
  z-index: 9998;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, 0.5);
}
</style>



<body>

  <!-- ======= Header ======= -->
  <header id="header" class="header fixed-top d-flex align-items-center">

    <div class="d-flex align-items-center justify-content-between">
      <a href="index.html" class="logo d-flex align-items-center">
        <img src="assets/img/logo2.png" alt="">
        <span class="htsimpan">SMART<br>
          <tb class="tbsmart">Sistem Manajemen dan Pelayanan Permintaan Barang Persediaan Terpadu</tb></span>
      </a>
      <i class="bi bi-list toggle-sidebar-btn"></i>
    </div><!-- End Logo -->

    <nav class="header-nav ms-auto">

      <ul class="d-flex align-items-center">


      <?php
      require_once 'koneksi.php';
      require_once 'notif_functions.php';

      // Create a database connection
      $con = db_connect();

      // Mengambil notifikasi dari fungsi-fungsi
      $barangHampirHabis = getBarangHampirHabis($con);
      $barangStokMinimal = getBarangStokMinimal($con);

      // Menghitung jumlah notifikasi
      $totalNotifikasi = count($barangHampirHabis) + count($barangStokMinimal);
      ?>

      <li class="nav-item dropdown">
        <a class="nav-link nav-icon" href="#" data-bs-toggle="dropdown">
          <i class="bi bi-bell"></i>
          <span class="badge bg-primary badge-number"><?php echo $totalNotifikasi; ?></span>
        </a><!-- End Notification Icon -->

        <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow notifications">
          <li class="dropdown-header">
            Notifikasi Terbaru
            <a href="#"><span class="badge rounded-pill bg-primary p-2 ms-2">Lihat Semua</span></a>
          </li>
          <li>
            <hr class="dropdown-divider">
          </li>

          <?php
          $counter = 1;
          foreach ($barangHampirHabis as $notif) {
              echo '<li class="notification-item">';
              echo '<i class="bi bi-exclamation-circle text-warning"></i>';
              echo '<div>';
              echo '<h4>Peringatan</h4>';
              echo "<p>$notif</p>";
              echo '</div>';
              echo '</li>';
              echo '<li><hr class="dropdown-divider"></li>';
              $counter++;
          }

          foreach ($barangStokMinimal as $notif) {
              echo '<li class="notification-item">';
              echo '<i class="bi bi-x-circle text-danger"></i>';
              echo '<div>';
              echo '<h4>Stok sudah mencapai batas minimal</h4>';
              echo "<p>$notif</p>";
              echo '</div>';
              echo '</li>';
              echo '<li><hr class="dropdown-divider"></li>';
              $counter++;
          }
          ?>


          <li>
            <hr class="dropdown-divider">
          </li>
          <li class="dropdown-footer">
            <a href="#">Lihat semua notifikasi</a>
          </li>
        </ul><!-- End Notification Dropdown Items -->
      </li><!-- End Notification Nav -->


        <li class="nav-item dropdown pe-3">

          <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
            <img src="assets/img/profile-img.jpg" alt="Profile" class="rounded-circle">
            <span class="d-none d-md-block dropdown-toggle ps-2"><?php echo $namaLengkap; ?></span>
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
              <a class="dropdown-item d-flex align-items-center" href="profil.php">
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
        <a class="nav-link collapsed" data-bs-target="#icons-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-layout-text-window-reverse"></i><span>Kelola Permintaan</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="icons-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
          <li>
            <a href="kelolaPermintaan.php">
              <i class="bi bi-circle"></i><span>Cek Permintaan</span>
            </a>
          </li>
          <li>
          <li>
            <a href="kelolaPermintaan3.php">
              <i class="bi bi-circle"></i><span>Permintaan Selesai</span>
            </a>
          </li>
          <li>
            <a href="kelolaPermintaan2.php">
              <i class="bi bi-circle"></i><span>Cek Stok Barang</span>
            </a>
          </li>
        </ul>
      </li>

  <!-- End Kelola Permintaan Data Sidebar -->

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
      <h1>Kelola User</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.html">Kelola Data</a></li>
          <li class="breadcrumb-item active">Kelola User</li>
        </ol>
    </nav>
    </div><!-- End Page Title -->
   

        <div class="col-lg-8">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Buat Akun Baru</h5>


              <form action="buatAkun.php" method="POST">
                <!-- Form untuk Buat Akun Baru -->


                <div class="row mb-3">
                    <label for="username" class="col-sm-2 col-form-label">Username</label>
                    <div class="col-sm-10">
                        <input name="username" type="text" class="form-control" id="username">
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="nama" class="col-sm-2 col-form-label">Nama Lengkap</label>
                    <div class="col-sm-10">
                        <input name="nama_lengkap" type="text" class="form-control" id="nama">
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="email" class="col-sm-2 col-form-label">Email</label>
                    <div class="col-sm-10">
                        <input name="email" type="email" class="form-control" id="email">
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="nip" class="col-sm-2 col-form-label">NIP</label>
                    <div class="col-sm-10">
                        <input name="nip" type="number" class="form-control" id="nip">
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="Password" class="col-sm-2 col-form-label">Password</label>
                    <div class="col-sm-10">
                        <input name="password" type="password" class="form-control" id="Password">
                    </div>
                </div>


                <div class="row mb-3">
                    <label for="tipeAkun" class="col-sm-2 col-form-label">Tipe Akun</label>
                    <div class="col-sm-10">
                      <select class="form-select" name="tipe_akun" id="tipeAkun" required>
                          <option value="">Pilih Jenis Akun</option>
                          <option value="supervisor">Admin Supervisor</option>
                          <option value="admin">Admin Gudang</option>
                          <option value="user">User</option>
                      </select>
                    </div>
                  </div>
                <div class="text-center">
                    <button type="submit" class="btn btn-primary">Buat Akun</button>
                </div>


              </form>


            </div>
          </div>
        </div>



           <!-- Card -->
          <section class="section">
            <div class="row">
              <div class="col-lg-12">
                <div class="card">
                  <div class="card-body">
                      <h5 class="card-title">Tabel Data User</h5>

                      <!--Tabel Data User-->
                      <table id="example" class="table table-striped" style="width:100%">
                        <thead>
                        <tr>
                          <th>Username</th>
                          <th>Nama Lengkap</th>
                          <th>Email</th>
                          <th>NIP</th>
                          <th>Password</th>
                          <th>Tipe Akun</th>
                          <th>Edit</th>
                          <th>Delete</th>
                        </tr>
                        </thead>
                        <tbody>
                              <?php
                              require_once 'koneksi.php';
                              $con = db_connect();

                              // Mendapatkan data pengguna dari database
                              $query = "SELECT username, nama_lengkap, email, nip, password, tipe_akun FROM tb_user";
                              $result = mysqli_query($con, $query);

                              while ($row = mysqli_fetch_assoc($result)) {
                                $username = $row['username'];
                                $nama = $row['nama_lengkap'];
                                $email = $row['email'];
                                $nip = $row['nip'];
                                $password = $row['password'];
                                $tipeAkun = $row['tipe_akun'];

                                echo "<tr>";
                                echo "<td>$username</td>";
                                echo "<td>$nama</td>";
                                echo "<td>$email</td>";
                                echo "<td>$nip</td>";
                                echo "<td>$password</td>";
                                echo "<td>$tipeAkun</td>";
                                echo "<td><button type='button' class='btn btn-primary' onclick='toggleEditPopup(\"$username\", \"$nama\", \"$email\", \"$nip\", \"$password\", \"$tipeAkun\")'>Edit</button></td>";
                                echo "<td><button type='button' class='btn btn-danger' onclick='confirmDelete(\"$username\")'>Hapus</button></td>";
                                echo "</tr>";
                                echo "</tr>";
                              }

                              db_disconnect($con);
                              ?>
                      </tbody>
                      </table>
                  </div>
                </div>
              </div>
            </div>
          </section>


      <div class="popup-overlay"></div>
                <div class="popup-card" id="editPopup">
                  <span class="close" onclick="toggleEditPopup()">&times;</span>
                  <h3>Edit Data Pengguna</h3>
                  <form action="editUser.php" method="POST">
                  <label for="editUsername">Username</label>
                    <input type="text" id="editUsername" name="editUsername">
                    <label for="editNamaLengkap">Nama Lengkap</label>
                    <input type="text" id="editNamaLengkap" name="editNamaLengkap" required>
                    <label for="editEmail">Email</label>
                    <input type="email" id="editEmail" name="editEmail" required>
                    <label for="editNIP">NIP</label>
                    <input type="text" id="editNIP" name="editNIP" required>
                    <label for="editPassword">Password</label>
                    <input type="password" id="editPassword" name="editPassword" required>
                    <label for="editTipeAkun">Tipe Akun</label>
                    <select class="form-select" name="editTipeAkun" id="editTipeAkun" required>
                        <option value="">Pilih Jenis Akun</option>
                        <option value="supervisor">Admin Supervisor</option>
                        <option value="admin">Admin Gudang</option>
                        <option value="user">User</option>
                    </select>
                    <br>
                    <input type="submit" value="Update">
                  </form>
                </div>



  </main><!-- End #main -->

<!-- ======= Footer ======= -->
<footer id="footer" class="footer">
    <div class="copyright">
      <strong>  SMART - </strong> <span>Sistem Manajemen dan Pelayanan Permintaan Barang Persediaan Terpadu</span>
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

<script>
    // Fungsi untuk melakukan refresh halaman setiap 1 menit
    function autoRefresh() {
      window.location.reload();
    }

    // Mengatur interval untuk melakukan refresh setiap 1 menit (60000 milidetik)
    setInterval(autoRefresh, 60000);

    $(document).ready(function () {
    $('#example').DataTable();
    });

    function confirmDelete(username) {
  if (confirm("Apakah Anda yakin ingin menghapus pengguna dengan username " + username + "?")) {
    // Kirim permintaan penghapusan data ke server
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "hapusUser.php", true);
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function() {
      if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
        // Tanggapi hasil penghapusan data
        var response = JSON.parse(xhr.responseText);
        if (response.success) {
          // Refresh halaman setelah penghapusan berhasil
          location.reload();
        } else {
          // Tampilkan pesan error jika penghapusan gagal
          alert("Terjadi kesalahan saat menghapus pengguna.");
        }
      }
    };
    xhr.send("username=" + username);
  }
}

function toggleEditPopup(username, nama_lengkap, email, nip, password, tipeAkun) {
  var popup = document.getElementById("editPopup");
  var overlay = document.querySelector(".popup-overlay");
  var editUsername = document.getElementById("editUsername");
  var editNamaLengkap = document.getElementById("editNamaLengkap");
  var editEmail = document.getElementById("editEmail");
  var editNIP = document.getElementById("editNIP");
  var editPassword = document.getElementById("editPassword");
  var editTipeAkun = document.getElementById("editTipeAkun");

  editUsername.value = username;
  editNamaLengkap.value = nama_lengkap;
  editEmail.value = email;
  editNIP.value = nip;
  editPassword.value = password;
  editTipeAkun.value = tipeAkun;

  if (popup.style.display === "block") {
    popup.style.display = "none";
    overlay.style.display = "none";
  } else {
    popup.style.display = "block";
    overlay.style.display = "block";
  }
}
</script>

</body>

</html>


