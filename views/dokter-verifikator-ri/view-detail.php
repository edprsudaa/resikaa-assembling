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
    $('#ResumeMedisRi_alergi_2_t').on('input change focus paste', function (e) {
        let teks = $('#ResumeMedisRi_alergi_2_t').val()
        $('#ResumeMedisRi_alergi_2').val(teks)
        $('#ResumeMedisRi_alergi_2').prop('checked', true)
    });
    $('#ResumeMedisRi_diet_2_t').on('keyup input change focus paste', function (e) {
        let teks = $('#ResumeMedisRi_diet_2_t').val()
        $('#ResumeMedisRi_diet_2').val(teks)
        $('#ResumeMedisRi_diet_2').prop('checked', true)
    });
    $('#ResumeMedisRi_kondisi_pulang_4_t').on('input change focus paste', function (e) {
        let teks = $('#ResumeMedisRi_kondisi_pulang_4_t').val()
        $('#ResumeMedisRi_kondisi_pulang_4').val(teks)
        $('#ResumeMedisRi_kondisi_pulang_4').prop('checked', true)
    });
    $('#ResumeMedisRi_cara_pulang_4_t').on('input change focus paste', function (e) {
        let teks = $('#ResumeMedisRi_cara_pulang_4_t').val()
        $('#ResumeMedisRi_cara_pulang_4').val(teks)
        $('#ResumeMedisRi_cara_pulang_4').prop('checked', true)
    });
    $('#ResumeMedisRi_obat_rumah_2_t').on('input change focus paste', function (e) {
        let teks = $('#ResumeMedisRi_obat_rumah_2_t').val()
        $('#ResumeMedisRi_obat_rumah_2').val(teks)
        $('#ResumeMedisRi_obat_rumah_2').prop('checked', true)
    });
    $('#ResumeMedisRi_terapi_pulang_2_t').on('input change focus paste', function (e) {
        let teks = $('#ResumeMedisRi_terapi_pulang_2_t').val()
        $('#ResumeMedisRi_terapi_pulang_2').val(teks)
        $('#ResumeMedisRi_terapi_pulang_2').prop('checked', true)
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
     $('#af-dokter-verifikator').on('beforeSubmit',function(e){
         e.preventDefault();
         var btn=$('.btn-submit');
         var htm=btn.html();
         $('body').addClass('loading');
         $('#btn-loading-analisa').attr('style', 'display: block')
         $.ajax({
             url:'" . Url::to(['save-resume-medis-verifikator']) . "',
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
    ");
    ?>

 <div class="card card-primary card-outline">

     <div class="card-body">
         <div class="row">
             <div class="col-lg-4">
                 <div class="card card-primary card-outline">
                     <div class="card-header">
                         <h5 style="margin-bottom:6px;">Daftar Resume Medis DPJP</h5>
                     </div>
                     <div class="card-body">
                         <table>
                             <?php
                                if (!empty($listResumeMedisDokter)) {
                                    foreach ($listResumeMedisDokter as $item) {
                                ?>
                                     <tr>
                                         <td>
                                             <div class="border border-info bg-info" style="border: 1px solid #e1e1e1fa;padding-left: 4px;">Nama Dokter : <?= HelperSpesialClass::getNamaPegawaiArray($item->dokter) ?? '' ?> <br>(Resume id: <?= $item->id ?? '' ?>)</div>

                                             <div class="border border-warning bg-warning font-weight-bold" style="border: 1px solid #e1e1e1fa;padding-left: 4px;">Diagnosa ICD10:</div>

                                             <div class="border border-info bg-info" style="border: 1px solid #e1e1e1fa;padding-left: 4px;">Utama : </div>
                                             <div colspan="3" class="border border-top-0 border-info" style="padding-left: 4px;"><b>ICD10 :</b><?= $item->diagutama->kode ?? '' ?><br><b>ICD10 Deskripsi :</b><?= $item->diagutama->deskripsi ?? '-' ?><br><b>Deskripsi Dokter : </b> <?= $item->diagnosa_utama_deskripsi ?? '' ?></div>
                                             <div class="border border-info bg-info" style="border: 1px solid #e1e1e1fa;padding-left: 4px;">Tambahan I :</div>
                                             <div colspan="3" class="border border-top-0 border-info" style="padding-left: 4px;"><b>ICD10 :</b><?= $item->diagsatu->kode ?? '' ?><br><b>ICD10 Deskripsi :</b><?= $item->diagsatu->deskripsi ?? '-' ?><br><b>Deskripsi Dokter : </b> <?= $item->diagnosa_tambahan1_deskripsi ?? '' ?></div>

                                             <div class="border border-info bg-info" style="border: 1px solid #e1e1e1fa;padding-left: 4px;">Tambahan II : </div>

                                             <div colspan="3" class="border border-top-0 border-info" style="padding-left: 4px;"><b>ICD10 :</b><?= $item->diagdua->kode ?? '' ?><br><b>ICD10 Deskripsi :</b><?= $item->diagdua->deskripsi ?? '-' ?><br><b>Deskripsi Dokter : </b> <?= $item->diagnosa_tambahan2_deskripsi ?? '' ?></div>

                                             <div class="border border-info bg-info" style="border: 1px solid #e1e1e1fa;padding-left: 4px;">Tambahan III : </div>

                                             <div colspan="3" class="border border-top-0 border-info" style="padding-left: 4px;"><b>ICD10 :</b><?= $item->diagtiga->kode ?? '' ?><br><b>ICD10 Deskripsi :</b><?= $item->diagtiga->deskripsi ?? '-' ?><br><b>Deskripsi Dokter : </b> <?= $item->diagnosa_tambahan3_deskripsi ?? '' ?></div>

                                             <div class="border border-info bg-info" style="border: 1px solid #e1e1e1fa;padding-left: 4px;">Tambahan IV : </div>
                                             <div colspan="3" class="border border-top-0 border-info" style="padding-left: 4px;"><b>ICD10 :</b><?= $item->diagempat->kode ?? '' ?><br><b>ICD10 Deskripsi :</b><?= $item->diagempat->deskripsi ?? '-' ?><br><b>Deskripsi Dokter : </b> <?= $item->diagnosa_tambahan4_deskripsi ?? '' ?></div>

                                             <div class="border border-info bg-info" style="border: 1px solid #e1e1e1fa;padding-left: 4px;">Tambahan V : <?= $item->diaglima->kode ?? '' ?></div>

                                             <div colspan="3" class="border border-top-0 border-info" style="padding-left: 4px;"><b>ICD10 :</b><?= $item->diaglima->kode ?? '' ?><br><b>ICD10 Deskripsi :</b><?= $item->diaglima->deskripsi ?? '-' ?><br><b>Deskripsi Dokter : </b> <?= $item->diagnosa_tambahan5_deskripsi ?? '' ?></div>



                                             <div class="border border-warning bg-warning" style="border: 1px solid #e1e1e1fa;padding-left: 4px;"><b>Tindakan ICD9 : </b></div>

                                             <div class="border border-info bg-info" style="border: 1px solid #e1e1e1fa;padding-left: 4px;">Utama : </div>

                                             <div colspan="3" class="border border-top-0 border-info" style="padding-left: 4px;"><b>ICD9 : </b><?= $item->tindutama->kode ?? '' ?><br><b>ICD9 Deskripsi : </b><?= $item->tindutama->deskripsi ?? '-' ?><br><b>Deskripsi Dokter : </b><?= $item->tindakan_utama_deskripsi ?? '' ?></div>
                                             <div class="border border-info bg-info" style="border: 1px solid #e1e1e1fa;padding-left: 4px;">Tambahan I : </div>
                                             <div colspan="3" class="border border-top-0 border-info" style="padding-left: 4px;"><b>ICD9 : </b><?= $item->tindsatu->kode ?? '' ?><br><b>ICD9 Deskripsi : </b><?= $item->tindsatu->deskripsi ?? '-' ?><br><b>Deskripsi Dokter : </b><?= $item->tindakan_tambahan1_deskripsi ?? '' ?></div>

                                             <div class="border border-info bg-info" style="border: 1px solid #e1e1e1fa;padding-left: 4px;">Tambahan II : </div>
                                             <div colspan="3" class="border border-top-0 border-info" style="padding-left: 4px;"><b>ICD9 : </b><?= $item->tinddua->kode ?? '' ?><br><b>ICD9 Deskripsi : </b><?= $item->tinddua->deskripsi ?? '-' ?><br><b>Deskripsi Dokter : </b><?= $item->tindakan_tambahan2_deskripsi ?? '' ?></div>

                                             <div class="border border-info bg-info" style="border: 1px solid #e1e1e1fa;padding-left: 4px;">Tambahan III : <?= $item->tindtiga->kode ?? '' ?></div>
                                             <div colspan="3" class="border border-top-0 border-info" style="padding-left: 4px;"><b>ICD9 : </b><?= $item->tindtiga->kode ?? '' ?><br><b>ICD9 Deskripsi : </b><?= $item->tindtiga->deskripsi ?? '-' ?><br><b>Deskripsi Dokter : </b><?= $item->tindakan_tambahan3_deskripsi ?? '' ?></div>

                                             <div class="border border-info bg-info" style="border: 1px solid #e1e1e1fa;padding-left: 4px;">Tambahan IV : <?= $item->tindempat->kode ?? '' ?></div>
                                             <div colspan="3" class="border border-top-0 border-info" style="padding-left: 4px;"><b>ICD9 : </b><?= $item->tindempat->kode ?? '' ?><br><b>ICD9 Deskripsi : </b><?= $item->tindempat->deskripsi ?? '-' ?><br><b>Deskripsi Dokter : </b><?= $item->tindakan_tambahan4_deskripsi ?? '' ?></div>

                                             <div class="border border-info bg-info" style="border: 1px solid #e1e1e1fa;padding-left: 4px;">Tambahan V : <?= $item->tindlima->kode ?? '' ?></div>
                                             <div colspan="3" class="border border-top-0 border-info" style="padding-left: 4px;"><b>ICD9 : </b><?= $item->tindlima->kode ?? '' ?><br><b>ICD9 Deskripsi : </b><?= $item->tindlima->deskripsi ?? '-' ?><br><b>Deskripsi Dokter : </b><?= $item->tindakan_tambahan5_deskripsi ?? '' ?></div>


                                         </td>
                                         <td style="vertical-align: top;text-align: left;">
                                             <div class="btn-group-vertical">
                                                 <a class="btn btn-success btn-sm btn-lihat-operasi" href="<?= Url::to(['analisa-kuantitatif/preview-resume-medis', 'id' => $item['id']]) ?>" data-id="<?= $item['id'] ?>" data-nama="<?= $item['id'] ?>"> <i class="fa fa-eye"></i></i></a>
                                                 <a class="btn btn-info btn-sm" href="<?= Url::to(['dokter-verifikator-ri/verifikator', 'id' => $item['id'], 'registrasi_kode' => HelperGeneralClass::hashData($registrasi['kode'])]) ?>" data-id="<?= $item['id'] ?>" data-nama="<?= $item['id'] ?>"> <i class="fa fa-edit"></i></i></a>
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
                         <h5 style="margin-bottom:6px;">Daftar Resume Medis Verifikator</h5>
                     </div>
                     <div class="card-body">
                         <table>

                             <?php
                                if (!empty($listResumeMedisVerifikator)) {
                                    foreach ($listResumeMedisVerifikator as $item) {
                                ?><tr>
                                         <td>
                                             <div class="border border-info bg-danger" style="border: 1px solid #e1e1e1fa;padding-left: 4px;">Nama Dokter : <?= HelperSpesialClass::getNamaPegawaiArray($item->dokterVerifikator) ?? '' ?><br>(Verifikator id :<?= $item->id ?? '' ?>)</div>


                                             <div class="border border-warning bg-warning font-weight-bold" style="border: 1px solid #e1e1e1fa;padding-left: 4px;">Diagnosa ICD10:</div>

                                             <div class="border border-info bg-info" style="border: 1px solid #e1e1e1fa;padding-left: 4px;">Utama : </div>
                                             <div colspan="3" class="border border-top-0 border-info" style="padding-left: 4px;"><b>ICD10 :</b><?= $item->diagutama->kode ?? '' ?><br><b>ICD10 Deskripsi :</b><?= $item->diagutama->deskripsi ?? '-' ?><br><b>Deskripsi Dokter : </b> <?= $item->diagnosa_utama_deskripsi ?? '' ?></div>
                                             <div class="border border-info bg-info" style="border: 1px solid #e1e1e1fa;padding-left: 4px;">Tambahan I :</div>
                                             <div colspan="3" class="border border-top-0 border-info" style="padding-left: 4px;"><b>ICD10 :</b><?= $item->diagsatu->kode ?? '' ?><br><b>ICD10 Deskripsi :</b><?= $item->diagsatu->deskripsi ?? '-' ?><br><b>Deskripsi Dokter : </b> <?= $item->diagnosa_tambahan1_deskripsi ?? '' ?></div>

                                             <div class="border border-info bg-info" style="border: 1px solid #e1e1e1fa;padding-left: 4px;">Tambahan II : </div>

                                             <div colspan="3" class="border border-top-0 border-info" style="padding-left: 4px;"><b>ICD10 :</b><?= $item->diagdua->kode ?? '' ?><br><b>ICD10 Deskripsi :</b><?= $item->diagdua->deskripsi ?? '-' ?><br><b>Deskripsi Dokter : </b> <?= $item->diagnosa_tambahan2_deskripsi ?? '' ?></div>

                                             <div class="border border-info bg-info" style="border: 1px solid #e1e1e1fa;padding-left: 4px;">Tambahan III : </div>

                                             <div colspan="3" class="border border-top-0 border-info" style="padding-left: 4px;"><b>ICD10 :</b><?= $item->diagtiga->kode ?? '' ?><br><b>ICD10 Deskripsi :</b><?= $item->diagtiga->deskripsi ?? '-' ?><br><b>Deskripsi Dokter : </b> <?= $item->diagnosa_tambahan3_deskripsi ?? '' ?></div>

                                             <div class="border border-info bg-info" style="border: 1px solid #e1e1e1fa;padding-left: 4px;">Tambahan IV : </div>
                                             <div colspan="3" class="border border-top-0 border-info" style="padding-left: 4px;"><b>ICD10 :</b><?= $item->diagempat->kode ?? '' ?><br><b>ICD10 Deskripsi :</b><?= $item->diagempat->deskripsi ?? '-' ?><br><b>Deskripsi Dokter : </b> <?= $item->diagnosa_tambahan4_deskripsi ?? '' ?></div>

                                             <div class="border border-info bg-info" style="border: 1px solid #e1e1e1fa;padding-left: 4px;">Tambahan V : <?= $item->diaglima->kode ?? '' ?></div>

                                             <div colspan="3" class="border border-top-0 border-info" style="padding-left: 4px;"><b>ICD10 :</b><?= $item->diaglima->kode ?? '' ?><br><b>ICD10 Deskripsi :</b><?= $item->diaglima->deskripsi ?? '-' ?><br><b>Deskripsi Dokter : </b> <?= $item->diagnosa_tambahan5_deskripsi ?? '' ?></div>



                                             <div class="border border-warning bg-warning" style="border: 1px solid #e1e1e1fa;padding-left: 4px;"><b>Tindakan ICD9 : </b></div>

                                             <div class="border border-info bg-info" style="border: 1px solid #e1e1e1fa;padding-left: 4px;">Utama : </div>

                                             <div colspan="3" class="border border-top-0 border-info" style="padding-left: 4px;"><b>ICD9 : </b><?= $item->tindutama->kode ?? '' ?><br><b>ICD9 Deskripsi : </b><?= $item->tindutama->deskripsi ?? '-' ?><br><b>Deskripsi Dokter : </b><?= $item->tindakan_utama_deskripsi ?? '' ?></div>
                                             <div class="border border-info bg-info" style="border: 1px solid #e1e1e1fa;padding-left: 4px;">Tambahan I : </div>
                                             <div colspan="3" class="border border-top-0 border-info" style="padding-left: 4px;"><b>ICD9 : </b><?= $item->tindsatu->kode ?? '' ?><br><b>ICD9 Deskripsi : </b><?= $item->tindsatu->deskripsi ?? '-' ?><br><b>Deskripsi Dokter : </b><?= $item->tindakan_tambahan1_deskripsi ?? '' ?></div>

                                             <div class="border border-info bg-info" style="border: 1px solid #e1e1e1fa;padding-left: 4px;">Tambahan II : </div>
                                             <div colspan="3" class="border border-top-0 border-info" style="padding-left: 4px;"><b>ICD9 : </b><?= $item->tinddua->kode ?? '' ?><br><b>ICD9 Deskripsi : </b><?= $item->tinddua->deskripsi ?? '-' ?><br><b>Deskripsi Dokter : </b><?= $item->tindakan_tambahan2_deskripsi ?? '' ?></div>

                                             <div class="border border-info bg-info" style="border: 1px solid #e1e1e1fa;padding-left: 4px;">Tambahan III : <?= $item->tindtiga->kode ?? '' ?></div>
                                             <div colspan="3" class="border border-top-0 border-info" style="padding-left: 4px;"><b>ICD9 : </b><?= $item->tindtiga->kode ?? '' ?><br><b>ICD9 Deskripsi : </b><?= $item->tindtiga->deskripsi ?? '-' ?><br><b>Deskripsi Dokter : </b><?= $item->tindakan_tambahan3_deskripsi ?? '' ?></div>

                                             <div class="border border-info bg-info" style="border: 1px solid #e1e1e1fa;padding-left: 4px;">Tambahan IV : <?= $item->tindempat->kode ?? '' ?></div>
                                             <div colspan="3" class="border border-top-0 border-info" style="padding-left: 4px;"><b>ICD9 : </b><?= $item->tindempat->kode ?? '' ?><br><b>ICD9 Deskripsi : </b><?= $item->tindempat->deskripsi ?? '-' ?><br><b>Deskripsi Dokter : </b><?= $item->tindakan_tambahan4_deskripsi ?? '' ?></div>

                                             <div class="border border-info bg-info" style="border: 1px solid #e1e1e1fa;padding-left: 4px;">Tambahan V : <?= $item->tindlima->kode ?? '' ?></div>
                                             <div colspan="3" class="border border-top-0 border-info" style="padding-left: 4px;"><b>ICD9 : </b><?= $item->tindlima->kode ?? '' ?><br><b>ICD9 Deskripsi : </b><?= $item->tindlima->deskripsi ?? '-' ?><br><b>Deskripsi Dokter : </b><?= $item->tindakan_tambahan5_deskripsi ?? '' ?></div>
                                         </td>
                                         <td style="vertical-align: top;text-align: left;">
                                             <div class="btn-group-vertical">
                                                 <a class="btn btn-success btn-sm btn-preview-resume-verifikator-ri" href="<?= Url::to(['analisa-kuantitatif/preview-resume-medis', 'id' => $item['id']]) ?>" data-id="<?= $item['id'] ?>" data-pasien="<?= $registrasi['pasien']['kode'] ?>" data-nama="<?= $item['id'] ?>"> <i class="fa fa-eye"></i></i></a>
                                                 <a class="btn btn-info btn-sm" href="<?= Url::to(['analisa-kuantitatif/detail-dokter-verifikator-update', 'id' => $item['id'], 'registrasi_kode' => HelperGeneralClass::hashData($registrasi['kode'])]) ?>" data-id="<?= $item['id'] ?>" data-nama="<?= $item['id'] ?>"> <i class="fa fa-edit"></i></i></a>
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

                         <h5 style="margin-bottom:6px;">Resume Medis Rawat Inap Dokter Verifikator </h5>
                     </div>
                     <div class="card-body">
                         <div class="row">
                             <div class="col-sm-12">
                                 <?php
                                    //  print_r($model);
                                    //  die;

                                    $form = ActiveForm::begin([
                                        'id' => 'af-dokter-verifikator',
                                    ]); ?>
                                 <?= $form->field($model, 'registrasi_kode')->hiddenInput(['value' => $registrasi['kode']])->label(false); ?>

                                 <?= $form->field($model, 'id_resume_medis_ri')->hiddenInput(['value' => $_GET['id']])->label(false); ?>
                                 <?= $form->field($model, 'dokter_verifikator_id')->hiddenInput(['value' => HelperSpesialClass::getUserLogin()['pegawai_id']])->label(false); ?>
                                 <?= $form->field($model, 'layanan_id')->hiddenInput()->label(false); ?>
                                 <div class="row">
                                     <div class="col-sm-6">
                                         <div class="row">
                                             <div class="col-md-3">
                                                 <label>Dokter DPJP:</label>
                                             </div>
                                             <div class="col-md-9">
                                                 <?= $form->field($model, 'dokter_id')->widget(Select2::classname(), [
                                                        'data' => [HelperSpesialClass::getListDokter(false, true)],
                                                        'size' => 'xs',
                                                        'options' => ['class' => 'form-control input-sm', 'placeholder' => 'Pilih Dokter DPJP...', 'required' => true],
                                                        'value' => 1,
                                                        'pluginOptions' => [
                                                            'allowClear' => false,
                                                            'initialize' => true
                                                        ],
                                                    ])->label(false); ?>

                                             </div>
                                         </div>
                                     </div>
                                 </div>
                                 <div class="row">
                                     <div class="col-sm-6">
                                         <div class="row">
                                             <div class="col-md-3">
                                                 <label>Tanggal Pulang :</label>
                                             </div>
                                             <div class="col-md-9">
                                                 <?= $form->field($model, 'tgl_pulang')->widget(DatePicker::classname(), [
                                                        'type' => DatePicker::TYPE_INPUT,
                                                        'pluginOptions' => [
                                                            'autoclose' => true,
                                                            'format' => 'yyyy-mm-dd',
                                                            'value' => $model->tgl_pulang
                                                        ]
                                                    ])->label(false);
                                                    ?>
                                             </div>
                                         </div>
                                     </div>
                                 </div>
                                 <div class="row">
                                     <div class="col-sm-4">
                                         <label>Ringkasan Riwayat Penyakit :</label>
                                         <div class="row">
                                             <div class="col-md-12">
                                                 <?= $form->field($model, 'ringkasan_riwayat_penyakit')->textarea(array('rows' => 10))->label(false); ?>
                                             </div>
                                         </div>
                                     </div>
                                     <div class="col-sm-4">
                                         <label>Hasil Pemeriksaan Fisik Penting & Temuan Lainya :</label>
                                         <div class="row">
                                             <div class="col-md-12">
                                                 <?= $form->field($model, 'hasil_pemeriksaan_fisik')->textarea(array('rows' => 10))->label(false); ?>
                                             </div>
                                         </div>
                                     </div>
                                     <div class="col-sm-4">
                                         <label>Indikasi Rawat Inap :</label>
                                         <div class="row">
                                             <div class="col-md-12">
                                                 <?= $form->field($model, 'indikasi_rawat_inap')->textarea(array('rows' => 10))->label(false); ?>
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
                                 <div class="row">
                                     <div class="col-sm-2">
                                         <label>Diagnosa Masuk :</label>
                                     </div>
                                     <div class="col-sm-10">
                                         <div class="row">
                                             <div class="col-sm-6">
                                                 <?= $form->field($model, "diagnosa_masuk_deskripsi")->textInput(['placeholder' => 'Diagnosa Masuk'])->label(false) ?>
                                             </div>
                                             <div class="col-sm-6">
                                                 <?= $form->field($model, 'diagnosa_masuk_id')->widget(Select2::classname(), [
                                                        'initValueText' => ($model->diagmasuk) ? '(' . $model->diagmasuk->kode . ')' . $model->diagmasuk->deskripsi : null,
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
                                         <label>Diagnosa Utama :</label>
                                     </div>
                                     <div class="col-sm-10">
                                         <div class="row">
                                             <div class="col-sm-6">
                                                 <?= $form->field($model, "diagnosa_utama_deskripsi")->textInput(['placeholder' => 'Diagnosa Utama'])->label(false) ?>
                                             </div>
                                             <div class="col-sm-6">
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
                                         <label>Diagnosa Tambahan I :</label>
                                     </div>
                                     <div class="col-sm-10">
                                         <div class="row">
                                             <div class="col-sm-6">
                                                 <?= $form->field($model, "diagnosa_tambahan1_deskripsi")->textInput(['placeholder' => 'Diagnosa Tambahan I'])->label(false) ?>
                                             </div>
                                             <div class="col-sm-6">
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
                                         <label>Diagnosa Tambahan II :</label>
                                     </div>
                                     <div class="col-sm-10">
                                         <div class="row">
                                             <div class="col-sm-6">
                                                 <?= $form->field($model, "diagnosa_tambahan2_deskripsi")->textInput(['placeholder' => 'Diagnosa Tambahan II'])->label(false) ?>
                                             </div>
                                             <div class="col-sm-6">
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
                                         <label>Diagnosa Tambahan III :</label>
                                     </div>
                                     <div class="col-sm-10">
                                         <div class="row">
                                             <div class="col-sm-6">
                                                 <?= $form->field($model, "diagnosa_tambahan3_deskripsi")->textInput(['placeholder' => 'Diagnosa Tambahan III'])->label(false) ?>
                                             </div>
                                             <div class="col-sm-6">
                                                 <?= $form->field($model, 'diagnosa_tambahan3_id')->widget(Select2::classname(), [
                                                        'initValueText' => ($model->diagtiga) ? '(' . $model->diagtiga->kode . ')' . $model->diagtiga->deskripsi : null,
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
                                             <div class="col-sm-6">
                                                 <?= $form->field($model, "diagnosa_tambahan4_deskripsi")->textInput(['placeholder' => 'Diagnosa Tambahan IV'])->label(false) ?>
                                             </div>
                                             <div class="col-sm-6">
                                                 <?= $form->field($model, 'diagnosa_tambahan4_id')->widget(Select2::classname(), [
                                                        'initValueText' => ($model->diagempat) ? '(' . $model->diagempat->kode . ')' . $model->diagempat->deskripsi : null,
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
                                             <div class="col-sm-6">
                                                 <?= $form->field($model, "diagnosa_tambahan5_deskripsi")->textInput(['placeholder' => 'Diagnosa Tambahan V'])->label(false) ?>
                                             </div>
                                             <div class="col-sm-6">
                                                 <?= $form->field($model, 'diagnosa_tambahan5_id')->widget(Select2::classname(), [
                                                        'initValueText' => ($model->diaglima) ? '(' . $model->diaglima->kode . ')' . $model->diaglima->deskripsi : null,
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
                                         <label>Tindakan Utama :</label>
                                     </div>
                                     <div class="col-sm-10">
                                         <div class="row">
                                             <div class="col-sm-6">
                                                 <?= $form->field($model, "tindakan_utama_deskripsi")->textInput(['placeholder' => 'Tindakan Utama'])->label(false) ?>
                                             </div>
                                             <div class="col-sm-6">
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
                                         <label>Tindakan Tambahan I :</label>
                                     </div>
                                     <div class="col-sm-10">
                                         <div class="row">
                                             <div class="col-sm-6">
                                                 <?= $form->field($model, "tindakan_tambahan1_deskripsi")->textInput(['placeholder' => 'Tindakan Tambahan I'])->label(false) ?>
                                             </div>
                                             <div class="col-sm-6">
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
                                         <label>Tindakan Tambahan II :</label>
                                     </div>
                                     <div class="col-sm-10">
                                         <div class="row">
                                             <div class="col-sm-6">
                                                 <?= $form->field($model, "tindakan_tambahan2_deskripsi")->textInput(['placeholder' => 'Tindakan Tambahan II'])->label(false) ?>
                                             </div>
                                             <div class="col-sm-6">
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
                                         <label>Tindakan Tambahan III :</label>
                                     </div>
                                     <div class="col-sm-10">
                                         <div class="row">
                                             <div class="col-sm-6">
                                                 <?= $form->field($model, "tindakan_tambahan3_deskripsi")->textInput(['placeholder' => 'Tindakan Tambahan III'])->label(false) ?>
                                             </div>
                                             <div class="col-sm-6">
                                                 <?= $form->field($model, 'tindakan_tambahan3_id')->widget(Select2::classname(), [
                                                        'initValueText' => ($model->tindtiga) ? '(' . $model->tindtiga->kode . ')' . $model->tindtiga->deskripsi : null,
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
                                             <div class="col-sm-6">
                                                 <?= $form->field($model, "tindakan_tambahan4_deskripsi")->textInput(['placeholder' => 'Tindakan Tambahan IV'])->label(false) ?>
                                             </div>
                                             <div class="col-sm-6">
                                                 <?= $form->field($model, 'tindakan_tambahan4_id')->widget(Select2::classname(), [
                                                        'initValueText' => ($model->tindempat) ? '(' . $model->tindempat->kode . ')' . $model->tindempat->deskripsi : null,
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
                                             <div class="col-sm-6">
                                                 <?= $form->field($model, "tindakan_tambahan5_deskripsi")->textInput(['placeholder' => 'Tindakan Tambahan V'])->label(false) ?>
                                             </div>
                                             <div class="col-sm-6">
                                                 <?= $form->field($model, 'tindakan_tambahan5_id')->widget(Select2::classname(), [
                                                        'initValueText' => ($model->tindlima) ? '(' . $model->tindlima->kode . ')' . $model->tindlima->deskripsi : null,
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
                                     <div class="col-sm-12">
                                         <label>Alergi :</label>
                                         <div class="row">
                                             <div class="col-md-2">
                                                 <?php
                                                    $alergi = ['Tidak Ada' => 'Tidak Ada'];
                                                    echo $form->field($model, 'alergi')->inline(true)->radioList($alergi)->label(false);
                                                    ?>
                                             </div>
                                             <div class="col-md-10">
                                                 <div class="form-group">
                                                     <div class="input-group">
                                                         <div class="input-group-prepend">
                                                             <div class="input-group-text">
                                                                 <input value="<?= (!in_array($model->alergi, $alergi) && !empty($model->alergi)) ? $model->alergi : null ?>" <?= (!in_array($model->alergi, $alergi) && !empty($model->alergi)) ? 'checked' : null ?> type="radio" id="ResumeMedisRi_alergi_2" name="ResumeMedisRiClaim[alergi]">
                                                             </div>
                                                         </div>
                                                         <textarea rows="3" id="ResumeMedisRi_alergi_2_t" class="form-control" placeholder="Sebutkan Jika Ada"><?= (!in_array($model->alergi, $alergi) && !empty($model->alergi)) ? $model->alergi : null ?></textarea>
                                                     </div>
                                                 </div>
                                             </div>
                                         </div>
                                         <label>Diet :</label>
                                         <div class="row">
                                             <div class="col-md-2">
                                                 <?php
                                                    $diet = ['Tidak Ada' => 'Tidak Ada'];
                                                    echo $form->field($model, 'diet')->inline(true)->radioList($diet)->label(false);
                                                    ?>
                                             </div>
                                             <div class="col-md-10">
                                                 <div class="form-group">
                                                     <div class="input-group">
                                                         <div class="input-group-prepend">
                                                             <div class="input-group-text">
                                                                 <input value="<?= (!in_array($model->diet, $diet) && !empty($model->diet)) ? $model->diet : null ?>" <?= (!in_array($model->diet, $diet) && !empty($model->diet)) ? 'checked' : null ?> type="radio" id="ResumeMedisRi_diet_2" name="ResumeMedisRiClaim[diet]">
                                                             </div>
                                                         </div>
                                                         <textarea rows="3" id="ResumeMedisRi_diet_2_t" class="form-control" placeholder="Sebutkan Jika Ada"><?= (!in_array($model->diet, $diet) && !empty($model->diet)) ? $model->diet : null ?></textarea>
                                                     </div>
                                                 </div>
                                             </div>
                                         </div>
                                     </div>
                                 </div>
                                 <div class="row">
                                     <div class="col-sm-12">
                                         <label>Alasan Pulang :</label>
                                         <?php
                                            $alasan_pulang = ['Dengan Persetujuan Dokter' => 'Dengan Persetujuan Dokter', 'Permintaan Sendiri/Keluarga' => 'Permintaan Sendiri/Keluarga', 'Pindah RS Lain' => 'Pindah RS Lain', 'Meninggal' => 'Meninggal'];
                                            echo $form->field($model, 'alasan_pulang')->inline(true)->radioList($alasan_pulang)->label(false);
                                            ?>
                                     </div>
                                 </div>
                                 <div class="row">
                                     <div class="col-sm-12">
                                         <label>Kondisi Saat Pulang :</label>
                                         <div class="row">
                                             <div class="col-md-6">
                                                 <?php
                                                    $kondisi_pulang = ['Sembuh' => 'Sembuh', 'Meninggal < 24 Jam' => 'Meninggal < 24 Jam', 'Meninggal > 24 Jam' => 'Meninggal > 24 Jam'];
                                                    echo $form->field($model, 'kondisi_pulang')->inline(true)->radioList($kondisi_pulang)->label(false);
                                                    ?>
                                             </div>
                                             <div class="col-md-6">
                                                 <div class="form-group">
                                                     <div class="input-group">
                                                         <div class="input-group-prepend">
                                                             <div class="input-group-text">
                                                                 <input value="<?= (!in_array($model->kondisi_pulang, $kondisi_pulang) && !empty($model->kondisi_pulang)) ? $model->kondisi_pulang : null ?>" <?= (!in_array($model->kondisi_pulang, $kondisi_pulang) && !empty($model->kondisi_pulang)) ? 'checked' : null ?> type="radio" id="<?= $model->formName() ?>_kondisi_pulang_4" name="<?= $model->formName() ?>[kondisi_pulang]">
                                                             </div>
                                                         </div>
                                                         <input value="<?= (!in_array($model->kondisi_pulang, $kondisi_pulang) && !empty($model->kondisi_pulang)) ? $model->kondisi_pulang : null ?>" type="text" id="<?= $model->formName() ?>_kondisi_pulang_4_t" class="form-control" placeholder="Jika Lain-lain">
                                                     </div>
                                                 </div>
                                             </div>
                                         </div>
                                     </div>
                                 </div>
                                 <div class="row">
                                     <div class="col-sm-12">
                                         <label>Cara Pulang :</label>
                                         <div class="row">
                                             <div class="col-md-6">
                                                 <?php
                                                    $cara_pulang = ['Brankart' => 'Brankart', 'Kursi Roda' => 'Kursi Roda', 'Ambulasi' => 'Ambulasi'];
                                                    echo $form->field($model, 'cara_pulang')->inline(true)->radioList($cara_pulang)->label(false);
                                                    ?>
                                             </div>
                                             <div class="col-md-6">
                                                 <div class="form-group">
                                                     <div class="input-group">
                                                         <div class="input-group-prepend">
                                                             <div class="input-group-text">
                                                                 <input value="<?= (!in_array($model->cara_pulang, $cara_pulang) && !empty($model->cara_pulang)) ? $model->cara_pulang : null ?>" <?= (!in_array($model->cara_pulang, $cara_pulang) && !empty($model->cara_pulang)) ? 'checked' : null ?> type="radio" id="<?= $model->formName() ?>_cara_pulang_4" name="<?= $model->formName() ?>[cara_pulang]">
                                                             </div>
                                                         </div>
                                                         <input value="<?= (!in_array($model->cara_pulang, $cara_pulang) && !empty($model->cara_pulang)) ? $model->cara_pulang : null ?>" type="text" id="<?= $model->formName() ?>_cara_pulang_4_t" class="form-control" placeholder="Jika Lain-lain">
                                                     </div>
                                                 </div>
                                             </div>
                                         </div>
                                     </div>
                                 </div>
                                 <div class="row">
                                     <div class="col-md-1">
                                         <label>GCS E :</label>
                                         <?= $form->field($model, "gcs_e")->textInput(['type' => 'number'])->label(false) ?>
                                     </div>
                                     <div class="col-md-1">
                                         <label>GCS M :</label>
                                         <?= $form->field($model, "gcs_m")->textInput(['type' => 'number'])->label(false) ?>
                                     </div>
                                     <div class="col-md-1">
                                         <label>GCS V :</label>
                                         <?= $form->field($model, "gcs_v")->textInput(['type' => 'number'])->label(false) ?>
                                     </div>
                                     <div class="col-md-2">
                                         <label>Nadi(x/menit) :</label>
                                         <?= $form->field($model, "nadi")->textInput(['type' => 'text'])->label(false) ?>
                                     </div>
                                     <div class="col-md-2">
                                         <label>TD(mmHg) :</label>
                                         <?= $form->field($model, "darah")->textInput(['type' => 'text'])->label(false) ?>
                                     </div>
                                     <div class="col-md-2">
                                         <label>Pernapasan(x/menit) :</label>
                                         <?= $form->field($model, "pernapasan")->textInput(['type' => 'text'])->label(false) ?>
                                     </div>
                                     <div class="col-md-1">
                                         <label>Suhu(C) :</label>
                                         <?= $form->field($model, "suhu")->textInput(['type' => 'text'])->label(false) ?>
                                     </div>
                                     <div class="col-md-1">
                                         <label>SatO2(%) :</label>
                                         <?= $form->field($model, "sato2")->textInput(['type' => 'text'])->label(false) ?>
                                     </div>
                                     <div class="col-md-1">
                                         <label>BB(Kg) :</label>
                                         <?= $form->field($model, "berat_badan")->textInput(['type' => 'text'])->label(false) ?>
                                     </div>
                                 </div>
                                 <div class="row">
                                     <div class="col-md-1">
                                         <label>TB(Cm) :</label>
                                         <?= $form->field($model, "tinggi_badan")->textInput(['type' => 'text'])->label(false) ?>
                                     </div>
                                     <div class="col-md-3">
                                         <label>Keadaan Gizi :</label>
                                         <?php
                                            $keadaan_gizi = ['Baik' => 'Baik', 'Sedang' => 'Sedang', 'Kurang' => 'Kurang'];
                                            echo $form->field($model, 'keadaan_gizi')->inline(true)->radioList($keadaan_gizi)->label(false);
                                            ?>
                                     </div>
                                     <div class="col-md-3">
                                         <label>Keadaan Umum :</label>
                                         <?php
                                            $keadaan_umum = ['Baik' => 'Baik', 'Sedang' => 'Sedang', 'Buruk' => 'Buruk'];
                                            echo $form->field($model, 'keadaan_umum')->inline(true)->radioList($keadaan_umum)->label(false);
                                            ?>
                                     </div>
                                     <div class="col-md-5">
                                         <label>Tingkat Kesadaran :</label>
                                         <?php
                                            $tingkat_kesadaran = ['Compos Mentis' => 'Compos Mentis', 'Apatis' => 'Apatis', 'Somnolent' => 'Somnolent', 'Delirium' => 'Delirium', 'Soporo Coma' => 'Soporo Coma', 'Coma' => 'Coma'];
                                            echo $form->field($model, 'tingkat_kesadaran')->inline(true)->radioList($tingkat_kesadaran)->label(false);
                                            ?>
                                     </div>
                                 </div>
                                 <div class="row">
                                     <div class="col-sm-12">
                                         <label>Obat Rumah :</label>
                                         <div class="row">
                                             <div class="col-md-3">
                                                 <?php
                                                    $obat_rumah = ['Tidak Ada' => 'Tidak Ada'];
                                                    echo $form->field($model, 'obat_rumah')->inline(true)->radioList($obat_rumah)->label(false);
                                                    ?>
                                             </div>
                                             <div class="col-md-9">
                                                 <div class="form-group">
                                                     <div class="input-group">
                                                         <div class="input-group-prepend">
                                                             <div class="input-group-text">
                                                                 <input value="<?= (!in_array($model->obat_rumah, $obat_rumah) && !empty($model->obat_rumah)) ? $model->obat_rumah : null ?>" <?= (!in_array($model->obat_rumah, $obat_rumah) && !empty($model->obat_rumah)) ? 'checked' : null ?> type="radio" id="<?= $model->formName() ?>_obat_rumah_2" name="<?= $model->formName() ?>[obat_rumah]">
                                                             </div>
                                                         </div>
                                                         <textarea rows="10" id="<?= $model->formName() ?>_obat_rumah_2_t" class="form-control" placeholder="Sebutkan Jika Ada"><?= (!in_array($model->obat_rumah, $obat_rumah) && !empty($model->obat_rumah)) ? $model->obat_rumah : null ?></textarea>
                                                     </div>
                                                 </div>
                                             </div>
                                         </div>
                                     </div>
                                 </div>
                                 <div class="row">
                                     <div class="col-sm-12">
                                         <label>Terapi Pulang :</label>
                                         <div class="row">
                                             <div class="col-md-3">
                                                 <?php
                                                    $terapi_pulang = ['Tidak Ada' => 'Tidak Ada'];
                                                    echo $form->field($model, 'terapi_pulang')->inline(true)->radioList($terapi_pulang)->label(false);
                                                    ?>
                                             </div>
                                             <div class="col-md-9">
                                                 <div class="form-group">
                                                     <div class="input-group">
                                                         <div class="input-group-prepend">
                                                             <div class="input-group-text">
                                                                 <input value="<?= (!in_array($model->terapi_pulang, $terapi_pulang) && !empty($model->terapi_pulang)) ? $model->terapi_pulang : null ?>" <?= (!in_array($model->terapi_pulang, $terapi_pulang) && !empty($model->terapi_pulang)) ? 'checked' : null ?> type="radio" id="<?= $model->formName() ?>_terapi_pulang_2" name="<?= $model->formName() ?>[terapi_pulang]">
                                                             </div>
                                                         </div>
                                                         <textarea rows="10" id="<?= $model->formName() ?>_terapi_pulang_2_t" class="form-control" placeholder="Sebutkan Jika Ada"><?= (!in_array($model->terapi_pulang, $terapi_pulang) && !empty($model->terapi_pulang)) ? $model->terapi_pulang : null ?></textarea>
                                                     </div>
                                                 </div>
                                             </div>
                                         </div>
                                     </div>
                                 </div>
                                 <div class="row">
                                     <div class="col-sm-4">
                                         <label>Tanggal Kontrol Poliklinik :</label>
                                         <div class="row">
                                             <div class="col-md-12">
                                                 <?= $form->field($model, 'tgl_kontrol')->widget(DatePicker::classname(), [
                                                        'type' => DatePicker::TYPE_INPUT,
                                                        'pluginOptions' => [
                                                            'autoclose' => true,
                                                            'format' => 'yyyy-mm-dd',
                                                            'value' => $model->tgl_kontrol
                                                        ]
                                                    ])->label(false);
                                                    ?>
                                             </div>
                                         </div>
                                     </div>
                                     <div class="col-sm-4">
                                         <label>Poliklinik Tujuan Kontrol :</label>
                                         <div class="row">
                                             <div class="col-md-12">
                                                 <?= $form->field($model, 'poli_tujuan_kontrol_id')->widget(Select2::classname(), [
                                                        'data' => HelperSpesialClass::getListUnitLayanan(KelompokUnitLayanan::RJ, false, true),
                                                        'size' => 'xs',
                                                        'options' => ['class' => 'form-control input-sm', 'placeholder' => 'Pilih Poliklinik Tujuan Kontrol...'],
                                                        'pluginOptions' => [
                                                            'allowClear' => false
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
                             <?= Html::submitButton('Simpan Resume Verifikator', ['class' => 'btn btn-success btn-block mb-2 rounded-0', 'id' => 'btn-icd-10-laporan-simpan']) ?>
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
