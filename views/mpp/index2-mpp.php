<?php

use yii\helpers\Html;
use yii\grid\GridView;
use kartik\date\DatePicker;
use app\components\HelperGeneralClass;
use app\components\HelperSpesialClass;
use app\models\medis\Cppt;

$this->title = 'Daftar Pasien Rawatjalan';
$this->params['breadcrumbs'][] = $this->title;
$userLogin=HelperSpesialClass::getUserLogin();
$dokterpass= ['197807022005012006','196910132000032002'];
?>
<div class="row">
    <div class="col-lg-12">
        <div class="layanan-index">
            <?php echo $this->render('_search', ['model' => $searchModel]); ?>
			<?php
			$colums=[
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
							//return $model->registrasi_kode.'<br>'.;
							if($model->registrasi!=NULL){
								if($model->registrasi->pasien!=NULL){
									return $model->registrasi->pasien->nama . '<br/> (RM:'. $model->registrasi->pasien->kode . ')<br/>(Reg:'. $model->registrasi_kode.')';
								}
							}
                            return $model->registrasi_kode;
                        },
                        'filter' => Html::activeTextInput($searchModel, 'pasien', ['class' => 'form-control', 'autocomplete' => 'off','placeholder'=>'Cari : Ketik+Enter'])
                    ],
                    [
                        'attribute' => 'tgl_masuk',
                        'label'=>'TGL.MASUK',
                        'format' => 'html',
                        'headerOptions' => ['style' => 'width: 13%;text-align: center;'],
                        'contentOptions' => ['style' => 'text-align: center;'],
                        'value' => function ($model) {
                            return Yii::$app->formatter->asDate($model->tgl_masuk) . '<br>' . Yii::$app->formatter->asTime($model->tgl_masuk);
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
                        'attribute' => 'unit_kode',
                        'label'=>'UNIT',
                        'format' => 'raw',
                        'headerOptions' => ['style' => 'width: 20%;text-align: center;'],
                        'contentOptions' => ['style' => 'text-align: center;'],
                        'value' => function ($model){
                            return $model->unit->nama . '<br/> (No.Antrian:'. $model->nomor_urut. ')';
                        },
                        'filter' => false,
                    ],
					[
                        'label'=>'CPPT DPJP',
                        'format' => 'raw',
                        'headerOptions' => ['style' => 'width: 5%;text-align: center;'],
                        'contentOptions' => ['style' => 'text-align: center;'],
                        'value' => function ($model)use($userLogin,$dokterpass){
                            if($userLogin['akses_level']==HelperSpesialClass::LEVEL_DOKTER && !in_array($userLogin['username'],$dokterpass)){
								$cppt=Cppt::find()->where(['layanan_id'=>$model->id,'dokter_perawat_id'=>$userLogin['pegawai_id']])->nodraf()->nobatal()->asArray()->one();
                                return (($cppt)?'<span class="badge badge-success badge-pill">Sudah</span>':'<span class="badge badge-danger badge-pill">Belum</span>');
                            }else{
                                return 'unsupport';
                            }
                        }
                    ],
                    // [
                    //     'attribute' => 'unit_asal_kode',
                    //     'label'=>'DARI',
                    //     'headerOptions' => ['style' => 'width: 5%;text-align: center;'],
                    //     'contentOptions' => ['style' => 'text-align: center;'],
                    //     'format' => 'html',
                    //     'value' =>function($model){
                    //         return ((empty($model->unit_asal_kode))?'-':$model->unitAsal->nama);
                    //     },
                    //     'filter' =>false
                    // ],
                    [
                        'class' => 'yii\grid\ActionColumn',
                        'header' => 'PILIH',
                        'headerOptions' => ['style' => 'width: 15%;text-align: center;color:#6658dd;'],
                        'contentOptions' => ['style' => 'text-align: center'],
                        // 'template' => '{pilih} {sbpk} {sbpkv2} {resumerj}',
						'template' => '{pilih} {resumerj}',
                        'buttons' => [
                            'pilih' => function ($url, $model) {
                                return Html::a(Html::tag('span', '', ['class' => "mdi mdi-24px mdi-account-check text-white","data-toggle"=>"tooltip","data-placement"=>"bottom","title"=>"","data-original-title"=>"Pilih Pasien"]), $url, [
                                    'class' => 'btn btn-success btn-xs',
                                    // 'target'=>'_blank',
                                    'data' => [
                                        // 'confirm' => 'Are you sure you want to delete this item?',
                                        'method' => 'post',
                                    ],
                                ]);
                            },
                            'sbpk' => function ($url, $model) {
                                return Html::a(Html::tag('span', 'SBPK', ['class' => "mdi mdi-24px mdi-account-check text-white","data-toggle"=>"tooltip","data-placement"=>"bottom","title"=>"","data-original-title"=>"SBPK Pasien"]), $url, [
                                    'class' => 'btn btn-warning btn-xs',
                                    'target'=>'_blank',
                                    'data' => [
                                        // 'confirm' => 'Are you sure you want to delete this item?',
                                        'method' => 'post',
                                    ],
                                ]);
                            },
							'sbpkv2' => function ($url, $model) {
                                return Html::a(Html::tag('span', 'SBPK(ICD9 V.2010)', ['class' => "mdi mdi-24px mdi-account-check text-white","data-toggle"=>"tooltip","data-placement"=>"bottom","title"=>"","data-original-title"=>"SBPK Pasien"]), $url, [
                                    'class' => 'btn btn-warning btn-xs',
                                    'target'=>'_blank',
                                    'data' => [
                                        // 'confirm' => 'Are you sure you want to delete this item?',
                                        'method' => 'post',
                                    ],
                                ]);
                            },
							'resumerj' => function ($url, $model) {
                                return Html::a(Html::tag('span', 'Resume', ['class' => "mdi mdi-24px mdi-account-check text-white","data-toggle"=>"tooltip","data-placement"=>"bottom","title"=>"","data-original-title"=>"Resume Pasien"]), $url, [
                                    'class' => 'btn btn-warning btn-xs',
                                    'target'=>'_blank',
                                    'data' => [
                                        // 'confirm' => 'Are you sure you want to delete this item?',
                                        'method' => 'post',
                                    ],
                                ]);
                            }
                        ],
                        'urlCreator' => function ($action, $model, $key, $index) {
                            if ($action === 'pilih') {
                                $url = \yii\helpers\Url::to(['/pasien-site', 'id' => HelperGeneralClass::hashData($model->id)]);
                                return $url;
                            }
                            if ($action === 'sbpk') {
                                $url = \yii\helpers\Url::to(['/pasien-site/sbpk', 'id' => HelperGeneralClass::hashData($model->id)]);
                                return $url;
                            }
							if ($action === 'sbpkv2') {
                                $url = \yii\helpers\Url::to(['/pasien-site/sbpkv2', 'id' => HelperGeneralClass::hashData($model->id)]);
                                return $url;
                            }
							if ($action === 'resumerj') {
                                $url = \yii\helpers\Url::to(['/pasien-site/resume-rj', 'id' => HelperGeneralClass::hashData($model->id)]);
                                return $url;
                            }
                            // if ($action === '2params') {
                            //     $url = \yii\helpers\Url::to(['/controllerid/method', 
                            //         'param1' => $model->params1,'params2'=>$model->params2]);
                            //     return $url;
                            // }
                        }
                    ],
                ];
			?>
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'layout' => "{items}\n{summary}\n{pager}",
                'columns' => $colums,
                'pager' => [
                    'class' => 'app\components\GridPager',
                ],
            ]); ?>
        </div>    
    </div> <!-- end col -->
</div>