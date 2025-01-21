<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\pengolahandata\MasterJenisAnalisa */

$this->title = 'Update Master Jenis Analisa: ' . $model->jenis_analisa_id;
$this->params['breadcrumbs'][] = ['label' => 'Master Jenis Analisas', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->jenis_analisa_id, 'url' => ['view', 'jenis_analisa_id' => $model->jenis_analisa_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="master-jenis-analisa-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
