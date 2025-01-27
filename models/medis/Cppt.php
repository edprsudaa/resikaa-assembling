<?php

namespace app\models\medis;

use Yii;
use app\models\pegawai\TbPegawai;
use app\models\pendaftaran\Layanan;
/**
 * This is the model class for table "medis.cppt".
 *
 * @property int $id
 * @property int $layanan_id reff medis.layanan.id
 * @property int $dokter_perawat_id reff pegawai.tb_pegawai.id
 * @property string $s
 * @property string $o
 * @property string $a
 * @property string $p
 * @property string|null $intruksi_ppa
 * @property int|null $dokter_id_verifikasi
 * @property string|null $tanggal_verifikasi
 * @property int $draf
 * @property int $batal
 * @property string $created_at
 * @property int $created_by
 * @property string|null $updated_at
 * @property int|null $updated_by
 * @property string|null $log_data
 * @property int $is_deleted
 */
class Cppt extends BaseModelAR
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'medis.cppt';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['layanan_id', 'dokter_perawat_id', 's', 'o', 'a', 'p'], 'required'],
            [['layanan_id', 'dokter_perawat_id', 'dokter_id_verifikasi', 'draf', 'batal', 'created_by', 'updated_by', 'is_deleted'], 'default', 'value' => null],
            [['layanan_id', 'dokter_perawat_id', 'dokter_id_verifikasi', 'draf', 'batal', 'created_by', 'updated_by', 'is_deleted'], 'integer'],
            [['s', 'o', 'a', 'p', 'intruksi_ppa', 'log_data'], 'string'],
            [['tanggal_verifikasi','tanggal_batal','tanggal_final', 'created_at', 'updated_at'], 'safe'],
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
            'dokter_perawat_id' => 'Dokter/Perawat',
            's' => 'S',
            'o' => 'O',
            'a' => 'A',
            'p' => 'P',
            'intruksi_ppa' => 'Intruksi Ppa',
            'dokter_id_verifikasi' => 'Dokter Id Verifikasi',
            'tanggal_verifikasi' => 'Tanggal Verifikasi',
            'tanggal_batal' => 'Tanggal Batal',
            'tanggal_final' => 'Tanggal Final',
            'draf' => 'Draf',
            'batal' => 'Batal',
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
            $this->draf=1;
        }
        return parent::beforeSave($insert); // TODO: Change the autogenerated stub
    }
    /**
     * {@inheritdoc}
     * @return CpptQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CpptQuery(get_called_class());
    }
    public function getDokter()
    {
        return $this->hasOne(TbPegawai::className(),['pegawai_id'=>'dokter_perawat_id']);
    }
    public function getLayanan()
    {
        return $this->hasOne(Layanan::className(),['id'=>'layanan_id']);
    }
    public function getDokterVerif()
    {
        return $this->hasOne(TbPegawai::className(),['pegawai_id'=>'dokter_id_verifikasi']);
    }
}
