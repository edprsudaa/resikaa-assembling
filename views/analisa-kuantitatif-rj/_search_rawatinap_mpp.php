<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\search\LayananRiSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="layanan-search">
    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1,
            'autocomplete' => 'off'
        ],
    ]); ?>
    <div class="row">
        <div class="col-lg-9">
            <?php echo $form->field($model, 'pasien', ['options' => ['style' => 'margin-bottom: 10px !important;']])->textInput(['placeholder' => 'Ketik Nama / NO.MR / NO.REG Pasien Disini...', 'class' => 'form-control form-control-lg','autofocus' => 'autofocus'])->label(false) ?>
        </div>
        <div class="col-lg-2">
        <?= Html::submitButton('<i class="mdi mdi-account-search"></i> Cari', ['class' => 'btn btn-block btn-lg btn-success waves-effect waves-light',"data-toggle"=>"tooltip","data-placement"=>"bottom","title"=>"","data-original-title"=>"Pencarian Pasien"]) ?>
        </div>
        <div class="col-lg-1">
        <?= Html::a(Html::tag('span', '', ['class' => "mdi mdi-12px mdi-close-thick","data-toggle"=>"tooltip","data-placement"=>"bottom","title"=>"","data-original-title"=>"Reset Pencarian"]), \yii\helpers\Url::to(['/layanan-ri']), [
                                    'class' => 'btn btn-block btn-lg btn-danger waves-effect waves-light'
                                ])?>
        </div>
    </div>
    <?php ActiveForm::end(); ?>
</div>
