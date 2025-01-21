<?php

/** @var yii\web\View $this */
/** @var string $name */
/** @var string $message */
/** @var Exception$exception */

use yii\helpers\Html;

?>
<div class="site-error">

    <h1><?= Html::encode('Not Found (#404)') ?></h1>

    <div class="alert alert-danger">
        <?= nl2br(Html::encode('Error: Halaman Tidak Ditemukan')) ?>
    </div>

    <p>Mohon maaf, halaman yang Anda akses tidak sesuai dengan yang diharapkan. Kemungkinan halaman tersebut telah dihapus, dipindahkan, atau URL-nya telah berubah.</p>
    <p>Silakan periksa kembali URL atau coba cari konten yang Anda inginkan menggunakan kotak pencarian di situs kami. Jika Anda masih mengalami masalah, jangan ragu untuk menghubungi tim dukungan kami untuk bantuan lebih lanjut.</p>

</div>