<?php
session_start();

// cek apakah yang mengakses halaman ini sudah login
if ($_SESSION['level'] == "") {
  header("location: ../../index.php");
}

require '../../functions.php';

// Pagination
// konfigurasi
// $jumlahDataPerHalaman = 5;
// $jumlahData = count(query("SELECT * FROM transaksi"));
// $jumlahHalaman = ceil($jumlahData / $jumlahDataPerHalaman);
// $halamanAktif = (isset($_GET["halaman"])) ? $_GET["halaman"] : 1;
// $awalData = ($jumlahDataPerHalaman * $halamanAktif) - $jumlahDataPerHalaman;


$transaksi = query("SELECT * FROM tb_transaksi WHERE status='pinjam' ORDER BY id_transaksi DESC");

//Tombol cari diklik
if (isset($_POST["cari"])) {
  $transaksi = cariTransaksi($_POST["keyword"]);
}
?>

<!DOCTYPE html>
<html>

<head>
  <title>Pengembalian Buku</title>
  <link rel="icon" href="../../icon/logo.png">

  <!-- Bootstrap CSS -->
  <link href="../bs5/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="../../bs5/css/bootstrap.min.css" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" />
  <link rel="stylesheet" href="../../bs5/css/dataTables.bootstrap5.min.css" />
  <link rel="stylesheet" href="../../bs5/css/style.css" />

  <script src="js/jquery.min.js"></script>
</head>

<body>
  <!-- top navigation bar -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
    <div class="container-fluid">
      <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebar" aria-controls="offcanvasExample">
        <span class="navbar-toggler-icon" data-bs-target="#sidebar"></span>
      </button>
      <a class="navbar-brand me-auto ms-lg-0 ms-3 text-uppercase fw-bold" href="../home.php">R.Perpustakaan (ADMIN)</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#topNavBar" aria-controls="topNavBar" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="topNavBar">
        <form action="" method="POST" class="d-flex ms-auto my-3 my-lg-0">
          <div class="input-group">
            <input class="form-control" id="search" type="text" name="keyword" placeholder="Search" aria-label="Search" />
            <button class="btn btn-primary" type="submit" name="cari">
              <i class="bi bi-search"></i>
            </button>
          </div>
        </form>
        <ul class="navbar-nav">
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
  <div class="offcanvas offcanvas-start sidebar-nav bg-dark" tabindex="-1" id="sidebar">
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
            <a href="../add/add_petugas.php" class="nav-link px-3">
              <span class="me-2"><i class="bi bi-person-lines-fill"></i></span>
              <span>Petugas</span>
            </a>
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
            <a href="transaksi.php" class="nav-link px-3">
              <span class="me-2"><i class="bi bi-arrow-up-right-square"></i></span>
              <span>Pinjaman</span>
            </a>
          </li>
          <li>
            <a href="pengembalian.php" class="nav-link px-3">
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
          <div class="card mt-3 shadow mb-4">
            <div class="card-header bg-primary text-white text-center">
              Daftar Pinjaman
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <!-- NAVIGASI PAGINATION -->
                <!-- <?php if ($halamanAktif > 1) : ?>
                  <a href="?halaman=<?= $halamanAktif - 1; ?>"> &laquo;</a>
                <?php endif; ?>

                <?php for ($i = 1; $i <= $jumlahHalaman; $i++) : ?>
                  <?php if ($i == $halamanAktif) : ?>
                    <a href="?halaman=<?= $i; ?>" style="font-weight: bold; color: black;" class="btn btn-warning"><?= $i; ?></a>
                  <?php else : ?>
                    <a href="?halaman=<?= $i; ?>" class="btn btn-primary"><?= $i; ?></a>
                  <?php endif; ?>
                <?php endfor; ?> -->

                <!-- <?php if ($halamanAktif < $jumlahHalaman) : ?>
                  <a href="?halaman=<?= $halamanAktif + 1; ?>"> &raquo;</a>
                <?php endif; ?> -->
                <table class="text-center table table-bordered table-hover mt-3" id="dataTables-example">
                  <thead>
                    <tr>
                      <th>No</th>
                      <th>Judul</th>
                      <th>NIS</th>
                      <th>Nama</th>
                      <th>Tanggal Pinjam</th>
                      <th>Tanggal Kembali</th>
                      <th>Status</th>
                      <th>Terlambat</th>
                      <th>Denda</th>
                      <th width="10%">Aksi</th>
                    </tr>
                  </thead>
                  <tbody id="tampil">

                    <?php
                    $a = 1;
                    foreach ($transaksi as $data) : ?>
                      <tr>
                        <td><?php echo $a; ?></td>
                        <td>
                          <?= $data['judul']; ?>
                        </td>
                        <td>
                          <?= $data['username']; ?>
                        </td>
                        <td><?php echo $data['nama'];; ?></td>
                        <td><?= $data['tgl_pinjam'] ?></td>
                        <td><?php echo $data['tgl_kembali']; ?></td>
                        <td><?php
                            $tanggal_dateline = $data['tgl_kembali'];
                            $tgl_kembali = date('Y-m-d');
                            $lambat = terlambat($tanggal_dateline, $tgl_kembali);
                            $status = $data["status"];

                            if ($lambat > 0) {
                              echo "<font color='red'>Terlambat </font>";
                            } else {
                              echo "<font color='green'>$status</font>";
                            }

                            ?></td>

                        <td>
                          <?php
                          $tanggal_dateline = $data['tgl_kembali'];
                          $tgl_kembali = date('Y-m-d');
                          $lambat = terlambat($tanggal_dateline, $tgl_kembali);

                          if ($lambat > 0) {
                            echo "<font color='red'>$lambat hari </font>";
                          } else {
                            echo $lambat . " hari";
                          }

                          ?>
                        </td>

                        <td>
                          <?php
                          $denda = 1000;
                          $tanggal_dateline = $data['tgl_kembali'];
                          $tgl_kembali = date('Y-m-d');

                          $lambat = terlambat($tanggal_dateline, $tgl_kembali);

                          $denda1 = $lambat * $denda;

                          if ($lambat > 0) {
                            echo "<font color='red'>Rp.$denda1</font>";
                          } else {
                            echo "Rp" . $lambat;
                          }

                          ?>
                        </td>

                        <td>
                          <a href="kembali.php?id=<?= $data['id_transaksi']; ?>&buku=<?php echo $data['id_buku'] ?>" class="btn btn-danger" onclick="return confirm('ANDA YAKIN MENGEMBALIKAN BUKU INI?');">Kembalikan</a>
                        </td>
                      </tr>
                      <?php $a++; ?>
                    <?php endforeach; ?>
                  </tbody>
                </table>
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

  <script>
    $(document).ready(function() {
      $("#search").keyup(function() {
        $.ajax({
          type: 'POST',
          url: 'search/searchPengembalian.php',
          data: {
            search: $(this).val()
          },
          cache: false,
          success: function(data) {
            $("#tampil").html(data);
          }
        });
      });
    });
  </script>

</body>

</html>