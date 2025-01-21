<?php

namespace app\models\bedahsentral;

use app\components\Akun;
use app\models\other\TrimBehavior;
use Yii;

class PostAnestesi extends \yii\db\ActiveRecord
{
  const ass_n = 'Post Anestesi';
  /**
   * {@inheritdoc}
   */
  public static function tableName()
  {
    return 'bedah_sentral.post_anestesi';
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
      [['mpa_to_id'], 'required'],

      [['mpa_to_id', 'mpa_intra_anestesi_mpa_id', 'mpa_penata_anestesi_pgw_id', 'mpa_dokter_anestesi_pgw_id', 'mpa_skor_tools', 'mpa_final', 'mpa_batal', 'mpa_mdcp_id', 'mpa_created_by', 'mpa_updated_by', 'mpa_deleted_by'], 'default', 'value' => null],

      [['mpa_to_id', 'mpa_intra_anestesi_mpa_id', 'mpa_penata_anestesi_pgw_id', 'mpa_dokter_anestesi_pgw_id', 'mpa_skor_tools', 'mpa_final', 'mpa_batal', 'mpa_mdcp_id', 'mpa_created_by', 'mpa_updated_by', 'mpa_deleted_by'], 'integer'],

      [['mpa_tabel_adelt', 'mpa_tabel_padss', 'mpa_tabel_steward', 'mpa_tabel_bromage', 'mpa_jam_tiba_diruang_pemulihan', 'mpa_keluar_jam', 'mpa_tgl_final', 'mpa_tgl_batal', 'mpa_created_at', 'mpa_updated_at', 'mpa_deleted_at'], 'safe'],

      [['mpa_jenis_tools_digunakan', 'mpa_instruksi_awasi', 'mpa_instruksi_posisi', 'mpa_instruksi_makan_minum', 'mpa_instruksi_infus', 'mpa_instruksi_transfusi', 'mpa_instruksi_program_analgetik', 'mpa_instruksi_program_mual_muntah', 'mpa_instruksi_lain_lain'], 'string'],
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function attributeLabels()
  {
    return [
      'mpa_id' => 'ID',
      'mpa_to_id' => 'To ID',
      'mpa_intra_anestesi_mpa_id' => 'Intra Anestesi ID',
      'mpa_penata_anestesi_pgw_id' => 'Penata Anestesi Pgw ID',
      'mpa_dokter_anestesi_pgw_id' => 'Dokter Anestesi Pgw ID',
      'mpa_jam_tiba_diruang_pemulihan' => 'Jam Tiba Diruang Pemulihan',
      'mpa_keluar_jam' => 'Keluar Jam',
      'mpa_jenis_tools_digunakan' => 'Jenis Tools Digunakan',
      'mpa_skor_tools' => 'Skor Tools',
      'mpa_instruksi_awasi' => 'Instruksi Awasi',
      'mpa_instruksi_posisi' => 'Instruksi Posisi',
      'mpa_instruksi_makan_minum' => 'Instruksi Makan Minum',
      'mpa_instruksi_infus' => 'Instruksi Infus',
      'mpa_instruksi_transfusi' => 'Instruksi Transfusi',
      'mpa_instruksi_program_analgetik' => 'Instruksi Program Analgetik',
      'mpa_instruksi_program_mual_muntah' => 'Instruksi Program Mual Muntah',
      'mpa_instruksi_lain_lain' => 'Instruksi Lain Lain',
      'mpa_final' => 'Final',
      'mpa_tgl_final' => 'Tgl Final',
      'mpa_batal' => 'Batal',
      'mpa_tgl_batal' => 'Tgl Batal',
      'mpa_mdcp_id' => 'Mdcp ID',
      'mpa_created_at' => 'Created At',
      'mpa_created_by' => 'Created By',
      'mpa_updated_at' => 'Updated At',
      'mpa_updated_by' => 'Updated By',
      'mpa_deleted_at' => 'Deleted At',
      'mpa_deleted_by' => 'Deleted By',
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
      $this->mpa_created_by = Akun::user()->id;
      $this->mpa_created_at = date('Y-m-d H:i:s');
    } else {
      $this->mpa_updated_by = Akun::user()->id;
      $this->mpa_updated_at = date('Y-m-d H:i:s');
    }
    return parent::beforeSave($model);
  }
  function setDelete()
  {
    $this->mpa_deleted_at = date('Y-m-d H:i:s');
    $this->mpa_deleted_by = Akun::user()->id;
  }
  function setBatal()
  {
    $this->mpa_batal = 1;
    $this->mpa_tgl_batal = date('Y-m-d H:i:s');
  }
  function setFinal()
  {
    $this->mpa_final = 1;
    $this->mpa_tgl_final = date('Y-m-d H:i:s');
  }
  function getTimoperasi()
  {
    return $this->hasOne(TimOperasi::className(), ['to_id' => 'mpa_to_id']);
  }
  function getTtvpostanestesi()
  {
    return $this->hasOne(TtvPostAnestesi::className(), ['ttvp_post_anestesi_mpa_id' => 'mpa_id']);
  }
}
