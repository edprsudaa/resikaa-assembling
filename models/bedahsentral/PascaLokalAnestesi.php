<?php

namespace app\models\bedahsentral;

use app\components\Akun;
use app\models\other\TrimBehavior;
use app\models\pegawai\TbPegawai;
use Yii;

class PascaLokalAnestesi extends \yii\db\ActiveRecord
{
  const ass_n = 'Pasca Lokal Anestesi';
  /**
   * {@inheritdoc}
   */
  public static function tableName()
  {
    return 'pasca_lokal_anestesi';
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
      [['pla_to_id'], 'required'],
      [['pla_to_id', 'pla_skor_tools', 'pla_final', 'pla_batal', 'pla_mdcp_id', 'pla_created_by', 'pla_updated_by', 'pla_deleted_by'], 'default', 'value' => null],
      [['pla_to_id', 'pla_skor_tools', 'pla_final', 'pla_batal', 'pla_mdcp_id', 'pla_created_by', 'pla_updated_by', 'pla_deleted_by'], 'integer'],
      [['pla_jam_tiba_diruang_pemulihan', 'pla_keluar_jam', 'pla_tgl_final', 'pla_tgl_batal', 'pla_created_at', 'pla_updated_at', 'pla_deleted_at'], 'safe'],
      [['pla_jenis_tools_digunakan', 'pla_catatan'], 'string'],
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function attributeLabels()
  {
    return [
      'pla_id' => 'Pla ID',
      'pla_to_id' => 'Pla To ID',
      'pla_jam_tiba_diruang_pemulihan' => 'Pla Jam Tiba Diruang Pemulihan',
      'pla_keluar_jam' => 'Pla Keluar Jam',
      'pla_jenis_tools_digunakan' => 'Pla Jenis Tools Digunakan',
      'pla_skor_tools' => 'Pla Skor Tools',
      'pla_catatan' => 'Pla Catatan',
      'pla_final' => 'Pla Final',
      'pla_tgl_final' => 'Pla Tgl Final',
      'pla_batal' => 'Pla Batal',
      'pla_tgl_batal' => 'Pla Tgl Batal',
      'pla_mdcp_id' => 'Pla Mdcp ID',
      'pla_created_at' => 'Pla Created At',
      'pla_created_by' => 'Pla Created By',
      'pla_updated_at' => 'Pla Updated At',
      'pla_updated_by' => 'Pla Updated By',
      'pla_deleted_at' => 'Pla Deleted At',
      'pla_deleted_by' => 'Pla Deleted By',
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
      $this->pla_created_by = Akun::user()->id;
      $this->pla_created_at = date('Y-m-d H:i:s');
    } else {
      $this->pla_updated_by = Akun::user()->id;
      $this->pla_updated_at = date('Y-m-d H:i:s');
    }
    return parent::beforeSave($model);
  }
  
  function setDelete()
  {
    $this->pla_deleted_at = date('Y-m-d H:i:s');
    $this->pla_deleted_by = Akun::user()->id;
  }
  function setBatal()
  {
    $this->pla_batal = 1;
    $this->pla_tgl_batal = date('Y-m-d H:i:s');
  }
  function setFinal()
  {
    $this->pla_final = 1;
    $this->pla_tgl_final = date('Y-m-d H:i:s');
  }
  function getTimoperasi()
  {
    return $this->hasOne(TimOperasi::className(), ['to_id' => 'pla_to_id']);
  }
}
