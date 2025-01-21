<?php

namespace app\models\bedahsentral;

use app\components\Akun;
use app\models\other\TrimBehavior;
use Yii;

class PenggunaanJumlahKasaDanInstrumen extends \yii\db\ActiveRecord
{
  const ass_n = 'Penggunaan Jumlah Kasa dan Instrumen';
  /**
   * {@inheritdoc}
   */
  public static function tableName()
  {
    return 'bedah_sentral.penggunaan_jumlah_kasa_dan_instrumen';
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
      [['pjki_to_id'], 'required'],
      [['pjki_to_id', 'pjki_final', 'pjki_batal', 'pjki_mdcp_id', 'pjki_created_by', 'pjki_updated_by', 'pjki_deleted_by'], 'default', 'value' => null],
      [['pjki_to_id', 'pjki_final', 'pjki_batal', 'pjki_mdcp_id', 'pjki_created_by', 'pjki_updated_by', 'pjki_deleted_by'], 'integer'],
      [['pjki_tangkai_pisau_hitungan_pertama', 'pjki_tangkai_pisau_tambahan_slma_operasi', 'pjki_tangkai_pisau_jumlah', 'pjki_tangkai_pisau_dipakai', 'pjki_tangkai_pisau_sisa', 'pjki_pinset_anatomis_hitungan_pertama', 'pjki_pinset_anatomis_tambahan_slma_operasi', 'pjki_pinset_anatomis_jumlah', 'pjki_pinset_anatomis_dipakai', 'pjki_pinset_anatomis_sisa', 'pjki_pinset_chrirurgis_hitungan_pertama', 'pjki_pinset_chrirurgis_tambahan_slma_operasi', 'pjki_pinset_chrirurgis_jumlah', 'pjki_pinset_chrirurgis_dipakai', 'pjki_pinset_chrirurgis_sisa', 'pjki_gunting_benang_hitungan_pertama', 'pjki_gunting_benang_tambahan_slma_operasi', 'pjki_gunting_benang_jumlah', 'pjki_gunting_benang_dipakai', 'pjki_gunting_benang_sisa', 'pjki_gunting_jaringan_hitungan_pertama', 'pjki_gunting_jaringan_tambahan_slma_operasi', 'pjki_gunting_jaringan_jumlah', 'pjki_gunting_jaringan_dipakai', 'pjki_gunting_jaringan_sisa', 'pjki_mosquito_pean_hitungan_pertama', 'pjki_mosquito_pean_tambahan_slma_operasi', 'pjki_mosquito_pean_jumlah', 'pjki_mosquito_pean_dipakai', 'pjki_mosquito_pean_sisa', 'pjki_pean_lurus_hitungan_pertama', 'pjki_pean_lurus_tambahan_slma_operasi', 'pjki_pean_lurus_jumlah', 'pjki_pean_lurus_dipakai', 'pjki_pean_lurus_sisa', 'pjki_pean_bengkok_hitungan_pertama', 'pjki_pean_bengkok_tambahan_slma_operasi', 'pjki_pean_bengkok_jumlah', 'pjki_pean_bengkok_dipakai', 'pjki_pean_bengkok_sisa', 'pjki_duk_klem_hitungan_pertama', 'pjki_duk_klem_tambahan_slma_operasi', 'pjki_duk_klem_jumlah', 'pjki_duk_klem_dipakai', 'pjki_duk_klem_sisa', 'pjki_needle_holder_hitungan_pertama', 'pjki_needle_holder_tambahan_slma_operasi', 'pjki_needle_holder_jumlah', 'pjki_needle_holder_dipakai', 'pjki_needle_holder_sisa', 'pjki_kocher_hitungan_pertama', 'pjki_kocher_tambahan_slma_operasi', 'pjki_kocher_jumlah', 'pjki_kocher_dipakai', 'pjki_kocher_sisa', 'pjki_tambahan_1', 'pjki_tambahan_1_hitungan_pertama', 'pjki_tambahan_1_tambahan_slma_operasi', 'pjki_tambahan_1_jumlah', 'pjki_tambahan_1_dipakai', 'pjki_tambahan_1_sisa', 'pjki_tambahan_2', 'pjki_tambahan_2_hitungan_pertama', 'pjki_tambahan_2_tambahan_slma_operasi', 'pjki_tambahan_2_jumlah', 'pjki_tambahan_2_dipakai', 'pjki_tambahan_2_sisa', 'pjki_needle_atrumatic_hitungan_pertama', 'pjki_needle_atrumatic_tambahan_slma_operasi', 'pjki_needle_atrumatic_jumlah', 'pjki_needle_atrumatic_dipakai', 'pjki_needle_atrumatic_sisa', 'pjki_kassa_hitungan_pertama', 'pjki_kassa_tambahan_slma_operasi', 'pjki_kassa_jumlah', 'pjki_kassa_dipakai', 'pjki_kassa_sisa', 'pjki_roll_kassa_hitungan_pertama', 'pjki_roll_kassa_tambahan_slma_operasi', 'pjki_roll_kassa_jumlah', 'pjki_roll_kassa_dipakai', 'pjki_roll_kassa_sisa', 'pjki_depper_hitungan_pertama', 'pjki_depper_tambahan_slma_operasi', 'pjki_depper_jumlah', 'pjki_depper_dipakai', 'pjki_depper_sisa', 'pjki_kacang_hitungan_pertama', 'pjki_kacang_tambahan_slma_operasi', 'pjki_kacang_jumlah', 'pjki_kacang_dipakai', 'pjki_kacang_sisa', 'pjki_lidi_waten_hitungan_pertama', 'pjki_lidi_waten_tambahan_slma_operasi', 'pjki_lidi_waten_jumlah', 'pjki_lidi_waten_dipakai', 'pjki_lidi_waten_sisa'], 'string'],
      [['pjki_pasien_keluar_kamar_operasi', 'pjki_tgl_final', 'pjki_tgl_batal', 'pjki_created_at', 'pjki_updated_at', 'pjki_deleted_at'], 'safe'],
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function attributeLabels()
  {
    return [
      'pjki_id' => 'Pjki ID',
      'pjki_to_id' => 'Pjki To ID',
      'pjki_pasien_keluar_kamar_operasi' => 'Pasien Keluar Kamar Operasi',
      'pjki_tangkai_pisau_hitungan_pertama' => 'Pjki Tangkai Pisau Hitungan Pertama',
      'pjki_tangkai_pisau_tambahan_slma_operasi' => 'Pjki Tangkai Pisau Tambahan Slma Operasi',
      'pjki_tangkai_pisau_jumlah' => 'Pjki Tangkai Pisau Jumlah',
      'pjki_tangkai_pisau_dipakai' => 'Pjki Tangkai Pisau Dipakai',
      'pjki_tangkai_pisau_sisa' => 'Pjki Tangkai Pisau Sisa',
      'pjki_pinset_anatomis_hitungan_pertama' => 'Pjki Pinset Anatomis Hitungan Pertama',
      'pjki_pinset_anatomis_tambahan_slma_operasi' => 'Pjki Pinset Anatomis Tambahan Slma Operasi',
      'pjki_pinset_anatomis_jumlah' => 'Pjki Pinset Anatomis Jumlah',
      'pjki_pinset_anatomis_dipakai' => 'Pjki Pinset Anatomis Dipakai',
      'pjki_pinset_anatomis_sisa' => 'Pjki Pinset Anatomis Sisa',
      'pjki_pinset_chrirurgis_hitungan_pertama' => 'Pjki Pinset Chrirurgis Hitungan Pertama',
      'pjki_pinset_chrirurgis_tambahan_slma_operasi' => 'Pjki Pinset Chrirurgis Tambahan Slma Operasi',
      'pjki_pinset_chrirurgis_jumlah' => 'Pjki Pinset Chrirurgis Jumlah',
      'pjki_pinset_chrirurgis_dipakai' => 'Pjki Pinset Chrirurgis Dipakai',
      'pjki_pinset_chrirurgis_sisa' => 'Pjki Pinset Chrirurgis Sisa',
      'pjki_gunting_benang_hitungan_pertama' => 'Pjki Gunting Benang Hitungan Pertama',
      'pjki_gunting_benang_tambahan_slma_operasi' => 'Pjki Gunting Benang Tambahan Slma Operasi',
      'pjki_gunting_benang_jumlah' => 'Pjki Gunting Benang Jumlah',
      'pjki_gunting_benang_dipakai' => 'Pjki Gunting Benang Dipakai',
      'pjki_gunting_benang_sisa' => 'Pjki Gunting Benang Sisa',
      'pjki_gunting_jaringan_hitungan_pertama' => 'Pjki Gunting Jaringan Hitungan Pertama',
      'pjki_gunting_jaringan_tambahan_slma_operasi' => 'Pjki Gunting Jaringan Tambahan Slma Operasi',
      'pjki_gunting_jaringan_jumlah' => 'Pjki Gunting Jaringan Jumlah',
      'pjki_gunting_jaringan_dipakai' => 'Pjki Gunting Jaringan Dipakai',
      'pjki_gunting_jaringan_sisa' => 'Pjki Gunting Jaringan Sisa',
      'pjki_mosquito_pean_hitungan_pertama' => 'Pjki Mosquito Pean Hitungan Pertama',
      'pjki_mosquito_pean_tambahan_slma_operasi' => 'Pjki Mosquito Pean Tambahan Slma Operasi',
      'pjki_mosquito_pean_jumlah' => 'Pjki Mosquito Pean Jumlah',
      'pjki_mosquito_pean_dipakai' => 'Pjki Mosquito Pean Dipakai',
      'pjki_mosquito_pean_sisa' => 'Pjki Mosquito Pean Sisa',
      'pjki_pean_lurus_hitungan_pertama' => 'Pjki Pean Lurus Hitungan Pertama',
      'pjki_pean_lurus_tambahan_slma_operasi' => 'Pjki Pean Lurus Tambahan Slma Operasi',
      'pjki_pean_lurus_jumlah' => 'Pjki Pean Lurus Jumlah',
      'pjki_pean_lurus_dipakai' => 'Pjki Pean Lurus Dipakai',
      'pjki_pean_lurus_sisa' => 'Pjki Pean Lurus Sisa',
      'pjki_pean_bengkok_hitungan_pertama' => 'Pjki Pean Bengkok Hitungan Pertama',
      'pjki_pean_bengkok_tambahan_slma_operasi' => 'Pjki Pean Bengkok Tambahan Slma Operasi',
      'pjki_pean_bengkok_jumlah' => 'Pjki Pean Bengkok Jumlah',
      'pjki_pean_bengkok_dipakai' => 'Pjki Pean Bengkok Dipakai',
      'pjki_pean_bengkok_sisa' => 'Pjki Pean Bengkok Sisa',
      'pjki_duk_klem_hitungan_pertama' => 'Pjki Duk Klem Hitungan Pertama',
      'pjki_duk_klem_tambahan_slma_operasi' => 'Pjki Duk Klem Tambahan Slma Operasi',
      'pjki_duk_klem_jumlah' => 'Pjki Duk Klem Jumlah',
      'pjki_duk_klem_dipakai' => 'Pjki Duk Klem Dipakai',
      'pjki_duk_klem_sisa' => 'Pjki Duk Klem Sisa',
      'pjki_needle_holder_hitungan_pertama' => 'Pjki Needle Holder Hitungan Pertama',
      'pjki_needle_holder_tambahan_slma_operasi' => 'Pjki Needle Holder Tambahan Slma Operasi',
      'pjki_needle_holder_jumlah' => 'Pjki Needle Holder Jumlah',
      'pjki_needle_holder_dipakai' => 'Pjki Needle Holder Dipakai',
      'pjki_needle_holder_sisa' => 'Pjki Needle Holder Sisa',
      'pjki_kocher_hitungan_pertama' => 'Pjki Kocher Hitungan Pertama',
      'pjki_kocher_tambahan_slma_operasi' => 'Pjki Kocher Tambahan Slma Operasi',
      'pjki_kocher_jumlah' => 'Pjki Kocher Jumlah',
      'pjki_kocher_dipakai' => 'Pjki Kocher Dipakai',
      'pjki_kocher_sisa' => 'Pjki Kocher Sisa',
      'pjki_needle_atrumatic_hitungan_pertama' => 'Pjki Needle Atrumatic Hitungan Pertama',
      'pjki_needle_atrumatic_tambahan_slma_operasi' => 'Pjki Needle Atrumatic Tambahan Slma Operasi',
      'pjki_needle_atrumatic_jumlah' => 'Pjki Needle Atrumatic Jumlah',
      'pjki_needle_atrumatic_dipakai' => 'Pjki Needle Atrumatic Dipakai',
      'pjki_needle_atrumatic_sisa' => 'Pjki Needle Atrumatic Sisa',
      'pjki_kassa_hitungan_pertama' => 'Pjki Kassa Hitungan Pertama',
      'pjki_kassa_tambahan_slma_operasi' => 'Pjki Kassa Tambahan Slma Operasi',
      'pjki_kassa_jumlah' => 'Pjki Kassa Jumlah',
      'pjki_kassa_dipakai' => 'Pjki Kassa Dipakai',
      'pjki_kassa_sisa' => 'Pjki Kassa Sisa',
      'pjki_roll_kassa_hitungan_pertama' => 'Pjki Roll Kassa Hitungan Pertama',
      'pjki_roll_kassa_tambahan_slma_operasi' => 'Pjki Roll Kassa Tambahan Slma Operasi',
      'pjki_roll_kassa_jumlah' => 'Pjki Roll Kassa Jumlah',
      'pjki_roll_kassa_dipakai' => 'Pjki Roll Kassa Dipakai',
      'pjki_roll_kassa_sisa' => 'Pjki Roll Kassa Sisa',
      'pjki_depper_hitungan_pertama' => 'Pjki Depper Hitungan Pertama',
      'pjki_depper_tambahan_slma_operasi' => 'Pjki Depper Tambahan Slma Operasi',
      'pjki_depper_jumlah' => 'Pjki Depper Jumlah',
      'pjki_depper_dipakai' => 'Pjki Depper Dipakai',
      'pjki_depper_sisa' => 'Pjki Depper Sisa',
      'pjki_kacang_hitungan_pertama' => 'Pjki Kacang Hitungan Pertama',
      'pjki_kacang_tambahan_slma_operasi' => 'Pjki Kacang Tambahan Slma Operasi',
      'pjki_kacang_jumlah' => 'Pjki Kacang Jumlah',
      'pjki_kacang_dipakai' => 'Pjki Kacang Dipakai',
      'pjki_kacang_sisa' => 'Pjki Kacang Sisa',
      'pjki_lidi_waten_hitungan_pertama' => 'Pjki Lidi Waten Hitungan Pertama',
      'pjki_lidi_waten_tambahan_slma_operasi' => 'Pjki Lidi Waten Tambahan Slma Operasi',
      'pjki_lidi_waten_jumlah' => 'Pjki Lidi Waten Jumlah',
      'pjki_lidi_waten_dipakai' => 'Pjki Lidi Waten Dipakai',
      'pjki_lidi_waten_sisa' => 'Pjki Lidi Waten Sisa',
      'pjki_final' => 'Pjki Final',
      'pjki_tgl_final' => 'Pjki Tgl Final',
      'pjki_batal' => 'Pjki Batal',
      'pjki_tgl_batal' => 'Pjki Tgl Batal',
      'pjki_mdcp_id' => 'Pjki Mdcp ID',
      'pjki_created_at' => 'Pjki Created At',
      'pjki_created_by' => 'Pjki Created By',
      'pjki_updated_at' => 'Pjki Updated At',
      'pjki_updated_by' => 'Pjki Updated By',
      'pjki_deleted_at' => 'Pjki Deleted At',
      'pjki_deleted_by' => 'Pjki Deleted By',
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
      $this->pjki_created_by = Akun::user()->id;
      $this->pjki_created_at = date('Y-m-d H:i:s');
    } else {
      $this->pjki_updated_by = Akun::user()->id;
      $this->pjki_updated_at = date('Y-m-d H:i:s');
    }
    return parent::beforeSave($model);
  }
  function setDelete()
  {
    $this->pjki_deleted_at = date('Y-m-d H:i:s');
    $this->pjki_deleted_by = Akun::user()->id;
  }
  function setBatal()
  {
    $this->pjki_batal = 1;
    $this->pjki_tgl_batal = date('Y-m-d H:i:s');
  }
  function setFinal()
  {
    $this->pjki_final = 1;
    $this->pjki_tgl_final = date('Y-m-d H:i:s');
  }
  function getTimoperasi()
  {
    return $this->hasOne(TimOperasi::className(), ['to_id' => 'pjki_to_id']);
  }
}
