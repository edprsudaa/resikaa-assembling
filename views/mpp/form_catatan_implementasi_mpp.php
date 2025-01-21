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
             url:'" . Url::to(['save-catatan-implementasi-mpp']) . "',
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
                         <h5 style="margin-bottom:6px;">Isian Catatan Implementasi MPP (<?= ($_GET['layanan_nama'] ?? '') ?>)</h5>
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
                             <label> Catatan Implementasi MPP: <?= HelperSpesialClass::getUserLogin()['nama'] ?> </label>
                             <?= $form->field($model, 'catatan')->textarea(array('rows' => 10))->label(false); ?>

                         </div>
                         <div class="mb-2">
                             <?= Html::submitButton('Simpan Catatan MPP', ['class' => 'btn btn-success btn-block mb-2 rounded-0', 'id' => 'btn-icd-10-laporan-simpan']) ?>
                         </div>
                     </div>
                 </div>
             </div>
             <div class="col-lg-7">
                 <div class="card card-primary card-outline">
                     <div class="card-header">
                         <h5 style="margin-bottom:6px;">Daftar Catatan Implementasi MPP</h5>
                     </div>
                     <div class="card-body">
                         <table class="table table-striped table-bordered">
                             <tr class="bg-info">
                                 <th>Tanggal / Jam</th>
                                 <th>Catatan</th>
                                 <th>Nama Mpp</th>
                             </tr>
                             <?php
                                if (!empty($listMpp)) {
                                    foreach ($listMpp as $item) { ?>
                                     <tr>
                                         <td><?= $item['created_at'] ?? '' ?></td>
                                         <td><?= $item['catatan'] ?? '' ?></td>
                                         <td><?= HelperSpesialClass::getNamaPegawaiArray($item['pegawai']) ?? '' ?></td>
                                     </tr>

                             <?php
                                    }
                                } ?>
                         </table>
                     </div>
                 </div>

             </div>
         </div>

     </div>

     <?php ActiveForm::end(); ?>
 </div>