<?php
	include './config/koneksi-db.php';

	/* Kondisi jika tidak melakukan simpan/ submit, maka tampilkan formulir */
	if(!isset($_POST['simpan'])) {
		/* Mempersiapkan ID Penulis Baru */
		$sql = "SELECT id_penulis FROM penulis;";
		$query = mysqli_query($db_conn, $sql);
		$row = $query->num_rows;

		$id_penulis_tmp = $row + 1; // Menambahkan +1 untuk ID Penulis Baru
		$id_penulis_tmp = str_pad($id_penulis_tmp, 3, "0", STR_PAD_LEFT); // Menambahkan "0" sampai panjang 3 digit termasuk ID Anggota Baru
		$id_penulis_tmp = 'AG' . $id_penulis_tmp; // Menambahkan prefix 'AG' untuk ID Penulis Baru
?>

		<div id="container">
			<div class="page-title">
				<h3>Tambah Data Penulis</h3>	
			</div>
			<div class="page-content">
				<form action="" method="post" enctype="multipart/form-data">
					<table class="form-table">
						<tr>
							<td>
								<label for="id_penulis">ID Penulis</label>
							</td>
							<td>					
								<input type="text" name="id_penulis" id="id_penulis" value="<?php echo $id_penulis_tmp; ?>" readonly>
							</td>
						</tr>
						<tr>
							<td>
								<label for="nama_penulis">Nama Penulis</label>
							</td>
							<td>								
								<input type="text" name="nama_penulis" id="nama_penulis" required>
							</td>
						</tr>												
						<tr>
							<td>
								&nbsp;
							</td>
							<td>								
								<input type="submit" name="simpan" value="Simpan">
							</td>
						</tr>						
					</table>
				</form>
			</div>
		</div>

<?php 
	} else { 
		/* Proses Penyimpanan Data dari Form */

		$id_penulis 	= $_POST['id_penulis'];
		$nama_penulis 	= $_POST['nama_penulis'];
		
		// Query
		$sql = "INSERT INTO penulis 
				VALUES('{$id_penulis}', '{$nama_penulis}')";
		$query = mysqli_query($db_conn, $sql);

		// mengalihkan halaman
		echo "<meta http-equiv='refresh' content='0; url=index.php?p=penulis'>";
	}
?>