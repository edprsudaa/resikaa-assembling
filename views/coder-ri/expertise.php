<?php

use app\components\HelperGeneralClass;
use app\models\Lib;
use yii\helpers\Url;

$logo = Lib::konvertBase64("/images/logo.png");
$logo_riau = Lib::konvertBase64("/images/logo_riau.png");
$logo_kars = Lib::konvertBase64("/images/logo_kars.png");
?>
<style>
    p {
        padding: 0 0 0 0;
        margin: 0 0 0 0;
    }
</style>
<style>   
h2 {
    text-align: center !important;
}
table {
    margin-left: auto !important;
    margin-right: auto !important;
    margin-bottom: 9px !important;
    width: 90% !important;
    border-collapse: collapse;
}
th {
    background-color: #D3D3D3 !important;
    text-align: left !important;
}
tr td {
    padding: 5px 5px 5px 5px !important;
    text-align: left !important;

}
tr td .no_border{
    border: none;
}
</style>
<?php 

?>

<?=$this->render('doc_kop', ['pasien'=>$pasien]);

// echo '<pre>';
// print_r($asesmen);
?>
    <h2 style="margin-top: 15px; text-align: center;"><b>HASIL PEMERIKSAAN PATOLOGI ANATOMI</b></h2>
    <table style="width: 100%;">
        <tr>
            <td style="width: 20%; padding:2px; background-color: #D3D3D3"><b>NOMOR PERIKSA</b></td>
            <td style="width: 30%; padding:2px;"><b>: <?= isset($no_periksa['no_periksa']) ? $no_periksa['no_periksa'] : '' ?></b></td>
            <td style="width: 20%; padding:2px; background-color: #D3D3D3"><b>DOKTER PENGIRIM</b></td>
            <td style="width: 30%; padding:2px;"><b>: <?= ucfirst($pasienLaporan['dokter_nama']) ?></b></td>
        </tr>
        <tr>
            <td style="width: 20%; padding:2px; background-color: #D3D3D3"><b>NAMA PASIEN</b></td>
            <td style="width: 30%; padding:2px;"><b>: <?= isset($pasienLaporan['pasien_nama']) ? $pasienLaporan['pasien_nama'] : $pasienLaporan['pasien_luar_nama'] ?></b></td>
            <td style="width: 20%; padding:2px; background-color: #D3D3D3"><b>RS / RUANGAN</b></td>
            <td style="width: 30%; padding:2px;"><b>: <?= $pasienLaporan['unit_asal_nama'] ?></b></td>
        </tr>
        <?php
        if (isset($pasienLaporan['pasien_tgl_lahir'])) {
            $lahir = $pasienLaporan['pasien_tgl_lahir'];
        } else {
            $lahir = $pasienLaporan['pasien_luar_tgl_lahir'];
        }
     

        $umur = HelperGeneralClass::getUmur($lahir,date('Y-m-d'));
        ?>
        <tr>
            <td style="width: 20%; padding:2px; background-color: #D3D3D3"><b>UMUR PASIEN</b></td>
            <td style="width: 30%; padding:2px;"><b>: <?= $umur['th'] . ' TH ' . $umur['bl'] . ' BL ' . $umur['hr'] . ' HR'?? '-'; ?></b></td>
            <td style="width: 20%; padding:2px; background-color: #D3D3D3"><b>TGL ORDER</b></td>
            <td style="width: 30%; padding:2px;"><b>: <?= Lib::dateIndLaporan($pasienLaporan['tgl_order']) ?></b></td>
        </tr>
        <tr>
            <td style="width: 20%; padding:2px; background-color: #D3D3D3"><b>NO. M.R</b></td>
            <td style="width: 30%; padding:2px;"><b>: <?= isset($pasienLaporan['pasien_kode']) ? $pasienLaporan['pasien_kode'] : $pasienLaporan['pasien_luar_kode'] ?></b></td>
            <td style="width: 20%; padding:2px; background-color: #D3D3D3"><b>TGL TERIMA</b></td>
            <td style="width: 30%; padding:2px;"><b>: <?= Lib::dateIndLaporan($data['created_at']) ?></b></td>
        </tr>
        <tr>
            <td style="width: 20%; padding:2px; background-color: #D3D3D3"><b>JENIS KELAMIN</b></td>
            <td style="width: 30%; padding:2px;"><b>: <?= isset($pasienLaporan['pasien_jkel']) ? ($pasienLaporan['pasien_jkel'] == 'l' ? 'LAKI-LAKI' : 'PEREMPUAN') : ($pasienLaporan['pasien_luar_jkel'] == 'l' ? 'LAKI-LAKI' : 'PEREMPUAN') ?></b></td>
            <td style="width: 20%; padding:2px; background-color: #D3D3D3"><b>TGL JAWAB</b></td>
            <td style="width: 30%; padding:2px;"><b>: <?= Lib::dateIndLaporan(date('Y-m-d')) ?></b></td>
        </tr>
        <tr>
            <td style="width: 20%; padding:2px; background-color: #D3D3D3"><b>ALAMAT</b></td>
            <td style="width: 30%; padding:2px;"><b>: <?= ucfirst(isset($pasienLaporan['alamat']) ? $pasienLaporan['alamat'] : $pasienLaporan['pasien_luar_alamat']) ?></b></td>
            <td style="width: 20%; padding:2px; background-color: #D3D3D3"><b>CARA BAYAR</b></td>
            <td style="width: 30%; padding:2px;"><b>: <?= $pasienLaporan['debitur_nama'] ?></b></td>
        </tr>
    </table>
    <hr>
    <div style="width: 100%; text-align: center; background-color: #D3D3D3"><b>PEMERIKSAAN <br> <?= $jenis['jenis'] ?></b>
    </div>
    <hr>
    <table style="width: 100%">
        <tr style="padding-bottom: 10px;">
            <td style="width: 30%; vertical-align: text-top;"><b>KLINIS</b></td>
            <td style="width: 2%; vertical-align: text-top;"><b>:</b></td>
            <td style="width: 68%; vertical-align: text-top;"><?= $data['klinis'] ?></td>
        </tr><br><br>
        <?php if ($jenis['jenis'] == 'IMUNOHISTOKIMIA') { ?>
            <tr style="padding-bottom: 10px;">
                <td style="width: 30%; vertical-align: text-top;"><b>MAKROSKOPIS</b></td>
            </tr>
            <tr style="padding-bottom: 10px;">
                <td style="width: 30%; vertical-align: text-top;">NO. PA</td>
                <td style="width: 2%; vertical-align: text-top;"><b>:</b></td>
                <td style="width: 68%; vertical-align: text-top;"><?= $data['no_pa'] ?></td>
            </tr>
            <?php
            // $diagnosa = explode('<p>', $data['diagnosa_pa']);
            // $diagnosa_ = explode('</p>', $diagnosa[1]);
            ?>
            <tr>
                <td style="width: 30%; vertical-align: text-top;">DIAGNOSA PA</td>
                <td style="width: 2%; vertical-align: text-top;"><b>:</b></td>
                <td style="width: 68%; vertical-align: text-top;"><?= $data['diagnosa_pa'] ?></td>
            </tr><br><br>
            <tr style="padding-bottom: 10px;">
                <td style="width: 30%; vertical-align: text-top;"><b>MIKROSKOPIS</b></td>
            </tr>
            <?php if (isset($data['makroskopis'])) {
                foreach ($data['makroskopis'] as $idx => $m) {
                    if ($m['hasil'] != '') { ?>
                        <tr style="padding-bottom: 10px;">
                            <td style="width: 30%"><?= ($idx + 1) . '. ' . $m['deskripsi'] ?></td>
                            <td style="width: 2%">:</td>
                            <td style="width: 68%"><?= $m['hasil'] ?></td>
                        </tr>s
                    <?php }
                }
            } elseif (isset($panel)) {
                foreach ($panel as $idx => $m) {
                    if ($m['hasil'] != '') { ?>
                        <tr style="padding-bottom: 10px;">
                            <td style="width: 30%"><?= ($idx + 1) . '. ' . $m['nama'] ?></td>
                            <td style="width: 2%">:</td>
                            <td style="width: 68%"><?= $m['hasil'] ?></td>
                        </tr>
            <?php }
                }
            }
        } else { ?>
            <tr style="padding-bottom: 10px; margin-top: 20px">
                <td style="width: 30%"><b>MAKROSKOPIS :</b></td>
            </tr>
            <tr style="padding-bottom: 10px;">
                <td style="width: 30%; padding-bottom: 50px" colspan="3"><?= $data['no_pa'] ?></td>
            </tr>
            <tr style="padding-bottom: 10px; margin-top: 20px">
                <td style="width: 30%"><b>MIKROSKOPIS :</b></td>
            </tr>
            <tr style="padding-bottom: 10px;">
                <td style="width: 30%; padding-bottom: 50px" colspan="3"><?= $data['diagnosa_pa'] ?></td>
            </tr>
        <?php } ?><br><br>
        <tr style="padding-bottom: 10px; margin-top: 20px">
            <td style="width: 30%"><b>KESIMPULAN :</b></td>
        </tr>
        <tr style="padding-bottom: 10px;">
            <td style="width: 30%" colspan="3"><?= $data['kesimpulan'] ?></td>
        </tr><br><br>
        <tr style="padding-bottom: 10px; margin-top: 20px">
            <td style="width: 30%"><b>ANJURAN :</b></td>
        </tr>
        <tr style="padding-bottom: 10px;">
            <td style="width: 30%" colspan="3"><?= $data['anjuran'] ?></td>
        </tr>
    </table>
    <table style="width: 100%; margin-top: 30px">
        <tr>
            <td style="width: 50%;"></td>
            <td style="width: 50%; text-align: center">Salam Sejawat</td>
        </tr>
        <tr>
            <td style="width: 50%; height: 100px;"></td>
            <td style="width: 50%; height: 100px;"></td>
        </tr>
        <tr>
            <td style="width: 50%;"></td>
            <td style="width: 50%; text-align: center"><?= $dokter['dokter_nama'] ?></td>
        </tr>
    </table>