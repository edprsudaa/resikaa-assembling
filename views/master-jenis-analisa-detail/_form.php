<?php

use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\pengolahandata\MasterJenisAnalisaDetail */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="master-jenis-analisa-detail-form">
    <?php $form = ActiveForm::begin(); ?>
    <?= $form->field($model, 'jenis_analisa_detail_jenis_analisa_id')->widget(Select2::className(), [
        'data' =>  ArrayHelper::map($jenisAnalisa, 'jenis_analisa_id', 'jenis_analisa_uraian'),
        //'data' =>  ArrayHelper::map($tindakan,'id','deskripsi'),
        'options' => [
            'placeholder' => 'Pilih Tindakan',
            'class' => 'form-control'
        ],
        'pluginOptions' => [
            // 'allowClear' => true
        ],
    ])
    ?>
    <?= $form->field($model, 'jenis_analisa_detail_item_analisa_id')->widget(Select2::className(), [
        'data' =>  ArrayHelper::map($itemAnalisa, 'item_analisa_id', 'item_analisa_uraian'),
        //'data' =>  ArrayHelper::map($tindakan,'id','deskripsi'),
        'options' => [
            'placeholder' => 'Pilih Tindakan',
            'class' => 'form-control'
        ],
        'pluginOptions' => [
            // 'allowClear' => true
        ],
    ])
    ?>

    <?= $form->field($model, 'jenis_analisa_detail_aktif')->widget(Select2::className(), [
        'data' =>  ['' => 'Pilih Status', '1' => 'Aktif', '0' => 'Tidak Aktif'],
        'options' => [
            'id' => 'Status',
            'placeholder' => 'Pilih Status',
            'class' => 'form-control-sm'
        ],
        'pluginOptions' => [
            // 'allowClear' => true
        ],
    ])
    ?>
    <?= $form->field($model, 'jenis_analisa_detail_rj')->checkbox([
        'label' => 'Rawat Jalan', 'value' => 1,
        'uncheck' => 0
    ]) ?>

    <?= $form->field($model, 'jenis_analisa_detail_ri')->checkbox([
        'label' => 'Rawat Inap', 'value' => 1,
        'uncheck' => 0
    ]) ?>


    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>