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

$this->title = 'Rekapitulasi Jumlah Ketidaktepatan Waktu Pengisian dan Closing Sistem Rawat Inap';
$this->params['breadcrumbs'][] = $this->title;
// echo'<pre/>';print_r($dataProvider);die();
$this->registerJs("

window.onload = function () {
  document.getElementById('tgl_awal').value = new Date().toJSON('id-ID', { timeZone: 'Asia/Jakarta' }).slice(0, 10);

 
   myTable();
 
 };

// Fungsi Pencarian Tanggal
$('#tgl_awal').on('change', function (ev) {
  myTable();
});
$('#tgl_akhir').on('change', function (ev) {
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
    tanggal_awal: $('#tgl_awal').val(),
    tanggal_akhir: $('#tgl_akhir').val(),
  
  };
  $.ajax({
    url: baseUrl+'/laporan/data-laporan-audit-ruangan-tidak-tepat-waktu',
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

       
       

        trHTML +='<tr class=\'distribusi\' ><td>'+(i+1)+'</td><td>'+item.nama+'<br></td><td>'+item.total_analisa_dokumen+'<br></td><td>'+item.jumlah_tepat_waktu_ppa+'</td><td>'+item.persentase_jumlah_tepat_waktu_ppa+'%</td><td>'+item.jumlah_tidak_tepat_waktu_ppa+'</td><td>'+item.persentase_jumlah_tidak_tepat_waktu_ppa+'%</td><td>'+item.jumlah_tepat_waktu_closing+'</td><td>'+item.persentase_jumlah_tepat_waktu_closing+'%</td><td>'+item.jumlah_tidak_tepat_waktu_closing+'</td><td>'+item.persentase_jumlah_tidak_tepat_waktu_closing+'%</td></tr>';
               
        
        
      });
    }else{
      trHTML +='<tr><td colspan=\'11\' style=\'text-align:center\'>Data tidak tersedia / mohon pilih tanggal yang sesuai</td></tr>';
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
            <div class="col-lg-4">
              <label>Pencarian Ruangan</label>
              <?= Html::textInput('nama_input', null, ['id' => 'cari', 'class' => 'form-control', 'placeholder' => 'Cari nama coder']) ?>
            </div>
            <div class="col-lg-4">
              <label>Tgl. Awal</label>
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
            <div class="col-lg-4">
              <label>Tgl. Akhir</label>

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



          </div>

        </div>
        <br>


        <table id="example1" class="table table-striped" border="1" style="width: 100%;">
          <thead>
            <tr style="background-color: #0BB783;color: white;">

              <th width="5%" rowspan="3" style="vertical-align: middle;text-align:center">No</th>
              <th width="10%" rowspan="3" style="vertical-align: middle;text-align:center">Nama Ruangan</th>

              <th width="85%" colspan="9" style="vertical-align: middle;text-align:center">JUMLAH DOKUMEN</th>
              </th>
            </tr>
            <tr style="background-color: #0BB783;color: white;">
              <th width="10%" rowspan="2" style="vertical-align: middle;">Jumlah Analisa</th>

              <th width="40%" colspan="4" style="vertical-align: middle;text-align:center">KETEPATAN WAKTU PENGISIAN EMR OLEH PPA (1 X 24 Jam)</th>
              <th width="40%" colspan="4" style="vertical-align: middle;text-align:center">KETEPATAN WAKTU CLOSING SISTIM EMR OLEH ADMIN (2 X 24 JAM)</th>
            </tr>
            <tr style="background-color: #0BB783;color: white;">

              <th width="10%">Tepat Waktu</th>
              <th width="10%">Persentasi Tepat Waktu</th>

              <th width="10%">Tidak Tepat Waktu</th>
              <th width="10%">Persentasi Tidak Tepat Waktu</th>

              <th width="10%">Tepat Waktu</th>
              <th width="10%">Persentasi Tepat Waktu</th>

              <th width="10%">Jumlah Tepat Waktu</th>
              <th width="10%">Persentasi Tidak Tepat Waktu</th>
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
              <td colspan="11">
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