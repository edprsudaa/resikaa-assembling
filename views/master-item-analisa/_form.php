<?php

use kartik\select2\Select2;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\pengolahandata\MasterItemAnalisa */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="master-item-analisa-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'item_analisa_uraian')->textarea(['rows' => 6]) ?>
    <?= $form->field($model,'item_analisa_tipe')->widget(Select2::className(),[
            'data' =>  ['' => 'Pilih Tipe','1' => 'Ada / Tidak Ada','0' => 'Lengkap / Tidak Lengkap'],
            'options' => [
                'id'=>'tipe',
                'placeholder' => 'Pilih Tipe',
                'class'=>'form-control-sm'
            ],
            'pluginOptions' => [
                // 'allowClear' => true
            ],
        ]) 
        ?>
    <?= $form->field($model,'item_analisa_aktif')->widget(Select2::className(),[
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
