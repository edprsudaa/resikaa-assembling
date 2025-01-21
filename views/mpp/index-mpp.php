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

$this->title = 'Daftar Pasien Rawatinap';
$this->params['breadcrumbs'][] = $this->title;
// echo'<pre/>';print_r($dataProvider);die();
?>
<div class="row">
    <div class="col-lg-12">
        <div class="card card-primary card-outline">
            <div class="card-body">
                <h3><?= Html::encode($this->title) ?></h3>
                <?php
                $isCariDpjp = isset(Yii::$app->request->get('LayananRiSearch')['pjp']) && Yii::$app->request->get('LayananRiSearch')['pjp'] !== '';
                ?>
                <?php echo $this->render('_search_mpp', ['model' => $searchModel]); ?>
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
                                if ($model->registrasi != NULL) {
                                    return ($model->registrasi->pasien != NULL ? $model->registrasi->pasien->nama : '') . '<br/> (RM:' . ($model->registrasi->pasien != NULL ? $model->registrasi->pasien->kode : '') . ')<br/>(Reg:' . $model->registrasi_kode . ')';
                                }
                                return $model->registrasi_kode;
                            },
                            'filter' => Html::activeTextInput($searchModel, 'pasien', ['class' => 'form-control', 'autocomplete' => 'off', 'placeholder' => 'Cari : Ketik+Enter'])
                        ],
                        [
                            'attribute' => 'tgl_masuk',
                            'label' => 'TGL.MASUK',
                            'format' => 'html',
                            'headerOptions' => ['style' => 'width: 13%;text-align: center;'],
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
                            'attribute' => 'unit_kode',
                            'label' => 'UNIT',
                            'format' => 'raw',
                            'headerOptions' => ['style' => 'width: 20%;text-align: center;'],
                            'contentOptions' => ['style' => 'text-align: center;'],
                            'value' => function ($model) {
                                return (($model->unit) ? $model->unit->nama : '') . (($model->kamar) ? '<br/> (No.Kamar:' . $model->kamar->no_kamar . ')' . '<br/> (No.Bed:' . $model->kamar->no_kasur . ')' : '');
                            },
                            'filter' => Select2::widget([
                                'model' => $searchModel,
                                'attribute' => 'unit_kode',
                                'data' => HelperSpesialClass::getListRIAksesPegawaiMpp()['unit_akses'],
                                'options' => ['placeholder' => 'PILIH UNIT'],
                                'pluginOptions' => [
                                    'allowClear' => true,
                                ],
                            ]),
                        ],
                        [
                            'attribute' => 'catatan',
                            'label' => 'Catatan',
                            'format' => 'raw',
                            'headerOptions' => ['style' => 'width: 10%;text-align: center;'],
                            'contentOptions' => ['style' => 'text-align: center;'],
                            'value' => function ($model) {

                                if ($model->catatanMpp) {
                                    return '<span class="badge bg-success">Sudah ada Catatan</span>';
                                } else {
                                    return '<span class="badge bg-danger">Belum Ada catatan</span>';
                                }
                            },

                        ],
                        [
                            'attribute' => 'catatan',
                            'label' => 'Resume Medis',
                            'format' => 'raw',
                            'headerOptions' => ['style' => 'width: 10%;text-align: center;'],
                            'contentOptions' => ['style' => 'text-align: center;'],
                            'value' => function ($model) {

                                if ($model->resumemedisri) {
                                    return '<span class="badge bg-success">Sudah ada Resume</span>';
                                } else {
                                    return '<span class="badge bg-danger">Belum Ada Resume</span>';
                                }
                            },

                        ],
                        [
                            'attribute' => 'pjp',
                            'label' => 'PJP',
                            'headerOptions' => ['style' => 'width: 20%; color: #0168fa;text-align: center;'],
                            'format' => 'raw',
                            'value' => function ($model) use ($isCariDpjp) {
                                $detail = '';
                                if ($model->registrasi != NULL) {
                                    $urut = 1;
                                    foreach ($model->registrasi->pjpRi as $key => $value) {
                                        if ($value->is_deleted == 1) {
                                            continue;
                                        }
                                        $namaDpjp = HelperSpesialClass::getNamaPegawai($value->pegawai);
                                        if ($isCariDpjp) {
                                            $keyword = Yii::$app->request->get('LayananRiSearch')['pjp'];
                                            $namaDpjp = HelperGeneralClass::highlightKeyword($namaDpjp, $keyword);
                                        }
                                        if ($detail) {
                                            $detail .= '</br><u>' . ($urut++) . '. ' . $namaDpjp . ' ' . (($value->status == 1) ? '(Utama)' : '') . '</u>';
                                        } else {
                                            $detail .= '<u>' . ($urut++) . '. ' . $namaDpjp . ' ' . (($value->status == 1) ? '(Utama)' : '') . '</u>';
                                        }
                                    }
                                    if (empty($detail)) {
                                        $detail .= '<u>Belum Tersedia</u>';
                                    }
                                }
                                return $detail;
                            },
                            'filter' => Html::activeTextInput($searchModel, 'pjp', ['class' => 'form-control', 'autocomplete' => 'off', 'placeholder' => 'Cari : Ketik+Enter'])
                        ],
                        [
                            'attribute' => 'tgl_keluar',
                            'label' => 'TGL.KELUAR',
                            'format' => 'html',
                            'headerOptions' => ['style' => 'width: 10%;text-align: center;'],
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
                            'attribute' => 'unit_asal_kode',
                            'label' => 'DARI',
                            'headerOptions' => ['style' => 'width: 5%;text-align: center;'],
                            'contentOptions' => ['style' => 'text-align: center;'],
                            'format' => 'html',
                            'value' => function ($model) {
                                return ((empty($model->unit_asal_kode)) ? '-' : $model->unitAsal->nama);
                            },
                            'filter' => false
                        ],
                        [
                            'attribute' => 'unit_tujuan_kode',
                            'label' => 'KE',
                            'headerOptions' => ['style' => 'width: 5%;text-align: center;'],
                            'contentOptions' => ['style' => 'text-align: center;'],
                            'format' => 'html',
                            'value' => function ($model) {
                                return ((empty($model->unit_tujuan_kode)) ? '-' : $model->unitTujuan->nama);
                            },
                            'filter' => false
                        ],
                        // ['class' => 'app\components\ActionColumnGeneral'],
                        [
                            'class' => 'yii\grid\ActionColumn',
                            'header' => 'PILIH',
                            'headerOptions' => ['style' => 'width: 5%;text-align: center;color:#6658dd;'],
                            'contentOptions' => ['style' => 'text-align: center'],
                            'template' => '{pilih}',
                            'buttons' => [
                                'pilih' => function ($url, $model) {
                                    return Html::a(Html::tag('span', '', ['class' => "fa fa-edit text-white", "data-toggle" => "tooltip", "data-placement" => "bottom", "title" => "", "data-original-title" => "Pilih Pasien"]), $url, [
                                        'class' => 'btn btn-success btn-xs',
                                        // 'target'=>'_blank',
                                        'data' => [
                                            // 'confirm' => 'Are you sure you want to delete this item?',
                                            'method' => 'post',
                                        ],
                                    ]);
                                },
                                'resume_ri' => function ($url, $model) {
                                    return Html::a(Html::tag('span', 'RESUME', ['class' => "mdi mdi-24px mdi-account-check text-white", "data-toggle" => "tooltip", "data-placement" => "bottom", "title" => "", "data-original-title" => "KLIK UNTUK LIHAT RESUME"]), $url, [
                                        'class' => 'btn btn-warning btn-xs',
                                        'target' => '_blank',
                                        'data' => [
                                            // 'confirm' => 'Are you sure you want to delete this item?',
                                            'method' => 'post',
                                        ],
                                    ]);
                                }
                            ],
                            'urlCreator' => function ($action, $model, $key, $index) {
                                if ($action === 'pilih') {
                                    $url =  \yii\helpers\Url::to(['catatan', 'id' => ($model->registrasi ? HelperGeneralClass::hashData($model->registrasi->kode) : 0), 'layanan_id' => $model->id, 'layanan_nama' => $model->unit->nama]);
                                    return $url;
                                }
                                if ($action === 'resume_ri') {
                                    $url = \yii\helpers\Url::to(['/pasien-site/resume-ri', 'id' => HelperGeneralClass::hashData($model->id)]);
                                    return $url;
                                }
                                // if ($action === '2params') {
                                //     $url = \yii\helpers\Url::to(['/controllerid/method', 
                                //         'param1' => $model->params1,'params2'=>$model->params2]);
                                //     return $url;
                                // }
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