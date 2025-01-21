<?php

namespace app\models\bedahsentral;

use Yii;

class CairanKeluarCatatanLokalAnestesi extends \yii\db\ActiveRecord
{
  /**
   * {@inheritdoc}
   */
  public static function tableName()
  {
    return 'cairan_keluar_catatan_lokal_anestesi';
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
      [['kmcl_cla_id', 'kmcl_cairan_nama'], 'required'],
      [['kmcl_cla_id', 'kmcl_jumlah', 'kmcl_created_by', 'kmcl_updated_by', 'kmcl_deleted_by'], 'default', 'value' => null],
      [['kmcl_cairan_nama'], 'string'],
      [['kmcl_cla_id', 'kmcl_jumlah', 'kmcl_created_by', 'kmcl_updated_by', 'kmcl_deleted_by'], 'integer'],
      [['kmcl_waktu', 'kmcl_created_at', 'kmcl_updated_at', 'kmcl_deleted_at'], 'safe'],
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function attributeLabels()
  {
    return [
      'kmcl_id' => 'ID',
      'kmcl_cla_id' => 'Intra Operasi Mia ID',
      'kmcl_cairan_nama' => 'Cairan Mmc ID',
      'kmcl_jumlah' => 'Jumlah',
      'kmcl_waktu' => 'Waktu',
      'kmcl_created_at' => 'Created At',
      'kmcl_created_by' => 'Created By',
      'kmcl_updated_at' => 'Updated At',
      'kmcl_updated_by' => 'Updated By',
      'kmcl_deleted_at' => 'Deleted At',
      'kmcl_deleted_by' => 'Deleted By',
    ];
  }
}
