<?php

namespace app\models\bedahsentral;

use app\models\other\BaseQuery;
// use app\models\pegawai\Pegawai;
use app\models\pegawai\TbPegawai;
use app\models\sso\User;
use Yii;

class TimOperasiDetail extends \yii\db\ActiveRecord
{
  /**
   * {@inheritdoc}
   */
  public static function tableName()
  {
    return 'bedah_sentral.tim_operasi_detail';
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
      [['tod_jo_id', 'tod_pgw_id'], 'required'],
      [['tod_id', 'tod_to_id', 'tod_jo_id', 'tod_pgw_id'], 'integer'],
      [['tod_created_at', 'tod_updated_at', 'tod_deleted_at'], 'safe'],
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function attributeLabels()
  {
    return [
      'tod_id' => 'ID',
      'tod_to_id' => 'Tim Operasi',
      'tod_jo_id' => 'Jabatan Operasi',
      'tod_pgw_id' => 'Pegawai',
      'tod_created_at' => 'Created At',
      'tod_created_by' => 'Created By',
      'tod_updated_at' => 'Updated At',
      'tod_updated_by' => 'Updated By',
      'tod_deleted_at' => 'Deleted At',
      'tod_deleted_by' => 'Deleted By',
    ];
  }
  public static function find()
  {
    return new BaseQuery(get_called_class());
  }
  function attr()
  {
    $data = [];
    foreach ($this->attributeLabels() as $key => $val) {
      $data[$val] = $this->{$key};
    }
    return $data;
  }
  function getTimOperasi()
  {
    return $this->hasOne(TimOperasi::className(), ['to_id' => 'tod_to_id']);
  }
  function getPegawai()
  {
    return $this->hasOne(TbPegawai::className(), ['pegawai_id' => 'tod_pgw_id']);
  }
  function getJabatanOperasi()
  {
    return $this->hasOne(JabatanOperasi::className(), ['jo_id' => 'tod_jo_id']);
  }
  // function getUser()
  // {
  //   return $this->hasOne(User::className(), ['userid' => 'tod_pgw_id']);
  // }
}
