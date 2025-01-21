<?php

namespace app\models\bedahsentral;

use app\components\Akun;
use app\models\AkunAknUser;
use app\models\pegawai\TbPegawai;
use app\models\sso\PegawaiUser;
use app\models\User;
use Yii;

class Log extends \yii\db\ActiveRecord
{
  const TYPE_CREATE = 'C';
  const TYPE_READ = 'R';
  const TYPE_UPDATE = 'U';
  const TYPE_DELETE = 'D';

  const TYPE_DATA_HTML = 'H';
  const TYPE_DATA_HTML_BASE64 = 'B';
  const TYPE_DATA_LINKPDF = 'LP';
  const TYPE_DATA_LINKGAMBAR = 'LG';
  const TYPE_DATA_JSON = 'J';
  /**
   * {@inheritdoc}
   */
  public static function tableName()
  {
    return 'bedah_sentral.log';
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
      [['mlog_id', 'mlog_mdcp', 'mlog_type', 'mlog_deskripsi', 'mlog_data_type', 'mlog_ip', 'mlog_created_at', 'mlog_created_by'], 'required'],
      [['mlog_id', 'mlog_mdcp', 'mlog_mdcp_id', 'mlog_created_by'], 'default', 'value' => null],
      [['mlog_id', 'mlog_mdcp', 'mlog_mdcp_id', 'mlog_created_by'], 'integer'],
      [['mlog_deskripsi', 'mlog_data_before', 'mlog_data_after', 'mlog_media'], 'string'],
      [['mlog_created_at'], 'safe'],
      [['mlog_type', 'mlog_data_type'], 'string', 'max' => 1],
      [['mlog_ip'], 'string', 'max' => 255],
      [['mlog_id'], 'unique'],
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function attributeLabels()
  {
    return [
      'mlog_id' => 'ID',
      'mlog_mdcp' => 'Mdcp',
      'mlog_mdcp_id' => 'Mdcp ID',
      'mlog_type' => 'Type',
      'mlog_deskripsi' => 'Deskripsi',
      'mlog_data_type' => 'Data Type',
      'mlog_data_before' => 'Data Before',
      'mlog_data_after' => 'Data After',
      'mlog_ip' => 'Ip',
      'mlog_media' => 'Media',
      'mlog_created_at' => 'Created At',
      'mlog_created_by' => 'Created By',
    ];
  }
  function beforeSave($model)
  {
    // if($this->scenario=="created"){
    if ($this->scenario == "mdcp") {
      $this->mlog_mdcp = 1;
      $this->mlog_ip = Yii::$app->request->userIp;
      $this->mlog_media = Yii::$app->request->getUserAgent();
      $this->mlog_created_at = date('Y-m-d H:i:s');
      $this->mlog_created_by = Akun::user()->id;
    } else {
      $this->mlog_mdcp = 0;
      $this->mlog_mdcp_id = null;
      $this->mlog_data_type = self::TYPE_DATA_JSON;
      $this->mlog_ip = Yii::$app->request->userIp;
      $this->mlog_media = Yii::$app->request->getUserAgent();
      $this->mlog_created_at = date('Y-m-d H:i:s');
      $this->mlog_created_by = Akun::user()->id;
    }
    return parent::beforeSave($model);
  }
  public static function saveLog($log)
  {
    // $type,$deskripsi,$data_before,$data_after
    Yii::$app->db->createCommand()->insert(self::tableName(), [
      'mlog_mdcp' => 0,
      'mlog_mdcp_id' => null,
      'mlog_type' => $log['type'],
      'mlog_deskripsi' => $log['deskripsi'],
      'mlog_data_type' => self::TYPE_DATA_JSON,
      'mlog_data_before' => (count($log['before']) > 0) ? json_encode($log['before']) : null,
      'mlog_data_after' => (count($log['after']) > 0) ? json_encode($log['after']) : null,
      'mlog_ip' => Yii::$app->request->userIp,
      'mlog_media' => Yii::$app->request->getUserAgent(),
      'mlog_created_at' => date('Y-m-d H:i:s'),
      'mlog_created_by' => Akun::user()->id
    ])->execute();
  }
  public function getPegawai()
  {
    return $this->hasOne(PegawaiUser::className(), ['userid' => 'mlog_created_by']);
  }
}
