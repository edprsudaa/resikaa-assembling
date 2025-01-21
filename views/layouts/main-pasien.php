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
        <?= $this->render('sidebar-left-pasien', ['assetDir' => $assetDir]) ?>

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

<script>
    setPagination();
    submenuColor();

    function setPagination() {
        var gridview = document.getElementsByClassName('grid-view');
        if (typeof(gridview) != "undefined" && gridview !== null) {
            var pagination = document.getElementsByClassName('pagination')
            if (typeof(pagination) != "undefined" && pagination !== null) {
                var page = pagination[0].getElementsByTagName('a');
                let span = pagination[0].getElementsByTagName('span');
                if (span.length > 0) {
                    span[0].className = "page-link";
                }

                for (var a = 0; a < page.length; a++) {
                    page[a].className = "page-link";
                }
            }
            document.getElementsByClassName('pagination')[0].getElementsByClassName('active')[0].getElementsByTagName('a')[0].style.backgroundColor = "#dee2e6";
        }
    }

    function getAge(dob) {

        var now = new Date();
        var today = new Date(now.getYear(), now.getMonth(), now.getDate());

        var yearNow = now.getYear();
        var monthNow = now.getMonth();
        var dateNow = now.getDate();

        var yearDob = dob.getYear();
        var monthDob = dob.getMonth();
        var dateDob = dob.getDate();
        var age = {};
        var ageString = "";
        var yearString = "";
        var monthString = "";
        var dayString = "";


        yearAge = yearNow - yearDob;

        if (monthNow >= monthDob)
            var monthAge = monthNow - monthDob;
        else {
            yearAge--;
            var monthAge = 12 + monthNow - monthDob;
        }

        if (dateNow >= dateDob)
            var dateAge = dateNow - dateDob;
        else {
            monthAge--;
            var dateAge = 31 + dateNow - dateDob;

            if (monthAge < 0) {
                monthAge = 11;
                yearAge--;
            }
        }

        age = {
            years: yearAge,
            months: monthAge,
            days: dateAge
        };

        if (age.years > 1) yearString = " Tahun";
        else yearString = " Tahun";
        if (age.months > 1) monthString = " Bulan";
        else monthString = " Bulan";
        if (age.days > 1) dayString = " Hari";
        else dayString = " Hari";


        if ((age.years > 0) && (age.months > 0) && (age.days > 0))
            ageString = age.years + yearString + ", " + age.months + monthString + ", " + age.days + dayString;
        else if ((age.years == 0) && (age.months == 0) && (age.days > 0))
            ageString = age.days + dayString;
        else if ((age.years > 0) && (age.months == 0) && (age.days == 0))
            ageString = age.years + yearString;
        else if ((age.years > 0) && (age.months > 0) && (age.days == 0))
            ageString = age.years + yearString + ", " + age.months + monthString;
        else if ((age.years == 0) && (age.months > 0) && (age.days > 0))
            ageString = age.months + monthString + ", " + age.days + dayString;
        else if ((age.years > 0) && (age.months == 0) && (age.days > 0))
            ageString = age.years + yearString + ", " + age.days + dayString;
        else if ((age.years == 0) && (age.months > 0) && (age.days == 0))
            ageString = age.months + monthString;
        else ageString = "Umur tidak dapat dihitung";

        return ageString;
    }

    function openPopup(url, target, btn, modalID) {
        var iframe = document.createElement('iframe');

        iframe.style = "width:100%;border:0;height: 100%;overflow:auto;position:relative;z-index:10";
        iframe.src = url;

        iframe.onload = function() {
            $(modalID + " iframe").contents().find('[name=target]').val(target);
            $(modalID + " iframe").contents().find('[name=btn]').val(btn);
            $('.modal-loading-pasien').css('display', 'none');
        };

        $(modalID + "-content").css('height', '700px').css('html', '500px').html(iframe);
        $(modalID).modal('show');

        return false;
    }

    function submenuColor() {
        var menu = document.getElementsByClassName('nav-treeview')
        console.log(menu)
    }
</script>

</html>
<?php $this->endPage() ?>