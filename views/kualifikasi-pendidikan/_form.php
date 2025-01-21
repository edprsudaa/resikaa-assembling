<?php

use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\MedisMTindakan */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="medis-mtindakan-form box box-primary">
    <?php $form = ActiveForm::begin(); ?>
    <div class="box-body table-responsive">

        <?= $form->field($model,'parent_id')->widget(Select2::className(),[
            'data' =>  ArrayHelper::map($kualifikasiPendidikan, 'id', 'rumpun'),
            //'data' =>  ArrayHelper::map($tindakan,'id','uraian'),
            'options' => [
                'id'=>'kualifikasipendidikan',
                'placeholder' => 'Pilih Pendidikan',
                'class'=>'form-control-sm'
            ],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]) 
        ?>

        <?= $form->field($model, 'uraian')->textarea(['rows' => 6]) ?>

     

        <?= $form->field($model,'aktif')->widget(Select2::className(),[
            'data' =>  ['' => 'Pilih Status','1' => 'Aktif','0' => 'Tidak Aktif'],
            'options' => [
                'id'=>'Status',
                'placeholder' => 'Pilih Status',
                'class'=>'form-control-sm'
            ],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]) 
        ?>

        <!-- <?= $form->field($model, 'created_at')->textInput() ?>

        <?= $form->field($model, 'created_by')->textInput() ?>

        <?= $form->field($model, 'updated_at')->textInput() ?>

        <?= $form->field($model, 'updated_by')->textInput() ?>

        <?= $form->field($model, 'deleted_at')->textInput() ?>

        <?= $form->field($model, 'deleted_by')->textInput() ?> -->

    </div>
    <div class="box-footer">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success btn-flat']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
