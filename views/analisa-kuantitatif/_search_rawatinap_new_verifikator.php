<?php

use kartik\date\DatePicker;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\search\LayananRjSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="layanan-search">
    <?php $form = ActiveForm::begin([
        'action' => ['list-rawat-inap-verifikator'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1,
            'autocomplete' => 'off'
        ],
    ]); ?>
    <div class="row">
        <div class="col-lg-4">
            <label style="color: white;">.</label>

            <?php echo $form->field($model, 'pasien', ['options' => ['style' => 'margin-bottom: 10px !important;']])->textInput(['placeholder' => 'Ketik Nama / NO.MR / NO.REG Pasien Disini...', 'class' => 'form-control form-control-md', 'autofocus' => 'autofocus', 'value' => Yii::$app->getRequest()->getQueryParam('RegistrasiSearch')['pasien'] ?? ''])->label(false) ?>
        </div>
        <div class="col-lg-2">
            <label>Tgl. Checkout Awal</label>

            <?= DatePicker::widget([
                'name' => 'RegistrasiSearch[tgl_awal]',
                'type' => DatePicker::TYPE_INPUT,
                'value' => (Yii::$app->getRequest()->getQueryParam('RegistrasiSearch')['tgl_awal']) ?? date("Y-m-d"),
                'options' => ['placeholder' => 'Pilih tanggal Awal Analisa ...'],
                'pluginOptions' => [
                    'autoclose' => true,
                    'format' => 'yyyy-mm-dd',
                    'clearBtn' => true
                ]
            ]) ?>
        </div>
        <div class="col-lg-2">
            <label>Tgl. Checkout Akhir</label>

            <?= DatePicker::widget([
                'name' => 'RegistrasiSearch[tgl_akhir]',
                'type' => DatePicker::TYPE_INPUT,
                'value' => Yii::$app->getRequest()->getQueryParam('RegistrasiSearch')['tgl_akhir'] ?? date("Y-m-d"),
                'options' => ['placeholder' => 'Pilih tanggal Akhir Analisa ...'],
                'pluginOptions' => [
                    'autoclose' => true,
                    'format' => 'yyyy-mm-dd',
                    'clearBtn' => true,
                ]
            ]) ?>
        </div>
        
        <div class="col-lg-1">
            <label style="color: white;">.</label>
            <?= Html::submitButton('<i class="mdi"></i> Cari', ['class' => 'btn btn-block btn-success', "data-toggle" => "tooltip", "data-placement" => "bottom", "title" => "", "data-original-title" => "Pencarian Pasien"]) ?>
        </div>
        <div class="col-lg-1">
            <label style="color: white;">.</label>

            <?= Html::a(Html::tag('span', 'Reset', ['class' => "mdi mdi-close-thick", "data-toggle" => "tooltip", "data-placement" => "bottom", "title" => "", "data-original-title" => "Reset Pencarian"]), \yii\helpers\Url::to(['/analisa-kuantitatif/list-rawat-inap-new']), [
                'class' => 'btn btn-block btn-danger'
            ]) ?>
        </div>
    </div>
</div>
<?php ActiveForm::end(); ?>
</div>