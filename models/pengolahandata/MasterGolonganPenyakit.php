<?php

namespace app\models\pengolahandata;

use Yii;

/**
 * This is the model class for table "master_golongan_penyakit".
 *
 * @property int $golongan_penyakit_id
 * @property string $golongan_penyakit_no_dtd
 * @property string $golongan_penyakit_no_daftar_terperinci
 * @property string $golongan_penyakit_uraian
 * @property int|null $golongan_penyakit_aktif
 * @property string|null $golongan_penyakit_created_at
 * @property int $golongan_penyakit_created_by
 * @property string|null $golongan_penyakit_updated_at
 * @property int|null $golongan_penyakit_updated_by
 * @property string|null $golongan_penyakit_deleted_at
 * @property int|null $golongan_penyakit_deleted_by
 */
class MasterGolonganPenyakit extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'master_golongan_penyakit';
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
            [['golongan_penyakit_no_dtd', 'golongan_penyakit_no_daftar_terperinci', 'golongan_penyakit_uraian', 'golongan_penyakit_created_by'], 'required'],
            [['golongan_penyakit_no_dtd', 'golongan_penyakit_no_daftar_terperinci', 'golongan_penyakit_uraian'], 'string'],
            [['golongan_penyakit_aktif', 'golongan_penyakit_created_by', 'golongan_penyakit_updated_by', 'golongan_penyakit_deleted_by'], 'default', 'value' => null],
            [['golongan_penyakit_aktif', 'golongan_penyakit_created_by', 'golongan_penyakit_updated_by', 'golongan_penyakit_deleted_by'], 'integer'],
            [['golongan_penyakit_created_at', 'golongan_penyakit_updated_at', 'golongan_penyakit_deleted_at'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'golongan_penyakit_id' => 'Golongan Penyakit ID',
            'golongan_penyakit_no_dtd' => 'Golongan Penyakit No Dtd',
            'golongan_penyakit_no_daftar_terperinci' => 'Golongan Penyakit No Daftar Terperinci',
            'golongan_penyakit_uraian' => 'Golongan Penyakit Uraian',
            'golongan_penyakit_aktif' => 'Golongan Penyakit Aktif',
            'golongan_penyakit_created_at' => 'Golongan Penyakit Created At',
            'golongan_penyakit_created_by' => 'Golongan Penyakit Created By',
            'golongan_penyakit_updated_at' => 'Golongan Penyakit Updated At',
            'golongan_penyakit_updated_by' => 'Golongan Penyakit Updated By',
            'golongan_penyakit_deleted_at' => 'Golongan Penyakit Deleted At',
            'golongan_penyakit_deleted_by' => 'Golongan Penyakit Deleted By',
        ];
    }
    function beforeSave($model)
    {
        if ($this->isNewRecord) {
            $this->golongan_penyakit_created_at = date('Y-m-d H:i:s');
            $this->golongan_penyakit_created_by = Yii::$app->user->identity->id;
        } else {
            $this->golongan_penyakit_updated_at = date('Y-m-d H:i:s');
            $this->golongan_penyakit_updated_by = Yii::$app->user->identity->id;
        }
        return parent::beforeSave($model);
    }
}
