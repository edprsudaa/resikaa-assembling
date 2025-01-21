<?php

use kartik\select2\Select2;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\pengolahandata\MasterJenisAnalisa */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="master-jenis-analisa-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'jenis_analisa_uraian')->textarea(['rows' => 6]) ?>

    <?= $form->field($model,'jenis_analisa_aktif')->widget(Select2::className(),[
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

   

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
