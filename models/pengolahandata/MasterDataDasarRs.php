<?php

namespace app\models\pengolahandata;

use app\components\Akun;
use app\models\pengolahandata\MasterDataDasarRsQuery;
use Yii;

/**
 * This is the model class for table "master_data_dasar_rs".
 *
 * @property int $id
 * @property int|null $parent_id
 * @property int|null $no_urut
 * @property string $deskripsi
 * @property int $is_active
 * @property int $created_by
 * @property string $created_at
 * @property int|null $updated_by
 * @property string|null $updated_at
 * @property int|null $deleted_by
 * @property string|null $deleted_at
 */
class MasterDataDasarRs extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'pengolahan_data.master_data_dasar_rs';
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
            [['parent_id', 'no_urut', 'is_active', 'created_by', 'updated_by', 'deleted_by'], 'default', 'value' => null],
            [['parent_id', 'no_urut', 'is_active', 'created_by', 'updated_by', 'deleted_by'], 'integer'],
            [['deskripsi'], 'required'],
            [['deskripsi'], 'string'],
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
            'parent_id' => 'Parent ID',
            'no_urut' => 'No Urut',
            'deskripsi' => 'Deskripsi',
            'is_active' => 'Is Active',
            'created_by' => 'Created By',
            'created_at' => 'Created At',
            'updated_by' => 'Updated By',
            'updated_at' => 'Updated At',
            'deleted_by' => 'Deleted By',
            'deleted_at' => 'Deleted At',
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

    static function getDataDasarRs()
    {
        $data = \Yii::$app->db->createCommand("
        WITH RECURSIVE rec_data_dasar_rs AS (
            SELECT a.id, a.parent_id, a.deskripsi,
                   a.deskripsi AS rumpun
            FROM ".MasterDataDasarRs::tableName()." as a
            WHERE a.parent_id = 0
         UNION ALL
            SELECT b.id, b.parent_id, b.deskripsi, CONCAT(rec_data_dasar_rs.rumpun, ' -> ', b.deskripsi)
            FROM ".MasterDataDasarRs::tableName()." as b
               JOIN rec_data_dasar_rs ON b.parent_id = rec_data_dasar_rs.id
      )
      SELECT * FROM rec_data_dasar_rs ORDER BY id ASC")->queryAll();

      return $data;
    }

    static function getDataDasarRsInduk()
    {
        $data = \Yii::$app->db->createCommand("
        WITH RECURSIVE rec_data_dasar_rs AS (
            SELECT a.id, a.parent_id, a.deskripsi,
                   a.deskripsi AS rumpun
            FROM ".MasterDataDasarRs::tableName()." as a
            WHERE a.parent_id = 0
         UNION ALL
            SELECT b.id, b.parent_id, b.deskripsi, CONCAT(rec_data_dasar_rs.rumpun, ' >> ', b.deskripsi)
            FROM ".MasterDataDasarRs::tableName()." as b
               JOIN rec_data_dasar_rs ON b.parent_id = rec_data_dasar_rs.id
      )
      SELECT * FROM rec_data_dasar_rs WHERE id IN(select c.parent_id FROM ".MasterDataDasarRs::tableName()." as c where c.parent_id <> 0 group by c.parent_id) ORDER BY id ASC")->queryAll();

      return $data;
    }

    static function getDataDasarRsAnak()
    {
        $data = \Yii::$app->db->createCommand("
        WITH RECURSIVE rec_data_dasar_rs AS (
            SELECT a.id, a.parent_id, a.deskripsi,
                   a.deskripsi AS rumpun
            FROM ".MasterDataDasarRs::tableName()." as a
            WHERE a.parent_id = 0
         UNION ALL
            SELECT b.id, b.parent_id, b.deskripsi, CONCAT(rec_data_dasar_rs.rumpun, ' >> ', b.deskripsi)
            FROM ".MasterDataDasarRs::tableName()." as b
               JOIN rec_data_dasar_rs ON b.parent_id = rec_data_dasar_rs.id
      )
      SELECT * FROM rec_data_dasar_rs WHERE id NOT IN(select c.parent_id FROM ".MasterDataDasarRs::tableName()." as c where c.parent_id <> 0 group by c.parent_id) AND parent_id <> 0 ORDER BY id ASC")->queryAll();

      return $data;
    }

    public static function find()
    {
        return new MasterDataDasarRsQuery(get_called_class());
    }
}
