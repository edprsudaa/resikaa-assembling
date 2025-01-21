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
     $('#catatan-mpp').on('beforeSubmit',function(e){
         e.preventDefault();
         var btn=$('.btn-submit');
         var htm=btn.html();
         $('body').addClass('loading');
         $('#btn-loading-analisa').attr('style', 'display: block')
         $.ajax({
             url:'" . Url::to(['save-mpp']) . "',
             type:'post',
             dataType:'json',
             data:$(this).serialize(),
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
                         });
                     }else{
                         toastr.error(result.msg);
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
    ");
    ?>

 <div class="card card-primary card-outline">

     <div class="card-body">
         <div class="row">
             <div class="col-lg-5">
                 <div class="card card-primary card-outline">
                     <div class="card-header">
                         <h5 style="margin-bottom:6px;">Daftar Catatan MPP</h5>
                     </div>
                     <div class="card-body">
                         <?php
                            if (!empty($listMpp)) {
                                foreach ($listMpp as $item) { ?>
                                 <div class="border border-info bg-info" style="border: 1px solid #e1e1e1fa;padding-left: 4px;">Nama MPP : <?= HelperSpesialClass::getNamaPegawaiArray($item['pegawai']) ?? '' ?><br>Unit: <?= $item['layanan']['unit']['nama'] ?? '' ?></div>
                                 <div class="border border-top-0 border-bottom-0 border-info font-weight-bold" style="padding-left: 4px;">Catatan: (<?= $item['lengkap'] == 1 ? '<b>Lengkap</b>' : '<b>Tidak Lengkap</b>' ?>)</div>
                                 <div colspan="3" class="border border-top-0 border-info" style="padding-left: 4px;"><?= $item['catatan'] ?? '' ?></div>

                                 <div class="mt-1"></div>
                             <?php
                                }
                            } else {
                                ?>
                             <div class="border border-info bg-info" style="border: 1px solid #e1e1e1fa;padding-left: 4px;">Nama MPP :</div>

                             <div colspan="3" class="border border-top-0 border-info" style="padding-left: 4px;">Tidak Ada Data</div>
                         <?php } ?>
                     </div>
                 </div>
                 <div class="card card-danger card-outline">
                     <div class="card-header">
                         <h5 style="margin-bottom:6px;">Daftar Resume Medis DPJP</h5>
                     </div>
                     <div class="card-body">
                         <?php
                            if (!empty($listResumeMedis)) {
                                foreach ($listResumeMedis as $item) {
                            ?>

                                 <div class="border border-info bg-info" style="border: 1px solid #e1e1e1fa;padding-left: 4px;">Nama Dokter : <?= HelperSpesialClass::getNamaPegawaiArray($item->dokter) ?? '' ?></div>
                                 <div class="border border-top-0 border-bottom-0 border-info font-weight-bold" style="padding-left: 4px;">Diagnosa Masuk:</div>
                                 <div colspan="3" class="border border-top-0 border-info" style="padding-left: 4px;"><?= $item->diagnosa_masuk_deskripsi ?? '' ?></div>
                                 <div colspan="3" class="border border-top-0 border-info" style="padding-left: 4px;">
                                     <div class="btn-group">
                                         <a class="btn btn-success btn-sm btn-lihat-operasi" href="<?= Url::to(['/analisa-kuantitatif/preview-resume-medis', 'id' => $item['id']]) ?>" data-id="<?= $item['id'] ?>" data-nama="<?= $item['id'] ?>"> <i class="fa fa-eye"></i></i></a>
                                         <a class="btn btn-warning btn-sm" target="_blank" href="<?= Url::to(['/mpp/cetak-resume-medis-ri', 'id' => $item['id'], 'pasien' => $registrasi['pasien']['kode']]) ?>" data-id="<?= $item['id'] ?>" data-pasien="<?= $registrasi['pasien']['kode'] ?>" data-nama="<?= $item['id'] ?>"> <i class="fa fa-print"></i></i></a>

                                         <a class="btn btn-info btn-sm" href="<?= Url::to(['/mpp/detail-mpp-edit-resume', 'id' => HelperGeneralClass::hashData($registrasi['kode']), 'id_resume' => $item['id'], 'layanan_id' => $_GET['layanan_id']]) ?>" data-id="<?= $item['id'] ?>" data-nama="<?= $item['id'] ?>"> <i class="fa fa-edit"></i></i></a>
                                     </div>
                                 </div>
                                 <div class="border border-warning bg-warning font-weight-bold" style="border: 1px solid #e1e1e1fa;padding-left: 4px;">Diagnosa ICD10:</div>

                                 <div class="border border-info bg-info" style="border: 1px solid #e1e1e1fa;padding-left: 4px;">Utama : <?= $item->diagutama->kode ?? '' ?></div>

                                 <div colspan="3" class="border border-top-0 border-info" style="padding-left: 4px;"><?= $item->diagutama->deskripsi ?? '-' ?></div>
                                 <div class="border border-info bg-info" style="border: 1px solid #e1e1e1fa;padding-left: 4px;">Tambahan I : <?= $item->diagsatu->kode ?? '' ?></div>

                                 <div colspan="3" class="border border-top-0 border-info" style="padding-left: 4px;"><?= $item->diagsatu->deskripsi ?? '-' ?></div>
                                 <div class="border border-info bg-info" style="border: 1px solid #e1e1e1fa;padding-left: 4px;">Tambahan II : <?= $item->diagdua->kode ?? '' ?></div>

                                 <div colspan="3" class="border border-top-0 border-info" style="padding-left: 4px;"><?= $item->diagdua->deskripsi ?? '-' ?></div>
                                 <div class="border border-info bg-info" style="border: 1px solid #e1e1e1fa;padding-left: 4px;">Tambahan III : <?= $item->diagtiga->kode ?? '' ?></div>

                                 <div colspan="3" class="border border-top-0 border-info" style="padding-left: 4px;"><?= $item->diagtiga->deskripsi ?? '-' ?></div>
                                 <div class="border border-info bg-info" style="border: 1px solid #e1e1e1fa;padding-left: 4px;">Tambahan IV : <?= $item->diagempat->kode ?? '' ?></div>

                                 <div colspan="3" class="border border-top-0 border-info" style="padding-left: 4px;"><?= $item->diagempat->deskripsi ?? '-' ?></div>
                                 <div class="border border-info bg-info" style="border: 1px solid #e1e1e1fa;padding-left: 4px;">Tambahan V : <?= $item->diaglima->kode ?? '' ?></div>

                                 <div colspan="3" class="border border-top-0 border-info" style="padding-left: 4px;"><?= $item->diaglima->deskripsi ?? '-' ?></div>

                                 <div class="border border-warning bg-warning" style="border: 1px solid #e1e1e1fa;padding-left: 4px;">Tindakan :</div>

                                 <div class="border border-info bg-info" style="border: 1px solid #e1e1e1fa;padding-left: 4px;">Utama : <?= $item->tindutama->kode ?? '' ?></div>

                                 <div colspan="3" class="border border-top-0 border-info" style="padding-left: 4px;"><?= $item->tindutama->deskripsi ?? '-' ?></div>
                                 <div class="border border-info bg-info" style="border: 1px solid #e1e1e1fa;padding-left: 4px;">Tambahan I : <?= $item->tindsatu->kode ?? '' ?></div>

                                 <div colspan="3" class="border border-top-0 border-info" style="padding-left: 4px;"><?= $item->tindsatu->deskripsi ?? '-' ?></div>
                                 <div class="border border-info bg-info" style="border: 1px solid #e1e1e1fa;padding-left: 4px;">Tambahan II : <?= $item->tinddua->kode ?? '' ?></div>

                                 <div colspan="3" class="border border-top-0 border-info" style="padding-left: 4px;"><?= $item->tinddua->deskripsi ?? '-' ?></div>
                                 <div class="border border-info bg-info" style="border: 1px solid #e1e1e1fa;padding-left: 4px;">Tambahan III : <?= $item->tindtiga->kode ?? '' ?></div>

                                 <div colspan="3" class="border border-top-0 border-info" style="padding-left: 4px;"><?= $item->tindtiga->deskripsi ?? '-' ?></div>
                                 <div class="border border-info bg-info" style="border: 1px solid #e1e1e1fa;padding-left: 4px;">Tambahan IV : <?= $item->tindempat->kode ?? '' ?></div>

                                 <div colspan="3" class="border border-top-0 border-info" style="padding-left: 4px;"><?= $item->tindempat->deskripsi ?? '-' ?></div>
                                 <div class="border border-info bg-info" style="border: 1px solid #e1e1e1fa;padding-left: 4px;">Tambahan V : <?= $item->tindlima->kode ?? '' ?></div>

                                 <div colspan="3" class="border border-top-0 border-info" style="padding-left: 4px;"><?= $item->tindlima->deskripsi ?? '-' ?></div>

                             <?php
                                }
                            } else {
                                ?>
                             <div class="border border-info bg-info" style="border: 1px solid #e1e1e1fa;padding-left: 4px;">Nama Dokter :</div>

                             <div colspan="3" class="border border-top-0 border-info" style="padding-left: 4px;">Tidak Ada Data</div>
                         <?php } ?>
                     </div>
                 </div>
             </div>
             <div class="col-lg-7">
                 <div class="card card-primary card-outline">

                     <div class="card-body">
                         <div class="row">

                             <div class="col-lg-12">


                                 <div class="card card-primary card-outline">

                                     <div class="card-header">
                                         <h5 style="margin-bottom:6px;">Form Pengisian ICD10 dan ICD9</h5>
                                     </div>
                                     <div class="card-body">
                                         <div class="tab-content" id="custom-tabs-four-tabContent">
                                             <div class="tab-pane fade active show" id="custom-tabs-four-home" role="tabpanel" aria-labelledby="custom-tabs-four-home-tab">

                                                 <?php $form = ActiveForm::begin([
                                                        'id' => 'codingclaimmpp-' . $modelCodingClaimRi->formName(),
                                                        'options' => [
                                                            'name' => 'codingclaimmpp-' . $modelCodingClaimRi->formName(),
                                                            'data-pjax' => true
                                                        ],
                                                    ]); ?>
                                                 <?= $form->field($modelCodingClaimRi, 'id_resume_medis_ri')->hiddenInput(['value' => Yii::$app->request->get('id')])->label(false) ?>

                                                 <?= $form->field($modelCodingClaimRi, 'registrasi_kode')->hiddenInput(['maxlength' => true, 'value' => $registrasi['kode']])->label(false) ?>
                                                 <?= $form->field($modelCodingClaimRi, 'jenis_layanan')->hiddenInput(['maxlength' => true, 'value' => 3])->label(false) ?>
                                                 <?= $form->field($modelCodingClaimRi, 'pegawai_mpp_id')->hiddenInput(['maxlength' => true, 'value' => HelperSpesialClass::getUserLogin()['pegawai_id']])->label(false) ?>
                                                 <?= $form->field($modelCodingClaimRi, 'estimasi')->textInput(['maxlength' => true, 'type' => 'number', 'step' => '1', 'id' => 'estimasi']) ?>


                                                 <div class="panel-heading">
                                                     <h6 class="mb-2 text-uppercase bg-light p-2"><i class="fas fa-archive mr-3"></i>I. ICD-10 Claim </h6>
                                                 </div>
                                                 <?= $form->field($modelCodingClaimRi, 'kasus', ['inputOptions' =>  ['class' => 'form-control']])->inline(true)->radioList(['0' => 'Baru', '1' => 'Lama'])->label("Jenis Kasus") ?>
                                                 <div class="row">
                                                     <div class="col-md-12">
                                                         <?php DynamicFormWidget::begin([
                                                                'widgetContainer' => 'dynamicform_wrapper',
                                                                'widgetBody' => '.form-options-body',
                                                                'widgetItem' => '.form-options-item',
                                                                'min' => 1,
                                                                'insertButton' => '.add-item',
                                                                'deleteButton' => '.delete-item',
                                                                'model' => $modelCodingClaimDiagnosaDetailRi[0],
                                                                'formId' => 'codingclaimmpp-' . $modelCodingClaimRi->formName(),
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

                                                                 <?php foreach ($modelCodingClaimDiagnosaDetailRi as $i => $modelDetail) : ?>

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
                                                        'id' => 'codingclaimicd9mpp-' . $modelCodingClaimRi->formName(),
                                                        'options' => [
                                                            'name' => 'codingclaimicd9mpp-' . $modelCodingClaimRi->formName(),
                                                            'data-pjax' => true
                                                        ],
                                                    ]); ?>
                                                 <?= $form->field($modelCodingClaimRi, 'id_resume_medis_rj')->hiddenInput(['value' => Yii::$app->request->get('id')])->label(false) ?>


                                                 <?= $form->field($modelCodingClaimRi, 'registrasi_kode')->hiddenInput(['maxlength' => true, 'value' => $registrasi['kode']])->label(false) ?>
                                                 <?= $form->field($modelCodingClaimRi, 'jenis_layanan')->hiddenInput(['maxlength' => true, 'value' => 3])->label(false) ?>
                                                 <?php if ($modelCodingClaimRi->isNewRecord) { ?>
                                                     <?= $form->field($modelCodingClaimRi, 'pegawai_mpp_id')->hiddenInput(['maxlength' => true, 'value' => HelperSpesialClass::getUserLogin()['pegawai_id']])->label(false) ?>
                                                 <?php } else { ?>
                                                     <?= $form->field($modelCodingClaimRi, 'pegawai_mpp_id')->hiddenInput(['maxlength' => true])->label(false) ?>

                                                 <?php } ?>
                                                 <?php $form->field($modelCodingClaimRi, 'estimasi')->hiddenInput(['maxlength' => true, 'type' => 'number', 'step' => '1']) ?>
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
                                                                'model' => $modelCodingClaimTindakanDetailRi[0],
                                                                'formId' => 'codingclaimicd9mpp-' . $modelCodingClaimRi->formName(),
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

                                                                 <?php foreach ($modelCodingClaimTindakanDetailRi as $i => $modelDetail) : ?>
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
                     </div>
                     <div class="card-footer">
                         <div class="col-sm-2">
                             <button class="btn btn-outline-info">Kembali</button>
                         </div>
                     </div>

                 </div>
             </div>
         </div>
     </div>

     <?php ActiveForm::end(); ?>
 </div>