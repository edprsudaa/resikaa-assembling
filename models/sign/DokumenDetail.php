<?php

namespace app\models\sign;

use Yii;

/**
 * This is the model class for table "dokumen_detail".
 *
 * @property int $id_dokumen_detail
 * @property int $id_dokumen
 * @property string|null $versi
 * @property int $integrasi
 * @property string $url
 * @property string $name_colums_params_url
 * @property string $created_at
 * @property int $created_by
 * @property string|null $updated_at
 * @property int|null $updated_by
 * @property string|null $deleted_at
 * @property int|null $deleted_by
 * @property string|null $key_hash_code
 */
class DokumenDetail extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'dokumen_detail';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db_sign');
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_dokumen', 'url_lihat', 'url_cetak', 'name_colums_params_url'], 'required'],
            [['id_dokumen', 'integrasi', 'created_by', 'updated_by', 'deleted_by'], 'default', 'value' => null],
            [['id_dokumen', 'integrasi', 'created_by', 'updated_by', 'deleted_by'], 'integer'],
            [['url_lihat', 'url_cetak',], 'string'],
            [['created_at', 'updated_at', 'deleted_at'], 'safe'],
            [['versi'], 'string', 'max' => 12],
            [['name_colums_params_url', 'key_hash_code'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_dokumen_detail' => 'Id Dokumen Detail',
            'id_dokumen' => 'Id Dokumen',
            'versi' => 'Versi',
            'integrasi' => 'Integrasi',
            'url_lihat' => 'Url Lihat',
            'name_colums_params_url' => 'Name Colums Params Url',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
            'deleted_at' => 'Deleted At',
            'deleted_by' => 'Deleted By',
            'key_hash_code' => 'Key Hash Code',
            'url_cetak' => 'Url Cetak',

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
    public function getDokumen()
    {
        return $this->hasOne(Dokumen::class, ['id_dokumen' => 'id_dokumen']);
    }
}
