<?php

use yii\helpers\Url;
?>
<style>
  h2 {
    text-align: center !important;
  }

  table {
    margin-left: auto !important;
    margin-right: auto !important;
    margin-bottom: 9px !important;
    width: 90% !important;
    border-collapse: collapse;
  }

  th {
    background-color: #D3D3D3 !important;
    text-align: left !important;
  }

  tr td {
    padding: 5px 5px 5px 5px !important;
    text-align: left !important;

  }

  tr td .no_border {
    border: none;
  }
</style>
<?= $this->render('doc_kop_v2.php', ['pasien' => $model->layanan->registrasi->pasien]);
// echo '<pre>';print_r($resume);die();
?>
<h2>RESUME MEDIS RAWATINAP</h2>
<table class="table table-sm table-form" style="border: 1px solid;">

  <tr>
    <td style="text-align:left"><b>Id :</b></td>
    <td style="text-align:left"><?= $model->id ?></td>
    <td style="text-align:left"><b>No.Reg :</b></td>
    <td style="text-align:left"><?= $model->layanan->registrasi->kode ?></td>
    <td style="text-align:left"><b>Tgl.Masuk :</b></td>
    <td style="text-align:left"><?= date('d-m-Y', strtotime($model->layanan->registrasi->tgl_masuk)) ?></td>
    <td style="text-align:left"><b>Cara Bayar :</b></td>
    <td style="text-align:left"><?= $model->layanan->registrasi->debiturDetail->nama ?></td>
    <td colspan="2" style="text-align:left"><b>Tgl & Ruangan Pulang :</b></td>
    <td colspan="4" style="text-align:left"><?php
                                            $tgl_resume = '..../..../......(TGL.PLG PASIEN BELUM INPUT OLEH DPJP)';
                                            $txt = null;
                                            if ($model->tgl_pulang) {
                                              $txt = $txt . date('d-m-Y', strtotime($model->tgl_pulang));
                                              $tgl_resume = date('d-m-Y', strtotime($model->tgl_pulang));
                                            } else {
                                              //$txt=$txt.(($model->layanan->registrasi->tgl_keluar)?date('d-m-Y',strtotime($model->layanan->registrasi->tgl_keluar)):'-');
                                              $txt = $txt . 'TANGGAL PULANG PASIEN BELUM DI INPUT OLEH DPJP';
                                            }
                                            if ($model->layanan_pulang_id) {
                                              $txt = $txt . ' / ' . $model->layananPulang->unit->nama;
                                            }
                                            echo $txt;
                                            ?></td>
  </tr>
  <tr>
    <td colspan="12"><b>Ringkasan Riwayat Penyakit :</b></td>
  </tr>
  <tr>
    <td colspan="12"><?= $model->ringkasan_riwayat_penyakit ? $model->ringkasan_riwayat_penyakit : '-' ?></td>
  </tr>
  <tr>
    <td colspan="12"><b>Hasil Pemeriksaan Fisik Penting & Temuan Lainya :</b></td>
  </tr>
  <tr>
    <td colspan="12"><?= $model->hasil_pemeriksaan_fisik ? $model->hasil_pemeriksaan_fisik : '-' ?></td>
  </tr>
  <tr>
    <td colspan="12"><b>Hasil Penunjang(Lab,Radiologi Dan Lainnya) :</b></td>
  </tr>
  <tr>
    <td colspan="12"><?= $model->hasil_penunjang ? $model->hasil_penunjang : '-' ?></td>
  </tr>
  <tr>
    <td colspan="12"><b>Terapi/Pengobatan selama dirawat :</b></td>
  </tr>
  <tr>
    <td colspan="12"><?= $model->terapi_perawatan ? $model->terapi_perawatan : '-' ?></td>
  </tr>
  <tr>
    <td colspan="3"><b>Indikasi Rawat Inap : </b></td>
    <td colspan="3"><b>Alasan Pulang :</b></td>
    <td colspan="3"><b>Kondisi Saat Pulang :</b></td>
    <td colspan="3"><b>Cara Pulang :</b></td>
  </tr>
  <tr>
    <td colspan="3"><?= $model->indikasi_rawat_inap ? $model->indikasi_rawat_inap : '-' ?></b></td>
    <td colspan="3"><?= $model->alasan_pulang ? $model->alasan_pulang : '-' ?></b></td>
    <td colspan="3"><?= $model->kondisi_pulang ? $model->kondisi_pulang : '-' ?></b></td>
    <td colspan="3"><?= $model->cara_pulang ? $model->cara_pulang : '-' ?></b></td>
  </tr>
  <tr>
    <th class="bg-lightblue" colspan="12" style="text-align:center">DIAGNOSA</th>
  </tr>
  <tr>
    <td colspan="12"><b>Diagnosa Masuk :</b></td>
  </tr>
  <tr>
    <td colspan="12"><?= (($model->diagnosa_masuk_deskripsi) ? $model->diagnosa_masuk_deskripsi . ' ( Kode ICD10:' . (($model->diagnosa_masuk_id) ? $model->diagmasuk->kode : '........') . ')' : (($model->diagnosa_masuk_id) ? $model->diagmasuk->nama . ' ( Kode ICD10:' . $model->diagmasuk->kode . ' )' : '........')) ?></td>
  </tr>
  <tr>
    <td colspan="4" class="text-left"><b>Jenis</b></td>
    <td colspan="6" class="text-left"><b>Nama Diagnosa :</b></td>
    <td colspan="2" class="text-left"><b>Kode ICD10</b></td>
  </tr>
  <tr>
    <td colspan="4" class="text-left">Utama</td>
    <td colspan="6" class="text-left"><?= $model->diagnosa_utama_deskripsi ? $model->diagnosa_utama_deskripsi : '-' ?></td>
    <td colspan="2" class="text-left"><?= $model->diagnosa_utama_id ? $model->diagutama->kode : '' ?></td>
  </tr>
  <?php
  if ($model->diagnosa_tambahan1_deskripsi || $model->diagnosa_tambahan1_id) {
  ?>
    <tr>
      <td colspan="4" class="text-left">Tambahan 1</td>
      <td colspan="6" class="text-left"><?= $model->diagnosa_tambahan1_deskripsi ? $model->diagnosa_tambahan1_deskripsi : '-' ?></td>
      <td colspan="2" class="text-left"><?= $model->diagnosa_tambahan1_id ? $model->diagsatu->kode : '' ?></td>
    </tr>
  <?php
  }
  ?>
  <?php
  if ($model->diagnosa_tambahan2_deskripsi || $model->diagnosa_tambahan2_id) {
  ?>
    <tr>
      <td colspan="4" class="text-left">Tambahan 2</td>
      <td colspan="6" class="text-left"><?= $model->diagnosa_tambahan2_deskripsi ? $model->diagnosa_tambahan2_deskripsi : '-' ?></td>
      <td colspan="2" class="text-left"><?= $model->diagnosa_tambahan2_id ? $model->diagdua->kode : '' ?></td>
    </tr>
  <?php
  }
  ?>
  <?php
  if ($model->diagnosa_tambahan3_deskripsi || $model->diagnosa_tambahan3_id) {
  ?>
    <tr>
      <td colspan="4" class="text-left">Tambahan 3</td>
      <td colspan="6" class="text-left"><?= $model->diagnosa_tambahan3_deskripsi ? $model->diagnosa_tambahan3_deskripsi : '-' ?></td>
      <td colspan="2" class="text-left"><?= $model->diagnosa_tambahan3_id ? $model->diagtiga->kode : '' ?></td>
    </tr>
  <?php
  }
  ?>
  <?php
  if ($model->diagnosa_tambahan4_deskripsi || $model->diagnosa_tambahan4_id) {
  ?>
    <tr>
      <td colspan="4" class="text-left">Tambahan 4</td>
      <td colspan="6" class="text-left"><?= $model->diagnosa_tambahan4_deskripsi ? $model->diagnosa_tambahan4_deskripsi : '-' ?></td>
      <td colspan="2" class="text-left"><?= $model->diagnosa_tambahan4_id ? $model->diagempat->kode : '' ?></td>
    </tr>
  <?php
  }
  ?>
  <?php
  if ($model->diagnosa_tambahan5_deskripsi || $model->diagnosa_tambahan5_id) {
  ?>
    <tr>
      <td colspan="4" class="text-left">Tambahan 5</td>
      <td colspan="6" class="text-left"><?= $model->diagnosa_tambahan5_deskripsi ? $model->diagnosa_tambahan5_deskripsi : '-' ?></td>
      <td colspan="2" class="text-left"><?= $model->diagnosa_tambahan5_id ? $model->diaglima->kode : '' ?></td>
    </tr>
  <?php
  }
  ?>
  <?php
  if ($model->diagnosa_tambahan6_deskripsi || $model->diagnosa_tambahan6_id) {
  ?>
    <tr>
      <td colspan="4" class="text-left">Tambahan 6</td>
      <td colspan="6" class="text-left"><?= $model->diagnosa_tambahan6_deskripsi ? $model->diagnosa_tambahan6_deskripsi : '-' ?></td>
      <td colspan="2" class="text-left"><?= $model->diagnosa_tambahan6_id ? $model->diagenam->kode : '' ?></td>
    </tr>
  <?php
  }
  ?>
  <tr>
    <th class="bg-lightblue" colspan="12" style="text-align:center">TINDAKAN</th>
  </tr>
  <tr>
    <td colspan="4" class="text-left"><b>Jenis</b></td>
    <td colspan="6" class="text-left"><b>Nama Tindakan :</b></td>
    <td colspan="2" class="text-left"><b>Kode ICD9</b></td>
  </tr>
  <tr>
    <td colspan="4" class="text-left">Utama</td>
    <td colspan="6" class="text-left"><?= $model->tindakan_utama_deskripsi ? $model->tindakan_utama_deskripsi : '-' ?></td>
    <td colspan="2" class="text-left"><?= $model->tindakan_utama_id ? $model->tindutama->kode : '' ?></td>
  </tr>
  <?php
  if ($model->tindakan_tambahan1_deskripsi || $model->tindakan_tambahan1_id) {
  ?>
    <tr>
      <td colspan="4" class="text-left">Tambahan 1</td>
      <td colspan="6" class="text-left"><?= $model->tindakan_tambahan1_deskripsi ? $model->tindakan_tambahan1_deskripsi : '-' ?></td>
      <td colspan="2" class="text-left"><?= $model->tindakan_tambahan1_id ? $model->tindsatu->kode : '' ?></td>
    </tr>
  <?php
  }
  ?>
  <?php
  if ($model->tindakan_tambahan2_deskripsi || $model->tindakan_tambahan2_id) {
  ?>
    <tr>
      <td colspan="4" class="text-left">Tambahan 2</td>
      <td colspan="6" class="text-left"><?= $model->tindakan_tambahan2_deskripsi ? $model->tindakan_tambahan2_deskripsi : '-' ?></td>
      <td colspan="2" class="text-left"><?= $model->tindakan_tambahan2_id ? $model->tinddua->kode : '' ?></td>
    </tr>
  <?php
  }
  ?>
  <?php
  if ($model->tindakan_tambahan3_deskripsi || $model->tindakan_tambahan3_id) {
  ?>
    <tr>
      <td colspan="4" class="text-left">Tambahan 3</td>
      <td colspan="6" class="text-left"><?= $model->tindakan_tambahan3_deskripsi ? $model->tindakan_tambahan3_deskripsi : '-' ?></td>
      <td colspan="2" class="text-left"><?= $model->tindakan_tambahan3_id ? $model->tindtiga->kode : '' ?></td>
    </tr>
  <?php
  }
  ?>
  <?php
  if ($model->tindakan_tambahan4_deskripsi || $model->tindakan_tambahan4_id) {
  ?>
    <tr>
      <td colspan="4" class="text-left">Tambahan 4</td>
      <td colspan="6" class="text-left"><?= $model->tindakan_tambahan4_deskripsi ? $model->tindakan_tambahan4_deskripsi : '-' ?></td>
      <td colspan="2" class="text-left"><?= $model->tindakan_tambahan4_id ? $model->tindempat->kode : '' ?></td>
    </tr>
  <?php
  }
  ?>
  <?php
  if ($model->tindakan_tambahan5_deskripsi || $model->tindakan_tambahan5_id) {
  ?>
    <tr>
      <td colspan="4" class="text-left">Tambahan 5</td>
      <td colspan="6" class="text-left"><?= $model->tindakan_tambahan5_deskripsi ? $model->tindakan_tambahan5_deskripsi : '-' ?></td>
      <td colspan="2" class="text-left"><?= $model->tindakan_tambahan5_id ? $model->tindlima->kode : '' ?></td>
    </tr>
  <?php
  }
  ?>
  <?php
  if ($model->tindakan_tambahan6_deskripsi || $model->tindakan_tambahan6_id) {
  ?>
    <tr>
      <td colspan="4" class="text-left">Tambahan 6</td>
      <td colspan="6" class="text-left"><?= $model->tindakan_tambahan6_deskripsi ? $model->tindakan_tambahan6_deskripsi : '-' ?></td>
      <td colspan="2" class="text-left"><?= $model->tindakan_tambahan6_id ? $model->tindenam->kode : '' ?></td>
    </tr>
  <?php
  }
  ?>
  <tr>
    <th class="bg-lightblue" colspan="12" style="text-align:center">PEMERIKSAAN FISIK</th>
  </tr>
  <tr>
    <td><b>GCS E :</b> <?= $model->gcs_e ? $model->gcs_e : '-' ?></td>
    <td><b>GCS M :</b> <?= $model->gcs_m ? $model->gcs_m : '-' ?></td>
    <td colspan="2"><b>GCS V :</b> <?= $model->gcs_v ? $model->gcs_v : '-' ?></td>
    <td><b>Nadi(x/menit) :</b> <?= $model->nadi ? $model->nadi : '-' ?></td>
    <td><b>TD(mmHg) :</b> <?= $model->darah ? $model->darah : '-' ?></td>
    <td><b>Suhu(C) :</b> <?= $model->suhu ? $model->suhu : '-' ?></td>
    <td><b>SatO2(%) :</b> <?= $model->sato2 ? $model->sato2 : '-' ?></td>
    <td colspan="2"><b>Pernapasan(x/menit) :</b> <?= $model->pernapasan ? $model->pernapasan : '-' ?></td>
  </tr>
  <tr>
    <td><b>BB (Kg) :</b> <?= $model->berat_badan ? $model->berat_badan : '-' ?></td>
    <td><b>TB (Cm) :</b> <?= $model->tinggi_badan ? $model->tinggi_badan : '-' ?></td>
    <td colspan="4"><b>Keadaan Gizi :</b> <?= $model->keadaan_gizi ? $model->keadaan_gizi : '-' ?></td>
    <td colspan="3"><b>Keadaan Umum :</b> <?= $model->keadaan_umum ? $model->keadaan_umum : '-' ?></td>
    <td colspan="3"><b>Tingkat Kesadaran :</b> <?= $model->tingkat_kesadaran ? $model->tingkat_kesadaran : '-' ?></td>
  </tr>
  <tr>
    <td colspan="2"><b>Alergi :</b></td>
    <td colspan="10"><?= $model->alergi ? $model->alergi : '-' ?></td>
  </tr>
  <tr>
    <td colspan="2"><b>Diet :</b></td>
    <td colspan="10"><?= $model->diet ? $model->diet : '-' ?></td>
  </tr>
  <tr>
    <td colspan="2"><b>Obat Rumah :</b></td>
    <td colspan="10"><?= $model->obat_rumah ? $model->obat_rumah : '-' ?></td>
  </tr>
  <tr>
    <td colspan="2"><b>Terapi Pulang :</b></td>
    <td colspan="10"><?= $model->terapi_pulang ? $model->terapi_pulang : '-' ?></td>
  </tr>
  <tr>
    <td colspan="2"><b>Tanggal Kontrol Poliklinik :</b></td>
    <td colspan="10"><?= $model->tgl_kontrol ? $model->tgl_kontrol : '-' ?></td>
  </tr>
  <tr>
    <td colspan="2"><b>Poliklinik Tujuan Kontrol :</b></td>
    <td colspan="10"><?= $model->poli_tujuan_kontrol_id ? $model->unitTujuan->nama : '-' ?></td>
  </tr>
  <tr style="height: 200px; margin: 0; padding: 0;">
    <td colspan="8"></td>
    <td colspan="4" style="text-align: center; border:0">
      Pekanbaru, <?= $tgl_resume ?><br />Dokter DPJP
      <br /><br /><br />
      <span style="color:white"><?= isset($markTte->{$model->dokter_id}) ? htmlspecialchars($markTte->{$model->dokter_id}) : '-'; ?></span>
      <br /><br /><br /> <br />
      <b><?= ($model->dokter->gelar_sarjana_depan ? $model->dokter->gelar_sarjana_depan . ' ' : null) . $model->dokter->nama_lengkap . ($model->dokter->gelar_sarjana_belakang ? ', ' . $model->dokter->gelar_sarjana_belakang : null) ?></b><br>
      <u><?= $model->dokter->id_nip_nrp ?? '-' ?></u>
    </td>
  </tr>
  <tr style="height: 50px; margin: 0; padding: 0;">
    <td colspan="4"></td>
    <td colspan="4">
      <center><b>SERAH TERIMA PASIEN</b></center>
    </td>
    <td colspan="4"></td>
  </tr>
  <tr style="height: 200px; margin: 0; padding: 0;">
    <td colspan="2"></td>
    <td colspan="4"><b>Keluarga yang menerima,<br /><br /><br /><br /><br /><br /><b><b>(........................................)</b></td>
    <td colspan="2"></td>
    <td colspan="4"><b>Perawat yang menyerahkan,<br /><br /><br /><br /><br /><br /><b><b>(........................................)</b></td>
  </tr>
</table>