<?php

namespace app\models\medis;

use Yii;
use app\models\pegawai\TbPegawai;
use app\models\pendaftaran\Layanan;
/**
 * This is the model class for table "medis.asesmen_down_score_ipn".
 *
 * @property int $id
 * @property int $layanan_id
 * @property int $perawat_id
 * @property int $hasil_nilai
 * @property string $hasil_json
 * @property int $batal
 * @property string|null $tanggal_batal
 * @property string|null $created_at
 * @property int $created_by
 * @property string|null $updated_at
 * @property int|null $updated_by
 * @property string|null $log_data
 * @property int $is_deleted
 */
class AsesmenDownScoreIpn extends BaseModelAR
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'medis.asesmen_down_score_ipn';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['layanan_id', 'perawat_id', 'hasil_nilai', 'hasil_deskripsi', 'hasil_json'], 'required'],
            [['layanan_id', 'perawat_id', 'hasil_nilai','hasil_deskripsi', 'batal', 'created_by', 'updated_by', 'is_deleted'], 'default', 'value' => null],
            [['layanan_id', 'perawat_id', 'hasil_nilai', 'batal', 'created_by', 'updated_by', 'is_deleted'], 'integer'],
            [['hasil_json', 'log_data'], 'string'],
            [['tanggal_batal', 'created_at', 'updated_at'], 'safe'],
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
            'hasil_nilai' => 'Hasil Nilai',
            'hasil_json' => 'Hasil Json',
            'hasil_deskripsi' => 'Hasil Deskripsi',
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
    public static function getFieldJsonDecode($filedNameValue)
    {
        return json_decode($filedNameValue);
    }

    public static function setFieldJsonEncode($filedNameValue)
    {
        return json_encode($filedNameValue);
    }
    public function getPerawat()
    {
        return $this->hasOne(TbPegawai::className(),['pegawai_id'=>'perawat_id']);
    }
    public function getLayanan()
    {
        return $this->hasOne(Layanan::className(),['id'=>'layanan_id']);
    }
    /**
     * {@inheritdoc}
     * @return AsesmenDownScoreIpnQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new AsesmenDownScoreIpnQuery(get_called_class());
    }
}