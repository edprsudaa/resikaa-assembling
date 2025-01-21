<?php

namespace app\models\pengolahandata;

use app\models\pegawai\TbPegawai;
use app\models\pendaftaran\Layanan;

use Yii;

/**
 * This is the model class for table "catatan_implementasi_mpp".
 *
 * @property int $id
 * @property int $layanan_id
 * @property int $pegawai_mpp_id
 * @property string|null $catatan
 * @property string|null $created_at
 * @property int $created_by
 * @property string|null $updated_at
 * @property int|null $updated_by
 * @property string|null $deleted_at
 * @property int|null $deleted_by
 */
class CatatanImplementasiMpp extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'catatan_implementasi_mpp';
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
            [['layanan_id', 'pegawai_mpp_id'], 'required'],
            [['layanan_id', 'pegawai_mpp_id', 'created_by', 'updated_by', 'deleted_by'], 'default', 'value' => null],
            [['layanan_id', 'pegawai_mpp_id', 'created_by', 'updated_by', 'deleted_by'], 'integer'],
            [['catatan'], 'string'],
            [['created_at', 'updated_at', 'deleted_at'], 'safe'],
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
            'pegawai_mpp_id' => 'Pegawai Mpp ID',
            'catatan' => 'Catatan',
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
    function getLayanan()
    {
        return $this->hasOne(Layanan::className(), ['id' => 'layanan_id']);
    }
    function getPegawai()
    {
        return $this->hasOne(TbPegawai::className(), ['pegawai_id' => 'pegawai_mpp_id']);
    }
    function saveDataMpp()
    {
        $CatatanMppReq = Yii::$app->request->post('CatatanImplementasiMpp');

        $db = Yii::$app->db;
        $transaction = $db->beginTransaction();
        try {

            $this->layanan_id = $CatatanMppReq['layanan_id'];
            $this->pegawai_mpp_id = $CatatanMppReq['pegawai_mpp_id'];
            $this->catatan = $CatatanMppReq['catatan'];
            if ($this->save()) {
                $transaction->commit();
                return true;
            } else {
                $transaction->rollback();
                return false;
            }
        } catch (\Exception $e) {
            $transaction->rollBack();
            return $e->getMessage();
        }
    }
}
