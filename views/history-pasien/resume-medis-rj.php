<?php

use app\components\HelperGeneralClass;
use app\components\HelperSpesialClass;
//print_r($pasien); exit;
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
<?php
if ($is_ajax == true) {
    echo $this->render('doc_kop', ['pasien' => $pasien]);
} else {
    echo $this->render('doc_kop_v2', ['pasien' => $pasien]);
} ?>

<h2>RESUME MEDIS RAWATJALAN</h2>
<table class="table table-sm table-form" style="border: 1px solid;">

    <tr>
        <td colspan="2" style="text-align:left"><b>Id :</b></td>
        <td colspan="4" style="text-align:left"><?= $resume->id ?></td>
        <td colspan="2" style="text-align:left"><b>Nomor Registrasi :</b></td>
        <td colspan="4" style="text-align:left"><?= $resume->layanan->registrasi->kode ?></td>
    </tr>
    <tr>
        <td colspan="2" style="text-align:left"><b>Tanggal Masuk :</b></td>
        <td colspan="4" style="text-align:left"><?= date('d-m-Y', strtotime($resume->layanan->registrasi->tgl_masuk)) ?></td>

        <td colspan="2" style="text-align:left"><b>Poliklinik :</b></td>
        <td colspan="4" style="text-align:left"><?= (($resume->layanan->unit->nama) ? $resume->layanan->unit->nama : '-') ?></td>

    </tr>
    <tr>
        <td colspan="2" style="vertical-align:top ;"><b>Anamesis :</b></td>
        <td colspan="10"><?= $resume->anamesis ? $resume->anamesis : '-' ?></td>
    </tr>
    <tr>
        <td colspan="2" style="vertical-align:top ;"><b>Pemeriksaan fisik :</b></td>
        <td colspan="10"><?= $resume->pemeriksaan_fisik ? $resume->pemeriksaan_fisik : '-' ?></td>
    </tr>

    <tr>
        <td colspan="2" style="vertical-align:top ;"><b>Kasus :</b></td>
        <td colspan="10"><?= isset($resume->kasus) ? ($resume->kasus === 1 ? 'lama' : ($resume->kasus === 0 ? 'baru' : '-')) : '-' ?></td>
    </tr>
    <tr>
        <td colspan="2" style="vertical-align:top ;"><b>Diagnosa :</b></td>
        <td colspan="6" style="vertical-align:top ;"><?= $resume->diagnosa ? $resume->diagnosa : '-' ?></td>
        <?php
        $kode_icd10 = null;
        if ($resume->diagnosa_utama_id || $resume->diagnosa_tambahan1_id || $resume->diagnosa_tambahan2_id || $resume->diagnosa_tambahan3_id || $resume->diagnosa_tambahan4_id || $resume->diagnosa_tambahan5_id || $resume->diagnosa_tambahan6_id) {
            if ($resume->diagnosa_utama_id) {
                $kode_icd10 = $kode_icd10 . 'ICD-10 Utama : ' . $resume->diagutama->kode;
            }
            if ($resume->diagnosa_tambahan1_id) {
                $kode_icd10 = $kode_icd10 . '<br/>ICD-10 Tambahan 1 : ' . $resume->diagsatu->kode;
            }
            if ($resume->diagnosa_tambahan2_id) {
                $kode_icd10 = $kode_icd10 . '<br/>ICD-10 Tambahan 2 : ' . $resume->diagdua->kode;
            }
            if ($resume->diagnosa_tambahan3_id) {
                $kode_icd10 = $kode_icd10 . '<br/>ICD-10 Tambahan 3 : ' . $resume->diagtiga->kode;
            }
            if ($resume->diagnosa_tambahan4_id) {
                $kode_icd10 = $kode_icd10 . '<br/>ICD-10 Tambahan 4 : ' . $resume->diagempat->kode;
            }
            if ($resume->diagnosa_tambahan5_id) {
                $kode_icd10 = $kode_icd10 . '<br/>ICD-10 Tambahan 5 : ' . $resume->diaglima->kode;
            }
            if ($resume->diagnosa_tambahan6_id) {
                $kode_icd10 = $kode_icd10 . '<br/>ICD-10 Tambahan 6 : ' . $resume->diagenam->kode;
            }
        }
        ?>

        <td colspan="4" style="vertical-align:top ;"><?= $kode_icd10 ? $kode_icd10 : 'Kode ICD-10 : -' ?></td>
    </tr>
    <tr>
        <td colspan="2" style="vertical-align:top ;"><b>Tindakan :</b></td>
        <td colspan="6" style="vertical-align:top ;"><?= $resume->tindakan ? $resume->tindakan : '-' ?></td>
        <?php
        $kode_icd9 = null;
        if ($resume->tindakan_utama_id || $resume->tindakan_tambahan1_id || $resume->tindakan_tambahan2_id || $resume->tindakan_tambahan3_id || $resume->tindakan_tambahan4_id || $resume->tindakan_tambahan5_id || $resume->tindakan_tambahan6_id) {
            if ($resume->tindakan_utama_id) {
                $kode_icd9 = $kode_icd9 . 'ICD-9 Utama : ' . $resume->tindutama->kode;
            }
            if ($resume->tindakan_tambahan1_id) {
                $kode_icd9 = $kode_icd9 . '<br/>ICD-9 Tambahan 1 : ' . $resume->tindsatu->kode;
            }
            if ($resume->tindakan_tambahan2_id) {
                $kode_icd9 = $kode_icd9 . '<br/>ICD-9 Tambahan 2 : ' . $resume->tinddua->kode;
            }
            if ($resume->tindakan_tambahan3_id) {
                $kode_icd9 = $kode_icd9 . '<br/>ICD-9 Tambahan 3 : ' . $resume->tindtiga->kode;
            }
            if ($resume->tindakan_tambahan4_id) {
                $kode_icd9 = $kode_icd9 . '<br/>ICD-9 Tambahan 4 : ' . $resume->tindempat->kode;
            }
            if ($resume->tindakan_tambahan5_id) {
                $kode_icd9 = $kode_icd9 . '<br/>ICD-9 Tambahan 5 : ' . $resume->tindlima->kode;
            }
            if ($resume->tindakan_tambahan6_id) {
                $kode_icd9 = $kode_icd9 . '<br/>ICD-9 Tambahan 6 : ' . $resume->tindenam->kode;
            }
        }
        ?>
        <td colspan="4" style="vertical-align:top ;"><?= $kode_icd9 ? $kode_icd9 : 'Kode ICD-9 : -' ?></td>
    </tr>
    <tr>
        <td colspan="2" style="vertical-align:top ;"><b>Terapi :</b></td>
        <td colspan="10"><?= $resume->terapi ? $resume->terapi : '-' ?></td>
    </tr>
    <tr>
        <td colspan="2" style="vertical-align:top ;"><b>Laboratorium :</b></td>
        <td colspan="10"><?= $resume->lab ? $resume->lab : '-' ?></td>
    </tr>
    <tr>
        <td colspan="2" style="vertical-align:top ;"><b>Radiologi :</b></td>
        <td colspan="10"><?= $resume->rad ? $resume->rad : '-' ?></td>
    </tr>
    <tr>
        <td colspan="2" style="vertical-align:top ;"><b>Rencana Tindak Lanjut :</b></td>
        <td colspan="10"><?= $resume->rencana ? $resume->rencana : '-' ?></td>
    </tr>
    <tr>
        <td colspan="2" style="vertical-align:top ;"><b>Alasan Kontrol :</b></td>
        <td colspan="10"><?= $resume->alasan_kontrol ? $resume->alasan_kontrol : '-' ?></td>
    </tr>
    <tr>
        <td colspan="2"><b>Tanggal Kontrol Poliklinik :</b></td>
        <td colspan="10"><?= $resume->tgl_kontrol ? $resume->tgl_kontrol : '-' ?></td>
    </tr>
    <tr>
        <td colspan="2"><b>Poliklinik Tujuan Kontrol :</b></td>
        <td colspan="10"><?= $resume->poli_tujuan_kontrol_id ? $resume->unitTujuan->nama : '-' ?></td>
    </tr>
    <tr>
        <td colspan="2" style="vertical-align:top ;"><b>Alasan belum dikembali ke faskes :</b></td>
        <td colspan="10"><?= $resume->alasan ? $resume->alasan : '-' ?></td>
    </tr>

    <tr>
        <td colspan="2" style="vertical-align:top ;"><b>Keterangan lainnya : :</b></td>
        <td colspan="10"><?= $resume->keterangan ? $resume->keterangan : '-' ?></td>
    </tr>
    <tr style="height: 200px; margin: 0; padding: 0;">
        <td colspan="8"></td>
        <td colspan="4">Pekanbaru,<?= date('d-m-Y', strtotime($resume->created_at)) ?><br />Dokter DPJP<br /><br /><br /><br /><br /><br /><b><?= $resume->dokter->nama_lengkap ?? '-' ?></b><br><u><?= $resume->dokter->id_nip_nrp ?? '-' ?></u></td>
    </tr>
</table>