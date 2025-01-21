<?php

namespace app\models\medis;

use Yii;
use app\models\pegawai\TbPegawai;
use app\models\pendaftaran\Layanan;

class AsesmenHemodialisaDokterLanjutan extends BaseModelAR
{

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'medis.asesmen_hemodialisa_dokter_lanjutan';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['layanan_id', 'perawat_id'], 'required'],
            [['layanan_id', 'perawat_id', 'batal', 'draf', 'created_by', 'updated_by', 'is_deleted'], 'default', 'value' => null],
            [['layanan_id', 'perawat_id', 'batal', 'draf', 'created_by', 'updated_by', 'is_deleted'], 'integer'],
            [['tanggal_batal', 'tanggal_final', 'created_at', 'updated_at','tanggal_asesmen'], 'safe'],
            [['log_data', 'diagnosis_ginjal', 'etiologi', 'penyulit', 'penyakit_penyerta', 'anamnesis', 'pemeriksaan_fisik', 'pengkajian_fisik_ulang', 'hbs_ag', 'ureum', 'natrium', 'fe_serum', 'anti_hcv', 'kreatinin', 'kalsium', 'tibc', 'anti_hiv', 'asam_urat', 'poforanorganik', 'sa_transferin', 'hemoglobin', 'kalium', 'gula_darah', 'target_pengobatan', 'frekuensi_hd', 'pencapaian_adekuasi_dialisis', 'lainnya',  'akses_sirkulasi', 'durasi_hd', 'uf_goal', 'bb_kering', 'kecepatan_aliran_darah', 'kecepatan_aliran_dialisat', 'heparinisasi', 'program_profilling', 'suhu', 'catatan_lain', 'perubahan_terapi', 'obat', 'catatan_medis', 'dializer_model', 'dializer_tipe_flux', 'dializer_status_penggunaan', 'resep_hd_status', 'resep_hd_td', 'resep_hd_qb', 'resep_hd_qd', 'resep_hd_uf_goal', 'dialisat', 'pp_na', 'pp_uf', 'pp_bicarbonat', 'pp_conductivity', 'pp_temperatur', 'dosis_sirkulasi', 'dosis_awal', 'dosis_continue', 'dosis_intermitten', 'dosis_total', 'program_bilas','lmwh','heparin','resep_hd_pre_op','resep_hd_sled','ktv_target'], 'string'],
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
            'batal' => 'Batal',
            'tanggal_batal' => 'Tanggal Batal',
            'tanggal_asesmen' => 'Tanggal Asesmen',
            'draf' => 'Draf',
            'tanggal_final' => 'Tanggal Final',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
            'log_data' => 'Log Data',
            'is_deleted' => 'Is Deleted',
            'diagnosis_ginjal' => 'Diagnosis Ginjal',
            'etiologi' => 'Etiologi',
            'penyulit' => 'Penyulit',
            'penyakit_penyerta' => 'Penyakit Penyerta',
            'anamnesis' => 'Anamnesis',
            'pemeriksaan_fisik' => 'Pemeriksaan Fisik',
            'pengkajian_fisik_ulang' => 'Pengkajian Fisik Ulang',
            'hbs_ag' => 'Hbs Ag',
            'ureum' => 'Ureum',
            'natrium' => 'Natrium',
            'fe_serum' => 'Fe Serum',
            'anti_hcv' => 'Anti Hcv',
            'kreatinin' => 'Kreatinin',
            'kalsium' => 'Kalsium',
            'tibc' => 'Tibc',
            'anti_hiv' => 'Anti Hiv',
            'asam_urat' => 'Asam Urat',
            'poforanorganik' => 'Poforanorganik',
            'sa_transferin' => 'Sa Transferin',
            'hemoglobin' => 'Hemoglobin',
            'kalium' => 'Kalium',
            'gula_darah' => 'Gula Darah',
            'target_pengobatan' => 'Target Pengobatan',
            'frekuensi_hd' => 'Frekuensi Hd',
            'pencapaian_adekuasi_dialisis' => 'Pencapaian Adekuasi Dialisis',
            'lainnya' => 'Lainnya',
            'akses_sirkulasi' => 'Akses Sirkulasi',
            'durasi_hd' => 'Durasi Hd',
            'uf_goal' => 'Uf Goal',
            'bb_kering' => 'Bb Kering',
            'kecepatan_aliran_darah' => 'Kecepatan Aliran Darah',
            'kecepatan_aliran_dialisat' => 'Kecepatan Aliran Dialisat',
            'heparinisasi' => 'Heparinisasi',
            'program_profilling' => 'Program Profilling',
            'suhu' => 'Suhu',
            'catatan_lain' => 'Catatan Lain',
            'perubahan_terapi' => 'Perubahan Terapi',
            'obat' => 'Obat',
            'catatan_medis' => 'Catatan Medis',
            'dializer_model' => 'Dializer Model',
            'dializer_tipe_flux' => 'Dializer Tipe Flux',
            'dializer_status_penggunaan' => 'Dializer Status Penggunaan',
            'resep_hd' => 'Status Hd',
            'resep_hd_td' => 'Resep Hd Td',
            'resep_hd_qb' => 'Resep Hd Qb',
            'resep_hd_qd' => 'Resep Hd Qd',
            'resep_hd_uf_goal' => 'Resep Hd Uf Goal',
            'dialisat' => 'Dialisat',
            'pp_na' => 'Pp Na',
            'pp_uf' => 'Pp Uf',
            'pp_bicarbonat' => 'Pp Bicarbonat',
            'pp_conductivity' => 'Pp Conductivity',
            'pp_temperatur' => 'Pp Temperatur',
            'dosis_sirkulasi' => 'Dosis Sirkulasi',
            'dosis_awal' => 'Dosis Awal',
            'dosis_continue' => 'Dosis Continue',
            'dosis_intermitten' => 'Dosis Intermitten',
            'dosis_total' => 'Dosis Total',
            'program_bilas' => 'Program Bilas',
            'lmwh' => 'LMWH',
            'heparin' => 'Heparin',
            'ktv_target' => 'Kt/V Target',
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

    public function afterFind()
    {
        parent::afterFind();
        
        // Format 12 jam dengan AM/PM
        $this->tanggal_asesmen = Yii::$app->formatter->asDateTime($this->tanggal_asesmen, 'php:d-m-Y h:i');
    }

    public static function find()
    {
        return new AsesmenHemodialisaDokterLanjutanQuery(get_called_class());
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
