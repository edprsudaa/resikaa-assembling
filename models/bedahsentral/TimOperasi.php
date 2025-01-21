<?php

namespace app\models\bedahsentral;

use app\components\Akun;
use app\models\other\BaseQuery;
use app\models\other\TrimBehavior;
use app\models\pegawai\DmUnitPenempatan;
use app\models\pendaftaran\Layanan;
use app\models\sso\PegawaiUser;
use app\models\User;
use Yii;

class TimOperasi extends \yii\db\ActiveRecord
{
  /**
   * {@inheritdoc}
   */
  public static function tableName()
  {
    return 'bedah_sentral.tim_operasi';
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
      [['to_ruang_asal_pl_id', 'to_ok_unt_id', 'to_tanggal_operasi'], 'required'],

      // [['to_tanggal_operasi', 'to_ok_pl_id'], 'required', 'on' => 'ok_create_lainnya', 'message' => '{attribute} harus diisi'],

      [['to_ruang_asal_pl_id', 'to_ok_pl_id', 'to_ok_unt_id', 'to_jenis_operasi_cito'], 'integer'],
      [['to_diagnosa_medis_pra_bedah', 'to_diagnosa_medis_pasca_bedah', 'to_tindakan_operasi'], 'string'],
      [['to_tanggal_operasi', 'to_created_at', 'to_updated_at', 'to_deleted_at'], 'safe'],
      [['to_created_by', 'to_updated_by', 'to_deleted_by'], 'string', 'max' => 255],
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function attributeLabels()
  {
    return [
      'to_id' => 'ID',
      'to_ok_pl_id' => 'Layanan OK Pasien',
      'to_ruang_asal_pl_id' => 'Layanan Asal Pasien',
      'to_ok_unt_id' => 'Unit OK Pasien',
      'to_diagnosa_medis_pra_bedah' => 'Diagnosa Medis Pra Bedah',
      'to_diagnosa_medis_pasca_bedah' => 'Diagnosa Medis Pasca Bedah',
      'to_jenis_operasi_cito' => 'Jenis Operasi Cito',
      'to_tindakan_operasi' => 'Tindakan Operasi',
      'to_tanggal_operasi' => 'Tanggal Operasi',
      'to_created_at' => 'Created At',
      'to_created_by' => 'Created By',
      'to_updated_at' => 'Updated At',
      'to_updated_by' => 'Updated By',
      'to_deleted_at' => 'Deleted At',
      'to_deleted_by' => 'Deleted By',
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
  public static function find()
  {
    return new BaseQuery(get_called_class());
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
      $this->to_created_by = Akun::user()->id;
      $this->to_created_at = date('Y-m-d H:i:s');
    } else {
      $this->to_updated_by = Akun::user()->id;
      $this->to_updated_at = date('Y-m-d H:i:s');
    }
    return parent::beforeSave($model);
  }
  function setDelete()
  {
    $this->to_deleted_at = date('Y-m-d H:i:s');
    $this->to_deleted_by = Akun::user()->id;
  }
  function getLayanan()
  {
    return $this->hasOne(Layanan::className(), ['id' => 'to_ruang_asal_pl_id']);
  }
  function getLayananAsal()
  {
    return $this->hasOne(Layanan::className(), ['id' => 'to_ok_pl_id']);
  }
  function getTimOperasiDetail()
  {
    return $this->hasMany(TimOperasiDetail::className(), ['tod_to_id' => 'to_id']);
  }
  function getLaporanOperasi()
  {
    return $this->hasMany(LaporanOperasi::className(), ['lap_op_to_id' => 'to_id']);
  }
  function getTimDetail()
  {
    return $this->hasOne(TimOperasiDetail::className(), ['tod_to_id' => 'to_id']);
  }
  function getUnit()
  {
    return $this->hasOne(DmUnitPenempatan::className(), ['kode' => 'to_ok_unt_id']);
  }
  function getCreatedby()
  {
    return $this->hasOne(PegawaiUser::className(), ['userid' => 'to_created_by']);
  }
}
