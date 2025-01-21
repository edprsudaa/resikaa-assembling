<?php

use app\components\HelperGeneralClass;
use app\models\pendaftaran\Registrasi;
use kartik\date\DatePicker;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\pendaftaran\RegistrasiSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Daftar Dokumen Analisa';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="row">
    <div class="col-lg-12">
        <div class="card card-primary card-outline">
            <div class="card-body">
                <h3><?= Html::encode($this->title) ?></h3>

                <?php echo $this->render('_search', ['model' => $searchModel]); ?>


                <br>

                <table class="table table-striped table-bordered" style="text-align: justify;" id="analisa-kuantitatif">
                    <tr style="text-align: center;">
                        <th rowspan="2" style="vertical-align : middle;" class="bg-lightblue">Kriteria Analisa</th>
                        <th colspan="2" class="bg-lightblue">Ada</th>
                        <th rowspan="2" class="bg-lightblue" style="vertical-align : middle;">Tidak Ada</th>
                    </tr>
                    <tr style="text-align: center;">
                        <th class="bg-lightblue">Lengkap</th>
                        <th class="bg-lightblue">Tidak Lengkap</th>
                    </tr>
                    <?php
                    if (count($data) > 0) {
                        $no = 1;
                        $tab = 1;
                        $jenis = [null, null];
                        foreach ($data as $k) {

                            if ($jenis[0] != $k['analisa_dokumen_jenis_id']) {
                                $jenis = [$k['analisa_dokumen_jenis_id'], $k['jenis_analisa_uraian']];
                    ?>
                                <tr class="p-0" style="border: 1px solid;">
                                    <td colspan="5">
                                        <div>
                                            <b><?php echo $k['jenis_analisa_uraian']; ?></b>
                                        </div>
                                    </td>
                                </tr>
                            <?php }

                            if ($k['item_analisa_tipe'] == 1) {
                            ?>
                                <tr>
                                    <td style="width: 55%;">
                                        <?php echo $no . '. ' . $k['item_analisa_uraian']; ?>
                                        <input type="hidden" name="AnalisaDokumen[<?php // echo $no; 
                                                                                    ?>][analisa_dokumen_detail_id]" value="<?php // $k['analisa_dokumen_detail_id'] 
                                                                                                                        ?>">
                                        <input type="hidden" name="AnalisaDokumen[<?php // echo $no; 
                                                                                    ?>][analisa_dokumen_jenis_analisa_detail_id]" value="<?php // $k['analisa_dokumen_jenis_analisa_detail_id'] 
                                                                                                                                        ?>">
                                        <input type="hidden" name="AnalisaDokumen[<?php // echo $no; 
                                                                                    ?>][analisa_dokumen_item_id]" value="<?php // $k['itemAnalisa']['item_analisa_id'] 
                                                                                                                        ?>">

                                        <input type="hidden" name="AnalisaDokumen[<?php // echo $no; 
                                                                                    ?>][analisa_dokumen_jenis_id]" value="<?php // $k['jenisAnalisa']['jenis_analisa_id'] 
                                                                                                                        ?>">
                                    </td>

                                    <td width="15%" colspan="2" style="text-align:center">
                                        <div>
                                            <?php echo sprintf("%.2f%%", ($k['ada'] / $k['count']) * 100); ?>
                                        </div>
                                    </td>

                                    <td width="15%">
                                        <div>
                                            <?php echo sprintf("%.2f%%", ($k['tidak_ada'] / $k['count']) * 100); ?>
                                        </div>
                                    </td>

                                </tr>
                            <?php
                            } else {
                            ?>
                                <tr>
                                    <td style="width: 55%;">
                                        <?php echo $no . '. ' . $k['item_analisa_uraian']; ?>
                                        <input type="hidden" name="AnalisaDokumen[<?php // echo $no; 
                                                                                    ?>][analisa_dokumen_detail_id]" value="<?php // $k['analisa_dokumen_detail_id'] 
                                                                                                                        ?>">
                                        <input type="hidden" name="AnalisaDokumen[<?php // echo $no; 
                                                                                    ?>][analisa_dokumen_jenis_analisa_detail_id]" value="<?php // $k['analisa_dokumen_jenis_analisa_detail_id'] 
                                                                                                                                        ?>">
                                        <input type="hidden" name="AnalisaDokumen[<?php // echo $no; 
                                                                                    ?>][analisa_dokumen_item_id]" value="<?php // $k['itemAnalisa']['item_analisa_id'] 
                                                                                                                        ?>">

                                        <input type="hidden" name="AnalisaDokumen[<?php // echo $no; 
                                                                                    ?>][analisa_dokumen_jenis_id]" value="<?php // $k['jenisAnalisa']['jenis_analisa_id'] 
                                                                                                                        ?>">
                                    </td>


                                    <td width="15%">
                                        <div>
                                            <?php echo sprintf("%.2f%%", ($k['lengkap'] / $k['count']) * 100); ?>
                                        </div>
                                    </td>

                                    <td width="15%">
                                        <div>
                                            <?php echo sprintf("%.2f%%", ($k['tidak_lengkap'] / $k['count']) * 100); ?>
                                        </div>
                                    </td>

                                    <td width="15%">
                                        <div>
                                            <?php echo sprintf("%.2f%%", ($k['tidak_ada'] / $k['count']) * 100); ?>
                                        </div>
                                    </td>

                                </tr>
                    <?php
                            }
                            $no++;
                        }
                    }
                    ?>


                    <tr style="text-align: center;">
                        <td><b>Total Dokumen Analisis</b></td>
                        <td colspan="3"> <?= $data[0]['count'] ?? 0; ?> Dokumen</td>
                    </tr>

                </table>



            </div>
        </div>
    </div>
</div>