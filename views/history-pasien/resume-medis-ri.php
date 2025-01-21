<?php

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
if ($is_ajax == true) {
    echo $this->render('doc_kop', ['pasien' => $pasien]);
} else {
    echo $this->render('doc_kop_v2', ['pasien' => $pasien]);
} ?>
<h2>RESUME MEDIS RAWATINAP</h2>
<table class="table table-sm table-form" style="border: 1px solid;">

    <tr>
        <td colspan="2" style="text-align:left"><b>Id :</b></td>
        <td colspan="4" style="text-align:left"><?= $resume->id ?? '-' ?></td>
        <td colspan="2" style="text-align:left"><b>No.Reg :</b></td>
        <td colspan="4" style="text-align:left"><?= $resume->layanan->registrasi->kode ?? '-' ?></td>
    </tr>
    <tr>
        <td colspan="2" style="text-align:left"><b>Tgl.Masuk :</b></td>
        <td colspan="4" style="text-align:left"><?= date('d-m-Y', strtotime($resume->layanan->registrasi->tgl_masuk ?? '-')) ?></td>

        <td colspan="2" style="text-align:left"><b>Tgl & Ruangan Pulang :</b></td>
        <td colspan="4" style="text-align:left"><?php
                                                $txt = null;
                                                if (isset($resume->tgl_pulang)) {
                                                    $txt = $txt . date('d-m-Y', strtotime($resume->tgl_pulang ?? '-'));
                                                } else {
                                                    //$txt=$txt.(($resume->layanan->registrasi->tgl_keluar)?date('d-m-Y',strtotime($resume->layanan->registrasi->tgl_keluar)):'-');
                                                    $txt = $txt . 'TANGGAL PULANG PASIEN BELUM DI INPUT OLEH DPJP';
                                                }
                                                if (isset($resume->layanan_pulang_id)) {
                                                    $txt = $txt . ' / ' . $resume->layananPulang->unit->nama ?? '-';
                                                }
                                                echo $txt;
                                                ?></td>
    </tr>
    <tr>
        <td colspan="2"></td>
        <td colspan="4"></td>
        <td colspan="2" style="text-align:left"><b>Cara Bayar :</b></td>
        <td colspan="4" style="text-align:left"><?= $resume->layanan->registrasi->debiturDetail->nama ?? '-' ?></td>

    </tr>
    <tr>
        <td colspan="12"><b>Ringkasan Riwayat Penyakit :</b></td>
    </tr>
    <tr>
        <td colspan="12"><?= isset($resume->ringkasan_riwayat_penyakit) ? $resume->ringkasan_riwayat_penyakit : '-' ?></td>
    </tr>
    <tr>
        <td colspan="12"><b>Hasil Pemeriksaan Fisik Penting & Temuan Lainya :</b></td>
    </tr>
    <tr>
        <td colspan="12"><?= isset($resume->hasil_pemeriksaan_fisik) ? $resume->hasil_pemeriksaan_fisik : '-' ?></td>
    </tr>
    <tr>
        <td colspan="12"><b>Hasil Penunjang(Lab,Radiologi Dan Lainnya) :</b></td>
    </tr>
    <tr>
        <td colspan="12"><?= isset($resume->hasil_penunjang) ? $resume->hasil_penunjang : '-' ?></td>
    </tr>
    <tr>
        <td colspan="12"><b>Terapi/Pengobatan selama dirawat :</b></td>
    </tr>
    <tr>
        <td colspan="12"><?= isset($resume->terapi_perawatan) ? $resume->terapi_perawatan : '-' ?></td>
    </tr>
    <tr>
        <td colspan="3"><b>Indikasi Rawat Inap : </b></td>
        <td colspan="3"><b>Alasan Pulang :</b></td>
        <td colspan="3"><b>Kondisi Saat Pulang :</b></td>
        <td colspan="3"><b>Cara Pulang :</b></td>
    </tr>
    <tr>
        <td colspan="3"><?= isset($resume->indikasi_rawat_inap) ? $resume->indikasi_rawat_inap : '-' ?></b></td>
        <td colspan="3"><?= isset($resume->alasan_pulang) ? $resume->alasan_pulang : '-' ?></b></td>
        <td colspan="3"><?= isset($resume->kondisi_pulang) ? $resume->kondisi_pulang : '-' ?></b></td>
        <td colspan="3"><?= isset($resume->cara_pulang) ? $resume->cara_pulang : '-' ?></b></td>
    </tr>
    <tr>
        <th class="bg-lightblue" colspan="12" style="text-align:center">DIAGNOSA</th>
    </tr>
    <tr>
        <td colspan="12"><b>Diagnosa Masuk :</b></td>
    </tr>
    <tr>
        <td colspan="12"><?= ((isset($resume->diagnosa_masuk_deskripsi)) ? $resume->diagnosa_masuk_deskripsi . '  ( Kode ICD10:' . (isset($resume->diagnosa_masuk_id) ? $resume->diagmasuk->kode : '........') . ')' : (isset($resume->diagnosa_masuk_id) ? $resume->diagmasuk->nama ?? '-' . ' ( Kode ICD10:' . $resume->diagmasuk->kode ?? '-' . ' )' : '........')) ?></td>
    </tr>
    <tr>
        <td colspan="4" class="text-left"><b>Jenis</b></td>
        <td colspan="6" class="text-left"><b>Nama Diagnosa :</b></td>
        <td colspan="2" class="text-left"><b>Kode ICD10</b></td>
    </tr>
    <tr>
        <td colspan="4" class="text-left">Utama</td>
        <td colspan="6" class="text-left"><?= isset($resume->diagnosa_utama_deskripsi) ? $resume->diagnosa_utama_deskripsi : '-' ?></td>
        <td colspan="2" class="text-left"><?= isset($resume->diagnosa_utama_id) ? $resume->diagutama->kode : '' ?></td>
    </tr>
    <?php
    if (isset($resume->diagnosa_tambahan1_deskripsi) || isset($resume->diagnosa_tambahan1_id)) {
    ?>
        <tr>
            <td colspan="4" class="text-left">Tambahan 1</td>
            <td colspan="6" class="text-left"><?= isset($resume->diagnosa_tambahan1_deskripsi) ? $resume->diagnosa_tambahan1_deskripsi : '-' ?></td>
            <td colspan="2" class="text-left"><?= isset($resume->diagnosa_tambahan1_id) ? $resume->diagsatu->kode : '' ?></td>
        </tr>
    <?php
    }
    ?>
    <?php
    if (isset($resume->diagnosa_tambahan2_deskripsi) || isset($resume->diagnosa_tambahan2_id)) {
    ?>
        <tr>
            <td colspan="4" class="text-left">Tambahan 2</td>
            <td colspan="6" class="text-left"><?= isset($resume->diagnosa_tambahan2_deskripsi) ? $resume->diagnosa_tambahan2_deskripsi : '-' ?></td>
            <td colspan="2" class="text-left"><?= isset($resume->diagnosa_tambahan2_id) ? $resume->diagdua->kode : '' ?></td>
        </tr>
    <?php
    }
    ?>
    <?php
    if (isset($resume->diagnosa_tambahan3_deskripsi) || isset($resume->diagnosa_tambahan3_id)) {
    ?>
        <tr>
            <td colspan="4" class="text-left">Tambahan 3</td>
            <td colspan="6" class="text-left"><?= isset($resume->diagnosa_tambahan3_deskripsi) ? $resume->diagnosa_tambahan3_deskripsi : '-' ?></td>
            <td colspan="2" class="text-left"><?= isset($resume->diagnosa_tambahan3_id) ? $resume->diagtiga->kode : '' ?></td>
        </tr>
    <?php
    }
    ?>
    <?php
    if (isset($resume->diagnosa_tambahan4_deskripsi) || isset($resume->diagnosa_tambahan4_id)) {
    ?>
        <tr>
            <td colspan="4" class="text-left">Tambahan 4</td>
            <td colspan="6" class="text-left"><?= isset($resume->diagnosa_tambahan4_deskripsi) ? $resume->diagnosa_tambahan4_deskripsi : '-' ?></td>
            <td colspan="2" class="text-left"><?= isset($resume->diagnosa_tambahan4_id) ? $resume->diagempat->kode : '' ?></td>
        </tr>
    <?php
    }
    ?>
    <?php
    if (isset($resume->diagnosa_tambahan5_deskripsi) || isset($resume->diagnosa_tambahan5_id)) {
    ?>
        <tr>
            <td colspan="4" class="text-left">Tambahan 5</td>
            <td colspan="6" class="text-left"><?= isset($resume->diagnosa_tambahan5_deskripsi) ? $resume->diagnosa_tambahan5_deskripsi : '-' ?></td>
            <td colspan="2" class="text-left"><?= isset($resume->diagnosa_tambahan5_id) ? $resume->diaglima->kode : '' ?></td>
        </tr>
    <?php
    }
    ?>
    <?php
    if (isset($resume->diagnosa_tambahan6_deskripsi) || isset($resume->diagnosa_tambahan6_id)) {
    ?>
        <tr>
            <td colspan="4" class="text-left">Tambahan 6</td>
            <td colspan="6" class="text-left"><?= isset($resume->diagnosa_tambahan6_deskripsi) ? $resume->diagnosa_tambahan6_deskripsi : '-' ?></td>
            <td colspan="2" class="text-left"><?= isset($resume->diagnosa_tambahan6_id) ? $resume->diagenam->kode : '' ?></td>
        </tr>
    <?php
    }
    ?>
    <tr>
        <th class="bg-lightblue" colspan="12" style="text-align:center">TINDAKAN</th>
    </tr>
    <tr>
        <td colspan="4" class="text-left"><b>Jenis</b></td>
        <td colspan="6" class="text-left"><b>Nama Tindakan :</b></td>
        <td colspan="2" class="text-left"><b>Kode ICD9</b></td>
    </tr>
    <tr>
        <td colspan="4" class="text-left">Utama</td>
        <td colspan="6" class="text-left"><?= isset($resume->tindakan_utama_deskripsi) ? $resume->tindakan_utama_deskripsi : '-' ?></td>
        <td colspan="2" class="text-left"><?= isset($resume->tindakan_utama_id) ? $resume->tindutama->kode : '' ?></td>
    </tr>
    <?php
    if (isset($resume->tindakan_tambahan1_deskripsi) || isset($resume->tindakan_tambahan1_id)) {
    ?>
        <tr>
            <td colspan="4" class="text-left">Tambahan 1</td>
            <td colspan="6" class="text-left"><?= isset($resume->tindakan_tambahan1_deskripsi) ? $resume->tindakan_tambahan1_deskripsi : '-' ?></td>
            <td colspan="2" class="text-left"><?= isset($resume->tindakan_tambahan1_id) ? $resume->tindsatu->kode : '' ?></td>
        </tr>
    <?php
    }
    ?>
    <?php
    if (isset($resume->tindakan_tambahan2_deskripsi) || isset($resume->tindakan_tambahan2_id)) {
    ?>
        <tr>
            <td colspan="4" class="text-left">Tambahan 2</td>
            <td colspan="6" class="text-left"><?= isset($resume->tindakan_tambahan2_deskripsi) ? $resume->tindakan_tambahan2_deskripsi : '-' ?></td>
            <td colspan="2" class="text-left"><?= isset($resume->tindakan_tambahan2_id) ? $resume->tinddua->kode : '' ?></td>
        </tr>
    <?php
    }
    ?>
    <?php
    if (isset($resume->tindakan_tambahan3_deskripsi) || isset($resume->tindakan_tambahan3_id)) {
    ?>
        <tr>
            <td colspan="4" class="text-left">Tambahan 3</td>
            <td colspan="6" class="text-left"><?= isset($resume->tindakan_tambahan3_deskripsi) ? $resume->tindakan_tambahan3_deskripsi : '-' ?></td>
            <td colspan="2" class="text-left"><?= isset($resume->tindakan_tambahan3_id) ? $resume->tindtiga->kode : '' ?></td>
        </tr>
    <?php
    }
    ?>
    <?php
    if (isset($resume->tindakan_tambahan4_deskripsi) || isset($resume->tindakan_tambahan4_id)) {
    ?>
        <tr>
            <td colspan="4" class="text-left">Tambahan 4</td>
            <td colspan="6" class="text-left"><?= isset($resume->tindakan_tambahan4_deskripsi) ? $resume->tindakan_tambahan4_deskripsi : '-' ?></td>
            <td colspan="2" class="text-left"><?= isset($resume->tindakan_tambahan4_id) ? $resume->tindempat->kode : '' ?></td>
        </tr>
    <?php
    }
    ?>
    <?php
    if (isset($resume->tindakan_tambahan5_deskripsi) || isset($resume->tindakan_tambahan5_id)) {
    ?>
        <tr>
            <td colspan="4" class="text-left">Tambahan 5</td>
            <td colspan="6" class="text-left"><?= isset($resume->tindakan_tambahan5_deskripsi) ? $resume->tindakan_tambahan5_deskripsi : '-' ?></td>
            <td colspan="2" class="text-left"><?= isset($resume->tindakan_tambahan5_id) ? $resume->tindlima->kode : '' ?></td>
        </tr>
    <?php
    }
    ?>
    <?php
    if (isset($resume->tindakan_tambahan6_deskripsi) || isset($resume->tindakan_tambahan6_id)) {
    ?>
        <tr>
            <td colspan="4" class="text-left">Tambahan 6</td>
            <td colspan="6" class="text-left"><?= isset($resume->tindakan_tambahan6_deskripsi) ? $resume->tindakan_tambahan6_deskripsi : '-' ?></td>
            <td colspan="2" class="text-left"><?= isset($resume->tindakan_tambahan6_id) ? $resume->tindenam->kode : '' ?></td>
        </tr>
    <?php
    }
    ?>
    <tr>
        <th class="bg-lightblue" colspan="12" style="text-align:center">PEMERIKSAAN FISIK</th>
    </tr>
    <tr>
        <td><b>GCS E :</b> <?= isset($resume->gcs_e) ? $resume->gcs_e : '-' ?></td>
        <td><b>GCS M :</b> <?= isset($resume->gcs_m) ? $resume->gcs_m : '-' ?></td>
        <td colspan="2"><b>GCS V :</b> <?= isset($resume->gcs_v) ? $resume->gcs_v : '-' ?></td>
        <td><b>Nadi(x/menit) :</b> <?= isset($resume->nadi) ? $resume->nadi : '-' ?></td>
        <td><b>TD(mmHg) :</b> <?= isset($resume->darah) ? $resume->darah : '-' ?></td>
        <td><b>Suhu(C) :</b> <?= isset($resume->suhu) ? $resume->suhu : '-' ?></td>
        <td><b>SatO2(%) :</b> <?= isset($resume->sato2) ? $resume->sato2 : '-' ?></td>
        <td colspan="2"><b>Pernapasan(x/menit) :</b> <?= isset($resume->pernapasan) ? $resume->pernapasan : '-' ?></td>
    </tr>
    <tr>
        <td><b>BB (Kg) :</b> <?= isset($resume->berat_badan) ? $resume->berat_badan : '-' ?></td>
        <td><b>TB (Cm) :</b> <?= isset($resume->tinggi_badan) ? $resume->tinggi_badan : '-' ?></td>
        <td colspan="4"><b>Keadaan Gizi :</b> <?= isset($resume->keadaan_gizi) ? $resume->keadaan_gizi : '-' ?></td>
        <td colspan="3"><b>Keadaan Umum :</b> <?= isset($resume->keadaan_umum) ? $resume->keadaan_umum : '-' ?></td>
        <td colspan="3"><b>Tingkat Kesadaran :</b> <?= isset($resume->tingkat_kesadaran) ? $resume->tingkat_kesadaran : '-' ?></td>
    </tr>
    <tr>
        <td colspan="2"><b>Alergi :</b></td>
        <td colspan="10"><?= isset($resume->alergi) ? $resume->alergi : '-' ?></td>
    </tr>
    <tr>
        <td colspan="2"><b>Diet :</b></td>
        <td colspan="10"><?= isset($resume->diet) ? $resume->diet : '-' ?></td>
    </tr>
    <tr>
        <td colspan="2"><b>Obat Rumah :</b></td>
        <td colspan="10"><?= isset($resume->obat_rumah) ? $resume->obat_rumah : '-' ?></td>
    </tr>
    <tr>
        <td colspan="2"><b>Terapi Pulang :</b></td>
        <td colspan="10"><?= isset($resume->terapi_pulang) ? $resume->terapi_pulang : '-' ?></td>
    </tr>
    <tr>
        <td colspan="2"><b>Tanggal Kontrol Poliklinik :</b></td>
        <td colspan="10"><?= isset($resume->tgl_kontrol) ? $resume->tgl_kontrol : '-' ?></td>
    </tr>
    <tr>
        <td colspan="2"><b>Poliklinik Tujuan Kontrol :</b></td>
        <td colspan="10"><?= isset($resume->poli_tujuan_kontrol_id) ? $resume->unitTujuan->nama : '-' ?></td>
    </tr>
    <tr style="height: 200px; margin: 0; padding: 0;">
        <td colspan="8"></td>
        <td colspan="4">Pekanbaru,<?= date('d-m-Y', strtotime($resume->created_at ?? '-')) ?><br />
            Dokter DPJP<br /><br /><br /><br /><br /><br /><b><?= (isset($resume->dokter->gelar_sarjana_depan) ? $resume->dokter->gelar_sarjana_depan . ' ' : null) .
                                                                    isset($resume->dokter->nama_lengkap) ? $resume->dokter->nama_lengkap : '-' .
                                                                    (isset($resume->dokter->gelar_sarjana_belakang) ? ', ' .
                                                                        $resume->dokter->gelar_sarjana_belakang : null) ?></b><br><u>
                <?= isset($resume->dokter->id_nip_nrp) ? $resume->dokter->id_nip_nrp : '-' ?></u></td>
    </tr>
    <tr style="height: 50px; margin: 0; padding: 0;">
        <td colspan="4"></td>
        <td colspan="4">
            <center><b>SERAH TERIMA PASIEN</b></center>
        </td>
        <td colspan="4"></td>
    </tr>
    <tr style="height: 200px; margin: 0; padding: 0;">
        <td colspan="2"></td>
        <td colspan="4"><b>Keluarga yang menerima,<br /><br /><br /><br /><br /><br /><b><b>(........................................)</b></td>
        <td colspan="2"></td>
        <td colspan="4"><b>Perawat yang menyerahkan,<br /><br /><br /><br /><br /><br /><b><b>(........................................)</b></td>
    </tr>
</table>