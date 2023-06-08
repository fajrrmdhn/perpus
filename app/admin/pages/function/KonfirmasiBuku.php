<?php
session_start();
include "../../../../config/koneksi.php";

if ($_GET['aksi'] == "ya") {
    $id_peminjaman = $_GET['id'];
    $judul_buku = $_GET['judul'];
    $jumlah_buku2 = $_GET['jumlah_buku_pinjam'];
    $kondisi_buku_saat_dipinjam = $_GET['kondisi'];
    date_default_timezone_set('Asia/Jakarta');
    $tanggal_kirim = date('d-m-Y');

    $sql = "UPDATE peminjaman SET konfirmasi = 'Di Konfirmasi', tanggal_peminjaman = '$tanggal_kirim' WHERE id_peminjaman = '$id_peminjaman'";
    $sql .= mysqli_query($koneksi, $sql);

    if ($sql) {
        $_SESSION['berhasil'] = "Konfirmasi berhasil !";
        header("location: " . $_SERVER['HTTP_REFERER']);
        if ($kondisi_buku_saat_dipinjam == "Baik"){
            $sql2 = "UPDATE buku SET j_buku_baik = j_buku_baik - $jumlah_buku2 WHERE judul_buku = '$judul_buku'";
            $setbuku = mysqli_query($koneksi, $sql2);
        } elseif ($kondisi_buku_saat_dipinjam == "Rusak"){
            $sql2 = "UPDATE buku SET j_buku_rusak = j_buku_rusak - $jumlah_buku2 WHERE judul_buku = '$judul_buku'";
            $setbuku = mysqli_query($koneksi, $sql2);
        }
    } else {
        $_SESSION['gagal'] = "Konfirmasi gagal !";
        header("location: " . $_SERVER['HTTP_REFERER']);
    }
} else if ($_GET['aksi'] == "tidak") {
    $id_peminjaman = $_GET['id'];
    date_default_timezone_set('Asia/Jakarta');
    $tanggal_kirim = date('d-m-Y');

    $sql = "UPDATE peminjaman SET konfirmasi = 'Tidak Dikonfirmasi', tanggal_pengembalian = '$tanggal_kirim' WHERE id_peminjaman = '$id_peminjaman'";
    $sql .= mysqli_query($koneksi, $sql);

    if ($sql) {
        $_SESSION['berhasil'] = "Konfirmasi berhasil !";
        header("location: " . $_SERVER['HTTP_REFERER']);
    } else {
        $_SESSION['gagal'] = "Konfirmasi gagal !";
        header("location: " . $_SERVER['HTTP_REFERER']);
    }
}