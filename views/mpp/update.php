<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\pengolahandata\CatatanMpp $model */

$this->title = 'Update Catatan Mpp: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Catatan Mpps', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="catatan-mpp-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
