<?php

use app\assets\plugins\InputmaskAsset;
use app\components\HelperGeneralClass;
use app\components\HelperSpesialClass;
use app\models\pendaftaran\KelompokUnitLayanan;
use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;
use kartik\select2\Select2;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\web\JsExpression;
use yii\web\View;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\models\DistribusiSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'ANALISA DATA ELECTRONIC MEDICAL RECORD';
$this->params['breadcrumbs'][] = $this->title;
$this->registerJs($this->render('script.js'), View::POS_END);
$this->registerCss("
table.dataTable tbody tr.selected, table.dataTable tbody th.selected, table.dataTable tbody td.selected{
    font-weight:bolder;
    background-color:#00A65A;
}

tr, th {
    padding: 5px 5px 5px 5px !important;
}
tr, td {
    padding: 5px 5px 5px 5px !important;
}


");
?>
<div class="row">
    <div class="col-lg-12">
        <!-- Card Pasien -->
        <?php echo $this->render('card-pasien', ['registrasi' => $registrasi]); ?>
        <!-- Card Pasien -->

        <div class="row">

            <?php echo $this->render('riwayat_pasien', ['registrasi' => $registrasi]); ?>
            <br>

            <div class="col-lg-12">
                <?php

                echo $this->render('view-coder', [
                    'listCoder' => $listCoder,
                    'listRingkasanPulangIgd' => $listRingkasanPulangIgd,
                    'registrasi' => $registrasi
                ]);
                ?>
            </div>


        </div>


    </div>
</div>
</div>