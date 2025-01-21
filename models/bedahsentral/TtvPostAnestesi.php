<?php

namespace app\models\bedahsentral;

use Yii;

class TtvPostAnestesi extends \yii\db\ActiveRecord
{
  /**
   * {@inheritdoc}
   */
  public static function tableName()
  {
    return 'bedah_sentral.ttv_post_anestesi';
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
      [['ttvp_post_anestesi_mpa_id'], 'required'],
      [['ttvp_post_anestesi_mpa_id', 'ttvp_tek_darah_sistole', 'ttvp_tek_darah_diastole', 'ttvp_nadi', 'ttvp_created_by', 'ttvp_updated_by', 'ttvp_deleted_by'], 'default', 'value' => null],
      [['ttvp_post_anestesi_mpa_id', 'ttvp_tek_darah_sistole', 'ttvp_tek_darah_diastole', 'ttvp_nadi', 'ttvp_created_by', 'ttvp_updated_by', 'ttvp_deleted_by'], 'integer'],
      [['ttvp_nyeri_metode', 'ttvp_nyeri_skor'], 'string'],
      [['ttvp_waktu', 'ttvp_created_at', 'ttvp_updated_at', 'ttvp_deleted_at'], 'safe'],
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function attributeLabels()
  {
    return [
      'ttvp_id' => 'ID',
      'ttvp_post_anestesi_mpa_id' => 'Post Anestesi Mpa ID',
      'ttvp_tek_darah_sistole' => 'Sistole',
      'ttvp_tek_darah_diastole' => 'Diastole',
      'ttvp_nadi' => 'Nadi',
      'ttvp_nyeri_metode' => 'Nyeri Metode',
      'ttvp_nyeri_skor' => 'Nyeri Skor',
      'ttvp_waktu' => 'Waktu',
      'ttvp_created_at' => 'Created At',
      'ttvp_created_by' => 'Created By',
      'ttvp_updated_at' => 'Updated At',
      'ttvp_updated_by' => 'Updated By',
      'ttvp_deleted_at' => 'Deleted At',
      'ttvp_deleted_by' => 'Deleted By',
    ];
  }
}
