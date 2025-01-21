<?php

namespace app\models\bedahsentral;

use app\components\Akun;
use Yii;

class AskanPascaAnestesi extends \yii\db\ActiveRecord
{
  const ass_n = 'Askan Pasca Anestesi';
  /**
   * {@inheritdoc}
   */
  public static function tableName()
  {
    return 'askan_pasca_anestesi';
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
      [['pas_to_id'], 'required'],

      [['pas_to_id', 'pas_final', 'pas_batal', 'pas_created_by', 'pas_updated_by', 'pas_deleted_by'], 'default', 'value' => null],

      [['pas_to_id', 'pas_final', 'pas_batal', 'pas_created_by', 'pas_updated_by', 'pas_deleted_by'], 'integer'],

      [['pas_pernafasan', 'pas_pola_nafas', 'pas_jam_masuk', 'pas_masalah_kesehatan', 'pas_intervensi', 'pas_implementasi', 'pas_evaluasi', 'pas_jam_keluar', 'pas_tgl_final', 'pas_tgl_batal', 'pas_created_at', 'pas_updated_at', 'pas_deleted_at'], 'safe'],

      [['pas_pernafasan1', 'pas_spo2', 'pas_sirkulasi', 'pas_td', 'pas_nadi', 'pas_suhu'], 'string'],
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function attributeLabels()
  {
    return [
      'pas_id' => 'ID',
      'pas_to_id' => 'To ID',
      'pas_jam_masuk' => 'Jam Masuk',
      'pas_jam_keluar' => 'Jam Keluar',
      'pas_pernafasan' => 'Pernafasan',
      'pas_pernafasan1' => 'Pernafasan 1',
      'pas_pola_nafas' => 'Pola Nafas',
      'pas_spo2' => 'Spo 2',
      'pas_sirkulasi' => 'Sirkulasi',
      'pas_td' => 'Td',
      'pas_nadi' => 'Nadi',
      'pas_masalah_kesehatan' => 'Masalah Kesehatan',
      'pas_intervensi' => 'Intervensi',
      'pas_implementasi' => 'Implementasi',
      'pas_evaluasi' => 'Evaluasi',
      'pas_suhu' => 'Suhu',
      'pas_final' => 'Final',
      'pas_tgl_final' => 'Tgl Final',
      'pas_batal' => 'Batal',
      'pas_tgl_batal' => 'Tgl Batal',
      'pas_created_at' => 'Created At',
      'pas_created_by' => 'Created By',
      'pas_updated_at' => 'Updated At',
      'pas_updated_by' => 'Updated By',
      'pas_deleted_at' => 'Deleted At',
      'pas_deleted_by' => 'Deleted By',
    ];
  }

  public function getModelClasName()
  {
    $class = explode("\\", get_called_class());
    return $class[(count($class) - 1)];
  }

  // public function behaviors()
  // {
  //   return [
  //     [
  //       'class' => TrimBehavior::className(),
  //     ],
  //   ];
  // }

  function attr()
  {
    $data = [];
    foreach ($this->attributeLabels() as $key => $val) {
      $data[$val] = $this->{$key};
    }
    return $data;
  }

  function beforeSave($model)
  {
    if ($this->isNewRecord) {
      $this->pas_created_by = Akun::user()->id;
      $this->pas_created_at = date('Y-m-d H:i:s');
    } else {
      $this->pas_updated_by = Akun::user()->id;
      $this->pas_updated_at = date('Y-m-d H:i:s');
    }
    return parent::beforeSave($model);
  }

  function setDelete()
  {
    $this->pas_deleted_at = date('Y-m-d H:i:s');
    $this->pas_deleted_by = Akun::user()->id;
  }
  function setBatal()
  {
    $this->pas_batal = 1;
    $this->pas_tgl_batal = date('Y-m-d H:i:s');
  }
  function setFinal()
  {
    $this->pas_final = 1;
    $this->pas_tgl_final = date('Y-m-d H:i:s');
  }
  function getTimoperasi()
  {
    return $this->hasOne(TimOperasi::className(), ['to_id' => 'pas_to_id']);
  }
}
