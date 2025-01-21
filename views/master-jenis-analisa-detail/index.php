<?php

use app\models\pengolahandata\MasterJenisAnalisaDetail;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel app\models\pengolahandata\MasterJenisAnalisaDetailSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Master Jenis Analisa Details';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-12">
                            <?= Html::a('Tambah Mapping Jenis Analisa', ['create'], ['class' => 'btn btn-success']) ?>

                        </div>
                    </div>
                </div>
                <div class="card-body">

                    <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                        'filterModel' => $searchModel,
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn'],
                            [
                                'attribute' => 'jenis_analisa_detail_item_analisa_id',
                                'value' => function ($data) {
                                    return $data->jenis_analisa_detail_id ?? '-';
                                },
                                'headerOptions' => ['style' => 'min-width:220px'],
                                'filter' => Select2::widget([
                                    'model' => $searchModel,
                                    'attribute' => 'jenis_analisa_detail_id',
                                    'data' => ArrayHelper::map($itemAnalisa, 'item_analisa_id', 'item_analisa_uraian'),
                                    'options' => [
                                        'placeholder' => 'Pilih...'
                                    ],
                                    'pluginOptions' => [
                                        'allowClear' => true
                                    ],
                                ]),
                            ],
                            [
                                'attribute' => 'jenis_analisa_detail_item_analisa_id',
                                'value' => function ($data) {
                                    return $data->itemAnalisa->item_analisa_uraian ?? '-';
                                },
                                'headerOptions' => ['style' => 'min-width:220px'],
                                'filter' => Select2::widget([
                                    'model' => $searchModel,
                                    'attribute' => 'jenis_analisa_detail_id',
                                    'data' => ArrayHelper::map($itemAnalisa, 'item_analisa_id', 'item_analisa_uraian'),
                                    'options' => [
                                        'placeholder' => 'Pilih...'
                                    ],
                                    'pluginOptions' => [
                                        'allowClear' => true
                                    ],
                                ]),
                            ],
                            [
                                'attribute' => 'jenis_analisa_detail_id',
                                'value' => function ($data) {
                                    return $data->jenisAnalisa->jenis_analisa_uraian;
                                },
                                'headerOptions' => ['style' => 'min-width:220px'],
                                'filter' => Select2::widget([
                                    'model' => $searchModel,
                                    'attribute' => 'jenis_analisa_detail_jenis_analisa_id',
                                    'data' => ArrayHelper::map($jenisAnalisa, 'jenis_analisa_detail_id', 'jenis_analisa_uraian'),
                                    'options' => [
                                        'placeholder' => 'Pilih...'
                                    ],
                                    'pluginOptions' => [
                                        'allowClear' => true
                                    ],
                                ]),
                            ],
                            [
                                'attribute' => 'jenis_analisa_detail_aktif',
                                'value' => function ($model) {
                                    $status = [0 => 'Tidak Aktif', 1 => 'Aktif'];
                                    return $status[$model->jenis_analisa_detail_aktif];
                                },
                                'filter' => Select2::widget([
                                    'model' => $searchModel,
                                    'attribute' => 'jenis_analisa_detail_aktif',
                                    'data' => [1 => 'Aktif', 0 => 'Tidak Aktif'],
                                    'options' => [
                                        'placeholder' => 'Pilih...'
                                    ],
                                    'pluginOptions' => [
                                        'allowClear' => true
                                    ],
                                ]),
                            ],


                            [
                                'headerOptions' => ['style' => 'min-width:160px'],
                                'class' => 'yii\grid\ActionColumn',
                                'template' => '{view}{update}{delete}{import}',
                                'buttons' => [
                                    'view' => function ($url, $model) {
                                        return Html::a('<span class="btn btn-sm btn-default"><b class="fa fa-search-plus"></b></span>', ['view', 'jenis_analisa_detail_id' => $model['jenis_analisa_detail_id']], ['title' => 'View', 'jenis_analisa_detail_id' => 'modal-btn-view']);
                                    },
                                    'update' => function ($id, $model) {
                                        return Html::a('<span class="btn btn-sm btn-default"><b class="fas fa-pencil-alt"></b></span>', ['update', 'jenis_analisa_detail_id' => $model['jenis_analisa_detail_id']], ['title' => 'Update', 'jenis_analisa_detail_id' => 'modal-btn-view']);
                                    },
                                    'delete' => function ($url, $model) {
                                        return Html::a('<span class="btn btn-sm btn-danger"><b class="fa fa-trash"></b></span>', ['delete', 'jenis_analisa_detail_id' => $model['jenis_analisa_detail_id']], ['title' => 'Delete', 'class' => '', 'data' => ['confirm' => 'Are you absolutely sure ? You will lose all the information about this user with this action.', 'method' => 'post', 'data-pjax' => false],]);
                                    },

                                ]
                            ],
                        ],
                        'pager' => [
                            'class' => 'app\components\GridPager',
                        ],
                    ]); ?>
                </div>
                <!--.card-body-->
            </div>
            <!--.card-->
        </div>
        <!--.col-md-12-->
    </div>
    <!--.row-->
</div>