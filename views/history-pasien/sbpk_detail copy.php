<?php
use app\components\HelperGeneralClass;
use app\components\HelperSpesialClass;
?>
<?php
echo "<pre>";
print_r($pasien);?>
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
<table class="tbl-kop" style="width: 100%; border: solid 1px;">
<tbody>
    <tr>
        <?php
            //new
            $path = \Yii::getAlias('@webroot').'/images/riau.png';
            $type = pathinfo($path, PATHINFO_EXTENSION);
            $data = file_get_contents($path);
            $base64_1 = 'data:image/' . $type . ';base64,' . base64_encode($data);
            $path = \Yii::getAlias('@webroot').'/images/logo-light.png';
            $type = pathinfo($path, PATHINFO_EXTENSION);
            $data = file_get_contents($path);
            $base64_2 = 'data:image/' . $type . ';base64,' . base64_encode($data);
            $path = \Yii::getAlias('@webroot').'/images/kars.png';
            $type = pathinfo($path, PATHINFO_EXTENSION);
            $data = file_get_contents($path);
            $base64_3 = 'data:image/' . $type . ';base64,' . base64_encode($data);
            
        ?>
        <td class="td-kop" style="width: 90px;">
            <img src="<?=$base64_1?>" alt="" width="90px;" style="padding: 0; margin: 0;">
        </td>
        <td style="width: 35%; text-align: center; padding: 0; width: 60%;">
            <h6 style="padding: 1px; margin: 1px;">PEMERINTAH PROVINSI RIAU</h6>
            <h4 style="padding: 1px; margin: 1px;">RSUD ARIFIN ACHMAD</h4>
            <p style="font-size: 12px; font-weight: 700; margin-bottom: 0;">JLN.DIPONEGORO NO.2 TELP.23418, 21618, 21657 FAX.20253 PEKANBARU</p>
            <hr style="margin: 5px; height: 3px; background: #000;">
            <hr style="margin: 0 5px 0 5px; background: #000;">
        </td>
        <td class="td-kop" style="width: 90px">
            <img src="<?=$base64_2?>" alt="" width="90px;">
        </td>
        <td class="td-kop" style="width: 90px;">
            <img src="<?=$base64_3?>" alt="" width="90px;">
        </td>
        <td class="td-kop" style="width: 50%; border: solid 1px;">
            <table style="width: 100%; font-size: 11px;">
                <tbody>
                    <tr>
                        <td style="padding: 1px; width: 35%;">Nama Pasien</td>
                        <td style="padding: 1px; width: 10px;">: </td>
                        <td style="padding: 1px;"><?=$pasien['pasien']!=NULL ? $pasien['pasien']['nama'] : '' ?></td>
                    </tr>
                    <tr>
                        <td style="padding: 1px;">Nomor Rekam Medis</td>
                        <td style="padding: 1px;">: </td>
                        <td style="padding: 1px;"><?=$pasien['pasien']!=NULL ? $pasien['pasien']['kode'] : ''?></td>
                    </tr>
                    <tr>
                        <td style="padding: 1px;">Tanggal Lahir</td>
                        <td style="padding: 1px;">: </td>
                        <td style="padding: 1px;"><?= $pasien['pasien'] !=NULL ? date('d-m-Y',strtotime($pasien['pasien']['tgl_lahir'])) : ''?></td>
                    </tr>
                    <tr>
                        <td style="padding: 1px;">Jenis Kelamin</td>
                        <td style="padding: 1px;">: </td>
                        <td style="padding: 1px;"><?= $pasien['pasien']!=NULL ? (($pasien['pasien']['jkel']=='p')?'Perempuan':'Laki-laki') : '' ?></td>
                    </tr>
                </tbody>
            </table>
        </td>
    </tr>
</tbody>
</table>