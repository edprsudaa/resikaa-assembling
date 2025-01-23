<?php

use app\components\HelperGeneralClass;
use yii\helpers\Url;

?>

<div class="col-lg-4">
    <div class="card">
        <a type="button" href=<?= Url::to(["history-pasien/list-kunjungan-object?id=" . HelperGeneralClass::hashData($registrasi['pasien_kode']) . "&versi=1"]) ?> href="#custom-tabs-two-0" role="tab" aria-controls="custom-tabs-two-0" aria-selected="false" target="_blank" class="btn btn-block bg-gradient-warning btn-lg">Histori Berdasar Dokumen</a>
    </div>
</div>
<div class="col-lg-4">
    <div class="card">
        <a type="button" href=<?= Url::to(["history-pasien/list-kunjungan?id=" . HelperGeneralClass::hashData($registrasi['pasien_kode']) . "&versi=1"]) ?> href="#custom-tabs-two-0" role="tab" aria-controls="custom-tabs-two-0" aria-selected="false" target="_blank" class="btn btn-block bg-gradient-success btn-lg">Histori Berdasar Registrasi</a>

    </div>
</div>
<div class="col-lg-4">
    <div class="card">
        <a type="button" href=<?= Url::to(["history-pasien/detail-kunjungan?noreg=" . HelperGeneralClass::hashData($registrasi['kode'])]) ?> href="#custom-tabs-two-0" role="tab" aria-controls="custom-tabs-two-0" aria-selected="false" target="_blank" class="btn btn-block bg-gradient-primary btn-lg">Histori Berdasar Registrasi Hari Ini</a>

    </div>
</div>