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
$('#analisa-dokumen').on('beforeSubmit',function(e){
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
            // App.ResetLoadingBtn(btn,htm);
        },
        error:function(xhr,status,error){
            // App.Error(error);
            // App.ResetLoadingBtn(btn,htm);
        }
    });
}).submit(function(e){
    e.preventDefault();
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
$(document).on('click', '.btn-dokumen-rme', function (e) {
    e.preventDefault(); // Prevent the default action

    const pdfUrl = $(this).attr('href') + '#toolbar=0'; // Get the PDF URL and append #toolbar=0
    const iframe = '<iframe src=\"' + pdfUrl + '\" style=\"width:100%; height:80vh; border:none;\"></iframe>'; // Create an iframe with the PDF URL

    $('.mymodal_card_xl_body').html(iframe); // Set the iframe in the modal body
    $('.mymodal_card_xl').modal('show'); // Show the modal
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

        <div class="col-lg-12">
            <div class="card card-primary card-outline">

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card card-info">
                                <div class="card-header">
                                    <h3 class="card-title">Resume Rawat Inap</h3>
                                    <div class="card-tools">
                                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                            <i class="fas fa-plus"></i>
                                        </button>
                                    </div>

                                </div>

                                <div class="card-body">
                                    <table class="table table-striped table-bordered " style="text-align: justify;">

                                        <tr class="bg-info">
                                            <th>No</th>
                                            <th>Tanggal</th>
                                            <th>Dokter</th>
                                            <th>Ruangan</th>

                                            <th>Aksi</th>




                                        </tr>
                                        <?php
                                        if (!empty($listResumeMedis)) {
                                            $i = 1;
                                            foreach ($listResumeMedis as $item) {
                                        ?>
                                                <tr>
                                                    <td><?= $i ?></td>
                                                    <td><?= $item['created_at'] ?></td>
                                                    <td><?= HelperSpesialClass::getNamaPegawaiArray($item->dokter) ?? '' ?></td>
                                                    <td><?= $item->layanan->unit->nama ?? '' ?>
                                                    </td>
                                                    <td>
                                                        <?php if (($item->versi == '2.0') && ($item->tanggal_final != null)) { ?>
                                                            <a class="btn btn-success btn-sm btn-dokumen-rme" href="http://sign.simrs.aa/api-esign/view-dokumen?id=<?= HelperGeneralClass::hashData($item->id_dokumen_rme) ?>">
                                                                Klik untuk lihat</i>
                                                            </a>
                                                            <a class="btn btn-warning btn-sm" target="_blank" href="http://sign.simrs.aa/api-esign/view-dokumen?id=<?= HelperGeneralClass::hashData($item->id_dokumen_rme) ?>">Cetak <i class="fas fa-print fa-sm"></i></a>


                                                        <?php } else { ?>
                                                            <a class="btn <?php echo $item->is_deleted == 0 ? 'btn-success' : 'btn-danger' ?> btn-sm btn-sm btn-lihat-operasi" href="<?= Url::to(['/history-pasien/preview-resume-medis', 'id' => HelperGeneralClass::hashData($item->id)]) ?>" data-id="<?= $item->id
                                                                                                                                                                                                                                                                                                            ?>" data-nama="<?= $item->id
                                                                                                                                                                                                                                                                                                                            ?>">Klik untuk lihat</a>

                                                            <a class="btn btn-warning btn-sm" target="_blank" href="http://medis.simrs.aa/pasien-resume-medis-ri/cetak?subid=<?= HelperGeneralClass::hashData($item->id) ?>">Cetak <i class="fas fa-print fa-sm"></i></a>

                                                        <?php } ?>
                                                    </td>
                                                </tr>
                                            <?php
                                            }
                                        } else {
                                            ?>
                                            <tr>
                                                <td style="text-align: left;">Tidak ada dokumen</td>
                                            </tr>
                                        <?php

                                        }
                                        ?>
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
</div>
</div>