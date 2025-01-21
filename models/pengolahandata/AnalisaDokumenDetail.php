<?php

namespace app\models\pengolahandata;

use Yii;

/**
 * This is the model class for table "analisa_dokumen_detail".
 *
 * @property int $analisa_dokumen_detail_id
 * @property int $analisa_dokumen_id
 * @property int $analisa_dokumen_jenis_analisa_detail_id
 * @property int $analisa_dokumen_item_id
 * @property int $analisa_dokumen_jenis_id
 * @property int|null $analisa_dokumen_kelengkapan
 * @property int $analisa_dokumen_dokter_id
 * @property int $analisa_dokumen_petugas_analisa_id
 * @property string $created_by
 * @property string $created_at
 * @property string|null $updated_by
 * @property string|null $updated_at
 * @property string|null $deleted_at
 * @property int|null $deleted_by
 */
class AnalisaDokumenDetail extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'pengolahan_data.analisa_dokumen_detail';
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
            [['analisa_dokumen_id', 'analisa_dokumen_jenis_analisa_detail_id', 'analisa_dokumen_item_id', 'analisa_dokumen_jenis_id', 'analisa_dokumen_dokter_id', 'analisa_dokumen_petugas_analisa_id', 'created_by', 'created_at'], 'required'],
            [['analisa_dokumen_id', 'analisa_dokumen_jenis_analisa_detail_id', 'analisa_dokumen_item_id', 'analisa_dokumen_jenis_id', 'analisa_dokumen_kelengkapan', 'analisa_dokumen_dokter_id', 'analisa_dokumen_petugas_analisa_id', 'deleted_by'], 'default', 'value' => null],
            [['analisa_dokumen_id', 'analisa_dokumen_jenis_analisa_detail_id', 'analisa_dokumen_item_id', 'analisa_dokumen_jenis_id', 'analisa_dokumen_kelengkapan', 'analisa_dokumen_dokter_id', 'analisa_dokumen_petugas_analisa_id', 'deleted_by'], 'integer'],
            [['created_at', 'updated_at', 'deleted_at'], 'safe'],
            [['created_by', 'updated_by'], 'string', 'max' => 10],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'analisa_dokumen_detail_id' => 'Analisa Dokumen Detail ID',
            'analisa_dokumen_id' => 'Analisa Dokumen ID',
            'analisa_dokumen_jenis_analisa_detail_id' => 'Analisa Dokumen Jenis Analisa Detail ID',
            'analisa_dokumen_item_id' => 'Analisa Dokumen Item ID',
            'analisa_dokumen_jenis_id' => 'Analisa Dokumen Jenis ID',
            'analisa_dokumen_kelengkapan' => 'Analisa Dokumen Kelengkapan',
            'analisa_dokumen_dokter_id' => 'Analisa Dokumen Dokter ID',
            'analisa_dokumen_petugas_analisa_id' => 'Analisa Dokumen Petugas Analisa ID',
            'created_by' => 'Created By',
            'created_at' => 'Created At',
            'updated_by' => 'Updated By',
            'updated_at' => 'Updated At',
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
    function getJenisAnalisa(){
        return $this->hasOne(MasterJenisAnalisa::className(), ['jenis_analisa_id' => 'analisa_dokumen_jenis_id']);
    }

    function getItemAnalisa(){
        return $this->hasOne(MasterItemAnalisa::className(), ['item_analisa_id' => 'analisa_dokumen_item_id']);
    }
    
}
