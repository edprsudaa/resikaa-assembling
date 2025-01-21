<?php

use app\components\HelperSpesial;
use app\components\HelperSpesialClass;
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

<?= $this->render('doc_kop', ['pasien' => $pasien]);

// echo '<pre>';
// print_r($asesmen);
?>
<h4 style="text-align: center;font-weight:bold">FORMULIR A (EVALUASI AWAL MPP)</h4>
<table border="1">
    <thead>
        <tr>
            <th style="width: 150px;">Tanggal/Jam</th>
            <th style="width: 200px;">Kegiatan</th>
            <th style="width: 450px;">Catatan</th>

        </tr>
    </thead>
    <tbody>
        <tr>
            <td rowspan="58" style="vertical-align: top;text-align: left;"> <?= $skriningPasienMpp['created_at'] ?></td>
            <td colspan="2" style="width: 400px;"><b>A. ASESMEN</b></td>

        </tr>
        <tr>

            <td style="width: 400px;"><i class="fa fa-caret-right"></i> Fisik, Fungsional, Kognitif, Kekuatan, Kemandirian</td>
            <td style="width: 450px;"><?= $skriningPasienMpp['fisik_fungsional_kognitif_kekuatan_mandiri'] ?? '' ?></td>

        </tr>
        <tr>

            <td style="width: 400px;"><i class="fa fa-caret-right"></i> Riwayat Kesehatan</td>
            <td style="width: 450px;"><?= $skriningPasienMpp['riwayat_kesehatan'] ?? '' ?></td>

        </tr>
        <tr>

            <td style="width: 400px;"><i class="fa fa-caret-right"></i> Perilaku Psikososio Kultural</td>
            <td style="width: 450px;"><?= $skriningPasienMpp['perilaku_psikososio_kultural'] ?? '' ?></td>

        </tr>
        <tr>

            <td style="width: 400px;"><i class="fa fa-caret-right"></i> Kesehatan Mental</td>
            <td style="width: 450px;"><?= $skriningPasienMpp['kesehatan_mental'] ?? '' ?></td>

        </tr>
        <tr>

            <td style="width: 400px;"><i class="fa fa-caret-right"></i> Dukungan Keluarga dan Kemampuan Merawat</td>
            <td style="width: 450px;"><?= $skriningPasienMpp['dukungan_keluarga_kemampuan_merawat'] ?? '' ?></td>

        </tr>
        <tr>

            <td style="width: 400px;"><i class="fa fa-caret-right"></i> finansial / Status Asuransi</td>
            <td style="width: 450px;"><?= $skriningPasienMpp['finansial_status_asuransi'] ?? '' ?></td>

        </tr>
        <tr>

            <td style="width: 400px;"><i class="fa fa-caret-right"></i> Riwayat Penggunaan Obat, Alternatif Pengobatan</td>
            <td style="width: 450px;"><?= $skriningPasienMpp['riwayat_penggunaan_obat_alternatif_pengobatan'] ?? '' ?></td>

        </tr>
        <tr>

            <td style="width: 400px;"><i class="fa fa-caret-right"></i> Riwayat trauma atau kekerasan</td>
            <td style="width: 450px;"><?= $skriningPasienMpp['riwayat_trauma_kekerasan'] ?? '' ?></td>

        </tr>
        <tr>

            <td style="width: 400px;"><i class="fa fa-caret-right"></i> Pemahaman Tentang Kesehatan</td>
            <td style="width: 450px;"><?= $skriningPasienMpp['pemahaman_tentang_kesehatan'] ?? '' ?></td>

        </tr>
        <tr>

            <td style="width: 400px;"><i class="fa fa-caret-right"></i> Harapan terhadap hasil asuhan atau kemampuan untuk menerima perubahan</td>
            <td style="width: 450px;"><?= $skriningPasienMpp['harapan_hasil_asuhan_kemampuan_menerima_perubahan'] ?? '' ?></td>

        </tr>
        <tr>

            <td style="width: 400px;"><i class="fa fa-caret-right"></i> Aspek Legalitas</td>
            <td style="width: 450px;"><?= $skriningPasienMpp['aspek_legalitas'] ?? '' ?></td>

        </tr>
        <tr>

            <td style="width: 400px;"><i class="fa fa-caret-right"></i> Lainnya</td>
            <td style="width: 450px;"><?= $skriningPasienMpp['asesmen_lainnya'] ?? '' ?></td>

        </tr>
        <tr>

            <td colspan="2" style="width: 400px;"><b>B. IDENTIFIKASI MASALAH</b></td>

        </tr>
        <tr>

            <td style="width: 400px;"><i class="fa fa-caret-right"></i> Asuhan yang tidak sesuai panduan</td>
            <td style="width: 450px;"><?= $skriningPasienMpp['asuhan_tidak_sesuai_panduan'] ?? '' ?></td>

        </tr>
        <tr>

            <td style="width: 400px;"><i class="fa fa-caret-right"></i> Over/under Utilization pelayanan dengan dasar panduan</td>
            <td style="width: 450px;"><?= $skriningPasienMpp['over_under_utilization_pelayanan_dasar_panduan'] ?? '' ?></td>

        </tr>
        <tr>

            <td style="width: 400px;"><i class="fa fa-caret-right"></i> Ketidakpatuhan Pasien</td>
            <td style="width: 450px;"><?= $skriningPasienMpp['ketidakpatuhan_pasien'] ?? '' ?></td>

        </tr>
        <tr>

            <td style="width: 400px;"><i class="fa fa-caret-right"></i> Edukasi kurang memadai tentang penyakit, kondisi kini, obat, nutrisi</td>
            <td style="width: 450px;"><?= $skriningPasienMpp['edukasi_kurang_memadai_tentang_penyakit_kondisi_kini_obat_nutri'] ?? '' ?></td>

        </tr>
        <tr>

            <td style="width: 400px;"><i class="fa fa-caret-right"></i> Kurang dukungan keluarga</td>
            <td style="width: 450px;"><?= $skriningPasienMpp['kurang_dukungan_keluarga'] ?? '' ?></td>

        </tr>
        <tr>

            <td style="width: 400px;"><i class="fa fa-caret-right"></i> Penurunan Determinasi Pasien (ketika tingkat keparahan / komplikasi meningkat)</td>
            <td style="width: 450px;"><?= $skriningPasienMpp['penurunan_determinasi_pasien'] ?? '' ?></td>

        </tr>
        <tr>

            <td style="width: 400px;"><i class="fa fa-caret-right"></i> Kendala Keuangan</td>
            <td style="width: 450px;"><?= $skriningPasienMpp['kendala_keuangan'] ?? '' ?></td>

        </tr>
        <tr>

            <td style="width: 400px;"><i class="fa fa-caret-right"></i> Pemulangan / Rujukan bermasalah</td>
            <td style="width: 450px;"><?= $skriningPasienMpp['pemulangan_rujukan_bermasalah'] ?? '' ?></td>

        </tr>
        <tr>

            <td style="width: 400px;"><i class="fa fa-caret-right"></i> Lainnya</td>
            <td style="width: 450px;"><?= $skriningPasienMpp['identifikasi_masalah_lainnya'] ?? '' ?></td>

        </tr>
        <tr>

            <td colspan="2" style="width: 400px;"><b>C. PERENCANAAN</b></td>

        </tr>
        <tr>

            <td colspan="2" style="width: 400px;"><i class="fa fa-bookmark"></i><b> Koordinasi dengan DPJP</b></td>

        </tr>
        <tr>

            <td style="width: 400px;"><i class="fa fa-caret-right"></i> Penggunaan alat medis</td>
            <td style="width: 450px;"><?= $skriningPasienMpp['penggunaan_alat_medis'] ?? '' ?></td>

        </tr>
        <tr>

            <td style="width: 400px;"><i class="fa fa-caret-right"></i> Tatalaksana Medis</td>
            <td style="width: 450px;"><?= $skriningPasienMpp['tatalaksana_medis'] ?? '' ?></td>

        </tr>
        <tr>

            <td style="width: 400px;"><i class="fa fa-caret-right"></i> Komplikasi</td>
            <td style="width: 450px;"><?= $skriningPasienMpp['komplikasi'] ?? '' ?></td>

        </tr>
        <tr>

            <td style="width: 400px;"><i class="fa fa-caret-right"></i> Gejala Perburukan</td>
            <td style="width: 450px;"><?= $skriningPasienMpp['gejalan_perburukan'] ?? '' ?></td>

        </tr>
        <tr>

            <td style="width: 400px;"><i class="fa fa-caret-right"></i> Pemeriksaan Diagnostik</td>
            <td style="width: 450px;"><?= $skriningPasienMpp['pemeriksaan_diagnostik'] ?? '' ?></td>

        </tr>
        <tr>

            <td style="width: 400px;"><i class="fa fa-caret-right"></i> Perkembangan Penyakit</td>
            <td style="width: 450px;"><?= $skriningPasienMpp['perkembangan_penyakit'] ?? '' ?></td>

        </tr>
        <tr>

            <td style="width: 400px;"><i class="fa fa-caret-right"></i> Rencana Pengobatan Dirumah</td>
            <td style="width: 450px;"><?= $skriningPasienMpp['rencana_pengobatan_dirumah'] ?? '' ?></td>

        </tr>
        <tr>

            <td colspan="2" style="width: 400px;"><i class="fa fa-bookmark"></i><b> Koordinasi dengan PPA</b></td>

        </tr>
        <tr>

            <td style="width: 400px;"><i class="fa fa-caret-right"></i> Management Nyeri</td>
            <td style="width: 450px;"><?= $skriningPasienMpp['management_nyeri'] ?? '' ?></td>

        </tr>
        <tr>

            <td style="width: 400px;"><i class="fa fa-caret-right"></i> Aktivitas dan Istirahat</td>
            <td style="width: 450px;"><?= $skriningPasienMpp['aktivitas_istirahat'] ?? '' ?></td>

        </tr>
        <tr>

            <td style="width: 400px;"><i class="fa fa-caret-right"></i> Modifikasi Perilaku / Lingkungan</td>
            <td style="width: 450px;"><?= $skriningPasienMpp['modifikasi_perilaku_lingkungan'] ?? '' ?></td>

        </tr>
        <tr>

            <td style="width: 400px;"><i class="fa fa-caret-right"></i> Personal Hygiene</td>
            <td style="width: 450px;"><?= $skriningPasienMpp['personal_hygiene'] ?? '' ?></td>

        </tr>
        <tr>

            <td style="width: 400px;"><i class="fa fa-caret-right"></i> Management Resiko Jatuh</td>
            <td style="width: 450px;"><?= $skriningPasienMpp['management_resiko_jatuh'] ?? '' ?></td>

        </tr>
        <tr>

            <td style="width: 400px;"><i class="fa fa-caret-right"></i> Perawatan luka</td>
            <td style="width: 450px;"><?= $skriningPasienMpp['perawatan_luka'] ?? '' ?></td>

        </tr>
        <tr>

            <td style="width: 400px;"><i class="fa fa-caret-right"></i> Management Cemas / Stress</td>
            <td style="width: 450px;"><?= $skriningPasienMpp['management_cemas_stress'] ?? '' ?></td>

        </tr>
        <tr>

            <td style="width: 400px;"><i class="fa fa-caret-right"></i> Pemberian Nutrisi dengan NGT</td>
            <td style="width: 450px;"><?= $skriningPasienMpp['pembrrian_nutrisi_ngt'] ?? '' ?></td>

        </tr>
        <tr>

            <td style="width: 400px;"><i class="fa fa-caret-right"></i> Pemeriksaan Rutin dilakukan</td>
            <td style="width: 450px;"><?= $skriningPasienMpp['pemeriksaan_rutin_dilakukan'] ?? '' ?></td>

        </tr>
        <tr>

            <td colspan="2" style="width: 400px;"><i class="fa fa-bookmark"></i><b> Koordinasi dengan Farmasi</b></td>

        </tr>
        <tr>

            <td style="width: 400px;"><i class="fa fa-caret-right"></i> Obat-obat yang digunakan</td>
            <td style="width: 450px;"><?= $skriningPasienMpp['obat_obatan_yang_digunakan'] ?? '' ?></td>

        </tr>
        <tr>

            <td style="width: 400px;"><i class="fa fa-caret-right"></i> Indikasi Obat</td>
            <td style="width: 450px;"><?= $skriningPasienMpp['indikasi_obat'] ?? '' ?></td>

        </tr>
        <tr>

            <td style="width: 400px;"><i class="fa fa-caret-right"></i> Efek samping Obat</td>
            <td style="width: 450px;"><?= $skriningPasienMpp['efek_samping_obat'] ?? '' ?></td>

        </tr>
        <tr>

            <td style="width: 400px;"><i class="fa fa-caret-right"></i> Cara / Waktu / Lama makan obat</td>
            <td style="width: 450px;"><?= $skriningPasienMpp['cara_waktu_lama_makan_obat'] ?? '' ?></td>

        </tr>
        <tr>

            <td style="width: 400px;"><i class="fa fa-caret-right"></i> Cara mengkonsumsi obat</td>
            <td style="width: 450px;"><?= $skriningPasienMpp['cara_konsumsi_obat'] ?? '' ?></td>

        </tr>
        <tr>

            <td colspan="2" style="width: 400px;"><i class="fa fa-bookmark"></i> <b>Koordinasi dengan PPA lain</b></td>

        </tr>
        <tr>

            <td style="width: 400px;"><i class="fa fa-caret-right"></i> Modifikasi Diet</td>
            <td style="width: 450px;"><?= $skriningPasienMpp['modifikasi_diet'] ?? '' ?></td>

        </tr>
        <tr>

            <td style="width: 400px;"><i class="fa fa-caret-right"></i> Rehabilitation Medis</td>
            <td style="width: 450px;"><?= $skriningPasienMpp['rehabilitation_medis'] ?? '' ?></td>

        </tr>
        <tr>

            <td style="width: 400px;"><i class="fa fa-caret-right"></i> Home Traing</td>
            <td style="width: 450px;"><?= $skriningPasienMpp['home_training'] ?? '' ?></td>

        </tr>
        <tr>

            <td colspan="2" style="width: 400px;"><i class="fa fa-bookmark"></i> <b>Koordinasi dengan Petugas Eksternal</b></td>

        </tr>
        <tr>

            <td style="width: 400px;"><i class="fa fa-caret-right"></i> Laboratorium</td>
            <td style="width: 450px;"><?= $skriningPasienMpp['laboratorium'] ?? '' ?></td>

        </tr>
        <tr>

            <td style="width: 400px;"><i class="fa fa-caret-right"></i> Radiologi</td>
            <td style="width: 450px;"><?= $skriningPasienMpp['radiologi'] ?? '' ?></td>

        </tr>
        <tr>

            <td style="width: 400px;"><i class="fa fa-caret-right"></i> Petugas Asuransi Kesehatan</td>
            <td style="width: 450px;"><?= $skriningPasienMpp['petugas_asuransi_kesehatan'] ?? '' ?></td>

        </tr>
        <tr>

            <td style="width: 400px;"><i class="fa fa-caret-right"></i> Rohaniawan</td>
            <td style="width: 450px;"><?= $skriningPasienMpp['rohaniawan'] ?? '' ?></td>

        </tr>
        <tr>

            <td style="width: 400px;"><i class="fa fa-caret-right"></i> Fasilitas Kesehatan</td>
            <td style="width: 450px;"><?= $skriningPasienMpp['fasilitas_kesehatan'] ?? '' ?></td>

        </tr>
        <tr style="height: 200px; margin: 0; padding: 0;">
            <td colspan="2" style="width:50%"></td>
            <td>Pekanbaru, <?= date('d-m-Y', strtotime($skriningPasienMpp['created_at'])) ?><br />Manager Pelayanan Pasien<br /><br /><br /><br /><br /><b><?= HelperSpesialClass::getNamaPegawaiArray($skriningPasienMpp['mpp']) ?? '-' ?></b><br><u><?= $skriningPasienMpp['mpp']['id_nip_nrp'] ?? '-' ?></u></td>

        </tr>
    </tbody>
</table>