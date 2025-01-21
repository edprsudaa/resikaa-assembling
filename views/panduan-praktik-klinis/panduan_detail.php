 <?php

    use app\components\DynamicFormWidget;
    use app\components\HelperGeneralClass;
    use app\components\HelperSpesialClass;
    use kartik\date\DatePicker;
    use kartik\datetime\DateTimePicker;
    use kartik\select2\Select2;
    use yii\bootstrap4\ActiveForm;
    use yii\helpers\Html;
    use yii\helpers\Url;
    use yii\web\JsExpression;


    $this->registerJs("
    $('#PanduanPraktikKlinis').on('beforeSubmit', function(e) {
        e.preventDefault();
    
        var form = $(this)[0]; // Get the form DOM element
        var formData = new FormData(form); // Create a FormData object from the form
    
        var btn = $('.btn-submit');
        var htm = btn.html();
        $('body').addClass('loading');
        $('#btn-loading-analisa').attr('style', 'display: block');
    
        $.ajax({
            url: '" . Url::to(['save']) . "', // Replace with your server endpoint
            type: 'post',
            dataType: 'json',
            data: formData,
            processData: false, // Prevent jQuery from processing the data
            contentType: false, // Prevent jQuery from setting the Content-Type header
            success: function(result) {
                if (result.status) {
                    toastr.success(result.msg);
                    setTimeout(function () {
                        window.location.href = '" . Url::to(['panduan-praktik-klinis/list']) . "'; // Redirect ke URL list
                    }, 2000);
                } else {
                    if (typeof result.msg == 'object') {
                        $.each(result.msg, function(i, v) {
                            toastr.error(v);
                        });
                    } else {
                        toastr.error(result.msg);
                    }
                    $('body').removeClass('loading');
                    $('#btn-loading-analisa').attr('style', 'display: none');
                }
            },
            error: function(xhr, status, error) {
                toastr.error('An error occurred. Please try again.');
                $('body').removeClass('loading');
                $('#btn-loading-analisa').attr('style', 'display: none');
            }
        });
    }).submit(function(e) {
        e.preventDefault();
    });
    

    
    
    ");

    ?>

 <div class="card card-primary card-outline">

     <div class="card-body">
         <div class="row">



             <div class="col-lg-12">



                 <div class="card-header">
                     <h5 style="margin-bottom:6px;">Form Peminjaman Rekam Medis</h5>
                 </div>
                 <div class="card-body">
                     <div class="tab-content" id="custom-tabs-four-tabContent">
                         <div class="tab-pane fade active show" id="custom-tabs-four-home" role="tabpanel" aria-labelledby="custom-tabs-four-home-tab">

                             <?php $form = ActiveForm::begin([
                                    'id' => $model->formName(),
                                    'options' => [
                                        'name' => $model->formName(),
                                        'data-pjax' => true
                                    ],
                                ]); ?>

                             <div class="row">
                                 <div class="col-md-12">

                                     <?= $form->field($model, 'id')->hiddenInput()->label(false) ?>
                                     <?= $form->field($model, 'keterangan')->textInput() ?>




                                     <?= $form->field($model, 'link')->textarea() ?>
                                     <?= $form->field($model, 'file_upload')->fileInput() ?>



                                 </div>


                                 <?= Html::submitButton('Simpan', ['class' => 'btn btn-success btn-block mb-2 rounded-0', 'id' => 'btn-icd-10-claim-simpan']) ?>

                             </div>

                             <?php ActiveForm::end(); ?>

                         </div>
                         <?php if ($model->file_upload) : ?>
                             <button class="btn btn-success mt-2" onclick="lihatHasilLuar(<?= $model->id ?>)"><i class="fa fa-eye"></i> Lihat Dokumen Upload</button>
                         <?php endif; ?>

                     </div>
                 </div>
             </div>
         </div>
     </div>
     <div class="card-footer">
         <div class="col-sm-2">
             <button class="btn btn-outline-info">Kembali</button>
         </div>
     </div>
     <div class="modal fade" id="hasil-lab-luar-lihat">
         <div class="modal-dialog modal-xl">
             <div class="modal-content">
                 <div class="modal-header">
                     <h4 class="modal-title">Panduan Praktik Klinis </h4>
                     <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                         <span aria-hidden="true">&times;</span>
                     </button>
                 </div>
                 <div class="modal-body" id="pdf-hasil-luar">
                 </div>
                 <div class="modal-footer justify-content-between">
                     <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                 </div>
             </div>
         </div>
     </div>


 </div>
 <script>
     function lihatHasilLuar(id) {
         $('#hasil-lab-luar-lihat').modal('show')
         $('#pdf-hasil-luar').html("<embed src='<?= Url::to(['/panduan-praktik-klinis/dokumen?id=']) ?>" + id + "' width='100%' height='800px'>")

     }
 </script>