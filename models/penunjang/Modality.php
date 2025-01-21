<?php

namespace app\models\penunjang;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "modality".
 *
 * @property int $id
 * @property string|null $kode
 * @property string|null $alat
 * @property string $created_at
 * @property int $created_by
 * @property string|null $updated_at
 * @property string|null $deleted_at
 * @property int|null $deleted_by
 * @property int|null $updated_by
 */
class Modality extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'penunjang_2.modality';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db_penunjang');
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['kode', 'alat'], 'string'],
            [['created_at', 'created_by'], 'required'],
            [['created_at', 'updated_at', 'deleted_at'], 'safe'],
            [['created_by', 'deleted_by', 'updated_by'], 'default', 'value' => null],
            [['created_by', 'deleted_by', 'updated_by'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'kode' => 'Kode',
            'alat' => 'Alat',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'deleted_at' => 'Deleted At',
            'deleted_by' => 'Deleted By',
            'updated_by' => 'Updated By',
        ];
    }

    public static function modalityKode()
    {
        $data = self::find()->select(['kode', 'alat'])->orderBy('kode')->asArray()->all();

        return ArrayHelper::map($data, 'kode', 'alat');
    }
}
