<?php

namespace app\models\medis;

use Yii;
use app\models\pegawai\TbPegawai;
use app\models\pendaftaran\Layanan;
/**
 * This is the model class for table "medis.asesmen_awal_keperawatan_neonatus".
 *
 * @property int $id
 * @property int $layanan_id
 * @property int $perawat_id
 * @property int|null $rb_apgar_score_1
 * @property int|null $rb_apgar_score_5
 * @property string|null $rb_usia_gestasi
 * @property int|null $rb_anak_ke
 * @property int|null $rb_bb
 * @property int|null $rb_pb
 * @property int|null $rb_lk
 * @property int|null $rb_ld
 * @property int|null $rb_ll
 * @property string|null $rb_aspirasi_meconium
 * @property string|null $rb_prolaps_tali_pusar
 * @property string|null $rb_ketuban_pecah_dini
 * @property string|null $kbm_ipn_tgl_jam
 * @property int|null $kbm_ipn_bb
 * @property string|null $kbm_ipn_kesadaran
 * @property int|null $kbm_ipn_suhu
 * @property string|null $kbm_ipn_rujukan
 * @property string|null $kbm_ipn_keluhan
 * @property int|null $ri_usia
 * @property int|null $ri_g
 * @property int|null $ri_p
 * @property int|null $ri_a
 * @property string|null $ri_jenis_persalinan_spontan
 * @property string|null $ri_jenis_persalinan_sectio_caesarea
 * @property string|null $ri_pervaginam_forceps
 * @property string|null $ri_pervaginam_ve
 * @property string|null $ri_komplikasi_kehamilan
 * @property string|null $pfn_refleks_moro
 * @property string|null $pfn_refleks_menggenggam
 * @property string|null $pfn_refleks_rooting_menghisap
 * @property string|null $pfn_refleks_tonus_aktifitas
 * @property string|null $pfn_refleks_menangis
 * @property string|null $pfn_kl_fontanel_anterior
 * @property string|null $pfn_kl_gambaran_wajah
 * @property int|null $pfn_kl_kepala_lingkar_kepala
 * @property string|null $pfn_kl_kepala_trauma
 * @property string|null $pfn_kl_mata
 * @property string|null $pfn_kl_mata_kelainan
 * @property string|null $pfn_kl_telinga
 * @property string|null $pfn_kl_hidung
 * @property int|null $rk_anc_jumlah
 * @property string|null $rk_anc_tempat
 * @property int|null $rk_tb
 * @property int|null $rk_bb_hamil
 * @property int|null $rk_sebelum_hamil
 * @property string|null $rk_merokok
 * @property string|null $rk_alkohol
 * @property string|null $rk_minum_jamu
 * @property string|null $rk_obat_obatan
 * @property string|null $rk_pd_diabetes
 * @property string|null $rk_pd_hipertensi
 * @property string|null $rk_pd_tiroid
 * @property string|null $rk_pd_hiv
 * @property string|null $rk_pd_hepatitis
 * @property string|null $rk_pd_penyakit_lain
 * @property int|null $ku_berat_badan_masuk
 * @property string|null $ku_abn_nasal
 * @property string|null $ku_abn_bcpap
 * @property string|null $ku_abn_ventilator
 * @property string|null $ku_abn_neopuff
 * @property string|null $ku_sisper_nafas_cuping_hidung
 * @property string|null $ku_sisper_sianosis
 * @property string|null $ku_sisper_retraksi_dada
 * @property string|null $ku_sisper_bunyi_paru
 * @property string|null $ku_sisper_bunyi_jantung
 * @property string|null $ku_sisper_periode_apnne
 * @property string|null $ku_sisper_crt
 * @property string|null $ku_sispen_refleks_isap
 * @property string|null $ku_sispen_refleks_menelan
 * @property string|null $ku_sispen_bentuk_mulut
 * @property string|null $ku_sispen_kelainan_mulut
 * @property string|null $ku_sispen_abdomen
 * @property string|null $ku_sispen_bising_usus
 * @property string|null $ku_sispen_keluar_meconium
 * @property string|null $ku_sispen_warna_residu
 * @property string|null $ku_sispen_muntah
 * @property string|null $ku_kc_fontanel
 * @property string|null $ku_kc_mata
 * @property string|null $ku_kc_mukosa
 * @property string|null $ku_kc_cubitis_perut
 * @property string|null $ku_kc_urinasi
 * @property string|null $ku_kc_nadi
 * @property string|null $ku_kc_lain
 * @property string|null $ku_su_keadaan
 * @property string|null $ku_su_bentuk
 * @property string|null $ku_su_meatus_urinarius
 * @property string|null $ku_su_anus
 * @property string|null $ku_su_lain
 * @property string|null $ku_su_genitalia_wanita
 * @property string|null $ku_su_genitalia_pria
 * @property string|null $ku_st_perabaan
 * @property string|null $ku_st_bantuan_inkubator
 * @property string|null $ku_st_bantuan_blue_light
 * @property string|null $ku_st_bantuan_penghangat_radiant
 * @property string|null $ku_st_kondisi_ruangan
 * @property string|null $ku_st_suhu_ruangan
 * @property string|null $ku_st_treatmen_perawatan
 * @property string|null $ku_st_kelainan_lain
 * @property string|null $ku_bs_jarak_pandang
 * @property string|null $ku_bs_keterlibatan_ibu_ayah
 * @property string|null $ku_bs_pekerjaan_ayah
 * @property string|null $ku_bs_pekerjaan_ibu
 * @property string|null $ku_bs_lingkungan_rumah
 * @property string|null $ku_bs_agama_yg_dianut
 * @property string|null $ku_bs_kepercayaan_terhadap_adat_istiadat
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
class AsesmenAwalKeperawatanNeonatus extends BaseModelAR
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'medis.asesmen_awal_keperawatan_neonatus';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['layanan_id', 'perawat_id'], 'required'],
            [['layanan_id', 'perawat_id', 'rb_apgar_score_1', 'rb_apgar_score_5', 'rb_anak_ke', 'rb_bb', 'rb_pb', 'rb_lk', 'rb_ld', 'rb_ll', 'kbm_ipn_bb', 'kbm_ipn_suhu', 'ri_usia', 'ri_g', 'ri_p', 'ri_a', 'pfn_kl_kepala_lingkar_kepala', 'rk_anc_jumlah', 'rk_tb', 'rk_bb_hamil', 'rk_sebelum_hamil', 'ku_berat_badan_masuk', 'batal', 'draf', 'created_by', 'updated_by', 'is_deleted'], 'default', 'value' => null],
            [['layanan_id', 'perawat_id', 'rb_apgar_score_1', 'rb_apgar_score_5', 'rb_anak_ke', 'rb_bb', 'rb_pb', 'rb_lk', 'rb_ld', 'rb_ll', 'kbm_ipn_bb', 'kbm_ipn_suhu', 'ri_usia', 'ri_g', 'ri_p', 'ri_a', 'pfn_kl_kepala_lingkar_kepala', 'rk_anc_jumlah', 'rk_tb', 'rk_bb_hamil', 'rk_sebelum_hamil', 'ku_berat_badan_masuk', 'batal', 'draf', 'created_by', 'updated_by', 'is_deleted'], 'integer'],
            [['rb_usia_gestasi', 'rb_aspirasi_meconium', 'rb_prolaps_tali_pusar', 'rb_ketuban_pecah_dini', 'kbm_ipn_kesadaran', 'kbm_ipn_rujukan', 'kbm_ipn_keluhan', 'ri_jenis_persalinan_spontan', 'ri_jenis_persalinan_sectio_caesarea', 'ri_pervaginam_forceps', 'ri_pervaginam_ve', 'ri_komplikasi_kehamilan', 'pfn_refleks_moro', 'pfn_refleks_menggenggam', 'pfn_refleks_rooting_menghisap', 'pfn_refleks_tonus_aktifitas', 'pfn_refleks_menangis', 'pfn_kl_fontanel_anterior', 'pfn_kl_gambaran_wajah', 'pfn_kl_kepala_trauma', 'pfn_kl_mata', 'pfn_kl_mata_kelainan', 'pfn_kl_telinga', 'pfn_kl_hidung', 'rk_anc_tempat', 'rk_merokok', 'rk_alkohol', 'rk_minum_jamu', 'rk_obat_obatan', 'rk_pd_diabetes', 'rk_pd_hipertensi', 'rk_pd_tiroid', 'rk_pd_hiv', 'rk_pd_hepatitis', 'rk_pd_penyakit_lain', 'ku_abn_nasal', 'ku_abn_bcpap', 'ku_abn_ventilator', 'ku_abn_neopuff', 'ku_sisper_nafas_cuping_hidung', 'ku_sisper_sianosis', 'ku_sisper_retraksi_dada', 'ku_sisper_bunyi_paru', 'ku_sisper_bunyi_jantung', 'ku_sisper_periode_apnne', 'ku_sisper_crt', 'ku_sispen_refleks_isap', 'ku_sispen_refleks_menelan', 'ku_sispen_bentuk_mulut', 'ku_sispen_kelainan_mulut', 'ku_sispen_abdomen', 'ku_sispen_bising_usus', 'ku_sispen_keluar_meconium', 'ku_sispen_warna_residu', 'ku_sispen_muntah', 'ku_kc_fontanel', 'ku_kc_mata', 'ku_kc_mukosa', 'ku_kc_cubitis_perut', 'ku_kc_urinasi', 'ku_kc_nadi', 'ku_kc_lain', 'ku_su_keadaan', 'ku_su_bentuk', 'ku_su_meatus_urinarius', 'ku_su_anus', 'ku_su_lain', 'ku_su_genitalia_wanita', 'ku_su_genitalia_pria', 'ku_st_perabaan', 'ku_st_bantuan_inkubator', 'ku_st_bantuan_blue_light', 'ku_st_bantuan_penghangat_radiant', 'ku_st_kondisi_ruangan', 'ku_st_suhu_ruangan', 'ku_st_treatmen_perawatan', 'ku_st_kelainan_lain', 'ku_bs_jarak_pandang', 'ku_bs_keterlibatan_ibu_ayah', 'ku_bs_pekerjaan_ayah', 'ku_bs_pekerjaan_ibu', 'ku_bs_lingkungan_rumah', 'ku_bs_agama_yg_dianut', 'ku_bs_kepercayaan_terhadap_adat_istiadat', 'log_data'], 'string'],
            [['kbm_ipn_tgl_jam', 'tanggal_batal', 'tanggal_final', 'created_at', 'updated_at'], 'safe'],
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
            'rb_apgar_score_1' => 'Rb Apgar Score 1',
            'rb_apgar_score_5' => 'Rb Apgar Score 5',
            'rb_usia_gestasi' => 'Rb Usia Gestasi',
            'rb_anak_ke' => 'Rb Anak Ke',
            'rb_bb' => 'Rb Bb',
            'rb_pb' => 'Rb Pb',
            'rb_lk' => 'Rb Lk',
            'rb_ld' => 'Rb Ld',
            'rb_ll' => 'Rb Ll',
            'rb_aspirasi_meconium' => 'Rb Aspirasi Meconium',
            'rb_prolaps_tali_pusar' => 'Rb Prolaps Tali Pusar',
            'rb_ketuban_pecah_dini' => 'Rb Ketuban Pecah Dini',
            'kbm_ipn_tgl_jam' => 'Kbm Ipn Tgl Jam',
            'kbm_ipn_bb' => 'Kbm Ipn Bb',
            'kbm_ipn_kesadaran' => 'Kbm Ipn Kesadaran',
            'kbm_ipn_suhu' => 'Kbm Ipn Suhu',
            'kbm_ipn_rujukan' => 'Kbm Ipn Rujukan',
            'kbm_ipn_keluhan' => 'Kbm Ipn Keluhan',
            'ri_usia' => 'Ri Usia',
            'ri_g' => 'Ri G',
            'ri_p' => 'Ri P',
            'ri_a' => 'Ri A',
            'ri_jenis_persalinan_spontan' => 'Ri Jenis Persalinan Spontan',
            'ri_jenis_persalinan_sectio_caesarea' => 'Ri Jenis Persalinan Sectio Caesarea',
            'ri_pervaginam_forceps' => 'Ri Pervaginam Forceps',
            'ri_pervaginam_ve' => 'Ri Pervaginam Ve',
            'ri_komplikasi_kehamilan' => 'Ri Komplikasi Kehamilan',
            'pfn_refleks_moro' => 'Pfn Refleks Moro',
            'pfn_refleks_menggenggam' => 'Pfn Refleks Menggenggam',
            'pfn_refleks_rooting_menghisap' => 'Pfn Refleks Rooting Menghisap',
            'pfn_refleks_tonus_aktifitas' => 'Pfn Refleks Tonus Aktifitas',
            'pfn_refleks_menangis' => 'Pfn Refleks Menangis',
            'pfn_kl_fontanel_anterior' => 'Pfn Kl Fontanel Anterior',
            'pfn_kl_gambaran_wajah' => 'Pfn Kl Gambaran Wajah',
            'pfn_kl_kepala_lingkar_kepala' => 'Pfn Kl Kepala Lingkar Kepala',
            'pfn_kl_kepala_trauma' => 'Pfn Kl Kepala Trauma',
            'pfn_kl_mata' => 'Pfn Kl Mata',
            'pfn_kl_mata_kelainan' => 'Pfn Kl Mata Kelainan',
            'pfn_kl_telinga' => 'Pfn Kl Telinga',
            'pfn_kl_hidung' => 'Pfn Kl Hidung',
            'rk_anc_jumlah' => 'Rk Anc Jumlah',
            'rk_anc_tempat' => 'Rk Anc Tempat',
            'rk_tb' => 'Rk Tb',
            'rk_bb_hamil' => 'Rk Bb Hamil',
            'rk_sebelum_hamil' => 'Rk Sebelum Hamil',
            'rk_merokok' => 'Rk Merokok',
            'rk_alkohol' => 'Rk Alkohol',
            'rk_minum_jamu' => 'Rk Minum Jamu',
            'rk_obat_obatan' => 'Rk Obat Obatan',
            'rk_pd_diabetes' => 'Rk Pd Diabetes',
            'rk_pd_hipertensi' => 'Rk Pd Hipertensi',
            'rk_pd_tiroid' => 'Rk Pd Tiroid',
            'rk_pd_hiv' => 'Rk Pd Hiv',
            'rk_pd_hepatitis' => 'Rk Pd Hepatitis',
            'rk_pd_penyakit_lain' => 'Rk Pd Penyakit Lain',
            'ku_berat_badan_masuk' => 'Ku Berat Badan Masuk',
            'ku_abn_nasal' => 'Ku Abn Nasal',
            'ku_abn_bcpap' => 'Ku Abn Bcpap',
            'ku_abn_ventilator' => 'Ku Abn Ventilator',
            'ku_abn_neopuff' => 'Ku Abn Neopuff',
            'ku_sisper_nafas_cuping_hidung' => 'Ku Sisper Nafas Cuping Hidung',
            'ku_sisper_sianosis' => 'Ku Sisper Sianosis',
            'ku_sisper_retraksi_dada' => 'Ku Sisper Retraksi Dada',
            'ku_sisper_bunyi_paru' => 'Ku Sisper Bunyi Paru',
            'ku_sisper_bunyi_jantung' => 'Ku Sisper Bunyi Jantung',
            'ku_sisper_periode_apnne' => 'Ku Sisper Periode Apnne',
            'ku_sisper_crt' => 'Ku Sisper Crt',
            'ku_sispen_refleks_isap' => 'Ku Sispen Refleks Isap',
            'ku_sispen_refleks_menelan' => 'Ku Sispen Refleks Menelan',
            'ku_sispen_bentuk_mulut' => 'Ku Sispen Bentuk Mulut',
            'ku_sispen_kelainan_mulut' => 'Ku Sispen Kelainan Mulut',
            'ku_sispen_abdomen' => 'Ku Sispen Abdomen',
            'ku_sispen_bising_usus' => 'Ku Sispen Bising Usus',
            'ku_sispen_keluar_meconium' => 'Ku Sispen Keluar Meconium',
            'ku_sispen_warna_residu' => 'Ku Sispen Warna Residu',
            'ku_sispen_muntah' => 'Ku Sispen Muntah',
            'ku_kc_fontanel' => 'Ku Kc Fontanel',
            'ku_kc_mata' => 'Ku Kc Mata',
            'ku_kc_mukosa' => 'Ku Kc Mukosa',
            'ku_kc_cubitis_perut' => 'Ku Kc Cubitis Perut',
            'ku_kc_urinasi' => 'Ku Kc Urinasi',
            'ku_kc_nadi' => 'Ku Kc Nadi',
            'ku_kc_lain' => 'Ku Kc Lain',
            'ku_su_keadaan' => 'Ku Su Keadaan',
            'ku_su_bentuk' => 'Ku Su Bentuk',
            'ku_su_meatus_urinarius' => 'Ku Su Meatus Urinarius',
            'ku_su_anus' => 'Ku Su Anus',
            'ku_su_lain' => 'Ku Su Lain',
            'ku_su_genitalia_wanita' => 'Ku Su Genitalia Wanita',
            'ku_su_genitalia_pria' => 'Ku Su Genitalia Pria',
            'ku_st_perabaan' => 'Ku St Perabaan',
            'ku_st_bantuan_inkubator' => 'Ku St Bantuan Inkubator',
            'ku_st_bantuan_blue_light' => 'Ku St Bantuan Blue Light',
            'ku_st_bantuan_penghangat_radiant' => 'Ku St Bantuan Penghangat Radiant',
            'ku_st_kondisi_ruangan' => 'Ku St Kondisi Ruangan',
            'ku_st_suhu_ruangan' => 'Ku St Suhu Ruangan',
            'ku_st_treatmen_perawatan' => 'Ku St Treatmen Perawatan',
            'ku_st_kelainan_lain' => 'Ku St Kelainan Lain',
            'ku_bs_jarak_pandang' => 'Ku Bs Jarak Pandang',
            'ku_bs_keterlibatan_ibu_ayah' => 'Ku Bs Keterlibatan Ibu Ayah',
            'ku_bs_pekerjaan_ayah' => 'Ku Bs Pekerjaan Ayah',
            'ku_bs_pekerjaan_ibu' => 'Ku Bs Pekerjaan Ibu',
            'ku_bs_lingkungan_rumah' => 'Ku Bs Lingkungan Rumah',
            'ku_bs_agama_yg_dianut' => 'Ku Bs Agama Yg Dianut',
            'ku_bs_kepercayaan_terhadap_adat_istiadat' => 'Ku Bs Kepercayaan Terhadap Adat Istiadat',
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
        return new AsesmenAwalKeperawatanNeonatusQuery(get_called_class());
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
