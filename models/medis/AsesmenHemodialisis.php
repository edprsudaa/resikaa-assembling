<?php

namespace app\models\medis;

use Yii;
use app\models\pegawai\TbPegawai;
use app\models\pendaftaran\Layanan;
/**
 * This is the model class for table "medis.asesmen_hemodialisis".
 *
 * @property int $id
 * @property int $layanan_id
 * @property int $perawat_id
 * @property string|null $anamnesis_sumber
 * @property string|null $anamnesis_keluhan
 * @property string|null $riwayat_penyakit_sekarang
 * @property string|null $riwayat_penyakit_dahulu
 * @property string|null $riwayat_operasi
 * @property string|null $riwayat_pengobatan_tb
 * @property string|null $riwayat_pengobatan_lain
 * @property string|null $riwayat_penyakit_keluarga
 * @property string|null $alergi
 * @property string|null $status_sosial
 * @property string|null $ekonomi
 * @property string|null $imunisasi
 * @property string|null $status_psikologi
 * @property string|null $status_mental
 * @property string|null $riwayat_perilaku_kekerasan
 * @property string|null $ketergantungan_obat
 * @property string|null $ketergantungan_alkohol
 * @property string|null $permintaan_informasi
 * @property string|null $ps_keadaan_umum
 * @property string|null $ps_tekanan_darah
 * @property string|null $ps_nadi
 * @property string|null $ps_fnadi
 * @property string|null $ps_respirasi
 * @property string|null $ps_frespirasi
 * @property string|null $ps_konjungtiva
 * @property string|null $ps_ekstrimitas
 * @property int|null $ps_berat_badan_prehd
 * @property int|null $ps_berat_badan_bbkering
 * @property int|null $ps_berat_badan_bbhd
 * @property int|null $ps_berat_badan_posthd
 * @property string|null $ps_akses_vaskular
 * @property string|null $pp_penunjang
 * @property string|null $pp_gizi_tanggal
 * @property string|null $pp_gizi_mis_skor
 * @property string|null $pp_gizi_sga_skor
 * @property string|null $pp_gizi_kesimpulan
 * @property string|null $im_model
 * @property string|null $im_dializer
 * @property string|null $im_dialisat
 * @property string|null $im_rh_td
 * @property string|null $im_rh_qb
 * @property string|null $im_rh_qd
 * @property string|null $im_rh_uf_goal
 * @property string|null $im_pp_bicarbonat
 * @property string|null $im_pp_conductivity
 * @property string|null $im_pp_temperatur
 * @property string|null $h_dosis_sirkulasi
 * @property string|null $h_dosis_awal
 * @property string|null $h_dosis_m_continue
 * @property string|null $h_dosis_m_intermitten
 * @property string|null $h_dosis_m_total
 * @property string|null $h_lmwh
 * @property string|null $h_tanpa_heparin_penyebab
 * @property string|null $im_catatan_lain
 * @property int|null $im_dokter_id
 * @property string|null $ik_pre_hd_qb
 * @property string|null $ik_pre_hd_uf_rate
 * @property string|null $ik_pre_hd_tek_drh
 * @property string|null $ik_pre_hd_nadi
 * @property string|null $ik_pre_hd_suhu
 * @property string|null $ik_pre_hd_resp
 * @property string|null $ik_pre_hd_intake_nacl
 * @property string|null $ik_pre_hd_intake_dextro
 * @property string|null $ik_pre_hd_intake_makan_minum
 * @property string|null $ik_pre_hd_intake_lain_lain
 * @property string|null $ik_pre_hd_intake_output_uf_volume
 * @property string|null $ik_pre_hd_intake_keterangan_lain
 * @property string|null $ik_intra_hd_qb_1
 * @property string|null $ik_intra_hd_uf_rate_1
 * @property string|null $ik_intra_hd_tek_drh_1
 * @property string|null $ik_intra_hd_nadi_1
 * @property string|null $ik_intra_hd_suhu_1
 * @property string|null $ik_intra_hd_resp_1
 * @property string|null $ik_intra_hd_intake_nacl_1
 * @property string|null $ik_intra_hd_intake_dextro_1
 * @property string|null $ik_intra_hd_intake_makan_minum_1
 * @property string|null $ik_intra_hd_intake_lain_lain_1
 * @property string|null $ik_intra_hd_intake_output_uf_volume_1
 * @property string|null $ik_intra_hd_intake_keterangan_lain_1
 * @property string|null $ik_intra_hd_qb_2
 * @property string|null $ik_intra_hd_uf_rate_2
 * @property string|null $ik_intra_hd_tek_drh_2
 * @property string|null $ik_intra_hd_nadi_2
 * @property string|null $ik_intra_hd_suhu_2
 * @property string|null $ik_intra_hd_resp_2
 * @property string|null $ik_intra_hd_intake_nacl_2
 * @property string|null $ik_intra_hd_intake_dextro_2
 * @property string|null $ik_intra_hd_intake_makan_minum_2
 * @property string|null $ik_intra_hd_intake_lain_lain_2
 * @property string|null $ik_intra_hd_intake_output_uf_volume_2
 * @property string|null $ik_intra_hd_intake_keterangan_lain_2
 * @property string|null $ik_intra_hd_qb_3
 * @property string|null $ik_intra_hd_uf_rate_3
 * @property string|null $ik_intra_hd_tek_drh_3
 * @property string|null $ik_intra_hd_nadi_3
 * @property string|null $ik_intra_hd_suhu_3
 * @property string|null $ik_intra_hd_resp_3
 * @property string|null $ik_intra_hd_intake_nacl_3
 * @property string|null $ik_intra_hd_intake_dextro_3
 * @property string|null $ik_intra_hd_intake_makan_minum_3
 * @property string|null $ik_intra_hd_intake_lain_lain_3
 * @property string|null $ik_intra_hd_intake_output_uf_volume_3
 * @property string|null $ik_intra_hd_intake_keterangan_lain_3
 * @property string|null $ik_intra_hd_qb_4
 * @property string|null $ik_intra_hd_uf_rate_4
 * @property string|null $ik_intra_hd_tek_drh_4
 * @property string|null $ik_intra_hd_nadi_4
 * @property string|null $ik_intra_hd_suhu_4
 * @property string|null $ik_intra_hd_resp_4
 * @property string|null $ik_intra_hd_intake_nacl_4
 * @property string|null $ik_intra_hd_intake_dextro_4
 * @property string|null $ik_intra_hd_intake_makan_minum_4
 * @property string|null $ik_intra_hd_intake_lain_lain_4
 * @property string|null $ik_intra_hd_intake_output_uf_volume_4
 * @property string|null $ik_intra_hd_intake_keterangan_lain_4
 * @property string|null $ik_intra_hd_qb_5
 * @property string|null $ik_intra_hd_uf_rate_5
 * @property string|null $ik_intra_hd_tek_drh_5
 * @property string|null $ik_intra_hd_nadi_5
 * @property string|null $ik_intra_hd_suhu_5
 * @property string|null $ik_intra_hd_resp_5
 * @property string|null $ik_intra_hd_intake_nacl_5
 * @property string|null $ik_intra_hd_intake_dextro_5
 * @property string|null $ik_intra_hd_intake_makan_minum_5
 * @property string|null $ik_intra_hd_intake_lain_lain_5
 * @property string|null $ik_intra_hd_intake_output_uf_volume_5
 * @property string|null $ik_intra_hd_intake_keterangan_lain_5
 * @property string|null $ik_intra_hd_qb_6
 * @property string|null $ik_intra_hd_uf_rate_6
 * @property string|null $ik_intra_hd_tek_drh_6
 * @property string|null $ik_intra_hd_nadi_6
 * @property string|null $ik_intra_hd_suhu_6
 * @property string|null $ik_intra_hd_resp_6
 * @property string|null $ik_intra_hd_intake_nacl_6
 * @property string|null $ik_intra_hd_intake_dextro_6
 * @property string|null $ik_intra_hd_intake_makan_minum_6
 * @property string|null $ik_intra_hd_intake_lain_lain_6
 * @property string|null $ik_intra_hd_intake_output_uf_volume_6
 * @property string|null $ik_intra_hd_intake_keterangan_lain_6
 * @property string|null $ik_intra_hd_qb_7
 * @property string|null $ik_intra_hd_uf_rate_7
 * @property string|null $ik_intra_hd_tek_drh_7
 * @property string|null $ik_intra_hd_nadi_7
 * @property string|null $ik_intra_hd_suhu_7
 * @property string|null $ik_intra_hd_resp_7
 * @property string|null $ik_intra_hd_intake_nacl_7
 * @property string|null $ik_intra_hd_intake_dextro_7
 * @property string|null $ik_intra_hd_intake_makan_minum_7
 * @property string|null $ik_intra_hd_intake_lain_lain_7
 * @property string|null $ik_intra_hd_intake_output_uf_volume_7
 * @property string|null $ik_intra_hd_intake_keterangan_lain_7
 * @property string|null $ik_post_hd_qb
 * @property string|null $ik_post_hd_uf_rate
 * @property string|null $ik_post_hd_tek_drh
 * @property string|null $ik_post_hd_nadi
 * @property string|null $ik_post_hd_suhu
 * @property string|null $ik_post_hd_resp
 * @property string|null $ik_post_hd_intake_nacl
 * @property string|null $ik_post_hd_intake_dextro
 * @property string|null $ik_post_hd_intake_makan_minum
 * @property string|null $ik_post_hd_intake_lain_lain
 * @property string|null $ik_post_hd_intake_output_uf_volume
 * @property string|null $ik_post_hd_intake_keterangan_lain
 * @property string|null $ik_komplikasi_selama_hd
 * @property string|null $hambatan_dalam_pembelajaran
 * @property string|null $dibutuhkan_penerjamah
 * @property string|null $bahasa_isyarat
 * @property string|null $kebutuhan_edukasi
 * @property string|null $perencanaan_pasien_pulang
 * @property string|null $ek_obat
 * @property string|null $ek_catatan_medis
 * @property int|null $akses_vaskuler_dokter_id
 * @property int $batal
 * @property string|null $tanggal_batal
 * @property int $draf
 * @property string|null $tanggal_final
 * @property string|null $created_at
 * @property int $created_by
 * @property string|null $updated_at
 * @property int|null $updated_by
 * @property string|null $log_data
 * @property int $is_deleted
 */
class AsesmenHemodialisis extends BaseModelAR
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'medis.asesmen_hemodialisis';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['layanan_id', 'perawat_id'], 'required'],
            [['layanan_id', 'perawat_id', 'ps_berat_badan_prehd', 'ps_berat_badan_bbkering', 'ps_berat_badan_bbhd', 'ps_berat_badan_posthd', 'im_dokter_id', 'akses_vaskuler_dokter_id', 'batal', 'draf', 'created_by', 'updated_by', 'is_deleted'], 'default', 'value' => null],
            [['layanan_id', 'perawat_id', 'ps_berat_badan_prehd', 'ps_berat_badan_bbkering', 'ps_berat_badan_bbhd', 'ps_berat_badan_posthd', 'im_dokter_id', 'akses_vaskuler_dokter_id', 'batal', 'draf', 'created_by', 'updated_by', 'is_deleted'], 'integer'],
            [['anamnesis_sumber', 'anamnesis_keluhan', 'riwayat_penyakit_sekarang', 'riwayat_penyakit_dahulu', 'riwayat_operasi', 'riwayat_pengobatan_tb', 'riwayat_pengobatan_lain', 'riwayat_penyakit_keluarga', 'alergi', 'status_sosial', 'ekonomi', 'imunisasi', 'status_psikologi', 'status_mental', 'riwayat_perilaku_kekerasan', 'ketergantungan_obat', 'ketergantungan_alkohol', 'permintaan_informasi', 'ps_keadaan_umum', 'ps_tekanan_darah', 'ps_nadi', 'ps_fnadi', 'ps_respirasi', 'ps_frespirasi', 'ps_konjungtiva', 'ps_ekstrimitas', 'ps_akses_vaskular', 'pp_penunjang', 'pp_gizi_tanggal', 'pp_gizi_mis_skor', 'pp_gizi_sga_skor', 'pp_gizi_kesimpulan', 'im_model', 'im_dializer', 'im_dialisat', 'im_rh_td', 'im_rh_qb', 'im_rh_qd', 'im_rh_uf_goal', 'im_pp_bicarbonat', 'im_pp_conductivity', 'im_pp_temperatur', 'h_dosis_sirkulasi', 'h_dosis_awal', 'h_dosis_m_continue', 'h_dosis_m_intermitten', 'h_dosis_m_total', 'h_lmwh', 'h_tanpa_heparin_penyebab', 'im_catatan_lain', 'ik_pre_hd_qb', 'ik_pre_hd_uf_rate', 'ik_pre_hd_tek_drh', 'ik_pre_hd_nadi', 'ik_pre_hd_suhu', 'ik_pre_hd_resp', 'ik_pre_hd_intake_nacl', 'ik_pre_hd_intake_dextro', 'ik_pre_hd_intake_makan_minum', 'ik_pre_hd_intake_lain_lain', 'ik_pre_hd_intake_output_uf_volume', 'ik_pre_hd_intake_keterangan_lain', 'ik_intra_hd_qb_1', 'ik_intra_hd_uf_rate_1', 'ik_intra_hd_tek_drh_1', 'ik_intra_hd_nadi_1', 'ik_intra_hd_suhu_1', 'ik_intra_hd_resp_1', 'ik_intra_hd_intake_nacl_1', 'ik_intra_hd_intake_dextro_1', 'ik_intra_hd_intake_makan_minum_1', 'ik_intra_hd_intake_lain_lain_1', 'ik_intra_hd_intake_output_uf_volume_1', 'ik_intra_hd_intake_keterangan_lain_1', 'ik_intra_hd_qb_2', 'ik_intra_hd_uf_rate_2', 'ik_intra_hd_tek_drh_2', 'ik_intra_hd_nadi_2', 'ik_intra_hd_suhu_2', 'ik_intra_hd_resp_2', 'ik_intra_hd_intake_nacl_2', 'ik_intra_hd_intake_dextro_2', 'ik_intra_hd_intake_makan_minum_2', 'ik_intra_hd_intake_lain_lain_2', 'ik_intra_hd_intake_output_uf_volume_2', 'ik_intra_hd_intake_keterangan_lain_2', 'ik_intra_hd_qb_3', 'ik_intra_hd_uf_rate_3', 'ik_intra_hd_tek_drh_3', 'ik_intra_hd_nadi_3', 'ik_intra_hd_suhu_3', 'ik_intra_hd_resp_3', 'ik_intra_hd_intake_nacl_3', 'ik_intra_hd_intake_dextro_3', 'ik_intra_hd_intake_makan_minum_3', 'ik_intra_hd_intake_lain_lain_3', 'ik_intra_hd_intake_output_uf_volume_3', 'ik_intra_hd_intake_keterangan_lain_3', 'ik_intra_hd_qb_4', 'ik_intra_hd_uf_rate_4', 'ik_intra_hd_tek_drh_4', 'ik_intra_hd_nadi_4', 'ik_intra_hd_suhu_4', 'ik_intra_hd_resp_4', 'ik_intra_hd_intake_nacl_4', 'ik_intra_hd_intake_dextro_4', 'ik_intra_hd_intake_makan_minum_4', 'ik_intra_hd_intake_lain_lain_4', 'ik_intra_hd_intake_output_uf_volume_4', 'ik_intra_hd_intake_keterangan_lain_4', 'ik_intra_hd_qb_5', 'ik_intra_hd_uf_rate_5', 'ik_intra_hd_tek_drh_5', 'ik_intra_hd_nadi_5', 'ik_intra_hd_suhu_5', 'ik_intra_hd_resp_5', 'ik_intra_hd_intake_nacl_5', 'ik_intra_hd_intake_dextro_5', 'ik_intra_hd_intake_makan_minum_5', 'ik_intra_hd_intake_lain_lain_5', 'ik_intra_hd_intake_output_uf_volume_5', 'ik_intra_hd_intake_keterangan_lain_5', 'ik_intra_hd_qb_6', 'ik_intra_hd_uf_rate_6', 'ik_intra_hd_tek_drh_6', 'ik_intra_hd_nadi_6', 'ik_intra_hd_suhu_6', 'ik_intra_hd_resp_6', 'ik_intra_hd_intake_nacl_6', 'ik_intra_hd_intake_dextro_6', 'ik_intra_hd_intake_makan_minum_6', 'ik_intra_hd_intake_lain_lain_6', 'ik_intra_hd_intake_output_uf_volume_6', 'ik_intra_hd_intake_keterangan_lain_6', 'ik_intra_hd_qb_7', 'ik_intra_hd_uf_rate_7', 'ik_intra_hd_tek_drh_7', 'ik_intra_hd_nadi_7', 'ik_intra_hd_suhu_7', 'ik_intra_hd_resp_7', 'ik_intra_hd_intake_nacl_7', 'ik_intra_hd_intake_dextro_7', 'ik_intra_hd_intake_makan_minum_7', 'ik_intra_hd_intake_lain_lain_7', 'ik_intra_hd_intake_output_uf_volume_7', 'ik_intra_hd_intake_keterangan_lain_7', 'ik_post_hd_qb', 'ik_post_hd_uf_rate', 'ik_post_hd_tek_drh', 'ik_post_hd_nadi', 'ik_post_hd_suhu', 'ik_post_hd_resp', 'ik_post_hd_intake_nacl', 'ik_post_hd_intake_dextro', 'ik_post_hd_intake_makan_minum', 'ik_post_hd_intake_lain_lain', 'ik_post_hd_intake_output_uf_volume', 'ik_post_hd_intake_keterangan_lain', 'ik_komplikasi_selama_hd', 'hambatan_dalam_pembelajaran', 'dibutuhkan_penerjamah', 'bahasa_isyarat', 'kebutuhan_edukasi', 'perencanaan_pasien_pulang', 'ek_obat', 'ek_catatan_medis', 'log_data'], 'string'],
            [['tanggal_batal', 'tanggal_final', 'created_at', 'updated_at'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'layanan_id' => 'Layanan ID',
            'perawat_id' => 'Perawat ID',
            'anamnesis_sumber' => 'Anamnesis Sumber',
            'anamnesis_keluhan' => 'Anamnesis Keluhan',
            'riwayat_penyakit_sekarang' => 'Riwayat Penyakit Sekarang',
            'riwayat_penyakit_dahulu' => 'Riwayat Penyakit Dahulu',
            'riwayat_operasi' => 'Riwayat Operasi',
            'riwayat_pengobatan_tb' => 'Riwayat Pengobatan Tb',
            'riwayat_pengobatan_lain' => 'Riwayat Pengobatan Lain',
            'riwayat_penyakit_keluarga' => 'Riwayat Penyakit Keluarga',
            'alergi' => 'Alergi',
            'status_sosial' => 'Status Sosial',
            'ekonomi' => 'Ekonomi',
            'imunisasi' => 'Imunisasi',
            'status_psikologi' => 'Status Psikologi',
            'status_mental' => 'Status Mental',
            'riwayat_perilaku_kekerasan' => 'Riwayat Perilaku Kekerasan',
            'ketergantungan_obat' => 'Ketergantungan Obat',
            'ketergantungan_alkohol' => 'Ketergantungan Alkohol',
            'permintaan_informasi' => 'Permintaan Informasi',
            'ps_keadaan_umum' => 'Ps Keadaan Umum',
            'ps_tekanan_darah' => 'Ps Tekanan Darah',
            'ps_nadi' => 'Ps Nadi',
            'ps_fnadi' => 'Ps Fnadi',
            'ps_respirasi' => 'Ps Respirasi',
            'ps_frespirasi' => 'Ps Frespirasi',
            'ps_konjungtiva' => 'Ps Konjungtiva',
            'ps_ekstrimitas' => 'Ps Ekstrimitas',
            'ps_berat_badan_prehd' => 'Ps Berat Badan Prehd',
            'ps_berat_badan_bbkering' => 'Ps Berat Badan Bbkering',
            'ps_berat_badan_bbhd' => 'Ps Berat Badan Bbhd',
            'ps_berat_badan_posthd' => 'Ps Berat Badan Posthd',
            'ps_akses_vaskular' => 'Ps Akses Vaskular',
            'pp_penunjang' => 'Pp Penunjang',
            'pp_gizi_tanggal' => 'Pp Gizi Tanggal',
            'pp_gizi_mis_skor' => 'Pp Gizi Mis Skor',
            'pp_gizi_sga_skor' => 'Pp Gizi Sga Skor',
            'pp_gizi_kesimpulan' => 'Pp Gizi Kesimpulan',
            'im_model' => 'Im Model',
            'im_dializer' => 'Im Dializer',
            'im_dialisat' => 'Im Dialisat',
            'im_rh_td' => 'Im Rh Td',
            'im_rh_qb' => 'Im Rh Qb',
            'im_rh_qd' => 'Im Rh Qd',
            'im_rh_uf_goal' => 'Im Rh Uf Goal',
            'im_pp_bicarbonat' => 'Im Pp Bicarbonat',
            'im_pp_conductivity' => 'Im Pp Conductivity',
            'im_pp_temperatur' => 'Im Pp Temperatur',
            'h_dosis_sirkulasi' => 'H Dosis Sirkulasi',
            'h_dosis_awal' => 'H Dosis Awal',
            'h_dosis_m_continue' => 'H Dosis M Continue',
            'h_dosis_m_intermitten' => 'H Dosis M Intermitten',
            'h_dosis_m_total' => 'H Dosis M Total',
            'h_lmwh' => 'H Lmwh',
            'h_tanpa_heparin_penyebab' => 'H Tanpa Heparin Penyebab',
            'im_catatan_lain' => 'Im Catatan Lain',
            'im_dokter_id' => 'Im Dokter ID',
            'ik_pre_hd_qb' => 'Ik Pre Hd Qb',
            'ik_pre_hd_uf_rate' => 'Ik Pre Hd Uf Rate',
            'ik_pre_hd_tek_drh' => 'Ik Pre Hd Tek Drh',
            'ik_pre_hd_nadi' => 'Ik Pre Hd Nadi',
            'ik_pre_hd_suhu' => 'Ik Pre Hd Suhu',
            'ik_pre_hd_resp' => 'Ik Pre Hd Resp',
            'ik_pre_hd_intake_nacl' => 'Ik Pre Hd Intake Nacl',
            'ik_pre_hd_intake_dextro' => 'Ik Pre Hd Intake Dextro',
            'ik_pre_hd_intake_makan_minum' => 'Ik Pre Hd Intake Makan Minum',
            'ik_pre_hd_intake_lain_lain' => 'Ik Pre Hd Intake Lain Lain',
            'ik_pre_hd_intake_output_uf_volume' => 'Ik Pre Hd Intake Output Uf Volume',
            'ik_pre_hd_intake_keterangan_lain' => 'Ik Pre Hd Intake Keterangan Lain',
            'ik_intra_hd_qb_1' => 'Ik Intra Hd Qb 1',
            'ik_intra_hd_uf_rate_1' => 'Ik Intra Hd Uf Rate 1',
            'ik_intra_hd_tek_drh_1' => 'Ik Intra Hd Tek Drh 1',
            'ik_intra_hd_nadi_1' => 'Ik Intra Hd Nadi 1',
            'ik_intra_hd_suhu_1' => 'Ik Intra Hd Suhu 1',
            'ik_intra_hd_resp_1' => 'Ik Intra Hd Resp 1',
            'ik_intra_hd_intake_nacl_1' => 'Ik Intra Hd Intake Nacl 1',
            'ik_intra_hd_intake_dextro_1' => 'Ik Intra Hd Intake Dextro 1',
            'ik_intra_hd_intake_makan_minum_1' => 'Ik Intra Hd Intake Makan Minum 1',
            'ik_intra_hd_intake_lain_lain_1' => 'Ik Intra Hd Intake Lain Lain 1',
            'ik_intra_hd_intake_output_uf_volume_1' => 'Ik Intra Hd Intake Output Uf Volume 1',
            'ik_intra_hd_intake_keterangan_lain_1' => 'Ik Intra Hd Intake Keterangan Lain 1',
            'ik_intra_hd_qb_2' => 'Ik Intra Hd Qb 2',
            'ik_intra_hd_uf_rate_2' => 'Ik Intra Hd Uf Rate 2',
            'ik_intra_hd_tek_drh_2' => 'Ik Intra Hd Tek Drh 2',
            'ik_intra_hd_nadi_2' => 'Ik Intra Hd Nadi 2',
            'ik_intra_hd_suhu_2' => 'Ik Intra Hd Suhu 2',
            'ik_intra_hd_resp_2' => 'Ik Intra Hd Resp 2',
            'ik_intra_hd_intake_nacl_2' => 'Ik Intra Hd Intake Nacl 2',
            'ik_intra_hd_intake_dextro_2' => 'Ik Intra Hd Intake Dextro 2',
            'ik_intra_hd_intake_makan_minum_2' => 'Ik Intra Hd Intake Makan Minum 2',
            'ik_intra_hd_intake_lain_lain_2' => 'Ik Intra Hd Intake Lain Lain 2',
            'ik_intra_hd_intake_output_uf_volume_2' => 'Ik Intra Hd Intake Output Uf Volume 2',
            'ik_intra_hd_intake_keterangan_lain_2' => 'Ik Intra Hd Intake Keterangan Lain 2',
            'ik_intra_hd_qb_3' => 'Ik Intra Hd Qb 3',
            'ik_intra_hd_uf_rate_3' => 'Ik Intra Hd Uf Rate 3',
            'ik_intra_hd_tek_drh_3' => 'Ik Intra Hd Tek Drh 3',
            'ik_intra_hd_nadi_3' => 'Ik Intra Hd Nadi 3',
            'ik_intra_hd_suhu_3' => 'Ik Intra Hd Suhu 3',
            'ik_intra_hd_resp_3' => 'Ik Intra Hd Resp 3',
            'ik_intra_hd_intake_nacl_3' => 'Ik Intra Hd Intake Nacl 3',
            'ik_intra_hd_intake_dextro_3' => 'Ik Intra Hd Intake Dextro 3',
            'ik_intra_hd_intake_makan_minum_3' => 'Ik Intra Hd Intake Makan Minum 3',
            'ik_intra_hd_intake_lain_lain_3' => 'Ik Intra Hd Intake Lain Lain 3',
            'ik_intra_hd_intake_output_uf_volume_3' => 'Ik Intra Hd Intake Output Uf Volume 3',
            'ik_intra_hd_intake_keterangan_lain_3' => 'Ik Intra Hd Intake Keterangan Lain 3',
            'ik_intra_hd_qb_4' => 'Ik Intra Hd Qb 4',
            'ik_intra_hd_uf_rate_4' => 'Ik Intra Hd Uf Rate 4',
            'ik_intra_hd_tek_drh_4' => 'Ik Intra Hd Tek Drh 4',
            'ik_intra_hd_nadi_4' => 'Ik Intra Hd Nadi 4',
            'ik_intra_hd_suhu_4' => 'Ik Intra Hd Suhu 4',
            'ik_intra_hd_resp_4' => 'Ik Intra Hd Resp 4',
            'ik_intra_hd_intake_nacl_4' => 'Ik Intra Hd Intake Nacl 4',
            'ik_intra_hd_intake_dextro_4' => 'Ik Intra Hd Intake Dextro 4',
            'ik_intra_hd_intake_makan_minum_4' => 'Ik Intra Hd Intake Makan Minum 4',
            'ik_intra_hd_intake_lain_lain_4' => 'Ik Intra Hd Intake Lain Lain 4',
            'ik_intra_hd_intake_output_uf_volume_4' => 'Ik Intra Hd Intake Output Uf Volume 4',
            'ik_intra_hd_intake_keterangan_lain_4' => 'Ik Intra Hd Intake Keterangan Lain 4',
            'ik_intra_hd_qb_5' => 'Ik Intra Hd Qb 5',
            'ik_intra_hd_uf_rate_5' => 'Ik Intra Hd Uf Rate 5',
            'ik_intra_hd_tek_drh_5' => 'Ik Intra Hd Tek Drh 5',
            'ik_intra_hd_nadi_5' => 'Ik Intra Hd Nadi 5',
            'ik_intra_hd_suhu_5' => 'Ik Intra Hd Suhu 5',
            'ik_intra_hd_resp_5' => 'Ik Intra Hd Resp 5',
            'ik_intra_hd_intake_nacl_5' => 'Ik Intra Hd Intake Nacl 5',
            'ik_intra_hd_intake_dextro_5' => 'Ik Intra Hd Intake Dextro 5',
            'ik_intra_hd_intake_makan_minum_5' => 'Ik Intra Hd Intake Makan Minum 5',
            'ik_intra_hd_intake_lain_lain_5' => 'Ik Intra Hd Intake Lain Lain 5',
            'ik_intra_hd_intake_output_uf_volume_5' => 'Ik Intra Hd Intake Output Uf Volume 5',
            'ik_intra_hd_intake_keterangan_lain_5' => 'Ik Intra Hd Intake Keterangan Lain 5',
            'ik_intra_hd_qb_6' => 'Ik Intra Hd Qb 6',
            'ik_intra_hd_uf_rate_6' => 'Ik Intra Hd Uf Rate 6',
            'ik_intra_hd_tek_drh_6' => 'Ik Intra Hd Tek Drh 6',
            'ik_intra_hd_nadi_6' => 'Ik Intra Hd Nadi 6',
            'ik_intra_hd_suhu_6' => 'Ik Intra Hd Suhu 6',
            'ik_intra_hd_resp_6' => 'Ik Intra Hd Resp 6',
            'ik_intra_hd_intake_nacl_6' => 'Ik Intra Hd Intake Nacl 6',
            'ik_intra_hd_intake_dextro_6' => 'Ik Intra Hd Intake Dextro 6',
            'ik_intra_hd_intake_makan_minum_6' => 'Ik Intra Hd Intake Makan Minum 6',
            'ik_intra_hd_intake_lain_lain_6' => 'Ik Intra Hd Intake Lain Lain 6',
            'ik_intra_hd_intake_output_uf_volume_6' => 'Ik Intra Hd Intake Output Uf Volume 6',
            'ik_intra_hd_intake_keterangan_lain_6' => 'Ik Intra Hd Intake Keterangan Lain 6',
            'ik_intra_hd_qb_7' => 'Ik Intra Hd Qb 7',
            'ik_intra_hd_uf_rate_7' => 'Ik Intra Hd Uf Rate 7',
            'ik_intra_hd_tek_drh_7' => 'Ik Intra Hd Tek Drh 7',
            'ik_intra_hd_nadi_7' => 'Ik Intra Hd Nadi 7',
            'ik_intra_hd_suhu_7' => 'Ik Intra Hd Suhu 7',
            'ik_intra_hd_resp_7' => 'Ik Intra Hd Resp 7',
            'ik_intra_hd_intake_nacl_7' => 'Ik Intra Hd Intake Nacl 7',
            'ik_intra_hd_intake_dextro_7' => 'Ik Intra Hd Intake Dextro 7',
            'ik_intra_hd_intake_makan_minum_7' => 'Ik Intra Hd Intake Makan Minum 7',
            'ik_intra_hd_intake_lain_lain_7' => 'Ik Intra Hd Intake Lain Lain 7',
            'ik_intra_hd_intake_output_uf_volume_7' => 'Ik Intra Hd Intake Output Uf Volume 7',
            'ik_intra_hd_intake_keterangan_lain_7' => 'Ik Intra Hd Intake Keterangan Lain 7',
            'ik_post_hd_qb' => 'Ik Post Hd Qb',
            'ik_post_hd_uf_rate' => 'Ik Post Hd Uf Rate',
            'ik_post_hd_tek_drh' => 'Ik Post Hd Tek Drh',
            'ik_post_hd_nadi' => 'Ik Post Hd Nadi',
            'ik_post_hd_suhu' => 'Ik Post Hd Suhu',
            'ik_post_hd_resp' => 'Ik Post Hd Resp',
            'ik_post_hd_intake_nacl' => 'Ik Post Hd Intake Nacl',
            'ik_post_hd_intake_dextro' => 'Ik Post Hd Intake Dextro',
            'ik_post_hd_intake_makan_minum' => 'Ik Post Hd Intake Makan Minum',
            'ik_post_hd_intake_lain_lain' => 'Ik Post Hd Intake Lain Lain',
            'ik_post_hd_intake_output_uf_volume' => 'Ik Post Hd Intake Output Uf Volume',
            'ik_post_hd_intake_keterangan_lain' => 'Ik Post Hd Intake Keterangan Lain',
            'ik_komplikasi_selama_hd' => 'Ik Komplikasi Selama Hd',
            'hambatan_dalam_pembelajaran' => 'Hambatan Dalam Pembelajaran',
            'dibutuhkan_penerjamah' => 'Dibutuhkan Penerjamah',
            'bahasa_isyarat' => 'Bahasa Isyarat',
            'kebutuhan_edukasi' => 'Kebutuhan Edukasi',
            'perencanaan_pasien_pulang' => 'Perencanaan Pasien Pulang',
            'ek_obat' => 'Ek Obat',
            'ek_catatan_medis' => 'Ek Catatan Medis',
            'akses_vaskuler_dokter_id' => 'Akses Vaskuler Dokter ID',
            'batal' => 'Batal',
            'tanggal_batal' => 'Tanggal Batal',
            'draf' => 'Draf',
            'tanggal_final' => 'Tanggal Final',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
            'log_data' => 'Log Data',
            'is_deleted' => 'Is Deleted',
        ];
    }

    public function beforeSave($insert) {
        if ($insert) {
            $this->batal = 0;
            $this->draf = 1;
            $this->is_deleted = 0;
        }
        return parent::beforeSave($insert); // TODO: Change the autogenerated stub
    }
    public static function find()
    {
        return new AsesmenHemodialisisQuery(get_called_class());
    }
    public function getDokter()
    {
        return $this->hasOne(TbPegawai::className(),['pegawai_id'=>'im_dokter_id']);
    }
    public function getPerawat()
    {
        return $this->hasOne(TbPegawai::className(),['pegawai_id'=>'perawat_id']);
    }
    public function getLayanan()
    {
        return $this->hasOne(Layanan::className(),['id'=>'layanan_id']);
    }
}
