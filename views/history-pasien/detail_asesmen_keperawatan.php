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
$('.btn-lihat-asesmen').on('click', function (){
    $.get($(this).attr('href'), function(data) {
        $('.mymodal_card_xl_body').html(data);
        $('.mymodal_card_xl').modal('show');
   });
   return false;
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
                                    <h3 class="card-title">ASESMEN AWAL KEPERAWATAN</h3>
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
                                                    <td> <?php echo $item->batal == 0 ? ($item->draf == 1 ? 'DRAFT' : 'FINAL') : 'BATAL' ?></td>
                                                    <td><a class="btn <?php echo $item->is_deleted == 0 ? 'btn-success' : 'btn-danger' ?> btn-sm btn-lihat-asesmen" href="<?= Url::to(['/history-pasien/preview-asesmen-awal-keperawatan', 'id' => HelperGeneralClass::hashData($item->id)]) ?>" data-id="<?= HelperGeneralClass::hashData($item->id) ?>" data-nama="<?= HelperGeneralClass::hashData($item->id) ?>">Klik Untuk Lihat</b></a>
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