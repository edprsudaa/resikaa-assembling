<?php

namespace app\models\bedahsentral;

use app\components\Akun;
use app\models\other\TrimBehavior;
use Yii;

class PraAnestesi extends \yii\db\ActiveRecord
{
  const ass_n = 'Pra Anestesi';
  public static function tableName()
  {
    return 'bedah_sentral.pra_anestesi';
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
      [['ppa_to_id'], 'required'],
      [['ppa_to_id', 'ppa_mdcp_id', 'ppa_final', 'ppa_batal', 'ppa_created_by', 'ppa_updated_by', 'ppa_deleted_by'], 'default', 'value' => null],
      [['ppa_to_id', 'ppa_mdcp_id', 'ppa_final', 'ppa_batal', 'ppa_created_by', 'ppa_updated_by', 'ppa_deleted_by'], 'integer'],
      [['ppa_tanggal_pukul', 'ppa_tgl_final', 'ppa_tgl_batal', 'ppa_created_at', 'ppa_updated_at', 'ppa_deleted_at'], 'safe'],
      [['ppa_jalan_nafas_class1','ppa_jalan_nafas_class2','ppa_jalan_nafas_class3','ppa_jalan_nafas_class4', 'ppa_kesadaran', 'ppa_tekanan_darah', 'ppa_frekuensi_nadi', 'ppa_frekuensi_nafas', 'ppa_bb', 'ppa_riwayat_operasi', 'ppa_riwayat_komplikasi', 'ppa_gigi_normal', 'ppa_gigi_palsu_atas', 'ppa_gigi_palsu_bawah', 'ppa_jalan_nafas', 'ppa_jalan_nafas_skor_malampati', 'ppa_respirasi', 'ppa_cardiovaskuler', 'ppa_sistem_pencernaan', 'ppa_neuromusculoscletal', 'ppa_ginjal', 'ppa_alergi_obat', 'ppa_lain_lain', 'ppa_diagnosis', 'ppa_rencana_tindakan', 'ppa_obat_yang_sedang_konsumsi', 'ppa_pemeriksaan_laboratorium', 'ppa_pemeriksaan_radiologi', 'ppa_pemeriksaan_penunjang', 'ppa_puasa_makan_terakhir_pukul', 'ppa_puasa_minum_terakhir_pukul', 'ppa_risiko_anestesi', 'ppa_rencana_anestesi', 'ppa_premedikasi', 'ppa_intruksi_lain'], 'string'],
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function attributeLabels()
  {
    return [
      'ppa_id' => 'ID',
      'ppa_to_id' => 'To ID',
      'ppa_tanggal_pukul' => 'Tanggal Pukul',
      'ppa_kesadaran' => 'Kesadaran',
      'ppa_tekanan_darah' => 'Tekanan Darah',
      'ppa_frekuensi_nadi' => 'Frekuensi Nadi',
      'ppa_frekuensi_nafas' => 'Frekuensi Nafas',
      'ppa_bb' => 'Bb',
      'ppa_riwayat_operasi' => 'Riwayat Operasi',
      'ppa_riwayat_komplikasi' => 'Riwayat Komplikasi',
      'ppa_gigi_normal' => 'Gigi Normal',
      'ppa_gigi_palsu_atas' => 'Gigi Palsu Atas',
      'ppa_gigi_palsu_bawah' => 'Gigi Palsu Bawah',
      'ppa_jalan_nafas' => 'Jalan Nafas',
      'ppa_jalan_nafas_class1' => 'ppa_jalan_nafas_class1',
      'ppa_jalan_nafas_class2' => 'ppa_jalan_nafas_class2',
      'ppa_jalan_nafas_class3' => 'ppa_jalan_nafas_class3',
      'ppa_jalan_nafas_class4' => 'ppa_jalan_nafas_class4',
      'ppa_jalan_nafas_skor_malampati' => 'Jalan Nafas Skor Malampati',
      'ppa_respirasi' => 'Respirasi',
      'ppa_cardiovaskuler' => 'Cardiovaskuler',
      'ppa_sistem_pencernaan' => 'Sistem Pencernaan',
      'ppa_neuromusculoscletal' => 'Neuromusculoscletal',
      'ppa_ginjal' => 'Ginjal',
      'ppa_alergi_obat' => 'Alergi Obat',
      'ppa_lain_lain' => 'Lain Lain',
      'ppa_diagnosis' => 'Diagnosis',
      'ppa_rencana_tindakan' => 'Rencana Tindakan',
      'ppa_obat_yang_sedang_konsumsi' => 'Obat Yang Sedang Konsumsi',
      'ppa_pemeriksaan_laboratorium' => 'Pemeriksaan Laboratorium',
      'ppa_pemeriksaan_radiologi' => 'Pemeriksaan Radiologi',
      'ppa_pemeriksaan_penunjang' => 'Pemeriksaan Penunjang',
      'ppa_puasa_makan_terakhir_pukul' => 'Puasa Makan Terakhir Pukul',
      'ppa_puasa_minum_terakhir_pukul' => 'Puasa Minum Terakhir Pukul',
      'ppa_risiko_anestesi' => 'Risiko Anestesi',
      'ppa_rencana_anestesi' => 'Rencana Anestesi',
      'ppa_premedikasi' => 'Premedikasi',
      'ppa_intruksi_lain' => 'Intruksi Lain',
      'ppa_mdcp_id' => 'Mdcp ID',
      'ppa_final' => 'Final',
      'ppa_tgl_final' => 'Tgl Final',
      'ppa_batal' => 'Batal',
      'ppa_tgl_batal' => 'Tgl Batal',
      'ppa_created_at' => 'Created At',
      'ppa_created_by' => 'Created By',
      'ppa_updated_at' => 'Updated At',
      'ppa_updated_by' => 'Updated By',
      'ppa_deleted_at' => 'Deleted At',
      'ppa_deleted_by' => 'Deleted By',
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
      $this->ppa_created_by = Akun::user()->id;
      $this->ppa_created_at = date('Y-m-d H:i:s');
    } else {
      $this->ppa_updated_by = Akun::user()->id;
      $this->ppa_updated_at = date('Y-m-d H:i:s');
    }
    return parent::beforeSave($model);
  }
  function setDelete()
  {
    $this->ppa_deleted_at = date('Y-m-d H:i:s');
    $this->ppa_deleted_by = Akun::user()->id;
  }
  function setBatal()
  {
    $this->ppa_batal = 1;
    $this->ppa_tgl_batal = date('Y-m-d H:i:s');
  }
  function setFinal()
  {
    $this->ppa_final = 1;
    $this->ppa_tgl_final = date('Y-m-d H:i:s');
  }
  function getTimoperasi()
  {
    return $this->hasOne(TimOperasi::className(), ['to_id' => 'ppa_to_id']);
  }
}
