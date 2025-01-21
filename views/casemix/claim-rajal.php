<?php

use app\components\HelperSpesialClass;
use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Html;
use yii\helpers\Url;

?>
<div class="item-detail">
    <?php if (empty($data)): ?>
        <div class="alert alert-warning">
            Tidak ada data item diagnosa dan tindakan yang tersedia untuk claim ini.
        </div>
    <?php else: ?>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Coder</th>
                    <th>Claim Diagnosa</th>
                    <th>Claim Tindakan</th>


                </tr>
            </thead>
            <tbody>
                <?php foreach ($data as  $item): ?>
                    <tr>
                        <td style="width: 20%;"><?= Html::encode($item->registrasi_kode) ?><br><?= $item->registrasi->pasien->nama ?? '' ?><br><?= $item->registrasi->pasien->kode ?> </td>
                        <td style="width: 20%;"><?= HelperSpesialClass::getNamaPegawaiArray($item->coder) ?? '' ?></td>
                        <td>
                            <ul>
                                <?php foreach ($item->pelaporanDiagnosa as $index => $itemDiagnosa) { ?>
                                    <li><?= $itemDiagnosa->diagnosa->kode ?> (<?= $itemDiagnosa->diagnosa->deskripsi ?>) - <?= $itemDiagnosa->utama == 1 ? "<span class='badge badge-info shadow p-2'>Dx Utama </span>" : "<span class='badge badge-warning shadow p-2'>Dx Sekunder " . $index . "</span>" ?></li>
                                <?php } ?>
                            </ul>
                        </td>
                        <td>
                            <ul>
                                <?php foreach ($item->pelaporanTindakan as $index => $itemTindakan) { ?>
                                    <li><?= $itemTindakan->tindakan->kode ?> (<?= $itemTindakan->tindakan->deskripsi ?>) - <?= $itemTindakan->utama == 1 ? "<span class='badge badge-info shadow p-2'>Dx Utama </span>" : "<span class='badge badge-warning shadow p-2'>Dx Sekunder " . $index . "</span>" ?></li>
                                <?php } ?>
                            </ul>
                        </td>


                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
    <?php if (empty($data)): ?>
        <div class="alert alert-danger">
            Tidak ada data yang tersedia untuk form estimasi claim ini.
        </div>
    <?php else: ?>
        <?php $form = ActiveForm::begin([
            'id' => 'claim-' . $model->formName(),
            'options' => [
                'name' => 'claim-' . $model->formName(),
                'data-pjax' => true
            ],
        ]); ?>
        <?= $form->field($model, 'id')->hiddenInput()->label(false) ?>

        <?= $form->field($model, 'estimasi')->textInput(['maxlength' => true, 'type' => 'number', 'step' => '1', 'id' => 'estimasi']) ?>




        <div class="form-group">
            <?= Html::button('Simpan', [
                'class' => 'btn btn-primary btn-claim',
                'id' => 'claim-simpan',
                'data-url' => Url::to(['/casemix/update-estimasi-rajal']) // Sesuaikan dengan URL yang diinginkan
            ]) ?>

        </div>

        <?php ActiveForm::end(); ?>
    <?php endif; ?>
</div>