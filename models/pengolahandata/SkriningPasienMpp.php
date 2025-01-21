<?php

namespace app\models\pengolahandata;

use app\models\pegawai\TbPegawai;
use app\models\pendaftaran\Layanan;
use Yii;

/**
 * This is the model class for table "skrining_pasien_mpp".
 *
 * @property int $id
 * @property string $registrasi_kode
 * @property int $layanan_id
 * @property int $mpp_id
 * @property string $hasil_deskripsi
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
class SkriningPasienMpp extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'skrining_pasien_mpp';
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
            // [['registrasi_kode', 'layanan_id', 'mpp_id', 'hasil_deskripsi', 'hasil_nilai', 'hasil_json', 'created_by'], 'required'],
            [['layanan_id', 'mpp_id', 'hasil_nilai', 'batal', 'created_by', 'updated_by', 'is_deleted'], 'default', 'value' => null],
            [['layanan_id', 'mpp_id', 'hasil_nilai', 'batal', 'created_by', 'updated_by', 'is_deleted'], 'integer'],
            [['hasil_json', 'log_data'], 'string'],
            [['tanggal_batal', 'created_at', 'updated_at'], 'safe'],
            [['registrasi_kode'], 'string', 'max' => 10],
            [['hasil_deskripsi'], 'string', 'max' => 255],
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
            'hasil_deskripsi' => 'Hasil Deskripsi',
            'hasil_nilai' => 'Hasil Nilai',
            'hasil_json' => 'Hasil Json',
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

    public static function getFieldJsonDecode($filedNameValue)
    {
        return json_decode($filedNameValue);
    }

    public static function setFieldJsonEncode($filedNameValue)
    {
        return json_encode($filedNameValue);
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
