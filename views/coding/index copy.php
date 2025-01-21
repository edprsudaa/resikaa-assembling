<?php

use app\assets\plugins\InputmaskAsset;
use app\components\HelperGeneralClass;
use app\components\HelperSpesialClass;
use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;
use kartik\select2\Select2;
use yii\grid\GridView;
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
    $.get(baseUrl+'/analisa-kuantitatif/preview-doc-clinical?id='+id, function(d){
        if(d.status){
            $('.mymodal_card_xl_body').html(d.data.data);
            $('.mymodal_card_xl').modal('show');
        }else{
            fmsg.w(d.msg);
        }
    });
});
$('.btn-lihat-labor').on('click', function() {
    var id=$(this).data('id');
    $.get(baseUrl+'/analisa-kuantitatif/preview-list-labor?id='+id, function(d){
        if(d.status){
            $('.mymodal_card_xl_body').html(d.data.data);
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
    // App.SetLoadingBtn(btn,'Menyimpan...');
    $.ajax({
        url:'" . Url::to(['save']) . "',
        type:'post',
        dataType:'json',
        data:$(this).serialize(),
        success:function(result){
            if(result.status){
                toastr.success(result.msg);
                
            }else{
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
        <?php echo $this->render('card-pasien', ['registrasi' => $registrasi]); ?>
        <!-- Card Pasien -->

        <?php $form = ActiveForm::begin(['id' => 'analisa-dokumen', 'action' => 'javascript::void(0)', 'options' => ['class' => 'form form-catatan', 'role' => 'form']]); ?>
        <?php if (!empty($model->analisa_dokumen_id)) {
        ?>
            <input type="hidden" name="analisa_dokumen_id" value="<?php echo $model->analisa_dokumen_id; ?>">
        <?php } ?>
        <input type="hidden" name="ps_kode" value="<?= $registrasi['pasien']['kode'] ?>">
        <input type="hidden" name="reg_kode" value="<?= $registrasi['kode'] ?>">
        <div class="row">
            <div class="col-lg-9">
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <h5 class="card-title m-0">Analisa Dokumen Rekam Medik</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <table class="table table-striped table-bordered" style="text-align: justify;" id="analisa-kuantitatif">
                                <tr style="text-align: center;">
                                    <th rowspan="2" style="vertical-align : middle;">Kriteria Analisa</th>
                                    <th colspan="2">Ada</th>
                                    <th rowspan="2" style="vertical-align : middle;">Tidak Ada</th>
                                </tr>
                                <tr style="text-align: center;">
                                    <th>Lengkap</th>
                                    <th>Tidak Lengkap</th>
                                </tr>
                                <?php
                                if (!$model->isNewRecord) {
                                    $no = 1;
                                    $tab = 1;
                                    $jenis = [null, null];
                                    foreach ($model->analisaDokumenDetail as $k) {
                                        if ($jenis[0] != $k->jenisAnalisa->jenis_analisa_id) {
                                            $jenis = [$k['jenisAnalisa']['jenis_analisa_id'], $k['jenisAnalisa']['jenis_analisa_uraian']];
                                ?>
                                            <tr class="p-0" style="border: 1px solid;">
                                                <td colspan="5">
                                                    <div>
                                                        <b><?php echo $k['jenisAnalisa']['jenis_analisa_uraian']; ?></b>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                        <tr>
                                            <td style="width: 55%;">
                                                <?php echo $no . '. ' . $k['itemAnalisa']['item_analisa_uraian']; ?>
                                                <input type="hidden" name="AnalisaDokumen[<?php echo $no; ?>][analisa_dokumen_detail_id]" value="<?= $k['analisa_dokumen_detail_id'] ?>">

                                                <input type="hidden" name="AnalisaDokumen[<?php echo $no; ?>][analisa_dokumen_item_id]" value="<?= $k['itemAnalisa']['item_analisa_id'] ?>">
                                                <input type="hidden" name="AnalisaDokumen[<?php echo $no; ?>][analisa_dokumen_jenis_id]" value="<?= $k['jenisAnalisa']['jenis_analisa_id'] ?>">
                                            </td>


                                            <td width="15%">
                                                <div>
                                                    <input type="radio" required id="identifikasi_no_pasien_<?php echo $no; ?>_1" name="AnalisaDokumen[<?php echo $no; ?>][analisa_dokumen_kelengkapan]" value="2" <?php echo ($k->analisa_dokumen_kelengkapan == '2' ? 'checked' : '') ?>>
                                                    <label for="identifikasi_no_pasien_<?php echo $no; ?>_1">
                                                        Lengkap
                                                    </label>
                                                </div>
                                            </td>

                                            <td width="15%">
                                                <div>
                                                    <input type="radio" required id="identifikasi_no_pasien_<?php echo $no; ?>_2" name="AnalisaDokumen[<?php echo $no; ?>][analisa_dokumen_kelengkapan]" value="1" <?php echo ($k->analisa_dokumen_kelengkapan == '1' ? 'checked' : '') ?>>
                                                    <label for="identifikasi_no_pasien_<?php echo $no; ?>_2">
                                                        Tidak Lengkap
                                                    </label>
                                                </div>
                                            </td>

                                            <td width="15%">
                                                <div>
                                                    <input type="radio" required id="identifikasi_no_pasien_<?php echo $no; ?>_3" name="AnalisaDokumen[<?php echo $no; ?>][analisa_dokumen_kelengkapan]" value="0" <?php echo ($k->analisa_dokumen_kelengkapan == '0' ? 'checked' : '') ?>>
                                                    <label for="identifikasi_no_pasien_<?php echo $no; ?>_3">
                                                        Tidak Ada
                                                    </label>
                                                </div>
                                            </td>

                                        </tr>
                                    <?php
                                        $no++;
                                    }
                                } else {


                                    ?>

                                    <?php
                                    $no = 1;
                                    $tab = 1;
                                    $jenis = [null, null];
                                    foreach ($listAnalisa as $k) {
                                        if ($jenis[0] != $k['jenisAnalisa']['jenis_analisa_id']) {
                                            $jenis = [$k['jenisAnalisa']['jenis_analisa_id'], $k['jenisAnalisa']['jenis_analisa_uraian']];
                                    ?>
                                            <tr class="p-0" style="border: 1px solid;">
                                                <td colspan="5">
                                                    <div>
                                                        <b><?php echo $k['jenisAnalisa']['jenis_analisa_uraian']; ?></b>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                        <tr>
                                            <td style="width: 55%;">
                                                <?php echo $no . '. ' . $k['itemAnalisa']['item_analisa_uraian']; ?>
                                                <input type="hidden" name="AnalisaDokumen[<?php echo $no; ?>][analisa_dokumen_item_id]" value="<?= $k['itemAnalisa']['item_analisa_id'] ?>">
                                                <input type="hidden" name="AnalisaDokumen[<?php echo $no; ?>][analisa_dokumen_jenis_id]" value="<?= $k['jenisAnalisa']['jenis_analisa_id'] ?>">
                                            </td>


                                            <td width="15%">
                                                <div>
                                                    <input type="radio" required id="identifikasi_no_pasien_<?php echo $no; ?>_1" name="AnalisaDokumen[<?php echo $no; ?>][analisa_dokumen_kelengkapan]" value="2">
                                                    <label for="identifikasi_no_pasien_<?php echo $no; ?>_1">
                                                        Lengkap
                                                    </label>
                                                </div>
                                            </td>

                                            <td width="15%">
                                                <div>
                                                    <input type="radio" required id="identifikasi_no_pasien_<?php echo $no; ?>_2" name="AnalisaDokumen[<?php echo $no; ?>][analisa_dokumen_kelengkapan]" value="1">
                                                    <label for="identifikasi_no_pasien_<?php echo $no; ?>_2">
                                                        Tidak Lengkap
                                                    </label>
                                                </div>
                                            </td>

                                            <td width="15%">
                                                <div>
                                                    <input type="radio" required id="identifikasi_no_pasien_<?php echo $no; ?>_3" name="AnalisaDokumen[<?php echo $no; ?>][analisa_dokumen_kelengkapan]" value="0">
                                                    <label for="identifikasi_no_pasien_<?php echo $no; ?>_3">
                                                        Tidak Ada
                                                    </label>
                                                </div>
                                            </td>

                                        </tr>
                                <?php
                                        $no++;
                                    }
                                }
                                ?>


                                <tr>
                                    <td><b>Nama Dokter DPJP Utama</b></td>
                                    <td colspan="3">

                                        <?php echo Select2::widget([
                                            'name' => 'analisa_dokumen_dokter_id',
                                            'data' => HelperSpesialClass::getListDokter(false, true),
                                            'size' => 'xs',
                                            'value' => $model->analisaDokumenDetail[0]->analisa_dokumen_dokter_id ?? null,
                                            'options' => ['class' => 'form-control input-sm', 'placeholder' => 'Pilih Dokter Tujuan...'],
                                            'pluginOptions' => [
                                                'allowClear' => false
                                            ],
                                        ]); ?>

                                    </td>

                                </tr>


                            </table>
                        </div>

                        <div class="form-group row">

                            <div class="col-sm-6">
                                <button class="btn btn-secondary btn-block">Kembali</button>
                            </div>
                            <div class="col-sm-6">
                                <?= Html::submitButton('Simpan Analisa Dokumen', ['class' => 'btn btn-success btn-block btn-peminjaman-distribusi-submit']) ?>
                            </div>

                        </div>

                    </div>



                    <?php ActiveForm::end(); ?>
                </div>
            </div>
            <div class="col-lg-3">

                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <h5 class="card-title m-0">Daftar Formulir Telah Diisi</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <table class="table table-striped table-bordered" style="text-align: justify;">

                                <?php
                                // if ($docClinicalList->data !== null) {
                                //     foreach ($docClinicalList->data as $item) { 
                                ?>
                                <tr>
                                    <td style="text-align: left;"><button type="button" class="btn btn-success btn-sm btn-lihat" data-id="<? // $item['id_doc_clinical_pasien'] 
                                                                                                                                            ?>" data-nama="<? // $item['id_doc_clinical_pasien'] 
                                                                                                                                                                                                ?>"> <? // ($item['itemDocClinical']['nama']) 
                                                                                                                                                                                                                                        ?> <i class="fas fa-eye fa-sm"></i></button></td>
                                </tr>
                                <?php
                                //     }
                                // } else { 
                                ?>
                                <tr>
                                    <td style="text-align: left;">Tidak ada dokumen</td>
                                </tr>
                                <?php

                                // }
                                ?>

                            </table>
                        </div>
                    </div>


                </div>
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <h5 class="card-title m-0">Daftar Pemeriksaan Laboratorium</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <table class="table table-striped table-bordered" style="text-align: justify;">

                                <?php
                                // print_r($listLabor);
                                if ($listLabor->data !== null) {
                                    foreach ($listLabor->data as $item) {
                                ?>
                                        <tr>
                                            <td style="text-align: left;"><button type="button" class="btn btn-success btn-sm btn-lihat-labor" data-id="<? //$item['id'] 
                                                                                                                                                        ?>" data-nama="<? // $item['id'] 
                                                                                                                                                                                        ?>"> Hasil Labor <i class="fas fa-eye fa-sm"></i></button></td>
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