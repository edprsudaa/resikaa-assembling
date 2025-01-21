<?php

namespace app\models\bedahsentral;

use app\components\Akun;
use Yii;

class AskanIntraAnestesi extends \yii\db\ActiveRecord
{
  const ass_n = 'Askan Intra Anestesi';
  /**
   * {@inheritdoc}
   */
  public static function tableName()
  {
    return 'askan_intra_anestesi';
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
      [['aia_to_id'], 'required'],

      [['aia_to_id', 'aia_mdcp_id', 'aia_final', 'aia_batal', 'aia_created_by', 'aia_updated_by', 'aia_deleted_by'], 'default', 'value' => null],

      [['aia_to_id', 'aia_mdcp_id', 'aia_final', 'aia_batal', 'aia_created_by', 'aia_updated_by', 'aia_deleted_by'], 'integer'],

      [['aia_obat_induksi', 'aia_cairan_darah', 'aia_darah', 'aia_obat_regional', 'aia_posisi_operasi', 'aia_tehnik_anestesi', 'aia_mulai_anestesi', 'aia_mulai_pembedahan', 'aia_masalah_kesehatan', 'aia_intervensi', 'aia_implementasi', 'aia_evaluasi', 'aia_selesai_anestesi', 'aia_selesai_pembedahan', 'aia_tgl_final', 'aia_tgl_batal', 'aia_created_at', 'aia_updated_at', 'aia_deleted_at'], 'safe'],

      [['aia_obat_inhalasi', 'aia_obat_lainnya'], 'string'],
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function attributeLabels()
  {
    return [
      'aia_id' => 'ID',
      'aia_to_id' => 'To ID',
      'aia_mulai_anestesi' => 'Mulai Anestesi',
      'aia_mulai_pembedahan' => 'Mulai Pembedahan',
      'aia_selesai_anestesi' => 'Selesai Anestesi',
      'aia_selesai_pembedahan' => 'Selesai Pembedahan',
      'aia_tehnik_anestesi' => 'Tehnik Anestesi',
      'aia_obat_induksi' => 'Obat Induksi',
      'aia_obat_inhalasi' => 'Obat Inhalasi',
      'aia_obat_regional' => 'Obat Regional',
      'aia_cairan_darah' => 'Cairan Darah',
      'aia_darah' => 'Darah',
      'aia_posisi_operasi' => 'Posisi Operasi',
      'aia_masalah_kesehatan' => 'Masalah Kesehatan',
      'aia_intervensi' => 'Intervensi',
      'aia_implementasi' => 'Implementasi',
      'aia_evaluasi' => 'Evaluasi',
      'aia_mdcp_id' => 'Mdcp ID',
      'aia_final' => 'Final',
      'aia_tgl_final' => 'Tgl Final',
      'aia_batal' => 'Batal',
      'aia_tgl_batal' => 'Tgl Batal',
      'aia_created_at' => 'Created At',
      'aia_created_by' => 'Created By',
      'aia_updated_at' => 'Updated At',
      'aia_updated_by' => 'Updated By',
      'aia_deleted_at' => 'Deleted At',
      'aia_deleted_by' => 'Deleted By',
      'aia_obat_lainnya' => 'Obat Lainnya',
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
      $this->aia_created_by = Akun::user()->id;
      $this->aia_created_at = date('Y-m-d H:i:s');
    } else {
      $this->aia_updated_by = Akun::user()->id;
      $this->aia_updated_at = date('Y-m-d H:i:s');
    }
    return parent::beforeSave($model);
  }

  function setDelete()
  {
    $this->aia_deleted_at = date('Y-m-d H:i:s');
    $this->aia_deleted_by = Akun::user()->id;
  }
  function setBatal()
  {
    $this->aia_batal = 1;
    $this->aia_tgl_batal = date('Y-m-d H:i:s');
  }
  function setFinal()
  {
    $this->aia_final = 1;
    $this->aia_tgl_final = date('Y-m-d H:i:s');
  }
  function getTimoperasi()
  {
    return $this->hasOne(TimOperasi::className(), ['to_id' => 'aia_to_id']);
  }
}
