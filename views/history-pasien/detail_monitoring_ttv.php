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

$('.btn-monitoring-ttv').on('click', function (){
    $.get($(this).attr('href'), function(data) {
        $('.mymodal_card_xl_body').html(data);
        $('.mymodal_card_xl').modal('show');
   });
   return false;
});

$(document).on('click', '.btn-dokumen-rme', function (e) {
    e.preventDefault(); // Prevent the default action

    const pdfUrl = $(this).attr('href') + '#toolbar=0'; // Get the PDF URL and append #toolbar=0
    const iframe = '<iframe src=\"' + pdfUrl + '\" style=\"width:100%; height:80vh; border:none;\"></iframe>'; // Create an iframe with the PDF URL

    $('.mymodal_card_xl_body').html(iframe); // Set the iframe in the modal body
    $('.mymodal_card_xl').modal('show'); // Show the modal
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
<div class="row">
    <div class="col-lg-12">

        <div class="col-lg-12">
            <div class="card card-primary card-outline">

                <div class="card-body">
                    <div class="tab-content">

                        <?php foreach ($dokumenRme as $idx => $du): ?>
                            <div class="card">
                                <h5>Daftar Riwayat <?= htmlspecialchars(is_string($du['deskripsi']) ? $du['deskripsi'] : '') ?></h5>
                                <div class="row">
                                    <div class="col-12">
                                        <?php if (!empty($du['data'])): ?>
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>No</th> <!-- Kolom nomor -->
                                                        <?php
                                                        // Ambil semua atribut data
                                                        $dataAttributes = array_keys($du['data'][0] ?? []);
                                                        // Tentukan atribut yang akan diabaikan
                                                        $excludedAttributes = ['id_dokumen', 'versi', 'id_dokumen_rme', 'url_lihat', 'url_cetak'];
                                                        // Filter atribut yang ditampilkan
                                                        $filteredDataAttributes = array_filter($dataAttributes, function ($attr) use ($excludedAttributes) {
                                                            return !in_array($attr, $excludedAttributes, true);
                                                        });

                                                        // Render header tabel
                                                        foreach ($filteredDataAttributes as $dataAttr) {
                                                            echo "<th>" . htmlspecialchars($dataAttr) . "</th>";
                                                        }
                                                        ?>
                                                        <th>Action</th> <!-- Tambahkan kolom Action -->
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach ($du['data'] as $key => $item): ?>
                                                        <tr>
                                                            <!-- Kolom nomor -->
                                                            <td><?= $key + 1 ?></td>

                                                            <?php foreach ($filteredDataAttributes as $dataAttr): ?>
                                                                <td><?= htmlspecialchars($item[$dataAttr] ?? '-') ?></td>
                                                            <?php endforeach; ?>

                                                            <!-- Kolom Action -->
                                                            <td>
                                                                <?php if (!empty($item['url_lihat'])): ?>
                                                                    <a class="btn btn-success btn-sm btn-dokumen-rme" href="<?= $item['url_lihat'] ?>">
                                                                        Klik untuk lihat <i class="fas fa-eye fa-sm"></i>
                                                                    </a>
                                                                <?php endif; ?>
                                                                <?php if (!empty($item['url_cetak'])): ?>
                                                                    <a class="btn btn-warning btn-sm" target="_blank" href="<?= $item['url_cetak'] ?>">
                                                                        Cetak <i class="fas fa-print fa-sm"></i>
                                                                    </a>
                                                                <?php endif; ?>
                                                            </td>
                                                        </tr>
                                                    <?php endforeach; ?>
                                                </tbody>
                                            </table>
                                        <?php else: ?>
                                            <p class="text-center">Data tidak tersedia.</p>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>

                    </div>







                </div>
            </div>


        </div>

    </div>

</div>
</div>
</div>