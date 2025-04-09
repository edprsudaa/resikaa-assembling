<?php

use app\assets\PdfAsset;
use yii\widgets\Pjax;
use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;
use yii\helpers\Url;
use app\components\HelperGeneral;
use app\widgets\PreviewDokumen;
use kartik\switchinput\SwitchInput;

Pjax::begin(['id' => 'pjform', 'timeout' => false]);
PdfAsset::register($this);
$this->registerJs($this->render('view_rme.js'));

$urlDokumen = $viewrme->data->url;

?>
<style type="text/css">
  .table-form th,
  .table-form td {
    padding: 0.5px;
    /* border: 0.5px solid #3c8dbc; */
  }
</style>

<div class="row">
  <div class="col-lg-2">
    <?php echo $this->render('list_resume.php', ['datalist' => $datalist]);
    ?>
  </div>
  <div class="col-lg-9">
    <div class="card card-outline card-info">
      <div class="card-body">
        <div class="col-12 mt-2">
          <div class="row">
            <?= PreviewDokumen::widget(['url' => $urlDokumen]) ?>
          </div>
        </div>
      </div>
    </div>
  </div>

  <?php $form = ActiveForm::begin(['id' => 'lap', 'options' => ['enctype' => 'multipart/form-data']]); ?>
  <div class="col-lg-1">
    <div class="row icon-sticky">
      <div class="col-lg-12">
        <div class="btn-group-vertical">
          <?php
          if (!$model->batal) {
            // URL DOKUMEN RME
            $url = Url::to(['/dokter-verifikator-rawat-inap/print', 'id_dokumen_rme' => HelperGeneral::hashData($model->id_dokumen_rme)]);
            echo Html::button('<i class="fas fa-print"></i> Print', [
              'class' => "btn btn-info btn-cetak-rme",
              'data-url' => $url
            ]);
            if ($cek_manual['sign_finish']) {

              echo Html::a('<i class="fas fa-copy"></i> Copy', ['/dokter-verifikator-rawat-inap/copy', 'id' => Yii::$app->request->get('id'), 'subid' => $model->id], ['class' => 'btn btn-primary', 'data-pjax' => 0]);
            }
          }
          echo Html::button('<i class="fas fa-sync"></i> Segarkan', ['class' => 'btn btn-warning btn-segarkan']);
          ?>
        </div>
      </div>
    </div>
  </div>
  <?php ActiveForm::end(); ?>

</div>

<?php Pjax::end(); ?>