<?php

namespace app\models\medis;

use Yii;
use app\models\pegawai\TbPegawai;
use app\models\pendaftaran\Layanan;
/**
 * This is the model class for table "medis.asesmen_awal_medis".
 *
 * @property int $id
 * @property string|null $anamnesis_sumber
 * @property string|null $anamnesis_keluhan
 * @property string|null $riwayat_penyakit_sekarang
 * @property string|null $riwayat_penyakit_dahulu
 * @property string|null $riwayat_pengobatan
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
 * @property int|null $gcs_e
 * @property int|null $gcs_m
 * @property int|null $gcs_v
 * @property string|null $tingkat_kesadaran
 * @property string|null $nadi
 * @property string|null $darah
 * @property string|null $pernapasan
 * @property int|null $suhu
 * @property int|null $sato2
 * @property int|null $berat_badan
 * @property int|null $tinggi_badan
 * @property string|null $keadaan_gizi
 * @property string|null $keadaan_umum
 * @property string|null $kepala
 * @property string|null $mata
 * @property string|null $mulut
 * @property string|null $leher
 * @property string|null $jantung
 * @property string|null $paru
 * @property string|null $hati
 * @property string|null $abdomen
 * @property string|null $ginjal_kemih
 * @property string|null $anus
 * @property string|null $ektremitas
 * @property string|null $status_lokalis
 * @property string|null $pemeriksaan_penunjang
 * @property string|null $masalah
 * @property string|null $penatalaksanaan
 * @property string|null $pemeriksaan_ulang
 * @property string|null $status_keluar
 * @property string|null $keterangan_keluar
 * @property int $batal
 * @property string|null $created_at
 * @property int $created_by
 * @property string|null $updated_at
 * @property int|null $updated_by
 * @property string|null $log_data
 * @property int $is_deleted
 */
class AsesmenAwalMedis extends BaseModelAR
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'medis.asesmen_awal_medis';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['layanan_id','dokter_id',], 'required'],
            [['layanan_id','dokter_id', 'gcs_e', 'gcs_m', 'gcs_v', 'suhu', 'sato2', 'berat_badan', 'tinggi_badan', 'batal', 'draf', 'created_by', 'updated_by', 'is_deleted'], 'default', 'value' => null],
            [['layanan_id','dokter_id', 'gcs_e', 'gcs_m', 'gcs_v', 'suhu', 'sato2', 'berat_badan', 'tinggi_badan', 'batal', 'draf', 'created_by', 'updated_by', 'is_deleted'], 'integer'],
            [['anamnesis_sumber', 'anamnesis_keluhan', 'riwayat_penyakit_sekarang', 'riwayat_penyakit_dahulu', 'riwayat_pengobatan', 'riwayat_penyakit_keluarga', 'alergi', 'status_sosial', 'ekonomi', 'imunisasi', 'status_psikologi', 'status_mental', 'riwayat_perilaku_kekerasan', 'ketergantungan_obat', 'ketergantungan_alkohol', 'permintaan_informasi', 'tingkat_kesadaran', 'nadi', 'darah', 'pernapasan', 'keadaan_gizi', 'keadaan_umum', 'kepala', 'mata', 'mulut', 'leher', 'jantung', 'paru', 'hati', 'abdomen', 'ginjal_kemih', 'anus', 'ektremitas', 'status_lokalis', 'pemeriksaan_penunjang', 'masalah', 'penatalaksanaan', 'pemeriksaan_ulang', 'status_keluar', 'keterangan_keluar', 'log_data'], 'string'],
            [['created_at', 'updated_at','tanggal_batal','tanggal_final'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'layanan_id' => 'Layanan',
            'dokter_id'=>'Dokter',
            'anamnesis_sumber' => 'Sumber :',
            'anamnesis_keluhan' => 'Keluhan Utama :',
            'riwayat_penyakit_sekarang' => 'Riwayat Penyakit Sekarang :',
            'riwayat_penyakit_dahulu' => 'Riwayat Penyakit Dahulu :',
            'riwayat_pengobatan' => 'Riwayat Pengobatan :',
            'riwayat_penyakit_keluarga' => 'Riwayat Penyakit Keluarga :',
            'alergi' => 'Alergi :',
            'status_sosial' => 'Status Sosial',
            'ekonomi' => 'Ekonomi',
            'imunisasi' => 'Imunisasi',
            'status_psikologi' => 'Status Psikologi',
            'status_mental' => 'Status Mental',
            'riwayat_perilaku_kekerasan' => 'Riwayat Perilaku Kekerasan',
            'ketergantungan_obat' => 'Ketergantungan Obat',
            'ketergantungan_alkohol' => 'Ketergantungan Alkohol',
            'permintaan_informasi' => 'Permintaan Informasi',
            'gcs_e' => 'Gcs E',
            'gcs_m' => 'Gcs M',
            'gcs_v' => 'Gcs V',
            'tingkat_kesadaran' => 'Tingkat Kesadaran',
            'nadi' => 'Nadi',
            'darah' => 'Darah',
            'pernapasan' => 'Pernapasan',
            'suhu' => 'Suhu',
            'sato2' => 'Sato2',
            'berat_badan' => 'Berat Badan',
            'tinggi_badan' => 'Tinggi Badan',
            'keadaan_gizi' => 'Keadaan Gizi',
            'keadaan_umum' => 'Keadaan Umum',
            'kepala' => 'Kepala',
            'mata' => 'Mata',
            'mulut' => 'Mulut',
            'leher' => 'Leher',
            'jantung' => 'Jantung',
            'paru' => 'Paru',
            'hati' => 'Hati',
            'abdomen' => 'Abdomen',
            'ginjal_kemih' => 'Ginjal Kemih',
            'anus' => 'Anus',
            'ektremitas' => 'Ektremitas',
            'status_lokalis' => 'Status Lokalis',
            'pemeriksaan_penunjang' => 'Pemeriksaan Penunjang',
            'masalah' => 'Masalah',
            'penatalaksanaan' => 'Penatalaksanaan',
            'pemeriksaan_ulang' => 'Pemeriksaan Ulang',
            'status_keluar' => 'Status Keluar',
            'keterangan_keluar' => 'Keterangan Keluar',
            'batal' => 'Batal',
            'draf' => 'Draf',
            'tanggal_batal' => 'Tanggal Batal',
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
    /**
     * {@inheritdoc}
     * @return AsesmenAwalMedisQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new AsesmenAwalMedisQuery(get_called_class());
    }
    public function getDokter()
    {
        return $this->hasOne(TbPegawai::className(),['pegawai_id'=>'dokter_id']);
    }
    public function getLayanan()
    {
        return $this->hasOne(Layanan::className(),['id'=>'layanan_id']);
    }
}
