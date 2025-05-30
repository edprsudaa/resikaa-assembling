<?php

use app\modules\rbac\AnimateAsset;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\web\YiiAsset;

/* @var $this yii\web\View */
/* @var $routes [] */

$this->title = Yii::t('rbac-admin', 'Routes');
$this->params['breadcrumbs'][] = $this->title;

AnimateAsset::register($this);
YiiAsset::register($this);
$opts = Json::htmlEncode([
    'routes' => $routes,
]);
$this->registerJs("var _opts = {$opts};");
$this->registerJs($this->render('_script.js'));
$animateIcon = ' <i class="fas fa-spinner glyphicon-refresh-animate"></i>';
?>
<div class="row">
    <div class="col-sm-11">
        <div class="input-group">
            <input id="inp-route" type="text" class="form-control form-control-sm" placeholder="<?= Yii::t('rbac-admin', 'Route Baru'); ?>">
            <span class="input-group-btn">
                <?= Html::a(Yii::t('rbac-admin', 'Tambah') . $animateIcon, ['create'], [
                    'class' => 'btn btn-success btn-sm',
                    'id' => 'btn-new',
                ]); ?>
            </span>
        </div>
    </div>
</div>
<p>&nbsp;</p>
<div class="row">
    <div class="col-sm-5">
        <div class="input-group">
            <input class="form-control form-control-sm search" data-target="available" placeholder="<?= Yii::t('rbac-admin', 'Cari...'); ?>">
            <span class="input-group-btn">
                <?= Html::a('<span class="fas fa-sync"></span>', ['refresh'], [
                    'class' => 'btn btn-default btn-sm',
                    'id' => 'btn-refresh',
                ]); ?>
            </span>
        </div>
        <select multiple size="20" class="form-control list" data-target="available"></select>
    </div>
    <div class="col-sm-1">
        <br><br>
        <?= Html::a('&gt;&gt;' . $animateIcon, ['assign'], [
            'class' => 'btn btn-success btn-assign',
            'data-target' => 'available',
            'title' => Yii::t('rbac-admin', 'Assign'),
        ]); ?><br><br>
        <?= Html::a('&lt;&lt;' . $animateIcon, ['remove'], [
            'class' => 'btn btn-danger btn-assign',
            'data-target' => 'assigned',
            'title' => Yii::t('rbac-admin', 'Remove'),
        ]); ?>
    </div>
    <div class="col-sm-5">
        <input class="form-control form-control-sm search" data-target="assigned" placeholder="<?= Yii::t('rbac-admin', 'Cari...'); ?>">
        <select multiple size="20" class="form-control list" data-target="assigned"></select>
    </div>
</div>