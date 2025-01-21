<?php

use kartik\select2\Select2;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\JsExpression;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\pengolahandata\MasterItemAnalisa */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="master-ip-peminjaman-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, "username")->widget(Select2::classname(), [
        'options' => ['placeholder' => 'Gunakan Untuk Pegawai ...'],
        'initValueText' => ($model->username != null) ? '(' . $model->pegawai->id_nip_nrp . ') ' . $model->pegawai->nama_lengkap : null,
        'pluginOptions' => [
            'allowClear' => true,
            'minimumInputLength' => 2,
            'language' => [
                'errorLoading' => new JsExpression('function () { 
                                return "Menunggu hasil..."; 
                            }'),
                'inputTooShort' => new JsExpression('function () {
                                return "Minimal 2 karakter...";
                            }'),
                'searching' => new JsExpression('function() {
                                return "Mencari...";
                            }'),
            ],
            'ajax' => [
                'url' => Url::to(['pegawai']),
                'type' => 'post',
                'dataType' => 'json',
                'data' => new JsExpression('function(params) {
                                return {term:params.term};
                            }')
            ],
            'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
            'templateResult' => new JsExpression('function(data) { 
                            return data.text  
                        }'),
            'templateSelection' => new JsExpression('function (data) { return data.text; }'),
        ],

    ])->label('<label>Username : <b><span style="font-size: 12px;color: #000000;important;"><u></u></span></b></label>');
    ?>
    <?= $form->field($model, "ip_id")->widget(Select2::classname(), [
        'options' => ['placeholder' => 'Gunakan Untuk Pegawai ...'],
        'initValueText' => ($model->ip_id != null) ? $model->ipPeminjaman->ip_address : null,
        'pluginOptions' => [
            'allowClear' => true,
            'minimumInputLength' => 2,
            'language' => [
                'errorLoading' => new JsExpression('function () { 
                                return "Menunggu hasil..."; 
                            }'),
                'inputTooShort' => new JsExpression('function () {
                                return "Minimal 2 karakter...";
                            }'),
                'searching' => new JsExpression('function() {
                                return "Mencari...";
                            }'),
            ],
            'ajax' => [
                'url' => Url::to(['ip-address']),
                'type' => 'post',
                'dataType' => 'json',
                'data' => new JsExpression('function(params) {
                                return {term:params.term};
                            }')
            ],
            'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
            'templateResult' => new JsExpression('function(data) { 
                            return data.text  
                        }'),
            'templateSelection' => new JsExpression('function (data) { return data.text; }'),
        ],

    ])->label('<label>Ip Komputer : <b><span style="font-size: 12px;color: #000000;important;"><u></u></span></b></label>');
    ?>



    <?= $form->field($model, 'aktif')->widget(Select2::className(), [
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



    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>