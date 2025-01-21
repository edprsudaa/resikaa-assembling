<?php

namespace app\models\pengolahandata;

use Yii;
use app\models\medis\Icd9cmv3;

/**
 * This is the model class for table "coding_pelaporan_tindakan_detail_igd".
 *
 * @property int $id
 * @property int $coding_pelaporan_id
 * @property int $utama
 * @property int $icd9_id
 * @property string|null $icd9_kode
 * @property string|null $icd9_deskripsi
 * @property string|null $created_at
 * @property int $created_by
 * @property string|null $updated_at
 * @property int|null $updated_by
 * @property string|null $deleted_at
 * @property int|null $deleted_by
 */
class CodingPelaporanTindakanDetailIgd extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'coding_pelaporan_tindakan_detail_igd';
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
            [['icd9_id'], 'required'],
            [['coding_pelaporan_id', 'utama', 'icd9_id', 'created_by', 'updated_by', 'deleted_by'], 'default', 'value' => null],
            [['coding_pelaporan_id', 'utama', 'icd9_id', 'created_by', 'updated_by', 'deleted_by'], 'integer'],
            [['icd9_kode', 'icd9_deskripsi'], 'string'],
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
            'icd9_id' => 'Icd9 ID',
            'icd9_kode' => 'Icd9 Kode',
            'icd9_deskripsi' => 'Icd9 Deskripsi',
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

    function getTindakan()
    {
        return $this->hasOne(Icd9cmv3::className(), ['id' => 'icd9_id']);
    }
    function getCodingPelaporan()
    {
        return $this->hasOne(CodingPelaporanIgd::className(), ['id' => 'coding_pelaporan_id']);
    }
}
