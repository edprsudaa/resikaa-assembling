<?php

namespace app\models\medis;

use Yii;
use app\models\pegawai\TbPegawai;
use app\models\pendaftaran\Layanan;
/**
 * This is the model class for table "medis.triase_pasien".
 *
 * @property int $id
 * @property int $layanan_id reff pendaftaran.layanan.id
 * @property int $perawat_id reff pegawai.tb_pegawai.pegawai_id => id perawat triase
 * @property int $dokter_id reff pegawai.tb_pegawai.pegawai_id => id dokter triease
 * @property string $tanggal_triase
 * @property string $jam_serah_terima_dokter
 * @property string $cara_datang
 * @property string $asal_rujukan
 * @property string $doa_tanda_kehidupan
 * @property string $doa_denyut_nadi
 * @property string $doa_reflex_cahaya
 * @property string $doa_ekg_flat
 * @property string $doa_jam
 * @property string $skala_triase
 * @property string $jalan_nafas
 * @property string|null $pernapasan
 * @property string|null $sirkulasi
 * @property string|null $kesadaran
 * @property string $diteruskan_ke
 * @property int $batal
 * @property string|null $tanggal_batal
 * @property string $created_at
 * @property int $created_by
 * @property string|null $updated_at
 * @property int|null $updated_by
 * @property string|null $log_data
 * @property int $is_deleted
 */
class TriasePasien extends BaseModelAR
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'medis.triase_pasien';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['layanan_id', 'perawat_id', 'dokter_id', 'tanggal_triase', 'jam_serah_terima_dokter', 'cara_datang', 'asal_rujukan', 'doa_tanda_kehidupan', 'doa_denyut_nadi', 'doa_reflex_cahaya', 'doa_ekg_flat', 'doa_jam', 'skala_triase', 'diteruskan_ke'], 'required'],
            [['layanan_id', 'perawat_id', 'dokter_id', 'batal', 'created_by', 'updated_by', 'is_deleted'], 'default', 'value' => null],
            [['layanan_id', 'perawat_id', 'dokter_id', 'batal', 'created_by', 'updated_by', 'is_deleted'], 'integer'],
            [['tanggal_triase', 'jam_serah_terima_dokter', 'doa_jam', 'tanggal_batal', 'created_at', 'updated_at'], 'safe'],
            [['cara_datang', 'asal_rujukan', 'doa_tanda_kehidupan', 'doa_denyut_nadi', 'doa_reflex_cahaya', 'doa_ekg_flat', 'diteruskan_ke', 'log_data'], 'string'],
            [['skala_triase'], 'string', 'max' => 255],
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
            'perawat_id' => 'Perawat',
            'dokter_id' => 'Dokter',
            'tanggal_triase' => 'Tanggal Triase',
            'jam_serah_terima_dokter' => 'Jam Serah Terima Dokter',
            'cara_datang' => 'Cara Datang',
            'asal_rujukan' => 'Asal Rujukan',
            'doa_tanda_kehidupan' => 'Doa Tanda Kehidupan',
            'doa_denyut_nadi' => 'Doa Denyut Nadi',
            'doa_reflex_cahaya' => 'Doa Reflex Cahaya',
            'doa_ekg_flat' => 'Doa Ekg Flat',
            'doa_jam' => 'Doa Jam',
            'skala_triase' => 'Skala Triase',
            'jalan_nafas' => 'Jalan Nafas',
            'pernapasan' => 'Pernapasan',
            'sirkulasi' => 'Sirkulasi',
            'kesadaran' => 'Kesadaran',
            'diteruskan_ke' => 'Diteruskan Ke',
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
    public function beforeSave($insert) {
        if ($insert) {
            $this->is_deleted = 0;
            $this->batal = 0;
        }
        return parent::beforeSave($insert); // TODO: Change the autogenerated stub
    }
    public function getFieldJsonDecode($filedNameValue)
    {
        return json_decode($filedNameValue);
    }

    public function setFieldJsonEncode($filedNameValue)
    {
        return json_encode($filedNameValue);
    }
    /**
     * {@inheritdoc}
     * @return TriasePasienQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new TriasePasienQuery(get_called_class());
    }
    public function getPerawat()
    {
        return $this->hasOne(TbPegawai::className(),['pegawai_id'=>'perawat_id']);
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