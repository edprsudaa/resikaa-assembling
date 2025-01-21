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
    $('#ResumeMedisRj_anamesis_2_t').on('input change focus paste', function (e) {
        let teks = $('#ResumeMedisRj_anamesis_2_t').val()
        $('#ResumeMedisRj_anamesis_2').val(teks)
        $('#ResumeMedisRj_anamesis_2').prop('checked', true)
    });
    $('#ResumeMedisRj_pemeriksaan_fisik_2_t').on('keyup input change focus paste', function (e) {
        let teks = $('#ResumeMedisRj_pemeriksaan_fisik_2_t').val()
        $('#ResumeMedisRj_pemeriksaan_fisik_2').val(teks)
        $('#ResumeMedisRj_pemeriksaan_fisik_2').prop('checked', true)
    });
    $('#ResumeMedisRj_terapi_2_t').on('keyup input change focus paste', function (e) {
        let teks = $('#ResumeMedisRj_terapi_2_t').val()
        $('#ResumeMedisRj_terapi_2').val(teks)
        $('#ResumeMedisRj_terapi_2').prop('checked', true)
    });
    $('#ResumeMedisRj_lab_2_t').on('keyup input change focus paste', function (e) {
        let teks = $('#ResumeMedisRj_lab_2_t').val()
        $('#ResumeMedisRj_lab_2').val(teks)
        $('#ResumeMedisRj_lab_2').prop('checked', true)
    });
    $('#ResumeMedisRj_rad_2_t').on('keyup input change focus paste', function (e) {
        let teks = $('#ResumeMedisRj_rad_2_t').val()
        $('#ResumeMedisRj_rad_2').val(teks)
        $('#ResumeMedisRj_rad_2').prop('checked', true)
    });
    $('#ResumeMedisRj_keterangan_2_t').on('keyup input change focus paste', function (e) {
        let teks = $('#ResumeMedisRj_keterangan_2_t').val()
        $('#ResumeMedisRj_keterangan_2').val(teks)
        $('#ResumeMedisRj_keterangan_2').prop('checked', true)
    });
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
             <div class="col-lg-4">

                 <div class="card card-danger card-outline">
                     <div class="card-header">
                         <h5 style="margin-bottom:6px;">Daftar Resume Medis</h5>
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
                                             <div colspan="3" class="border border-top-0 border-info" style="padding-left: 4px;"><b>Anamenesis : </b><?= $item->anamesis ?? '' ?></div>
                                             <div colspan="3" class="border border-top-0 border-info" style="padding-left: 4px;"><b>Pemeriksaan Fisik : </b><?= $item->pemeriksaan_fisik ?? '' ?></div>

                                             <div colspan="3" class="border border-top-0 border-info" style="padding-left: 4px;"><b>Diagnosa : </b><?= $item->diagnosa ?? '' ?></div>

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

                                                 <a class="btn btn-success btn-sm btn-preview-resume-rj" href="<?= Url::to(['analisa-kuantitatif/detail-resume-rj', 'id' => $item['id']]) ?>" data-id="<?= $item['id'] ?>" data-pasien="<?= $registrasi['pasien']['kode'] ?>" data-nama="<?= $item['id'] ?>"> <i class="fa fa-eye"></i></i></a>
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
                 <div class="card card-primary card-outline">
                     <div class="card-header">
                         <h5 style="margin-bottom:6px;">Daftar Resume Medis Jalan Claim Coder</h5>
                     </div>
                     <div class="card-body">

                         <table>

                             <?php
                                if (!empty($listResumeMedisVerifikator)) {
                                    foreach ($listResumeMedisVerifikator as $item) {
                                ?><tr>
                                         <td>
                                             <div class="border border-info bg-danger" style="border: 1px solid #e1e1e1fa;padding-left: 4px;">Nama Dokter : <?= HelperSpesialClass::getNamaPegawaiArray($item->dokterVerifikator) ?? '' ?> <br>(Resume id: <?= $item->id_resume_medis_rj ?? '' ?>)<br>(Verifikator id :<?= $item->id ?? '' ?>)</div>

                                             <div colspan="3" class="border border-top-0 border-info" style="padding-left: 4px;"><b>Anamenesis : </b><?= $item->anamesis ?? '' ?></div>
                                             <div colspan="3" class="border border-top-0 border-info" style="padding-left: 4px;"><b>Pemeriksaan Fisik : </b><?= $item->pemeriksaan_fisik ?? '' ?></div>

                                             <div colspan="3" class="border border-top-0 border-info" style="padding-left: 4px;"><b>Diagnosa : </b><?= $item->diagnosa ?? '' ?></div>

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
                                                 <a class="btn btn-success btn-sm btn-preview-resume-verifikator-rj" href="<?= Url::to(['analisa-kuantitatif/preview-resume-medis', 'id' => $item['id']]) ?>" data-id="<?= $item['id'] ?>" data-pasien="<?= $registrasi['pasien']['kode'] ?>" data-nama="<?= $item['id'] ?>"> <i class="fa fa-eye"></i></i></a>
                                                 <a class="btn btn-warning btn-sm" target="_blank" href="<?= Url::to(['/analisa-kuantitatif/cetak-resume-medis-dokter-verifikator-rj', 'id' => $item['id'], 'pasien' => $registrasi['pasien']['kode']]) ?>" data-id="<?= $item['id'] ?>" data-pasien="<?= $registrasi['pasien']['kode'] ?>" data-nama="<?= $item['id'] ?>"> <i class="fa fa-print"></i></i></a>


                                                 <a class="btn btn-info btn-sm" href="<?= Url::to(['analisa-kuantitatif/detail-coder-claim-rj-no-verif-update', 'id' => $item['id'], 'registrasi_kode' => HelperGeneralClass::hashData($registrasi['kode'])]) ?>" data-id="<?= $item['id'] ?>" data-nama="<?= $item['id'] ?>"> <i class="fa fa-edit"></i></i></a>
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
             </div>
             <div class="col-lg-8">


                 <div class="card card-primary card-outline">

                     <div class="card-header">
                         <h5 style="margin-bottom:6px;">Coding Claim (Resume id : <?= $model->id_resume_medis_rj ?? '' ?>) <a class="btn btn-danger" href="<?= Url::to(['/analisa-kuantitatif/detail-coder-pelaporan-rj', 'id' => HelperGeneralClass::hashData($registrasi['kode']), 'icd' => true]) ?>"><i style="color: white;" class="fa fa-edit"></i> Buat Coding Pelaporan</a></h5>
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
                                 <?= $form->field($model, 'dokter_id')->hiddenInput()->label(false);
                                    ?>

                                 <?= $form->field($model, 'id_resume_medis_rj')->hiddenInput()->label(false); ?>
                                 <?= $form->field($model, 'dokter_verifikator_id')->hiddenInput()->label(false); ?>
                                 <?= $form->field($model, 'layanan_id')->hiddenInput()->label(false); ?>
                                 <?= $form->field($model, 'anamesis')->hiddenInput()->label(false); ?>
                                 <?= $form->field($model, 'diagnosa')->hiddenInput()->label(false); ?>

                                 <?= $form->field($model, 'kasus')->hiddenInput()->label(false); ?>
                                 <?= $form->field($model, 'terapi')->hiddenInput()->label(false); ?>
                                 <?= $form->field($model, 'rencana')->hiddenInput()->label(false); ?>
                                 <?= $form->field($model, 'alasan_kontrol')->hiddenInput()->label(false); ?>
                                 <?= $form->field($model, 'alasan')->hiddenInput()->label(false); ?>
                                 <?= $form->field($model, 'lab')->hiddenInput()->label(false); ?>

                                 <?= $form->field($model, 'rad')->hiddenInput()->label(false); ?>
                                 <?= $form->field($model, 'poli_tujuan_kontrol_id')->hiddenInput()->label(false); ?>
                                 <?= $form->field($model, 'poli_tujuan_kontrol_nama')->hiddenInput()->label(false); ?>
                                 <?= $form->field($model, 'tgl_kontrol')->hiddenInput()->label(false); ?>
                                 <?= $form->field($model, 'keterangan')->hiddenInput()->label(false); ?>
                                 <?= $form->field($model, 'anamesis')->hiddenInput()->label(false); ?>
                                 <?= $form->field($model, 'kasus')->hiddenInput()->label(false); ?>

                                 <hr>
                                 <h3><b>Diagnosa</b></h3>
                                 <hr>
                                 <div class="row">
                                     <div class="col-sm-2">
                                         <label>Utama :</label>
                                     </div>
                                     <div class="col-sm-10">
                                         <div class="row">
                                             <div class="col-sm-12">
                                                 <?= $form->field($model, 'diagnosa_utama_id')->widget(Select2::classname(), [
                                                        'initValueText' => ($model->diagutama) ? '(' . $model->diagutama->kode . ')' . $model->diagutama->deskripsi : null,
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
                                         <label>Tambahan I :</label>
                                     </div>
                                     <div class="col-sm-10">
                                         <div class="row">
                                             <div class="col-sm-12">
                                                 <?= $form->field($model, 'diagnosa_tambahan1_id')->widget(Select2::classname(), [
                                                        'initValueText' => ($model->diagsatu) ? '(' . $model->diagsatu->kode . ')' . $model->diagsatu->deskripsi : null,
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
                                             <div class="col-sm-12">
                                                 <?= $form->field($model, 'diagnosa_tambahan2_id')->widget(Select2::classname(), [
                                                        'initValueText' => ($model->diagdua) ? '(' . $model->diagdua->kode . ')' . $model->diagdua->deskripsi : null,
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
                                         <label>Tambahan IV :</label>
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
                                         <label>Tambahan V :</label>
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
                                 <hr>
                                 <h3><b>Tindakan</b></h3>
                                 <hr>

                                 <div class="row">
                                     <div class="col-sm-2">
                                         <label>Utama :</label>
                                     </div>
                                     <div class="col-sm-10">
                                         <div class="row">
                                             <div class="col-sm-12">
                                                 <?= $form->field($model, 'tindakan_utama_id')->widget(Select2::classname(), [
                                                        'initValueText' => ($model->tindutama) ? '(' . $model->tindutama->kode . ')' . $model->tindutama->deskripsi : null,
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
                                         <label>Tambahan I :</label>
                                     </div>
                                     <div class="col-sm-10">
                                         <div class="row">
                                             <div class="col-sm-12">
                                                 <?= $form->field($model, 'tindakan_tambahan1_id')->widget(Select2::classname(), [
                                                        'initValueText' => ($model->tindsatu) ? '(' . $model->tindsatu->kode . ')' . $model->tindsatu->deskripsi : null,
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
                                             <div class="col-sm-12">
                                                 <?= $form->field($model, 'tindakan_tambahan2_id')->widget(Select2::classname(), [
                                                        'initValueText' => ($model->tinddua) ? '(' . $model->tinddua->kode . ')' . $model->tinddua->deskripsi : null,
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
                                         <label>Tambahan IV :</label>
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
                                         <label>Tambahan V :</label>
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

                                 <div class="mb-2">
                                     <?= Html::submitButton('Simpan Data Coder', ['class' => 'btn btn-success btn-block mb-2 rounded-0', 'id' => 'btn-icd-10-laporan-simpan']) ?>
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
         <?php ActiveForm::end(); ?>
     </div>
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
