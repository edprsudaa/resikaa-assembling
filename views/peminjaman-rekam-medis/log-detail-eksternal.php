<?php

use app\components\HelperSpesialClass;
use yii\bootstrap4\Html;

?>
<div class="log-detail">
    <?php if (empty($logData)): ?>
        <div class="alert alert-warning">
            Tidak ada data log yang tersedia untuk peminjaman ini.
        </div>
    <?php else: ?>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Nos</th>
                    <th>Nama Pegawai</th>
                    <th>IP Komputer</th>
                    <th>Token Peminjaman</th>
                    <th>Kapan Diakses</th>

                </tr>
            </thead>
            <tbody>
                <?php foreach ($logData as $index => $log): ?>
                    <tr>
                        <td><?= $index + 1 ?></td>
                        <td><?= $log->pegawaiSso->nama ?></td>
                        <td><?= Html::encode($log->log_ip) ?></td>
                        <td><?= Html::encode($log->token) ?></td>
                        <td><?= Html::encode($log->created_at) ?></td>

                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>