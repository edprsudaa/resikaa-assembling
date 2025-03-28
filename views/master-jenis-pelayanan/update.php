<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\pengolahandata\MasterJenisPelayanan */

$this->title = 'Update Master Jenis Pelayanan: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Master Jenis Pelayanans', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="master-jenis-pelayanan-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
