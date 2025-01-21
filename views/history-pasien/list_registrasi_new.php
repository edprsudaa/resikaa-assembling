<?php

use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\widgets\Pjax;
use yii\grid\GridView;
use kartik\date\DatePicker;
use kartik\select2\Select2;
use app\components\HelperSpesialClass;
use app\components\HelperGeneralClass;
use yii\web\View;


$this->title = 'Daftar Kunjungan Pasien ' . ($pasien != NULL ? '<b>' . $pasien['nama'] . ' (' . $pasien['kode'] . ')</b>' : '');
// echo '<pre>';
// print_r($pasien);
// echo '</pre>';
// die;

$this->registerJs('
$( document ).ready(function() {

    
    var links = document.querySelectorAll(".callout a");
		var iframes = document.querySelectorAll(".tab-content iframe");
        links[0].classList.add("active");
        iframes[0].setAttribute("src", links[0].getAttribute("data-href"));
        
		links.forEach(function(link, index) {
			link.addEventListener("click", function(event) {

				event.preventDefault();
				var url = link.getAttribute("data-href");
				iframes[index].setAttribute("src", url);
                links.forEach(function(link) {
                    link.classList.remove("active");
                  });
                  link[index].classList.add("active");
                document.documentElement.scrollTop = 0;
			}); 
            
		});
       
    });
    ');
$this->registerCss(' .fixed-card {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        z-index: 999;
    }
    

    ');

?>

<div class="card card-primary card-outline">

    <?php
    if ($versi == 1) {
    ?>

        <div class="row">
            <div class="col-lg-12">
                <div class="card bg-info text-white  fixed-card">

                    <div class="card-body">
                        <div class="row">

                            <div class="col-lg-12">
                                <div class="row">
                                    <div class="col-lg-3">
                                        <h6 class="mt-0">No.RM:</h6>

                                        <h6 class="mt-0 text-white"><b><?php echo $pasien['kode']; ?></b></h6>
                                    </div>
                                    <div class="col-lg-3">
                                        <h6 class="mt-0">Identitas:</h6>
                                        <h6 class="mt-0 text-white"><b><?php echo $pasien['no_identitas'] ?? '-'; ?></b></h6>
                                    </div>
                                    <div class="col-lg-3">
                                        <h6 class="mt-0">Gender:</h6>
                                        <h6 class="mt-0 text-white"><b><?php echo ($pasien['jkel'] == 'p' ? 'WANITA' : 'PRIA'); ?></b></h6>
                                    </div>
                                    <div class="col-lg-3">
                                        <h6 class="mt-0">Umur Saat ini:</h6>
                                        <h6 class="mt-0 text-white"><b><?php $umur = HelperGeneralClass::getUmur($pasien['tgl_lahir'], date('Y-m-d'));
                                                                        echo $umur['th'] . ' TH ' . $umur['bl'] . ' BL ' . $umur['hr'] . ' HR' ?? '-'; ?></b></h6>
                                    </div>

                                </div>
                                <div class="row">
                                    <div class="col-lg-3">
                                        <h6 class="mt-0">Nama:</h6>
                                        <h6 class="mt-0 text-white"><b><?php echo $pasien['nama'] ?? '-'; ?></b></h6>
                                    </div>
                                    <div class="col-lg-3">
                                        <h6 class="mt-0">Tempat Lahir:</h6>
                                        <h6 class="mt-0 text-white"><b><?php echo $pasien['tempat_lahir'] ?? '-'; ?></b></h6>
                                    </div>
                                    <div class="col-lg-3">
                                        <h6 class="mt-0">Tgl. Lahir:</h6>
                                        <h6 class="mt-0 text-white"><b><?php echo HelperGeneralClass::getDateFormatToIndo($pasien['tgl_lahir'], false) ?? '-'; ?></b></h6>
                                    </div>
                                    <div class="col-lg-3">
                                        <h6 class="mt-0">Alamat:</h6>
                                        <h6 class="mt-0 text-white"><b><?php echo $pasien['alamat'] ?? '-'; ?></b></h6>
                                    </div>



                                </div>

                            </div>
                        </div>
                    </div> <!-- end card-body -->
                </div>
            </div>
        </div>
    <?php }  ?>

    <div class="row" <?php
                        if ($versi == 1) {
                        ?>style="margin-top: 150px;" <?php } else { ?>style="margin-top: 10px;" <?php } ?>>
        <div class="col-md-3">
            <div class="card table-responsive">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-bullhorn"></i>
                        Daftar Kunjungan
                    </h3>
                </div>
                <div class="card-body" style="height: calc(100vh);overflow-y: auto;">

                    <?php foreach ($registrasi as $key => $item) { ?>
                        <div class=" callout callout-danger">
                            <a class="nav-link bg-info  <?php if ($key == 0) {
                                                            echo 'active';
                                                        } ?>" id="vert-tabs-profile-tab<?= $key ?>" data-toggle="pill" data-href='http://emr-pengolahan-data.simrs.aa/history-pasien/detail-kunjungan?rm=<?= $item["pasien_kode"]; ?>&noreg=<?= $item["kode"]; ?>' href="#vert-tabs-profile<?= $key ?>" role="tab" aria-controls="vert-tabs-profile<?= $key ?>" aria-selected="false">
                                <b>Tgl. Kunjungan : </b><br>
                                <?= $item['tgl_masuk'] ?><br>
                                <b>No. Registrasi :</b><br>
                                <?= $item['kode'] ?><br>
                                <b>Poli / Ruangan :</b><br>
                                <?php
                                $units = array();
                                foreach ($item['layanan'] as $value) {
                                    $unitName = $value['unit']['nama'];
                                    if (!in_array($unitName, $units)) {
                                        $units[] = $unitName;
                                        if ($value['jenis_layanan'] == 1) {
                                            echo '<span class="right badge badge-danger">' . $unitName . '</span>';
                                        } elseif ($value['jenis_layanan'] == 2) {
                                            echo '<span class="right badge badge-info">' . $unitName . '</span>';
                                        } elseif ($value['jenis_layanan'] == 3) {
                                            echo '<span class="right badge badge-success">' . $unitName . '</span>';
                                        } else {
                                            echo '<span class="right badge badge-warning">' . $unitName . '</span>';
                                        }
                                    }
                                } ?>



                            </a>

                        </div>
                    <?php } ?>

                </div>
            </div>
        </div>
        <div class="col-md-9">
            <div class="tab-content" id="vert-tabs-tabContent">
                <?php foreach ($registrasi as $key => $item) { ?>
                    <div class="tab-pane fade <?php if ($key == 0) {
                                                    echo 'show active';
                                                } ?>" id="vert-tabs-profile<?= $key ?>" role="tabpanel" aria-labelledby="vert-tabs-profile-tab<?= $key ?>">
                        <iframe width="100%" style="height: calc(100vh);" id="iframe-<?= $key ?>">

                        </iframe>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>


</div>
<?php
