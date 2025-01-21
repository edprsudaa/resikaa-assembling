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

<h2>TRIASE IGD</h2>
<label style="text-align: right !important;"><i>Tanggal Cetak Dokumen : <?= date('d-m-Y H:i:s') ?></i></label>
<table class="table table-sm table-form" style="border: 1px solid;">
    <tr>
        <td colspan="2"><b>Tanggal:</b></td>
        <td colspan="10"><?= $triaseIgd->tanggal_triase ? date('d-m-Y H:i:s', strtotime($triaseIgd->tanggal_triase)) : '-' ?></td>
    </tr>
    <tr>
        <td colspan="2"><b>Cara Datang :</b></td>
        <td colspan="10"><?= $triaseIgd->cara_datang ? $triaseIgd->cara_datang : '-' ?></td>
    </tr>
    <tr>
        <td colspan="2"><b>Asal Rujukan :</b></td>
        <td colspan="10"><?= $triaseIgd->asal_rujukan ? $triaseIgd->asal_rujukan : '-' ?></td>
    </tr>
    <tr>
        <td colspan="2"><b>Pukul Serah Terima Ke Dokter :</b></td>
        <td colspan="10"><?= $triaseIgd->jam_serah_terima_dokter ? $triaseIgd->jam_serah_terima_dokter : '-' ?></td>
    </tr>
    <tr>
        <td colspan="2"><b>Dokter Jaga :</b></td>
        <td colspan="10"><?= HelperSpesialClass::getNamaPegawaiArray($triaseIgd->dokter) ?? '' ?></td>
    </tr>
    <tr>
        <td colspan="2"><b>Perawat :</b></td>
        <td colspan="10"><?= HelperSpesialClass::getNamaPegawaiArray($triaseIgd->perawat) ?? '' ?></td>
    </tr>
    <tr>
        <td colspan="12"><b>DEATH ON ARRIVAL (DOA)</b></td>
    </tr>
    <tr>
        <td colspan="2"><b>Tanda Kehidupan :</b></td>
        <td colspan="10"><?= $triaseIgd->doa_tanda_kehidupan ? $triaseIgd->doa_tanda_kehidupan : '-' ?></td>
    </tr>
    <tr>
        <td colspan="2"><b>Denyut Nadi :</b></td>
        <td colspan="10"><?= $triaseIgd->doa_denyut_nadi ? $triaseIgd->doa_denyut_nadi : '-' ?></td>
    </tr>

    <tr>
        <td colspan="2"><b>Reflex Cahaya :</b></td>
        <td colspan="10"><?= $triaseIgd->doa_reflex_cahaya ? $triaseIgd->doa_reflex_cahaya : '-' ?></td>
    </tr>

    <tr>
        <td colspan="2"><b>EKG FLAT :</b></td>
        <td colspan="10"><?= $triaseIgd->doa_ekg_flat ? $triaseIgd->doa_ekg_flat : '-' ?></td>
    </tr>
    <tr>
        <td colspan="2"><b>Pukul :</b></td>
        <td colspan="10"><?= $triaseIgd->doa_jam ? $triaseIgd->doa_jam : '-' ?></td>
    </tr>
    <tr>
        <td colspan="2"><b>Pemeriksaan :</b></td>
        <td colspan="10"><?= $triaseIgd->skala_triase ? $triaseIgd->skala_triase : '-' ?></td>
    </tr>
    <tr>
        <td colspan="2"><b>Jalan Nafas :</b></td>
        <td colspan="10">
            <?php
            $jalanNafas = json_decode($triaseIgd->jalan_nafas, true);
            echo is_array($jalanNafas) ? implode(', ', $jalanNafas) : ($triaseIgd->jalan_nafas ?: '-');
            ?>
        </td>
    </tr>
    <tr>
        <td colspan="2"><b>Pernapasan :</b></td>
        <td colspan="10">
            <?php
            $penapasan = json_decode($triaseIgd->pernapasan, true);
            echo is_array($penapasan) ? implode(', ', $penapasan) : ($triaseIgd->pernapasan ?: '-');
            ?>
        </td>
    </tr>
    <tr>
        <td colspan="2"><b>Sirkulasi :</b></td>
        <td colspan="10">
            <?php
            $sirkulasi = json_decode($triaseIgd->sirkulasi, true);
            echo is_array($sirkulasi) ? implode(', ', $sirkulasi) : ($triaseIgd->sirkulasi ?: '-');
            ?>
        </td>
    </tr>
    <tr>
        <td colspan="2"><b>Kesadaran :</b></td>
        <td colspan="10">
            <?php
            $kesadaran = json_decode($triaseIgd->kesadaran, true);
            echo is_array($kesadaran) ? implode(', ', $kesadaran) : ($triaseIgd->kesadaran ?: '-');
            ?>
        </td>
    </tr>
    <tr>
        <td colspan="2"><b>Diteruskan Ke :</b></td>
        <td colspan="10"><?= $triaseIgd->diteruskan_ke ? $triaseIgd->diteruskan_ke : '-' ?></td>
    </tr>


    <tr style="height: 200px; margin: 0; padding: 0;">
        <td colspan="6"><br />Perawat<br />Pelayanan Kegawatdaruratan<br /><br /><br /><br /><br /><b><?= HelperSpesialClass::getNamaPegawaiArray($triaseIgd->perawat) ?? '' ?></b><br><u><?= $triaseIgd->dokter->id_nip_nrp ?? '-' ?></u></td>
        <td colspan="6">Pekanbaru, <?= date('d-m-Y', strtotime($triaseIgd->created_at)) ?><br />Dokter<br />Pelayanan Kegawatdaruratan<br /><br /><br /><br /><br /><b><?= HelperSpesialClass::getNamaPegawaiArray($triaseIgd->dokter) ?? '' ?></b><br><u><?= $triaseIgd->dokter->id_nip_nrp ?? '-' ?></u></td>
    </tr>
</table>