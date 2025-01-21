<?= $this->render('doc_kop_v2', ['pasien' => $pasien]);
// echo '<pre>';
// print_r($data[0]['penjualanDetail']);
// die;
?>
<h5><b><u>Detail Resep Obat</u></b></h5>
<table class="table table-bordered">
	<tbody>
		<tr>
			<th>Dokter</th>
			<td><?php echo $data[0]['dokter'] != NULL ? $data[0]['dokter']['gelar_sarjana_depan'] . ' ' . $data[0]['dokter']['nama_lengkap'] . ' ' . $data[0]['dokter']['gelar_sarjana_belakang'] : '' ?></td>
		</tr>
		<tr>
			<th>Depo</th>
			<td><?php echo $data[0]['depo'] != NULL ? $data[0]['depo']['nama'] : '' ?></td>
		</tr>
		<tr>
			<th>Tanggal</th>
			<td><?php echo date('d-m-Y H:i', strtotime($data[0]['tgl_resep'])) ?></td>
		</tr>
		<tr>
			<th>No Daftar</th>
			<td><?php echo $data[0]['no_daftar'] != NULL ? $data[0]['no_daftar'] : '' ?></td>
		</tr>
	</tbody>
</table>
<h5><b><u>Obat Non Racikan</u></b></h5>
<table border="1" style="border-collapse: collapse">
	<thead>
		<tr>
			<th>No.</th>
			<th>Nama Obat</th>
			<th>Jumlah Diresep</th>
			<th>Jumlah Diberi</th>

			<th>Dosis</th>
			<th>Catatan</th>
			<th>Diganti</th>
			<th>Pengganti</th>
		</tr>
	</thead>
	<tbody>
		<?php
		if (count($data[0]['penjualanDetail']) > 0) {
			$no = 1;
			foreach ($data[0]['penjualanDetail'] as $rd) {
		?>
				<tr>
					<td class="td-tabel-obat-center"><?php echo $no; ?></td>
					<td class="td-tabel-obat-left"><?php echo $rd['barang'] != NULL ? $rd['barang']['nama_barang'] : ''; ?></td>
					<td class="td-tabel-obat-center"><?php echo $rd['jumlah']; ?></td>
					<td class="td-tabel-obat-center"><?php echo $rd['jumlah_diberi']; ?></td>

					<td class="td-tabel-obat-center"><?php echo $rd['signa']; ?></td>
					<td class="td-tabel-obat-left"><?php echo $rd['catatan']; ?></td>
					<td class="td-tabel-obat-left"><?php echo ($rd['is_diganti'] == 1) ? "Diganti" : '-';
													"" ?></td>
					<td class="td-tabel-obat-left"><?php echo ($rd['is_pengganti'] == 1) ? "Pengganti (" . $rd['barangGanti']['nama_barang'] . ")" : '-';
													"" ?></td>

				</tr>
		<?php
				$no++;
			}
		}
		?>
	</tbody>
</table>

<?php //print_r($data);