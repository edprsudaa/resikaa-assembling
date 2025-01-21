<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\pengolahandata\MasterItemAnalisaSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="master-item-analisa-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'item_analisa_id') ?>

    <?= $form->field($model, 'item_analisa_uraian') ?>

    <?= $form->field($model, 'item_analisa_aktif') ?>

    <?= $form->field($model, 'item_analisa_created_at') ?>

    <?= $form->field($model, 'item_analisa_created_by') ?>

    <?php // echo $form->field($model, 'item_analisa_updated_at') ?>

    <?php // echo $form->field($model, 'item_analisa_updated_by') ?>

    <?php // echo $form->field($model, 'item_analisa_deleted_at') ?>

    <?php // echo $form->field($model, 'item_analisa_deleted_by') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
