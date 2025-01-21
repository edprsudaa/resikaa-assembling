<?php

use app\assets\plugins\InputmaskAsset;
use app\components\HelperGeneralClass;
use app\components\HelperSpesialClass;
use app\models\pendaftaran\PasienPenanggung;
use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;
use kartik\select2\Select2;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\web\JsExpression;
use yii\web\View;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\models\DistribusiSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Analisa Kuantitatif';
$this->params['breadcrumbs'][] = $this->title;
$this->registerJs($this->render('script.js'), View::POS_END);
$this->registerJs("
 
");
$this->registerCss("
table.dataTable tbody tr.selected, table.dataTable tbody th.selected, table.dataTable tbody td.selected{
    font-weight:bolder;
    background-color:#00A65A;
}
");

$no_bpjs = PasienPenanggung::find()->where(['pasien_kode' => $registrasi['pasien']['kode']])->andWhere(['debitur_detail_kode' => 1210])->one();
$no_bpjs = $no_bpjs->debitur_nomor ?? '-';

?>
<div class="row">
    <div class="col-lg-12">


        <div class="row">
            <div class="col-lg-12">
                <div class="card bg-info text-white">

                    <div class="card-body">
                        <div class="row">

                            <div class="col-lg-12">
                                <div class="row">
                                    <div class="col-lg-3">
                                        <h6 class="mt-0">No.RM:</h6>
                                        <h6 class="mt-0 text-white"><b><?php echo $registrasi['pasien']['kode']; ?></b></h6>
                                    </div>
                                    <div class="col-lg-3">
                                        <h6 class="mt-0">Identitas:</h6>
                                        <h6 class="mt-0 text-white"><b><?php echo $registrasi['pasien']['no_identitas'] ?? '-'; ?></b></h6>
                                    </div>
                                    <div class="col-lg-3">
                                        <h6 class="mt-0">No.Reg:</h6>
                                        <h6 class="mt-0 text-white"><?php echo $registrasi['kode'] ?? '-'; ?></h6>
                                    </div>
                                    <div class="col-lg-3">
                                        <h6 class="mt-0">Penjamin:</h6>
                                        <h6 class="mt-0 text-white"><?php echo $registrasi['debiturDetail']['nama'] ?? '-'; ?></h6>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-3">
                                        <h6 class="mt-0">Nama:</h6>
                                        <h6 class="mt-0 text-white"><b><?php echo $registrasi['pasien']['nama'] ?? '-'; ?></b></h6>
                                    </div>
                                    <div class="col-lg-3">
                                        <h6 class="mt-0">Gender:</h6>
                                        <h6 class="mt-0 text-white"><b><?php echo ($registrasi['pasien']['jkel'] == 'p' ? 'WANITA' : 'PRIA'); ?></b></h6>
                                    </div>
                                    <div class="col-lg-3">
                                        <h6 class="mt-0">Tgl. Lahir:</h6>
                                        <h6 class="mt-0 text-white"><b><?php echo HelperGeneralClass::getDateFormatToIndo($registrasi['pasien']['tgl_lahir'], false) ?? '-'; ?></b></h6>
                                    </div>
                                    <div class="col-lg-3">
                                        <h6 class="mt-0">Umur By Tgl.Masuk:</h6>
                                        <h6 class="mt-0 text-white"><b><?php $umur = HelperGeneralClass::getUmur($registrasi['pasien']['tgl_lahir'], $registrasi['tgl_masuk']);
                                                                        echo $umur['th'] . ' TH ' . $umur['bl'] . ' BL ' . $umur['hr'] . ' HR' ?? '-'; ?></b></h6>
                                    </div>



                                </div>
                                <div class="row">
                                    <div class="col-lg-3">
                                        <h6 class="mt-0">Nomor BPJS:</h6>
                                        <h6 class="mt-0 text-white"><b><?php echo $no_bpjs ?? '-'; ?></b></h6>
                                    </div>
                                    <div class="col-lg-3">
                                        <h6 class="mt-0">E-SEP RJ:</h6>
                                        <h6 class="mt-0 text-white"><b><?php echo $registrasi['no_sep'] ?? '-'; ?></b></h6>
                                    </div>
                                    <div class="col-lg-3">
                                        <h6 class="mt-0">E-SEP RI:</h6>
                                        <h6 class="mt-0 text-white"><b><?php echo $registrasi['no_sep_ri'] ?? '-'; ?></b></h6>
                                    </div>
                                    <div class="col-lg-3">
                                        <h6 class="mt-0">E-SEP IGD:</h6>
                                        <h6 class="mt-0 text-white"><b><?php echo $registrasi['no_sep_igd'] ?? '-'; ?></b></h6>
                                    </div>



                                </div>
                                <div class="row">

                                    <div class="col-lg-3">
                                        <h6 class="mt-0">Tgl.Masuk:</h6>
                                        <h6 class="mt-0 text-white"><b><?php echo  HelperGeneralClass::getDateFormatToIndo($registrasi['tgl_masuk'], false) . ' ' . date('H:i', strtotime($registrasi['tgl_masuk'])) ?? '-'; ?></b></h6>
                                    </div>
                                    <div class="col-lg-3">
                                        <h6 class="mt-0">Tgl.Keluar:</h6>
                                        <h6 class="mt-0 text-white"><b><?php echo  $registrasi['tgl_keluar'] != NULL ? (HelperGeneralClass::getDateFormatToIndo($registrasi['tgl_keluar'], false) . ' ' . date('H:i', strtotime($registrasi['tgl_keluar'])) ?? '-') : '-'; ?></b></h6>
                                    </div>
                                    <div class="col-lg-3">
                                        <h6 class="mt-0">Unit:</h6>
                                        <?php
                                        $detail = null;
                                        $no = 1;
                                        foreach ($registrasi['layanan'] as $item) {
                                            $detail .= $no++ . '. ' . ($item['unit']['nama'] ?? '-') . '</br>';
                                        }
                                        if ($detail) {
                                            echo '<h6 class="mt-0 text-white"><b>' . $detail . '</b></h6>';
                                        } else {
                                            echo '<h6 class="mt-0 text-white"><b>Belum Ditentukan</b></h6>';
                                        }
                                        ?>

                                    </div>

                                    <div class="col-lg-3">
                                        <h6 class="mt-0">Dpjp Utama:</h6>
                                        <?php


                                        $detail = null;
                                        $dokterRj = null;
                                        $no = 1;
                                        if ($registrasi['pjpRi']) {
                                            foreach ($registrasi['pjpRi'] as $dpjp) {
                                                if ($dpjp['status'] == 1) {
                                                    $namaDpjp = $namaDpjp = HelperSpesialClass::getNamaPegawaiArray($dpjp['pegawai']);
                                                    if ($detail) {
                                                        $detail .= '</br>' . $no++ . '. ' . $namaDpjp;
                                                    } else {
                                                        $detail .= $no++ . '. ' . $namaDpjp;
                                                    }
                                                }
                                            }
                                        } else {
                                            foreach ($registrasi['layanan'] as $dpjp) {
                                                foreach ($dpjp['pjp'] as $item) {
                                                    $namaDpjp = $namaDpjp = HelperSpesialClass::getNamaPegawaiArray($item['pegawai']);
                                                    if ($detail) {
                                                        $detail .= '</br>' . $no++ . '. ' . $namaDpjp;
                                                    } else {
                                                        $detail .= $no++ . '. ' . $namaDpjp;
                                                    }
                                                }
                                            }
                                        }
                                        if ($detail) {
                                            echo '<h6 class="mt-0 text-white"><b>' . $detail . '</b></h6>';
                                        } else {
                                            echo '<h6 class="mt-0 text-white"><b>Belum Ditentukan</b></h6>';
                                        }

                                        ?>
                                    </div>






                                </div>
                            </div>
                        </div>
                    </div> <!-- end card-body -->
                </div>
            </div>
        </div>

    </div>
</div>