<?php

use yii\helpers\Html;
use yii\grid\GridView;
use kartik\select2\Select2;
use kartik\date\DatePicker;
use app\models\pendaftaran\KelompokUnitLayanan;
use app\components\HelperGeneralClass;
use app\components\HelperSpesialClass;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\LayananIgdSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Generate List Rekam Medis';
$this->params['breadcrumbs'][] = $this->title;
// echo'<pre/>';print_r($dataProvider);die();
$this->registerJs("

$(document).ready(function() {
  // Periksa apakah input #cari memiliki nilai saat halaman dimuat
  if ($('#cari').val() !== '') {
    myTable();
  }
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
    var td2 = td[2];
    var td3 = td[3];
    var td4 = td[4];
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
  if (event.keyCode === 13) { // 13 adalah kode untuk tombol Enter
    myTable();
}
});
// Generate Tabel
function myTable() {
  var data = {
    cari: $('#cari').val()

  };
  $.ajax({
    url: baseUrl+'/peminjaman-rekam-medis/check-generate-token-external',
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
        
       
       
        trHTML +='<tr class=\'distribusi\' ><td>'+(i+1)+'</td><td>'+item.pasien_kode+'<br>'+item.nama+'</td><td>'+item.alasan_peminjaman+'</td><td>'+item.tanggal_start+'</td><td>'+item.tanggal_expire+'</td><td><a class=\'btn btn-sm btn-success\' target=\'_blank\' href='+baseUrl+'/history-pasien/list-kunjungan-object?id='+item.pasien_kode_hash+'&versi=1 data-method=\'post\'><span class=\'nav-icon fas fa-edit text-white\' title=\'\' data-toggle=\'tooltip\' data-placement=\'bottom\' data-original-title=\'Coding Pelaporan\' aria-describedby=\'tooltip537870\'></span>Riwayat By Dokumen</a></td><td><a class=\'btn btn-sm btn-warning\' target=\'_blank\' href='+baseUrl+'/history-pasien/list-kunjungan?id='+item.pasien_kode_hash+'&versi=1 data-method=\'post\'><span class=\'nav-icon fas fa-edit text-white\' title=\'\' data-toggle=\'tooltip\' data-placement=\'bottom\' data-original-title=\'Coding Pelaporan\' aria-describedby=\'tooltip537870\'></span>Riwayat By Kunjungan</a></td></tr>';
        
        
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
        <h3><?= Html::encode($this->title) ?></h3>

        <div class="layanan-search">

          <div class="row">
            <div class="col-lg-12">
              <?= Html::textInput('nama_input', isset($_GET['token']) ? HelperGeneralClass::validateData($_GET['token']) : '', [
                'id' => 'cari',

                'class' => 'form-control',
                'placeholder' => 'Cari nama pasien, nomor rekam medis atau registrasi',
                'style' => 'height: 2cm; text-align: center; font-size: 24px;'  //
              ]) ?>
            </div>




          </div>

        </div>
        <br>


        <table id="example1" class="table table-striped">
          <thead>
            <tr style="background-color: #0BB783;color: white;">
              <th width="5%">No</th>
              <th width="20%">Nama / Rekam Medis</th>

              <th width="15%">Alasan Peminjaman</th>
              <th width="10%">Tanggal Start</th>
              <th width="10%">Tanggal Expire</th>

              <th width="10%">Riwayat By Dokumen</th>
              <th width="10%">Riwayat By Kunjungan</th>

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