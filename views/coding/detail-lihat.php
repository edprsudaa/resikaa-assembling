<?php

use app\models\Unit;
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

$this->title = 'Detail Pendistribusian Dokumen Rekam Medik';
$this->params['breadcrumbs'][] = $this->title;
$this->registerJs($this->render('script.js'), View::POS_END);
?>
<div class="container-fluid">
  <div class="row">
    <div class="col-md-3">


      <!-- About Me Box -->
      <div class="card card-primary">
        <div class="card-header">
          <h3 class="card-title">Detail Distribusi Dokumen Rekam Medik</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
          <strong><i class="fas fa-book mr-1"></i> Tanggal Pendistribusian Awal Dokumen</strong>

          <p class="text-muted">
            <?= $distribusi->fd_created_at ?>
          </p>

          <hr>
          <?php if ($distribusi->pegawai->pgw_nama != null) { ?>
            <strong><i class="fas fa-user mr-1"></i> Petugas Pengantar Dokumen RM</strong>

            <p class="text-muted">
              <?= $distribusi->pegawai->pgw_nama ?>
            </p>

            <hr>
          <?php } ?>
          <?php if ($distribusi->fd_reg_kode != null) { ?>
            <strong><i class="fas fa-book mr-1"></i> Nomor Pendistribusian Dokumen Registrasi</strong>

            <p class="text-muted">
              <?= $distribusi->fd_reg_kode ?>
            </p>

            <hr>
          <?php } ?>
          <?php if ($distribusi->fd_reg_peminjaman != null) { ?>
            <strong><i class="far fa-file-alt mr-1"></i> Nomor Pendistribusian Dokumen Peminjaman </strong>

            <p class="text-muted">
              <?= $distribusi->fd_reg_peminjaman ?>
            </p>

            <hr>
            <?php if ($distribusi->peminjamanDetail->peminjaman->fp_alasan_peminjaman != null) { ?>
              <strong><i class="fas fa-book mr-1"></i> Alasan Peminjaman Dokumen </strong>

              <p class="text-muted">
                <?= $distribusi->peminjamanDetail->peminjaman->fp_alasan_peminjaman ?>
              </p>

              <hr>
            <?php } ?>
          <?php } ?>

          <?php if ($distribusi->fd_pasien_kode != null) { ?>
            <strong><i class="fas fa-book mr-1"></i> Nomor Rekam Medis </strong>

            <p class="text-muted">
              <?= $distribusi->fd_pasien_kode ?>
            </p>

            <hr>
          <?php } ?>
          <?php if ($distribusi->pasien->ps_nama != null) { ?>
            <strong><i class="fas fa-book mr-1"></i> Nama Pasien </strong>

            <p class="text-muted">
              <?= $distribusi->pasien->ps_nama ?>
            </p>

            <hr>
          <?php } ?>


        </div>
        <!-- /.card-body -->
      </div>
      <!-- /.card -->
    </div>
    <!-- /.col -->
    <div class="col-md-9">
      <div class="card">
        <div class="card-header p-2">
          <ul class="nav nav-pills">

            <li class="nav-item"><a class="nav-link active" href="#timeline" data-toggle="tab">Rute Perjalanan Dokumen Rekam Medik</a></li>
          </ul>
        </div><!-- /.card-header -->
        <div class="card-body">
          <div class="tab-content">

            <!-- /.tab-pane -->
            <div class="tab-pane active" id="timeline">
              <!-- The timeline -->
              <div class="timeline timeline-inverse">
                <!-- timeline time label -->

                <!-- /.timeline-label -->
                <!-- timeline item -->
                <?php
                $id = 0;
                $status = '';
                foreach ($distribusiDetail as $data) {
                  if ($data->fdd_petugas_penerima_id != null && $data->fdd_tgl_terima != null) {
                    $status = 'success';
                  } else {
                    $status = 'warning';
                  }

                ?>
                  <div>
                    <i class="fas fa-envelope bg-<?= $status ?>"></i>

                    <div class="timeline-item">
                      <span class="time"><i class="far fa-clock"></i> <?= $data->fdd_created_at ? $data->fdd_created_at : '-' ?></span>

                      <h3 class="timeline-header">

                        <span class='right badge badge-<?= $status ?>'>
                          <?= $data->unitTujuan->unt_nama ?>
                        </span>
                        <?= $data->fdd_tgl_terima ? ' telah menerima dokumen' : '' ?>
                      </h3>

                      <div class="timeline-footer">
                        <?php if ($data->fdd_petugas_penerima_id != null && $data->fdd_tgl_terima != null) { ?>
                          <strong><i class="fas fa-book mr-1"></i> Nama Penerima Dokumen </strong>

                          <p class="text-muted">
                            <?= $data->pegawai->pgw_nama ?>
                          </p>
                          <strong><i class="fas fa-book mr-1"></i> Waktu Terima Dokumen </strong>

                          <p class="text-muted">
                            <?= $data->fdd_tgl_terima ?>
                          </p>
                        <?php } ?>
                        <?php if ($data->fdd_petugas_penerima_id == null && $data->fdd_tgl_terima == null) { ?>
                          <strong><i class="fas fa-book mr-1"></i> Nama Penerima Dokumen </strong>

                          <p class="text-muted">
                            -
                          </p>
                          <strong><i class="fas fa-book mr-1"></i> Waktu Terima Dokumen </strong>

                          <p class="text-muted">
                            -
                          </p>
                          <strong><i class="fas fa-book mr-1"></i> Posisi Dokumen Sebelumnya </strong>

                          <p class="text-muted">
                            <?= $data['unitAsal']['unt_nama'] ?>
                          </p>
                          
                        <?php } ?>

                      </div>
                    </div>
                  </div>

                <?php
                  $id++;
                }
                ?>



              </div>
            </div>
            <!-- /.tab-pane -->


            <!-- /.tab-pane -->
          </div>
          <!-- /.tab-content -->
        </div><!-- /.card-body -->
      </div>
      <!-- /.card -->
    </div>
    <!-- /.col -->
  </div>
  <!-- /.row -->
</div>