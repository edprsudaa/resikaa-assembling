<?php

use app\components\HelperSpesialClass;
use app\models\medis\AsesmenAwalKeperawatanGeneral;
use app\models\medis\AsesmenAwalMedis;
use app\models\pendaftaran\Pasien;
use yii\helpers\Url;

?>
<style>
    h2 {
        text-align: center !important;
    }

    table {
        margin-left: auto !important;
        margin-right: auto !important;
        margin-bottom: 9px !important;
        width: 90% !important;
        border-collapse: collapse;
    }

    th {
        background-color: #D3D3D3 !important;
        text-align: left !important;
    }

    tr td {
        padding: 5px 5px 5px 5px !important;
        text-align: left !important;

    }

    tr td .no_border {
        border: none;
    }
</style>
<?php

?>

<?= $this->render('doc_kop', ['pasien' => $pasien]);

?>
<h2>Laporan Operasi</h2>
<table border="1" cellspacing="0" class="table table-sm table-form" style="border: 1px solid;">
    <tr style="height:50px; text-align: center;">
        <th style="border-bottom-style: none;">Tanggal Operasi</th>
        <th style="border-bottom-style: none;"><?= $model->getAttributeLabel('lap_op_ruangan') ?></th>
        <th style="border-bottom-style: none;"><?= $model->getAttributeLabel('lap_op_kelas') ?></th>
        <th style="border-bottom-style: none;"><?= $model->getAttributeLabel('lap_op_jam_mulai') ?></th>
        <th style="border-bottom-style: none;"><?= $model->getAttributeLabel('lap_op_jam_selesai') ?></th>
        <th style="border-bottom-style: none;"><?= $model->getAttributeLabel('lap_op_lama_operasi') ?></th>
    </tr>
    <tr style="text-align:center;">
        <td><?= \Yii::$app->formatter->asDate($model->lap_op_tanggal) . ' ' . \Yii::$app->formatter->asTime($model->lap_op_tanggal); ?></td>
        <td><?= $timoperasi->unit->nama??'-' ?></td>
        <td><?= $model->lap_op_kelas??'-'; ?></td>
        <td><?= $model->lap_op_jam_mulai??'-' ?></td>
        <td><?= $model->lap_op_jam_selesai??'-' ?></td>
        <td> <?= $model->lap_op_lama_operasi??'-' ?></td>
    </tr>
    <tr>
        <td style="text-align: center;"><label>Nama Ahli Bedah</label></td>
        <td style="text-align: center;"><label>Nama Dokter Anestesi</label></td>
        <td style="border-right-style: none;"><label>Asisten</label></td>
        <td colspan="3">
            <?php
            foreach ($asisten as $val) {
                echo HelperSpesialClass::getNamaPegawai($val->pegawai) . "</br>";
            }
            ?>
        </td>
    </tr>
    <tr>
        <td rowspan="3" align="center">
            <?php
            foreach ($ahlibedah as $val) {
                echo HelperSpesialClass::getNamaPegawai($val->pegawai) . "</br>";
            }
            ?>
        </td>
        <td rowspan="3" align="center">
            <?php
            foreach ($ahlianestesi as $val) {
                echo HelperSpesialClass::getNamaPegawai($val->pegawai);
            }
            ?>
        </td>
        <td style="border-right-style: none;"><label>Instrumentator</label></td>
        <td colspan="3">
            <?php
            $no = 1;
            foreach ($instrumen as $val) {
                echo $no++ . '. ' . HelperSpesialClass::getNamaPegawai($val->pegawai) . "</br>";
            }
            ?>
        </td>
    </tr>
    <tr>
        <td style="border-right-style: none;"><label>Sirkuler</label></td>
        <td colspan="3">
            <?php
            $no = 1;
            foreach ($sirkuler as $val) {
                echo $no++ . '. ' . HelperSpesialClass::getNamaPegawai($val->pegawai) . "</br>";
            }
            ?>
        </td>
    </tr>
    <tr>
        <td style="border-right-style: none;"><label>Penata Anestesi</label></td>
        <td colspan="3">
            <?php
            $no = 1;
              foreach ($perawatanestesi as $val) {
                echo $no++ . '. ' . HelperSpesialClass::getNamaPegawai($val->pegawai) . "</br>";
              }
            ?>
        </td>
    </tr>
    <tr>
        <td>
            <label><?= $model->getAttributeLabel('lap_op_diagnosis_pre_operasi') ?> : </label>
        </td>
        <td colspan="5">
            <?= $model->lap_op_diagnosis_pre_operasi??'-' ?>
        </td>
    </tr>
    <tr>
        <td>
            <label><?= $model->getAttributeLabel('lap_op_diagnosis_pasca_operasi') ?> : </label>
        </td>
        <td colspan="5">
            <?= $model->lap_op_diagnosis_pasca_operasi??'-' ?>
        </td>
    </tr>
    <tr>
        <td colspan="6">
            <label> <?= $model->getAttributeLabel('lap_op_nama_jenis_operasi') ?> : </label>
            <?= $model->lap_op_nama_jenis_operasi??'-' ?>

        </td>
    </tr>
    <tr>
        <td colspan="6">
            <label>Jaringan yang dieksisi/insisi: </label>
            <?= $model->lap_op_jenis_jaringan??'-'; ?>
        </td>
    </tr>
    <tr>
        <td colspan="6">
            <label><?= $model->getAttributeLabel('lap_op_jaringan_operasi_dikirim') ?> : </label>
            <?= $model->lap_op_jaringan_operasi_dikirim??'-' ?>
        </td>
    </tr>
    <tr>
    <td colspan="6">
    <label><?= $model->getAttributeLabel('lap_op_laporan') ?> :</label><br>
      <?= $model->lap_op_laporan??'-' ?>
    </td>
  </tr>
  <tr>
    <td colspan="6">
      <label><?= $model->getAttributeLabel('lap_op_instruksi_prwt_pasca_operasi') ?> :</label>
      <?= $model->lap_op_instruksi_prwt_pasca_operasi??'-' ?>
    </td>
  </tr>
    <tr>
        <td colspan="6">
            <label><?= $model->getAttributeLabel('lap_op_penyulit') ?>: </label>
            <?= $model->lap_op_penyulit??'-' ?>
        </td>
    </tr>
    <tr>
        <td colspan="6">
            <label><?= $model->getAttributeLabel('lap_op_jumlah_perdarahan') ?> :</label>
            <?= $model->lap_op_jumlah_perdarahan??'-' ?>
        </td>
    </tr>
    <tr style="height: 200px; margin: 0; padding: 0;">
        <td colspan="12"><p>Nama dan Tanda Tangan Dokter Operator</p><br /><br /><br /><br /><br /><br /><b><?php
      foreach ($ahlibedah as $val) {
        echo HelperSpesialClass::getNamaPegawai($val->pegawai) . "</br>";
      }
      ?></b><br></td>
    </tr>
   
</table>