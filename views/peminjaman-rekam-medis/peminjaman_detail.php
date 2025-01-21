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
    $('#PeminjamanRekamMedis').on('beforeSubmit', function(e) {
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
                        window.location.href = '" . Url::to(['peminjaman-rekam-medis/list']) . "'; // Redirect ke URL list
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
                                    'id' => $modelPeminjaman->formName(),
                                    'options' => [
                                        'name' => $modelPeminjaman->formName(),
                                        'data-pjax' => true
                                    ],
                                ]); ?>

                             <div class="row">
                                 <div class="col-md-4">

                                     <?= $form->field($modelPeminjaman, "pegawai_id")->widget(Select2::classname(), [
                                            'options' => ['placeholder' => 'Gunakan Untuk Pegawai ...'],
                                            'initValueText' => ($modelPeminjaman->pegawai_id != null) ? '(' . $modelPeminjaman->pegawaiPinjam->id_nip_nrp . ') ' . $modelPeminjaman->pegawaiPinjam->nama_lengkap : null,
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
                                                    'url' => Url::to(['pegawai']),
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

                                        ])->label('<label>Peminjam : <b><span style="font-size: 12px;color: #000000;important;"><u></u></span></b></label>');
                                        ?>

                                     <?= $form->field($modelPeminjaman, 'id')->hiddenInput()->label(false) ?>
                                     <?= $form->field($modelPeminjaman, 'is_internal')->inline()->radioList(
                                            [1 => 'Internal', 0 => 'Eksternal'], // Opsi radio button
                                            [
                                                'item' => function ($index, $label, $name, $checked, $value) {
                                                    $checked = $checked ? 'checked' : ''; // Menentukan apakah radio button terpilih
                                                    return "<label class='radio-inline'><input type='radio' name='{$name}' value='{$value}' {$checked}> {$label}</label>";
                                                }
                                            ]
                                        )->label('Internal / Eksternal'); ?>
                                     <?= $form->field($modelPeminjaman, 'alasan_peminjaman')->widget(Select2::className(), [
                                            'hideSearch' => true,
                                            'data' => [
                                                'AUDIT MEDIK' => 'AUDIT MEDIK',
                                                'VERIFIKASI JAMKESMAS' => 'VERIFIKASI JAMKESMAS',
                                                'VERIFIKASI ASURANSI KESEHATAN LAINNYA' => 'VERIFIKASI ASURANSI KESEHATAN LAINNYA',
                                                'VERIFIKASI KEUANGAN / TAGIHAN' => 'VERIFIKASI KEUANGAN / TAGIHAN',
                                                'KLAIM JASA RAHARJA' => 'KLAIM JASA RAHARJA',
                                                'KLAIM ASURANSI KESEHATAN LAINNYA' => 'KLAIM ASURANSI KESEHATAN LAINNYA',
                                                'KLAIM KEUANGAN / TAGIHAN' => 'KLAIM KEUANGAN / TAGIHAN',
                                                'PENELITIAN NON PENDIDIKAN' => 'PENELITIAN NON PENDIDIKAN',
                                                'PENELITIAN PENDIDIKAN' => 'PENELITIAN PENDIDIKAN',
                                                'KEPENTINGAN HUKUM / PENGADILAN' => 'KEPENTINGAN HUKUM / PENGADILAN',
                                                'KEPENTINGAN DOKUMENTASI PASIEN' => 'KEPENTINGAN DOKUMENTASI PASIEN',
                                                'KEPENTINGAN LAIN (DIKETAHUI DIREKTUR)' => 'KEPENTINGAN LAIN (DIKETAHUI DIREKTUR)',
                                                'LAIN-LAINNYA' => 'LAIN-LAINNYA'
                                            ],
                                            'options' => [
                                                'placeholder' => 'Pilih alasan peminjaman',
                                                'style' => 'width: 100%;' // Ensuring full width
                                            ],
                                            'pluginOptions' => [
                                                'allowClear' => true
                                            ],
                                        ]); ?>


                                     <?= $form->field($modelPeminjaman, 'keterangan')->textarea() ?>
                                     <?= $form->field($modelPeminjaman, 'file_upload')->fileInput()->label('File Peminjaman <span class="text-danger">*</span> (Wajib saat pemberian akses)') ?>

                                     <?= $form->field($modelPeminjaman, 'tanggal_start')->widget(DateTimePicker::classname(), [
                                            'type' => DateTimePicker::TYPE_INPUT,
                                            'options' => ['placeholder' => 'Pilih tanggal dan waktu Awal Peminjaman ...'],
                                            'pluginOptions' => [
                                                'autoclose' => true,
                                                'format' => 'yyyy-mm-dd hh:ii:ss', // Mengatur format tampilan tanggal dan waktu
                                                'clearBtn' => true,
                                                'todayHighlight' => true,
                                                'startDate' => date('Y-m-d H:i:s'), // Mengatur tanggal minimum menjadi hari ini

                                            ],
                                            'value' => $modelPeminjaman->tanggal_start ? date('Y-m-d H:i:s', strtotime($modelPeminjaman->tanggal_start)) : '', // Mengatur nilai default yang ditampilkan atau kosong
                                        ]); ?>

                                     <?= $form->field($modelPeminjaman, 'tanggal_expire')->widget(DateTimePicker::classname(), [
                                            'type' => DateTimePicker::TYPE_INPUT,
                                            'options' => ['placeholder' => 'Pilih tanggal dan waktu Expire Peminjaman ...'],
                                            'pluginOptions' => [
                                                'autoclose' => true,
                                                'format' => 'yyyy-mm-dd hh:ii:ss', // Mengatur format tampilan tanggal dan waktu
                                                'clearBtn' => true,
                                                'todayHighlight' => true,
                                                'startDate' => date('Y-m-d H:i:s'), // Mengatur tanggal minimum menjadi hari ini

                                            ],
                                            'value' => $modelPeminjaman->tanggal_expire ? date('Y-m-d H:i:s', strtotime($modelPeminjaman->tanggal_expire)) : '', // Mengatur nilai default yang ditampilkan atau kosong
                                        ]); ?>

                                 </div>
                                 <div class="col-md-8">
                                     <?php DynamicFormWidget::begin([
                                            'widgetContainer' => 'dynamicform_wrapper',
                                            'widgetBody' => '.form-options-body',
                                            'widgetItem' => '.form-options-item',
                                            'min' => 1,
                                            'insertButton' => '.add-item',
                                            'deleteButton' => '.delete-item',
                                            'model' => $modelDetailPeminjaman[0],
                                            'formId' => $modelPeminjaman->formName(),
                                            'formFields' => [
                                                'id',
                                                'icd10_id',
                                                'jumlah',
                                                'dosis',
                                                'catatan',
                                                'utama'
                                            ],
                                        ]); ?>
                                     <table class="table-list-item table table-bordered" style="width: 100%;">
                                         <thead class="thead-light" style="text-align: center;">
                                             <th style="width: 98%">Daftar Rekam Medis</th>
                                             <th style="width: 2%"></th>
                                         </thead>
                                         <tbody class="form-options-body">

                                             <?php foreach ($modelDetailPeminjaman as $i => $modelDetail) : ?>

                                                 <tr class="form-options-item">
                                                     <?php
                                                        // necessary for update action.
                                                        if (!$modelDetail->isNewRecord) {
                                                            echo Html::activeHiddenInput($modelDetail, "[{$i}]id");
                                                        }
                                                        ?>

                                                     <td>
                                                         <?= $form->field($modelDetail, "[{$i}]pasien_kode")->widget(Select2::classname(), [
                                                                'options' => ['placeholder' => 'Gunakan Untuk Pencarian Rekam Medis ...'],
                                                                'initValueText' => ($modelDetail->pasien_kode != null) ? '(' . $modelDetail->pasien->kode . ') ' . $modelDetail->pasien->nama : null,
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
                                                                        'url' => Url::to(['pasien']),
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

                                                            ])->label(false);
                                                            ?>
                                                         <div class="row" style="padding-left: 10px">
                                                             <div class="text-lg div-icd10 mr-2">

                                                             </div>

                                                         </div>

                                                     </td>


                                                     <td class="style-td">
                                                         <button type="button" class="delete-item btn btn-outline-danger btn-xs rounded-pill btn-icon">
                                                             <i class="fa fa-trash fa-xs"></i>
                                                         </button>

                                                     </td>
                                                 </tr>
                                             <?php endforeach; ?>
                                         </tbody>
                                         <tfoot>
                                             <tr class="style-td">
                                                 <td style="text-align: center;"></td>
                                                 <td>
                                                     <button type="button" class="add-item btn btn-outline-primary btn-xs rounded-pill btn-icon">
                                                         <i class="fa fa-plus fa-xs"></i>
                                                     </button>
                                                 </td>
                                             </tr>
                                         </tfoot>

                                     </table>
                                     <?php DynamicFormWidget::end(); ?>

                                     <?= Html::submitButton('Simpan', ['class' => 'btn btn-success btn-block mb-2 rounded-0', 'id' => 'btn-icd-10-claim-simpan']) ?>

                                 </div>
                             </div>

                             <?php ActiveForm::end(); ?>

                         </div>
                         <?php if ($modelPeminjaman->file_upload) : ?>
                             <button class="btn btn-success mt-2" onclick="lihatHasilLuar(<?= $modelPeminjaman->id ?>)"><i class="fa fa-eye"></i> Lihat Dokumen Upload</button>
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
                     <h4 class="modal-title">Dokumen Peminjaman</h4>
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
         $('#pdf-hasil-luar').html("<embed src='<?= Url::to(['/peminjaman-rekam-medis/dokumen?id=']) ?>" + id + "' width='100%' height='800px'>")
     }
 </script>