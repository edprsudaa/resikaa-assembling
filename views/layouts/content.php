<?php
/* @var $content string */

use yii\bootstrap4\Breadcrumbs;
use app\widgets\Alert;
?>

<div class="content-wrapper">

    <!-- Main content -->
    <div class="content p-2">
    <div class="container-fluid">
            <?php // Alert::widget() ?>
        </div>
        <?= $content ?>
    </div>
    <!-- /.content -->
</div>