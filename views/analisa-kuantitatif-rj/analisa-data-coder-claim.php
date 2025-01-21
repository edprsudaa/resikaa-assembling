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
     $('#af-dokter-verifikator').on('beforeSubmit',function(e){
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
                         analisa_kuantitatif_controller+'list-checkout'
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
    $this->registerJs("
$('.btn-lihat').on('click', function() {
    var id=$(this).data('id');
    $.get(baseUrl+'/analisa-kuantitatif/preview-doc-clinical?id='+id, function(d){
        if(d.status){
            $('.mymodal_card_xl_body').html(d.data.data);
            $('.mymodal_card_xl').modal('show');
        }else{
            fmsg.w(d.msg);
        }
    });
});

$('.btn-lihat-asesmen').on('click', function (){
    $.get($(this).attr('href'), function(data) {
        $('.mymodal_card_xl_body').html(data);
        $('.mymodal_card_xl').modal('show');
   });
   return false;
});
$('.btn-lihat-operasi').on('click', function (){
    $.get($(this).attr('href'), function(data) {
        $('.mymodal_card_xl_body').html(data);
        $('.mymodal_card_xl').modal('show');
   });
   return false;
});
$('.btn-lihat-anastesi').on('click', function (){
    $.get($(this).attr('href'), function(data) {
        $('.mymodal_card_xl_body').html(data);
        $('.mymodal_card_xl').modal('show');
   });
   return false;
});

$('.btn-preview-resume-rj').click(function(e){
	e.preventDefault();
	var id=$(this).attr('data-id');
    var pasien=$(this).attr('data-pasien');
    console.log(pasien)
	if(id){
		$.post('" . Url::to(['detail-resume-rj']) . "',{id:id,pasien:pasien},function(res){
			$('.mymodal_card_xl_body').html(res);
            $('.mymodal_card_xl').modal('show');
		});
	}
});
$('.btn-lihat-asesmen-keperawatans').on('click', function() {
    var id=$(this).attr('href');
    // $.get(baseUrl+'/analisa-kuantitatif/preview-doc-clinical?id='+id, function(d){
    //     if(d.status){
        console.log(id);
            $('.mymodal_card_xl_body').html(id);
            $('.mymodal_card_xl').modal('show');
        // }else{
        //     fmsg.w(d.msg);
        // }
    // });
});
$('.btn-lihat-labor').on('click', function() {
    var id=$(this).data('id');
    
    $.get(baseUrl+'/analisa-kuantitatif/preview-list-labor?id='+id, function(d){

        if(d.status){
            console.log(d.data);
            $('.mymodal_card_xl_body').html(d.data.pdf);
            $('.mymodal_card_xl').modal('show');
        }else{
            fmsg.w(d.msg);
        }
    });
});


//detail riwayat konsultasi
$('.tb-riwayat-konsultasi tbody tr td').on('click','.btn-detail',function(e){
	e.preventDefault();
	var id=$(this).attr('data-id');
	if(id){
		$.post('" . Url::to(['detail-konsultasi']) . "',{id:id},function(res){
			$('.mymodal_card_xl_body').html(res);
            $('.mymodal_card_xl').modal('show');
		});
	}
});
$('.btn-sbpk').click(function(e){
	e.preventDefault();
	var id=$(this).attr('data-id');
	if(id){
		$.post('" . Url::to(['detail-sbpk']) . "',{id:id},function(res){
			$('.mymodal_card_xl_body').html(res);
            $('.mymodal_card_xl').modal('show');
		});
	}
});
$('.btn-resep').click(function(e){
	e.preventDefault();
	var id=$(this).attr('data-id');
	if(id){
		$.post('" . Url::to(['detail-resep']) . "',{id:id},function(res){
			$('.mymodal_card_xl_body').html(res);
            $('.mymodal_card_xl').modal('show');
		});
	}
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
    $this->registerCss("
table.dataTable tbody tr.selected, table.dataTable tbody th.selected, table.dataTable tbody td.selected{
    font-weight:bolder;
    background-color:#00A65A;
}

tr, th {
    padding: 5px 5px 5px 5px !important;
}
tr, td {
    padding: 5px 5px 5px 5px !important;
}


");
    ?>

 <div class="card card-primary card-outline">

     <div class="card-body">
         <div class="row">
             <div class="col-lg-4">

                 <div class="card card-danger card-outline">
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
                                                 <a class="btn btn-success btn-sm btn-preview-resume-verifikator-ri" href="<?= Url::to(['/analisa-kuantitatif/preview-resume-medis', 'id' => $item['id']]) ?>" data-id="<?= $item['id'] ?>" data-pasien="<?= $registrasi['pasien']['kode'] ?>" data-nama="<?= $item['id'] ?>"> <i style="color: white;" class="fa fa-eye"></i></i></a>
                                                 <a class="btn btn-warning btn-sm" target="_blank" href="<?= Url::to(['/analisa-kuantitatif/cetak-resume-medis-dokter-verifikator-ri', 'id' => $item['id'], 'pasien' => $registrasi['pasien']['kode']]) ?>" data-id="<?= $item['id'] ?>" data-pasien="<?= $registrasi['pasien']['kode'] ?>" data-nama="<?= $item['id'] ?>"> <i class="fa fa-print"></i></i></a>
                                                 <a class="btn btn-info btn-sm" href="<?= Url::to(['analisa-kuantitatif/detail-coder-claim-update', 'id' => $item['id'], 'registrasi_kode' => HelperGeneralClass::hashData($registrasi['kode'])]) ?>" data-id="<?= $item['id'] ?>" data-nama="<?= $item['id'] ?>"> <i class="fa fa-edit"></i></i></a>
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
                 <?php

                    $form = ActiveForm::begin([
                        'id' => 'af-dokter-verifikator',
                    ]); ?>


                 <div class="card card-primary card-outline">

                     <div class="card-header">
                         <h5 style="margin-bottom:6px;">Coding Claim</h5>
                     </div>
                     <div class="card-body">
                         <div class="row">
                             <div class="col-sm-12">



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
                                                        'initValueText' => (!$model->isNewRecord && $model->diagutama) ? '(' . $model->diagutama->kode . ')' . $model->diagutama->deskripsi : null,
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
                                                        'initValueText' => (!$model->isNewRecord  && $model->diagsatu) ? '(' . $model->diagsatu->kode . ')' . $model->diagsatu->deskripsi : null,
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
                                                        'initValueText' => (!$model->isNewRecord  && $model->diagdua) ? '(' . $model->diagdua->kode . ')' . $model->diagdua->deskripsi : null,
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
                                                        'initValueText' => (!$model->isNewRecord  && $model->diagtiga) ? '(' . $model->diagtiga->kode . ')' . $model->diagtiga->deskripsi : null,
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
                                                        'initValueText' => (!$model->isNewRecord  && $model->diagempat) ? '(' . $model->diagempat->kode . ')' . $model->diagempat->deskripsi : null,
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
                                                        'initValueText' => (!$model->isNewRecord  && $model->diaglima) ? '(' . $model->diaglima->kode . ')' . $model->diaglima->deskripsi : null,
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
                                                        'initValueText' => (!$model->isNewRecord  && $model->tindutama) ? '(' . $model->tindutama->kode . ')' . $model->tindutama->deskripsi : null,
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
                                                        'initValueText' => (!$model->isNewRecord   && $model->tindsatu) ? '(' . $model->tindsatu->kode . ')' . $model->tindsatu->deskripsi : null,
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
                                                        'initValueText' => (!$model->isNewRecord   && $model->tinddua) ? '(' . $model->tinddua->kode . ')' . $model->tinddua->deskripsi : null,
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
                                                        'initValueText' => (!$model->isNewRecord   && $model->tindtiga) ? '(' . $model->tindtiga->kode . ')' . $model->tindtiga->deskripsi : null,
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
                                                        'initValueText' => (!$model->isNewRecord   && $model->tindempat) ? '(' . $model->tindempat->kode . ')' . $model->tindempat->deskripsi : null,
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
                                                        'initValueText' => (!$model->isNewRecord   && $model->tindlima) ? '(' . $model->tindlima->kode . ')' . $model->tindlima->deskripsi : null,
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
