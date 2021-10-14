<?php
session_start();

// cek apakah yang mengakses halaman ini sudah login
if ($_SESSION['level'] == "") {
  header("location: ../../index.php");
}

require '../../functions.php';

// ambil data di URL
$id = $_GET["id"];

//query data siswa berdasarkan id nya
$swa = query("SELECT * FROM tb_siswa WHERE id_siswa = $id")[0];

// Cek apakah tombol submit sudah pernah di tekan atau belum
if (isset($_POST["submit"])) {
  // cek apakah data berhasil di ubah atau tidak
  if (ubahSiswa($_POST) > 0) {
    echo "
        <script>
        alert('DATA BERHASIL DIUBAH !');
        document.location.href = '../tables/tb_siswa.php';
        </script>
      ";
  } else {
    echo "
        <script>
        alert('DATA GAGAL DIUBAH !!');
        document.location.href = '../tables/tb_siswa.php';
        </script>
      ";
  }
}

?>

<!DOCTYPE html>
<html>

<head>
  <title>Ubah Data Siswa</title>
  <link rel="icon" href="../../icon/logo.png">

  <!-- Bootstrap CSS -->
  <link href="../bs5/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="../../bs5/css/bootstrap.min.css" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" />
  <link rel="stylesheet" href="../../bs5/css/dataTables.bootstrap5.min.css" />
  <link rel="stylesheet" href="../../bs5/css/style.css" />
</head>

<body>
  <!-- top navigation bar -->
  <nav class="navbar navbar-expand-lg navbar-dark fixed-top" style="background-color: #000080;">
    <div class="container-fluid">
      <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebar" aria-controls="offcanvasExample">
        <span class="navbar-toggler-icon" data-bs-target="#sidebar"></span>
      </button>
      <a class="navbar-brand me-auto ms-lg-0 ms-3 text-uppercase fw-bold" href="../home.php">R.Perpustakaan (Petugas)</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#topNavBar" aria-controls="topNavBar" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="topNavBar">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle ms-2" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              <i class="bi bi-person-fill"></i>
            </a>
            <ul class="dropdown-menu dropdown-menu-end">
              <li><a class="dropdown-item" href="#">Profile</a></li>
              <li><a class="dropdown-item" href="../../logout.php">Logout</a></li>
            </ul>
          </li>
        </ul>
      </div>
    </div>
  </nav>
  <!-- top navigation bar -->

  <!-- offcanvas -->
  <div class="offcanvas offcanvas-start sidebar-nav" tabindex="-1" id="sidebar" style="background-color: #000080;">
    <div class="offcanvas-body p-0">
      <nav class="navbar-dark">
        <ul class="navbar-nav">
          <li>
            <div class="text-muted small fw-bold text-uppercase px-3">CORE</div>
          </li>
          <li>
            <a href="../home.php" class="nav-link px-3 active">
              <span class="me-2"><i class="bi bi-speedometer2"></i></span>
              <span>Dashboard</span>
            </a>
          </li>
          <li class="my-4">
            <hr class="dropdown-divider bg-light" />
          </li>
          <li>
            <div class="text-muted small fw-bold text-uppercase px-3 mb-3">ADD DATA <i class="bi bi-person-plus-fill"></i></div>
          </li>
          <li>
            <a href="../add/add_siswa.php" class="nav-link px-3">
              <span class="me-2"><i class="bi bi-person-fill"></i></span>
              <span>Siswa</span>
            </a>
          </li>
          <li>
            <a href="../add/add_buku.php" class="nav-link px-3">
              <span class="me-2"><i class="bi bi-book-fill"></i></span>
              <span>Buku</span>
            </a>
          </li>

          <li class="my-4">
            <hr class="dropdown-divider bg-light" />
          </li>
          <li>
            <div class="text-muted small fw-bold text-uppercase px-3 mb-3">TRANSAKSI</div>
          </li>
          <li>
            <a href="../transaksi/transaksi.php" class="nav-link px-3">
              <span class="me-2"><i class="bi bi-arrow-up-right-square"></i></span>
              <span>Pinjaman</span>
            </a>
          </li>
          <li>
            <a href="../transaksi/pengembalian.php" class="nav-link px-3">
              <span class="me-2"><i class="bi bi-arrow-down-left-square"></i></span>
              <span>Pengembalian</span>
            </a>
          </li>
        </ul>
      </nav>
    </div>
  </div>
  <!-- offcanvas -->
  <main class="mt-5 pt-3">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
          <h1 class="text-center">Ubah Data Siswa</h1>

          <div class="container">
            <div class="card mt-3 shadow">
              <div class="card-header bg-primary text-white text-center">
                Form Ubah Data Siswa
              </div>
              <div class="card-body">
                <form action="" method="POST" enctype="multipart/form-data">
                  <input type="hidden" name="id" value="<?= $swa["id_siswa"]; ?>">
                  <input type="hidden" name="fotoLama" value="<?= $swa["foto"]; ?>">

                  <div class="form-group mb-3">
                    <label for="nama">
                      Nama :
                    </label>
                    <input type="text" name="name" id="nama" required value="<?= $swa["nama"]; ?>" autocomplete="off" class="form-control">

                  </div>

                  <div class="form-group mb-3">
                    <label for="username">
                      Username :
                    </label>
                    <input type="text" name="username" id="username" required value="<?= $swa["username"]; ?>" autocomplete="off" class="form-control">
                  </div>

                  <div class="form-group mb-3">
                    <label for="email">
                      Email :
                    </label>
                    <input type="email" name="email" id="email" required value="<?= $swa["email"]; ?>" autocomplete="off" class="form-control">
                  </div>

                  <div class="form-group mb-3">
                    <label for="foto">
                      Foto : <br>
                      <img src="../../img/siswa/<?= $swa['foto']; ?>" width="70"> <br>
                      <input type="file" name="foto" id="foto" class="form-control">
                    </label>
                  </div>

                  <button type="submit" name="submit" class="btn btn-success">Ubah Data!</button>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>
  <script src="../../bs5/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js@3.0.2/dist/chart.min.js"></script>
  <script src="../../bs5/js/jquery-3.5.1.js"></script>
  <script src="../../bs5/js/jquery.dataTables.min.js"></script>
  <script src="../../bs5/js/dataTables.bootstrap5.min.js"></script>
  <script src="../../bs5/js/script.js"></script>
</body>

</html>

</body>

</html>