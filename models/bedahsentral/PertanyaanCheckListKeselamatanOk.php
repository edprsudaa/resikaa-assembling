<?php

namespace app\models\bedahsentral;

use app\components\Akun;
use app\models\other\TrimBehavior;
use Yii;

class PertanyaanCheckListKeselamatanOk extends \yii\db\ActiveRecord
{
  const ass_n = 'Pertanyaan Checklist OK';
  /**
   * {@inheritdoc}
   */
  public static function tableName()
  {
    return 'bedah_sentral.pertanyaan_check_list_keselamatan_ok';
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
      [['pcok_to_id'], 'required'],
      [['pcok_id', 'pcok_to_id', 'pcok_final', 'pcok_batal', 'pcok_mdcp_id', 'pcok_created_by', 'pcok_updated_by', 'pcok_deleted_by'], 'integer'],
      [['pcok_si_pertanyaan1', 'pcok_si_pertanyaan2', 'pcok_si_pertanyaan3', 'pcok_si_pertanyaan4', 'pcok_si_pertanyaan5', 'pcok_si_pertanyaan6', 'pcok_si_pertanyaan7', 'pcok_si_pertanyaan8', 'pcok_to_pertanyaan1', 'pcok_to_pertanyaan2', 'pcok_to_pertanyaan3', 'pcok_to_pertanyaan4', 'pcok_to_pertanyaan5', 'pcok_to_pertanyaan6', 'pcok_to_pertanyaan7', 'pcok_to_pertanyaan8', 'pcok_to_pertanyaan9', 'pcok_to_pertanyaan10', 'pcok_so_pertanyaan1', 'pcok_so_pertanyaan2', 'pcok_so_pertanyaan3', 'pcok_so_pertanyaan4', 'pcok_so_pertanyaan5'], 'string'],
      [['pcok_tgl_final', 'pcok_tgl_batal', 'pcok_created_at', 'pcok_updated_at', 'pcok_deleted_at'], 'safe'],
    ];
  }
  public function attributeLabels()
  {
    return [
      'pcok_id' => 'ID',
      'pcok_to_id' => 'To ID',
      'pcok_final' => 'Final',
      'pcok_tgl_final' => 'Tgl Final',
      'pcok_batal' => 'Batal',
      'pcok_tgl_batal' => 'Tgl Batal',
      'pcok_mdcp_id' => 'Mdcp ID',
      'pcok_created_at' => 'Created At',
      'pcok_created_by' => 'Created By',
      'pcok_updated_at' => 'Updated At',
      'pcok_updated_by' => 'Updated By',
      'pcok_deleted_at' => 'Deleted At',
      'pcok_deleted_by' => 'Deleted By',
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
      $this->pcok_created_by = Akun::user()->id;
      $this->pcok_created_at = date('Y-m-d H:i:s');
    } else {
      $this->pcok_updated_by = Akun::user()->id;
      $this->pcok_updated_at = date('Y-m-d H:i:s');
    }
    return parent::beforeSave($model);
  }
  function setDelete()
  {
    $this->pcok_deleted_at = date('Y-m-d H:i:s');
    $this->pcok_deleted_by = Akun::user()->id;
  }
  function setBatal()
  {
    $this->pcok_batal = 1;
    $this->pcok_tgl_batal = date('Y-m-d H:i:s');
  }
  function setFinal()
  {
    $this->pcok_final = 1;
    $this->pcok_tgl_final = date('Y-m-d H:i:s');
  }
  function getTimoperasi()
  {
    return $this->hasOne(TimOperasi::className(), ['to_id' => 'pcok_to_id']);
  }
}
