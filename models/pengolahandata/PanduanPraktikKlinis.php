<?php

namespace app\models\pengolahandata;

use Yii;

/**
 * This is the model class for table "panduan_praktik_klinis".
 *
 * @property int $id
 * @property string|null $link
 * @property string|null $file_upload
 * @property string|null $keterangan
 * @property string|null $created_at
 * @property int $created_by
 * @property string|null $updated_at
 * @property int|null $updated_by
 * @property string|null $deleted_at
 * @property int|null $deleted_by
 */
class PanduanPraktikKlinis extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'pengolahan_data.panduan_praktik_klinis';
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
            [['link', 'file_upload', 'keterangan'], 'string'],
            [['created_at', 'updated_at', 'deleted_at'], 'safe'],
            // [['created_by'], 'required'],
            [['created_by', 'updated_by', 'deleted_by'], 'default', 'value' => null],
            [['created_by', 'updated_by', 'deleted_by'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'link' => 'Link Drive',
            'file_upload' => 'File Upload',
            'keterangan' => 'Nama Panduan Praktik Klinis',
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
            $this->created_at = date('Y-m-d H:i:s');
            $this->created_by = Yii::$app->user->identity->id;
        } else {
            $this->updated_at = date('Y-m-d H:i:s');
            $this->updated_by = Yii::$app->user->identity->id;
        }
        return parent::beforeSave($model);
    }
}
