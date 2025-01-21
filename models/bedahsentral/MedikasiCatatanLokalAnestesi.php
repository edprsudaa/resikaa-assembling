<?php

namespace app\models\bedahsentral;

use Yii;

class MedikasiCatatanLokalAnestesi extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'medikasi_catatan_lokal_anestesi';
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
            [['mcl_cla_id'], 'required'],
            [['mcl_cla_id', 'mcl_created_by', 'mcl_updated_by', 'mcl_deleted_by'], 'default', 'value' => null],
            [['mcl_cla_id', 'mcl_created_by', 'mcl_updated_by', 'mcl_deleted_by'], 'integer'],
            [['mcl_nama_obat'], 'string'],
            [['mcl_waktu', 'mcl_created_at', 'mcl_updated_at', 'mcl_deleted_at'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'mcl_id' => 'ID',
            'mcl_cla_id' => 'Intra Operasi Mia ID',
            'mcl_nama_obat' => 'Nama Obat',
            'mcl_waktu' => 'Waktu',
            'mcl_created_at' => 'Created At',
            'mcl_created_by' => 'Created By',
            'mcl_updated_at' => 'Updated At',
            'mcl_updated_by' => 'Updated By',
            'mcl_deleted_at' => 'Deleted At',
            'mcl_deleted_by' => 'Deleted By',
        ];
    }
}
