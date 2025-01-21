<?php

namespace app\models\bedahsentral;

use app\components\Akun;
use app\models\other\TrimBehavior;
use Yii;

class PostOperasiPerawat extends \yii\db\ActiveRecord
{
  const ass_psop = 'Post Operasi';
  /**
   * {@inheritdoc}
   */
  public static function tableName()
  {
    return 'bedah_sentral.post_operasi_perawat';
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
      [['psop_to_id'], 'required'],
      [['psop_to_id', 'psop_iop_id', 'psop_final', 'psop_batal', 'psop_mdcp_id', 'psop_created_by', 'psop_updated_by', 'psop_deleted_by'], 'integer'],
      [['psop_ruang_pemulihan', 'psop_keadaan_umum', 'psop_tingkat_kesadaran', 'psop_status_emosi', 'psop_e', 'psop_m', 'psop_v', 'psop_total_gcs', 'psop_diit_lain_lain', 'psop_tekanan_darah', 'psop_tekanan_darah_diastole', 'psop_nadi', 'psop_suhu', 'psop_pernapasan', 'psop_sirkulasi', 'psop_turgor_kulit', 'psop_posisi_klien', 'psop_pasang_drain', 'psop_jaringan_pa_form', 'psop_serah_keluarga', 'psop_resep', 'psop_pesan_khusus', 'psop_bedrest', 'psop_puasa', 'psop_head_up', 'psop_resep_obat_post_operasi', 'psop_lain_lain', 'psop_penilaian_nyeri', 'psop_integritas_kulit', 'psop_tulang', 'psop_masalah', 'psop_tindakan', 'psop_implementasi', 'psop_evaluasi'], 'string'],
      [['psop_masuk_rr', 'psop_keluar_rr', 'psop_jam_panggil_perawat_ruangan', 'psop_jam_perawat_datang', 'psop_tgl_final', 'psop_tgl_batal', 'psop_created_at', 'psop_updated_at', 'psop_deleted_at', 'psop_barang_diserahkan_via_prwt_rgn'], 'safe'],
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function attributeLabels()
  {
    return [
      'psop_id' => 'ID',
      'psop_to_id' => 'To ID',
      'psop_iop_id' => 'To ID',
      'psop_ruang_pemulihan' => 'Ruang Pemulihan',
      'psop_masuk_rr' => 'Masuk Jam',
      'psop_keluar_rr' => 'Keluar Jam',
      'psop_keadaan_umum' => 'Keadaan Umum',
      'psop_tingkat_kesadaran' => 'Tingkat Kesadaran',
      'psop_status_emosi' => 'Status Emosi',
      'psop_e' => 'GCS (E)',
      'psop_m' => 'GCS (M)',
      'psop_v' => 'GCS (V)',
      'psop_total_gcs' => 'Total GCS',
      'psop_tekanan_darah' => 'TD',
      'psop_diit_lain_lain' => 'Lain-lain',
      'psop_tekanan_darah_diastole' => 'Tekanan Darah Diastole',
      'psop_nadi' => 'Nadi',
      'psop_suhu' => 'Suhu',
      'psop_pernapasan' => 'Pernapasan',
      'psop_sirkulasi' => 'Sirkulasi',
      'psop_turgor_kulit' => 'Turgor Kulit',
      'psop_posisi_klien' => 'Posisi Klien',
      'psop_pasang_drain' => 'Terpasang Drain',
      'psop_jaringan_pa_form' => 'Jaringan PA dan Formulir',
      'psop_serah_keluarga' => 'Serah Keluarga',
      'psop_resep' => 'Resep',
      'psop_jam_panggil_perawat_ruangan' => 'Jam Memanggil Perawat Ruangan',
      'psop_jam_perawat_datang' => 'Jam Perawat Datang',
      'psop_barang_diserahkan_via_prwt_rgn' => 'Barang Diserahkan Via Perawat Ruangan',
      'psop_pesan_khusus' => 'Pesan Khusus',
      'psop_bedrest' => 'Bedrest',
      'psop_puasa' => 'Puasa',
      'psop_head_up' => 'Head Up',
      'psop_resep_obat_post_operasi' => 'Resep Obat post operasi dan nama obat',
      'psop_lain_lain' => 'Lain-lain',
      'psop_penilaian_nyeri' => 'Penilaian Nyeri',
      'psop_integritas_kulit' => 'Integritas Kulit',
      'psop_tulang' => 'Tulang',
      'psop_masalah' => 'MASALAH KEPERAWATAN',
      'psop_tindakan' => 'INTERVENSI/IMPLEMENTASI',
      'psop_implementasi' => 'INTERVENSI/IMPLEMENTASI',
      'psop_evaluasi' => 'EVALUASI',
      'psop_final' => 'Final',
      'psop_tgl_final' => 'Tgl Final',
      'psop_batal' => 'Batal',
      'psop_tgl_batal' => 'Tgl Batal',
      'psop_mdcp_id' => 'Mdcp ID',
      'psop_created_at' => 'Created At',
      'psop_created_by' => 'Created By',
      'psop_updated_at' => 'Updated At',
      'psop_updated_by' => 'Updated By',
      'psop_deleted_at' => 'Deleted At',
      'psop_deleted_by' => 'Deleted By',
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
      $this->psop_created_by = Akun::user()->id;
      $this->psop_created_at = date('Y-m-d H:i:s');
    } else {
      $this->psop_updated_by = Akun::user()->id;
      $this->psop_updated_at = date('Y-m-d H:i:s');
    }
    return parent::beforeSave($model);
  }
  function setDelete()
  {
    $this->psop_deleted_at = date('Y-m-d H:i:s');
    $this->psop_deleted_by = Akun::user()->id;
  }
  function setBatal()
  {
    $this->psop_batal = 1;
    $this->psop_tgl_batal = date('Y-m-d H:i:s');
  }
  function setFinal()
  {
    $this->psop_final = 1;
    $this->psop_tgl_final = date('Y-m-d H:i:s');
  }
  function getTimoperasi()
  {
    return $this->hasOne(TimOperasi::className(), ['to_id' => 'psop_to_id']);
  }
}
