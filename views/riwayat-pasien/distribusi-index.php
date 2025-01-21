<?php

use app\assets\plugins\InputmaskAsset;
use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;
use kartik\select2\Select2;
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
            {'data':'reg_tgl_masuk','name':'reg_tgl_masuk'},

            {'data':'reg_kode','name':'reg_kode'},
            {'data':'ps_kode','name':'ps_kode'},
            {'data':'ps_nama','name':'ps_nama'},
            {'data':'fd_distribusi_kode','name':'fd_distribusi_kode'},
            {'data':'fd_created_at','name':'fd_created_at'},
           
            // {'data':'pgw_nama','name':'pgw_nama'},
           
            // {'data':'unt_nama','name':'unt_nama'},
            {
                'data':null,
                'render':function(data,type,row){
                    if(data.fd_reg_kode!=null){
                        return '<span class=\'right badge badge-success\'>Sudah Distribusi</span>';

                    }else{
                        return '<span class=\'right badge badge-danger\'>Belum Distribusi</span>';

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
                    console.log(r)
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
                <h5 class="card-title m-0">Status Pendistribusian Dokumen Pendaftaran</h5>
            </div>
            <div class="card-body">

                <a role="button" href="#registrasi-form-search-datatable" data-toggle="collapse" class="btn-sm btn btn-flat btn-success">Form Pencarian</a>
                <form class="well collapse in" id="registrasi-form-search-datatable">
                    <div class="row">
                        <div class="col-md-3">
                            <label>Tanggal Distribusi</label>
                            <input type="date" name="tgl_distribusi" class="form-control input-sm">
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

                    </div>

                    <button type="submit" class="btn btn-sm btn-success btn-flat pull-right"><i class="fa fa-search"></i> Submit</button>
                    <br>
                </form>
                <table id="table-registrasi-list-index" class="table table-bordered table-hover table-striped">
                    <thead>
                        <tr>
                            <th data-priority='1'>No. Pendaftaran</th>
                            <th data-priority='1'>Tgl Pendaftaran</th>
                            <th data-priority='1'>No. Rekam Medik</th>
                            <th data-priority='1'>Nama Pasien</th>

                            <th data-priority='1'>Kode Distribusi</th>
                            <th data-priority='1'>Tgl Distribusi</th>


                            <th data-priority='1'>Status Distribusi</th>

                        </tr>
                    </thead>

                </table>

            </div>
        </div>
    </div>
    <!-- /.col-md-6 -->
</div>