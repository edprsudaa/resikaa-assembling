<?php

use app\models\medis\AsesmenAwalKeperawatanGeneral;
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
// $asesmen = AsesmenAwalKeperawatanGeneral::find()->joinWith(['perawat','layanan'=>function($q){
//     $q->joinWith(['registrasi'=>function($query){
//         $query->joinWith('pasien');
//     }]);
// }])->where(['medis.asesmen_awal_keperawatan_general.id'=>'2125'])->one();
// $pasien = Pasien::find()->where(['kode'=>$asesmen->layanan->registrasi->pasien->kode])->one();
?>

<?= $this->render('doc_kop', ['pasien' => $pasien]);
?>
<h2>Asesmen Awal Keperawatan</h2>
<table class="table table-sm table-form" style="border: 2px solid;">
    <tr>
        <th class="text-left bg-lightblue" colspan="12" style="text-align:left">A. ANAMNESIS</th>
    </tr>
    <tr style="width: 100%;border:none">
        <td style="width: 9%;border:none"></td>
        <td style="width: 9%;border:none"></td>
        <td style="width: 9%;border:none"></td>
        <td style="width: 9%;border:none"></td>
        <td style="width: 8%;border:none"></td>
        <td style="width: 8%;border:none"></td>
        <td style="width: 8%;border:none"></td>
        <td style="width: 8%;border:none"></td>
        <td style="width: 8%;border:none"></td>
        <td style="width: 8%;border:none"></td>
        <td style="width: 8%;border:none"></td>
        <td style="width: 8%;border:none"></td>
    </tr>
    <tr>
        <td colspan="2"><b>Sumber Anamnesis :</b></td>

        <td colspan="10"><?= ($asesmen->anamnesis_sumber ?? '-') ?></td>
    </tr>
    <tr>
        <td colspan="2"><b>Keluhan Utama :</b></td>
        <td colspan="10"><?= ($asesmen->anamnesis_keluhan ?? '-') ?></td>
    </tr>
    <tr>
        <td colspan="2"><b>Riwayat Penyakit Sekarang :</b></td>
        <td colspan="10"><?= ($asesmen->riwayat_penyakit_sekarang ?? '-') ?></td>
    </tr>
    <tr>
        <td colspan="2"><b>Riwayat Penyakit Dahulu :</b></td>
        <td colspan="10"><?= ($asesmen->riwayat_penyakit_dahulu ?? '-') ?></td>
    </tr>
    <tr>
        <td colspan="2"><b>Riwayat Pengobatan TB :</b></td>
        <td colspan="10"><?= ($asesmen->riwayat_pengobatan_tb ?? '-') ?></td>
    </tr>
    <tr>
        <td colspan="2"><b>Riwayat Pengobatan Lain :</b></td>
        <td colspan="10"><?= ($asesmen->riwayat_pengobatan_lain ?? '-') ?></td>
    </tr>
    <tr>
        <td colspan="2"><b>Riwayat Penyakit Keluarga :</b></td>
        <td colspan="10"><?= ($asesmen->riwayat_penyakit_keluarga ?? '-') ?></td>
    </tr>
    <tr>
        <td colspan="2"><b>Alergi :</b></td>
        <td colspan="10"><?= ($asesmen->alergi ?? '-') ?></td>
    </tr>
    <tr>
        <td colspan="2"><b>Status Sosial :</b></td>
        <td colspan="10"><?= ($asesmen->status_sosial ?? '-') ?></td>
    </tr>
    <tr>
        <td colspan="2"><b>Status Mental :</b></td>
        <td colspan="10"><?= ($asesmen->status_mental ?? '-') ?></td>
    </tr>
    <tr>
        <td colspan="2"><b>Ekonomi :</b></td>
        <td colspan="10"><?= ($asesmen->ekonomi ?? '-') ?></td>
    </tr>
    <tr>
        <td colspan="2"><b>Riwayat Prilaku Kekerasan :</b></td>
        <td colspan="10"><?= ($asesmen->riwayat_perilaku_kekerasan ?? '-') ?></td>
    </tr>

    <tr>
        <td colspan="2"><b>Ketergantungan Obat :</b></td>
        <td colspan="10"><?= ($asesmen->ketergantungan_obat ?? '-') ?></td>
    </tr>
    <tr>
        <td colspan="2"><b>Ketergantungan Alkohol :</b></td>
        <td colspan="10"><?= ($asesmen->ketergantungan_alkohol ?? '-') ?></td>
    </tr>
    <tr>
        <td colspan="2"><b>Permintaan Informasi Adanya Pelayanan Spiritual :</b></td>
        <td colspan="10"><?= ($asesmen->permintaan_informasi ?? '-') ?></td>
    </tr>
    <tr>
        <td colspan="2"><b>Status Psikologis :</b></td>
        <td colspan="10"><?= ($asesmen->status_psikologi ?? '-') ?></td>
    </tr>
    <tr>
        <th class="bg-lightblue" colspan="12" style="text-align:left">B. PEMERIKSAAN TANDA VITAL</th>
    </tr>
    <tr>
        <td><b>GCS E :</b><?= ($asesmen->gcs_e ?? '-') ?></td>
        <td><b>GCS M :</b><?= ($asesmen->gcs_m ?? '-') ?></td>
        <td><b>GCS V :</b><?= ($asesmen->gcs_v ?? '-') ?></td>
        <td colspan="2"><b>Nadi(x/menit) :</b><?= ($asesmen->nadi ?? '-') ?></td>
        <td colspan="2"><b>TD(mmHg) :</b><?= ($asesmen->darah ?? '-') ?></td>
        <td colspan="3"><b>Pernapasan(x/menit) :</b><?= ($asesmen->pernapasan ?? '-') ?></td>
        <td colspan="2"><b>Suhu(C) :</b><?= ($asesmen->suhu ?? '-') ?></td>

    </tr>
    <tr>
        <td colspan="2"><b>SatO2(%) :</b><?= ($asesmen->sato2 ?? '-') ?></td>
        <td colspan="4"><b>Sikap Tubuh :</b><?= ($asesmen->sikap_tubuh ?? '-') ?></td>
        <td colspan="3"><b>Tingkat Kesadaran :</b><?= ($asesmen->tingkat_kesadaran ?? '-') ?></td>
    </tr>
    <tr>
        <th class="bg-lightblue" colspan="12" style="text-align:left">C. PEMERIKSAAN ANTROPOMETRI</th>
    </tr>
    <tr>
        <td colspan="4"><b>TB (Cm) :</b><?= ($asesmen->tinggi_badan ?? '-') ?></td>
        <td colspan="4"><b>BB Skrg(Kg) :</b><?= ($asesmen->berat_badan ?? '-') ?></td>
        <td colspan="4"><b>BB Sebelum Sakit (Kg) :</b><?= ($asesmen->berat_badan_sebelum ?? '-') ?></td>

    </tr>
    <tr>
        <td colspan="2"><b>IMT :</b><?= ($asesmen->imt ?? '-') ?></td>
        <td colspan="2"><b>LILA (cm) :</b><?= ($asesmen->lila ?? '-') ?></td>
        <td colspan="3"><b>Terjadi Penurunan BB :</b><?= ($asesmen->penurunan_bb ?? '-') ?></td>
        <td colspan="3"><b>Skoring Penurunan BB :</b><?= ($asesmen->skor_penurunan_bb ?? '-') ?></td>
    </tr>
    <tr>
        <th class="text-left bg-lightblue" colspan="6" style="text-align:left">C. PEMERIKSAAN KULIT & KELAMIN</th>
        <th class="text-left bg-lightblue" colspan="6" style="text-align:left">D. PEMERIKSAAN KEPALA & LEHER</th>
    </tr>
    <tr>
        <td colspan="2"><b>Warna Kulit :</b></td>
        <td colspan="4"><?= ($asesmen->kulit_warna ?? '-') ?></td>
        <td colspan="2"><b>Lingkar Kepala (Cm) :</b></td>
        <td colspan="4"><?= ($asesmen->kepala_lk ?? '-') ?></td>
    </tr>
    <tr>
        <td colspan="2"><b>Sianosis :</b></td>
        <td colspan="4"><?= ($asesmen->kulit_sianosis ?? '-') ?></td>
        <td colspan="2"><b>Bentuk Kepala :</b></td>
        <td colspan="4"><?= ($asesmen->kepala_bentuk ?? '-') ?></td>
    </tr>
    <tr>
        <td colspan="2"><b>Kemerahan(Rash) :</b></td>
        <td colspan="4"><?= ($asesmen->kulit_kemerahan ?? '-') ?></td>
        <td colspan="2"><b>Gigi Palsu :</b></td>
        <td colspan="4"><?= ($asesmen->gigi_palsu ?? '-') ?></td>
    </tr>
    <tr>
        <td colspan="2"><b>Tugor Kulit :</b></td>
        <td colspan="4"><?= ($asesmen->kulit_turgor_kulit ?? '-') ?></td>
        <td colspan="2"><b>Fontanel :</b></td>
        <td colspan="4"><?= ($asesmen->fontanel ?? '-') ?></td>
    </tr>
    <tr>
        <td colspan="2"><b>Dekubitus :</b></td>
        <td colspan="4"><?= ($asesmen->kulit_dekubitus ?? '-') ?></td>
        <td colspan="2"><b>Telinga :</b></td>
        <td colspan="4"><?= ($asesmen->telinga ?? '-') ?></td>
    </tr>
    <tr>
        <td colspan="2"><b>Tumor :</b></td>
        <td colspan="4"><?= ($asesmen->kulit_tumor ?? '-') ?></td>
        <td colspan="2"><b>Hidung :</b></td>
        <td colspan="4"><?= ($asesmen->hidung ?? '-') ?></td>
    </tr>
    <tr>
        <td colspan="2"><b>Luka Bakar :</b></td>
        <td colspan="4"><?= ($asesmen->kulit_luka_bakar ?? '-') ?></td>
        <td colspan="2"><b>Sclera Mata :</b></td>
        <td colspan="4"><?= ($asesmen->sclera_mata ?? '-') ?></td>
    </tr>
    <tr>
        <td colspan="2"><b>Luka Tusuk :</b></td>
        <td colspan="4"><?= ($asesmen->kulit_luka_tusuk ?? '-') ?></td>
        <td colspan="2"><b>Konjungtiva Mata :</b></td>
        <td colspan="4"><?= ($asesmen->konjungtiva_mata ?? '-') ?></td>
    </tr>
    <tr>
        <td colspan="2"><b>Luka Memar :</b></td>
        <td colspan="4"><?= ($asesmen->kulit_luka_memar ?? '-') ?></td>
        <td colspan="2"><b>Mulut :</b></td>
        <td colspan="4"><?= ($asesmen->mulut ?? '-') ?></td>
    </tr>
    <tr>
        <td colspan="2"><b>Luka Robek :</b></td>
        <td colspan="4"><?= ($asesmen->kulit_luka_robek ?? '-') ?></td>
        <td colspan="2"><b>Rambut/Kepala :</b></td>
        <td colspan="4"><?= ($asesmen->kepala_rambut ?? '-') ?></td>
    </tr>
    <tr>
        <td colspan="2"></td>
        <td colspan="4"></td>
        <td colspan="2"><b>Terpasang Alat :</b></td>
        <td colspan="4"><?= ($asesmen->kepala_leher_terpasang_alat ?? '-') ?></td>
    </tr>
    <tr>
        <th class="text-left bg-lightblue" colspan="6" style="text-align:left">E. PEMERIKSAAN RESPIRASI</th>
        <th class="text-left bg-lightblue" colspan="6" style="text-align:left">F. PEMERIKSAAN KARDIOVASKULER</th>
    </tr>
    <tr>
        <td colspan="2"><b>Suara Nafas :</b></td>
        <td colspan="4"><?= ($asesmen->respirasi_suara_napas ?? '-') ?></td>
        <td colspan="2"><b>Bunyi Jantung :</b></td>
        <td colspan="4"><?= ($asesmen->kardiovaskular_jantung ?? '-') ?></td>
    </tr>
    <tr>
        <td colspan="2"><b>Pola Nafas :</b></td>
        <td colspan="4"><?= ($asesmen->respirasi_pola_napas ?? '-') ?></td>
        <td colspan="2"><b>EKG :</b></td>
        <td colspan="4"><?= ($asesmen->kardiovaskular_ekg ?? '-') ?></td>
    </tr>
    <tr>
        <td colspan="2"><b>Nafas Cuping Hidung :</b></td>
        <td colspan="4"><?= ($asesmen->respirasi_napas_cuping ?? '-') ?></td>
        <td colspan="2"></td>
        <td colspan="4"></td>
    </tr>
    <tr>
        <td colspan="2"><b>Retraksi Dada :</b></td>
        <td colspan="4"><?= ($asesmen->respirasi_otot_bantu ?? '-') ?></td>
        <td colspan="2"></td>
        <td colspan="4"></td>
    </tr>
    <tr>
        <td colspan="2"><b>Clubing Finger :</b></td>
        <td colspan="4"><?= ($asesmen->respirasi_clubing_finger ?? '-') ?></td>
        <td colspan="2"></td>
        <td colspan="4"></td>
    </tr>
    <tr>
        <td colspan="2"><b>Terpasang Alat :</b></td>
        <td colspan="4"><?= ($asesmen->respirasi_terpasang_alat ?? '-') ?></td>
        <td colspan="2"></td>
        <td colspan="4"></td>
    </tr>
    <tr>
        <th class="text-left bg-lightblue" colspan="6" style="text-align:left">G. PEMERIKSAAN PERSEPSI SENSORI</th>
        <th class="text-left bg-lightblue" colspan="6" style="text-align:left">H. PEMERIKSAAN NEUROLOGIS</th>
    </tr>
    <tr>
        <td colspan="2"><b>Pendengaran :</b></td>
        <td colspan="4"><?= ($asesmen->persepsi_pendengaran ?? '-') ?></td>
        <td colspan="2"><b>Keluhan :</b></td>
        <td colspan="4"><?= ($asesmen->neurologi_keluhan ?? '-') ?></td>
    </tr>
    <tr>
        <td colspan="2"><b>Penglihatan :</b></td>
        <td colspan="4"><?= ($asesmen->persepsi_penglihatan ?? '-') ?></td>
        <td colspan="2"><b>Refleks Fisiologis :</b></td>
        <td colspan="4"><?= ($asesmen->neurologi_reflek_fisiologis ?? '-') ?></td>
    </tr>
    <tr>
        <td colspan="2"><b>Penghiduan :</b></td>
        <td colspan="4"><?= ($asesmen->persepsi_penghiduan ?? '-') ?></td>
        <td colspan="2"><b>Refleks Patologis :</b></td>
        <td colspan="4"><?= ($asesmen->neurologi_reflek_patologis ?? '-') ?></td>
    </tr>
    <tr>
        <th class="text-left bg-lightblue" colspan="6" style="text-align:left">I. PEMERIKSAAN ELIMINASI</th>
        <th class="text-left bg-lightblue" colspan="6" style="text-align:left">J. PEMERIKSAAN GENETALIA</th>
    </tr>
    <tr>
        <td colspan="2"><b>BAB :</b></td>
        <td colspan="4"><?= ($asesmen->eleminasi_bab ?? '-') ?></td>
        <td colspan="2"><b>Kelainan :</b></td>
        <td colspan="4"><?= ($asesmen->genetalia_kelainan ?? '-') ?></td>
    </tr>
    <tr>
        <td colspan="2"><b>BAK :</b></td>
        <td colspan="4"><?= ($asesmen->eliminasi_bak ?? '-') ?></td>
        <td colspan="2"><b>Bentuk :</b></td>
        <td colspan="4"><?= ($asesmen->genetalia_simetris ?? '-') ?></td>
    </tr>
    <tr>
        <td colspan="2"><b></b></td>
        <td colspan="4"></td>
        <td colspan="2"><b>Edema :</b></td>
        <td colspan="4"><?= ($asesmen->genetalia_edema ?? '-') ?></td>
    </tr>
    <tr>
        <td colspan="2"><b></b></td>
        <td colspan="4"></td>
        <td colspan="2"><b>Secret :</b></td>
        <td colspan="4"><?= ($asesmen->genetalia_secret ?? '-') ?></td>
    </tr>
    <tr>
        <th class="text-left bg-lightblue" colspan="6" style="text-align:left">K. PEMERIKSAAN GASTROINTESTINAL</th>
        <th class="text-left bg-lightblue" colspan="6" style="text-align:left">L. PEMERIKSAAN EXTREMITAS</th>
    </tr>
    <tr>
        <td colspan="2"><b>Mual :</b></td>
        <td colspan="4"><?= ($asesmen->gastro_mual ?? '-') ?></td>
        <td colspan="2"><b>Edema :</b></td>
        <td colspan="4"><?= ($asesmen->extremitas_edema ?? '-') ?></td>
    </tr>
    <tr>
        <td colspan="2"><b>Muntah :</b></td>
        <td colspan="4"><?= ($asesmen->gastro_muntah ?? '-') ?></td>
        <td colspan="2"><b>Fraktur :</b></td>
        <td colspan="4"><?= ($asesmen->extremitas_fraktur ?? '-') ?></td>
    </tr>
    <tr>
        <td colspan="2"><b>Acites :</b></td>
        <td colspan="4"><?= ($asesmen->gastro_acites ?? '-') ?></td>
        <td colspan="2"><b>Amputasi :</b></td>
        <td colspan="4"><?= ($asesmen->extremitas_amputasi ?? '-') ?></td>
    </tr>
    <tr>
        <td colspan="2"><b>Pembesaran Hepar :</b></td>
        <td colspan="4"><?= ($asesmen->gastro_pembesaran_hepar ?? '-') ?></td>
        <td colspan="2"><b>Parase :</b></td>
        <td colspan="4"><?= ($asesmen->extremitas_parase ?? '-') ?></td>
    </tr>
    <tr>
        <td colspan="2"><b>Pembesaran Limpa :</b></td>
        <td colspan="4"><?= ($asesmen->gastro_pembesaran_limpa ?? '-') ?></td>
        <td colspan="2"><b>Legi :</b></td>
        <td colspan="4"><?= ($asesmen->extremitas_legi ?? '-') ?></td>
    </tr>
    <tr>
        <td colspan="2"><b>Nyeri Tekan :</b></td>
        <td colspan="4"><?= ($asesmen->gastro_nyeri_tekan ?? '-') ?></td>
        <td colspan="2"><b>Defornitas :</b></td>
        <td colspan="4"><?= ($asesmen->extremitas_defornitas ?? '-') ?></td>
    </tr>
    <tr>
        <td colspan="2"><b>Masa Abdomen :</b></td>
        <td colspan="4"><?= ($asesmen->gastro_massa_abdomen ?? '-') ?></td>
        <td colspan="2"><b>Tumor :</b></td>
        <td colspan="4"><?= ($asesmen->extremitas_tumor ?? '-') ?></td>
    </tr>
    <tr>
        <td colspan="2"><b>Nyeri Lepas :</b></td>
        <td colspan="4"><?= ($asesmen->gastro_nyeri_lepas ?? '-') ?></td>
        <td colspan="2"><b></b></td>
        <td colspan="4"></td>
    </tr>
    <tr>
        <td colspan="2"><b>Terpasang Alat :</b></td>
        <td colspan="4"><?= ($asesmen->gastro_terpasang_alat ?? '-') ?></td>
        <td colspan="2"><b></b></td>
        <td colspan="4"></td>
    </tr>
    <tr>
        <th class="text-left bg-lightblue" colspan="12" style="text-align:left">M. PERTUMBUHAN & PERKEMBANGAN</th>
    </tr>
    <tr>
        <td colspan="2"><b>Gangguan Pertumbuhan :</b></td>
        <td colspan="4"><?= ($asesmen->gangguan_pertumbuhan ?? '-') ?></td>
        <td colspan="2"><b>Gangguan Perkembangan :</b></td>
        <td colspan="4"><?= ($asesmen->gangguan_perkembangan ?? '-') ?></td>
    </tr>

    <tr>
        <th class="text-left bg-lightblue" colspan="12" style="text-align:left">N. KEBUTUHAN KOMUNIKASI EDUKASI</th>
    </tr>
    <tr>
        <td colspan="2"><b>Hambatan dalam pembelajaran :</b></td>
        <td colspan="4"><?= ($asesmen->hambatan_dalam_pembelajaran ?? '-') ?></td>
        <td colspan="2"><b>Butuh Penerjemah :</b></td>
        <td colspan="4"><?= ($asesmen->dibutuhkan_penerjamah ?? '-') ?></td>
    </tr>
    <tr>
        <td colspan="2"><b>Bahasa Isyarat :</b></td>
        <td colspan="4"><?= ($asesmen->bahasa_isyarat ?? '-') ?></td>
        <td colspan="2"><b>Kebutuhan Edukasi :</b></td>
        <td colspan="4"><?= ($asesmen->kebutuhan_edukasi ?? '-') ?></td>
    </tr>

    <tr>
        <th class="text-left bg-lightblue" colspan="12" style="text-align:left">O. PERENCANAAN PASIEN PULANG</th>
    </tr>
    <tr>
        <td colspan="12"><?= ($asesmen->perencanaan_pasien_pulang ?? '-') ?></td>
    </tr>

    <tr style="height: 200px; margin: 0; padding: 0;">
        <td colspan="12"><br /><br /><br /><br /><br /><br /><b><?= $asesmen->perawat->nama_lengkap ?? '-' ?></b><br><u><?= $asesmen->perawat->id_nip_nrp ?? '-' ?></u></td>
    </tr>


</table>