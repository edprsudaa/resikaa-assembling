<?php

namespace app\models\bedahsentral;

use app\components\Akun;
use app\models\other\TrimBehavior;
use app\models\pegawai\TbPegawai;
use Yii;

class IntraAnestesi extends \yii\db\ActiveRecord
{
  const ass_n = 'Intra Anestesi';
  /**
   * {@inheritdoc}
   */
  public static function tableName()
  {
    return 'bedah_sentral.intra_anestesi';
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
      [['mia_to_id', 'mia_pra_anestesi_mia_id', 'mia_penata_anestesi_pgw_id', 'mia_dokter_anestesi_pgw_id', 'mia_preinduksi_api_id', 'mia_iso_flurane', 'mia_sevo_flurane', 'mia_oksigen', 'mia_air', 'mia_n20', 'mia_final', 'mia_batal', 'mia_mdcp_id', 'mia_created_by', 'mia_updated_by', 'mia_deleted_by'], 'default', 'value' => null],

      [['mia_to_id', 'mia_pra_anestesi_mia_id', 'mia_penata_anestesi_pgw_id', 'mia_dokter_anestesi_pgw_id', 'mia_preinduksi_api_id', 'mia_iso_flurane', 'mia_sevo_flurane', 'mia_oksigen', 'mia_air', 'mia_n20', 'mia_final', 'mia_batal', 'mia_mdcp_id', 'mia_created_by', 'mia_updated_by', 'mia_deleted_by'], 'integer'],

      [['mia_premedikasi', 'mia_jalan_nafas', 'mia_pengaturan_nafas', 'mia_induksi', 'mia_ventilator_tidal_volume', 'mia_ventilator_rr', 'mia_ventilator_peep', 'mia_teknik_khusus', 'mia_komplikasi_anestesi'], 'string'],

      [['mia_jam', 'mia_posisi_operasi', 'mia_teknik_anestesi', 'mia_jam_mulai_anestesi', 'mia_jam_mulai_operasi', 'mia_jam_berakhir_operasi', 'mia_jam_berakhir_anestesi', 'mia_tgl_final', 'mia_tgl_batal', 'mia_created_at', 'mia_updated_at', 'mia_deleted_at'], 'safe'],
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function attributeLabels()
  {
    return [
      'mia_id' => 'ID',
      'mia_to_id' => 'To ID',
      'mia_pra_anestesi_mia_id' => 'Pra Anestesi ID',
      'mia_penata_anestesi_pgw_id' => 'Penata Anestesi Pgw ID',
      'mia_dokter_anestesi_pgw_id' => 'Dokter Anestesi Pgw ID',
      'mia_preinduksi_api_id' => 'Preinduksi Api ID',
      'mia_premedikasi' => 'Premidikasi',
      'mia_jam' => 'Jam',
      'mia_jam_mulai_anestesi' => 'Jam Mulai Anestesi',
      'mia_jam_mulai_operasi' => 'Jam Mulai Operasi',
      'mia_jam_berakhir_operasi' => 'Jam Berakhir Operasi',
      'mia_jam_berakhir_anestesi' => 'Jam Berakhir Anestesi',
      'mia_posisi_operasi' => 'Posisi Operasi',
      'mia_teknik_anestesi' => 'Tehnik Anestesi',
      'mia_jalan_nafas' => 'Jalan Nafas',
      'mia_pengaturan_nafas' => 'Pernafasan',
      'mia_induksi' => 'Induksi',
      'mia_ventilator_tidal_volume' => 'Ventilator Tidal Volume',
      'mia_ventilator_rr' => 'Ventilator Rr',
      'mia_ventilator_peep' => 'Ventilator Peep',
      'mia_teknik_khusus' => 'Teknik Khusus',
      'mia_iso_flurane' => 'Iso Flurane',
      'mia_sevo_flurane' => 'Sevo Flurane',
      'mia_oksigen' => 'Oksigen',
      'mia_air' => 'Air',
      'mia_n20' => 'N 20',
      'mia_komplikasi_anestesi' => 'Komplikasi Anestesi',
      'mia_final' => 'Final',
      'mia_tgl_final' => 'Tgl Final',
      'mia_batal' => 'Batal',
      'mia_tgl_batal' => 'Tgl Batal',
      'mia_mdcp_id' => 'Mdcp ID',
      'mia_created_at' => 'Created At',
      'mia_created_by' => 'Created By',
      'mia_updated_at' => 'Updated At',
      'mia_updated_by' => 'Updated By',
      'mia_deleted_at' => 'Deleted At',
      'mia_deleted_by' => 'Deleted By',
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
      $this->mia_created_by = Akun::user()->id;
      $this->mia_created_at = date('Y-m-d H:i:s');
    } else {
      $this->mia_updated_by = Akun::user()->id;
      $this->mia_updated_at = date('Y-m-d H:i:s');
    }
    return parent::beforeSave($model);
  }
  function setDelete()
  {
    $this->mia_deleted_at = date('Y-m-d H:i:s');
    $this->mia_deleted_by = Akun::user()->id;
  }
  function setBatal()
  {
    $this->mia_batal = 1;
    $this->mia_tgl_batal = date('Y-m-d H:i:s');
  }
  function setFinal()
  {
    $this->mia_final = 1;
    $this->mia_tgl_final = date('Y-m-d H:i:s');
  }
  function getDokter()
  {
    return $this->hasOne(TbPegawai::className(), ['pegawai_id' => 'mia_dokter_anestesi_pgw_id']);
  }
  function getTimoperasi()
  {
    return $this->hasOne(TimOperasi::className(), ['to_id' => 'mia_to_id']);
  }
  function getTtvintraanestesi()
  {
    return $this->hasOne(TtvIntraAnestesi::className(), ['ttva_intra_operasi_mia_id' => 'mia_id']);
  }
}
