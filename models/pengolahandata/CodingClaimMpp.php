<?php

namespace app\models\pengolahandata;

use app\models\medis\ResumeMedisRi;
use app\models\pegawai\TbPegawai;
use Yii;

/**
 * This is the model class for table "coding_claim".
 *
 * @property int $id
 * @property string $registrasi_kode
 * @property int $jenis_layanan
 * @property int $pegawai_mpp_id
 * @property string|null $keterangan
 * @property string|null $created_at
 * @property int $created_by
 * @property string|null $updated_at
 * @property int|null $updated_by
 * @property string|null $deleted_at
 * @property int|null $deleted_by
 */
class CodingClaimMpp extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'coding_claim_mpp';
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
            [['registrasi_kode', 'jenis_layanan', 'pegawai_mpp_id',], 'required'],
            [['jenis_layanan', 'pegawai_mpp_id', 'id_resume_medis_ri', 'created_by', 'updated_by', 'deleted_by'], 'default', 'value' => null],
            [['jenis_layanan', 'pegawai_mpp_id',  'created_by', 'updated_by', 'deleted_by', 'kasus', 'diagnosa_simpan', 'tindakan_simpan'], 'integer'],
            [['keterangan'], 'string'],
            [['estimasi'], 'number'],
            [['created_at', 'updated_at', 'deleted_at'], 'safe'],
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
            'jenis_layanan' => 'Jenis Layanan',
            'pegawai_mpp_id' => 'Pegawai Mpp ID',
            'id_resume_medis_ri' => 'Id Resume Medis Ri',
            'estimasi' => 'Estimasi Claim BPJS (Rp.)',
            'keterangan' => 'Keterangan',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
            'deleted_at' => 'Deleted At',
            'deleted_by' => 'Deleted By',
        ];
    }
    function beforeSave($model)
    {
        if ($this->isNewRecord) {
            $this->created_at = date('Y-m-d H:i:s');
            $this->created_by = Yii::$app->user->identity->id;
        } else {
            $this->updated_at = date('Y-m-d H:i:s');
            $this->updated_by = Yii::$app->user->identity->id;
        }
        return parent::beforeSave($model);
    }

    function getClaimDiagnosa()
    {
        return $this->hasMany(CodingClaimMppDiagnosaDetail::className(), ['coding_claim_id' => 'id']);
    }
    function getClaimTindakan()
    {
        return $this->hasMany(CodingClaimMppTindakanDetail::className(), ['coding_claim_id' => 'id']);
    }
    public function getCoder()
    {
        return $this->hasOne(TbPegawai::className(), ['pegawai_id' => 'pegawai_mpp_id']);
    }
    function getResumeMedis()
    {
        return $this->hasOne(ResumeMedisRi::className(), ['id' => 'id_resume_medis_ri']);
    }
}
