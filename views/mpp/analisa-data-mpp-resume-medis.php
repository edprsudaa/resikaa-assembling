 <?php

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
         </div>
         <div class="col-lg-7">
             <div class="card card-primary card-outline">
                 <div class="card-header">

                     <h5 style="margin-bottom:6px;">Resume Medis Rawat Inap Dokter Revisi MPP (<?= $model->id ?? '' ?>) </h5>
                 </div>
                 <div class="card-body">
                     <div class="row">
                         <div class="col-sm-12">


                             <?php

                                $form = ActiveForm::begin([
                                    'id' => 'update-resume-mpp',
                                ]); ?>

                             <?= $form->field($model, 'id')->hiddenInput()->label(false); ?>
                             <?= $form->field($model, 'layanan_id')->hiddenInput()->label(false); ?>
                             <div class="row">
                                 <div class="col-sm-12">
                                     <label>Hasil Pemeriksaan Fisik Penting & Temuan Lainya :</label>
                                     <div class="row">
                                         <div class="col-lg-12">
                                             <?= $form->field($model, 'hasil_pemeriksaan_fisik')->textarea(array('rows' => 10))->label(false); ?>
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

                             <hr>
                             <h3><b>Diagnosa</b></h3>
                             <hr>
                             <div class="row">
                                 <div class="col-sm-2">
                                     <label>Tambahan I :</label>
                                 </div>
                                 <div class="col-sm-10">
                                     <div class="row">
                                         <div class="col-sm-6">
                                             <?= $form->field($model, "diagnosa_tambahan1_deskripsi")->textInput(['placeholder' => 'Diagnosa Tambahan I'])->label(false) ?>
                                         </div>
                                         <div class="col-sm-6">
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
                                                ])->label(false);
                                                ?>
                                         </div>
                                     </div>
                                 </div>
                             </div>
                             <div class="row">
                                 <div class="col-sm-2">
                                     <label>Tambahan II :</label>
                                 </div>
                                 <div class="col-sm-10">
                                     <div class="row">
                                         <div class="col-sm-6">
                                             <?= $form->field($model, "diagnosa_tambahan2_deskripsi")->textInput(['placeholder' => 'Diagnosa Tambahan II'])->label(false) ?>
                                         </div>
                                         <div class="col-sm-6">
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
                                                ])->label(false);
                                                ?>
                                         </div>
                                     </div>
                                 </div>
                             </div>
                             <div class="row">
                                 <div class="col-sm-2">
                                     <label>Tambahan III :</label>
                                 </div>
                                 <div class="col-sm-10">
                                     <div class="row">
                                         <div class="col-sm-6">
                                             <?= $form->field($model, "diagnosa_tambahan3_deskripsi")->textInput(['placeholder' => 'Diagnosa Tambahan III'])->label(false) ?>
                                         </div>
                                         <div class="col-sm-6">
                                             <?= $form->field($model, 'diagnosa_tambahan3_id')->widget(Select2::classname(), [
                                                    'initValueText' => (!$model->isNewRecord  && $model->diagtiga) ? '(' . $model->diagtiga->kode . ')' . $model->diagtiga->deskripsi : null,
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
                                     <label>Tambahan IV :</label>
                                 </div>
                                 <div class="col-sm-10">
                                     <div class="row">
                                         <div class="col-sm-6">
                                             <?= $form->field($model, "diagnosa_tambahan4_deskripsi")->textInput(['placeholder' => 'Diagnosa Tambahan IV'])->label(false) ?>
                                         </div>
                                         <div class="col-sm-6">
                                             <?= $form->field($model, 'diagnosa_tambahan4_id')->widget(Select2::classname(), [
                                                    'initValueText' => (!$model->isNewRecord  && $model->diagempat) ? '(' . $model->diagempat->kode . ')' . $model->diagempat->deskripsi : null,
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
                                     <label>Tambahan V :</label>
                                 </div>
                                 <div class="col-sm-10">
                                     <div class="row">
                                         <div class="col-sm-6">
                                             <?= $form->field($model, "diagnosa_tambahan5_deskripsi")->textInput(['placeholder' => 'Diagnosa Tambahan V'])->label(false) ?>
                                         </div>
                                         <div class="col-sm-6">
                                             <?= $form->field($model, 'diagnosa_tambahan5_id')->widget(Select2::classname(), [
                                                    'initValueText' => (!$model->isNewRecord  && $model->diaglima) ? '(' . $model->diaglima->kode . ')' . $model->diaglima->deskripsi : null,
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
                             <hr>
                             <h3><b>Tindakan</b></h3>
                             <hr>

                             <div class="row">
                                 <div class="col-sm-2">
                                     <label>Tambahan I :</label>
                                 </div>
                                 <div class="col-sm-10">
                                     <div class="row">
                                         <div class="col-sm-6">
                                             <?= $form->field($model, "tindakan_tambahan1_deskripsi")->textInput(['placeholder' => 'Tindakan Tambahan I'])->label(false) ?>
                                         </div>
                                         <div class="col-sm-6">
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
                                                ])->label(false);
                                                ?>
                                         </div>
                                     </div>
                                 </div>
                             </div>
                             <div class="row">
                                 <div class="col-sm-2">
                                     <label>Tambahan II :</label>
                                 </div>
                                 <div class="col-sm-10">
                                     <div class="row">
                                         <div class="col-sm-6">
                                             <?= $form->field($model, "tindakan_tambahan2_deskripsi")->textInput(['placeholder' => 'Tindakan Tambahan II'])->label(false) ?>
                                         </div>
                                         <div class="col-sm-6">
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
                                                ])->label(false);
                                                ?>
                                         </div>
                                     </div>
                                 </div>
                             </div>
                             <div class="row">
                                 <div class="col-sm-2">
                                     <label>Tambahan III :</label>
                                 </div>
                                 <div class="col-sm-10">
                                     <div class="row">
                                         <div class="col-sm-6">
                                             <?= $form->field($model, "tindakan_tambahan3_deskripsi")->textInput(['placeholder' => 'Tindakan Tambahan III'])->label(false) ?>
                                         </div>
                                         <div class="col-sm-6">
                                             <?= $form->field($model, 'tindakan_tambahan3_id')->widget(Select2::classname(), [
                                                    'initValueText' => (!$model->isNewRecord   && $model->tindtiga) ? '(' . $model->tindtiga->kode . ')' . $model->tindtiga->deskripsi : null,
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
                                     <label>Tambahan IV :</label>
                                 </div>
                                 <div class="col-sm-10">
                                     <div class="row">
                                         <div class="col-sm-6">
                                             <?= $form->field($model, "tindakan_tambahan4_deskripsi")->textInput(['placeholder' => 'Tindakan Tambahan IV'])->label(false) ?>
                                         </div>
                                         <div class="col-sm-6">
                                             <?= $form->field($model, 'tindakan_tambahan4_id')->widget(Select2::classname(), [
                                                    'initValueText' => (!$model->isNewRecord   && $model->tindempat) ? '(' . $model->tindempat->kode . ')' . $model->tindempat->deskripsi : null,
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
                                     <label>Tambahan V :</label>
                                 </div>
                                 <div class="col-sm-10">
                                     <div class="row">
                                         <div class="col-sm-6">
                                             <?= $form->field($model, "tindakan_tambahan5_deskripsi")->textInput(['placeholder' => 'Tindakan Tambahan V'])->label(false) ?>
                                         </div>
                                         <div class="col-sm-6">
                                             <?= $form->field($model, 'tindakan_tambahan5_id')->widget(Select2::classname(), [
                                                    'initValueText' => (!$model->isNewRecord   && $model->tindlima) ? '(' . $model->tindlima->kode . ')' . $model->tindlima->deskripsi : null,
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

                         </div>
                     </div>

                 </div>
             </div>
         </div>
     </div>
 </div>

 <?php ActiveForm::end(); ?>
 </div>