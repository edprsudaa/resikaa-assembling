<?php

namespace app\models\pengolahandata;

use app\models\pegawai\Pegawai;
use app\models\pegawai\TbPegawai;
use Yii;

/**
 * This is the model class for table "master_user_access_peminjaman".
 *
 * @property int $id
 * @property string $username
 * @property int $ip_id
 * @property int|null $aktif
 * @property string|null $created_at
 * @property int $created_by
 * @property string|null $updated_at
 * @property int|null $updated_by
 * @property string|null $deleted_at
 * @property int|null $deleted_by
 */
class MasterUserAccessPeminjaman extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'pengolahan_data.master_user_access_peminjaman';
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
            [['username', 'ip_id'], 'required'],
            [['ip_id', 'aktif', 'created_by', 'updated_by', 'deleted_by'], 'default', 'value' => null],
            [['ip_id', 'aktif', 'created_by', 'updated_by', 'deleted_by'], 'integer'],
            [['created_at', 'updated_at', 'deleted_at'], 'safe'],
            [['username'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Username',
            'ip_id' => 'Ip ID',
            'aktif' => 'Aktif',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
            'deleted_at' => 'Deleted At',
            'deleted_by' => 'Deleted By',
        ];
    }
    function beforeSave($model)
    {
        if ($this->isNewRecord) {
            $this->created_by = Yii::$app->user->identity->id;
            $this->created_at = date('Y-m-d H:i:s');
        } else {
            $this->updated_by = Yii::$app->user->identity->id;
            $this->updated_at = date('Y-m-d H:i:s');
        }
        return parent::beforeSave($model);
    }

    public function getPegawai()
    {
        return $this->hasOne(Pegawai::className(), ['id_nip_nrp' => 'username'])
            ->from(['pegawai' => 'pegawai.tb_pegawai']); // alias untuk tabel pegawai
    }
    public function getIpPeminjaman()
    {
        return $this->hasOne(MasterIpPeminjaman::className(), ['id' => 'ip_id']);
    }
}
