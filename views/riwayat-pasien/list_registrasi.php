<?php

use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\widgets\Pjax;
use yii\grid\GridView;
use kartik\date\DatePicker;
use kartik\select2\Select2;
use app\components\HelperSpesialClass;

$this->title = 'Daftar Kunjungan Pasien ' . ($pasien != NULL ? '<b>' . $pasien['nama'] . ' (' . $pasien['kode'] . ')</b>' : '');
?>
<div class="card card-primary card-outline">
    <div class="card-header">
        <h4 class="card-title"><?php echo $this->title; ?></h4><br>
        <i>Pilih salah satu kunjungan untuk melihat detail pelayanan pasien</i>
    </div>
    <div class="card-body">
        <?php Pjax::begin(['id' => 'pjax-registrasi']); ?>
        <?= GridView::widget([
            'id' => 'grid-registrasi',
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                [
                    'label' => 'No. RM',
                    'attribute' => 'pasien_kode',
                    'format' => 'raw',
                    'visible' => HelperSpesialClass::isMpp() ? true : false,
                    'value' => function ($q) {
                        return $q->pasien_kode . ($q->pasien != NULL ? '<br><i>' . $q->pasien->nama . '</i>' : '');
                    }
                ],
                [
                    'label' => 'No. Registrasi',
                    'attribute' => 'kode',
                    //'headerOptions'=>['style' => 'width:12%'],
                ],
                [
                    'label' => 'Tgl Masuk',
                    'format' => 'raw',
                    'attribute' => 'tgl_masuk',
                    //'headerOptions'=>['style' => 'width:12%'],
                    'value' => function ($q) {
                        return $q->tgl_masuk != NULL ? date('d-m-Y H:i:s', strtotime($q->tgl_masuk)) : '';
                    },
                    'filter' => DatePicker::widget([
                        'model' => $searchModel,
                        'type' => 1,
                        'removeButton' => false,
                        'attribute' => 'tgl_masuk',
                        'options' => ['class' => 'form-control', 'id' => 'tgl_masuk', 'autocomplete' => 'off'],
                        'pluginOptions' => [
                            'autoclose' => true,
                            'format' => 'dd-mm-yyyy'
                        ]
                    ])
                ],
                [
                    'label' => 'Tgl Keluar',
                    'format' => 'raw',
                    'attribute' => 'tgl_keluar',
                    //'headerOptions'=>['style' => 'width:12%'],
                    'value' => function ($q) {
                        return $q->tgl_keluar != NULL ? date('d-m-Y H:i:s', strtotime($q->tgl_keluar)) : '';
                    },
                    'filter' => DatePicker::widget([
                        'model' => $searchModel,
                        'type' => 1,
                        'removeButton' => false,
                        'attribute' => 'tgl_keluar',
                        'options' => ['class' => 'form-control', 'id' => 'tgl_keluar', 'autocomplete' => 'off'],
                        'pluginOptions' => [
                            'autoclose' => true,
                            'format' => 'dd-mm-yyyy'
                        ]
                    ])
                ],
                [
                    'label' => 'Debitur',
                    'attribute' => 'debitur_detail_kode',
                    //'headerOptions'=>['style' => 'width:15%'],
                    'value' => function ($q) {
                        return $q->debiturDetail != NULL ? $q->debiturDetail->nama : '';
                    },
                    'filter' => Select2::widget([
                        'attribute' => 'debitur_detail_kode',
                        'model' => $searchModel,
                        'data' => ArrayHelper::map($debitur, 'kode', 'nama'),
                        'options' => [
                            'placeholder' => '',
                        ],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ])
                ],
                [
                    'class' => 'yii\grid\ActionColumn',
                    'header' => '-',
                    'template' => '{view}',
                    'buttons' => [
                        'view' => function ($url, $model) {
                            return "<a href='" . Url::to(['detail-kunjungan', 'rm' => $model->pasien_kode, 'noreg' => $model->kode]) . "' data-pjax='0' class='btn btn-flat btn-info btn-sm btn-detail' data-id='" . $model->kode . "' title='lihat detail pelayanan'><i class='fa fa-list'></i></a>";
                        },
                    ]
                ],
            ],
        ]); ?>
        <?php Pjax::end(); ?>
    </div>
</div>