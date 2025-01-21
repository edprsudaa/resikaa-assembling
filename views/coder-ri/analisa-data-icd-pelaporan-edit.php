<?php

use app\components\DynamicFormWidget;
use app\components\HelperGeneralClass;
use app\components\HelperSpesialClass;
use app\models\pegawai\DmUnitPenempatan;
use kartik\select2\Select2;
use yii\bootstrap4\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\JsExpression;

$this->registerJs("
$('#af-CodingPelaporanRi').on('beforeSubmit',function(e){
   
    e.preventDefault();
    var btn=$('.btn-submit');
    var htm=btn.html();
    $('body').addClass('loading');
    $('#btn-loading-analisa').attr('style', 'display: block')
    $.ajax({
        url:'" . Url::to(['coding-pelaporan-icd-10-save']) . "',
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

$('#af-CodingClaim').on('beforeSubmit',function(e){
   
    e.preventDefault();
    var btn=$('.btn-submit');
    var htm=btn.html();
    $('body').addClass('loading');
    $('#btn-loading-analisa').attr('style', 'display: block')
    $.ajax({
        url:'" . Url::to(['claim-icd-10-save']) . "',
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
//             // App.Error(error);
//             // App.ResetLoadingBtn(btn,htm);
        }
    });
}).submit(function(e){
    e.preventDefault();
});

$('#icd9-CodingPelaporanRi').on('beforeSubmit',function(e){
   
    e.preventDefault();
    var btn=$('.btn-submit');
    var htm=btn.html();
    $('body').addClass('loading');
    $('#btn-loading-analisa').attr('style', 'display: block')
    $.ajax({
        url:'" . Url::to(['coding-pelaporan-icd-9-save']) . "',
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

$('#icd9-CodingClaim').on('beforeSubmit',function(e){
   
    e.preventDefault();
    var btn=$('.btn-submit');
    var htm=btn.html();
    $('body').addClass('loading');
    $('#btn-loading-analisa').attr('style', 'display: block')
    $.ajax({
        url:'" . Url::to(['claim-icd-9-save']) . "',
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

    <div class="card-header">
        <h5 class="card-title m-0"> ICD-10 & ICD-9 UNTUK LAPORAN</h5>
    </div>
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
                                                <a class="btn btn-success btn-md btn-lihat-operasi" href="<?= Url::to(['/analisa-kuantitatif/preview-resume-medis', 'id' => $item['id']]) ?>" data-id="<?= $item['id'] ?>" data-nama="<?= $item['id'] ?>"> <i style="color:white" class="fa fa-eye"></i></i></a>
                                                <a class="btn btn-info btn-md" href="<?= Url::to(['/analisa-kuantitatif/detail-coder-pelaporan-edit', 'id' => $item['id'], 'icd' => true, 'registrasi_kode' => HelperGeneralClass::hashData($registrasi['kode'])]) ?>" data-id="<?= $item['id'] ?>" data-nama="<?= $item['id'] ?>"> <i style="color:white" class="fa fa-edit"></i></i></a>
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
                                                <a class="btn btn-success btn-md btn-preview-resume-verifikator-ri" href="<?= Url::to(['/analisa-kuantitatif/preview-resume-medis', 'id' => $item['id']]) ?>" data-id="<?= $item['id'] ?>" data-pasien="<?= $registrasi['pasien']['kode'] ?>" data-nama="<?= $item['id'] ?>"> <i style="color:white" class="fa fa-eye"></i></i></a>
                                                <a class="btn btn-warning btn-md" target="_blank" href="<?= Url::to(['/analisa-kuantitatif/cetak-resume-medis-dokter-verifikator-ri', 'id' => $item['id'], 'pasien' => $registrasi['pasien']['kode']]) ?>" data-id="<?= $item['id'] ?>" data-pasien="<?= $registrasi['pasien']['kode'] ?>" data-nama="<?= $item['id'] ?>"> <i class="fa fa-print"></i></i></a>
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
                        <h5 style="margin-bottom:6px;">Coding Pelaporan <a class="btn btn-danger" href="<?= Url::to(['/analisa-kuantitatif/detail-coder-claim', 'id' => HelperGeneralClass::hashData($registrasi['kode']), 'icd' => true]) ?>"><i style="color: white;" class="fa fa-edit"></i> Buat Coding Klaim</a></h5>
                    </div>
                    <div class="card-body">
                        <div class="tab-content" id="custom-tabs-four-tabContent">
                            <div class="tab-pane fade active show" id="custom-tabs-four-home" role="tabpanel" aria-labelledby="custom-tabs-four-home-tab">

                                <?php $form = ActiveForm::begin([
                                    'id' => 'af-' . $modelCustomer->formName(),
                                    'options' => [
                                        'name' => 'af-' . $modelCustomer->formName(),
                                        'data-pjax' => true
                                    ],
                                ]); ?>
                                <?= $form->field($modelCustomer, 'id_resume_medis_ri')->hiddenInput(['value' => $model->id])->label(false) ?>

                                <?= $form->field($modelCustomer, 'registrasi_kode')->hiddenInput(['maxlength' => true, 'value' => $registrasi['kode']])->label(false) ?>
                                <?= $form->field($modelCustomer, 'jenis_layanan')->hiddenInput(['maxlength' => true, 'value' => 3])->label(false) ?>
                                <?= $form->field($modelCustomer, 'pegawai_coder_id')->hiddenInput(['maxlength' => true, 'value' => HelperSpesialClass::getUserLogin()['pegawai_id']])->label(false) ?>

                                <div class="panel-heading">
                                    <h6 class="mb-2 text-uppercase bg-light p-2"><i class="fas fa-archive mr-3"></i>I. ICD-10 Laporan (Resume id: <?= $model->id ?? '' ?> ) </h6>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <?php DynamicFormWidget::begin([
                                            'widgetContainer' => 'dynamicform_wrapper',
                                            'widgetBody' => '.form-options-body',
                                            'widgetItem' => '.form-options-item',
                                            'min' => 1,
                                            'insertButton' => '.add-item',
                                            'deleteButton' => '.delete-item',
                                            'model' => $modelsAddress[0],
                                            'formId' => 'af-' . $modelCustomer->formName(),
                                            'formFields' => [
                                                'id',
                                                'icd10_id',
                                                'jumlah',
                                                'dosis',
                                                'catatan',
                                            ],
                                        ]); ?>
                                        <table class="table-list-item table table-bordered table-responsive">
                                            <thead class="thead-light" style="text-align: center;">
                                                <th style="width: 98%">Diagnosa</th>

                                                <th style="width: 2%"></th>
                                            </thead>
                                            <tbody class="form-options-body">

                                                <?php foreach ($modelsAddress as $i => $modelDetail) : ?>
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
                                        <?= Html::submitButton('Simpan ICD-10 Claim', ['class' => 'btn btn-success btn-block mb-2 rounded-0', 'id' => 'btn-icd-10-claim-simpan']) ?>

                                    </div>
                                </div>

                                <?php ActiveForm::end(); ?>
                                <?php $form = ActiveForm::begin([
                                    'id' => 'icd9-' . $modelCustomer->formName(),
                                    'options' => [
                                        'name' => 'icd9-' . $modelCustomer->formName(),
                                        'data-pjax' => true
                                    ],
                                ]); ?>
                                <?= $form->field($modelCustomer, 'id_resume_medis_ri')->hiddenInput(['value' => $model->id])->label(false) ?>

                                <?= $form->field($modelCustomer, 'registrasi_kode')->hiddenInput(['maxlength' => true, 'value' => $registrasi['kode']])->label(false) ?>
                                <?= $form->field($modelCustomer, 'jenis_layanan')->hiddenInput(['maxlength' => true, 'value' => 3])->label(false) ?>
                                <?= $form->field($modelCustomer, 'pegawai_coder_id')->hiddenInput(['maxlength' => true, 'value' => HelperSpesialClass::getUserLogin()['pegawai_id']])->label(false) ?>
                                <div class="panel-heading">
                                    <h6 class="mb-2 text-uppercase bg-light p-2"><i class="fas fa-archive mr-3"></i>II. ICD-9 Laporan (Resume id: <?= $model->id ?? '' ?> )</h6>
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
                                            'model' => $modelsIcd9[0],
                                            'formId' => 'icd9-' . $modelCustomer->formName(),
                                            'formFields' => [
                                                'id',
                                                'icd9_id',

                                            ],
                                        ]); ?>
                                        <table class="table-list-item table table-bordered table-responsive" style="width: 100%;">
                                            <thead class="thead-light" style="text-align: center;">
                                                <th style="width: 98%">Diagnosa</th>

                                                <th style="width: 2%"></th>
                                            </thead>
                                            <tbody class="form-options-bodys">

                                                <?php foreach ($modelsIcd9 as $i => $modelDetail) : ?>
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
                                        <?= Html::submitButton('Simpan ICD-10 Claim', ['class' => 'btn btn-success btn-block mb-2 rounded-0', 'id' => 'btn-icd-10-claim-simpan']) ?>

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

</div>

<div class="card-footer">
    <div class="col-sm-2">
        <button class="btn btn-outline-info">Kembali</button>
    </div>
</div>