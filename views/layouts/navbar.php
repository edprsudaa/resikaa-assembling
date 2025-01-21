<?php

use app\models\FilterHeader;
use yii\helpers\Html;
use yii\helpers\Url;

$filterHeader = new FilterHeader();
$tglNow = substr($filterHeader->getTanggal(), 0, 10);
?>
<!-- Navbar -->

<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
        <li class="nav-item  mt-1">
            <span class="text-lg text-success"><i class="fa fa-plus-square" aria-hidden="true"></i> <b><?= Yii::$app->params['app']['fullName'] ?> VERSI <?= Yii::$app->params['app']['version'] ?> |</b> <?= isset($this->context->title) ? $this->context->title : '' ?></span>
        </li>

    </ul>

    <!-- SEARCH FORM -->

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        <!-- Navbar Search -->


        <!-- Notifications Dropdown Menu -->
        <li class="nav-item dropdown user-menu">
            <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">
                <img src="<?= \yii\helpers\Url::base() . "/images/logo.png" ?>" class="user-image img-circle elevation-2" alt="User Image">
                <span class="d-none d-md-inline"><?= ((Yii::$app->user->identity) ? Yii::$app->user->identity->nama : '?') ?></span>
            </a>
            <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                <!-- User image -->
                <li class="user-header bg-info">

                    <p>
                        <?= ((Yii::$app->user->identity) ? Yii::$app->user->identity->nama : '?') ?>
                        <small><?= ((Yii::$app->user->identity) ? Yii::$app->user->identity->kodeAkun : '?') ?></small>
                    </p>
                </li>
                <li class="user-footer">
                    <a href="#" class="btn btn-default btn-flat">Profile</a>
                    <?= Html::a('Log out', ['/site/logout'], ['data-method' => 'post', 'class' => 'btn btn-default btn-flat float-right']) ?>
                </li>
            </ul>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                <i class="fas fa-expand-arrows-alt"></i>
            </a>
        </li>
        <!-- <li class="nav-item"> -->

        <?php //Html::a('<i class="fas fa-sign-out-alt"></i>', ['/site/logout'], ['data-method' => 'post', 'class' => 'nav-link']) 
        ?>
        <!-- </li> -->


    </ul>
</nav>
<!-- /.navbar -->