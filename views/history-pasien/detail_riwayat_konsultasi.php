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
                                    <h3 class="card-title">RIWAYAT KONSULTASI</h3>
                                    <div class="card-tools">
                                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                            <i class="fas fa-plus"></i>
                                        </button>
                                    </div>

                                </div>

                                <div class="card-body">
                                    <table class="table table-striped table-bordered tb-riwayat-konsultasi" style="text-align: justify;">

                                        <tr class="bg-info">
                                            <th>No</th>
                                            <th>Tanggal</th>
                                            <th>Registrasi</th>
                                            <th>Dokter Minta</th>
                                            <th>Dokter Tujuan</th>

                                            <th>Poli Minta</th>

                                            <th>Poli Tujuan</th>
                                            <th>Dokter Jawab Konsultasi</th>

                                            <th>Aksi</th>




                                        </tr>
                                        <?php
                                        if (!empty($list_konsultasi)) {
                                            $i = 1;
                                            foreach ($list_konsultasi as $lk) {
                                        ?>
                                                <tr>
                                                    <td><?= $i ?></td>

                                                    <td><?php echo $lk['tanggal_minta'] != NULL ? date('d-m-Y H:i', strtotime($lk['tanggal_minta'])) : ''; ?></td>
                                                    <td><?= $lk['layananMinta']['registrasi']['kode'] ?? '' ?></td>
                                                    <td><?= (!empty($lk->dokterMinta) ? HelperSpesialClass::getNamaPegawaiArray($lk->dokterMinta) : '-') ?></td>
                                                    <td><?= (!empty($lk->dokterTujuan) ? HelperSpesialClass::getNamaPegawaiArray($lk->dokterTujuan) : '-') ?></td>

                                                    <td><?php echo $lk['layananMinta'] != NULL ? ($lk['layananMinta']['unit'] != NULL ? $lk['layananMinta']['unit']['nama'] : '') : '' ?></td>
                                                    <td><?php echo $lk['unitTujuan'] != NULL ? $lk['unitTujuan']['nama'] : '' ?></td>
                                                    <td><?php $dokter = array();
                                                        foreach ($lk['jawabanKonsultasi'] as $value) {
                                                            $unitName = HelperSpesialClass::getNamaPegawaiArray($value['dokterJawab']);
                                                            if (!in_array($unitName, $dokter)) {
                                                                $dokter[] = $unitName;

                                                                echo '<span class="right badge badge-danger">' . $unitName . '</span><br>';
                                                            }
                                                        } ?></td>

                                                    <td><a href="#" title="klik untuk melihat detail konsultasi" class="btn btn-flat btn-success btn-sm btn-detail" data-id='<?= HelperGeneralClass::hashData($lk['id']); ?>'>Klik untuk lihat <i class="fa fa-eye"></i></a>
                                                        <a class="btn btn-warning btn-sm" target="_blank" href="<?= Url::to([
                                                                                                                    '/history-pasien/cetak-riwayat-konsultasi',
                                                                                                                    'id' => HelperGeneralClass::hashData($lk['id']),

                                                                                                                ]) ?>">Cetak <i class="fas fa-print fa-sm"></i></a>
                                                    </td>
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