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


            <?= $form->field($model, 'dokter_verifikator_id')->hiddenInput(['value' => HelperSpesialClass::getUserLogin()['pegawai_id']])->label(false); ?>
            <?= $form->field($model, 'layanan_id')->hiddenInput()->label(false); ?>
            <div class="row">
              <div class="col-sm-6">
                <div class="row">
                  <div class="col-md-3">
                    <label>Dokter DPJP:</label>
                  </div>
                  <div class="col-md-9">
                    <?= $form->field($model, 'dokter_id')->widget(Select2::classname(), [
                      'data' => [HelperSpesialClass::getListDokter(false, true)],
                      'size' => 'xs',
                      'options' => ['class' => 'form-control input-sm', 'placeholder' => 'Pilih Dokter DPJP...', 'required' => true],
                      'value' => 1,
                      'pluginOptions' => [
                        'allowClear' => false,
                        'initialize' => true
                      ],
                    ])->label(false); ?>

                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-sm-6">
                <div class="row">
                  <div class="col-md-3">
                    <label>Tanggal Pulang :</label>
                  </div>
                  <div class="col-md-9">
                    <?= $form->field($model, 'tgl_pulang')->widget(DatePicker::classname(), [
                      'type' => DatePicker::TYPE_INPUT,
                      'pluginOptions' => [
                        'autoclose' => true,
                        'format' => 'yyyy-mm-dd',
                        'value' => $model->tgl_pulang
                      ]
                    ])->label(false);
                    ?>
                  </div>
                </div>
              </div>
              <div class="col-sm-6">
                <div class="row">

                  <div class="col-md-3">
                    <label>Ruangan Layanan Pulang :</label>
                  </div>
                  <div class="col-md-9">
                    <?= $form->field($model, 'layanan_pulang_id')->widget(Select2::classname(), [
                      'data' => HelperSpesialClass::getListRuanganLayanan($model->layanan_id),
                      'size' => 'xs',
                      'options' => ['class' => 'form-control input-sm', 'placeholder' => 'Pilih Ruangan Layanan Pulang...'],
                      'pluginOptions' => [
                        'allowClear' => false
                      ],
                    ])->label(false);
                    ?>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-sm-4">
                <label>Ringkasan Riwayat Penyakit :</label>
                <div class="row">
                  <div class="col-md-12">
                    <?= $form->field($model, 'ringkasan_riwayat_penyakit')->textarea(array('rows' => 10))->label(false); ?>
                  </div>
                </div>
              </div>
              <div class="col-sm-4">
                <label>Hasil Pemeriksaan Fisik Penting & Temuan Lainya :</label>
                <div class="row">
                  <div class="col-md-12">
                    <?= $form->field($model, 'hasil_pemeriksaan_fisik')->textarea(array('rows' => 10))->label(false); ?>
                  </div>
                </div>
              </div>
              <div class="col-sm-4">
                <label>Indikasi Rawat Inap :</label>
                <div class="row">
                  <div class="col-md-12">
                    <?= $form->field($model, 'indikasi_rawat_inap')->textarea(array('rows' => 10))->label(false); ?>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-sm-12">
                <label>Hasil Penunjang(Lab,Radiologi Dan Lain-lainya) :</label>
                <div class="row">
                  <div class="col-lg-12">
                    <?= $form->field($model, 'hasil_penunjang')->textarea(array('rows' => 10))->label(false); ?>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-sm-12">
                <label>Terapi/Pengobatan selama dirawat :</label>
                <div class="row">
                  <div class="col-md-12">
                    <?= $form->field($model, 'terapi_perawatan')->textarea(array('rows' => 10))->label(false); ?>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-sm-2">
                <label>Diagnosa Masuk :</label>
              </div>
              <div class="col-sm-10">
                <div class="row">
                  <div class="col-sm-6">
                    <?= $form->field($model, "diagnosa_masuk_deskripsi")->textInput(['placeholder' => 'Diagnosa Masuk'])->label(false) ?>
                  </div>
                  <div class="col-sm-6">
                    <?= $form->field($model, 'diagnosa_masuk_id')->widget(Select2::classname(), [
                      'initValueText' => ($model->diagmasuk) ? '(' . $model->diagmasuk->kode . ')' . $model->diagmasuk->deskripsi : null,
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
                    ])->label(false);
                    ?>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-sm-2">
                <label>Diagnosa Utama :</label>
              </div>
              <div class="col-sm-10">
                <div class="row">
                  <div class="col-sm-6">
                    <?= $form->field($model, "diagnosa_utama_deskripsi")->textInput(['placeholder' => 'Diagnosa Utama'])->label(false) ?>
                  </div>
                  <div class="col-sm-6">
                    <?= $form->field($model, 'diagnosa_utama_id')->widget(Select2::classname(), [
                      'initValueText' => ($model->diagutama) ? '(' . $model->diagutama->kode . ')' . $model->diagutama->deskripsi : null,
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
                    ])->label(false);
                    ?>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-sm-2">
                <label>Diagnosa Tambahan I :</label>
              </div>
              <div class="col-sm-10">
                <div class="row">
                  <div class="col-sm-6">
                    <?= $form->field($model, "diagnosa_tambahan1_deskripsi")->textInput(['placeholder' => 'Diagnosa Tambahan I'])->label(false) ?>
                  </div>
                  <div class="col-sm-6">
                    <?= $form->field($model, 'diagnosa_tambahan1_id')->widget(Select2::classname(), [
                      'initValueText' => ($model->diagsatu) ? '(' . $model->diagsatu->kode . ')' . $model->diagsatu->deskripsi : null,
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
                    ])->label(false);
                    ?>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-sm-2">
                <label>Diagnosa Tambahan II :</label>
              </div>
              <div class="col-sm-10">
                <div class="row">
                  <div class="col-sm-6">
                    <?= $form->field($model, "diagnosa_tambahan2_deskripsi")->textInput(['placeholder' => 'Diagnosa Tambahan II'])->label(false) ?>
                  </div>
                  <div class="col-sm-6">
                    <?= $form->field($model, 'diagnosa_tambahan2_id')->widget(Select2::classname(), [
                      'initValueText' => ($model->diagdua) ? '(' . $model->diagdua->kode . ')' . $model->diagdua->deskripsi : null,
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
                    ])->label(false);
                    ?>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-sm-2">
                <label>Diagnosa Tambahan III :</label>
              </div>
              <div class="col-sm-10">
                <div class="row">
                  <div class="col-sm-6">
                    <?= $form->field($model, "diagnosa_tambahan3_deskripsi")->textInput(['placeholder' => 'Diagnosa Tambahan III'])->label(false) ?>
                  </div>
                  <div class="col-sm-6">
                    <?= $form->field($model, 'diagnosa_tambahan3_id')->widget(Select2::classname(), [
                      'initValueText' => ($model->diagtiga) ? '(' . $model->diagtiga->kode . ')' . $model->diagtiga->deskripsi : null,
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
                    ])->label(false);
                    ?>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-sm-2">
                <label>Diagnosa Tambahan IV :</label>
              </div>
              <div class="col-sm-10">
                <div class="row">
                  <div class="col-sm-6">
                    <?= $form->field($model, "diagnosa_tambahan4_deskripsi")->textInput(['placeholder' => 'Diagnosa Tambahan IV'])->label(false) ?>
                  </div>
                  <div class="col-sm-6">
                    <?= $form->field($model, 'diagnosa_tambahan4_id')->widget(Select2::classname(), [
                      'initValueText' => ($model->diagempat) ? '(' . $model->diagempat->kode . ')' . $model->diagempat->deskripsi : null,
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
                    ])->label(false);
                    ?>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-sm-2">
                <label>Diagnosa Tambahan V :</label>
              </div>
              <div class="col-sm-10">
                <div class="row">
                  <div class="col-sm-6">
                    <?= $form->field($model, "diagnosa_tambahan5_deskripsi")->textInput(['placeholder' => 'Diagnosa Tambahan V'])->label(false) ?>
                  </div>
                  <div class="col-sm-6">
                    <?= $form->field($model, 'diagnosa_tambahan5_id')->widget(Select2::classname(), [
                      'initValueText' => ($model->diaglima) ? '(' . $model->diaglima->kode . ')' . $model->diaglima->deskripsi : null,
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
                    ])->label(false);
                    ?>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-sm-2">
                <label>Tindakan Utama :</label>
              </div>
              <div class="col-sm-10">
                <div class="row">
                  <div class="col-sm-6">
                    <?= $form->field($model, "tindakan_utama_deskripsi")->textInput(['placeholder' => 'Tindakan Utama'])->label(false) ?>
                  </div>
                  <div class="col-sm-6">
                    <?= $form->field($model, 'tindakan_utama_id')->widget(Select2::classname(), [
                      'initValueText' => ($model->tindutama) ? '(' . $model->tindutama->kode . ')' . $model->tindutama->deskripsi : null,
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
                      'pluginEvents' => []
                    ])->label(false);
                    ?>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-sm-2">
                <label>Tindakan Tambahan I :</label>
              </div>
              <div class="col-sm-10">
                <div class="row">
                  <div class="col-sm-6">
                    <?= $form->field($model, "tindakan_tambahan1_deskripsi")->textInput(['placeholder' => 'Tindakan Tambahan I'])->label(false) ?>
                  </div>
                  <div class="col-sm-6">
                    <?= $form->field($model, 'tindakan_tambahan1_id')->widget(Select2::classname(), [
                      'initValueText' => ($model->tindsatu) ? '(' . $model->tindsatu->kode . ')' . $model->tindsatu->deskripsi : null,
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
                    ])->label(false);
                    ?>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-sm-2">
                <label>Tindakan Tambahan II :</label>
              </div>
              <div class="col-sm-10">
                <div class="row">
                  <div class="col-sm-6">
                    <?= $form->field($model, "tindakan_tambahan2_deskripsi")->textInput(['placeholder' => 'Tindakan Tambahan II'])->label(false) ?>
                  </div>
                  <div class="col-sm-6">
                    <?= $form->field($model, 'tindakan_tambahan2_id')->widget(Select2::classname(), [
                      'initValueText' => ($model->tinddua) ? '(' . $model->tinddua->kode . ')' . $model->tinddua->deskripsi : null,
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
                    ])->label(false);
                    ?>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-sm-2">
                <label>Tindakan Tambahan III :</label>
              </div>
              <div class="col-sm-10">
                <div class="row">
                  <div class="col-sm-6">
                    <?= $form->field($model, "tindakan_tambahan3_deskripsi")->textInput(['placeholder' => 'Tindakan Tambahan III'])->label(false) ?>
                  </div>
                  <div class="col-sm-6">
                    <?= $form->field($model, 'tindakan_tambahan3_id')->widget(Select2::classname(), [
                      'initValueText' => ($model->tindtiga) ? '(' . $model->tindtiga->kode . ')' . $model->tindtiga->deskripsi : null,
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
                    ])->label(false);
                    ?>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-sm-2">
                <label>Tindakan Tambahan IV :</label>
              </div>
              <div class="col-sm-10">
                <div class="row">
                  <div class="col-sm-6">
                    <?= $form->field($model, "tindakan_tambahan4_deskripsi")->textInput(['placeholder' => 'Tindakan Tambahan IV'])->label(false) ?>
                  </div>
                  <div class="col-sm-6">
                    <?= $form->field($model, 'tindakan_tambahan4_id')->widget(Select2::classname(), [
                      'initValueText' => ($model->tindempat) ? '(' . $model->tindempat->kode . ')' . $model->tindempat->deskripsi : null,
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
                    ])->label(false);
                    ?>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-sm-2">
                <label>Tindakan Tambahan V :</label>
              </div>
              <div class="col-sm-10">
                <div class="row">
                  <div class="col-sm-6">
                    <?= $form->field($model, "tindakan_tambahan5_deskripsi")->textInput(['placeholder' => 'Tindakan Tambahan V'])->label(false) ?>
                  </div>
                  <div class="col-sm-6">
                    <?= $form->field($model, 'tindakan_tambahan5_id')->widget(Select2::classname(), [
                      'initValueText' => ($model->tindlima) ? '(' . $model->tindlima->kode . ')' . $model->tindlima->deskripsi : null,
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
                    ])->label(false);
                    ?>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-sm-12">
                <label>Alergi :</label>
                <div class="row">
                  <div class="col-md-2">
                    <?php
                    $alergi = ['Tidak Ada' => 'Tidak Ada'];
                    echo $form->field($model, 'alergi')->inline(true)->radioList($alergi)->label(false);
                    ?>
                  </div>
                  <div class="col-md-10">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <div class="input-group-text">
                            <input value="<?= (!in_array($model->alergi, $alergi) && !empty($model->alergi)) ? $model->alergi : null ?>" <?= (!in_array($model->alergi, $alergi) && !empty($model->alergi)) ? 'checked' : null ?> type="radio" id="ResumeMedisRi_alergi_2" name="ResumeMedisRi[alergi]">
                          </div>
                        </div>
                        <textarea rows="3" id="ResumeMedisRi_alergi_2_t" class="form-control" placeholder="Sebutkan Jika Ada"><?= (!in_array($model->alergi, $alergi) && !empty($model->alergi)) ? $model->alergi : null ?></textarea>
                      </div>
                    </div>
                  </div>
                </div>
                <label>Diet :</label>
                <div class="row">
                  <div class="col-md-2">
                    <?php
                    $diet = ['Tidak Ada' => 'Tidak Ada'];
                    echo $form->field($model, 'diet')->inline(true)->radioList($diet)->label(false);
                    ?>
                  </div>
                  <div class="col-md-10">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <div class="input-group-text">
                            <input value="<?= (!in_array($model->diet, $diet) && !empty($model->diet)) ? $model->diet : null ?>" <?= (!in_array($model->diet, $diet) && !empty($model->diet)) ? 'checked' : null ?> type="radio" id="ResumeMedisRi_diet_2" name="ResumeMedisRi[diet]">
                          </div>
                        </div>
                        <textarea rows="3" id="ResumeMedisRi_diet_2_t" class="form-control" placeholder="Sebutkan Jika Ada"><?= (!in_array($model->diet, $diet) && !empty($model->diet)) ? $model->diet : null ?></textarea>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-sm-12">
                <label>Alasan Pulang :</label>
                <?php
                $alasan_pulang = ['Dengan Persetujuan Dokter' => 'Dengan Persetujuan Dokter', 'Permintaan Sendiri/Keluarga' => 'Permintaan Sendiri/Keluarga', 'Pindah RS Lain' => 'Pindah RS Lain', 'Meninggal' => 'Meninggal'];
                echo $form->field($model, 'alasan_pulang')->inline(true)->radioList($alasan_pulang)->label(false);
                ?>
              </div>
            </div>
            <div class="row">
              <div class="col-sm-12">
                <label>Kondisi Saat Pulang :</label>
                <div class="row">
                  <div class="col-md-6">
                    <?php
                    $kondisi_pulang = ['Sembuh' => 'Sembuh', 'Meninggal < 24 Jam' => 'Meninggal < 24 Jam', 'Meninggal > 24 Jam' => 'Meninggal > 24 Jam'];
                    echo $form->field($model, 'kondisi_pulang')->inline(true)->radioList($kondisi_pulang)->label(false);
                    ?>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <div class="input-group-text">
                            <input value="<?= (!in_array($model->kondisi_pulang, $kondisi_pulang) && !empty($model->kondisi_pulang)) ? $model->kondisi_pulang : null ?>" <?= (!in_array($model->kondisi_pulang, $kondisi_pulang) && !empty($model->kondisi_pulang)) ? 'checked' : null ?> type="radio" id="<?= $model->formName() ?>_kondisi_pulang_4" name="<?= $model->formName() ?>[kondisi_pulang]">
                          </div>
                        </div>
                        <input value="<?= (!in_array($model->kondisi_pulang, $kondisi_pulang) && !empty($model->kondisi_pulang)) ? $model->kondisi_pulang : null ?>" type="text" id="<?= $model->formName() ?>_kondisi_pulang_4_t" class="form-control" placeholder="Jika Lain-lain">
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-sm-12">
                <label>Cara Pulang :</label>
                <div class="row">
                  <div class="col-md-6">
                    <?php
                    $cara_pulang = ['Brankart' => 'Brankart', 'Kursi Roda' => 'Kursi Roda', 'Ambulasi' => 'Ambulasi'];
                    echo $form->field($model, 'cara_pulang')->inline(true)->radioList($cara_pulang)->label(false);
                    ?>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <div class="input-group-text">
                            <input value="<?= (!in_array($model->cara_pulang, $cara_pulang) && !empty($model->cara_pulang)) ? $model->cara_pulang : null ?>" <?= (!in_array($model->cara_pulang, $cara_pulang) && !empty($model->cara_pulang)) ? 'checked' : null ?> type="radio" id="<?= $model->formName() ?>_cara_pulang_4" name="<?= $model->formName() ?>[cara_pulang]">
                          </div>
                        </div>
                        <input value="<?= (!in_array($model->cara_pulang, $cara_pulang) && !empty($model->cara_pulang)) ? $model->cara_pulang : null ?>" type="text" id="<?= $model->formName() ?>_cara_pulang_4_t" class="form-control" placeholder="Jika Lain-lain">
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-1">
                <label>GCS E :</label>
                <?= $form->field($model, "gcs_e")->textInput(['type' => 'number'])->label(false) ?>
              </div>
              <div class="col-md-1">
                <label>GCS M :</label>
                <?= $form->field($model, "gcs_m")->textInput(['type' => 'number'])->label(false) ?>
              </div>
              <div class="col-md-1">
                <label>GCS V :</label>
                <?= $form->field($model, "gcs_v")->textInput(['type' => 'number'])->label(false) ?>
              </div>
              <div class="col-md-2">
                <label>Nadi(x/menit) :</label>
                <?= $form->field($model, "nadi")->textInput(['type' => 'text'])->label(false) ?>
              </div>
              <div class="col-md-2">
                <label>TD(mmHg) :</label>
                <?= $form->field($model, "darah")->textInput(['type' => 'text'])->label(false) ?>
              </div>
              <div class="col-md-2">
                <label>Pernapasan(x/menit) :</label>
                <?= $form->field($model, "pernapasan")->textInput(['type' => 'text'])->label(false) ?>
              </div>
              <div class="col-md-1">
                <label>Suhu(C) :</label>
                <?= $form->field($model, "suhu")->textInput(['type' => 'text'])->label(false) ?>
              </div>
              <div class="col-md-1">
                <label>SatO2(%) :</label>
                <?= $form->field($model, "sato2")->textInput(['type' => 'text'])->label(false) ?>
              </div>
              <div class="col-md-1">
                <label>BB(Kg) :</label>
                <?= $form->field($model, "berat_badan")->textInput(['type' => 'text'])->label(false) ?>
              </div>
            </div>
            <div class="row">
              <div class="col-md-1">
                <label>TB(Cm) :</label>
                <?= $form->field($model, "tinggi_badan")->textInput(['type' => 'text'])->label(false) ?>
              </div>
              <div class="col-md-3">
                <label>Keadaan Gizi :</label>
                <?php
                $keadaan_gizi = ['Baik' => 'Baik', 'Sedang' => 'Sedang', 'Kurang' => 'Kurang'];
                echo $form->field($model, 'keadaan_gizi')->inline(true)->radioList($keadaan_gizi)->label(false);
                ?>
              </div>
              <div class="col-md-3">
                <label>Keadaan Umum :</label>
                <?php
                $keadaan_umum = ['Baik' => 'Baik', 'Sedang' => 'Sedang', 'Buruk' => 'Buruk'];
                echo $form->field($model, 'keadaan_umum')->inline(true)->radioList($keadaan_umum)->label(false);
                ?>
              </div>
              <div class="col-md-5">
                <label>Tingkat Kesadaran :</label>
                <?php
                $tingkat_kesadaran = ['Compos Mentis' => 'Compos Mentis', 'Apatis' => 'Apatis', 'Somnolent' => 'Somnolent', 'Delirium' => 'Delirium', 'Soporo Coma' => 'Soporo Coma', 'Coma' => 'Coma'];
                echo $form->field($model, 'tingkat_kesadaran')->inline(true)->radioList($tingkat_kesadaran)->label(false);
                ?>
              </div>
            </div>
            <div class="row">
              <div class="col-sm-12">
                <label>Obat Rumah :</label>
                <div class="row">
                  <div class="col-md-3">
                    <?php
                    $obat_rumah = ['Tidak Ada' => 'Tidak Ada'];
                    echo $form->field($model, 'obat_rumah')->inline(true)->radioList($obat_rumah)->label(false);
                    ?>
                  </div>
                  <div class="col-md-9">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <div class="input-group-text">
                            <input value="<?= (!in_array($model->obat_rumah, $obat_rumah) && !empty($model->obat_rumah)) ? $model->obat_rumah : null ?>" <?= (!in_array($model->obat_rumah, $obat_rumah) && !empty($model->obat_rumah)) ? 'checked' : null ?> type="radio" id="<?= $model->formName() ?>_obat_rumah_2" name="<?= $model->formName() ?>[obat_rumah]">
                          </div>
                        </div>
                        <textarea rows="10" id="<?= $model->formName() ?>_obat_rumah_2_t" class="form-control" placeholder="Sebutkan Jika Ada"><?= (!in_array($model->obat_rumah, $obat_rumah) && !empty($model->obat_rumah)) ? $model->obat_rumah : null ?></textarea>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-sm-12">
                <label>Terapi Pulang :</label>
                <div class="row">
                  <div class="col-md-3">
                    <?php
                    $terapi_pulang = ['Tidak Ada' => 'Tidak Ada'];
                    echo $form->field($model, 'terapi_pulang')->inline(true)->radioList($terapi_pulang)->label(false);
                    ?>
                  </div>
                  <div class="col-md-9">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <div class="input-group-text">
                            <input value="<?= (!in_array($model->terapi_pulang, $terapi_pulang) && !empty($model->terapi_pulang)) ? $model->terapi_pulang : null ?>" <?= (!in_array($model->terapi_pulang, $terapi_pulang) && !empty($model->terapi_pulang)) ? 'checked' : null ?> type="radio" id="<?= $model->formName() ?>_terapi_pulang_2" name="<?= $model->formName() ?>[terapi_pulang]">
                          </div>
                        </div>
                        <textarea rows="10" id="<?= $model->formName() ?>_terapi_pulang_2_t" class="form-control" placeholder="Sebutkan Jika Ada"><?= (!in_array($model->terapi_pulang, $terapi_pulang) && !empty($model->terapi_pulang)) ? $model->terapi_pulang : null ?></textarea>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-sm-4">
                <label>Tanggal Kontrol Poliklinik :</label>
                <div class="row">
                  <div class="col-md-12">
                    <?= $form->field($model, 'tgl_kontrol')->widget(DatePicker::classname(), [
                      'type' => DatePicker::TYPE_INPUT,
                      'pluginOptions' => [
                        'autoclose' => true,
                        'format' => 'yyyy-mm-dd',
                        'value' => $model->tgl_kontrol
                      ]
                    ])->label(false);
                    ?>
                  </div>
                </div>
              </div>
              <div class="col-sm-4">
                <label>Poliklinik Tujuan Kontrol :</label>
                <div class="row">
                  <div class="col-md-12">
                    <?= $form->field($model, 'poli_tujuan_kontrol_id')->widget(Select2::classname(), [
                      'data' => HelperSpesialClass::getListUnitLayanan(KelompokUnitLayanan::RJ, false, true),
                      'size' => 'xs',
                      'options' => ['class' => 'form-control input-sm', 'placeholder' => 'Pilih Poliklinik Tujuan Kontrol...'],
                      'pluginOptions' => [
                        'allowClear' => false
                      ],
                    ])->label(false);
                    ?>
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
              $url = Url::to(['/dokter-verifikator-rawat-inap/print', 'id_dokumen_rme' => HelperGeneral::hashData($model->id_dokumen_rme)]);
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