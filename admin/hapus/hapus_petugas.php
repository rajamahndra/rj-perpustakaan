<?php
session_start();

// cek apakah yang mengakses halaman ini sudah login
if ($_SESSION['level'] == "") {
  header("location: ../../index.php");
}

require '../../functions.php';

$id = $_GET["id"];

if (hapusPetugas($id) > 0) {
  echo "
        <script>
        alert('DATA BERHASIL DIHAPUS !');
        document.location.href = '../tables/tb_petugas.php';
        </script>
      ";
} else {
  echo "
        <script>
        alert('DATA GAGAL DIHAPUS !');
        document.location.href = '../tables/tb_petugas.php';
        </script>
      ";
}
