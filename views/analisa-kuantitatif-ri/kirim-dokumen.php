<?php

use app\assets\plugins\InputmaskAsset;
use app\models\Registrasi;
use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;
use kartik\select2\Select2;
use kartik\widgets\DatePicker;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\web\JsExpression;
use yii\web\View;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\models\DistribusiSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Pendistribusian Registrasi Layanan';
$this->params['breadcrumbs'][] = $this->title;
$this->registerJs($this->render('script.js'), View::POS_END);
InputmaskAsset::register($this);
$this->registerJs("
function doc_keyUp(e) {
    if (e.keyCode == 113) {
        $('#input-rm').focus();
    }
    if (e.keyCode == 115) {
        $('#input-petugas').focus()
    }
}
document.addEventListener('keyup', doc_keyUp, false);

$('form#form-keluar-simpan').on('submit', function(e) {
    if($('#input-petugas').val()==''){
        Swal.fire({icon:'warning', title:'Mohon Pilih Petugas Terlebih Dulu', timer:1000});
        $('#input-petugas').focus();
    }else{
        rm = $('input#input-rm').val();
        ptg = $('#input-petugas').val();
        
        if(rm=='' || rm == null){
            Swal.fire({icon:'warning', title:'Masukkan No. RM yang akan didistribusikan', timer:1000});
            $('input#input-rm').focus();
        }
        else if(parseInt(rm, 10)>0){
        
            simpan(rm,ptg);
        }else{
            Swal.fire('Nomor Rekam Medik Harus Angka.');
        }
    }

    e.preventDefault();
});





function simpan(rm,ptg){
    $.ajax({
         url:'".Yii::$app->urlManager->createUrl('distribusi/registrasi-save')."',
         type: 'POST',
         data: {no_pasien: rm, petugas: ptg},
         dataType: 'json',
         
         success: function (result) {
            if (result.status) {
               
                Swal.fire({icon:'success', title:result.msg});
                if (result.status == true) {
                  setTimeout(function () {
                    location.reload();
                  }, 2000);
                }
              } else {
                Swal.fire({icon:'warning', title:result.msg});
              }
         },
     });
     
 }

    $('#table-registrasi-list-index tfoot th').each(function(){
        var title = $(this).text();
        var id = $(this).attr('data-id');
        if(id!=''){
            if(id=='jkel'){
                var slc='<select data-id=\''+id+'\' name=\'jkel\'><option></option><option value=\'l\'>Laki-laki</option><option value=\'p\'>Perempuan</option></select>';
                $(this).html(slc);
            }else{
                $(this).html('<input data-id=\''+id+'\' type=\'text\' placeholder=\'Cari '+title+'\' />');
            }
        }
    });
    $('#table-registrasi-list-index tfoot th').find('input[data-id=\'tgl_lahir\']').inputmask({
        regex:'[0-3][0-9]-[0-1][0-9]-[0-9]{4}'
    });
    $('#registrasi-form-search-datatable').find('input[name=\'tgl_lahir\']').inputmask({
        regex:'[0-3][0-9]-[0-1][0-9]-[0-9]{4}'
    });
    var oTable=$('#table-registrasi-list-index').dataTable({
        'bFilter':false,
        'autoWidth':true,
        'pagingType':'full_numbers',
        'iDisplayLength':10,
        'lengthMenu': [10, 50, 100, 200],
        'paging': true,
        'processing': true,
        'serverSide': true,
        'ordering': true,
        'fixedColumns': true,
        'language': {
            processing: '<i class=\'fa fa-refresh fa-spin fa-3x fa-fw\'></i><span class=\'sr-only\'>Loading...</span>'
        },
        'columns':[
            {'data':'fd_distribusi_kode','name':'fd_distribusi_kode'},
            {'data':'fd_created_at','name':'fd_created_at'},
            {'data':'fd_reg_kode','name':'fd_reg_kode'},
            {'data':'pgw_nama','name':'pgw_nama'},
            {'data':'ps_kode','name':'ps_kode'},
            {'data':'ps_nama','name':'ps_nama'},
            {'data':'unt_nama','name':'unt_nama'},
            {
                'data':null,
                'render':function(data,type,row){
                    if(data.fd_status==1){
                        return 'Proses Distribusi';

                    }else{
                        return 'Selesai Proses';

                    }


                }
            },
            {
                'data':null,
                'render':function(data,type,row){
                    if(data.fd_status==1){
                        return '<div class=\'btn-group\'><a href=\'detail?kodeDistribusi='+data.fd_distribusi_kode+'\' class=\'btn btn-sm btn-success btn-flat \' title=\'klik untuk detail distribusi\'><i class=\'fa fa-search\'></i></a><button data-kode=\''+data.fd_distribusi_kode+'\' type=\'button\' class=\'btn btn-sm btn-info btn-flat btn-registrasi\' title=\'klik untuk distribusi selesai\'><i class=\'fa fa-check\'></i></button></div>';

                    }else{
                        return '<div class=\'btn-group\'><a href=\'detail?kodeDistribusi='+data.fd_distribusi_kode+'\' class=\'btn btn-sm btn-success btn-flat \' title=\'klik untuk detail distribusi\'><i class=\'fa fa-search\'></i></a></div>';

                    }


                }
            },
        ],
       
        'ajax':function(data, callback, settings){
            var form=$('#registrasi-form-search-datatable');
            data.no_registrasi=form.find('input[name=\'no_registrasi\']').val();
            data.tgl_distribusi=form.find('input[name=\'tgl_distribusi\']').val();
            data.no_distribusi=form.find('input[name=\'no_distribusi\']').val();

            data.rm=form.find('input[name=\'no_rm\']').val();

            $.ajax({
                url:'" . Url::to(['distribusi-list-index']) . "',
                type:'post',
                data:{datatables:data},
                success:function(r){
                    callback({
                        recordsTotal: r.recordsTotal,
                        recordsFiltered: r.recordsFiltered,
                        data: r.data
                    });
                },
                error:function(xhr,status,error){
                    console.log(error)
                }
            })
        },
        'select': true,
        'responsive': true
    });
    $('#registrasi-form-search-datatable').on('submit',function(e){
        e.preventDefault();
        oTable.api().draw();
    });
    $(document).on('click','.btn-registrasi',function(e){
        e.preventDefault();
        e.stopImmediatePropagation();
        var btn=$(this);
        var kode=btn.attr('data-kode');
        if(kode){
            searchRegistrasiSelesai(kode);
        }else{
            errorMsg('No. Pasien tidak ditemukan');
        }
    });
");
$this->registerCss("
table.dataTable tbody tr.selected, table.dataTable tbody th.selected, table.dataTable tbody td.selected{
    font-weight:bolder;
    background-color:#00A65A;
}
");
?>
<div class="row">


    <div class="col-lg-12">
        <div class="card card-primary card-outline">
            <div class="card-header">
                <h5 class="card-title m-0">KIRIM DOKUMEN PASIEN KUNJUNGAN <?= date('d/m/Y') ?></h5>
            </div>
            <div class="card-body">

                <div class="row">
                    <div class="col-md-6">

                        <div class="row">
                            <div class="col-md-6 col-sm-6 col-12">
                                <div class="info-box bg-info">
                                    <span class="info-box-icon"><b style="border: 1px solid #fff; padding: 3px; border-radius:10px">F2</b></span>

                                    <div class="info-box-content">
                                        <h4 class="info-box-text">Input No RM</h4>

                                        <span class="info-box-number">Diisi dengan Nomor RM dengan Kunjungan Hari ini</span>

                                        <div class="progress">
                                            <div class="progress-bar" style="width: 100%"></div>
                                        </div>
                                        <span class="progress-description">
                                            Tanggal : <?= date('d/m/Y') ?>
                                        </span>
                                    </div>
                                    <!-- /.info-box-content -->
                                </div>
                                <!-- /.info-box -->
                            </div>
                            <div class="col-md-6 col-sm-6 col-12">
                                <div class="info-box bg-success">
                                    <span class="info-box-icon"><b style="border: 1px solid #fff; padding: 3px; border-radius:10px">F4</b></span>

                                    <div class="info-box-content">
                                        <h4 class="info-box-text">Pilih Petugas RM</h4>

                                        <span class="info-box-number">Diisi dengan Nama Petugas Pengantar Dokumen</span>

                                        <div class="progress">
                                            <div class="progress-bar" style="width: 100%"></div>
                                        </div>
                                        <span class="progress-description">
                                            Tanggal : <?= date('d/m/Y') ?>
                                        </span>
                                    </div>
                                    <!-- /.info-box-content -->
                                </div>
                                <!-- /.info-box -->
                            </div>

                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="row">
                            <form id="form-keluar-simpan">
                                <div class="col-sm-12">
                                    <!-- select -->
                                    <div class="form-group">
                                        <label>Pilih Petugas</label>
                                        <select class="form-control form-control-lg" data-toggle="tooltip" title="Tekan Spasi." id="input-petugas">
                                            <?php foreach ($petugasRm as $id => $nama) { ?>
                                                <option value="<?= $id ?>"><?= $nama ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <!-- select -->
                                    <div class="form-group">
                                        <input style="height:100px;font-size:56px;text-align:center" id="input-rm" class="form-control form-control-lg" type="text" autofocus=true placeholder="Input Nomor Rekam Medik">
                                    </div>
                                </div>
                            </form>

                        </div>
                    </div>

                    <!-- /.col -->
                </div>


            </div>
        </div>
    </div>
    <div class="col-lg-12">
        <div class="card card-primary card-outline">
            <div class="card-header">
                <h5 class="card-title m-0">Daftar Pengiriman Dokumen Rekam Medik Tanggal <?= date('d/m/Y') ?></h5>
            </div>
            <div class="card-body">
                <form class="well" id="registrasi-form-search-datatable">
                    <div class="row">
                        <div class="col-md-2">
                            <label>Tanggal Distribusi</label>
                            <?= DatePicker::widget([
                                'name' => 'tgl_distribusi',
                                'value' => date('Y-m-d'),
                                'removeButton' => false,
                                'pluginOptions' => [
                                    'autoclose' => true,
                                    'format' => 'yyyy-mm-dd'
                                ]
                            ]); ?>

                        </div>
                        <div class="col-md-3">
                            <label>Nomor Distribusi</label>
                            <input type="text" name="no_distribusi" class="form-control input-sm">
                        </div>
                        <div class="col-md-3">
                            <label>Nomor Registrasi</label>
                            <input type="text" name="no_registrasi" class="form-control input-sm">
                        </div>
                        <div class="col-md-3">
                            <label>Nomor Rekam Medis</label>
                            <input type="text" name="no_rm" class="form-control input-sm">
                        </div>
                        <div class="col-md-1">

                            <label>&nbsp;</label>
                            <button type="submit" class="btn btn-success btn-rounded pull-right form-control input-sm"><i class="fa fa-search"></i> Cari</button>
                        </div>

                    </div>

                    <br>
                </form>
                <table id="table-registrasi-list-index" class="table table-bordered table-hover table-striped">
                    <thead>
                        <tr>
                            <th>Tanggal Distribusi</th>
                            <th>No Pendaftaran</th>
                            <th>No. Rekam Medis</th>
                            <th>Nama</th>
                            <th>Unit Tujuan</th>
                            <th>Petugas RM</th>
                            <th>Waktu Kirim</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>

                </table>

            </div>
        </div>
    </div>
    <!-- /.col-md-6 -->
</div>