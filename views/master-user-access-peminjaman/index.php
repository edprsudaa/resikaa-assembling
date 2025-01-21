<?php

use app\models\pengolahandata\MasterIpPeminjaman;
use app\models\pengolahandata\MasterItemAnalisa;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\pengolahandata\MasterItemAnalisaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Master Item Analisas';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-12">
                            <?= Html::a('Tambah User Akses Peminjaman', ['create'], ['class' => 'btn btn-success']) ?>

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
                                'attribute' => 'nama_lengkap',
                                'label' => 'Nama Lengkap',
                                'value' => function ($model) {
                                    return $model->pegawai->nama_lengkap . ' (' . $model->pegawai->id_nip_nrp . ')';
                                },
                                'format' => 'ntext',
                            ],
                            [
                                'attribute' => 'ip_address',
                                'label' => 'IP Address',
                                'value' => function ($model) {
                                    return $model->ipPeminjaman->ip_address;
                                },
                                'filter' => Select2::widget([
                                    'model' => $searchModel,
                                    'attribute' => 'ip_address',
                                    'data' => MasterIpPeminjaman::getListIpPeminjaman(),
                                    'options' => [
                                        'placeholder' => 'Pilih IP...'
                                    ],
                                    'pluginOptions' => [
                                        'allowClear' => true
                                    ],
                                ]),
                            ],
                            [
                                'attribute' => 'aktif',
                                'value' => function ($model) {
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
                                'headerOptions' => ['style' => 'min-width:160px'],
                                'class' => 'yii\grid\ActionColumn',
                                'template' => '{view}{update}{delete}{import}',
                                'buttons' => [
                                    'view' => function ($url, $model) {
                                        $viewButton = Html::a('<span class="btn btn-sm btn-default"><b class="fa fa-search-plus"></b></span>', ['view', 'id' => $model['id']], ['title' => 'View', 'id' => 'modal-btn-view']);
                                        if ($model->deleted_at !== null) {
                                            return $viewButton . ' <span class="badge badge-danger">Data telah dihapus</span>';
                                        }
                                        return $viewButton;
                                    },
                                    'update' => function ($url, $model) {
                                        if ($model->deleted_at === null) {
                                            return Html::a('<span class="btn btn-sm btn-default"><b class="fas fa-pencil-alt"></b></span>', ['update', 'id' => $model['id']], ['title' => 'Update', 'id' => 'modal-btn-view']);
                                        }
                                        return '';
                                    },
                                    'delete' => function ($url, $model) {
                                        if ($model->deleted_at === null) {
                                            return Html::a('<span class="btn btn-sm btn-danger"><b class="fa fa-trash"></b></span>', ['delete', 'id' => $model['id']], ['title' => 'Delete', 'class' => '', 'data' => ['confirm' => 'Are you absolutely sure? You will lose all the information about this user with this action.', 'method' => 'post', 'data-pjax' => false]]);
                                        }
                                        return '';
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