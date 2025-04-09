<?php

use app\components\HelperGeneral;
use app\components\HelperSpesial;
use app\models\bedahsentral\TimOperasi;
use app\models\pendaftaran\Pasien;
use yii\helpers\Html;
use yii\helpers\Url;
?>
<?php
$this->registerJs($this->render('script.js'));
?>
<div class="row" style="margin: -10px -20px 0px -20px;">
  <div class="col-lg-12">
    <div class="card bg-info text-white">
      <div class="card-body" style="min-height:180px !important;padding:0.5rem !important;">
        <div class="row">
          <div class="col-lg-8">
            <div class="row">
              <div class="col-lg-4">
                <h6 class="text-sm">No.RM:</h6>
                <h6 class="text-sm text-white"><?php echo $layanan['registrasi']['pasien']['kode']; ?></h6>
              </div>
              <div class="col-lg-4">
                <h6 class="text-sm">No.Reg:</h6>
                <h6 class="text-sm text-white"><?php echo $layanan['registrasi']['kode']; ?></h6>
              </div>
            </div>
            <div class="row">
              <div class="col-lg-4">
                <h6 class="text-sm">Nama:</h6>
                <h6 class="text-sm text-white"><?php echo $layanan['registrasi']['pasien']['nama']; ?></h6>
              </div>
              <div class="col-lg-4">
                <h6 class="text-sm">Tgl.Lahir:</h6>
                <h6 class="text-sm text-white"><?php echo HelperGeneral::getDateFormatToIndo($layanan['registrasi']['pasien']['tgl_lahir'], false); ?></h6>
              </div>
              <div class="col-lg-4">
                <h6 class="text-sm">Tgl.Masuk:</h6>
                <h6 class="text-sm text-white"><?php echo  HelperGeneral::getDateFormatToIndo($layanan['tgl_masuk'], false) . ' ' . date('H:i', strtotime($layanan['tgl_masuk'])); ?></h6>
              </div>
            </div>
            <div class="row">
              <div class="col-lg-4">
                <h6 class="text-sm">Gender:</h6>
                <h6 class="text-sm text-white">
                  <?= ($layanan['registrasi']['pasien']['jkel'] ? Pasien::$jenis_kelamin[strtolower($layanan['registrasi']['pasien']['jkel'])] : "-"); ?>
                </h6>
              </div>
              <div class="col-lg-4">
                <h6 class="text-sm">Umur By Tgl.Masuk:</h6>
                <h6 class="text-sm text-white">
                  <?php
                  $umur = HelperGeneral::getUmur($layanan['registrasi']['pasien']['tgl_lahir'], $layanan['tgl_masuk']);
                  echo $umur['th'] . ' TH ' . $umur['bl'] . ' BL ' . $umur['hr'] . ' HR'; ?>
                </h6>
              </div>
              <div class="col-lg-4">
                <h6 class="text-sm">Ruangan:</h6>
                <h6 class="text-sm text-white"><?php echo $layanan['unit']['nama']; ?></h6>
              </div>
            </div>
          </div>
          <div class="col-lg-4">
            <div class="row">
              <div class="col-lg-12">
                <h6 class="text-sm">Penjamin:</h6>
                <h6 class="text-sm text-white"><?= ($layanan['registrasi']['debiturDetail']) ? $layanan['registrasi']['debiturDetail']['nama'] : 'Tidak Ada'; ?></h6>
              </div>
            </div>
            <div class="row">
              <div class="col-lg-12">
                <button type="button" class="btn btn-warning btn-sm btn-block mb-1" data-id="0" id="kembali">
                  <i class="nav-icon fas fa-fas fa-search"></i> Cari Pasien Lain
                </button>

                <?php
                if (Yii::$app->params['fitur']['esep']) {
                  $no_sep = [];
                  if ($layanan['registrasi']) {
                    if (($layanan['registrasi']['no_sep'] != 0) && ($layanan['registrasi']['no_sep'] != '')) {
                      $no_sep['rj'] = $layanan['registrasi']['no_sep'];
                    }
                    if (($layanan['registrasi']['no_sep_ri'] != 0) && ($layanan['registrasi']['no_sep_ri'] != '')) {
                      $no_sep['ri'] = $layanan['registrasi']['no_sep_ri'];
                    }
                    if (($layanan['registrasi']['no_sep_igd'] != 0) && ($layanan['registrasi']['no_sep_igd'] != '')) {
                      $no_sep['igd'] = $layanan['registrasi']['no_sep_igd'];
                    }
                  }
                  $closing = $layanan['registrasi'] ? $layanan['registrasi']['is_closing_billing_ranap'] : '';
                  if ($closing == 1 && Yii::$app->params['fitur']['closing']) {
                    echo "<i style='color:red' class='fas fa-times'>HUBUNGI RIDHO GANTENG</i>";
                  } else {
                    if (!empty($no_sep)) {
                      $no_sepp = '';
                      foreach ($no_sep as $k => $values) {
                        $lay = strtoupper($k);
                        $url = "http://pendaftaran.simrs.aa/sep-v3/cetak-esep?no_sep={$values}";
                        $no_sepp .= "<a href='{$url}' target='_blank' class='btn btn-dark btn-sm btn-block mb-1'>
                                      <i class='nav-icon'></i> E-SEP {$lay}
                                    </a>";
                      }
                      echo $no_sepp;
                    }
                  }
                }
                ?>
              </div>
            </div>
          </div>
        </div>
      </div> <!-- end card-body -->
    </div> <!-- end card-->
  </div> <!-- end col-->
</div>