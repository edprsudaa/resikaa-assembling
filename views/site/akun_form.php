<?php

use yii\bootstrap4\ActiveForm;
use yii\helpers\Url;

$this->registerJs("
    $('#" . $model->formName() . "').on('beforeSubmit',function(e){
        e.preventDefault();
        var form=$(this);
        var btn=form.find('.btn-submit');
        var htm=btn.html();
        setLoadingBtn(btn,'Menyimpan...');
        $.ajax({
            url:'" . url::to(['akun-update']) . "',
            type:'post',
            dataType:'json',
            data:form.serialize(),
            success:function(result){
                if(result.status){
                    successMsg(result.msg);
                }else{
                    errorMsg(result.msg);
                }
                resetLoadingBtn(btn,htm);
            },
            error:function(xhr,status,error){
                errorMsg(error);
                resetLoadingBtn(btn,htm);
            }
        });
    }).on('submit',function(e){
        e.preventDefault();
    });
");
?>
<div class="row">
    <div class="col-md-5">
        <div class="box box-solid">
            <div class="box-header with-border">
                <h3 class="box-title">Edit Akun</h3>
            </div>
            <div class="box-body">
                <?php $form = ActiveForm::begin(['id' => $model->formName()]); ?>
                <?= $form->field($model, 'pgw_username')->textInput(['autofocus' => true]) ?>
                <?= $form->field($model, 'pgw_password_hash')->passwordInput() ?>
                <button type="submit" class="btn btn-flat btn-success pull-right btn-submit"><i class="fa fa-save"></i> Simpan</button>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>