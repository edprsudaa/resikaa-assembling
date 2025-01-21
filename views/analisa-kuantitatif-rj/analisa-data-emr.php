 <?php

    use app\components\HelperSpesialClass;
    use kartik\select2\Select2;
    use yii\bootstrap4\ActiveForm;
    use yii\helpers\Html;
    use yii\helpers\Url;

    $this->registerJs("
    $('#analisa-dokumen').on('beforeSubmit',function(e){
        e.preventDefault();
        var btn=$('.btn-submit');
        var htm=btn.html();
        $('body').addClass('loading');
        $('#btn-loading-analisa').attr('style', 'display: block')
        $.ajax({
            url:'" . Url::to(['save']) . "',
            type:'post',
            dataType:'json',
            data:$(this).serialize(),
            success:function(result){
                if(result.status){
                toastr.success(result.msg);
                }
                if(result.status){
                    setTimeout(function () {
                    window.location =
                    baseUrl +
                        analisa_kuantitatif_controller+'list-rawat-inap'
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
                // App.Error(error);
                // App.ResetLoadingBtn(btn,htm);
            }
        });
    }).submit(function(e){
        e.preventDefault();
    });
    ")
    ?>

 <div class="card card-primary card-outline">
     <?php $form = ActiveForm::begin(['id' => 'analisa-dokumen', 'action' => 'javascript::void(0)', 'options' => ['class' => 'form form-catatan', 'role' => 'form']]); ?>
     <?php if (!empty($model->analisa_dokumen_id)) { ?>
         <input type="hidden" name="analisa_dokumen_id" value="<?php echo $model->analisa_dokumen_id; ?>">
     <?php } ?>
     <?= $form->field($model, 'reg_kode')->hiddenInput(['value' => $registrasi['kode']])->label(false); ?>
     <?= $form->field($model, 'ps_kode')->hiddenInput(['value' => $registrasi['pasien']['kode']])->label(false); ?>
     <div class="card-header">
         <h5 class="card-title m-0">ANALISA DATA ELECTRONIC MEDICAL RECORD</h5>
     </div>
     <div class="card-body">
         <div class="row">
             <table class="table table-striped table-bordered" style="text-align: justify;" id="analisa-kuantitatif">
                 <tr style="text-align: center;">
                     <th rowspan="2" style="vertical-align : middle;">Kriteria Analisa</th>
                     <th colspan="2">Ada</th>
                     <th rowspan="2" style="vertical-align : middle;">Tidak Ada</th>
                 </tr>
                 <tr style="text-align: center;">
                     <th>Lengkap</th>
                     <th>Tidak Lengkap</th>
                 </tr>
                 <?php
                    if (!$model->isNewRecord) {

                        $no = 1;
                        $tab = 1;
                        $jenis = [null, null];
                        foreach ($model->analisaDokumenDetail as $k) {
                            if ($jenis[0] != $k->jenisAnalisa->jenis_analisa_id) {
                                $jenis = [$k['jenisAnalisa']['jenis_analisa_id'], $k['jenisAnalisa']['jenis_analisa_uraian']];
                    ?>
                             <tr class="p-0" style="border: 1px solid;">
                                 <td colspan="5">
                                     <div>
                                         <b><?php echo $k['jenisAnalisa']['jenis_analisa_uraian']; ?></b>
                                     </div>
                                 </td>
                             </tr>
                             <?php }
                            if ($k['itemAnalisa'] != null) {

                                if ($k['itemAnalisa']['item_analisa_tipe'] == 1) {
                                ?>
                                 <tr>
                                     <td style="width: 55%;">
                                         <?php echo  $no . '. ' . $k['itemAnalisa']['item_analisa_uraian']; ?>
                                         <input type="hidden" name="AnalisaDokumenDetail[<?php echo $no; ?>][analisa_dokumen_detail_id]" value="<?= $k['analisa_dokumen_detail_id'] ?>">
                                         <input type="hidden" name="AnalisaDokumenDetail[<?php echo $no; ?>][analisa_dokumen_jenis_analisa_detail_id]" value="<?= $k['analisa_dokumen_jenis_analisa_detail_id'] ?>">
                                         <input type="hidden" name="AnalisaDokumenDetail[<?php echo $no; ?>][analisa_dokumen_item_id]" value="<?= $k['itemAnalisa']['item_analisa_id'] ?>">

                                         <input type="hidden" name="AnalisaDokumenDetail[<?php echo $no; ?>][analisa_dokumen_jenis_id]" value="<?= $k['jenisAnalisa']['jenis_analisa_id'] ?>">
                                     </td>


                                     <td width="15%" colspan="2">
                                         <div>
                                             <input type="radio" required id="identifikasi_no_pasien_<?php echo $no; ?>_1" name="AnalisaDokumenDetail[<?php echo $no; ?>][analisa_dokumen_kelengkapan]" value="3" <?php echo ($k->analisa_dokumen_kelengkapan == '3' ? 'checked' : '') ?>>
                                             <label for="identifikasi_no_pasien_<?php echo $no; ?>_1">
                                                 Ada
                                             </label>
                                         </div>
                                     </td>
                                     <td width="15%">
                                         <div>
                                             <input type="radio" required id="identifikasi_no_pasien_<?php echo $no; ?>_2" name="AnalisaDokumenDetail[<?php echo $no; ?>][analisa_dokumen_kelengkapan]" value="0" <?php echo ($k->analisa_dokumen_kelengkapan == '0' ? 'checked' : '') ?>>
                                             <label for="identifikasi_no_pasien_<?php echo $no; ?>_2">
                                                 Tidak Ada
                                             </label>
                                         </div>
                                     </td>



                                 </tr>
                             <?php   } else { ?>
                                 <tr>
                                     <td style="width: 55%;">
                                         <?php echo  $no . '. ' . $k['itemAnalisa']['item_analisa_uraian']; ?>
                                         <input type="hidden" name="AnalisaDokumenDetail[<?php echo $no; ?>][analisa_dokumen_detail_id]" value="<?= $k['analisa_dokumen_detail_id'] ?>">
                                         <input type="hidden" name="AnalisaDokumenDetail[<?php echo $no; ?>][analisa_dokumen_jenis_analisa_detail_id]" value="<?= $k['analisa_dokumen_jenis_analisa_detail_id'] ?>">
                                         <input type="hidden" name="AnalisaDokumenDetail[<?php echo $no; ?>][analisa_dokumen_item_id]" value="<?= $k['itemAnalisa']['item_analisa_id'] ?>">

                                         <input type="hidden" name="AnalisaDokumenDetail[<?php echo $no; ?>][analisa_dokumen_jenis_id]" value="<?= $k['jenisAnalisa']['jenis_analisa_id'] ?>">
                                     </td>


                                     <td width="15%">
                                         <div>
                                             <input type="radio" required id="identifikasi_no_pasien_<?php echo $no; ?>_1" name="AnalisaDokumenDetail[<?php echo $no; ?>][analisa_dokumen_kelengkapan]" value="2" <?php echo ($k->analisa_dokumen_kelengkapan == '2' ? 'checked' : '') ?>>
                                             <label for="identifikasi_no_pasien_<?php echo $no; ?>_1">
                                                 Lengkap
                                             </label>
                                         </div>
                                     </td>

                                     <td width="15%">
                                         <div>
                                             <input type="radio" required id="identifikasi_no_pasien_<?php echo $no; ?>_2" name="AnalisaDokumenDetail[<?php echo $no; ?>][analisa_dokumen_kelengkapan]" value="1" <?php echo ($k->analisa_dokumen_kelengkapan == '1' ? 'checked' : '') ?>>
                                             <label for="identifikasi_no_pasien_<?php echo $no; ?>_2">
                                                 Tidak Lengkap
                                             </label>
                                         </div>
                                     </td>

                                     <td width="15%">
                                         <div>
                                             <input type="radio" required id="identifikasi_no_pasien_<?php echo $no; ?>_3" name="AnalisaDokumenDetail[<?php echo $no; ?>][analisa_dokumen_kelengkapan]" value="0" <?php echo ($k->analisa_dokumen_kelengkapan == '0' ? 'checked' : '') ?>>
                                             <label for="identifikasi_no_pasien_<?php echo $no; ?>_3">
                                                 Tidak Ada
                                             </label>
                                         </div>
                                     </td>

                                 </tr>

                         <?php }
                                $no++;
                            }
                            ?>


                     <?php

                        }
                    } else {


                        ?>

                     <?php

                        $no = 1;
                        $tab = 1;
                        $jenis = [null, null];
                        foreach ($listAnalisa as $k) {
                            if ($jenis[0] != $k['jenisAnalisa']['jenis_analisa_id']) {
                                $jenis = [$k['jenisAnalisa']['jenis_analisa_id'], $k['jenisAnalisa']['jenis_analisa_uraian']];
                        ?>
                             <tr class="p-0" style="border: 1px solid;">
                                 <td colspan="5">
                                     <div>
                                         <b><?php echo $k['jenisAnalisa']['jenis_analisa_uraian']; ?></b>
                                     </div>
                                 </td>
                             </tr>
                         <?php } ?>

                         <?php
                            if ($k['itemAnalisa']['item_analisa_tipe'] == 1) {
                            ?>
                             <tr>
                                 <td style="width: 55%;">
                                     <?php echo $no . '. ' . $k['itemAnalisa']['item_analisa_uraian']; ?>
                                     <input type="hidden" name="AnalisaDokumenDetail[<?php echo $no; ?>][analisa_dokumen_jenis_analisa_detail_id]" value="<?= $k['jenis_analisa_detail_id'] ?>">
                                     <input type="hidden" name="AnalisaDokumenDetail[<?php echo $no; ?>][analisa_dokumen_item_id]" value="<?= $k['itemAnalisa']['item_analisa_id'] ?>">
                                     <input type="hidden" name="AnalisaDokumenDetail[<?php echo $no; ?>][analisa_dokumen_jenis_id]" value="<?= $k['jenisAnalisa']['jenis_analisa_id'] ?>">
                                 </td>


                                 <td width="15%" colspan="2">
                                     <div>
                                         <input type="radio" required id="identifikasi_no_pasien_<?php echo $no; ?>_1" name="AnalisaDokumenDetail[<?php echo $no; ?>][analisa_dokumen_kelengkapan]" value="3">
                                         <label for="identifikasi_no_pasien_<?php echo $no; ?>_1">
                                             Ada
                                         </label>
                                     </div>
                                 </td>
                                 <td width="15%">
                                     <div>
                                         <input type="radio" required id="identifikasi_no_pasien_<?php echo $no; ?>_3" name="AnalisaDokumenDetail[<?php echo $no; ?>][analisa_dokumen_kelengkapan]" value="0">
                                         <label for="identifikasi_no_pasien_<?php echo $no; ?>_3">
                                             Tidak Ada
                                         </label>
                                     </div>
                                 </td>




                             </tr>
                         <?php   } else { ?>
                             <tr>
                                 <td style="width: 55%;">
                                     <?php echo $no . '. ' . $k['itemAnalisa']['item_analisa_uraian']; ?>
                                     <input type="hidden" name="AnalisaDokumenDetail[<?php echo $no; ?>][analisa_dokumen_jenis_analisa_detail_id]" value="<?= $k['jenis_analisa_detail_id'] ?>">
                                     <input type="hidden" name="AnalisaDokumenDetail[<?php echo $no; ?>][analisa_dokumen_item_id]" value="<?= $k['itemAnalisa']['item_analisa_id'] ?>">
                                     <input type="hidden" name="AnalisaDokumenDetail[<?php echo $no; ?>][analisa_dokumen_jenis_id]" value="<?= $k['jenisAnalisa']['jenis_analisa_id'] ?>">
                                 </td>


                                 <td width="15%">
                                     <div>
                                         <input type="radio" required id="identifikasi_no_pasien_<?php echo $no; ?>_1" name="AnalisaDokumenDetail[<?php echo $no; ?>][analisa_dokumen_kelengkapan]" value="2">
                                         <label for="identifikasi_no_pasien_<?php echo $no; ?>_1">
                                             Lengkap
                                         </label>
                                     </div>
                                 </td>

                                 <td width="15%">
                                     <div>
                                         <input type="radio" required id="identifikasi_no_pasien_<?php echo $no; ?>_2" name="AnalisaDokumenDetail[<?php echo $no; ?>][analisa_dokumen_kelengkapan]" value="1">
                                         <label for="identifikasi_no_pasien_<?php echo $no; ?>_2">
                                             Tidak Lengkap
                                         </label>
                                     </div>
                                 </td>

                                 <td width="15%">
                                     <div>
                                         <input type="radio" required id="identifikasi_no_pasien_<?php echo $no; ?>_3" name="AnalisaDokumenDetail[<?php echo $no; ?>][analisa_dokumen_kelengkapan]" value="0">
                                         <label for="identifikasi_no_pasien_<?php echo $no; ?>_3">
                                             Tidak Ada
                                         </label>
                                     </div>
                                 </td>

                             </tr>
                         <?php
                            }
                            ?>
                 <?php
                            $no++;
                        }
                    }
                    ?>


                 <tr>
                     <td>
                         <?= $form->field($model, 'dokter_id')->widget(Select2::classname(), [
                                'data' => HelperSpesialClass::getListDokter(false, true),
                                'size' => 'xs',
                                'options' => ['class' => 'form-control input-sm', 'placeholder' => 'Pilih Dokter DPJP...', 'required' => true],
                                'value' => $model->dokter_id,
                                'pluginOptions' => [
                                    'allowClear' => false,
                                    'initialize' => true
                                ],
                            ])->label('<label>Dokter DPJP : <b><span style="font-size: 12px;color: #000000;important;"><u></u></span></b></label>');
                            ?>


                     </td>
                     <td colspan="3">

                         <?= $form->field($model, 'unit_id')->widget(Select2::classname(), [
                                'data' => HelperSpesialClass::getListUnitAnalisa(),
                                'size' => 'xs',
                                'options' => ['class' => 'form-control input-sm', 'placeholder' => 'Pilih Poli Tujuan...'],
                                'value' => $model->unit_id,
                                'pluginOptions' => [
                                    'allowClear' => false
                                ],
                            ])->label('<label>Ruangan / Poli : <b><span style="font-size: 12px;color: #000000;important;"><u></u></span></b></label>');
                            ?>

                     </td>
                 </tr>
             </table>
         </div>
         <div class="form-group row">

             <div class="col-sm-6">
                 <button class="btn btn-secondary btn-block">Kembali</button>
             </div>
             <div class="col-sm-6">
                 <?= Html::submitButton('Simpan Analisa Dokumen', ['class' => 'btn btn-success btn-block btn-peminjaman-distribusi-submit', 'id' => 'btn-analisa-simpan']) ?>
             </div>

             <button class="btn btn-success" id="btn-loading-analisa" style="display:none" type="button" disabled>
                 <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                 Loading...
             </button>
         </div>
     </div>
     <?php ActiveForm::end(); ?>
 </div>