<?php

namespace app\models\medis;

use Yii;

/**
 * This is the model class for table "medis.tindakan".
 *
 * @property int $id
 * @property int|null $parent_id
 * @property string $deskripsi
 * @property int|null $aktif
 * @property string|null $kode_jenis
 * @property string|null $created_at
 * @property int $created_by
 * @property string|null $updated_at
 * @property int|null $updated_by
 * @property int|null $is_deleted
 */
class Tindakan extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'medis.tindakan';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['parent_id', 'aktif', 'created_by', 'updated_by', 'is_deleted'], 'default', 'value' => null],
            [['parent_id', 'aktif', 'created_by', 'updated_by', 'is_deleted'], 'integer'],
            [['deskripsi', 'created_by'], 'required'],
            [['deskripsi'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['kode_jenis'], 'string', 'max' => 255],
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
            'deskripsi' => 'Deskripsi',
            'aktif' => 'Aktif',
            'kode_jenis' => 'Kode Jenis',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
            'is_deleted' => 'Is Deleted',
        ];
    }

    /**
     * {@inheritdoc}
     * @return TindakanQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new TindakanQuery(get_called_class());
    }
}
