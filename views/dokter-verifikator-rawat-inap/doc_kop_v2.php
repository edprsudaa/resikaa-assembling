<?php
use yii\helpers\Url;
?>
<style>
    table {
        margin-left: auto !important;
        margin-right: auto !important;
        margin-bottom: 10px !important;
        width: 100% !important;
    }
    th {
        background-color: #D3D3D3 !important;
        text-align: center !important;
    }
    td {
        padding: 0 0 0 25px !important;
    }
    .td-kop {
        padding: 0 !important;
        margin: 0 !important;
    }
</style>

<table class="tbl-kop" style="width: 100%; border: 1px solid;">
<tbody>
    <tr>
        <?php
            //new
            $path = \Yii::getAlias('@webroot').'/images/logo_riau_small.png';
            $type = pathinfo($path, PATHINFO_EXTENSION);
            $data = file_get_contents($path);
            $base64_1 = 'data:image/' . $type . ';base64,' . base64_encode($data);
            $path = \Yii::getAlias('@webroot').'/images/logo_rsudaa_small.png';
            $type = pathinfo($path, PATHINFO_EXTENSION);
            $data = file_get_contents($path);
            $base64_2 = 'data:image/' . $type . ';base64,' . base64_encode($data);
            //$path = \Yii::getAlias('@webroot').'/images/logo_kars_small.png';
			$path = \Yii::getAlias('@webroot').'/images/kars_small.png';
            $type = pathinfo($path, PATHINFO_EXTENSION);
            $data = file_get_contents($path);
            $base64_3 = 'data:image/' . $type . ';base64,' . base64_encode($data);
            
        ?>
        <td class="td-kop" rowspan="5" style="text-align: center;">
            <img src="<?=$base64_1?>" alt=""  width="9%" style="padding: 0;">
        </td>
        <td rowspan="5" style="text-align: center; padding:0; margin:0; width: 30%;">
            <p style="padding: 1px; font-size:12px; margin: 0;">PEMERINTAH PROVINSI RIAU</p>
            <p style="font-size:16px; margin: 0;">
            <b>RSUD ARIFIN ACHMAD</b>
            </p>
            <p style="font-size: 9px; font-weight: 700; margin: 0;">
            JLN.DIPONEGORO NO.2 TELP.23418, 21618, 21657 FAX.20253 PEKANBARU
            </p>
            <hr style="margin: 5px; height: 3px; background: #000;">
            <hr style="margin: 0 5px 0 5px; background: #000;">
        </td>
        <td class="td-kop" rowspan="5" style="text-align: center;">
            <img src="<?=$base64_2?>" alt=""  width="9%" style="padding: 0;">
        </td>
        <td class="td-kop" rowspan="5" style="text-align: center;">
            <img src="<?=$base64_3?>" alt=""  width="9%" style="padding: 0;">
        </td>
        <td style="padding-left: 9px;padding-right:1px; font-size: 11px; width:18%;">Nama Pasien</td>
        <td valign="center" style="font-size: 11px;padding-left: 1px;padding-right: 1px; width: 1%;">: </td>
        <td style="font-size: 12px; padding: 1px; width:24%"><b><?=$pasien['nama']?></b></td>
    </tr>
    <tr>
      <td style="padding-left: 9px;padding-right:1px; font-size: 11px;">Nomor Rekam Medis</td>
      <td valign="center" style="font-size: 11px;padding-left: 1px;padding-right: 1px;">: </td>
      <td style="font-size: 15px; padding: 1px;"><b><?= $pasien['kode'] ?></b></td>
    </tr>
    <tr>
      <td style="padding-left: 9px;padding-right:1px; font-size: 11px;">Tanggal Lahir</td>
      <td valign="center" style="font-size: 11px;padding-left: 1px;padding-right: 1px;">: </td>
      <td style="font-size: 15px; padding: 1px;"><b><?= date('d-m-Y', strtotime($pasien['tgl_lahir'])) ?></b></td>
    </tr>
    <tr>
      <td style="padding-left: 9px;padding-right:1px; font-size: 11px;">Jenis Kelamin</td>
      <td valign="center" style="font-size: 11px;padding-left: 1px;padding-right: 1px;">: </td>
      <td style="font-size: 15px; padding: 1px;"><b><?= ($pasien['jkel'] == 'l' ? 'Laki-laki' : 'Perempuan') ?></b></td>
    </tr>
    <tr>
      <td style="padding-left: 9px;padding-right:1px; font-size: 11px;">NIK</td>
      <td valign="center" style="font-size: 11px;padding-left: 1px;padding-right: 1px;">: </td>
      <td style="font-size: 15px; padding: 1px;"><b><?=(($pasien['no_identitas'])?$pasien['no_identitas']:'-')?></b></td>
    </tr>
</tbody>
</table>