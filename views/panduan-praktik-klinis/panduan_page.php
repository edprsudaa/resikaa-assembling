<?php

use yii\helpers\Html;

use app\models\Lib;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\LayananIgdSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'PANDUAN PRAKTIK KLINIS';
$this->params['breadcrumbs'][] = $this->title;
$path = \Yii::getAlias('@webroot') . '/images/logo_rsudaa_small.png';
$type = pathinfo($path, PATHINFO_EXTENSION);
$data = file_get_contents($path);
$base64_2 = 'data:image/' . $type . ';base64,' . base64_encode($data);
// echo'<pre/>';print_r($dataProvider);die();
$this->registerJs("
")
?>
<h3><?= Html::encode($this->title) ?> </h3>

<div class="card card-solid">
  <div class="card-body pb-0">
    <div class="row">
      <?php foreach ($model as $i => $item) { ?>


        <div class="col-12 col-sm-6 col-md-4 d-flex align-items-stretch flex-column">
          <div class="card bg-light d-flex flex-fill">
            <div class="card-header text-muted border-bottom-0">
              Panduan #<?= $i + 1 ?>
            </div>
            <div class="card-body pt-0">
              <div class="row">
                <div class="col-7">
                  <h2 class="lead"><b><?= $item->keterangan ?></b></h2>
                  <p class="text-muted text-sm"><b>Link Drive : </b> <?= $item->link ?? '' ?> </p>
                  <div class="text-left">
                    <a href="<?= $item->link ?>" target="_blank" class="btn btn-sm bg-teal">
                      <i class="fa fa-paper-plane"></i>
                    </a>
                    <a href="#" onclick="lihatPanduanPraktikKlinis(<?= $item->id ?>)" class="btn btn-sm btn-primary">
                      <i class="fas fa-eye"></i> Lihat Panduan
                    </a>
                  </div>
                </div>
                <div class="col-5 text-center">
                  <img src="<?= $base64_2 ?>" alt="user-avatar" class="img-circle img-fluid">
                </div>
              </div>
            </div>

          </div>
        </div>
      <?php } ?>

    </div>
  </div>
  <div class="modal fade" id="hasil-lab-luar-lihat">
    <div class="modal-dialog modal-xl">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Panduan Praktik Klinis </h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body" id="pdf-hasil-luar">
        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
        </div>
      </div>
    </div>
  </div>

</div>

<script>
  function lihatPanduanPraktikKlinis(id) {
    $('#hasil-lab-luar-lihat').modal('show')
    $('#pdf-hasil-luar').html("<embed src='<?= Url::to(['/panduan-praktik-klinis/dokumen?id=']) ?>" + id + "' width='100%' height='800px'>")

  }
</script>