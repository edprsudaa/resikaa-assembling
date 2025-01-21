<h5><b><u>Permintaan Konsultasi</u></b></h5>
<div class="row">
	<div class="col-md-5">
		<table width="100%" border='0'>
			<tbody>
				<tr>
					<th>Tgl Konsultasi</th>
					<td>: <?php echo $data['tanggal_minta']!=NULL ? date('d-m-Y H:i',strtotime($data['tanggal_minta'])) : '' ?></td>
				</tr>
				<tr>
					<th>Unit Asal</th>
					<td>: <?php echo $data['layananMinta']!=NULL ? ($data['layananMinta']['unit']!=NULL ? $data['layananMinta']['unit']['nama'] : ''  ) : '' ?></td>
				</tr>
				<tr>
					<th>Dokter Asal</th>
					<td>: <?php echo $data['dokterMinta']!=NULL ? $data['dokterMinta']['gelar_sarjana_depan'].' '.$data['dokterMinta']['nama_lengkap'].' '.$data['dokterMinta']['gelar_sarjana_belakang'] : '' ?></td>
				</tr>
				<tr>
					<th>Unit Tujuan</th>
					<td>: <?php echo $data['unitTujuan']!=NULL ? $data['unitTujuan']['nama'] : '' ?></td>
				</tr>
				<tr>
					<th>Dokter Tujuan</th>
					<td>: <?php echo $data['dokterTujuan']!=NULL ? $data['dokterTujuan']['nama_lengkap'] : '' ?></td>
				</tr>
			</tbody>
		</table>
	</div>
	<div class="col-md-7">
		<table width="100%" border='0'>
			<tbody>
				<tr>
					<th valign="top">Jenis Konsultasi</th>
					<td>: <?php echo $data['jenis_konsultasi'] ?></td>
				</tr>
				<tr>
					<th valign="top">Diagnosa</th>
					<td>: <?php echo $data['diagnosa_kerja'] ?></td>
				</tr>
				<tr>
					<th valign="top">Riwayat Singkat</th>
					<td>: <?php echo $data['riwayat_klinik_singkat'] ?></td>
				</tr>
			</tbody>
		</table>
	</div>
</div>
<h5><b><u>Jawaban Konsulan</u></b></h5> 
<table class="table table-bordered" border="0">
	<thead>
		<tr>
			<th rowspan="2" style="text-align:center; width:20%;">Tanggal/Unit/Dokter</th>
			<th colspan="4" style="text-align:center;">Jawaban</th>
		</tr>
		<tr>
			<th style="text-align:center;">S</th>
			<th style="text-align:center;">O</th>
			<th style="text-align:center;">A</th>
			<th style="text-align:center;">P</th>
		</tr>
	</thead>
	<tbody>
		<?php
		if(count($data['jawabanKonsultasi'])>0){
			foreach($data['jawabanKonsultasi'] as $jk){
				?>
				<tr>
					<td style="text-align:center;">
						<?php echo $jk['tanggal_jawab']!=NULL ? date('d-m-Y H:i',strtotime($jk['tanggal_jawab'])) : '' ?>
						<?php echo $jk['layananJawab']!=NULL ? ( $jk['layananJawab']['unit']!=NULL ? '<br><i>'.$jk['layananJawab']['unit']['nama'].'</i>' : '' ) : '' ?>
						<?php echo $jk['dokterJawab']!=NULL ? '<br><b>'.$jk['dokterJawab']['gelar_sarjana_depan'].' '.$jk['dokterJawab']['nama_lengkap'].' '.$jk['dokterJawab']['gelar_sarjana_belakang'].'</b>' : '' ?>
					</td>
					<td><?php echo $jk['jawab_s']; ?></td>
					<td><?php echo $jk['jawab_o']; ?></td>
					<td><?php echo $jk['jawab_a']; ?></td>
					<td><?php echo $jk['jawab_p']; ?></td>
				</tr>
				<?php
			}
		}else{
			?><tr><td colspan="5">Jawaban konsulen tidak ditemukan</td></tr><?php
		}
		?>
	</tbody>
</table>
<pre>
<?php //print_r($data); ?>