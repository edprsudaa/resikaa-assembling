<?php

namespace app\models\medis;

use Yii;

/**
 * This is the model class for table "medis.icd9cm".
 *
 * @property int $id
 * @property string $kode
 * @property string $deskripsi
 * @property string|null $keterangan
 * @property int|null $aktif
 * @property string|null $created_at
 * @property int $created_by
 * @property string|null $updated_at
 * @property int|null $updated_by
 * @property int|null $is_deleted
 */
class Icd9cmv3 extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'medis.icd9cm_2010_fix';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['aktif', 'created_by', 'updated_by', 'is_deleted'], 'default', 'value' => null],
            [['aktif', 'created_by', 'updated_by', 'is_deleted'], 'integer'],
            [['kode', 'deskripsi', 'created_by'], 'required'],
            [['deskripsi'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['kode'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'kode' => 'Kode',
            'deskripsi' => 'Deskripsi',
            'aktif' => 'Aktif',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
            'is_deleted' => 'Is Deleted',
        ];
    }

    /**
     * {@inheritdoc}
     * @return Icd9cmQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new Icd9cmv3Query(get_called_class());
    }
    public static function getListProsedur($q=null){
        $sql="
        select
            id as id ,CONCAT('(',kode,') ',deskripsi) as text,kode,deskripsi
        FROM ".self::tableName()."  where kode LIKE '%".$q."%' OR deskripsi LIKE '%".$q."%'
        ";
        return \Yii::$app->db->createCommand($sql)->queryAll();
    }
}
