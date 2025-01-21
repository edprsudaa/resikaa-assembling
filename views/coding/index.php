<?php

use app\assets\plugins\InputmaskAsset;
use app\components\HelperGeneralClass;
use app\components\HelperSpesialClass;
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

$this->title = 'Analisa Kuantitatif';
$this->params['breadcrumbs'][] = $this->title;
$this->registerJs($this->render('script.js'), View::POS_END);
$this->registerJs("
$('.btn-lihat').on('click', function() {
    var id=$(this).data('id');
    $.get(baseUrl+'/analisa-kuantitatif/preview-doc-clinical?id='+id, function(d){
        if(d.status){
            $('.mymodal_card_xl_body').html(d.data.data);
            $('.mymodal_card_xl').modal('show');
        }else{
            fmsg.w(d.msg);
        }
    });
});
$('.btn-lihat-labor').on('click', function() {
    var id=$(this).data('id');
    
    $.get(baseUrl+'/analisa-kuantitatif/preview-list-labor?id='+id, function(d){

        if(d.status){
            console.log(d.data);
            $('.mymodal_card_xl_body').html(d.data.pdf);
            $('.mymodal_card_xl').modal('show');
        }else{
            fmsg.w(d.msg);
        }
    });
});
$('#coding-icd').on('beforeSubmit',function(e){
    e.preventDefault();
    var btn=$('.btn-submit');
    var htm=btn.html();
    // App.SetLoadingBtn(btn,'Menyimpan...');
    $.ajax({
        url:'" . Url::to(['save']) . "',
        type:'post',
        dataType:'json',
        data:$(this).serialize(),
        success:function(result){
            if(result.status){
            toastr.success(result.msg);
            }
            if(result.status){
                setTimeout(function () {
                  window.location =
                    base_url +
                    analisa_kuantitatif_controller+'list-checkout'
                }, 2000);
            }
            else{
                if(typeof result.msg=='object'){
                    $.each(result.msg,function(i,v){
                        toastr.error(v);
                    });
                }else{
                    toastr.error(result.msg);
                }
            }
            // App.ResetLoadingBtn(btn,htm);
        },
        error:function(xhr,status,error){
            // App.Error(error);
            // App.ResetLoadingBtn(btn,htm);
        }
    });
}).submit(function(e){
    e.preventDefault();
});

");
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

        <?php $form = ActiveForm::begin(['id' => 'coding-icd', 'action' => 'javascript::void(0)', 'options' => ['class' => 'form', 'role' => 'form']]); ?>
        <?php if (!empty($model->analisa_dokumen_id)) {
        ?>
            <input type="hidden" name="analisa_dokumen_id" value="<?php echo $model->analisa_dokumen_id; ?>">
        <?php } ?>
        <input type="hidden" name="ps_kode" value="<?= $registrasi['pasien']['kode'] ?>">
        <input type="hidden" name="reg_kode" value="<?= $registrasi['kode'] ?>">
        <div class="row">
            <div class="col-lg-9">
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <h5 class="card-title m-0">Analisa Dokumen Rekam Medik</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <?= $form->field($model, 'diagnosa_utama_id')->widget(Select2::classname(), [
                                            'options' => ['placeholder' => 'Gunakan Untuk Pencarian ICD-10 ...'],
                                            'pluginOptions' => [
                                                'allowClear' => true,
                                                'minimumInputLength' => 2,
                                                'language' => [
                                                    'errorLoading' => new JsExpression('function () { 
                                return "Menunggu hasil..."; 
                            }'),
                                                    'inputTooShort' => new JsExpression('function () {
                                return "Minimal 2 karakter...";
                            }'),
                                                    'searching' => new JsExpression('function() {
                                return "Mencari...";
                            }'),
                                                ],
                                                'ajax' => [
                                                    'url' => Url::to(['icd-10']),
                                                    'type' => 'post',
                                                    'dataType' => 'json',
                                                    'data' => new JsExpression('function(params) {
                                return {term:params.term};
                            }')
                                                ],
                                                'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
                                                'templateResult' => new JsExpression('function(data) { 
                            return data.text  
                        }'),
                                                'templateSelection' => new JsExpression('function (data) { return data.text; }'),
                                            ],
                                            'pluginEvents' => [
                                                "select2:select" => new JsExpression('function(e) { 
                            // console.log(e.params.data);
                            let icdpilih = e.params.data
                            // $("#id").val(getvalue).trigger("change")
                            $("#codingicd-diagnosa_utama_kode").val(icdpilih.kode)
                            $("#codingicd-diagnosa_utama_deskripsi").val(icdpilih.deskripsi)
                            $("#codingicd-diagnosa_utama_kode").focus()
                        }'),

                                            ]
                                        ])->label('Pencarian Diagnosa Utama');
                                        ?>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-3">
                                        <?= $form->field($model, 'diagnosa_utama_kode')->textInput(['placeholder' => "Kode ICD-10"])->label(false) ?>
                                    </div>
                                    <div class="col-lg-9">
                                        <?= $form->field($model, 'diagnosa_utama_deskripsi')->textInput(['placeholder' => "Deskripsi ICD-10"])->label(false) ?>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <?= $form->field($model, 'diagnosa_tambahan1_id')->widget(Select2::classname(), [
                                            'options' => ['placeholder' => 'Gunakan Untuk Pencarian ICD-10 ...'],
                                            'pluginOptions' => [
                                                'allowClear' => true,
                                                'minimumInputLength' => 2,
                                                'language' => [
                                                    'errorLoading' => new JsExpression('function () { 
                                return "Menunggu hasil..."; 
                            }'),
                                                    'inputTooShort' => new JsExpression('function () {
                                return "Minimal 2 karakter...";
                            }'),
                                                    'searching' => new JsExpression('function() {
                                return "Mencari...";
                            }'),
                                                ],
                                                'ajax' => [
                                                    'url' => Url::to(['icd-10']),
                                                    'type' => 'post',
                                                    'dataType' => 'json',
                                                    'data' => new JsExpression('function(params) {
                                return {term:params.term};
                            }')
                                                ],
                                                'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
                                                'templateResult' => new JsExpression('function(data) { 
                            return data.text  
                        }'),
                                                'templateSelection' => new JsExpression('function (data) { return data.text; }'),
                                            ],
                                            'pluginEvents' => [
                                                "select2:select" => new JsExpression('function(e) { 
                            // console.log(e.params.data);
                            let icdpilih = e.params.data
                            // $("#id").val(getvalue).trigger("change")
                            $("#codingicd-diagnosa_tambahan1_kode").val(icdpilih.kode)
                            $("#codingicd-diagnosa_tambahan1_deskripsi").val(icdpilih.deskripsi)
                            $("#codingicd-diagnosa_tambahan1_kode").focus()
                        }'),

                                            ]
                                        ])->label('Pencarian Diagnosa Tambahan 1');
                                        ?>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-3">
                                        <?= $form->field($model, 'diagnosa_tambahan1_kode')->textInput(['placeholder' => "Kode ICD-10"])->label(false) ?>
                                    </div>
                                    <div class="col-lg-9">
                                        <?= $form->field($model, 'diagnosa_tambahan1_deskripsi')->textInput(['placeholder' => "Deskripsi ICD-10"])->label(false) ?>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <?= $form->field($model, 'diagnosa_tambahan2_id')->widget(Select2::classname(), [
                                            'options' => ['placeholder' => 'Gunakan Untuk Pencarian ICD-10 ...'],
                                            'pluginOptions' => [
                                                'allowClear' => true,
                                                'minimumInputLength' => 2,
                                                'language' => [
                                                    'errorLoading' => new JsExpression('function () { 
                                return "Menunggu hasil..."; 
                            }'),
                                                    'inputTooShort' => new JsExpression('function () {
                                return "Minimal 2 karakter...";
                            }'),
                                                    'searching' => new JsExpression('function() {
                                return "Mencari...";
                            }'),
                                                ],
                                                'ajax' => [
                                                    'url' => Url::to(['icd-10']),
                                                    'type' => 'post',
                                                    'dataType' => 'json',
                                                    'data' => new JsExpression('function(params) {
                                return {term:params.term};
                            }')
                                                ],
                                                'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
                                                'templateResult' => new JsExpression('function(data) { 
                            return data.text  
                        }'),
                                                'templateSelection' => new JsExpression('function (data) { return data.text; }'),
                                            ],
                                            'pluginEvents' => [
                                                "select2:select" => new JsExpression('function(e) { 
                            // console.log(e.params.data);
                            let icdpilih = e.params.data
                            // $("#id").val(getvalue).trigger("change")
                            $("#codingicd-diagnosa_tambahan2_kode").val(icdpilih.kode)
                            $("#codingicd-diagnosa_tambahan2_deskripsi").val(icdpilih.deskripsi)
                            $("#codingicd-diagnosa_tambahan2_kode").focus()
                        }'),

                                            ]
                                        ])->label('Pencarian DDiagnosa Tambahan 2');
                                        ?>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-3">
                                        <?= $form->field($model, 'diagnosa_tambahan2_kode')->textInput(['placeholder' => "Kode ICD-10"])->label(false) ?>
                                    </div>
                                    <div class="col-lg-9">
                                        <?= $form->field($model, 'diagnosa_tambahan2_deskripsi')->textInput(['placeholder' => "Deskripsi ICD-10"])->label(false) ?>
                                    </div>
                                </div>

                               
                                <div class="row">
                                    <div class="col-lg-12">
                                        <?= $form->field($model, 'diagnosa_tambahan3_id')->widget(Select2::classname(), [
                                            'options' => ['placeholder' => 'Gunakan Untuk Pencarian ICD-10 ...'],
                                            'pluginOptions' => [
                                                'allowClear' => true,
                                                'minimumInputLength' => 2,
                                                'language' => [
                                                    'errorLoading' => new JsExpression('function () { 
                                return "Menunggu hasil..."; 
                            }'),
                                                    'inputTooShort' => new JsExpression('function () {
                                return "Minimal 2 karakter...";
                            }'),
                                                    'searching' => new JsExpression('function() {
                                return "Mencari...";
                            }'),
                                                ],
                                                'ajax' => [
                                                    'url' => Url::to(['icd-10']),
                                                    'type' => 'post',
                                                    'dataType' => 'json',
                                                    'data' => new JsExpression('function(params) {
                                return {term:params.term};
                            }')
                                                ],
                                                'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
                                                'templateResult' => new JsExpression('function(data) { 
                            return data.text  
                        }'),
                                                'templateSelection' => new JsExpression('function (data) { return data.text; }'),
                                            ],
                                            'pluginEvents' => [
                                                "select2:select" => new JsExpression('function(e) { 
                            // console.log(e.params.data);
                            let icdpilih = e.params.data
                            // $("#id").val(getvalue).trigger("change")
                            $("#codingicd-diagnosa_tambahan3_kode").val(icdpilih.kode)
                            $("#codingicd-diagnosa_tambahan3_deskripsi").val(icdpilih.deskripsi)
                            $("#codingicd-diagnosa_tambahan3_kode").focus()
                        }'),

                                            ]
                                        ])->label('Pencarian Diagnosa Tambahan 3');
                                        ?>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-3">
                                        <?= $form->field($model, 'diagnosa_tambahan3_kode')->textInput(['placeholder' => "Kode ICD-10"])->label(false) ?>
                                    </div>
                                    <div class="col-lg-9">
                                        <?= $form->field($model, 'diagnosa_tambahan3_deskripsi')->textInput(['placeholder' => "Deskripsi ICD-10"])->label(false) ?>
                                    </div>
                                </div>


                                <div class="row">
                                    <div class="col-lg-12">
                                        <?= $form->field($model, 'diagnosa_tambahan4_id')->widget(Select2::classname(), [
                                            'options' => ['placeholder' => 'Gunakan Untuk Pencarian ICD-10 ...'],
                                            'pluginOptions' => [
                                                'allowClear' => true,
                                                'minimumInputLength' => 2,
                                                'language' => [
                                                    'errorLoading' => new JsExpression('function () { 
                                return "Menunggu hasil..."; 
                            }'),
                                                    'inputTooShort' => new JsExpression('function () {
                                return "Minimal 2 karakter...";
                            }'),
                                                    'searching' => new JsExpression('function() {
                                return "Mencari...";
                            }'),
                                                ],
                                                'ajax' => [
                                                    'url' => Url::to(['icd-10']),
                                                    'type' => 'post',
                                                    'dataType' => 'json',
                                                    'data' => new JsExpression('function(params) {
                                return {term:params.term};
                            }')
                                                ],
                                                'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
                                                'templateResult' => new JsExpression('function(data) { 
                            return data.text  
                        }'),
                                                'templateSelection' => new JsExpression('function (data) { return data.text; }'),
                                            ],
                                            'pluginEvents' => [
                                                "select2:select" => new JsExpression('function(e) { 
                            // console.log(e.params.data);
                            let icdpilih = e.params.data
                            // $("#id").val(getvalue).trigger("change")
                            $("#codingicd-diagnosa_tambahan4_kode").val(icdpilih.kode)
                            $("#codingicd-diagnosa_tambahan4_deskripsi").val(icdpilih.deskripsi)
                            $("#codingicd-diagnosa_tambahan4_kode").focus()
                        }'),

                                            ]
                                        ])->label('Pencarian Diagnosa Tambahan 4');
                                        ?>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-3">
                                        <?= $form->field($model, 'diagnosa_tambahan4_kode')->textInput(['placeholder' => "Kode ICD-10"])->label(false) ?>
                                    </div>
                                    <div class="col-lg-9">
                                        <?= $form->field($model, 'diagnosa_tambahan4_deskripsi')->textInput(['placeholder' => "Deskripsi ICD-10"])->label(false) ?>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <?= $form->field($model, 'diagnosa_tambahan5_id')->widget(Select2::classname(), [
                                            'options' => ['placeholder' => 'Gunakan Untuk Pencarian ICD-10 ...'],
                                            'pluginOptions' => [
                                                'allowClear' => true,
                                                'minimumInputLength' => 2,
                                                'language' => [
                                                    'errorLoading' => new JsExpression('function () { 
                                return "Menunggu hasil..."; 
                            }'),
                                                    'inputTooShort' => new JsExpression('function () {
                                return "Minimal 2 karakter...";
                            }'),
                                                    'searching' => new JsExpression('function() {
                                return "Mencari...";
                            }'),
                                                ],
                                                'ajax' => [
                                                    'url' => Url::to(['icd-10']),
                                                    'type' => 'post',
                                                    'dataType' => 'json',
                                                    'data' => new JsExpression('function(params) {
                                return {term:params.term};
                            }')
                                                ],
                                                'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
                                                'templateResult' => new JsExpression('function(data) { 
                            return data.text  
                        }'),
                                                'templateSelection' => new JsExpression('function (data) { return data.text; }'),
                                            ],
                                            'pluginEvents' => [
                                                "select2:select" => new JsExpression('function(e) { 
                            // console.log(e.params.data);
                            let icdpilih = e.params.data
                            // $("#id").val(getvalue).trigger("change")
                            $("#codingicd-diagnosa_tambahan5_kode").val(icdpilih.kode)
                            $("#codingicd-diagnosa_tambahan5_deskripsi").val(icdpilih.deskripsi)
                            $("#codingicd-diagnosa_tambahan5_kode").focus()
                        }'),

                                            ]
                                        ])->label('Pencarian Diagnosa Tambahan 5');
                                        ?>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-3">
                                        <?= $form->field($model, 'diagnosa_tambahan5_kode')->textInput(['placeholder' => "Kode ICD-10"])->label(false) ?>
                                    </div>
                                    <div class="col-lg-9">
                                        <?= $form->field($model, 'diagnosa_tambahan5_deskripsi')->textInput(['placeholder' => "Deskripsi ICD-10"])->label(false) ?>
                                    </div>
                                </div>





                            </div>
                            <div class="col-lg-6">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <?= $form->field($model, 'tindakan_utama_id')->widget(Select2::classname(), [
                                            'options' => ['placeholder' => 'Gunakan Untuk Pencarian ICD-9 ...'],
                                            'pluginOptions' => [
                                                'allowClear' => true,
                                                'minimumInputLength' => 2,
                                                'language' => [
                                                    'errorLoading' => new JsExpression('function () { 
                                return "Menunggu hasil..."; 
                            }'),
                                                    'inputTooShort' => new JsExpression('function () {
                                return "Minimal 2 karakter...";
                            }'),
                                                    'searching' => new JsExpression('function() {
                                return "Mencari...";
                            }'),
                                                ],
                                                'ajax' => [
                                                    'url' => Url::to(['icd-9']),
                                                    'type' => 'post',
                                                    'dataType' => 'json',
                                                    'data' => new JsExpression('function(params) {
                                return {term:params.term};
                            }')
                                                ],
                                                'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
                                                'templateResult' => new JsExpression('function(data) { 
                            return data.text  
                        }'),
                                                'templateSelection' => new JsExpression('function (data) { return data.text; }'),
                                            ],
                                            'pluginEvents' => [
                                                "select2:select" => new JsExpression('function(e) { 
                            // console.log(e.params.data);
                            let icdpilih = e.params.data
                            // $("#id").val(getvalue).trigger("change")
                            $("#codingicd-tindakan_utama_kode").val(icdpilih.kode)
                            $("#codingicd-tindakan_utama_deskripsi").val(icdpilih.deskripsi)
                            $("#codingicd-tindakan_utama_kode").focus()
                        }'),
                                                // "select2:unselect" => new JsExpression('function() { 
                                                // }'),
                                                // "change" => new JsExpression('function(data) { 
                                                // }'),                                                
                                                // "select2:opening" => "function() { log('select2:opening'); }",
                                                // "select2:open" => "function() { log('open'); }",
                                                // "select2:closing" => "function() { log('close'); }",
                                                // "select2:close" => "function() { log('close'); }",
                                                // "select2:selecting" => "function() { log('selecting'); }",
                                                // "select2:unselecting" => "function() { log('unselecting'); }",
                                            ]
                                        ])->label('Pencarian Tindakan Utama');
                                        ?>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-3">
                                        <?= $form->field($model, 'tindakan_utama_kode')->textInput(['placeholder' => "Kode ICD-9"])->label(false) ?>
                                    </div>
                                    <div class="col-lg-9">
                                        <?= $form->field($model, 'tindakan_utama_deskripsi')->textInput(['placeholder' => "Deskripsi ICD-9"])->label(false) ?>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-12">
                                        <?= $form->field($model, 'tindakan_tambahan1_id')->widget(Select2::classname(), [
                                            'options' => ['placeholder' => 'Gunakan Untuk Pencarian ICD-9 ...'],
                                            'pluginOptions' => [
                                                'allowClear' => true,
                                                'minimumInputLength' => 2,
                                                'language' => [
                                                    'errorLoading' => new JsExpression('function () { 
                                return "Menunggu hasil..."; 
                            }'),
                                                    'inputTooShort' => new JsExpression('function () {
                                return "Minimal 2 karakter...";
                            }'),
                                                    'searching' => new JsExpression('function() {
                                return "Mencari...";
                            }'),
                                                ],
                                                'ajax' => [
                                                    'url' => Url::to(['icd-9']),
                                                    'type' => 'post',
                                                    'dataType' => 'json',
                                                    'data' => new JsExpression('function(params) {
                                return {term:params.term};
                            }')
                                                ],
                                                'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
                                                'templateResult' => new JsExpression('function(data) { 
                            return data.text  
                        }'),
                                                'templateSelection' => new JsExpression('function (data) { return data.text; }'),
                                            ],
                                            'pluginEvents' => [
                                                "select2:select" => new JsExpression('function(e) { 
                            // console.log(e.params.data);
                            let icdpilih = e.params.data
                            // $("#id").val(getvalue).trigger("change")
                            $("#codingicd-tindakan_tambahan1_kode").val(icdpilih.kode)
                            $("#codingicd-tindakan_tambahan1_deskripsi").val(icdpilih.deskripsi)
                            $("#codingicd-tindakan_tambahan1_kode").focus()
                        }'),
                                                // "select2:unselect" => new JsExpression('function() { 
                                                // }'),
                                                // "change" => new JsExpression('function(data) { 
                                                // }'),                                                
                                                // "select2:opening" => "function() { log('select2:opening'); }",
                                                // "select2:open" => "function() { log('open'); }",
                                                // "select2:closing" => "function() { log('close'); }",
                                                // "select2:close" => "function() { log('close'); }",
                                                // "select2:selecting" => "function() { log('selecting'); }",
                                                // "select2:unselecting" => "function() { log('unselecting'); }",
                                            ]
                                        ])->label('Pencarian Tindakan Tambahan 1');
                                        ?>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-3">
                                        <?= $form->field($model, 'tindakan_tambahan1_kode')->textInput(['placeholder' => "Kode ICD-9"])->label(false) ?>
                                    </div>
                                    <div class="col-lg-9">
                                        <?= $form->field($model, 'tindakan_tambahan1_deskripsi')->textInput(['placeholder' => "Deskripsi ICD-9"])->label(false) ?>
                                    </div>
                                </div>
                          
                                <div class="row">
                                    <div class="col-lg-12">
                                        <?= $form->field($model, 'tindakan_tambahan2_id')->widget(Select2::classname(), [
                                            'options' => ['placeholder' => 'Gunakan Untuk Pencarian ICD-9 ...'],
                                            'pluginOptions' => [
                                                'allowClear' => true,
                                                'minimumInputLength' => 2,
                                                'language' => [
                                                    'errorLoading' => new JsExpression('function () { 
                                return "Menunggu hasil..."; 
                            }'),
                                                    'inputTooShort' => new JsExpression('function () {
                                return "Minimal 2 karakter...";
                            }'),
                                                    'searching' => new JsExpression('function() {
                                return "Mencari...";
                            }'),
                                                ],
                                                'ajax' => [
                                                    'url' => Url::to(['icd-9']),
                                                    'type' => 'post',
                                                    'dataType' => 'json',
                                                    'data' => new JsExpression('function(params) {
                                return {term:params.term};
                            }')
                                                ],
                                                'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
                                                'templateResult' => new JsExpression('function(data) { 
                            return data.text  
                        }'),
                                                'templateSelection' => new JsExpression('function (data) { return data.text; }'),
                                            ],
                                            'pluginEvents' => [
                                                "select2:select" => new JsExpression('function(e) { 
                            // console.log(e.params.data);
                            let icdpilih = e.params.data
                            // $("#id").val(getvalue).trigger("change")
                            $("#codingicd-tindakan_tambahan2_kode").val(icdpilih.kode)
                            $("#codingicd-tindakan_tambahan2_deskripsi").val(icdpilih.deskripsi)
                            $("#codingicd-tindakan_tambahan2_kode").focus()
                        }'),
                                                // "select2:unselect" => new JsExpression('function() { 
                                                // }'),
                                                // "change" => new JsExpression('function(data) { 
                                                // }'),                                                
                                                // "select2:opening" => "function() { log('select2:opening'); }",
                                                // "select2:open" => "function() { log('open'); }",
                                                // "select2:closing" => "function() { log('close'); }",
                                                // "select2:close" => "function() { log('close'); }",
                                                // "select2:selecting" => "function() { log('selecting'); }",
                                                // "select2:unselecting" => "function() { log('unselecting'); }",
                                            ]
                                        ])->label('Pencarian Tindakan Tambahan 2');
                                        ?>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-3">
                                        <?= $form->field($model, 'tindakan_tambahan2_kode')->textInput(['placeholder' => "Kode ICD-9"])->label(false) ?>
                                    </div>
                                    <div class="col-lg-9">
                                        <?= $form->field($model, 'tindakan_tambahan2_deskripsi')->textInput(['placeholder' => "Deskripsi ICD-9"])->label(false) ?>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <?= $form->field($model, 'tindakan_tambahan3_id')->widget(Select2::classname(), [
                                            'options' => ['placeholder' => 'Gunakan Untuk Pencarian ICD-9 ...'],
                                            'pluginOptions' => [
                                                'allowClear' => true,
                                                'minimumInputLength' => 2,
                                                'language' => [
                                                    'errorLoading' => new JsExpression('function () { 
                                return "Menunggu hasil..."; 
                            }'),
                                                    'inputTooShort' => new JsExpression('function () {
                                return "Minimal 2 karakter...";
                            }'),
                                                    'searching' => new JsExpression('function() {
                                return "Mencari...";
                            }'),
                                                ],
                                                'ajax' => [
                                                    'url' => Url::to(['icd-9']),
                                                    'type' => 'post',
                                                    'dataType' => 'json',
                                                    'data' => new JsExpression('function(params) {
                                return {term:params.term};
                            }')
                                                ],
                                                'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
                                                'templateResult' => new JsExpression('function(data) { 
                            return data.text  
                        }'),
                                                'templateSelection' => new JsExpression('function (data) { return data.text; }'),
                                            ],
                                            'pluginEvents' => [
                                                "select2:select" => new JsExpression('function(e) { 
                            // console.log(e.params.data);
                            let icdpilih = e.params.data
                            // $("#id").val(getvalue).trigger("change")
                            $("#codingicd-tindakan_tambahan3_kode").val(icdpilih.kode)
                            $("#codingicd-tindakan_tambahan3_deskripsi").val(icdpilih.deskripsi)
                            $("#codingicd-tindakan_tambahan3_kode").focus()
                        }'),
                                                // "select2:unselect" => new JsExpression('function() { 
                                                // }'),
                                                // "change" => new JsExpression('function(data) { 
                                                // }'),                                                
                                                // "select2:opening" => "function() { log('select2:opening'); }",
                                                // "select2:open" => "function() { log('open'); }",
                                                // "select2:closing" => "function() { log('close'); }",
                                                // "select2:close" => "function() { log('close'); }",
                                                // "select2:selecting" => "function() { log('selecting'); }",
                                                // "select2:unselecting" => "function() { log('unselecting'); }",
                                            ]
                                        ])->label('Pencarian Tindakan Tambahan 3');
                                        ?>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-3">
                                        <?= $form->field($model, 'tindakan_tambahan3_kode')->textInput(['placeholder' => "Kode ICD-9"])->label(false) ?>
                                    </div>
                                    <div class="col-lg-9">
                                        <?= $form->field($model, 'tindakan_tambahan3_deskripsi')->textInput(['placeholder' => "Deskripsi ICD-9"])->label(false) ?>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-12">
                                        <?= $form->field($model, 'tindakan_tambahan4_id')->widget(Select2::classname(), [
                                            'options' => ['placeholder' => 'Gunakan Untuk Pencarian ICD-9 ...'],
                                            'pluginOptions' => [
                                                'allowClear' => true,
                                                'minimumInputLength' => 2,
                                                'language' => [
                                                    'errorLoading' => new JsExpression('function () { 
                                return "Menunggu hasil..."; 
                            }'),
                                                    'inputTooShort' => new JsExpression('function () {
                                return "Minimal 2 karakter...";
                            }'),
                                                    'searching' => new JsExpression('function() {
                                return "Mencari...";
                            }'),
                                                ],
                                                'ajax' => [
                                                    'url' => Url::to(['icd-9']),
                                                    'type' => 'post',
                                                    'dataType' => 'json',
                                                    'data' => new JsExpression('function(params) {
                                return {term:params.term};
                            }')
                                                ],
                                                'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
                                                'templateResult' => new JsExpression('function(data) { 
                            return data.text  
                        }'),
                                                'templateSelection' => new JsExpression('function (data) { return data.text; }'),
                                            ],
                                            'pluginEvents' => [
                                                "select2:select" => new JsExpression('function(e) { 
                            // console.log(e.params.data);
                            let icdpilih = e.params.data
                            // $("#id").val(getvalue).trigger("change")
                            $("#codingicd-tindakan_tambahan4_kode").val(icdpilih.kode)
                            $("#codingicd-tindakan_tambahan4_deskripsi").val(icdpilih.deskripsi)
                            $("#codingicd-tindakan_tambahan4_kode").focus()
                        }'),
                                                // "select2:unselect" => new JsExpression('function() { 
                                                // }'),
                                                // "change" => new JsExpression('function(data) { 
                                                // }'),                                                
                                                // "select2:opening" => "function() { log('select2:opening'); }",
                                                // "select2:open" => "function() { log('open'); }",
                                                // "select2:closing" => "function() { log('close'); }",
                                                // "select2:close" => "function() { log('close'); }",
                                                // "select2:selecting" => "function() { log('selecting'); }",
                                                // "select2:unselecting" => "function() { log('unselecting'); }",
                                            ]
                                        ])->label('Pencarian Tindakan Tambahan 4');
                                        ?>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-3">
                                        <?= $form->field($model, 'tindakan_tambahan4_kode')->textInput(['placeholder' => "Kode ICD-9"])->label(false) ?>
                                    </div>
                                    <div class="col-lg-9">
                                        <?= $form->field($model, 'tindakan_tambahan4_deskripsi')->textInput(['placeholder' => "Deskripsi ICD-9"])->label(false) ?>
                                    </div>
                                </div>

                                       
                                <div class="row">
                                    <div class="col-lg-12">
                                        <?= $form->field($model, 'tindakan_tambahan5_id')->widget(Select2::classname(), [
                                            'options' => ['placeholder' => 'Gunakan Untuk Pencarian ICD-9 ...'],
                                            'pluginOptions' => [
                                                'allowClear' => true,
                                                'minimumInputLength' => 2,
                                                'language' => [
                                                    'errorLoading' => new JsExpression('function () { 
                                return "Menunggu hasil..."; 
                            }'),
                                                    'inputTooShort' => new JsExpression('function () {
                                return "Minimal 2 karakter...";
                            }'),
                                                    'searching' => new JsExpression('function() {
                                return "Mencari...";
                            }'),
                                                ],
                                                'ajax' => [
                                                    'url' => Url::to(['icd-9']),
                                                    'type' => 'post',
                                                    'dataType' => 'json',
                                                    'data' => new JsExpression('function(params) {
                                return {term:params.term};
                            }')
                                                ],
                                                'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
                                                'templateResult' => new JsExpression('function(data) { 
                            return data.text  
                        }'),
                                                'templateSelection' => new JsExpression('function (data) { return data.text; }'),
                                            ],
                                            'pluginEvents' => [
                                                "select2:select" => new JsExpression('function(e) { 
                            // console.log(e.params.data);
                            let icdpilih = e.params.data
                            // $("#id").val(getvalue).trigger("change")
                            $("#codingicd-tindakan_tambahan5_kode").val(icdpilih.kode)
                            $("#codingicd-tindakan_tambahan5_deskripsi").val(icdpilih.deskripsi)
                            $("#codingicd-tindakan_tambahan5_kode").focus()
                        }'),
                                                // "select2:unselect" => new JsExpression('function() { 
                                                // }'),
                                                // "change" => new JsExpression('function(data) { 
                                                // }'),                                                
                                                // "select2:opening" => "function() { log('select2:opening'); }",
                                                // "select2:open" => "function() { log('open'); }",
                                                // "select2:closing" => "function() { log('close'); }",
                                                // "select2:close" => "function() { log('close'); }",
                                                // "select2:selecting" => "function() { log('selecting'); }",
                                                // "select2:unselecting" => "function() { log('unselecting'); }",
                                            ]
                                        ])->label('Pencarian Tindakan Tambahan 5');
                                        ?>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-3">
                                        <?= $form->field($model, 'tindakan_tambahan5_kode')->textInput(['placeholder' => "Kode ICD-9"])->label(false) ?>
                                    </div>
                                    <div class="col-lg-9">
                                        <?= $form->field($model, 'tindakan_tambahan5_deskripsi')->textInput(['placeholder' => "Deskripsi ICD-9"])->label(false) ?>
                                    </div>
                                </div>


                                    </div>
                                </div>

                                <div class="form-group row">

                                    <div class="col-sm-6">
                                        <button class="btn btn-secondary btn-block">Kembali</button>
                                    </div>
                                    <div class="col-sm-6">
                                        <?= Html::submitButton('Simpan Analisa Dokumen', ['class' => 'btn btn-success btn-block btn-peminjaman-distribusi-submit']) ?>
                                    </div>

                                </div>

                            </div>



                            <?php ActiveForm::end(); ?>
                        </div>
                    </div>
                    <div class="col-lg-3">

                        <div class="card card-primary card-outline">
                            <div class="card-header">
                                <h5 class="card-title m-0">Daftar Formulir Telah Diisi</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <table class="table table-striped table-bordered" style="text-align: justify;">

                                        <?php
                                        if ($docClinicalList->data !== null) {
                                            foreach ($docClinicalList->data as $item) {
                                        ?>
                                                <tr>
                                                    <td style="text-align: left;"><button type="button" class="btn btn-success btn-sm btn-lihat" data-id="<?= $item['id_doc_clinical_pasien']
                                                                                                                                                            ?>" data-nama="<?= $item['id_doc_clinical_pasien']
                                                                                                                                                                    ?>"> <?= ($item['itemDocClinical']['nama'])
                                                                                                                                                                            ?> <i class="fas fa-eye fa-sm"></i></button></td>
                                                </tr>
                                            <?php
                                            }
                                        } else {
                                            ?>
                                            <tr>
                                                <td style="text-align: left;">Tidak ada dokumen</td>
                                            </tr>
                                        <?php

                                        }
                                        ?>

                                    </table>
                                </div>
                            </div>


                        </div>
                        <div class="card card-primary card-outline">
                            <div class="card-header">
                                <h5 class="card-title m-0">Daftar Pemeriksaan Laboratorium</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <table class="table table-striped table-bordered" style="text-align: justify;">

                                        <?php

                                        if ($listLabor->data !== null) {
                                            foreach ($listLabor->data as $item) {
                                        ?>
                                                <?php $dataUnit = explode('^', $item['SOURCE']);
                                                $array = array_map(function ($input) {
                                                    return explode(',', $input);
                                                }, explode('^', $item['CLINICIAN']));
                                                ?>
                                                <tr>
                                                    <td style="text-align: left;"><button type="button" class="btn btn-success btn-sm btn-lihat-labor" data-id="<?= $item['ID']
                                                                                                                                                                ?>" data-nama="<?= $item['ID']
                                                                                                                                                                        ?>"> <?= $dataUnit['1'] ?> - <?php
                                                                                                                                                                                                        if (!empty($array[1][1]) && !empty($array[1][0]) && !empty($array[1][2])) {
                                                                                                                                                                                                            echo ($array[1][1]) . '. ' . ($array[1][0]) . ',' . ($array[1][2]);
                                                                                                                                                                                                        } else {
                                                                                                                                                                                                            echo "-";
                                                                                                                                                                                                        }

                                                                                                                                                                                                        ?> <i class="fas fa-eye fa-sm"></i></button></td>
                                                </tr>
                                            <?php
                                            }
                                        } else { ?>
                                            <tr>
                                                <td style="text-align: left;">Tidak ada dokumen</td>
                                            </tr>
                                        <?php

                                        }
                                        ?>

                                    </table>
                                </div>
                            </div>


                        </div>
                    </div>

                </div>
            </div>
        </div>