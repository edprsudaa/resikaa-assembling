<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\MedisMTindakan */

$this->title = 'Update Tindakan: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Tindakan', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="medis-mtindakan-update">

    <?= $this->render('_form', [
        'model' => $model,
        'kualifikasiPendidikan' => $kualifikasiPendidikan,
    ]) ?>

</div>
