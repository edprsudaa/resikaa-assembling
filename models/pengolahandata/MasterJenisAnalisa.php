<?php

namespace app\models\pengolahandata;

use Yii;

/**
 * This is the model class for table "master_jenis_analisa".
 *
 * @property int $jenis_analisa_id
 * @property string $jenis_analisa_uraian
 * @property int|null $jenis_analisa_aktif
 * @property string|null $jenis_analisa_created_at
 * @property int $jenis_analisa_created_by
 * @property string|null $jenis_analisa_updated_at
 * @property int|null $jenis_analisa_updated_by
 * @property string|null $jenis_analisa_deleted_at
 * @property int|null $jenis_analisa_deleted_by
 */
class MasterJenisAnalisa extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'master_jenis_analisa';
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
            [['jenis_analisa_uraian'], 'required'],
            [['jenis_analisa_uraian'], 'string'],
            [['jenis_analisa_aktif', 'jenis_analisa_created_by', 'jenis_analisa_updated_by', 'jenis_analisa_deleted_by'], 'default', 'value' => null],
            [['jenis_analisa_aktif', 'jenis_analisa_created_by', 'jenis_analisa_updated_by', 'jenis_analisa_deleted_by'], 'integer'],
            [['jenis_analisa_created_at', 'jenis_analisa_updated_at', 'jenis_analisa_deleted_at'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'jenis_analisa_id' => 'Jenis Analisa ID',
            'jenis_analisa_uraian' => 'Jenis Analisa Uraian',
            'jenis_analisa_aktif' => 'Jenis Analisa Aktif',
            'jenis_analisa_created_at' => 'Jenis Analisa Created At',
            'jenis_analisa_created_by' => 'Jenis Analisa Created By',
            'jenis_analisa_updated_at' => 'Jenis Analisa Updated At',
            'jenis_analisa_updated_by' => 'Jenis Analisa Updated By',
            'jenis_analisa_deleted_at' => 'Jenis Analisa Deleted At',
            'jenis_analisa_deleted_by' => 'Jenis Analisa Deleted By',
        ];
    }

    function beforeSave($model)
    {
        if ($this->isNewRecord) {
            $this->jenis_analisa_created_by = Yii::$app->user->identity->id;
            $this->jenis_analisa_created_at = date('Y-m-d H:i:s');
           
        } else {
            $this->jenis_analisa_updated_by = Yii::$app->user->identity->id;
            $this->jenis_analisa_updated_at = date('Y-m-d H:i:s');
        }
        return parent::beforeSave($model);
    }
}
