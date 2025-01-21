<?php

use yii\helpers\Url;
use yii\widgets\DetailView;
use yii\helpers\Html;
use app\components\HelperGeneralClass;
use app\components\HelperSpesialClass;
use yii\helpers\ArrayHelper;
use app\models\medis\MasalahKeperawatan;
use app\models\medis\IntervensiKeperawatan;

$logo1 = Yii::getAlias('../web/images/logo-light.png');
$gambarData1 = file_get_contents($logo1);
$base64Image1 = 'data:image/png;base64,' . base64_encode($gambarData1);

$logo2 = Yii::getAlias('../web/images/kars.png');
$gambarData2 = file_get_contents($logo2);
$base64Image2 = 'data:image/png;base64,' . base64_encode($gambarData2);


$logo3 = Yii::getAlias('../web/images/riau.png');
$gambarData3 = file_get_contents($logo3);
$base64Image3 = 'data:image/png;base64,' . base64_encode($gambarData3);
// CSS untuk styling PDF
$css = "
    table.detail-view {
        width: 100%;
        border-collapse: collapse;
        border-spacing: 0;
        font-size: 14px;
    }
    table.detail-view th {
        background-color: #f0f0f0;
        text-align: left;
        padding: 5px;
        border: 1px solid #ddd;
    }
    table.detail-view td {
        padding: 5px;
        border: 1px solid #ddd;
    }
";
$this->registerCss($css);


$this->title = "Monitoring Tanda Tanda Vital";


?>
<style>
    .table_component2 {
        overflow: auto;
        width: 100%;
    }

    .table_component2 table {
        border: 0px solid #dededf;
        height: 100%;
        width: 100%;
        table-layout: fixed;
        border-collapse: collapse;
        border-spacing: 1px;
        text-align: left;
    }

    .table_component2 caption {
        caption-side: top;
        text-align: left;
    }

    .table_component2 th {
        border: 1px solid #dededf;
        background-color: #eceff1;
        color: #000000;
        padding: 5px;
    }

    .table_component2 td {
        border-bottom: 1px solid #dededf;
        background-color: #ffffff;
        color: #000000;
        padding: 3px;
        font-size: 12px;
    }
</style>
<?php
if ($is_ajax == true) {
    echo $this->render('doc_kop', ['pasien' => $pasien]);
} else {
    echo $this->render('doc_kop_v2', ['pasien' => $pasien]);
} ?>
<br>
<h4 style="margin: 0; padding: 0;" align="center"><b> MONITORING TANDA TANDA VITAL </b>
    <hr style="margin: 5px; height: 3px; background: #00000;">
    <br>

    <table class="table table-striped table-bordered table-responsive" style="font-size: 12px;">
        <thead>
            <tr>
                <!-- <th rowspan="2">No</th> -->
                <th rowspan="3">Tanggal</th>
                <th rowspan="3">Nadi</th>
                <th rowspan="3">Suhu</th>
                <th rowspan="3">Pernapasan</th>
                <th rowspan="3">TD (mmHg )</th>
                <th rowspan="3">BB (kg)</th>
                <th colspan="4" class="text-center" style="vertical-align: middle;">Masuk (ml)</th>
                <th colspan="10" class="text-center" style="vertical-align: middle;">Keluar (ml)</th>
                <th rowspan="3">IWL (ml)</th>
                <th rowspan="3">Balance (cc)</th>
                <th rowspan="3">Petugas</th>
            </tr>
            <tr>
                <th rowspan="2">Per Oral/NGT</th>
                <th rowspan="2">Perenteral</th>
                <th rowspan="2">Transfusi</th>
                <th rowspan="2">Obat Lainnya</th>
                <th rowspan="2">Kemih</th>
                <th rowspan="2">Muntah</th>
                <th colspan="2">Drain I</th>
                <th colspan="2">Drain II</th>
                <th colspan="2">Drain III</th>
                <th rowspan="2">Lainnya</th>
                <th rowspan="2">Defeksi / BAB</th>
            </tr>
            <tr>
                <th>Jumlah</th>
                <th>Lokasi</th>
                <th>Jumlah</th>
                <th>Lokasi</th>
                <th>Jumlah</th>
                <th>Lokasi</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $no = 1;

            // Cari data dengan created_at paling baru
            $latestData = null;
            foreach ($model as $val) {
                if ($latestData === null || strtotime($val['created_at']) > strtotime($latestData['created_at'])) {
                    $latestData = $val;
                }
            }

            foreach ($model as $val) {
                // Menghitung total bagian "Masuk" dan "Keluar"
                // $masuk = $val['masuk_per_oral_ngt'] + $val['masuk_perenteral'] + $val['masuk_transfusi'] + $val['masuk_obat_lainnya'];
                // $keluar = $val['keluar_kemih'] + $val['keluar_muntah'] + $val['keluar_drain_i'] + $val['keluar_drain_ii'] + $val['keluar_drain_iii'] + $val['keluar_lainnya']+ $val['iwl'];
            ?>
                <tr class="<?= isset($val['perawatBatal']) ? 'table-danger' : '' ?>">
                    <!-- <td><?= $no++ ?></td> -->
                    <td class="text-nowrap">
                        <?= date('Y-m-d H:i:s', strtotime($val['tanggal'])) ?>



                    </td>
                    <td style="text-align: right;"><?= $val['nadi'] ?></td>
                    <td style="text-align: right;"><?= number_format($val['suhu'], 2) ?></td>
                    <td style="text-align: right;"><?= $val['pernafasan'] ?></td>
                    <td style="text-align: right;"><?= $val['td_sistolik'] . "/" . $val['td_diastolik'] ?></td>
                    <td style="text-align: right;"><?= number_format($val['berat_badan'], 2) ?></td>
                    <td style="text-align: right;"><?= number_format($val['masuk_per_oral_ngt'], 2) ?></td>
                    <td style="text-align: right;"><?= number_format($val['masuk_perenteral'], 2) ?></td>
                    <td style="text-align: right;"><?= number_format($val['masuk_transfusi'], 2) ?></td>
                    <td style="text-align: right;"><?= number_format($val['masuk_obat_lainnya'], 2) ?></td>
                    <td style="text-align: right;"><?= number_format($val['keluar_kemih'], 2) ?></td>
                    <td style="text-align: right;"><?= number_format($val['keluar_muntah'], 2) ?></td>
                    <td style="text-align: right;"><?= number_format($val['keluar_drain_i'], 2) ?></td>
                    <td style="text-align: right;"><?= $val['lokasi_drain_i'] ?></td>
                    <td style="text-align: right;"><?= number_format($val['keluar_drain_ii'], 2) ?></td>
                    <td style="text-align: right;"><?= $val['lokasi_drain_ii'] ?></td>
                    <td style="text-align: right;"><?= number_format($val['keluar_drain_iii'], 2) ?></td>
                    <td style="text-align: right;"><?= $val['lokasi_drain_iii'] ?></td>
                    <td style="text-align: right;"><?= number_format($val['keluar_lainnya'], 2) ?></td>
                    <td style="text-align: right;"><?= number_format($val['defeksi_bab'], 2) ?></td>
                    <td style="text-align: right;"><?= number_format($val['iwl'], 2) ?></td>
                    <td style="text-align: right;"><?= number_format($val['balance'], 2) ?></td>
                    <td style="text-align: right;">
                        <?php


                        if (isset($val['perawatFinal'])) {
                            echo "Final : " . HelperSpesialClass::getNamaPegawai((object)$val['perawatFinal']) . "(" . date('Y-m-d H:i:s', strtotime($val['tanggal_final'])) . ")";
                        }
                        echo "<br>";
                        if (isset($val['perawatBatal'])) {
                            echo "Batal : " . HelperSpesialClass::getNamaPegawai((object)$val['perawat']) . "(" . date('Y-m-d H:i:s', strtotime($val['tanggal_batal'])) . ")";
                        }
                        ?>
                    </td>
                </tr>
            <?php
            }


            ?>
        </tbody>

    </table>

    </div>