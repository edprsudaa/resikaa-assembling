<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\MedisMTindakan */

$this->title = 'Create Tindakan';
$this->params['breadcrumbs'][] = ['label' => 'Tindakan', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <?=$this->render('_form', [
                        'model' => $model,
                        'kualifikasiPendidikan' => $kualifikasiPendidikan,
                    ]) ?>
                </div>
            </div>
        </div>
        <!--.card-body-->
    </div>
    <!--.card-->
</div>
