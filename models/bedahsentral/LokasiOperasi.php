<?php

namespace app\models\bedahsentral;

use app\components\Akun;
use app\models\other\TrimBehavior;
use app\models\pegawai\TbPegawai;
use Yii;

class LokasiOperasi extends \yii\db\ActiveRecord
{
  const ass_n = 'Lokasi Operasi';

  public static function tableName()
  {
    return 'bedah_sentral.lokasi_operasi';
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
      [['mlo_to_id', 'mlo_dokter_yg_melakukan_pgw_id'], 'required'],
      [['mlo_to_id', 'mlo_dokter_yg_melakukan_pgw_id', 'mlo_batal', 'mlo_mdcp_id', 'mlo_created_by', 'mlo_updated_by', 'mlo_deleted_by'], 'default', 'value' => null],
      [['mlo_to_id', 'mlo_dokter_yg_melakukan_pgw_id', 'mlo_final', 'mlo_batal', 'mlo_mdcp_id', 'mlo_created_by', 'mlo_updated_by', 'mlo_deleted_by'], 'integer'],
      [['mlo_gambar_marking', 'mlo_keterangan_marking', 'mlo_catatan'], 'string'],
      [['mlo_tgl_final', 'mlo_tgl_batal', 'mlo_created_at', 'mlo_updated_at', 'mlo_deleted_at'], 'safe'],
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function attributeLabels()
  {
    return [
      'mlo_id' => 'Mlo ID',
      'mlo_to_id' => 'Mlo To ID',
      'mlo_dokter_yg_melakukan_pgw_id' => 'Mlo Dokter Yg Melakukan Pgw ID',
      'mlo_gambar_marking' => 'Mlo Gambar Marking',
      'mlo_keterangan_marking' => 'Mlo Keterangan Marking',
      'mlo_catatan' => 'Mlo Catatan',
      'mlo_final' => 'Mlo Final',
      'mlo_tgl_final' => 'Mlo Tgl Final',
      'mlo_batal' => 'Mlo Batal',
      'mlo_tgl_batal' => 'Mlo Tgl Batal',
      'mlo_mdcp_id' => 'Mlo Mdcp ID',
      'mlo_created_at' => 'Mlo Created At',
      'mlo_created_by' => 'Mlo Created By',
      'mlo_updated_at' => 'Mlo Updated At',
      'mlo_updated_by' => 'Mlo Updated By',
      'mlo_deleted_at' => 'Mlo Deleted At',
      'mlo_deleted_by' => 'Mlo Deleted By',
    ];
  }
  public function getModelClasName()
  {
    $class = explode("\\", get_called_class());
    return $class[(count($class) - 1)];
  }
  public function behaviors()
  {
    return [
      [
        'class' => TrimBehavior::className(),
      ],
    ];
  }
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
      $this->mlo_created_by = Akun::user()->id;
      $this->mlo_created_at = date('Y-m-d H:i:s');
    } else {
      $this->mlo_updated_by = Akun::user()->id;
      $this->mlo_updated_at = date('Y-m-d H:i:s');
    }
    return parent::beforeSave($model);
  }
  function setDelete()
  {
    $this->mlo_deleted_at = date('Y-m-d H:i:s');
    $this->mlo_deleted_by = Akun::user()->id;
  }
  function setBatal()
  {
    $this->mlo_batal = 1;
    $this->mlo_tgl_batal = date('Y-m-d H:i:s');
  }
  function setFinal()
  {
    $this->mlo_final = 1;
    $this->mlo_tgl_final = date('Y-m-d H:i:s');
  }
  function getTimoperasi()
  {
    return $this->hasOne(TimOperasi::className(), ['to_id' => 'mlo_to_id']);
  }
  function getDokter()
  {
    return $this->hasOne(TbPegawai::className(), ['pgw_id' => 'mlo_dokter_yg_melakukan_pgw_id']);
  }
}
