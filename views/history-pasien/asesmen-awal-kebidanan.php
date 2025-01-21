<?php

use app\models\medis\AsesmenAwalKebidanan;
use app\models\medis\AsesmenAwalKeperawatanGeneral;
use app\models\pendaftaran\Pasien;
use app\models\pendaftaran\Registrasi;
use PHPUnit\Util\Annotation\Registry;
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
if ($is_ajax == true) {
    echo $this->render('doc_kop', ['pasien' => $pasien]);
} else {
    echo $this->render('doc_kop_v2', ['pasien' => $pasien]);
} ?>


<h2>Asesmen Awal Kebidanan</h2>
<table class="table table-sm table-form" style="border: 2px solid;">
    <tr>
        <th class="text-left bg-lightblue" colspan="12" style="text-align:left">I. ANAMNESIS</th>
    </tr>
    <tr style="width: 100%;border: none">
        <td style="width: 9%;border: none"></td>
        <td style="width: 9%;border: none"></td>
        <td style="width: 9%;border: none"></td>
        <td style="width: 9%;border: none"></td>
        <td style="width: 8%;border: none"></td>
        <td style="width: 8%;border: none"></td>
        <td style="width: 8%;border: none"></td>
        <td style="width: 8%;border: none"></td>
        <td style="width: 8%;border: none"></td>
        <td style="width: 8%;border: none"></td>
        <td style="width: 8%;border: none"></td>
        <td style="width: 8%;border: none"></td>
    </tr>
    <tr>
        <td colspan="2" style="vertical-align:top ;"><b>Sumber Anamnesis :</b></td>

        <td colspan="4"><?= ($asesmen->anamnesis_sumber ?? '-') ?></td>

        <td colspan="2" style="vertical-align:top ;"><b>Keluhan Utama :</b></td>
        <td colspan="4"><?= ($asesmen->anamnesis_keluhan ?? '-') ?></td>
    </tr>
    <tr>
        <td colspan="2" style="vertical-align:top ;"><b>Riwayat Penyakit Sekarang :</b></td>
        <td colspan="4"><?= ($asesmen->riwayat_penyakit_sekarang ?? '-') ?></td>

        <td colspan="2" style="vertical-align:top ;"><b>Riwayat Penyakit Dahulu :</b></td>
        <td colspan="4"><?= ($asesmen->riwayat_penyakit_dahulu ?? '-') ?></td>
    </tr>
    <tr>
        <td colspan="2" style="vertical-align:top ;"><b>Riwayat Pengobatan TB :</b></td>
        <td colspan="4"><?= ($asesmen->riwayat_pengobatan_tb ?? '-') ?></td>

        <td colspan="2" style="vertical-align:top ;"><b>Riwayat Pengobatan Lain :</b></td>
        <td colspan="4"><?= ($asesmen->riwayat_pengobatan_lain ?? '-') ?></td>
    </tr>
    <tr>
        <td colspan="2" style="vertical-align:top ;"><b>Riwayat Penyakit Keluarga :</b></td>
        <td colspan="4"><?= ($asesmen->riwayat_penyakit_keluarga ?? '-') ?></td>

        <td colspan="2" style="vertical-align:top ;"><b>Alergi :</b></td>
        <td colspan="4"><?= ($asesmen->alergi ?? '-') ?></td>
    </tr>
    <tr>
        <td colspan="2" style="vertical-align:top ;"><b>Status Sosial :</b></td>
        <td colspan="4"><?= ($asesmen->status_sosial ?? '-') ?></td>

        <td colspan="2" style="vertical-align:top ;"><b>Status Mental :</b></td>
        <td colspan="4"><?= ($asesmen->status_mental ?? '-') ?></td>
    </tr>
    <tr>
        <td colspan="2" style="vertical-align:top ;"><b>Ekonomi :</b></td>
        <td colspan="4"><?= ($asesmen->ekonomi ?? '-') ?></td>

        <td colspan="2" style="vertical-align:top ;"><b>Imunisasi/Tumbuh Kembang :</b></td>
        <td colspan="4"><?= ($asesmen->imunisasi ?? '-') ?></td>
    </tr>
    <tr>
        <td colspan="2" style="vertical-align:top ;"><b>Riwayat Prilaku Kekerasan :</b></td>
        <td colspan="4"><?= ($asesmen->riwayat_perilaku_kekerasan ?? '-') ?></td>

        <td colspan="2" style="vertical-align:top ;"><b>Ketergantungan Obat :</b></td>
        <td colspan="4"><?= ($asesmen->ketergantungan_obat ?? '-') ?></td>
    </tr>
    <tr>
        <td colspan="2" style="vertical-align:top ;"><b>Ketergantungan Alkohol :</b></td>
        <td colspan="4"><?= ($asesmen->ketergantungan_alkohol ?? '-') ?></td>

        <td colspan="2" style="vertical-align:top ;"><b>Permintaan Informasi Adanya Pelayanan Spiritual :</b></td>
        <td colspan="4"><?= ($asesmen->permintaan_informasi ?? '-') ?></td>
    </tr>
    <tr>
        <td colspan="2" style="vertical-align:top ;"><b>Status Psikologis :</b></td>
        <td colspan="4"><?= ($asesmen->status_psikologi ?? '-') ?></td>
    </tr>
    <tr>
        <th class="text-left bg-lightblue" colspan="12" style="text-align:left">II. RIWAYAT PERKAWINAN</th>
    </tr>
    <tr>
        <td colspan="4"><b>Perkawinan Ke : </b></td>
        <td colspan="4"><b>Lama Perkawinan(tahun) : </b></td>
        <td colspan="4"><b>Usia Saat Perkawinan(tahun) :</b></td>
    </tr>
    <tr>
        <td colspan="4"><?= ($asesmen->riwayat_perkawinan_ke ?? '-') ?></td>
        <td colspan="4"><?= ($asesmen->riwayat_perkawinan_lama_kawin_thn ?? '-') ?></td>
        <td colspan="4"><?= ($asesmen->riwayat_perkawinan_usia_kawin_thn ?? '-') ?></td>
    </tr>
    <tr>
        <th class="text-left bg-lightblue" colspan="12" style="text-align:left">III. RIWAYAT HAID</th>
    </tr>
    <tr>
        <td colspan="2"><b>Menarche umur(tahun) : </b></td>
        <td><b>Haid : </b></td>
        <td colspan="2"><b>Siklus haid (hari) : </b></td>
        <td colspan="2"><b>Kelainan haid :</b></td>
        <td><b>Fluor albus :</b></td>
        <td><b>HPHT :</b></td>
        <td colspan="3"><b>Perkiraan partus :</b></td>

    </tr>
    <tr>
        <td colspan="2"><?= ($asesmen->riwayat_perkawinan_usia_kawin_thn ?? '-') ?></td>
        <td><?= ($asesmen->riwayat_haid_haid ?? '-') ?></td>
        <td colspan="2"><?= ($asesmen->riwayat_haid_siklus_haid_hari ?? '-') ?></td>
        <td colspan="2"><?= ($asesmen->riwayat_haid_kelainan_haid ?? '-') ?></td>
        <td><?= ($asesmen->riwayat_haid_fluor_albus ?? '-') ?></td>
        <td><?= ($asesmen->riwayat_haid_hpht ?? '-') ?></td>
        <td colspan="3"><?= ($asesmen->riwayat_haid_perkiraan_partus ?? '-') ?></td>

    </tr>
    <tr>
        <th class="text-left bg-lightblue" colspan="12" style="text-align:left">IV. RIWAYAT KEHAMILAN,PERSALINAN DAN NIFAS YANG LALU</th>
    </tr>
    <tr>
        <td><b>No</b></td>
        <td><b>Tgl/Thn</b></td>
        <td><b>Usia Kehamilan</b></td>
        <td><b>Tempat</b></td>
        <td><b>Penyulit</b></td>
        <td><b>Jenis Tindakan</b></td>
        <td><b>Penolong</b></td>
        <td><b>Jenis Kelamin</b></td>
        <td><b>BB (Gram)</b></td>
        <td colspan="2"><b>Keterangan Anak Skrg</b></td>
        <td><b>Keterangan</b></td>

    </tr>
    <?php foreach ($asesmenRiwayatKehamilan as $key => $item) { ?>
        <tr>
            <td><?= ($key + 1) ?></td>
            <td><?= ($item->tanggal ?? '-') ?></td>
            <td><?= ($item->usia_kehamilan ?? '-') ?></td>
            <td><?= ($item->tempat ?? '-') ?></td>
            <td><?= ($item->penyulit ?? '-') ?></td>
            <td><?= ($item->tindakan ?? '-') ?></td>
            <td><?= ($item->penolong ?? '-') ?></td>
            <td><?= ($item->jk ?? '-') ?></td>
            <td><?= ($item->bb_gram ?? '-')  ?></td>
            <td colspan="2"><?= ($item->ket_anak_skrg ?? '-') ?></td>
            <td><?= ($item->ket ?? '-') ?></td>


        </tr><?php } ?>
    <tr>
    <tr>
        <th class="text-left bg-lightblue" colspan="12" style="text-align:left">V. RIWAYAT KEHAMILAN INI</th>
    </tr>
    <tr>
        <td><b>G :</b></td>
        <td><b>P :</b></td>
        <td><b>A :</b></td>
        <td><b>H :</b></td>
        <td colspan="2"><b>Awal pemeriksaan pada usia kehamilan(minggu):</b></td>
        <td><b>Tempat :</b></td>
        <td colspan="2"><b>Masalah yang pernah dialami selama kehamilan :</b></td>
        <td><b>Tanda-tanda bahaya/penyulit:</b></td>
        <td colspan="2"><b>Usia kehamilan dari HPHT(minggu):</b></td>
    </tr>
    <tr>
        <td><?= ($asesmen->rhamil_g ?? '-') ?></td>
        <td><?= ($asesmen->rhamil_p ?? '-') ?></td>
        <td><?= ($asesmen->rhamil_a ?? '-') ?></td>
        <td><?= ($asesmen->rhamil_h ?? '-') ?></td>
        <td colspan="2"><?= ($asesmen->rhamil_usia_kehamilan_pemeriksaan_awal_minggu ?? '-') ?></b></td>
        <td><?= ($asesmen->rhamil_tempat_pemeriksaan_awal ?? '-') ?></td>
        <td colspan="2"><?= ($asesmen->rhamil_masalah_selama_hamil ?? '-') ?></td>
        <td><?= ($asesmen->rhamil_tanda_bahaya ?? '-') ?></td>
        <td colspan="2"><?= ($asesmen->rhamil_usia_kehamilan_hpht_minggu ?? '-') ?></td>
    </tr>
    <tr>
        <th class="text-left bg-lightblue" colspan="12" style="text-align:left">VI. RIWAYAT PERSALINAN SEKARANG</th>
    </tr>
    <tr>
        <td colspan="2"><b>Tempat Melahirkan :</b></td>
        <td colspan="2"><b>Penolong persalinan :</b></td>
        <td colspan="2"><b>Jenis persalinan :</b></td>
        <td colspan="2"><b>K.ketuban :</b></td>
        <td colspan="2"><b>Ket K.ketuban :</b><?= ($asesmen->rpersalinan_keadaan_ketuban_ket ?? '-') ?></td>
        <td colspan="3"><b>Warna air ketuban :</b><?= ($asesmen->rpersalinan_warna_air_ketuban ?? '-') ?></td>

    </tr>
    <tr>
        <td colspan="2"><?= ($asesmen->rpersalinan_tempat_melahirkan ?? '-') ?></td>
        <td colspan="2"><?= ($asesmen->rpersalinan_penolong_lahiran ?? '-') ?></td>
        <td colspan="2"><?= ($asesmen->rpersalinan_jenis_persalinan ?? '-') ?></td>
        <td colspan="2"><?= ($asesmen->rpersalinan_keadaan_ketuban ?? '-') ?></td>
        <td colspan="2"><?= ($asesmen->rpersalinan_keadaan_ketuban_ket ?? '-') ?></td>
        <td colspan="3"><?= ($asesmen->rpersalinan_warna_air_ketuban ?? '-') ?></td>

    </tr>
    <tr>
        <td colspan="3"><b>Kala I :</b></td>
        <td colspan="3"><b>Kala II :</b></td>
        <td colspan="3"><b>Kala III :</b></td>
        <td colspan="3"><b>Keadaan perineum :</b></td>

    </tr>
    <tr>
        <td colspan="3"><?= ($asesmen->rpersalinan_lama_persalinan_kala1 ?? '-') ?></td>
        <td colspan="3"><?= ($asesmen->rpersalinan_lama_persalinan_kala2 ?? '-') ?></td>
        <td colspan="3"><?= ($asesmen->rpersalinan_lama_persalinan_kala3 ?? '-') ?></td>
        <td colspan="3"><?= ($asesmen->rpersalinan_keadaan_perineum ?? '-') ?></td>

    </tr>
    <tr>
        <td colspan="6"><b>Komplikasi persalinan :</b></td>
        <td colspan="6"><b>Komplikasi persalinan lainya:</b></td>

    </tr>
    <tr>
        <td colspan="6"><?= ($asesmen->rpersalinan_komplikasi_persalinan ?? '-') ?></td>
        <td colspan="6"><?= ($asesmen->rpersalinan_komplikasi_persalinan_lainya ?? '-') ?></td>

    </tr>
    <tr>
        <td colspan="3"><b>Tgl.Lahir Bayi :</b></td>
        <td colspan="3"><b>JK bayi :</b></td>
        <td colspan="3"><b>BB bayi(gram) :</b></td>
        <td colspan="3"><b>PB bayi(cm) :</b></td>


    </tr>
    <tr>
        <td colspan="3"><?= ($asesmen->rpersalinan_bayi_tanggal ?? '-') ?></td>
        <td colspan="3"><?= ($asesmen->rpersalinan_bayi_jk ?? '-') ?></td>
        <td colspan="3"><?= ($asesmen->rpersalinan_bayi_bb_gram ?? '-') ?></td>
        <td colspan="3"><?= ($asesmen->rpersalinan_bayi_pb_cm ?? '-') ?></td>

    </tr>
    <tr>
        <td colspan="3"><b>M.gestasi(mnggu) :</b></td>
        <td colspan="3"><b>Anus bayi:</b></td>
        <td colspan="3"><b>Cacat bawaan bayi :</b></td>
        <td colspan="3"><b>Masalah bayi :</b></td>


    </tr>
    <tr>
        <td colspan="3"><?= ($asesmen->rpersalinan_bayi_masa_gestasi_minggu ?? '-') ?></td>
        <td colspan="3"><?= ($asesmen->rpersalinan_bayi_anus ?? '-') ?></td>
        <td colspan="3"><?= ($asesmen->rpersalinan_bayi_cacat_bawaan ?? '-') ?></td>
        <td colspan="3"><?= ($asesmen->rpersalinan_bayi_masalah ?? '-') ?></td>

    </tr>

    <tr>
        <th class="text-left bg-lightblue" colspan="12" style="text-align:left">VII. RIWAYAT BERHUBUNGAN DENGAN MASALAH KESEHAN REPRODUKSI</th>
    </tr>
    <tr>
        <td colspan="6"><b>Masalah : </b></td>
        <td colspan="6"><b>Masalah lainya: </b></td>
    </tr>
    <tr>
        <td colspan="6"><?= ($asesmen->rkesehatan_reproduksi ?? '-') ?></td>
        <td colspan="6"><?= ($asesmen->rkesehatan_reproduksi_lainya ?? '-') ?></td>
    </tr>
    <tr>
        <th class="text-left bg-lightblue" colspan="12" style="text-align:left">VIII. RIWAYAT KELUARGA BERENCANA</th>
    </tr>
    <tr>
        <td colspan="2"><b>Pernah jadi peserta KB: </b></td>
        <td colspan="3"><b>Metode KB: </b></td>
        <td colspan="2"><b>Lamanya : </b></td>
        <td colspan="3"><b>Komplikasi/Masalah :</b></td>
        <td colspan="2"><b>Lain-lainnya :</b></td>

    </tr>
    <tr>
        <td colspan="2"><?= ($asesmen->rkb_pernah_kb ?? '-') ?></td>
        <td colspan="3"><?= ($asesmen->rkb_metode_kb ?? '-') ?></td>
        <td colspan="2"><?= ($asesmen->rkb_lama_kb ?? '-') ?></td>
        <td colspan="3"><?= ($asesmen->rkb_komplikasi_kb ?? '-') ?></td>
        <td colspan="2"><?= ($asesmen->rkb_lainnya ?? '-') ?></td>
    </tr>
    <tr>
        <th class="text-left bg-lightblue" colspan="12" style="text-align:left">IX. PEMERIKSAAN TANDA VITAL</th>
    </tr>
    <tr>
        <td><b>GCS E : </b><?= ($asesmen->gcs_e ?? '-') ?></td>
        <td><b>GCS M : </b><?= ($asesmen->gcs_m ?? '-') ?></td>
        <td><b>GCS V : </b><?= ($asesmen->gcs_v ?? '-') ?></td>
        <td colspan="2"><b>Nadi(x/menit) : </b><?= ($asesmen->nadi ?? '-') ?></td>
        <td colspan="2"><b>TD(mmHg) : </b><?= ($asesmen->darah ?? '-') ?></td>
        <td colspan="3"><b>Pernapasan(x/menit) : </b><?= ($asesmen->pernapasan ?? '-') ?></td>
        <td colspan="2"><b>Suhu(C) : </b><?= ($asesmen->suhu ?? '-') ?></td>

    </tr>
    <tr>
        <td colspan="2"><b>SatO2(%) :</b><?= ($asesmen->sato2 ?? '-') ?></td>
        <td colspan="4"><b>Sikap Tubuh :</b><?= ($asesmen->sikap_tubuh ?? '-') ?></td>
        <td colspan="3"><b>Tingkat Kesadaran :</b><?= ($asesmen->tingkat_kesadaran ?? '-') ?></td>
    </tr>
    <tr>
        <th class="bg-lightblue" colspan="12" style="text-align:left">X. PEMERIKSAAN ANTROPOMETRI</th>
    </tr>
    <tr>
        <td colspan="3"><b>TB (Cm) : </b><?= ($asesmen->tinggi_badan ?? '-') ?></td>
        <td colspan="3"><b>BB Skrg(Kg) : </b><?= ($asesmen->berat_badan ?? '-') ?></td>
        <td colspan="3"><b>BB Sebelum Sakit (Kg) : </b><?= ($asesmen->berat_badan_sebelum ?? '-') ?></td>
        <td colspan="3"><b>IMT : </b><?= ($asesmen->imt ?? '-') ?></td>


    </tr>
    <tr>
        <td colspan="2"><b>LILA (cm) : </b><?= ($asesmen->lila ?? '-') ?></td>
        <td colspan="3"><b>Terjadi Penurunan BB : </b><?= ($asesmen->penurunan_bb ?? '-') ?></td>
        <td colspan="3"><b>Skoring Penurunan BB : </b><?= ($asesmen->skor_penurunan_bb ?? '-') ?></td>
    </tr>
    <tr>
        <th class="text-left bg-lightblue" colspan="6" style="text-align:left">XI. PEMERIKSAAN KULIT & KELAMIN</th>
        <th class="text-left bg-lightblue" colspan="6" style="text-align:left">XII. PEMERIKSAAN KEPALA & LEHER</th>
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
        <td colspan="4"><?= ($asesmen->anamnesis_keluhan ?? '-') ?></td>
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
        <th class="text-left bg-lightblue" colspan="6" style="text-align:left">XIII. PEMERIKSAAN RESPIRASI</th>
        <th class="text-left bg-lightblue" colspan="6" style="text-align:left">XIV. PEMERIKSAAN KARDIOVASKULER</th>
    </tr>
    <tr>
        <td colspan="2"><b>Suara Nafas :</b></td>
        <td colspan="4"><?= ($asesmen->respirasi_suara_napas ?? '-') ?></td>
        <td colspan="2"><b>Ictus cordis :</b></td>
        <td colspan="4"><?= ($asesmen->kardiovaskular_ictus ?? '-') ?></td>
    </tr>
    <tr>
        <td colspan="2"><b>Pola Nafas :</b></td>
        <td colspan="4"><?= ($asesmen->respirasi_pola_napas ?? '-') ?></td>
        <td colspan="2"><b>Bunyi Jantung :</b></td>
        <td colspan="4"><?= ($asesmen->kardiovaskular_jantung ?? '-') ?></td>
    </tr>
    <tr>
        <td colspan="2"><b>Nafas Cuping Hidung :</b></td>
        <td colspan="4"><?= ($asesmen->respirasi_napas_cuping ?? '-') ?></td>
        <td colspan="2"><b>JVP :</b></td>
        <td colspan="4"><?= ($asesmen->kardiovaskular_jvp ?? '-') ?></td>
    </tr>
    <tr>
        <td colspan="2"><b>Retraksi Dada :</b></td>
        <td colspan="4"><?= ($asesmen->respirasi_otot_bantu ?? '-') ?></td>
        <td colspan="2"><b>EKG :</b></td>
        <td colspan="4"><?= ($asesmen->kardiovaskular_ekg ?? '-') ?></td>
    </tr>
    <tr>
        <td colspan="2"><b>Clubing Finger :</b></td>
        <td colspan="4"><?= ($asesmen->respirasi_clubing_finger ?? '-') ?></td>
        <td colspan="2"><b>CTR (persen):</b></td>
        <td colspan="4"><?= ($asesmen->kardiovaskular_ctr ?? '-') ?></td>
    </tr>
    <tr>
        <td colspan="2"><b>Terpasang Alat :</b></td>
        <td colspan="4"><?= ($asesmen->respirasi_terpasang_alat ?? '-') ?></td>
        <td colspan="2"><b>ECHO :</b></td>
        <td colspan="4"><?= ($asesmen->kardiovaskular_echo ?? '-') ?></td>
    </tr>
    <tr>
        <th class="text-left bg-lightblue" colspan="6" style="text-align:left">XV. PEMERIKSAAN PERSEPSI SENSORI</th>
        <th class="text-left bg-lightblue" colspan="6" style="text-align:left">XVI. PEMERIKSAAN NEUROLOGIS</th>
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
        <th class="text-left bg-lightblue" colspan="6" style="text-align:left">XVII. PEMERIKSAAN ELIMINASI</th>
        <th class="text-left bg-lightblue" colspan="6" style="text-align:left">XVIII. PEMERIKSAAN GENETALIA</th>
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
        <th class="text-left bg-lightblue" colspan="6" style="text-align:left">XIX. PEMERIKSAAN GASTROINTESTINAL</th>
        <th class="text-left bg-lightblue" colspan="6" style="text-align:left">XX. PEMERIKSAAN EXTREMITAS</th>
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
        <th class="text-left bg-lightblue" colspan="6" style="text-align:left">XXI. PEMERIKSAAN FISIK LAINNYA</th>
        <th class="text-left bg-lightblue" colspan="6" style="text-align:left">XXII. PEMERIKSAAN DALAM</th>
    </tr>
    <tr>
        <td colspan="2"><b>Payudara :</b></td>
        <td colspan="4"><?= ($asesmen->bentuk_payudara ?? '-') ?></td>
        <td colspan="2"><b>Indikasi:</b></td>
        <td colspan="4"><?= ($asesmen->vt_idikasi ?? '-') ?></td>
    </tr>
    <tr>
        <td colspan="2"><b>Puting susu :</b></td>
        <td colspan="4"><?= ($asesmen->puting_susu ?? '-') ?></td>
        <td colspan="2"><b>Portio konsistensi :</b></td>
        <td colspan="4"><?= ($asesmen->vt_portio_konsistensi ?? '-') ?></td>
    </tr>
    <tr>
        <td colspan="2"><b>Areola mammae :</b></td>
        <td colspan="4"><?= ($asesmen->areola_mammae ?? '-') ?></td>
        <td colspan="2"><b>Portio Pendataran :</b></td>
        <td colspan="4"><?= ($asesmen->vt_portio_pendataran ?? '-') ?></td>
    </tr>
    <tr>
        <td colspan="2"><b>Pengeluaran ASI(Kolostrum) :</b></td>
        <td colspan="4"><?= ($asesmen->pengeluaran_asi ?? '-') ?></td>
        <td colspan="2"><b>Pembukaan(cm):</b></td>
        <td colspan="4"><?= ($asesmen->vt_portio_pembukaan ?? '-') ?></td>
    </tr>
    <tr>
        <td colspan="2"><b>Abdomen, bekas operasi :</b></td>
        <td colspan="4"><?= ($asesmen->abdomen_bekas_operasi ?? '-') ?></td>
        <td colspan="2"><b>Ketuban :</b></td>
        <td colspan="4"><?= ($asesmen->vt_ketuban ?? '-') ?></td>
    </tr>
    <tr>
        <td colspan="2"><b>Palpasi Atas:</b></td>
        <td colspan="4"><?= ($asesmen->palpasi_atas ?? '-') ?></td>
        <td colspan="2"><b>Presentase :</b></td>
        <td colspan="4"><?= ($asesmen->vt_presentase ?? '-') ?></td>
    </tr>
    <tr>
        <td colspan="2"><b>Palpasi Samping:</b></td>
        <td colspan="4"><?= ($asesmen->palpasi_samping ?? '-') ?></td>
        <td colspan="2"><b>Posisi:</b></td>
        <td colspan="4"><?= ($asesmen->vt_posisi ?? '-') ?></td>
    </tr>
    <tr>
        <td colspan="2"><b>Palpasi Bawah:</b></td>
        <td colspan="4"><?= ($asesmen->palpasi_bawah ?? '-') ?></td>
        <td colspan="2"><b>Penurunan :</b></td>
        <td colspan="4"><?= ($asesmen->vt_penurunan ?? '-') ?></td>
    </tr>
    <tr>
        <td colspan="2"><b>Palpasi TBJ (gram):</b></td>
        <td colspan="4"><?= ($asesmen->palpasi_tbj ?? '-') ?></td>
        <td colspan="2"><b>Lain-lain:</b></td>
        <td colspan="4"><?= ($asesmen->vt_lainya ?? '-') ?></td>
    </tr>
    <tr>
        <td colspan="2"><b>Auskultasi DJJ (x/m):</b></td>
        <td colspan="4"><?= ($asesmen->auskultasi_nilai_djj ?? '-') ?></td>
        <td colspan="2"></td>
        <td colspan="4"></td>
    </tr>
    <tr>
        <td colspan="2"><b>Perkusi Reflek Patela Kanan:</b></td>
        <td colspan="4"><?= ($asesmen->perkusi_refleks_patela_kanan ?? '-') ?></td>
        <td colspan="2"></td>
        <td colspan="4"></td>
    </tr>
    <tr>
        <td colspan="2"><b>Perkusi Reflek Patela Kiri:</b></td>
        <td colspan="4"><?= ($asesmen->perkusi_refleks_patela_kiri ?? '-') ?></td>
        <td colspan="2"></td>
        <td colspan="4"></td>
    </tr>
    <tr>
        <th class="text-left bg-lightblue" colspan="12" style="text-align:left">XXIII. PERTUMBUHAN & PERKEMBANGAN</th>
    </tr>
    <tr>
        <td colspan="2"><b>Gangguan Pertumbuhan :</b></td>
        <td colspan="4"><?= ($asesmen->gangguan_pertumbuhan ?? '-') ?></td>
        <td colspan="2"><b>Gangguan Perkembangan :</b></td>
        <td colspan="4"><?= ($asesmen->gangguan_perkembangan ?? '-') ?></td>
    </tr>
    <tr>
        <th class="text-left bg-lightblue" colspan="12" style="text-align:left">XXIV. KEBUTUHAN KOMUNIKASI EDUKASI</th>
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
        <th class="text-left bg-lightblue" colspan="12" style="text-align:left">XXV. PERENCANAAN PASIEN PULANG</th>
    </tr>
    <tr>
        <td colspan="12"><?= ($asesmen->perencanaan_pasien_pulang ?? '-') ?></td>
    </tr>
    <tr>
        <th class="text-left bg-lightblue" colspan="12" style="text-align:left">XXVI. HAL-HAL YANG MASIH PERLU DIKAJI(TETAPI TIDAK TERCANTUM DALAM FORMAT)</th>
    </tr>
    <tr>
        <td colspan="12"><?= ($asesmen->hal_hal_lain ?? '-') ?></td>
    </tr>
    <tr>
        <th class="text-left bg-lightblue" colspan="12" style="text-align:left">XXVII. KESIMPULAN/DIAGNOSA ATAU MASALAH</th>
    </tr>
    <tr>
        <td colspan="12"><?= ($asesmen->kesimpulan ?? '-') ?></td>
    </tr>
    <tr>
        <th class="text-left bg-lightblue" colspan="12" style="text-align:left">XXVIII. PENATALAKSANAAN</th>
    </tr>
    <tr>
        <td colspan="12"><?= ($asesmen->penatalaksanaan ?? '-') ?></td>
    </tr>

    <tr style="height: 200px; margin: 0; padding: 0;">
        <td colspan="12"><?= !empty($asesmen->tanggal_final) ? 'Tanggal Final : ' . $asesmen->tanggal_final : 'Tanggal Buat : ' . $asesmen->created_at ?><br />Perawat<br /><br /><br /><br /><br /><b><?= $asesmen->perawat->nama_lengkap ?? '-' ?></b><br><u><?= $asesmen->perawat->id_nip_nrp ?? '-' ?></u></td>
    </tr>
</table>