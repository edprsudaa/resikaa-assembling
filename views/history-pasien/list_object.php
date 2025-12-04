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


$this->title = 'Riwayat Pasien Berdasarkan Dokumen';


$this->registerJs('
    var links = document.querySelectorAll(".nav-tabs a");
		var iframes = document.querySelectorAll(".tab-content iframe");
        links[0].classList.add("active");
      
        document.getElementById("custom-tabs-two-0").classList.add("show", "active");
        document.getElementById("iframe-0").setAttribute("src", links[0].getAttribute("data-href"));
        
		links.forEach(function(link, index) {
			link.addEventListener("click", function(event) {
				event.preventDefault();
				var url = link.getAttribute("data-href");
				iframes[index].setAttribute("src", url);
			});
		});
       
  
    ');
$this->registerCss(' .fixed-card {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        z-index: 999;
    }')

?>

<div class="card card-primary card-outline">
    <?php
    if ($versi == 1) {
    ?>
        <div class="row">
            <div class="col-lg-12">
                <div class="card bg-info text-white fixed-card">

                    <div class="card-body">
                        <div class="row">

                            <div class="col-lg-12">
                                <div class="col-lg-12">
                                    <div class="row">
                                        <div class="col-lg-3">
                                            <h6 class="mt-0">No.RM:</h6>

                                            <h6 class="mt-0 text-white"><b><?php echo $pasien['kode'] ?? '-'; ?></b></h6>
                                        </div>
                                        <div class="col-lg-3">
                                            <h6 class="mt-0">Identitas:</h6>
                                            <h6 class="mt-0 text-white"><b><?php echo $pasien['no_identitas'] ?? '-'; ?></b></h6>
                                        </div>
                                        <div class="col-lg-3">
                                            <h6 class="mt-0">Gender:</h6>
                                            <h6 class="mt-0 text-white"><b><?= isset($pasien['jkel']) ? ($pasien['jkel'] == 'p' ? 'WANITA' : 'PRIA') : '-'; ?></b></h6>
                                        </div>
                                        <div class="col-lg-3">
                                            <h6 class="mt-0">Umur Saat ini:</h6>
                                            <h6 class="mt-0 text-white"><b>
                                                    <?php
                                                    $umur = isset($pasien['tgl_lahir']) ? HelperGeneralClass::getUmur($pasien['tgl_lahir'], date('Y-m-d')) : ['th' => 0, 'bl' => 0, 'hr' => 0];
                                                    echo $umur['th'] . ' TH ' . $umur['bl'] . ' BL ' . $umur['hr'] . ' HR';
                                                    ?>
                                                </b></h6>

                                        </div>

                                    </div>
                                    <div class="row">
                                        <div class="col-lg-3">
                                            <h6 class="mt-0">Nama:</h6>
                                            <h6 class="mt-0 text-white"><b><?= $pasien['nama'] ?? '-'; ?></b></h6>
                                        </div>
                                        <div class="col-lg-3">
                                            <h6 class="mt-0">Tempat Lahir:</h6>
                                            <h6 class="mt-0 text-white"><b><?= $pasien['tempat_lahir'] ?? '-'; ?></b></h6>
                                        </div>
                                        <div class="col-lg-3">
                                            <h6 class="mt-0">Tgl. Lahir:</h6>
                                            <h6 class="mt-0 text-white"><b><?= isset($pasien['tgl_lahir']) ? HelperGeneralClass::getDateFormatToIndo($pasien['tgl_lahir'], false) : '-'; ?></b></h6>
                                        </div>
                                        <div class="col-lg-3">
                                            <h6 class="mt-0">Alamat:</h6>
                                            <h6 class="mt-0 text-white"><b><?= $pasien['alamat'] ?? '-'; ?></b></h6>
                                        </div>



                                    </div>

                                </div>

                            </div>
                        </div>
                    </div> <!-- end card-body -->
                </div>
            </div>
        </div>
    <?php }  ?>

    <div class="col-12 col-sm-12" <?php
                                    if ($versi == 1) {
                                    ?>style="margin-top: 150px;" <?php } else { ?>style="margin-top: 10px;" <?php } ?>>
        <div class="card card-info card-tabs">
            <div class="card-header p-0 pt-1">
                <ul class="nav nav-tabs" id="custom-tabs-two-tab" role="tablist">

                    <li class="nav-item">
                        <a class="nav-link active" id="custom-tabs-two-tab-0" data-toggle="pill" data-href=<?= Url::to(["history-pasien/detail-asesmen-keperawatan?id=" . (HelperGeneralClass::hashData($pasien['kode'] ?? '-'))]) ?> href="#custom-tabs-two-0" role="tab" aria-controls="custom-tabs-two-0" aria-selected="false">
                            ASESMEN AWAL KEPERAWATAN

                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="custom-tabs-two-tab-1" data-toggle="pill" data-href=<?= Url::to(["history-pasien/detail-asesmen-kebidanan?id=" . (HelperGeneralClass::hashData($pasien['kode'] ?? '-'))]) ?> href="#custom-tabs-two-1" role="tab" aria-controls="custom-tabs-two-1" aria-selected="false">
                            ASESMEN AWAL KEBIDANAN

                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" id="custom-tabs-two-tab-2" data-toggle="pill" data-href=<?= Url::to(["history-pasien/detail-asesmen-medis?id=" . (HelperGeneralClass::hashData($pasien['kode'] ?? '-'))]) ?> href="#custom-tabs-two-2" role="tab" aria-controls="custom-tabs-two-2" aria-selected="false">
                            ASESMEN AWAL MEDIS

                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="custom-tabs-two-tab-3" data-toggle="pill" data-href=<?= Url::to(["history-pasien/detail-hasil-penunjang?id=" . (HelperGeneralClass::hashData($pasien['kode'] ?? '-'))]) ?> href="#custom-tabs-two-3" role="tab" aria-controls="custom-tabs-two-3" aria-selected="false">
                            HASIL PENUNJANG (Laboratorium, Radiologi Dll)
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="custom-tabs-two-tab-4" data-toggle="pill" data-href=<?= Url::to(["history-pasien/detail-laporan-operasi?id=" . (HelperGeneralClass::hashData($pasien['kode'] ?? '-'))]) ?> href="#custom-tabs-two-4" role="tab" aria-controls="custom-tabs-two-4" aria-selected="false">
                            LAPORAN OPERASI

                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="custom-tabs-two-tab-5" data-toggle="pill" data-href=<?= Url::to(["history-pasien/detail-laporan-anastesi?id=" . (HelperGeneralClass::hashData($pasien['kode'] ?? '-'))]) ?> href="#custom-tabs-two-5" role="tab" aria-controls="custom-tabs-two-5" aria-selected="false">
                            LAPORAN ANASTESI

                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" id="custom-tabs-two-tab-6" data-toggle="pill" data-href=<?= Url::to(["history-pasien/detail-cppt?id=" . (HelperGeneralClass::hashData($pasien['kode'] ?? '-'))]) ?> href="#custom-tabs-two-6" role="tab" aria-controls="custom-tabs-two-6" aria-selected="false">
                            CPPT

                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="custom-tabs-two-tab-7" data-toggle="pill" data-href=<?= Url::to(["history-pasien/detail-resume-rawat-inap?id=" . (HelperGeneralClass::hashData($pasien['kode'] ?? '-'))]) ?> href="#custom-tabs-two-7" role="tab" aria-controls="custom-tabs-two-7" aria-selected="false">
                            RESUME MEDIS RAWATINAP

                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="custom-tabs-two-tab-8" data-toggle="pill" data-href=<?= Url::to(["history-pasien/detail-riwayat-konsultasi?id=" . (HelperGeneralClass::hashData($pasien['kode'] ?? '-'))]) ?> href="#custom-tabs-two-8" role="tab" aria-controls="custom-tabs-two-8" aria-selected="false">
                            RIWAYAT KONSULTASI

                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="custom-tabs-two-tab-9" data-toggle="pill" data-href=<?= Url::to(["history-pasien/detail-resume-rawat-jalan?id=" . (HelperGeneralClass::hashData($pasien['kode'] ?? '-'))]) ?> href="#custom-tabs-two-9" role="tab" aria-controls="custom-tabs-two-9" aria-selected="false">
                            RESUME MEDIS RAWATJALAN

                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="custom-tabs-two-tab-10" data-toggle="pill" data-href=<?= Url::to(["history-pasien/detail-resep-obat?id=" . (HelperGeneralClass::hashData($pasien['kode'] ?? '-'))]) ?> href="#custom-tabs-two-10" role="tab" aria-controls="custom-tabs-two-10" aria-selected="false">
                            RESEP OBAT

                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="custom-tabs-two-tab-11" data-toggle="pill" data-href=<?= Url::to(["history-pasien/detail-obat-terjual?id=" . (HelperGeneralClass::hashData($pasien['kode'] ?? '-'))]) ?> href="#custom-tabs-two-11" role="tab" aria-controls="custom-tabs-two-11" aria-selected="false">
                            OBAT TERJUAL

                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="custom-tabs-two-tab-12" data-toggle="pill" data-href=<?= Url::to(["history-pasien/detail-rincian-biaya?id=" . (HelperGeneralClass::hashData($pasien['kode'] ?? '-'))]) ?> href="#custom-tabs-two-12" role="tab" aria-controls="custom-tabs-two-12" aria-selected="false">
                            RINCIAN BIAYA

                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="custom-tabs-two-tab-13" data-toggle="pill" data-href=<?= Url::to(["history-pasien/detail-laporan-checklist-keselamatan?id=" . (HelperGeneralClass::hashData($pasien['kode'] ?? '-'))]) ?> href="#custom-tabs-two-13" role="tab" aria-controls="custom-tabs-two-13" aria-selected="false">
                            LAPORAN CHECKLIST KESELAMATAN

                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="custom-tabs-two-tab-14" data-toggle="pill" data-href=<?= Url::to(["history-pasien/detail-laporan-marking-operasi?id=" . (HelperGeneralClass::hashData($pasien['kode'] ?? '-'))]) ?> href="#custom-tabs-two-14" role="tab" aria-controls="custom-tabs-two-14" aria-selected="false">
                            LAPORAN MARKING OPERASI
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="custom-tabs-two-tab-15" data-toggle="pill" data-href=<?= Url::to(["history-pasien/detail-laporan-pembatalan-operasi?id=" . (HelperGeneralClass::hashData($pasien['kode'] ?? '-'))]) ?> href="#custom-tabs-two-15" role="tab" aria-controls="custom-tabs-two-15" aria-selected="false">
                            LAPORAN PEMBATALAN OPERASI
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="custom-tabs-two-tab-16" data-toggle="pill" data-href=<?= Url::to(["history-pasien/detail-laporan-askan-intra-operasi?id=" . (HelperGeneralClass::hashData($pasien['kode'] ?? '-'))]) ?> href="#custom-tabs-two-16" role="tab" aria-controls="custom-tabs-two-16" aria-selected="false">
                            LAPORAN INTRA OPERASI
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="custom-tabs-two-tab-17" data-toggle="pill" data-href=<?= Url::to(["history-pasien/detail-laporan-post-operasi?id=" . (HelperGeneralClass::hashData($pasien['kode'] ?? '-'))]) ?> href="#custom-tabs-two-17" role="tab" aria-controls="custom-tabs-two-17" aria-selected="false">
                            LAPORAN POST OPERASI
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="custom-tabs-two-tab-18" data-toggle="pill" data-href=<?= Url::to(["history-pasien/detail-laporan-instrument-kasa?id=" . (HelperGeneralClass::hashData($pasien['kode'] ?? '-'))]) ?> href="#custom-tabs-two-18" role="tab" aria-controls="custom-tabs-two-18" aria-selected="false">
                            LAPORAN INTRUMENT DAN KASA
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="custom-tabs-two-tab-19" data-toggle="pill" data-href=<?= Url::to(["history-pasien/detail-laporan-askep-pre-operasi-perawat?id=" . (HelperGeneralClass::hashData($pasien['kode'] ?? '-'))]) ?> href="#custom-tabs-two-19" role="tab" aria-controls="custom-tabs-two-19" aria-selected="false">
                            LAPORAN ASKEP PRE OPERASI PERAWAT
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="custom-tabs-two-tab-20" data-toggle="pill" data-href=<?= Url::to(["history-pasien/detail-laporan-lembar-edukasi-anestesi?id=" . (HelperGeneralClass::hashData($pasien['kode'] ?? '-'))]) ?> href="#custom-tabs-two-20" role="tab" aria-controls="custom-tabs-two-20" aria-selected="false">
                            LAPORAN LEMBAR EDUKASI ANESTESI
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="custom-tabs-two-tab-21" data-toggle="pill" data-href=<?= Url::to(["history-pasien/detail-laporan-pra-anestesi?id=" . (HelperGeneralClass::hashData($pasien['kode'] ?? '-'))]) ?> href="#custom-tabs-two-21" role="tab" aria-controls="custom-tabs-two-21" aria-selected="false">
                            LAPORAN PRA ANESTESI
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="custom-tabs-two-tab-22" data-toggle="pill" data-href=<?= Url::to(["history-pasien/detail-laporan-catatan-lokal-anestesi?id=" . (HelperGeneralClass::hashData($pasien['kode'] ?? '-'))]) ?> href="#custom-tabs-two-22" role="tab" aria-controls="custom-tabs-two-22" aria-selected="false">
                            LAPORAN CATATAN LOKAL ANESTESI
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="custom-tabs-two-tab-23" data-toggle="pill" data-href=<?= Url::to(["history-pasien/detail-laporan-pasca-lokal-anestesi?id=" . (HelperGeneralClass::hashData($pasien['kode'] ?? '-'))]) ?> href="#custom-tabs-two-23" role="tab" aria-controls="custom-tabs-two-23" aria-selected="false">
                            LAPORAN PASCA LOKAL ANESTESI
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="custom-tabs-two-tab-24" data-toggle="pill" data-href=<?= Url::to(["history-pasien/detail-laporan-asuhan-kepenataan-pra-anestesi?id=" . (HelperGeneralClass::hashData($pasien['kode'] ?? '-'))]) ?> href="#custom-tabs-two-24" role="tab" aria-controls="custom-tabs-two-24" aria-selected="false">
                            LAPORAN ASUHAN KEPENATAAN PRA ANESTESI
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="custom-tabs-two-tab-25" data-toggle="pill" data-href=<?= Url::to(["history-pasien/detail-laporan-asuhan-kepenataan-intra-anestesi?id=" . (HelperGeneralClass::hashData($pasien['kode'] ?? '-'))]) ?> href="#custom-tabs-two-25" role="tab" aria-controls="custom-tabs-two-25" aria-selected="false">
                            LAPORAN ASUHAN KEPENATAAN INTRA ANESTESI
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="custom-tabs-two-tab-26" data-toggle="pill" data-href=<?= Url::to(["history-pasien/detail-laporan-asuhan-kepenataan-pasca-anestesi?id=" . (HelperGeneralClass::hashData($pasien['kode'] ?? '-'))]) ?> href="#custom-tabs-two-26" role="tab" aria-controls="custom-tabs-two-26" aria-selected="false">
                            LAPORAN ASUHAN KEPENATAAN PASCA ANESTESI
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="custom-tabs-two-tab-27" data-toggle="pill" data-href=<?= Url::to(["history-pasien/detail-esep?id=" . (HelperGeneralClass::hashData($pasien['kode'] ?? '-'))]) ?> href="#custom-tabs-two-27" role="tab" aria-controls="custom-tabs-two-27" aria-selected="false">
                            E-SEP
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="custom-tabs-two-tab-28" data-toggle="pill" data-href=<?= Url::to(["history-pasien/detail-ringkasan-pulang-igd?id=" . (HelperGeneralClass::hashData($pasien['kode'] ?? '-'))]) ?> href="#custom-tabs-two-28" role="tab" aria-controls="custom-tabs-two-28" aria-selected="false">
                            RINGKASAN PULANG IGD
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="custom-tabs-two-tab-29" data-toggle="pill" data-href=<?= Url::to(["history-pasien/detail-triase-igd?id=" . (HelperGeneralClass::hashData($pasien['kode'] ?? '-'))]) ?> href="#custom-tabs-two-29" role="tab" aria-controls="custom-tabs-two-29" aria-selected="false">
                            TRIASE IGD
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" id="custom-tabs-two-tab-30" data-toggle="pill" data-href=<?= Url::to(["history-pasien/detail-monitoring-ttv?id=" . (HelperGeneralClass::hashData($pasien['kode'] ?? '-'))]) ?> href="#custom-tabs-two-30" role="tab" aria-controls="custom-tabs-two-30" aria-selected="false">
                            MONITORING TTV
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="custom-tabs-two-tab-31" data-toggle="pill" data-href=<?= Url::to(["history-pasien/detail-asesmen-hd-awal?id=" . (HelperGeneralClass::hashData($pasien['kode'] ?? '-'))]) ?> href="#custom-tabs-two-31" role="tab" aria-controls="custom-tabs-two-31" aria-selected="false">
                            ASESMEN AWAL HEMODIALISA
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="custom-tabs-two-tab-32" data-toggle="pill" data-href=<?= Url::to(["history-pasien/detail-asesmen-hd-awal-lanjutan?id=" . (HelperGeneralClass::hashData($pasien['kode'] ?? '-'))]) ?> href="#custom-tabs-two-32" role="tab" aria-controls="custom-tabs-two-32" aria-selected="false">
                            ASESMEN AWAL HEMODIALISA LANJUTAN
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="custom-tabs-two-tab-33" data-toggle="pill" data-href=<?= Url::to(["history-pasien/detail-asesmen-hd-keperawatan?id=" . (HelperGeneralClass::hashData($pasien['kode'] ?? '-'))]) ?> href="#custom-tabs-two-33" role="tab" aria-controls="custom-tabs-two-33" aria-selected="false">
                            ASESMEN HEMODIALISA KEPERAWATAN
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="custom-tabs-two-tab-34" data-toggle="pill" data-href=<?= Url::to(["history-pasien/detail-resume-rehab-medik?id=" . (HelperGeneralClass::hashData($pasien['kode'] ?? '-'))]) ?> href="#custom-tabs-two-34" role="tab" aria-controls="custom-tabs-two-34" aria-selected="false">
                            RESUME REHAB MEDIK
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="custom-tabs-two-tab-35" data-toggle="pill" data-href=<?= Url::to(["history-pasien/detail-asesmen-rehab-medik?id=" . (HelperGeneralClass::hashData($pasien['kode'] ?? '-'))]) ?> href="#custom-tabs-two-35" role="tab" aria-controls="custom-tabs-two-35" aria-selected="false">
                            ASESMEN REHAB MEDIK
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="custom-tabs-two-tab-36" data-toggle="pill" data-href=<?= Url::to(["history-pasien/detail-resep-dokter-terbaru?id=" . (HelperGeneralClass::hashData($pasien['kode'] ?? '-'))]) ?> href="#custom-tabs-two-36" role="tab" aria-controls="custom-tabs-two-36" aria-selected="false">
                            RESEP DOKTER VERSI TERBARU
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="custom-tabs-two-tab-37" data-toggle="pill" data-href=<?= Url::to(["history-pasien/detail-surat-penetapan-dirawat?id=" . (HelperGeneralClass::hashData($pasien['kode'] ?? '-'))]) ?> href="#custom-tabs-two-37" role="tab" aria-controls="custom-tabs-two-37" aria-selected="false">
                            SURAT PENETAPAN DIRAWAT
                        </a>
                    </li>

                </ul>
            </div>
            <div class="card-body">
                <div class="tab-content" id="custom-tabs-two-tabContent">
                    <div class="tab-pane fade 'show active" id="custom-tabs-two-0" role="tabpanel" aria-labelledby="custom-tabs-two-tab-0">
                        <iframe width="100%" style="height:1000px" id="iframe-0">

                        </iframe>
                    </div>
                    <div class="tab-pane fade" id="custom-tabs-two-1" role="tabpanel" aria-labelledby="custom-tabs-two-tab-1">
                        <iframe width="100%" style="height:1000px" id="iframe-0">

                        </iframe>
                    </div>
                    <div class="tab-pane fade" id="custom-tabs-two-2" role="tabpanel" aria-labelledby="custom-tabs-two-tab-2">
                        <iframe width="100%" style="height:1000px" id="iframe-0">

                        </iframe>
                    </div>
                    <div class="tab-pane fade" id="custom-tabs-two-3" role="tabpanel" aria-labelledby="custom-tabs-two-tab-3">
                        <iframe width="100%" style="height:1000px" id="iframe-0">

                        </iframe>
                    </div>
                    <div class="tab-pane fade" id="custom-tabs-two-4" role="tabpanel" aria-labelledby="custom-tabs-two-tab-4">
                        <iframe width="100%" style="height:1000px" id="iframe-0">

                        </iframe>
                    </div>
                    <div class="tab-pane fade" id="custom-tabs-two-5" role="tabpanel" aria-labelledby="custom-tabs-two-tab-5">
                        <iframe width="100%" style="height:1000px" id="iframe-0">

                        </iframe>
                    </div>
                    <div class="tab-pane fade" id="custom-tabs-two-6" role="tabpanel" aria-labelledby="custom-tabs-two-tab-6">
                        <iframe width="100%" style="height:1000px" id="iframe-0">

                        </iframe>
                    </div>
                    <div class="tab-pane fade" id="custom-tabs-two-7" role="tabpanel" aria-labelledby="custom-tabs-two-tab-7">
                        <iframe width="100%" style="height:1000px" id="iframe-0">

                        </iframe>
                    </div>
                    <div class="tab-pane fade" id="custom-tabs-two-8" role="tabpanel" aria-labelledby="custom-tabs-two-tab-8">
                        <iframe width="100%" style="height:1000px" id="iframe-0">

                        </iframe>
                    </div>
                    <div class="tab-pane fade" id="custom-tabs-two-9" role="tabpanel" aria-labelledby="custom-tabs-two-tab-9">
                        <iframe width="100%" style="height:1000px" id="iframe-0">

                        </iframe>
                    </div>
                    <div class="tab-pane fade" id="custom-tabs-two-10" role="tabpanel" aria-labelledby="custom-tabs-two-tab-10">
                        <iframe width="100%" style="height:1000px" id="iframe-0">

                        </iframe>
                    </div>
                    <div class="tab-pane fade" id="custom-tabs-two-11" role="tabpanel" aria-labelledby="custom-tabs-two-tab-11">
                        <iframe width="100%" style="height:1000px" id="iframe-0">

                        </iframe>
                    </div>
                    <div class="tab-pane fade" id="custom-tabs-two-12" role="tabpanel" aria-labelledby="custom-tabs-two-tab-12">
                        <iframe width="100%" style="height:1000px" id="iframe-0">

                        </iframe>
                    </div>
                    <div class="tab-pane fade" id="custom-tabs-two-13" role="tabpanel" aria-labelledby="custom-tabs-two-tab-13">
                        <iframe width="100%" style="height:1000px" id="iframe-0">

                        </iframe>
                    </div>
                    <div class="tab-pane fade" id="custom-tabs-two-14" role="tabpanel" aria-labelledby="custom-tabs-two-tab-14">
                        <iframe width="100%" style="height:1000px" id="iframe-0">

                        </iframe>
                    </div>
                    <div class="tab-pane fade" id="custom-tabs-two-15" role="tabpanel" aria-labelledby="custom-tabs-two-tab-15">
                        <iframe width="100%" style="height:1000px" id="iframe-0">

                        </iframe>
                    </div>
                    <div class="tab-pane fade" id="custom-tabs-two-16" role="tabpanel" aria-labelledby="custom-tabs-two-tab-16">
                        <iframe width="100%" style="height:1000px" id="iframe-0">

                        </iframe>
                    </div>
                    <div class="tab-pane fade" id="custom-tabs-two-17" role="tabpanel" aria-labelledby="custom-tabs-two-tab-17">
                        <iframe width="100%" style="height:1000px" id="iframe-0">

                        </iframe>
                    </div>
                    <div class="tab-pane fade" id="custom-tabs-two-18" role="tabpanel" aria-labelledby="custom-tabs-two-tab-18">
                        <iframe width="100%" style="height:1000px" id="iframe-0">

                        </iframe>
                    </div>

                    <div class="tab-pane fade" id="custom-tabs-two-19" role="tabpanel" aria-labelledby="custom-tabs-two-tab-19">
                        <iframe width="100%" style="height:1000px" id="iframe-0">

                        </iframe>
                    </div>
                    <div class="tab-pane fade" id="custom-tabs-two-20" role="tabpanel" aria-labelledby="custom-tabs-two-tab-20">
                        <iframe width="100%" style="height:1000px" id="iframe-0">

                        </iframe>
                    </div>
                    <div class="tab-pane fade" id="custom-tabs-two-21" role="tabpanel" aria-labelledby="custom-tabs-two-tab-21">
                        <iframe width="100%" style="height:1000px" id="iframe-0">

                        </iframe>
                    </div>
                    <div class="tab-pane fade" id="custom-tabs-two-22" role="tabpanel" aria-labelledby="custom-tabs-two-tab-22">
                        <iframe width="100%" style="height:1000px" id="iframe-0">

                        </iframe>
                    </div>
                    <div class="tab-pane fade" id="custom-tabs-two-23" role="tabpanel" aria-labelledby="custom-tabs-two-tab-23">
                        <iframe width="100%" style="height:1000px" id="iframe-0">

                        </iframe>
                    </div>
                    <div class="tab-pane fade" id="custom-tabs-two-24" role="tabpanel" aria-labelledby="custom-tabs-two-tab-24">
                        <iframe width="100%" style="height:1000px" id="iframe-0">

                        </iframe>
                    </div>
                    <div class="tab-pane fade" id="custom-tabs-two-25" role="tabpanel" aria-labelledby="custom-tabs-two-tab-25">
                        <iframe width="100%" style="height:1000px" id="iframe-0">

                        </iframe>
                    </div>
                    <div class="tab-pane fade" id="custom-tabs-two-26" role="tabpanel" aria-labelledby="custom-tabs-two-tab-26">
                        <iframe width="100%" style="height:1000px" id="iframe-0">

                        </iframe>
                    </div>
                    <div class="tab-pane fade" id="custom-tabs-two-27" role="tabpanel" aria-labelledby="custom-tabs-two-tab-27">
                        <iframe width="100%" style="height:1000px" id="iframe-0">

                        </iframe>
                    </div>
                    <div class="tab-pane fade" id="custom-tabs-two-28" role="tabpanel" aria-labelledby="custom-tabs-two-tab-28">
                        <iframe width="100%" style="height:1000px" id="iframe-0">

                        </iframe>
                    </div>
                    <div class="tab-pane fade" id="custom-tabs-two-29" role="tabpanel" aria-labelledby="custom-tabs-two-tab-29">
                        <iframe width="100%" style="height:1000px" id="iframe-0">

                        </iframe>
                    </div>
                    <div class="tab-pane fade" id="custom-tabs-two-30" role="tabpanel" aria-labelledby="custom-tabs-two-tab-30">
                        <iframe width="100%" style="height:1000px" id="iframe-0">

                        </iframe>
                    </div>
                    <div class="tab-pane fade" id="custom-tabs-two-31" role="tabpanel" aria-labelledby="custom-tabs-two-tab-31">
                        <iframe width="100%" style="height:1000px" id="iframe-0">

                        </iframe>
                    </div>
                    <div class="tab-pane fade" id="custom-tabs-two-32" role="tabpanel" aria-labelledby="custom-tabs-two-tab-32">
                        <iframe width="100%" style="height:1000px" id="iframe-0">

                        </iframe>
                    </div>
                    <div class="tab-pane fade" id="custom-tabs-two-33" role="tabpanel" aria-labelledby="custom-tabs-two-tab-33">
                        <iframe width="100%" style="height:1000px" id="iframe-0">

                        </iframe>
                    </div>
                    <div class="tab-pane fade" id="custom-tabs-two-34" role="tabpanel" aria-labelledby="custom-tabs-two-tab-34">
                        <iframe width="100%" style="height:1000px" id="iframe-0">

                        </iframe>
                    </div>
                    <div class="tab-pane fade" id="custom-tabs-two-35" role="tabpanel" aria-labelledby="custom-tabs-two-tab-35">
                        <iframe width="100%" style="height:1000px" id="iframe-0">

                        </iframe>
                    </div>
                    <div class="tab-pane fade" id="custom-tabs-two-36" role="tabpanel" aria-labelledby="custom-tabs-two-tab-36">
                        <iframe width="100%" style="height:1000px" id="iframe-0">

                        </iframe>
                    </div>
                    <div class="tab-pane fade" id="custom-tabs-two-37" role="tabpanel" aria-labelledby="custom-tabs-two-tab-37">
                        <iframe width="100%" style="height:1000px" id="iframe-0">

                        </iframe>
                    </div>
                </div>
            </div>

        </div>
    </div>


</div>
<?php
