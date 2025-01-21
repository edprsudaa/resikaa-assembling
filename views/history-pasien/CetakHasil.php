<?php

use app\models\Lib;
use yii\helpers\Url;

$logo = Lib::konvertBase64("/images/logo-rsud-basic.png");
?>

<?=$this->render('doc_kop', ['pasien'=>$pasien]);?>

<table style="border: 1px solid black;font-size:14px" width="100%">
    <tr>
        <td><br />
            <center>
                <h4 style="margin: 0; padding: 0;"><b>HASIL PEMERIKSAAN RADIOLOGI</b></h4>
            </center>
        </td>
    </tr>
</table>

<table style="border: 1px solid black;font-size:13px;padding:20px 0px 20px 0px" width="100%">
    <tr>
        <td>
            Nama Pasien
        </td>
        <td width="25%">: <b><?= isset($data['pasien_nama']) ? $data['pasien_nama'] : $data['pasien_luar_nama'] ?></b></td>
        <td></td>
        <td></td>
        <td>NO RM</td>
        <td width="25%">: <b><?= $data['nomor_pasien'] ?></b></td>
    </tr>
    <tr>
        <td>
            Umur/Jenis Kelamin
        </td>
        <td>: <?= isset($data['jkel']) ? ($data['jkel'] == 'l' ? 'LAKI-LAKI' : 'PEREMPUAN') : ($data['pasien_luar_jkel'] == 'l' ? 'LAKI-LAKI' : 'PEREMPUAN') ?></td>
        <td></td>
        <td></td>
        <td>Tanggal</td>
        <td>: <?= Lib::dateInd(date('Y-m-d', strtotime(isset($data['order_date']) ? $data['order_date'] : Null)), $day = false)  ?> </td>
    </tr>
    <tr>
        <td>
            Ruangan
        </td>
        <td>: <?= $data['unit_asal_nama'] ?></td>
        <td></td>
        <td></td>
        <td>No Reg.</td>
        <td style="font-size:13px">: <?= $data['nomor_registrasi'] ?> - No. <?= $no_tran ?></td>
    </tr>
    <tr>
        <td>
            Dokter Pengirim
        </td>
        <td>: <?= $data['dokter_asal_nama'] ?></td>
        <td></td>
        <td></td>
        <td>No. Photo</td>
        <td>: </td>
    </tr>
    <tr>
        <td style="vertical-align: top;">
            Jenis Pemeriksaan
        </td>
        <td colspan="4">:
            <?php
            if (!empty($data['nama_tindakan'])) {
            ?>
                <?= '-' . $data['nama_tindakan'] . '<br/>' ?>

            <?php
            } else {
            ?>
                Tidak ada data
            <?php
            }
            ?>
        </td>
    </tr>

</table>

<!--<div class="col-lg-12" style="height: 620px; min-height: 620px; vertical-align: top; border:1px solid black; border-top:0px solid black; border-bottom: 0px solid black;">
    <b>YTH TS,</b> <br/>
    <pre style=" white-space : normal; background-color:#ffffff; word-wrap: break-word;  overflow-x: auto; white-space:pre-line; border:0px solid white; margin-left: 5px;"><?php //$Data['HasilPemeriksaan']; 
                                                                                                                                                                            ?></pre><br/><br/><br/><br/><br/>
</div>-->
<div class="col-lg-12" style="height: 620px; min-height: 620px; vertical-align: top; border:1px solid black; border-top:0px solid black; border-bottom: 0px solid black;">
    <table style="width:100%;font-size:14px;padding:20px 0px 20px 0px">
        <tr>
            <td style="width:14%;vertical-align:top"> <b>YTH TS,<b></td>
            <td style="width:86%">
                <pre>:  <?= $data['report_description'] ?> <br/><br/><br/></pre>
            </td>
        </tr>
    </table>
</div>
<table style="border: 1px solid black; border-top: 0px;font-size:14px" width="100%">
    <tr>
        <td style="width:60%"></td>
        <td style="width:40%" colspan="3" align="center">
            <div style="border: 1px; text-align: center">
                Pekanbaru, <?= Lib::dateInd(date('Y-m-d', strtotime($data['order_date'])), $day = false)  ?><br /> Radiolog<br /><br /><br /><br /><br /><br />
                <u><?= $data['dokter_name'] ?></u>
            </div>
        </td>
    </tr>
</table>