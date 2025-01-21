<?php

use app\components\HelperGeneralClass;
use app\models\pendaftaran\Registrasi;
use kartik\date\DatePicker;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

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
                <h1><?= Html::encode($this->title) ?></h1>

               

                <?php // echo $this->render('_search', ['model' => $searchModel]); 
                ?>

                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'layout' => "{summary}\n{items}\n{pager}",
                    'columns' => [
                        [
                            'class' => 'yii\grid\SerialColumn',
                            'header'=>'NO',
                            'headerOptions' => ['style' => 'width: 5%;text-align: center;color:#6658dd;'],
                            'contentOptions' => ['style' => 'text-align: center'],
                        ],

                        [
                            'attribute' => 'pasien',
                            'label' => 'PASIEN',
                            'format' => 'html',
                            'headerOptions' => ['style' => 'width: 17%;text-align: center;color:#6658dd;'],
                            'value' => function ($model) {
                                return $model->pasien['nama'] . '<br/> (RM:'. $model->pasien['kode'] . ')<br/>(Reg:'. $model->kode.')';
                            },
                            'filter' => Html::activeTextInput($searchModel, 'pasien', ['class' => 'form-control', 'autocomplete' => 'off','placeholder'=>'Cari : Ketik+Enter'])
                        ],
                        'pasien_kode',
                        [
                            'attribute' => 'created_at',
                            'label'=>'TGL.MASUK',
                            'format' => 'html',
                            'headerOptions' => ['style' => 'width: 13%;text-align: center;'],
                            'contentOptions' => ['style' => 'text-align: center;'],
                            'value' => function ($model) {
                                return Yii::$app->formatter->asDate($model->created_at) . '<br>' . Yii::$app->formatter->asTime($model->created_at);
                            },
                            'filter' =>DatePicker::widget([
                                'model' => $searchModel,
                                'attribute' => 'tgl_masuk',
                                'type' => DatePicker::TYPE_INPUT,
                                'pluginOptions' => [
                                    'autoclose'=>true,
                                    'format' => 'yyyy-mm-dd'
                                ]
                            ]),
                        ],
                        [
                            'attribute' => 'tgl_keluar',
                            'label'=>'TGL.KELUAR',
                            'format' => 'html',
                            'headerOptions' => ['style' => 'width: 13%;text-align: center;'],
                            'contentOptions' => ['style' => 'text-align: center;'],
                            'value' => function ($model) {
                                return Yii::$app->formatter->asDate($model->tgl_keluar) . '<br>' . Yii::$app->formatter->asTime($model->tgl_keluar);
                            },
                            'filter' =>DatePicker::widget([
                                'model' => $searchModel,
                                'attribute' => 'tgl_keluar',
                                'type' => DatePicker::TYPE_INPUT,
                                'pluginOptions' => [
                                    'autoclose'=>true,
                                    'format' => 'yyyy-mm-dd'
                                ]
                            ]),
                        ],
                        'kiriman_detail_kode',

                        [
                            'class' => 'yii\grid\ActionColumn',
                            'header' => 'PILIH',
                            'headerOptions' => ['style' => 'width: 5%;text-align: center;color:#6658dd;'],
                            'contentOptions' => ['style' => 'text-align: center'],
                            'template' => '{pilih}',
                            'buttons' => [
                                'pilih' => function ($url, $model) {
                                    return Html::a(Html::tag('span', '', ['class' => "nav-icon fas fa-edit text-white","data-toggle"=>"tooltip","data-placement"=>"bottom","title"=>"","data-original-title"=>"Pilih Pasien"]), $url, [
                                        'class' => 'btn btn-success btn-xs',
                                        // 'target'=>'_blank',
                                        'data' => [
                                            // 'confirm' => 'Are you sure you want to delete this item?',
                                            'method' => 'post',
                                        ],
                                    ]);
                                },
                            ],
                            'urlCreator' => function ($action, $model, $key, $index) {
                                if ($action === 'pilih') {
                                    $url = \yii\helpers\Url::to(['/analisa-kuantitatif','id' => HelperGeneralClass::hashData($model->kode)]);
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