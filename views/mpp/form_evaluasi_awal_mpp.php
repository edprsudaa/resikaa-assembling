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
      $('#evaluasi_awal_form').on('beforeSubmit',function(e){
        e.preventDefault();
        var btn=$('.btn-submit');
        var htm=btn.html();
        $('body').addClass('loading');
        $('#btn-loading-analisa').attr('style', 'display: block')
        $.ajax({
            url:'" . Url::to(['save-evaluasi-awal-pasien-mpp']) . "',
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

    $('#SkriningPemulanganPasienMpp_bantuan_diperlukan_dalam_hal_4_t').on('input change focus paste', function (e) {
        let teks = $('#SkriningPemulanganPasienMpp_bantuan_diperlukan_dalam_hal_4_t').val()
        $('#SkriningPemulanganPasienMpp_bantuan_diperlukan_dalam_hal_4').val(teks)
        $('#SkriningPemulanganPasienMpp_bantuan_diperlukan_dalam_hal_4').prop('checked', true)
    });

    $(document).on('click','.btn-batalkan-evaluasi-awal',function(e){
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
    $('.btn-preview-evaluasi-awal-pasien-mpp').on('click', function (){
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
                 <?php $form = ActiveForm::begin(['id' => 'evaluasi_awal_form',  'options' => ['class' => 'form form-catatan', 'role' => 'form']]); ?>
                 <?= $form->field($model, 'mpp_id')->hiddenInput(['value' => HelperSpesialClass::getUserLogin()['pegawai_id']])->label(false); ?>
                 <?= $form->field($model, 'layanan_id')->hiddenInput(['value' => $_GET['layanan_id']])->label(false); ?>

                 <?= $form->field($model, 'registrasi_kode')->hiddenInput(['value' => $registrasi['kode']])->label(false); ?>
                 <div class="row">
                     <div class="col-md-12">
                         <p class="mb-3 text-uppercase bg-info p-2"><i class="fa fa-bookmark"></i> ASESMEN </p>
                     </div>
                 </div>
                 <div class="row">
                     <div class="col-sm-4">
                         <label>Fisik, Fungsional, Kognitif, Kekuatan, Kemandirian :</label>

                     </div>
                     <div class="col-sm-8">

                         <?= $form->field($model, 'fisik_fungsional_kognitif_kekuatan_mandiri')->textarea(['rows' => 2])->label(false); ?>

                     </div>
                 </div>
                 <div class="row">
                     <div class="col-sm-4">
                         <label>Riwayat Kesehatan :</label>

                     </div>
                     <div class="col-sm-8">

                         <?= $form->field($model, 'riwayat_kesehatan')->textarea(['rows' => 2])->label(false); ?>

                     </div>
                 </div>
                 <div class="row">
                     <div class="col-sm-4">
                         <label>Perilaku Psikososio Kultural :</label>

                     </div>
                     <div class="col-sm-8">

                         <?= $form->field($model, 'perilaku_psikososio_kultural')->textarea(['rows' => 2])->label(false); ?>

                     </div>
                 </div>
                 <div class="row">
                     <div class="col-sm-4">
                         <label>Kesehatan Mental :</label>

                     </div>
                     <div class="col-sm-8">

                         <?= $form->field($model, 'kesehatan_mental')->textarea(['rows' => 2])->label(false); ?>

                     </div>
                 </div>
                 <div class="row">
                     <div class="col-sm-4">
                         <label>Dukungan Keluarga dan Kemampuan Merawat :</label>

                     </div>
                     <div class="col-sm-8">

                         <?= $form->field($model, 'dukungan_keluarga_kemampuan_merawat')->textarea(['rows' => 2])->label(false); ?>

                     </div>
                 </div>
                 <div class="row">
                     <div class="col-sm-4">
                         <label>Finansial / Status Asuransi :</label>

                     </div>
                     <div class="col-sm-8">

                         <?= $form->field($model, 'finansial_status_asuransi')->textarea(['rows' => 2])->label(false); ?>

                     </div>
                 </div>
                 <div class="row">
                     <div class="col-sm-4">
                         <label>Riwayat Penggunaan Obat, Alternatif Pengobatan :</label>

                     </div>
                     <div class="col-sm-8">

                         <?= $form->field($model, 'riwayat_penggunaan_obat_alternatif_pengobatan')->textarea(['rows' => 2])->label(false); ?>

                     </div>
                 </div>
                 <div class="row">
                     <div class="col-sm-4">
                         <label>Riwayat trauma atau kekerasan :</label>

                     </div>
                     <div class="col-sm-8">

                         <?= $form->field($model, 'riwayat_trauma_kekerasan')->textarea(['rows' => 2])->label(false); ?>

                     </div>
                 </div>
                 <div class="row">
                     <div class="col-sm-4">
                         <label>Pemahaman Tentang Kesehatan :</label>

                     </div>
                     <div class="col-sm-8">

                         <?= $form->field($model, 'pemahaman_tentang_kesehatan')->textarea(['rows' => 2])->label(false); ?>

                     </div>
                 </div>
                 <div class="row">
                     <div class="col-sm-4">
                         <label>Harapan terhadap hasil asuhan atau kemampuan untuk menerima perubahan :</label>

                     </div>
                     <div class="col-sm-8">

                         <?= $form->field($model, 'harapan_hasil_asuhan_kemampuan_menerima_perubahan')->textarea(['rows' => 2])->label(false); ?>

                     </div>
                 </div>
                 <div class="row">
                     <div class="col-sm-4">
                         <label>Aspek Legalitas :</label>

                     </div>
                     <div class="col-sm-8">

                         <?= $form->field($model, 'aspek_legalitas')->textarea(['rows' => 2])->label(false); ?>

                     </div>
                 </div>
                 <div class="row">
                     <div class="col-sm-4">
                         <label>Lainnya :</label>

                     </div>
                     <div class="col-sm-8">

                         <?= $form->field($model, 'asesmen_lainnya')->textarea(['rows' => 2])->label(false); ?>

                     </div>
                 </div>
                 <div class="row">
                     <div class="col-md-12">
                         <p class="mb-3 text-uppercase bg-info p-2"><i class="fa fa-bookmark"></i> IDENTIFIKASI MASALAH </p>
                     </div>
                 </div>
                 <div class="row">
                     <div class="col-sm-4">
                         <label>Asuhan yang tidak sesuai panduan:</label>

                     </div>
                     <div class="col-sm-8">

                         <?= $form->field($model, 'asuhan_tidak_sesuai_panduan')->textarea(['rows' => 2])->label(false); ?>

                     </div>
                 </div>
                 <div class="row">
                     <div class="col-sm-4">
                         <label>Over/under Utilization pelayanan dengan dasar panduan:</label>

                     </div>
                     <div class="col-sm-8">

                         <?= $form->field($model, 'over_under_utilization_pelayanan_dasar_panduan')->textarea(['rows' => 2])->label(false); ?>

                     </div>
                 </div>
                 <div class="row">
                     <div class="col-sm-4">
                         <label>Ketidakpatuhan Pasien:</label>

                     </div>
                     <div class="col-sm-8">

                         <?= $form->field($model, 'ketidakpatuhan_pasien')->textarea(['rows' => 2])->label(false); ?>

                     </div>
                 </div>
                 <div class="row">
                     <div class="col-sm-4">
                         <label>Edukasi kurang memadai tentang penyakit, kondisi kini, obat, nutrisi :</label>

                     </div>
                     <div class="col-sm-8">

                         <?= $form->field($model, 'edukasi_kurang_memadai_tentang_penyakit_kondisi_kini_obat_nutri')->textarea(['rows' => 2])->label(false); ?>

                     </div>
                 </div>
                 <div class="row">
                     <div class="col-sm-4">
                         <label>Kurang dukungan keluarga :</label>

                     </div>
                     <div class="col-sm-8">

                         <?= $form->field($model, 'kurang_dukungan_keluarga')->textarea(['rows' => 2])->label(false); ?>

                     </div>
                 </div>
                 <div class="row">
                     <div class="col-sm-4">
                         <label>Penurunan Determinasi Pasien (ketika tingkat keparahan / komplikasi meningkat):</label>

                     </div>
                     <div class="col-sm-8">

                         <?= $form->field($model, 'penurunan_determinasi_pasien')->textarea(['rows' => 2])->label(false); ?>

                     </div>
                 </div>
                 <div class="row">
                     <div class="col-sm-4">
                         <label>Kendala Keuangan:</label>

                     </div>
                     <div class="col-sm-8">

                         <?= $form->field($model, 'kendala_keuangan')->textarea(['rows' => 2])->label(false); ?>

                     </div>
                 </div>
                 <div class="row">
                     <div class="col-sm-4">
                         <label>Pemulangan / Rujukan bermasalah:</label>

                     </div>
                     <div class="col-sm-8">

                         <?= $form->field($model, 'pemulangan_rujukan_bermasalah')->textarea(['rows' => 2])->label(false); ?>

                     </div>
                 </div>
                 <div class="row">
                     <div class="col-sm-4">
                         <label>Lainnya:</label>

                     </div>
                     <div class="col-sm-8">

                         <?= $form->field($model, 'identifikasi_masalah_lainnya')->textarea(['rows' => 2])->label(false); ?>

                     </div>
                 </div>
                 <div class="row">
                     <div class="col-md-12">
                         <p class="mb-3 text-uppercase bg-info p-2"><i class="fa fa-bookmark"></i> PERENCANAAN </p>
                     </div>
                 </div>
                 <div class="row">
                     <div class="col-md-6">
                         <p class="mb-3 text-uppercase bg-warning p-2"><i class="fa fa-bookmark"></i> Koordinasi dengan DPJP </p>
                     </div>
                 </div>
                 <div class="row">
                     <div class="col-sm-4">
                         <label>Penggunaan alat medis:</label>

                     </div>
                     <div class="col-sm-8">

                         <?= $form->field($model, 'penggunaan_alat_medis')->textarea(['rows' => 2])->label(false); ?>

                     </div>
                 </div>
                 <div class="row">
                     <div class="col-sm-4">
                         <label>Tatalaksana Medis:</label>

                     </div>
                     <div class="col-sm-8">

                         <?= $form->field($model, 'tatalaksana_medis')->textarea(['rows' => 2])->label(false); ?>

                     </div>
                 </div>

                 <div class="row">
                     <div class="col-sm-4">
                         <label>Komplikasi:</label>

                     </div>
                     <div class="col-sm-8">

                         <?= $form->field($model, 'komplikasi')->textarea(['rows' => 2])->label(false); ?>

                     </div>
                 </div>
                 <div class="row">
                     <div class="col-sm-4">
                         <label>Gejala Perburukan:</label>

                     </div>
                     <div class="col-sm-8">

                         <?= $form->field($model, 'gejalan_perburukan')->textarea(['rows' => 2])->label(false); ?>

                     </div>
                 </div>
                 <div class="row">
                     <div class="col-sm-4">
                         <label>Pemeriksaan Diagnostik:</label>

                     </div>
                     <div class="col-sm-8">

                         <?= $form->field($model, 'pemeriksaan_diagnostik')->textarea(['rows' => 2])->label(false); ?>

                     </div>
                 </div>
                 <div class="row">
                     <div class="col-sm-4">
                         <label>Perkembangan Penyakit:</label>

                     </div>
                     <div class="col-sm-8">

                         <?= $form->field($model, 'perkembangan_penyakit')->textarea(['rows' => 2])->label(false); ?>

                     </div>
                 </div>
                 <div class="row">
                     <div class="col-sm-4">
                         <label>Rencana Pengobatan Dirumah:</label>

                     </div>
                     <div class="col-sm-8">

                         <?= $form->field($model, 'rencana_pengobatan_dirumah')->textarea(['rows' => 2])->label(false); ?>

                     </div>
                 </div>
                 <div class="row">
                     <div class="col-md-6">
                         <p class="mb-3 text-uppercase bg-warning p-2"><i class="fa fa-bookmark"></i> Koordinasi dengan PPA </p>
                     </div>
                 </div>
                 <div class="row">
                     <div class="col-sm-4">
                         <label>Management Nyeri:</label>

                     </div>
                     <div class="col-sm-8">

                         <?= $form->field($model, 'management_nyeri')->textarea(['rows' => 2])->label(false); ?>

                     </div>
                 </div>
                 <div class="row">
                     <div class="col-sm-4">
                         <label>Aktivitas dan Istirahat:</label>

                     </div>
                     <div class="col-sm-8">

                         <?= $form->field($model, 'aktivitas_istirahat')->textarea(['rows' => 2])->label(false); ?>

                     </div>
                 </div>
                 <div class="row">
                     <div class="col-sm-4">
                         <label>Modifikasi Perilaku / Lingkungan:</label>

                     </div>
                     <div class="col-sm-8">

                         <?= $form->field($model, 'modifikasi_perilaku_lingkungan')->textarea(['rows' => 2])->label(false); ?>

                     </div>
                 </div>
                 <div class="row">
                     <div class="col-sm-4">
                         <label>Personal Hygiene:</label>

                     </div>
                     <div class="col-sm-8">

                         <?= $form->field($model, 'personal_hygiene')->textarea(['rows' => 2])->label(false); ?>

                     </div>
                 </div>
                 <div class="row">
                     <div class="col-sm-4">
                         <label>Management Resiko Jatuh:</label>

                     </div>
                     <div class="col-sm-8">

                         <?= $form->field($model, 'management_resiko_jatuh')->textarea(['rows' => 2])->label(false); ?>

                     </div>
                 </div>
                 <div class="row">
                     <div class="col-sm-4">
                         <label>Perawatan luka:</label>

                     </div>
                     <div class="col-sm-8">

                         <?= $form->field($model, 'perawatan_luka')->textarea(['rows' => 2])->label(false); ?>

                     </div>
                 </div>
                 <div class="row">
                     <div class="col-sm-4">
                         <label>Management Cemas / Stress:</label>

                     </div>
                     <div class="col-sm-8">

                         <?= $form->field($model, 'management_cemas_stress')->textarea(['rows' => 2])->label(false); ?>

                     </div>
                 </div>
                 <div class="row">
                     <div class="col-sm-4">
                         <label>Pemberian Nutrisi dengan NGT:</label>

                     </div>
                     <div class="col-sm-8">

                         <?= $form->field($model, 'pembrrian_nutrisi_ngt')->textarea(['rows' => 2])->label(false); ?>

                     </div>
                 </div>
                 <div class="row">
                     <div class="col-sm-4">
                         <label>Pemeriksaan Rutin dilakukan:</label>

                     </div>
                     <div class="col-sm-8">

                         <?= $form->field($model, 'pemeriksaan_rutin_dilakukan')->textarea(['rows' => 2])->label(false); ?>

                     </div>
                 </div>
                 <div class="row">
                     <div class="col-md-6">
                         <p class="mb-3 text-uppercase bg-warning p-2"><i class="fa fa-bookmark"></i> Koordinasi dengan Farmasi </p>
                     </div>
                 </div>
                 <div class="row">
                     <div class="col-sm-4">
                         <label>Obat-obat yang digunakan:</label>

                     </div>
                     <div class="col-sm-8">

                         <?= $form->field($model, 'obat_obatan_yang_digunakan')->textarea(['rows' => 2])->label(false); ?>

                     </div>
                 </div>
                 <div class="row">
                     <div class="col-sm-4">
                         <label>Indikasi Obat:</label>

                     </div>
                     <div class="col-sm-8">

                         <?= $form->field($model, 'indikasi_obat')->textarea(['rows' => 2])->label(false); ?>

                     </div>
                 </div>
                 <div class="row">
                     <div class="col-sm-4">
                         <label>Efek samping Obat:</label>

                     </div>
                     <div class="col-sm-8">

                         <?= $form->field($model, 'efek_samping_obat')->textarea(['rows' => 2])->label(false); ?>

                     </div>
                 </div>
                 <div class="row">
                     <div class="col-sm-4">
                         <label>Cara / Waktu / Lama makan obat:</label>

                     </div>
                     <div class="col-sm-8">

                         <?= $form->field($model, 'cara_waktu_lama_makan_obat')->textarea(['rows' => 2])->label(false); ?>

                     </div>
                 </div>
                 <div class="row">
                     <div class="col-sm-4">
                         <label>Cara mengkonsumsi obat:</label>

                     </div>
                     <div class="col-sm-8">

                         <?= $form->field($model, 'cara_konsumsi_obat')->textarea(['rows' => 2])->label(false); ?>

                     </div>
                 </div>
                 <div class="row">
                     <div class="col-md-6">
                         <p class="mb-3 text-uppercase bg-warning p-2"><i class="fa fa-bookmark"></i> Koordinasi dengan PPA lain </p>
                     </div>
                 </div>
                 <div class="row">
                     <div class="col-sm-4">
                         <label>Modifikasi Diet:</label>

                     </div>
                     <div class="col-sm-8">

                         <?= $form->field($model, 'modifikasi_diet')->textarea(['rows' => 2])->label(false); ?>

                     </div>
                 </div>
                 <div class="row">
                     <div class="col-sm-4">
                         <label>Rehabilitation Medis:</label>

                     </div>
                     <div class="col-sm-8">

                         <?= $form->field($model, 'rehabilitation_medis')->textarea(['rows' => 2])->label(false); ?>

                     </div>
                 </div>
                 <div class="row">
                     <div class="col-sm-4">
                         <label>Home Traing:</label>

                     </div>
                     <div class="col-sm-8">

                         <?= $form->field($model, 'home_training')->textarea(['rows' => 2])->label(false); ?>

                     </div>
                 </div>
                 <div class="row">
                     <div class="col-md-6">
                         <p class="mb-3 text-uppercase bg-warning p-2"><i class="fa fa-bookmark"></i> Koordinasi dengan Petugas Eksternal </p>
                     </div>
                 </div>
                 <div class="row">
                     <div class="col-sm-4">
                         <label>Laboratorium:</label>

                     </div>
                     <div class="col-sm-8">

                         <?= $form->field($model, 'laboratorium')->textarea(['rows' => 2])->label(false); ?>

                     </div>
                 </div>
                 <div class="row">
                     <div class="col-sm-4">
                         <label>Radiologi:</label>

                     </div>
                     <div class="col-sm-8">

                         <?= $form->field($model, 'radiologi')->textarea(['rows' => 2])->label(false); ?>

                     </div>
                 </div>
                 <div class="row">
                     <div class="col-sm-4">
                         <label>Petugas Asuransi Kesehatan:</label>

                     </div>
                     <div class="col-sm-8">

                         <?= $form->field($model, 'petugas_asuransi_kesehatan')->textarea(['rows' => 2])->label(false); ?>

                     </div>
                 </div>
                 <div class="row">
                     <div class="col-sm-4">
                         <label>Rohaniawan:</label>

                     </div>
                     <div class="col-sm-8">

                         <?= $form->field($model, 'rohaniawan')->textarea(['rows' => 2])->label(false); ?>

                     </div>
                 </div>
                 <div class="row">
                     <div class="col-sm-4">
                         <label>Fasilitas Kesehatan :</label>

                     </div>
                     <div class="col-sm-8">

                         <?= $form->field($model, 'fasilitas_kesehatan')->textarea(['rows' => 2])->label(false); ?>

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
                 <h5 style="margin-bottom:6px;">Daftar Evaluasi Awal Pasien MPP</h5>
             </div>
             <div class="card-body">
                 <?php
                    if (!empty($listEvaluasiAwalMpp)) {
                        foreach ($listEvaluasiAwalMpp as $item) { ?>
                         <div class="border border-info <?= $item['batal'] ? 'bg-danger' : 'bg-info' ?>" style="border: 1px solid #e1e1e1fa;padding-left: 4px;">Nama MPP : <?= HelperSpesialClass::getNamaPegawaiArray($item['mpp']) ?? '' ?><br>Unit: <?= $item['layanan']['unit']['nama'] ?? '' ?><br>Waktu : <?= $item['created_at'] ?? '' ?></div>
                         <div class="border border-top-0 border-info bg-white text-right" style="padding: 4px;color:white">
                             <a class="btn btn-success btn-sm btn-preview-evaluasi-awal-pasien-mpp" href="<?= Url::to(['/mpp/preview-evaluasi-awal-pasien-mpp', 'id' => $item['id']]) ?>" data-id="<?= $item['id'] ?>" data-nama="<?= $item['id'] ?>"> <i class="fa fa-eye"></i></i></a>

                             <a class="btn btn-danger btn-sm btn-batalkan-evaluasi-awal" data-url="<?= Url::to(['mpp/batalkan-evaluasi-awal-pasien-mpp', 'id' => $item['id']]) ?>" data-id="<?= $item['id'] ?>" data-nama="<?= $item['id'] ?>"> <i style="color:white" class="fa fa-trash"></i></i></a>

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