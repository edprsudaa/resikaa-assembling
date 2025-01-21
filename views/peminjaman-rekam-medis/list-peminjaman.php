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

$this->title = 'Daftar Peminjaman Rekam Medis';
$this->params['breadcrumbs'][] = $this->title;
// echo'<pre/>';print_r($dataProvider);die();
$this->registerJs("

$(document).ready(function() {
  document.getElementById('tgl_awal').value = new Date().toJSON('id-ID', { timeZone: 'Asia/Jakarta' }).slice(0, 10);
  document.getElementById('tgl_akhir').value = new Date().toJSON('id-ID', { timeZone: 'Asia/Jakarta' }).slice(0, 10);

 
  myTable();
});

// Fungsi Pencarian Tanggal
$('#tgl_awal').on('change', function (ev) {
  myTable();
});
$('#tgl_akhir').on('change', function (ev) {
  myTable();
});
$('#tipe_tanggal').on('change', function (ev) {
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
    url: baseUrl+'/peminjaman-rekam-medis/daftar-peminjaman-by-peminjam',
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

        

       
        trHTML +='<tr class=\'distribusi\' ><td>'+(i+1)+'</td><td><b>'+item.peminjam+'</b><br>('+item.is_internal+')<br></td><td>'+item.petugas_pinjam+'</td><td>'+item.alasan_peminjaman+'</td><td>'+item.tanggal_start+'</td><td>'+item.tanggal_expire+'</td><td>'+item.token+'</td><td><a class=\'btn btn-sm btn-info\' target=\'_blank\' href='+baseUrl+'/peminjaman-rekam-medis/generate-list-pasien?token='+item.token_hash+' data-method=\'post\'><span class=\'nav-icon fas fa-eye text-white\' title=\'\' data-toggle=\'tooltip\' data-placement=\'bottom\' data-original-title=\'Coding Pelaporan\' aria-describedby=\'tooltip537870\'></span> Lihat Rekam Medis</a></td></tr>';
               
        
        
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
            <div class="col-lg-2">
              <label>Pencarian Peminjam</label>
              <?= Html::textInput('nama_input', null, ['id' => 'cari', 'class' => 'form-control', 'placeholder' => 'Cari nama pasien, nomor rekam medis atau registrasi']) ?>
            </div>
            <div class="col-lg-3">
              <label>Tgl. Pinjam Awal</label>
              <?= DatePicker::widget([
                'name' => 'tgl_awal',
                'id' => 'tgl_awal',
                'type' => DatePicker::TYPE_INPUT,
                'value' => (Yii::$app->getRequest()->getQueryParam('RegistrasiSearch')['tgl_awal']) ?? date("Y-m-d"),
                'options' => ['placeholder' => 'Pilih tanggal Awal Analisa ...'],
                'pluginOptions' => [
                  'autoclose' => true,
                  'format' => 'yyyy-mm-dd',
                  'clearBtn' => true
                ]
              ]) ?>
            </div>
            <div class="col-lg-3">
              <label>Tgl. Pinjam Akhir</label>

              <?= DatePicker::widget([
                'name' => 'tgl_akhir',
                'id' => 'tgl_akhir',

                'type' => DatePicker::TYPE_INPUT,
                'value' => Yii::$app->getRequest()->getQueryParam('RegistrasiSearch')['tgl_akhir'] ?? date("Y-m-d"),
                'options' => ['placeholder' => 'Pilih tanggal Akhir Analisa ...'],
                'pluginOptions' => [
                  'autoclose' => true,
                  'format' => 'yyyy-mm-dd',
                  'clearBtn' => true,
                ]
              ]) ?>
            </div>
            <div class="col-lg-3">
              <label>Berdasarkan Tanggal Start / Expire</label>
              <?= Select2::widget([
                'name' => 'tipe_tanggal',
                'id' => 'tipe_tanggal',
                'data' => ['0' => 'Tanggal Start', '1' => 'Tanggal Expire'],
                'value' => '1', // Set default value
                'options' => [
                  'placeholder' => 'Pilih Start / Expire ...',

                ],

              ]); ?>
            </div>



          </div>

        </div>
        <br>


        <table id="example1" class="table table-striped">
          <thead>
            <tr style="background-color: #0BB783;color: white;">
              <th width="5%">No</th>

              <th width="10%">Pegawai Peminjaman</th>

              <th width="10%">Pegawai Rekam Medis</th>

              <th width="10%">Alasan Peminjaman</th>
              <th width="10%">Tgl Akses Start</th>
              <th width="10%">Tgl Akses Expire</th>


              <th width="10%">Token</th>

              <th width="10%">Aksi</th>
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