<?php

use app\components\Helper;
use app\components\HelperGeneralClass;
use app\components\HelperSpesialClass;
use app\models\pendaftaran\Registrasi;
use kartik\date\DatePicker;
use kartik\select2\Select2;
use yii\web\View;
use yii\bootstrap4\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\web\JsExpression;

/* @var $this yii\web\View */
/* @var $searchModel app\models\pendaftaran\RegistrasiSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Daftar Dokumen Analisa';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="row">
    <div class="col-lg-12">
        <div class="card card-primary card-outline">
            <div class="card-body">
                <div id="accordion">
                    <div class="card">
                        <div class="card-header bg-lightblue">
                            <h5 class="mb-0">
                                LAPORAN ANALISA
                            </h5>
                        </div>
                        
                            <div class="card-body">
                                <?php $form = ActiveForm::begin([
                                    'action' => ['/analisa-kuantitatif/testing'],
                                    'options' => [
                                        'target' => 'blank',
                                    ],
                                    'id' => 'form-laporan',
                                    'layout' => 'horizontal',
                                    'fieldConfig' => [
                                        'template' => "{label}\n{beginWrapper}\n{input}\n{hint}\n{error}\n{endWrapper}",
                                        'horizontalCssClasses' => [
                                            'label' => 'col-sm-2 col-form-label-sm',
                                            'wrapper' => 'col-sm-10',
                                            'error' => '',
                                            'hint' => '',
                                        ],
                                    ],
                                ]); ?>

                                <div class="row">
                                    <div class="col-md-12">

                                    <?php
                                    echo $form->field($modelAnalisaDokumen, 'jenis_laporan',[ 'options' => [ 'required' => 'required']])->inline()->radioList(
                                        [
                                            'harian' => 'Harian',
                                            'bulanan' => 'Bulanan',
                                            'tahunan' => 'Tahunan',
                                        ],
                                        [
                                            'item' => static function ($index, $label, $name, $checked, $value) use ($modelAnalisaDokumen) {
                                                return Helper::radioList($index, $label, $name, $checked, $value, $modelAnalisaDokumen);
                                            }
                                        ]
                                    )->label('Jenis Laporan');
                                    ?>
                                    <?php
                                    echo $form->field($modelAnalisaDokumen, 'tipe_laporan')->inline()->radioList(
                                        [
                                            'seluruh' => 'Seluruh',
                                            'ruangan' => 'Ruangan',
                                            'dokter' => 'Dokter',
                                        ],
                                        [
                                            'item' => static function ($index, $label, $name, $checked, $value) use ($modelAnalisaDokumen) {
                                                return Helper::radioList($index, $label, $name, $checked, $value, $modelAnalisaDokumen);
                                            }
                                        ]
                                    )->label('Berdasarkan');
                                    ?>
                                    <?php
                                    echo '<div id="div-analisa-dokumen-tgl_hari">';
                                    echo $form->field($modelAnalisaDokumen, 'tgl_hari', [
                                        'wrapperOptions' => ['style' => 'margin-left: 0px;'],
                                    ])->widget(DatePicker::classname(), [
                                        'options' => ['placeholder' => 'Pilih...'],
                                        'removeButton' => false,
                                        'pluginOptions' => [
                                            'layout' => '{input}{error}',
                                            'autoclose' => true,
                                            'todayHighlight' => true,
                                            // 'viewMode' => "months",
                                            // 'minViewMode' => "months",
                                            'format' => 'dd-mm-yyyy'
                                        ]
                                    ])->label('Tanggal <span style="color: red;">*</span>');
                                    echo '</div>';

                                    echo '<div id="div-analisa-dokumen-tgl_bulan" style="display: none;">';
                                    echo $form->field($modelAnalisaDokumen, 'tgl_bulan', [
                                        'wrapperOptions' => ['style' => 'margin-left: 0px;'],
                                    ])->widget(DatePicker::classname(), [
                                        'options' => ['placeholder' => 'Pilih...'],
                                        'removeButton' => false,
                                        'pluginOptions' => [
                                            'layout' => '{input}{error}',
                                            'autoclose' => true,
                                            'viewMode' => "months",
                                            'minViewMode' => "months",
                                            'format' => 'mm-yyyy',
                                            'orientation' => 'bottom',
                                        ]
                                    ])->label('Bulan <span style="color: red;">*</span>');
                                    echo '</div>';

                                    echo '<div id="div-analisa-dokumen-tgl_tahun" style="display: none;">';
                                    echo $form->field($modelAnalisaDokumen, 'tgl_tahun', [
                                        'wrapperOptions' => ['style' => 'margin-left: 0px;'],
                                    ])->widget(DatePicker::classname(), [
                                        'options' => ['placeholder' => 'Pilih...'],
                                        'removeButton' => false,
                                        'pluginOptions' => [
                                            'layout' => '{input}{error}',
                                            'autoclose' => true,
                                            'viewMode' => "years",
                                            'minViewMode' => "years",
                                            'format' => 'yyyy',
                                            'orientation' => 'bottom',
                                        ]
                                    ])->label('Tahun <span style="color: red;">*</span>');
                                    echo '</div>';

                                    ?>
                                        <?php
                                   echo '<div id="div-analisa-dokumen-unit_id" style="display: none;">';
                                     echo $form->field($model, 'unit_id')->widget(Select2::classname(), [
                                            'data' => HelperSpesialClass::getListUnitRawatInapAnalisa(),
                                            'size' => 'xs',
                                            'options' => ['class' => 'form-control input-sm', 'placeholder' => 'Pilih Poli Tujuan...'],
                                            'value' => $model->unit_id,
                                            'pluginOptions' => [
                                                'allowClear' => true,
                                            ],
                                        ])->label('<label>Ruangan / Poli : <b><span style="font-size: 12px;color: #000000;important;"><u></u></span></b></label>');
                                        echo '</div>';
                                        echo '<div id="div-analisa-dokumen-dokter_id" style="display: none;">';
                                       echo $form->field($model, 'dokter_id')->widget(Select2::classname(), [
                                            'data' => HelperSpesialClass::getListDokter(false, true),
                                            'size' => 'xs',
                                            'options' => ['class' => 'form-control input-sm', 'placeholder' => 'Pilih Dokter DPJP...'],
                                            'value' => $model->dokter_id,
                                            'pluginOptions' => [
                                                'allowClear' => true,
                                                'initialize' => true
                                            ],
                                        ])->label('<label>Dokter DPJP : <b><span style="font-size: 12px;color: #000000;important;"><u></u></span></b></label>');
                                        echo '</div>';
                                        ?>

                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label-sm"></label>
                                            <div class="col-sm-10" style="margin-left: 0px;">
                                                <?= Html::submitButton('<i class="far fa-file-excel"></i> &nbsp; Download Excel <span id="spinner-btn-form-depo-penjualan" style="display: none;" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>', [
                                                    'class' => 'btn btn-primary',
                                                    'id' => 'btn-form-depo-penjualan',
                                                ]) ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <?php ActiveForm::end(); ?>
                            </div>
                        

                    </div>


                </div>
            </div>
        </div>
    </div>
</div>

<?php
$this->registerJs($this->render('laporan-index.js'), View::POS_END);