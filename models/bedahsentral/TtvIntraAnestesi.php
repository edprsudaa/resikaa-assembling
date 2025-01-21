<?php

namespace app\models\bedahsentral;

use Yii;

class TtvIntraAnestesi extends \yii\db\ActiveRecord
{
  /**
   * {@inheritdoc}
   */
  public static function tableName()
  {
    return 'bedah_sentral.ttv_intra_anestesi';
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
      [['ttva_intra_operasi_mia_id'], 'required'],
      [['ttva_intra_operasi_mia_id', 'ttva_nadi', 'ttva_pernafasan', 'ttva_tek_darah_sistole', 'ttva_tek_darah_diastole', 'ttva_created_by', 'ttva_updated_by', 'ttva_deleted_by'], 'default', 'value' => null],
      [['ttva_intra_operasi_mia_id', 'ttva_nadi', 'ttva_pernafasan', 'ttva_tek_darah_sistole', 'ttva_tek_darah_diastole', 'ttva_created_by', 'ttva_updated_by', 'ttva_deleted_by'], 'integer'],
      [['ttva_waktu', 'ttva_created_at', 'ttva_updated_at', 'ttva_deleted_at'], 'safe'],
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function attributeLabels()
  {
    return [
      'ttva_id' => 'ID',
      'ttva_intra_operasi_mia_id' => 'Intra Operasi Mia ID',
      'ttva_nadi' => 'Nadi',
      'ttva_pernafasan' => 'Pernafasan',
      'ttva_tek_darah_sistole' => 'Sistole',
      'ttva_tek_darah_diastole' => 'Diastole',
      'ttva_waktu' => 'Waktu',
      'ttva_created_at' => 'Created At',
      'ttva_created_by' => 'Created By',
      'ttva_updated_at' => 'Updated At',
      'ttva_updated_by' => 'Updated By',
      'ttva_deleted_at' => 'Deleted At',
      'ttva_deleted_by' => 'Deleted By',
    ];
  }
}
