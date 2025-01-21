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

<h2>RINGKASAN PULANG IGD</h2>
<label style="text-align: right !important;"><i>Tanggal Cetak Dokumen : <?= date('d-m-Y H:i:s') ?></i></label>
<table class="table table-sm table-form" style="border: 1px solid;">
    <tr>
        <td colspan="2"><b>Tanggal Datang IGD:</b></td>
        <td colspan="10"><?= $ringkasanPulangIgd->tgl_datang ? date('d-m-Y H:i:s', strtotime($ringkasanPulangIgd->tgl_datang)) : '-' ?></td>
    </tr>
    <tr>
        <td colspan="2"><b>Tanggal Keluar IGD:</b></td>
        <td colspan="10"><?= $ringkasanPulangIgd->tgl_keluar ? date('d-m-Y H:i:s', strtotime($ringkasanPulangIgd->tgl_keluar)) : '-' ?></td>
    </tr>
    <tr>
        <td colspan="2"><b>Indikasi Masuk IGD :</b></td>
        <td colspan="10"><?= $ringkasanPulangIgd->indikasi_masuk ? $ringkasanPulangIgd->indikasi_masuk : '-' ?></td>
    </tr>
    <tr>
        <td colspan="2"><b>Keluhan Utama :</b></td>
        <td colspan="10"><?= $ringkasanPulangIgd->keluhan_utama ? $ringkasanPulangIgd->keluhan_utama : '-' ?></td>
    </tr>
    <tr>
        <td colspan="2"><b>Pemeriksaan Fisik :</b></td>
        <td colspan="10"><?= $ringkasanPulangIgd->pemeriksaan_fisik ? $ringkasanPulangIgd->pemeriksaan_fisik : '-' ?></td>
    </tr>
    <tr>
        <td colspan="2"><b>Pemeriksaan Penunjang :</b></td>
        <td colspan="10"><?= $ringkasanPulangIgd->pemeriksaan_penunjang ? $ringkasanPulangIgd->pemeriksaan_penunjang : '-' ?></td>
    </tr>
    <tr>
        <td colspan="2"><b>Diagnosa Kerja :</b></td>
        <td colspan="10"><?= $ringkasanPulangIgd->diagnosa_kerja ? $ringkasanPulangIgd->diagnosa_kerja : '-' ?></td>
    </tr>
    <tr>
        <td colspan="2"><b>Diagnosa Banding :</b></td>
        <td colspan="10"><?= $ringkasanPulangIgd->diagnosa_banding ? $ringkasanPulangIgd->diagnosa_banding : '-' ?></td>
    </tr>
    <tr>
        <td colspan="2"><b>Tindakan/Prosedur :</b></td>
        <td colspan="10"><?= $ringkasanPulangIgd->tindakan ? $ringkasanPulangIgd->tindakan : '-' ?></td>
    </tr>
    <?php
    $tindak_lanjut = null;
    if ($ringkasanPulangIgd->tindak_lanjut_paps !== 'Tidak') {
        $tindak_lanjut = 'Pulang Atas Permintaan Sendiri / Menolak Rawat Inap Karena ' . $ringkasanPulangIgd->tindak_lanjut_paps;
    }
    if ($ringkasanPulangIgd->tindak_lanjut_pap !== 'Tidak') {
        if (empty($ringkasanPulangIgd->tindak_lanjut_pap)) {
            $tindak_lanjut = 'Pulang Atas Persetujuan, Pada Jam ' . $ringkasanPulangIgd->tindak_lanjut_pap;
        } else {
            $tindak_lanjut = $tindak_lanjut . '; Pulang Atas Persetujuan, Pada Jam ' . $ringkasanPulangIgd->tindak_lanjut_pap;
        }
    }
    if ($ringkasanPulangIgd->tindak_lanjut_kontrol !== 'Tidak') {
        if (empty($ringkasanPulangIgd->tindak_lanjut_kontrol)) {
            $tindak_lanjut = 'Kontrol Tanggal ' . $ringkasanPulangIgd->tindak_lanjut_kontrol;
        } else {
            $tindak_lanjut = $tindak_lanjut . '; Kontrol Tanggal ' . $ringkasanPulangIgd->tindak_lanjut_kontrol;
        }
    }
    if ($ringkasanPulangIgd->tindak_lanjut_dirujuk !== 'Tidak') {
        if (empty($ringkasanPulangIgd->tindak_lanjut_dirujuk)) {
            $tindak_lanjut = ' Dirujuk Ke ' . $ringkasanPulangIgd->tindak_lanjut_dirujuk;
        } else {
            $tindak_lanjut = $tindak_lanjut . '; Dirujuk Ke ' . $ringkasanPulangIgd->tindak_lanjut_dirujuk;
        }
    }
    if ($ringkasanPulangIgd->tindak_lanjut_meninggal_wib !== 'Tidak') {
        if (empty($ringkasanPulangIgd->tindak_lanjut_meninggal_wib)) {
            $tindak_lanjut = 'Meninggal Pukul ' . $ringkasanPulangIgd->tindak_lanjut_meninggal_wib;
        } else {
            $tindak_lanjut = $tindak_lanjut . '; Meninggal Pukul ' . $ringkasanPulangIgd->tindak_lanjut_meninggal_wib;
        }
    }
    ?>
    <tr>
        <td colspan="2"><b>Tindak Lanjut :</b></td>
        <td colspan="10"><?= $tindak_lanjut ? $tindak_lanjut : '-' ?></td>
    </tr>
    <tr>
        <td colspan="2"><b>Alasan tidak Perlu Dirawat :</b></td>
        <td colspan="10">Keadaaan Umum : <?= $ringkasanPulangIgd->alasan_tidak_dirawat_ku ? $ringkasanPulangIgd->alasan_tidak_dirawat_ku : '-' ?></td>
    </tr>
    <tr>
        <td colspan="2"></td>
        <td colspan="10">Tanda-tanda Kegawatan : <?= $ringkasanPulangIgd->alasan_tidak_dirawat_tk ? $ringkasanPulangIgd->alasan_tidak_dirawat_tk : '-' ?></td>
    </tr>
    <tr>
        <td colspan="2"></td>
        <td colspan="10">Hal Lain : <?= $ringkasanPulangIgd->alasan_tidak_dirawat_lainya ? $ringkasanPulangIgd->alasan_tidak_dirawat_lainya : '-' ?></td>
    </tr>
    <tr>
        <td colspan="2"><b>Terapi dan Tindakan Yang Telah Diberikan :</b></td>
        <td colspan="10"><?= $ringkasanPulangIgd->terapi_tindakan_diberikan ? $ringkasanPulangIgd->terapi_tindakan_diberikan : '-' ?></td>
    </tr>
    <tr>
        <td colspan="2"><b>Kondisi Saat Keluar :</b></td>
        <td colspan="10">Keadaaan Umum : <?= $ringkasanPulangIgd->kondisi_keluar_ku ? $ringkasanPulangIgd->kondisi_keluar_ku : '-' ?></td>
    </tr>
    <tr>
        <td colspan="2"></td>
        <td colspan="10">Kesadaran : <?= $ringkasanPulangIgd->kondisi_keluar_kesadaran ? $ringkasanPulangIgd->kondisi_keluar_kesadaran : '-' ?></td>
    </tr>
    <tr>
        <td colspan="2"></td>
        <td colspan="2">Vital Sign</td>
        <td colspan="2">TD(mmHG):<?= $ringkasanPulangIgd->kondisi_keluar_vs_td_mmhg ? $ringkasanPulangIgd->kondisi_keluar_vs_td_mmhg : '-' ?></td>
        <td colspan="2">Nadi(x/menit):<?= $ringkasanPulangIgd->kondisi_keluar_vs_nadi_xm ? $ringkasanPulangIgd->kondisi_keluar_vs_nadi_xm : '-' ?></td>
        <td colspan="2">RR(mmHG):<?= $ringkasanPulangIgd->kondisi_keluar_vs_rr_xm ? $ringkasanPulangIgd->kondisi_keluar_vs_rr_xm : '-' ?></td>
        <td colspan="2">Suhu(c):<?= $ringkasanPulangIgd->kondisi_keluar_vs_suhu_c ? $ringkasanPulangIgd->kondisi_keluar_vs_suhu_c : '-' ?></td>
    </tr>
    <tr>
        <td colspan="2"></td>
        <td colspan="2"></td>
        <td colspan="2">Nyeri:<?= $ringkasanPulangIgd->kondisi_keluar_vs_nyeri ? $ringkasanPulangIgd->kondisi_keluar_vs_nyeri : '-' ?></td>
    </tr>
    <tr>
        <td colspan="2"></td>
        <td colspan="10">Terapi Saat Pulang : <?= $ringkasanPulangIgd->kondisi_keluar_terapi_pulang ? $ringkasanPulangIgd->kondisi_keluar_terapi_pulang : '-' ?></td>
    </tr>
    <tr>
        <td colspan="2"><b>Edukasi :</b></td>
        <td colspan="10">Edukasi Tentang Kondisi Pasien dan Rencana Asuhan Kepada : <?= $ringkasanPulangIgd->edukasi_kepada ? $ringkasanPulangIgd->edukasi_kepada : '-' ?></td>
    </tr>
    <?php if ($ringkasanPulangIgd->edukasi_bisa !== 'Ya') { ?>
        <tr>
            <td colspan="2"></td>
            <td colspan="10">Tidak Bisa Diberikan Edukasi Karena : <?= $ringkasanPulangIgd->edukasi_bisa ? $ringkasanPulangIgd->edukasi_bisa : '-' ?></td>
        </tr>
    <?php } ?>
    <tr>
        <td colspan="2"><b>Saran :</b></td>
        <td colspan="10"><?= $ringkasanPulangIgd->saran ? $ringkasanPulangIgd->saran : '-' ?></td>
    </tr>
    <tr style="height: 200px; margin: 0; padding: 0;">
        <td colspan="8"><br /><br />Pasien/Keluarga<br /><br /><br /><br /><br /><br /><b>(.........................)</b><br></td>
        <td colspan="4">Pekanbaru,<?= date('d-m-Y', strtotime($ringkasanPulangIgd->created_at)) ?><br />Dokter Penanggung Jawab<br />Pelayanan Kegawatdaruratan<br /><br /><br /><br /><br /><b><?= $ringkasanPulangIgd->dokter->nama_lengkap ?? '-' ?></b><br><u><?= $ringkasanPulangIgd->dokter->id_nip_nrp ?? '-' ?></u></td>
    </tr>
</table>