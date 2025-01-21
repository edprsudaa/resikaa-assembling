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
        width: 100% !important;
        border-collapse: collapse;
        table-layout: fixed;
    }

    th {
        background-color: #D3D3D3 !important;
        text-align: left !important;
        word-wrap: break-word;
        word-break: break-all;
        font-size: 14px;
    }

    tr td {
        padding: 5px 5px 5px 5px !important;
        text-align: left !important;
        word-wrap: break-word;
        word-break: break-all;
        font-size: 14px;


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

<h2>CATATAN PERKEMBANGAN TERINTEGRASI</h2>
<table border="1" class="table-responsive p-0">
    <thead>
        <tr>
            <th style="width: 15%;white-space: pre-wrap">Tgl Final,Tgl Batal & Ruang</th>
            <th style="width: 20%;white-space: pre-wrap">Profesional Pemberi Asuhan (PPA)</th>
            <th style="width: 45%;white-space: pre-wrap">ANAMNESIS, PEMERIKSAAN FISIK / PENUNJANG, HASIL PENGOBATAN, RENCANA TATA LAKSANA
                (PENGOBATAN / GIZI / TINDAKAN / PEMERIKSAAN / PENUNJANG / KONSULTASI). S O A P
            </th>
            <th style="width: 20%;white-space: pre-wrap">Intruksi PPA</th>
        </tr>
    </thead>
    <tbody>
        <?php

        if (!empty($asesmen)) {
            foreach ($asesmen as $v) {
                $style = 'border: 1px solid;';
                if ($v['batal']) {
                    if (\Yii::$app->params['setting']['doc']['bg_batal']) {
                        $path = \Yii::getAlias('@webroot') . \Yii::$app->params['setting']['doc']['bg_batal'];
                        $type = pathinfo($path, PATHINFO_EXTENSION);
                        $data = file_get_contents($path);
                        $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
                        $style = "border: 1px solid;background-image:url('" . $base64 . "');background-repeat: repeat;background-size: 80px 50px;";
                    }
                }

        ?>
                <tr style="<?= ((intval($v['batal']) == 1) ? $style : '') ?>">
                    <td style="vertical-align: text-top;white-space: pre-wrap"><?= 'Tgl Final : ' . Yii::$app->formatter->asDate($v['tanggal_final']) . ' ' . Yii::$app->formatter->asTime($v['tanggal_final']) . ((intval($v['batal']) == 1) ? '<br>Tgl Batal : ' . Yii::$app->formatter->asDate($v['tanggal_batal']) . ' ' . Yii::$app->formatter->asTime($v['tanggal_batal']) : '') . '<br>Ruang : ' . $v['layanan']['unit']['nama'] ?></td>
                    <td style="vertical-align: text-top;white-space: pre-wrap"><?= ($v['dokter']['gelar_sarjana_depan'] ?? '') . ' ' . ($v['dokter']['nama_lengkap'] ?? '') . ' ,' . ($v['dokter']['gelar_sarjana_belakang'] ?? '') . '<br>' ?></td>
                    <td style="vertical-align: text-top;white-space: pre-wrap"><?= 'S (Subject):<br>' . (($v['s']) ?? '-') . '<br>O (Object):<br>' . '--> ' . (($v['o']) ?? '') . '<br>A (Asessment):<br>' . '--> ' . (($v['a']) ?? '-') . '<br>P (Planning):<br>' . '--> ' . (($v['p']) ?? '-')
                                                                                    . (($v['ppa_jenis'] == 'PERAWAT') ? (($v['ppja_id_verifikasi']) ? '<br><b><u>Perawat (KA.TIM) Verifikasi </u></b>' . '<br>Nama : ' . HelperSpesial::getNamaPegawaiArray($v['ppjaVerif']) . (($v['ppja_tgl_verifikasi']) ? '<br>Tgl & Jam : ' . Yii::$app->formatter->asDate($v['ppja_tgl_verifikasi']) . ' ' . Yii::$app->formatter->asTime($v['ppja_tgl_verifikasi']) : '<br>Tgl & Jam : Belum Diverifikasi') : '')
                                                                                        . (($v['ppja_serah_id_verifikasi']) ? '<br><b><u>Perawat (PJ.Shift) Verifikasi (Yg.Menyerahkan) </u></b>' . '<br>Nama : ' . HelperSpesial::getNamaPegawaiArray($v['ppjaSerahVerif']) . (($v['ppja_serah_tgl_verifikasi']) ? '<br>Tgl & Jam : ' . Yii::$app->formatter->asDate($v['ppja_serah_tgl_verifikasi']) . ' ' . Yii::$app->formatter->asTime($v['ppja_serah_tgl_verifikasi']) : '<br>Tgl & Jam : Belum Diverifikasi') : '')
                                                                                        . (($v['ppja_terima_id_verifikasi']) ? '<br><b><u>Perawat (PJ.Shift) Verifikasi (Yg.Menerima) </u></b>' . '<br>Nama : ' . HelperSpesial::getNamaPegawaiArray($v['ppjaTerimaVerif']) . (($v['ppja_terima_tgl_verifikasi']) ? '<br>Tgl & Jam : ' . Yii::$app->formatter->asDate($v['ppja_terima_tgl_verifikasi']) . ' ' . Yii::$app->formatter->asTime($v['ppja_terima_tgl_verifikasi']) : '<br>Tgl & Jam : Belum Diverifikasi') : '') : '')
                                                                                ?>
                    </td>
                    <td style="vertical-align: text-top;white-space: pre-wrap"><?= $v['intruksi_ppa'] ?? '' ?></td>
                </tr>
            <?php
            }
        } else { ?>
            <tr>
                <td style="text-align: center!important;" colspan="4">Tidak ada catatan</td>
            </tr>
        <?php

        }
        ?>

    </tbody>
</table>