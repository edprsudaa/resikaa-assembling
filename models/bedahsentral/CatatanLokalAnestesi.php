<?php

namespace app\models\bedahsentral;

use app\components\Akun;
use app\models\other\TrimBehavior;
use Yii;

class CatatanLokalAnestesi extends \yii\db\ActiveRecord
{
  const ass_n = 'Catatan Lokal Anestesi';
  /**
   * {@inheritdoc}
   */
  public static function tableName()
  {
    return 'catatan_lokal_anestesi';
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
      [['cla_to_id'], 'required'],

      [['cla_to_id', 'cla_final', 'cla_batal', 'cla_created_by', 'cla_updated_by', 'cla_deleted_by'], 'default', 'value' => null],

      [['cla_to_id', 'cla_final', 'cla_batal', 'cla_created_by', 'cla_updated_by', 'cla_deleted_by'], 'integer'],

      [['cla_jam_mulai_operasi', 'cla_jam_akhir_operasi', 'cla_tgl_final', 'cla_tgl_batal', 'cla_created_at', 'cla_updated_at', 'cla_deleted_at', 'cla_tanggal', 'cla_posisi_operasi'], 'safe'],

      [['cla_lama_operasi', 'cla_ruangan', 'cla_diagnosis_pra_bedah', 'cla_diagnosis_pasca_bedah', 'cla_tindakan', 'cla_tb', 'cla_bb', 'cla_td', 'cla_nadi', 'cla_hb', 'cla_ht'], 'string'],
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function attributeLabels()
  {
    return [
      'cla_id' => 'ID',
      'cla_to_id' => 'To ID',
      'cla_jam_mulai_operasi' => 'Jam Mulai Operasi',
      'cla_jam_akhir_operasi' => 'Jam Akhir Operasi',
      'cla_lama_operasi' => 'Lama Operasi',
      'cla_posisi_operasi' => 'Posisi Operasi',
      'cla_final' => 'Final',
      'cla_tgl_final' => 'Tgl Final',
      'cla_batal' => 'Batal',
      'cla_tanggal' => 'Tanggal',
      'cla_ruangan' => 'Ruangan',
      'cla_diagnosis_pra_bedah' => 'Diagnosis Pra Bedah',
      'cla_diagnosis_pasca_bedah' => 'Diagnosis Pasca Bedah',
      'cla_tindakan' => 'Tindakan',
      'cla_tb' => 'TB',
      'cla_bb' => 'BB',
      'cla_td' => 'TD',
      'cla_nadi' => 'Nadi',
      'cla_hb' => 'HB',
      'cla_ht' => 'HT',
      'cla_tgl_batal' => 'Tgl Batal',
      'cla_created_at' => 'Created At',
      'cla_created_by' => 'Created By',
      'cla_updated_at' => 'Updated At',
      'cla_updated_by' => 'Updated By',
      'cla_deleted_at' => 'Deleted At',
      'cla_deleted_by' => 'Deleted By',
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
      $this->cla_created_by = Akun::user()->id;
      $this->cla_created_at = date('Y-m-d H:i:s');
    } else {
      $this->cla_updated_by = Akun::user()->id;
      $this->cla_updated_at = date('Y-m-d H:i:s');
    }
    return parent::beforeSave($model);
  }
  function setDelete()
  {
    $this->cla_deleted_at = date('Y-m-d H:i:s');
    $this->cla_deleted_by = Akun::user()->id;
  }
  function setBatal()
  {
    $this->cla_batal = 1;
    $this->cla_tgl_batal = date('Y-m-d H:i:s');
  }
  function setFinal()
  {
    $this->cla_final = 1;
    $this->cla_tgl_final = date('Y-m-d H:i:s');
  }
  function getTimoperasi()
  {
    return $this->hasOne(TimOperasi::className(), ['to_id' => 'cla_to_id']);
  }
}
