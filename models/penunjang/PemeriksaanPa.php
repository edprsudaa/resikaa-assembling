<?php

namespace app\models\penunjang;

use app\models\sso\User;
use Yii;

/**
 * This is the model class for table "pemeriksaan_pa".
 *
 * @property int $id
 * @property string $pemeriksaan
 * @property string|null $created_at
 * @property string|null $updated_at
 * @property string|null $deleted_at
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property int|null $deleted_by
 */
class PemeriksaanPa extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'penunjang_2.pemeriksaan_pa';
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
            [['pemeriksaan'], 'required'],
            [['pemeriksaan'], 'string'],
            [['created_at', 'updated_at', 'deleted_at'], 'safe'],
            [['created_by', 'updated_by', 'deleted_by'], 'default', 'value' => null],
            [['created_by', 'updated_by', 'deleted_by'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'pemeriksaan' => 'Pemeriksaan',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'deleted_at' => 'Deleted At',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'deleted_by' => 'Deleted By',
        ];
    }

    public function getUserCreated()
    {
        return $this->hasOne(User::className(), ['userid' => 'created_by']);
    }
    public function getUserUpdated()
    {
        return $this->hasOne(User::className(), ['userid' => 'updated_by']);
    }
    public function getUserDeleted()
    {
        return $this->hasOne(User::className(), ['userid' => 'deleted_by']);
    }
}
