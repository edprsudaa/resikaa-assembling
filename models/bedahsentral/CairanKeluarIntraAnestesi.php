<?php

namespace app\models\bedahsentral;

use Yii;

class CairanKeluarIntraAnestesi extends \yii\db\ActiveRecord
{
  /**
   * {@inheritdoc}
   */
  public static function tableName()
  {
    return 'bedah_sentral.cairan_keluar_intra_anestesi';
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
      [['ckeluar_intra_operasi_mia_id', 'ckeluar_cairan_nama'], 'required'],
      [['ckeluar_intra_operasi_mia_id', 'ckeluar_jumlah', 'ckeluar_created_by', 'ckeluar_updated_by', 'ckeluar_deleted_by'], 'default', 'value' => null],
      [['ckeluar_cairan_nama'], 'string'],
      [['ckeluar_intra_operasi_mia_id', 'ckeluar_jumlah', 'ckeluar_created_by', 'ckeluar_updated_by', 'ckeluar_deleted_by'], 'integer'],
      [['ckeluar_waktu', 'ckeluar_created_at', 'ckeluar_updated_at', 'ckeluar_deleted_at'], 'safe'],
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function attributeLabels()
  {
    return [
      'ckeluar_id' => 'ID',
      'ckeluar_intra_operasi_mia_id' => 'Intra Operasi Mia ID',
      'ckeluar_cairan_nama' => 'Cairan Mmc ID',
      'ckeluar_jumlah' => 'Jumlah',
      'ckeluar_waktu' => 'Waktu',
      'ckeluar_created_at' => 'Created At',
      'ckeluar_created_by' => 'Created By',
      'ckeluar_updated_at' => 'Updated At',
      'ckeluar_updated_by' => 'Updated By',
      'ckeluar_deleted_at' => 'Deleted At',
      'ckeluar_deleted_by' => 'Deleted By',
    ];
  }
}
