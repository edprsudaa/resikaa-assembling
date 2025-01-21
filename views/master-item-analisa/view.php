<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\pengolahandata\MasterItemAnalisa */

$this->title = $model->item_analisa_id;
$this->params['breadcrumbs'][] = ['label' => 'Master Item Analisas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="master-item-analisa-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'item_analisa_id' => $model->item_analisa_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'item_analisa_id' => $model->item_analisa_id], [
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
            'item_analisa_id',
            'item_analisa_uraian:ntext',
            'item_analisa_aktif',
            'item_analisa_created_at',
            'item_analisa_created_by',
            'item_analisa_updated_at',
            'item_analisa_updated_by',
            'item_analisa_deleted_at',
            'item_analisa_deleted_by',
        ],
    ]) ?>
 </div>
</div>
