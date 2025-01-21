<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\pengolahandata\MasterItemAnalisa */

$this->title = 'Create Master Item Analisa';
$this->params['breadcrumbs'][] = ['label' => 'Master Item Analisas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>
            </div>
        </div>
        <!--.card-body-->
    </div>
    <!--.card-->
</div>
