<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\grid\GridView;
use kartik\select2\Select2;
use kartik\date\DatePicker;
use app\components\HelperGeneral;
use app\components\Akun;
use app\components\HelperSpesial;
use app\models\bedahsentral\LaporanOperasi;
use app\models\bedahsentral\PembatalanOperasi;
use app\models\bedahsentral\TimOperasi;
use app\models\bedahsentral\TimOperasiDetail;
use app\models\pendaftaran\Layanan;
use yii\widgets\Pjax;

$this->title = 'Pasien Rawat Inap';
$this->params['breadcrumbs'][] = $this->title;
Pjax::begin(['id' => 'pjform', 'timeout' => false]);
$this->registerJs($this->render('script.js'));
$this->registerCss($this->render('style.css'));

// echo '<pre>';
// print_r($model);
// die;

?>

<div class="row">
    <div class="col-lg-12">

        <div class="row mb-2">
            <div class="col-sm-4 text-left"></div>
            <div class="col-sm-4 text-left"></div>

            <div class="col-sm-4 text-right">
                <button class="btn btn-success btn-custom btn-success-custom" id="refresh">
                    <i class="fas fa-sync"></i> Refresh Data
                </button>
            </div>
        </div>
        <div class="layanan-index">

            <?php
            echo GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'tableOptions' => [
                    'class' => 'table table-sm table-bordered table-hover'
                ],

                'rowOptions' => function ($searchModel, $index, $key) {
                    //   $url = Url::to(['/site-pasien/index', 'id' => HelperGeneral::hashData($searchModel->id)]);
                    //   return ['id' => $searchModel->id, 'onclick' => 'location.href="' . $url . '"', 'data-toggle' => "tooltip", 'data-placement' => "right", 'data-original-title' => "Klik Untuk Pilih Pasien", 'style' => "cursor:pointer;"];

                },
                'layout' => "{items}\n{summary}\n{pager}",
                'columns' => [
                    [
                        'class' => 'yii\grid\SerialColumn',
                        'header' => 'No',
                        'headerOptions' => ['style' => 'text-align: center; width: 50px;'],
                        'contentOptions' => ['style' => 'vertical-align: middle;text-align: center'],
                    ],



                    [
                        'attribute' => 'pasien',
                        'label' => 'Pasien',
                        'format' => 'html',
                        'headerOptions' => ['style' => 'text-align: center;width:15%'],
                        'contentOptions' => ['style' => 'vertical-align: middle'],
                        'value' => function ($model) {
                            if (!is_object($model) && $model['pasien_kode']) {
                                return '<span class="text-black"><b>' . $model['nama'] . '</b></span><br/>' .
                                    '(RM: <span class="text-red"><b>' . $model['pasien_kode'] . '</b></span>)<br/>' .
                                    '(Regis: <span class="text-blue"><b>' . $model['kode'] . '</b></span>)';
                            } elseif (is_object($model)) {
                                return 'Pasien Kosong / Registrasi kosong';
                            } else {
                                return '-';
                            }
                        },
                        'format' => 'raw',

                        'filterInputOptions' => [
                            'class' => 'form-control',
                            'autofocus' => true,
                            'onFocus' => 'this.select()',
                            'placeholder' => 'Cari : Ketik + Enter',
                        ],
                    ],
                    [
                        'attribute' => 'tgl_masuk',
                        'label' => 'Tgl.Masuk',
                        'format' => 'html',
                        'headerOptions' => ['style' => 'text-align: center;width:10%'],
                        'contentOptions' => ['style' => 'vertical-align: middle;text-align: center;width:115px'],
                        'value' => function ($model) {
                            return ($model['tgl_masuk'] ? '<span class="text-black"><b>' . $model['tgl_masuk'] . '</b></span>' : '');
                        },
                        // 'filter' => true,

                    ],
                    [
                        'attribute' => 'tanggal_pulang',
                        'label' => 'Tgl.Pulang (Resume)',
                        'format' => 'html',
                        'headerOptions' => ['style' => 'text-align: center;width:10%'],
                        'contentOptions' => ['style' => 'vertical-align: middle;text-align: center;width:115px'],
                        'value' => function ($model) {
                            return ($model['tgl_pulang'] ? '<span class="text-black"><b>' . $model['tgl_pulang'] . '</b></span>' : '');
                        },
                        // 'filter' => true,
                        'filter' => DatePicker::widget([
                            'model' => $searchModel,
                            'attribute' => 'tgl_pulang',
                            'type' => DatePicker::TYPE_INPUT,
                            'pluginOptions' => [
                                'autoclose' => true,
                                'format' => 'dd-mm-yyyy'
                            ],
                            'options' => ['placeholder' => 'Tanggal']
                        ]),

                    ],
                    [
                        'attribute' => 'tanggal_keluar',
                        'label' => 'Tgl.Checkout (Perawat)',
                        'format' => 'html',
                        'headerOptions' => ['style' => 'text-align: center;width:10%'],
                        'contentOptions' => ['style' => 'vertical-align: middle;text-align: center;width:115px'],
                        'value' => function ($model) {
                            return ($model['tgl_keluar'] ? '<span class="text-black"><b>' . $model['tgl_keluar'] . '</b></span>' : '<span class="badge badge-danger">Belum Checkout</span>');
                        },
                        // 'filter' => true,

                    ],
                    [
                        'attribute' => 'tanggal_closing',
                        'label' => 'Tgl.Closing Billing (Adm)',
                        'format' => 'html',
                        'headerOptions' => ['style' => 'text-align: center;width:10%'],
                        'contentOptions' => ['style' => 'vertical-align: middle;text-align: center;width:115px'],
                        'value' => function ($model) {
                            return ($model['closing_billing_ranap_at'] ? '<span class="text-black"><b>' . $model['closing_billing_ranap_at'] . '</b></span>' : '<span class="badge badge-danger">Belum Checkout</span>');
                        },
                        // 'filter' => true,

                    ],
                    [
                        'attribute' => 'ruangan',
                        'label' => 'Tgl.Checkout (Perawat)',
                        'format' => 'html',
                        'headerOptions' => ['style' => 'text-align: center;width:10%'],
                        'contentOptions' => ['style' => 'vertical-align: middle;text-align: center;width:115px'],
                        'value' => function ($model) {
                            $string = str_replace(['{', '}', '"'], '', $model['poli']);

                            // memisahkan string berdasarkan tanda koma
                            $poliListData = explode(',', $string);
                            $poliListData = array_unique($poliListData);

                            // Buat array asosiatif untuk "poli" tanpa angka di depannya
                            $poli = [];
                            foreach ($poliListData as $index => $namaPoli) {
                                // Menghapus angka di depan nilai
                                $namaPoli = preg_replace("/^[0-9]+/", "", $namaPoli);
                                $poli[$index] = $namaPoli;
                            }
                            return ($model['poli'] ? '<span class="text-black"><b>' . $namaPoli . '</b></span>' : '<span class="badge badge-danger">Belum Checkout</span>');
                        },
                        // 'filter' => true,

                    ],
                    [
                        'class' => 'yii\grid\ActionColumn',
                        'header' => 'Aksi',
                        'headerOptions' => ['style' => 'text-align: center'],
                        'contentOptions' => ['style' => 'vertical-align: middle;text-align: center'],
                        'template' => '{pilih}',
                        'buttons' => [

                            'pilih' => function ($url, $model) {

                                // if (!empty($model['closing_billing_ranap_at'])) {
                                $url = Url::to(['/dokter-verifikator-rawat-inap/index', 'id' => HelperGeneral::hashData($model['layanan_id'])]);
                                return '<button type="button" data-url="' . $url . '" class="btn btn-outline-primary btn-sm btn-block pilih" onclick="localStorage.setItem(\'layanan\', \'index\')">
                                                <span class="fas fa-user-check"></span> Klik untuk verifikasi
                                            </button>';
                                // } else {
                                //     return '<span class="badge badge-danger">Belum Bisa Coding / Belum Closing</span>';
                                // }
                            },
                        ]
                    ],
                ],
                'pager' => [
                    'class' => 'app\components\GridPager',
                ],
            ]); ?>

        </div>
    </div> <!-- end col -->
</div>
</div>
<?php Pjax::end(); ?>