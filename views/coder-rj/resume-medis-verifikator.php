<?php

use app\models\medis\ResumeMedisRi;
use app\models\pendaftaran\Pasien;
use yii\helpers\Url;
use app\components\HelperSpesialClass;


?>
<style>
    h2 {
        text-align: center !important;
    }

    table {
        margin-left: auto !important;
        margin-right: auto !important;
        margin-bottom: 9px !important;
        width: 100 !important;
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

<?= $this->render('doc_kop', ['pasien' => $pasien]);

?>
<h2>Resume Medis Rawat Inap</h2>
<table border="1" style="width:100%">
    <tbody>
        <tr>
            <td style="width:20%"><b>Nomor Registrasi :</b></td>
            <td colspan="2" style="width:30%"><?= ($asesmen->layanan->registrasi_kode ?? '-') ?></td>
            <td style="width:20%"><b>Tanggal Masuk :</b></td>
            <td colspan="2" style="width:30%"><?= ($asesmen->layanan->registrasi->tgl_masuk ?? '-') ?></td>

        </tr>

        <tr>
            <td colspan="3" style="width:50%">
                <p><b>Ringkasan Riwayat Penyakit :</b></p>
            </td>

            <td colspan="3" style="width:50%">
                <p><b>Hasil Pemeriksaan Fisik Penting & Temuan Lainya :</b></p>
            </td>
        </tr>
        <tr>
            <td colspan="3" style="width:50%">
                <p><?= ($asesmen->ringkasan_riwayat_penyakit ?? '-') ?></p>
            </td>

            <td colspan="3" style="width:50%">
                <p><?= ($asesmen->hasil_pemeriksaan_fisik ?? '-') ?></p>
            </td>
        </tr>
        <tr>

            <td style="width:20%"><b>Indikasi Rawat Inap : </b></td>
            <td colspan="2" style="width:30%"><b>Alasan Pulang :</b></td>
            <td style="width:20%"><b>Kondisi Saat Pulang :</b></td>
            <td colspan="2" style="width:30%"><b>Cara Pulang :</b></td>
        </tr>
        <tr>
            <td style="width:20%"><?= ($asesmen->indikasi_rawat_inap ?? '-') ?></b></td>
            <td colspan="2" style="width:30%"><?= ($asesmen->alasan_pulang ?? '-') ?></b></td>
            <td style="width:20%"><?= ($asesmen->kondisi_pulang ?? '-') ?></b></td>
            <td colspan="2" style="width:30%"><?= ($asesmen->cara_pulang ?? '-') ?></b></td>
        </tr>

        <tr>
            <td colspan="3" style="width:50%"><b>Hasil Penunjang(Lab,Radiologi Dan Lain-lainya) : </b></td>
            <td colspan="3" style="width:50%"><b>Terapi/Pengobatan selama dirawat :</b></td>
        </tr>
        <tr>
            <td colspan="3" style="max-width:50%; vertical-align: top;text-align: left;"><?= ($asesmen->hasil_penunjang ?? '-') ?></td>
            <td colspan="3" style="width:50%; vertical-align: top;text-align: left;"><?= ($asesmen->terapi_perawatan ?? '-') ?></td>

        </tr>
        <tr>
            <th class="bg-lightblue" colspan="6" style="text-align:center">DIAGNOSA DAN TINDAKAN</th>
        </tr>
        <tr>
            <td colspan="6"><b>Diaknosa Masuk : </b></td>

        </tr>
        <tr>
            <td colspan="6"><?= ($asesmen->diagnosa_masuk_deskripsi ?? '-') ?></b></td>

        </tr>
        <tr>
            <td rowspan="7" style="width:10%;vertical-align: top;text-align: left;"><b>Diagnosa :</b></td>
            <td style="width:10%"><b>Jenis :</b></td>
            <td style="width:30%"><b>ICD10 :</b></td>

            <td rowspan="7" style="width:10%; vertical-align: top;text-align: left;"><b>Tindakan :</b></td>
            <td style="width:10%"><b>Jenis :</b></td>
            <td style="width:30%"><b>ICD10 :</b></td>

        </tr>
        <tr>
            <td><?= 'UTAMA' ?></td>
            <td><?= ($asesmen->diagnosa_utama_id ? $asesmen->diagutama->kode . ' (' . $asesmen->diagutama->deskripsi . ')' : '-') . ' / ' . ($asesmen->diagnosa_utama_deskripsi ? $asesmen->diagnosa_utama_deskripsi : '-') ?></td>
            <td><?= 'UTAMA' ?></td>
            <td><?= ($asesmen->tindakan_utama_id ? $asesmen->tindutama->kode . ' (' . $asesmen->tindutama->deskripsi . ')'  : '-') . '/' . ($asesmen->tindakan_utama_deskripsi ? $asesmen->tindakan_utama_deskripsi : '-') ?></td>

        </tr>
        <tr>
            <td><?= 'TAMBAHAN 1' ?></td>
            <td><?= ($asesmen->diagnosa_tambahan1_id ? $asesmen->diagsatu->kode . ' (' . $asesmen->diagsatu->deskripsi . ')' : '-') . '/' . ($asesmen->diagnosa_tambahan1_deskripsi ? $asesmen->diagnosa_tambahan1_deskripsi : '-') ?></td>
            <td><?= 'TAMBAHAN 1' ?></td>
            <td><?= ($asesmen->tindakan_tambahan1_id ? $asesmen->tindsatu->kode . ' (' . $asesmen->tindsatu->deskripsi . ')' : '-') . '/' . ($asesmen->tindakan_tambahan1_deskripsi ? $asesmen->tindakan_tambahan1_deskripsi : '-') ?></td>

        </tr>
        <tr>
            <td><?= 'TAMBAHAN 2' ?></td>
            <td><?= ($asesmen->diagnosa_tambahan2_id ? $asesmen->diagdua->kode . ' (' . $asesmen->diagdua->deskripsi . ')' : '-') . '/' . ($asesmen->diagnosa_tambahan2_deskripsi ? $asesmen->diagnosa_tambahan2_deskripsi : '-') ?></td>
            <td><?= 'TAMBAHAN 2' ?></td>
            <td><?= ($asesmen->tindakan_tambahan2_id ? $asesmen->tinddua->kode . ' (' . $asesmen->tinddua->deskripsi . ')' : '-') . '/' . ($asesmen->tindakan_tambahan2_deskripsi ? $asesmen->tindakan_tambahan2_deskripsi : '-') ?></td>

        </tr>
        <tr>
            <td><?= 'TAMBAHAN 3' ?></td>
            <td><?= ($asesmen->diagnosa_tambahan3_id ? $asesmen->diagtiga->kode . ' (' . $asesmen->diagtiga->deskripsi . ')' : '-') . '/' . ($asesmen->diagnosa_tambahan3_deskripsi ? $asesmen->diagnosa_tambahan3_deskripsi : '-') ?></td>
            <td><?= 'TAMBAHAN 3' ?></td>
            <td><?= ($asesmen->tindakan_tambahan3_id ? $asesmen->tindtiga->kode . ' (' . $asesmen->tindtiga->deskripsi . ')' : '-') . '/' . ($asesmen->tindakan_tambahan3_deskripsi ? $asesmen->tindakan_tambahan3_deskripsi : '-') ?></td>

        </tr>
        <tr>
            <td><?= 'TAMBAHAN 4' ?></td>
            <td><?= ($asesmen->diagnosa_tambahan4_kode ? $asesmen->diagempat->kode . ' (' . $asesmen->diagempat->deskripsi . ')' : '-') . '/' . ($asesmen->diagnosa_tambahan4_deskripsi ? $asesmen->diagnosa_tambahan4_deskripsi : '-') ?></td>
            <td><?= 'TAMBAHAN 4' ?></td>
            <td><?= ($asesmen->tindakan_tambahan4_kode ? $asesmen->tindempat->kode . ' (' . $asesmen->tindempat->deskripsi . ')' : '-') . '/' . ($asesmen->tindakan_tambahan4_deskripsi ? $asesmen->tindakan_tambahan4_deskripsi : '-') ?></td>

        </tr>
        <tr>
            <td><?= 'TAMBAHAN 5' ?></td>
            <td><?= ($asesmen->diagnosa_tambahan5_id ? $asesmen->diaglima->kode . ' (' . $asesmen->diaglima->deskripsi . ')' : '-') . '/' . ($asesmen->diagnosa_tambahan5_deskripsi ? $asesmen->diagnosa_tambahan5_deskripsi : '-') ?></td>
            <td><?= 'TAMBAHAN 5' ?></td>
            <td><?= ($asesmen->tindakan_tambahan5_id ? $asesmen->tindlima->kode . ' (' . $asesmen->tindlima->deskripsi . ')' : '-') . '/' . ($asesmen->tindakan_tambahan5_deskripsi ? $asesmen->diagnosa_tambahan5_deskripsi : '-') ?></td>

        </tr>

        <tr>
            <td style="width:10%;vertical-align: top;text-align: left;"><b>GCS E : </b></td>
            <td style="width:10%;vertical-align: top;text-align: left;"><b>GCS M : </b></td>
            <td style="width:30%;vertical-align: top;text-align: left;"><b>GCS V : </b></td>

            <td style="width:10%; vertical-align: top;text-align: left;"><b>Nadi(x/menit) : </b></td>
            <td style="width:10%;vertical-align: top;text-align: left;"><b>TD(mmHg) : </b></td>
            <td style="width:30%;vertical-align: top;text-align: left;"><b>Pernapasan(x/menit) : </b></td>

        </tr>
        <tr>

            <td style="width:10%;vertical-align: top;text-align: left;"><?= ($asesmen->gcs_e ?? '-') ?></td>
            <td style="width:10%"><?= ($asesmen->gcs_m ?? '-') ?></td>
            <td style="width:30%"><?= ($asesmen->gcs_v ?? '-') ?></td>

            <td style="width:10%; vertical-align: top;text-align: left;"><?= ($asesmen->nadi ?? '-') ?></td>
            <td style="width:10%"><?= ($asesmen->darah ?? '-') ?></td>
            <td style="width:30%"><?= ($asesmen->pernapasan ?? '-') ?></td>
        </tr>

        <tr>
            <td style="width:10%;vertical-align: top;text-align: left;"><b>Suhu(C) : </b></td>
            <td style="width:10%;vertical-align: top;text-align: left;"><b>BB (Kg) :</b></td>
            <td style="width:30%;vertical-align: top;text-align: left;"><b>TB (Cm) :</b></td>

            <td style="width:10%; vertical-align: top;text-align: left;"><b>Keadaan Gizi :</b></td>
            <td style="width:10%;vertical-align: top;text-align: left;"><b>Keadaan Umum :</b></td>
            <td style="width:30%;vertical-align: top;text-align: left;"><b>Tingkat Kesadaran :</b></td>

        </tr>
        <tr>

            <td style="width:10%;vertical-align: top;text-align: left;"><?= ($asesmen->suhu ?? '-') ?></td>
            <td style="width:10%"><?= ($asesmen->berat_badan ?? '-') ?></td>
            <td style="width:30%"><?= ($asesmen->tinggi_badan ?? '-') ?></td>

            <td style="width:10%; vertical-align: top;text-align: left;"><?= ($asesmen->keadaan_gizi ?? '-') ?></td>
            <td style="width:10%"><?= ($asesmen->keadaan_umum ?? '-') ?></td>
            <td style="width:30%"><?= ($asesmen->tingkat_kesadaran ?? '-') ?></td>
        </tr>
        <tr>
            <td style="width:20%"><b>Alergi :</td>
            <td colspan="2" style="width:30%"><?= ($asesmen->alergi ?? '-') ?></td>
            <td style="width:20%"><b>Diet :</b></td>
            <td colspan="2" style="width:30%"><?= ($asesmen->diet ?? '-') ?></td>

        </tr>
        <tr>
            <td colspan="2" style="width:40%"><b>Obat Rumah :</td>
            <td colspan="4" style="width:60%"><?= ($asesmen->alergi ?? '-') ?></td>


        </tr>
        <tr>
            <td colspan="2" style="width:40%"><b>Terapi Pulang :</b></td>
            <td colspan="4" style="width:60%"><?= ($asesmen->diet ?? '-') ?></td>
        </tr>

        <tr style="height: 200px; margin: 0; padding: 0;">
            <td colspan="3" style="width:50%"></td>
            <td colspan="3">Pekanbaru, <?= date('d-m-Y', strtotime($asesmen->created_at)) ?><br />Dokter DPJP<br /><br /><br /><br /><br /><b><?= HelperSpesialClass::getNamaPegawaiArray($asesmen->dokter) ?? '-' ?></b><br><u><?= $asesmen->dokter->id_nip_nrp ?? '-' ?></u></td>

        </tr>
    </tbody>
</table>