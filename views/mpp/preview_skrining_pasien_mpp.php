<?php

use app\components\HelperSpesial;
use app\components\HelperSpesialClass;
use app\models\medis\AsesmenAwalKeperawatanGeneral;
use app\models\medis\AsesmenAwalMedis;
use app\models\pendaftaran\Pasien;
use yii\helpers\Url;

?>
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

    tr td .no_border {
        border: none;
    }
</style>
<?php

?>

<?= $this->render('doc_kop', ['pasien' => $pasien]);

// echo '<pre>';
// print_r($asesmen);
?>
<h2>SKRINING PASIEN MPP</h2>
<table border="1">
    <thead>
        <tr>
            <th style="width: 30px;">No</th>
            <th style="width: 200px;">Parameter</th>
            <th style="width: 450px;">Nilai</th>

        </tr>
    </thead>
    <tbody>
        <?php

        if (!empty($skriningPasienMpp)) {
            $data = json_decode($skriningPasienMpp['hasil_json'], true);
            // echo '<pre>';
            // print_r(json_decode($skriningPasienMpp['hasil_json']));
            foreach ($data['penilaian'] as $key => $item) { ?>
                <tr>
                    <td style="width: 30px;text-align:center"><?= $key + 1 ?></td>
                    <td style="width: 200px;"><?= $item['parameter'] ?></td>
                    <td style="width: 450px;">
                        <?php foreach ($item['kriteria'] as $value) {
                            if ($value['pilih'] == 1) {
                                echo $value['des'] . ' = ' . $value['val'];
                            }
                        } ?>
                    </td>
                <?php }
                ?>
                </tr>
                <tr>
                    <td style="text-align: center!important;" colspan="2">Total Skor</td>
                    <td style="text-align: left!important;"><?= $data['total_skor'] ?></td>
                </tr>
                <tr>
                    <td style="text-align: center!important;" colspan="2">Kategori Skor</td>
                    <td style="text-align: left!important;"><?= $data['kategori_skor'] ?></td>
                </tr>

            <?php
            // }
        } else { ?>
                <tr>
                    <td style="text-align: center!important;" colspan="5">Tidak ada catatan</td>
                </tr>
            <?php

        }
            ?>
            <tr style="height: 200px; margin: 0; padding: 0;">
                <td colspan="2" style="width:50%"></td>
                <td>Pekanbaru, <?= date('d-m-Y', strtotime($skriningPasienMpp['created_at'])) ?><br />Manager Pelayanan Pasien<br /><br /><br /><br /><br /><b><?= HelperSpesialClass::getNamaPegawaiArray($skriningPasienMpp['mpp']) ?? '-' ?></b><br><u><?= $skriningPasienMpp['mpp']['id_nip_nrp'] ?? '-' ?></u></td>

            </tr>

    </tbody>
</table>