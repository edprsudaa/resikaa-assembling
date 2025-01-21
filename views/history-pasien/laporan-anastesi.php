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
<table class="table table-sm table-form">
  <tr>
    <td colspan="2" style="width: 15%;"><label>Nama Dokter Anestesi</label></td>
    <td><label>:</label></td>
    <td colspan="4" style="width: 35%;">
      <?php

      foreach ($detail as $val) {
        echo HelperSpesialClass::getNamaPegawai($val->pegawai) . "</br>";
      }
      ?>
    </td>
    <td colspan="2" style="width: 15%;"><label>Rencana Tindakan</label></td>
    <td><label>:</label></td>
    <td colspan="4" style="width: 35%;">
      <?php
      foreach ($timoperasi as $val) {
        if(!empty($val->to_tanggal_operasi)){
        echo $val->to_tindakan_operasi??'-' . "</br>";
        }
    }
      ?>
    </td>
  </tr>
  <tr>
    <td colspan="2"><label>Diagnosa Medis</label></td>
    <td><label>:</label></td>
    <td colspan="4">
      <?php
      foreach ($timoperasi as $val) {
        if(!empty($val->to_diagnosa_medis_pra_bedah)){
        echo $val->to_diagnosa_medis_pra_bedah??'-' . "<br>";
        }
      }
      ?>
    </td>
  </tr>
  <tr>
    <td colspan="2"><label>Tanggal</label></td>
    <td><label>:</label></td>
    <td colspan="4">
      <?php
      foreach ($timoperasi as $val) {
        if(!empty($val->to_tanggal_operasi)){
            echo date("d M Y H:i:s", strtotime($val->to_tanggal_operasi));

        }
      }
      ?>
    </td>
    <td colspan="2"><label>Lokasi</label></td>
    <td><label>:</label></td>
    <td colspan="4">
      <?php
      foreach ($timoperasi as $val) {
        echo $val->unit->nama??'-'. "<br>";
      }
      ?>
    </td>
  </tr>
</table>

<table class="table table-sm table-form">
  <tr>
    <th class="text-left bg-lightblue" colspan="13">ASESMEN PRA INDUKSI</th>
  </tr>
  <tr>
    <th class="text-left" colspan="13">Riwayat Penyakit</th>
  </tr>
  <tr>
    <!-- <td class="samping"></td> -->
    <td style="width: 20%;"><label><?= $model->getAttributeLabel('api_kesadaran') ?> </label></td>
    <td><label>:</label></td>
    <td>
      <?php
      echo $model->api_kesadaran??'-';
      ?>
    </td>
  </tr>
  <tr>
    <td><label><?= $model->getAttributeLabel('api_td') ?> </label></td>
    <td><label>:</label></td>
    <td>
      <?php
      echo $model->api_td??'-';
      ?>
    </td>
  </tr>
  <tr>
    <td><label><?= $model->getAttributeLabel('api_hr') ?> </label></td>
    <td><label>:</label></td>
    <td>
      <?php
      echo $model->api_hr??'-';
      ?>
    </td>
  </tr>
  <tr>
    <td class="samping"></td>
    <td><label><?= $model->getAttributeLabel('api_rr') ?> </label></td>
    <td><label>:</label></td>
    <td>
      <?php
      echo $model->api_rr??'-';
      ?>
    </td>
  </tr>
  <tr>
    <td class="samping"></td>
    <td><label><?= $model->getAttributeLabel('api_temp') ?> </label></td>
    <td><label>:</label></td>
    <td>
      <?php
      echo $model->api_temp??'-';
      ?>
    </td>
  </tr>
  <tr>
    <td class="samping"></td>
    <td><label><?= $model->getAttributeLabel('api_gol_darah') ?> </label></td>
    <td><label>:</label></td>
    <td>
      <?php
      echo $model->api_gol_darah??'-';;
      ?>
    </td>
  </tr>
  <tr>
    <td colspan="2"><label><?= $model->getAttributeLabel('api_puasa') ?> </label></td>
    <td><label>:</label></td>
    <td>
      <?= $model->api_puasa??'-'; ?>
    </td>
  </tr>
  <tr>
    <th colspan="2" class="text-left">Akses Infus</th>
    <td><label>:</label></td>
    <td><label>No. IV LINE</label></td>
  </tr>
  <tr>
    <td class="samping"></td>
    <td><label><?= $model->getAttributeLabel('api_infus_tangan_kanan') ?> </label></td>
    <td><label>:</label></td>
    <td>
      <?= $model->api_infus_tangan_kanan??'-'; ?>
    </td>
  </tr>
  <tr>
    <td class="samping"></td>
    <td><label><?= $model->getAttributeLabel('api_infus_tangan_kiri') ?> </label></td>
    <td><label>:</label></td>
    <td>
      <?= $model->api_infus_tangan_kiri??'-'; ?>
    </td>
  </tr>
  <tr>
    <td class="samping"></td>
    <td><label><?= $model->getAttributeLabel('api_infus_kaki_kanan') ?> </label></td>
    <td><label>:</label></td>
    <td>
      <?= $model->api_infus_kaki_kanan??'-'; ?>
    </td>
  </tr>
  <tr>
    <td class="samping"></td>
    <td><label><?= $model->getAttributeLabel('api_infus_kaki_kiri') ?> </label></td>
    <td><label>:</label></td>
    <td>
      <?= $model->api_infus_kaki_kiri??'-'; ?>
    </td>
  </tr>
  <tr>
    <th colspan="2" class="text-left">Akses Lain</th>
    <td><label>:</label></td>
  </tr>
  <tr>
    <td class="samping"></td>
    <td><label><?= $model->getAttributeLabel('api_ngt') ?> </label></td>
    <td><label>:</label></td>
    <td>
      <?= $model->api_ngt??'-'; ?>
    </td>
  </tr>
  <tr>
    <td class="samping"></td>
    <td><label><?= $model->getAttributeLabel('api_kateter') ?> </label></td>
    <td><label>:</label></td>
    <td>
      <?= $model->api_kateter??'-'; ?>
    </td>
  </tr>
  <tr>
    <td class="samping"></td>
    <td><label><?= $model->getAttributeLabel('api_drain') ?> </label></td>
    <td><label>:</label></td>
    <td>
      <?= $model->api_drain; ?>
    </td>
  </tr>
  <tr>
    <td class="samping"></td>
    <td><label><?= $model->getAttributeLabel('api_cvp') ?> </label></td>
    <td><label>:</label></td>
    <td>
      <?= $model->api_cvp??'-'; ?>
    </td>
  </tr>
  <tr>
    <td class="samping"></td>
    <td><label><?= $model->getAttributeLabel('api_lain_lain') ?> </label></td>
    <td><label>:</label></td>
    <td>
      <?= $model->api_lain_lain??'-'; ?>
    </td>
  </tr>
  <tr>
    <td colspan="2"><label><?= $model->getAttributeLabel('api_status_asa') ?></label> </td>
    <td><label>:</label></td>
    <td>
      <?php
      echo $model->api_status_asa??'-';
      ?>
    </td>
  </tr>
  <tr>
    <td colspan="2"><label><?= $model->getAttributeLabel('api_rencana_tindakan_anestesi') ?></label> </td>
    <td><label>:</label></td>
    <td>
      <?php
      echo $model->api_rencana_tindakan_anestesi??'-';
      ?>
    </td>
  </tr>
  <tr style="height: 200px; margin: 0; padding: 0;">
        <td colspan="12"><p>Dokter Anestesi</p><br /><br /><br /><br /><br /><br /><b><?php
      foreach ($detail as $val) {
        echo HelperSpesialClass::getNamaPegawai($val->pegawai) . "</br>";
      }
      ?></b><br></td>
    </tr>

</table>