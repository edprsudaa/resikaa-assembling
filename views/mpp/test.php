<?php

use yii\helpers\Html;
use yii\grid\GridView;
use kartik\date\DatePicker;
use app\components\HelperGeneralClass;
use app\components\HelperSpesialClass;

$this->title = 'Daftar Pasien Rawatjalan ';
$this->params['breadcrumbs'][] = $this->title;
$userLogin = HelperSpesialClass::getUserLogin();
?>
<script>
    function myFunction() {
        var input, filter, table, tr, td, i, txtValue;
        input = document.getElementById("myInput");
        filter = input.value.toUpperCase();
        table = document.getElementById("myTable");
        tr = table.getElementsByTagName("tr");
        for (i = 0; i < tr.length; i++) {
            td = tr[i].getElementsByTagName("td")[0];
            if (td) {
                txtValue = td.textContent || td.innerText;
                if (txtValue.toUpperCase().indexOf(filter) > -1) {
                    tr[i].style.display = "";
                } else {
                    tr[i].style.display = "none";
                }
            }
        }
    }

    function myUnit() {
        var input, filter, table, tr, td, i, txtValue;
        input = document.getElementById("myUnit");
        filter = input.value.toUpperCase();
        table = document.getElementById("myTable");
        tr = table.getElementsByTagName("tr");
        for (i = 0; i < tr.length; i++) {
            td = tr[i].getElementsByTagName("td")[3];
            if (td) {
                txtValue = td.textContent || td.innerText;
                if (txtValue.toUpperCase().indexOf(filter) > -1) {
                    tr[i].style.display = "";
                } else {
                    tr[i].style.display = "none";
                }
            }
        }
    }
</script>
<?php
// echo '<pre>';
// print_r($dataNew);
// echo '</pre>';
// die;
?>

<div class="row">
    <div class="col-lg-12">
        <div class="card card-primary card-outline">
            <div class="card-body">
                <p class="blink"><b>Untuk Pencarian : (harap Perhatikan Tgl.kunjungan/Tgl.Masuk pasien yang mau di entry Catatan MPP nya)</b></p>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="field-registrasisearch-pasien" style="margin-bottom: 10px !important;">

                            <input type="text" id="myInput" onkeyup="myFunction()" class="form-control form-control-md input-sm" name="RegistrasiSearch[pasien]" value="" placeholder="Ketik Nama / NO.MR / NO.REG Pasien Disini..." autofocus="autofocus">
                            <input type="text" id="myUnit" onkeyup="myUnit()" class="form-control form-control-md input-sm" name="RegistrasiSearch[pasien]" value="" placeholder="Ketik Nama / NO.MR / NO.REG Pasien Disini..." autofocus="autofocus">
                            <div class="help-block"></div>
                        </div>
                    </div>

                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="layanan-index">
                            <table class="table table-sm" id="myTable">
                                <thead>
                                    <tr>
                                        <th scope="col">NO</th>
                                        <th scope="col">PASIEN</th>
                                        <th scope="col">TGL.MASUK</th>
                                        <th scope="col">TGL.KELUAR</th>
                                        <th scope="col">UNIT</th>
                                        <th scope="col">Resume Medis</th>
                                        <th scope="col">Catatan MPP</th>

                                        <th scope="col">AKSI</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $no = 1;
                                    foreach ($dataNew as $val) {
                                        // if(strtotime(date('Y-m-d',strtotime($val['tgl_masuk'])))<strtotime(date('Y-m-d')) && in_array($userLogin['username'],['196910132000032002'])){
                                        // break;
                                        // }
                                        $url_pilih = \yii\helpers\Url::to(['catatan', 'id' => HelperGeneralClass::hashData($val['nomor_registrasi']), 'layanan_id' => $val['layanan_id'], 'layanan_nama' => $val['unit']]);
                                        // $url_sbpk = \yii\helpers\Url::to(['/pasien-site/sbpk', 'id' => HelperGeneralClass::hashData($val['layanan_id'])]);
                                        // $url_sbpkv2 = \yii\helpers\Url::to(['/pasien-site/sbpkv2', 'id' => HelperGeneralClass::hashData($val['layanan_id'])]);
                                        $url_mpp = \yii\helpers\Url::to(['detail-mpp-resume-medis', 'id' => HelperGeneralClass::hashData($val['nomor_registrasi']), 'layanan_id' => $val['layanan_id'], 'layanan_nama' => $val['unit']]);

                                    ?>
                                        <tr>
                                            <th scope="row"><?= $no ?></th>
                                            <td><?= $val['nama_pasien'] . '</br>(RM :' . $val['rm_pasien'] . ')' . '</br>(REG :' . $val['nomor_registrasi'] . ')' ?></td>
                                            <td>
                                                <?php
                                                if (strtotime(date('Y-m-d', strtotime($val['tgl_masuk']))) < strtotime(date('Y-m-d'))) {
                                                ?>
                                                    <p style="color:#dd5873;"><?= date('d-m-Y H:i:s', strtotime($val['tgl_masuk'])) ?></p>
                                                <?php
                                                } else {
                                                ?>
                                                    <b><?= date('d-m-Y H:i:s', strtotime($val['tgl_masuk'])) ?></b>
                                                <?php
                                                }
                                                ?>
                                            </td>
                                            <td>
                                                <?php

                                                if ($val['tgl_keluar'] != null) {

                                                    if (strtotime(date('Y-m-d', strtotime($val['tgl_keluar']))) < strtotime(date('Y-m-d'))) {
                                                ?>
                                                        <p style="color:#dd5873;"><?= date('d-m-Y H:i:s', strtotime($val['tgl_keluar'])) ?></p>
                                                    <?php
                                                    } else {
                                                    ?>
                                                        <b><?= date('d-m-Y H:i:s', strtotime($val['tgl_keluar'])) ?></b>
                                                    <?php
                                                    }
                                                } else { ?>
                                                    <b><?= 'Masih dirawat' ?></b>
                                                <?php
                                                }
                                                ?>
                                            </td>
                                            <td><?= $val['unit'] ?? '' ?></td>
                                            <td>
                                                <?php

                                                if (!empty($val['resume_jumlah'])) {

                                                ?>
                                                    <b><?= 'Sudah Ada Resume' ?></b>
                                                <?php

                                                } else { ?>
                                                    <p style="color:#dd5873;">Belum ada Resume</p>


                                                <?php
                                                }
                                                ?>
                                            </td>
                                            <td>
                                                <?php

                                                if (!empty($val['catatan'])) {

                                                ?>
                                                    <b><?= 'Sudah Catatan Mpp' ?></b>
                                                <?php

                                                } else { ?>
                                                    <p style="color:#dd5873;">Belum ada Catatan</p>


                                                <?php
                                                }
                                                ?>
                                            </td>
                                            <td>
                                                <a class="btn btn-success btn-xs" href=<?= $url_pilih ?>><span class="nav-icon fas fa-edit text-white" title="" data-toggle="tooltip" data-placement="bottom" data-original-title="Pilih Pasien"> Pilih Pasien</span></a>
                                                <!-- <a class="btn btn-danger btn-xs" href=<?php // $url_mpp 
                                                                                            ?>><span class="nav-icon fas fa-edit text-white" title="" data-toggle="tooltip" data-placement="bottom" data-original-title="Pilih Pasien"> Update Resume</span></a> -->

                                            </td>
                                        </tr>
                                    <?php
                                        $no++;
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div> <!-- end col -->
                </div>
            </div>
        </div>
    </div>
</div>