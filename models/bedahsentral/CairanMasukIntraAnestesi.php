<?php

namespace app\models\bedahsentral;

use Yii;

class CairanMasukIntraAnestesi extends \yii\db\ActiveRecord
{
  /**
   * {@inheritdoc}
   */
  public static function tableName()
  {
    return 'bedah_sentral.cairan_masuk_intra_anestesi';
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
      [['cmasuk_intra_operasi_mia_id', 'cmasuk_cairan_nama'], 'required'],
      [['cmasuk_intra_operasi_mia_id', 'cmasuk_jumlah', 'cmasuk_created_by', 'cmasuk_updated_by', 'cmasuk_deleted_by'], 'default', 'value' => null],
      [['cmasuk_cairan_nama'], 'string'],
      [['cmasuk_intra_operasi_mia_id', 'cmasuk_jumlah', 'cmasuk_created_by', 'cmasuk_updated_by', 'cmasuk_deleted_by'], 'integer'],
      [['cmasuk_waktu', 'cmasuk_created_at', 'cmasuk_updated_at', 'cmasuk_deleted_at'], 'safe'],
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function attributeLabels()
  {
    return [
      'cmasuk_id' => 'ID',
      'cmasuk_intra_operasi_mia_id' => 'Intra Operasi Mia ID',
      'cmasuk_cairan_nama' => 'Cairan Nama',
      'cmasuk_jumlah' => 'Jumlah',
      'cmasuk_waktu' => 'Waktu',
      'cmasuk_created_at' => 'Created At',
      'cmasuk_created_by' => 'Created By',
      'cmasuk_updated_at' => 'Updated At',
      'cmasuk_updated_by' => 'Updated By',
      'cmasuk_deleted_at' => 'Deleted At',
      'cmasuk_deleted_by' => 'Deleted By',
    ];
  }
}
