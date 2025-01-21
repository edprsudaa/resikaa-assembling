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
        <?php echo $this->render('card-pasien', ['registrasi' => $registrasi]); ?>
        <p>
            <a href="<?php echo Url::to(['list-kunjungan', 'id' => !HelperSpesialClass::isMpp() ? $registrasi['pasien_kode'] : NULL]) ?>" class="btn btn-success btn-flat" title="kembali ke halaman daftar kunjungan"><i class="fa fa-arrow-left"></i> Kembali</a>
        </p>
        <div class="col-lg-12">
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h5 class="card-title m-0">Daftar Formulir Telah Diisi</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
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
                                                    <td style="text-align: left;"><a class="btn <?php echo $item->tanggal_final != null ? 'btn-success' : 'btn-danger' ?> btn-sm btn-lihat-asesmen" href="<?= Url::to(['/analisa-kuantitatif/preview-asesmen-awal-keperawatan', 'id' => $item->id]) ?>" data-id="<?= $item->id ?>" data-nama="<?= $item->id ?>"><?= $i ?>. Asesmen Keperawatan, <b>STATUS : <?php echo $item->is_deleted == 0 ? ($item->draf == 1 ? 'DRAFT' : 'FINAL') : 'BATAL' ?> - <?= $item->layanan->unit->nama ?? '' ?> - <?= $item->perawat->nama_lengkap ?? '' ?> Tanggal : <?= $item->tanggal_final ?? '' ?></b></a></td>
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


                        <div class="col-md-6">
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
                                    <?php
                                    if (!empty($listAsesmenKebidanan)) {
                                        foreach ($listAsesmenKebidanan as $item) {
                                    ?>
                                            <tr>
                                                <td style="text-align: left;"><a class="btn <?php echo $item->tanggal_final != null ? 'btn-success' : 'btn-danger' ?> btn-sm btn-lihat-asesmen" href="<?= Url::to(['/riwayat-pasien/preview-asesmen-awal-kebidanan', 'id' => $item->id]) ?>" data-id="<?= $item->id
                                                                                                                                                                                                                                                                                                        ?>" data-nama="<?= $item->id
                                                                                                                                                                                                                                                                                                                        ?>"> Asesmen Keperawatan , <b>STATUS : <?php echo $item->is_deleted == 0 ? ($item->draf == 1 ? 'DRAFT' : 'FINAL') : 'BATAL' ?> - <?= $item->layanan->unit->nama ?? '' ?> - <?= $item->perawat->nama_lengkap ?? '' ?>Tanggal : <?= $item->tanggal_final ?? '' ?></a></td>
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
                                </div>
                            </div>

                        </div>

                    </div>
                    <div class="row">
                        <div class="col-md-6">
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
                                                    <td style="text-align: left;"><a class="btn <?php echo $item->is_deleted == 0 ? 'btn-success' : 'btn-danger' ?> btn-sm btn-lihat-asesmen" href="<?= Url::to(['/riwayat-pasien/preview-asesmen-awal-medis', 'id' => $item->id]) ?>" data-id="<?= $item->id
                                                                                                                                                                                                                                                                                                ?>" data-nama="<?= $item->id
                                                                                                                                                                                                                                                                                                                ?>"> <?= $i ?> . Asesmen Medis, <b>STATUS : <?php echo $item->is_deleted == 0 ? ($item->draf == 1 ? 'DRAFT' : 'FINAL') : 'BATAL' ?> - <?= $item->layanan->unit->nama ?? '' ?> - <?= $item->dokter->nama_lengkap ?? '' ?> <br>Tanggal : <?= $item->tanggal_final ?? '' ?></a></td>
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

                        <div class="col-md-6">
                            <div class="card card-info collapsed-card">
                                <div class="card-header">
                                    <h3 class="card-title">HASIL PENUNJANG (Laboratorium, Radiologi Dll)</h3>
                                    <div class="card-tools">
                                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                            <i class="fas fa-plus"></i>
                                        </button>
                                    </div>

                                </div>

                                <div class="card-body">
                                    <table class="table table-striped table-bordered" style="text-align: justify;">


                                        <tr>
                                            <td style="text-align: left;"><a class="btn btn-success btn-sm" target="_blank" href="http://emr-penunjang.simrs.aa/hasil/list-lis?no_rm=<?= $registrasi['pasien']['kode'] ?>">HASIL LABORATORIUM <i class="fas fa-eye fa-sm"></i></a></td>
                                        </tr>
                                        <tr>
                                            <td style="text-align: left;"><a class="btn btn-success btn-sm" target="_blank" href="http://emr-penunjang.simrs.aa/hasil/pacs-lis?no_rm=<?= $registrasi['pasien']['kode'] ?>">HASIL RADIOLOGI <i class="fas fa-eye fa-sm"></i></a></td>
                                        </tr>
                                        <tr>
                                            <td style="text-align: left;"><a class="btn btn-success btn-sm" target="_blank" href="http://emr-penunjang.simrs.aa/hasil/pa-lis?no_rm=<?= $registrasi['pasien']['kode'] ?>">HASIL PATOLOGI ANATOMI <i class="fas fa-eye fa-sm"></i></a></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>

                        </div>





                    </div>


                    <div class="row">
                        <div class="col-md-6">
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
                                            $i = 1;
                                            foreach ($listLaporanOperasi as $item) {
                                        ?>

                                                <tr>
                                                    <td style="text-align: left;"><a class="btn btn-success btn-sm" target="_blank" href="http://bedah-sentral.simrs.aa/cetak/cetak-laporan-operasi?laporan_id=<?= $item['lap_op_id'] ?>" data-id="<?= $item['lap_op_id']
                                                                                                                                                                                                                                                    ?>" data-nama="<?= $item['lap_op_id']
                                                                                                                                                                                                                                                                    ?>"> <?= $item['lap_op_created_at']
                                                                                                                                                                                                                                                                            ?> <i class="fas fa-eye fa-sm"></i></a></td>


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


                        <div class="col-md-6">
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
                                                <td style="text-align: left;"><a class="btn btn-success btn-sm btn-lihat-operasi" href="<?= Url::to(['/riwayat-pasien/preview-laporan-anastesi', 'id' => $item['api_id']]) ?>" data-id="<?= $item['api_id']
                                                                                                                                                                                                                                        ?>" data-nama="<?= $item['api_id']
                                                                                                                                                                                                                                                        ?>"> <?= $item['api_tgl_final']
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
                        <div class="col-md-6">
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
                                                                                                                                        '/riwayat-pasien/preview-cppt',
                                                                                                                                        'id' => $registrasi['kode'],

                                                                                                                                    ]) ?>">Dokumen CPPT<i class="fas fa-eye fa-sm"></i></a></td>
                                        </tr>


                                    </table>
                                </div>
                            </div>

                        </div>


                        <div class="col-md-6">
                            <div class="card card-info collapsed-card">
                                <div class="card-header">
                                    <h3 class="card-title">RESUME MEDIS RAWATINAP</h3>
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
                                                    <td style="text-align: left;"><a class="btn btn-success btn-sm btn-lihat-operasi" href="<?= Url::to(['/riwayat-pasien/preview-resume-medis', 'id' => $item['id']]) ?>" data-id="<?= $item['id']
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
                        <div class="col-md-6">
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
                        <div class="col-md-6">
                            <div class="card card-info collapsed-card">
                                <div class="card-header">
                                    <h3 class="card-title">RESUME MEDIS RAWATJALAN</h3>
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
                                                <td style="text-align: left;"><a class="btn btn-success btn-sm btn-preview-resume-rj" href="<?= Url::to(['/riwayat-pasien/preview-resume-medis-rj', 'id' => $item['id']]) ?>" data-id="<?= $item['id']
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
                                    <!-- <a href="#" class="btn btn-flat btn-success btn-sbpk" data-id="<?php echo $registrasi['kode'] ?>"><i class="fa fa-search"></i> Lihat SBPK</a>-->
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
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
                </div>
            </div>


        </div>

    </div>

</div>
</div>
</div>