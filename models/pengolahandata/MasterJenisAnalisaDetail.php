<?php

namespace app\models\pengolahandata;

use Yii;

/**
 * This is the model class for table "master_jenis_analisa_detail".
 *
 * @property int $jenis_analisa_detail_id
 * @property string $jenis_analisa_detail_jenis_analisa_id
 * @property string $jenis_analisa_detail_item_analisa_id
 * @property int|null $jenis_analisa_detail_aktif
 * @property string|null $jenis_analisa_detail_created_at
 * @property int $jenis_analisa_detail_created_by
 * @property string|null $jenis_analisa_detail_updated_at
 * @property int|null $jenis_analisa_detail_updated_by
 * @property int|null $jenis_analisa_detail_urutan
 * @property string|null $jenis_analisa_detail_deleted_at
 * @property int|null $jenis_analisa_detail_deleted_by
 * @property int|null $jenis_analisa_detail_rj
 * @property int|null $jenis_analisa_detail_ri
 */
class MasterJenisAnalisaDetail extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'master_jenis_analisa_detail';
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
            [['jenis_analisa_detail_jenis_analisa_id'], 'required'],
            [['jenis_analisa_detail_jenis_analisa_id', 'jenis_analisa_detail_item_analisa_id'], 'string'],
            [['jenis_analisa_detail_aktif', 'jenis_analisa_detail_created_by', 'jenis_analisa_detail_updated_by', 'jenis_analisa_detail_deleted_by', 'jenis_analisa_detail_rj', 'jenis_analisa_detail_ri'], 'default', 'value' => null],
            [['jenis_analisa_detail_aktif', 'jenis_analisa_detail_created_by', 'jenis_analisa_detail_updated_by', 'jenis_analisa_detail_deleted_by', 'jenis_analisa_detail_urutan', 'jenis_analisa_detail_rj', 'jenis_analisa_detail_ri'], 'integer'],
            [['jenis_analisa_detail_created_at', 'jenis_analisa_detail_updated_at', 'jenis_analisa_detail_deleted_at'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'jenis_analisa_detail_id' => 'Jenis Analisa Detail ID',
            'jenis_analisa_detail_jenis_analisa_id' => 'Jenis Analisa Detail Jenis Analisa ID',
            'jenis_analisa_detail_item_analisa_id' => 'Jenis Analisa Detail Item Analisa ID',
            'jenis_analisa_detail_aktif' => 'Jenis Analisa Detail Aktif',
            'jenis_analisa_detail_created_at' => 'Jenis Analisa Detail Created At',
            'jenis_analisa_detail_created_by' => 'Jenis Analisa Detail Created By',
            'jenis_analisa_detail_updated_at' => 'Jenis Analisa Detail Updated At',
            'jenis_analisa_detail_updated_by' => 'Jenis Analisa Detail Updated By',
            'jenis_analisa_detail_deleted_at' => 'Jenis Analisa Detail Deleted At',
            'jenis_analisa_detail_deleted_by' => 'Jenis Analisa Detail Deleted By',
            'jenis_analisa_detail_urutan' => 'Jenis Analisa Detail Urutan',
            'jenis_analisa_detail_rj' => 'Jenis Analisa Detail Rj',
            'jenis_analisa_detail_ri' => 'Jenis Analisa Detail Ri',
        ];
    }

    function getJenisAnalisa()
    {
        return $this->hasOne(MasterJenisAnalisa::className(), ['jenis_analisa_id' => 'jenis_analisa_detail_jenis_analisa_id']);
    }

    function getItemAnalisa()
    {
        return $this->hasOne(MasterItemAnalisa::className(), ['item_analisa_id' => 'jenis_analisa_detail_item_analisa_id']);
    }
    function getAnalisaDokumenDetail()
    {
        return $this->hasMany(AnalisaDokumenDetail::className(), ['registrasi_kode' => 'kode']);
    }

    function beforeSave($model)
    {
        if ($this->isNewRecord) {
            $this->jenis_analisa_detail_created_by = Yii::$app->user->identity->id;
            $this->jenis_analisa_detail_created_at = date('Y-m-d H:i:s');
        } else {
            $this->jenis_analisa_detail_updated_by = Yii::$app->user->identity->id;
            $this->jenis_analisa_detail_updated_at = date('Y-m-d H:i:s');
        }
        return parent::beforeSave($model);
    }
}
