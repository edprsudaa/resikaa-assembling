<?php

use app\components\HelperGeneralClass;
use app\models\pendaftaran\Registrasi;
use kartik\date\DatePicker;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\pendaftaran\RegistrasiSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Daftar Pasien';
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="row">
    <div class="col-lg-12">
        <div class="card card-primary card-outline">
            <div class="card-body">
                <h3><?= Html::encode($this->title) ?></h3>

                <?php //echo $this->render('_search', ['model' => $searchModel]); 
                ?>
                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'layout' => "{summary}\n{items}\n{pager}",
                    'columns' => [
                        [
                            'class' => 'yii\grid\SerialColumn',
                            'header' => 'NO',
                            'headerOptions' => ['style' => 'width: 2%;text-align: center;color:#6658dd;'],
                            'contentOptions' => ['style' => 'text-align: center'],
                        ],

                        [
                            'attribute' => 'kode',
                            'label' => 'NO REKAM MEDIS',
                            'format' => 'html',
                            'headerOptions' => ['style' => 'width: 10%;text-align: center;color:#6658dd;'],

                            'filter' => Html::activeTextInput($searchModel, 'kode', ['class' => 'form-control', 'autocomplete' => 'off', 'placeholder' => 'Cari : Ketik+Enter'])
                        ],

                        [
                            'attribute' => 'nama',
                            'label' => 'NAMA PASIEN',
                            'format' => 'html',
                            'headerOptions' => ['style' => 'width: 10%;text-align: center;color:#6658dd;'],

                            'filter' => Html::activeTextInput($searchModel, 'nama', ['class' => 'form-control', 'autocomplete' => 'off', 'placeholder' => 'Cari : Ketik+Enter'])
                        ],
                        [
                            'attribute' => 'tgl_lahir',
                            'label' => 'TGL LAHIR PASIEN',
                            'format' => 'html',
                            'headerOptions' => ['style' => 'width: 10%;text-align: center;color:#6658dd;'],

                            'filter' => DatePicker::widget([
                                'model' => $searchModel,
                                'attribute' => 'tgl_lahir',
                                'type' => DatePicker::TYPE_INPUT,
                                'pluginOptions' => [
                                    'autoclose' => true,
                                    'format' => 'yyyy-mm-dd',
                                    'clearBtn' => true,
                                    'autoclose' => true
                                ]
                            ]),
                        ],
                        [
                            'attribute' => 'ibu_nama',
                            'label' => 'NAMA IBU PASIEN',
                            'format' => 'html',
                            'headerOptions' => ['style' => 'width: 10%;text-align: center;color:#6658dd;'],

                            'filter' => Html::activeTextInput($searchModel, 'ibu_nama', ['class' => 'form-control', 'autocomplete' => 'off', 'placeholder' => 'Cari : Ketik+Enter'])
                        ],
                        [
                            'attribute' => 'ayah_nama',
                            'label' => 'NAMA AYAH PASIEN',
                            'format' => 'html',
                            'headerOptions' => ['style' => 'width: 10%;text-align: center;color:#6658dd;'],

                            'filter' => Html::activeTextInput($searchModel, 'ayah_nama', ['class' => 'form-control', 'autocomplete' => 'off', 'placeholder' => 'Cari : Ketik+Enter'])
                        ],



                        [
                            'class' => 'yii\grid\ActionColumn',
                            'header' => 'Aksi',
                            'headerOptions' => ['style' => 'width: 2%;text-align: center;color:#6658dd;'],
                            'contentOptions' => ['style' => 'text-align: center'],
                            'template' => '{pilih}{edit}',
                            'buttons' => [
                                'pilih' => function ($url, $model) {
                                    return Html::a(Html::tag('span', ' History by Kunjungan', ['class' => "nav-icon fas fa-copy", "data-toggle" => "tooltip", "data-placement" => "bottom", "title" => "", "data-original-title" => "Pilih Pasien"]), $url, [
                                        'class' => 'btn btn-success btn-xs',
                                        'target' => '_blank',
                                        'data' => [
                                            // 'confirm' => 'Are you sure you want to delete this item?',
                                            'method' => 'post',
                                        ],
                                    ]);
                                },
                                'edit' => function ($url, $model) {
                                    return Html::a(Html::tag('span', ' History by Dokumen', ['class' => "nav-icon fas fa-book", "data-toggle" => "tooltip", "data-placement" => "bottom", "title" => "", "data-original-title" => "Pilih Pasien"]), $url, [
                                        'class' => 'btn btn-warning btn-xs',
                                        'target' => '_blank',
                                        'data' => [
                                            // 'confirm' => 'Are you sure you want to delete this item?',
                                            'method' => 'post',
                                        ],
                                    ]);
                                },


                            ],
                            'urlCreator' => function ($action, $model, $key, $index) {
                                if ($action === 'pilih') {
                                    $url = \yii\helpers\Url::to(['/history-pasien/list-kunjungan', 'id' => HelperGeneralClass::hashData($model->kode), 'versi' => 1]);
                                    return $url;
                                }

                                if ($action === 'edit') {
                                    $url = \yii\helpers\Url::to(['/history-pasien/list-kunjungan-object', 'id' => HelperGeneralClass::hashData($model->kode), 'versi' => 1]);
                                    return $url;
                                }
                            }
                        ],
                    ],
                    'pager' => [
                        'class' => 'app\components\GridPager',
                    ],
                ]); ?>


            </div>
        </div>
    </div>
</div>