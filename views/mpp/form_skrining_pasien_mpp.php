 <?php

    use app\components\HelperSpesialClass;
    use kartik\select2\Select2;
    use yii\bootstrap4\ActiveForm;
    use yii\helpers\Html;
    use yii\helpers\Url;

    $this->registerJsVar("json_nyeri", json_encode(Yii::$app->params['other']['skrining_pasien_mpp']));
    $this->registerJs("

    function formTojson(data) {
        var formData = {};
        var formDataArrays = {};
        $.each(data, function (i, field) {
          if (field.value.trim() != '') {
            if (/\[\]$/.test(field.name)) {
              var fName = field.name.substr(0, field.name.length - 2);
              if (!formDataArrays[fName]) {
                formDataArrays[fName] = [];
              }
              formData[fName + '[' + formDataArrays[fName].length + ']'] =
                field.value;
              formDataArrays[fName].push(field.value);
            } else {
              formData[field.name] = field.value;
            }
          }
        });
        return formData;
      }
     $('#spmpp_form').on('beforeSubmit',function(e){
         e.preventDefault();
         var btn=$('.btn-submit');
         var htm=btn.html();
         var form = $('#spmpp_form').serializeArray();

         var formjson = formTojson(form);
         var obj_json_nyeri = JSON.parse(json_nyeri);
         var obj_json_spmpp = obj_json_nyeri.spmpp;
         //SET JSON Nyeri  spmpp BY FORM INPUT
         $.each(obj_json_spmpp.penilaian, function (i1, v1) {
           if (formjson[v1.id]) {
             var formjsonsplit = formjson[v1.id].split('@');
             $.each(v1.kriteria, function (i2, v2) {
               if (v2.val == formjsonsplit[2]) {
                 obj_json_spmpp.penilaian[i1].kriteria[i2].pilih = '1';
               }
             });
           }
         });
         obj_json_spmpp.total_skor = formjson.spmpp_total_skor;
         obj_json_spmpp.kategori_skor = formjson.spmpp_kategori_skor;
         //SET PARENT FORM SAVE Nyeri
         $('#skriningpasienmpp-hasil_json').val(JSON.stringify(obj_json_spmpp));
         $('#skriningpasienmpp-hasil_nilai').val(formjson.spmpp_total_skor);
         $('#skriningpasienmpp-hasil_deskripsi').val(formjson.spmpp_kategori_skor);
         $('body').addClass('loading');
         $('#btn-loading-analisa').attr('style', 'display: block')
         $.ajax({
             url:'" . Url::to(['save-skrining-pasien-mpp']) . "',
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
    console.log('error')
                App.ResetLoadingBtn(btn,htm);
             }
         });
     }).submit(function(e){
         e.preventDefault();
     });

     $(document).on('click','.btn-batalkan-skrining-pasien-mpp',function(e){
        e.preventDefault;
        e.stopImmediatePropagation();
        var obj_url=$(this).data('url');
        var key=$(this).data('key');
        Swal.fire({
            title:\"Anda Yakin ?\",
            text:\"Yakin Batalkan \"+key,
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
                Swal.fire({
                    title:\"Anda Benar-benar Yakin ?\",
                    text:\"Benaran Yakin Batalkan \"+key,
                    type:\"warning\",
                    showCancelButton:!0,
                    confirmButtonText:\"Ya!\",
                    cancelButtonText:\"Tidak!\",
                    confirmButtonClass:\"btn btn-success mt-2\",
                    cancelButtonClass:\"btn btn-danger ml-2 mt-2\",
                    buttonsStyling:!1,
                    showLoaderOnConfirm: true,
                }).then(function(tt){
                    tt.value?
                        $.ajax({
                            url:obj_url,
                            type:'GET',
                            success:function(data){
                                setTimeout(function () {
                                    window.location.reload();
                                 }, 2000);
                                if(data.con){
                                    
                                    fmsg.s(data.msg);
                                    
                                    
                                }else{
                                    fmsg.w(data.msg);
                                }
                            }
                            ,error:function(){
                                fmsg.e('Maaf, Terjadi Kesalahan Pada Aplikasi');
                            }
                        })
                    :tt.dismiss===Swal.DismissReason.cancel    
                    }
                )
            :t.dismiss===Swal.DismissReason.cancel    
            }
        );
    });
    $('.btn-preview-skrining-pasien-mpp').on('click', function (){
        $.get($(this).attr('href'), function(data) {
            $('.mymodal_card_xl_body').html(data);
            $('.mymodal_card_xl').modal('show');
       });
       return false;
    });
    ");
    ?>


 <div class="row">

     <div class="col-lg-9">
         <div class="card card-primary card-outline">
             <div class="card-header">
                 <h5 style="margin-bottom:6px;">Skrining Pasien Manager Pelayanan Pasien </h5>
             </div>
             <div class="card-body">
                 <?php $form = ActiveForm::begin(['id' => 'spmpp_form', 'action' => 'javascript::void(0)', 'options' => ['class' => 'form form-catatan', 'role' => 'form']]); ?>
                 <?= $form->field($model, 'mpp_id')->hiddenInput(['value' => HelperSpesialClass::getUserLogin()['pegawai_id']])->label(false); ?>
                 <?= $form->field($model, 'layanan_id')->hiddenInput(['value' => $_GET['layanan_id']])->label(false); ?>

                 <?= $form->field($model, 'registrasi_kode')->hiddenInput(['value' => $registrasi['kode']])->label(false); ?>
                 <?= $form->field($model, 'hasil_json')->hiddenInput()->label(false); ?>
                 <?= $form->field($model, 'hasil_nilai')->hiddenInput()->label(false); ?>
                 <?= $form->field($model, 'hasil_deskripsi')->hiddenInput()->label(false); ?>
                 <table class="table table-sm tabelm">
                     <colgroup width="40"></colgroup>
                     <colgroup width="100"></colgroup>
                     <colgroup width="400"></colgroup>
                     <tr>
                         <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=middle>No</td>
                         <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=middle>Parameter</td>
                         <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=middle>Nilai</td>
                     </tr>
                     <?php
                        $penilaian = Yii::$app->params['other']['skrining_pasien_mpp']['spmpp']['penilaian'];
                        $no = 1;
                        foreach ($penilaian as $p) {
                            echo '<tr>';
                            echo '<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=middle>' . $no . '</td>';
                            echo '<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom>' . $p['parameter'] . '</td>';
                            echo '<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom>';
                            echo '<div class="row"><div class="col-sm-12">';
                            foreach ($p['kriteria'] as $k) {
                                echo '<div class="mb-2">';
                                echo '<input type="radio" required id="' . $p['id'] . '" name="' . $p['id'] . '" value="' . $p['parameter'] . '@' . $k['des'] . '@' . $k['val'] . '">';
                                echo '<label style="margin-bottom:0px;!important;">' . $k['des'] . ' = ' . $k['val'] . '</label>';
                                echo '</div>';
                            }
                            echo '</div></div>';
                            echo '</td>';
                            echo '</tr>';
                            $no++;
                        }
                        ?>
                     <tr>
                         <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" colspan="2" valign=middle>Keterangan Kategori Skor</td>
                         <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=middle>
                             <?= Yii::$app->params['other']['skrining_pasien_mpp']['spmpp']['keterangan_skor'] ?>
                         </td>
                     </tr>
                     <tr>
                         <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" colspan="2" valign=middle>Total Skor</td>
                         <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom>
                             <div class="row">
                                 <div class="col-sm-12">
                                     <input type="text" id="spmpp_total_skor" name="spmpp_total_skor" class="form-control form-control-sm" readonly="true">
                                 </div>
                             </div>
                         </td>
                     </tr>
                     <tr>
                         <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" colspan="2" valign=middle>Kategori Skor</td>
                         <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom>
                             <div class="row">
                                 <div class="col-sm-12">
                                     <input type="text" id="spmpp_kategori_skor" name="spmpp_kategori_skor" class="form-control form-control-sm" readonly="true">
                                 </div>
                             </div>
                         </td>
                     </tr>
                 </table>
                 <div class="mb-2">
                     <?= Html::submitButton('Simpan Skrining', ['class' => 'btn btn-success btn-block mb-2 rounded-0', 'id' => 'btn-icd-10-laporan-simpan']) ?>
                 </div>
                 <?php ActiveForm::end(); ?>
             </div>
         </div>
     </div>
     <div class="col-lg-3">
         <div class="card card-primary card-outline">
             <div class="card-header">
                 <h5 style="margin-bottom:6px;">Daftar Skrining Pasien MPP</h5>
             </div>
             <div class="card-body">
                 <?php
                    if (!empty($listSkriningPasienMpp)) {
                        foreach ($listSkriningPasienMpp as $item) { ?>
                         <div class="border border-info <?= $item['batal'] ? 'bg-danger' : 'bg-info' ?>" style="border: 1px solid #e1e1e1fa;padding-left: 4px;">Nama MPP : <?= HelperSpesialClass::getNamaPegawaiArray($item['mpp']) ?? '' ?><br>Unit: <?= $item['layanan']['unit']['nama'] ?? '' ?><br>Waktu : <?= $item['created_at'] ?? '' ?></div>
                         <div class="border border-top-0 border-bottom-0 border-info font-weight-bold" style="padding-left: 4px;">Hasil : <?= $item['hasil_nilai'] ?? '' ?></div>
                         <div colspan="3" class="border border-top-0 border-info" style="padding-left: 4px;"><?= $item['hasil_deskripsi'] ?? '' ?></div>
                         <div class="border border-top-0 border-info bg-white text-right" style="padding: 4px;color:white">
                             <a class="btn btn-success btn-sm btn-preview-skrining-pasien-mpp" href="<?= Url::to(['/mpp/preview-skrining-pasien-mpp', 'id' => $item['id']]) ?>" data-id="<?= $item['id'] ?>" data-nama="<?= $item['id'] ?>"> <i class="fa fa-eye"></i></i></a>

                             <a class="btn btn-danger btn-sm btn-batalkan-skrining-pasien-mpp" data-url="<?= Url::to(['mpp/batalkan-skrining-pasien-mpp', 'id' => $item['id']]) ?>" data-id="<?= $item['id'] ?>" data-nama="<?= $item['id'] ?>"> <i style="color:white" class="fa fa-trash"></i></i></a>

                         </div>
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

     </div>
 </div>

 <?php
    $this->registerJs($this->render('_form.js'));
    ?>