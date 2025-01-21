 <?php

    use app\components\HelperSpesialClass;
    use app\components\HelperGeneralClass;

    use kartik\select2\Select2;
    use yii\bootstrap4\ActiveForm;
    use yii\helpers\Html;
    use yii\helpers\Url;

    $this->registerJs("
     $('#catatan-mpp').on('beforeSubmit',function(e){
         e.preventDefault();
         var btn=$('.btn-submit');
         var htm=btn.html();
         $('body').addClass('loading');
         $('#btn-loading-analisa').attr('style', 'display: block')
         $.ajax({
             url:'" . Url::to(['save-catatan-mpp']) . "',
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
                                 <div class="border border-info bg-info" style="border: 1px solid #e1e1e1fa;padding-left: 4px;">Nama MPP : <?= HelperSpesialClass::getNamaPegawaiArray($item['pegawai']) ?? '' ?><br>Unit: <?= $item['layanan']['unit']['nama'] ?? '' ?><br>Waktu : <?= $item['created_at'] ?? '' ?></div>
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

                                     </div>
                                 </div>
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
                     <div class="card-header">
                         <h5 style="margin-bottom:6px;">Isian Catatan MPP (<?= ($_GET['layanan_nama'] ?? '') ?>)</h5>
                     </div>
                     <div class="card-body">
                         <?php $form = ActiveForm::begin(['id' => 'catatan-mpp', 'action' => 'javascript::void(0)', 'options' => ['class' => 'form form-catatan', 'role' => 'form']]); ?>
                         <?php if ($model->layanan_id != null && $model->pegawai_mpp_id != null) { ?>
                             <?= $form->field($model, 'id')->hiddenInput(['value' => $model->id])->label(false); ?>
                             <?= $form->field($model, 'pegawai_mpp_id')->hiddenInput(['value' => $model->pegawai_mpp_id])->label(false); ?>
                             <?= $form->field($model, 'layanan_id')->hiddenInput(['value' => $model->layanan_id])->label(false); ?>
                         <?php } else { ?>
                             <?= $form->field($model, 'pegawai_mpp_id')->hiddenInput(['value' => HelperSpesialClass::getUserLogin()['pegawai_id']])->label(false); ?>
                             <?= $form->field($model, 'layanan_id')->hiddenInput(['value' => $_GET['layanan_id']])->label(false); ?>
                         <?php } ?>
                         <div class="mb-2">
                             <label> Catatan MPP: <?= HelperSpesialClass::getUserLogin()['nama'] ?> </label>
                             <?= $form->field($model, 'catatan')->textarea(array('rows' => 10))->label(false); ?>
                             <?php
                                //  $form->field($model, 'lengkap')->widget(Select2::classname(), [
                                //         'data' => [
                                //             1 => 'Lengkap',
                                //             0 => 'Tidak Lengkap',
                                //         ],
                                //         'pluginOptions' => [
                                //             'allowClear' => false,
                                //             'placeholder' => 'Pilih...'
                                //         ],

                                //     ])->label('Status Catatan') 
                                // 
                                ?>
                         </div>
                         <div class="mb-2">
                             <?= Html::submitButton('Simpan Catatan MPP', ['class' => 'btn btn-success btn-block mb-2 rounded-0', 'id' => 'btn-icd-10-laporan-simpan']) ?>
                         </div>
                     </div>
                 </div>
             </div>
         </div>
     </div>

     <?php ActiveForm::end(); ?>
 </div>