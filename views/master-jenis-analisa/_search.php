<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\pengolahandata\MasterJenisAnalisaSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="master-jenis-analisa-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'jenis_analisa_id') ?>

    <?= $form->field($model, 'jenis_analisa_uraian') ?>

    <?= $form->field($model, 'jenis_analisa_aktif') ?>

    <?= $form->field($model, 'jenis_analisa_created_at') ?>

    <?= $form->field($model, 'jenis_analisa_created_by') ?>

    <?php // echo $form->field($model, 'jenis_analisa_updated_at') ?>

    <?php // echo $form->field($model, 'jenis_analisa_updated_by') ?>

    <?php // echo $form->field($model, 'jenis_analisa_deleted_at') ?>

    <?php // echo $form->field($model, 'jenis_analisa_deleted_by') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
