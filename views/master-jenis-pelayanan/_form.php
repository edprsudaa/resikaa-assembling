<?php

use kartik\select2\Select2;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\pengolahandata\MasterJenisPelayanan */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="master-jenis-pelayanan-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'deskripsi')->textarea(['rows' => 6]) ?>

    <?= $form->field($model,'is_active')->widget(Select2::className(),[
            'data' =>  ['' => 'Pilih Status','1' => 'Aktif','0' => 'Tidak Aktif'],
            'options' => [
                'id'=>'Status',
                'placeholder' => 'Pilih Status',
                'class'=>'form-control-sm'
            ],
            'pluginOptions' => [
                // 'allowClear' => true
            ],
        ]) 
        ?>
   
    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
