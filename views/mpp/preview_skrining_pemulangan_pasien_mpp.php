<?php

use app\components\HelperSpesial;
use app\components\HelperSpesialClass;
use app\models\medis\AsesmenAwalKeperawatanGeneral;
use app\models\medis\AsesmenAwalMedis;
use app\models\pendaftaran\Pasien;
use yii\helpers\Url;

?>
<style>
    h4 {
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
<h4>SKRINING PEMULANGAN PASIEN MPP<br>(DISCHARGE PLANNING)</h4>
<table border="1">

    <tbody>
        <tr>
            <td colspan="2">Kriteria Discharge Planning</td>
        </tr>
        <tr>
            <td style="width:600px"><i class="fa fa-caret-right"></i> Umur > 65 Tahun</td>
            <td><?= $skriningPasienMpp['umur'] ?></td>
        </tr>
        <tr>
            <td style="width:600px"><i class="fa fa-caret-right"></i> Keterbatasan Mobilitas</td>
            <td><?= $skriningPasienMpp['keterbatasan_mobilitas'] ?></td>
        </tr>
        <tr>
            <td style="width:600px"><i class="fa fa-caret-right"></i> Perawatan dan Pengobatan Lanjutan</td>
            <td><?= $skriningPasienMpp['perawatan_pengobatan_lanjutan'] ?></td>
        </tr>
        <tr>
            <td style="width:600px"><i class="fa fa-caret-right"></i> Bantuan untuk melakukan aktivitas sehari-hari</td>
            <td><?= $skriningPasienMpp['bantuan_aktivitas_sehari_hari'] ?></td>
        </tr>
        <tr>
            <td colspan="2">Bila semua jawaban '<b class="text-black">Tidak</b>' maka tidak memerlukan Manager Pelayanan Pasien <br>
                Bila ada jawaban '<b>Ya</b>' diperlukan Manager Pelayanan Pasien, lanjutkan perencana pulang berikut :</td>
        </tr>
        <tr>
            <td colspan="2">1. Pengaruh Rawat Inap terhadap :</td>
        </tr>
        <tr>
            <td style="width:600px"><i class="fa fa-caret-right"></i> Pasien dan keluarga pasien</td>
            <td><?= $skriningPasienMpp['pengaruh_rawat_inap_pasien_keluarga'] ?></td>
        </tr>
        <tr>
            <td style="width:600px"><i class="fa fa-caret-right"></i> Pekerjaan / Sekolah</td>
            <td><?= $skriningPasienMpp['pengaruh_pekerjaan_sekolah'] ?></td>
        </tr>
        <tr>
            <td style="width:600px"><i class="fa fa-caret-right"></i> Keuangan</td>
            <td><?= $skriningPasienMpp['pengaruh_keuangan'] ?></td>
        </tr>
        <tr>
            <td style="width:600px">2. Antisipasi terhadap masalah saat pulang :</td>
            <td><?= $skriningPasienMpp['antisipasi_masalah_saat_pulang'] ?></td>
        </tr>
        <tr>
            <td style="width:600px">3. Bantuan diperlukan dalam hal :</td>
            <td>

                <ul>
                    <?php
                    $data = json_decode($skriningPasienMpp['bantuan_diperlukan_dalam_hal']);
                    foreach ($data as $item) { ?>
                        <li><?= $item ?></li>
                    <?php } ?>
                </ul>
            </td>
        </tr>
        <tr>
            <td style="width:600px">4. Adakah yang membantu keperluan diatas :</td>
            <td><?= $skriningPasienMpp['membantu_keperluan_diatas'] ?></td>
        </tr>
        <tr>
            <td style="width:600px">5. Apakah pasien tinggal sendiri setelah keluar dari rumah sakit :</td>
            <td><?= $skriningPasienMpp['pasien_tinggal_sendiri_setelah_keluar_rs'] ?></td>
        </tr>
        <tr>
            <td style="width:600px">6. Apakah pasien menggunakan peralatan medis di rumah setelah keluar rumah sakit (Cateter, NGT, Double Lumen, Tracheostomy, Oksigen, Dll) :</td>
            <td><?= $skriningPasienMpp['pasien_gunakan_peralatan_medis_setelah_keluar_rs'] ?></td>
        </tr>
        <tr>
            <td style="width:600px">7. Apakah pasien memerlukan alat bantu setelah keluar rumah sakit (Tongkat, kursi roda, walker Dll) :</td>
            <td><?= $skriningPasienMpp['perlu_alat_bantu_setelah_keluar_rs'] ?></td>
        </tr>
        <tr>
            <td style="width:600px">8. Apakah memerlukan bantuan / perawatan khusus di rumah setelah keluar dari rumah sakit (home care home visit):</td>
            <td><?= $skriningPasienMpp['bantuan_khusus_perawatan_setelah_keluar_rs'] ?></td>
        </tr>
        <tr>
            <td style="width:600px">9. Apakah pasien bermasalah dalam memenuhi kebutuhan pribadinya setelah keluar dari rumah sakit (makan, minum, BAK/BAB, Dll) :</td>
            <td><?= $skriningPasienMpp['masalah_memenuhi_kebutuhan_setelah_keluar_rs'] ?></td>
        </tr>
        <tr>
            <td style="width:600px">10. Apakah pasien memiliki nyeri kronis dan kelelahan setelah keluar rumah sakit :</td>
            <td><?= $skriningPasienMpp['nyeri_kronis_kelelahan_setelah_keluar_rs'] ?></td>
        </tr>
        <tr>
            <td style="width:600px">11. Apakah pasien dan keluarga memerlukan edukasi kesehatan setelah keluar dari rumah sakit (obat-obatan, efek samping obat, nyeri, diit, mencari pertolongan, follow up, dll) :</td>
            <td><?= $skriningPasienMpp['perlu_edukasi_kesehatan_setelah_keluar_rs'] ?></td>
        </tr>
        <tr>
            <td style="width:600px">12. Apakah pasien dan kelurga memerlukan keterampilan khusus setelah keluar dari rumah sakit (perawatan luka, injeksi, perawatan bayi, dll) :</td>
            <td><?= $skriningPasienMpp['perlu_keterampilan_khusus_setelah_keluar_rs'] ?></td>
        </tr>
        <tr style="height: 200px; margin: 0; padding: 0;">
            <td style="width:50%"></td>
            <td>Pekanbaru, <?= date('d-m-Y', strtotime($skriningPasienMpp['created_at'])) ?><br />Manager Pelayanan Pasien<br /><br /><br /><br /><br /><b><?= HelperSpesialClass::getNamaPegawaiArray($skriningPasienMpp['mpp']) ?? '-' ?></b><br><u><?= $skriningPasienMpp['mpp']['id_nip_nrp'] ?? '-' ?></u></td>

        </tr>
    </tbody>
</table>