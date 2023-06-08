<?php
session_start();
include "../../../../config/koneksi.php";

if ($_GET['aksi'] == "pinjam") {

    if ($_POST['judulBuku'] == NULL) {
        $_SESSION['gagal'] = "Peminjaman buku gagal, Kamu belum memilih buku yang akan dipinjam !";
        header("location: " . $_SERVER['HTTP_REFERER']);
    } elseif ($_POST['kondisiBukuSaatDipinjam'] == NULL) {
        $_SESSION['gagal'] = "Peminjaman buku gagal, Kamu belum memilih kondisi buku yang akan dipinjam !";
        header("location: " . $_SERVER['HTTP_REFERER']);
    } elseif ($_POST['alasanPeminjaman'] == NULL) {
        $_SESSION['gagal'] = "Peminjaman buku gagal, Kamu belum memberikan alasan peminjaman !";
        header("location: " . $_SERVER['HTTP_REFERER']);
    }else {

        include "Pemberitahuan.php";

        $nama_anggota = $_POST['namaAnggota'];
        $judul_buku = $_POST['judulBuku'];
        $jumlah_buku2 = $_POST['jumlahBukuPinjam'];
        $tanggal_peminjaman = $_POST['tanggalPeminjaman'];
        $alasan_peminjaman = $_POST['alasanPeminjaman'];
        $kondisi_buku_saat_dipinjam = $_POST['kondisiBukuSaatDipinjam'];

        $query = mysqli_query($koneksi, "SELECT * FROM peminjaman WHERE nama_anggota = '$nama_anggota' AND judul_buku = '$judul_buku' AND tanggal_pengembalian = ''");
        $cek = mysqli_num_rows($query);

        if ($cek > 0) {
            $_SESSION['gagal'] = "Peminjaman buku gagal, Kamu telah meminjam buku ini sebelumnya !";
            header("location: " . $_SERVER['HTTP_REFERER']);
        } else {
            $sql = "INSERT INTO peminjaman(nama_anggota,judul_buku,jumlah_buku_pinjam,alasan_peminjaman,kondisi_buku_saat_dipinjam,konfirmasi)
            VALUES('" . $nama_anggota . "','" . $judul_buku . "'," . $jumlah_buku2 . ",'" . $alasan_peminjaman . "','" . $kondisi_buku_saat_dipinjam . "','Belum di Konfirmasi')";
            $sql .= mysqli_query($koneksi, $sql);
        
            // Send notif to admin
            InsertPemberitahuanPeminjaman();
            //

            if ($sql) {
                $_SESSION['berhasil'] = "Peminjaman buku berhasil !";
                header("location: " . $_SERVER['HTTP_REFERER']);
            } else {
                $_SESSION['gagal'] = "Terjadi masalah dalam pengiriman data peminjaman !";
                header("location: " . $_SERVER['HTTP_REFERER']);
            }
        }
    }
} elseif ($_GET['aksi'] == "pengembalian") {
    include "../../config/koneksi.php";
    $id = $_SESSION['fullname'];
    $judul_buku = $_POST['judulBuku'];
    $tanggal_pengembalian = $_POST['tanggalPengembalian'];
    $tanggal_peminjaman = $_POST['tanggalPeminjaman'];
    $diambil_id = mysqli_query($koneksi, "SELECT * FROM peminjaman WHERE judul_buku = '$judul_buku' AND nama_anggota = '$id' AND tanggal_pengembalian ='' AND konfirmasi = 'Di Konfirmasi'");
    $row2 = mysqli_fetch_assoc($diambil_id);
    $id_pinjam = $row2['id_peminjaman'];
    $query_fullname = mysqli_query($koneksi, "SELECT * FROM peminjaman WHERE id_peminjaman = '$id_pinjam'");
    $row1 = mysqli_fetch_array($query_fullname);
                                    

    include "Pemberitahuan.php";
    if ($_POST['judulBuku'] == NULL) {
        $_SESSION['gagal'] = "Pengembalian buku gagal, Kamu belum memilih buku yang akan dikembalikan !";
        header("location: " . $_SERVER['HTTP_REFERER']);
    } elseif ($_POST['kondisiBukuSaatDikembalikan'] == NULL) {
        $_SESSION['gagal'] = "Pengembalian buku gagal, Kamu belum memilih kondisi buku yang akan dikembalikan !";
        header("location: " . $_SERVER['HTTP_REFERER']);
    }elseif ($_POST['hasilLiterasi'] == NULL) {
        $_SESSION['gagal'] = "Pengembalian buku gagal, Kamu belum membuat hasil literasi !";
        header("location: " . $_SERVER['HTTP_REFERER']);
    }

    $diff = date_diff ($tanggal_peminjaman,$tanggal_pengembalian);
    $days = $diff ->days;
    
    if ($_POST['kondisiBukuSaatDikembalikan'] == "Hilang" || $jumlah_buku2 >= $jumlah_buku) {
        $denda = "Rp 30.000";
    }elseif ($_POST['kondisiBukuSaatDikembalikan'] === "Rusak" && $row1['kondisi_buku_saat_dipinjam'] === "Rusak" && $days <= 2) {
        $denda = "Tidak ada";
    }elseif ($_POST['kondisiBukuSaatDikembalikan'] === "Rusak" && $row1['kondisi_buku_saat_dipinjam'] === "Rusak" && $days > 2) {
        $denda = "Rp 5.000";
    }elseif ($_POST['kondisiBukuSaatDikembalikan'] === "Rusak" && $row1['kondisi_buku_saat_dipinjam'] === "Rusak" && $days >= 14) {
        $denda = "Rp 10.000";
    }elseif ($_POST['kondisiBukuSaatDikembalikan'] ==="Rusak" && $row1['kondisi_buku_saat_dipinjam'] === "Baik" && $days <= 2) {
        $denda = "Rp 10.000";
    }elseif ($_POST['kondisiBukuSaatDikembalikan'] ==="Rusak" && $row1['kondisi_buku_saat_dipinjam'] === "Baik" && $days > 2) {
        $denda = "Rp 15.000";
    }elseif ($_POST['kondisiBukuSaatDikembalikan'] ==="Rusak" && $row1['kondisi_buku_saat_dipinjam'] === "Baik" && $days >= 14) {
        $denda = "Rp 20.000";
    }elseif ($_POST['kondisiBukuSaatDikembalikan'] == "Baik" && $days <= 2) {
        $denda = "Tidak ada";
    }elseif ($_POST['kondisiBukuSaatDikembalikan'] == "Baik" && $days > 2) {
        $denda = "Rp 5.000";
    }elseif ($_POST['kondisiBukuSaatDikembalikan'] == "Baik" && $days >= 14) {
        $denda = "Rp Rp. 10.000";
    }
    
    $judul_buku = $_POST['judulBuku'];
    $kondisiBukuSaatDikembalikan = $_POST['kondisiBukuSaatDikembalikan'];
    $hasilLiterasi = $_POST['hasilLiterasi'];
    $jumlah_buku = $_POST['jumlahBukuKembali'];

    $ambil_id = mysqli_query($koneksi, "SELECT * FROM peminjaman WHERE judul_buku = '$judul_buku' AND nama_anggota = '$id' AND tanggal_pengembalian =''");
    $row = mysqli_fetch_assoc($ambil_id);

    $id_peminjaman = $row['id_peminjaman'];

    $query = "UPDATE peminjaman SET tanggal_pengembalian = '$tanggal_pengembalian',jumlah_buku_kembali = $jumlah_buku, kondisi_buku_saat_dikembalikan = '$kondisiBukuSaatDikembalikan',hasil_literasi = '$hasilLiterasi', denda = '$denda' WHERE id_peminjaman = $id_peminjaman";

    $sql = mysqli_query($koneksi, $query);

    if ($sql) {
        // Send notif to admin
        InsertPemberitahuanPengembalian();

        $_SESSION['berhasil'] = "Pengembalian buku berhasil !";
        header("location: " . $_SERVER['HTTP_REFERER']);
        if ($_POST['kondisiBukuSaatDipinjam'] == "Baik"){
            $sql2 = "UPDATE buku SET j_buku_baik = j_buku_baik + $jumlah_buku WHERE judul_buku = '$judul_buku'";
            $setbuku = mysqli_query($koneksi, $sql2);
        } elseif ($_POST['kondisiBukuSaatDipinjam'] == "Rusak"){
            $sql2 = "UPDATE buku SET j_buku_rusak = j_buku_rusak + $jumlah_buku WHERE judul_buku = '$judul_buku'";
            $setbuku = mysqli_query($koneksi, $sql2);
        }
    } else {
        $_SESSION['gagal'] = "Pengembalian buku gagal !";
        header("location: " . $_SERVER['HTTP_REFERER']);
    }

}
function UpdateDataPeminjaman()
{
    include "../../../../config/koneksi.php";

    $nama_lama = $_SESSION['fullname'];
    $nama_anggota = $_POST['Fullname'];

    // Mencari nama dalam database berdasarkan session nama lengkap
    $query1 = mysqli_query($koneksi, "SELECT * FROM user WHERE fullname = '$nama_lama'");
    $row = mysqli_fetch_assoc($query1);

    // membuat variable dari hasil query1
    $nama_lama = $row['fullname'];

    // Fungsi update nama anggota pada table peminjaman
    $query = "UPDATE peminjaman SET nama_anggota = '$nama_anggota'";
    $query .= "WHERE nama_anggota = '$nama_lama'";

    $sql = mysqli_query($koneksi, $query);
}
