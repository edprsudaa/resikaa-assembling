 <?php

    use app\components\HelperGeneralClass;
    use app\components\HelperSpesialClass;
    use app\models\pendaftaran\KelompokUnitLayanan;
    use app\components\DynamicFormWidget;
    use kartik\date\DatePicker;
    use kartik\select2\Select2;
    use yii\bootstrap4\ActiveForm;
    use yii\helpers\Html;
    use yii\helpers\Url;
    use yii\web\JsExpression;

    $this->registerJs("
    $('#codingclaim-CodingClaim').on('beforeSubmit',function(e){
        e.preventDefault();
        
        // Get the value of the estimasi input
        var estimasiValue = $('#estimasi').val();
        
        // Serialize form data
        var formData = $(this).serializeArray();
        
        // Add the estimasi value to the serialized form data
        formData.push({name: 'CodingClaim[estimasi]', value: estimasiValue});
        
        // Convert serialized array to query string format
        var formDataString = $.param(formData);
    
        var btn=$('.btn-submit');
        var htm=btn.html();
        $('body').addClass('loading');
        $('#btn-loading-analisa').attr('style', 'display: block')
       
        $.ajax({
            url:'" . Url::to(['claim-diagnosa-save']) . "',
            type:'post',
            dataType:'json',
            data:formDataString,
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
                            $('body').removeClass('loading');
        $('#btn-loading-analisa').attr('style', 'display: none');
        return false;
                        });
                    }else{
                        toastr.error(result.msg);
                        $('body').removeClass('loading');
        $('#btn-loading-analisa').attr('style', 'display: none');
        return false;
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

    $('#codingclaimic9-CodingClaim').on('beforeSubmit',function(e){
    
        e.preventDefault();
        
        // Get the value of the estimasi input
        var estimasiValue = $('#estimasi').val();
        
        // Serialize form data
        var formData = $(this).serializeArray();
        
        // Add the estimasi value to the serialized form data
        formData.push({name: 'CodingClaim[estimasi]', value: estimasiValue});
        
        // Convert serialized array to query string format
        var formDataString = $.param(formData);
        var btn=$('.btn-submit');
        var htm=btn.html();
        $('body').addClass('loading');
        $('#btn-loading-analisa').attr('style', 'display: block')
        
        $.ajax({
            url:'" . Url::to(['claim-tindakan-save']) . "',
            type:'post',
            dataType:'json',
            data:formDataString,
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
                            $('body').removeClass('loading');
        $('#btn-loading-analisa').attr('style', 'display: none');
        return false;
                        });
                    }else{
                        toastr.error(result.msg);
                        $('body').removeClass('loading');
        $('#btn-loading-analisa').attr('style', 'display: none');
        return false;
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
    $('.btn-lihat-resume-medis').on('click', function (){
        $.get($(this).attr('href'), function(data) {
            $('.mymodal_card_xl_body').html(data);
            $('.mymodal_card_xl').modal('show');
       });
       return false;
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
             <div class="col-lg-4">

                 <div class="card card-danger card-outline">
                     <div class="card-header">
                         <h5 style="margin-bottom:6px;"><b>Silahkan Pilih Salah Satu Resume Medis</b></h5>
                     </div>
                     <div class="card-body">

                         <table style="width: 100%;">
                             <?php
                                if (!empty($listResumeMedisDokter)) {
                                    foreach ($listResumeMedisDokter as $item) {
                                ?>
                                     <tr>
                                         <td>
                                             <div class="border border-info bg-info" style="border: 1px solid #e1e1e1fa;padding-left: 4px;">Nama Dokter : <?= HelperSpesialClass::getNamaPegawaiArray($item->dokter) ?? '' ?> <br>(Resume id: <?= $item->id ?? '' ?>)</div>

                                             <div colspan="3" class="border border-top-0 border-info" style="padding-left: 4px;"><b>Ringkasan Riwayat Penyakit : </b><?= $item->ringkasan_riwayat_penyakit ?? '' ?></div>
                                             <div colspan="3" class="border border-top-0 border-info" style="padding-left: 4px;"><b>Hasil Pemeriksaan Fisik : </b><?= $item->hasil_pemeriksaan_fisik ?? '' ?></div>
                                             <div colspan="3" class="border border-top-0 border-info" style="padding-left: 4px;"><b>Indikasi Rawat Inap : </b><?= $item->indikasi_rawat_inap ?? '' ?></div>

                                             <div colspan="3" class="border border-top-0 border-info" style="padding-left: 4px;"><b>Diagnosa Masuk : </b><?= $item->diagnosa_masuk_deskripsi ?? '' ?></div>
                                             <div class="border border-warning bg-warning font-weight-bold" style="border: 1px solid #e1e1e1fa;padding-left: 4px;">Diagnosa Dokter : </div>
                                             <div colspan="3" class="border border-top-0 border-info" style="padding-left: 4px;"><b>Dx Utama : </b> <?= $item->diagnosa_utama_deskripsi ?? '' ?></div>
                                             <div colspan="3" class="border border-top-0 border-info" style="padding-left: 4px;"><b>Dx Sekunder 1 :</b> <?= $item->diagnosa_tambahan1_deskripsi ?? '' ?></div>
                                             <div colspan="3" class="border border-top-0 border-info" style="padding-left: 4px;"><b>Dx Sekunder 2 :</b> <?= $item->diagnosa_tambahan2_deskripsi ?? '' ?></div>
                                             <div colspan="3" class="border border-top-0 border-info" style="padding-left: 4px;"><b>Dx Sekunder 3 :</b> <?= $item->diagnosa_tambahan3_deskripsi ?? '' ?></div>
                                             <div colspan="3" class="border border-top-0 border-info" style="padding-left: 4px;"><b>Dx Sekunder 4 :</b> <?= $item->diagnosa_tambahan4_deskripsi ?? '' ?></div>
                                             <div colspan="3" class="border border-top-0 border-info" style="padding-left: 4px;"><b>Dx Sekunder 5 :</b> <?= $item->diagnosa_tambahan5_deskripsi ?? '' ?></div>

                                             <div class="border border-warning bg-warning font-weight-bold" style="border: 1px solid #e1e1e1fa;padding-left: 4px;">Diagnosa ICD10:</div>
                                             <?php if ($item->diagutama) { ?>
                                                 <div class="border border-info bg-info" style="border: 1px solid #e1e1e1fa;padding-left: 4px;">Utama : </div>
                                                 <div colspan="3" class="border border-top-0 border-info" style="padding-left: 4px;"><b>ICD10 : </b><?= $item->diagutama->kode ?? '' ?><br><b>ICD10 Deskripsi :</b><?= $item->diagutama->deskripsi ?? '-' ?></div>
                                             <?php } ?>

                                             <?php if ($item->diagsatu) { ?>
                                                 <div class="border border-info bg-info" style="border: 1px solid #e1e1e1fa;padding-left: 4px;">Tambahan I :</div>
                                                 <div colspan="3" class="border border-top-0 border-info" style="padding-left: 4px;"><b>ICD10 : </b><?= $item->diagsatu->kode ?? '' ?><br><b>ICD10 Deskripsi :</b><?= $item->diagsatu->deskripsi ?? '-' ?></div>
                                             <?php } ?>
                                             <?php if ($item->diagdua) { ?>

                                                 <div class="border border-info bg-info" style="border: 1px solid #e1e1e1fa;padding-left: 4px;">Tambahan II : </div>

                                                 <div colspan="3" class="border border-top-0 border-info" style="padding-left: 4px;"><b>ICD10 : </b><?= $item->diagdua->kode ?? '' ?><br><b>ICD10 Deskripsi :</b><?= $item->diagdua->deskripsi ?? '-' ?></div>
                                             <?php } ?>
                                             <?php if ($item->diagtiga) { ?>

                                                 <div class="border border-info bg-info" style="border: 1px solid #e1e1e1fa;padding-left: 4px;">Tambahan III : </div>

                                                 <div colspan="3" class="border border-top-0 border-info" style="padding-left: 4px;"><b>ICD10 : </b><?= $item->diagtiga->kode ?? '' ?><br><b>ICD10 Deskripsi :</b><?= $item->diagtiga->deskripsi ?? '-' ?></div>
                                             <?php } ?>
                                             <?php if ($item->diagempat) { ?>

                                                 <div class="border border-info bg-info" style="border: 1px solid #e1e1e1fa;padding-left: 4px;">Tambahan IV : </div>
                                                 <div colspan="3" class="border border-top-0 border-info" style="padding-left: 4px;"><b>ICD10 : </b><?= $item->diagempat->kode ?? '' ?><br><b>ICD10 Deskripsi :</b><?= $item->diagempat->deskripsi ?? '-' ?></div>
                                             <?php } ?>
                                             <?php if ($item->diaglima) { ?>


                                                 <div class="border border-info bg-info" style="border: 1px solid #e1e1e1fa;padding-left: 4px;">Tambahan V : <?= $item->diaglima->kode ?? '' ?></div>

                                                 <div colspan="3" class="border border-top-0 border-info" style="padding-left: 4px;"><b>ICD10 : </b><?= $item->diaglima->kode ?? '' ?><br><b>ICD10 Deskripsi :</b><?= $item->diaglima->deskripsi ?? '-' ?></div>

                                             <?php } ?>
                                             <div class="border border-warning bg-warning font-weight-bold" style="border: 1px solid #e1e1e1fa;padding-left: 4px;">Tindakan Dokter : </div>
                                             <div colspan="3" class="border border-top-0 border-info" style="padding-left: 4px;"><b>Tx Utama : </b> <?= $item->tindakan_utama_deskripsi ?? '' ?></div>
                                             <div colspan="3" class="border border-top-0 border-info" style="padding-left: 4px;"><b>Tx Sekunder 1 :</b> <?= $item->tindakan_tambahan1_deskripsi ?? '' ?></div>
                                             <div colspan="3" class="border border-top-0 border-info" style="padding-left: 4px;"><b>Tx Sekunder 2 :</b> <?= $item->tindakan_tambahan2_deskripsi ?? '' ?></div>
                                             <div colspan="3" class="border border-top-0 border-info" style="padding-left: 4px;"><b>Tx Sekunder 3 :</b> <?= $item->tindakan_tambahan3_deskripsi ?? '' ?></div>
                                             <div colspan="3" class="border border-top-0 border-info" style="padding-left: 4px;"><b>Tx Sekunder 4 :</b> <?= $item->tindakan_tambahan4_deskripsi ?? '' ?></div>
                                             <div colspan="3" class="border border-top-0 border-info" style="padding-left: 4px;"><b>Tx Sekunder 5 :</b> <?= $item->tindakan_tambahan5_deskripsi ?? '' ?></div>

                                             <div colspan="3" class="border border-info border-info" style="padding-left: 4px;"><b>Tindakan : </b><?= $item->tindakan ?? '' ?></div>

                                             <div class="border border-warning bg-warning" style="border: 1px solid #e1e1e1fa;padding-left: 4px;"><b>Tindakan ICD9 : </b></div>
                                             <?php if ($item->tindutama) { ?>

                                                 <div class="border border-info bg-info" style="border: 1px solid #e1e1e1fa;padding-left: 4px;">Utama : </div>

                                                 <div colspan="3" class="border border-top-0 border-info" style="padding-left: 4px;"><b>ICD9 : </b><?= $item->tindutama->kode ?? '' ?><br><b>ICD9 Deskripsi : </b><?= $item->tindutama->deskripsi ?? '-' ?></div>
                                             <?php } ?>
                                             <?php if ($item->tindsatu) { ?>

                                                 <div class="border border-info bg-info" style="border: 1px solid #e1e1e1fa;padding-left: 4px;">Tambahan I : </div>
                                                 <div colspan="3" class="border border-top-0 border-info" style="padding-left: 4px;"><b>ICD9 : </b><?= $item->tindsatu->kode ?? '' ?><br><b>ICD9 Deskripsi : </b><?= $item->tindsatu->deskripsi ?? '-' ?></div>
                                             <?php } ?>
                                             <?php if ($item->tinddua) { ?>

                                                 <div class="border border-info bg-info" style="border: 1px solid #e1e1e1fa;padding-left: 4px;">Tambahan II : </div>
                                                 <div colspan="3" class="border border-top-0 border-info" style="padding-left: 4px;"><b>ICD9 : </b><?= $item->tinddua->kode ?? '' ?><br><b>ICD9 Deskripsi : </b><?= $item->tinddua->deskripsi ?? '-' ?></div>
                                             <?php } ?>
                                             <?php if ($item->tindtiga) { ?>

                                                 <div class="border border-info bg-info" style="border: 1px solid #e1e1e1fa;padding-left: 4px;">Tambahan III : <?= $item->tindtiga->kode ?? '' ?></div>
                                                 <div colspan="3" class="border border-top-0 border-info" style="padding-left: 4px;"><b>ICD9 : </b><?= $item->tindtiga->kode ?? '' ?><br><b>ICD9 Deskripsi : </b><?= $item->tindtiga->deskripsi ?? '-' ?></div>
                                             <?php } ?>
                                             <?php if ($item->tindempat) { ?>

                                                 <div class="border border-info bg-info" style="border: 1px solid #e1e1e1fa;padding-left: 4px;">Tambahan IV : <?= $item->tindempat->kode ?? '' ?></div>
                                                 <div colspan="3" class="border border-top-0 border-info" style="padding-left: 4px;"><b>ICD9 : </b><?= $item->tindempat->kode ?? '' ?><br><b>ICD9 Deskripsi : </b><?= $item->tindempat->deskripsi ?? '-' ?></div>
                                             <?php } ?>
                                             <?php if ($item->tindlima) { ?>

                                                 <div class="border border-info bg-info" style="border: 1px solid #e1e1e1fa;padding-left: 4px;">Tambahan V : <?= $item->tindlima->kode ?? '' ?></div>
                                                 <div colspan="3" class="border border-top-0 border-info" style="padding-left: 4px;"><b>ICD9 : </b><?= $item->tindlima->kode ?? '' ?><br><b>ICD9 Deskripsi : </b><?= $item->tindlima->deskripsi ?? '-' ?></div>
                                             <?php } ?>
                                             <div colspan="3" class="border border-top-0 border-info" style="padding-left: 4px;"><b>Terapi : </b><?= $item->terapi ?? '' ?></div>


                                         </td>
                                         <td style="vertical-align: top;text-align: left;">
                                             <div class="btn-group-vertical">

                                                 <a class="btn btn-success btn-sm btn-lihat-resume-medis" href="<?= Url::to(['preview-resume-medis', 'id' => $item['id']]) ?>" data-id="<?= $item['id'] ?>" data-nama="<?= $item['id'] ?>"> <i style="color:white" class="fa fa-eye"></i></i></a>

                                                 <a class="btn btn-info btn-sm" href="<?= Url::to(['/coder-ri/pelaporan', 'id' => $item['id'], 'icd' => true, 'registrasi_kode' => HelperGeneralClass::hashData($registrasi['kode'])]) ?>" data-id="<?= $item['id'] ?>" data-nama="<?= $item['id'] ?>"> <i style="color:white" class="fa fa-edit"></i></i></a>


                                             </div>
                                         </td>
                                     </tr>
                                 <?php
                                    }
                                } else {
                                    ?>
                                 <div class="border border-info bg-info" style="border: 1px solid #e1e1e1fa;padding-left: 4px;">Nama Dokter :</div>

                                 <div colspan="3" class="border border-top-0 border-info" style="padding-left: 4px;">Tidak Ada Data</div>
                             <?php } ?>



                         </table>
                     </div>
                 </div>

                 <!-- <div class="card card-danger card-outline">
                     <div class="card-header">
                         <h5 style="margin-bottom:6px;">Daftar Resume Medis Dokter Verifikator</h5>
                     </div>
                     <div class="card-body">

                         <table style="width: 100%;">
                             <?php
                                if (!empty($listResumeMedisDokterVerifikator)) {
                                    foreach ($listResumeMedisDokterVerifikator as $item) {
                                ?>
                                     <tr>
                                         <td>
                                             <div class="border border-info bg-info" style="border: 1px solid #e1e1e1fa;padding-left: 4px;">Nama Dokter : <?= HelperSpesialClass::getNamaPegawaiArray($item->dokter) ?? '' ?> <br>Nama Dokter Verifikator : <?= HelperSpesialClass::getNamaPegawaiArray($item->dokterVerifikator) ?? '' ?> <br>(Resume id: <?= $item->id_resume_medis_ri ?? '' ?>)</div>

                                             <div colspan="3" class="border border-top-0 border-info" style="padding-left: 4px;"><b>Ringkasan Riwayat Penyakit : </b><?= $item->ringkasan_riwayat_penyakit ?? '' ?></div>
                                             <div colspan="3" class="border border-top-0 border-info" style="padding-left: 4px;"><b>Hasil Pemeriksaan Fisik : </b><?= $item->hasil_pemeriksaan_fisik ?? '' ?></div>
                                             <div colspan="3" class="border border-top-0 border-info" style="padding-left: 4px;"><b>Indikasi Rawat Inap : </b><?= $item->indikasi_rawat_inap ?? '' ?></div>

                                             <div colspan="3" class="border border-top-0 border-info" style="padding-left: 4px;"><b>Diagnosa Masuk : </b><?= $item->diagnosa_masuk_deskripsi ?? '' ?></div>

                                             <div class="border border-warning bg-warning font-weight-bold" style="border: 1px solid #e1e1e1fa;padding-left: 4px;">Diagnosa ICD10:</div>
                                             <?php if ($item->diagutama) { ?>
                                                 <div class="border border-info bg-info" style="border: 1px solid #e1e1e1fa;padding-left: 4px;">Utama : </div>
                                                 <div colspan="3" class="border border-top-0 border-info" style="padding-left: 4px;"><b>ICD10 : </b><?= $item->diagutama->kode ?? '' ?><br><b>ICD10 Deskripsi :</b><?= $item->diagutama->deskripsi ?? '-' ?></div>
                                             <?php } ?>

                                             <?php if ($item->diagsatu) { ?>
                                                 <div class="border border-info bg-info" style="border: 1px solid #e1e1e1fa;padding-left: 4px;">Tambahan I :</div>
                                                 <div colspan="3" class="border border-top-0 border-info" style="padding-left: 4px;"><b>ICD10 : </b><?= $item->diagsatu->kode ?? '' ?><br><b>ICD10 Deskripsi :</b><?= $item->diagsatu->deskripsi ?? '-' ?></div>
                                             <?php } ?>
                                             <?php if ($item->diagdua) { ?>

                                                 <div class="border border-info bg-info" style="border: 1px solid #e1e1e1fa;padding-left: 4px;">Tambahan II : </div>

                                                 <div colspan="3" class="border border-top-0 border-info" style="padding-left: 4px;"><b>ICD10 : </b><?= $item->diagdua->kode ?? '' ?><br><b>ICD10 Deskripsi :</b><?= $item->diagdua->deskripsi ?? '-' ?></div>
                                             <?php } ?>
                                             <?php if ($item->diagtiga) { ?>

                                                 <div class="border border-info bg-info" style="border: 1px solid #e1e1e1fa;padding-left: 4px;">Tambahan III : </div>

                                                 <div colspan="3" class="border border-top-0 border-info" style="padding-left: 4px;"><b>ICD10 : </b><?= $item->diagtiga->kode ?? '' ?><br><b>ICD10 Deskripsi :</b><?= $item->diagtiga->deskripsi ?? '-' ?></div>
                                             <?php } ?>
                                             <?php if ($item->diagempat) { ?>

                                                 <div class="border border-info bg-info" style="border: 1px solid #e1e1e1fa;padding-left: 4px;">Tambahan IV : </div>
                                                 <div colspan="3" class="border border-top-0 border-info" style="padding-left: 4px;"><b>ICD10 : </b><?= $item->diagempat->kode ?? '' ?><br><b>ICD10 Deskripsi :</b><?= $item->diagempat->deskripsi ?? '-' ?></div>
                                             <?php } ?>
                                             <?php if ($item->diaglima) { ?>


                                                 <div class="border border-info bg-info" style="border: 1px solid #e1e1e1fa;padding-left: 4px;">Tambahan V : <?= $item->diaglima->kode ?? '' ?></div>

                                                 <div colspan="3" class="border border-top-0 border-info" style="padding-left: 4px;"><b>ICD10 : </b><?= $item->diaglima->kode ?? '' ?><br><b>ICD10 Deskripsi :</b><?= $item->diaglima->deskripsi ?? '-' ?></div>

                                             <?php } ?>

                                             <div colspan="3" class="border border-info border-info" style="padding-left: 4px;"><b>Tindakan : </b><?= $item->tindakan ?? '' ?></div>

                                             <div class="border border-warning bg-warning" style="border: 1px solid #e1e1e1fa;padding-left: 4px;"><b>Tindakan ICD9 : </b></div>
                                             <?php if ($item->tindutama) { ?>

                                                 <div class="border border-info bg-info" style="border: 1px solid #e1e1e1fa;padding-left: 4px;">Utama : </div>

                                                 <div colspan="3" class="border border-top-0 border-info" style="padding-left: 4px;"><b>ICD9 : </b><?= $item->tindutama->kode ?? '' ?><br><b>ICD9 Deskripsi : </b><?= $item->tindutama->deskripsi ?? '-' ?></div>
                                             <?php } ?>
                                             <?php if ($item->tindsatu) { ?>

                                                 <div class="border border-info bg-info" style="border: 1px solid #e1e1e1fa;padding-left: 4px;">Tambahan I : </div>
                                                 <div colspan="3" class="border border-top-0 border-info" style="padding-left: 4px;"><b>ICD9 : </b><?= $item->tindsatu->kode ?? '' ?><br><b>ICD9 Deskripsi : </b><?= $item->tindsatu->deskripsi ?? '-' ?></div>
                                             <?php } ?>
                                             <?php if ($item->tinddua) { ?>

                                                 <div class="border border-info bg-info" style="border: 1px solid #e1e1e1fa;padding-left: 4px;">Tambahan II : </div>
                                                 <div colspan="3" class="border border-top-0 border-info" style="padding-left: 4px;"><b>ICD9 : </b><?= $item->tinddua->kode ?? '' ?><br><b>ICD9 Deskripsi : </b><?= $item->tinddua->deskripsi ?? '-' ?></div>
                                             <?php } ?>
                                             <?php if ($item->tindtiga) { ?>

                                                 <div class="border border-info bg-info" style="border: 1px solid #e1e1e1fa;padding-left: 4px;">Tambahan III : <?= $item->tindtiga->kode ?? '' ?></div>
                                                 <div colspan="3" class="border border-top-0 border-info" style="padding-left: 4px;"><b>ICD9 : </b><?= $item->tindtiga->kode ?? '' ?><br><b>ICD9 Deskripsi : </b><?= $item->tindtiga->deskripsi ?? '-' ?></div>
                                             <?php } ?>
                                             <?php if ($item->tindempat) { ?>

                                                 <div class="border border-info bg-info" style="border: 1px solid #e1e1e1fa;padding-left: 4px;">Tambahan IV : <?= $item->tindempat->kode ?? '' ?></div>
                                                 <div colspan="3" class="border border-top-0 border-info" style="padding-left: 4px;"><b>ICD9 : </b><?= $item->tindempat->kode ?? '' ?><br><b>ICD9 Deskripsi : </b><?= $item->tindempat->deskripsi ?? '-' ?></div>
                                             <?php } ?>
                                             <?php if ($item->tindlima) { ?>

                                                 <div class="border border-info bg-info" style="border: 1px solid #e1e1e1fa;padding-left: 4px;">Tambahan V : <?= $item->tindlima->kode ?? '' ?></div>
                                                 <div colspan="3" class="border border-top-0 border-info" style="padding-left: 4px;"><b>ICD9 : </b><?= $item->tindlima->kode ?? '' ?><br><b>ICD9 Deskripsi : </b><?= $item->tindlima->deskripsi ?? '-' ?></div>
                                             <?php } ?>
                                             <div colspan="3" class="border border-top-0 border-info" style="padding-left: 4px;"><b>Terapi : </b><?= $item->terapi ?? '' ?></div>


                                         </td>
                                         <td style="vertical-align: top;text-align: left;">
                                             <div class="btn-group-vertical">

                                                 <a class="btn btn-success btn-sm btn-preview-resume-verifikator-ri" href="<?= Url::to(['/analisa-kuantitatif/preview-resume-medis', 'id' => $item['id']]) ?>" data-id="<?= $item['id'] ?>" data-nama="<?= $item['id'] ?>" data-pasien="<?= $registrasi['pasien']['kode'] ?>"> <i style="color:white" class="fa fa-eye"></i></i></a>

                                                 <a class="btn btn-info btn-sm" href="<?= Url::to(['/coder-ri/pelaporan', 'id' => $item['id_resume_medis_ri'], 'icd' => true, 'registrasi_kode' => HelperGeneralClass::hashData($registrasi['kode'])]) ?>" data-id="<?= $item['id'] ?>" data-nama="<?= $item['id'] ?>"> <i style="color:white" class="fa fa-edit"></i></i></a>

                                             </div>
                                         </td>
                                     </tr>
                                 <?php
                                    }
                                } else {
                                    ?>
                                 <div class="border border-info bg-info" style="border: 1px solid #e1e1e1fa;padding-left: 4px;">Nama Dokter :</div>

                                 <div colspan="3" class="border border-top-0 border-info" style="padding-left: 4px;">Tidak Ada Data</div>
                             <?php } ?>



                         </table>
                     </div>
                 </div> -->
                 <div class="card card-primary card-outline">
                     <div class="card-header">
                         <h5 style="margin-bottom:6px;">Hasil Coding Dari Coder</h5>
                     </div>
                     <div class="card-body">

                         <table>

                             <?php
                                if (!empty($listCoder)) {
                                ?><tr>
                                     <td>
                                         <div class="border border-info bg-danger" style="border: 1px solid #e1e1e1fa;padding-left: 4px;"><b>Nama Dokter : </b><?= HelperSpesialClass::getNamaPegawaiArray($listCoder->resumeMedis->dokter) ?? '' ?><br>Nama Coder : <?= HelperSpesialClass::getNamaPegawaiArray($listCoder->coder) ?? '' ?><br>Tgl Coder : <?= $listCoder->updated_at ?? $listCoder->created_at ?><br>(Resume id: <?= $listCoder->id_resume_medis_rj ?? '' ?>)</div>
                                         <div colspan="3" class="border border-top-0 border-info" style="padding-left: 4px;"><b>Ringkasan Riwayat Penyakit : </b><?= $listCoder->resumeMedis->ringkasan_riwayat_penyakit ?? '' ?></div>
                                         <div colspan="3" class="border border-top-0 border-info" style="padding-left: 4px;"><b>Hasil Pemeriksaan Fisik : </b><?= $listCoder->resumeMedis->hasil_pemeriksaan_fisik ?? '' ?></div>
                                         <div colspan="3" class="border border-top-0 border-info" style="padding-left: 4px;"><b>Indikasi Rawat Inap : </b><?= $listCoder->resumeMedis->indikasi_rawat_inap ?? '' ?></div>
                                         <div colspan="3" class="border border-top-0 border-info" style="padding-left: 4px;"><b>Diagnosa Masuk : </b><?= $listCoder->resumeMedis->diagnosa_masuk_deskripsi ?? '' ?></div>

                                         <div class="border border-warning bg-warning font-weight-bold" style="border: 1px solid #e1e1e1fa;padding-left: 4px;">Diagnosa ICD10:</div>

                                         <?php foreach ($listCoder->claimDiagnosa as $key => $item) {
                                            ?> <?php if ($item->id) { ?>

                                                 <div class="border border-info" style="border: 1px solid #e1e1e1fa;padding-left: 4px;"><b>Diagnosa <?= ($key + 1) ?>:</b> <?= $item->diagnosa->kode ?? '' ?> (<?= $item->diagnosa->deskripsi ?? '' ?>) - <b><?= $item->utama == 1 ? 'Utama' : 'Tambahan' ?></b></div>


                                             <?php } ?>
                                         <?php } ?>

                                         <div colspan="3" class="border border-info border-info" style="padding-left: 4px;"><b>Tindakan : </b><?= $listCoder->resumeMedis->tindakan ?? '' ?></div>

                                         <div class="border border-warning bg-warning" style="border: 1px solid #e1e1e1fa;padding-left: 4px;"><b>Tindakan ICD9 : </b></div>
                                         <?php foreach ($listCoder->claimTindakan as $key => $item) {
                                            ?> <?php if ($item->id) { ?>

                                                 <div class="border border-info" style="border: 1px solid #e1e1e1fa;padding-left: 4px;"><b>Diagnosa <?= ($key + 1) ?>:</b> <?= $item->tindakan->kode ?? '' ?> (<?= $item->tindakan->deskripsi ?? '' ?>) - <b><?= $item->utama == 1 ? 'Utama' : 'Tambahan' ?></b></div>


                                             <?php } ?>
                                         <?php } ?>

                                         <div colspan="3" class="border border-top-0 border-info" style="padding-left: 4px;"><b>Terapi : </b><?= $listCoder->resumeMedis->terapi ?? '' ?></div>
                                     </td>

                                 </tr>
                             <?php
                                } else {
                                ?>
                                 <div class="border border-info bg-info" style="border: 1px solid #e1e1e1fa;padding-left: 4px;">Nama Dokter :</div>

                                 <div colspan="3" class="border border-top-0 border-info" style="padding-left: 4px;">Tidak Ada Data</div>
                             <?php } ?>

                         </table>
                     </div>
                 </div>
             </div>
             <div class="col-lg-8">


                 <div class="card card-primary card-outline">

                     <div class="card-header">
                         <h5 style="margin-bottom:6px;">Coding Claim (Coder Claim id:<?= Yii::$app->request->get('id') ?? '' ?>) <a class="btn btn-danger" href="<?= Url::to(['/coder-ri/pelaporan', 'id' => Yii::$app->request->get('id'), 'registrasi_kode' => HelperGeneralClass::hashData($registrasi['kode'])]) ?>"><i style="color: white;" class="fa fa-edit"></i> Buat Coding Pelaporan</a></h5>
                     </div>
                     <div class="card-body">
                         <div class="tab-content" id="custom-tabs-four-tabContent">
                             <div class="tab-pane fade active show" id="custom-tabs-four-home" role="tabpanel" aria-labelledby="custom-tabs-four-home-tab">

                                 <?php $form = ActiveForm::begin([
                                        'id' => 'codingclaim-' . $modelCodingClaimRi->formName(),
                                        'options' => [
                                            'name' => 'codingclaim-' . $modelCodingClaimRi->formName(),
                                            'data-pjax' => true
                                        ],
                                    ]); ?>
                                 <?= $form->field($modelCodingClaimRi, 'id_resume_medis_ri')->hiddenInput(['value' => Yii::$app->request->get('id')])->label(false) ?>

                                 <?= $form->field($modelCodingClaimRi, 'registrasi_kode')->hiddenInput(['maxlength' => true, 'value' => $registrasi['kode']])->label(false) ?>
                                 <?= $form->field($modelCodingClaimRi, 'jenis_layanan')->hiddenInput(['maxlength' => true, 'value' => 3])->label(false) ?>
                                 <?= $form->field($modelCodingClaimRi, 'pegawai_coder_id')->hiddenInput(['maxlength' => true, 'value' => HelperSpesialClass::getUserLogin()['pegawai_id']])->label(false) ?>

                                 <div class="panel-heading">
                                     <h6 class="mb-2 text-uppercase bg-light p-2"><i class="fas fa-archive mr-3"></i>I. ICD-10 Claim (Resume id: <?= Yii::$app->request->get('id') ?? '' ?> ) </h6>
                                 </div>
                                 <?= $form->field($modelCodingClaimRi, 'estimasi')->textInput(['maxlength' => true, 'type' => 'number', 'step' => '1', 'id' => 'estimasi']) ?>

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
                                                'formId' => 'codingclaim-' . $modelCodingClaimRi->formName(),
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
                                        'id' => 'codingclaimic9-' . $modelCodingClaimRi->formName(),
                                        'options' => [
                                            'name' => 'codingclaimic9-' . $modelCodingClaimRi->formName(),
                                            'data-pjax' => true
                                        ],
                                    ]); ?>
                                 <?= $form->field($modelCodingClaimRi, 'id_resume_medis_rj')->hiddenInput(['value' => Yii::$app->request->get('id')])->label(false) ?>


                                 <?= $form->field($modelCodingClaimRi, 'registrasi_kode')->hiddenInput(['maxlength' => true, 'value' => $registrasi['kode']])->label(false) ?>
                                 <?= $form->field($modelCodingClaimRi, 'jenis_layanan')->hiddenInput(['maxlength' => true, 'value' => 3])->label(false) ?>
                                 <?php if ($modelCodingClaimRi->isNewRecord) { ?>
                                     <?= $form->field($modelCodingClaimRi, 'pegawai_coder_id')->hiddenInput(['maxlength' => true, 'value' => HelperSpesialClass::getUserLogin()['pegawai_id']])->label(false) ?>
                                 <?php } else { ?>
                                     <?= $form->field($modelCodingClaimRi, 'pegawai_coder_id')->hiddenInput(['maxlength' => true])->label(false) ?>

                                 <?php } ?><div class="panel-heading">
                                     <h6 class="mb-2 text-uppercase bg-light p-2"><i class="fas fa-archive mr-3"></i>II. ICD-9 Claim (Resume id: <?= Yii::$app->request->get('id') ?? '' ?> )</h6>
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
                                                'formId' => 'codingclaimic9-' . $modelCodingClaimRi->formName(),
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