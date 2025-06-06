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

$this->title = 'Daftar Pasien Rawat Jalan';
$this->params['breadcrumbs'][] = $this->title;
// echo'<pre/>';print_r($dataProvider);die();
$this->registerJs("

window.onload = function () {
  document.getElementById('tgl_masuk_awal').value = new Date().toJSON('id-ID', { timeZone: 'Asia/Jakarta' }).slice(0, 10);
  document.getElementById('tgl_masuk_akhir').value = new Date().toJSON('id-ID', { timeZone: 'Asia/Jakarta' }).slice(0, 10);

 
   myTable();
 
 };

// Fungsi Pencarian Tanggal
$('#tgl_masuk_awal').on('change', function (ev) {
  myTable();
});
$('#tgl_masuk_akhir').on('change', function (ev) {
  myTable();
});
$('#tgl_keluar_awal').on('change', function (ev) {
  myTable();
});
$('#ruangan').on('change', function (ev) {
  myTable();
});
$('#tgl_keluar_akhir').on('change', function (ev) {
  myTable();
});
$('#claim').on('change', function (ev) {
  myTable();
});
$('#pelaporan').on('change', function (ev) {
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
    tanggal_masuk_awal: $('#tgl_masuk_awal').val(),
    tanggal_masuk_akhir: $('#tgl_masuk_akhir').val(),
    tanggal_keluar_awal: $('#tgl_keluar_awal').val(),
    tanggal_keluar_akhir: $('#tgl_keluar_akhir').val(),
    ruangan :$('#ruangan').val(),
    claim: $('#claim').val(),
    pelaporan: $('#pelaporan').val(),

  };
  $.ajax({
    url: 'http://emr-pengolahan-data.simrs.aa/history-pasien/data-pasien-list',
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
      console.log(response);

      $('tr:has(td)').remove();
      var trHTML = '';
      if(response.data.length>0){
      $.each(response.data, function (i, item) {

        // Membuat list pada elemen HTML

        let poliList = '';
        $.each(item.poli, function(index, value) {
            poliList += '<span class=\'badge badge-warning\'>' + value + '</span><br>';
        });
        let claim = '';
        if(item.claim==0){
          claim += '<span class=\'badge badge-danger\'>Belum Claim</span><br>';
        }else{
          claim += '<span class=\'badge badge-success\'>Sudah Claim</span><br>';

        }
        let pelaporan = '';
        if(item.pelaporan==0){
          pelaporan += '<span class=\'badge badge-danger\'>Belum pelaporan</span><br>';
        }else{
          pelaporan += '<span class=\'badge badge-success\'>Sudah pelaporan</span><br>';

        }

       

        trHTML +='<tr class=\'distribusi\' ><td>'+(i+1)+'</td><td>'+item.nomor_registrasi+'<br>'+item.rm_pasien+'<br>'+item.nama_pasien+'</td><td>'+item.tgl_registrasi+'</td><td>'+item.tgl_checkout+'</td><td>'+item.rawat+'</td><td>'+item.tgl_masuk+'</td><td>'+item.tgl_keluar+'</td><td>'+item.unit+'</td><td>'+item.unit_asal+'</td><td>'+item.catatan+'</td><td>'+item.resume+'</td><td><a class=\'btn btn-sm btn-success\' href=\'/mpp/catatan?id='+item.registrasi_kode_hash+'&amp;layanan_id='+item.layanan_nama+' data-method=\'post\'><span class=\'nav-icon fas fa-edit text-white\' title=\'\' data-toggle=\'tooltip\' data-placement=\'bottom\' data-original-title=\'Coding Pelaporan\' aria-describedby=\'tooltip537870\'></span> Pilih Pasien</a></td></tr>';
               
        
        
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
              <label>Pencarian Pasien</label>
              <?= Html::textInput('nama_input', null, ['id' => 'cari', 'class' => 'form-control', 'placeholder' => 'Cari nama pasien, nomor rekam medis atau registrasi']) ?>
            </div>
            <div class="col-lg-2">
              <label>Ruangan</label>

              <?= Select2::widget([
                'name' => 'ruangan',
                'id' => 'ruangan',

                'data' => HelperSpesialClass::getListRIAksesPegawaiMppNew()['unit_akses'],
                'attribute' => 'ruangan',
                'options' => ['placeholder' => 'Select a state ...'],
                'pluginOptions' => [
                  'allowClear' => true
                ],
              ]); ?>
            </div>
            <div class="col-lg-2">
              <label>Tgl. Masuk Awal</label>
              <?= DatePicker::widget([
                'name' => 'tgl_masuk_awal',
                'id' => 'tgl_masuk_awal',
                'type' => DatePicker::TYPE_INPUT,
                'options' => ['placeholder' => 'Pilih tanggal Awal Analisa ...'],
                'pluginOptions' => [
                  'autoclose' => true,
                  'format' => 'yyyy-mm-dd',
                  'clearBtn' => true
                ]
              ]) ?>
            </div>



            <div class="col-lg-2">
              <label>Tgl. Masuk Akhir</label>

              <?= DatePicker::widget([
                'name' => 'tgl_masuk_akhir',
                'id' => 'tgl_masuk_akhir',

                'type' => DatePicker::TYPE_INPUT,
                'options' => ['placeholder' => 'Pilih tanggal Akhir Analisa ...'],
                'pluginOptions' => [
                  'autoclose' => true,
                  'format' => 'yyyy-mm-dd',
                  'clearBtn' => true,
                ]
              ]) ?>
            </div>

            <div class="col-lg-2">
              <label>Tgl. Keluar Awal</label>
              <?= DatePicker::widget([
                'name' => 'tgl_keluar_awal',
                'id' => 'tgl_keluar_awal',
                'type' => DatePicker::TYPE_INPUT,
                'options' => ['placeholder' => 'Pilih tanggal Awal Analisa ...'],
                'pluginOptions' => [
                  'autoclose' => true,
                  'format' => 'yyyy-mm-dd',
                  'clearBtn' => true
                ]
              ]) ?>
            </div>
            <div class="col-lg-2">
              <label>Tgl. Keluar Akhir</label>

              <?= DatePicker::widget([
                'name' => 'tgl_keluar_akhir',
                'id' => 'tgl_keluar_akhir',

                'type' => DatePicker::TYPE_INPUT,
                'options' => ['placeholder' => 'Pilih tanggal Akhir Analisa ...'],
                'pluginOptions' => [
                  'autoclose' => true,
                  'format' => 'yyyy-mm-dd',
                  'clearBtn' => true,
                ]
              ]) ?>
            </div>



          </div>

        </div>
        <br>


        <table id="example1" class="table table-striped">
          <thead>
            <tr style="background-color: #0BB783;color: white;">
              <th width="5%">No</th>
              <th width="10%">No Daftar</th>

              <th width="10%">Tgl. Registrasi</th>
              <th width="10%">Tgl. Checkout</th>
              <th width="10%">Status Pasien</th>

              <th width="10%">Tgl. Masuk Ruangan</th>
              <th width="10%">Tgl. Keluar Ruangan</th>

              <th width="15%">Poli/Unit</th>
              <th width="15%">Poli/Unit Asal</th>

              <th width="5%">Catatan </th>
              <th width="5%">Resume Medis</th>


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