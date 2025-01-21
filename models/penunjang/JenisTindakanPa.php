<?php

namespace app\models\penunjang;

use Yii;

/**
 * This is the model class for table "jenis_tindakan_pa".
 *
 * @property int $id
 * @property int $id_tindakan
 * @property string|null $jenis
 * @property string|null $created_at
 * @property string|null $updated_at
 * @property string|null $deleted_at
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property int|null $deleted_by
 */
class JenisTindakanPa extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'penunjang_2.jenis_tindakan_pa';
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
            [['id_tindakan'], 'required'],
            [['id_tindakan', 'created_by', 'updated_by', 'deleted_by'], 'default', 'value' => null],
            [['id_tindakan', 'created_by', 'updated_by', 'deleted_by'], 'integer'],
            [['jenis'], 'string'],
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
            'id_tindakan' => 'Id Tindakan',
            'jenis' => 'Jenis',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'deleted_at' => 'Deleted At',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'deleted_by' => 'Deleted By',
        ];
    }
}
