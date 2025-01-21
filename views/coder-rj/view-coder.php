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
        url:'" . Url::to(['pelaporan-icd-10-save']) . "',
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

$('#icd9-CodingPelaporan').on('beforeSubmit',function(e){
   
    e.preventDefault();
    var btn=$('.btn-submit');
    var htm=btn.html();
    $('body').addClass('loading');
    $('#btn-loading-analisa').attr('style', 'display: block')
    $.ajax({
        url:'" . Url::to(['pelaporan-icd-9-save']) . "',
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


$('.btn-preview-resume-rj').click(function(e){
	e.preventDefault();
	var id=$(this).attr('data-id');
    var pasien=$(this).attr('data-pasien');
	if(id){
		$.post('" . Url::to(['preview-resume-medis']) . "',{id:id,pasien:pasien},function(res){
			$('.mymodal_card_xl_body').html(res);
            $('.mymodal_card_xl').modal('show');
		});
	}
});

");
?>


<div class="card card-primary card-outline">

    <div class="card-header">
        <h5 class="card-title m-0"> ICD-10 & ICD-9 UNTUK LAPORAN SERTA CLAIM</h5>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-lg-4">
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <h5 style="margin-bottom:6px;"><b>Silahkan Pilih Salah Satu Resume Medis</b></h5>
                    </div>
                    <div class="card-body">

                        <table style="width:100%">
                            <?php
                            if (!empty($listResumeMedisDokter)) {
                                foreach ($listResumeMedisDokter as $item) {
                            ?>
                                    <tr>
                                        <td><?php
                                            if (!empty($listCoder->id_resume_medis_rj)) {
                                                if ($item->id == $listCoder->id_resume_medis_rj) {
                                                    $status_coder = '<div class="border border-info bg-danger" style="border: 1px solid #e1e1e1fa;padding-left: 4px;"><b>Terpilih Untuk Coding</b></div>';
                                                } else {
                                                    $status_coder = '';
                                                }
                                            } else {
                                                $status_coder = '';
                                            }
                                            ?>


                                            <?= $status_coder; ?>
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
                                                <a class="btn btn-success btn-sm btn-preview-resume-rj" data-id="<?= $item['id'] ?>" data-pasien="<?= $registrasi['pasien']['kode'] ?>" data-nama="<?= $item['id'] ?>"> <i style="color:white" class="fa fa-eye"></i></i></a>
                                                <a class="btn btn-info btn-sm" href="<?= Url::to(['/coder-rj/pelaporan', 'id' => $item['id'], 'icd' => true, 'registrasi_kode' => HelperGeneralClass::hashData($registrasi['kode'])]) ?>" data-id="<?= $item['id'] ?>" data-nama="<?= $item['id'] ?>"> <i style="color:white" class="fa fa-edit"></i></i></a>
                                            </div>
                                        </td>
                                        <td style="vertical-align: top;text-align: left;">
                                            <div class="btn-group-vertical">

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
                        <h5 style="margin-bottom:6px;">Hasil Coding Dari Coder</h5>

                    </div>
                    <div class="card-body">

                        <table>

                            <?php
                            if (!empty($listCoder)) {
                            ?><tr>
                                    <td>
                                        <div class="border border-info bg-danger" style="border: 1px solid #e1e1e1fa;padding-left: 4px;">Nama Dokter : <?= HelperSpesialClass::getNamaPegawaiArray($listCoder->resumeMedis->dokter) ?? '' ?><br>(Resume id: <?= $listCoder->id_resume_medis_rj ?? '' ?>)<br><b>Nama Coder : </b><?= HelperSpesialClass::getNamaPegawaiArray($listCoder->coder) ?? '' ?><br></div>
                                        <div colspan="3" class="border border-top-0 border-info" style="padding-left: 4px;"><b>Anamenesis : </b><?= $listCoder->resumeMedis->anamesis ?? '' ?></div>
                                        <div colspan="3" class="border border-top-0 border-info" style="padding-left: 4px;"><b>Pemeriksaan Fisik : </b><?= $listCoder->resumeMedis->pemeriksaan_fisik ?? '' ?></div>

                                        <div colspan="3" class="border border-top-0 border-info" style="padding-left: 4px;"><b>Diagnosa : </b><?= $listCoder->resumeMedis->diagnosa ?? '' ?></div>

                                        <div class="border border-warning bg-warning font-weight-bold" style="border: 1px solid #e1e1e1fa;padding-left: 4px;">Diagnosa ICD10:</div>

                                        <?php foreach ($listCoder->pelaporanDiagnosa as $key => $item) {
                                        ?> <?php if ($item->id) { ?>

                                                <div class="border border-info bg-info" style="border: 1px solid #e1e1e1fa;padding-left: 4px;"><b>Diagnosa <?= ($key + 1) ?>:</b> <?= $item->diagnosa->kode ?? '' ?> (<?= $item->diagnosa->deskripsi ?? '' ?>) - <b><?= $item->utama == 1 ? 'Utama' : 'Tambahan' ?></b></div>


                                            <?php } ?>
                                        <?php } ?>

                                        <div colspan="3" class="border border-info border-info" style="padding-left: 4px;"><b>Tindakan : </b><?= $listCoder->resumeMedis->tindakan ?? '' ?></div>

                                        <div class="border border-warning bg-warning" style="border: 1px solid #e1e1e1fa;padding-left: 4px;"><b>Tindakan ICD9 : </b></div>
                                        <?php foreach ($listCoder->pelaporanTindakan as $key => $item) {
                                        ?> <?php if ($item->id) { ?>

                                                <div class="border border-info bg-info" style="border: 1px solid #e1e1e1fa;padding-left: 4px;"><b>Tindakan <?= ($key + 1) ?>:</b> <?= $item->tindakan->kode ?? '' ?> (<?= $item->tindakan->deskripsi ?? '' ?>)</div>


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
                <div class="card card-primary card-outline card-outline-tabs">

                    <div class="card-header">
                        <h5 style="margin-bottom:6px;">RESUME BELUM DIPILIH </h5>
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