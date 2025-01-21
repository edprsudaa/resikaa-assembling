<?php

namespace app\models\bedahsentral;

use app\components\Akun;
use app\models\other\TrimBehavior;
use app\models\pegawai\TbPegawai;
use app\models\sso\PegawaiUser;
use Yii;

class LembarEdukasiTindakanAnestesi extends \yii\db\ActiveRecord
{
  const ass_n = 'Lembar Edukasi Tindakan Anestesi';
  /**
   * {@inheritdoc}
   */
  public static function tableName()
  {
    return 'bedah_sentral.lembar_edukasi_tindakan_anestesi';
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
      [['leta_to_id'], 'required'],
      [['leta_id', 'leta_to_id', 'leta_final', 'leta_batal', 'leta_created_by', 'leta_updated_by', 'leta_deleted_by', 'leta_dokter_yg_mejelaskan', 'leta_mdcp_id'], 'integer'],
      [['leta_keluarga_nama', 'leta_keluarga_umur', 'leta_keluarga_alamat', 'leta_keluarga_no_identitas', 'leta_keluarga_hubunga_dgn_pasien', 'leta_pasien_nama', 'leta_pasien_no_rekam_medis', 'leta_pasien_diagnosa', 'leta_pasien_rencana_tindakan', 'leta_pasien_jenis_anestesi', 'leta_pasien_analgesi_pasca_anestesi', 'leta_keluarga_jenis_kelamin', 'leta_setuju'], 'string'],
      [['leta_pasien_tgl_lahir', 'leta_tanggal_persetujuan', 'leta_tgl_final', 'leta_tgl_batal', 'leta_created_at', 'leta_updated_at', 'leta_deleted_at', 'leta_kelebihan_anestesi_umum', 'leta_kekurangan_anestesi_umum', 'leta_komplikasi_anestesi_umum', 'leta_kelebihan_anestesi_regional', 'leta_kekurangan_anestesi_regional', 'leta_komplikasi_anestesi_regional', 'leta_kelebihan_anestesi_lokal', 'leta_kekurangan_anestesi_lokal', 'leta_komplikasi_anestesi_lokal', 'leta_kelebihan_sedasi', 'leta_kekurangan_sedasi', 'leta_komplikasi_sedasi'], 'safe'],
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function attributeLabels()
  {
    return [
      'leta_id' => 'ID',
      'leta_to_id' => 'Pl ID',
      'leta_kelebihan_anestesi_umum' => 'Kelebihan Anestesi Umum',
      'leta_kekurangan_anestesi_umum' => 'Kekurangan Anestesi Umum',
      'leta_komplikasi_anestesi_umum' => 'Komplikasi Anestesi Umum',
      'leta_kelebihan_anestesi_regional' => 'Kelebihan Anestesi Regional',
      'leta_kekurangan_anestesi_regional' => 'Kekurangan Anestesi Regional',
      'leta_komplikasi_anestesi_regional' => 'Komplikasi Anestesi Regional',
      'leta_kelebihan_anestesi_lokal' => 'Kelebihan Anestesi Lokal',
      'leta_kekurangan_anestesi_lokal' => 'Kekurangan Anestesi Lokal',
      'leta_komplikasi_anestesi_lokal' => 'Komplikasi Anestesi Lokal',
      'leta_kelebihan_sedasi' => 'Kelebihan Sedasi',
      'leta_kekurangan_sedasi' => 'Kekurangan Sedasi',
      'leta_komplikasi_sedasi' => 'Komplikasi Sedasi',
      'leta_keluarga_nama' => 'Nama',
      'leta_keluarga_umur' => 'Umur',
      'leta_keluarga_jenis_kelamin' => 'Jenis kelamin',
      'leta_keluarga_alamat' => 'Alamat',
      'leta_keluarga_no_identitas' => 'No. Kartu Identitas',
      'leta_keluarga_hubunga_dgn_pasien' => 'Hubungan Dengan Pasien',
      'leta_pasien_nama' => 'Nama',
      'leta_pasien_tgl_lahir' => 'Tanggal Lahir',
      'leta_pasien_no_rekam_medis' => 'No. Rekam Medis',
      'leta_pasien_diagnosa' => 'Diagnosa',
      'leta_pasien_rencana_tindakan' => 'Rencana Tindakan',
      'leta_pasien_jenis_anestesi' => 'Jenis Anestesi/sedasi',
      'leta_pasien_analgesi_pasca_anestesi' => 'Analgesi Pasca Anestesi/sedasi',
      'leta_tanggal_persetujuan' => 'Tanggal Persetujuan',
      'leta_setuju' => 'Setuju',
      'leta_final' => 'Final',
      'leta_tgl_final' => 'Tgl Final',
      'leta_batal' => 'Batal',
      'leta_tgl_batal' => 'Tgl Batal',
      'leta_created_at' => 'Created At',
      'leta_created_by' => 'Created By',
      'leta_updated_at' => 'Updated At',
      'leta_updated_by' => 'Updated By',
      'leta_deleted_at' => 'Deleted At',
      'leta_deleted_by' => 'Deleted By',
      'leta_mdcp_id' => 'Mdcp ID',
    ];
    // return [
    //   'leta_id' => 'ID',
    //   'leta_to_id' => 'To ID',
    //   'leta_dokter_yg_mejelaskan' => 'Dokter Yg Mejelaskan',
    //   'leta_kelebihan_anestesi_umum' => 'Kelebihan Anestesi Umum',
    //   'leta_kekurangan_anestesi_umum' => 'Kekurangan Anestesi Umum',
    //   'leta_komplikasi_anestesi_umum' => 'Komplikasi Anestesi Umum',
    //   'leta_kelebihan_anestesi_regional' => 'Kelebihan Anestesi Regional',
    //   'leta_kekurangan_anestesi_regional' => 'Kekurangan Anestesi Regional',
    //   'leta_komplikasi_anestesi_regional' => 'Komplikasi Anestesi Regional',
    //   'leta_kelebihan_anestesi_lokal' => 'Kelebihan Anestesi Lokal',
    //   'leta_kekurangan_anestesi_lokal' => 'Kekurangan Anestesi Lokal',
    //   'leta_komplikasi_anestesi_lokal' => 'Komplikasi Anestesi Lokal',
    //   'leta_kelebihan_sedasi' => 'Kelebihan Sedasi',
    //   'leta_kekurangan_sedasi' => 'Kekurangan Sedasi',
    //   'leta_komplikasi_sedasi' => 'Komplikasi Sedasi',
    //   'leta_keluarga_nama' => 'Keluarga Nama',
    //   'leta_keluarga_umur' => 'Keluarga Umur',
    //   'leta_keluarga_jenis_kelamin' => 'Keluarga Jenis Kelamin',
    //   'leta_keluarga_alamat' => 'Keluarga Alamat',
    //   'leta_keluarga_no_identitas' => 'Keluarga No Identitas',
    //   'leta_keluarga_hubunga_dgn_pasien' => 'Keluarga Hubunga Dgn Pasien',
    //   'leta_pasien_nama' => 'Pasien Nama',
    //   'leta_pasien_tgl_lahir' => 'Pasien Tgl Lahir',
    //   'leta_pasien_no_rekam_medis' => 'Pasien No Rekam Medis',
    //   'leta_pasien_diagnosa' => 'Pasien Diagnosa',
    //   'leta_pasien_rencana_tindakan' => 'Pasien Rencana Tindakan',
    //   'leta_pasien_jenis_anestesi' => 'Pasien Jenis Anestesi',
    //   'leta_pasien_analgesi_pasca_anestesi' => 'Pasien Analgesi Pasca Anestesi',
    //   'leta_tanggal_persetujuan' => 'Tanggal Persetujuan',
    //   'leta_setuju' => 'Setuju',
    //   'leta_final' => 'Final',
    //   'leta_tgl_final' => 'Tgl Final',
    //   'leta_batal' => 'Batal',
    //   'leta_tgl_batal' => 'Tgl Batal',
    //   'leta_created_at' => 'Created At',
    //   'leta_created_by' => 'Created By',
    //   'leta_updated_at' => 'Updated At',
    //   'leta_updated_by' => 'Updated By',
    //   'leta_deleted_at' => 'Deleted At',
    //   'leta_deleted_by' => 'Deleted By',
    // ];
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
      $this->leta_created_by = Akun::user()->id;
      $this->leta_created_at = date('Y-m-d H:i:s');
    } else {
      $this->leta_updated_by = Akun::user()->id;
      $this->leta_updated_at = date('Y-m-d H:i:s');
    }
    return parent::beforeSave($model);
  }
  function setDelete()
  {
    $this->leta_deleted_at = date('Y-m-d H:i:s');
    $this->leta_deleted_by = Akun::user()->id;
  }
  function setBatal()
  {
    $this->leta_batal = 1;
    $this->leta_tgl_batal = date('Y-m-d H:i:s');
  }
  function setFinal()
  {
    $this->leta_final = 1;
    $this->leta_tgl_final = date('Y-m-d H:i:s');
  }
  function getTimoperasi()
  {
    return $this->hasOne(TimOperasi::className(), ['to_id' => 'leta_to_id']);
  }
  function getDokter()
  {
    return $this->hasOne(PegawaiUser::className(), ['userid' => 'leta_dokter_yg_mejelaskan']);
  }
}
