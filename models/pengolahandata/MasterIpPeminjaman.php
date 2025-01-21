<?php

namespace app\models\pengolahandata;

use Yii;

/**
 * This is the model class for table "master_ip_peminjaman".
 *
 * @property int $id
 * @property string|null $ip_address
 * @property int|null $aktif
 * @property string|null $created_at
 * @property int $created_by
 * @property string|null $updated_at
 * @property int|null $updated_by
 * @property string|null $deleted_at
 * @property int|null $deleted_by
 */
class MasterIpPeminjaman extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'pengolahan_data.master_ip_peminjaman';
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
            [['ip_address'], 'string'],
            [['ip_address', 'aktif'], 'required'],
            [['ip_address'], 'unique', 'message' => 'IP Address sudah ada.'],
            [['aktif', 'created_by', 'updated_by', 'deleted_by'], 'default', 'value' => null],
            [['aktif', 'created_by', 'updated_by', 'deleted_by'], 'integer'],
            [['created_at', 'updated_at', 'deleted_at'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'ip_address' => 'Log Ip',
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

    public static function getListIpPeminjaman($q = null)
    {
        $sql = "
        select
        id as id ,ip_address as text
        FROM " . self::tableName() . "  where ip_address ILIKE '%" . $q . "%' AND aktif=1
         AND deleted_at is null and deleted_by is null";
        return \Yii::$app->db->createCommand($sql)->queryAll();
    }
}
