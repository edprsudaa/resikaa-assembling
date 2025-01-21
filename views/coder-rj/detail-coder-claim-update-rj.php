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
            <div class="col-lg-9">
                <?php
                echo $this->render('analisa-data-coder-claim-update-rj', ['model' => $model, 'listResumeMedisVerifikator' => $listResumeMedisVerifikator, 'listResumeMedisDokter' => $listResumeMedisDokter, 'registrasi' => $registrasi]);
                ?>
            </div>
            <div class="col-lg-3">
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <h5 class="card-title m-0">Daftar Formulir Telah Diisi</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card card-info collapsed-card">
                                    <div class="card-header">
                                        <h3 class="card-title">ASESMEN AWAL KEPERAWATAN</h3>
                                        <div class="card-tools">
                                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                                <i class="fas fa-plus"></i>
                                            </button>
                                        </div>

                                    </div>

                                    <div class="card-body">
                                        <table class="table table-striped table-bordered" style="text-align: justify;">

                                            <?php
                                            if (!empty($listAsesmenKeperawatan)) {
                                                $i = 1;
                                                foreach ($listAsesmenKeperawatan as $item) {
                                            ?>
                                                    <tr>
                                                        <td style="text-align: left;"><a class="btn <?php echo $item->is_deleted == 0 ? 'btn-success' : 'btn-danger' ?> btn-sm btn-lihat-asesmen" href="<?= Url::to(['/analisa-kuantitatif/preview-asesmen-awal-keperawatan', 'id' => $item->id]) ?>" data-id="<?= $item->id ?>" data-nama="<?= $item->id ?>"><?= $i ?>. Asesmen Keperawatan, <b>STATUS : <?php echo $item->is_deleted == 0 ? ($item->draf == 1 ? 'DRAFT' : 'FINAL') : 'BATAL' ?></b></a></td>
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
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card card-info collapsed-card">
                                    <div class="card-header">
                                        <h3 class="card-title">ASESMEN AWAL KEBIDANAN</h3>
                                        <div class="card-tools">
                                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                                <i class="fas fa-plus"></i>
                                            </button>
                                        </div>

                                    </div>

                                    <div class="card-body">
                                        <table class="table table-striped table-bordered" style="text-align: justify;">

                                            <?php
                                            if (!empty($listAsesmenKebidanan)) {
                                                foreach ($listAsesmenKebidanan as $item) {
                                            ?>
                                                    <tr>
                                                        <td style="text-align: left;"><a class="btn <?php echo $item->is_deleted == 0 ? 'btn-success' : 'btn-danger' ?> btn-sm btn-lihat-asesmen" href="<?= Url::to(['/analisa-kuantitatif/preview-asesmen-awal-kebidanan', 'id' => $item->id]) ?>" data-id="<?= $item->id
                                                                                                                                                                                                                                                                                                                ?>" data-nama="<?= $item->id
                                                                                                                                                                                                                                                                                                                                ?>"> Asesmen Keperawatan , <b>STATUS : <?php echo $item->is_deleted == 0 ? ($item->draf == 1 ? 'DRAFT' : 'FINAL') : 'BATAL' ?></a></td>
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
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card card-info collapsed-card">
                                    <div class="card-header">
                                        <h3 class="card-title">ASESMEN AWAL MEDIS</h3>
                                        <div class="card-tools">
                                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                                <i class="fas fa-plus"></i>
                                            </button>
                                        </div>

                                    </div>

                                    <div class="card-body">
                                        <table class="table table-striped table-bordered" style="text-align: justify;">

                                            <?php
                                            if (!empty($listAsesmenMedis)) {
                                                $i = 1;
                                                foreach ($listAsesmenMedis as $item) {
                                            ?>
                                                    <tr>
                                                        <td style="text-align: left;"><a class="btn <?php echo $item->is_deleted == 0 ? 'btn-success' : 'btn-danger' ?> btn-sm btn-lihat-asesmen" href="<?= Url::to(['/analisa-kuantitatif/preview-asesmen-awal-medis', 'id' => $item->id]) ?>" data-id="<?= $item->id
                                                                                                                                                                                                                                                                                                            ?>" data-nama="<?= $item->id
                                                                                                                                                                                                                                                                                                                            ?>"> <?= $i ?> . Asesmen Medis, <b>STATUS : <?php echo $item->is_deleted == 0 ? ($item->draf == 1 ? 'DRAFT' : 'FINAL') : 'BATAL' ?></a></td>
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
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card card-info collapsed-card">
                                    <div class="card-header">
                                        <h3 class="card-title">HASIL LABORATORIUM PATOLOGI KLINIK
                                        </h3>
                                        <div class="card-tools">
                                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                                <i class="fas fa-plus"></i>
                                            </button>
                                        </div>

                                    </div>

                                    <div class="card-body">
                                        <table class="table table-striped table-bordered" style="text-align: justify;">

                                            <?php
                                            if ($listLabor->data !== null) {
                                                $i = 1;
                                                foreach ($listLabor->data as $item) {
                                            ?>
                                                    <?php
                                                    $dataUnit = explode('^', $item['SOURCE']);
                                                    $array = array_map(function ($input) {
                                                        return explode(',', $input);
                                                    }, explode('^', $item['CLINICIAN']));
                                                    ?>
                                                    <tr>
                                                        <td style="text-align: left;"><button style="text-align: left;" type="button" class="btn btn-success btn-flat btn-lihat-labor" data-id="<?= $item['ID'] ?>" data-nama="<?= $item['ID'] ?>"><?= $i ?>. UNIT : <?php echo $dataUnit[1] ?><?= $item['REQUEST_DT'] != NULL ? '<br>TGL ORDER : ' . date('d-m-Y H:i', strtotime($item['REQUEST_DT'])) : ''; ?></button></td>
                                                    </tr>
                                                <?php
                                                    $i++;
                                                }
                                            } else { ?>
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
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card card-info collapsed-card">
                                    <div class="card-header">
                                        <h3 class="card-title">HASIL LABORATORIUM PATOLOGI ANATOMI</h3>
                                        <div class="card-tools">
                                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                                <i class="fas fa-plus"></i>
                                            </button>
                                        </div>

                                    </div>

                                    <div class="card-body">
                                        <table class="table table-striped table-bordered" style="text-align: justify;">

                                            <?php

                                            if ($listPatologiAnatomi->data !== null) {
                                                foreach ($listPatologiAnatomi->data as $item) {
                                            ?>

                                                    <tr>
                                                        <td style="text-align: left;"><a class="btn btn-success btn-sm btn-lihat-asesmen" href="<?= Url::to([
                                                                                                                                                    '/analisa-kuantitatif/preview-patologi-anatomi',
                                                                                                                                                    'id' => $item['id'],
                                                                                                                                                    // 'id' => $item['id'],
                                                                                                                                                    'pemeriksaan' => $item['tarif_tindakan_pasien_id']
                                                                                                                                                ]) ?>"> <?= $item['tgl_pemeriksaan']; ?><i class="fas fa-eye fa-sm"></i></a></td>
                                                    </tr>
                                                <?php
                                                }
                                            } else { ?>
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

                        <div class="row">
                            <div class="col-md-12">
                                <div class="card card-info collapsed-card">
                                    <div class="card-header">
                                        <h3 class="card-title">HASIL RADIOLOGI</h3>
                                        <div class="card-tools">
                                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                                <i class="fas fa-plus"></i>
                                            </button>
                                        </div>

                                    </div>

                                    <div class="card-body">
                                        <table class="table table-striped table-bordered" style="text-align: justify;">

                                            <?php
                                            // echo '<pre>';
                                            // print_r($listRadiologi);
                                            if ($listRadiologi->data !== null) {
                                                foreach ($listRadiologi->data as $item) {
                                            ?>
                                                    <?php
                                                    // $dataUnit = explode('^', $item['SOURCE']);
                                                    // $array = array_map(function ($input) {
                                                    //     return explode(',', $input);
                                                    // }, explode('^', $item['CLINICIAN']));
                                                    ?>
                                                    <tr>
                                                        <td style="text-align: left;"><a class="btn btn-success btn-sm btn-lihat-asesmen" href="<?= Url::to(['/analisa-kuantitatif/preview-radiologi', 'id' => $item['id_pacsorder']]) ?>" data-id="<?= $item['id_pacsorder']
                                                                                                                                                                                                                                                    ?>" data-nama="<?= $item['id_pacsorder']
                                                                                                                                                                                                                                                                    ?>"> <?= $item['tanggal_masuk']
                                                                                                                                                                                                                                                                            ?> <i class="fas fa-eye fa-sm"></i></a></td>


                                                    </tr>
                                                <?php
                                                }
                                            } else { ?>
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

                        <div class="row">
                            <div class="col-md-12">
                                <div class="card card-info collapsed-card">
                                    <div class="card-header">
                                        <h3 class="card-title">LAPORAN OPERASI</h3>
                                        <div class="card-tools">
                                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                                <i class="fas fa-plus"></i>
                                            </button>
                                        </div>

                                    </div>

                                    <div class="card-body">
                                        <table>
                                            <?php

                                            if (!empty($listLaporanOperasi)) {
                                                foreach ($listLaporanOperasi as $item) {
                                            ?>

                                                    <tr>
                                                        <td style="text-align: left;"><a class="btn btn-success btn-sm btn-lihat-operasi" href="<?= Url::to(['/analisa-kuantitatif/preview-laporan-operasi', 'id' => $item['lap_op_id']]) ?>" data-id="<?= $item['lap_op_id']
                                                                                                                                                                                                                                                        ?>" data-nama="<?= $item['lap_op_id']
                                                                                                                                                                                                                                                                        ?>"> <?= $item['lap_op_created_at']
                                                                                                                                                                                                                                                                                ?> <i class="fas fa-eye fa-sm"></i></a></td>


                                                    </tr>
                                                <?php
                                                }
                                            } else { ?>
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
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card card-info collapsed-card">
                                    <div class="card-header">
                                        <h3 class="card-title">LAPORAN ANASTESI</h3>
                                        <div class="card-tools">
                                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                                <i class="fas fa-plus"></i>
                                            </button>
                                        </div>

                                    </div>

                                    <div class="card-body">

                                        <?php

                                        if (!empty($listLaporanAnastesi)) {
                                            foreach ($listLaporanAnastesi as $item) {

                                        ?>

                                                <tr>
                                                    <td style="text-align: left;"><a class="btn btn-success btn-sm btn-lihat-anastesi" href="<?= Url::to(['/analisa-kuantitatif/preview-laporan-anastesi', 'id' => $item['api_id']]) ?>" data-id="<?= $item['api_id']
                                                                                                                                                                                                                                                    ?>" data-nama="<?= $item['api_id']
                                                                                                                                                                                                                                                                    ?>"> Laporan Anastesi <?= Yii::$app->formatter->asDate($item['api_tgl_final'])
                                                                                                                                                                                                                                                                                            ?> <i class="fas fa-eye fa-sm"></i></a></td>


                                                </tr>
                                            <?php
                                            }
                                        } else { ?>
                                            <tr>
                                                <td style="text-align: left;">Tidak ada dokumen</td>
                                            </tr>
                                        <?php

                                        }
                                        ?>

                                    </div>
                                </div>

                            </div>

                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card card-info collapsed-card">
                                    <div class="card-header">
                                        <h3 class="card-title">CPPT</h3>
                                        <div class="card-tools">
                                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                                <i class="fas fa-plus"></i>
                                            </button>
                                        </div>

                                    </div>

                                    <div class="card-body">
                                        <table class="table table-striped table-bordered" style="text-align: justify;">



                                            <tr>
                                                <td style="text-align: left;"><a class="btn btn-success btn-sm btn-lihat-asesmen" href="<?= Url::to([
                                                                                                                                            '/analisa-kuantitatif/preview-cppt',
                                                                                                                                            'id' => $registrasi['kode'],

                                                                                                                                        ]) ?>">Dokumen CPPT<i class="fas fa-eye fa-sm"></i></a></td>
                                            </tr>


                                        </table>
                                    </div>
                                </div>

                            </div>

                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card card-info collapsed-card">
                                    <div class="card-header">
                                        <h3 class="card-title">RESUME MEDIS RAWAT INAP</h3>
                                        <div class="card-tools">
                                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                                <i class="fas fa-plus"></i>
                                            </button>
                                        </div>

                                    </div>

                                    <div class="card-body">
                                        <table class="table table-striped table-bordered" style="text-align: justify;">


                                            <?php

                                            if (!empty($listResumeMedis)) {
                                                foreach ($listResumeMedis as $item) {
                                            ?>

                                                    <tr>
                                                        <td style="text-align: left;"><a class="btn btn-success btn-sm btn-lihat-operasi" href="<?= Url::to(['/analisa-kuantitatif/preview-resume-medis', 'id' => $item['id']]) ?>" data-id="<?= $item['id']
                                                                                                                                                                                                                                                ?>" data-nama="<?= $item['id']
                                                                                                                                                                                                                                                                ?>"> <?= $item['created_at']
                                                                                                                                                                                                                                                                        ?> <i class="fas fa-eye fa-sm"></i></a></td>


                                                    </tr>
                                                <?php
                                                }
                                            } else { ?>
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
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card card-info collapsed-card">
                                    <div class="card-header">
                                        <h3 class="card-title">RESEP OBAT</h3>
                                        <div class="card-tools">
                                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                                <i class="fas fa-plus"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <?php
                                        if (count($resep) > 0) {
                                            foreach ($resep as $r) {
                                        ?>
                                                <a href="#" class="btn btn-flat btn-resep <?php echo $r['is_deleted'] == 0 ? 'btn-success' : 'btn-danger' ?>" data-id="<?php echo $r['id']; ?>">
                                                    <?php echo "Tanggal : " . date('d-m-Y H:i', strtotime($r['tanggal'])) ?> <?php echo $r['depo'] != NULL ? '<br>Depo : ' . $r['depo']['nama'] : '' ?><?php echo $r['dokter'] != NULL ? '<br> Dokter : ' . $r['dokter']['gelar_sarjana_depan'] . ' ' . $r['dokter']['nama_lengkap'] . $r['dokter']['gelar_sarjana_belakang'] : '' ?>
                                                </a>
                                        <?php
                                            }
                                        } else {
                                            echo "RESEP OBAT TIDAK TERSEDIA";
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6"></div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="card card-info collapsed-card">
                                    <div class="card-header">
                                        <h3 class="card-title">RIWAYAT KONSULTASI</h3>
                                        <div class="card-tools">
                                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                                <i class="fas fa-plus"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <?php
                                        if (count($list_konsultasi) > 0) {
                                        ?>
                                            <table class="table table-bordered tb-riwayat-konsultasi">
                                                <thead>
                                                    <tr>
                                                        <th>Tgl. Konsultasi</th>
                                                        <th>Unit Asal</th>
                                                        <th>Unit Tujuan</th>
                                                        <th></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    foreach ($list_konsultasi as $lk) {
                                                    ?>
                                                        <tr>
                                                            <td><?php echo $lk['tanggal_minta'] != NULL ? date('d-m-Y H:i', strtotime($lk['tanggal_minta'])) : ''; ?></td>
                                                            <td><?php echo $lk['layananMinta'] != NULL ? ($lk['layananMinta']['unit'] != NULL ? $lk['layananMinta']['unit']['nama'] : '') : '' ?></td>
                                                            <td><?php echo $lk['unitTujuan'] != NULL ? $lk['unitTujuan']['nama'] : '' ?></td>
                                                            <td><a href="#" title="klik untuk melihat detail konsultasi" class="btn btn-flat btn-info btn-sm btn-detail" data-id='<?php echo $lk['id']; ?>'><i class="fa fa-eye"></i></a></td>
                                                        </tr>
                                                    <?php
                                                    }
                                                    ?>
                                                </tbody>
                                            </table>
                                        <?php
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="card card-info collapsed-card">
                                    <div class="card-header">
                                        <h3 class="card-title">RESUME MEDIS RAWAT JALAN</h3>
                                        <div class="card-tools">
                                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                                <i class="fas fa-plus"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="card-body">

                                        <?php

                                        if (!empty($listResumeMedisRj)) {
                                            foreach ($listResumeMedisRj as $item) {
                                        ?>

                                                <tr>
                                                    <td style="text-align: left;"><a class="btn btn-success btn-sm btn-preview-resume-rj" href="<?= Url::to(['/analisa-kuantitatif/preview-resume-medis-rj', 'id' => $item['id']]) ?>" data-id="<?= $item['id']
                                                                                                                                                                                                                                                ?>" data-pasien="<?= $registrasi['pasien']['kode']
                                                                                                                                                                                                                                                                    ?>" data-nama="<?= $item['id']
                                                                                                                                                                                                                                                                                    ?>"> <?= $item['created_at']
                                                                                                                                                                                                                                                                                            ?> <i class="fas fa-eye fa-sm"></i></a></td>


                                                </tr>
                                            <?php
                                            }
                                        } else { ?>
                                            <tr>
                                                <td style="text-align: left;">Tidak ada dokumen</td>
                                            </tr>
                                        <?php

                                        }
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