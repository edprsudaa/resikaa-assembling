<?php

use app\models\pengolahandata\MasterJenisAnalisa;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\pengolahandata\MasterJenisAnalisaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Master Jenis Analisas';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-12">
                            <?= Html::a('Tambah Jenis Analisa', ['create'], ['class' => 'btn btn-success']) ?>
                           
                        </div>
                    </div>
                </div>
                <div class="card-body">

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'jenis_analisa_id',
            'jenis_analisa_uraian:ntext',
            [
                'attribute'=>'jenis_analisa_aktif',
                'value' => function ($model){
                    $status = [0 => 'Tidak Aktif', 1 => 'Aktif'];
                    return $status[$model->jenis_analisa_aktif];
                },
                'filter' => Select2::widget([
                    'model' => $searchModel,
                    'attribute' => 'jenis_analisa_aktif',
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
                'headerOptions'=>['style'=>'min-width:160px'],
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view}{update}{delete}{import}',
                'buttons' => [
                    'view' => function($url, $model) {
                        return Html::a('<span class="btn btn-sm btn-default"><b class="fa fa-search-plus"></b></span>', ['view', 'jenis_analisa_id' => $model['jenis_analisa_id']], ['title' => 'View', 'jenis_analisa_id' => 'modal-btn-view']);
                    },
                    'update' => function($id, $model) {
                        return Html::a('<span class="btn btn-sm btn-default"><b class="fas fa-pencil-alt"></b></span>', ['update', 'jenis_analisa_id' => $model['jenis_analisa_id']], ['title' => 'Update', 'jenis_analisa_id' => 'modal-btn-view']);
                    },
                    'delete' => function($url, $model) {
                        return Html::a('<span class="btn btn-sm btn-danger"><b class="fa fa-trash"></b></span>', ['delete', 'jenis_analisa_id' => $model['jenis_analisa_id']], ['title' => 'Delete', 'class' => '', 'data' => ['confirm' => 'Are you absolutely sure ? You will lose all the information about this user with this action.', 'method' => 'post', 'data-pjax' => false],]);
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