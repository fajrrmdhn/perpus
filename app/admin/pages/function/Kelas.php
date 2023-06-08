<?php
session_start();
include "../../../../config/koneksi.php";

if ($_GET['act'] == "tambah") {
    $kode_kelas = $_POST['kodeKelas'];
    $nama_kelas = $_POST['namaKelas'];

    $sql = "INSERT INTO daftar_kelas(kode_kelas,kelas)
            VALUES('$kode_kelas','$nama_kelas')";
    $sql .= mysqli_query($koneksi, $sql);

    if ($sql) {
        $_SESSION['berhasil'] = "Kelas berhasil ditambahkan !";
        header("location: " . $_SERVER['HTTP_REFERER']);
    } else {
        $_SESSION['gagal'] = "Penerbit gagal ditambahkan !";
        header("location: " . $_SERVER['HTTP_REFERER']);
    }
} elseif ($_GET['act'] == "edit") {
    $kode_kelas = $_POST['kodeKelas'];
    $nama_kelas = $_POST['kelas'];

    $query = "UPDATE daftar_kelas SET kelas = '$nama_kelas'";
    $query .= "WHERE kode_kelas = '$kode_kelas'";
    $sql = mysqli_query($koneksi, $query);

    if ($sql) {
        $_SESSION['berhasil'] = "Data Kelas berhasil di ganti !";
        header("location: " . $_SERVER['HTTP_REFERER']);
    } else {
        $_SESSION['gagal'] = "Data Kelas gagal di ganti !";
        header("location: " . $_SERVER['HTTP_REFERER']);
    }
} elseif ($_GET['act'] == "hapus") {
    $kode_kelas = $_GET['id'];

    $sql = mysqli_query($koneksi, "DELETE FROM daftar_kelas WHERE id_kelas = '$kode_kelas'");

    if ($sql) {
        $_SESSION['berhasil'] = "Data Kelas berhasil dihapus !";
        header("location: " . $_SERVER['HTTP_REFERER']);
    } else {
        $_SESSION['gagal'] = "Data Kelas gagal dihapus !";
        header("location: " . $_SERVER['HTTP_REFERER']);
    }
}
