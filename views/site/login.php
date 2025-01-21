<?php

use yii\helpers\Url;
use yii\bootstrap4\ActiveForm;

$this->title = 'SIMRS Penunjang';
$this->registerJs("
    $('#" . $model->formName() . "').on('beforeSubmit',function(e){
        e.preventDefault();
        e.stopImmediatePropagation();
        var form=$(this);
        var btn=form.find('.btn-submit');
        var htm=btn.html();
        $.ajax({
            url:'" . Url::to(['login-do']) . "',
            type:'post',
            dataType:'json',
            data:form.serialize(),
            beforeSend:function(){
                fbtn.setLoading(btn);
            },
            success:function(result){
                if(result.status){
                    location.reload();
                }else{
                    fmsg.w(result.msg);
                }
                fbtn.resetLoading(btn,htm); 
            },
            complete:function(){
                fbtn.resetLoading(btn,htm);
            },
            error:function(xhr,status,error){
                fmsg.e(error);
                fbtn.resetLoading(btn,htm);
            }
        });
    }).on('submit',function(e){
        e.preventDefault();
    })
");
?>
<style>
    .form-holder {
        margin-left: 0px;
    }

    .form-content {
        background-image: url("<?= Yii::$app->request->baseUrl ?>/images/gedung.jpg") !important;
        background-repeat: no-repeat !important;
        background-size: cover !important;
    }
</style>

<div class="form-body" class="container-fluid" style="font-family: 'Roboto', sans-serif !important;">
    <div class="row">
        <div class="form-holder">
            <div class="form-content">
                <div class="bg-opacity-10" style="background-color: #fdfdfd !important; padding: 35px; opacity: .8; border-radius: 15px;">
                    <div class="form-items">
                        <img src="<?= Yii::$app->request->baseUrl ?>/images/logo_riau.png" height="100px" alt="">&nbsp;&nbsp;
                        <img src="<?= Yii::$app->request->baseUrl ?>/images/logo_rsud.png" height="100px" alt="">&nbsp;&nbsp;
                        <img src="<?= Yii::$app->request->baseUrl ?>/images/logo_kars.png" height="100px" alt="">
                        <hr>
                        <h3><?= Yii::$app->params['app']['fullName'] ?></h3>
                        <?php $form = ActiveForm::begin(['id' => $model->formName()]); ?>
                        <?= $form->field($model, 'username')->textInput(['autofocus' => true, 'style' => 'border: 1px solid #2196f3 !important;']) ?>
                        <?= $form->field($model, 'password')->passwordInput(['style' => 'border: 1px solid #2196f3 !important;']) ?>
                        <div class="form-button">
                            <button id="submit" type="submit" class="btn btn-success btn-lg btn-block btn-submit">Login</button>
                        </div>
                        <?php ActiveForm::end(); ?>
                        <div class="credits" style="text-align:center">
                            <small>&copy 2021-<?= date('Y') ?> with EDP - <?= Yii::$app->params['owner']['fullName'] ?></small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>