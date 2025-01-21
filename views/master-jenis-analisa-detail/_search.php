<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\pengolahandata\MasterJenisAnalisaDetailSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="master-jenis-analisa-detail-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'jenis_analisa_detail_id') ?>

    <?= $form->field($model, 'jenis_analisa_detail_jenis_analisa_id') ?>

    <?= $form->field($model, 'jenis_analisa_detail_item_analisa_id') ?>

    <?= $form->field($model, 'jenis_analisa_detail_aktif') ?>

    <?= $form->field($model, 'jenis_analisa_detail_created_at') ?>

    <?php // echo $form->field($model, 'jenis_analisa_detail_created_by') ?>

    <?php // echo $form->field($model, 'jenis_analisa_detail_updated_at') ?>

    <?php // echo $form->field($model, 'jenis_analisa_detail_updated_by') ?>

    <?php // echo $form->field($model, 'jenis_analisa_detail_deleted_at') ?>

    <?php // echo $form->field($model, 'jenis_analisa_detail_deleted_by') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
