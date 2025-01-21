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

$this->title = 'Daftar Dokumen Analisa';
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="row">
    <div class="col-lg-12">
        <div class="card card-primary card-outline">
            <div class="card-body">
                <h3><?= Html::encode($this->title) ?></h3>

                <?php //echo $this->render('_search', ['model' => $searchModel]); ?>
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
                            'attribute' => 'pasien',
                            'label' => 'PASIEN',
                            'format' => 'html',
                            'headerOptions' => ['style' => 'width: 10%;text-align: center;color:#6658dd;'],
                            'value' => function ($model) {
                                return $model->pasien['nama'] . '<br/> (RM:' . $model->pasien['kode'] . ')<br/>(Reg:' . $model->kode . ')';
                            },
                            'filter' => Html::activeTextInput($searchModel, 'pasien', ['class' => 'form-control', 'autocomplete' => 'off', 'placeholder' => 'Cari : Ketik+Enter'])
                        ],
                        [
                            'attribute' => 'tgl_masuk',
                            'label' => 'Tanggal Masuk',
                            'format' => 'html',
                            'headerOptions' => ['style' => 'width: 5%;text-align: center;'],
                            'contentOptions' => ['style' => 'text-align: center;'],
                            'value' => function ($model) {
                                return Yii::$app->formatter->asDate($model->tgl_masuk) . '<br>' . Yii::$app->formatter->asTime($model->tgl_masuk);
                            },
                            'filter' => DatePicker::widget([
                                'model' => $searchModel,
                                'attribute' => 'tgl_masuk',
                                'type' => DatePicker::TYPE_INPUT,
                                'pluginOptions' => [
                                    'autoclose' => true,
                                    'format' => 'yyyy-mm-dd'
                                ]
                            ]),
                        ],
                        [
                            'attribute' => 'tgl_keluar',
                            'label' => 'TGL.KELUAR',
                            'format' => 'html',
                            'headerOptions' => ['style' => 'width: 5%;text-align: center;'],
                            'contentOptions' => ['style' => 'text-align: center;'],
                            'value' => function ($model) {
                                return Yii::$app->formatter->asDate($model->tgl_keluar) . '<br>' . Yii::$app->formatter->asTime($model->tgl_keluar);
                            },
                            'filter' => DatePicker::widget([
                                'model' => $searchModel,
                                'attribute' => 'tgl_keluar',
                                'type' => DatePicker::TYPE_INPUT,
                                'pluginOptions' => [
                                    'autoclose' => true,
                                    'format' => 'yyyy-mm-dd'
                                ]
                            ]),
                        ],
                        [
                            'attribute' => 'layanan.pl_id',
                            'label' => 'Pelayanan',
                            'format' => 'html',
                            'headerOptions' => ['style' => 'width: 17%;text-align: center;color:#6658dd;'],
                            'value' => function ($model) {

                                $data = '';
                                foreach ($model->layanan as $no => $item) {
                                    if ($item->jenis_layanan == 1) {
                                        $data .= ($no+1).'. Instalasi Gawat Darurat (IGD) - '.$item->tgl_masuk.'<br>' ?? '';
                                    } elseif ($item->jenis_layanan == 2) {
                                        $data .= ($no+1).'. Rawat Jalan ('.$item->unit->nama.') - '.$item->tgl_masuk.'<br>' ?? '';
                                    } elseif ($item->jenis_layanan == 3) {
                                        $data .= ($no+1).'. Rawat Inap ('.$item->unit->nama.') - '.$item->tgl_masuk.'<br>' ?? '';
                                    } else {
                                        $data .= ($no+1).'. Penunjang ('.$item->unit->nama.') - '.$item->tgl_masuk.'<br>' ?? '';
                                    }
                                }
                                return $data;
                            },
                            // 'filter' => Html::activeTextInput($searchModel, 'layanan.pl_id', ['class' => 'form-control', 'autocomplete' => 'off', 'placeholder' => 'Cari : Ketik+Enter'])
                        ],
                        [
                            'label' => 'Tanggal Analisa',
                            'attribute'=>'status',
                            'format' => 'html',
                            'headerOptions' => ['style' => 'width: 5%;text-align: center;color:#6658dd;'],
                            'value' => function ($model){
                                if ($model->getAnalisaDokumen()->count()>0) {
                                    return $model->analisaDokumen->created_at;
                                } else {
                                    return '-';

                                }
                            },
                            'filter' => DatePicker::widget([
                                'model' => $searchModel,
                                'attribute' => 'created_at',
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
                            'label' => 'Status',
                            'attribute'=>'status',
                            'format' => 'html',
                            'headerOptions' => ['style' => 'width: 5%;text-align: center;color:#6658dd;'],
                            'value' => function ($model){
                                if ($model->getAnalisaDokumen()->count()>0) {
                                    return '<span class="badge bg-success">Sudah di analisa</span>';
                                } else {
                                    return '<span class="badge bg-danger">Belum di analisa</span>';

                                }
                            },
                        ],
                        [
                            'class' => 'yii\grid\ActionColumn',
                            'header' => 'Aksi',
                            'headerOptions' => ['style' => 'width: 2%;text-align: center;color:#6658dd;'],
                            'contentOptions' => ['style' => 'text-align: center'],
                            'template' => '{pilih}{edit}',
                            'buttons' => [
                                'pilih' => function ($url, $model) {
                                    return Html::a(Html::tag('span', '', ['class' => "nav-icon fas fa-edit text-white", "data-toggle" => "tooltip", "data-placement" => "bottom", "title" => "", "data-original-title" => "Pilih Pasien"]), $url, [
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
                                    $url = \yii\helpers\Url::to(['/coding/detail', 'id' => HelperGeneralClass::hashData($model->kode)]);
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