<?php

use app\models\medis\ResumeMedisRi;
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

<?= $this->render('doc_kop', ['pasien' => $pasien]);

?>
<h2>Resume Medis Rawat Inap</h2>
<table class="table table-sm table-form" style="border: 1px solid;">

    <tr>
        <td colspan="2" style="text-align:left"><b>Nomor Registrasi :</b></td>
        <td colspan="4" style="text-align:left"><?= ($asesmen->layanan->registrasi_kode ?? '-') ?></td>
        <td colspan="2" style="text-align:left"><b>Tanggal Periksa :</b></td>
        <td colspan="4" style="text-align:left"><?= ($asesmen->created_at ?? '-') ?></td>
    </tr>
    <tr>
        <td colspan="6"><b>Ringkasan Riwayat Penyakit :</b></td>


        <td colspan="6"><b>Hasil Pemeriksaan Fisik Penting & Temuan Lainya :</b></td>
    </tr>
    <tr>

        <td colspan="6"><?= ($asesmen->ringkasan_riwayat_penyakit ?? '-') ?></td>


        <td colspan="6"><?= ($asesmen->hasil_pemeriksaan_fisik ?? '-') ?></td>
    </tr>
    <tr>
        <td colspan="3"><b>Indikasi Rawat Inap : </b></td>
        <td colspan="3"><b>Alasan Pulang :</b></td>
        <td colspan="3"><b>Kondisi Saat Pulang :</b></td>
        <td colspan="3"><b>Cara Pulang :</b></td>
    </tr>
    <tr>
        <td colspan="3"><?= ($asesmen->indikasi_rawat_inap ?? '-') ?></b></td>
        <td colspan="3"><?= ($asesmen->alasan_pulang ?? '-') ?></b></td>
        <td colspan="3"><?= ($asesmen->kondisi_pulang ?? '-') ?></b></td>
        <td colspan="3"><?= ($asesmen->cara_pulang ?? '-') ?></b></td>
    </tr>
    <tr>
        <td colspan="6"><b>Hasil Penunjang(Lab,Radiologi Dan Lain-lainya) : </b></td>
        <td colspan="6"><b>Terapi/Pengobatan selama dirawat :</b></td>
    </tr>
    <tr>
        <td colspan="6"><?= ($asesmen->hasil_penunjang ?? '-') ?></b></td>
        <td colspan="6"><?= ($asesmen->terapi_perawatan ?? '-') ?></b></td>
       
    </tr>
    <tr>
        <th class="bg-lightblue" colspan="12" style="text-align:center">DIAGNOSA DAN TINDAKAN</th>
    </tr>
    <tr>
        <td colspan="12"><b>Diaknosa Masuk : </b></td>
        
    </tr>
    <tr>
        <td colspan="12"><?= ($asesmen->diagnosa_masuk_deskripsi ?? '-') ?></b></td>
       
    </tr>
    <tr>
        <td class="text-left" rowspan="7" style="width: 10%;"><b>Diagnosa :</b></td>
        <td class="text-left" style="width: 10%;"><b>Jenis</b></td>
        <td colspan="4" class="text-left" style="width: 30%;"><b>ICD10</b></td>
        <td class="text-left" rowspan="7" style="width: 10%;"><b>Tindakan :</b></td>
        <td class="text-left" style="width: 10%;"><b>Jenis</b></td>
        <td colspan="4" class="text-left" style="width: 30%;"><b>ICD9</b></td>
    </tr>


    <tr>
        <td><?= 'UTAMA' ?></td>
        <td colspan="4"><?= ($asesmen->diagnosa_utama_kode ? $asesmen->diagnosa_utama_kode : '-') . '/' . ($asesmen->diagnosa_utama_deskripsi ? $asesmen->diagnosa_utama_deskripsi : '-') ?></td>
        <td><?= 'UTAMA' ?></td>
        <td colspan="4"><?= ($asesmen->tindakan_utama_kode ? $asesmen->tindakan_utama_kode : '-') . '/' . ($asesmen->tindakan_utama_deskripsi ? $asesmen->tindakan_utama_deskripsi : '-') ?></td>

    </tr>
    <tr>
        <td><?= 'TAMBAHAN 1' ?></td>
        <td colspan="4"><?= ($asesmen->diagnosa_tambahan1_kode ? $asesmen->diagnosa_tambahan1_kode : '-') . '/' . ($asesmen->diagnosa_tambahan1_deskripsi ? $asesmen->diagnosa_tambahan1_deskripsi : '-') ?></td>
        <td><?= 'TAMBAHAN 1' ?></td>
        <td colspan="4"><?= ($asesmen->tindakan_tambahan1_kode ? $asesmen->tindakan_tambahan1_kode : '-') . '/' . ($asesmen->tindakan_tambahan1_deskripsi ? $asesmen->tindakan_tambahan1_deskripsi : '-') ?></td>

    </tr>
    <tr>
        <td><?= 'TAMBAHAN 2' ?></td>
        <td colspan="4"><?= ($asesmen->diagnosa_tambahan2_kode? $asesmen->diagnosa_tambahan2_kode:'-') . '/' . ($asesmen->diagnosa_tambahan2_deskripsi?$asesmen->diagnosa_tambahan2_deskripsi: '-') ?></td>
        <td><?= 'TAMBAHAN 2' ?></td>
        <td colspan="4"><?= ($asesmen->tindakan_tambahan2_kode ? $asesmen->tindakan_tambahan2_kode:'-') . '/' . ($asesmen->tindakan_tambahan2_deskripsi?$asesmen->tindakan_tambahan2_deskripsi : '-') ?></td>

    </tr>
    <tr>
        <td><?= 'TAMBAHAN 3' ?></td>
        <td colspan="4"><?= ($asesmen->diagnosa_tambahan3_kode ? $asesmen->diagnosa_tambahan3_kode:'-') . '/' . ($asesmen->diagnosa_tambahan3_deskripsi?$asesmen->diagnosa_tambahan3_deskripsi: '-') ?></td>
        <td><?= 'TAMBAHAN 3' ?></td>
        <td colspan="4"><?= ($asesmen->tindakan_tambahan3_kode ? $asesmen->tindakan_tambahan3_kode :'-'). '/' . ($asesmen->tindakan_tambahan3_deskripsi?$asesmen->tindakan_tambahan3_deskripsi: '-') ?></td>

    </tr>
    <tr>
        <td><?= 'TAMBAHAN 4' ?></td>
        <td colspan="4"><?= ($asesmen->diagnosa_tambahan4_kode ? $asesmen->diagnosa_tambahan4_kode:'-') . '/' . ($asesmen->diagnosa_tambahan4_deskripsi? $asesmen->diagnosa_tambahan4_deskripsi: '-') ?></td>
        <td><?= 'TAMBAHAN 4' ?></td>
        <td colspan="4"><?= ($asesmen->tindakan_tambahan4_kode ? $asesmen->tindakan_tambahan4_kode :'-'). '/' . ($asesmen->tindakan_tambahan4_deskripsi? $asesmen->tindakan_tambahan4_deskripsi : '-') ?></td>

    </tr>
    <tr>
        <td><?= 'TAMBAHAN 5' ?></td>
        <td colspan="4"><?= ($asesmen->diagnosa_tambahan5_kode ? $asesmen->diagnosa_tambahan5_kode:'-') . '/' . ($asesmen->diagnosa_tambahan5_deskripsi?$asesmen->diagnosa_tambahan5_deskripsi : '-') ?></td>
        <td><?= 'TAMBAHAN 5' ?></td>
        <td colspan="4"><?= ($asesmen->tindakan_tambahan5_kode ? $asesmen->tindakan_tambahan5_kode:'-') . '/' . ($asesmen->tindakan_tambahan5_deskripsi?$asesmen->diagnosa_tambahan5_deskripsi : '-') ?></td>

    </tr>
    <tr>
        <th class="bg-lightblue" colspan="12" style="text-align:center">PEMERIKSAAN FISIK</th>
    </tr>

    <td><b>GCS E : </b><?= ($asesmen->gcs_e ?? '-') ?></td>
    <td><b>GCS M : </b><?= ($asesmen->gcs_m ?? '-') ?></td>
    <td><b>GCS V : </b><?= ($asesmen->gcs_v ?? '-') ?></td>
    <td colspan="2"><b>Nadi(x/menit) : </b><?= ($asesmen->nadi ?? '-') ?></td>
    <td colspan="2"><b>TD(mmHg) : </b><?= ($asesmen->darah ?? '-') ?></td>
    <td colspan="3"><b>Pernapasan(x/menit) : </b><?= ($asesmen->pernapasan ?? '-') ?></td>
    <td colspan="2"><b>Suhu(C) : </b><?= ($asesmen->suhu ?? '-') ?></td>

    </tr>


    <tr>
        <td><b>BB (Kg) :</b><?= ($asesmen->berat_badan ?? '-') ?></td>
        <td><b>TB (Cm) :</b><?= ($asesmen->tinggi_badan ?? '-') ?></td>
        <td colspan="4"><b>Keadaan Gizi :</b><?= ($asesmen->keadaan_gizi ?? '-') ?></td>
        <td colspan="3"><b>Keadaan Umum :</b><?= ($asesmen->keadaan_umum ?? '-') ?></td>
        <td colspan="3"><b>Tingkat Kesadaran :</b><?= ($asesmen->tingkat_kesadaran ?? '-') ?></td>
    </tr>

    <tr>
        <td colspan="2"><b>Alergi :</b></td>
        <td colspan="10"><?= ($asesmen->alergi ?? '-') ?></td>
    </tr>


    <tr>
        <td colspan="2"><b>Diet :</b></td>
        <td colspan="10"><?= ($asesmen->diet ?? '-') ?></td>
    </tr>
    <tr>
        <td colspan="2"><b>Obat Rumah :</b></td>
        <td colspan="10"><?= ($asesmen->obat_rumah ?? '-') ?></td>
    </tr>
    <tr>
        <td colspan="2"><b>Terapi Pulang :</b></td>
        <td colspan="10"><?= ($asesmen->terapi_pulang ?? '-') ?></td>
    </tr>

    <tr style="height: 200px; margin: 0; padding: 0;">
        <td colspan="12"><br /><br /><br /><br /><br /><br /><b><?= $asesmen->dokter->nama_lengkap ?? '-' ?></b><br><u><?= $asesmen->dokter->id_nip_nrp ?? '-' ?></u></td>
    </tr>
</table>