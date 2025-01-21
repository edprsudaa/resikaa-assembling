<?php

use yii\helpers\Html;
use yii\grid\GridView;
use kartik\select2\Select2;
use kartik\date\DatePicker;
use app\models\pendaftaran\KelompokUnitLayanan;
use app\components\HelperGeneralClass;
use app\components\HelperSpesialClass;
/* @var $this yii\web\View */
/* @var $searchModel app\models\search\LayananIgdSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Daftar Pasien Rawat Jalan';
$this->params['breadcrumbs'][] = $this->title;
// echo'<pre/>';print_r($dataProvider);die();
?>
<div class="row">
    <div class="col-lg-12">
        <div class="card card-primary card-outline">
            <div class="card-body">
                <h3><?= Html::encode($this->title) ?></h3>

                <?php echo $this->render('_search_rawatjalan_new_coder', ['model' => $searchModel]); ?>
                <br>
                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'layout' => "{items}\n{summary}\n{pager}",
                    'columns' => [
                        [
                            'class' => 'yii\grid\SerialColumn',
                            'header' => 'NO',
                            'headerOptions' => ['style' => 'width: 5%;text-align: center;color:#6658dd;'],
                            'contentOptions' => ['style' => 'text-align: center'],
                        ],
                        [
                            'attribute' => 'pasien',
                            'label' => 'PASIEN',
                            'format' => 'html',
                            'headerOptions' => ['style' => 'width: 17%;text-align: center;color:#6658dd;'],
                            'value' => function ($model) {

                                return $model['nama'] . '<br/> (RM:' . $model['pasien_kode'] . ')<br/>(Reg:' . $model['kode'] . ')';
                            },
                            // 'filter' => Html::activeTextInput($searchModel, 'pasien', ['class' => 'form-control', 'autocomplete' => 'off','placeholder'=>'Cari : Ketik+Enter'])
                        ],
                        [
                            'attribute' => 'tgl_masuk',
                            'label' => 'TGL.MASUK',
                            'format' => 'html',
                            'headerOptions' => ['style' => 'width: 12%;text-align: center;'],
                            'contentOptions' => ['style' => 'text-align: center;'],
                            'value' => function ($model) {
                                return Yii::$app->formatter->asDate($model['tgl_masuk']) . '<br>' . Yii::$app->formatter->asTime($model['tgl_masuk']);
                            },
                            // 'filter' =>DatePicker::widget([
                            //     'model' => $searchModel,
                            //     'attribute' => 'tgl_masuk',
                            //     'type' => DatePicker::TYPE_INPUT,
                            //     'pluginOptions' => [
                            //         'autoclose'=>true,
                            //         'format' => 'yyyy-mm-dd'
                            //     ]
                            // ]),
                        ],
                        [
                            'attribute' => 'unit_kode',
                            'label' => 'UNIT',
                            'format' => 'raw',
                            'headerOptions' => ['style' => 'width: 20%;text-align: center;'],
                            'contentOptions' => ['style' => 'text-align: left;'],
                            'value' => function ($model) {
                                $pg_intarr = $model['poli'];
                                $vals = substr($pg_intarr, 1, -1); // Remove curly brackets
                                $vals = explode(',', $vals);

                                // return ;
                                $listPoli = '';
                                foreach ($vals as $i => $item) {
                                    $listPoli .= ($i + 1) . '. ' . $item . '<br>';
                                }
                                return $listPoli;
                            },
                            // 'filter' => Select2::widget([
                            //     'model' => $searchModel,
                            //     'attribute' => 'unit_kode',
                            //     'data' => HelperSpesialClass::getListRJAksesPegawai()['unit_akses'],
                            //     'options' => ['placeholder' => 'PILIH UNIT'],
                            //     'pluginOptions' => [
                            //         'allowClear' => true,
                            //     ],
                            // ]),
                        ],
                        [
                            'label' => 'Status Claim',
                            'format' => 'html',
                            'headerOptions' => ['style' => 'width: 4%;text-align: center;color:#6658dd;'],
                            'value' => function ($model) {
                                if ($model['claim']) {
                                    return '<span class="badge bg-success">Sudah Claim</span><br><';
                                } else {
                                    return '<span class="badge bg-danger">Belum di Claim</span>';
                                }
                            },

                        ],
                        [
                            'label' => 'Status Pelaporan',
                            'format' => 'html',
                            'headerOptions' => ['style' => 'width: 4%;text-align: center;color:#6658dd;'],
                            'value' => function ($model) {
                                if ($model['pelaporan']) {
                                    return '<span class="badge bg-success">Sudah Pelaporan</span><br>';
                                } else {
                                    return '<span class="badge bg-danger">Belum di Pelaporan</span>';
                                }
                            },

                        ],



                        [
                            'class' => 'yii\grid\ActionColumn',
                            'header' => 'Aksi',
                            'headerOptions' => ['style' => 'width: 2%;text-align: center;color:#6658dd;'],
                            'contentOptions' => ['style' => 'text-align: center'],
                            'template' => '{icd}{no-verif}{coder}',
                            'buttons' => [


                                // 'no-verif' => function ($url, $model) {
                                //     return Html::a(Html::tag('span', '', ['class' => "nav-icon fa fa-code text-white", "data-toggle" => "tooltip", "data-placement" => "bottom", "title" => "", "data-original-title" => "Coding Claim"]), $url, [
                                //         'class' => 'btn btn-warning btn-xs',
                                //         // 'target'=>'_blank',
                                //         'data' => [
                                //             // 'confirm' => 'Are you sure you want to delete this item?',
                                //             'method' => 'post',
                                //         ],
                                //     ]);
                                // },
                                'coder' => function ($url, $model) {
                                    return Html::a(Html::tag('span', '', ['class' => "nav-icon fa fa-book text-white", "data-toggle" => "tooltip", "data-placement" => "bottom", "title" => "", "data-original-title" => "Coding Pelaporan"]), $url, [
                                        'class' => 'btn btn-danger btn-xs',
                                        'target' => '_blank',
                                        'data' => [
                                            // 'confirm' => 'Are you sure you want to delete this item?',
                                            'method' => 'post',
                                        ],
                                    ]);
                                },





                            ],
                            'urlCreator' => function ($action, $model, $key, $index) {

                                if ($action === 'icd') {
                                    $url = \yii\helpers\Url::to(['/analisa-kuantitatif/detail-coder-claim-rj', 'id' => HelperGeneralClass::hashData($model['kode']), 'icd' => true]);
                                    return $url;
                                }
                                if ($action === 'no-verif') {
                                    $url = \yii\helpers\Url::to(['/analisa-kuantitatif/detail-coder-claim-rj-no-verif', 'id' => HelperGeneralClass::hashData($model['kode']), 'icd' => true]);
                                    return $url;
                                }
                                if ($action === 'coder') {
                                    $url = \yii\helpers\Url::to(['/analisa-kuantitatif/detail-coder-pelaporan-rj', 'id' => HelperGeneralClass::hashData($model['kode']), 'icd' => true]);
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