<?php

use app\components\DynamicFormWidget;
use app\components\HelperGeneralClass;
use app\components\HelperSpesialClass;
use app\models\medis\Icd10cmv2;
use app\models\pegawai\DmUnitPenempatan;
use app\models\pengolahandata\CodingPelaporanDiagnosaDetailRj;
use app\models\pengolahandata\CodingPelaporanTindakanDetailRj;
use kartik\select2\Select2;
use yii\bootstrap4\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\JsExpression;


// retrieve the form options body
$this->registerJs("
$('#af-CodingPelaporanIgd').on('beforeSubmit',function(e){
    e.preventDefault();
    // Get the value of the estimasi input
    var estimasiValue = $('#estimasi').val();
    
    // Serialize form data
    var formData = $(this).serializeArray();
    
    // Add the estimasi value to the serialized form data
    formData.push({name: 'CodingPelaporanIgd[estimasi]', value: estimasiValue});
    
    // Convert serialized array to query string format
    var formDataString = $.param(formData);
    var btn=$('.btn-submit');
    var htm=btn.html();
    $('body').addClass('loading');
    $('#btn-loading-analisa').attr('style', 'display: block')

    
    $.ajax({
        url:'" . Url::to(['pelaporan-diagnosa-save']) . "',
        type:'post',
        dataType:'json',
        data:formDataString,
        success:function(result){
            if(result.status){
            toastr.success(result.msg);
            }
            if(result.status){
                setTimeout(function () {
                    window.location.reload();
                }, 2000);
            }
            else{
                if(typeof result.msg=='object'){
                    $.each(result.msg,function(i,v){
                        toastr.error(v);
                        $('body').removeClass('loading');
        $('#btn-loading-analisa').attr('style', 'display: none');
        return false;
                    });
                }else{
                    toastr.error(result.msg);
                    $('body').removeClass('loading');
        $('#btn-loading-analisa').attr('style', 'display: none');
        return false;
                }
            }
            // App.ResetLoadingBtn(btn,htm);
        },
        error:function(xhr,status,error){
//             // App.Error(error);
//             // App.ResetLoadingBtn(btn,htm);
        }
    });
}).submit(function(e){
    e.preventDefault();
});


$('#icd9-CodingPelaporanIgd').on('beforeSubmit',function(e){
   
    e.preventDefault();
   
 
    // Get the value of the estimasi input
    var estimasiValue = $('#estimasi').val();
    
    // Serialize form data
    var formData = $(this).serializeArray();
    
    // Add the estimasi value to the serialized form data
    formData.push({name: 'CodingPelaporanIgd[estimasi]', value: estimasiValue});
    
    // Convert serialized array to query string format
    var formDataString = $.param(formData);

    var btn=$('.btn-submit');
    var htm=btn.html();
    $('body').addClass('loading');
    $('#btn-loading-analisa').attr('style', 'display: block')
   
    $.ajax({
        url:'" . Url::to(['pelaporan-tindakan-save']) . "',
        type:'post',
        dataType:'json',
        data:formDataString,
        success:function(result){
            if(result.status){
            toastr.success(result.msg);
            }
            if(result.status){
                setTimeout(function () {
                    window.location.reload();
                }, 2000);
            }
            else{
                if(typeof result.msg=='object'){
                    $.each(result.msg,function(i,v){
                        toastr.error(v);
                        $('body').removeClass('loading');
        $('#btn-loading-analisa').attr('style', 'display: none');
        return false;
                    });
                }else{
                    toastr.error(result.msg);
                    $('body').removeClass('loading');
        $('#btn-loading-analisa').attr('style', 'display: none');
        return false;
                }
            }
            // App.ResetLoadingBtn(btn,htm);
        },
        error:function(xhr,status,error){
//             // App.Error(error);
//             // App.ResetLoadingBtn(btn,htm);
        }
    });
}).submit(function(e){
    e.preventDefault();
});


$('.btn-preview-ringkasan-pulang-igd').click(function(e){
	e.preventDefault();
	var id=$(this).attr('data-id');
    var pasien=$(this).attr('data-pasien');
	if(id){
		$.post('" . Url::to(['preview-ringkasan-pulang-igd']) . "',{id:id,pasien:pasien},function(res){
			$('.mymodal_card_xl_body').html(res);
            $('.mymodal_card_xl').modal('show');
		});
	}
});


");

?>



<div class="card card-primary card-outline">

    <div class="card-header">
        <h5 class="card-title m-0"> ICD-10 & ICD-9 UNTUK LAPORAN</h5>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-lg-4">
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <h5 style="margin-bottom:6px;"><b>Silahkan Pilih Salah Satu Ringkasan Pulang IGD</b></h5>
                    </div>
                    <div class="card-body">

                        <table style="width:100%">
                            <?php
                            if (!empty($listRingkasanPulangIgd)) {
                                foreach ($listRingkasanPulangIgd as $item) {
                            ?>
                                    <tr>
                                        <td><?php
                                            if (!empty($listCoder->id_resume_medis_rj)) {
                                                if ($item->id == $listCoder->id_resume_medis_rj) {
                                                    $status_coder = '<div class="border border-info bg-danger" style="border: 1px solid #e1e1e1fa;padding-left: 4px;"><b>Terpilih Untuk Coding</b></div>';
                                                } else {
                                                    $status_coder = '';
                                                }
                                            } else {
                                                $status_coder = '';
                                            }
                                            ?>


                                            <?= $status_coder; ?>
                                            <div class="border border-info bg-info" style="border: 1px solid #e1e1e1fa;padding-left: 4px;">Nama Dokter : <?= HelperSpesialClass::getNamaPegawaiArray($item->dokter) ?? '' ?> <br>(Resume id: <?= $item->id ?? '' ?>)</div>
                                            <div colspan="3" class="border border-top-0 border-info" style="padding-left: 4px;"><b>Indikasi Masuk IGD : </b><?= $item->indikasi_masuk ?? '-' ?></div>
                                            <div colspan="3" class="border border-top-0 border-info" style="padding-left: 4px;"><b>Keluhan Utama : </b><?= $item->keluhan_utama ?? '' ?></div>
                                            <div colspan="3" class="border border-top-0 border-info" style="padding-left: 4px;"><b>Diagnosa Kerja : </b><?= $item->diagnosa_kerja ?? '' ?></div>
                                            <div colspan="3" class="border border-top-0 border-info" style="padding-left: 4px;"><b>Diagnosa Banding : </b><?= $item->diagnosa_banding ?? '' ?></div>
                                            <div colspan="3" class="border border-top-0 border-info" style="padding-left: 4px;"><b>Tindakan/Prosedur : </b><?= $item->tindakan ?? '' ?></div>



                                        </td>
                                        <td style="vertical-align: top;text-align: left;">
                                            <div class="btn-group-vertical">
                                                <a class="btn btn-success btn-sm btn-preview-ringkasan-pulang-igd" data-id="<?= $item['id'] ?>" data-pasien="<?= $registrasi['pasien']['kode'] ?>" data-nama="<?= $item['id'] ?>"> <i style="color:white" class="fa fa-eye"></i></i></a>
                                                <a class="btn btn-info btn-sm" href="<?= Url::to(['/coder-igd/pelaporan', 'id' => $item['id'], 'icd' => true, 'registrasi_kode' => HelperGeneralClass::hashData($registrasi['kode'])]) ?>" data-id="<?= $item['id'] ?>" data-nama="<?= $item['id'] ?>"> <i style="color:white" class="fa fa-edit"></i></i></a>
                                            </div>
                                        </td>
                                        <td style="vertical-align: top;text-align: left;">
                                            <div class="btn-group-vertical">

                                            </div>
                                        </td>
                                    </tr>
                                <?php
                                }
                            } else {
                                ?>
                                <div class="border border-info bg-info" style="border: 1px solid #e1e1e1fa;padding-left: 4px;">Nama Dokter :</div>

                                <div colspan="3" class="border border-top-0 border-info" style="padding-left: 4px;">Tidak Ada Data</div>
                            <?php } ?>



                        </table>
                    </div>
                </div>
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <h5 style="margin-bottom:6px;">Hasil Coding Dari Coder</h5>
                    </div>
                    <div class="card-body">

                        <table>

                            <?php
                            if (!empty($listCoder)) {
                            ?><tr>
                                    <td>
                                        <div class="border border-info bg-danger" style="border: 1px solid #e1e1e1fa;padding-left: 4px;"><b>Nama Dokter : </b><?= HelperSpesialClass::getNamaPegawaiArray($listCoder->ringkasanPulangIgd->dokter) ?? '' ?><br>Nama Coder : <?= HelperSpesialClass::getNamaPegawaiArray($listCoder->coder) ?? '' ?><br>Tgl Coder : <?= $listCoder->updated_at ?? $listCoder->created_at ?><br>(Resume id: <?= $listCoder->id_ringkasan_pulang_igd ?? '' ?>)</div>
                                        <div colspan="3" class="border border-top-0 border-info" style="padding-left: 4px;"><b>Anamenesis : </b><?= $listCoder->resumeMedis->ringkasan_riwayat_penyakit ?? '' ?></div>
                                        <div colspan="3" class="border border-top-0 border-info" style="padding-left: 4px;"><b>Pemeriksaan Fisik : </b><?= $listCoder->resumeMedis->hasil_pemeriksaan_fisik ?? '' ?></div>
                                        <div colspan="3" class="border border-top-0 border-info" style="padding-left: 4px;"><b>Indikasi Rawat Inap : </b><?= $listCoder->resumeMedis->indikasi_rawat_inap ?? '' ?></div>

                                        <div colspan="3" class="border border-top-0 border-info" style="padding-left: 4px;"><b>Diagnosa : </b><?= $listCoder->resumeMedis->diagnosa ?? '' ?></div>

                                        <div class="border border-warning bg-warning font-weight-bold" style="border: 1px solid #e1e1e1fa;padding-left: 4px;">Diagnosa ICD10:</div>

                                        <?php foreach ($listCoder->pelaporanDiagnosa as $key => $item) {
                                        ?> <?php if ($item->id) { ?>

                                                <div class="border border-info" style="border: 1px solid #e1e1e1fa;padding-left: 4px;"><b>Diagnosa <?= ($key + 1) ?>:</b> <?= $item->diagnosa->kode ?? '' ?> (<?= $item->diagnosa->deskripsi ?? '' ?>) - <b><?= $item->utama == 1 ? 'Utama' : 'Tambahan' ?></b></div>


                                            <?php } ?>
                                        <?php } ?>

                                        <div colspan="3" class="border border-info border-info" style="padding-left: 4px;"><b>Tindakan : </b><?= $listCoder->resumeMedis->tindakan ?? '' ?></div>

                                        <div class="border border-warning bg-warning" style="border: 1px solid #e1e1e1fa;padding-left: 4px;"><b>Tindakan ICD9 : </b></div>
                                        <?php foreach ($listCoder->pelaporanTindakan as $key => $item) {
                                        ?> <?php if ($item->id) { ?>

                                                <div class="border border-info" style="border: 1px solid #e1e1e1fa;padding-left: 4px;"><b>Diagnosa <?= ($key + 1) ?>:</b> <?= $item->tindakan->kode ?? '' ?> (<?= $item->tindakan->deskripsi ?? '' ?>) - <b><?= $item->utama == 1 ? 'Utama' : 'Tambahan' ?></b></div>


                                            <?php } ?>
                                        <?php } ?>

                                        <div colspan="3" class="border border-top-0 border-info" style="padding-left: 4px;"><b>Terapi : </b><?= $listCoder->resumeMedis->terapi ?? '' ?></div>
                                    </td>

                                </tr>
                            <?php
                            } else {
                            ?>
                                <div class="border border-info bg-info" style="border: 1px solid #e1e1e1fa;padding-left: 4px;">Nama Dokter :</div>

                                <div colspan="3" class="border border-top-0 border-info" style="padding-left: 4px;">Tidak Ada Data</div>
                            <?php } ?>

                        </table>
                    </div>
                </div>
            </div>
            <div class="col-lg-8">
                <div class="card card-primary card-outline ">

                    <div class="card-header">
                        <h5 style="margin-bottom:6px;"><b>Coding Pelaporan</b> <a class="btn btn-danger" href="<?= Url::to(['/coder-igd/claim', 'id' => Yii::$app->request->get('id'), 'registrasi_kode' => HelperGeneralClass::hashData($registrasi['kode'])]) ?>"><i style="color: white;" class="fa fa-edit"></i> Buat Coding Klaim</a></h5>
                    </div>
                    <div class="card-body">
                        <div class="tab-content" id="custom-tabs-four-tabContent">
                            <div class="tab-pane fade active show" id="custom-tabs-four-home" role="tabpanel" aria-labelledby="custom-tabs-four-home-tab">

                                <?php $form = ActiveForm::begin([
                                    'id' => 'af-' . $modelCodingPelaporanIgd->formName(),
                                    'options' => [
                                        'name' => 'af-' . $modelCodingPelaporanIgd->formName(),
                                        'data-pjax' => true
                                    ],
                                ]); ?>
                                <?= $form->field($modelCodingPelaporanIgd, 'id_ringkasan_pulang_igd')->hiddenInput(['value' => Yii::$app->request->get('id')])->label(false) ?>

                                <?= $form->field($modelCodingPelaporanIgd, 'registrasi_kode')->hiddenInput(['maxlength' => true, 'value' => $registrasi['kode']])->label(false) ?>
                                <?= $form->field($modelCodingPelaporanIgd, 'jenis_layanan')->hiddenInput(['maxlength' => true, 'value' => 3])->label(false) ?>
                                <?= $form->field($modelCodingPelaporanIgd, 'pegawai_coder_id')->hiddenInput(['maxlength' => true, 'value' => HelperSpesialClass::getUserLogin()['pegawai_id']])->label(false) ?>


                                <div class="panel-heading">
                                    <h4 class="mb-2 text-uppercase bg-light p-2"><i class="fas fa-archive mr-3"></i>I. ICD-10 Laporan (Resume id: <?= $model->id ?? '' ?> ) </h4>
                                </div>
                                <?= $form->field($modelCodingPelaporanIgd, 'estimasi')->textInput(['maxlength' => true, 'type' => 'number', 'step' => '1', 'id' => 'estimasi']) ?>

                                <?= $form->field($modelCodingPelaporanIgd, 'kasus', ['inputOptions' =>  ['class' => 'form-control']])->inline(true)->radioList(['0' => 'Baru', '1' => 'Lama'])->label("Jenis Kasus") ?>
                                <div class="row">
                                    <div class="col-md-12">
                                        <?php DynamicFormWidget::begin([
                                            'widgetContainer' => 'dynamicform_wrapper',
                                            'widgetBody' => '.form-options-body',
                                            'widgetItem' => '.form-options-item',
                                            'min' => 1,
                                            'insertButton' => '.add-item',
                                            'deleteButton' => '.delete-item',
                                            'model' => $modelsPelaporanDiagnosa[0],
                                            'formId' => 'af-' . $modelCodingPelaporanIgd->formName(),
                                            'formFields' => [
                                                'id',
                                                'icd10_id',
                                                'jumlah',
                                                'dosis',
                                                'catatan',
                                                'utama'
                                            ],
                                        ]); ?>
                                        <table class="table-list-item table table-bordered" style="width: 100%;">
                                            <thead class="thead-light" style="text-align: center;">
                                                <th style="width: 98%">Diagnosa</th>
                                                <th style="width: 2%"></th>
                                            </thead>
                                            <tbody class="form-options-body">

                                                <?php foreach ($modelsPelaporanDiagnosa as $i => $modelDetail) : ?>

                                                    <tr class="form-options-item">
                                                        <?php
                                                        // necessary for update action.
                                                        if (!$modelDetail->isNewRecord) {
                                                            echo Html::activeHiddenInput($modelDetail, "[{$i}]id");
                                                        }
                                                        ?>
                                                        <td>
                                                            <?= $form->field($modelDetail, "[{$i}]icd10_id")->widget(Select2::classname(), [
                                                                'options' => ['placeholder' => 'Gunakan Untuk Pencarian ICD-10 ...'],
                                                                'initValueText' => ($modelDetail->diagnosa != null) ? '(' . $modelDetail->diagnosa->kode . ') ' . $modelDetail->diagnosa->deskripsi : null,

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
                                                                'pluginEvents' => [
                                                                    "select2:select" => new JsExpression('function(e) { 
                                                                            let index = $(this).closest("tr").index()
                                                                            if (index == 0) {
                                                                                $($(this).closest("tr"))
                                                                                  .find(".div-fornas")
                                                                                  .html("<span class=\'badge bg-info shadow p-2\'>Dx Utama</span>");
                                                                              } else {
                                                                                $($(this).closest("tr"))
                                                                                  .find(".div-fornas")
                                                                                  .html(
                                                                                    "<span class=\'badge bg-warning shadow p-2\'>Dx Sekunder " +
                                                                                      index +
                                                                                      "</span>"
                                                                                  );
                                                                              }
                                                                    
                                                                    }'),
                                                                ]
                                                            ])->label(false);
                                                            ?>
                                                            <div class="row" style="padding-left: 10px">
                                                                <div class="text-lg div-icd10 mr-2">

                                                                </div>

                                                            </div>

                                                        </td>


                                                        <td class="style-td">
                                                            <button type="button" class="delete-item btn btn-outline-danger btn-xs rounded-pill btn-icon">
                                                                <i class="fa fa-trash fa-xs"></i>
                                                            </button>

                                                        </td>


                                                    </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                            <tfoot>
                                                <tr class="style-td">
                                                    <td style="text-align: center;"></td>
                                                    <td>
                                                        <button type="button" class="add-item btn btn-outline-primary btn-xs rounded-pill btn-icon">
                                                            <i class="fa fa-plus fa-xs"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                            </tfoot>

                                        </table>
                                        <?php DynamicFormWidget::end(); ?>

                                        <?= Html::submitButton('Simpan ICD-10', ['class' => 'btn btn-success btn-block mb-2 rounded-0', 'id' => 'btn-icd-10-claim-simpan']) ?>

                                    </div>
                                </div>

                                <?php ActiveForm::end(); ?>
                                <?php $form = ActiveForm::begin([
                                    'id' => 'icd9-' . $modelCodingPelaporanIgd->formName(),
                                    'options' => [
                                        'name' => 'icd9-' . $modelCodingPelaporanIgd->formName(),
                                        'data-pjax' => true
                                    ],
                                ]); ?>
                                <?= $form->field($modelCodingPelaporanIgd, 'id_ringkasan_pulang_igd')->hiddenInput(['value' => $model->id])->label(false) ?>

                                <?= $form->field($modelCodingPelaporanIgd, 'registrasi_kode')->hiddenInput(['maxlength' => true, 'value' => $registrasi['kode']])->label(false) ?>
                                <?= $form->field($modelCodingPelaporanIgd, 'jenis_layanan')->hiddenInput(['maxlength' => true, 'value' => 3])->label(false) ?>
                                <?php if ($modelCodingPelaporanIgd->isNewRecord) { ?>
                                    <?= $form->field($modelCodingPelaporanIgd, 'pegawai_coder_id')->hiddenInput(['maxlength' => true, 'value' => HelperSpesialClass::getUserLogin()['pegawai_id']])->label(false) ?>
                                <?php } else { ?>
                                    <?= $form->field($modelCodingPelaporanIgd, 'pegawai_coder_id')->hiddenInput(['maxlength' => true])->label(false) ?>

                                <?php } ?> <div class="panel-heading">
                                    <h4 class="mb-2 text-uppercase bg-light p-2"><i class="fas fa-archive mr-3"></i>II. ICD-9 Laporan (Resume id: <?= $model->id ?? '' ?> )</h4>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <?php DynamicFormWidget::begin([
                                            'widgetContainer' => 'dynamicform_wrappers',
                                            'widgetBody' => '.form-options-bodys',
                                            'widgetItem' => '.form-options-items',
                                            'min' => 1,
                                            'insertButton' => '.add-items',
                                            'deleteButton' => '.delete-items',
                                            'model' => $modelsPelaporanTindakan[0],
                                            'formId' => 'icd9-' . $modelCodingPelaporanIgd->formName(),
                                            'formFields' => [
                                                'id',
                                                'icd9_id',

                                            ],
                                        ]); ?>
                                        <table class="table-list-item table table-bordered table-responsive" style="width: 100%;">
                                            <thead class="thead-light" style="text-align: center;">
                                                <th style="width: 98%">Tindakan</th>
                                                <th style="width: 2%"></th>
                                            </thead>
                                            <tbody class="form-options-bodys">

                                                <?php foreach ($modelsPelaporanTindakan as $i => $modelDetail) : ?>
                                                    <tr class="form-options-items">
                                                        <?php
                                                        // necessary for update action.
                                                        if (!$modelDetail->isNewRecord) {
                                                            echo Html::activeHiddenInput($modelDetail, "[{$i}]id");
                                                        }
                                                        ?>

                                                        <td>
                                                            <?= $form->field($modelDetail, "[{$i}]icd9_id")->widget(Select2::classname(), [
                                                                'options' => ['placeholder' => 'Gunakan Untuk Pencarian ICD-9 ...'],
                                                                'initValueText' => ($modelDetail->tindakan != null) ? '(' . $modelDetail->tindakan->kode . ') ' . $modelDetail->tindakan->deskripsi : null,
                                                                'value' => $modelDetail->icd9_id,
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
                                                                    "select2:select" => new JsExpression('function(e) { 
                                                                            let index = $(this).closest("tr").index()
                                                                            if (index == 0) {
                                                                                $($(this).closest("tr"))
                                                                                  .find(".div-icd9")
                                                                                  .html("<span class=\'badge bg-info shadow p-2\'>Dx Utama</span>");
                                                                              } else {
                                                                                $($(this).closest("tr"))
                                                                                  .find(".div-icd9")
                                                                                  .html(
                                                                                    "<span class=\'badge bg-warning shadow p-2\'>Dx Sekunder " +
                                                                                      index +
                                                                                      "</span>"
                                                                                  );
                                                                              }
                                                                    
                                                                    }'),
                                                                ]

                                                            ])->label(false);
                                                            ?>
                                                            <div class="row" style="padding-left: 10px">
                                                                <div class="text-lg div-icd9 mr-2">

                                                                </div>

                                                            </div>

                                                        </td>

                                                        <td class="style-td">
                                                            <button type="button" class="delete-items btn btn-outline-danger btn-xs rounded-pill btn-icon">
                                                                <i class="fa fa-trash fa-xs"></i>
                                                            </button>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                            <tfoot>
                                                <tr class="style-td">
                                                    <td style="text-align: center;"></td>
                                                    <td>
                                                        <button type="button" class="add-items btn btn-outline-primary btn-xs rounded-pill btn-icon">
                                                            <i class="fa fa-plus fa-xs"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                            </tfoot>
                                        </table>
                                        <?php DynamicFormWidget::end(); ?>
                                        <?= Html::submitButton('Simpan ICD-9', ['class' => 'btn btn-success btn-block mb-2 rounded-0', 'id' => 'btn-icd-10-claim-simpan']) ?>

                                    </div>
                                </div>

                                <?php ActiveForm::end(); ?>
                            </div>

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

</div>

<div class="card-footer">
    <div class="col-sm-2">
        <button class="btn btn-outline-info">Kembali</button>
    </div>
</div>