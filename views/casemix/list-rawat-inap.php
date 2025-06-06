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

$this->title = 'Daftar Pasien Rawat Inap';
$this->params['breadcrumbs'][] = $this->title;
// echo'<pre/>';print_r($dataProvider);die();
$this->registerJs("

$(document).ready(function() {
  document.getElementById('tanggal').value = new Date().toJSON('id-ID', { timeZone: 'Asia/Jakarta' }).slice(0, 10);

  myTable();
});

$('#search').on('click', function() {
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

$('#reset').on('click', function() {
  // Reset nilai input pencarian
  $('#cari').val('');

  // Reset tanggal ke hari ini
  var today = new Date().toISOString().split('T')[0];
  $('#tanggal').val(today);

  // Reset select2 (unit_kode) ke default
  $('#unit_kode').val(null).trigger('change');
  myTable(); 
});

function formatRupiah(amount) {
  return new Intl.NumberFormat('id-ID', {
      style: 'currency',
      currency: 'IDR',
      minimumFractionDigits: 0,
  }).format(amount);
}

// Generate Tabel
function myTable() {
  var data = {
    tanggal: $('#tanggal').val(),
    cari :$('#cari').val(),
    unit_kode :$('#unit_kode').val(),

  };
  $.ajax({
    url: baseUrl+'/casemix/data-rawat-inap',
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
        // Membuat list pada elemen HTML
        // var array = JSON.parse('[' + item.poli + ']');
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
        if(item.pelaporan_ri==0){
          pelaporan += '<span class=\'badge badge-danger\'>Belum pelaporan</span><br>';
        }else{
          pelaporan += '<span class=\'badge badge-success\'>Sudah pelaporan</span><br>';

        }
        let tgl_checkout = '';
        let tgl_closing = '';

        let button_coding ='';
        if(item.tgl_keluar==null){
          tgl_checkout += '<span class=\'badge badge-danger\'>Belum Checkout</span><br>';
      }else{      
          tgl_checkout += item.tgl_keluar;
      }
      if(item.closing_billing_ranap_at==null){
          tgl_closing += '<span class=\'badge badge-danger\'>Belum Closing</span><br>';
      }else{
          tgl_closing += item.closing_billing_ranap_at;
      }

      if(item.tgl_pulang >= '2024-03-01'){
        if(item.closing_billing_ranap_at==null){
          button_coding += '<span class=\'badge badge-danger\'>Belum Bisa Lihat Riwayat / Belum Closing</span><br>'; 
        }else{ 
          button_coding +='<a class=\'btn btn-sm btn-info\' target=\'_blank\' href='+baseUrl+'/history-pasien/detail-kunjungan?rm='+item.pasien_kode+'&noreg='+item.kode+' data-method=\'post\'><span class=\'nav-icon fas fa-edit text-white\' title=\'\' data-toggle=\'tooltip\' data-placement=\'bottom\' data-original-title=\'Coding Pelaporan\' aria-describedby=\'tooltip537870\'></span>Riwayat Pendaftaran Saat Ini</a> <br> <a class=\'btn btn-sm btn-warning\' title=\'log akses\' onclick=\'updateClaim('+item.kode+')\'><i class=\'fa fa-clock\'></i> Update Estimasi Claim BPJS</a>';
    
        }
      }else{
        if(item.tgl_keluar==null){
    
          button_coding += '<span class=\'badge badge-danger\'>Belum Checkout</span><br>';
          // button_coding +='<a class=\'btn btn-sm btn-success\' target=\'_blank\' href='+baseUrl+'/coder-ri/view?id='+item.registrasi_kode_hash+' data-method=\'post\'><span class=\'nav-icon fas fa-edit text-white\' title=\'\' data-toggle=\'tooltip\' data-placement=\'bottom\' data-original-title=\'Coding Pelaporan\' aria-describedby=\'tooltip537870\'></span> Klik Untuk Coding</a>';
          
        
        }else{
          button_coding +='<a class=\'btn btn-sm btn-info\' target=\'_blank\' href='+baseUrl+'/history-pasien/detail-kunjungan?rm='+item.pasien_kode+'&noreg='+item.kode+' data-method=\'post\'><span class=\'nav-icon fas fa-edit text-white\' title=\'\' data-toggle=\'tooltip\' data-placement=\'bottom\' data-original-title=\'Coding Pelaporan\' aria-describedby=\'tooltip537870\'></span>Riwayat Pendaftaran Saat Ini</a>';
    
        } 
      }

       
        //trHTML +='<tr class=\'distribusi\' ><td>'+(i+1)+'</td><td>'+item.kode+'<br>'+item.pasien_kode+'<br>'+item.nama+'</td><td>'+item.tgl_masuk+'</td><td>'+item.tgl_pulang+'</td><td>'+tgl_checkout+'</td><td>'+tgl_closing+'</td><td>'+poliList+'</td><td><a class=\'btn btn-sm btn-success\' target=\'_blank\' href='+baseUrl+'/history-pasien/list-kunjungan-object?id='+item.pasien_kode_hash+'&versi=1 data-method=\'post\'><span class=\'nav-icon fas fa-edit text-white\' title=\'\' data-toggle=\'tooltip\' data-placement=\'bottom\' data-original-title=\'Coding Pelaporan\' aria-describedby=\'tooltip537870\'></span>Riwayat By Dokumen</a><a class=\'btn btn-sm btn-warning\' target=\'_blank\' href='+baseUrl+'/history-pasien/list-kunjungan?id='+item.pasien_kode_hash+'&versi=1 data-method=\'post\'><span class=\'nav-icon fas fa-edit text-white\' title=\'\' data-toggle=\'tooltip\' data-placement=\'bottom\' data-original-title=\'Coding Pelaporan\' aria-describedby=\'tooltip537870\'></span>Riwayat By Kunjungan</a>'+button_coding+'</td></tr>';

        trHTML +='<tr class=\'distribusi\' ><td>'+(i+1)+'</td><td>'+item.kode+'<br>'+item.pasien_kode+'<br>'+item.nama+'</td><td>'+item.tgl_masuk+'</td><td>'+item.tgl_pulang+'</td><td>'+tgl_checkout+'</td><td>'+tgl_closing+'</td><td>'+poliList+'</td><td>'+formatRupiah(item.estimasi)+'</td><td>'+button_coding+'</td></tr>';
               
        
        
      });
    }else{
      trHTML +='<tr><td colspan=\'9\' style=\'text-align:center\'>Data tidak tersedia / mohon pilih tanggal yang sesuai</td></tr>';
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
  
}


")
?>
<div class="row">
  <div class="col-lg-12">
    <div class="card card-primary card-outline">
      <div class="card-body">
        <h3><?= Html::encode($this->title) ?></h3>

        <div class="layanan-search">

          <div class="row">
            <div class="col-lg-3">
              <label>Pencarian Pasien</label>
              <?= Html::textInput('nama_input', null, ['id' => 'cari', 'class' => 'form-control', 'placeholder' => 'Cari nama pasien, nomor rekam medis atau registrasi']) ?>
            </div>
            <div class="col-lg-2">
              <label>Tgl. Plg Resume Medis</label>
              <?= DatePicker::widget([
                'name' => 'tanggal',
                'id' => 'tanggal',
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
              <label>Ruangan</label>
              <?= Select2::widget([
                'name' => 'state_10',
                'id' => 'unit_kode',
                'data' => HelperSpesialClass::getListRuangan()['unit_akses'],
                'options' => [
                  'placeholder' => 'Pilih Ruangan ...',

                ],

              ]); ?>
            </div>
            <div class="col-lg-2 d-flex align-items-end">
              <button id="search" class="btn btn-info">Cari</button>
              <button id="reset" class="btn btn-danger">Reset</button>
            </div>



          </div>

        </div>
        <br>


        <table id="example1" class="table table-striped">
          <thead>
            <tr style="background-color: #0BB783;color: white;">
              <th width="5%">No</th>
              <th width="10%">No Daftar</th>

              <th width="10%">Tgl. Masuk</th>
              <th width="10%">Tgl. Pulang Pasien (Resume)</th>

              <th width="10%">Tgl. Checkout Perawat</th>

              <th width="10%">Tgl. Closing Adm Ranap</th>

              <th width="15%">Poli/Unit Terakhir</th>
              <th width="15%">Estimasi Claim Bpjs (Rp.)</th>




              <th width="15%">Aksi</th>
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

<div id="log-peminjaman" class="modal fade" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Claim BPJS Rawat Inap</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div id="log-detail"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<?php

?>
<script>
  function updateClaim(id) {
    // Tampilkan modal
    $('#log-peminjaman').modal('show');

    // Kosongkan konten sebelumnya
    $('#log-detail').html('');
    // Muat konten log dari server
    $.ajax({
      url: '<?= Url::to(['/casemix/claim-ranap']) ?>', // URL endpoint untuk mengambil data log
      type: 'GET',
      data: {
        id: id
      }, // Kirim ID peminjaman_rekam_medis
      success: function(response) {
        // Masukkan respon ke dalam modal
        $('#log-detail').html(response);

        $('#claim-simpan').on('click', function(e) {
          e.preventDefault();
          // Serialize form data
          var form = $('#claim-CodingClaim'); // ID dari form
          var formData = form.serializeArray(); // Mengambil data formulir sebagai array
          var urlSimpan = $(this).data('url');

          $.ajax({
            url: urlSimpan,
            type: 'post',
            dataType: 'json',
            data: $.param(formData),
            success: function(result) {
              if (result.status) {
                toastr.success(result.msg);
                setTimeout(function() {
                  window.location.reload();
                }, 2000);
              } else {
                handleErrors(result.msg);
              }
            },
            error: function(xhr, status, error) {
              toastr.error('Terjadi kesalahan saat mengirim data. Silakan coba lagi.');
              $('body').removeClass('loading');
              $('#btn-loading-analisa').hide();
            },
            complete: function() {
              // Reset button and loading state
              btn.html(originalBtnHtml);
              $('body').removeClass('loading');
              $('#btn-loading-analisa').hide();
            }
          });

          return false; // Prevent default form submission
        }).submit(function(e) {
          e.preventDefault();
        });

      },
      error: function() {
        // Tampilkan pesan error jika gagal memuat
        $('#log-detail').html('<div class="alert alert-danger">Gagal memuat log. Silakan coba lagi.</div>');
      }
    });
  }
</script>