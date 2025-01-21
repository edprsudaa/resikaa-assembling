<?php

namespace app\models\medis;

use Yii;

/**
 * This is the model class for table "master_doc_clinical".
 *
 * @property int $id_doc_clinical
 * @property string $nomor
 * @property string $nama
 * @property string|null $deskripsi
 * @property string|null $content
 * @property int $is_active
 * @property string $created_at
 * @property int $created_by
 * @property string|null $updated_at
 * @property int|null $updated_by
 * @property string|null $deleted_at
 * @property int|null $deleted_by
 */
class ItemDocClinical extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'medis.doc_clinical';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db_medis');
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nomor', 'nama', 'created_at', 'created_by'], 'required'],
            [['deskripsi', 'content'], 'string'],
            [['is_active', 'created_by', 'updated_by', 'deleted_by'], 'default', 'value' => null],
            [['is_active', 'created_by', 'updated_by', 'deleted_by'], 'integer'],
            [['created_at', 'updated_at', 'deleted_at'], 'safe'],
            [['nomor'], 'string', 'max' => 255],
            [['nama'], 'string', 'max' => 500],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_doc_clinical' => 'Id Doc Clinical',
            'nomor' => 'Nomor',
            'nama' => 'Nama',
            'deskripsi' => 'Deskripsi',
            'content' => 'Content',
            'is_active' => 'Is Active',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
            'deleted_at' => 'Deleted At',
            'deleted_by' => 'Deleted By',
        ];
    }
}
