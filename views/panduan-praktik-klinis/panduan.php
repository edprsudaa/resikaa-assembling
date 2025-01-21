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

$this->title = 'Panduan Praktik Klinis';
$this->params['breadcrumbs'][] = $this->title;
$this->registerJs($this->render('script.js'), View::POS_END);

?>
<div class="row">
    <div class="col-lg-12">
        <?php
        echo $this->render('panduan_detail', [
            'model' => $model,
        ]);
        ?>
    </div>
</div>
</div>