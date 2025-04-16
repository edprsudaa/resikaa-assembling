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
?>
<h2>RESUME MEDIS RAWATJALAN</h2>
<table class="table table-sm table-form" style="border: 1px solid;">

  <tr>
    <td style="text-align:left"><b>Id :</b></td>
    <td style="text-align:left"><?= $model->id ?></td>
    <td style="text-align:left"><b>No.Reg :</b></td>
    <td style="text-align:left"><?= $model->layanan->registrasi->kode ?></td>
    <td colspan="2" style="text-align:left"><b>Tgl.Masuk :</b></td>
    <td colspan="2" style="text-align:left"><?= date('d-m-Y', strtotime($model->layanan->registrasi->tgl_masuk)) ?></td>
    <td colspan="2" style="text-align:left"><b>Poliklinik :</b></td>
    <td colspan="2" style="text-align:left"><?= (($model->layanan->unit->nama) ? $model->layanan->unit->nama : '-') ?></td>
  </tr>
  <tr>
    <td colspan="2"><b>Anamnesis :</b></td>
    <td colspan="10"><?= htmlspecialchars(($model->anamesis ? $model->anamesis : '-'), ENT_QUOTES, 'UTF-8') ?></td>
  </tr>
  <tr>
    <td colspan="2"><b>Pemeriksaan fisik :</b></td>
    <td colspan="10"><?= htmlspecialchars(($model->pemeriksaan_fisik ? $model->pemeriksaan_fisik : '-'), ENT_QUOTES, 'UTF-8') ?></td>
  </tr>
  <?php
  $kode_icd10 = null;
  if ($model->diagnosa_utama_id || $model->diagnosa_tambahan1_id || $model->diagnosa_tambahan2_id || $model->diagnosa_tambahan3_id || $model->diagnosa_tambahan4_id || $model->diagnosa_tambahan5_id || $model->diagnosa_tambahan6_id) {
    if ($model->diagnosa_utama_id) {
      $kode_icd10 = $kode_icd10 . 'ICD-10 Utama : ' . $model->diagutama->kode;
    }
    if ($model->diagnosa_tambahan1_id) {
      $kode_icd10 = $kode_icd10 . '<br/>ICD-10 Tambahan 1 : ' . $model->diagsatu->kode;
    }
    if ($model->diagnosa_tambahan2_id) {
      $kode_icd10 = $kode_icd10 . '<br/>ICD-10 Tambahan 2 : ' . $model->diagdua->kode;
    }
    if ($model->diagnosa_tambahan3_id) {
      $kode_icd10 = $kode_icd10 . '<br/>ICD-10 Tambahan 3 : ' . $model->diagtiga->kode;
    }
    if ($model->diagnosa_tambahan4_id) {
      $kode_icd10 = $kode_icd10 . '<br/>ICD-10 Tambahan 4 : ' . $model->diagempat->kode;
    }
    if ($model->diagnosa_tambahan5_id) {
      $kode_icd10 = $kode_icd10 . '<br/>ICD-10 Tambahan 5 : ' . $model->diaglima->kode;
    }
    if ($model->diagnosa_tambahan6_id) {
      $kode_icd10 = $kode_icd10 . '<br/>ICD-10 Tambahan 6 : ' . $model->diagenam->kode;
    }
  }
  ?>
  <tr>
    <td colspan="2"><b>Diagnosa :</b></td>
    <td colspan="6"><?= htmlspecialchars(($model->diagnosa ? $model->diagnosa : '-'), ENT_QUOTES, 'UTF-8') ?></td>
    <td colspan="4"><?= htmlspecialchars(($kode_icd10 ? $kode_icd10 : 'Kode ICD-10 : -'), ENT_QUOTES, 'UTF-8') ?></td>
  </tr>
  <?php
  $kode_icd9 = null;
  if ($model->tindakan_utama_id || $model->tindakan_tambahan1_id || $model->tindakan_tambahan2_id || $model->tindakan_tambahan3_id || $model->tindakan_tambahan4_id || $model->tindakan_tambahan5_id || $model->tindakan_tambahan6_id) {
    if ($model->tindakan_utama_id) {
      $kode_icd9 = $kode_icd9 . 'ICD-9 Utama : ' . $model->tindutama->kode;
    }
    if ($model->tindakan_tambahan1_id) {
      $kode_icd9 = $kode_icd9 . '<br/>ICD-9 Tambahan 1 : ' . $model->tindsatu->kode;
    }
    if ($model->tindakan_tambahan2_id) {
      $kode_icd9 = $kode_icd9 . '<br/>ICD-9 Tambahan 2 : ' . $model->tinddua->kode;
    }
    if ($model->tindakan_tambahan3_id) {
      $kode_icd9 = $kode_icd9 . '<br/>ICD-9 Tambahan 3 : ' . $model->tindtiga->kode;
    }
    if ($model->tindakan_tambahan4_id) {
      $kode_icd9 = $kode_icd9 . '<br/>ICD-9 Tambahan 4 : ' . $model->tindempat->kode;
    }
    if ($model->tindakan_tambahan5_id) {
      $kode_icd9 = $kode_icd9 . '<br/>ICD-9 Tambahan 5 : ' . $model->tindlima->kode;
    }
    if ($model->tindakan_tambahan6_id) {
      $kode_icd9 = $kode_icd9 . '<br/>ICD-9 Tambahan 6 : ' . $model->tindenam->kode;
    }
  }
  ?>
  <tr>
    <td colspan="2"><b>Tindakan :</b></td>
    <td colspan="6"><?= htmlspecialchars(($model->tindakan ? $model->tindakan : '-'), ENT_QUOTES, 'UTF-8') ?></td>
    <td colspan="4"><?= htmlspecialchars(($kode_icd9 ? $kode_icd9 : 'Kode ICD-9 : -'), ENT_QUOTES, 'UTF-8') ?></td>
  </tr>
  <tr>
    <td colspan="2"><b>Terapi :</b></td>
    <td colspan="10"><?= htmlspecialchars(($model->terapi ? $model->terapi : '-'), ENT_QUOTES, 'UTF-8') ?></td>
  </tr>
  <tr>
    <td colspan="2"><b>Laboratorium :</b></td>
    <td colspan="10"><?= htmlspecialchars(($model->lab ? $model->lab : '-'), ENT_QUOTES, 'UTF-8') ?></td>
  </tr>
  <tr>
    <td colspan="2"><b>Radiologi :</b></td>
    <td colspan="10"><?= htmlspecialchars(($model->rad ? $model->rad : '-'), ENT_QUOTES, 'UTF-8') ?></td>
  </tr>
  <tr>
    <td colspan="2"><b>Rencana Tindak Lanjut :</b></td>
    <td colspan="10"><?= htmlspecialchars(($model->rencana ? $model->rencana : '-'), ENT_QUOTES, 'UTF-8') ?></td>
  </tr>
  <tr>
    <td colspan="2"><b>Alasan Kontrol :</b></td>
    <td colspan="10"><?= htmlspecialchars(($model->alasan_kontrol ? $model->alasan_kontrol : '-'), ENT_QUOTES, 'UTF-8') ?></td>
  </tr>
  <tr>
    <td colspan="2"><b>Tanggal Kontrol Poliklinik :</b></td>
    <td colspan="10"><?= $model->tgl_kontrol ? $model->tgl_kontrol : '-' ?></td>
  </tr>
  <tr>
    <td colspan="2"><b>Poliklinik Tujuan Kontrol :</b></td>
    <td colspan="10"><?= $model->poli_tujuan_kontrol_id ? $model->unitTujuan->nama : '-' ?></td>
  </tr>
  <tr>
    <td colspan="2"><b>Alasan belum dikembali ke faskes :</b></td>
    <td colspan="10"><?= htmlspecialchars(($model->alasan ? $model->alasan : '-'), ENT_QUOTES, 'UTF-8') ?></td>
  </tr>
  <tr style="height: 200px; margin: 0; padding: 0;">
    <td colspan="8"></td>
    <td colspan="4" style="text-align: center; border:0">
      Pekanbaru, <?= date('d-m-Y', strtotime($model->created_at)) ?><br />Dokter DPJP
      <br /><br /><br />
      <span style="color:white"><?= isset($markTte->{$model->dokter_id}) ? htmlspecialchars($markTte->{$model->dokter_id}) : '-'; ?></span>
      <br /><br /><br /> <br />
      <b><?= ($model->dokter->gelar_sarjana_depan ? $model->dokter->gelar_sarjana_depan . ' ' : null) . $model->dokter->nama_lengkap . ($model->dokter->gelar_sarjana_belakang ? ', ' . $model->dokter->gelar_sarjana_belakang : null) ?></b><br>
      <u><?= $model->dokter->id_nip_nrp ?? '-' ?></u>
    </td>
  </tr>
</table>