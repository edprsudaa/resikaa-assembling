<?php

use app\models\pengolahandata\MasterJenisPelayanan;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\pengolahandata\MasterJenisPelayananSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Master Jenis Pelayanans';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-12">
                            <?= Html::a('Tambah Jenis Pelayanan', ['create'], ['class' => 'btn btn-success']) ?>
                           
                        </div>
                    </div>
                </div>
                <div class="card-body">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'deskripsi:ntext',
            [
                'label' => 'Aktif',
                'attribute'=>'is_active',
                'value' => function ($model){
                    $status = [0 => 'Tidak Aktif', 1 => 'Aktif'];
                    return $status[$model->is_active];
                },
                'filter' => Select2::widget([
                    'model' => $searchModel,
                    'attribute' => 'is_active',
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
                'template' => '{view}{update}{delete}',
                'buttons' => [
                    'view' => function($url, $model) {
                        return Html::a('<span class="btn btn-sm btn-default"><b class="fa fa-search-plus"></b></span>', ['view', 'id' => $model['id']], ['title' => 'View', 'id' => 'modal-btn-view']);
                    },
                    'update' => function($id, $model) {
                        return Html::a('<span class="btn btn-sm btn-default"><b class="fas fa-pencil-alt"></b></span>', ['update', 'id' => $model['id']], ['title' => 'Update', 'id' => 'modal-btn-view']);
                    },
                    'delete' => function($url, $model) {
                        return Html::a('<span class="btn btn-sm btn-danger"><b class="fa fa-trash"></b></span>', ['delete', 'id' => $model['id']], ['title' => 'Delete', 'class' => '', 'data' => ['confirm' => 'Are you absolutely sure ? You will lose all the information about this user with this action.', 'method' => 'post', 'data-pjax' => false],]);
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


