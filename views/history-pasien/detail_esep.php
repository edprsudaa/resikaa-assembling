<?php

use app\assets\plugins\InputmaskAsset;
use app\components\HelperGeneralClass;
use app\components\HelperSpesialClass;
use app\models\pendaftaran\KelompokUnitLayanan;
use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;
use kartik\select2\Select2;
use yii\bootstrap4\Modal;
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
<div class="row">
    <div class="col-lg-12">

        <div class="col-lg-12">
            <div class="card card-primary card-outline">

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card card-info">
                                <div class="card-header">
                                    <h3 class="card-title">Daftar E-Sep Pasien</h3>
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
                                            <th>No Registrasi</th>
                                            <th>Unit</th>

                                            <th>Tanggal Masuk</th>
                                            <th>Tanggal Keluar</th>

                                            <th>Aksi</th>




                                        </tr>
                                        <?php
                                        if (!empty($listEsep)) {
                                            $i = 1;
                                            foreach ($listEsep as $item) {

                                        ?>
                                                <tr>
                                                    <td><?= $i ?></td>
                                                    <td><?= $item['kode'] ?></td>
                                                    <td><?php
                                                        $units = array();
                                                        foreach ($item['layanan'] as $value) {
                                                            $unitName = $value['unit']['nama'] ?? '';
                                                            if (!in_array($unitName, $units)) {
                                                                $units[] = $unitName;
                                                                if ($value['jenis_layanan'] == 1) {
                                                                    echo '<span class="right badge badge-danger">' . $unitName . '</span><br>';
                                                                } elseif ($value['jenis_layanan'] == 2) {
                                                                    echo '<span class="right badge badge-info">' . $unitName . '</span><br>';
                                                                } elseif ($value['jenis_layanan'] == 3) {
                                                                    echo '<span class="right badge badge-success">' . $unitName . '</span><br>';
                                                                } else {
                                                                    echo '<span class="right badge badge-warning">' . $unitName . '</span><br>';
                                                                }
                                                            }
                                                        } ?></td>
                                                    <td><?= $item['tgl_masuk'] ?></td>
                                                    <td><?= $item['tgl_keluar'] ?></td>



                                                    <td>

                                                        <?php if ($item['no_sep'] != null || $item['no_sep'] != '') { ?>

                                                            <?= Html::a(
                                                                'E-SEP RJ &nbsp;&nbsp; <span class="fas fa-teeth"></span>',
                                                                ['/history-pasien/lihat-sep', 'sep' => $item['no_sep']],
                                                                [
                                                                    'rel' => 'tooltip',
                                                                    'data-placement' => 'top',
                                                                    'data-title' => 'Lihat SEP',
                                                                    'class' => 'btn btn-warning btn-sm',
                                                                    'style' => 'cursor: pointer;',
                                                                    'data-target' => "#modalSep",
                                                                    'data-toggle' => 'modal',
                                                                ]
                                                            ); ?>
                                                            <a class="btn btn-warning btn-sm" target="_blank" href="http://pendaftaran.simrs.aa/sep-v3/cetak-esep?no_sep=<?= $item['no_sep'] ?>">Cetak E-SEP RJ <i class="fas fa-print fa-sm"></i></a>
                                                        <?php  } ?>
                                                        <?php if ($item['no_sep_ri'] != null || $item['no_sep_ri'] != '') { ?>
                                                            <?= Html::a(
                                                                'E-SEP RI &nbsp;&nbsp; <span class="fas fa-teeth"></span>',
                                                                ['/history-pasien/lihat-sep', 'sep' => $item['no_sep_ri']],
                                                                [
                                                                    'rel' => 'tooltip',
                                                                    'data-placement' => 'top',
                                                                    'data-title' => 'Lihat SEP',
                                                                    'class' => 'btn btn-warning btn-sm',
                                                                    'style' => 'cursor: pointer;',
                                                                    'data-target' => "#modalSep",
                                                                    'data-toggle' => 'modal',
                                                                ]
                                                            ); ?>
                                                            <a class="btn btn-warning btn-sm" target="_blank" href="http://pendaftaran.simrs.aa/sep-v3/cetak-esep?no_sep=<?= $item['no_sep_ri'] ?>">Cetak E-SEP RI <i class="fas fa-print fa-sm"></i></a>
                                                        <?php  } ?>
                                                        <?php if ($item['no_sep_igd'] != null || $item['no_sep_igd'] != '') { ?>
                                                            <?= Html::a(
                                                                'E-SEP IGD &nbsp;&nbsp; <span class="fas fa-teeth"></span>',
                                                                ['/history-pasien/lihat-sep', 'sep' => $item['no_sep_igd']],
                                                                [
                                                                    'rel' => 'tooltip',
                                                                    'data-placement' => 'top',
                                                                    'data-title' => 'Lihat SEP',
                                                                    'class' => 'btn btn-warning btn-sm',
                                                                    'style' => 'cursor: pointer;',
                                                                    'data-target' => "#modalSep",
                                                                    'data-toggle' => 'modal',
                                                                ]
                                                            ); ?>
                                                            <a class="btn btn-warning btn-sm" target="_blank" href="http://pendaftaran.simrs.aa/sep-v3/cetak-esep?no_sep=<?= $item['no_sep_igd'] ?>">Cetak E-SEP IGD<i class="fas fa-print fa-sm"></i></a>
                                                        <?php  } ?>
                                                    </td>

                                                </tr>

                                            <?php
                                                $i++;
                                            }
                                            ?>
                                            <tr>
                                                <td style="text-align: left;">Tidak ada dokumen</td>
                                            </tr>
                                        <?php

                                        }
                                        ?>
                                    </table>
                                    <?php Modal::begin([
                                        'id' => 'modalSep',
                                        'size' => Modal::SIZE_LARGE,
                                        'options' => [
                                            'tabindex' => false,
                                            // 'data-backdrop' => 'static',
                                        ],
                                    ]);
                                    Modal::end(); ?>
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

<?php
$this->registerJs(<<<JS
$('#modalSep').on('show.bs.modal', function (event) {
    let button = $(event.relatedTarget)
    let modal = $(this)
    let title = button.data('title')

    if(title == 'Serahkan Obat keruangan sekaligus') {
        modal.find('.modal-dialog').removeClass('modal-lg').addClass('modal-xl');
    } else if(title == 'Lihat SEP'){
        modal.find('.modal-header').css('display','none')
        modal.find('.modal-dialog').removeClass('modal-lg').addClass('modal-xl');
    }else if(title == 'Verifikasi Iter'){
        modal.find('.modal-dialog').removeClass('modal-lg').addClass('modal-xl');
    }else{
        modal.find('.modal-dialog').removeClass('modal-xl').addClass('modal-lg');
    }
    
    let header = title + `
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>`
    let href = button.attr('href')
    modal.find('.modal-header').html(header)
    // modal.find('.modal-body').html(bodyLoad)
    $.post(href)
        .done(function (data) {
            modal.find('.modal-body').html(data)
            if(title == 'Lihat SEP'){
                modal.find('.modal-body').css('padding', '0')
                modal.find('.modal-body').css('margin', '0')
            }
        });
})

JS, View::POS_END); ?>