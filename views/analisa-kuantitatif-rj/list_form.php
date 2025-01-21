<?php

use yii\web\View;
use yii\helpers\Url;

?>
<div class="card card-primary card-outline">
    <div class="card-header">
        <h5 class="card-title m-0">Daftar Formulir Telah Diisi</h5>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-info collapsed-card">
                    <div class="card-header">
                        <h3 class="card-title">ASESMEN AWAL KEPERAWATAN</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>

                    </div>

                    <div class="card-body">
                        <table class="table table-striped table-bordered" style="text-align: justify;">

                            <?php
                            if (!empty($listAsesmenKeperawatan)) {
                                $i = 1;
                                foreach ($listAsesmenKeperawatan as $item) {
                            ?>
                                    <tr>
                                        <td style="text-align: left;"><a class="btn <?php echo $item->tanggal_final != null ? 'btn-success' : 'btn-danger' ?> btn-sm btn-lihat-asesmen" href="<?= Url::to(['/analisa-kuantitatif/preview-asesmen-awal-keperawatan', 'id' => $item->id]) ?>" data-id="<?= $item->id ?>" data-nama="<?= $item->id ?>"><?= $i ?>. Asesmen Keperawatan, <b>STATUS : <?php echo $item->is_deleted == 0 ? ($item->draf == 1 ? 'DRAFT' : 'FINAL') : 'BATAL' ?> Tanggal : <?= $item->tanggal_final ?? '' ?></b></a></td>
                                    </tr>
                                <?php
                                    $i++;
                                }
                            } else {
                                ?>
                                <tr>
                                    <td style="text-align: left;">Tidak ada dokumen</td>
                                </tr>
                            <?php

                            }
                            ?>
                        </table>
                    </div>
                </div>

            </div>

        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card card-info collapsed-card">
                    <div class="card-header">
                        <h3 class="card-title">ASESMEN AWAL KEBIDANAN</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>

                    </div>

                    <div class="card-body">
                        <table class="table table-striped table-bordered" style="text-align: justify;">

                            <?php
                            if (!empty($listAsesmenKebidanan)) {
                                foreach ($listAsesmenKebidanan as $item) {
                            ?>
                                    <tr>
                                        <td style="text-align: left;"><a class="btn <?php echo $item->is_deleted == 0 ? 'btn-success' : 'btn-danger' ?> btn-sm btn-lihat-asesmen" href="<?= Url::to(['/analisa-kuantitatif/preview-asesmen-awal-kebidanan', 'id' => $item->id]) ?>" data-id="<?= $item->id
                                                                                                                                                                                                                                                                                                ?>" data-nama="<?= $item->id
                                                                                                                                                                                                                                                                                                                ?>"> Asesmen Keperawatan , <b>STATUS : <?php echo $item->is_deleted == 0 ? ($item->draf == 1 ? 'DRAFT' : 'FINAL') : 'BATAL' ?> Tanggal : <?= $item->tanggal_final ?? '' ?></a></td>
                                    </tr>
                                <?php
                                }
                            } else {
                                ?>
                                <tr>
                                    <td style="text-align: left;">Tidak ada dokumen</td>
                                </tr>
                            <?php

                            }
                            ?>
                        </table>
                    </div>
                </div>

            </div>

        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card card-info collapsed-card">
                    <div class="card-header">
                        <h3 class="card-title">ASESMEN AWAL MEDIS</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>

                    </div>

                    <div class="card-body">
                        <table class="table table-striped table-bordered" style="text-align: justify;">

                            <?php
                            if (!empty($listAsesmenMedis)) {
                                $i = 1;
                                foreach ($listAsesmenMedis as $item) {
                            ?>
                                    <tr>
                                        <td style="text-align: left;"><a class="btn <?php echo $item->is_deleted == 0 ? 'btn-success' : 'btn-danger' ?> btn-sm btn-lihat-asesmen" href="<?= Url::to(['/analisa-kuantitatif/preview-asesmen-awal-medis', 'id' => $item->id]) ?>" data-id="<?= $item->id
                                                                                                                                                                                                                                                                                            ?>" data-nama="<?= $item->id
                                                                                                                                                                                                                                                                                                            ?>"> <?= $i ?> . Asesmen Medis, <b>STATUS : <?php echo $item->is_deleted == 0 ? ($item->draf == 1 ? 'DRAFT' : 'FINAL') : 'BATAL' ?> Tanggal : <?= $item->tanggal_final ?? '' ?></a></td>
                                    </tr>
                                <?php
                                    $i++;
                                }
                            } else {
                                ?>
                                <tr>
                                    <td style="text-align: left;">Tidak ada dokumen</td>
                                </tr>
                            <?php

                            }
                            ?>
                        </table>
                    </div>
                </div>

            </div>

        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card card-info collapsed-card">
                    <div class="card-header">
                        <h3 class="card-title">HASIL PENUNJANG</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>

                    </div>

                    <div class="card-body">
                        <table class="table table-striped table-bordered" style="text-align: justify;">


                            <tr>
                                <td style="text-align: left;"><a class="btn btn-success btn-sm" target="_blank" href="http://emr-penunjang.simrs.aa/hasil/list-lis?no_rm=<?= $registrasi['pasien']['kode'] ?>">HASIL LABORATORIUM <i class="fas fa-eye fa-sm"></i></a></td>
                            </tr>
                            <tr>
                                <td style="text-align: left;"><a class="btn btn-success btn-sm" target="_blank" href="http://emr-penunjang.simrs.aa/hasil/pacs-lis?no_rm=<?= $registrasi['pasien']['kode'] ?>">HASIL RADIOLOGI <i class="fas fa-eye fa-sm"></i></a></td>
                            </tr>
                            <tr>
                                <td style="text-align: left;"><a class="btn btn-success btn-sm" target="_blank" href="http://emr-penunjang.simrs.aa/hasil/pa-lis?no_rm=<?= $registrasi['pasien']['kode'] ?>">HASIL PATOLOGI ANATOMI <i class="fas fa-eye fa-sm"></i></a></td>
                            </tr>
                        </table>
                    </div>
                </div>

            </div>

        </div>




        <div class="row">
            <div class="col-md-12">
                <div class="card card-info collapsed-card">
                    <div class="card-header">
                        <h3 class="card-title">LAPORAN OPERASI</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>

                    </div>

                    <div class="card-body">
                        <table>
                            <?php

                            if (!empty($listLaporanOperasi)) {
                                foreach ($listLaporanOperasi as $item) {
                            ?>

                                    <tr>
                                        <td style="text-align: left;"><a class="btn btn-success btn-sm btn-lihat-operasi" href="<?= Url::to(['/analisa-kuantitatif/preview-laporan-operasi', 'id' => $item['lap_op_id']]) ?>" data-id="<?= $item['lap_op_id']
                                                                                                                                                                                                                                        ?>" data-nama="<?= $item['lap_op_id']
                                                                                                                                                                                                                                                        ?>"> <?= $item['lap_op_created_at']
                                                                                                                                                                                                                                                                ?> <i class="fas fa-eye fa-sm"></i></a></td>


                                    </tr>
                                <?php
                                }
                            } else { ?>
                                <tr>
                                    <td style="text-align: left;">Tidak ada dokumen</td>
                                </tr>
                            <?php

                            }
                            ?>
                        </table>
                    </div>
                </div>

            </div>

        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card card-info collapsed-card">
                    <div class="card-header">
                        <h3 class="card-title">LAPORAN ANASTESI</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>

                    </div>

                    <div class="card-body">

                        <?php

                        if (!empty($listLaporanAnastesi)) {
                            foreach ($listLaporanAnastesi as $item) {

                        ?>

                                <tr>
                                    <td style="text-align: left;"><a class="btn btn-success btn-sm btn-lihat-anastesi" href="<?= Url::to(['/analisa-kuantitatif/preview-laporan-anastesi', 'id' => $item['api_id']]) ?>" data-id="<?= $item['api_id']
                                                                                                                                                                                                                                    ?>" data-nama="<?= $item['api_id']
                                                                                                                                                                                                                                                    ?>"> Laporan Anastesi <?= Yii::$app->formatter->asDate($item['api_tgl_final'])
                                                                                                                                                                                                                                                                            ?> <i class="fas fa-eye fa-sm"></i></a></td>


                                </tr>
                            <?php
                            }
                        } else { ?>
                            <tr>
                                <td style="text-align: left;">Tidak ada dokumen</td>
                            </tr>
                        <?php

                        }
                        ?>

                    </div>
                </div>

            </div>

        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card card-info collapsed-card">
                    <div class="card-header">
                        <h3 class="card-title">CPPT</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>

                    </div>

                    <div class="card-body">
                        <table class="table table-striped table-bordered" style="text-align: justify;">



                            <tr>
                                <td style="text-align: left;"><a class="btn btn-success btn-sm btn-lihat-asesmen" href="<?= Url::to([
                                                                                                                            '/analisa-kuantitatif/preview-cppt',
                                                                                                                            'id' => $registrasi['kode'],

                                                                                                                        ]) ?>">Dokumen CPPT<i class="fas fa-eye fa-sm"></i></a></td>
                            </tr>


                        </table>
                    </div>
                </div>

            </div>

        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card card-info collapsed-card">
                    <div class="card-header">
                        <h3 class="card-title">RESUME MEDIS RAWAT INAP</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>

                    </div>

                    <div class="card-body">
                        <table class="table table-striped table-bordered" style="text-align: justify;">


                            <?php

                            if (!empty($listResumeMedis)) {
                                foreach ($listResumeMedis as $item) {
                            ?>

                                    <tr>
                                        <td style="text-align: left;"><a class="btn btn-success btn-sm btn-lihat-operasi" href="<?= Url::to(['/analisa-kuantitatif/preview-resume-medis', 'id' => $item['id']]) ?>" data-id="<?= $item['id']
                                                                                                                                                                                                                                ?>" data-nama="<?= $item['id']
                                                                                                                                                                                                                                                ?>"> <?= $item['created_at']
                                                                                                                                                                                                                                                        ?> <i class="fas fa-eye fa-sm"></i></a></td>


                                    </tr>
                                <?php
                                }
                            } else { ?>
                                <tr>
                                    <td style="text-align: left;">Tidak ada dokumen</td>
                                </tr>
                            <?php

                            }
                            ?>

                        </table>
                    </div>
                </div>

            </div>

        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card card-info collapsed-card">
                    <div class="card-header">
                        <h3 class="card-title">RESEP OBAT</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <?php
                        if (count($resep) > 0) {
                            foreach ($resep as $r) {
                        ?>
                                <a href="#" class="btn btn-flat btn-resep <?php echo $r['is_deleted'] == 0 ? 'btn-success' : 'btn-danger' ?>" data-id="<?php echo $r['id']; ?>">
                                    <?php echo "Tanggal : " . date('d-m-Y H:i', strtotime($r['tanggal'])) ?> <?php echo $r['depo'] != NULL ? '<br>Depo : ' . $r['depo']['nama'] : '' ?><?php echo $r['dokter'] != NULL ? '<br> Dokter : ' . $r['dokter']['gelar_sarjana_depan'] . ' ' . $r['dokter']['nama_lengkap'] . $r['dokter']['gelar_sarjana_belakang'] : '' ?>
                                </a>
                        <?php
                            }
                        } else {
                            echo "RESEP OBAT TIDAK TERSEDIA";
                        }
                        ?>
                    </div>
                </div>
            </div>
            <div class="col-md-6"></div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card card-info collapsed-card">
                    <div class="card-header">
                        <h3 class="card-title">RIWAYAT KONSULTASI</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <?php
                        if (count($list_konsultasi) > 0) {
                        ?>
                            <table class="table table-bordered tb-riwayat-konsultasi">
                                <thead>
                                    <tr>
                                        <th>Tgl. Konsultasi</th>
                                        <th>Unit Asal</th>
                                        <th>Unit Tujuan</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach ($list_konsultasi as $lk) {
                                    ?>
                                        <tr>
                                            <td><?php echo $lk['tanggal_minta'] != NULL ? date('d-m-Y H:i', strtotime($lk['tanggal_minta'])) : ''; ?></td>
                                            <td><?php echo $lk['layananMinta'] != NULL ? ($lk['layananMinta']['unit'] != NULL ? $lk['layananMinta']['unit']['nama'] : '') : '' ?></td>
                                            <td><?php echo $lk['unitTujuan'] != NULL ? $lk['unitTujuan']['nama'] : '' ?></td>
                                            <td><a href="#" title="klik untuk melihat detail konsultasi" class="btn btn-flat btn-info btn-sm btn-detail" data-id='<?php echo $lk['id']; ?>'><i class="fa fa-eye"></i></a></td>
                                        </tr>
                                    <?php
                                    }
                                    ?>
                                </tbody>
                            </table>
                        <?php
                        }
                        ?>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="card card-info collapsed-card">
                    <div class="card-header">
                        <h3 class="card-title">RESUME MEDIS RAWAT JALAN</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">

                        <?php

                        if (!empty($listResumeMedisRj)) {
                            foreach ($listResumeMedisRj as $item) {
                        ?>

                                <tr>
                                    <td style="text-align: left;"><a class="btn btn-success btn-sm btn-preview-resume-rj" href="<?= Url::to(['/analisa-kuantitatif/preview-resume-medis-rj', 'id' => $item['id']]) ?>" data-id="<?= $item['id']
                                                                                                                                                                                                                                ?>" data-pasien="<?= $registrasi['pasien']['kode']
                                                                                                                                                                                                                                                    ?>" data-nama="<?= $item['id']
                                                                                                                                                                                                                                                                    ?>"> <?= $item['created_at']
                                                                                                                                                                                                                                                                            ?> <i class="fas fa-eye fa-sm"></i></a></td>


                                </tr>
                            <?php
                            }
                        } else { ?>
                            <tr>
                                <td style="text-align: left;">Tidak ada dokumen</td>
                            </tr>
                        <?php

                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>