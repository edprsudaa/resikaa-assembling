<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\pengolahandata\MasterItemAnalisa */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Master Item Analisas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="master-item-analisa-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Daftar', ['index', 'id' => $model->id], ['class' => 'btn btn-success']) ?>

        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
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
            'id',
            [
                'attribute' => 'ip_address',
                'label' => 'IP Address',
                'value' => function ($model) {
                    return $model->pegawai ? $model->ipPeminjaman->ip_address : 'N/A';
                },
                'format' => 'ntext',
            ],
            [
                'attribute' => 'pegawai',
                'label' => 'Pegawai',
                'value' => function ($model) {
                    return $model->pegawai ? $model->pegawai->nama_lengkap . ' (' . $model->pegawai->id_nip_nrp . ')' : 'N/A';
                },
                'format' => 'ntext',
            ],
            'aktif',
            'created_at',
            'created_by',
            'updated_at',
            'updated_by',
            'deleted_at',
            'deleted_by',
        ],
    ]) ?>
</div>
</div>