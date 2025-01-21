<?php

namespace app\models\pengolahandata;

use Yii;

/**
 * This is the model class for table "master_item_analisa".
 *
 * @property int $item_analisa_id
 * @property string $item_analisa_uraian
 * @property int|null $item_analisa_aktif
 * @property string|null $item_analisa_created_at
 * @property int $item_analisa_created_by
 * @property string|null $item_analisa_updated_at
 * @property int|null $item_analisa_updated_by
 * @property string|null $item_analisa_deleted_at
 * @property int|null $item_analisa_deleted_by
 * @property int|null $item_analisa_tipe
 */
class MasterItemAnalisa extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'master_item_analisa';
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
            [['item_analisa_uraian'], 'required'],
            [['item_analisa_uraian'], 'string'],
            [['item_analisa_aktif', 'item_analisa_created_by', 'item_analisa_updated_by', 'item_analisa_deleted_by', 'item_analisa_tipe'], 'default', 'value' => null],
            [['item_analisa_aktif', 'item_analisa_created_by', 'item_analisa_updated_by', 'item_analisa_deleted_by', 'item_analisa_tipe'], 'integer'],
            [['item_analisa_created_at', 'item_analisa_updated_at', 'item_analisa_deleted_at'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'item_analisa_id' => 'Item Analisa ID',
            'item_analisa_uraian' => 'Item Analisa Uraian',
            'item_analisa_aktif' => 'Item Analisa Aktif',
            'item_analisa_created_at' => 'Item Analisa Created At',
            'item_analisa_created_by' => 'Item Analisa Created By',
            'item_analisa_updated_at' => 'Item Analisa Updated At',
            'item_analisa_updated_by' => 'Item Analisa Updated By',
            'item_analisa_deleted_at' => 'Item Analisa Deleted At',
            'item_analisa_deleted_by' => 'Item Analisa Deleted By',
            'item_analisa_tipe' => 'Item Analisa Tipe',
        ];
    }
    function beforeSave($model)
    {
        if ($this->isNewRecord) {
            $this->item_analisa_created_by = Yii::$app->user->identity->id;
            $this->item_analisa_created_at = date('Y-m-d H:i:s');
           
        } else {
            $this->item_analisa_updated_by = Yii::$app->user->identity->id;
            $this->item_analisa_updated_at = date('Y-m-d H:i:s');
        }
        return parent::beforeSave($model);
    }
}
