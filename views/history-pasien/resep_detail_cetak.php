<?php
if ($is_ajax == true) {
	echo $this->render('doc_kop', ['pasien' => $pasien]);
} else {
	echo $this->render('doc_kop_v2', ['pasien' => $pasien]);
} ?>
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
			<td><?php echo date('d-m-Y H:i', strtotime($data['tanggal'])) ?></td>
		</tr>
	</tbody>
</table>
<h5><b><u>Obat Racikan</u></b></h5>
<table class="table table-bordered">
	<tbody>
		<tr>
			<td>
				<pre><?= $data['racikan_txt'] ?></pre>
			</td>
		</tr>
	</tbody>
</table>
<h5><b><u>Obat Non Racikan</u></b></h5>
<table class="table table-bordered">
	<thead>
		<tr>
			<th>No.</th>
			<th>Nama Obat</th>
			<th>Jumlah</th>
			<th>Dosis</th>
			<th>Catatan</th>
		</tr>
	</thead>
	<tbody>
		<?php
		if (count($data['resepDetail']) > 0) {
			$no = 1;
			foreach ($data['resepDetail'] as $rd) {
		?>
				<tr>
					<td><?php echo $no; ?></td>
					<td><?php echo $rd['obat'] != NULL ? $rd['obat']['nama_barang'] : ''; ?></td>
					<td><?php echo $rd['jumlah']; ?></td>
					<td><?php echo $rd['dosis']; ?></td>
					<td><?php echo $rd['catatan']; ?></td>
				</tr>
		<?php
				$no++;
			}
		}
		?>
	</tbody>
</table>
<?php //print_r($data);