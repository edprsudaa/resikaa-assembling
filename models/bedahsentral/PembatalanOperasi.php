<?php

namespace app\models\bedahsentral;

use app\components\Akun;
use app\models\pegawai\TbPegawai;
use app\models\sso\PegawaiUser;
use Yii;

class PembatalanOperasi extends \yii\db\ActiveRecord
{
  public static function tableName()
  {
    return 'pembatalan_operasi';
  }

  public static function getDb()
  {
    return Yii::$app->get('db_bedah_sentral');
  }

  public function rules()
  {
    return [
      [['bat_to_id', 'bat_dpjp_bedah', 'bat_karu'], 'required'],

      [['bat_to_id', 'bat_dpjp_anestesi', 'bat_dpjp_bedah', 'bat_karu', 'bat_created_by', 'bat_updated_by', 'bat_deleted_by', 'bat_final', 'bat_batal'], 'default', 'value' => null],

      [['bat_to_id', 'bat_dpjp_anestesi', 'bat_dpjp_bedah', 'bat_karu', 'bat_created_by', 'bat_updated_by', 'bat_deleted_by', 'bat_final', 'bat_batal'], 'integer'],

      [['bat_alasan_pasien', 'bat_alasan_ruang_perawatan', 'bat_alasan_faskamop', 'bat_alasan_operator', 'bat_tanggal_tunda', 'bat_created_at', 'bat_updated_at', 'bat_deleted_at', 'bat_tgl_final', 'bat_tgl_batal'], 'safe'],

      [['bat_diagnosa', 'bat_tindakan', 'bat_alasan_pasien_lain', 'bat_alasan_operator_lain', 'bat_alasan_faskamop_lain', 'bat_alasan_ruang_perawatan_lain'], 'string'],
    ];
  }

  public function attributeLabels()
  {
    return [
      'bat_id' => 'ID',
      'bat_to_id' => 'To ID',
      'bat_dpjp_bedah' => 'Dpjp Bedah',
      'bat_dpjp_anestesi' => 'Dpjp Anestesi',
      'bat_karu' => 'Kepala Ruangan',
      'bat_diagnosa' => 'diagnosa',
      'bat_tindakan' => 'Tindakan',
      'bat_tanggal_tunda' => 'Tanggal Tunda',
      'bat_alasan_pasien' => 'Alasan Pasien',
      'bat_alasan_pasien_lain' => 'Alasan Pasien Lain',
      'bat_alasan_operator' => 'Alasan Operator',
      'bat_alasan_operator_lain' => 'Alasan Operator Lain',
      'bat_alasan_faskamop' => 'Alasan Faskamop',
      'bat_alasan_faskamop_lain' => 'Alasan Faskamop Lain',
      'bat_alasan_ruang_perawatan' => 'Alasan Ruang Perawatan',
      'bat_alasan_ruang_perawatan_lain' => 'Alasan Ruang Perawatan Lain',
      'bat_final' => 'Final',
      'bat_batal' => 'Batal',
      'bat_created_at' => 'Created At',
      'bat_created_by' => 'Created By',
      'bat_updated_at' => 'Updated At',
      'bat_updated_by' => 'Updated By',
      'bat_deleted_at' => 'Deleted At',
      'bat_deleted_by' => 'Deleted By',
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
      $this->bat_created_by = Akun::user()->id;
      $this->bat_created_at = date('Y-m-d H:i:s');
    } else {
      $this->bat_updated_by = Akun::user()->id;
      $this->bat_updated_at = date('Y-m-d H:i:s');
    }
    return parent::beforeSave($model);
  }

  function setDelete()
  {
    $this->bat_deleted_at = date('Y-m-d H:i:s');
    $this->bat_deleted_by = Akun::user()->id;
  }

  function setBatal()
  {
    $this->bat_batal = 1;
    $this->bat_tgl_batal = date('Y-m-d H:i:s');
  }

  function setFinal()
  {
    $this->bat_final = 1;
    $this->bat_tgl_final = date('Y-m-d H:i:s');
  }

  function getTimoperasi()
  {
    return $this->hasOne(TimOperasi::className(), ['to_id' => 'bat_to_id']);
  }

  function getCreatedby()
  {
    return $this->hasOne(PegawaiUser::className(), ['userid' => 'bat_created_by']);
  }

  function getDpjpBedah()
  {
    return $this->hasOne(TbPegawai::className(), ['pegawai_id' => 'bat_dpjp_bedah']);
  }

  function getDpjpAnestesi()
  {
    return $this->hasOne(TbPegawai::className(), ['pegawai_id' => 'bat_dpjp_anestesi']);
  }

  function getKaru()
  {
    return $this->hasOne(TbPegawai::className(), ['pegawai_id' => 'bat_karu']);
  }
}
