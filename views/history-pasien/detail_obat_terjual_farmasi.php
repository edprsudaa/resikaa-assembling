<h5><b><u>Detail Resep Obat</u></b></h5>
<table class="table table-bordered">
	<tbody>
		<tr>
			<th>Dokter</th>
			<td><?php echo $data['dokter'] != NULL ? $data['dokter']['gelar_sarjana_depan'] . ' ' . $data['dokter']['nama_lengkap'] . ' ' . $data['dokter']['gelar_sarjana_belakang'] : '' ?></td>
		</tr>
		<tr>
			<th>Depo</th>
			<td><?php echo $data['depo'] != NULL ? $data['depo']['nama'] : '' ?></td>
		</tr>
		<tr>
			<th>Tanggal</th>
			<td><?php echo date('d-m-Y H:i', strtotime($data['tgl_resep'])) ?></td>
		</tr>
		<tr>
			<th>No Daftar</th>
			<td><?php echo $data['no_daftar'] != NULL ? $data['no_daftar'] : '' ?></td>
		</tr>
	</tbody>
</table>

<h5><b><u>Obat Non Racikan</u></b></h5>
<table class="table table-bordered">
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
		if (count($data['penjualanDetail']) > 0) {
			$no = 1;
			foreach ($data['penjualanDetail'] as $rd) {
		?>
				<tr>
					<td><?php echo $no; ?></td>
					<td><?php echo $rd['barang'] != NULL ? $rd['barang']['nama_barang'] : ''; ?></td>
					<td><?php echo $rd['jumlah']; ?></td>
					<td><?php echo $rd['jumlah_diberi']; ?></td>

					<td><?php echo $rd['signa']; ?></td>
					<td><?php echo $rd['catatan']; ?></td>
					<td><?php echo ($rd['is_diganti'] == 1) ? "Diganti" : '-';
						"" ?></td>
					<td><?php echo ($rd['is_pengganti'] == 1) ? "Pengganti (" . $rd['barangGanti']['nama_barang'] . ")" : '-';
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