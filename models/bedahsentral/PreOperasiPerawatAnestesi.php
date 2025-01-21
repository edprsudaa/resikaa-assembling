<?php

namespace app\models\bedahsentral;

use Yii;
use app\models\other\TrimBehavior;
use app\components\Akun;
use app\models\bedahsentral\TimOperasi;
use app\models\pegawai\TbPegawai;

class PreOperasiPerawatAnestesi extends \yii\db\ActiveRecord
{
  const ass_pop = 'Pre Operasi';

  public static function tableName()
  {
    return 'bedah_sentral.pre_operasi_perawat';
  }

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
      [['pop_to_id'], 'required'],
      [['pop_to_id', 'pop_pl_id', 'pop_pgw_id_ruangan', 'pop_pgw_id_anestesi', 'pop_pgw_id_ok', 'pop_final_ruangan', 'pop_batal', 'pop_mdcp_id_ok', 'pop_created_by', 'pop_updated_by', 'pop_deleted_by', 'pop_final_anestesi', 'pop_final_ok', 'pop_batal_ok', 'pop_batal_anestesi', 'pop_batal_ruangan', 'pop_mdcp_id_ruangan', 'pop_mdcp_id_anestesi'], 'default', 'value' => null],
      [['pop_to_id', 'pop_pl_id', 'pop_pgw_id_ruangan', 'pop_pgw_id_anestesi', 'pop_pgw_id_ok', 'pop_final_ruangan', 'pop_batal', 'pop_mdcp_id_ok', 'pop_created_by', 'pop_updated_by', 'pop_deleted_by', 'pop_final_anestesi', 'pop_final_ok', 'pop_batal_ok', 'pop_batal_anestesi', 'pop_batal_ruangan', 'pop_mdcp_id_ruangan', 'pop_mdcp_id_anestesi'], 'integer'],
      [['pop_tingkat_kesadaran', 'pop_e', 'pop_m', 'pop_v', 'pop_total_gcs', 'pop_pernapasan', 'pop_riwayat_operasi', 'pop_jenis_operasi', 'pop_rumah_sakit', 'pop_tahun', 'pop_status_emosional', 'pop_berat_badan', 'pop_tinggi_badan', 'pop_sio_ruangan', 'pop_sio_ruangan_ket', 'pop_sio_ok', 'pop_sio_ok_ket', 'pop_sio_anestesi', 'pop_sio_anestesi_ket', 'pop_puasa_ruangan', 'pop_puasa_ruangan_ket', 'pop_puasa_ok', 'pop_puasa_ok_ket', 'pop_puasa_anestesi', 'pop_puasa_anestesi_ket', 'pop_protesa_ruangan', 'pop_protesa_ruangan_ket', 'pop_protesa_ok', 'pop_protesa_ok_ket', 'pop_protesa_anestesi', 'pop_protesa_anestesi_ket', 'pop_perhiasan_ruangan', 'pop_perhiasan_ruangan_ket', 'pop_perhiasan_ok', 'pop_perhiasan_ok_ket', 'pop_perhiasan_anestesi', 'pop_perhiasan_anestesi_ket', 'pop_pdo_ruangan', 'pop_pdo_ruangan_ket', 'pop_pdo_ok', 'pop_pdo_ok_ket', 'pop_pdo_anestesi', 'pop_pdo_anestesi_ket', 'pop_plo_ruangan', 'pop_plo_ruangan_ket', 'pop_plo_ok', 'pop_plo_ok_ket', 'pop_plo_anestesi', 'pop_plo_anestesi_ket', 'pop_huknah_ruangan', 'pop_huknah_ruangan_ket', 'pop_huknah_ok', 'pop_huknah_ok_ket', 'pop_huknah_anestesi', 'pop_huknah_anestesi_ket', 'pop_fkateter_ruangan', 'pop_fkateter_ruangan_ket', 'pop_fkateter_ok', 'pop_fkateter_ok_ket', 'pop_fkateter_anestesi', 'pop_fkateter_anestesi_ket', 'pop_h_lab_ruangan', 'pop_h_lab_ruangan_ket', 'pop_h_lab_ok', 'pop_h_lab_ok_ket', 'pop_h_lab_anestesi', 'pop_h_lab_anestesi_ket', 'pop_rontgen_ruangan', 'pop_rontgen_ruangan_ket', 'pop_rontgen_ok', 'pop_rontgen_ok_ket', 'pop_rontgen_anestesi', 'pop_rontgen_anestesi_ket', 'pop_usg_ruangan', 'pop_usg_ruangan_ket', 'pop_usg_ok', 'pop_usg_ok_ket', 'pop_usg_anestesi', 'pop_usg_anestesi_ket', 'pop_ctscan_ruangan', 'pop_ctscan_ruangan_ket', 'pop_ctscan_ok', 'pop_ctscan_ok_ket', 'pop_ctscan_anestesi', 'pop_ctscan_anestesi_ket', 'pop_ekg_ruangan', 'pop_ekg_ruangan_ket', 'pop_ekg_ok', 'pop_ekg_ok_ket', 'pop_ekg_anestesi', 'pop_ekg_anestesi_ket', 'pop_echo_ruangan', 'pop_echo_ruangan_ket', 'pop_echo_ok', 'pop_echo_ok_ket', 'pop_echo_anestesi', 'pop_echo_anestesi_ket', 'pop_persediaan_darah_ruangan', 'pop_persediaan_darah_ruangan_ket', 'pop_persediaan_darah_ok', 'pop_persediaan_darah_ok_ket', 'pop_persediaan_darah_anestesi', 'pop_persediaan_darah_anestesi_ket', 'pop_ivline_ruangan', 'pop_ivline_ruangan_ket', 'pop_ivline_ok', 'pop_ivline_ok_ket', 'pop_ivline_anestesi', 'pop_ivline_anestesi_ket', 'pop_propilaksis_ruangan', 'pop_propilaksis_ruangan_ket', 'pop_propilaksis_ok', 'pop_propilaksis_ok_ket', 'pop_propilaksis_anestesi', 'pop_propilaksis_anestesi_ket', 'pop_alergi_obat_ruangan', 'pop_alergi_obat_ruangan_ket', 'pop_alergi_obat_ok', 'pop_alergi_obat_ok_ket', 'pop_alergi_obat_anestesi', 'pop_alergi_obat_anestesi_ket', 'pop_tkn_darah_ruangan', 'pop_tkn_darah_ruangan_ket', 'pop_tkn_darah_ok', 'pop_tkn_darah_ok_ket', 'pop_tkn_darah_anestesi', 'pop_tkn_darah_anestesi_ket', 'pop_nadi_ruangan', 'pop_nadi_ruangan_ket', 'pop_nadi_ok', 'pop_nadi_ok_ket', 'pop_nadi_anestesi', 'pop_nadi_anestesi_ket', 'pop_suhu_ruangan', 'pop_suhu_ruangan_ket', 'pop_suhu_ok', 'pop_suhu_ok_ket', 'pop_suhu_anestesi', 'pop_suhu_anestesi_ket', 'pop_pernapasan_ruangan', 'pop_pernapasan_ruangan_ket', 'pop_pernapasan_ok', 'pop_pernapasan_ok_ket', 'pop_pernapasan_anestesi', 'pop_pernapasan_anestesi_ket', 'pop_pendidikan', 'pop_obatan', 'pop_integritas_kulit', 'pop_tulang', 'pop_masalah', 'pop_tindakan', 'pop_implementasi', 'pop_evaluasi'], 'string'],
      [['pop_tgl_final', 'pop_tgl_batal', 'pop_created_at', 'pop_updated_at', 'pop_deleted_at'], 'safe'],
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function attributeLabels()
  {
    return [
      'pop_id' => 'ID',
      'pop_to_id' => 'To ID',
      'pop_pl_id' => 'Pl ID',
      'pop_pgw_id_ruangan' => 'Pgw Id Ruangan',
      'pop_pgw_id_anestesi' => 'Pgw Id Anestesi',
      'pop_pgw_id_ok' => 'Pgw Id Ok',
      'pop_tingkat_kesadaran' => 'Tingkat Kesadaran',
      'pop_e' => 'GCS (E)',
      'pop_m' => 'GCS (M)',
      'pop_v' => 'GCS (V)',
      'pop_total_gcs' => 'Total GCS',
      'pop_pernapasan' => 'Pernapasan',
      'pop_riwayat_operasi' => 'Riwayat Operasi',
      'pop_jenis_operasi' => 'Jenis Operasi',
      'pop_rumah_sakit' => 'Rumah Sakit',
      'pop_tahun' => 'Tahun',
      'pop_status_emosional' => 'Status Emosional',
      'pop_berat_badan' => 'Berat Badan',
      'pop_tinggi_badan' => 'Tinggi Badan',
      'pop_sio_ruangan' => 'Sio Ruangan',
      'pop_sio_ruangan_ket' => 'Sio Ruangan Ket',
      'pop_sio_ok' => 'Sio Ok',
      'pop_sio_ok_ket' => 'Sio Ok Ket',
      'pop_sio_anestesi' => 'Sio Anestesi',
      'pop_sio_anestesi_ket' => 'Sio Anestesi Ket',
      'pop_puasa_ruangan' => 'Puasa Ruangan',
      'pop_puasa_ruangan_ket' => 'Puasa Ruangan Ket',
      'pop_puasa_ok' => 'Puasa Ok',
      'pop_puasa_ok_ket' => 'Puasa Ok Ket',
      'pop_puasa_anestesi' => 'Puasa Anestesi',
      'pop_puasa_anestesi_ket' => 'Puasa Anestesi Ket',
      'pop_protesa_ruangan' => 'Protesa Ruangan',
      'pop_protesa_ruangan_ket' => 'Protesa Ruangan Ket',
      'pop_protesa_ok' => 'Protesa Ok',
      'pop_protesa_ok_ket' => 'Protesa Ok Ket',
      'pop_protesa_anestesi' => 'Protesa Anestesi',
      'pop_protesa_anestesi_ket' => 'Protesa Anestesi Ket',
      'pop_perhiasan_ruangan' => 'Perhiasan Ruangan',
      'pop_perhiasan_ruangan_ket' => 'Perhiasan Ruangan Ket',
      'pop_perhiasan_ok' => 'Perhiasan Ok',
      'pop_perhiasan_ok_ket' => 'Perhiasan Ok Ket',
      'pop_perhiasan_anestesi' => 'Perhiasan Anestesi',
      'pop_perhiasan_anestesi_ket' => 'Perhiasan Anestesi Ket',
      'pop_pdo_ruangan' => 'Pdo Ruangan',
      'pop_pdo_ruangan_ket' => 'Pdo Ruangan Ket',
      'pop_pdo_ok' => 'Pdo Ok',
      'pop_pdo_ok_ket' => 'Pdo Ok Ket',
      'pop_pdo_anestesi' => 'Pdo Anestesi',
      'pop_pdo_anestesi_ket' => 'Pdo Anestesi Ket',
      'pop_plo_ruangan' => 'Plo Ruangan',
      'pop_plo_ruangan_ket' => 'Plo Ruangan Ket',
      'pop_plo_ok' => 'Plo Ok',
      'pop_plo_ok_ket' => 'Plo Ok Ket',
      'pop_plo_anestesi' => 'Plo Anestesi',
      'pop_plo_anestesi_ket' => 'Plo Anestesi Ket',
      'pop_huknah_ruangan' => 'Huknah Ruangan',
      'pop_huknah_ruangan_ket' => 'Huknah Ruangan Ket',
      'pop_huknah_ok' => 'Huknah Ok',
      'pop_huknah_ok_ket' => 'Huknah Ok Ket',
      'pop_huknah_anestesi' => 'Huknah Anestesi',
      'pop_huknah_anestesi_ket' => 'Huknah Anestesi Ket',
      'pop_fkateter_ruangan' => 'Fkateter Ruangan',
      'pop_fkateter_ruangan_ket' => 'Fkateter Ruangan Ket',
      'pop_fkateter_ok' => 'Fkateter Ok',
      'pop_fkateter_ok_ket' => 'Fkateter Ok Ket',
      'pop_fkateter_anestesi' => 'Fkateter Anestesi',
      'pop_fkateter_anestesi_ket' => 'Fkateter Anestesi Ket',
      'pop_h_lab_ruangan' => 'H Lab Ruangan',
      'pop_h_lab_ruangan_ket' => 'H Lab Ruangan Ket',
      'pop_h_lab_ok' => 'H Lab Ok',
      'pop_h_lab_ok_ket' => 'H Lab Ok Ket',
      'pop_h_lab_anestesi' => 'H Lab Anestesi',
      'pop_h_lab_anestesi_ket' => 'H Lab Anestesi Ket',
      'pop_rontgen_ruangan' => 'Rontgen Ruangan',
      'pop_rontgen_ruangan_ket' => 'Rontgen Ruangan Ket',
      'pop_rontgen_ok' => 'Rontgen Ok',
      'pop_rontgen_ok_ket' => 'Rontgen Ok Ket',
      'pop_rontgen_anestesi' => 'Rontgen Anestesi',
      'pop_rontgen_anestesi_ket' => 'Rontgen Anestesi Ket',
      'pop_usg_ruangan' => 'Usg Ruangan',
      'pop_usg_ruangan_ket' => 'Usg Ruangan Ket',
      'pop_usg_ok' => 'Usg Ok',
      'pop_usg_ok_ket' => 'Usg Ok Ket',
      'pop_usg_anestesi' => 'Usg Anestesi',
      'pop_usg_anestesi_ket' => 'Usg Anestesi Ket',
      'pop_ctscan_ruangan' => 'Ctscan Ruangan',
      'pop_ctscan_ruangan_ket' => 'Ctscan Ruangan Ket',
      'pop_ctscan_ok' => 'Ctscan Ok',
      'pop_ctscan_ok_ket' => 'Ctscan Ok Ket',
      'pop_ctscan_anestesi' => 'Ctscan Anestesi',
      'pop_ctscan_anestesi_ket' => 'Ctscan Anestesi Ket',
      'pop_ekg_ruangan' => 'Ekg Ruangan',
      'pop_ekg_ruangan_ket' => 'Ekg Ruangan Ket',
      'pop_ekg_ok' => 'Ekg Ok',
      'pop_ekg_ok_ket' => 'Ekg Ok Ket',
      'pop_ekg_anestesi' => 'Ekg Anestesi',
      'pop_ekg_anestesi_ket' => 'Ekg Anestesi Ket',
      'pop_echo_ruangan' => 'Echo Ruangan',
      'pop_echo_ruangan_ket' => 'Echo Ruangan Ket',
      'pop_echo_ok' => 'Echo Ok',
      'pop_echo_ok_ket' => 'Echo Ok Ket',
      'pop_echo_anestesi' => 'Echo Anestesi',
      'pop_echo_anestesi_ket' => 'Echo Anestesi Ket',
      'pop_persediaan_darah_ruangan' => 'Persediaan Darah Ruangan',
      'pop_persediaan_darah_ruangan_ket' => 'Persediaan Darah Ruangan Ket',
      'pop_persediaan_darah_ok' => 'Persediaan Darah Ok',
      'pop_persediaan_darah_ok_ket' => 'Persediaan Darah Ok Ket',
      'pop_persediaan_darah_anestesi' => 'Persediaan Darah Anestesi',
      'pop_persediaan_darah_anestesi_ket' => 'Persediaan Darah Anestesi Ket',
      'pop_ivline_ruangan' => 'Ivline Ruangan',
      'pop_ivline_ruangan_ket' => 'Ivline Ruangan Ket',
      'pop_ivline_ok' => 'Ivline Ok',
      'pop_ivline_ok_ket' => 'Ivline Ok Ket',
      'pop_ivline_anestesi' => 'Ivline Anestesi',
      'pop_ivline_anestesi_ket' => 'Ivline Anestesi Ket',
      'pop_propilaksis_ruangan' => 'Propilaksis Ruangan',
      'pop_propilaksis_ruangan_ket' => 'Propilaksis Ruangan Ket',
      'pop_propilaksis_ok' => 'Propilaksis Ok',
      'pop_propilaksis_ok_ket' => 'Propilaksis Ok Ket',
      'pop_propilaksis_anestesi' => 'Propilaksis Anestesi',
      'pop_propilaksis_anestesi_ket' => 'Propilaksis Anestesi Ket',
      'pop_alergi_obat_ruangan' => 'Alergi Obat Ruangan',
      'pop_alergi_obat_ruangan_ket' => 'Alergi Obat Ruangan Ket',
      'pop_alergi_obat_ok' => 'Alergi Obat Ok',
      'pop_alergi_obat_ok_ket' => 'Alergi Obat Ok Ket',
      'pop_alergi_obat_anestesi' => 'Alergi Obat Anestesi',
      'pop_alergi_obat_anestesi_ket' => 'Alergi Obat Anestesi Ket',
      'pop_tkn_darah_ruangan' => 'Tkn Darah Ruangan',
      'pop_tkn_darah_ruangan_ket' => 'Tkn Darah Ruangan Ket',
      'pop_tkn_darah_ok' => 'Tkn Darah Ok',
      'pop_tkn_darah_ok_ket' => 'Tkn Darah Ok Ket',
      'pop_tkn_darah_anestesi' => 'Tkn Darah Anestesi',
      'pop_tkn_darah_anestesi_ket' => 'Tkn Darah Anestesi Ket',
      'pop_nadi_ruangan' => 'Nadi Ruangan',
      'pop_nadi_ruangan_ket' => 'Nadi Ruangan Ket',
      'pop_nadi_ok' => 'Nadi Ok',
      'pop_nadi_ok_ket' => 'Nadi Ok Ket',
      'pop_nadi_anestesi' => 'Nadi Anestesi',
      'pop_nadi_anestesi_ket' => 'Nadi Anestesi Ket',
      'pop_suhu_ruangan' => 'Suhu Ruangan',
      'pop_suhu_ruangan_ket' => 'Suhu Ruangan Ket',
      'pop_suhu_ok' => 'Suhu Ok',
      'pop_suhu_ok_ket' => 'Suhu Ok Ket',
      'pop_suhu_anestesi' => 'Suhu Anestesi',
      'pop_suhu_anestesi_ket' => 'Suhu Anestesi Ket',
      'pop_pernapasan_ruangan' => 'Pernapasan Ruangan',
      'pop_pernapasan_ruangan_ket' => 'Pernapasan Ruangan Ket',
      'pop_pernapasan_ok' => 'Pernapasan Ok',
      'pop_pernapasan_ok_ket' => 'Pernapasan Ok Ket',
      'pop_pernapasan_anestesi' => 'Pernapasan Anestesi',
      'pop_pernapasan_anestesi_ket' => 'Pernapasan Anestesi Ket',
      'pop_pendidikan' => 'Pendidikan kesehatan yang telah di berikan',
      'pop_obatan' => 'Obat-obatan/Alkes',
      'pop_integritas_kulit' => 'Integritas Kulit',
      'pop_tulang' => 'Tulang',
      'pop_masalah' => 'MASALAH KEPERAWATAN',
      'pop_tindakan' => 'INTERVENSI/IMPLEMENTASI',
      'pop_implementasi' => 'INTERVENSI/IMPLEMENTASI',
      'pop_evaluasi' => 'EVALUASI',
      'pop_final_ruangan' => 'Final Ruangan',
      'pop_final_ok' => 'Final Ok',
      'pop_final_anestesi' => 'Final Anestesi',
      'pop_batal_ok' => 'Batal Ok',
      'pop_batal_ruangan' => 'Batal Ruangan',
      'pop_batal_anestesi' => 'Batal Anestesi',
      'pop_tgl_final' => 'Tgl Final',
      'pop_batal' => 'Batal',
      'pop_tgl_batal' => 'Tgl Batal',
      'pop_mdcp_id_ok' => 'Mdcp Id Ok',
      'pop_mdcp_id_ruangan' => 'Mdcp Id Ruangan',
      'pop_mdcp_id_anestesi' => 'Mdcp Id Anestesi',
      'pop_created_at' => 'Created At',
      'pop_created_by' => 'Created By',
      'pop_updated_at' => 'Updated At',
      'pop_updated_by' => 'Updated By',
      'pop_deleted_at' => 'Deleted At',
      'pop_deleted_by' => 'Deleted By',
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
      $this->pop_created_by = Akun::user()->id;
      $this->pop_created_at = date('Y-m-d H:i:s');
    } else {
      $this->pop_updated_by = Akun::user()->id;
      $this->pop_updated_at = date('Y-m-d H:i:s');
    }
    return parent::beforeSave($model);
  }
  function setDelete()
  {
    $this->pop_deleted_at = date('Y-m-d H:i:s');
    $this->pop_deleted_by = Akun::user()->id;
  }
  function setBatal()
  {
    $this->pop_batal_anestesi = 1;
    $this->pop_tgl_batal = date('Y-m-d H:i:s');
  }
  function setFinal()
  {
    $this->pop_final_anestesi = 1;
    $this->pop_tgl_final = date('Y-m-d H:i:s');
  }
  function getTimoperasi()
  {
    return $this->hasOne(TimOperasi::className(), ['to_id' => 'pop_to_id']);
  }
  function getPerawat()
  {
    return $this->hasOne(TbPegawai::className(), ['pegawai_id' => 'pop_pgw_id_anestesi']);
  }
}
