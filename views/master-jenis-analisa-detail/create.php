<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\pengolahandata\MasterJenisAnalisaDetail */

$this->title = 'Create Master Jenis Analisa Detail';
$this->params['breadcrumbs'][] = ['label' => 'Master Jenis Analisa Details', 'url' => ['index']];
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
                        'jenisAnalisa' => $jenisAnalisa,
                        'itemAnalisa' => $itemAnalisa
                    ]) ?>


                </div>
            </div>
        </div>
        <!--.card-body-->
    </div>
    <!--.card-->
</div>