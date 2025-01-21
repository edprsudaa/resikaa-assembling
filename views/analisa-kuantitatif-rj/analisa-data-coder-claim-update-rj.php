 <?php

    use app\components\HelperGeneralClass;
    use app\components\HelperSpesialClass;
    use app\models\pendaftaran\KelompokUnitLayanan;
    use kartik\date\DatePicker;
    use kartik\select2\Select2;
    use yii\bootstrap4\ActiveForm;
    use yii\helpers\Html;
    use yii\helpers\Url;
    use yii\web\JsExpression;

    $this->registerJs("
     $('#af-dokter-verifikator').on('beforeSubmit',function(e){
         e.preventDefault();
         var btn=$('.btn-submit');
         var htm=btn.html();
         $('body').addClass('loading');
         $('#btn-loading-analisa').attr('style', 'display: block')
         $.ajax({
             url:'" . Url::to(['save-resume-medis-verifikator-rj']) . "',
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
    //             // App.ResetLoadingBtn(btn,htm);
             },
             error:function(xhr,status,error){
    //             // App.Error(error);
    //             // App.ResetLoadingBtn(btn,htm);
             }
         });
     }).submit(function(e){
         e.preventDefault();
     });
     $('.btn-preview-resume-verifikator-rj').click(function(e){
        e.preventDefault();
        var id=$(this).attr('data-id');
        var pasien=$(this).attr('data-pasien');
        console.log(pasien)
        if(id){
            $.post('" . Url::to(['detail-resume-verifikator-rj']) . "',{id:id,pasien:pasien},function(res){
                $('.mymodal_card_xl_body').html(res);
                $('.mymodal_card_xl').modal('show');
            });
        }
    });
    $('.btn-preview-resume-verifikator-rj-cetak').click(function(e){
        e.preventDefault();
        var id=$(this).attr('data-id');
        var pasien=$(this).attr('data-pasien');
        console.log(pasien)
        if(id){
            $.post('" . Url::to(['detail-resume-verifikator-rj']) . "',{id:id,pasien:pasien},function(res){
                var newTab = window.open();
                newTab.document.body.innerHTML = res;
            });
        }
    });
    $('.btn-preview-resume-verifikator-ri').click(function(e){
        e.preventDefault();
        var id=$(this).attr('data-id');
        var pasien=$(this).attr('data-pasien');
        console.log(pasien)
        if(id){
            $.post('" . Url::to(['detail-resume-verifikator-ri']) . "',{id:id,pasien:pasien},function(res){
    
                $('.mymodal_card_xl_body').html(res);
                $('.mymodal_card_xl').modal('show');
            });
        }
    });
    $('.btn-preview-resume-verifikator-ri-cetak').click(function(e){
        e.preventDefault();
        var id=$(this).attr('data-id');
        var pasien=$(this).attr('data-pasien');
        console.log(pasien)
        if(id){
            $.post('" . Url::to(['detail-resume-verifikator-ri']) . "',{id:id,pasien:pasien},function(res){
                var newTab = window.open();
                newTab.document.body.innerHTML = res;
                
            });
        }
    });
    ");
    ?>

 <div class="card card-primary card-outline">

     <div class="card-body">
         <div class="row">
             <div class="col-lg-5">
                 <div class="card card-danger card-outline">
                     <div class="card-header">
                         <h5 style="margin-bottom:6px;">Daftar Resume Medis DPJP</h5>
                     </div>
                     <div class="card-body">
                         <?php

                            if (!empty($listResumeMedisDokter)) {
                                foreach ($listResumeMedisDokter as $item) {
                            ?>

                                 <div class="border border-info bg-info" style="border: 1px solid #e1e1e1fa;padding-left: 4px;">Nama Dokter : <?= HelperSpesialClass::getNamaPegawaiArray($item->dokter) ?? '' ?><br>(Resume id : <?= $item->id ?? '' ?>)</div>
                                 <div class="border border-top-0 border-bottom-0 border-info font-weight-bold" style="padding-left: 4px;">Diagnosa Masuk:</div>
                                 <div colspan="3" class="border border-top-0 border-info" style="padding-left: 4px;"><?= $item->diagnosa_masuk_deskripsi ?? '' ?></div>
                                 <div colspan="3" class="border border-top-0 border-info" style="padding-left: 4px;">
                                     <div class="btn-group">
                                         <a class="btn btn-success btn-sm btn-preview-resume-rj" href="<?= Url::to(['/analisa-kuantitatif/preview-resume-medis', 'id' => $item['id']]) ?>" data-id="<?= $item['id'] ?>" data-pasien="<?= $registrasi['pasien']['kode'] ?>" data-nama=" <?= $item['id'] ?>"> <i class="fa fa-eye"></i></i></a>
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
                 <?php if (!empty($listResumeMedisVerifikator)) { ?>
                     <div class="card card-primary card-outline">
                         <div class="card-header">
                             <h5 style="margin-bottom:6px;">Daftar Resume Medis Verifikator</h5>
                         </div>
                         <div class="card-body">
                             <?php

                                foreach ($listResumeMedisVerifikator as $item) {
                                ?>
                                 <div class="border border-info bg-danger" style="border: 1px solid #e1e1e1fa;padding-left: 4px;">Nama Dokter : <?= HelperSpesialClass::getNamaPegawaiArray($item->dokterVerifikator) ?? '' ?><br>(Verifikator id : <?= $item->id ?? '' ?>)</div>

                                 <div colspan="3" class="border border-top-0 border-info text-right" style="padding: 4px;">
                                     <b style="color:black">(Resume id: <?= $item->id_resume_medis_rj ?? '' ?> )</b>

                                     <a class="btn btn-success btn-sm btn-preview-resume-verifikator-rj" href="<?= Url::to(['analisa-kuantitatif/preview-resume-medis', 'id' => $item['id']]) ?>" data-id="<?= $item['id'] ?>" data-pasien="<?= $registrasi['pasien']['kode'] ?>" data-nama="<?= $item['id'] ?>"> <i class="fa fa-eye"></i></i></a>
                                     <a class="btn btn-warning btn-sm" target="_blank" href="<?= Url::to(['/analisa-kuantitatif/cetak-resume-medis-dokter-verifikator-rj', 'id' => $item['id'], 'pasien' => $registrasi['pasien']['kode']]) ?>" data-id="<?= $item['id'] ?>" data-pasien="<?= $registrasi['pasien']['kode'] ?>" data-nama="<?= $item['id'] ?>"> <i class="fa fa-print"></i></i></a>


                                     <a class="btn btn-info btn-sm" href="<?= Url::to(['analisa-kuantitatif/detail-coder-claim-rj-update', 'id' => $item['id'], 'registrasi_kode' => HelperGeneralClass::hashData($registrasi['kode'])]) ?>" data-id="<?= $item['id'] ?>" data-nama="<?= $item['id'] ?>"> <i class="fa fa-edit"></i></i></a>
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
                                ?>
                         </div>
                     </div>
                 <?php
                    }
                    ?>
             </div>
             <div class="col-lg-7">


                 <div class="card card-primary card-outline">

                     <div class="card-header">
                         <h5 style="margin-bottom:6px;">Coding Pelaporan (Verifikator id:<?= $model->id ?? '' ?>) <a class="btn btn-danger" href="<?= Url::to(['/analisa-kuantitatif/detail-coder-pelaporan-rj', 'id' => HelperGeneralClass::hashData($registrasi['kode']), 'icd' => true]) ?>"><i style="color: white;" class="fa fa-edit"></i> Buat Coding Pelaporan</a></h5>
                     </div>
                     <div class="card-body">
                         <div class="row">
                             <div class="col-sm-12">
                                 <?php
                                    $form = ActiveForm::begin([
                                        'id' => 'af-dokter-verifikator',
                                    ]); ?>
                                 <?= $form->field($model, 'registrasi_kode')->hiddenInput()->label(false); ?>
                                 <?= $form->field($model, 'coder_claim_id')->hiddenInput(['value' => HelperSpesialClass::getUserLogin()['pegawai_id']])->label(false); ?>

                                 <?= $form->field($model, 'id_resume_medis_rj')->hiddenInput()->label(false); ?>
                                 <?= $form->field($model, 'dokter_verifikator_id')->hiddenInput()->label(false); ?>
                                 <?= $form->field($model, 'layanan_id')->hiddenInput()->label(false); ?>


                                 <div class="row">
                                     <div class="col-sm-2">
                                         <label>Diagnosa Utama :</label>
                                     </div>
                                     <div class="col-sm-10">
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
                                                    ])->label(false);
                                                    ?>
                                             </div>
                                         </div>
                                     </div>
                                 </div>
                                 <div class="row">
                                     <div class="col-sm-2">
                                         <label>Tindakan :</label>
                                     </div>
                                     <div class="col-sm-10">
                                         <?= $form->field($model, 'tindakan')->textarea(['rows' => 3])->label(false); ?>
                                     </div>
                                 </div>
                                 <div class="row">
                                     <div class="col-sm-2">
                                         <label>Tindakan Utama :</label>
                                     </div>
                                     <div class="col-sm-10">
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
                                                    ])->label(false);
                                                    ?>
                                             </div>
                                         </div>
                                     </div>
                                 </div>

                             </div>
                         </div>
                         <div class="mb-2">
                             <?= Html::submitButton('Simpan Data Coder', ['class' => 'btn btn-success btn-block mb-2 rounded-0', 'id' => 'btn-icd-10-laporan-simpan']) ?>
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
     <?php ActiveForm::end(); ?>
 </div>

 <?php
    $this->registerJs("
$(document).ready(function(){ 
    //ini gk dipake karna hbis simpan langsung view, jika tidak maka ini dipake
    // $(\"#pjgrid-" . $model->formName() . "\").on(\"pjax:end\", function() {
    //     $.pjax.reload({container:\"#pjform-" . $model->formName() . "\"});  //Reload Form
    // });
});
$(document).on('click','.btn-view-" . $model->formName() . "',function(e){
    e.preventDefault;
    e.stopImmediatePropagation();
    $.get($(this).data('url'),null, function (data, textStatus, jqXHR) {
        $('.page-form-" . $model->formName() . "').html(data);
    });
});
$(document).on('click','.btn-edit-" . $model->formName() . "',function(e){
    e.preventDefault;
    e.stopImmediatePropagation();
    $.get($(this).data('url'),null, function (data, textStatus, jqXHR) {
        $('.page-form-" . $model->formName() . "').html(data);
    });
});
$(document).on('click','.btn-copy-" . $model->formName() . "',function(e){
    e.preventDefault;
    e.stopImmediatePropagation();
    var obj_url=$(this).data('url');
    var key=$(this).data('key');
    Swal.fire({
        title:\"Anda Yakin ?\",
        text:\"Yakin Copy Resep : \"+key,
        type:\"warning\",
        showCancelButton:!0,
        confirmButtonText:\"Ya!\",
        cancelButtonText:\"Tidak!\",
        confirmButtonClass:\"btn btn-success mt-2\",
        cancelButtonClass:\"btn btn-danger ml-2 mt-2\",
        buttonsStyling:!1,
        showLoaderOnConfirm: true,
    }).then(function(t){
        t.value?
            $.ajax({
                url:obj_url,
                type:'GET',
                success:function(data){
                    if(data.con){
                        fmsg.s(data.msg);
                        location.reload();
                    }else{
                        fmsg.w(data.msg);
                        location.reload();
                    }
                }
                ,error:function(){
                    fmsg.e('Maaf, Terjadi Kesalahan Pada Aplikasi');
                }
            })
        :t.dismiss===Swal.DismissReason.cancel    
        }
    );
});
$(document).on('click','.btn-delete-" . $model->formName() . "',function(e){
    e.preventDefault;
    e.stopImmediatePropagation();
    var obj_url=$(this).data('url');
    var key=$(this).data('key');
    Swal.fire({
        title:\"Anda Yakin ?\",
        text:\"Yakin Hapus Data : \"+key,
        type:\"warning\",
        showCancelButton:!0,
        confirmButtonText:\"Ya!\",
        cancelButtonText:\"Tidak!\",
        confirmButtonClass:\"btn btn-success mt-2\",
        cancelButtonClass:\"btn btn-danger ml-2 mt-2\",
        buttonsStyling:!1,
        showLoaderOnConfirm: true,
    }).then(function(t){
        t.value?
            $.ajax({
                url:obj_url,
                type:'GET',
                success:function(data){
                    if(data.con){
                        fmsg.s(data.msg);
                        $.pjax.reload({container:\"#pjgrid-" . $model->formName() . "\"});
                    }else{
                        fmsg.w(data.msg);
                    }
                }
                ,error:function(){
                    fmsg.e('Maaf, Terjadi Kesalahan Pada Aplikasi');
                }
            })
        :t.dismiss===Swal.DismissReason.cancel    
        }
    );
});
");
