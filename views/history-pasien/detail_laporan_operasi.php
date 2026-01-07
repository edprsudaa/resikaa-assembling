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
                                    <h3 class="card-title">LAPORAN OPERASI</h3>
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
                                            <th>Tim Operasi</th>
                                            <th>Ruangan</th>

                                            <th>Status</th>
                                            <th>Aksi</th>




                                        </tr>
                                        <?php
                                        if (!empty($listLaporanOperasi)) {
                                            $i = 1;
                                            foreach ($listLaporanOperasi as $item) {

                                        ?>
                                                <tr>
                                                    <td><?= $i ?></td>
                                                    <td><?= $item['lap_op_created_at'] ?></td>
                                                    <td>
                                                        <?php
                                                        foreach ($item['timoperasi']['timOperasiDetail'] as $key => $value) {
                                                            echo ($key + 1) . '. ' . HelperSpesialClass::getNamaPegawaiArray($value['pegawai']) ?? '';
                                                            echo '<br>';
                                                        }
                                                        ?>
                                                    </td>
                                                    <td><?= $item->lap_op_ruangan ?? '' ?></td>
                                                    <td> <?php echo $item->lap_op_batal == 0 ? ($item->lap_op_final == 0 ? 'DRAFT' : 'FINAL') : 'BATAL' ?>
                                                    </td>
                                                    <td>
                                                        <?php if ($item->id_dokumen_rme != null) { ?>
                                                            <a class="btn btn-success btn-sm btn-dokumen-rme"
                                                                href="http://sign.simrs.aa/api-esign/view-dokumen?id=<?= HelperGeneralClass::hashData($item->id_dokumen_rme) ?>">
                                                                Klik untuk lihat</i>
                                                            </a>
                                                            <a class="btn btn-warning btn-sm" target="_blank"
                                                                href="http://sign.simrs.aa/api-esign/view-dokumen?id=<?= HelperGeneralClass::hashData($item->id_dokumen_rme) ?>">Cetak
                                                                <i class="fas fa-print fa-sm"></i></a>


                                                        <?php } else { ?>
                                                            <a class="btn btn-success btn-sm" target="_blank"
                                                                href="http://bedah-sentral.simrs.aa/cetak/cetak-laporan-operasi?laporan_id=<?= HelperGeneralClass::hashData($item['lap_op_id']) ?>"
                                                                data-id="<?= $item['lap_op_id']
                                                                            ?>" data-nama="<?= $item['lap_op_id']
                                                                                            ?>">Klik
                                                                Untuk Lihat</b></a>
                                                        <?php } ?>
                                                    </td>
                                                    <!-- <td><a class="btn btn-success btn-sm" target="_blank"
                                                            href="http://bedah-sentral.simrs.aa/cetak/cetak-laporan-operasi?laporan_id=<?= HelperGeneralClass::hashData($item['lap_op_id']) ?>"
                                                            data-id="<?= $item['lap_op_id']
                                                                        ?>" data-nama="<?= $item['lap_op_id']
                                                                                        ?>">Klik
                                                            Untuk Lihat</b></a></td> -->
                                                </tr>

                                            <?php
                                                $i++;
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