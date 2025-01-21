<?php

use app\models\medis\AsesmenAwalKeperawatanGeneral;
use app\models\medis\AsesmenAwalMedis;
use app\models\pendaftaran\Pasien;
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
<?php

?>

<?php
if ($is_ajax == true) {
    echo $this->render('doc_kop', ['pasien' => $pasien]);
} else {
    echo $this->render('doc_kop_v2', ['pasien' => $pasien]);
}
// echo '<pre>';
// print_r($asesmen);
?>
<h2>Asesmen Awal Medis General</h2>
<table class="table table-sm table-form" style="border: 1px solid;">
    <tr>
        <th class="text-left bg-lightblue" colspan="12" style="text-align:left">I. ANAMNESIS</th>
    </tr>
    <tr>
        <td colspan="2"><b>Sumber :</b></td>

        <td colspan="4"><?= ($asesmen->anamnesis_sumber ?? '-') ?></td>

        <td colspan="2" style="vertical-align:top"><b>Keluhan Utama :</b></td>
        <td colspan="4"><?= ($asesmen->anamnesis_keluhan ?? '-') ?></td>
    </tr>
    <tr>
        <td colspan="2"><b>Riwayat Penyakit Sekarang :</b></td>
        <td colspan="4"><?= ($asesmen->riwayat_penyakit_sekarang ?? '-') ?></td>

        <td colspan="2"><b>Riwayat Penyakit Dahulu :</b></td>
        <td colspan="4"><?= ($asesmen->riwayat_penyakit_dahulu ?? '-') ?></td>
    </tr>
    <tr>
        <td colspan="2"><b>Riwayat Pengobatan :</b></td>
        <td colspan="4"><?= ($asesmen->riwayat_pengobatan ?? '-') ?></td>

        <td colspan="2"><b>Riwayat Penyakit Keluarga :</b></td>
        <td colspan="4"><?= ($asesmen->riwayat_penyakit_keluarga ?? '-') ?></td>
    </tr>
    <tr>
        <td colspan="2"><b>Alergi :</b></td>
        <td colspan="4"><?= ($asesmen->alergi ?? '-') ?></td>

        <td colspan="2"><b>Status Sosial :</b></td>
        <td colspan="4"><?= ($asesmen->status_sosial ?? '-') ?></td>
    </tr>
    <tr>
        <td colspan="2"><b>Status Mental :</b></td>
        <td colspan="4"><?= ($asesmen->status_mental ?? '-') ?></td>

        <td colspan="2"><b>Ekonomi :</b></td>
        <td colspan="4"><?= ($asesmen->ekonomi ?? '-') ?></td>
    </tr>
    <tr>
        <td colspan="2"><b>Imunisasi/Tumbuh Kembang :</b></td>
        <td colspan="4"><?= ($asesmen->imunisasi ?? '-') ?></td>

        <td colspan="2"><b>Riwayat Prilaku Kesehatan :</b></td>
        <td colspan="4"><?= ($asesmen->riwayat_perilaku_kekerasan ?? '-') ?></td>
    </tr>
    <tr>
        <td colspan="2"><b>Ketergantungan Obat :</b></td>
        <td colspan="4"><?= ($asesmen->ketergantungan_obat ?? '-') ?></td>

        <td colspan="2"><b>Ketergantungan Alkohol :</b></td>
        <td colspan="4"><?= ($asesmen->ketergantungan_obat ?? '-') ?></td>
    </tr>
    <tr>
        <td colspan="2" style="vertical-align:top"><b>Permintaan Informasi Adanya Pelayanan Spiritual :</b></td>
        <td colspan="4"><?= ($asesmen->permintaan_informasi ?? '-') ?></td>

        <td colspan="2"><b>Status Psikologis :</b></td>
        <td colspan="4"><?= ($asesmen->status_psikologi ?? '-') ?></td>
    </tr>
    <tr>
        <th class="bg-lightblue" colspan="12" style="text-align:left">II. PEMERIKSAAN TANDA VITAL</th>
    </tr>
    <tr>
        <td><b>GCS E :</b><?= ($asesmen->gcs_e ?? '-') ?></td>
        <td><b>GCS M :</b><?= ($asesmen->gcs_m ?? '-') ?></td>
        <td><b>GCS V :</b><?= ($asesmen->gcs_v ?? '-') ?></td>
        <td colspan="2"><b>Nadi(x/menit) :</b><?= ($asesmen->nadi ?? '-') ?></td>
        <td colspan="2"><b>TD(mmHg) :</b><?= ($asesmen->darah ?? '-') ?></td>
        <td colspan="2"><b>Pernapasan(x/menit) :</b><?= ($asesmen->pernapasan ?? '-') ?></td>
        <td><b>Suhu(C) :</b><?= ($asesmen->suhu ?? '-') ?></td>
        <td colspan="2"><b>SatO2(%) :</b><?= ($asesmen->sato2 ?? '-') ?></td>
    </tr>

    <tr>
        <td><b>BB (Kg) :</b><?= ($asesmen->berat_badan ?? '-') ?></td>
        <td><b>TB (Cm) :</b><?= ($asesmen->tinggi_badan ?? '-') ?></td>
        <td colspan="4"><b>Keadaan Gizi :</b><?= ($asesmen->keadaan_gizi ?? '-') ?></td>
        <td colspan="3"><b>Keadaan Umum :</b><?= ($asesmen->keadaan_umum ?? '-') ?></td>
        <td colspan="3"><b>Tingkat Kesadaran :</b><?= ($asesmen->tingkat_kesadaran ?? '-') ?></td>
    </tr>
    <tr>
        <th class="text-left bg-lightblue" colspan="12" style="text-align:left">III. PEMERIKSAAN FISIK</th>
    </tr>
    <tr>
        <td colspan="2"><b>Kepala :</b></td>
        <td colspan="4"><?= ($asesmen->kepala ?? '-') ?></td>
        <td colspan="2"><b>Status Lokalis :</b></td>
        <td colspan="4"><?= ($asesmen->status_lokalis ?? '-') ?></td>
    </tr>
    <tr>
        <td colspan="2"><b>Mata :</b></td>
        <td colspan="10"><?= ($asesmen->mata ?? '-') ?></td>
    </tr>
    <tr>
        <td colspan="2"><b>Mulut :</b></td>
        <td colspan="10"><?= ($asesmen->mulut ?? '-') ?></td>
    </tr>
    <tr>
        <td colspan="2"><b>Leher :</b></td>
        <td colspan="10"><?= ($asesmen->leher ?? '-') ?></td>
    </tr>
    <tr>
        <td colspan="2"><b>Jantung :</b></td>
        <td colspan="10"><?= ($asesmen->jantung ?? '-') ?></td>
    </tr>
    <tr>
        <td colspan="2"><b>Paru :</b></td>
        <td colspan="10"><?= ($asesmen->paru ?? '-') ?></td>
    </tr>
    <tr>
        <td colspan="2"><b>Hati :</b></td>
        <td colspan="10"><?= ($asesmen->hati ?? '-') ?></td>
    </tr>
    <tr>
        <td colspan="2"><b>Abdomen :</b></td>
        <td colspan="10"><?= ($asesmen->abdomen ?? '-') ?></td>
    </tr>
    <tr>
        <td colspan="2"><b>Ginjal & K.Kemih :</b></td>
        <td colspan="10"><?= ($asesmen->ginjal_kemih ?? '-') ?></td>
    </tr>
    <tr>
        <td colspan="2"><b>Anus :</b></td>
        <td colspan="10"><?= ($asesmen->anus ?? '-') ?></td>
    </tr>
    <tr>
        <td colspan="2"><b>Ektremitas :</b></td>
        <td colspan="10"><?= ($asesmen->ektremitas ?? '-') ?></td>
    </tr>

    <tr>
        <th class="text-left bg-lightblue" colspan="12" style="text-align:left">IV. PEMERIKSAAN PENUNJANG</th>
    </tr>
    <tr>
        <td colspan="12">
            <?= ($asesmen->pemeriksaan_penunjang ?? '-') ?>
        </td>
    </tr>
    <tr>
        <th class="text-left bg-lightblue" colspan="12" style="text-align:left">V. MASALAH</th>
    </tr>
    <tr>
        <td colspan="12">
            <?= ($asesmen->masalah ?? '-') ?>
        </td>
    </tr>
    <tr>
        <th class="text-left bg-lightblue" colspan="12" style="text-align:left">VI. PENATALAKSANAAN</th>
    </tr>
    <tr>
        <td colspan="12">
            <?= ($asesmen->penatalaksanaan ?? '-') ?>
        </td>
    </tr>
    <tr>
        <th class="text-left bg-lightblue" colspan="12" style="text-align:left">VII. PEMERIKSAAN LANJUTAN</th>
    </tr>
    <tr>
        <td colspan="12">
            <?= ($asesmen->pemeriksaan_ulang ?? '-') ?>
        </td>
    </tr>
    <tr>
        <th class="text-left bg-lightblue" colspan="12" style="text-align:left">VIII. RENCANA ASUHAN</th>
    </tr>
    <tr>
        <?php if ($asesmen->versi == '2.0'): ?>
            <td colspan="3">
                <b>Catatan Rencana Asuhan : </b>
            </td>
            <td colspan="9">
                <?= ($asesmen->catatan_rencana_asuhan ?? '') ?>
            </td>
        <?php else: ?>
        <?php endif; ?>
    </tr>
    <tr>
        <td colspan="3">
            <b>Status Keluar : </b>
        </td>
        <td colspan="9"><?= ($asesmen->status_keluar ?? '-') ?>
        </td>
    </tr>
    <tr>

        <td colspan="3">
            <b>Keterangan Status Keluar : </b>
        </td>
        <td colspan="9"><?= ($asesmen->keterangan_keluar ?? '-') ?>
        </td>

    </tr>

    <tr style="height: 200px; margin: 0; padding: 0;">
        <td colspan="12"><?= !empty($asesmen->tanggal_final) ? 'Tanggal Final : ' . $asesmen->tanggal_final : 'Tanggal Buat : ' . $asesmen->created_at ?><br />Dokter<br /><br /><br /><br /><br /><b><?= $asesmen->dokter->nama_lengkap ?? '-' ?></b><br><u><?= $asesmen->dokter->id_nip_nrp ?? '-' ?></u></td>
    </tr>
</table>