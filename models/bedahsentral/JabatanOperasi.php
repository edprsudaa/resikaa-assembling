<?php

namespace app\models\bedahsentral;

use app\components\Akun;
use app\models\other\BaseQuery;
use Yii;

class JabatanOperasi extends \yii\db\ActiveRecord
{
  /**
   * {@inheritdoc}
   */
  public static function tableName()
  {
    return 'bedah_sentral.jabatan_operasi';
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
      [['jo_jabatan', 'jo_utama'], 'required'],
      [['jo_utama'], 'default', 'value' => null],
      [['jo_utama'], 'integer'],
      [['jo_jabatan'], 'string'],
      [['jo_created_at', 'jo_updated_at', 'jo_deleted_at'], 'safe'],
      [['jo_created_by', 'jo_updated_by', 'jo_deleted_by'], 'string', 'max' => 255],
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function attributeLabels()
  {
    return [
      'jo_id' => 'Jo ID',
      'jo_jabatan' => 'Jo Jabatan',
      'jo_utama' => 'Jo Utama',
      'jo_created_at' => 'Jo Created At',
      'jo_created_by' => 'Jo Created By',
      'jo_updated_at' => 'Jo Updated At',
      'jo_updated_by' => 'Jo Updated By',
      'jo_deleted_at' => 'Jo Deleted At',
      'jo_deleted_by' => 'Jo Deleted By',
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
      $this->jo_created_by = Akun::user()->id;
      $this->jo_created_at = date('Y-m-d H:i:s');
    } else {
      $this->jo_updated_by = Akun::user()->id;
      $this->jo_updated_at = date('Y-m-d H:i:s');
    }
    return parent::beforeSave($model);
  }

  function setDelete()
  {
    $this->jo_deleted_at = date('Y-m-d H:i:s');
    $this->jo_deleted_by = Akun::user()->id;
  }

  public static function getData($search = null)
  {
    $query = self::find();
    if ($search) {
      $query->andWhere(['ilike', 'LOWER(jo_jabatan)', strtolower($search)]);
    }
    return $query->orderBy(['jo_jabatan' => SORT_ASC])->asArray()->all();
  }
}
