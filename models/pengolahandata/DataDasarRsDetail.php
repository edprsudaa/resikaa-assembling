<?php

namespace app\models\pengolahandata;

use Yii;

/**
 * This is the model class for table "data_dasar_rs_detail".
 *
 * @property int $data_dasar_rs_detail_id
 * @property int $data_dasar_rs_id
 * @property int $data_dasar_rs_master_id
 * @property int $data_dasar_rs_master_parent_id
 * @property int $data_dasar_rs_keadaan_lk
 * @property int $data_dasar_rs_keadaan_pr
 * @property int $data_dasar_rs_kebutuhan_lk
 * @property int $data_dasar_rs_kebutuhan_pr
 * @property int $data_dasar_rs_kekurangan_lk
 * @property int $data_dasar_rs_kekurangan_pr
 * @property string $created_by
 * @property string $created_at
 * @property string|null $updated_by
 * @property string|null $updated_at
 * @property string|null $deleted_at
 * @property int|null $deleted_by
 */
class DataDasarRsDetail extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'data_dasar_rs_detail';
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
            [['data_dasar_rs_id', 'data_dasar_rs_master_id', 'data_dasar_rs_master_parent_id', 'data_dasar_rs_keadaan_lk', 'data_dasar_rs_keadaan_pr', 'data_dasar_rs_kebutuhan_lk', 'data_dasar_rs_kebutuhan_pr', 'data_dasar_rs_kekurangan_lk', 'data_dasar_rs_kekurangan_pr', 'created_by', 'created_at'], 'required'],
            [['data_dasar_rs_id', 'data_dasar_rs_master_id', 'data_dasar_rs_master_parent_id', 'data_dasar_rs_keadaan_lk', 'data_dasar_rs_keadaan_pr', 'data_dasar_rs_kebutuhan_lk', 'data_dasar_rs_kebutuhan_pr', 'data_dasar_rs_kekurangan_lk', 'data_dasar_rs_kekurangan_pr', 'deleted_by'], 'default', 'value' => null],
            [['data_dasar_rs_id', 'data_dasar_rs_master_id', 'data_dasar_rs_master_parent_id', 'data_dasar_rs_keadaan_lk', 'data_dasar_rs_keadaan_pr', 'data_dasar_rs_kebutuhan_lk', 'data_dasar_rs_kebutuhan_pr', 'data_dasar_rs_kekurangan_lk', 'data_dasar_rs_kekurangan_pr', 'deleted_by'], 'integer'],
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
            'data_dasar_rs_detail_id' => 'Data Dasar Rs Detail ID',
            'data_dasar_rs_id' => 'Data Dasar Rs ID',
            'data_dasar_rs_master_id' => 'Data Dasar Rs Master ID',
            'data_dasar_rs_master_parent_id' => 'Data Dasar Rs Master Parent ID',
            'data_dasar_rs_keadaan_lk' => 'Data Dasar Rs Keadaan Lk',
            'data_dasar_rs_keadaan_pr' => 'Data Dasar Rs Keadaan Pr',
            'data_dasar_rs_kebutuhan_lk' => 'Data Dasar Rs Kebutuhan Lk',
            'data_dasar_rs_kebutuhan_pr' => 'Data Dasar Rs Kebutuhan Pr',
            'data_dasar_rs_kekurangan_lk' => 'Data Dasar Rs Kekurangan Lk',
            'data_dasar_rs_kekurangan_pr' => 'Data Dasar Rs Kekurangan Pr',
            'created_by' => 'Created By',
            'created_at' => 'Created At',
            'updated_by' => 'Updated By',
            'updated_at' => 'Updated At',
            'deleted_at' => 'Deleted At',
            'deleted_by' => 'Deleted By',
        ];
    }
}
