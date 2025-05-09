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

$this->title = 'Analisa Kuantitatif';
$this->params['breadcrumbs'][] = $this->title;
$this->registerJs($this->render('script.js'), View::POS_END);
$this->registerJs("
$('.btn-lihat').on('click', function() {
    var id=$(this).data('id');
    $.get(baseUrl+'/riwayat-pasien/preview-doc-clinical?id='+id, function(d){
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
$('.btn-lihat-asesmen-keperawatans').on('click', function() {
    var id=$(this).attr('href');
    // $.get(baseUrl+'/riwayat-pasien/preview-doc-clinical?id='+id, function(d){
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
    
    $.get(baseUrl+'/riwayat-pasien/preview-list-labor?id='+id, function(d){

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
$('.btn-preview-resume-rj').click(function(e){
	e.preventDefault();
	var id=$(this).attr('data-id');
	if(id){
		$.post('" . Url::to(['detail-resume-rj']) . "',{id:id},function(res){
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
<?php
$pasienKode = $registrasi['pasien']['kode'] ?? null;
?>

<div class="row">
    <div class="col-lg-12">
        <div class="col-lg-12">
            <div class="card card-primary card-outline">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card card-info">
                                <div class="card-header">
                                    <h3 class="card-title">DAFTAR DOKUMEN PENUNJANG</h3>
                                    <div class="card-tools">
                                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                            <i class="fas fa-plus"></i>
                                        </button>
                                    </div>
                                </div>

                                <div class="card-body">
                                    <table class="table table-striped table-bordered " style="text-align: justify;">
                                        <tr class="bg-info">
                                            <th>PATOLOGI KLINIK</th>
                                            <th>Laboratorium Biomolekuler</th>
                                            <th>Laboratorium PCR</th>
                                            <th>RADIOLOGI</th>
                                            <th>Ekokardiografi</th>
                                            <th>PATOLOGI ANATOMI</th>
                                            <th>ESWL</th>
                                            <th>ENDOSKOPI</th>
                                        </tr>
                                        <tr>
                                            <td style="text-align: left;">
                                                <a class="btn btn-success btn-sm" target="_blank" href="http://emr-penunjang.simrs.aa/hasil/expertise-lab-pk?jenis=a&rm=<?= HelperGeneralClass::hashData($pasienKode) ?? ''; ?>">Lihat Hasil <i class="fas fa-eye fa-sm"></i></a>
                                            </td>
                                            <td style="text-align: left;">
                                                <a class="btn btn-success btn-sm" target="_blank" href="http://emr-penunjang.simrs.aa/hasil/expertise-lab-biomolekuler?jenis=a&rm=<?= HelperGeneralClass::hashData($pasienKode) ?? ''; ?>">Lihat Hasil <i class="fas fa-eye fa-sm"></i></a>
                                            </td>
                                            <td style="text-align: left;">
                                                <a class="btn btn-success btn-sm" target="_blank" href="http://emr-penunjang.simrs.aa/hasil/expertise-pcr?jenis=a&rm=<?= HelperGeneralClass::hashData($pasienKode) ?? ''; ?>">Lihat Hasil <i class="fas fa-eye fa-sm"></i></a>
                                            </td>
                                            <td style="text-align: left;">
                                                <a class="btn btn-success btn-sm" target="_blank" href="http://emr-penunjang.simrs.aa/hasil/expertise-radiologi?jenis=a&rm=<?= HelperGeneralClass::hashData($pasienKode) ?? ''; ?>">Lihat Hasil <i class="fas fa-eye fa-sm"></i></a>
                                            </td>
                                            <td style="text-align: left;">
                                                <a class="btn btn-success btn-sm" target="_blank" href="http://emr-penunjang.simrs.aa/hasil/expertise-echo?jenis=a&rm=<?= HelperGeneralClass::hashData($pasienKode) ?? ''; ?>">Lihat Hasil <i class="fas fa-eye fa-sm"></i></a>
                                            </td>
                                            <td style="text-align: left;">
                                                <a class="btn btn-success btn-sm" target="_blank" href="http://emr-penunjang.simrs.aa/hasil/expertise-lab-pa?jenis=a&rm=<?= HelperGeneralClass::hashData($pasienKode) ?? ''; ?>">Lihat Hasil <i class="fas fa-eye fa-sm"></i></a>
                                            </td>
                                            <td style="text-align: left;">
                                                <a class="btn btn-success btn-sm" target="_blank" href="http://emr-penunjang.simrs.aa/hasil/expertise-eswl?jenis=a&rm=<?= HelperGeneralClass::hashData($pasienKode) ?? ''; ?>">Lihat Hasil <i class="fas fa-eye fa-sm"></i></a>
                                            </td>
                                            <td style="text-align: left;">
                                                <a class="btn btn-success btn-sm" target="_blank" href="http://emr-penunjang.simrs.aa/hasil/expertise-endoskopi?jenis=a&rm=<?= HelperGeneralClass::hashData($pasienKode) ?? ''; ?>">Lihat Hasil <i class="fas fa-eye fa-sm"></i></a>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>