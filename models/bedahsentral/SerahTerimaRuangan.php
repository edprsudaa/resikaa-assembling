<?php

namespace app\models\bedahsentral;

use app\components\Akun;
use app\models\other\TrimBehavior;
use app\models\pegawai\TbPegawai;
use Yii;

class SerahTerimaRuangan extends \yii\db\ActiveRecord
{
  const ass_n = 'Serah Terima Ruangan';
  /**
   * {@inheritdoc}
   */
  public static function tableName()
  {
    return 'bedah_sentral.serah_terima_ruangan';
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
      [['mstr_pl_id', 'mstr_perawat_menyerahkan_pgw_id', 'mstr_perawat_penerima_pgw_id', 'mstr_tgl_final', 'mstr_tgl_batal', 'mstr_created_at', 'mstr_updated_at', 'mstr_deleted_at'], 'required'],
      [['mstr_pl_id', 'mstr_dpjp1_pgw_id', 'mstr_dpjp2_pgw_id', 'mstr_dpjp3_pgw_id', 'mstr_dpjp4_pgw_id', 'mstr_perawat_menyerahkan_pgw_id', 'mstr_perawat_penerima_pgw_id', 'mstr_nyeri_skor', 'mstr_final', 'mstr_batal', 'mstr_mdcp_id', 'mstr_created_by', 'mstr_updated_by', 'mstr_deleted_by'], 'default', 'value' => null],
      [['mstr_pl_id', 'mstr_dpjp1_pgw_id', 'mstr_dpjp2_pgw_id', 'mstr_dpjp3_pgw_id', 'mstr_dpjp4_pgw_id', 'mstr_perawat_menyerahkan_pgw_id', 'mstr_perawat_penerima_pgw_id', 'mstr_nyeri_skor', 'mstr_final', 'mstr_batal', 'mstr_mdcp_id', 'mstr_created_by', 'mstr_updated_by', 'mstr_deleted_by'], 'integer'],
      [['mstr_tgl_masuk_ruangan', 'mstr_amp_iv_catch_tgl_pasang', 'mstr_ngt_ogt_tgl_pasang', 'mstr_catheter_tgl_pasang', 'mstr_tgl_final', 'mstr_tgl_batal', 'mstr_created_at', 'mstr_updated_at', 'mstr_deleted_at'], 'safe'],
      [['mstr_ruangan_asal', 'mstr_pindah_keruangan', 'mstr_diagnosis_sekarang', 'mstr_alat_transfer_pasien', 'mstr_keadaan_umum', 'mstr_tekanan_darah_sistole', 'mstr_tekanan_darah_diastole', 'mstr_suhu', 'mstr_nadi', 'mstr_pernafasan', 'mstr_tingkat_kesadaran', 'mstr_gcs_e', 'mstr_gcs_m', 'mstr_gcs_v', 'mstr_penggunaan_o2', 'mstr_penggunaan_o2_via', 'mstr_nyeri_penyebab', 'mstr_nyeri_hal_memperburuk', 'mstr_nyeri_hal_memperingan', 'mstr_nyeri_kualitas', 'mstr_nyeri_lokasi', 'mstr_nyeri_penjalaran', 'mstr_nyeri_kategori', 'mstr_nyeri_metode', 'mstr_nyeri_lama', 'mstr_nyeri_frekuensi', 'mstr_resiko_jatuh_skor', 'mstr_resiko_jatuh_kategori', 'mstr_resiko_jatuh_metode', 'mstr_resiko_jatuh_langkah_pencegahan', 'mstr_dekubitus', 'mstr_diet', 'mstr_mobilisasi', 'mstr_ambulasi', 'mstr_obat_oral', 'mstr_ivyd', 'mstr_obat_injeksi', 'mstr_amp_iv_catch_no', 'mstr_ngt_ogt_no', 'mstr_catheter_no', 'mstr_tindakan_medis_yg_sudah_dilakukan', 'mstr_tindakan_keperawatan_yg_sudah_dilakukan', 'mstr_pemeriksaan_diagnosis_yg_sudah_dilakukan', 'mstr_hal_yg_diperhatikan_dan_dokumen'], 'string'],
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function attributeLabels()
  {
    return [
      'mstr_id' => 'Mstr ID',
      'mstr_pl_id' => 'Mstr Pl ID',
      'mstr_to_id' => 'Mstr To ID',
      'mstr_dpjp1_pgw_id' => 'Mstr Dpjp 1 Pgw ID',
      'mstr_dpjp2_pgw_id' => 'Mstr Dpjp 2 Pgw ID',
      'mstr_dpjp3_pgw_id' => 'Mstr Dpjp 3 Pgw ID',
      'mstr_dpjp4_pgw_id' => 'Mstr Dpjp 4 Pgw ID',
      'mstr_perawat_menyerahkan_pgw_id' => 'Mstr Perawat Menyerahkan Pgw ID',
      'mstr_perawat_penerima_pgw_id' => 'Mstr Perawat Penerima Pgw ID',
      'mstr_tgl_masuk_ruangan' => 'Mstr Tgl Masuk Ruangan',
      'mstr_ruangan_asal' => 'Mstr Ruangan Asal',
      'mstr_pindah_keruangan' => 'Mstr Pindah Keruangan',
      'mstr_diagnosis_sekarang' => 'Mstr Diagnosis Sekarang',
      'mstr_alat_transfer_pasien' => 'Mstr Alat Transfer Pasien',
      'mstr_keadaan_umum' => 'Mstr Keadaan Umum',
      'mstr_tekanan_darah_sistole' => 'Mstr Tekanan Darah Sistole',
      'mstr_tekanan_darah_diastole' => 'Mstr Tekanan Darah Diastole',
      'mstr_suhu' => 'Mstr Suhu',
      'mstr_nadi' => 'Mstr Nadi',
      'mstr_pernafasan' => 'Mstr Pernafasan',
      'mstr_tingkat_kesadaran' => 'Mstr Tingkat Kesadaran',
      'mstr_gcs_e' => 'Mstr Gcs E',
      'mstr_gcs_m' => 'Mstr Gcs M',
      'mstr_gcs_v' => 'Mstr Gcs V',
      'mstr_penggunaan_o2' => 'Mstr Penggunaan O 2',
      'mstr_penggunaan_o2_via' => 'Mstr Penggunaan O 2 Via',
      'mstr_nyeri_penyebab' => 'Mstr Nyeri Penyebab',
      'mstr_nyeri_hal_memperburuk' => 'Mstr Nyeri Hal Memperburuk',
      'mstr_nyeri_hal_memperingan' => 'Mstr Nyeri Hal Memperingan',
      'mstr_nyeri_kualitas' => 'Mstr Nyeri Kualitas',
      'mstr_nyeri_lokasi' => 'Mstr Nyeri Lokasi',
      'mstr_nyeri_penjalaran' => 'Mstr Nyeri Penjalaran',
      'mstr_nyeri_skor' => 'Mstr Nyeri Skor',
      'mstr_nyeri_kategori' => 'Mstr Nyeri Kategori',
      'mstr_nyeri_metode' => 'Mstr Nyeri Metode',
      'mstr_nyeri_lama' => 'Mstr Nyeri Lama',
      'mstr_nyeri_frekuensi' => 'Mstr Nyeri Frekuensi',
      'mstr_resiko_jatuh_skor' => 'Mstr Resiko Jatuh Skor',
      'mstr_resiko_jatuh_kategori' => 'Mstr Resiko Jatuh Kategori',
      'mstr_resiko_jatuh_metode' => 'Mstr Resiko Jatuh Metode',
      'mstr_resiko_jatuh_langkah_pencegahan' => 'Mstr Resiko Jatuh Langkah Pencegahan',
      'mstr_dekubitus' => 'Mstr Dekubitus',
      'mstr_diet' => 'Mstr Diet',
      'mstr_mobilisasi' => 'Mstr Mobilisasi',
      'mstr_ambulasi' => 'Mstr Ambulasi',
      'mstr_obat_oral' => 'Mstr Obat Oral',
      'mstr_ivyd' => 'Mstr Ivyd',
      'mstr_obat_injeksi' => 'Mstr Obat Injeksi',
      'mstr_amp_iv_catch_no' => 'Mstr Amp Iv Catch No',
      'mstr_amp_iv_catch_tgl_pasang' => 'Mstr Amp Iv Catch Tgl Pasang',
      'mstr_ngt_ogt_no' => 'Mstr Ngt Ogt No',
      'mstr_ngt_ogt_tgl_pasang' => 'Mstr Ngt Ogt Tgl Pasang',
      'mstr_catheter_no' => 'Mstr Catheter No',
      'mstr_catheter_tgl_pasang' => 'Mstr Catheter Tgl Pasang',
      'mstr_tindakan_medis_yg_sudah_dilakukan' => 'Mstr Tindakan Medis Yg Sudah Dilakukan',
      'mstr_tindakan_keperawatan_yg_sudah_dilakukan' => 'Mstr Tindakan Keperawatan Yg Sudah Dilakukan',
      'mstr_pemeriksaan_diagnosis_yg_sudah_dilakukan' => 'Mstr Pemeriksaan Diagnosis Yg Sudah Dilakukan',
      'mstr_hal_yg_diperhatikan_dan_dokumen' => 'Mstr Hal Yg Diperhatikan Dan Dokumen',
      'mstr_final' => 'Mstr Final',
      'mstr_tgl_final' => 'Mstr Tgl Final',
      'mstr_batal' => 'Mstr Batal',
      'mstr_tgl_batal' => 'Mstr Tgl Batal',
      'mstr_mdcp_id' => 'Mstr Mdcp ID',
      'mstr_created_at' => 'Mstr Created At',
      'mstr_created_by' => 'Mstr Created By',
      'mstr_updated_at' => 'Mstr Updated At',
      'mstr_updated_by' => 'Mstr Updated By',
      'mstr_deleted_at' => 'Mstr Deleted At',
      'mstr_deleted_by' => 'Mstr Deleted By',
    ];
  }

  public function getModelClasName()
  {
    $class = explode("\\", get_called_class());
    return $class[(count($class) - 1)];
  }
  // public static function find()
  // {
  //     return (new BaseQuery(get_called_class()))->setPrefix(self::prefix);
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
      $this->mstr_created_by = Akun::user()->id;
      $this->mstr_created_at = date('Y-m-d H:i:s');
    } else {
      $this->mstr_updated_by = Akun::user()->id;
      $this->mstr_updated_at = date('Y-m-d H:i:s');
    }
    return parent::beforeSave($model);
  }
  function setDelete()
  {
    $this->mstr_deleted_at = date('Y-m-d H:i:s');
    $this->mstr_deleted_by = Akun::user()->id;
  }
  function setBatal()
  {
    $this->mstr_batal = 1;
    $this->mstr_tgl_batal = date('Y-m-d H:i:s');
  }
  function setFinal()
  {
    $this->mstr_final = 1;
    $this->mstr_tgl_final = date('Y-m-d H:i:s');
  }
  function getPerawatpenerima()
  {
    return $this->hasOne(TbPegawai::className(), ['pegawai_id' => 'mstr_perawat_penerima_pgw_id']);
  }
  function getPerawatmenyerahkan()
  {
    return $this->hasOne(TbPegawai::className(), ['pegawai_id' => 'mstr_perawat_menyerahkan_pgw_id']);
  }
  function getDokter1()
  {
    return $this->hasOne(TbPegawai::className(), ['pegawai_id' => 'mstr_dpjp1_pgw_id']);
  }
  function getDokter2()
  {
    return $this->hasOne(TbPegawai::className(), ['pegawai_id' => 'mstr_dpjp2_pgw_id']);
  }
  function getDokter3()
  {
    return $this->hasOne(TbPegawai::className(), ['pegawai_id' => 'mstr_dpjp3_pgw_id']);
  }
  function getDokter4()
  {
    return $this->hasOne(TbPegawai::className(), ['pegawai_id' => 'mstr_dpjp4_pgw_id']);
  }
  function getTimoperasi()
  {
    return $this->hasOne(TimOperasi::className(), ['to_id' => 'mstr_to_id']);
  }
}
