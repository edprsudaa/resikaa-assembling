<?php

namespace app\models\medis;

use Yii;
use app\models\medis\ActiveQuery\MasterAksesUnitQuery;
use app\models\other\BaseQuery;
/**
 * This is the model class for table "master_akses_unit".
 *
 * @property int $id_akses_unit
 * @property int $is_active
 * @property int $created_by
 * @property string $created_at
 * @property int|null $updated_by
 * @property string|null $updated_at
 * @property int $is_deleted
 * @property int|null $deleted_by
 * @property string|null $deleted_at
 * @property int $id_user
 * @property int $id_unit
 */
class MasterAksesUnit extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'master_akses_unit';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db_medis');
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['is_active', 'created_by', 'updated_by', 'is_deleted', 'deleted_by', 'id_user', 'id_unit'], 'default', 'value' => null],
            [['is_active', 'created_by', 'updated_by', 'is_deleted', 'deleted_by', 'id_user', 'id_unit'], 'integer'],
            [['created_by', 'created_at', 'id_user', 'id_unit'], 'required'],
            [['created_at', 'updated_at', 'deleted_at'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_akses_unit' => 'Id Akses Unit',
            'is_active' => 'Is Active',
            'created_by' => 'Created By',
            'created_at' => 'Created At',
            'updated_by' => 'Updated By',
            'updated_at' => 'Updated At',
            'is_deleted' => 'Is Deleted',
            'deleted_by' => 'Deleted By',
            'deleted_at' => 'Deleted At',
            'id_user' => 'Id User',
            'id_unit' => 'Id Unit',
        ];
    }

    /**
     * {@inheritdoc}
     * @return MasterAksesUnitQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new BaseQuery(get_called_class());
    }
    public static function find_uniq()
    {
        return new MasterAksesUnitQuery(get_called_class());
    }
}
