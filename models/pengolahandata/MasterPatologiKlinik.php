<?php

namespace app\models\pengolahandata;

use Yii;

/**
 * This is the model class for table "master_patologi_klinik".
 *
 * @property int $patologi_klinik_id
 * @property string $patologi_klinik_no
 * @property string $patologi_klinik_uraian
 * @property int|null $patologi_klinik_aktif
 * @property string|null $patologi_klinik_created_at
 * @property int $patologi_klinik_created_by
 * @property string|null $patologi_klinik_updated_at
 * @property int|null $patologi_klinik_updated_by
 * @property string|null $patologi_klinik_deleted_at
 * @property int|null $patologi_klinik_deleted_by
 */
class MasterPatologiKlinik extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'master_patologi_klinik';
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
            [['patologi_klinik_no', 'patologi_klinik_uraian'], 'required'],
            [['patologi_klinik_no', 'patologi_klinik_uraian'], 'string'],
            [['patologi_klinik_aktif', 'patologi_klinik_created_by', 'patologi_klinik_updated_by', 'patologi_klinik_deleted_by'], 'default', 'value' => null],
            [['patologi_klinik_aktif', 'patologi_klinik_created_by', 'patologi_klinik_updated_by', 'patologi_klinik_deleted_by'], 'integer'],
            [['patologi_klinik_created_at', 'patologi_klinik_updated_at', 'patologi_klinik_deleted_at'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'patologi_klinik_id' => 'Patologi Klinik ID',
            'patologi_klinik_no' => 'Patologi Klinik No',
            'patologi_klinik_uraian' => 'Patologi Klinik Uraian',
            'patologi_klinik_aktif' => 'Patologi Klinik Aktif',
            'patologi_klinik_created_at' => 'Patologi Klinik Created At',
            'patologi_klinik_created_by' => 'Patologi Klinik Created By',
            'patologi_klinik_updated_at' => 'Patologi Klinik Updated At',
            'patologi_klinik_updated_by' => 'Patologi Klinik Updated By',
            'patologi_klinik_deleted_at' => 'Patologi Klinik Deleted At',
            'patologi_klinik_deleted_by' => 'Patologi Klinik Deleted By',
        ];
    }
    function beforeSave($model)
    {
        if ($this->isNewRecord) {
            $this->patologi_klinik_created_by = Yii::$app->user->identity->id;
            $this->patologi_klinik_created_at = date('Y-m-d H:i:s');
           
        } else {
            $this->patologi_klinik_updated_by = Yii::$app->user->identity->id;
            $this->patologi_klinik_updated_at = date('Y-m-d H:i:s');
        }
        return parent::beforeSave($model);
    }
}
