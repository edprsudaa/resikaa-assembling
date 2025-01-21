<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\pengolahandata\CatatanMpp $model */

$this->title = 'Create Catatan Mpp';
$this->params['breadcrumbs'][] = ['label' => 'Catatan Mpps', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="catatan-mpp-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
