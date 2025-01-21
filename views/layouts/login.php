<?php

use yii\helpers\Url;
use yii\helpers\Html;
use app\assets\AppAsset;
use app\assets\LoginAsset;

\hail812\adminlte3\assets\PluginAsset::register($this)->add([
    'pace',
    'toastr',
    'popper'
]);
LoginAsset::register($this);
AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title><?= Html::encode($this->title) ?></title>
    <!-- <link rel="shortcut icon" href="<?php echo Url::base(); ?>/app/images/favicon.ico" /> -->
    <link rel="shortcut icon" type="image/x-icon" href="<?= Url::to('@web/images/logo_rsud.png') ?>">
    <?php $this->head() ?>
</head>

<body>
    <?php $this->beginBody() ?>
    <?php echo $content; ?>
    <?php $this->endBody() ?>
</body>

</html>
<?php $this->endPage() ?>