<?php

namespace app\models\pengolahandata;

use app\components\Akun;
use Yii;

/**
 * This is the model class for table "master_jenis_pelayanan".
 *
 * @property int $id
 * @property string $deskripsi
 * @property int $is_active
 * @property int $created_by
 * @property string $created_at
 * @property int|null $updated_by
 * @property string|null $updated_at
 * @property int|null $deleted_by
 * @property string|null $deleted_at
 */
class MasterJenisPelayanan extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'master_jenis_pelayanan';
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
            [['deskripsi'], 'required'],
            [['deskripsi'], 'string'],
            [['is_active', 'created_by', 'updated_by', 'deleted_by'], 'default', 'value' => null],
            [['is_active', 'created_by', 'updated_by', 'deleted_by'], 'integer'],
            [['created_at', 'updated_at', 'deleted_at'], 'safe'],
        ];
    }

    function beforeSave($model)
    {
        if ($this->isNewRecord) {
            $this->created_by = Yii::$app->user->identity->id;
            $this->created_at = date('Y-m-d H:i:s');
           
        } else {
            $this->updated_by = Yii::$app->user->identity->id;
            $this->updated_at = date('Y-m-d H:i:s');
        }
        return parent::beforeSave($model);
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'deskripsi' => 'Deskripsi',
            'is_active' => 'Is Active',
            'created_by' => 'Created By',
            'created_at' => 'Created At',
            'updated_by' => 'Updated By',
            'updated_at' => 'Updated At',
            'deleted_by' => 'Deleted By',
            'deleted_at' => 'Deleted At',
        ];
    }
}