<?php

namespace app\models\pengolahandata;

use Yii;

/**
 * This is the model class for table "formulir_rl_detail".
 *
 * @property int $id
 * @property int $formulir_rl_id
 * @property int|null $jenis_kegiatan_id
 * @property int|null $jenis_pelayanan_id
 * @property int $aktif
 * @property string $created_at
 * @property int $created_by
 * @property string|null $updated_at
 * @property int|null $updated_by
 * @property int|null $deleted_by
 * @property string|null $deleted_at
 */
class FormulirRlDetail extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'formulir_rl_detail';
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
            [['formulir_rl_id', 'created_by'], 'required'],
            [['formulir_rl_id', 'jenis_kegiatan_id', 'jenis_pelayanan_id', 'aktif', 'created_by', 'updated_by', 'deleted_by'], 'default', 'value' => null],
            [['formulir_rl_id', 'jenis_kegiatan_id', 'jenis_pelayanan_id', 'aktif', 'created_by', 'updated_by', 'deleted_by'], 'integer'],
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
            'formulir_rl_id' => 'Formulir Rl ID',
            'jenis_kegiatan_id' => 'Jenis Kegiatan ID',
            'jenis_pelayanan_id' => 'Jenis Pelayanan ID',
            'aktif' => 'Aktif',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
            'deleted_by' => 'Deleted By',
            'deleted_at' => 'Deleted At',
        ];
    }
}
