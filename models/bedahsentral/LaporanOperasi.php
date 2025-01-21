<?php

namespace app\models\bedahsentral;

use app\components\Akun;
use app\models\other\TrimBehavior;
use Yii;

class LaporanOperasi extends \yii\db\ActiveRecord
{
  public $label_implan;
  const ass_n = 'Laporan Operasi';
  /**
   * {@inheritdoc}
   */
  public static function tableName()
  {
    return 'bedah_sentral.laporan_operasi';
  }

  /**
   * @return \yii\db\Connection the database connection used by this AR class.
   */
  public static function getDb()
  {
    return Yii::$app->get('db_bedah_sentral');
  }

  public function rules()
  {
    return [
      [['lap_op_to_id'], 'required'],
      [['lap_op_id', 'lap_op_jumlah_tranfusi', 'lap_op_to_id', 'lap_op_final', 'lap_op_batal', 'lap_op_mdcp_id', 'lap_op_created_by', 'lap_op_updated_by', 'lap_op_deleted_by'], 'integer'],
      [['lap_op_tanggal', 'lap_op_jam_mulai', 'lap_op_jam_selesai', 'lap_op_tgl_final', 'lap_op_tgl_batal', 'lap_op_created_at', 'lap_op_updated_at', 'lap_op_deleted_at'], 'safe'],
      [['lap_op_jumlah_perdarahan', 'lap_op_ruangan', 'lap_op_kelas', 'lap_op_jenis_operasi', 'lap_op_lama_operasi', 'lap_op_diagnosis_pre_operasi', 'lap_op_diagnosis_pasca_operasi', 'lap_op_nama_jenis_operasi', 'lap_op_jaringan_operasi_dikirim', 'lap_op_jenis_jaringan', 'lap_op_label_implant', 'lap_op_instruksi_prwt_pasca_operasi', 'lap_op_kompikasi', 'lap_op_laporan', 'lap_op_penyulit'], 'string'],
      [['label_implan'], 'file', 'skipOnEmpty' => true, 'extensions' => 'jpg, png, jpeg'],
    ];
  }

  public function attributeLabels()
  {
    return [
      'lap_op_id' => 'ID',
      'lap_op_to_id' => 'To ID',
      'lap_op_tanggal' => 'Hari/Tanggal',
      'lap_op_ruangan' => 'Ruangan',
      'lap_op_kelas' => 'Kelas',
      'lap_op_jenis_operasi' => 'Jenis Operasi',
      'lap_op_jam_mulai' => 'Jam Mulai',
      'lap_op_jam_selesai' => 'Jam Selesai',
      'lap_op_lama_operasi' => 'Lama Anastesi Berlangsung',
      'lap_op_diagnosis_pre_operasi' => 'Diagnosis Pre Operasi',
      'lap_op_diagnosis_pasca_operasi' => 'Diagnosis Pasca Operasi',
      'lap_op_nama_jenis_operasi' => 'Nama Jenis Operasi',
      'lap_op_jaringan_operasi_dikirim' => 'Dikirim untuk Pemeriksaan',
      'lap_op_jenis_jaringan' => 'Jenis Jaringan',
      'lap_op_label_implant' => 'Label Implant',
      'lap_op_instruksi_prwt_pasca_operasi' => 'Instruksi Perawatan Pasca Operasi',
      'lap_op_kompikasi' => 'Komplikasi',
      'lap_op_jumlah_perdarahan' => 'Jumlah Perdarahan',
      'lap_op_jumlah_tranfusi' => 'Jumlah Tranfusi',
      'lap_op_laporan' => 'Laporan',
      'lap_op_penyulit' => 'Penyulit',
      'lap_op_final' => 'Final',
      'lap_op_tgl_final' => 'Tgl Final',
      'lap_op_batal' => 'Batal',
      'lap_op_tgl_batal' => 'Tgl Batal',
      'lap_op_mdcp_id' => 'Mdcp ID',
      'lap_op_created_at' => 'Created At',
      'lap_op_created_by' => 'Created By',
      'lap_op_updated_at' => 'Updated At',
      'lap_op_updated_by' => 'Updated By',
      'lap_op_deleted_at' => 'Deleted At',
      'lap_op_deleted_by' => 'Deleted By',
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
      $this->lap_op_created_by = Akun::user()->id;
      $this->lap_op_created_at = date('Y-m-d H:i:s');
    } else {
      $this->lap_op_updated_by = Akun::user()->id;
      $this->lap_op_updated_at = date('Y-m-d H:i:s');
    }
    return parent::beforeSave($model);
  }
  function setDelete()
  {
    $this->lap_op_deleted_at = date('Y-m-d H:i:s');
    $this->lap_op_deleted_by = Akun::user()->id;
  }
  function setBatal()
  {
    $this->lap_op_batal = 1;
    $this->lap_op_tgl_batal = date('Y-m-d H:i:s');
  }
  function setFinal()
  {
    $this->lap_op_final = 1;
    $this->lap_op_tgl_final = date('Y-m-d H:i:s');
  }
  function getTimoperasi()
  {
    return $this->hasOne(TimOperasi::className(), ['to_id' => 'lap_op_to_id']);
  }
}
