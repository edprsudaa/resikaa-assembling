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

$this->title = 'Riwayat Pasien Berdasarkan Kunjungan';
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
$('.btn-ringkasan-pulang-igd').on('click', function (){
    $.get($(this).attr('href'), function(data) {
        $('.mymodal_card_xl_body').html(data);
        $('.mymodal_card_xl').modal('show');
   });
   return false;
});
$('.btn-triase-igd').on('click', function (){
    $.get($(this).attr('href'), function(data) {
        $('.mymodal_card_xl_body').html(data);
        $('.mymodal_card_xl').modal('show');
   });
   return false;
});

//detail riwayat konsultasi
$('.tb-riwayat-konsultasi tbody tr td').on('click','.btn-detail',function(e){
    console.log('tes')
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
$('.btn-obat-terjual').click(function(e){
	e.preventDefault();
	var id=$(this).attr('data-id');
	if(id){
		$.post('" . Url::to(['detail-obat-terjual-farmasi']) . "',{id:id},function(res){
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
                        <div class="col-md-4">
                            No Registrasi : <br>
                            <b class="widget-user-username"><?= $registrasi['kode'] ?></b>
                        </div>
                        <div class="col-md-4">
                            Tgl. Kunjungan : <br>
                            <b class="widget-user-username"><?= $registrasi['tgl_masuk'] ?></b>
                        </div>
                        <div class="col-md-4">
                            Poli/Ruangan : <br>
                            <?php
                            $units = array();
                            foreach ($registrasi['layanan'] as $value) {
                                $unitName = $value['unit']['nama'];
                                if (!in_array($unitName, $units)) {
                                    $units[] = $unitName;
                                    if ($value['jenis_layanan'] == 1) {
                                        echo '<span class="right badge badge-danger">' . $unitName . '</span> ';
                                    } elseif ($value['jenis_layanan'] == 2) {
                                        echo '<span class="right badge badge-info">' . $unitName . '</span> ';
                                    } elseif ($value['jenis_layanan'] == 3) {
                                        echo '<span class="right badge badge-success">' . $unitName . '</span> ';
                                    } else {
                                        echo '<span class="right badge badge-warning">' . $unitName . '</span> ';
                                    }
                                }
                            } ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card card-info <?php
                                                        if (empty($listAsesmenKeperawatan)) {
                                                            echo 'collapsed-card';
                                                        }

                                                        ?>">
                                <div class="card-header">
                                    <h3 class="card-title">ASESMEN AWAL KEPERAWATAN</h3>
                                    <div class="card-tools">
                                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                            <i class="fas fa-plus"></i>
                                        </button>
                                    </div>

                                </div>

                                <div class="card-body">
                                    <div class="table-responsive">

                                        <table class="table table-striped table-bordered" style="text-align: justify;width:100%">
                                            <tr class="bg-info">
                                                <th>No</th>
                                                <th>No Registrasi</th>
                                                <th>Tgl. Masuk</th>

                                                <th>Tgl. Buat</th>
                                                <th>Tgl. Final</th>

                                                <th>Perawat</th>
                                                <th>Ruangan</th>

                                                <th>Status</th>
                                                <th>Aksi</th>




                                            </tr>
                                            <?php
                                            if (!empty($listAsesmenKeperawatan)) {
                                                $i = 1;
                                                foreach ($listAsesmenKeperawatan as $item) {

                                            ?>
                                                    <tr>
                                                        <td><?= $i ?></td>
                                                        <td><?= $item->layanan->registrasi->kode ?? '' ?></td>
                                                        <td><?= $item->layanan->registrasi->tgl_masuk ?? '' ?></td>

                                                        <td><?= $item['created_at'] ?? '' ?></td>
                                                        <td><?= $item['tanggal_final'] ?? '' ?></td>

                                                        <td><?= $item->perawat->nama_lengkap ?? '' ?></td>
                                                        <td><?= $item->layanan->unit->nama ?? '' ?></td>
                                                        <td> <?php echo $item->is_deleted == 0 ? ($item->draf == 1 ? 'DRAFT' : 'FINAL') : 'BATAL' ?></td>
                                                        <td><a class="btn <?php echo $item->is_deleted == 0 ? 'btn-success' : 'btn-danger' ?> btn-sm btn-lihat-asesmen" href="<?= Url::to(['/history-pasien/preview-asesmen-awal-keperawatan', 'id' => HelperGeneralClass::hashData($item->id)]) ?>" data-id="<?= $item->id ?>" data-nama="<?= HelperGeneralClass::hashData($item->id) ?>">Lihat</b> <i class="fas fa-eye"></i></a>
                                                            <a class="btn btn-warning btn-sm" target="_blank" href="<?= Url::to([
                                                                                                                        '/history-pasien/cetak-asesmen-awal-keperawatan',
                                                                                                                        'id' => HelperGeneralClass::hashData($item->id),

                                                                                                                    ]) ?>">Cetak <i class="fas fa-print fa-sm"></i></a>
                                                        </td>
                                                    </tr>

                                                <?php
                                                    $i++;
                                                }
                                            } else {
                                                ?>
                                                <tr>
                                                    <td colspan="9" style="text-align: center;">Tidak ada dokumen</td>
                                                </tr>
                                            <?php

                                            }
                                            ?>
                                        </table>
                                    </div>
                                </div>
                            </div>

                        </div>


                        <div class="col-md-12">
                            <div class="card card-info <?php
                                                        if (empty($listAsesmenKebidanan)) {
                                                            echo 'collapsed-card';
                                                        }

                                                        ?>">
                                <div class="card-header">
                                    <h3 class="card-title">ASESMEN AWAL KEBIDANAN</h3>
                                    <div class="card-tools">
                                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                            <i class="fas fa-plus"></i>
                                        </button>
                                    </div>

                                </div>

                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered" style="text-align: justify;width:100%">

                                            <tr class="bg-info">
                                                <th>No</th>
                                                <th>No Registrasi</th>
                                                <th>Tgl. Masuk</th>

                                                <th>Tgl. Buat</th>
                                                <th>Tgl. Final</th>
                                                <th>Perawat/Bidan</th>
                                                <th>Ruangan</th>

                                                <th>Status</th>
                                                <th>Aksi</th>




                                            </tr>
                                            <?php
                                            if (!empty($listAsesmenKebidanan)) {
                                                $i = 1;
                                                foreach ($listAsesmenKebidanan as $item) {
                                            ?>
                                                    <tr>
                                                        <td><?= $i ?></td>
                                                        <td><?= $item->layanan->registrasi->kode ?? '' ?></td>
                                                        <td><?= $item->layanan->registrasi->tgl_masuk ?? '' ?></td>

                                                        <td><?= $item['created_at'] ?? '' ?></td>
                                                        <td><?= $item['tanggal_final'] ?? '' ?></td>

                                                        <td><?= $item->perawat->nama_lengkap ?? '' ?></td>
                                                        <td><?= $item->layanan->unit->nama ?? '' ?></td>
                                                        <td> <?php echo $item->is_deleted == 0 ? ($item->draf == 1 ? 'DRAFT' : 'FINAL') : 'BATAL' ?></td>
                                                        <td><a class="btn <?php echo $item->is_deleted == 0 ? 'btn-success' : 'btn-danger' ?> btn-sm btn-lihat-asesmen" href="<?= Url::to(['/history-pasien/preview-asesmen-awal-kebidanan', 'id' => HelperGeneralClass::hashData($item->id)]) ?>" data-id="<?= $item->id
                                                                                                                                                                                                                                                                                                            ?>" data-nama="<?= $item->id
                                                                                                                                                                                                                                                                                                                            ?>">Klik untuk lihat</a>
                                                            <a class="btn btn-warning btn-sm" target="_blank" href="<?= Url::to([
                                                                                                                        '/history-pasien/cetak-asesmen-awal-kebidanan',
                                                                                                                        'id' => HelperGeneralClass::hashData($item->id),

                                                                                                                    ]) ?>">Cetak <i class="fas fa-print fa-sm"></i></a>
                                                        </td>
                                                    </tr>
                                                <?php
                                                }
                                            } else {
                                                ?>
                                                <tr>
                                                    <td colspan="9" style="text-align: center;">Tidak ada dokumen</td>
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
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card card-info <?php
                                                        if (empty($listAsesmenMedis)) {
                                                            echo 'collapsed-card';
                                                        }

                                                        ?>">
                                <div class="card-header">
                                    <h3 class="card-title">ASESMEN AWAL MEDIS</h3>
                                    <div class="card-tools">
                                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                            <i class="fas fa-plus"></i>
                                        </button>
                                    </div>

                                </div>

                                <div class="card-body">
                                    <div class="table-responsive">

                                        <table class="table table-striped table-bordered " style="text-align: justify;">

                                            <tr class="bg-info">
                                                <th>No</th>
                                                <th>No Registrasi</th>
                                                <th>Tgl. Masuk</th>

                                                <th>Tgl. Buat</th>
                                                <th>Tgl. Final</th>
                                                <th>Dokter</th>
                                                <th>Ruangan</th>

                                                <th>Status</th>
                                                <th>Aksi</th>




                                            </tr>
                                            <?php
                                            if (!empty($listAsesmenMedis)) {
                                                $i = 1;
                                                foreach ($listAsesmenMedis as $item) {
                                            ?>
                                                    <tr>
                                                        <td><?= $i ?></td>
                                                        <td><?= $item->layanan->registrasi->kode ?? '' ?></td>
                                                        <td><?= $item->layanan->registrasi->tgl_masuk ?? '' ?></td>

                                                        <td><?= $item['created_at'] ?? '' ?></td>
                                                        <td><?= $item['tanggal_final'] ?? '' ?></td>
                                                        <td><?= $item->dokter->nama_lengkap ?? '' ?></td>
                                                        <td><?= $item->layanan->unit->nama ?? '' ?></td>
                                                        <td> <?php echo $item->is_deleted == 0 ? ($item->draf == 1 ? 'DRAFT' : 'FINAL') : 'BATAL' ?></td>
                                                        <td><a class="btn <?php echo $item->is_deleted == 0 ? 'btn-success' : 'btn-danger' ?> btn-sm btn-lihat-asesmen" href="<?= Url::to(['/history-pasien/preview-asesmen-awal-medis', 'id' => HelperGeneralClass::hashData($item->id)]) ?>" data-id="<?= HelperGeneralClass::hashData($item->id)
                                                                                                                                                                                                                                                                                                        ?>" data-nama="<?= HelperGeneralClass::hashData($item->id)
                                                                                                                                                                                                                                                                                                                        ?>">Klik untuk lihat</a>

                                                            <a class="btn btn-warning btn-sm" target="_blank" href="<?= Url::to([
                                                                                                                        '/history-pasien/cetak-asesmen-awal-medis',
                                                                                                                        'id' => HelperGeneralClass::hashData($item->id),

                                                                                                                    ]) ?>">Cetak <i class="fas fa-print fa-sm"></i></a>
                                                        </td>
                                                    </tr>
                                                <?php
                                                    $i++;
                                                }
                                            } else {
                                                ?>
                                                <tr>
                                                    <td colspan="9" style="text-align: center;">Tidak ada dokumen</td>
                                                </tr>
                                            <?php

                                            }
                                            ?>
                                        </table>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="col-md-12">
                            <div class="card card-info">
                                <div class="card-header">
                                    <h3 class="card-title">HASIL PENUNJANG (Laboratorium, Radiologi Dll)</h3>
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

                                            <td style="text-align: left;"><a class="btn btn-success btn-sm" target="_blank" href="http://emr-penunjang.simrs.aa/hasil/expertise-lab-pk?regis=<?= HelperGeneralClass::hashData($registrasi['kode']); ?>">Klik untuk lihat <i class="fas fa-eye fa-sm"></i></a></td>

                                            <td style="text-align: left;"><a class="btn btn-success btn-sm" target="_blank" href="http://emr-penunjang.simrs.aa/hasil/expertise-lab-biomolekuler?regis=<?= HelperGeneralClass::hashData($registrasi['kode']); ?>">Klik untuk lihat <i class="fas fa-eye fa-sm"></i></a></td>
                                            <td style="text-align: left;"><a class="btn btn-success btn-sm" target="_blank" href="http://emr-penunjang.simrs.aa/hasil/expertise-pcr?regis=<?= HelperGeneralClass::hashData($registrasi['kode']); ?>">Klik untuk lihat <i class="fas fa-eye fa-sm"></i></a></td>

                                            <td style="text-align: left;"><a class="btn btn-success btn-sm" target="_blank" href="http://emr-penunjang.simrs.aa/hasil/expertise-radiologi?regis=<?= HelperGeneralClass::hashData($registrasi['kode']); ?>">Klik untuk lihat <i class="fas fa-eye fa-sm"></i></a></td>
                                            <td style="text-align: left;"><a class="btn btn-success btn-sm" target="_blank" href="http://emr-penunjang.simrs.aa/hasil/expertise-echo?regis=<?= HelperGeneralClass::hashData($registrasi['kode']); ?>">Klik untuk lihat <i class="fas fa-eye fa-sm"></i></a></td>

                                            <td style="text-align: left;"><a class="btn btn-success btn-sm" target="_blank" href="http://emr-penunjang.simrs.aa/hasil/expertise-lab-pa?regis=<?= HelperGeneralClass::hashData($registrasi['kode']); ?>">Klik untuk lihat <i class="fas fa-eye fa-sm"></i></a></td>
                                            <td style="text-align: left;"><a class="btn btn-success btn-sm" target="_blank" href="http://emr-penunjang.simrs.aa/hasil/expertise-eswl?regis=<?= HelperGeneralClass::hashData($registrasi['kode']); ?>">Klik untuk lihat <i class="fas fa-eye fa-sm"></i></a></td>
                                            <td style="text-align: left;"><a class="btn btn-success btn-sm" target="_blank" href="http://emr-penunjang.simrs.aa/hasil/expertise-endoskopi?regis=<?= HelperGeneralClass::hashData($registrasi['kode']); ?>">Klik untuk lihat <i class="fas fa-eye fa-sm"></i></a></td>

                                        </tr>

                                    </table>
                                </div>
                            </div>

                        </div>





                    </div>


                    <div class="row">
                        <div class="col-md-12">
                            <div class="card card-info <?php
                                                        if (empty($listLaporanOperasi)) {
                                                            echo 'collapsed-card';
                                                        }

                                                        ?>">
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
                                                    <td> <?php echo $item->lap_op_batal == 0 ? ($item->lap_op_final == 0 ? 'DRAFT' : 'FINAL') : 'BATAL' ?></td>

                                                    <td><a class="btn btn-success btn-sm" target="_blank" href="http://bedah-sentral.simrs.aa/cetak/cetak-laporan-operasi?laporan_id=<?= HelperGeneralClass::hashData($item['lap_op_id']) ?>" data-id="<?= HelperGeneralClass::hashData($item['lap_op_id'])
                                                                                                                                                                                                                                                        ?>" data-nama="<?= HelperGeneralClass::hashData($item['lap_op_id'])
                                                                                                                                                                                                                                                                        ?>">Klik Untuk Lihat</b></a></td>
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


                        <div class="col-md-12">
                            <div class="card card-info <?php
                                                        if (empty($listLaporanAnastesi)) {
                                                            echo 'collapsed-card';
                                                        }

                                                        ?>">
                                <div class="card-header">
                                    <h3 class="card-title">LAPORAN ANASTESI</h3>
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
                                        if (!empty($listLaporanAnastesi)) {
                                            $i = 1;
                                            foreach ($listLaporanAnastesi as $item) {

                                        ?>
                                                <tr>
                                                    <td><?= $i ?></td>
                                                    <td><?= $item['api_created_at'] ?></td>
                                                    <td>
                                                        <?php
                                                        foreach ($item['timoperasi']['timOperasiDetail'] as $key => $value) {
                                                            echo ($key + 1) . '. ' . HelperSpesialClass::getNamaPegawaiArray($value['pegawai']) ?? '';
                                                            echo '<br>';
                                                        }
                                                        ?>
                                                    </td>
                                                    <td><?= $item->lap_op_ruangan ?? '' ?></td>
                                                    <td> <?php echo $item->api_batal == 0 ? ($item->api_final == 0 ? 'DRAFT' : 'FINAL') : 'BATAL' ?></td>

                                                    <td><a class="btn btn-success btn-sm" target="_blank" href="http://bedah-sentral.simrs.aa/cetak/cetak-laporan-anestesi?laporan_id=<?= HelperGeneralClass::hashData($item['api_id'])  ?>" data-id="<?= HelperGeneralClass::hashData($item['api_id'])
                                                                                                                                                                                                                                                        ?>" data-nama="<?= HelperGeneralClass::hashData($item['api_id'])
                                                                                                                                                                                                                                                                        ?>">Klik Untuk Lihat</b></a></td>
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
                            <div class="card card-info">
                                <div class="card-header">
                                    <h3 class="card-title">CPPT</h3>
                                    <div class="card-tools">
                                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                            <i class="fas fa-plus"></i>
                                        </button>
                                    </div>

                                </div>

                                <div class="card-body">
                                    <table class="table table-striped table-bordered " style="text-align: justify;">
                                        <tr class="bg-info">
                                            <th>No Registrasi</th>
                                            <th>Unit</th>

                                            <th>Tanggal Masuk</th>
                                            <th>Tanggal Keluar</th>

                                            <th>Aksi</th>




                                        </tr>


                                        <tr>
                                            <td><?= $registrasi['kode'] ?></td>
                                            <td><?php
                                                $units = array();
                                                foreach ($registrasi['layanan'] as $value) {
                                                    $unitName = $value['unit']['nama'];
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
                                            <td><?= $registrasi['tgl_masuk'] ?? '' ?></td>
                                            <td><?= $registrasi['tgl_keluar'] ?? '' ?></td>
                                            <td style="text-align: left;"><a class="btn btn-success btn-sm btn-lihat-asesmen" href="<?= Url::to([
                                                                                                                                        '/history-pasien/preview-cppt',
                                                                                                                                        'id' => HelperGeneralClass::hashData($registrasi['kode']),

                                                                                                                                    ]) ?>">Lihat <i class="fas fa-eye fa-sm"></i></a>
                                                <a class="btn btn-warning btn-sm" target="_blank" href="<?= Url::to([
                                                                                                            '/history-pasien/cetak-cppt',
                                                                                                            'id' => HelperGeneralClass::hashData($registrasi['kode']),

                                                                                                        ]) ?>">Cetak <i class="fas fa-print fa-sm"></i></a>
                                            </td>
                                        </tr>


                                    </table>
                                </div>
                            </div>

                        </div>


                        <div class="col-md-12">
                            <div class="card card-info <?php
                                                        if (empty($listResumeMedis)) {
                                                            echo 'collapsed-card';
                                                        }

                                                        ?>">
                                <div class="card-header">
                                    <h3 class="card-title">RESUME MEDIS RAWATINAP</h3>
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
                                                    <td><?= $item['created_at'] ?? '' ?></td>
                                                    <td><?= HelperSpesialClass::getNamaPegawaiArray($item->dokter) ?? '' ?></td>
                                                    <td><?= $item->layanan->unit->nama ?? '' ?>
                                                    </td>
                                                    <td><a class="btn <?php echo $item->is_deleted == 0 ? 'btn-success' : 'btn-danger' ?> btn-sm btn-sm btn-lihat-operasi" href="<?= Url::to(['/history-pasien/preview-resume-medis', 'id' => HelperGeneralClass::hashData($item->id)]) ?>" data-id="<?= HelperGeneralClass::hashData($item->id)
                                                                                                                                                                                                                                                                                                        ?>" data-nama="<?= HelperGeneralClass::hashData($item->id)
                                                                                                                                                                                                                                                                                                                        ?>">Klik untuk lihat</a>
                                                        <a class="btn btn-warning btn-sm" target="_blank" href="http://medis.simrs.aa/pasien-resume-medis-ri/cetak?subid=<?= HelperGeneralClass::hashData($item->id) ?>">Cetak <i class="fas fa-print fa-sm"></i></a>
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
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card card-info <?php
                                                        if (empty($list_konsultasi)) {
                                                            echo 'collapsed-card';
                                                        }

                                                        ?>">
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
                                                    <td><?= $lk['layananMinta']['registrasi_kode'] ?? '' ?></td>

                                                    <td><?= (!empty($lk['dokterMinta']) ? HelperSpesialClass::getNamaPegawaiArray($lk['dokterMinta']) : '-') ?></td>
                                                    <td><?= (!empty($lk['dokterTujuan']) ? HelperSpesialClass::getNamaPegawaiArray($lk['dokterTujuan']) : '-') ?></td>

                                                    <td><?php echo $lk['layananMinta'] != NULL ? ($lk['layananMinta']['unit'] != NULL ? $lk['layananMinta']['unit']['nama'] : '') : '' ?></td>
                                                    <td><?php echo $lk['unitTujuan'] != NULL ? $lk['unitTujuan']['nama'] : '' ?></td>
                                                    <td><?php $dokter = array();
                                                        foreach ($lk['jawabanKonsultasi'] as $value) {
                                                            $unitName = HelperSpesialClass::getNamaPegawaiArray($value['dokterJawab']);
                                                            if (!in_array($unitName, $dokter)) {
                                                                $units[] = $unitName;

                                                                echo '<span class="right badge badge-danger">' . $unitName . '</span><br>';
                                                            }
                                                        } ?></td>

                                                    <td><a href="#" title="klik untuk melihat detail konsultasi" class="btn btn-flat btn-success btn-sm btn-detail" data-id='<?php echo HelperGeneralClass::hashData($lk['id']); ?>'>Lihat <i class="fa fa-eye"></i></a>
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
                        <div class="col-md-12">
                            <div class="card card-info <?php
                                                        if (empty($listResumeMedisRj)) {
                                                            echo 'collapsed-card';
                                                        }

                                                        ?>">
                                <div class="card-header">
                                    <h3 class="card-title">RESUME MEDIS RAWATJALAN</h3>
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
                                        if (!empty($listResumeMedisRj)) {
                                            $i = 1;
                                            foreach ($listResumeMedisRj as $item) {
                                        ?>
                                                <tr>
                                                    <td><?= $i ?></td>
                                                    <td><?= $item['created_at'] ?? '' ?></td>
                                                    <td><?= HelperSpesialClass::getNamaPegawaiArray($item->dokter) ?? '' ?></td>
                                                    <td><?= $item->layanan->unit->nama ?? '' ?>
                                                    </td>
                                                    <td><a class="btn <?php echo $item->is_deleted == 0 ? 'btn-success' : 'btn-danger' ?> btn-sm btn-sm btn-preview-resume-rj" href="<?= Url::to(['/riwayat-pasien/preview-resume-medis-rj', 'id' => HelperGeneralClass::hashData($item->id)]) ?>" data-id="<?= HelperGeneralClass::hashData($item->id)
                                                                                                                                                                                                                                                                                                            ?>" data-nama="<?= HelperGeneralClass::hashData($item->id)
                                                                                                                                                                                                                                                                                                                            ?>">Klik untuk lihat</a>

                                                        <a class="btn btn-warning btn-sm" target="_blank" href="http://medis.simrs.aa/pasien-resume-medis-rj/cetak?subid=<?= HelperGeneralClass::hashData($item->id) ?>">Cetak <i class="fas fa-print fa-sm"></i></a>
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
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card card-info <?php
                                                        if (empty($resep)) {
                                                            echo 'collapsed-card';
                                                        }

                                                        ?>">
                                <div class="card-header">
                                    <h3 class="card-title">RESEP OBAT</h3>
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
                                            <th>Registrasi</th>

                                            <th>Dokter</th>
                                            <th>Depo</th>


                                            <th>Aksi</th>




                                        </tr>
                                        <?php
                                        if (!empty($resep)) {
                                            $i = 1;
                                            foreach ($resep as $r) {
                                        ?>
                                                <tr>
                                                    <td><?= $i ?></td>
                                                    <td><?= $r['tanggal'] ?? '' ?></td>
                                                    <td><?= $r['layanan']['registrasi_kode'] ?? '' ?></td>

                                                    <td><?= (!empty($r['dokter']) ? HelperSpesialClass::getNamaPegawaiArray($r['dokter']) : '') ?></td>
                                                    <td><?= $r['depo'] != null ? $r['depo']['nama'] : '' ?></td>

                                                    <td> <a href="#" class="btn btn-sm btn-flat btn-resep <?php echo $r['is_deleted'] == 0 ? 'btn-success' : 'btn-danger' ?>" data-id="<?php echo HelperGeneralClass::hashData($r['id']); ?>">
                                                            Lihat <i class="fa fa-eye"></i>
                                                        </a>
                                                        <a class="btn btn-warning btn-sm" target="_blank" href="<?= Url::to([
                                                                                                                    '/history-pasien/cetak-resep-dokter',
                                                                                                                    'id' => HelperGeneralClass::hashData($r['id'])

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
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card card-info <?php
                                                        if (empty($penjualanObat)) {
                                                            echo 'collapsed-card';
                                                        }

                                                        ?>">
                                <div class="card-header">
                                    <h3 class="card-title">OBAT TERJUAL</h3>
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
                                            <th>Registrasi</th>

                                            <th>Dokter</th>
                                            <th>Depo</th>


                                            <th>Aksi</th>




                                        </tr>
                                        <?php
                                        if (!empty($penjualanObat)) {
                                            $i = 1;
                                            foreach ($penjualanObat as $r) {
                                        ?>
                                                <tr>
                                                    <td><?= $i ?></td>
                                                    <td><?= $r['tgl_resep'] ?? '' ?></td>
                                                    <td><?= $r['no_daftar'] ?? '' ?></td>

                                                    <td><?= (!empty($r['dokter']) ? HelperSpesialClass::getNamaPegawaiArray($r['dokter']) : '') ?></td>
                                                    <td><?= $r['depo'] != null ? $r['depo']['nama'] : '' ?></td>

                                                    <td> <a href="#" class="btn btn-sm btn-flat btn-obat-terjual <?php echo $r['is_deleted'] == 0 ? 'btn-success' : 'btn-danger' ?>" data-id="<?php echo HelperGeneralClass::hashData($r['id_penjualan']); ?>">
                                                            Klik untuk lihat <i class="fa fa-eye"></i>
                                                        </a>
                                                        <a class="btn btn-warning btn-sm" target="_blank" href="<?= Url::to([
                                                                                                                    '/history-pasien/cetak-obat-terjual-farmasi',
                                                                                                                    'id' => HelperGeneralClass::hashData($r['id_penjualan'])

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
                        <div class="col-md-12">
                            <div class="card card-info">
                                <div class="card-header">
                                    <h3 class="card-title">RINCIAN BIAYA</h3>
                                    <div class="card-tools">
                                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                            <i class="fas fa-plus"></i>
                                        </button>
                                    </div>

                                </div>

                                <div class="card-body">
                                    <table class="table table-striped table-bordered " style="text-align: justify;">
                                        <tr class="bg-info">
                                            <th>No Registrasi</th>
                                            <th>Unit</th>

                                            <th>Tanggal Masuk</th>
                                            <th>Tanggal Keluar</th>

                                            <th>Aksi</th>




                                        </tr>


                                        <tr>
                                            <td><?= $registrasi['kode'] ?></td>
                                            <td><?php
                                                $units = array();
                                                foreach ($registrasi['layanan'] as $value) {
                                                    $unitName = $value['unit']['nama'];
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
                                            <td><?= $registrasi['tgl_masuk'] ?? '' ?></td>
                                            <td><?= $registrasi['tgl_keluar'] ?? '' ?></td>
                                            <td style="text-align: left;">
                                                <a class="btn btn-warning btn-sm" target="_blank" href=http://emr-kasbank.simrs.aa/site/rincian-biaya-perawatan-detail-public?id=<?= HelperGeneralClass::hashData($registrasi['pasien']['kode'] . '_' . $registrasi['kode'] . '_' . date('d/m/Y')) ?>>Cetak <i class="fas fa-print fa-sm"></i></a>
                                            </td>
                                        </tr>


                                    </table>
                                </div>
                            </div>

                        </div>
                        <div class="col-md-12">
                            <div class="card card-info <?php
                                                        if (empty($listLaporanChecklisKeselamatan)) {
                                                            echo 'collapsed-card';
                                                        }

                                                        ?>">
                                <div class="card-header">
                                    <h3 class="card-title">LAPORAN CHECKLIST KESELAMATAN OPERASI </h3>
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
                                        if (!empty($listLaporanChecklisKeselamatan)) {
                                            $i = 1;
                                            foreach ($listLaporanChecklisKeselamatan as $item) {

                                        ?>
                                                <tr>
                                                    <td><?= $i ?></td>
                                                    <td><?= $item['pcok_created_at'] ?></td>
                                                    <td>
                                                        <?php
                                                        foreach ($item['timoperasi']['timOperasiDetail'] as $key => $value) {
                                                            echo ($key + 1) . '. ' . HelperSpesialClass::getNamaPegawaiArray($value['pegawai']) ?? '';
                                                            echo '<br>';
                                                        }
                                                        ?>
                                                    </td>
                                                    <td><?= $item->lap_op_ruangan ?? '' ?></td>
                                                    <td> <?php echo $item->pcok_batal == 0 ? ($item->pcok_final == 0 ? 'DRAFT' : 'FINAL') : 'BATAL' ?></td>

                                                    <td><a class="btn btn-success btn-sm" target="_blank" href="http://bedah-sentral.simrs.aa/cetak/cetak-checklist-keselamatan?checklist_id=<?= HelperGeneralClass::hashData($item['pcok_id'])  ?>" data-id="<?= HelperGeneralClass::hashData($item['pcok_id'])
                                                                                                                                                                                                                                                                ?>" data-nama="<?= HelperGeneralClass::hashData($item['pcok_id'])
                                                                                                                                                                                                                                                                                ?>">Klik Untuk Lihat</b></a></td>
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
                        <div class="col-md-12">
                            <div class="card card-info <?php
                                                        if (empty($listLaporanLokasiOperasi)) {
                                                            echo 'collapsed-card';
                                                        }

                                                        ?>">
                                <div class="card-header">
                                    <h3 class="card-title">LAPORAN MARKING OPERASI </h3>
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
                                        if (!empty($listLaporanLokasiOperasi)) {
                                            $i = 1;
                                            foreach ($listLaporanLokasiOperasi as $item) {

                                        ?>
                                                <tr>
                                                    <td><?= $i ?></td>
                                                    <td><?= $item['mlo_created_at'] ?></td>
                                                    <td>
                                                        <?php
                                                        foreach ($item['timoperasi']['timOperasiDetail'] as $key => $value) {
                                                            echo ($key + 1) . '. ' . HelperSpesialClass::getNamaPegawaiArray($value['pegawai']) ?? '';
                                                            echo '<br>';
                                                        }
                                                        ?>
                                                    </td>
                                                    <td><?= $item->lap_op_ruangan ?? '' ?></td>
                                                    <td> <?php echo $item->mlo_batal == 0 ? ($item->mlo_final == 0 ? 'DRAFT' : 'FINAL') : 'BATAL' ?></td>

                                                    <td><a class="btn btn-success btn-sm" target="_blank" href="http://bedah-sentral.simrs.aa/cetak/cetak-marking?marking_id=<?= HelperGeneralClass::hashData($item['mlo_id'])  ?>" data-id="<?= HelperGeneralClass::hashData($item['mlo_id'])
                                                                                                                                                                                                                                                ?>" data-nama="<?= HelperGeneralClass::hashData($item['mlo_id'])
                                                                                                                                                                                                                                                                ?>">Klik Untuk Lihat</b></a></td>
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

                        <div class="col-md-12">
                            <div class="card card-info <?php
                                                        if (empty($listLaporanPembatalanOperasi)) {
                                                            echo 'collapsed-card';
                                                        }

                                                        ?>">
                                <div class="card-header">
                                    <h3 class="card-title">LAPORAN PEMBATALAN OPERASI </h3>
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

                                            <th>Status</th>
                                            <th>Aksi</th>




                                        </tr>
                                        <?php
                                        if (!empty($listLaporanPembatalanOperasi)) {
                                            $i = 1;
                                            foreach ($listLaporanPembatalanOperasi as $item) {

                                        ?>
                                                <tr>
                                                    <td><?= $i ?></td>

                                                    <td><?= $item['bat_created_at'] ?></td>
                                                    <td>
                                                        <?php
                                                        foreach ($item['timoperasi']['timOperasiDetail'] as $key => $value) {
                                                            echo ($key + 1) . '. ' . HelperSpesialClass::getNamaPegawaiArray($value['pegawai']) ?? '';
                                                            echo '<br>';
                                                        }
                                                        ?>
                                                    </td>
                                                    <td> <?php echo $item->bat_batal == 0 ? ($item->bat_final == 0 ? 'DRAFT' : 'FINAL') : 'BATAL' ?></td>

                                                    <td><a class="btn btn-success btn-sm" target="_blank" href="http://bedah-sentral.simrs.aa/cetak/cetak-pembatalan-operasi?id=<?= HelperGeneralClass::hashData($item['bat_id'])  ?>" data-id="<?= HelperGeneralClass::hashData($item['bat_id'])
                                                                                                                                                                                                                                                ?>" data-nama="<?= HelperGeneralClass::hashData($item['bat_id'])
                                                                                                                                                                                                                                                                ?>">Klik Untuk Lihat</b></a></td>
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
                        <div class="col-md-12">
                            <div class="card card-info <?php
                                                        if (empty($listLaporanIntraOperasi)) {
                                                            echo 'collapsed-card';
                                                        }

                                                        ?>">
                                <div class="card-header">
                                    <h3 class="card-title">LAPORAN INTRA OPERASI </h3>
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

                                            <th>Status</th>
                                            <th>Aksi</th>




                                        </tr>
                                        <?php
                                        if (!empty($listLaporanIntraOperasi)) {
                                            $i = 1;
                                            foreach ($listLaporanIntraOperasi as $item) {

                                        ?>
                                                <tr>
                                                    <td><?= $i ?></td>

                                                    <td><?= $item['iop_created_at'] ?></td>
                                                    <td>
                                                        <?php
                                                        foreach ($item['timoperasi']['timOperasiDetail'] as $key => $value) {
                                                            echo ($key + 1) . '. ' . HelperSpesialClass::getNamaPegawaiArray($value['pegawai']) ?? '';
                                                            echo '<br>';
                                                        }
                                                        ?>
                                                    </td>
                                                    <td> <?php echo $item->iop_batal == 0 ? ($item->iop_final == 0 ? 'DRAFT' : 'FINAL') : 'BATAL' ?></td>

                                                    <td><a class="btn btn-success btn-sm" target="_blank" href="http://bedah-sentral.simrs.aa/cetak/cetak-intra-operasi?intra_id=<?= HelperGeneralClass::hashData($item['iop_id'])  ?>" data-id="<?= HelperGeneralClass::hashData($item['iop_id'])
                                                                                                                                                                                                                                                    ?>" data-nama="<?= HelperGeneralClass::hashData($item['iop_id'])
                                                                                                                                                                                                                                                                    ?>">Klik Untuk Lihat</b></a></td>
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
                        <div class="col-md-12">
                            <div class="card card-info <?php
                                                        if (empty($listLaporanPostOperasi)) {
                                                            echo 'collapsed-card';
                                                        }

                                                        ?>">
                                <div class="card-header">
                                    <h3 class="card-title">LAPORAN POST OPERASI </h3>
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

                                            <th>Status</th>
                                            <th>Aksi</th>




                                        </tr>
                                        <?php
                                        if (!empty($listLaporanPostOperasi)) {
                                            $i = 1;
                                            foreach ($listLaporanPostOperasi as $item) {

                                        ?>
                                                <tr>
                                                    <td><?= $i ?></td>

                                                    <td><?= $item['psop_created_at'] ?></td>
                                                    <td>
                                                        <?php
                                                        foreach ($item['timoperasi']['timOperasiDetail'] as $key => $value) {
                                                            echo ($key + 1) . '. ' . HelperSpesialClass::getNamaPegawaiArray($value['pegawai']) ?? '';
                                                            echo '<br>';
                                                        }
                                                        ?>
                                                    </td>
                                                    <td> <?php echo $item->psop_batal == 0 ? ($item->psop_final == 0 ? 'DRAFT' : 'FINAL') : 'BATAL' ?></td>

                                                    <td><a class="btn btn-success btn-sm" target="_blank" href="http://bedah-sentral.simrs.aa/cetak/cetak-post-operasi?psop_id=<?= HelperGeneralClass::hashData($item['psop_id'])  ?>" data-id="<?= HelperGeneralClass::hashData($item['psop_id'])
                                                                                                                                                                                                                                                ?>" data-nama="<?= HelperGeneralClass::hashData($item['psop_id'])
                                                                                                                                                                                                                                                                ?>">Klik Untuk Lihat</b></a></td>
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
                        <div class="col-md-12">
                            <div class="card card-info <?php
                                                        if (empty($listLaporanInstrumentKasa)) {
                                                            echo 'collapsed-card';
                                                        }

                                                        ?>">
                                <div class="card-header">
                                    <h3 class="card-title">LAPORAN INSTRUMEN KASA OPERASI </h3>
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

                                            <th>Status</th>
                                            <th>Aksi</th>




                                        </tr>
                                        <?php
                                        if (!empty($listLaporanInstrumentKasa)) {
                                            $i = 1;
                                            foreach ($listLaporanInstrumentKasa as $item) {

                                        ?>
                                                <tr>
                                                    <td><?= $i ?></td>

                                                    <td><?= $item['pjki_created_at'] ?></td>
                                                    <td>
                                                        <?php
                                                        foreach ($item['timoperasi']['timOperasiDetail'] as $key => $value) {
                                                            echo ($key + 1) . '. ' . HelperSpesialClass::getNamaPegawaiArray($value['pegawai']) ?? '';
                                                            echo '<br>';
                                                        }
                                                        ?>
                                                    </td>
                                                    <td> <?php echo $item->pjki_batal == 0 ? ($item->pjki_final == 0 ? 'DRAFT' : 'FINAL') : 'BATAL' ?></td>

                                                    <td><a class="btn btn-success btn-sm" target="_blank" href="http://bedah-sentral.simrs.aa/cetak/cetak-jumlah-kasa?pjki_id=<?= HelperGeneralClass::hashData($item['pjki_id'])  ?>" data-id="<?= HelperGeneralClass::hashData($item['pjki_id'])
                                                                                                                                                                                                                                                ?>" data-nama="<?= HelperGeneralClass::hashData($item['pjki_id'])
                                                                                                                                                                                                                                                                ?>">Klik Untuk Lihat</b></a></td>
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
                        <div class="col-md-12">
                            <div class="card card-info <?php
                                                        if (empty($listPreOperasiPerawatOk)) {
                                                            echo 'collapsed-card';
                                                        }

                                                        ?>">
                                <div class="card-header">
                                    <h3 class="card-title">LAPORAN ASKEP PRE OPERASI PERAWAT </h3>
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

                                            <th>Status</th>
                                            <th>Aksi</th>




                                        </tr>
                                        <?php
                                        if (!empty($listPreOperasiPerawatOk)) {
                                            $i = 1;
                                            foreach ($listPreOperasiPerawatOk  as $item) {

                                        ?>
                                                <tr>
                                                    <td><?= $i ?></td>
                                                    <td><?= $item['pop_created_at'] ?></td>

                                                    <td>
                                                        <?php
                                                        foreach ($item['timoperasi']['timOperasiDetail'] as $key => $value) {
                                                            echo ($key + 1) . '. ' . HelperSpesialClass::getNamaPegawaiArray($value['pegawai']) ?? '';
                                                            echo '<br>';
                                                        }
                                                        ?>
                                                    </td>
                                                    <td> <?php echo $item->pop_batal_ok == 0 ? ($item->pop_final_ok == 0 ? 'DRAFT' : 'FINAL') : 'BATAL' ?></td>

                                                    <td><a class="btn btn-success btn-sm" target="_blank" href="http://bedah-sentral.simrs.aa/cetak/cetak-pre-operasi?pre_id=<?= HelperGeneralClass::hashData($item['pop_id']) ?>" data-id="<?= $item['pop_id']
                                                                                                                                                                                                                                            ?>" data-nama="<?= $item['pop_id']
                                                                                                                                                                                                                                                            ?>">Klik Untuk Lihat</b></a></td>
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
                        <div class="col-md-12">
                            <div class="card card-info <?php
                                                        if (empty($listLembarEdukasiTindakanAnestesi)) {
                                                            echo 'collapsed-card';
                                                        }

                                                        ?>">
                                <div class="card-header">
                                    <h3 class="card-title">LAPORAN LEMBAR EDUKASI ANESTESI
                                    </h3>
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

                                            <th>Status</th>
                                            <th>Aksi</th>




                                        </tr>
                                        <?php
                                        if (!empty($listLembarEdukasiTindakanAnestesi)) {
                                            $i = 1;
                                            foreach ($listLembarEdukasiTindakanAnestesi  as $item) {

                                        ?>
                                                <tr>
                                                    <td><?= $i ?></td>
                                                    <td><?= $item['leta_created_at'] ?></td>

                                                    <td>
                                                        <?php
                                                        foreach ($item['timoperasi']['timOperasiDetail'] as $key => $value) {
                                                            echo ($key + 1) . '. ' . HelperSpesialClass::getNamaPegawaiArray($value['pegawai']) ?? '';
                                                            echo '<br>';
                                                        }
                                                        ?>
                                                    </td>
                                                    <td> <?php echo $item->leta_batal == 0 ? ($item->leta_final == 0 ? 'DRAFT' : 'FINAL') : 'BATAL' ?></td>

                                                    <td><a class="btn btn-success btn-sm" target="_blank" href="http://bedah-sentral.simrs.aa/cetak/cetak-lembar-edukasi?leta_id=<?= HelperGeneralClass::hashData($item['leta_id']) ?>" data-id="<?= $item['leta_id']
                                                                                                                                                                                                                                                    ?>" data-nama="<?= $item['leta_id']
                                                                                                                                                                                                                                                                    ?>">Klik Untuk Lihat</b></a></td>
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
                        <div class="col-md-12">
                            <div class="card card-info <?php
                                                        if (empty($listPraAnestesi)) {
                                                            echo 'collapsed-card';
                                                        }

                                                        ?>">
                                <div class="card-header">
                                    <h3 class="card-title">LAPORAN PRA ANESTESI
                                    </h3>
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

                                            <th>Status</th>
                                            <th>Aksi</th>




                                        </tr>
                                        <?php
                                        if (!empty($listPraAnestesi)) {
                                            $i = 1;
                                            foreach ($listPraAnestesi  as $item) {

                                        ?>
                                                <tr>
                                                    <td><?= $i ?></td>
                                                    <td><?= $item['ppa_created_at'] ?></td>

                                                    <td>
                                                        <?php
                                                        foreach ($item['timoperasi']['timOperasiDetail'] as $key => $value) {
                                                            echo ($key + 1) . '. ' . HelperSpesialClass::getNamaPegawaiArray($value['pegawai']) ?? '';
                                                            echo '<br>';
                                                        }
                                                        ?>
                                                    </td>
                                                    <td> <?php echo $item->ppa_batal == 0 ? ($item->ppa_final == 0 ? 'DRAFT' : 'FINAL') : 'BATAL' ?></td>

                                                    <td><a class="btn btn-success btn-sm" target="_blank" href="http://bedah-sentral.simrs.aa/cetak/cetak-askan-pra-anestesi?ppa_id=<?= HelperGeneralClass::hashData($item['ppa_id']) ?>" data-id="<?= $item['ppa_id']
                                                                                                                                                                                                                                                    ?>" data-nama="<?= $item['ppa_id']
                                                                                                                                                                                                                                                                    ?>">Klik Untuk Lihat</b></a></td>
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
                        <div class="col-md-12">
                            <div class="card card-info <?php
                                                        if (empty($listCatatanLokalAnestesi)) {
                                                            echo 'collapsed-card';
                                                        }

                                                        ?>">
                                <div class="card-header">
                                    <h3 class="card-title">LAPORAN CATATAN LOKAL ANESTESI

                                    </h3>
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

                                            <th>Status</th>
                                            <th>Aksi</th>




                                        </tr>
                                        <?php
                                        if (!empty($listCatatanLokalAnestesi)) {
                                            $i = 1;
                                            foreach ($listCatatanLokalAnestesi  as $item) {

                                        ?>
                                                <tr>
                                                    <td><?= $i ?></td>
                                                    <td><?= $item['cla_created_at'] ?></td>

                                                    <td>
                                                        <?php
                                                        foreach ($item['timoperasi']['timOperasiDetail'] as $key => $value) {
                                                            echo ($key + 1) . '. ' . HelperSpesialClass::getNamaPegawaiArray($value['pegawai']) ?? '';
                                                            echo '<br>';
                                                        }
                                                        ?>
                                                    </td>

                                                    <td> <?php echo $item->cla_batal == 0 ? ($item->cla_final == 0 ? 'DRAFT' : 'FINAL') : 'BATAL' ?></td>

                                                    <td><a class="btn btn-success btn-sm" target="_blank" href="http://bedah-sentral.simrs.aa/cetak/cetak-catatan-lokal-anestesi?cla_id=<?= HelperGeneralClass::hashData($item['cla_id']) ?>" data-id="<?= $item['cla_id']
                                                                                                                                                                                                                                                        ?>" data-nama="<?= $item['cla_id']
                                                                                                                                                                                                                                                                        ?>">Klik Untuk Lihat</b></a></td>
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
                        <div class="col-md-12">
                            <div class="card card-info <?php
                                                        if (empty($listPascaLokalAnestesi)) {
                                                            echo 'collapsed-card';
                                                        }

                                                        ?>">
                                <div class="card-header">
                                    <h3 class="card-title">LAPORAN PASCA LOKAL ANESTESI

                                    </h3>
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

                                            <th>Status</th>
                                            <th>Aksi</th>




                                        </tr>
                                        <?php
                                        if (!empty($listPascaLokalAnestesi)) {
                                            $i = 1;
                                            foreach ($listPascaLokalAnestesi  as $item) {

                                        ?>
                                                <tr>
                                                    <td><?= $i ?></td>
                                                    <td><?= $item['pla_created_at'] ?></td>

                                                    <td>
                                                        <?php
                                                        foreach ($item['timoperasi']['timOperasiDetail'] as $key => $value) {
                                                            echo ($key + 1) . '. ' . HelperSpesialClass::getNamaPegawaiArray($value['pegawai']) ?? '';
                                                            echo '<br>';
                                                        }
                                                        ?>
                                                    </td>
                                                    <td> <?php echo $item->pla_batal == 0 ? ($item->pla_final == 0 ? 'DRAFT' : 'FINAL') : 'BATAL' ?></td>

                                                    <td><a class="btn btn-success btn-sm" target="_blank" href="http://bedah-sentral.simrs.aa/cetak/cetak-pasca-lokal-anestesi?pla_id=<?= HelperGeneralClass::hashData($item['pla_id']) ?>" data-id="<?= $item['pla_id']
                                                                                                                                                                                                                                                        ?>" data-nama="<?= $item['pla_id']
                                                                                                                                                                                                                                                                        ?>">Klik Untuk Lihat</b></a></td>
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
                        <div class="col-md-12">
                            <div class="card card-info <?php
                                                        if (empty($listAskanPraAnestesi)) {
                                                            echo 'collapsed-card';
                                                        }

                                                        ?>">
                                <div class="card-header">
                                    <h3 class="card-title">LAPORAN ASUHAN KEPENATAAN PRA ANESTESI

                                    </h3>
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

                                            <th>Status</th>
                                            <th>Aksi</th>




                                        </tr>
                                        <?php
                                        if (!empty($listAskanPraAnestesi)) {
                                            $i = 1;
                                            foreach ($listAskanPraAnestesi  as $item) {

                                        ?>
                                                <tr>
                                                    <td><?= $i ?></td>
                                                    <td><?= $item['apa_created_at'] ?></td>

                                                    <td>
                                                        <?php
                                                        foreach ($item['timoperasi']['timOperasiDetail'] as $key => $value) {
                                                            echo ($key + 1) . '. ' . HelperSpesialClass::getNamaPegawaiArray($value['pegawai']) ?? '';
                                                            echo '<br>';
                                                        }
                                                        ?>
                                                    </td>
                                                    <td> <?php echo $item->apa_batal == 0 ? ($item->apa_final == 0 ? 'DRAFT' : 'FINAL') : 'BATAL' ?></td>

                                                    <td><a class="btn btn-success btn-sm" target="_blank" href="http://bedah-sentral.simrs.aa/cetak/cetak-askan-pra-anestesi?apa_id=<?= HelperGeneralClass::hashData($item['apa_id']) ?>" data-id="<?= $item['apa_id']
                                                                                                                                                                                                                                                    ?>" data-nama="<?= $item['apa_id']
                                                                                                                                                                                                                                                                    ?>">Klik Untuk Lihat</b></a></td>
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
                        <div class="col-md-12">
                            <div class="card card-info <?php
                                                        if (empty($listAskanIntraAnestesi)) {
                                                            echo 'collapsed-card';
                                                        }

                                                        ?>">
                                <div class="card-header">
                                    <h3 class="card-title">LAPORAN ASKAN KEPENTAAN INTRA ANESTESI


                                    </h3>
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

                                            <th>Status</th>
                                            <th>Aksi</th>




                                        </tr>
                                        <?php
                                        if (!empty($listAskanIntraAnestesi)) {
                                            $i = 1;
                                            foreach ($listAskanIntraAnestesi  as $item) {

                                        ?>
                                                <tr>
                                                    <td><?= $i ?></td>
                                                    <td><?= $item['aia_created_at'] ?></td>

                                                    <td>
                                                        <?php
                                                        foreach ($item['timoperasi']['timOperasiDetail'] as $key => $value) {
                                                            echo ($key + 1) . '. ' . HelperSpesialClass::getNamaPegawaiArray($value['pegawai']) ?? '';
                                                            echo '<br>';
                                                        }
                                                        ?>
                                                    </td>
                                                    <td> <?php echo $item->aia_batal == 0 ? ($item->aia_final == 0 ? 'DRAFT' : 'FINAL') : 'BATAL' ?></td>

                                                    <td><a class="btn btn-success btn-sm" target="_blank" href="http://bedah-sentral.simrs.aa/cetak/cetak-askan-intra-anestesi?aia_id=<?= HelperGeneralClass::hashData($item['aia_id']) ?>" data-id="<?= $item['aia_id']
                                                                                                                                                                                                                                                        ?>" data-nama="<?= $item['aia_id']
                                                                                                                                                                                                                                                                        ?>">Klik Untuk Lihat</b></a></td>
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
                        <div class="col-md-12">
                            <div class="card card-info <?php
                                                        if (empty($listAskanPascaAnestesi)) {
                                                            echo 'collapsed-card';
                                                        }

                                                        ?>">
                                <div class="card-header">
                                    <h3 class="card-title">LAPORAN ASUHAN KEPENATAAN PASCA ANESTESI</h3>
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

                                            <th>Status</th>
                                            <th>Aksi</th>




                                        </tr>
                                        <?php
                                        if (!empty($listAskanPascaAnestesi)) {
                                            $i = 1;
                                            foreach ($listAskanPascaAnestesi  as $item) {

                                        ?>
                                                <tr>
                                                    <td><?= $i ?></td>
                                                    <td><?= $item['pas_created_at'] ?></td>

                                                    <td>
                                                        <?php
                                                        foreach ($item['timoperasi']['timOperasiDetail'] as $key => $value) {
                                                            echo ($key + 1) . '. ' . HelperSpesialClass::getNamaPegawaiArray($value['pegawai']) ?? '';
                                                            echo '<br>';
                                                        }
                                                        ?>
                                                    </td>
                                                    <td> <?php echo $item->pas_batal == 0 ? ($item->pas_final == 0 ? 'DRAFT' : 'FINAL') : 'BATAL' ?></td>

                                                    <td><a class="btn btn-success btn-sm" target="_blank" href="http://bedah-sentral.simrs.aa/cetak/cetak-askan-pasca-anestesi?pas_id=<?= HelperGeneralClass::hashData($item['pas_id']) ?>" data-id="<?= $item['pas_id']
                                                                                                                                                                                                                                                        ?>" data-nama="<?= $item['pas_id']
                                                                                                                                                                                                                                                                        ?>">Klik Untuk Lihat</b></a></td>
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
                        <div class="col-md-12">
                            <div class="card card-info">
                                <div class="card-header">
                                    <h3 class="card-title">E-Sep</h3>
                                    <div class="card-tools">
                                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                            <i class="fas fa-plus"></i>
                                        </button>
                                    </div>

                                </div>

                                <div class="card-body">
                                    <table class="table table-striped table-bordered " style="text-align: justify;">
                                        <tr class="bg-info">
                                            <th>No Registrasi</th>
                                            <th>Unit</th>

                                            <th>Tanggal Masuk</th>
                                            <th>Tanggal Keluar</th>

                                            <th>Aksi</th>




                                        </tr>

                                        <tr>
                                            <td><?= $registrasi['kode'] ?></td>
                                            <td><?php
                                                $units = array();
                                                foreach ($registrasi['layanan'] as $value) {
                                                    $unitName = $value['unit']['nama'];
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
                                            <td><?= $registrasi['tgl_masuk'] ?? '' ?></td>
                                            <td><?= $registrasi['tgl_keluar'] ?? '' ?></td>
                                            <td style="text-align: left;">
                                                <?php if ($registrasi['no_sep'] != null || $registrasi['no_sep'] != '') { ?>

                                                    <?= Html::a(
                                                        'E-SEP RJ &nbsp;&nbsp; <span class="fas fa-teeth"></span>',
                                                        ['/history-pasien/lihat-sep', 'sep' => $registrasi['no_sep']],
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
                                                    <a class="btn btn-warning btn-sm" target="_blank" href="http://pendaftaran.simrs.aa/sep-v3/cetak-esep?no_sep=<?= $registrasi['no_sep'] ?>">Cetak E-SEP RJ <i class="fas fa-print fa-sm"></i></a>
                                                <?php  } ?>
                                                <?php if ($registrasi['no_sep_ri'] != null || $registrasi['no_sep_ri'] != '') { ?>
                                                    <?= Html::a(
                                                        'E-SEP RI &nbsp;&nbsp; <span class="fas fa-teeth"></span>',
                                                        ['/history-pasien/lihat-sep', 'sep' => $registrasi['no_sep_ri']],
                                                        [
                                                            'rel' => 'tooltip',
                                                            'data-placement' => 'top',
                                                            'data-title' => 'Lihat SEP',
                                                            'class' => 'btn btn-danger btn-sm',
                                                            'style' => 'cursor: pointer;',
                                                            'data-target' => "#modalSep",
                                                            'data-toggle' => 'modal',
                                                        ]
                                                    ); ?>
                                                    <a class="btn btn-danger btn-sm" target="_blank" href="http://pendaftaran.simrs.aa/sep-v3/cetak-esep?no_sep=<?= $registrasi['no_sep_ri'] ?>">Cetak E-SEP RI <i class="fas fa-print fa-sm"></i></a>
                                                <?php  } ?>

                                                <?php if ($registrasi['no_sep_igd'] != null || $registrasi['no_sep_igd'] != '') { ?>
                                                    <?= Html::a(
                                                        'E-SEP IGD &nbsp;&nbsp; <span class="fas fa-teeth"></span>',
                                                        ['/history-pasien/lihat-sep', 'sep' => $registrasi['no_sep_igd']],
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
                                                    <a class="btn btn-danger btn-sm" target="_blank" href="http://pendaftaran.simrs.aa/sep-v3/cetak-esep?no_sep=<?= $registrasi['no_sep_igd'] ?>">Cetak E-SEP IGD <i class="fas fa-print fa-sm"></i></a>
                                                <?php  } ?>


                                            </td>
                                        </tr>

                                        <?php Modal::begin([
                                            'id' => 'modalSep',
                                            'size' => Modal::SIZE_LARGE,
                                            'options' => [
                                                'tabindex' => false,
                                                // 'data-backdrop' => 'static',
                                            ],
                                        ]);
                                        Modal::end(); ?>
                                    </table>
                                </div>
                            </div>

                        </div>
                        <div class="col-md-12">
                            <div class="card card-info <?php
                                                        if (empty($listRingkasanPulangIgd)) {
                                                            echo 'collapsed-card';
                                                        }

                                                        ?>">
                                <div class="card-header">
                                    <h3 class="card-title">RINGKASAN PULANG IGD


                                    </h3>
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

                                            <th>Tanggal Masuk</th>
                                            <th>Tanggal Keluar</th>

                                            <th>Aksi</th>




                                        </tr>
                                        <?php
                                        if (!empty($listRingkasanPulangIgd)) {
                                            $i = 1;
                                            foreach ($listRingkasanPulangIgd as $item) {

                                        ?>
                                                <tr>
                                                    <td><?= $i ?></td>
                                                    <td><?= $item['layanan']['registrasi_kode'] ?></td>

                                                    <td><?= $item['tgl_datang'] ?></td>
                                                    <td><?= $item['tgl_keluar'] ?></td>



                                                    <td><a class="btn btn-success btn-sm btn-ringkasan-pulang-igd" href="<?= Url::to([
                                                                                                                                '/history-pasien/preview-ringkasan-pulang-igd',
                                                                                                                                'id' => HelperGeneralClass::hashData($item['id']),

                                                                                                                            ]) ?>">Klik untuk lihat<i class="fas fa-eye fa-sm"></i></a>
                                                        <a class="btn btn-warning btn-sm" target="_blank" href="<?= Url::to([
                                                                                                                    '/history-pasien/cetak-ringkasan-pulang-igd',
                                                                                                                    'id' => HelperGeneralClass::hashData($item['id']),

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
                        <div class="col-md-12">
                            <div class="card card-info <?php
                                                        if (empty($listTriaseIgd)) {
                                                            echo 'collapsed-card';
                                                        }

                                                        ?>">
                                <div class="card-header">
                                    <h3 class="card-title">TRIASE IGD


                                    </h3>
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

                                            <th>Tanggal Triase</th>

                                            <th>Aksi</th>




                                        </tr>
                                        <?php
                                        if (!empty($listTriaseIgd)) {
                                            $i = 1;
                                            foreach ($listTriaseIgd as $item) {

                                        ?>
                                                <tr>
                                                    <td><?= $i ?></td>
                                                    <td><?= $item['layanan']['registrasi_kode'] ?></td>

                                                    <td><?= $item['tanggal_triase'] ?></td>



                                                    <td><a class="btn btn-success btn-sm btn-triase-igd" href="<?= Url::to([
                                                                                                                    '/history-pasien/preview-triase-igd',
                                                                                                                    'id' => HelperGeneralClass::hashData($item['id']),

                                                                                                                ]) ?>">Klik untuk lihat<i class="fas fa-eye fa-sm"></i></a>
                                                        <a class="btn btn-warning btn-sm" target="_blank" href="<?= Url::to([
                                                                                                                    '/history-pasien/cetak-triase-igd',
                                                                                                                    'id' => HelperGeneralClass::hashData($item['id']),

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
                        <div class="col-md-12">
                            <div class="card card-info">
                                <div class="card-header">
                                    <h3 class="card-title">MONITORING TTV</h3>
                                    <div class="card-tools">
                                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                            <i class="fas fa-plus"></i>
                                        </button>
                                    </div>

                                </div>

                                <div class="card-body">
                                    <?php foreach ($listMonitoringTtv as $idx => $du): ?>
                                        <div class="card">
                                            <div class="row">
                                                <div class="col-12">
                                                    <?php if (!empty($du['data'])): ?>
                                                        <table class="table table-bordered">
                                                            <thead>
                                                                <tr class="bg-info">

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
                        <div class="col-md-12">
                            <div class="card card-info">
                                <div class="card-header">
                                    <h3 class="card-title">ASESMEN HEMODIALISA AWAL MEDIS</h3>
                                    <div class="card-tools">
                                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                            <i class="fas fa-plus"></i>
                                        </button>
                                    </div>

                                </div>

                                <div class="card-body">
                                    <?php foreach ($listAsesmenHemodialisaDokter as $idx => $du): ?>
                                        <div class="card">
                                            <div class="row">
                                                <div class="col-12">
                                                    <?php if (!empty($du['data'])): ?>
                                                        <table class="table table-bordered">
                                                            <thead>
                                                                <tr class="bg-info">

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
                        <div class="col-md-12">
                            <div class="card card-info">
                                <div class="card-header">
                                    <h3 class="card-title">ASESMEN HEMODIALISA AWAL MEDIS LANJUTAN</h3>
                                    <div class="card-tools">
                                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                            <i class="fas fa-plus"></i>
                                        </button>
                                    </div>

                                </div>

                                <div class="card-body">
                                    <?php foreach ($listAsesmenHemodialisaDokterLanjutan as $idx => $du): ?>
                                        <div class="card">
                                            <div class="row">
                                                <div class="col-12">
                                                    <?php if (!empty($du['data'])): ?>
                                                        <table class="table table-bordered">
                                                            <thead>
                                                                <tr class="bg-info">

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
                        <div class="col-md-12">
                            <div class="card card-info">
                                <div class="card-header">
                                    <h3 class="card-title">ASESMEN HEMODIALISA KEPERAWATAN</h3>
                                    <div class="card-tools">
                                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                            <i class="fas fa-plus"></i>
                                        </button>
                                    </div>

                                </div>

                                <div class="card-body">
                                    <?php foreach ($listAsesmenHemodialisaKeperawatan as $idx => $du): ?>
                                        <div class="card">
                                            <div class="row">
                                                <div class="col-12">
                                                    <?php if (!empty($du['data'])): ?>
                                                        <table class="table table-bordered">
                                                            <thead>
                                                                <tr class="bg-info">

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
                        <div class="col-md-12">
                            <div class="card card-info">
                                <div class="card-header">
                                    <h3 class="card-title">RESUME REHAB MEDIK</h3>
                                    <div class="card-tools">
                                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                            <i class="fas fa-plus"></i>
                                        </button>
                                    </div>

                                </div>

                                <div class="card-body">
                                    <?php foreach ($listResumeRehabMedik as $idx => $du): ?>
                                        <div class="card">
                                            <div class="row">
                                                <div class="col-12">
                                                    <?php if (!empty($du['data'])): ?>
                                                        <table class="table table-bordered">
                                                            <thead>
                                                                <tr class="bg-info">

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
                        <div class="col-md-12">
                            <div class="card card-info">
                                <div class="card-header">
                                    <h3 class="card-title">ASESMEN REHAB MEDIK</h3>
                                    <div class="card-tools">
                                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                            <i class="fas fa-plus"></i>
                                        </button>
                                    </div>

                                </div>

                                <div class="card-body">
                                    <?php foreach ($listAsesmenRehabMedik as $idx => $du): ?>
                                        <div class="card">
                                            <div class="row">
                                                <div class="col-12">
                                                    <?php if (!empty($du['data'])): ?>
                                                        <table class="table table-bordered">
                                                            <thead>
                                                                <tr class="bg-info">

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

                    <div class="row">


                        <?php if (HelperSpesialClass::isCoder()) { ?>
                            <div class="col-md-12">
                                <div class="card card-info <?php
                                                            if (empty($listPelaporan)) {
                                                                echo 'collapsed-card';
                                                            }

                                                            ?>">
                                    <div class="card-header">
                                        <h3 class="card-title">RIWAYAT ICD 9 & 10 PELAPORAN</h3>
                                        <div class="card-tools">
                                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                                <i class="fas fa-plus"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <table class="table table-striped table-bordered " style="text-align: justify;">

                                            <tr class="bg-info">
                                                <th style="width:5%">No</th>
                                                <th style="width:10%">Tanggal</th>

                                                <th style="width:20%">No. Registrasi</th>
                                                <th style="width:15%">Kasus</th>
                                                <th style="width:25%">ICD 10</th>

                                                <th style="width:25%">ICD 9</th>




                                            </tr>
                                            <?php
                                            if (!empty($listPelaporan)) {
                                                $i = 1;
                                                foreach ($listPelaporan as $item) {
                                            ?>
                                                    <tr>
                                                        <td><?= $i ?></td>
                                                        <td><?= $item['created_at'] ?? '' ?></td>
                                                        <td><?= $item['registrasi_kode'] ?? '' ?></td>
                                                        <td><?= $item['kasus'] == '1' ? 'Lama' : 'Baru' ?></td>
                                                        <td>
                                                            <?php



                                                            // Menampilkan data
                                                            foreach ($item['pelaporanDiagnosa'] as $value) {
                                                                echo ($value['icd10_kode'] ?? '') . ' - ' . ($value['icd10_deskripsi'] ?? '') . ' - ' . ($value['utama'] == '1' ? '<span class="right badge badge-danger">Utama</span> ' : '<span class="right badge badge-warning">Tambahan</span> ');
                                                                echo '<br>';
                                                            }
                                                            ?></td>
                                                        <td>
                                                            <?php



                                                            // Menampilkan data
                                                            foreach ($item['pelaporanTindakan'] as $value) {
                                                                echo ($value['icd9_kode'] ?? '') . ' - ' . ($value['icd9_deskripsi'] ?? '') . ' - ' . ($value['utama'] == '1' ? '<span class="right badge badge-danger">Utama</span> ' : '<span class="right badge badge-warning">Tambahan</span> ');
                                                                echo '<br>';
                                                            }
                                                            ?></td>

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
                        <?php } ?>
                    </div>

                    <div class="row">


                        <?php if (HelperSpesialClass::isCoder()) { ?>
                            <div class="col-md-12">
                                <div class="card card-info <?php
                                                            if (empty($listClaim)) {
                                                                echo 'collapsed-card';
                                                            }

                                                            ?>">
                                    <div class="card-header">
                                        <h3 class="card-title">RIWAYAT ICD 9 & 10 CLAIM</h3>
                                        <div class="card-tools">
                                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                                <i class="fas fa-plus"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <table class="table table-striped table-bordered " style="text-align: justify;">

                                            <tr class="bg-info">
                                                <th style="width:5%">No</th>
                                                <th style="width:10%">Tanggal</th>

                                                <th style="width:20%">No. Registrasi</th>
                                                <th style="width:15%">Kasus</th>
                                                <th style="width:25%">ICD 10</th>

                                                <th style="width:25%">ICD 9</th>




                                            </tr>
                                            <?php
                                            if (!empty($listClaim)) {
                                                $i = 1;
                                                foreach ($listClaim as $item) {
                                            ?>
                                                    <tr>
                                                        <td><?= $i ?></td>
                                                        <td><?= $item['created_at'] ?? '' ?></td>
                                                        <td><?= $item['registrasi_kode'] ?? '' ?></td>
                                                        <td><?= $item['kasus'] == '1' ? 'Lama' : 'Baru' ?></td>
                                                        <td>
                                                            <?= $item['diagutama']['kode'] ?? '' ?> <?= $item['diagutama']['deskripsi'] ?? '' ?> <?= (!empty($item['diagutama'])) ? '<span class="right badge badge-danger">Utama</span>' : '' ?><br>
                                                            <?= $item['diagsatu']['kode'] ?? '' ?> <?= $item['diagsatu']['deskripsi'] ?? '' ?> <?= (!empty($item['diagsatu'])) ? '<span class="right badge badge-warning">Tambahan 1</span>' : '' ?><br>
                                                            <?= $item['diagdua']['kode'] ?? '' ?> <?= $item['diagdua']['deskripsi'] ?? '' ?> <?= (!empty($item['diagdua'])) ? '<span class="right badge badge-warning">Tambahan 2</span>' : '' ?><br>
                                                            <?= $item['diagtiga']['kode'] ?? '' ?> <?= $item['diagtiga']['deskripsi'] ?? '' ?> <?= (!empty($item['diagtiga'])) ? '<span class="right badge badge-warning">Tambahan 3</span>' : '' ?><br>
                                                            <?= $item['diagempat']['kode'] ?? '' ?> <?= $item['diagempat']['deskripsi'] ?? '' ?> <?= (!empty($item['diagempat'])) ? '<span class="right badge badge-warning">Tambahan 4</span>' : '' ?><br>
                                                            <?= $item['diaglima']['kode'] ?? '' ?> <?= $item['diaglima']['deskripsi'] ?? '' ?> <?= (!empty($item['diaglima'])) ? '<span class="right badge badge-warning">Tambahan 5</span>' : '' ?><br>
                                                        </td>
                                                        <td>
                                                            <?= $item['tindutama']['kode'] ?? '' ?> <?= $item['tindutama']['deskripsi'] ?? '' ?> <?= (!empty($item['tindutama'])) ? '<span class="right badge badge-danger">Utama</span>' : '' ?><br>
                                                            <?= $item['tindsatu']['kode'] ?? '' ?> <?= $item['tindsatu']['deskripsi'] ?? '' ?> <?= (!empty($item['tindsatu'])) ? '<span class="right badge badge-dwarninganger">Tambahan 1</span>' : '' ?><br>
                                                            <?= $item['tinddua']['kode'] ?? '' ?> <?= $item['tinddua']['deskripsi'] ?? '' ?> <?= (!empty($item['tinddua'])) ? '<span class="right badge badge-warning">Tambahan 2</span>' : '' ?><br>
                                                            <?= $item['tindtiga']['kode'] ?? '' ?> <?= $item['tindtiga']['deskripsi'] ?? '' ?> <?= (!empty($item['tindtiga'])) ? '<span class="right badge badge-warning">Tambahan 3</span>' : '' ?><br>
                                                            <?= $item['tindempat']['kode'] ?? '' ?> <?= $item['tindempat']['deskripsi'] ?? '' ?> <?= (!empty($item['tindempat'])) ? '<span class="right badge badge-warning">Tambahan 4</span>' : '' ?><br>
                                                            <?= $item['tindlima']['kode'] ?? '' ?> <?= $item['tindlima']['deskripsi'] ?? '' ?> <?= (!empty($item['tindlima'])) ? '<span class="right badge badge-warning">Tambahan 5</span>' : '' ?><br>
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
                        <?php } ?>
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
    // modal.find('.modal-body').addClass('loading');
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