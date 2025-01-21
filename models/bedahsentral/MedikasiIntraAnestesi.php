<?php

namespace app\models\bedahsentral;

use Yii;

class MedikasiIntraAnestesi extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'bedah_sentral.medikasi_intra_anestesi';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db_bedah_sentral');
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['mmia_intra_anestesi_mia_id'], 'required'],
            [['mmia_intra_anestesi_mia_id', 'mmia_created_by', 'mmia_updated_by', 'mmia_deleted_by'], 'default', 'value' => null],
            [['mmia_intra_anestesi_mia_id', 'mmia_created_by', 'mmia_updated_by', 'mmia_deleted_by'], 'integer'],
            [['mmia_nama_obat'], 'string'],
            [['mmia_waktu', 'mmia_created_at', 'mmia_updated_at', 'mmia_deleted_at'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'mmia_id' => 'ID',
            'mmia_intra_anestesi_mia_id' => 'Intra Operasi Mia ID',
            'mmia_nama_obat' => 'Nama Obat',
            'mmia_waktu' => 'Waktu',
            'mmia_created_at' => 'Created At',
            'mmia_created_by' => 'Created By',
            'mmia_updated_at' => 'Updated At',
            'mmia_updated_by' => 'Updated By',
            'mmia_deleted_at' => 'Deleted At',
            'mmia_deleted_by' => 'Deleted By',
        ];
    }
}
