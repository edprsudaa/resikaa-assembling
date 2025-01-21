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
             url:'" . Url::to(['save-skrining-pemulangan-pasien-mpp']) . "',
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

     $('#SkriningPemulanganPasienMpp_pengaruh_rawat_inap_pasien_keluarga_2_t').on('input change focus paste', function (e) {
        let teks = $('#SkriningPemulanganPasienMpp_pengaruh_rawat_inap_pasien_keluarga_2_t').val()
        $('#SkriningPemulanganPasienMpp_pengaruh_rawat_inap_pasien_keluarga_2').val(teks)
        $('#SkriningPemulanganPasienMpp_pengaruh_rawat_inap_pasien_keluarga_2').prop('checked', true)
    });
    $('#SkriningPemulanganPasienMpp_pengaruh_pekerjaan_sekolah_2_t').on('input change focus paste', function (e) {
        let teks = $('#SkriningPemulanganPasienMpp_pengaruh_pekerjaan_sekolah_2_t').val()
        $('#SkriningPemulanganPasienMpp_pengaruh_pekerjaan_sekolah_2').val(teks)
        $('#SkriningPemulanganPasienMpp_pengaruh_pekerjaan_sekolah_2').prop('checked', true)
    });
    $('#SkriningPemulanganPasienMpp_pengaruh_keuangan_2_t').on('input change focus paste', function (e) {
        let teks = $('#SkriningPemulanganPasienMpp_pengaruh_keuangan_2_t').val()
        $('#SkriningPemulanganPasienMpp_pengaruh_keuangan_2').val(teks)
        $('#SkriningPemulanganPasienMpp_pengaruh_keuangan_2').prop('checked', true)
    });
    $('#SkriningPemulanganPasienMpp_antisipasi_masalah_saat_pulang_2_t').on('input change focus paste', function (e) {
        let teks = $('#SkriningPemulanganPasienMpp_antisipasi_masalah_saat_pulang_2_t').val()
        $('#SkriningPemulanganPasienMpp_antisipasi_masalah_saat_pulang_2').val(teks)
        $('#SkriningPemulanganPasienMpp_antisipasi_masalah_saat_pulang_2').prop('checked', true)
    });
  
    $('#SkriningPemulanganPasienMpp_bantuan_diperlukan_dalam_hal_0').on('change', function() {
        if (this.checked) {
            $(this).val(this.checked ? 'Menyiapkan Makanan': null)
            console.log($(this).val())
        } 
      });
    $('#SkriningPemulanganPasienMpp_bantuan_diperlukan_dalam_hal_1').on('change', function() {
        if (this.checked) {
            $(this).val(this.checked ? 'Makan Diet' : null)
            console.log($(this).val())
        } 
      });
      $('#SkriningPemulanganPasienMpp_bantuan_diperlukan_dalam_hal_2').on('change', function() {
        if (this.checked) {
            $(this).val(this.checked ? 'Menyiapkan Obat' : null)
            console.log($(this).val())
        } 
      });
      $('#SkriningPemulanganPasienMpp_bantuan_diperlukan_dalam_hal_3').on('change', function() {
        if (this.checked) {
            $(this).val(this.checked ? 'Minum Obat' : null)
            console.log($(this).val())
        } 
      });
      
      $('#SkriningPemulanganPasienMpp_bantuan_diperlukan_dalam_hal_4').on('change', function() {
        if (this.checked) {
            $(this).val(this.checked ? 'Mandi' : null)
            console.log($(this).val())
        } 
      });
      $('#SkriningPemulanganPasienMpp_bantuan_diperlukan_dalam_hal_5').on('change', function() {
        if (this.checked) {
            $(this).val(this.checked ? 'Berpakaian' : null)
            console.log($(this).val())
        } 
      });
      $('#SkriningPemulanganPasienMpp_bantuan_diperlukan_dalam_hal_6').on('change', function() {
        if (this.checked) {
            $(this).val(this.checked ? 'Transportasi' : null)
            console.log($(this).val())
        } 
      });
      $('#SkriningPemulanganPasienMpp_bantuan_diperlukan_dalam_hal_7').on('change', function() {
        if (this.checked) {
            $(this).val(this.checked ? 'Edukasi Kesehatan' : null)
            console.log($(this).val())
        } 
      });
      $('#SkriningPemulanganPasienMpp_bantuan_diperlukan_dalam_hal_8_t').on('input change focus paste', function (e) {
        let teks = $('#SkriningPemulanganPasienMpp_bantuan_diperlukan_dalam_hal_8_t').val()
        $('#SkriningPemulanganPasienMpp_bantuan_diperlukan_dalam_hal_8').val(teks)
        $('#SkriningPemulanganPasienMpp_bantuan_diperlukan_dalam_hal_8').prop('checked', true)
    });

    $('#SkriningPemulanganPasienMpp_membantu_keperluan_diatas_2_t').on('input change focus paste', function (e) {
        let teks = $('#SkriningPemulanganPasienMpp_membantu_keperluan_diatas_2_t').val()
        $('#SkriningPemulanganPasienMpp_membantu_keperluan_diatas_2').val(teks)
        $('#SkriningPemulanganPasienMpp_membantu_keperluan_diatas_2').prop('checked', true)
    });
    $('#SkriningPemulanganPasienMpp_pasien_tinggal_sendiri_setelah_keluar_rs_2_t').on('input change focus paste', function (e) {
        let teks = $('#SkriningPemulanganPasienMpp_pasien_tinggal_sendiri_setelah_keluar_rs_2_t').val()
        $('#SkriningPemulanganPasienMpp_pasien_tinggal_sendiri_setelah_keluar_rs_2').val(teks)
        $('#SkriningPemulanganPasienMpp_pasien_tinggal_sendiri_setelah_keluar_rs_2').prop('checked', true)
    });
    $('#SkriningPemulanganPasienMpp_pasien_gunakan_peralatan_medis_setelah_keluar_rs_2_t').on('input change focus paste', function (e) {
        let teks = $('#SkriningPemulanganPasienMpp_pasien_gunakan_peralatan_medis_setelah_keluar_rs_2_t').val()
        $('#SkriningPemulanganPasienMpp_pasien_gunakan_peralatan_medis_setelah_keluar_rs_2').val(teks)
        $('#SkriningPemulanganPasienMpp_pasien_gunakan_peralatan_medis_setelah_keluar_rs_2').prop('checked', true)
    });
    $('#SkriningPemulanganPasienMpp_perlu_alat_bantu_setelah_keluar_rs_2_t').on('input change focus paste', function (e) {
        let teks = $('#SkriningPemulanganPasienMpp_perlu_alat_bantu_setelah_keluar_rs_2_t').val()
        $('#SkriningPemulanganPasienMpp_perlu_alat_bantu_setelah_keluar_rs_2').val(teks)
        $('#SkriningPemulanganPasienMpp_perlu_alat_bantu_setelah_keluar_rs_2').prop('checked', true)
    });
    $('#SkriningPemulanganPasienMpp_bantuan_khusus_perawatan_setelah_keluar_rs_2_t').on('input change focus paste', function (e) {
        let teks = $('#SkriningPemulanganPasienMpp_bantuan_khusus_perawatan_setelah_keluar_rs_2_t').val()
        $('#SkriningPemulanganPasienMpp_bantuan_khusus_perawatan_setelah_keluar_rs_2').val(teks)
        $('#SkriningPemulanganPasienMpp_bantuan_khusus_perawatan_setelah_keluar_rs_2').prop('checked', true)
    });
    $('#SkriningPemulanganPasienMpp_masalah_memenuhi_kebutuhan_setelah_keluar_rs_2_t').on('input change focus paste', function (e) {
        let teks = $('#SkriningPemulanganPasienMpp_masalah_memenuhi_kebutuhan_setelah_keluar_rs_2_t').val()
        $('#SkriningPemulanganPasienMpp_masalah_memenuhi_kebutuhan_setelah_keluar_rs_2').val(teks)
        $('#SkriningPemulanganPasienMpp_masalah_memenuhi_kebutuhan_setelah_keluar_rs_2').prop('checked', true)
    });
    $('#SkriningPemulanganPasienMpp_nyeri_kronis_kelelahan_setelah_keluar_rs_2_t').on('input change focus paste', function (e) {
        let teks = $('#SkriningPemulanganPasienMpp_nyeri_kronis_kelelahan_setelah_keluar_rs_2_t').val()
        $('#SkriningPemulanganPasienMpp_nyeri_kronis_kelelahan_setelah_keluar_rs_2').val(teks)
        $('#SkriningPemulanganPasienMpp_nyeri_kronis_kelelahan_setelah_keluar_rs_2').prop('checked', true)
    });
    $('#SkriningPemulanganPasienMpp_perlu_edukasi_kesehatan_setelah_keluar_rs_2_t').on('input change focus paste', function (e) {
        let teks = $('#SkriningPemulanganPasienMpp_perlu_edukasi_kesehatan_setelah_keluar_rs_2_t').val()
        $('#SkriningPemulanganPasienMpp_perlu_edukasi_kesehatan_setelah_keluar_rs_2').val(teks)
        $('#SkriningPemulanganPasienMpp_perlu_edukasi_kesehatan_setelah_keluar_rs_2').prop('checked', true)
    });
    $('#SkriningPemulanganPasienMpp_perlu_keterampilan_khusus_setelah_keluar_rs_2_t').on('input change focus paste', function (e) {
        let teks = $('#SkriningPemulanganPasienMpp_perlu_keterampilan_khusus_setelah_keluar_rs_2_t').val()
        $('#SkriningPemulanganPasienMpp_perlu_keterampilan_khusus_setelah_keluar_rs_2').val(teks)
        $('#SkriningPemulanganPasienMpp_perlu_keterampilan_khusus_setelah_keluar_rs_2').prop('checked', true)
    });

    $('#SkriningPemulanganPasienMpp_bantuan_diperlukan_dalam_hal_4_t').on('input change focus paste', function (e) {
        let teks = $('#SkriningPemulanganPasienMpp_bantuan_diperlukan_dalam_hal_4_t').val()
        $('#SkriningPemulanganPasienMpp_bantuan_diperlukan_dalam_hal_4').val(teks)
        $('#SkriningPemulanganPasienMpp_bantuan_diperlukan_dalam_hal_4').prop('checked', true)
    });
    $(document).on('click','.btn-batalkan-skrining-pemulangan-pasien-mpp',function(e){
        e.preventDefault;
        e.stopImmediatePropagation();
        var obj_url=$(this).data('url');
        var key=$(this).data('key');
        Swal.fire({
            title:\"Anda Yakin ?\",
            text:\"Yakin Batalkan \",
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
    $('.btn-preview-skrining-pemulangan-pasien-mpp').on('click', function (){
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
                 <h5 style="margin-bottom:6px;">Skrining Pemulangan Pasien Manager Pelayanan Pasien </h5>
             </div>
             <div class="card-body">
                 <?php $form = ActiveForm::begin(['id' => 'spmpp_form',  'options' => ['class' => 'form form-catatan', 'role' => 'form']]); ?>
                 <?= $form->field($model, 'mpp_id')->hiddenInput(['value' => HelperSpesialClass::getUserLogin()['pegawai_id']])->label(false); ?>
                 <?= $form->field($model, 'layanan_id')->hiddenInput(['value' => $_GET['layanan_id']])->label(false); ?>

                 <?= $form->field($model, 'registrasi_kode')->hiddenInput(['value' => $registrasi['kode']])->label(false); ?>
                 <div class="row">
                     <div class="col-md-12">
                         <p class="mb-3 text-uppercase bg-info p-2"><i class="fa fa-bookmark"></i> Kriteria Discharge Planning </p>
                     </div>
                 </div>
                 <div class="row">
                     <div class="col-md-6">
                         <p>Umur > 65 Tahun :</p>
                     </div>
                     <div class="col-md-6">

                         <?= $form->field($model, 'umur')->inline(true)->radioList(['Tidak' => 'Tidak', 'Ya' => 'Ya'])->label(false) ?>
                     </div>
                 </div>
                 <div class="row">
                     <div class="col-md-6">
                         <p>Keterbatasan Mobilitas :</p>
                     </div>
                     <div class="col-md-6">

                         <?= $form->field($model, 'keterbatasan_mobilitas')->inline(true)->radioList(['Tidak' => 'Tidak', 'Ya' => 'Ya'])->label(false) ?>
                     </div>
                 </div>
                 <div class="row">
                     <div class="col-md-6">
                         <p>Perawatan dan Pengobatan Lanjutan :</p>
                     </div>
                     <div class="col-md-6">

                         <?= $form->field($model, 'perawatan_pengobatan_lanjutan')->inline(true)->radioList(['Tidak' => 'Tidak', 'Ya' => 'Ya'])->label(false) ?>
                     </div>
                 </div>
                 <div class="row">
                     <div class="col-md-6">
                         <p>Bantuan untuk melakukan aktivitas sehari-hari :</p>
                     </div>
                     <div class="col-md-6">

                         <?= $form->field($model, 'bantuan_aktivitas_sehari_hari')->inline(true)->radioList(['Tidak' => 'Tidak', 'Ya' => 'Ya'])->label(false) ?>
                     </div>
                 </div>
                 <div class="row">
                     <div class="col-md-12">
                         <p class="mb-3 bg-info p-2">Bila semua jawaban '<b class="text-black">Tidak</b>' maka tidak memerlukan Manager Pelayanan Pasien <br>
                             Bila ada jawaban '<b>Ya</b>' diperlukan Manager Pelayanan Pasien, lanjutkan perencana pulang berikut :
                         </p>
                     </div>
                 </div>
                 <p><b>1. Pengaruh Rawat Inap terhadap :</b></p>
                 <div class="row">
                     <div class="col-sm-12">
                         <div class="row">
                             <div class="col-md-4">
                                 <p>Pasien dan keluarga pasien :</p>
                             </div>
                             <div class="col-md-2">
                                 <?php
                                    $pengaruh_rawat_inap_pasien_keluarga = ['Tidak' => 'Tidak'];
                                    echo $form->field($model, 'pengaruh_rawat_inap_pasien_keluarga')->inline(true)->radioList($pengaruh_rawat_inap_pasien_keluarga)->label(false);
                                    ?>
                             </div>
                             <div class="col-md-6">
                                 <div class="form-group">
                                     <div class="input-group">
                                         <div class="input-group-prepend">
                                             <div class="input-group-text">
                                                 <input value="<?= (!in_array($model->pengaruh_rawat_inap_pasien_keluarga, $pengaruh_rawat_inap_pasien_keluarga) && !empty($model->pengaruh_rawat_inap_pasien_keluarga)) ? $model->pengaruh_rawat_inap_pasien_keluarga : null ?>" <?= (!in_array($model->pengaruh_rawat_inap_pasien_keluarga, $pengaruh_rawat_inap_pasien_keluarga) && !empty($model->pengaruh_rawat_inap_pasien_keluarga)) ? 'checked' : null ?> type="radio" id="SkriningPemulanganPasienMpp_pengaruh_rawat_inap_pasien_keluarga_2" name="SkriningPemulanganPasienMpp[pengaruh_rawat_inap_pasien_keluarga]">
                                             </div>
                                         </div>
                                         <textarea rows="3" id="SkriningPemulanganPasienMpp_pengaruh_rawat_inap_pasien_keluarga_2_t" class="form-control" placeholder="Sebutkan Jika Ya"><?= (!in_array($model->pengaruh_rawat_inap_pasien_keluarga, $pengaruh_rawat_inap_pasien_keluarga) && !empty($model->pengaruh_rawat_inap_pasien_keluarga)) ? $model->pengaruh_rawat_inap_pasien_keluarga : null ?></textarea>
                                     </div>
                                 </div>
                             </div>
                         </div>
                         <div class="row">
                             <div class="col-md-4">
                                 <p>Pekerjaan / Sekolah :</p>
                             </div>
                             <div class="col-md-2">
                                 <?php
                                    $pengaruh_pekerjaan_sekolah = ['Tidak' => 'Tidak'];
                                    echo $form->field($model, 'pengaruh_pekerjaan_sekolah')->inline(true)->radioList($pengaruh_pekerjaan_sekolah)->label(false);
                                    ?>
                             </div>
                             <div class="col-md-6">
                                 <div class="form-group">
                                     <div class="input-group">
                                         <div class="input-group-prepend">
                                             <div class="input-group-text">
                                                 <input value="<?= (!in_array($model->pengaruh_pekerjaan_sekolah, $pengaruh_pekerjaan_sekolah) && !empty($model->pengaruh_pekerjaan_sekolah)) ? $model->pengaruh_pekerjaan_sekolah : null ?>" <?= (!in_array($model->pengaruh_pekerjaan_sekolah, $pengaruh_pekerjaan_sekolah) && !empty($model->pengaruh_pekerjaan_sekolah)) ? 'checked' : null ?> type="radio" id="SkriningPemulanganPasienMpp_pengaruh_pekerjaan_sekolah_2" name="SkriningPemulanganPasienMpp[pengaruh_pekerjaan_sekolah]">
                                             </div>
                                         </div>
                                         <textarea rows="3" id="SkriningPemulanganPasienMpp_pengaruh_pekerjaan_sekolah_2_t" class="form-control" placeholder="Sebutkan Jika Ya"><?= (!in_array($model->pengaruh_pekerjaan_sekolah, $pengaruh_pekerjaan_sekolah) && !empty($model->pengaruh_pekerjaan_sekolah)) ? $model->pengaruh_pekerjaan_sekolah : null ?></textarea>
                                     </div>
                                 </div>
                             </div>
                         </div>
                         <div class="row">
                             <div class="col-md-4">
                                 <p>Keuangan :</p>
                             </div>
                             <div class="col-md-2">
                                 <?php
                                    $pengaruh_keuangan = ['Tidak' => 'Tidak'];
                                    echo $form->field($model, 'pengaruh_keuangan')->inline(true)->radioList($pengaruh_keuangan)->label(false);
                                    ?>
                             </div>
                             <div class="col-md-6">
                                 <div class="form-group">
                                     <div class="input-group">
                                         <div class="input-group-prepend">
                                             <div class="input-group-text">
                                                 <input value="<?= (!in_array($model->pengaruh_keuangan, $pengaruh_keuangan) && !empty($model->pengaruh_keuangan)) ? $model->pengaruh_keuangan : null ?>" <?= (!in_array($model->pengaruh_keuangan, $pengaruh_keuangan) && !empty($model->pengaruh_keuangan)) ? 'checked' : null ?> type="radio" id="SkriningPemulanganPasienMpp_pengaruh_keuangan_2" name="SkriningPemulanganPasienMpp[pengaruh_keuangan]">
                                             </div>
                                         </div>
                                         <textarea rows="3" id="SkriningPemulanganPasienMpp_pengaruh_keuangan_2_t" class="form-control" placeholder="Sebutkan Jika Ya"><?= (!in_array($model->pengaruh_keuangan, $pengaruh_keuangan) && !empty($model->pengaruh_keuangan)) ? $model->pengaruh_keuangan : null ?></textarea>
                                     </div>
                                 </div>
                             </div>
                         </div>

                     </div>
                 </div>
                 <p><b>2. Antisipasi terhadap masalah saat pulang :</b></p>
                 <div class="row">

                     <div class="col-md-2">
                         <?php
                            $antisipasi_masalah_saat_pulang = ['Tidak' => 'Tidak'];
                            echo $form->field($model, 'antisipasi_masalah_saat_pulang')->inline(true)->radioList($antisipasi_masalah_saat_pulang)->label(false);
                            ?>
                     </div>
                     <div class="col-md-10">
                         <div class="form-group">
                             <div class="input-group">
                                 <div class="input-group-prepend">
                                     <div class="input-group-text">
                                         <input value="<?= (!in_array($model->antisipasi_masalah_saat_pulang, $antisipasi_masalah_saat_pulang) && !empty($model->antisipasi_masalah_saat_pulang)) ? $model->antisipasi_masalah_saat_pulang : null ?>" <?= (!in_array($model->antisipasi_masalah_saat_pulang, $antisipasi_masalah_saat_pulang) && !empty($model->antisipasi_masalah_saat_pulang)) ? 'checked' : null ?> type="radio" id="SkriningPemulanganPasienMpp_antisipasi_masalah_saat_pulang_2" name="SkriningPemulanganPasienMpp[antisipasi_masalah_saat_pulang]">
                                     </div>
                                 </div>
                                 <textarea rows="3" id="SkriningPemulanganPasienMpp_antisipasi_masalah_saat_pulang_2_t" class="form-control" placeholder="Sebutkan Jika Ya"><?= (!in_array($model->antisipasi_masalah_saat_pulang, $antisipasi_masalah_saat_pulang) && !empty($model->antisipasi_masalah_saat_pulang)) ? $model->antisipasi_masalah_saat_pulang : null ?></textarea>
                             </div>
                         </div>



                     </div>
                 </div>
                 <p><b>3. Bantuan diperlukan dalam hal :</b></p>
                 <div class="row">
                     <div class="col-md-12">
                         <div class="row pt-2">
                             <div class="col-sm-2">

                             </div>

                             <div class="col-sm-9">
                                 <div class="form-group field-SkriningPemulanganPasienMpp-bantuan_diperlukan_dalam_hal">
                                     <div id="SkriningPemulanganPasienMpp-bantuan_diperlukan_dalam_hal">
                                         <?php
                                            $masalahValue = json_decode($model->bantuan_diperlukan_dalam_hal, true);
                                            $masalah_keperawatan = Yii::$app->params['other']['neonatus']['bantuan_diperlukan_dalam_hal'];


                                            foreach ($masalah_keperawatan as $key => $value) {
                                            ?>
                                             <div class="row pb-2">
                                                 <div class="custom-control custom-checkbox  custom-control-inline">
                                                     <input value="<?= (!empty($masalahValue[$key])) ? $masalahValue[$key] : null ?>" <?= (!empty($masalahValue[$key])) ? 'checked' : null ?> type="checkbox" id="SkriningPemulanganPasienMpp_bantuan_diperlukan_dalam_hal_<?= $key ?>" class="custom-control-input" name="SkriningPemulanganPasienMpp[bantuan_diperlukan_dalam_hal][]">
                                                     <label class="custom-control-label pr-2" for="SkriningPemulanganPasienMpp_bantuan_diperlukan_dalam_hal_<?= $key ?>"><?= $masalah_keperawatan[$key] ?> </label>
                                                     <?php if ($value == null) { ?>
                                                         <input type="text" style='width:15em' placeholder="Isi data bantuan yang diperlukan" id="SkriningPemulanganPasienMpp_bantuan_diperlukan_dalam_hal_<?= $key ?>_t" class="form-control" value="<?= (!empty($masalahValue[$key])) ? $masalahValue[$key] : null ?>">
                                                     <?php } ?>
                                                     <div class="invalid-feedback"></div>
                                                 </div>
                                             </div>
                                         <?php
                                            }
                                            ?>



                                     </div>
                                 </div>
                             </div>








                         </div>
                     </div>

                 </div>
                 <p><b>4. Adakah yang membantu keperluan diatas :</b></p>
                 <div class="row">

                     <div class="col-md-2">
                         <?php
                            $membantu_keperluan_diatas = ['Tidak' => 'Tidak'];
                            echo $form->field($model, 'membantu_keperluan_diatas')->inline(true)->radioList($membantu_keperluan_diatas)->label(false);
                            ?>
                     </div>
                     <div class="col-md-10">
                         <div class="form-group">
                             <div class="input-group">
                                 <div class="input-group-prepend">
                                     <div class="input-group-text">
                                         <input value="<?= (!in_array($model->membantu_keperluan_diatas, $membantu_keperluan_diatas) && !empty($model->membantu_keperluan_diatas)) ? $model->membantu_keperluan_diatas : null ?>" <?= (!in_array($model->membantu_keperluan_diatas, $membantu_keperluan_diatas) && !empty($model->membantu_keperluan_diatas)) ? 'checked' : null ?> type="radio" id="SkriningPemulanganPasienMpp_membantu_keperluan_diatas_2" name="SkriningPemulanganPasienMpp[membantu_keperluan_diatas]">
                                     </div>
                                 </div>
                                 <textarea rows="3" id="SkriningPemulanganPasienMpp_membantu_keperluan_diatas_2_t" class="form-control" placeholder="Sebutkan Jika Ya"><?= (!in_array($model->membantu_keperluan_diatas, $membantu_keperluan_diatas) && !empty($model->membantu_keperluan_diatas)) ? $model->membantu_keperluan_diatas : null ?></textarea>
                             </div>
                         </div>



                     </div>
                 </div>
                 <p><b>5. Apakah pasien tinggal sendiri setelah keluar dari rumah sakit :</b></p>
                 <div class="row">

                     <div class="col-md-2">
                         <?php
                            $pasien_tinggal_sendiri_setelah_keluar_rs = ['Tidak' => 'Tidak'];
                            echo $form->field($model, 'pasien_tinggal_sendiri_setelah_keluar_rs')->inline(true)->radioList($pasien_tinggal_sendiri_setelah_keluar_rs)->label(false);
                            ?>
                     </div>
                     <div class="col-md-10">
                         <div class="form-group">
                             <div class="input-group">
                                 <div class="input-group-prepend">
                                     <div class="input-group-text">
                                         <input value="<?= (!in_array($model->pasien_tinggal_sendiri_setelah_keluar_rs, $pasien_tinggal_sendiri_setelah_keluar_rs) && !empty($model->pasien_tinggal_sendiri_setelah_keluar_rs)) ? $model->pasien_tinggal_sendiri_setelah_keluar_rs : null ?>" <?= (!in_array($model->pasien_tinggal_sendiri_setelah_keluar_rs, $pasien_tinggal_sendiri_setelah_keluar_rs) && !empty($model->pasien_tinggal_sendiri_setelah_keluar_rs)) ? 'checked' : null ?> type="radio" id="SkriningPemulanganPasienMpp_pasien_tinggal_sendiri_setelah_keluar_rs_2" name="SkriningPemulanganPasienMpp[pasien_tinggal_sendiri_setelah_keluar_rs]">
                                     </div>
                                 </div>
                                 <textarea rows="3" id="SkriningPemulanganPasienMpp_pasien_tinggal_sendiri_setelah_keluar_rs_2_t" class="form-control" placeholder="Sebutkan Jika Ya"><?= (!in_array($model->pasien_tinggal_sendiri_setelah_keluar_rs, $pasien_tinggal_sendiri_setelah_keluar_rs) && !empty($model->pasien_tinggal_sendiri_setelah_keluar_rs)) ? $model->pasien_tinggal_sendiri_setelah_keluar_rs : null ?></textarea>
                             </div>
                         </div>



                     </div>
                 </div>
                 <p><b>6. Apakah pasien menggunakan peralatan medis di rumah setelah keluar rumah sakit (Cateter, NGT, Double Lumen, Tracheostomy, Oksigen, Dll) :</b></p>
                 <div class="row">

                     <div class="col-md-2">
                         <?php
                            $pasien_gunakan_peralatan_medis_setelah_keluar_rs = ['Tidak' => 'Tidak'];
                            echo $form->field($model, 'pasien_gunakan_peralatan_medis_setelah_keluar_rs')->inline(true)->radioList($pasien_gunakan_peralatan_medis_setelah_keluar_rs)->label(false);
                            ?>
                     </div>
                     <div class="col-md-10">
                         <div class="form-group">
                             <div class="input-group">
                                 <div class="input-group-prepend">
                                     <div class="input-group-text">
                                         <input value="<?= (!in_array($model->pasien_gunakan_peralatan_medis_setelah_keluar_rs, $pasien_gunakan_peralatan_medis_setelah_keluar_rs) && !empty($model->pasien_gunakan_peralatan_medis_setelah_keluar_rs)) ? $model->pasien_gunakan_peralatan_medis_setelah_keluar_rs : null ?>" <?= (!in_array($model->pasien_gunakan_peralatan_medis_setelah_keluar_rs, $pasien_gunakan_peralatan_medis_setelah_keluar_rs) && !empty($model->pasien_gunakan_peralatan_medis_setelah_keluar_rs)) ? 'checked' : null ?> type="radio" id="SkriningPemulanganPasienMpp_pasien_gunakan_peralatan_medis_setelah_keluar_rs_2" name="SkriningPemulanganPasienMpp[pasien_gunakan_peralatan_medis_setelah_keluar_rs]">
                                     </div>
                                 </div>
                                 <textarea rows="3" id="SkriningPemulanganPasienMpp_pasien_gunakan_peralatan_medis_setelah_keluar_rs_2_t" class="form-control" placeholder="Sebutkan Jika Ya"><?= (!in_array($model->pasien_gunakan_peralatan_medis_setelah_keluar_rs, $pasien_gunakan_peralatan_medis_setelah_keluar_rs) && !empty($model->pasien_gunakan_peralatan_medis_setelah_keluar_rs)) ? $model->pasien_gunakan_peralatan_medis_setelah_keluar_rs : null ?></textarea>
                             </div>
                         </div>



                     </div>
                 </div>
                 <p><b>7. Apakah pasien memerlukan alat bantu setelah keluar rumah sakit (Tongkat, kursi roda, walker Dll) :</b></p>
                 <div class="row">

                     <div class="col-md-2">
                         <?php
                            $perlu_alat_bantu_setelah_keluar_rs = ['Tidak' => 'Tidak'];
                            echo $form->field($model, 'perlu_alat_bantu_setelah_keluar_rs')->inline(true)->radioList($perlu_alat_bantu_setelah_keluar_rs)->label(false);
                            ?>
                     </div>
                     <div class="col-md-10">
                         <div class="form-group">
                             <div class="input-group">
                                 <div class="input-group-prepend">
                                     <div class="input-group-text">
                                         <input value="<?= (!in_array($model->perlu_alat_bantu_setelah_keluar_rs, $perlu_alat_bantu_setelah_keluar_rs) && !empty($model->perlu_alat_bantu_setelah_keluar_rs)) ? $model->perlu_alat_bantu_setelah_keluar_rs : null ?>" <?= (!in_array($model->perlu_alat_bantu_setelah_keluar_rs, $perlu_alat_bantu_setelah_keluar_rs) && !empty($model->perlu_alat_bantu_setelah_keluar_rs)) ? 'checked' : null ?> type="radio" id="SkriningPemulanganPasienMpp_perlu_alat_bantu_setelah_keluar_rs_2" name="SkriningPemulanganPasienMpp[perlu_alat_bantu_setelah_keluar_rs]">
                                     </div>
                                 </div>
                                 <textarea rows="3" id="SkriningPemulanganPasienMpp_perlu_alat_bantu_setelah_keluar_rs_2_t" class="form-control" placeholder="Sebutkan Jika Ya"><?= (!in_array($model->perlu_alat_bantu_setelah_keluar_rs, $perlu_alat_bantu_setelah_keluar_rs) && !empty($model->perlu_alat_bantu_setelah_keluar_rs)) ? $model->perlu_alat_bantu_setelah_keluar_rs : null ?></textarea>
                             </div>
                         </div>



                     </div>
                 </div>
                 <p><b>8. Apakah memerlukan bantuan / perawatan khusus di rumah setelah keluar dari rumah sakit (home care home visit) :</b></p>
                 <div class="row">

                     <div class="col-md-2">
                         <?php
                            $bantuan_khusus_perawatan_setelah_keluar_rs = ['Tidak' => 'Tidak'];
                            echo $form->field($model, 'bantuan_khusus_perawatan_setelah_keluar_rs')->inline(true)->radioList($bantuan_khusus_perawatan_setelah_keluar_rs)->label(false);
                            ?>
                     </div>
                     <div class="col-md-10">
                         <div class="form-group">
                             <div class="input-group">
                                 <div class="input-group-prepend">
                                     <div class="input-group-text">
                                         <input value="<?= (!in_array($model->bantuan_khusus_perawatan_setelah_keluar_rs, $bantuan_khusus_perawatan_setelah_keluar_rs) && !empty($model->bantuan_khusus_perawatan_setelah_keluar_rs)) ? $model->bantuan_khusus_perawatan_setelah_keluar_rs : null ?>" <?= (!in_array($model->bantuan_khusus_perawatan_setelah_keluar_rs, $bantuan_khusus_perawatan_setelah_keluar_rs) && !empty($model->bantuan_khusus_perawatan_setelah_keluar_rs)) ? 'checked' : null ?> type="radio" id="SkriningPemulanganPasienMpp_bantuan_khusus_perawatan_setelah_keluar_rs_2" name="SkriningPemulanganPasienMpp[bantuan_khusus_perawatan_setelah_keluar_rs]">
                                     </div>
                                 </div>
                                 <textarea rows="3" id="SkriningPemulanganPasienMpp_bantuan_khusus_perawatan_setelah_keluar_rs_2_t" class="form-control" placeholder="Sebutkan Jika Ya"><?= (!in_array($model->bantuan_khusus_perawatan_setelah_keluar_rs, $bantuan_khusus_perawatan_setelah_keluar_rs) && !empty($model->bantuan_khusus_perawatan_setelah_keluar_rs)) ? $model->bantuan_khusus_perawatan_setelah_keluar_rs : null ?></textarea>
                             </div>
                         </div>



                     </div>
                 </div>
                 <p><b>9. Apakah pasien bermasalah dalam memenuhi kebutuhan pribadinya setelah keluar dari rumah sakit (makan, minum, BAK/BAB, Dll) :</b></p>
                 <div class="row">

                     <div class="col-md-2">
                         <?php
                            $masalah_memenuhi_kebutuhan_setelah_keluar_rs = ['Tidak' => 'Tidak'];
                            echo $form->field($model, 'masalah_memenuhi_kebutuhan_setelah_keluar_rs')->inline(true)->radioList($masalah_memenuhi_kebutuhan_setelah_keluar_rs)->label(false);
                            ?>
                     </div>
                     <div class="col-md-10">
                         <div class="form-group">
                             <div class="input-group">
                                 <div class="input-group-prepend">
                                     <div class="input-group-text">
                                         <input value="<?= (!in_array($model->masalah_memenuhi_kebutuhan_setelah_keluar_rs, $masalah_memenuhi_kebutuhan_setelah_keluar_rs) && !empty($model->masalah_memenuhi_kebutuhan_setelah_keluar_rs)) ? $model->masalah_memenuhi_kebutuhan_setelah_keluar_rs : null ?>" <?= (!in_array($model->masalah_memenuhi_kebutuhan_setelah_keluar_rs, $masalah_memenuhi_kebutuhan_setelah_keluar_rs) && !empty($model->masalah_memenuhi_kebutuhan_setelah_keluar_rs)) ? 'checked' : null ?> type="radio" id="SkriningPemulanganPasienMpp_masalah_memenuhi_kebutuhan_setelah_keluar_rs_2" name="SkriningPemulanganPasienMpp[masalah_memenuhi_kebutuhan_setelah_keluar_rs]">
                                     </div>
                                 </div>
                                 <textarea rows="3" id="SkriningPemulanganPasienMpp_masalah_memenuhi_kebutuhan_setelah_keluar_rs_2_t" class="form-control" placeholder="Sebutkan Jika Ya"><?= (!in_array($model->masalah_memenuhi_kebutuhan_setelah_keluar_rs, $masalah_memenuhi_kebutuhan_setelah_keluar_rs) && !empty($model->masalah_memenuhi_kebutuhan_setelah_keluar_rs)) ? $model->masalah_memenuhi_kebutuhan_setelah_keluar_rs : null ?></textarea>
                             </div>
                         </div>



                     </div>
                 </div>
                 <p><b>10. Apakah pasien memiliki nyeri kronis dan kelelahan setelah keluar rumah sakit :</b></p>
                 <div class="row">

                     <div class="col-md-2">
                         <?php
                            $nyeri_kronis_kelelahan_setelah_keluar_rs = ['Tidak' => 'Tidak'];
                            echo $form->field($model, 'nyeri_kronis_kelelahan_setelah_keluar_rs')->inline(true)->radioList($nyeri_kronis_kelelahan_setelah_keluar_rs)->label(false);
                            ?>
                     </div>
                     <div class="col-md-10">
                         <div class="form-group">
                             <div class="input-group">
                                 <div class="input-group-prepend">
                                     <div class="input-group-text">
                                         <input value="<?= (!in_array($model->nyeri_kronis_kelelahan_setelah_keluar_rs, $nyeri_kronis_kelelahan_setelah_keluar_rs) && !empty($model->nyeri_kronis_kelelahan_setelah_keluar_rs)) ? $model->nyeri_kronis_kelelahan_setelah_keluar_rs : null ?>" <?= (!in_array($model->nyeri_kronis_kelelahan_setelah_keluar_rs, $nyeri_kronis_kelelahan_setelah_keluar_rs) && !empty($model->nyeri_kronis_kelelahan_setelah_keluar_rs)) ? 'checked' : null ?> type="radio" id="SkriningPemulanganPasienMpp_nyeri_kronis_kelelahan_setelah_keluar_rs_2" name="SkriningPemulanganPasienMpp[nyeri_kronis_kelelahan_setelah_keluar_rs]">
                                     </div>
                                 </div>
                                 <textarea rows="3" id="SkriningPemulanganPasienMpp_nyeri_kronis_kelelahan_setelah_keluar_rs_2_t" class="form-control" placeholder="Sebutkan Jika Ya"><?= (!in_array($model->nyeri_kronis_kelelahan_setelah_keluar_rs, $nyeri_kronis_kelelahan_setelah_keluar_rs) && !empty($model->nyeri_kronis_kelelahan_setelah_keluar_rs)) ? $model->nyeri_kronis_kelelahan_setelah_keluar_rs : null ?></textarea>
                             </div>
                         </div>



                     </div>
                 </div>
                 <p><b>11. Apakah pasien dan keluarga memerlukan edukasi kesehatan setelah keluar dari rumah sakit (obat-obatan, efek samping obat, nyeri, diit, mencari pertolongan, follow up, dll) :</b></p>
                 <div class="row">

                     <div class="col-md-2">
                         <?php
                            $perlu_edukasi_kesehatan_setelah_keluar_rs = ['Tidak' => 'Tidak'];
                            echo $form->field($model, 'perlu_edukasi_kesehatan_setelah_keluar_rs')->inline(true)->radioList($perlu_edukasi_kesehatan_setelah_keluar_rs)->label(false);
                            ?>
                     </div>
                     <div class="col-md-10">
                         <div class="form-group">
                             <div class="input-group">
                                 <div class="input-group-prepend">
                                     <div class="input-group-text">
                                         <input value="<?= (!in_array($model->perlu_edukasi_kesehatan_setelah_keluar_rs, $perlu_edukasi_kesehatan_setelah_keluar_rs) && !empty($model->perlu_edukasi_kesehatan_setelah_keluar_rs)) ? $model->perlu_edukasi_kesehatan_setelah_keluar_rs : null ?>" <?= (!in_array($model->perlu_edukasi_kesehatan_setelah_keluar_rs, $perlu_edukasi_kesehatan_setelah_keluar_rs) && !empty($model->perlu_edukasi_kesehatan_setelah_keluar_rs)) ? 'checked' : null ?> type="radio" id="SkriningPemulanganPasienMpp_perlu_edukasi_kesehatan_setelah_keluar_rs_2" name="SkriningPemulanganPasienMpp[perlu_edukasi_kesehatan_setelah_keluar_rs]">
                                     </div>
                                 </div>
                                 <textarea rows="3" id="SkriningPemulanganPasienMpp_perlu_edukasi_kesehatan_setelah_keluar_rs_2_t" class="form-control" placeholder="Sebutkan Jika Ya"><?= (!in_array($model->perlu_edukasi_kesehatan_setelah_keluar_rs, $perlu_edukasi_kesehatan_setelah_keluar_rs) && !empty($model->perlu_edukasi_kesehatan_setelah_keluar_rs)) ? $model->perlu_edukasi_kesehatan_setelah_keluar_rs : null ?></textarea>
                             </div>
                         </div>



                     </div>
                 </div>
                 <p><b>12. Apakah pasien dan kelurga memerlukan keterampilan khusus setelah keluar dari rumah sakit (perawatan luka, injeksi, perawatan bayi, dll) :</b></p>
                 <div class="row">

                     <div class="col-md-2">
                         <?php
                            $perlu_keterampilan_khusus_setelah_keluar_rs = ['Tidak' => 'Tidak'];
                            echo $form->field($model, 'perlu_keterampilan_khusus_setelah_keluar_rs')->inline(true)->radioList($perlu_keterampilan_khusus_setelah_keluar_rs)->label(false);
                            ?>
                     </div>
                     <div class="col-md-10">
                         <div class="form-group">
                             <div class="input-group">
                                 <div class="input-group-prepend">
                                     <div class="input-group-text">
                                         <input value="<?= (!in_array($model->perlu_keterampilan_khusus_setelah_keluar_rs, $perlu_keterampilan_khusus_setelah_keluar_rs) && !empty($model->perlu_keterampilan_khusus_setelah_keluar_rs)) ? $model->perlu_keterampilan_khusus_setelah_keluar_rs : null ?>" <?= (!in_array($model->perlu_keterampilan_khusus_setelah_keluar_rs, $perlu_keterampilan_khusus_setelah_keluar_rs) && !empty($model->perlu_keterampilan_khusus_setelah_keluar_rs)) ? 'checked' : null ?> type="radio" id="SkriningPemulanganPasienMpp_perlu_keterampilan_khusus_setelah_keluar_rs_2" name="SkriningPemulanganPasienMpp[perlu_keterampilan_khusus_setelah_keluar_rs]">
                                     </div>
                                 </div>
                                 <textarea rows="3" id="SkriningPemulanganPasienMpp_perlu_keterampilan_khusus_setelah_keluar_rs_2_t" class="form-control" placeholder="Sebutkan Jika Ya"><?= (!in_array($model->perlu_keterampilan_khusus_setelah_keluar_rs, $perlu_keterampilan_khusus_setelah_keluar_rs) && !empty($model->perlu_keterampilan_khusus_setelah_keluar_rs)) ? $model->perlu_keterampilan_khusus_setelah_keluar_rs : null ?></textarea>
                             </div>
                         </div>



                     </div>
                 </div>

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
                         <div class="border border-top-0 border-info bg-white text-right" style="padding: 4px;color:white">
                             <a class="btn btn-success btn-sm btn-preview-skrining-pemulangan-pasien-mpp" href="<?= Url::to(['/mpp/preview-skrining-pemulangan-pasien-mpp', 'id' => $item['id']]) ?>" data-id="<?= $item['id'] ?>" data-nama="<?= $item['id'] ?>"> <i style="color:white" class="fa fa-eye"></i></i></a>

                             <a class="btn btn-danger btn-sm btn-batalkan-skrining-pemulangan-pasien-mpp" data-url="<?= Url::to(['mpp/batalkan-skrining-pemulangan-pasien-mpp', 'id' => $item['id']]) ?>" data-id="<?= $item['id'] ?>" data-nama="<?= $item['id'] ?>"> <i style="color:white" class="fa fa-trash"></i></i></a>

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