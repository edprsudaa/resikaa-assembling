<?php

use app\components\Akun;
use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;
use yii\helpers\Url;
use yii\widgets\Pjax;
use kartik\date\DatePicker;
use kartik\select2\Select2;
use app\models\bedahsentral\Log;
use app\components\HelperSpesial;
use app\components\HelperGeneral;
use app\components\HelperSpesialClass;
use yii\web\View;
use yii\web\JsExpression;
use kartik\switchinput\SwitchInput;
use app\models\bedahsentral\LaporanOperasi;
use app\models\bedahsentral\TimOperasi;
use kartik\file\FileInput;
use app\models\bedahsentral\TimOperasiDetail;
use app\models\pendaftaran\KelompokUnitLayanan;

Pjax::begin(['id' => 'pjform', 'timeout' => false]);
$this->registerJs($this->render('_form_update_ready.js'));


?>
<style type="text/css">
  #pengkajian {
    border-top: 2px solid;
    border-bottom: 2px solid;
  }

  .table-form th,
  .table-form td {
    padding: 0.5px;
    /* border: 0.5px solid #3c8dbc; */
  }
</style>

<?php $form = ActiveForm::begin(['id' => 'lap', 'options' => ['enctype' => 'multipart/form-data']]); ?>
<div class="row">
  <div class="col-lg-3">
    <?php echo $this->render('list_resume.php', ['datalist' => $datalist]);
    ?>
  </div>
  <div class="col-lg-9">
    <div class="card card-outline card-info">
      <div class="card-body">
        <table border="0" class="table table-sm table-form">
          <div class="col-sm-12">
            <div class="row">
              <div class="col-sm-2">
                <label><b>Dokter :</b></label>
              </div>
              <div class="col-sm-10">
                <?= HelperSpesialClass::getNamaPegawai($model->dokter) ?>
              </div>
            </div>
            <div class="row">
              <div class="col-sm-12">
                <div class="row">
                  <div class="col-sm-2">
                    <label><b>Anamnesis :</b></label>
                  </div>
                  <div class="col-sm-2">
                    <?php
                    $anamesis = ['Tidak Ada' => 'Tidak Ada'];
                    echo $form->field($model, 'anamesis')->inline(true)->radioList($anamesis)->label(false);
                    ?>
                  </div>
                  <div class="col-sm-8">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <div class="input-group-text">
                            <input value="<?= (!in_array($model->anamesis, $anamesis) && !empty($model->anamesis)) ? $model->anamesis : null ?>" <?= (!in_array($model->anamesis, $anamesis) && !empty($model->anamesis)) ? 'checked' : null ?> type="radio" id="ResumeMedisRj_anamesis_2" name="ResumeMedisRj[anamesis]">
                          </div>
                        </div>
                        <textarea rows="3" id="ResumeMedisRj_anamesis_2_t" class="form-control" placeholder="Sebutkan Jika Ada"><?= (!in_array($model->anamesis, $anamesis) && !empty($model->anamesis)) ? $model->anamesis : null ?></textarea>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-sm-2">
                    <label><b>Pemeriksaan fisik :</b></label>
                  </div>
                  <div class="col-sm-2">
                    <?php
                    $pemeriksaan_fisik = ['Tidak Ada' => 'Tidak Ada'];
                    echo $form->field($model, 'pemeriksaan_fisik')->inline(true)->radioList($pemeriksaan_fisik)->label(false);
                    ?>
                  </div>
                  <div class="col-sm-8">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <div class="input-group-text">
                            <input value="<?= (!in_array($model->pemeriksaan_fisik, $pemeriksaan_fisik) && !empty($model->pemeriksaan_fisik)) ? $model->pemeriksaan_fisik : null ?>" <?= (!in_array($model->pemeriksaan_fisik, $pemeriksaan_fisik) && !empty($model->pemeriksaan_fisik)) ? 'checked' : null ?> type="radio" id="ResumeMedisRj_pemeriksaan_fisik_2" name="ResumeMedisRj[pemeriksaan_fisik]">
                          </div>
                        </div>
                        <textarea rows="3" id="ResumeMedisRj_pemeriksaan_fisik_2_t" class="form-control" placeholder="Sebutkan Jika Ada"><?= (!in_array($model->pemeriksaan_fisik, $pemeriksaan_fisik) && !empty($model->pemeriksaan_fisik)) ? $model->pemeriksaan_fisik : null ?></textarea>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-sm-2">
                <label><b>Kasus :</b></label>
              </div>
              <div class="col-sm-10">
                <?= $form->field($model, 'kasus', ['inputOptions' =>  ['class' => 'form-control']])->inline(true)->radioList(['0' => 'Baru', '1' => 'Lama'])->label(false) ?>
              </div>
            </div>
            <hr style="margin-top:0.5rem !important;margin-bottom:0.5rem !important;" />
            <div class="row">
              <div class="col-sm-6">
                <?= $form->field($model, 'diagnosa')->textarea(['rows' => 21])->label('<b>Diagnosa (TEXT VERSI MEDIS) :</b>'); ?>
              </div>
              <div class="col-sm-6">
                <div class="row">
                  <div class="col-sm-12">
                    <?= $form->field($model, 'diagnosa_utama_id')->widget(Select2::classname(), [
                      'initValueText' => (!$model->isNewRecord && $model->diagutama) ? '(' . $model->diagutama->kode . ')' . $model->diagutama->deskripsi : null,
                      'options' => ['placeholder' => 'Gunakan Untuk Pencarian ICD-10 ...'],
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
                          'url' => Url::to(['icd-10']),
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
                      // 'pluginEvents' => [
                      //     "select2:select" => new JsExpression('function(e) { 
                      //         let icdpilih = e.params.data
                      //         $("#resumemedisri-diagnosa_utama_kode").val(icdpilih.kode)
                      //         $("#resumemedisri-diagnosa_utama_deskripsi").val(icdpilih.deskripsi)
                      //         $("#resumemedisri-diagnosa_utama_kode").focus()
                      //     }'),
                      // ]
                    ])->label('Kode ICD-10/Diagnosa Utama :');
                    ?>
                  </div>
                </div>
                <div class="row">
                  <div class="col-sm-12">
                    <?= $form->field($model, 'diagnosa_tambahan1_id')->widget(Select2::classname(), [
                      'initValueText' => (!$model->isNewRecord  && $model->diagsatu) ? '(' . $model->diagsatu->kode . ')' . $model->diagsatu->deskripsi : null,
                      'options' => ['placeholder' => 'Gunakan Untuk Pencarian ICD-10 ...'],
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
                          'url' => Url::to(['icd-10']),
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
                    ])->label('Kode ICD-10/Diagnosa Tambahan I :');
                    ?>
                  </div>
                </div>
                <div class="row">
                  <div class="col-sm-12">
                    <?= $form->field($model, 'diagnosa_tambahan2_id')->widget(Select2::classname(), [
                      'initValueText' => (!$model->isNewRecord  && $model->diagdua) ? '(' . $model->diagdua->kode . ')' . $model->diagdua->deskripsi : null,
                      'options' => ['placeholder' => 'Gunakan Untuk Pencarian ICD-10 ...'],
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
                          'url' => Url::to(['icd-10']),
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
                    ])->label('Kode ICD-10/Diagnosa Tambahan II :');
                    ?>
                  </div>
                </div>
                <div class="row">
                  <div class="col-sm-12">
                    <?= $form->field($model, 'diagnosa_tambahan3_id')->widget(Select2::classname(), [
                      'options' => ['placeholder' => 'Gunakan Untuk Pencarian ICD-10 ...'],
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
                          'url' => Url::to(['icd-10']),
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
                    ])->label('Kode ICD-10/Diagnosa Tambahan III :');
                    ?>
                  </div>
                </div>
                <div class="row">
                  <div class="col-sm-12">
                    <?= $form->field($model, 'diagnosa_tambahan4_id')->widget(Select2::classname(), [
                      'options' => ['placeholder' => 'Gunakan Untuk Pencarian ICD-10 ...'],
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
                          'url' => Url::to(['icd-10']),
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
                    ])->label('Kode ICD-10/Diagnosa Tambahan IV :');
                    ?>
                  </div>
                </div>
                <div class="row">
                  <div class="col-sm-12">
                    <?= $form->field($model, 'diagnosa_tambahan5_id')->widget(Select2::classname(), [
                      'options' => ['placeholder' => 'Gunakan Untuk Pencarian ICD-10 ...'],
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
                          'url' => Url::to(['icd-10']),
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
                    ])->label('Kode ICD-10/Diagnosa Tambahan V :');
                    ?>
                  </div>
                </div>
              </div>
            </div>
            <hr style="margin-top:0.5rem !important;margin-bottom:0.5rem !important;" />
            <div class="row">
              <div class="col-sm-6">
                <?= $form->field($model, 'tindakan')->textarea(['rows' => 21])->label('<b>Tindakan (TEXT VERSI MEDIS) :</b>'); ?>
              </div>
              <div class="col-sm-6">
                <div class="row">
                  <div class="col-sm-12">
                    <?= $form->field($model, 'tindakan_utama_id')->widget(Select2::classname(), [
                      'initValueText' => (!$model->isNewRecord  && $model->tindutama) ? '(' . $model->tindutama->kode . ')' . $model->tindutama->deskripsi : null,
                      'options' => ['placeholder' => 'Gunakan Untuk Pencarian ICD-9 ...'],
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
                          'url' => Url::to(['icd-9']),
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
                      'pluginEvents' => [
                        // "select2:select" => new JsExpression('function(e) { 
                        //     let icdpilih = e.params.data
                        //     $("#resumemedisri-tindakan_utama_kode").val(icdpilih.kode)
                        //     $("#resumemedisri-tindakan_utama_deskripsi").val(icdpilih.deskripsi)
                        //     $("#resumemedisri-tindakan_utama_kode").focus()
                        // }'),
                      ]
                    ])->label('Kode ICD-9/Tindakan Utama :');
                    ?>
                  </div>
                </div>
                <div class="row">
                  <div class="col-sm-12">
                    <?= $form->field($model, 'tindakan_tambahan1_id')->widget(Select2::classname(), [
                      'initValueText' => (!$model->isNewRecord   && $model->tindsatu) ? '(' . $model->tindsatu->kode . ')' . $model->tindsatu->deskripsi : null,
                      'options' => ['placeholder' => 'Gunakan Untuk Pencarian ICD-9 ...'],
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
                          'url' => Url::to(['icd-9']),
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
                    ])->label('Kode ICD-9/Tindakan Tambahan I :');
                    ?>
                  </div>
                </div>
                <div class="row">
                  <div class="col-sm-12">
                    <?= $form->field($model, 'tindakan_tambahan2_id')->widget(Select2::classname(), [
                      'initValueText' => (!$model->isNewRecord   && $model->tinddua) ? '(' . $model->tinddua->kode . ')' . $model->tinddua->deskripsi : null,
                      'options' => ['placeholder' => 'Gunakan Untuk Pencarian ICD-9 ...'],
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
                          'url' => Url::to(['icd-9']),
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
                    ])->label('Kode ICD-9/Tindakan Tambahan II :');
                    ?>
                  </div>
                </div>
                <div class="row">
                  <div class="col-sm-12">
                    <?= $form->field($model, 'tindakan_tambahan3_id')->widget(Select2::classname(), [
                      'options' => ['placeholder' => 'Gunakan Untuk Pencarian ICD-9 ...'],
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
                          'url' => Url::to(['icd-9']),
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
                    ])->label('Kode ICD-9/Tindakan Tambahan III :');
                    ?>
                  </div>
                </div>
                <div class="row">
                  <div class="col-sm-12">
                    <?= $form->field($model, 'tindakan_tambahan4_id')->widget(Select2::classname(), [
                      'options' => ['placeholder' => 'Gunakan Untuk Pencarian ICD-9 ...'],
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
                          'url' => Url::to(['icd-9']),
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
                    ])->label('Kode ICD-9/Tindakan Tambahan IV :');
                    ?>
                  </div>
                </div>
                <div class="row">
                  <div class="col-sm-12">
                    <?= $form->field($model, 'tindakan_tambahan5_id')->widget(Select2::classname(), [
                      'options' => ['placeholder' => 'Gunakan Untuk Pencarian ICD-9 ...'],
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
                          'url' => Url::to(['icd-9']),
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
                    ])->label('Kode ICD-9/Tindakan Tambahan V :');
                    ?>
                  </div>
                </div>
              </div>
            </div>
            <hr style="margin-top:0.5rem !important;margin-bottom:0.5rem !important;" />
            <div class="row">
              <div class="col-sm-12">
                <div class="row">
                  <div class="col-md-2">
                    <label><b>Terapi :</b></label>
                  </div>
                  <div class="col-md-2">
                    <?php
                    $terapi = ['Tidak Ada' => 'Tidak Ada'];
                    echo $form->field($model, 'terapi')->inline(true)->radioList($terapi)->label(false);
                    ?>
                  </div>
                  <div class="col-md-8">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <div class="input-group-text">
                            <input value="<?= (!in_array($model->terapi, $terapi) && !empty($model->terapi)) ? $model->terapi : null ?>" <?= (!in_array($model->terapi, $terapi) && !empty($model->terapi)) ? 'checked' : null ?> type="radio" id="<?= $model->formName() ?>_terapi_2" name="<?= $model->formName() ?>[terapi]">
                          </div>
                        </div>
                        <textarea rows="10" id="<?= $model->formName() ?>_terapi_2_t" class="form-control" placeholder="Sebutkan Jika Ada"><?= (!in_array($model->terapi, $terapi) && !empty($model->terapi)) ? $model->terapi : null ?></textarea>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-sm-12">
                <div class="row">
                  <div class="col-md-2">
                    <label>Laboratorium :</label>
                  </div>
                  <div class="col-md-2">
                    <?php
                    $lab = ['Tidak Ada' => 'Tidak Ada'];
                    echo $form->field($model, 'lab')->inline(true)->radioList($lab)->label(false);
                    ?>
                  </div>
                  <div class="col-md-8">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <div class="input-group-text">
                            <input value="<?= (!in_array($model->lab, $lab) && !empty($model->lab)) ? $model->lab : null ?>" <?= (!in_array($model->lab, $lab) && !empty($model->lab)) ? 'checked' : null ?> type="radio" id="<?= $model->formName() ?>_lab_2" name="<?= $model->formName() ?>[lab]">
                          </div>
                        </div>
                        <textarea rows="5" id="<?= $model->formName() ?>_lab_2_t" class="form-control" placeholder="Sebutkan Jika Ada"><?= (!in_array($model->lab, $lab) && !empty($model->lab)) ? $model->lab : null ?></textarea>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-sm-12">
                <div class="row">
                  <div class="col-md-2">
                    <label>Radiologi :</label>
                  </div>
                  <div class="col-md-2">
                    <?php
                    $rad = ['Tidak Ada' => 'Tidak Ada'];
                    echo $form->field($model, 'rad')->inline(true)->radioList($lab)->label(false);
                    ?>
                  </div>
                  <div class="col-md-8">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <div class="input-group-text">
                            <input value="<?= (!in_array($model->rad, $rad) && !empty($model->rad)) ? $model->rad : null ?>" <?= (!in_array($model->rad, $rad) && !empty($model->rad)) ? 'checked' : null ?> type="radio" id="<?= $model->formName() ?>_rad_2" name="<?= $model->formName() ?>[rad]">
                          </div>
                        </div>
                        <textarea rows="5" id="<?= $model->formName() ?>_rad_2_t" class="form-control" placeholder="Sebutkan Jika Ada"><?= (!in_array($model->rad, $rad) && !empty($model->rad)) ? $model->rad : null ?></textarea>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-sm-2">
                <label><b>Rencana Tindak Lanjut :</b></label>
              </div>
              <div class="col-sm-10">
                <?= $form->field($model, 'rencana')->textarea(['rows' => 3])->label(false); ?>
              </div>
            </div>
            <label><b>DI ISI JIKA PASIEN KONTROL !!!</b></label>
            <hr style="margin-top:0.5rem !important;margin-bottom:0.5rem !important;" />
            <div class="row">
              <div class="col-sm-2">
                <label>Alasan Kontrol :</label>
              </div>
              <div class="col-sm-10">
                <?= $form->field($model, 'alasan_kontrol')->textarea(['rows' => 2])->label(false); ?>
              </div>
            </div>
            <div class="row">
              <div class="col-sm-2">
                <label>Tgl. Kontrol Poliklinik :</label>
              </div>
              <div class="col-sm-10">
                <div class="row">
                  <div class="col-md-12">
                    <?= $form->field($model, 'tgl_kontrol')->widget(DatePicker::classname(), [
                      'type' => DatePicker::TYPE_INPUT,
                      'pluginOptions' => [
                        'autoclose' => true,
                        'format' => 'yyyy-mm-dd'
                      ]
                    ])->label(false);
                    ?>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-sm-2">
                <label>Poliklinik Tujuan Kontrol :</label>
              </div>
              <div class="col-sm-10">
                <div class="row">
                  <div class="col-md-12">
                    <?= $form->field($model, 'poli_tujuan_kontrol_id')->widget(Select2::classname(), [
                      'data' => HelperSpesialClass::getListUnitLayanan(KelompokUnitLayanan::RJ, false, true),
                      'size' => 'xs',
                      'options' => ['class' => 'form-control input-sm', 'placeholder' => 'Pilih Poliklinik Tujuan Kontrol...'],
                      'pluginOptions' => [
                        'allowClear' => true
                      ],
                    ])->label(false);
                    ?>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-sm-2">
                <label>Alasan Belum dikembali ke faskes :</label>
              </div>
              <div class="col-sm-10">
                <?= $form->field($model, 'alasan')->textarea(['rows' => 2])->label(false); ?>
              </div>
            </div>
            <hr style="margin-top:0.5rem !important;margin-bottom:0.5rem !important;" />
            <div class="row">
              <div class="col-sm-12">
                <div class="row">
                  <div class="col-md-2">
                    <label><b>Keterangan lainya :</b></label>
                  </div>
                  <div class="col-md-2">
                    <?php
                    $keterangan = ['Tidak Ada' => 'Tidak Ada'];
                    echo $form->field($model, 'keterangan')->inline(true)->radioList($keterangan)->label(false);
                    ?>
                  </div>
                  <div class="col-md-8">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <div class="input-group-text">
                            <input value="<?= (!in_array($model->keterangan, $keterangan) && !empty($model->keterangan)) ? $model->keterangan : null ?>" <?= (!in_array($model->keterangan, $keterangan) && !empty($model->keterangan)) ? 'checked' : null ?> type="radio" id="<?= $model->formName() ?>_keterangan_2" name="<?= $model->formName() ?>[keterangan]">
                          </div>
                        </div>
                        <textarea rows="3" id="<?= $model->formName() ?>_keterangan_2_t" class="form-control" placeholder="Sebutkan Jika Ada"><?= (!in_array($model->keterangan, $keterangan) && !empty($model->keterangan)) ? $model->keterangan : null ?></textarea>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </table>
      </div>
    </div>
  </div>
  <div class="col-lg-1">
    <div class="row icon-sticky">
      <div class="col-lg-12">
        <div class="btn-group-vertical">
          <?php
          if (!$model->batal) {

            echo Html::submitButton('<i class="fas fa-save"></i> Simpan', ['class' => 'btn btn-success btn-submit', 'data-subid' => $model->id]);

            if (!$model->tanggal_final) {
              echo Html::button('<i class="fas fa-trash-alt"></i> Hapus', ['class' => 'btn btn-danger btn-hapus-draf', 'data-url' => Url::to(['/laporan-operasi-pasien/save-update-hapus', 'id' => Yii::$app->request->get('id'), 'subid' => $model->id])]);
            } else {
              // URL DOKUMEN BUKAN RME
              $url = Url::to(['/dokter-verifikator-rawat-jalan/print', 'id_dokumen_rme' => HelperGeneral::hashData($model->id_dokumen_rme)]);
              echo Html::button('<i class="fas fa-print"></i> Print', [
                'class' => "btn btn-info btn-cetak-rme",
                'data-url' => $url
              ]);
            }
          } else {
            // echo Html::a('<i class="fas fa-plus-circle"></i> Tambah Baru', ['/laporan-operasi-pasien/create', 'id' => Yii::$app->request->get('id')], ['class' => 'btn btn-primary', 'data-pjax' => 0]);
          }
          echo Html::button('<i class="fas fa-sync"></i> Segarkan', ['class' => 'btn btn-warning btn-segarkan']);
          ?>
        </div>
      </div>
    </div>
  </div>
</div>
<?php ActiveForm::end(); ?>
<?php Pjax::end(); ?>