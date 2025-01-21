<?php
use yii\helpers\Url;
use app\components\HelperSpesial;
use app\models\medis\AsesmenAwalBidanBayiBaruLahir;
use yii\helpers\ArrayHelper;
$model=AsesmenAwalBidanBayiBaruLahir::find()->with(['layanan.unit','perawat'])->where(['maan_id'=>$maan_id])->notDeleted()->one();
$style='border: 1px solid;';
if($model->maan_batal){
    if(\Yii::$app->params['setting']['doc']['bg_batal']){
        $path = \Yii::getAlias('@webroot').\Yii::$app->params['setting']['doc']['bg_batal'];
        $type = pathinfo($path, PATHINFO_EXTENSION);
        $data = file_get_contents($path);
        $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
        $style="border: 1px solid;background-image:url('".$base64."');background-repeat: repeat;background-size: 80px 50px;";
    }
}
// echo'<pre/>';print_r($penunjang_order);die();
// https://www.picturetopeople.org/text_generator/others/transparent/transparent-text-generator.html
echo \Yii::$app->controller->renderPartial('../layouts/doc_kop.php',['params'=>['reg_kode'=>$model->layanan->pl_reg_kode,'pl_id'=>'']]);
?>
<style>   
h2 {
    text-align: center !important;
}
table {
    margin-left: auto !important;
    margin-right: auto !important;
    margin-bottom: 10px !important;
    width: 100% !important;
}
th {
    background-color: #D3D3D3 !important;
    text-align: left !important;
}
td {
    padding: 0 0 0 0px !important;
}
</style>
<h2>ANALISA KUANTITATIF</h2>
<table class="table table-striped table-bordered" style="text-align: justify;" id="analisa-kuantitatif">
                                <tr style="text-align: center;">
                                    <th rowspan="2" style="vertical-align : middle;">No</th>
                                    <th rowspan="2" style="vertical-align : middle;">Kriteria Analisa</th>
                                    <th colspan="2">Ada</th>
                                    <th rowspan="2" style="vertical-align : middle;">Tidak Ada</th>
                                </tr>
                                <tr style="text-align: center;">
                                    <th>Lengkap</th>
                                    <th>Tidak Lengkap</th>
                                </tr>



                                <tr>
                                    <th colspan="6">IDENTIFIKASI PASIEN</th>
                                </tr>
                                <tr class="p-0">
                                    <td width="5%">1</td>
                                    <td width="40%">Nomor Rekam Medis</td>


                                    <td width="15%">
                                        <div class="icheck-primary">
                                            <input type="radio" id="identifikasi_no_pasien1" name="AnalisaKuantitatif[identifikasi_no_pasien]">
                                            <label for="identifikasi_no_pasien1">
                                                Lengkap
                                            </label>
                                        </div>
                                    </td>

                                    <td width="15%">
                                        <div class="icheck-primary">
                                            <input type="radio" id="identifikasi_no_pasien2" name="identifikasi_no_pasien">
                                            <label for="identifikasi_no_pasien2">
                                                Tidak Lengkap
                                            </label>
                                        </div>
                                    </td>

                                    <td width="15%">
                                        <div class="icheck-primary">
                                            <input type="radio" id="identifikasi_no_pasien3" name="identifikasi_no_pasien">
                                            <label for="identifikasi_no_pasien3">
                                                Tidak Ada
                                            </label>
                                        </div>
                                    </td>

                                </tr>
                                <tr>
                                    <td>2</td>

                                    <td>Nama Pasien</td>
                                    <td>
                                        <div class="icheck-primary">
                                            <input type="radio" id="identifikasi_nama_pasien1" name="identifikasi_nama_pasien">
                                            <label for="identifikasi_nama_pasien1">
                                                Lengkap
                                            </label>
                                        </div>
                                    </td>

                                    <td>
                                        <div class="icheck-primary">
                                            <input type="radio" id="identifikasi_nama_pasien2" name="identifikasi_nama_pasien">
                                            <label for="identifikasi_nama_pasien2">
                                                Tidak Lengkap
                                            </label>
                                        </div>
                                    </td>

                                    <td>
                                        <div class="icheck-primary">
                                            <input type="radio" id="identifikasi_nama_pasien3" name="identifikasi_nama_pasien">
                                            <label for="identifikasi_nama_pasien3">
                                                Tidak Ada
                                            </label>
                                        </div>
                                    </td>

                                </tr>
                                <tr>
                                    <td>3</td>

                                    <td>Tanggal Lahir</td>


                                    <td>
                                        <div class="icheck-primary">
                                            <input type="radio" id="identifikasi_tgl_lahir1" name="identifikasi_tgl_lahir">
                                            <label for="identifikasi_tgl_lahir1">
                                                Lengkap
                                            </label>
                                        </div>
                                    </td>

                                    <td>
                                        <div class="icheck-primary">
                                            <input type="radio" id="identifikasi_tgl_lahir2" name="identifikasi_tgl_lahir">
                                            <label for="identifikasi_tgl_lahir2">
                                                Tidak Lengkap
                                            </label>
                                        </div>
                                    </td>

                                    <td>
                                        <div class="icheck-primary">
                                            <input type="radio" id="identifikasi_tgl_lahir3" name="identifikasi_tgl_lahir">
                                            <label for="identifikasi_tgl_lahir3">
                                                Tidak Ada

                                            </label>
                                        </div>
                                    </td>

                                </tr>
                                <tr>
                                    <td>4</td>

                                    <td>Umur Pasien</td>


                                    <td>
                                        <div class="icheck-primary">
                                            <input type="radio" id="ps_umur1" name="ps_umur">
                                            <label for="ps_umur1">
                                                Lengkap
                                            </label>
                                        </div>
                                    </td>

                                    <td>
                                        <div class="icheck-primary d-inline">
                                            <input type="radio" id="ps_umur2" name="ps_umur">
                                            <label for="ps_umur2">
                                                Tidak Lengkap
                                            </label>
                                        </div>
                                    </td>

                                    <td>
                                        <div class="icheck-primary d-inline">
                                            <input type="radio" id="ps_umur3" name="ps_umur">
                                            <label for="ps_umur3">
                                                Tidak Ada
                                            </label>
                                        </div>
                                    </td>

                                </tr>
                                <tr>
                                    <td>5</td>

                                    <td>Jenis Kelamin</td>


                                    <td>
                                        <div class="icheck-primary">
                                            <input type="radio" id="radioPrimary1" name="r1">
                                            <label for="radioPrimary1">
                                                Lengkap

                                            </label>
                                        </div>
                                    </td>

                                    <td>
                                        <div class="icheck-primary d-inline">
                                            <input type="radio" id="radioPrimary2" name="r1">
                                            <label for="radioPrimary2">
                                                Tidak Lengkap

                                            </label>
                                        </div>
                                    </td>

                                    <td>
                                        <div class="icheck-primary d-inline">
                                            <input type="radio" id="radioPrimary3" name="r1">
                                            <label for="radioPrimary3">
                                                Tidak Ada

                                            </label>
                                        </div>
                                    </td>

                                </tr>
                                <tr>
                                    <th colspan="6">A. Kelengkapan Laporan dan Form Yang Penting</th>
                                </tr>
                                <tr>
                                    <td>1</td>
                                    <td>Formulir DPJP</td>


                                    <td>
                                        <div class="icheck-primary d-inline">
                                            <input type="radio" id="kelengkapan_formulir_dpjp1" name="kelengkapan_formulir_dpjp">
                                            <label for="kelengkapan_formulir_dpjp1">
                                                Lengkap
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="icheck-primary d-inline">
                                            <input type="radio" id="kelengkapan_formulir_dpjp2" name="kelengkapan_formulir_dpjp">
                                            <label for="kelengkapan_formulir_dpjp2">
                                                Tidak Lengkap


                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="icheck-primary d-inline">
                                            <input type="radio" id="kelengkapan_formulir_dpjp3" name="kelengkapan_formulir_dpjp">
                                            <label for="kelengkapan_formulir_dpjp3">
                                                Tidak Ada
                                            </label>
                                        </div>
                                    </td>

                                </tr>
                                <tr>
                                    <td>1</td>
                                    <td>Resume Medis Rawat Jalan</td>


                                    <td>
                                        <div class="icheck-primary d-inline">
                                            <input type="radio" id="resume_medis1" name="resume_medis">
                                            <label for="resume_medis1">
                                                Lengkap
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="icheck-primary d-inline">
                                            <input type="radio" id="resume_medis2" name="resume_medis">
                                            <label for="resume_medis2">
                                                Tidak Lengkap


                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="icheck-primary d-inline">
                                            <input type="radio" id="resume_medis3" name="resume_medis">
                                            <label for="resume_medis3">
                                                Tidak Ada
                                            </label>
                                        </div>
                                    </td>

                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>Informed Consent</td>


                                    <td>
                                        <div class="icheck-primary d-inline">
                                            <input type="radio" id="informed_consent1" name="informed_consent">
                                            <label for="informed_consent1">
                                                Lengkap
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="icheck-primary d-inline">
                                            <input type="radio" id="informed_consent2" name="informed_consent">
                                            <label for="informed_consent2">
                                                Tidak Lengkap
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="icheck-primary d-inline">
                                            <input type="radio" id="informed_consent3" name="informed_consent">
                                            <label for="informed_consent3">
                                                Tidak Ada

                                            </label>
                                        </div>
                                    </td>


                                </tr>
                                <tr>
                                    <td>3</td>
                                    <td>Laporan Operasi</td>


                                    <td>
                                        <div class="icheck-primary d-inline">
                                            <input type="radio" id="laporan_operasi1" name="laporan_operasi">
                                            <label for="laporan_operasi1">
                                                Lengkap
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="icheck-primary d-inline">
                                            <input type="radio" id="laporan_operasi2" name="laporan_operasi">
                                            <label for="laporan_operasi2">
                                                Tidak Lengkap
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="icheck-primary d-inline">
                                            <input type="radio" id="laporan_operasi3" name="laporan_operasi">
                                            <label for="laporan_operasi3">
                                                Tidak Ada

                                            </label>
                                        </div>
                                    </td>

                                </tr>
                                <tr>
                                    <td>4</td>
                                    <td>Laporan Anasthesi</td>


                                    <td>
                                        <div class="icheck-primary d-inline">
                                            <input type="radio" id="laporan_anasthesi1" name="laporan_anasthesi">
                                            <label for="laporan_anasthesi1">
                                                Lengkap
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="icheck-primary d-inline">
                                            <input type="radio" id="laporan_anasthesi2" name="laporan_anasthesi">
                                            <label for="laporan_anasthesi2">
                                                Tidak Lengkap
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="icheck-primary d-inline">
                                            <input type="radio" id="laporan_anasthesi3" name="laporan_anasthesi">
                                            <label for="laporan_anasthesi3">
                                                Tidak Ada

                                            </label>
                                        </div>
                                    </td>

                                </tr>
                                <tr>
                                    <td>5</td>
                                    <td>Identifikasi Bayi Baru Lahir</td>


                                    <td>
                                        <div class="icheck-primary d-inline">
                                            <input type="radio" id="identifikasi_bayi_baru1" name="identifikasi_bayi_baru">
                                            <label for="identifikasi_bayi_baru1">
                                                Lengkap
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="icheck-primary d-inline">
                                            <input type="radio" id="identifikasi_bayi_baru2" name="identifikasi_bayi_baru">
                                            <label for="identifikasi_bayi_baru2">
                                                Tidak Lengkap
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="icheck-primary d-inline">
                                            <input type="radio" id="identifikasi_bayi_baru3" name="identifikasi_bayi_baru">
                                            <label for="identifikasi_bayi_baru3">
                                                Tidak Ada

                                            </label>
                                        </div>
                                    </td>

                                </tr>
                                <tr>
                                    <td>6</td>
                                    <td>ASESMEN AWAL KEPERAWATAN GENERAL</td>


                                    <td>
                                        <div class="icheck-primary d-inline">
                                            <input type="radio" id="asesmen_awal_keperawatan_umum1" name="asesmen_awal_keperawatan_umum">
                                            <label for="asesmen_awal_keperawatan_umum1">
                                                Lengkap
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="icheck-primary d-inline">
                                            <input type="radio" id="asesmen_awal_keperawatan_umum2" name="asesmen_awal_keperawatan_umum">
                                            <label for="asesmen_awal_keperawatan_umum2">
                                                Tidak Lengkap
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="icheck-primary d-inline">
                                            <input type="radio" id="asesmen_awal_keperawatan_umum3" name="asesmen_awal_keperawatan_umum">
                                            <label for="asesmen_awal_keperawatan_umum3">
                                                Tidak Ada

                                            </label>
                                        </div>
                                    </td>

                                </tr>
                                <tr>
                                    <td>7</td>
                                    <td>ASESMEN AWAL KEBIDANAN</td>


                                    <td>
                                        <div class="icheck-primary d-inline">
                                            <input type="radio" id="asesmen_awal_kebidanan1" name="asesmen_awal_kebidanan">
                                            <label for="asesmen_awal_kebidanan1">
                                                Lengkap
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="icheck-primary d-inline">
                                            <input type="radio" id="asesmen_awal_kebidanan2" name="asesmen_awal_kebidanan">
                                            <label for="asesmen_awal_kebidanan2">
                                                Tidak Lengkap
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="icheck-primary d-inline">
                                            <input type="radio" id="asesmen_awal_kebidanan3" name="asesmen_awal_kebidanan">
                                            <label for="asesmen_awal_kebidanan3">
                                                Tidak Ada

                                            </label>
                                        </div>
                                    </td>

                                </tr>
                                <tr>
                                    <td>8</td>
                                    <td>DOWN SCORE IPN</td>


                                    <td>
                                        <div class="icheck-primary d-inline">
                                            <input type="radio" id="down_score_ipn1" name="down_score_ipn">
                                            <label for="down_score_ipn1">
                                                Lengkap
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="icheck-primary d-inline">
                                            <input type="radio" id="down_score_ipn2" name="down_score_ipn">
                                            <label for="down_score_ipn2">
                                                Tidak Lengkap
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="icheck-primary d-inline">
                                            <input type="radio" id="down_score_ipn3" name="down_score_ipn">
                                            <label for="down_score_ipn3">
                                                Tidak Ada

                                            </label>
                                        </div>
                                    </td>

                                </tr>
                                <tr>
                                    <td>9</td>
                                    <td>SKRINING GIZI ANAK</td>


                                    <td>
                                        <div class="icheck-primary d-inline">
                                            <input type="radio" id="skrining_gizi_anak1" name="skrining_gizi_anak">
                                            <label for="skrining_gizi_anak1">
                                                Lengkap
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="icheck-primary d-inline">
                                            <input type="radio" id="skrining_gizi_anak2" name="skrining_gizi_anak">
                                            <label for="skrining_gizi_anak2">
                                                Tidak Lengkap
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="icheck-primary d-inline">
                                            <input type="radio" id="skrining_gizi_anak3" name="skrining_gizi_anak">
                                            <label for="skrining_gizi_anak3">
                                                Tidak Ada

                                            </label>
                                        </div>
                                    </td>

                                </tr>
                                <tr>
                                    <td>10</td>
                                    <td>ASESMEN RESIKO JATUH</td>


                                    <td>
                                        <div class="icheck-primary d-inline">
                                            <input type="radio" id="asesmen_resiko_jatuh1" name="asesmen_resiko_jatuh">
                                            <label for="asesmen_resiko_jatuh1">
                                                Lengkap
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="icheck-warning d-inline">
                                            <input type="radio" id="asesmen_resiko_jatuh2" name="asesmen_resiko_jatuh">
                                            <label for="asesmen_resiko_jatuh2">
                                                Tidak Lengkap
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="icheck-primary d-inline">
                                            <input type="radio" id="asesmen_resiko_jatuh3" name="asesmen_resiko_jatuh">
                                            <label for="asesmen_resiko_jatuh3">
                                                Tidak Ada

                                            </label>
                                        </div>
                                    </td>

                                </tr>
                                <tr>
                                    <td>11</td>
                                    <td>RESIKO DEKUBITUS</td>


                                    <td>
                                        <div class="icheck-primary d-inline">
                                            <input type="radio" id="resiko_dekubitus1" name="resiko_dekubitus">
                                            <label for="resiko_dekubitus1">
                                                Lengkap
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="icheck-primary d-inline">
                                            <input type="radio" id="resiko_dekubitus2" name="resiko_dekubitus">
                                            <label for="resiko_dekubitus2">
                                                Tidak Lengkap
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="icheck-primary d-inline">
                                            <input type="radio" id="resiko_dekubitus3" name="resiko_dekubitus">
                                            <label for="resiko_dekubitus3">
                                                Tidak Ada

                                            </label>
                                        </div>
                                    </td>

                                </tr>
                                <tr>
                                    <td>12</td>
                                    <td>ASESMEN NYERI</td>


                                    <td>
                                        <div class="icheck-primary d-inline">
                                            <input type="radio" id="asesmen_nyeri1" name="asesmen_nyeri">
                                            <label for="asesmen_nyeri1">
                                                Lengkap
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="icheck-primary d-inline">
                                            <input type="radio" id="asesmen_nyeri2" name="asesmen_nyeri">
                                            <label for="asesmen_nyeri2">
                                                Tidak Lengkap
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="icheck-primary d-inline">
                                            <input type="radio" id="asesmen_nyeri3" name="asesmen_nyeri">
                                            <label for="asesmen_nyeri3">
                                                Tidak Ada

                                            </label>
                                        </div>
                                    </td>

                                </tr>
                                <tr>
                                    <td>13</td>
                                    <td>ASUHAN PREOPERASI RUANGAN</td>


                                    <td>
                                        <div class="icheck-primary d-inline">
                                            <input type="radio" id="asuhan_preoperasi_ruangan1" name="asuhan_preoperasi_ruangan">
                                            <label for="asuhan_preoperasi_ruangan1">
                                                Lengkap
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="icheck-primary d-inline">
                                            <input type="radio" id="asuhan_preoperasi_ruangan2" name="asuhan_preoperasi_ruangan">
                                            <label for="asuhan_preoperasi_ruangan2">
                                                Tidak Lengkap
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="icheck-primary d-inline">
                                            <input type="radio" id="asuhan_preoperasi_ruangan3" name="asuhan_preoperasi_ruangan">
                                            <label for="asuhan_preoperasi_ruangan3">
                                                Tidak Ada

                                            </label>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>14</td>
                                    <td>MASALAH KEPERAWATAN</td>



                                    <td>
                                        <div class="icheck-primary d-inline">
                                            <input type="radio" id="masalah_keperawatan1" name="masalah_keperawatan">
                                            <label for="masalah_keperawatan1">
                                                Lengkap
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="icheck-primary d-inline">
                                            <input type="radio" id="masalah_keperawatan2" name="masalah_keperawatan">
                                            <label for="masalah_keperawatan2">
                                                Tidak Lengkap
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="icheck-primary d-inline">
                                            <input type="radio" id="masalah_keperawatan3" name="masalah_keperawatan">
                                            <label for="masalah_keperawatan3">
                                                Tidak Ada

                                            </label>
                                        </div>
                                    </td>

                                </tr>
                                <tr>
                                    <td>15</td>
                                    <td>DIET KEPERAWATAN</td>


                                    <td>
                                        <div class="icheck-primary d-inline">
                                            <input type="radio" id="diet_keperawatan1" name="diet_keperawatan">
                                            <label for="diet_keperawatan1">
                                                Lengkap
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="icheck-primary d-inline">
                                            <input type="radio" id="diet_keperawatan2" name="diet_keperawatan">
                                            <label for="diet_keperawatan2">
                                                Tidak Lengkap
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="icheck-primary d-inline">
                                            <input type="radio" id="diet_keperawatan3" name="diet_keperawatan">
                                            <label for="diet_keperawatan3">
                                                Tidak Ada

                                            </label>
                                        </div>
                                    </td>

                                </tr>
                                <tr>
                                    <td>16</td>
                                    <td>CPPT</td>


                                    <td>
                                        <div class="icheck-primary d-inline">
                                            <input type="radio" id="cppt1" name="cppt">
                                            <label for="cppt1">
                                                Lengkap
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="icheck-primary d-inline">
                                            <input type="radio" id="cppt2" name="cppt">
                                            <label for="cppt2">
                                                Tidak Lengkap
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="icheck-primary d-inline">
                                            <input type="radio" id="cppt3" name="cppt">
                                            <label for="cppt3">
                                                Tidak Ada

                                            </label>
                                        </div>
                                    </td>

                                </tr>
                                <tr>
                                    <td>17</td>
                                    <td>ASESMEN AWAL MEDIS</td>


                                    <td>
                                        <div class="icheck-primary d-inline">
                                            <input type="radio" id="asesmen_awal_medis1" name="asesmen_awal_medis">
                                            <label for="asesmen_awal_medis1">
                                                Lengkap
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="icheck-primary d-inline">
                                            <input type="radio" id="asesmen_awal_medis2" name="asesmen_awal_medis">
                                            <label for="asesmen_awal_medis2">
                                                Tidak Lengkap
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="icheck-primary d-inline">
                                            <input type="radio" id="asesmen_awal_medis3" name="asesmen_awal_medis">
                                            <label for="asesmen_awal_medis3">
                                                Tidak Ada

                                            </label>
                                        </div>
                                    </td>

                                </tr>
                                <tr>
                                    <td>18</td>
                                    <td>ICD-10 DIAGNOSA</td>


                                    <td>
                                        <div class="icheck-primary d-inline">
                                            <input type="radio" id="icd_10_diagnosa1" name="icd_10_diagnosa">
                                            <label for="icd_10_diagnosa1">
                                                Lengkap
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="icheck-primary d-inline">
                                            <input type="radio" id="icd_10_diagnosa2" name="icd_10_diagnosa">
                                            <label for="icd_10_diagnosa2">
                                                Tidak Lengkap
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="icheck-primary d-inline">
                                            <input type="radio" id="icd_10_diagnosa3" name="icd_10_diagnosa">
                                            <label for="icd_10_diagnosa3">
                                                Tidak Ada

                                            </label>
                                        </div>
                                    </td>

                                </tr>
                                <tr>
                                    <td>19</td>
                                    <td>ICD-9 PROCEDUR</td>


                                    <td>
                                        <div class="icheck-primary d-inline">
                                            <input type="radio" id="icd_9_procedur1" name="icd_9_procedur">
                                            <label for="icd_9_procedur1">
                                                Lengkap
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="icheck-primary d-inline">
                                            <input type="radio" id="icd_9_procedur2" name="icd_9_procedur">
                                            <label for="icd_9_procedur2">
                                                Tidak Lengkap
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="icheck-primary d-inline">
                                            <input type="radio" id="icd_9_procedur3" name="icd_9_procedur">
                                            <label for="icd_9_procedur3">
                                                Tidak Ada

                                            </label>
                                        </div>
                                    </td>

                                </tr>
                                <tr>
                                    <td>20</td>
                                    <td>RESEP OBAT</td>


                                    <td>
                                        <div class="icheck-primary d-inline">
                                            <input type="radio" id="resep_obat1" name="resep_obat">
                                            <label for="resep_obat1">
                                                Lengkap
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="icheck-primary d-inline">
                                            <input type="radio" id="resep_obat2" name="resep_obat">
                                            <label for="resep_obat2">
                                                Tidak Lengkap
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="icheck-primary d-inline">
                                            <input type="radio" id="resep_obat3" name="resep_obat">
                                            <label for="resep_obat3">
                                                Tidak Ada

                                            </label>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>21</td>
                                    <td>KONSULTASI</td>


                                    <td>
                                        <div class="icheck-primary d-inline">
                                            <input type="radio" id="konsultasi1" name="konsultasi">
                                            <label for="konsultasi1">
                                                Lengkap
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="icheck-primary d-inline">
                                            <input type="radio" id="konsultasi2" name="konsultasi">
                                            <label for="konsultasi2">
                                                Tidak Lengkap
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="icheck-primary d-inline">
                                            <input type="radio" id="konsultasi3" name="konsultasi">
                                            <label for="konsultasi3">
                                                Tidak Ada

                                            </label>
                                        </div>
                                    </td>

                                </tr>
                                <tr>
                                    <td>22</td>
                                    <td>PEMERIKSAAN LAB.PA </td>


                                    <td>
                                        <div class="icheck-primary d-inline">
                                            <input type="radio" id="pemeriksaan_lab_pa1" name="pemeriksaan_lab_pa">
                                            <label for="pemeriksaan_lab_pa1">
                                                Lengkap
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="icheck-primary d-inline">
                                            <input type="radio" id="pemeriksaan_lab_pa2" name="pemeriksaan_lab_pa">
                                            <label for="pemeriksaan_lab_pa2">
                                                Tidak Lengkap
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="icheck-primary d-inline">
                                            <input type="radio" id="pemeriksaan_lab_pa3" name="pemeriksaan_lab_pa">
                                            <label for="pemeriksaan_lab_pa3">
                                                Tidak Ada

                                            </label>
                                        </div>
                                    </td>

                                </tr>
                                <tr>
                                    <td>23</td>
                                    <td>PEMERIKSAAN LAB.PK </td>


                                    <td>
                                        <div class="icheck-primary d-inline">
                                            <input type="radio" id="pemeriksaan_lab_pk1" name="pemeriksaan_lab_pk">
                                            <label for="pemeriksaan_lab_pk1">
                                                Lengkap
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="icheck-primary d-inline">
                                            <input type="radio" id="pemeriksaan_lab_pk2" name="pemeriksaan_lab_pk">
                                            <label for="pemeriksaan_lab_pk2">
                                                Tidak Lengkap
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="icheck-primary d-inline">
                                            <input type="radio" id="pemeriksaan_lab_pk3" name="pemeriksaan_lab_pk">
                                            <label for="pemeriksaan_lab_pk3">
                                                Tidak Ada

                                            </label>
                                        </div>
                                    </td>

                                </tr>
                                <tr>
                                    <td>24</td>
                                    <td>PEMERIKSAAN RADIOLOGI </td>


                                    <td>
                                        <div class="icheck-primary d-inline">
                                            <input type="radio" id="pemeriksaan_radiologi1" name="pemeriksaan_radiologi">
                                            <label for="pemeriksaan_radiologi1">
                                                Lengkap
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="icheck-primary d-inline">
                                            <input type="radio" id="pemeriksaan_radiologi2" name="pemeriksaan_radiologi">
                                            <label for="pemeriksaan_radiologi2">
                                                Tidak Lengkap
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="icheck-primary d-inline">
                                            <input type="radio" id="pemeriksaan_radiologi3" name="pemeriksaan_radiologi">
                                            <label for="pemeriksaan_radiologi3">
                                                Tidak Ada

                                            </label>
                                        </div>
                                    </td>

                                </tr>
                                <tr>
                                    <td>25</td>
                                    <td>RESUME MEDIS RAWATINAP </td>


                                    <td>
                                        <div class="icheck-primary d-inline">
                                            <input type="radio" id="resume_medis_rawat_inap1" name="resume_medis_rawat_inap">
                                            <label for="resume_medis_rawat_inap1">
                                                Lengkap
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="icheck-primary d-inline">
                                            <input type="radio" id="resume_medis_rawat_inap2" name="resume_medis_rawat_inap">
                                            <label for="resume_medis_rawat_inap2">
                                                Tidak Lengkap
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="icheck-primary d-inline">
                                            <input type="radio" id="resume_medis_rawat_inap3" name="resume_medis_rawat_inap">
                                            <label for="resume_medis_rawat_inap3">
                                                Tidak Ada

                                            </label>
                                        </div>
                                    </td>

                                </tr>
                                <tr>
                                    <th colspan="6">B. Autentikasi</th>
                                </tr>
                                <tr>
                                    <td>1</td>
                                    <td>Nama Dokter</td>

                                    <td>
                                        <div class="icheck-primary d-inline">
                                            <input type="radio" id="nama_dokter1" name="nama_dokter">
                                            <label for="nama_dokter1">
                                                Lengkap
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="icheck-primary d-inline">
                                            <input type="radio" id="nama_dokter2" name="nama_dokter">
                                            <label for="nama_dokter2">
                                                Tidak Lengkap
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="icheck-primary d-inline">
                                            <input type="radio" id="nama_dokter3" name="nama_dokter">
                                            <label for="nama_dokter3">
                                                Tidak Ada

                                            </label>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>Tanda Tangan Dokter</td>

                                    <td>
                                        <div class="icheck-primary d-inline">
                                            <input type="radio" id="ttd_dokter1" name="ttd_dokter">
                                            <label for="ttd_dokter1">
                                                Lengkap
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="icheck-primary d-inline">
                                            <input type="radio" id="ttd_dokter2" name="ttd_dokter">
                                            <label for="ttd_dokter2">
                                                Tidak Lengkap
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="icheck-primary d-inline">
                                            <input type="radio" id="ttd_dokter3" name="ttd_dokter">
                                            <label for="ttd_dokter3">
                                                Tidak Ada

                                            </label>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>3</td>
                                    <td>Nama Perawat</td>

                                    <td>
                                        <div class="icheck-primary d-inline">
                                            <input type="radio" id="nama_perawat1" name="nama_perawat">
                                            <label for="nama_perawat1">
                                                Lengkap
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="icheck-primary d-inline">
                                            <input type="radio" id="nama_perawat2" name="nama_perawat">
                                            <label for="nama_perawat2">
                                                Tidak Lengkap
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="icheck-primary d-inline">
                                            <input type="radio" id="nama_perawat3" name="nama_perawat">
                                            <label for="nama_perawat3">
                                                Tidak Ada

                                            </label>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>4</td>
                                    <td>Tanda Tangan Perawat</td>

                                    <td>
                                        <div class="icheck-primary d-inline">
                                            <input type="radio" id="ttd_perawat1" name="ttd_perawat">
                                            <label for="ttd_perawat1">
                                                Lengkap
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="icheck-primary d-inline">
                                            <input type="radio" id="ttd_perawat2" name="ttd_perawat">
                                            <label for="ttd_perawat2">
                                                Tidak Lengkap
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="icheck-primary d-inline">
                                            <input type="radio" id="ttd_perawat3" name="ttd_perawat">
                                            <label for="ttd_perawat3">
                                                Tidak Ada

                                            </label>
                                        </div>
                                    </td>
                                </tr>
                               


                            </table>