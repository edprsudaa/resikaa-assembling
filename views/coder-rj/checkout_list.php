<?php

use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
use app\assets\plugins\InputmaskAsset;
use app\assets\plugins\DatatableAsset;
use kartik\widgets\DatePicker;

InputmaskAsset::register($this);
// DatatableAsset::register($this);
$this->registerJs("
  
    $('#table-registrasi-list tfoot th').find('input[data-id=\'tgl_lahir\']').inputmask({
        regex:'[0-3][0-9]-[0-1][0-9]-[0-9]{4}'
    });
    $('#registrasi-form-search-datatable').find('input[name=\'tgl_lahir\']').inputmask({
        regex:'[0-3][0-9]-[0-1][0-9]-[0-9]{4}'
    });
    var oTable=$('#table-registrasi-list').dataTable({
        'bFilter':false,
        'autoWidth':true,
        'pagingType':'full_numbers',
        'iDisplayLength':10,
        'lengthMenu': [10,20,50, 100, 200],
        'paging': true,
        'processing': true,
        'serverSide': true,
        'searching': false,
        'ordering': true,
        'fixedColumns': true,
        'language': {
            processing: '<i class=\'fa fa-refresh fa-spin fa-3x fa-fw\'></i><span class=\'sr-only\'>Loading...</span>'
        },
        'order': [ 1, 'asc'],
        'columns':[
            {'data':'reg_kode','name':'reg_kode','defaultContent':'-'},
            {'data':'reg_tgl_masuk','name':'reg_tgl_masuk','defaultContent':'-'},


            {'data':'pasien.ps_kode','name':'ps_kode','defaultContent':'-'},

            {'data':'pasien.ps_nama','name':'ps_nama','defaultContent':'-'},

            {'data':'layanan.0.unit.unt_nama','name':'unt_nama','defaultContent':'-'},

           
            {
                'data':null,
                'name':'fd_created_at',
                'defaultContent':'-',
                'render':function(data,type,row){
                    if(data.distribusi.length==0){
                        return '<span class=\'right badge badge-danger\'>Belum Didistribusikan</span>';

                    }else{
                        return '<span class=\'right badge badge-success\'>Sudah Didistribusikan</span>';
                    }
                }
            },
            {
                'data':null,
                'orderable':false,
                'render':function(data,type,row){
                    if(data.distribusi.length==0){
                    return '<button data-kode=\''+data.reg_kode+'\' type=\'button\' class=\'btn btn-sm btn-success btn-flat btn-grab\' title=\'klik untuk mencari pasien\'><i class=\'fa fa-search\'></i></button>';
                    }else{
                        return '';
                    }
                }
            },
        ],
        
        'ajax':function(data, callback, settings){
            var form=$('#registrasi-form-search-datatable');
            data.no_registrasi=form.find('input[name=\'no_registrasi\']').val();
            data.rm=form.find('input[name=\'no_rm\']').val();
            data.tgl_pendaftaran=form.find('input[name=\'tgl_pendaftaran\']').val();


            $.ajax({
                url:'" . Url::to(['checkout-list-datatable']) . "',
                type:'post',
                data:{datatables:data},
                success:function(r){
                    console.log(r);
                    callback({
                        recordsTotal: r.recordsTotal,
                        recordsFiltered: r.recordsFiltered,
                        data: r.data
                    });
                },
                error:function(xhr,status,error){
                    errorMsg(error);
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
    $(document).on('click','.btn-grab',function(e){
        e.preventDefault();
        e.stopImmediatePropagation();
        var btn=$(this);
        var kode=btn.attr('data-kode');
        if(kode){
            $('input[name=\'noregistrasi\']').val(kode);
            console.log(kode)
            searchDistribusiRegistrasi();
            $('#mymodal').modal('hide');
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


<div class="modal-dialog modal-xl" style="width:100%;">
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title">Daftar Checkout Pasien</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
        </div>
        <div class="modal-body">
            <form class="well" id="registrasi-form-search-datatable">
                <div class="row">
                <div class="col-md-2">
                        <label>Tanggal Pendaftaran</label>
                        <?= DatePicker::widget([
                            'name' => 'tgl_pendaftaran',
                            'value' => date('Y-m-d'),
                            'removeButton' => false,
                            'pluginOptions' => [
                                'autoclose' => true,
                                'format' => 'yyyy-mm-dd'
                            ]
                        ]); ?>

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
            <table id="table-registrasi-list" class="table table-bordered table-hover table-striped" style="width:100%">
                <thead>
                    <tr>
                        <th data-priority='1'>No. Registrasi</th>
                        <th data-priority='1'>Tgl Daftar</th>

                        <th data-priority='1'>No. Rekam Medis</th>
                        <th data-priority='1'>Nama</th>
                        <th data-priority='1'>Unit Tujuan</th>
                        <th data-priority='1'>Status</th>


                        <th data-priority='1'>Aksi</th>
                    </tr>
                </thead>

            </table>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-danger btn-sm btn-flat" data-dismiss="modal"><i class="fa fa-close"></i> Tutup</button>
        </div>
    </div>
</div>
</div>