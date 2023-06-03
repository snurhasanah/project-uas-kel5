<?php
	include './config/koneksi-db.php';

	/* Kondisi jika tidak melakukan simpan/ submit, maka tampilkan formulir */
	if(!isset($_POST['simpan'])) {
		/* Mempersiapkan ID Kategori Baru */
		$sql = "SELECT id_kategori FROM kategori;";
		$query = mysqli_query($db_conn, $sql);
		$row = $query->num_rows;

		$id_kategori_tmp = $row + 1; // Menambahkan +1 untuk ID Kategori Baru
		$id_kategori_tmp = str_pad($id_kategori_tmp, 3, "0", STR_PAD_LEFT); // Menambahkan "0" sampai panjang 3 digit termasuk ID Anggota Baru
		$id_kategori_tmp = 'AG' . $id_kategori_tmp; // Menambahkan prefix 'AG' untuk ID Kategori Baru
?>

		<div id="container">
			<div class="page-title">
				<h3>Tambah Data Kategori</h3>	
			</div>
			<div class="page-content">
				<form action="" method="post" enctype="multipart/form-data">
					<table class="form-table">
						<tr>
							<td>
								<label for="id_kategori">ID Kategori</label>
							</td>
							<td>					
								<input type="text" name="id_kategori" id="id_kategori" value="<?php echo $id_kategori_tmp; ?>" readonly>
							</td>
						</tr>
						<tr>
							<td>
								<label for="nama_kategori">Nama Kategori</label>
							</td>
							<td>								
								<input type="text" name="nama_kategori" id="nama_kategori" required>
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

		$id_kategori 	= $_POST['id_kategori'];
		$nama_kategori 	= $_POST['nama_kategori'];
		
		// Query
		$sql = "INSERT INTO kategori 
				VALUES('{$id_kategori}', '{$nama_kategori}')";
		$query = mysqli_query($db_conn, $sql);

		// mengalihkan halaman
		echo "<meta http-equiv='refresh' content='0; url=index.php?p=kategori'>";
	}
?>