<?php
$server = "localhost";
$username = "root";
$password = "";
$database = "db_perpustakaan";

$koneksi = mysqli_connect($server, $username, $password, $database);

if (mysqli_connect_errno()) {
    echo "Koneksi database gagal : " . mysqli_connect_error();
}

 
$data = $_POST['data'];
$id = $_POST['id'];
?>
<?php 
if($data == "kabupaten"){
	?>
	<select id="form_kab">
	<option value="">-- Silahkan pilih judul buku --</option>
		<?php
			$daerah = mysqli_query($koneksi,"SELECT * FROM buku WHERE kategori_buku = '$id' and (j_buku_rusak > 0 or j_buku_baik > 0)");
			while($d = mysqli_fetch_array($daerah)){
			?>
			<option value="<?php echo $d['judul_buku']; ?>"><?php echo $d['judul_buku']; ?></option>
			<?php 
		}
		?>
	</select>
 
<?php } ?>