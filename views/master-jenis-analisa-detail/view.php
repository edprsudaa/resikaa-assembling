<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\pengolahandata\MasterJenisAnalisaDetail */

$this->title = $model->jenis_analisa_detail_id;
$this->params['breadcrumbs'][] = ['label' => 'Master Jenis Analisa Details', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="master-jenis-analisa-detail-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'jenis_analisa_detail_id' => $model->jenis_analisa_detail_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'jenis_analisa_detail_id' => $model->jenis_analisa_detail_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'jenis_analisa_detail_id',
            'jenis_analisa_detail_jenis_analisa_id:ntext',
            'jenis_analisa_detail_item_analisa_id:ntext',
            'jenis_analisa_detail_aktif',
            'jenis_analisa_detail_created_at',
            'jenis_analisa_detail_created_by',
            'jenis_analisa_detail_updated_at',
            'jenis_analisa_detail_updated_by',
            'jenis_analisa_detail_deleted_at',
            'jenis_analisa_detail_deleted_by',
        ],
    ]) ?>

</div>
