<?php

use app\components\Helper;
use kartik\select2\Select2;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\MedisMTindakanSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Kodefikasi Barang';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-12">
                            <?= Html::a('Tambah Kualifikasi Pendidikan', ['create'], ['class' => 'btn btn-success']) ?>
                           
                        </div>
                    </div>
                </div>
                <div class="card-body">
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'layout' => "{items}\n{summary}\n{pager}",
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],

                [
                    'headerOptions'=>['style'=>'min-width:320px'],    
                    'attribute' => 'Referensi',
                    'value' => function ($model){
                        return Helper::getKualifikasiPendidikan($model->parent_id);
                    },
                    'filter' => Select2::widget([
                        'model' => $searchModel,
                        'attribute' => 'parent_id',
                        'data' => ArrayHelper::map($kualifikasiPendidikan, 'id', 'rumpun'),
                        'options' => [
                            'placeholder' => 'Pilih...'
                        ],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]),
                ],
              
                'uraian:ntext',
                [
                    'attribute'=>'aktif',
                    'value' => function ($model){
                        $status = [0 => 'Tidak Aktif', 1 => 'Aktif'];
                        return $status[$model->aktif];
                    },
                    'filter' => Select2::widget([
                        'model' => $searchModel,
                        'attribute' => 'aktif',
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
                            return Html::a('<span class="btn btn-sm btn-default"><b class="fa fa-search-plus"></b></span>', ['view', 'id' => $model['id']], ['title' => 'View', 'id' => 'modal-btn-view']);
                        },
                        'update' => function($id, $model) {
                            return Html::a('<span class="btn btn-sm btn-default"><b class="fas fa-pencil-alt"></b></span>', ['update', 'id' => $model['id']], ['title' => 'Update', 'id' => 'modal-btn-view']);
                        },
                        'delete' => function($url, $model) {
                            return Html::a('<span class="btn btn-sm btn-danger"><b class="fa fa-trash"></b></span>', ['delete', 'id' => $model['id']], ['title' => 'Delete', 'class' => '', 'data' => ['confirm' => 'Are you absolutely sure ? You will lose all the information about this user with this action.', 'method' => 'post', 'data-pjax' => false],]);
                        },
                        'import' => function($url, $model) {
                            return Html::a('<span class="btn btn-sm btn-warning"><b class="fa fa-upload"></b></span>', ['form-import', 'id' => $model['id']], ['title' => 'Upload', 'id' => 'modal-btn-view']);
                        }
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

