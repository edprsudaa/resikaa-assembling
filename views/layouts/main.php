<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\helpers\Url;

\hail812\adminlte3\assets\FontAwesomeAsset::register($this);
\hail812\adminlte3\assets\AdminLteAsset::register($this);
\hail812\adminlte3\assets\PluginAsset::register($this)->add(['sweetalert2', 'toastr', 'datatable', 'pace', 'icheck-bootstrap']);

use app\assets\AppAsset;

AppAsset::register($this);
$this->registerCssFile('@web/font/css_font_1.css');


$assetDir = Yii::$app->assetManager->getPublishedUrl('@vendor/almasaeed2010/adminlte/dist');
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">

<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode(isset($this->title) ? $this->title : '') ?></title>
    <?php $this->head() ?>
</head>

<style>
    .modal-loading {
        display: none;
        position: fixed;
        z-index: 1000;
        top: 0;
        left: 0;
        height: 100%;
        width: 100%;
        background: rgba(255, 255, 255, .8) url('<?= Url::to(['images/giphy.gif']) ?>') 50% 50% no-repeat;
    }

    .modal-loading-pasien {
        position: fixed;
        z-index: 1000;
        top: 0;
        left: 0;
        height: 100%;
        width: 100%;
        background: rgba(255, 255, 255, .8) url('<?= Url::to(['images/giphy.gif']) ?>') 50% 50% no-repeat;
    }

    body.loading .modal-loading {
        overflow: hidden;
        display: block;
    }

    .toast {
        opacity: 1 !important;
    }
</style>

<body class="layout-navbar-fixed layout-fixed hold-transition skin-blue sidebar-collapse sidebar-mini">
    <?php $this->beginBody() ?>
    <div class="wrapper">
        <!-- Navbar -->
        <?= $this->render('navbar', ['assetDir' => $assetDir]) ?>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <?= $this->render('sidebar', ['assetDir' => $assetDir]) ?>

        <!-- Content Wrapper. Contains page content -->
        <?= $this->render('content', ['content' => $content, 'assetDir' => $assetDir]) ?>
        <!-- /.content-wrapper -->

        <!-- Control Sidebar -->
        <?= $this->render('control-sidebar') ?>
        <!-- /.control-sidebar -->

        <!-- Main Footer -->
        <?= $this->render('footer') ?>

    </div>
    <div class="modal fade" id="mymodal" tabindex="false" role="dialog" aria-labelledby="myModalLabel"></div>
    <div class="modal fade mymodal_card_xl" tabindex="false" role="dialog">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title mymodal_card_xl_header"></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body mymodal_card_xl_body">

                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <script>
        var baseUrl = '<?php echo Url::base(); ?>';
    </script>
    <?php $this->endBody() ?>
    <div class="modal-loading"></div>
</body>


</html>
<?php $this->endPage() ?>