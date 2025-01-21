<?php

use app\assets\plugins\InputmaskAsset;
use app\components\HelperGeneralClass;
use app\components\HelperSpesialClass;
use app\models\pendaftaran\KelompokUnitLayanan;
use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;
use kartik\select2\Select2;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\web\JsExpression;
use yii\web\View;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\models\DistribusiSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'ANALISA DATA ELECTRONIC MEDICAL RECORD';
$this->params['breadcrumbs'][] = $this->title;
$this->registerJs($this->render('script.js'), View::POS_END);
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
<div class="row">
    <div class="col-lg-12">
        <!-- Card Pasien -->
        <?php echo $this->render('card-pasien', ['registrasi' => $registrasi]);
        // print_r($model->analisa_dokumen_id);
        // die();

        ?>
        <!-- Card Pasien -->

        <div class="row">

            <div class="col-lg-4">
                <div class="card">
                    <a type="button" href=http://emr-pengolahan-data.simrs.aa/history-pasien/list-kunjungan-object?id=<?= $registrasi['pasien_kode'] ?>&versi=1 href="#custom-tabs-two-0" role="tab" aria-controls="custom-tabs-two-0" aria-selected="false" target="_blank" class="btn btn-block bg-gradient-warning btn-lg">Histori Berdasar Dokumen</a>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card">
                    <a type="button" href=http://emr-pengolahan-data.simrs.aa/history-pasien/list-kunjungan?id=<?= $registrasi['pasien_kode'] ?>&versi=1 href="#custom-tabs-two-0" role="tab" aria-controls="custom-tabs-two-0" aria-selected="false" target="_blank" class="btn btn-block bg-gradient-success btn-lg">Histori Berdasar Registrasi</a>

                </div>
            </div>
            <div class="col-lg-4">
                <div class="card">
                    <a type="button" href=http://emr-pengolahan-data.simrs.aa/history-pasien/detail-kunjungan?rm=<?= $registrasi['pasien_kode'] ?>&noreg=<?= $registrasi['kode'] ?> href="#custom-tabs-two-0" role="tab" aria-controls="custom-tabs-two-0" aria-selected="false" target="_blank" class="btn btn-block bg-gradient-primary btn-lg">Histori Berdasar Registrasi Hari Ini</a>

                </div>
            </div>
            <br>

            <div class="col-lg-12">
                <?php
                if (!$icd) {
                    echo $this->render('analisa-data-emr', ['model' => $model, 'listAnalisa' => $listAnalisa, 'registrasi' => $registrasi]);
                } else {
                    echo $this->render('analisa-data-icd-rj', [
                        'model' => $model, 'modelCustomer' => $modelCustomer,
                        'listCoder' => $listCoder,

                        'listResumeMedisVerifikator' => $listResumeMedisVerifikator, 'listResumeMedisDokter' => $listResumeMedisDokter,
                        'modelsAddress' => $modelsAddress, 'modelsIcd9' => $modelsIcd9, 'listAnalisa' => $listAnalisa, 'registrasi' => $registrasi
                    ]);
                }
                ?>
            </div>


        </div>


    </div>
</div>
</div>