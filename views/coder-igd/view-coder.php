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


$('.btn-preview-ringkasan-pulang-igd').click(function(e){
	e.preventDefault();
	var id=$(this).attr('data-id');
    var pasien=$(this).attr('data-pasien');
	if(id){
		$.post('" . Url::to(['preview-ringkasan-pulang-igd']) . "',{id:id,pasien:pasien},function(res){
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
                        <h5 style="margin-bottom:6px;"><b>Silahkan Pilih Salah Satu Ringkasan Pulang IGD</b></h5>
                    </div>
                    <div class="card-body">

                        <table style="width:100%">
                            <?php
                            if (!empty($listRingkasanPulangIgd)) {
                                foreach ($listRingkasanPulangIgd as $item) {
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
                                            <div colspan="3" class="border border-top-0 border-info" style="padding-left: 4px;"><b>Indikasi Masuk IGD : </b><?= $item->indikasi_masuk ?? '-' ?></div>
                                            <div colspan="3" class="border border-top-0 border-info" style="padding-left: 4px;"><b>Keluhan Utama : </b><?= $item->keluhan_utama ?? '' ?></div>
                                            <div colspan="3" class="border border-top-0 border-info" style="padding-left: 4px;"><b>Diagnosa Kerja : </b><?= $item->diagnosa_kerja ?? '' ?></div>
                                            <div colspan="3" class="border border-top-0 border-info" style="padding-left: 4px;"><b>Diagnosa Banding : </b><?= $item->diagnosa_banding ?? '' ?></div>
                                            <div colspan="3" class="border border-top-0 border-info" style="padding-left: 4px;"><b>Tindakan/Prosedur : </b><?= $item->tindakan ?? '' ?></div>



                                        </td>
                                        <td style="vertical-align: top;text-align: left;">
                                            <div class="btn-group-vertical">
                                                <a class="btn btn-success btn-sm btn-preview-ringkasan-pulang-igd" data-id="<?= $item['id'] ?>" data-pasien="<?= $registrasi['pasien']['kode'] ?>" data-nama="<?= $item['id'] ?>"> <i style="color:white" class="fa fa-eye"></i></i></a>
                                                <a class="btn btn-info btn-sm" href="<?= Url::to(['/coder-igd/pelaporan', 'id' => $item['id'], 'icd' => true, 'registrasi_kode' => HelperGeneralClass::hashData($registrasi['kode'])]) ?>" data-id="<?= $item['id'] ?>" data-nama="<?= $item['id'] ?>"> <i style="color:white" class="fa fa-edit"></i></i></a>
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
                                        <div class="border border-info bg-danger" style="border: 1px solid #e1e1e1fa;padding-left: 4px;">Nama Dokter : <?= HelperSpesialClass::getNamaPegawaiArray($listCoder->ringkasanPulangIgd->dokter) ?? '' ?><br>(Resume id: <?= $listCoder->id_resume_medis_rj ?? '' ?>)<br><b>Nama Coder : </b><?= HelperSpesialClass::getNamaPegawaiArray($listCoder->coder) ?? '' ?><br></div>
                                        <div colspan="3" class="border border-top-0 border-info" style="padding-left: 4px;"><b>Anamenesis : </b><?= $listCoder->ringkasanPulangIgd->anamesis ?? '' ?></div>
                                        <div colspan="3" class="border border-top-0 border-info" style="padding-left: 4px;"><b>Pemeriksaan Fisik : </b><?= $listCoder->ringkasanPulangIgd->pemeriksaan_fisik ?? '' ?></div>

                                        <div colspan="3" class="border border-top-0 border-info" style="padding-left: 4px;"><b>Diagnosa : </b><?= $listCoder->ringkasanPulangIgd->diagnosa ?? '' ?></div>

                                        <div class="border border-warning bg-warning font-weight-bold" style="border: 1px solid #e1e1e1fa;padding-left: 4px;">Diagnosa ICD10:</div>

                                        <?php foreach ($listCoder->pelaporanDiagnosa as $key => $item) {
                                        ?> <?php if ($item->id) { ?>

                                                <div class="border border-info bg-info" style="border: 1px solid #e1e1e1fa;padding-left: 4px;"><b>Diagnosa <?= ($key + 1) ?>:</b> <?= $item->diagnosa->kode ?? '' ?> (<?= $item->diagnosa->deskripsi ?? '' ?>) - <b><?= $item->utama == 1 ? 'Utama' : 'Tambahan' ?></b></div>


                                            <?php } ?>
                                        <?php } ?>

                                        <div colspan="3" class="border border-info border-info" style="padding-left: 4px;"><b>Tindakan : </b><?= $listCoder->ringkasanPulangIgd->tindakan ?? '' ?></div>

                                        <div class="border border-warning bg-warning" style="border: 1px solid #e1e1e1fa;padding-left: 4px;"><b>Tindakan ICD9 : </b></div>
                                        <?php foreach ($listCoder->pelaporanTindakan as $key => $item) {
                                        ?> <?php if ($item->id) { ?>

                                                <div class="border border-info bg-info" style="border: 1px solid #e1e1e1fa;padding-left: 4px;"><b>Tindakan <?= ($key + 1) ?>:</b> <?= $item->tindakan->kode ?? '' ?> (<?= $item->tindakan->deskripsi ?? '' ?>)</div>


                                            <?php } ?>
                                        <?php } ?>

                                        <div colspan="3" class="border border-top-0 border-info" style="padding-left: 4px;"><b>Terapi : </b><?= $listCoder->ringkasanPulangIgd->terapi ?? '' ?></div>
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