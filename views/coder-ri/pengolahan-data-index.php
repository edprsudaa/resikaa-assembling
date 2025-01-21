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
                                KEGIATAN PELAYANAN RAWAT INAP (Formulir RL 3.1)
                            </h5>
                        </div>

                        <div class="card-body">
                            <?php $form = ActiveForm::begin([
                                'action' => ['/analisa-kuantitatif/pengolahan-data-laporan'],
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
                                    echo $form->field($KegiatanPelayananRawatInap, 'jenis_laporan', ['options' => ['required' => 'required']])->inline()->radioList(
                                        [
                                            'harian' => 'Harian',
                                            'bulanan' => 'Bulanan',
                                            'tahunan' => 'Tahunan',
                                        ],
                                        [
                                            'item' => static function ($index, $label, $name, $checked, $value) use ($KegiatanPelayananRawatInap) {
                                                return Helper::radioList($index, $label, $name, $checked, $value, $KegiatanPelayananRawatInap);
                                            }
                                        ]
                                    )->label('Jenis Laporan');
                                    ?>

                                    <?php
                                    echo '<div id="div-kegiatan-pelayanan-rawat-inap-tgl_hari">';
                                    echo $form->field($KegiatanPelayananRawatInap, 'tgl_hari', [
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

                                    echo '<div id="div-kegiatan-pelayanan-rawat-inap-tgl_bulan" style="display: none;">';
                                    echo $form->field($KegiatanPelayananRawatInap, 'tgl_bulan', [
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

                                    echo '<div id="div-kegiatan-pelayanan-rawat-inap-tgl_tahun" style="display: none;">';
                                    echo $form->field($KegiatanPelayananRawatInap, 'tgl_tahun', [
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
    <div class="col-lg-12">
        <div class="card card-primary card-outline">
            <div class="card-body">
                <div id="accordion">
                    <div class="card">
                        <div class="card-header bg-lightblue">
                            <h5 class="mb-0">
                                KUNJUNGAN RAWAT DARURAT (Formulir RL 3.2)
                            </h5>
                        </div>

                        <div class="card-body">
                            <?php $form = ActiveForm::begin([
                                'action' => ['/analisa-kuantitatif/pengolahan-data-laporan'],
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
                                    echo $form->field($KunjunganRawatDarurat, 'jenis_laporan', ['options' => ['required' => 'required']])->inline()->radioList(
                                        [
                                            'harian' => 'Harian',
                                            'bulanan' => 'Bulanan',
                                            'tahunan' => 'Tahunan',
                                        ],
                                        [
                                            'item' => static function ($index, $label, $name, $checked, $value) use ($KunjunganRawatDarurat) {
                                                return Helper::radioList($index, $label, $name, $checked, $value, $KunjunganRawatDarurat);
                                            }
                                        ]
                                    )->label('Jenis Laporan');
                                    ?>

                                    <?php
                                    echo '<div id="div-kunjungan-rawat-darurat-tgl_hari">';
                                    echo $form->field($KunjunganRawatDarurat, 'tgl_hari', [
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

                                    echo '<div id="div-kunjungan-rawat-darurat-tgl_bulan" style="display: none;">';
                                    echo $form->field($KunjunganRawatDarurat, 'tgl_bulan', [
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

                                    echo '<div id="div-kunjungan-rawat-darurat-tgl_tahun" style="display: none;">';
                                    echo $form->field($KunjunganRawatDarurat, 'tgl_tahun', [
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

    <div class="col-lg-12">
        <div class="card card-primary card-outline">
            <div class="card-body">
                <div id="accordion">
                    <div class="card">
                        <div class="card-header bg-lightblue">
                            <h5 class="mb-0">
                                KEGIATAN KESEHATAN GIGI DAN MULUT (Formulir RL 3.3)
                            </h5>
                        </div>

                        <div class="card-body">
                            <?php $form = ActiveForm::begin([
                                'action' => ['/analisa-kuantitatif/pengolahan-data-laporan'],
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
                                    echo $form->field($KegiatanKesehatanGigiMulut, 'jenis_laporan', ['options' => ['required' => 'required']])->inline()->radioList(
                                        [
                                            'harian' => 'Harian',
                                            'bulanan' => 'Bulanan',
                                            'tahunan' => 'Tahunan',
                                        ],
                                        [
                                            'item' => static function ($index, $label, $name, $checked, $value) use ($KegiatanKesehatanGigiMulut) {
                                                return Helper::radioList($index, $label, $name, $checked, $value, $KegiatanKesehatanGigiMulut);
                                            }
                                        ]
                                    )->label('Jenis Laporan');
                                    ?>

                                    <?php
                                    echo '<div id="div-kegiatan-kesehatan-gigi-mulut-tgl_hari">';
                                    echo $form->field($KegiatanKesehatanGigiMulut, 'tgl_hari', [
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

                                    echo '<div id="div-kegiatan-kesehatan-gigi-mulut-tgl_bulan" style="display: none;">';
                                    echo $form->field($KegiatanKesehatanGigiMulut, 'tgl_bulan', [
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

                                    echo '<div id="div-kegiatan-kesehatan-gigi-mulut-tgl_tahun" style="display: none;">';
                                    echo $form->field($KegiatanKesehatanGigiMulut, 'tgl_tahun', [
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
    <div class="col-lg-12">
        <div class="card card-primary card-outline">
            <div class="card-body">
                <div id="accordion">
                    <div class="card">
                        <div class="card-header bg-lightblue">
                            <h5 class="mb-0">
                                KEGIATAN KEBIDANAN (Formulir RL 3.4)
                            </h5>
                        </div>

                        <div class="card-body">
                            <?php $form = ActiveForm::begin([
                                'action' => ['/analisa-kuantitatif/pengolahan-data-laporan'],
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
                                    echo $form->field($KegiatanKebidanan, 'jenis_laporan', ['options' => ['required' => 'required']])->inline()->radioList(
                                        [
                                            'harian' => 'Harian',
                                            'bulanan' => 'Bulanan',
                                            'tahunan' => 'Tahunan',
                                        ],
                                        [
                                            'item' => static function ($index, $label, $name, $checked, $value) use ($KegiatanKebidanan) {
                                                return Helper::radioList($index, $label, $name, $checked, $value, $KegiatanKebidanan);
                                            }
                                        ]
                                    )->label('Jenis Laporan');
                                    ?>

                                    <?php
                                    echo '<div id="div-kegiatan-kebidanan-tgl_hari">';
                                    echo $form->field($KegiatanKebidanan, 'tgl_hari', [
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

                                    echo '<div id="div-kegiatan-kebidanan-tgl_bulan" style="display: none;">';
                                    echo $form->field($KegiatanKebidanan, 'tgl_bulan', [
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

                                    echo '<div id="div-kegiatan-kebidanan-tgl_tahun" style="display: none;">';
                                    echo $form->field($KegiatanKebidanan, 'tgl_tahun', [
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
    <div class="col-lg-12">
        <div class="card card-primary card-outline">
            <div class="card-body">
                <div id="accordion">
                    <div class="card">
                        <div class="card-header bg-lightblue">
                            <h5 class="mb-0">
                                KEGIATAN PERINATOLOGI (Formulir RL 3.5)
                            </h5>
                        </div>

                        <div class="card-body">
                            <?php $form = ActiveForm::begin([
                                'action' => ['/analisa-kuantitatif/pengolahan-data-laporan'],
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
                                    echo $form->field($KegiatanPerinatologi, 'jenis_laporan', ['options' => ['required' => 'required']])->inline()->radioList(
                                        [
                                            'harian' => 'Harian',
                                            'bulanan' => 'Bulanan',
                                            'tahunan' => 'Tahunan',
                                        ],
                                        [
                                            'item' => static function ($index, $label, $name, $checked, $value) use ($KegiatanPerinatologi) {
                                                return Helper::radioList($index, $label, $name, $checked, $value, $KegiatanPerinatologi);
                                            }
                                        ]
                                    )->label('Jenis Laporan');
                                    ?>

                                    <?php
                                    echo '<div id="div-kegiatan-perinatologi-tgl_hari">';
                                    echo $form->field($KegiatanPerinatologi, 'tgl_hari', [
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

                                    echo '<div id="div-kegiatan-perinatologi-tgl_bulan" style="display: none;">';
                                    echo $form->field($KegiatanPerinatologi, 'tgl_bulan', [
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

                                    echo '<div id="div-kegiatan-perinatologi-tgl_tahun" style="display: none;">';
                                    echo $form->field($KegiatanPerinatologi, 'tgl_tahun', [
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
    <div class="col-lg-12">
        <div class="card card-primary card-outline">
            <div class="card-body">
                <div id="accordion">
                    <div class="card">
                        <div class="card-header bg-lightblue">
                            <h5 class="mb-0">
                                KEGIATAN PEMBEDAHAN (Formulir RL 3.6)
                            </h5>
                        </div>

                        <div class="card-body">
                            <?php $form = ActiveForm::begin([
                                'action' => ['/analisa-kuantitatif/pengolahan-data-laporan'],
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
                                    echo $form->field($KegiatanPembedahan, 'jenis_laporan', ['options' => ['required' => 'required']])->inline()->radioList(
                                        [
                                            'harian' => 'Harian',
                                            'bulanan' => 'Bulanan',
                                            'tahunan' => 'Tahunan',
                                        ],
                                        [
                                            'item' => static function ($index, $label, $name, $checked, $value) use ($KegiatanPembedahan) {
                                                return Helper::radioList($index, $label, $name, $checked, $value, $KegiatanPembedahan);
                                            }
                                        ]
                                    )->label('Jenis Laporan');
                                    ?>

                                    <?php
                                    echo '<div id="div-kegiatan-pembedahan-tgl_hari">';
                                    echo $form->field($KegiatanPembedahan, 'tgl_hari', [
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

                                    echo '<div id="div-kegiatan-pembedahan-tgl_bulan" style="display: none;">';
                                    echo $form->field($KegiatanPembedahan, 'tgl_bulan', [
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

                                    echo '<div id="div-kegiatan-pembedahan-tgl_tahun" style="display: none;">';
                                    echo $form->field($KegiatanPembedahan, 'tgl_tahun', [
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
    <div class="col-lg-12">
        <div class="card card-primary card-outline">
            <div class="card-body">
                <div id="accordion">
                    <div class="card">
                        <div class="card-header bg-lightblue">
                            <h5 class="mb-0">
                                KEGIATAN RADIOLOGI (Formulir RL 3.7)
                            </h5>
                        </div>

                        <div class="card-body">
                            <?php $form = ActiveForm::begin([
                                'action' => ['/analisa-kuantitatif/pengolahan-data-laporan'],
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
                                    echo $form->field($KegiatanRadiologi, 'jenis_laporan', ['options' => ['required' => 'required']])->inline()->radioList(
                                        [
                                            'harian' => 'Harian',
                                            'bulanan' => 'Bulanan',
                                            'tahunan' => 'Tahunan',
                                        ],
                                        [
                                            'item' => static function ($index, $label, $name, $checked, $value) use ($KegiatanRadiologi) {
                                                return Helper::radioList($index, $label, $name, $checked, $value, $KegiatanRadiologi);
                                            }
                                        ]
                                    )->label('Jenis Laporan');
                                    ?>

                                    <?php
                                    echo '<div id="div-kegiatan-radiologi-tgl_hari">';
                                    echo $form->field($KegiatanRadiologi, 'tgl_hari', [
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

                                    echo '<div id="div-kegiatan-radiologi-tgl_bulan" style="display: none;">';
                                    echo $form->field($KegiatanRadiologi, 'tgl_bulan', [
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

                                    echo '<div id="div-kegiatan-radiologi-tgl_tahun" style="display: none;">';
                                    echo $form->field($KegiatanRadiologi, 'tgl_tahun', [
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
    <div class="col-lg-12">
        <div class="card card-primary card-outline">
            <div class="card-body">
                <div id="accordion">
                    <div class="card">
                        <div class="card-header bg-lightblue">
                            <h5 class="mb-0">
                                PEMERIKSAAN LABORATORIUM (Formulir RL 3.8)
                            </h5>
                        </div>

                        <div class="card-body">
                            <?php $form = ActiveForm::begin([
                                'action' => ['/analisa-kuantitatif/pengolahan-data-laporan'],
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
                                    echo $form->field($PemeriksaanLaboratorium, 'jenis_laporan', ['options' => ['required' => 'required']])->inline()->radioList(
                                        [
                                            'harian' => 'Harian',
                                            'bulanan' => 'Bulanan',
                                            'tahunan' => 'Tahunan',
                                        ],
                                        [
                                            'item' => static function ($index, $label, $name, $checked, $value) use ($PemeriksaanLaboratorium) {
                                                return Helper::radioList($index, $label, $name, $checked, $value, $PemeriksaanLaboratorium);
                                            }
                                        ]
                                    )->label('Jenis Laporan');
                                    ?>

                                    <?php
                                    echo '<div id="div-pemeriksaan-laboratorium-tgl_hari">';
                                    echo $form->field($PemeriksaanLaboratorium, 'tgl_hari', [
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

                                    echo '<div id="div-pemeriksaan-laboratorium-tgl_bulan" style="display: none;">';
                                    echo $form->field($PemeriksaanLaboratorium, 'tgl_bulan', [
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

                                    echo '<div id="div-pemeriksaan-laboratorium-tgl_tahun" style="display: none;">';
                                    echo $form->field($PemeriksaanLaboratorium, 'tgl_tahun', [
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
    <div class="col-lg-12">
        <div class="card card-primary card-outline">
            <div class="card-body">
                <div id="accordion">
                    <div class="card">
                        <div class="card-header bg-lightblue">
                            <h5 class="mb-0">
                                PELAYANAN REHABILITASI MEDIK(Formulir RL 3.9)
                            </h5>
                        </div>

                        <div class="card-body">
                            <?php $form = ActiveForm::begin([
                                'action' => ['/analisa-kuantitatif/pengolahan-data-laporan'],
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
                                    echo $form->field($PelayananRehabilitasiMedik, 'jenis_laporan', ['options' => ['required' => 'required']])->inline()->radioList(
                                        [
                                            'harian' => 'Harian',
                                            'bulanan' => 'Bulanan',
                                            'tahunan' => 'Tahunan',
                                        ],
                                        [
                                            'item' => static function ($index, $label, $name, $checked, $value) use ($PelayananRehabilitasiMedik) {
                                                return Helper::radioList($index, $label, $name, $checked, $value, $PelayananRehabilitasiMedik);
                                            }
                                        ]
                                    )->label('Jenis Laporan');
                                    ?>

                                    <?php
                                    echo '<div id="div-pelayanan-rehabilitasi-medik-tgl_hari">';
                                    echo $form->field($PelayananRehabilitasiMedik, 'tgl_hari', [
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

                                    echo '<div id="div-pelayanan-rehabilitasi-medik-tgl_bulan" style="display: none;">';
                                    echo $form->field($PelayananRehabilitasiMedik, 'tgl_bulan', [
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

                                    echo '<div id="div-pelayanan-rehabilitasi-medik-tgl_tahun" style="display: none;">';
                                    echo $form->field($PelayananRehabilitasiMedik, 'tgl_tahun', [
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
    <div class="col-lg-12">
        <div class="card card-primary card-outline">
            <div class="card-body">
                <div id="accordion">
                    <div class="card">
                        <div class="card-header bg-lightblue">
                            <h5 class="mb-0">
                                KEGIATAN PELAYANAN KHUSUS (Formulir RL 3.10)
                            </h5>
                        </div>

                        <div class="card-body">
                            <?php $form = ActiveForm::begin([
                                'action' => ['/analisa-kuantitatif/pengolahan-data-laporan'],
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
                                    echo $form->field($KegiatanPelayananKhusus, 'jenis_laporan', ['options' => ['required' => 'required']])->inline()->radioList(
                                        [
                                            'harian' => 'Harian',
                                            'bulanan' => 'Bulanan',
                                            'tahunan' => 'Tahunan',
                                        ],
                                        [
                                            'item' => static function ($index, $label, $name, $checked, $value) use ($KegiatanPelayananKhusus) {
                                                return Helper::radioList($index, $label, $name, $checked, $value, $KegiatanPelayananKhusus);
                                            }
                                        ]
                                    )->label('Jenis Laporan');
                                    ?>

                                    <?php
                                    echo '<div id="div-kegiatan-pelayanan-khusus-tgl_hari">';
                                    echo $form->field($KegiatanPelayananKhusus, 'tgl_hari', [
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

                                    echo '<div id="div-kegiatan-pelayanan-khusus-tgl_bulan" style="display: none;">';
                                    echo $form->field($KegiatanPelayananKhusus, 'tgl_bulan', [
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

                                    echo '<div id="div-kegiatan-pelayanan-khusus-tgl_tahun" style="display: none;">';
                                    echo $form->field($KegiatanPelayananKhusus, 'tgl_tahun', [
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
    <div class="col-lg-12">
        <div class="card card-primary card-outline">
            <div class="card-body">
                <div id="accordion">
                    <div class="card">
                        <div class="card-header bg-lightblue">
                            <h5 class="mb-0">
                                KEGIATAN KESEHATAN JIWA (Formulir RL 3.11)
                            </h5>
                        </div>

                        <div class="card-body">
                            <?php $form = ActiveForm::begin([
                                'action' => ['/analisa-kuantitatif/pengolahan-data-laporan'],
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
                                    echo $form->field($KegiatanKesehatanJiwa, 'jenis_laporan', ['options' => ['required' => 'required']])->inline()->radioList(
                                        [
                                            'harian' => 'Harian',
                                            'bulanan' => 'Bulanan',
                                            'tahunan' => 'Tahunan',
                                        ],
                                        [
                                            'item' => static function ($index, $label, $name, $checked, $value) use ($KegiatanKesehatanJiwa) {
                                                return Helper::radioList($index, $label, $name, $checked, $value, $KegiatanKesehatanJiwa);
                                            }
                                        ]
                                    )->label('Jenis Laporan');
                                    ?>

                                    <?php
                                    echo '<div id="div-kegiatan-kesehatan-jiwa-tgl_hari">';
                                    echo $form->field($KegiatanKesehatanJiwa, 'tgl_hari', [
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

                                    echo '<div id="div-kegiatan-kesehatan-jiwa-tgl_bulan" style="display: none;">';
                                    echo $form->field($KegiatanKesehatanJiwa, 'tgl_bulan', [
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

                                    echo '<div id="div-kegiatan-kesehatan-jiwa-tgl_tahun" style="display: none;">';
                                    echo $form->field($KegiatanKesehatanJiwa, 'tgl_tahun', [
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

    <div class="col-lg-12">
        <div class="card card-primary card-outline">
            <div class="card-body">
                <div id="accordion">
                    <div class="card">
                        <div class="card-header bg-lightblue">
                            <h5 class="mb-0">
                                KEGIATAN KELUARGA BERENCANA(Formulir RL 3.12)
                            </h5>
                        </div>

                        <div class="card-body">
                            <?php $form = ActiveForm::begin([
                                'action' => ['/analisa-kuantitatif/pengolahan-data-laporan'],
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
                                    echo $form->field($KegiatanKeluargaBerencana, 'jenis_laporan', ['options' => ['required' => 'required']])->inline()->radioList(
                                        [
                                            'harian' => 'Harian',
                                            'bulanan' => 'Bulanan',
                                            'tahunan' => 'Tahunan',
                                        ],
                                        [
                                            'item' => static function ($index, $label, $name, $checked, $value) use ($KegiatanKeluargaBerencana) {
                                                return Helper::radioList($index, $label, $name, $checked, $value, $KegiatanKeluargaBerencana);
                                            }
                                        ]
                                    )->label('Jenis Laporan');
                                    ?>

                                    <?php
                                    echo '<div id="div-kegiatan-keluarga-berencana-tgl_hari">';
                                    echo $form->field($KegiatanKeluargaBerencana, 'tgl_hari', [
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

                                    echo '<div id="div-kegiatan-keluarga-berencana-tgl_bulan" style="display: none;">';
                                    echo $form->field($KegiatanKeluargaBerencana, 'tgl_bulan', [
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

                                    echo '<div id="div-kegiatan-keluarga-berencana-tgl_tahun" style="display: none;">';
                                    echo $form->field($KegiatanKeluargaBerencana, 'tgl_tahun', [
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
    <div class="col-lg-12">
        <div class="card card-primary card-outline">
            <div class="card-body">
                <div id="accordion">
                    <div class="card">
                        <div class="card-header bg-lightblue">
                            <h5 class="mb-0">
                                PENGADAAN OBAT, PENULISAN, DAN PELAYANAN RESEP (Formulir RL 3.13)
                            </h5>
                        </div>

                        <div class="card-body">
                            <?php $form = ActiveForm::begin([
                                'action' => ['/analisa-kuantitatif/pengolahan-data-laporan'],
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
                                    echo $form->field($PengadaanObatPenulisanPelayananResep, 'jenis_laporan', ['options' => ['required' => 'required']])->inline()->radioList(
                                        [
                                            'harian' => 'Harian',
                                            'bulanan' => 'Bulanan',
                                            'tahunan' => 'Tahunan',
                                        ],
                                        [
                                            'item' => static function ($index, $label, $name, $checked, $value) use ($PengadaanObatPenulisanPelayananResep) {
                                                return Helper::radioList($index, $label, $name, $checked, $value, $PengadaanObatPenulisanPelayananResep);
                                            }
                                        ]
                                    )->label('Jenis Laporan');
                                    ?>

                                    <?php
                                    echo '<div id="div-pengadaan-obat-penulisan-pelayanan-resep-tgl_hari">';
                                    echo $form->field($PengadaanObatPenulisanPelayananResep, 'tgl_hari', [
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

                                    echo '<div id="div-pengadaan-obat-penulisan-pelayanan-resep-tgl_bulan" style="display: none;">';
                                    echo $form->field($PengadaanObatPenulisanPelayananResep, 'tgl_bulan', [
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

                                    echo '<div id="div-pengadaan-obat-penulisan-pelayanan-resep-tgl_tahun" style="display: none;">';
                                    echo $form->field($PengadaanObatPenulisanPelayananResep, 'tgl_tahun', [
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
    <div class="col-lg-12">
        <div class="card card-primary card-outline">
            <div class="card-body">
                <div id="accordion">
                    <div class="card">
                        <div class="card-header bg-lightblue">
                            <h5 class="mb-0">
                                KEGIATAN RUJUKAN (Formulir RL 3.14)
                            </h5>
                        </div>

                        <div class="card-body">
                            <?php $form = ActiveForm::begin([
                                'action' => ['/analisa-kuantitatif/pengolahan-data-laporan'],
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
                                    echo $form->field($KegiatanRujukan, 'jenis_laporan', ['options' => ['required' => 'required']])->inline()->radioList(
                                        [
                                            'harian' => 'Harian',
                                            'bulanan' => 'Bulanan',
                                            'tahunan' => 'Tahunan',
                                        ],
                                        [
                                            'item' => static function ($index, $label, $name, $checked, $value) use ($KegiatanRujukan) {
                                                return Helper::radioList($index, $label, $name, $checked, $value, $KegiatanRujukan);
                                            }
                                        ]
                                    )->label('Jenis Laporan');
                                    ?>

                                    <?php
                                    echo '<div id="div-kegiatan-rujukan-tgl_hari">';
                                    echo $form->field($KegiatanRujukan, 'tgl_hari', [
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

                                    echo '<div id="div-kegiatan-rujukan-tgl_bulan" style="display: none;">';
                                    echo $form->field($KegiatanRujukan, 'tgl_bulan', [
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

                                    echo '<div id="div-kegiatan-rujukan-tgl_tahun" style="display: none;">';
                                    echo $form->field($KegiatanRujukan, 'tgl_tahun', [
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
    <div class="col-lg-12">
        <div class="card card-primary card-outline">
            <div class="card-body">
                <div id="accordion">
                    <div class="card">
                        <div class="card-header bg-lightblue">
                            <h5 class="mb-0">
                                CARA BAYAR (Formulir RL 3.15)
                            </h5>
                        </div>

                        <div class="card-body">
                            <?php $form = ActiveForm::begin([
                                'action' => ['/analisa-kuantitatif/pengolahan-data-laporan'],
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
                                    echo $form->field($CaraBayar, 'jenis_laporan', ['options' => ['required' => 'required']])->inline()->radioList(
                                        [
                                            'harian' => 'Harian',
                                            'bulanan' => 'Bulanan',
                                            'tahunan' => 'Tahunan',
                                        ],
                                        [
                                            'item' => static function ($index, $label, $name, $checked, $value) use ($CaraBayar) {
                                                return Helper::radioList($index, $label, $name, $checked, $value, $CaraBayar);
                                            }
                                        ]
                                    )->label('Jenis Laporan');
                                    ?>

                                    <?php
                                    echo '<div id="div-cara-bayar-tgl_hari">';
                                    echo $form->field($CaraBayar, 'tgl_hari', [
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

                                    echo '<div id="div-cara-bayar-tgl_bulan" style="display: none;">';
                                    echo $form->field($CaraBayar, 'tgl_bulan', [
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

                                    echo '<div id="div-cara-bayar-tgl_tahun" style="display: none;">';
                                    echo $form->field($CaraBayar, 'tgl_tahun', [
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
    <div class="col-lg-12">
        <div class="card card-primary card-outline">
            <div class="card-body">
                <div id="accordion">
                    <div class="card">
                        <div class="card-header bg-lightblue">
                            <h5 class="mb-0">
                                DATA KEADAAN MORBIDITAS PASIEN RAWAT INAP RUMAH SAKIT (Formulir RL 4.A)
                            </h5>
                        </div>

                        <div class="card-body">
                            <?php $form = ActiveForm::begin([
                                'action' => ['/analisa-kuantitatif/pengolahan-data-laporan'],
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
                                    echo $form->field($MorbiditasPasienRawatInapRumahSakit, 'jenis_laporan', ['options' => ['required' => 'required']])->inline()->radioList(
                                        [
                                            'harian' => 'Harian',
                                            'bulanan' => 'Bulanan',
                                            'tahunan' => 'Tahunan',
                                        ],
                                        [
                                            'item' => static function ($index, $label, $name, $checked, $value) use ($MorbiditasPasienRawatInapRumahSakit) {
                                                return Helper::radioList($index, $label, $name, $checked, $value, $MorbiditasPasienRawatInapRumahSakit);
                                            }
                                        ]
                                    )->label('Jenis Laporan');
                                    ?>

                                    <?php
                                    echo '<div id="div-morbiditas-pasien-rawat-inap-rumah-sakit-tgl_hari">';
                                    echo $form->field($MorbiditasPasienRawatInapRumahSakit, 'tgl_hari', [
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

                                    echo '<div id="div-morbiditas-pasien-rawat-inap-rumah-sakit-tgl_bulan" style="display: none;">';
                                    echo $form->field($MorbiditasPasienRawatInapRumahSakit, 'tgl_bulan', [
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

                                    echo '<div id="div-morbiditas-pasien-rawat-inap-rumah-sakit-tgl_tahun" style="display: none;">';
                                    echo $form->field($MorbiditasPasienRawatInapRumahSakit, 'tgl_tahun', [
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
    <div class="col-lg-12">
        <div class="card card-primary card-outline">
            <div class="card-body">
                <div id="accordion">
                    <div class="card">
                        <div class="card-header bg-lightblue">
                            <h5 class="mb-0">
                                DATA KEADAAN MORBIDITAS PASIEN RAWAT INAP RUMAH SAKIT (Formulir RL 4A)
                                PENYEBAB KECELAKAAN
                            </h5>
                        </div>

                        <div class="card-body">
                            <?php $form = ActiveForm::begin([
                                'action' => ['/analisa-kuantitatif/pengolahan-data-laporan'],
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
                                    echo $form->field($MorbiditasPasienRawatInapRumahSakitPenyebabKecelakaan, 'jenis_laporan', ['options' => ['required' => 'required']])->inline()->radioList(
                                        [
                                            'harian' => 'Harian',
                                            'bulanan' => 'Bulanan',
                                            'tahunan' => 'Tahunan',
                                        ],
                                        [
                                            'item' => static function ($index, $label, $name, $checked, $value) use ($MorbiditasPasienRawatInapRumahSakitPenyebabKecelakaan) {
                                                return Helper::radioList($index, $label, $name, $checked, $value, $MorbiditasPasienRawatInapRumahSakitPenyebabKecelakaan);
                                            }
                                        ]
                                    )->label('Jenis Laporan');
                                    ?>

                                    <?php
                                    echo '<div id="div-morbiditas-pasien-rawat-inap-rumah-sakit-penyebab-kecelakaan-tgl_hari">';
                                    echo $form->field($MorbiditasPasienRawatInapRumahSakitPenyebabKecelakaan, 'tgl_hari', [
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

                                    echo '<div id="div-morbiditas-pasien-rawat-inap-rumah-sakit-penyebab-kecelakaan-tgl_bulan" style="display: none;">';
                                    echo $form->field($MorbiditasPasienRawatInapRumahSakitPenyebabKecelakaan, 'tgl_bulan', [
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

                                    echo '<div id="div-morbiditas-pasien-rawat-inap-rumah-sakit-penyebab-kecelakaan-tgl_tahun" style="display: none;">';
                                    echo $form->field($MorbiditasPasienRawatInapRumahSakitPenyebabKecelakaan, 'tgl_tahun', [
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
    <div class="col-lg-12">
        <div class="card card-primary card-outline">
            <div class="card-body">
                <div id="accordion">
                    <div class="card">
                        <div class="card-header bg-lightblue">
                            <h5 class="mb-0">
                                DATA KEADAAN MORBIDITAS PASIEN RAWAT JALAN RUMAH SAKIT (Formulir RL 4.B)
                            </h5>
                        </div>

                        <div class="card-body">
                            <?php $form = ActiveForm::begin([
                                'action' => ['/analisa-kuantitatif/pengolahan-data-laporan'],
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
                                    echo $form->field($MorbiditasPasienRawatJalanRumahSakit, 'jenis_laporan', ['options' => ['required' => 'required']])->inline()->radioList(
                                        [
                                            'harian' => 'Harian',
                                            'bulanan' => 'Bulanan',
                                            'tahunan' => 'Tahunan',
                                        ],
                                        [
                                            'item' => static function ($index, $label, $name, $checked, $value) use ($MorbiditasPasienRawatJalanRumahSakit) {
                                                return Helper::radioList($index, $label, $name, $checked, $value, $MorbiditasPasienRawatJalanRumahSakit);
                                            }
                                        ]
                                    )->label('Jenis Laporan');
                                    ?>

                                    <?php
                                    echo '<div id="div-morbiditas-pasien-rawat-jalan-rumah-sakit-tgl_hari">';
                                    echo $form->field($MorbiditasPasienRawatJalanRumahSakit, 'tgl_hari', [
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

                                    echo '<div id="div-morbiditas-pasien-rawat-jalan-rumah-sakit-tgl_bulan" style="display: none;">';
                                    echo $form->field($MorbiditasPasienRawatJalanRumahSakit, 'tgl_bulan', [
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

                                    echo '<div id="div-morbiditas-pasien-rawat-jalan-rumah-sakit-tgl_tahun" style="display: none;">';
                                    echo $form->field($MorbiditasPasienRawatJalanRumahSakit, 'tgl_tahun', [
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
    <div class="col-lg-12">
        <div class="card card-primary card-outline">
            <div class="card-body">
                <div id="accordion">
                    <div class="card">
                        <div class="card-header bg-lightblue">
                            <h5 class="mb-0">
                                DATA KEADAAN MORBIDITAS PASIEN RAWAT JALAN RUMAH SAKIT (Formulir RL 4.B)
                                PENYEBAB KECELAKAAN
                            </h5>
                        </div>

                        <div class="card-body">
                            <?php $form = ActiveForm::begin([
                                'action' => ['/analisa-kuantitatif/pengolahan-data-laporan'],
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
                                    echo $form->field($MorbiditasPasienRawatJalanRumahSakitPenyebabKecelakaan, 'jenis_laporan', ['options' => ['required' => 'required']])->inline()->radioList(
                                        [
                                            'harian' => 'Harian',
                                            'bulanan' => 'Bulanan',
                                            'tahunan' => 'Tahunan',
                                        ],
                                        [
                                            'item' => static function ($index, $label, $name, $checked, $value) use ($MorbiditasPasienRawatJalanRumahSakitPenyebabKecelakaan) {
                                                return Helper::radioList($index, $label, $name, $checked, $value, $MorbiditasPasienRawatJalanRumahSakitPenyebabKecelakaan);
                                            }
                                        ]
                                    )->label('Jenis Laporan');
                                    ?>

                                    <?php
                                    echo '<div id="div-morbiditas-pasien-rawat-jalan-rumah-sakit-penyebab-kecelakaan-darurat-tgl_hari">';
                                    echo $form->field($MorbiditasPasienRawatJalanRumahSakitPenyebabKecelakaan, 'tgl_hari', [
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

                                    echo '<div id="div-morbiditas-pasien-rawat-jalan-rumah-sakit-penyebab-kecelakaan-darurat-tgl_bulan" style="display: none;">';
                                    echo $form->field($MorbiditasPasienRawatJalanRumahSakitPenyebabKecelakaan, 'tgl_bulan', [
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

                                    echo '<div id="div-morbiditas-pasien-rawat-jalan-rumah-sakit-penyebab-kecelakaan-darurat-tgl_tahun" style="display: none;">';
                                    echo $form->field($MorbiditasPasienRawatJalanRumahSakitPenyebabKecelakaan, 'tgl_tahun', [
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
    <div class="col-lg-12">
        <div class="card card-primary card-outline">
            <div class="card-body">
                <div id="accordion">
                    <div class="card">
                        <div class="card-header bg-lightblue">
                            <h5 class="mb-0">
                                PENGUNJUNG RUMAH SAKIT (Formulir RL 5.1)
                            </h5>
                        </div>

                        <div class="card-body">
                            <?php $form = ActiveForm::begin([
                                'action' => ['/analisa-kuantitatif/pengolahan-data-laporan-pengunjung-rumah-sakit'],
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
                                    echo $form->field($PengunjungRumahSakit, 'jenis_laporan', ['options' => ['required' => 'required']])->inline()->radioList(
                                        [
                                            'harian' => 'Harian',
                                            'bulanan' => 'Bulanan',
                                            'tahunan' => 'Tahunan',
                                        ],
                                        [
                                            'item' => static function ($index, $label, $name, $checked, $value) use ($PengunjungRumahSakit) {
                                                return Helper::radioList($index, $label, $name, $checked, $value, $PengunjungRumahSakit);
                                            }
                                        ]
                                    )->label('Jenis Laporan');
                                    ?>

                                    <?php
                                    echo '<div id="div-pengunjung-rumah-sakit-tgl_hari">';
                                    echo $form->field($PengunjungRumahSakit, 'tgl_hari', [
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

                                    echo '<div id="div-pengunjung-rumah-sakit-tgl_bulan" style="display: none;">';
                                    echo $form->field($PengunjungRumahSakit, 'tgl_bulan', [
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

                                    echo '<div id="div-pengunjung-rumah-sakit-tgl_tahun" style="display: none;">';
                                    echo $form->field($PengunjungRumahSakit, 'tgl_tahun', [
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
    <div class="col-lg-12">
        <div class="card card-primary card-outline">
            <div class="card-body">
                <div id="accordion">
                    <div class="card">
                        <div class="card-header bg-lightblue">
                            <h5 class="mb-0">
                                KUNJUNGAN RAWAT JALAN (Formulir RL 5.2)
                            </h5>
                        </div>

                        <div class="card-body">
                            <?php $form = ActiveForm::begin([
                                'action' => ['/analisa-kuantitatif/pengolahan-data-laporan'],
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
                                    echo $form->field($KunjunganRawatJalan, 'jenis_laporan', ['options' => ['required' => 'required']])->inline()->radioList(
                                        [
                                            'harian' => 'Harian',
                                            'bulanan' => 'Bulanan',
                                            'tahunan' => 'Tahunan',
                                        ],
                                        [
                                            'item' => static function ($index, $label, $name, $checked, $value) use ($KunjunganRawatJalan) {
                                                return Helper::radioList($index, $label, $name, $checked, $value, $KunjunganRawatJalan);
                                            }
                                        ]
                                    )->label('Jenis Laporan');
                                    ?>

                                    <?php
                                    echo '<div id="div-da-tgl_hari">';
                                    echo $form->field($KunjunganRawatJalan, 'tgl_hari', [
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

                                    echo '<div id="div-da-tgl_bulan" style="display: none;">';
                                    echo $form->field($KunjunganRawatJalan, 'tgl_bulan', [
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

                                    echo '<div id="div-da-tgl_tahun" style="display: none;">';
                                    echo $form->field($KunjunganRawatJalan, 'tgl_tahun', [
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
    <div class="col-lg-12">
        <div class="card card-primary card-outline">
            <div class="card-body">
                <div id="accordion">
                    <div class="card">
                        <div class="card-header bg-lightblue">
                            <h5 class="mb-0">
                                DAFTAR 10 PENYAKIT BESAR RAWAT INAP (Formulir RL 5.3)
                            </h5>
                        </div>

                        <div class="card-body">
                            <?php $form = ActiveForm::begin([
                                'action' => ['/analisa-kuantitatif/pengolahan-data-laporan'],
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
                                    echo $form->field($KunjunganRawatDarurat, 'jenis_laporan', ['options' => ['required' => 'required']])->inline()->radioList(
                                        [
                                            'harian' => 'Harian',
                                            'bulanan' => 'Bulanan',
                                            'tahunan' => 'Tahunan',
                                        ],
                                        [
                                            'item' => static function ($index, $label, $name, $checked, $value) use ($KunjunganRawatDarurat) {
                                                return Helper::radioList($index, $label, $name, $checked, $value, $KunjunganRawatDarurat);
                                            }
                                        ]
                                    )->label('Jenis Laporan');
                                    ?>

                                    <?php
                                    echo '<div id="div-kunjungan-rawat-darurat-tgl_hari">';
                                    echo $form->field($KunjunganRawatDarurat, 'tgl_hari', [
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

                                    echo '<div id="div-kunjungan-rawat-darurat-tgl_bulan" style="display: none;">';
                                    echo $form->field($KunjunganRawatDarurat, 'tgl_bulan', [
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

                                    echo '<div id="div-kunjungan-rawat-darurat-tgl_tahun" style="display: none;">';
                                    echo $form->field($KunjunganRawatDarurat, 'tgl_tahun', [
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
    <div class="col-lg-12">
        <div class="card card-primary card-outline">
            <div class="card-body">
                <div id="accordion">
                    <div class="card">
                        <div class="card-header bg-lightblue">
                            <h5 class="mb-0">
                                DAFTAR 10 PENYAKIT BESAR RAWAT JALAN (Formulir RL 5.4)
                            </h5>
                        </div>

                        <div class="card-body">
                            <?php $form = ActiveForm::begin([
                                'action' => ['/analisa-kuantitatif/pengolahan-data-laporan'],
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
                                    echo $form->field($KunjunganRawatDarurat, 'jenis_laporan', ['options' => ['required' => 'required']])->inline()->radioList(
                                        [
                                            'harian' => 'Harian',
                                            'bulanan' => 'Bulanan',
                                            'tahunan' => 'Tahunan',
                                        ],
                                        [
                                            'item' => static function ($index, $label, $name, $checked, $value) use ($KunjunganRawatDarurat) {
                                                return Helper::radioList($index, $label, $name, $checked, $value, $KunjunganRawatDarurat);
                                            }
                                        ]
                                    )->label('Jenis Laporan');
                                    ?>

                                    <?php
                                    echo '<div id="div-kunjungan-rawat-darurat-tgl_hari">';
                                    echo $form->field($KunjunganRawatDarurat, 'tgl_hari', [
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

                                    echo '<div id="div-kunjungan-rawat-darurat-tgl_bulan" style="display: none;">';
                                    echo $form->field($KunjunganRawatDarurat, 'tgl_bulan', [
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

                                    echo '<div id="div-kunjungan-rawat-darurat-tgl_tahun" style="display: none;">';
                                    echo $form->field($KunjunganRawatDarurat, 'tgl_tahun', [
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
$this->registerJs($this->render('pengolahan-data-index.js'), View::POS_END);
