<?php

namespace app\models\penunjang;

use app\models\medis\ItemPemeriksaanPenunjang;
use app\models\medis\Tindakan;
use Yii;

/**
 * This is the model class for table "pemeriksaan_tindakan_pk".
 *
 * @property int $id
 * @property int $pemeriksaan_penunjang_id
 * @property int $tindakan_id
 * @property string|null $created_at
 * @property string|null $updated_at
 * @property string|null $deleted_at
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property int|null $deleted_by
 */
class PemeriksaanTindakanPk extends \yii\db\ActiveRecord
{
    public $deskripsi_tindakan;
    public $deskripsi_pemeriksaan;
    public static function tableName()
    {
        return 'penunjang_2.pemeriksaan_tindakan_pk';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db_penunjang');
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['pemeriksaan_penunjang_id', 'tindakan_id'], 'required'],
            [['pemeriksaan_penunjang_id', 'tindakan_id', 'created_by', 'updated_by', 'deleted_by'], 'default', 'value' => null],
            [['pemeriksaan_penunjang_id', 'tindakan_id', 'created_by', 'updated_by', 'deleted_by'], 'integer'],
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
            'pemeriksaan_penunjang_id' => 'Pemeriksaan Penunjang ID',
            'tindakan_id' => 'Tindakan ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'deleted_at' => 'Deleted At',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'deleted_by' => 'Deleted By',
        ];
    }

    public function getTindakan()
    {
        return $this->hasOne(Tindakan::className(), ['id' => 'tindakan_id']);
    }

    public function getPemeriksaan()
    {
        return $this->hasOne(ItemPemeriksaanPenunjang::className(), ['id' => 'pemeriksaan_penunjang_id']);
    }
}
