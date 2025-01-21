<?php

namespace app\models\bedahsentral;

use app\components\Akun;
use app\models\other\TrimBehavior;
use app\models\pegawai\TbPegawai;
use Yii;

/**
 * This is the model class for table "inform_concent_tindakan_dokter".
 *
 * @property int $incon_id
 * @property int $incon_to_id
 * @property int $incon_dokter_pgw_id
 * @property int|null $incon_pemberi_informasi_pgw_id
 * @property int|null $incon_saksi_pgw_id
 * @property string|null $incon_tindakan_inform_consent
 * @property string|null $incon_informasi_diagnosis
 * @property string|null $incon_informasi_dasar_diagnosis
 * @property string|null $incon_informasi_tindakan_operasi
 * @property string|null $incon_informasi_tindakan_pembiusan
 * @property string|null $incon_informasi_indikasi_tindakan
 * @property string|null $incon_informasi_tata_cara
 * @property string|null $incon_informasi_tujuan
 * @property string|null $incon_informasi_resiko
 * @property string|null $incon_informasi_komplikasi
 * @property string|null $incon_informasi_prognosis
 * @property string|null $incon_informasi_alternatif_dan_resiko
 * @property string|null $incon_informasi_pemberian_analgetik_pasca_anestesi
 * @property string|null $incon_penerima_informasi
 * @property string|null $incon_hubungan_keluarga
 * @property string|null $incon_keluarga_nama
 * @property string|null $incon_keluarga_umur
 * @property string|null $incon_keluarga_jenis_kelamin
 * @property string|null $incon_keluarga_alamat
 * @property string|null $incon_keluarga_saksi
 * @property string|null $incon_pasien_nama
 * @property string|null $incon_pasien_tanggal_lahir
 * @property string|null $incon_pasien_jenis_kelamin
 * @property string|null $incon_pasien_alamat
 * @property int|null $incon_setuju
 * @property int|null $incon_final
 * @property string|null $incon_tgl_final
 * @property int|null $incon_batal
 * @property string|null $incon_tgl_batal
 * @property int|null $incon_mdcp_id
 * @property string|null $incon_created_at
 * @property int|null $incon_created_by
 * @property string|null $incon_updated_at
 * @property int|null $incon_updated_by
 * @property string|null $incon_deleted_at
 * @property int|null $incon_deleted_by
 */
class InformConcentTindakanDokter extends \yii\db\ActiveRecord
{
  const prefix = 'incon';
  const alias = 'incon';
  const title = 'Inform Consent Kedokteran';
  /**
   * {@inheritdoc}
   */
  public static function tableName()
  {
    return 'inform_concent_tindakan_dokter';
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
      [['incon_to_id', 'incon_dokter_pgw_id'], 'required'],
      [['incon_to_id', 'incon_dokter_pgw_id', 'incon_pemberi_informasi_pgw_id', 'incon_saksi_pgw_id', 'incon_setuju', 'incon_final', 'incon_batal', 'incon_mdcp_id', 'incon_created_by', 'incon_updated_by', 'incon_deleted_by'], 'default', 'value' => null],
      [['incon_to_id', 'incon_dokter_pgw_id', 'incon_pemberi_informasi_pgw_id', 'incon_saksi_pgw_id', 'incon_setuju', 'incon_final', 'incon_batal', 'incon_mdcp_id', 'incon_created_by', 'incon_updated_by', 'incon_deleted_by'], 'integer'],
      [['incon_tindakan_inform_consent', 'incon_informasi_diagnosis', 'incon_informasi_dasar_diagnosis', 'incon_informasi_tindakan_operasi', 'incon_informasi_tindakan_pembiusan', 'incon_informasi_indikasi_tindakan', 'incon_informasi_tata_cara', 'incon_informasi_tujuan', 'incon_informasi_resiko', 'incon_informasi_komplikasi', 'incon_informasi_prognosis', 'incon_informasi_alternatif_dan_resiko', 'incon_informasi_pemberian_analgetik_pasca_anestesi', 'incon_penerima_informasi', 'incon_hubungan_keluarga', 'incon_keluarga_nama', 'incon_keluarga_umur', 'incon_keluarga_jenis_kelamin', 'incon_keluarga_alamat', 'incon_keluarga_saksi', 'incon_pasien_nama', 'incon_pasien_jenis_kelamin', 'incon_pasien_alamat'], 'string'],
      [['incon_pasien_tanggal_lahir', 'incon_tgl_final', 'incon_tgl_batal', 'incon_created_at', 'incon_updated_at', 'incon_deleted_at'], 'safe'],
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function attributeLabels()
  {
    return [
      'incon_id' => 'Incon ID',
      'incon_to_id' => 'Incon To ID',
      'incon_dokter_pgw_id' => 'Incon Dokter Pgw ID',
      'incon_pemberi_informasi_pgw_id' => 'Incon Pemberi Informasi Pgw ID',
      'incon_saksi_pgw_id' => 'Incon Saksi Pgw ID',
      'incon_tindakan_inform_consent' => 'Incon Tindakan Inform Consent',
      'incon_informasi_diagnosis' => 'Incon Informasi Diagnosis',
      'incon_informasi_dasar_diagnosis' => 'Incon Informasi Dasar Diagnosis',
      'incon_informasi_tindakan_operasi' => 'Incon Informasi Tindakan Operasi',
      'incon_informasi_tindakan_pembiusan' => 'Incon Informasi Tindakan Pembiusan',
      'incon_informasi_indikasi_tindakan' => 'Incon Informasi Indikasi Tindakan',
      'incon_informasi_tata_cara' => 'Incon Informasi Tata Cara',
      'incon_informasi_tujuan' => 'Incon Informasi Tujuan',
      'incon_informasi_resiko' => 'Incon Informasi Resiko',
      'incon_informasi_komplikasi' => 'Incon Informasi Komplikasi',
      'incon_informasi_prognosis' => 'Incon Informasi Prognosis',
      'incon_informasi_alternatif_dan_resiko' => 'Incon Informasi Alternatif Dan Resiko',
      'incon_informasi_pemberian_analgetik_pasca_anestesi' => 'Incon Informasi Pemberian Analgetik Pasca Anestesi',
      'incon_penerima_informasi' => 'Incon Penerima Informasi',
      'incon_hubungan_keluarga' => 'Incon Hubungan Keluarga',
      'incon_keluarga_nama' => 'Incon Keluarga Nama',
      'incon_keluarga_umur' => 'Incon Keluarga Umur',
      'incon_keluarga_jenis_kelamin' => 'Incon Keluarga Jenis Kelamin',
      'incon_keluarga_alamat' => 'Incon Keluarga Alamat',
      'incon_keluarga_saksi' => 'Incon Keluarga Saksi',
      'incon_pasien_nama' => 'Incon Pasien Nama',
      'incon_pasien_tanggal_lahir' => 'Incon Pasien Tanggal Lahir',
      'incon_pasien_jenis_kelamin' => 'Incon Pasien Jenis Kelamin',
      'incon_pasien_alamat' => 'Incon Pasien Alamat',
      'incon_setuju' => 'Incon Setuju',
      'incon_final' => 'Incon Final',
      'incon_tgl_final' => 'Incon Tgl Final',
      'incon_batal' => 'Incon Batal',
      'incon_tgl_batal' => 'Incon Tgl Batal',
      'incon_mdcp_id' => 'Incon Mdcp ID',
      'incon_created_at' => 'Incon Created At',
      'incon_created_by' => 'Incon Created By',
      'incon_updated_at' => 'Incon Updated At',
      'incon_updated_by' => 'Incon Updated By',
      'incon_deleted_at' => 'Incon Deleted At',
      'incon_deleted_by' => 'Incon Deleted By',
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
      $this->incon_created_by = Akun::user()->id;
      $this->incon_created_at = date('Y-m-d H:i:s');
    } else {
      $this->incon_updated_by = Akun::user()->id;
      $this->incon_updated_at = date('Y-m-d H:i:s');
    }
    return parent::beforeSave($model);
  }
  function setDelete()
  {
    $this->incon_deleted_at = date('Y-m-d H:i:s');
    $this->incon_deleted_by = Akun::user()->id;
  }
  function setBatal()
  {
    $this->incon_batal = 1;
    $this->incon_tgl_batal = date('Y-m-d H:i:s');
  }
  function setFinal()
  {
    $this->incon_final = 1;
    $this->incon_tgl_final = date('Y-m-d H:i:s');
  }
  function getTimoperasi()
  {
    return $this->hasOne(TimOperasi::className(), ['to_id' => 'incon_to_id']);
  }
  function getDokter()
  {
    return $this->hasOne(TbPegawai::className(), ['pegawai_id' => 'incon_dokter_pgw_id']);
  }
  function getPerawat()
  {
    return $this->hasOne(TbPegawai::className(), ['pegawai_id' => 'incon_saksi_pgw_id']);
  }
}
