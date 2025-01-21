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
<?= $this->render('doc_kop', ['pasien' => $pasien]); ?>
<h2>RESUME MEDIS RAWAT JALAN</h2>
<table border="1" style="width:100%">

    <tr>
        <td style="text-align:left"><b>Nomor Registrasi :</b></td>
        <td style="text-align:left"><?= $resume->layanan->registrasi->kode ?></td>
        <td style="text-align:left"><b>Tanggal Masuk :</b></td>
        <td style="text-align:left"><?= date('d-m-Y', strtotime($resume->layanan->registrasi->tgl_masuk)) ?></td>
        <td style="text-align:left"><b>Poliklinik :</b></td>
        <td style="text-align:left"><?= (($resume->layanan->unit->nama) ? $resume->layanan->unit->nama : '-') ?></td>
    </tr>
    <tr>
        <td colspan="2"><b>Anamesis :</b></td>
        <td colspan="4"><?= $resume->anamesis ? $resume->anamesis : '-' ?></td>
    </tr>
    <tr>
        <td colspan="2"><b>Pemeriksaan fisik :</b></td>
        <td colspan="4"><?= $resume->pemeriksaan_fisik ? $resume->pemeriksaan_fisik : '-' ?></td>
    </tr>
    <tr>
        <td colspan="2"><b>Diagnosa :</b></td>
        <td colspan="4"><?= $resume->diagnosa ? $resume->diagnosa : '-' ?></td>
    </tr>
    <tr>
        <td colspan="2"><b>Tindakan :</b></td>
        <td colspan="4"><?= $resume->tindakan ? $resume->tindakan : '-' ?></td>
    </tr>

    <tr>
        <td colspan="2"><b>Terapi :</b></td>
        <td colspan="4"><?= $resume->terapi ? $resume->terapi : '-' ?></td>
    </tr>
    <tr>
        <td colspan="2"><b>Laboratorium :</b></td>
        <td colspan="4"><?= $resume->lab ? $resume->lab : '-' ?></td>
    </tr>
    <tr>
        <td colspan="2"><b>Radiologi :</b></td>
        <td colspan="4"><?= $resume->rad ? $resume->rad : '-' ?></td>
    </tr>
    <tr>
        <td colspan="2"><b>Rencana Tindak Lanjut :</b></td>
        <td colspan="4"><?= $resume->rencana ? $resume->rencana : '-' ?></td>
    </tr>
    <tr>
        <td colspan="2"><b>Alasan Kontrol :</b></td>
        <td colspan="4"><?= $resume->alasan_kontrol ? $resume->alasan_kontrol : '-' ?></td>
    </tr>
    <tr>
        <td colspan="2"><b>Tanggal Kontrol Poliklinik :</b></td>
        <td colspan="4"><?= $resume->tgl_kontrol ? $resume->tgl_kontrol : '-' ?></td>
    </tr>
    <tr>
        <td colspan="2"><b>Poliklinik Tujuan Kontrol :</b></td>
        <td colspan="4"><?= $resume->poli_tujuan_kontrol_id ? $resume->unitTujuan->nama : '-' ?></td>
    </tr>
    <tr>
        <td colspan="2"><b>Alasan belum dikembali ke faskes :</b></td>
        <td colspan="4"><?= $resume->alasan ? $resume->alasan : '-' ?></td>
    </tr>
    <tr style="height: 200px; margin: 0; padding: 0;">
        <td colspan="3" style="width:50%"></td>
        <td colspan="3">Pekanbaru, <?= date('d-m-Y', strtotime($resume->created_at)) ?><br />Dokter DPJP<br /><br /><br /><br /><br /><br /><b><?= HelperSpesialClass::getNamaPegawaiArray($resume->dokter) ?? '-' ?></b><br><u><?= $resume->dokter->id_nip_nrp ?? '-' ?></u></td>
    </tr>

    </tr>
</table>