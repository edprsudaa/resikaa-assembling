<?php

namespace app\models\bedahsentral;

use Yii;

class CairanMasukCatatanLokalAnestesi extends \yii\db\ActiveRecord
{
  /**
   * {@inheritdoc}
   */
  public static function tableName()
  {
    return 'cairan_masuk_catatan_lokal_anestesi';
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
      [['mmcl_cla_id', 'mmcl_cairan_nama'], 'required'],
      [['mmcl_cla_id', 'mmcl_jumlah', 'mmcl_created_by', 'mmcl_updated_by', 'mmcl_deleted_by'], 'default', 'value' => null],
      [['mmcl_cairan_nama'], 'string'],
      [['mmcl_cla_id', 'mmcl_jumlah', 'mmcl_created_by', 'mmcl_updated_by', 'mmcl_deleted_by'], 'integer'],
      [['mmcl_waktu', 'mmcl_created_at', 'mmcl_updated_at', 'mmcl_deleted_at'], 'safe'],
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function attributeLabels()
  {
    return [
      'mmcl_id' => 'ID',
      'mmcl_cla_id' => 'Intra Operasi Mia ID',
      'mmcl_cairan_nama' => 'Cairan Nama',
      'mmcl_jumlah' => 'Jumlah',
      'mmcl_waktu' => 'Waktu',
      'mmcl_created_at' => 'Created At',
      'mmcl_created_by' => 'Created By',
      'mmcl_updated_at' => 'Updated At',
      'mmcl_updated_by' => 'Updated By',
      'mmcl_deleted_at' => 'Deleted At',
      'mmcl_deleted_by' => 'Deleted By',
    ];
  }
}
