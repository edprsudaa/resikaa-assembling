<?php

use yii\helpers\Html;
use yii\grid\GridView;
use kartik\select2\Select2;
use kartik\date\DatePicker;
use app\models\pendaftaran\KelompokUnitLayanan;
use app\components\HelperGeneralClass;
use app\components\HelperSpesialClass;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\LayananIgdSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Daftar Panduan Praktik Klinis';
$this->params['breadcrumbs'][] = $this->title;
// echo'<pre/>';print_r($dataProvider);die();
$this->registerJs("

$(document).ready(function() {
 
 
  myTable();
});



//Fungsi Pencarian Pada Tabel
function searchTable(str) {
  // Declare variables
  var filter, table, tr, td, i, txtValue;
  filter = str.toUpperCase();
  table = document.getElementById('example1');
  tr = table.getElementsByTagName('tr');
  var x = 0;
  // Loop through all table rows, and hide those who dont match the search query
  for (i = 1; i < tr.length; i++) {
    var td = tr[i].getElementsByTagName('td');
    var td1 = td[0];
    var td2 = td[1];
    var td3 = td[2];
    var td4 = td[3];
    if (td1 || td2 || td3 || td4) {
      txtValue = tr[i].textContent || tr[i].innerText;
      if (txtValue.toUpperCase().indexOf(filter) > -1) {
        tr[i].style.display = '';
        x = x + 1;
      } else {
        tr[i].style.display = 'none';
      }
    }
  }
 
}

$('#cari').keyup(function () {
  searchTable($(this).val());
});
// Generate Tabel
function myTable() {
  var data = {
    tanggal_awal: $('#tgl_awal').val(),
    tanggal_akhir: $('#tgl_akhir').val(),
    tipe_tanggal: $('#tipe_tanggal').val(),

  


  };
  $.ajax({
    url: baseUrl+'/panduan-praktik-klinis/daftar',
    type: 'post',
    data: { datatables: data },
    beforeSend: function () {
      // Show image container
      swal.fire({
        html: '<h5>Loading...</h5>',
        showConfirmButton: false,
      });
    },
    complete: function () {
      swal.close();
    },
    success: function (response) {

      $('tr:has(td)').remove();
      var trHTML = '';
      
      if(response.data.length>0){
      $.each(response.data, function (i, item) {
        let button = '';
        if(item.deleted_at==null){
          button += '<a class=\'btn btn-sm btn-info\' target=\'_blank\' href='+baseUrl+'/panduan-praktik-klinis/update?id='+item.id+' data-method=\'post\'><span class=\'nav-icon fas fa-edit text-white\' title=\'update\' data-toggle=\'tooltip\' data-placement=\'bottom\' data-original-title=\'Coding Pelaporan\' aria-describedby=\'tooltip537870\'></span></a><a class=\'btn btn-sm btn-success\' onclick=\'lihatPanduanPraktikKlinis('+item.id+')\'><i class=\'fa fa-eye\'></i></a><a class=\'btn btn-sm btn-info\' target=\'_blank\' href='+item.link+'><i class=\'fa fa-paper-plane\'></i> <a class=\'btn btn-sm btn-danger\' onclick=\'hapusPanduan('+item.id+')\'><i class=\'fa fa-trash\'></i></a>';

         
        }else{
          button += '<span class=\'badge badge-danger\'>Data Telah Dihapus</span><br>';

        }

       
        trHTML +='<tr class=\'distribusi\' ><td>'+(i+1)+'</td><td>'+item.keterangan+'</td><td>'+item.link+'</td><td>'+button+'</td></tr>';
               
        
        
      });
    }else{
      trHTML +='<tr><td colspan=\'7\' style=\'text-align:center\'>Data tidak tersedia / mohon pilih tanggal yang sesuai</td></tr>';
    }
      $('#example1').append(trHTML);
      let rowCount = $('#example1 tr:visible').length - 1;

      // $('span#total').text(response.data.length);
    },

    error: function (XMLHttpRequest, textStatus, errorThrown) {
      if (XMLHttpRequest.readyState == 4) {
        // HTTP error (can be checked by XMLHttpRequest.status and XMLHttpRequest.statusText)
      } else if (XMLHttpRequest.readyState == 0) {
        toastr.warning(
          'Gagal Terhubung Ke Server',
          'Silahkan cek koneksi / kabel jaringan'
        );
        // myTable();
      } else {
        // something weird is happening
      }
    },
  });
  
}")
?>
<div class="row">
  <div class="col-lg-12">
    <div class="card card-primary card-outline">
      <div class="card-body">
        <h3><?= Html::encode($this->title) ?> <?= Html::a('<span class=\'nav-icon fas fa-edit text-white\'></span> Tambah Panduan', ['create'], ['class' => 'btn btn-danger']) ?></h3>

        <br><br>

        <div class="layanan-search">

          <div class="row">
            <div class="col-lg-12">
              <label>Pencarian Panduan</label>
              <?= Html::textInput('nama_input', null, ['id' => 'cari', 'class' => 'form-control', 'placeholder' => 'Cari panduan']) ?>
            </div>




          </div>

        </div>
        <br>


        <table id="example1" class="table table-striped">
          <thead>
            <tr style="background-color: #0BB783;color: white;">
              <th width="5%">No</th>

              <th width="20%">Judul Panduan</th>


              <th width="55%">Link Drive</th>


              <th width="20%">Aksi</th>
            </tr>
          </thead>
          <tbody>
            <tr id="loading" style="display: none;text-align: center;">
              <td colspan="8">
                <button type="button" class="btn btn-outline-none spinner spinner-darker-primary spinner-right">
                  Memproses Data
                </button>
              </td>
            </tr>

            <tr id="no_data" style="display: none;text-align: center;">
              <td colspan="8">
                <button type="button" class="btn btn-outline-none spinner spinner-darker-primary spinner-right">
                  Tidak Ada Data
                </button>
              </td>
            </tr>

          </tbody>
        </table>

      </div>
    </div>
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
<script>
  function lihatPanduanPraktikKlinis(id) {
    $('#hasil-lab-luar-lihat').modal('show')
    $('#pdf-hasil-luar').html("<embed src='<?= Url::to(['/panduan-praktik-klinis/dokumen?id=']) ?>" + id + "' width='100%' height='800px'>")

  }


  function hapusPanduan(id) {
    Swal.fire({
      title: 'Apakah Anda yakin?',
      text: "Data yang sudah dihapus tidak bisa dikembalikan!",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Ya, hapus!',
      cancelButtonText: 'Batal'
    }).then((result) => {
      if (result.isConfirmed) {
        $('body').addClass('loading');

        $.ajax({
          url: '<?= Url::to(['/panduan-praktik-klinis/delete']) ?>',
          data: {
            id: id
          },
          dataType: 'json',
          type: 'POST',
          success: function(output) {
            $('body').removeClass('loading');
            if (output.status == true) {
              toastr.success(output.msg);
              location.reload(); // Reload halaman setelah berhasil
            } else {
              toastr.warning(output.msg);
            }
          },
          error: function(XMLHttpRequest, textStatus, errorThrown) {
            $('body').removeClass('loading');
            toastr.warning(errorThrown);
          }
        });
      }
    });
  }
</script>