<?php
	include './config/koneksi-db.php';

	/* Kondisi jika tidak melakukan simpan/ submit, maka tampilkan formulir */
	if(!isset($_POST['simpan'])) {
		/* Mempersiapkan ID Penerbit Baru */
		$sql = "SELECT id_penerbit FROM penerbit;";
		$query = mysqli_query($db_conn, $sql);
		$row = $query->num_rows;

		$id_penerbit_tmp = $row + 1; // Menambahkan +1 untuk ID Penerbit Baru
		$id_penerbit_tmp = str_pad($id_penerbit_tmp, 3, "0", STR_PAD_LEFT); // Menambahkan "0" sampai panjang 3 digit termasuk ID Anggota Baru
		$id_penerbit_tmp = 'PN' . $id_penerbit_tmp; // Menambahkan prefix 'AG' untuk ID Penerbit Baru
?>

		<div id="container">
			<div class="page-title">
				<h3>Tambah Data Penerbit</h3>	
			</div>
			<div class="page-content">
				<form action="" method="post" enctype="multipart/form-data">
					<table class="form-table">
						<tr>
							<td>
								<label for="id_penerbit">ID Penerbit</label>
							</td>
							<td>					
								<input type="text" name="id_penerbit" id="id_penerbit" value="<?php echo $id_penerbit_tmp; ?>" readonly>
							</td>
						</tr>
						<tr>
							<td>
								<label for="nama_penerbit">Nama Penerbit</label>
							</td>
							<td>								
								<input type="text" name="nama_penerbit" id="nama_penerbit" required>
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

		$id_penerbit 	= $_POST['id_penerbit'];
		$nama_penerbit 	= $_POST['nama_penerbit'];
		
		// Query
		$sql = "INSERT INTO penerbit 
				VALUES('{$id_penerbit}', '{$nama_penerbit}')";
		$query = mysqli_query($db_conn, $sql);

		// mengalihkan halaman
		echo "<meta http-equiv='refresh' content='0; url=index.php?p=penerbit'>";
	}
?>