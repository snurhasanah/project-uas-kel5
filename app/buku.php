<?php
	include './config/koneksi-db.php';

	$row = 0;
	$num = 0;
	$offset = 0;
	if(!isset($_POST['cari'])) { // Jika tidak melakukan pencarian buku
		/*** Pagination ***/
		if(isset($_GET['num'])) { // Jika menggunakan pagination
			$num = (int)$_GET['num'];

			if($num > 0) {
				$offset = ($num * $_QUERY_LIMIT) - $_QUERY_LIMIT;
			}
		}

		/* Query Main */
		$sql = "SELECT * FROM buku ORDER BY id_buku DESC LIMIT {$offset}, {$_QUERY_LIMIT};";
		$query = mysqli_query($db_conn, $sql);

		/* Query Count All */
		$sql_count = "SELECT id_buku FROM buku;";
		$query_count = mysqli_query($db_conn, $sql_count);		
		$row = $query_count->num_rows;
	} else { // Jika melakukan pencarian buku
		/*** Pencarian ***/
		$kata_kunci = $_POST['kata_kunci'];

		if(!empty($kata_kunci)) {
			/* Query Pencarian */
			$sql = "SELECT * FROM buku 
					WHERE id_buku LIKE '%{$kata_kunci}%'
						OR nama_lengkap LIKE '%{$kata_kunci}%'
						OR alamat LIKE '%{$kata_kunci}%'
					ORDER BY id_buku DESC;";
			$query = mysqli_query($db_conn, $sql);
			$row = $query->num_rows;
		}
	}
?>

		<div id="container">
			<div class="page-title">
				<h3>Data Buku</h3>	
			</div>
			<div class="page-content">
				<div class="table-upper">
					<div class="table-upper-left">
						<a href="index.php?p=buku-tambah" class="btn-success btn-medium">Tambah</a>
						<a href="./app/buku-cetak-daftar.php" title="Cetak Buku" target="_blank">
							<img src="./assets/img/print.png" width="50" class="btn-print">
						</a>
					</div>
					<div class="table-upper-right">
						<form name="pencarian_buku" action="" method="post" class="mg-top-15 text-right">
							<input type="text" name="kata_kunci">
							<input type="submit" name="cari" value="Cari">
						</form>
					</div>
				</div>

			<?php 
				if($row > 0) {
			?>
				<table class="data-table">
					<tr>
						<th>No.</th>
						<th>ID Buku</th>
						<th>Judul Buku</th>
						<th>ID Kategori</th>
						<th>ID Penulis</th>
						<th>ID Penerbit</th>
						<th>Status Aktif</th>
						<th>Aksi</th>
					</tr>
				<?php
					$i = 1;
					while($data = mysqli_fetch_array($query)) {
				?>
					<tr>
						<td class="text-center"><?php echo $i++; ?></td>
						<td><?php echo $data['id_buku']; ?></td>
						<td><?php echo $data['judul_buku']; ?></td>
                        <td><?php echo $data['id_kategori']; ?></td>
						<td><?php echo $data['id_penulis']; ?></td>
                        <td><?php echo $data['id_penerbit']; ?></td>
						<td>
							<?php
								$data_foto = $data['foto'];
								if($data_foto == '-') {
									$data_foto = 'foto-default.jpg';
								}
							?>
							<img src="<?php echo './images/' . $data_foto; ?>" width="60">
						</td>
						<td><?php echo ($data['jenis_kelamin'] == 'L') ? 'Pria' : 'Wanita'; ?></td>
						<td><?php echo $data['alamat']; ?></td>
						<td class="text-center"><?php echo ($data['status_aktif'] == 'Y') ? 'Ya' : 'Tidak'; ?></td>
						<td class="text-center">
							<a href="./app/buku-cetak-kartu.php?&id=<?php echo $data['id_buku']; ?>" class="btn-primary mg-btm-5" target="_blank">Cetak Kartu</a>
							<a href="index.php?p=buku-ubah&id=<?php echo $data['id_buku']; ?>" class="btn-warning mg-btm-5">Ubah</a>
							<a href="index.php?p=buku-hapus&id=<?php echo $data['id_buku']; ?>" class="btn-danger mg-btm-5 confirm">Hapus</a>
						</td>
					</tr>
				<?php
					}
				?>
				</table>
				<div class="table-lower">
					<div class="table-lower-left mg-top-5">
						Jumlah Data: <?php echo $row; ?>
					</div>
					<div class="table-lower-right text-right">
					<?php if(!isset($_POST['cari'])) { // disable pagination untuk pencarian ?>
						<ul class="table-pagination">
						<?php
							$page_num = ceil($row/$_QUERY_LIMIT);

							for($i = 1; $i <= $page_num; $i++) {
						?>
							<li><a href="index.php?p=buku&num=<?php echo $i; ?>" <?php echo ($num == $i || ($num == 0 && $i == 1)) ? 'class="active"' : '' ?>><?php echo $i; ?></a></li>
					<?php
							}
						}
					?>
						</ul>
					</div>
				</div>
			<?php } else { ?>
				<p class="text-center">Data tidak tersedia.</p>
			<?php } ?>		
			</div>
		</div>