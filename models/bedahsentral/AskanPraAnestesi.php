<?php

namespace app\models\bedahsentral;

use app\components\Akun;
use app\models\other\TrimBehavior;
use Yii;

class AskanPraAnestesi extends \yii\db\ActiveRecord
{
  const ass_n = 'Askan Pra Anestesi';

  public static function tableName()
  {
    return 'askan_pra_anestesi';
  }

  public static function getDb()
  {
    return Yii::$app->get('db_bedah_sentral');
  }

  public function rules()
  {
    return [
      [['apa_to_id'], 'required'],

      [['apa_to_id', 'apa_mdcp_id', 'apa_final', 'apa_batal', 'apa_created_by', 'apa_updated_by', 'apa_deleted_by'], 'default', 'value' => null],

      [['apa_to_id', 'apa_mdcp_id', 'apa_final', 'apa_batal', 'apa_created_by', 'apa_updated_by', 'apa_deleted_by'], 'integer'],

      [['apa_syaraf_kesadaran', 'apa_masalah_kesehatan', 'apa_kulit', 'apa_intervensi', 'apa_implementasi', 'apa_evaluasi', 'apa_tanggal_pukul', 'apa_tgl_final', 'apa_tgl_batal', 'apa_created_at', 'apa_updated_at', 'apa_deleted_at'], 'safe'],

      [['apa_td', 'apa_nadi', 'apa_suhu', 'apa_frekuensi_nafas', 'apa_bb', 'apa_tb', 'apa_gol_darah', 'apa_hb', 'apa_ht', 'apa_gds', 'apa_inform_consent', 'apa_respirasi', 'apa_renal_endokrin', 'apa_kardiovaskular', 'apa_hepato', 'apa_neuro', 'apa_lain_lain', 'apa_diagnosa', 'apa_tindakan', 'apa_crt', 'apa_pendarahan'], 'string'],
    ];
  }

  public function attributeLabels()
  {
    return [
      'apa_id' => 'ID',
      'apa_to_id' => 'To ID',
      'apa_tanggal_pukul' => 'Tanggal Pukul',
      'apa_td' => 'Td',
      'apa_nadi' => 'Nadi',
      'apa_suhu' => 'Suhu',
      'apa_frekuensi_nafas' => 'Frekuensi Nafas',
      'apa_bb' => 'Bb',
      'apa_tb' => 'Tb',
      'apa_gol_darah' => 'Gol Darah',
      'apa_hb' => 'Hb',
      'apa_ht' => 'Ht',
      'apa_gds' => 'Gds',
      'apa_inform_consent' => 'Inform Consent',
      'apa_respirasi' => 'Respirasi',
      'apa_renal_endokrin' => 'Renal Endokrin',
      'apa_kardiovaskular' => 'Kardiovaskular',
      'apa_syaraf_kesadaran' => 'Syaraf Kesadaran',
      'apa_hepato' => 'Hepato',
      'apa_neuro' => 'Neuro',
      'apa_kulit' => 'Kulit',
      'apa_pendarahan' => 'Pendarahan',
      'apa_crt' => 'CRT',
      'apa_lain_lain' => 'Lain Lain',
      'apa_diagnosa' => 'Diagnosa',
      'apa_tindakan' => 'Tindakan',
      'apa_masalah_kesehatan' => 'Masalah Kesehatan',
      'apa_intervensi' => 'Intervensi',
      'apa_implementasi' => 'Implementasi',
      'apa_evaluasi' => 'Evaluasi',
      'apa_mdcp_id' => 'Mdcp ID',
      'apa_final' => 'Final',
      'apa_tgl_final' => 'Tgl Final',
      'apa_batal' => 'Batal',
      'apa_tgl_batal' => 'Tgl Batal',
      'apa_created_at' => 'Created At',
      'apa_created_by' => 'Created By',
      'apa_updated_at' => 'Updated At',
      'apa_updated_by' => 'Updated By',
      'apa_deleted_at' => 'Deleted At',
      'apa_deleted_by' => 'Deleted By',
    ];
  }

  public function getModelClasName()
  {
    $class = explode("\\", get_called_class());
    return $class[(count($class) - 1)];
  }

  // public function behaviors()
  // {
  //   return [
  //     [
  //       'class' => TrimBehavior::className(),
  //     ],
  //   ];
  // }

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
      $this->apa_created_by = Akun::user()->id;
      $this->apa_created_at = date('Y-m-d H:i:s');
    } else {
      $this->apa_updated_by = Akun::user()->id;
      $this->apa_updated_at = date('Y-m-d H:i:s');
    }
    return parent::beforeSave($model);
  }

  function setDelete()
  {
    $this->apa_deleted_at = date('Y-m-d H:i:s');
    $this->apa_deleted_by = Akun::user()->id;
  }
  function setBatal()
  {
    $this->apa_batal = 1;
    $this->apa_tgl_batal = date('Y-m-d H:i:s');
  }
  function setFinal()
  {
    $this->apa_final = 1;
    $this->apa_tgl_final = date('Y-m-d H:i:s');
  }
  function getTimoperasi()
  {
    return $this->hasOne(TimOperasi::className(), ['to_id' => 'apa_to_id']);
  }
}
