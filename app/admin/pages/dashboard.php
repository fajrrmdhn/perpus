<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1 style="font-family: 'Quicksand', sans-serif; font-weight: bold;">
            Dashboard
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
            <li class="active">Dashboard</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.4.0/Chart.min.js"></script>
        <script type="text/javascript" src="jscript/graph.js"></script>
        <div class="alert alert-secondary" style="color: #383d41; background-color: #e2e3e5; border-color: #d6d8db;">
            Selamat Datang, <?= $_SESSION['fullname']; ?> di Administrator Perpustakaan SMAN 23 Bandung.
        </div>
        <!-- Small boxes (Stat box) -->
        <div class="row">
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <?php
                include "../../config/koneksi.php";
                $query_anggota = mysqli_query($koneksi, "SELECT * FROM user WHERE role = 'Anggota'");
                $row_anggota = mysqli_num_rows($query_anggota);
                ?>
                <div class="small-box bg-aqua">
                    <div class="inner">
                        <h3><?= $row_anggota; ?></h3>
                        <p>Anggota</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-users"></i>
                    </div>
                    <a href="anggota" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <?php
                include "../../config/koneksi.php";
                $query_buku = mysqli_query($koneksi, "SELECT * FROM buku");
                $row_buku = mysqli_num_rows($query_buku);
                ?>
                <div class="small-box bg-green">
                    <div class="inner">
                        <h3><?= $row_buku; ?></h3>
                        <p>Buku</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-book"></i>
                    </div>
                    <a href="data-buku" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <?php
                include "../../config/koneksi.php";
                $query_peminjaman = mysqli_query($koneksi, "SELECT * FROM peminjaman WHERE tanggal_peminjaman > 0");
                $row_peminjaman = mysqli_num_rows($query_peminjaman);
                ?>
                <div class="small-box bg-yellow">
                    <div class="inner">
                        <h3><?= $row_peminjaman; ?></h3>
                        <p>Peminjaman</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-sign-out"></i>
                    </div>
                    <a href="data-peminjaman" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <?php
                include "../../config/koneksi.php";
                $query_pengembalian = mysqli_query($koneksi, "SELECT * FROM peminjaman WHERE tanggal_pengembalian > 0");
                $row_pengembalian = mysqli_num_rows($query_pengembalian);
                ?>
                <div class="small-box bg-red">
                    <div class="inner">
                        <h3><?= $row_pengembalian; ?></h3>
                        <p>Pengembalian</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-sign-in"></i>
                    </div>
                    <a href="data-pengembalian" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
        </div>
        <!-- /.row -->
        <div class="row">
            <!-- -->
            <?php
            include "../../config/koneksi.php";
            $query = mysqli_query($koneksi, "SELECT * FROM identitas");
            $row = mysqli_fetch_assoc($query);
            ?>
            <img src="../../assets/dist/img/icon.png" width="120px" height="120px" style="display: block; margin-left: auto; margin-right: auto; margin-top: 50px; margin-bottom: -20px;">

            <h2 class="text-center" style="font-family: Quicksand, sans-serif;"><?= $row['nama_app']; ?></h2>
            <p class="text-center">Alamat : <?= $row['alamat_app']; ?>| Email : <?= $row['email_app']; ?> | Nomor Telpon : <?= $row['nomor_hp']; ?> </p>

        </div>
        <!-- /.row -->

        <!-- ./chart 
        <div class="row">
            <canvas id="myChart"></canvas>
        </div>

        <script>
        var ctx = document.getElementById("myChart").getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ["Buku", "Peminjaman"],
                datasets: [{
                    label: 'Grafik Peminjaman',
                    data: [
                    <?php 
                    $jumlah_buku = mysqli_query($koneksi,"SELECT * FROM buku");
                    echo mysqli_num_rows($jumlah_buku);
                    ?>, 
                    <?php 
                    $jumlah_peminjaman = mysqli_query($koneksi,"SELECT * FROM peminjaman WHERE tanggal_peminjaman > 0");
                    echo mysqli_num_rows($jumlah_peminjaman);
                    ?>
                    ],
                    backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)'
                    ],
                    borderColor: [
                    'rgba(255,99,132,1)',
                    'rgba(54, 162, 235, 1)'
                    ],
                    borderWidth: 1,
                }]
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero:true
                        }
                    }]
                }
            }
        });
	    </script>
    ./chart --> 


    </section>
    <!-- /.content -->
</div>