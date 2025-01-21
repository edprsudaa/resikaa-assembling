<?php

namespace app\models\bedahsentral;

use Yii;
use app\models\other\TrimBehavior;
use app\components\Akun;
use app\models\pegawai\TbPegawai;

class IntraOperasiPerawat extends \yii\db\ActiveRecord
{
  const ass_n = 'Intra Operasi';

  public static function tableName()
  {
    return 'bedah_sentral.intra_operasi_perawat';
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
      [['iop_to_id', 'iop_esu_dipasang_oleh', 'iop_ku_dipasang_oleh', 'iop_final', 'iop_batal', 'iop_mdcp_id', 'iop_created_by', 'iop_updated_by', 'iop_deleted_by'], 'integer'],

      [['iop_disenfeksi_kulit', 'iop_jam_masuk_ok', 'iop_jam_keluar_ok', 'iop_jam_mulai_anestesi', 'iop_jam_selesai_anestesi', 'iop_jam_mulai_bedah', 'iop_jam_selesai_bedah', 'iop_tourniquet_jam_mulai', 'iop_tourniquet_jam_selesai', 'iop_unit_penghangat_jam_mulai' => 'iop_unit_penghangat_jam_mulai', 'iop_unit_penghangat_jam_selesai' => 'iop_unit_penghangat_jam_selesai'], 'safe'],

      [['iop_jenis_pembiusan', 'iop_type_operasi', 'iop_posisi_kanul_intravena', 'iop_posisi_operasi', 'iop_jenis_operasi', 'iop_posisi_tangan', 'iop_kateter_urin', 'iop_esu', 'iop_lok_ntrl_elektroda', 'iop_pemeriksaan_kulit_pra_bedah', 'iop_pemeriksaan_kulit_pasca_bedah', 'iop_unit_penghangat_temperatur' => 'iop_unit_penghangat_temperatur', 'iop_unit_penghangat', 'iop_tourniquet', 'iop_implant', 'iop_drainage', 'iop_irigasi_luka', 'iop_tamplon', 'iop_pemeriksaan_jaringan', 'iop_pernapasan', 'iop_nadi', 'iop_suhu', 'iop_kesadaran', 'iop_status_emosi', 'iop_bowel', 'iop_integritas_kulit', 'iop_tulang', 'iop_tekanan_darah_sistole', 'iop_tekanan_darah_diastole', 'iop_masalah', 'iop_tindakan', 'iop_implementasi', 'iop_evaluasi', 'iop_insisi_kulit' => 'iop_insisi_kulit'], 'string'],

      [['iop_tgl_final', 'iop_tgl_batal', 'iop_created_at', 'iop_updated_at', 'iop_deleted_at'], 'safe'],
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function attributeLabels()
  {
    return [
      'iop_id' => 'ID',
      'iop_to_id' => 'To ID',
      'iop_jam_masuk_ok' => 'Jam Masuk Ok',
      'iop_jam_keluar_ok' => 'Jam Keluar Ok',
      'iop_jam_mulai_anestesi' => 'Jam Mulai Anestesi',
      'iop_jam_selesai_anestesi' => 'Jam Selesai Anestesi',
      'iop_jam_mulai_bedah' => 'Jam Mulai Bedah',
      'iop_jam_selesai_bedah' => 'Jam Selesai Bedah',
      'iop_jenis_pembiusan' => 'Jenis Pembiusan',
      'iop_type_operasi' => 'Type Operasi',
      'iop_posisi_kanul_intravena' => 'Posisi Kanul Intravena',
      'iop_posisi_operasi' => 'Posisi Operasi',
      'iop_jenis_operasi' => 'Jenis Operasi',
      'iop_posisi_tangan' => 'Posisi Tangan',
      'iop_kateter_urin' => 'Kateter Urin',
      'iop_ku_dipasang_oleh' => 'Ku Dipasang Oleh',
      'iop_disenfeksi_kulit' => 'Disenfeksi Kulit',
      'iop_insisi_kulit' => 'Insisi Kulit',
      'iop_esu' => 'Pemakaian Elektrosurgical',
      'iop_esu_dipasang_oleh' => 'Dipasang Oleh',
      'iop_lok_ntrl_elektroda' => 'Lokasi Netral Elektroda',
      'iop_pemeriksaan_kulit_pra_bedah' => 'Pemeriksaan Kulit Pra Bedah',
      'iop_pemeriksaan_kulit_pasca_bedah' => 'Pemeriksaan Kulit Pasca Bedah',
      'iop_unit_penghangat' => 'Unit Penghangat',
      'iop_unit_penghangat_jam_mulai' => 'Unit Penghangat jam mulai',
      'iop_unit_penghangat_temperatur' => 'Unit Penghangat temperatur',
      'iop_unit_penghangat_jam_selesai' => 'Unit Penghangat jam selesai',
      'iop_tourniquet' => 'Pemakaian Tourniquet',
      'iop_tekanan_darah_sistole' => 'Tekanan Darah Sistole',
      'iop_tekanan_darah_diastole' => 'Tekanan Darah Diastole',
      'iop_implant' => 'Pemakaian Implant',
      'iop_drainage' => 'Pemakaian Drainage',
      'iop_irigasi_luka' => 'Irigasi Luka',
      'iop_tamplon' => 'Pemakaian Tamplon',
      'iop_pemeriksaan_jaringan' => 'Pemeriksaan Jaringan',
      'iop_pernapasan' => 'Pernapasan',
      'iop_nadi' => 'Nadi',
      'iop_suhu' => 'Suhu',
      'iop_kesadaran' => 'Kesadaran',
      'iop_status_emosi' => 'Status Emosi',
      'iop_bowel' => 'Bowel',
      'iop_integritas_kulit' => 'Integritas Kulit',
      'iop_tulang' => 'Tulang',
      'iop_masalah' => 'MASALAH KEPERAWATAN',
      'iop_tindakan' => 'INTERVENSI/IMPLEMENTASI',
      'iop_implementasi' => 'INTERVENSI/IMPLEMENTASI',
      'iop_evaluasi' => 'EVALUASI',
    ];
  }
  public function getModelClasName()
  {
    $class = explode("\\", get_called_class());
    return $class[(count($class) - 1)];
  }
  // public static function find()
  // {
  //   return (new BaseQuery(get_called_class()))->setPrefix(self::prefix);
  // }
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
      $this->iop_created_by = Akun::user()->id;
      $this->iop_created_at = date('Y-m-d H:i:s');
    } else {
      $this->iop_updated_by = Akun::user()->id;
      $this->iop_updated_at = date('Y-m-d H:i:s');
    }
    return parent::beforeSave($model);
  }
  function setDelete()
  {
    $this->iop_deleted_at = date('Y-m-d H:i:s');
    $this->iop_deleted_by = Akun::user()->id;
  }
  function setBatal()
  {
    $this->iop_batal = 1;
    $this->iop_tgl_batal = date('Y-m-d H:i:s');
  }
  function setFinal()
  {
    $this->iop_final = 1;
    $this->iop_tgl_final = date('Y-m-d H:i:s');
  }

  function getTimoperasi()
  {
    return $this->hasOne(TimOperasi::className(), ['to_id' => 'iop_to_id']);
  }
  function getPegawaikateter()
  {
    return $this->hasOne(TbPegawai::className(), ['pegawai_id' => 'iop_ku_dipasang_oleh']);
  }
  function getPegawaiesu()
  {
    return $this->hasOne(TbPegawai::className(), ['pegawai_id' => 'iop_esu_dipasang_oleh']);
  }
}
