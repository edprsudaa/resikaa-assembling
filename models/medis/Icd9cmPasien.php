<?php

namespace app\models\medis;

use Yii;
use app\models\pegawai\TbPegawai;
use app\models\pendaftaran\Layanan;
/**
 * This is the model class for table "medis.icd9cm_pasien".
 *
 * @property int $id
 * @property string $icd9cm_kode reff medis.icd9cm.kode atau bisa saja manual input
 * @property string $icd9cm_deskripsi reff medis.icd9cm.deskripsi atau bisa saja manual input
 * @property int $batal jika dibatalkan atau salah maka value 1 dan di list tetap kebaca dan fungsi hapus tidak tersedia
 * @property string $created_at
 * @property int $created_by
 * @property string|null $updated_at
 * @property int|null $updated_by
 * @property string|null $log_data
 * @property int $is_deleted
 */
class Icd9cmPasien extends BaseModelAR
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'medis.icd9cm_pasien';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['layanan_id','dokter_id', 'icd9cm_kode', 'icd9cm_deskripsi','jenis'], 'required'],
            [['icd9cm_id','layanan_id','dokter_id', 'batal', 'created_by', 'updated_by', 'is_deleted'], 'integer'],
            [['icd9cm_deskripsi', 'log_data'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['icd9cm_kode'], 'string', 'max' => 255],
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
            'jenis' => 'Jenis',
            'icd9cm_id' => 'Pencarian ICD-9',
            'icd9cm_kode' => 'Kode',
            'icd9cm_deskripsi' => 'Deskripsi',
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
        }
        return parent::beforeSave($insert); // TODO: Change the autogenerated stub
    }
    /**
     * {@inheritdoc}
     * @return Icd9cmPasienQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new Icd9cmPasienQuery(get_called_class());
    }
    public function getIcd9cm()
    {
        return $this->hasOne(Icd9cm::className(),['kode'=>'icd9cm_kode']);
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
