<?php

namespace app\models\bedahsentral;

use app\components\Akun;
use app\models\other\TrimBehavior;
use Yii;

class AsesmenPraInduksi extends \yii\db\ActiveRecord
{
  const ass_n = 'Asesmen Pra Induksi';
  public $api_rencana_tindakan_anestesi2;
  /**
   * {@inheritdoc}
   */
  public static function tableName()
  {
    return 'asesmen_pra_induksi';
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
      [['api_to_id'], 'required'],

      [['api_to_id', 'api_final', 'api_batal', 'api_mdcp_id', 'api_created_by', 'api_updated_by', 'api_deleted_by'], 'default', 'value' => null],

      [['api_to_id', 'api_final', 'api_batal', 'api_mdcp_id', 'api_created_by', 'api_updated_by', 'api_deleted_by'], 'integer'],

      [['api_riwayat_penyakit', 'api_kesadaran', 'api_td', 'api_hr', 'api_rr', 'api_temp', 'api_status_asa', 'api_gol_darah', 'api_infus_tangan_kanan', 'api_infus_tangan_kiri', 'api_infus_kaki_kanan', 'api_infus_kaki_kiri', 'api_ngt', 'api_kateter', 'api_drain', 'api_cvp', 'api_lain_lain'], 'string'],

      [['api_puasa', 'api_rencana_tindakan_anestesi', 'api_tgl_final', 'api_tgl_batal', 'api_created_at', 'api_updated_at', 'api_deleted_at'], 'safe'],
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function attributeLabels()
  {
    return [
      'api_id' => 'ID',
      'api_to_id' => 'To ID',
      'api_riwayat_penyakit' => 'Riwayat Penyakit',
      'api_puasa' => 'Puasa Mulai Pukul',
      'api_kesadaran' => 'Kesadaran',
      'api_td' => 'TD',
      'api_hr' => 'HR',
      'api_rr' => 'RR',
      'api_temp' => 'Temp.',
      'api_status_asa' => 'Status ASA',
      'api_rencana_tindakan_anestesi' => 'Rencana Tindakan Anestesi',
      'api_final' => 'Final',
      'api_tgl_final' => 'Tgl Final',
      'api_batal' => 'Batal',
      'api_tgl_batal' => 'Tgl Batal',
      'api_mdcp_id' => 'Mdcp ID',
      'api_created_at' => 'Created At',
      'api_created_by' => 'Created By',
      'api_updated_at' => 'Updated At',
      'api_updated_by' => 'Updated By',
      'api_deleted_at' => 'Deleted At',
      'api_deleted_by' => 'Deleted By',
      'api_gol_darah' => 'Gol. Darah',
      'api_infus_tangan_kanan' => 'Tangan Kanan',
      'api_infus_tangan_kiri' => 'Tangan Kiri',
      'api_infus_kaki_kanan' => 'Kaki Kanan',
      'api_infus_kaki_kiri' => 'Kaki Kiri',
      'api_ngt' => 'NGT',
      'api_kateter' => 'Kateter',
      'api_drain' => 'Drain',
      'api_cvp' => 'CVP',
      'api_lain_lain' => 'Lain-Lain',
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
      $this->api_created_by = Akun::user()->id;
      $this->api_created_at = date('Y-m-d H:i:s');
    } else {
      $this->api_updated_by = Akun::user()->id;
      $this->api_updated_at = date('Y-m-d H:i:s');
    }
    return parent::beforeSave($model);
  }
  function setDelete()
  {
    $this->api_deleted_at = date('Y-m-d H:i:s');
    $this->api_deleted_by = Akun::user()->id;
  }
  function setBatal()
  {
    $this->api_batal = 1;
    $this->api_tgl_batal = date('Y-m-d H:i:s');
  }
  function setFinal()
  {
    $this->api_final = 1;
    $this->api_tgl_final = date('Y-m-d H:i:s');
  }
  function getTimoperasi()
  {
    return $this->hasOne(TimOperasi::className(), ['to_id' => 'api_to_id']);
  }
}
