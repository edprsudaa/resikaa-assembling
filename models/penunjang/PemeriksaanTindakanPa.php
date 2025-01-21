<?php

namespace app\models\penunjang;

use app\models\medis\Tindakan;
use app\models\pegawai\TbPegawai;
use app\models\sso\User;
use Yii;

/**
 * This is the model class for table "pemeriksaan_tindakan_pa".
 *
 * @property int $id
 * @property int $tindakan_id
 * @property int $pemeriksaan_pa_id
 * @property string|null $created_at
 * @property string|null $updated_at
 * @property string|null $deleted_at
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property int|null $deleted_by
 */
class PemeriksaanTindakanPa extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'penunjang_2.pemeriksaan_tindakan_pa';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db_postgre');
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['tindakan_id', 'pemeriksaan_pa_id'], 'required'],
            [['tindakan_id', 'pemeriksaan_pa_id', 'created_by', 'updated_by', 'deleted_by'], 'default', 'value' => null],
            [['tindakan_id', 'pemeriksaan_pa_id', 'created_by', 'updated_by', 'deleted_by'], 'integer'],
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
            'tindakan_id' => 'Tindakan ID',
            'pemeriksaan_pa_id' => 'Pemeriksaan Pa ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'deleted_at' => 'Deleted At',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'deleted_by' => 'Deleted By',
        ];
    }

    public function getPemeriksaanPa()
    {
        return $this->hasOne(PemeriksaanPa::className(), ['id' => 'pemeriksaan_pa_id']);
    }

    public function getTindakan()
    {
        return $this->hasOne(Tindakan::className(), ['id' => 'tindakan_id']);
    }

    public function getUserCreate()
    {
        return $this->hasOne(User::className(), ['userid' => 'created_by']);
    }

    public function getUserUpdate()
    {
        return $this->hasOne(User::className(), ['userid' => 'updated_by']);
    }

    public static function getPemeriksaanTindakanPa($id)
    {
        $data = self::find()->alias('pta')->select([
            'pta.id',
            'pa.pemeriksaan'
        ])->innerJoin('penunjang_2.pemeriksaan_pa pa', 'pa.id=pta.pemeriksaan_pa_id')
            ->where(['pta.tindakan_id' => $id])
            ->asArray()->all();

        return $data;
    }
}
