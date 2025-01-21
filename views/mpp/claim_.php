<?php

use app\components\HelperGeneralClass;
use app\components\HelperSpesialClass;
use app\models\pendaftaran\KelompokUnitLayanan;
use app\components\DynamicFormWidget;
use kartik\date\DatePicker;
use kartik\select2\Select2;
use yii\bootstrap4\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\JsExpression;

$this->registerJs("

 $('#af-dokter-verifikator').on('beforeSubmit',function(e){
     e.preventDefault();
     var btn=$('.btn-submit');
     var htm=btn.html();
     $('body').addClass('loading');
     $('#btn-loading-analisa').attr('style', 'display: block')
     // Cek jumlah opsi yang dipilih dengan nilai \'Yes\' pada field select2 \'utama\'
    var count = 0;
    $('#af-dokter-verifikator select[name$=\'[utama]\']').each(function() {
    if ($(this).val() == '1') {
        count++;
    }});


    // Jika jumlah opsi yang dipilih lebih dari satu, tampilkan alert

    if (count > 1) {
    toastr.error('Tidak boleh memilih lebih dari satu opsi Utama');
    $('body').removeClass('loading');
    $('#btn-loading-analisa').attr('style', 'display: none');
    return false;


    }
     $.ajax({
         url:'" . Url::to(['save-resume-medis-verifikator-rj']) . "',
         type:'post',
         dataType:'json',
         data:$(this).serialize(),
         success:function(result){
             if(result.status){
             toastr.success(result.msg);
             }
             if(result.status){
                 setTimeout(function () {
                    window.location.reload();
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
//             // App.ResetLoadingBtn(btn,htm);
         },
         error:function(xhr,status,error){
//             // App.Error(error);
//             // App.ResetLoadingBtn(btn,htm);
         }
     });
 }).submit(function(e){
     e.preventDefault();
 });
 $('.btn-preview-resume-verifikator-rj').click(function(e){
    e.preventDefault();
    var id=$(this).attr('data-id');
    var pasien=$(this).attr('data-pasien');
    console.log(pasien)
    if(id){
        $.post('" . Url::to(['detail-resume-verifikator-rj']) . "',{id:id,pasien:pasien},function(res){
            $('.mymodal_card_xl_body').html(res);
            $('.mymodal_card_xl').modal('show');
        });
    }
});
$('.btn-preview-resume-verifikator-rj-cetak').click(function(e){
    e.preventDefault();
    var id=$(this).attr('data-id');
    var pasien=$(this).attr('data-pasien');
    console.log(pasien)
    if(id){
        $.post('" . Url::to(['detail-resume-verifikator-rj']) . "',{id:id,pasien:pasien},function(res){
            var newTab = window.open();
            newTab.document.body.innerHTML = res;
        });
    }
});
$('.btn-lihat-resume-medis').on('click', function (){
    $.get($(this).attr('href'), function(data) {
        $('.mymodal_card_xl_body').html(data);
        $('.mymodal_card_xl').modal('show');
   });
   return false;
});
$('.btn-preview-resume-verifikator-ri').click(function(e){
    e.preventDefault();
    var id=$(this).attr('data-id');
    var pasien=$(this).attr('data-pasien');
    console.log(pasien)
    if(id){
        $.post('" . Url::to(['detail-resume-verifikator-ri']) . "',{id:id,pasien:pasien},function(res){

            $('.mymodal_card_xl_body').html(res);
            $('.mymodal_card_xl').modal('show');
        });
    }
});
$('.btn-preview-resume-verifikator-ri-cetak').click(function(e){
    e.preventDefault();
    var id=$(this).attr('data-id');
    var pasien=$(this).attr('data-pasien');
    console.log(pasien)
    if(id){
        $.post('" . Url::to(['detail-resume-verifikator-ri']) . "',{id:id,pasien:pasien},function(res){
            var newTab = window.open();
            newTab.document.body.innerHTML = res;
            
        });
    }
});
");


?>
<div class="row">
    <div class="col-lg-12">
        <!-- Card Pasien -->
        <?php echo $this->render('card-pasien', ['registrasi' => $registrasi]);
        // print_r($model->analisa_dokumen_id);
        // die();

        ?>
        <div class="row">


            <?php echo $this->render('riwayat_pasien', ['registrasi' => $registrasi]); ?>
            <br>

            <div class="col-lg-12">
                <?php

                echo $this->render('claim_detail', ['modelCodingClaimRi' => $modelCodingClaimRi, 'modelCodingClaimDiagnosaDetailRi' => $modelCodingClaimDiagnosaDetailRi, 'modelCodingClaimTindakanDetailRi' => $modelCodingClaimTindakanDetailRi,  'registrasi' => $registrasi]);
                ?>
            </div>


        </div>



    </div>
</div>