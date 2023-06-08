<?php
    include "../../config/koneksi.php";
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1 style="font-family: 'Quicksand', sans-serif; font-weight: bold;">
            Data Anggota
            <small>
                <script type='text/javascript'>
                    var months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
                    var myDays = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jum&#39;at', 'Sabtu'];
                    var date = new Date();
                    var day = date.getDate();
                    var month = date.getMonth();
                    var thisDay = date.getDay(),
                        thisDay = myDays[thisDay];
                    var yy = date.getYear();
                    var year = (yy < 1000) ? yy + 1900 : yy;
                    document.write(thisDay + ', ' + day + ' ' + months[month] + ' ' + year);
                    //
                </script>
            </small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Data Anggota</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title" style="font-family: 'Quicksand', sans-serif; font-weight: bold;">Data Anggota</h3>
                        <div class="form-group m-b-2 text-right" style="margin-top: -20px; margin-bottom: -5px;">
                            <button type="button" onclick="tambahAnggota()" class="btn btn-info"><i class="fa fa-plus"></i> Tambah Anggota</button>
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body table-responsive">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Kode Anggota</th>
                                    <th>NIS</th>
                                    <th>Nama Lengkap</th>
                                    <th>Kelas</th>
                                    <th>Alamat</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <?php

                            $no = 1;
                            $query = mysqli_query($koneksi, "SELECT * FROM user WHERE role = 'Anggota'");
                            while ($row = mysqli_fetch_assoc($query)) {
                            ?>
                                <tbody>
                                    <tr>
                                        <td><?= $no++; ?></td>
                                        <td><?= $row['kode_user']; ?></td>
                                        <td><?= $row['nis']; ?></td>
                                        <td><?= $row['fullname']; ?></td>
                                        <td><?= $row['kelas']; ?></td>
                                        <td><?= $row['alamat']; ?></td>
                                        <td>
                                            <a href="#" class="btn btn-info btn-sm" data-toggle="modal" data-target="#modalEditAnggota<?php echo $row['id_user']; ?>"><i class="fa fa-edit"></i></a>
                                            <a href="pages/function/Anggota.php?aksi=hapus&id=<?= $row['id_user']; ?>" class="btn btn-danger btn-sm btn-del"><i class="fa fa-trash"></i></a>
                                        </td>
                                    </tr>
                                    <!-- /. Modal Edit Anggota-->
                                </tbody>
                            <?php
                            }
                            ?>
                        </table>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </section>
    <!-- /.content -->
</div>
<!-- Modal Edit Anggota -->
<?php
$query = mysqli_query($koneksi, "SELECT * FROM user WHERE role = 'Anggota'");
while ($row = mysqli_fetch_assoc($query)) {
    ?>                       
    
<div class="modal fade" id="modalEditAnggota<?php echo $row['id_user']?>">
<div class="modal-dialog">
    <div class="modal-content" style="border-radius: 5px;">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" style="font-family: 'Quicksand', sans-serif; font-weight: bold;">
                Edit Anggota ( <?= $row['kode_user']; ?> - <?= $row['fullname']; ?> )
            </h4>
        </div>
        <form action="pages/function/Anggota.php?aksi=edit" enctype="multipart/form-data" method="POST">
            <div class="modal-body">
                <input type="hidden" value="<?= $row['id_user']; ?>" name="idUser">
                <div class="form-group">
                    <label>Kode Anggota <small style="color: red;">* Otomatis Terisi ( Tidak dapat diubah )</small></label>
                    <input type="text" class="form-control" value="<?= $row['kode_user'] ?>" name="kodeAnggota" readonly>
                </div>
                <div class="form-group">
                    <label>Nomor Induk Siswa </label>
                    <input type="number" class="form-control" value="<?= $row['nis']; ?>" name="nis" readonly>
                </div>
                <div class="form-group">
                    <label>Nama Lengkap </label>
                    <input type="text" class="form-control" value="<?= $row['fullname']; ?>" name="namaLengkap">
                </div>
                <div class="form-group">
                    <label>Nama Pengguna </label>
                    <input type="text" class="form-control" value="<?= $row['username']; ?>" name="uSername">
                </div>
                <div class="form-group">
                    <label>Kata Sandi </label>
                    <input type="text" class="form-control" value="<?= $row['password']; ?>" name="pAssword" readonly>
                </div>
                <div class="form-group">
                    <label>Kelas <small style="color: red;">* Wajib diisi</small></label>
                    <select class="form-control" name="kElas">
                        <!-- X -->
                        <?php 
                            $query2 = mysqli_query($koneksi, "SELECT kelas FROM daftar_kelas");
                            while ($row2 = mysqli_fetch_array($query2)){
                        ?>
                        <option><?php echo $row2['kelas']?></option>
                        <?php 
                            }
                        ?>
                    </select>
                </div>
                <div class="form-group">
                    <label>Alamat </label>
                    <textarea class="form-control" style="resize: none; height: 70px;" name="aLamat"><?= $row['alamat']; ?></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary btn-block">Simpan</button>
            </div>
        </form>
    </div>
    <!-- /.modal-content -->
</div>
<!-- /.modal-dialog -->
</div>
<?php
}
?>
<div class="modal fade" id="modalTambahAnggota">
    <div class="modal-dialog">
        <div class="modal-content" style="border-radius: 5px;">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" style="font-family: 'Quicksand', sans-serif; font-weight: bold;">Tambah Anggota</h4>
            </div>
            <form action="pages/function/Anggota.php?aksi=tambah" enctype="multipart/form-data" method="POST">
                <div class="modal-body">
                    <div class="form-group">
                        <label>Kode Anggota <small style="color: red;">* Otomatis Terisi</small></label>
                        <?php
                        include "../../config/koneksi.php";

                        $query = mysqli_query($koneksi, "SELECT max(kode_user) as kodeTerakhir FROM user");
                        $data = mysqli_fetch_array($query);
                        $kodeTerakhir = $data['kodeTerakhir'];

                        // mengambil angka dari kode barang terbesar, menggunakan fungsi substr
                        // dan diubah ke integer dengan (int)
                        $urutan = (int) substr($kodeTerakhir, 3, 3);

                        // bilangan yang diambil ini ditambah 1 untuk menentukan nomor urut berikutnya
                        $urutan++;

                        // membentuk kode barang baru
                        // perintah sprintf("%03s", $urutan); berguna untuk membuat string menjadi 3 karakter
                        // misalnya perintah sprintf("%03s", 15); maka akan menghasilkan '015'
                        // angka yang diambil tadi digabungkan dengan kode huruf yang kita inginkan, misalnya BRG 
                        $huruf = "AP";
                        $Anggota = $huruf . sprintf("%03s", $urutan);
                        ?>
                        <input type="text" class="form-control" value="<?php echo $Anggota ?>" name="kodeAnggota" readonly>
                    </div>
                    <div class="form-group">
                        <label>Nomor Induk Siswa <small style="color: red;">* Wajib diisi</small></label>
                        <input type="number" class="form-control" placeholder="Masukan NIS" name="nis" required>
                    </div>
                    <div class="form-group">
                        <label>Nama Lengkap <small style="color: red;">* Wajib diisi</small></label>
                        <input type="text" class="form-control" placeholder="Masukan Nama Lengkap" name="namaLengkap" required>
                    </div>
                    <div class="form-group">
                        <label>Nama Pengguna <small style="color: red;">* Wajib diisi</small></label>
                        <input type="text" class="form-control" placeholder="Masukan Nama Pengguna" name="username" required>
                    </div>
                    <div class="form-group">
                        <label>Kata Sandi <small style="color: red;">* Wajib diisi</small></label>
                        <input type="text" class="form-control" placeholder="Masukan Kata Sandi" name="password" required>
                    </div>
                    <div class="form-group">
                        <label>Kelas <small style="color: red;">* Wajib diisi</small></label>
                        <select class="form-control" name="kelas">
                            <option disabled selected>-- Harap Pilih Kelas --</option>
                            <option disabled>------------------------------------------</option>
                            <!-- X -->
                            <?php
                            //query menampilkan nip pegawai ke dalam combobox
                            $query =mysqli_query($koneksi, "SELECT kelas FROM daftar_kelas WHERE kelas LIKE 'X %' ORDER BY kelas");
                            while ($data = mysqli_fetch_array($query)) {
                            ?>
                            <option value="<?=$data['kelas'];?>"><?php echo $data['kelas'];?></option>
                            <?php
                            }
                            ?>
                            <!-- XI -->
                            <option disabled>------------------------------------------</option>
                            <?php
                            //query menampilkan nip pegawai ke dalam combobox
                            $query =mysqli_query($koneksi, "SELECT kelas FROM daftar_kelas WHERE kelas LIKE 'XI %' ORDER BY kelas");
                            while ($data = mysqli_fetch_array($query)) {
                            ?>
                            <option value="<?=$data['kelas'];?>"><?php echo $data['kelas'];?></option>
                            <?php
                            }
                            ?>
                            <!-- XII -->
                            <?php
                            //query menampilkan nip pegawai ke dalam combobox
                            $query =mysqli_query($koneksi, "SELECT kelas FROM daftar_kelas WHERE kelas LIKE 'XII %' ORDER BY kelas");
                            while ($data = mysqli_fetch_array($query)) {
                            ?>
                            <option value="<?=$data['kelas'];?>"><?php echo $data['kelas'];?></option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Alamat <small style="color: red;">* Wajib diisi</small></label>
                        <textarea class="form-control" style="resize: none; height: 70px;" name="alamat" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary btn-block">Simpan</button>
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
<script>
    function tambahAnggota() {
        $('#modalTambahAnggota').modal('show');
    }
</script>
<!-- jQuery 3 -->
<script src="../../assets/bower_components/jquery/dist/jquery.min.js"></script>
<script src="../../assets/dist/js/sweetalert.min.js"></script>
<!-- Pesan Berhasil Edit -->
<script>
    <?php
    if (isset($_SESSION['berhasil']) && $_SESSION['berhasil'] <> '') {
        echo "swal({
            icon: 'success',
            title: 'Berhasil',
            text: '$_SESSION[berhasil]'
        })";
    }
    $_SESSION['berhasil'] = '';
    ?>
</script>
<!-- Pesan Gagal Edit -->
<script>
    <?php
    if (isset($_SESSION['gagal']) && $_SESSION['gagal'] <> '') {
        echo "swal({
                icon: 'error',
                title: 'Gagal',
                text: '$_SESSION[gagal]'
              })";
    }
    $_SESSION['gagal'] = '';
    ?>
</script>
<!-- Swal Hapus Data -->
<script>
    $('.btn-del').on('click', function(e) {
        e.preventDefault();
        const href = $(this).attr('href')

        swal({
                icon: 'warning',
                title: 'Peringatan',
                text: 'Apakah anda yakin ingin menghapus data anggota ini ?',
                buttons: true,
                dangerMode: true,
                buttons: ['Tidak, Batalkan !', 'Iya, Hapus']
            })
            .then((willDelete) => {
                if (willDelete) {
                    document.location.href = href;
                } else {
                    swal({
                        icon: 'error',
                        title: 'Dibatalkan',
                        text: 'Data anggota tersebut aman !'
                    })
                }
            });
    })
</script>