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
                                        <?php
                                        // echo '<pre>';
                                        // print_r($listAsesmenKeperawatan);
                                        if (!empty($listAsesmenKeperawatan)) {
                                            $i=1;
                                            foreach ($listAsesmenKeperawatan as $item) {
                                        ?>
                                                <tr>
                                                    <td style="text-align: left;"><a class="btn btn-success btn-sm btn-lihat-asesmen" href="<?= Url::to(['/riwayat-pasien/preview-asesmen-awal-keperawatan', 'id' => $item->id]) ?>" data-id="<?= $item->id
                                                                                                                                                                                                                                                    ?>" data-nama="<?= $item->id
                                                                                                                                                                                                                                                                    ?>"><?=$i?>. Asesmen Keperawatan <i class="fas fa-eye fa-sm"></i></a></td>
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
                                                    <td style="text-align: left;"><a class="btn btn-success btn-sm btn-lihat-asesmen" href="<?= Url::to(['/riwayat-pasien/preview-asesmen-awal-kebidanan', 'id' => $item->id]) ?>" data-id="<?= $item->id
                                                                                                                                                                                                                                                    ?>" data-nama="<?= $item->id
                                                                                                                                                                                                                                                                    ?>"> Asesmen Keperawatan <i class="fas fa-eye fa-sm"></i></a></td>
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
                                                    <td style="text-align: left;"><a class="btn btn-success btn-sm btn-lihat-asesmen" href="<?= Url::to(['/riwayat-pasien/preview-asesmen-awal-medis', 'id' => $item->id]) ?>" data-id="<?= $item->id
                                                                                                                                                                                                                                                ?>" data-nama="<?= $item->id
                                                                                                                                                                                                                                                                ?>"> <?= $i?> . Asesmen Medis <i class="fas fa-eye fa-sm"></i></a></td>
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
                                        <h3 class="card-title">HASIL LABORATORIUM</h3>
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
                                            // print_r($listLabor);
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
                                                        <td style="text-align: left;"><button type="button" class="btn btn-success btn-sm btn-lihat-labor" data-id="<?= $item['ID']
                                                                                                                                                                    ?>" data-nama="<?= $item['ID']
                                                                                                                                                                                    ?>"><?=$i?>. <?= $item['REQUEST_DT']
                                                                                                                                                                                            ?> <i class="fas fa-eye fa-sm"></i></button></td>
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
                            <div class="col-md-6">
                                <div class="card card-info collapsed-card">
                                    <div class="card-header">
                                        <h3 class="card-title">HASIL PATOLOGI ANATOMI</h3>
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
                                                $i=1;
                                                foreach ($listPatologiAnatomi->data as $item) {
                                            ?>

                                                    <tr>
                                                        <td style="text-align: left;"><a class="btn btn-success btn-sm btn-lihat-asesmen" href="<?= Url::to([
                                                                                                                                                    '/riwayat-pasien/preview-patologi-anatomi',
                                                                                                                                                    'id' => $item['id'],
                                                                                                                                                    // 'id' => $item['id'],
                                                                                                                                                    'pemeriksaan' => $item['tarif_tindakan_pasien_id']
                                                                                                                                                ]) ?>"><?= $i?> . <?= $item['tgl_pemeriksaan']; ?><i class="fas fa-eye fa-sm"></i></a></td>
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
                                                $i=1;
                                                foreach ($listRadiologi->data as $item) {
                                            ?>
                                                    <?php
                                                    // $dataUnit = explode('^', $item['SOURCE']);
                                                    // $array = array_map(function ($input) {
                                                    //     return explode(',', $input);
                                                    // }, explode('^', $item['CLINICIAN']));
                                                    ?>
                                                    <tr>
                                                        <td style="text-align: left;"><a class="btn btn-success btn-sm btn-lihat-asesmen" href="<?= Url::to(['/riwayat-pasien/preview-radiologi', 'id' => $item['id_pacsorder']]) ?>" data-id="<?= $item['id_pacsorder']
                                                                                                                                                                                                                                                    ?>" data-nama="<?= $item['id_pacsorder']
                                                                                                                                                                                                                                                                    ?>"><?=$i?> . <?= $item['tanggal_masuk']
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
                                            $i=1;
                                            foreach ($listLaporanOperasi as $item) {
                                        ?>

                                                <tr>
                                                    <td style="text-align: left;"><a class="btn btn-success btn-sm btn-lihat-operasi" href="<?= Url::to(['/riwayat-pasien/preview-laporan-operasi', 'id' => $item['lap_op_id']]) ?>" data-id="<?= $item['lap_op_id']
                                                                                                                                                                                                                                                    ?>" data-nama="<?= $item['lap_op_id']
                                                                                                                                                                                                                                                                    ?>"><?=$i?>. <?= $item['lap_op_created_at']
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
                                                                                                                                                                                                                                                    ?>" data-nama="<?= $item['lap_op_id']
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
                                        <h3 class="card-title">RESUME MEDIS</h3>
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
                    </div>
                </div>


            </div>

        </div>

    </div>
</div>
</div>