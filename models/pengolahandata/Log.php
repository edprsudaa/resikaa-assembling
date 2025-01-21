<?php

namespace app\models\pengolahandata;

use app\components\HelperSpesialClass;
use app\models\pegawai\TbPegawai;
use app\models\sso\User;
use Yii;

/**
 * This is the model class for table "log".
 *
 * @property int $log_id
 * @property int $peminjaman_rekam_medis_id
 * @property string|null $token
 * @property int|null $pegawai_id
 * @property string|null $log_ip
 * @property string $created_at
 * @property int $created_by
 */
class Log extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'pengolahan_data.log';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db_pengolahan_data');
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [

            [['peminjaman_rekam_medis_id', 'created_at', 'created_by'], 'required'],
            [['peminjaman_rekam_medis_id', 'pegawai_id', 'created_by'], 'default', 'value' => null],
            [['peminjaman_rekam_medis_id', 'is_internal', 'pegawai_id', 'created_by'], 'integer'],
            [['token', 'log_ip'], 'string'],
            [['created_at'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'log_id' => 'Log ID',
            'peminjaman_rekam_medis_id' => 'Peminjaman Rekam Medis ID',
            'token' => 'Token',
            'pegawai_id' => 'Pegawai ID',
            'log_ip' => 'Log Ip',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
        ];
    }

    public static function logRead($id, $token, $is_internal)
    {
        $model = new Log();

        $model->peminjaman_rekam_medis_id = $id;
        $model->token = $token;
        $model->pegawai_id = $is_internal == true ? HelperSpesialClass::getUserLogin()['pegawai_id'] : 0;
        $model->log_ip = Log::getUserIpAddr();
        $model->created_at = date('Y-m-d H:i:s');
        $model->created_by = $is_internal == true ? \Yii::$app->user->identity->getId() : 0;
        $model->is_internal = $is_internal;
        $model->save();
    }

    public static function getUserIpAddr()
    {
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            //ip from share internet
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            //ip pass from proxy
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }

        // Handle IPv6 loopback address and map it to IPv4 loopback address
        if ($ip === '::1') {
            $ip = '127.0.0.1';
        }

        return $ip;
    }

    public function getPegawai()
    {
        return $this->hasOne(TbPegawai::className(), ['pegawai_id' => 'pegawai_id']);
    }
    public function getPegawaiSso()
    {
        return $this->hasOne(User::className(), ['userid' => 'pegawai_id']);
    }
}
