<?php

namespace app\models\pengolahandata;

use Yii;
use app\models\pegawai\TbPegawai;
use app\models\pendaftaran\Layanan;

/**
 * This is the model class for table "skrining_pemulangan_pasien_mpp".
 *
 * @property int $id
 * @property string $registrasi_kode
 * @property int $layanan_id
 * @property int $mpp_id
 * @property string|null $umur
 * @property string|null $keterbatasan_mobilitas
 * @property string|null $perawatan_pengobatan_lanjutan
 * @property string|null $bantuan_aktivitas_sehari_hari
 * @property string|null $pengaruh_rawat_inap_pasien_keluarga
 * @property string|null $pengaruh_pekerjaan_sekolah
 * @property string|null $pengaruh_keuangan
 * @property string|null $antisipasi_masalah_saat_pulang
 * @property string|null $bantuan_diperlukan_dalam_hal
 * @property string|null $membantu_keperluan_diatas
 * @property string|null $pasien_tinggal_sendiri_setelah_keluar_rs
 * @property string|null $pasien_gunakan_peralatan_medis_setelah_keluar_rs
 * @property string|null $perlu_alat_bantu_setelah_keluar_rs
 * @property string|null $bantuan_khusus_perawatan_setelah_keluar_rs
 * @property string|null $masalah_memenuhi_kebutuhan_setelah_keluar_rs
 * @property string|null $nyeri_kronis_kelelahan_setelah_keluar_rs
 * @property string|null $perlu_edukasi_kesehatan_setelah_keluar_rs
 * @property string|null $perlu_keterampilan_khusus_setelah_keluar_rs
 * @property int $batal
 * @property string|null $tanggal_batal
 * @property string|null $created_at
 * @property int $created_by
 * @property string|null $updated_at
 * @property int|null $updated_by
 * @property string|null $log_data
 * @property int $is_deleted
 */
class SkriningPemulanganPasienMpp extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */

    public $bantuan_diperlukan_dalam_hal_custom;

    public static function tableName()
    {
        return 'skrining_pemulangan_pasien_mpp';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db_pengolahan_data');
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['registrasi_kode', 'layanan_id', 'mpp_id'], 'required'],
            [['layanan_id', 'mpp_id', 'batal', 'created_by', 'updated_by', 'is_deleted'], 'default', 'value' => null],
            [['layanan_id', 'mpp_id', 'batal', 'created_by', 'updated_by', 'is_deleted'], 'integer'],
            [['umur', 'keterbatasan_mobilitas', 'perawatan_pengobatan_lanjutan', 'bantuan_aktivitas_sehari_hari', 'pengaruh_rawat_inap_pasien_keluarga', 'pengaruh_pekerjaan_sekolah', 'pengaruh_keuangan', 'antisipasi_masalah_saat_pulang', 'membantu_keperluan_diatas', 'pasien_tinggal_sendiri_setelah_keluar_rs', 'pasien_gunakan_peralatan_medis_setelah_keluar_rs', 'perlu_alat_bantu_setelah_keluar_rs', 'bantuan_khusus_perawatan_setelah_keluar_rs', 'masalah_memenuhi_kebutuhan_setelah_keluar_rs', 'nyeri_kronis_kelelahan_setelah_keluar_rs', 'perlu_edukasi_kesehatan_setelah_keluar_rs', 'perlu_keterampilan_khusus_setelah_keluar_rs', 'log_data'], 'string'],
            [['tanggal_batal', 'created_at', 'updated_at'], 'safe'],
            [['registrasi_kode'], 'string', 'max' => 10],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'registrasi_kode' => 'Registrasi Kode',
            'layanan_id' => 'Layanan ID',
            'mpp_id' => 'Mpp ID',
            'umur' => 'Umur',
            'keterbatasan_mobilitas' => 'Keterbatasan Mobilitas',
            'perawatan_pengobatan_lanjutan' => 'Perawatan Pengobatan Lanjutan',
            'bantuan_aktivitas_sehari_hari' => 'Bantuan Aktivitas Sehari Hari',
            'pengaruh_rawat_inap_pasien_keluarga' => 'Pengaruh Rawat Inap Pasien Keluarga',
            'pengaruh_pekerjaan_sekolah' => 'Pengaruh Pekerjaan Sekolah',
            'pengaruh_keuangan' => 'Pengaruh Keuangan',
            'antisipasi_masalah_saat_pulang' => 'Antisipasi Masalah Saat Pulang',
            'bantuan_diperlukan_dalam_hal' => 'Bantuan Diperlukan Dalam Hal',
            'membantu_keperluan_diatas' => 'Membantu Keperluan Diatas',
            'pasien_tinggal_sendiri_setelah_keluar_rs' => 'Pasien Tinggal Sendiri Setelah Keluar Rs',
            'pasien_gunakan_peralatan_medis_setelah_keluar_rs' => 'Pasien Gunakan Peralatan Medis Setelah Keluar Rs',
            'perlu_alat_bantu_setelah_keluar_rs' => 'Perlu Alat Bantu Setelah Keluar Rs',
            'bantuan_khusus_perawatan_setelah_keluar_rs' => 'Bantuan Khusus Perawatan Setelah Keluar Rs',
            'masalah_memenuhi_kebutuhan_setelah_keluar_rs' => 'Masalah Memenuhi Kebutuhan Setelah Keluar Rs',
            'nyeri_kronis_kelelahan_setelah_keluar_rs' => 'Nyeri Kronis Kelelahan Setelah Keluar Rs',
            'perlu_edukasi_kesehatan_setelah_keluar_rs' => 'Perlu Edukasi Kesehatan Setelah Keluar Rs',
            'perlu_keterampilan_khusus_setelah_keluar_rs' => 'Perlu Keterampilan Khusus Setelah Keluar Rs',
            'batal' => 'Batal',
            'tanggal_batal' => 'Tanggal Batal',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
            'log_data' => 'Log Data',
            'is_deleted' => 'Is Deleted',
        ];
    }
    function beforeSave($model)
    {
        if ($this->isNewRecord) {
            $this->created_at = date('Y-m-d H:i:s');
            $this->created_by = Yii::$app->user->identity->id;
            $this->batal = 0;
            $this->is_deleted = 0;
        } else {
            $this->updated_at = date('Y-m-d H:i:s');
            $this->updated_by = Yii::$app->user->identity->id;
        }
        return parent::beforeSave($model);
    }
    public function getMpp()
    {
        return $this->hasOne(TbPegawai::className(), ['pegawai_id' => 'mpp_id']);
    }
    public function getLayanan()
    {
        return $this->hasOne(Layanan::className(), ['id' => 'layanan_id']);
    }
}
