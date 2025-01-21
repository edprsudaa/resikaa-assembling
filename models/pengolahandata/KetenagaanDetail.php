<?php

namespace app\models\pengolahandata;

use Yii;

/**
 * This is the model class for table "ketenagaan_detail".
 *
 * @property int $ketenagaan_detail_id
 * @property int $ketenagaan_id
 * @property int $ketenagaan_master_id
 * @property int $ketenagaan_master_parent_id
 * @property int $ketenagaan_jenis_id
 * @property int $ketenagaan_keadaan_lk
 * @property int $ketenagaan_keadaan_pr
 * @property int $ketenagaan_kebutuhan_lk
 * @property int $ketenagaan_kebutuhan_pr
 * @property int $ketenagaan_kekurangan_lk
 * @property int $ketenagaan_kekurangan_pr
 * @property string $created_by
 * @property string $created_at
 * @property string|null $updated_by
 * @property string|null $updated_at
 * @property string|null $deleted_at
 * @property int|null $deleted_by
 */
class KetenagaanDetail extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ketenagaan_detail';
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
            [['ketenagaan_id', 'ketenagaan_master_id', 'ketenagaan_master_parent_id', 'ketenagaan_jenis_id', 'ketenagaan_keadaan_lk', 'ketenagaan_keadaan_pr', 'ketenagaan_kebutuhan_lk', 'ketenagaan_kebutuhan_pr', 'ketenagaan_kekurangan_lk', 'ketenagaan_kekurangan_pr', 'created_by', 'created_at'], 'required'],
            [['ketenagaan_id', 'ketenagaan_master_id', 'ketenagaan_master_parent_id', 'ketenagaan_jenis_id', 'ketenagaan_keadaan_lk', 'ketenagaan_keadaan_pr', 'ketenagaan_kebutuhan_lk', 'ketenagaan_kebutuhan_pr', 'ketenagaan_kekurangan_lk', 'ketenagaan_kekurangan_pr', 'deleted_by'], 'default', 'value' => null],
            [['ketenagaan_id', 'ketenagaan_master_id', 'ketenagaan_master_parent_id', 'ketenagaan_jenis_id', 'ketenagaan_keadaan_lk', 'ketenagaan_keadaan_pr', 'ketenagaan_kebutuhan_lk', 'ketenagaan_kebutuhan_pr', 'ketenagaan_kekurangan_lk', 'ketenagaan_kekurangan_pr', 'deleted_by'], 'integer'],
            [['created_at', 'updated_at', 'deleted_at'], 'safe'],
            [['created_by', 'updated_by'], 'string', 'max' => 10],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'ketenagaan_detail_id' => 'Ketenagaan Detail ID',
            'ketenagaan_id' => 'Ketenagaan ID',
            'ketenagaan_master_id' => 'Ketenagaan Master ID',
            'ketenagaan_master_parent_id' => 'Ketenagaan Master Parent ID',
            'ketenagaan_jenis_id' => 'Ketenagaan Jenis ID',
            'ketenagaan_keadaan_lk' => 'Ketenagaan Keadaan Lk',
            'ketenagaan_keadaan_pr' => 'Ketenagaan Keadaan Pr',
            'ketenagaan_kebutuhan_lk' => 'Ketenagaan Kebutuhan Lk',
            'ketenagaan_kebutuhan_pr' => 'Ketenagaan Kebutuhan Pr',
            'ketenagaan_kekurangan_lk' => 'Ketenagaan Kekurangan Lk',
            'ketenagaan_kekurangan_pr' => 'Ketenagaan Kekurangan Pr',
            'created_by' => 'Created By',
            'created_at' => 'Created At',
            'updated_by' => 'Updated By',
            'updated_at' => 'Updated At',
            'deleted_at' => 'Deleted At',
            'deleted_by' => 'Deleted By',
        ];
    }
}
