<?php

namespace app\models\pengolahandata;

use app\models\medis\Icd10cmv2;

use Yii;

/**
 * This is the model class for table "coding_pelaporan_diagnosa_detail_rj".
 *
 * @property int $id
 * @property int $coding_pelaporan_id
 * @property int $utama
 * @property int $icd10_id
 * @property string|null $icd10_kode
 * @property string|null $icd10_deskripsi
 * @property string|null $created_at
 * @property int $created_by
 * @property string|null $updated_at
 * @property int|null $updated_by
 * @property string|null $deleted_at
 * @property int|null $deleted_by
 */
class CodingPelaporanDiagnosaDetailIgd extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'coding_pelaporan_diagnosa_detail_igd';
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
            [['icd10_id'], 'required'],
            [['coding_pelaporan_id', 'utama', 'icd10_id', 'created_by', 'updated_by', 'deleted_by'], 'default', 'value' => null],
            [['coding_pelaporan_id', 'utama', 'icd10_id', 'created_by', 'updated_by', 'deleted_by'], 'integer'],
            [['icd10_kode', 'icd10_deskripsi'], 'string'],
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
            'coding_pelaporan_id' => 'Coding Pelaporan ID',
            'utama' => 'Utama',
            'icd10_id' => 'Icd10 ID',
            'icd10_kode' => 'Icd10 Kode',
            'icd10_deskripsi' => 'Icd10 Deskripsi',
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

    function getDiagnosa()
    {
        return $this->hasOne(Icd10cmv2::className(), ['id' => 'icd10_id']);
    }
    function getCodingPelaporan()
    {
        return $this->hasOne(CodingPelaporanIgd::className(), ['id' => 'coding_pelaporan_id']);
    }
}