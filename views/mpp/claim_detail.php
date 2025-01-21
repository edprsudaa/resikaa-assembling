 <?php

    use app\components\DynamicFormWidget;
    use app\components\HelperGeneralClass;
    use app\components\HelperSpesialClass;
    use kartik\select2\Select2;
    use yii\bootstrap4\ActiveForm;
    use yii\helpers\Html;
    use yii\helpers\Url;
    use yii\web\JsExpression;


    $this->registerJs("
    $('#codingclaimmpp-CodingClaimMpp').on('beforeSubmit', function(e) {
        e.preventDefault();
        
        // Get the value of the estimasi input
        var estimasiValue = $('#estimasi').val();
        
        // Serialize form data
        var formData = $(this).serializeArray();
        
        // Add the estimasi value to the serialized form data
        formData.push({name: 'CodingClaimMpp[estimasi]', value: estimasiValue});
        
        // Convert serialized array to query string format
        var formDataString = $.param(formData);
        
        var btn = $('.btn-submit');
        var htm = btn.html();
        $('body').addClass('loading');
        $('#btn-loading-analisa').attr('style', 'display: block');
       
        $.ajax({
            url: '" . Url::to(['claim-diagnosa-save']) . "',
            type: 'post',
            dataType: 'json',
            data: formDataString,
            success: function(result) {
                if(result.status) {
                    toastr.success(result.msg);
                    setTimeout(function () {
                        window.location.reload();
                    }, 2000);
                } else {
                    if (typeof result.msg == 'object') {
                        $.each(result.msg, function(i, v) {
                            toastr.error(v);
                        });
                    } else {
                        toastr.error(result.msg);
                    }
                    $('body').removeClass('loading');
                    $('#btn-loading-analisa').attr('style', 'display: none');
                }
            },
            error: function(xhr, status, error) {
                toastr.error('An error occurred. Please try again.');
                $('body').removeClass('loading');
                $('#btn-loading-analisa').attr('style', 'display: none');
            }
        });
    }).submit(function(e) {
        e.preventDefault();
    });
    $('#codingclaimicd9mpp-CodingClaimMpp').on('beforeSubmit', function(e) {
        e.preventDefault();
        
        // Get the value of the estimasi input
        var estimasiValue = $('#estimasi').val();
        
        // Serialize form data
        var formData = $(this).serializeArray();
        
        // Add the estimasi value to the serialized form data
        formData.push({name: 'CodingClaimMpp[estimasi]', value: estimasiValue});
        
        // Convert serialized array to query string format
        var formDataString = $.param(formData);
        
        var btn = $('.btn-submit');
        var htm = btn.html();
        $('body').addClass('loading');
        $('#btn-loading-analisa').attr('style', 'display: block');
       
        $.ajax({
            url: '" . Url::to(['claim-tindakan-save']) . "',
            type: 'post',
            dataType: 'json',
            data: formDataString,
            success: function(result) {
                if(result.status) {
                    toastr.success(result.msg);
                    setTimeout(function () {
                        window.location.reload();
                    }, 2000);
                } else {
                    if (typeof result.msg == 'object') {
                        $.each(result.msg, function(i, v) {
                            toastr.error(v);
                        });
                    } else {
                        toastr.error(result.msg);
                    }
                    $('body').removeClass('loading');
                    $('#btn-loading-analisa').attr('style', 'display: none');
                }
            },
            error: function(xhr, status, error) {
                toastr.error('An error occurred. Please try again.');
                $('body').removeClass('loading');
                $('#btn-loading-analisa').attr('style', 'display: none');
            }
        });
    }).submit(function(e) {
        e.preventDefault();
    });
    ");
    ?>

 <div class="card card-primary card-outline">

     <div class="card-body">
         <div class="row">



             <div class="col-lg-12">



                 <div class="card-header">
                     <h5 style="margin-bottom:6px;">Form Pengisian ICD10 dan ICD9</h5>
                 </div>
                 <div class="card-body">
                     <div class="tab-content" id="custom-tabs-four-tabContent">
                         <div class="tab-pane fade active show" id="custom-tabs-four-home" role="tabpanel" aria-labelledby="custom-tabs-four-home-tab">

                             <?php $form = ActiveForm::begin([
                                    'id' => 'codingclaimmpp-' . $modelCodingClaimMppRi->formName(),
                                    'options' => [
                                        'name' => 'codingclaimmpp-' . $modelCodingClaimMppRi->formName(),
                                        'data-pjax' => true
                                    ],
                                ]); ?>
                             <?= $form->field($modelCodingClaimMppRi, 'id_resume_medis_ri')->hiddenInput(['value' => Yii::$app->request->get('id')])->label(false) ?>

                             <?= $form->field($modelCodingClaimMppRi, 'registrasi_kode')->hiddenInput(['maxlength' => true, 'value' => $registrasi['kode']])->label(false) ?>
                             <?= $form->field($modelCodingClaimMppRi, 'jenis_layanan')->hiddenInput(['maxlength' => true, 'value' => 3])->label(false) ?>
                             <?= $form->field($modelCodingClaimMppRi, 'pegawai_mpp_id')->hiddenInput(['maxlength' => true, 'value' => HelperSpesialClass::getUserLogin()['pegawai_id']])->label(false) ?>
                             <?= $form->field($modelCodingClaimMppRi, 'estimasi')->textInput(['maxlength' => true, 'type' => 'number', 'step' => '1', 'id' => 'estimasi']) ?>


                             <div class="panel-heading">
                                 <h6 class="mb-2 text-uppercase bg-light p-2"><i class="fas fa-archive mr-3"></i>I. ICD-10 Claim </h6>
                             </div>
                             <?= $form->field($modelCodingClaimMppRi, 'kasus', ['inputOptions' =>  ['class' => 'form-control']])->inline(true)->radioList(['0' => 'Baru', '1' => 'Lama'])->label("Jenis Kasus") ?>
                             <div class="row">
                                 <div class="col-md-12">
                                     <?php DynamicFormWidget::begin([
                                            'widgetContainer' => 'dynamicform_wrapper',
                                            'widgetBody' => '.form-options-body',
                                            'widgetItem' => '.form-options-item',
                                            'min' => 1,
                                            'insertButton' => '.add-item',
                                            'deleteButton' => '.delete-item',
                                            'model' => $modelCodingClaimMppDiagnosaDetailRi[0],
                                            'formId' => 'codingclaimmpp-' . $modelCodingClaimMppRi->formName(),
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

                                             <?php foreach ($modelCodingClaimMppDiagnosaDetailRi as $i => $modelDetail) : ?>

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
                                    'id' => 'codingclaimicd9mpp-' . $modelCodingClaimMppRi->formName(),
                                    'options' => [
                                        'name' => 'codingclaimicd9mpp-' . $modelCodingClaimMppRi->formName(),
                                        'data-pjax' => true
                                    ],
                                ]); ?>
                             <?= $form->field($modelCodingClaimMppRi, 'id_resume_medis_rj')->hiddenInput(['value' => Yii::$app->request->get('id')])->label(false) ?>


                             <?= $form->field($modelCodingClaimMppRi, 'registrasi_kode')->hiddenInput(['maxlength' => true, 'value' => $registrasi['kode']])->label(false) ?>
                             <?= $form->field($modelCodingClaimMppRi, 'jenis_layanan')->hiddenInput(['maxlength' => true, 'value' => 3])->label(false) ?>
                             <?php if ($modelCodingClaimMppRi->isNewRecord) { ?>
                                 <?= $form->field($modelCodingClaimMppRi, 'pegawai_mpp_id')->hiddenInput(['maxlength' => true, 'value' => HelperSpesialClass::getUserLogin()['pegawai_id']])->label(false) ?>
                             <?php } else { ?>
                                 <?= $form->field($modelCodingClaimMppRi, 'pegawai_mpp_id')->hiddenInput(['maxlength' => true])->label(false) ?>

                             <?php } ?>
                             <?php $form->field($modelCodingClaimMppRi, 'estimasi')->hiddenInput(['maxlength' => true, 'type' => 'number', 'step' => '1']) ?>
                             <div class="panel-heading">
                                 <h6 class="mb-2 text-uppercase bg-light p-2"><i class="fas fa-archive mr-3"></i>II. ICD-9 Claim </h6>
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
                                            'model' => $modelCodingClaimMppTindakanDetailRi[0],
                                            'formId' => 'codingclaimicd9mpp-' . $modelCodingClaimMppRi->formName(),
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

                                             <?php foreach ($modelCodingClaimMppTindakanDetailRi as $i => $modelDetail) : ?>
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
     <div class="card-footer">
         <div class="col-sm-2">
             <button class="btn btn-outline-info">Kembali</button>
         </div>
     </div>



 </div>