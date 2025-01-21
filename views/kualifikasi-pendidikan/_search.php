<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\MedisMTindakanSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="medis-mtindakan-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'tdk_id') ?>

    <?= $form->field($model, 'tdk_parent_id') ?>

    <?= $form->field($model, 'tdk_deskripsi') ?>

    <?= $form->field($model, 'tdk_icd9_kode') ?>

    <?= $form->field($model, 'tdk_icd9_deskripsi') ?>

    <?php // echo $form->field($model, 'tdk_aktif') ?>

    <?php // echo $form->field($model, 'tdk_created_at') ?>

    <?php // echo $form->field($model, 'tdk_created_by') ?>

    <?php // echo $form->field($model, 'tdk_updated_at') ?>

    <?php // echo $form->field($model, 'tdk_updated_by') ?>

    <?php // echo $form->field($model, 'tdk_deleted_at') ?>

    <?php // echo $form->field($model, 'tdk_deleted_by') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
