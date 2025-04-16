<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Pjax;

?>

<div class="card card-outline card-info">
  <div style="padding: 0;" class="card-header">
    <h3 style="float: none;" class="card-title text-center mt-1 mb-1"><b>RIWAYAT</b></h3>
  </div>

  <div class="card-body">
    <table class="table table-sm table-hover"> <!-- Tambahkan class table-hover -->
      <thead>
        <tr>
          <th style="text-align:left;">List Dokumen:</th>
          <!-- <th></th> -->
        </tr>
      </thead>
      <tbody>
        <?php
        if (!empty($datalist)) {
          foreach ($datalist as $dl) {
            $url = Url::to(['/dokter-verifikator-rawat-jalan/update', 'id' => Yii::$app->request->get('id'), 'subid' => $dl['id']]);
            if ($dl['tanggal_final']) {
              if ($dl['batal']) {
                $status = "<span class='text-danger'><b>BATAL</b></span>";
              } else {
                $status = "<span class='text-success'><b>FINAL</b></span>";
              }
            } else {
              $status = "<span class='text-primary'><b>DRAFT</b></span>";
            }

            if ($dl['edit_verifikator'] == '1') {
              $statusVerifikator = "<span class='text-primary'><b> Diverifikasi</b></span>";
            } else {
              $statusVerifikator = "<span class='text-danger'><b> Belum Diverifikasi</b></span>";
            }
        ?>
            <tr onclick="location.href='<?= $url ?>'" style="cursor: pointer;" class="<?= Yii::$app->request->get('subid') == $dl['id'] ? 'table-secondary' : '' ?>">
              <td style="vertical-align: middle;"><b>Tgl</b>: <?= Yii::$app->formatter->asDate($dl['created_at']) . "<br><b>Jam</b>: " . Yii::$app->formatter->asTime($dl['created_at']) . "<br><b>Status</b>: " . $status . "<br><b>Verifikasi</b>:" . $statusVerifikator ?></td>
              <!-- <td style="vertical-align: middle;">
                <a href="<?= $url ?>" class="btn btn-outline-dark btn-sm btn-block" data-pjax=0>
                  <span class="fas fa-eye"></span>
                </a>
              </td> -->
            </tr>
          <?php }
        } else { ?>
          <tr>
            <td class="text-center">Belum dibuat</td>
          </tr>
        <?php } ?>
      </tbody>
    </table>
  </div>
</div>