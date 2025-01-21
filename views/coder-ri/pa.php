<div class="card card-success">
    <div class="card-header">
        <h3 class="card-title">Data Hasil Patologi Anatomi Pasien (<?= $no_rm ?>)</h3>
    </div>

    <div class="card-body">

        <div id="accordion">
            <?php

            use yii\helpers\Url;

            foreach ($data as $idx => $h) : ?>
                <div class="card card-<?php
                                        if ($h['is_save'] == 1) {
                                            echo 'primary';
                                        } else {
                                            echo 'danger';
                                        } ?> ?>">
                    <div class="card-header">
                        <h4 class="card-title w-100">
                            <a class="d-block w-100" data-toggle="collapse" href="#acc<?= $h['id'] ?>">
                                <b>Unit Asal :</b> <?= $h['unitAsal'] ?>, <b>Dokter Medis :</b> <?= $h['dokterNama'] ?>, <b>Tanggal Order :</b> <?= $h['tgl_pemeriksaan'] ?>
                            </a>
                        </h4>
                    </div>
                    <div id="acc<?= $h['id'] ?>" class="collapse <?= $idx == 0 ? 'show' : '' ?>" data-parent="#accordion">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-3">
                                    <b> Dokter Patologi Anatomi</b>
                                </div>
                                <div class="col-1">
                                    <b>:</b>
                                </div>
                                <div class="col-6">
                                    <b><?= $h['deskripsi'] ?></b>
                                </div>
                                <div class="col-3">
                                    <b> Pemeriksaan</b>
                                </div>
                                <div class="col-1">
                                    <b>:</b>
                                </div>
                                <div class="col-6 mb-4">
                                    <b><?= $h['dokterPAnama'] ?></b>
                                </div>
                                <?php if ($h['is_save'] == 1) { ?>
                                    <div class="col-12">
                                        <embed src="<?= Url::to(['/hasil/pa-id?id=' . $h['id'], '&pemeriksaan=' . $h['tarif_tindakan_pasien_id']]) ?>" width="100%" height="800px">
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach ?>
        </div>
    </div>
</div>