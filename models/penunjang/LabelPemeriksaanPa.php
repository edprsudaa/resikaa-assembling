<?php

namespace app\models\penunjang;

use Yii;

/**
 * This is the model class for table "label_pemeriksaan_pa".
 *
 * @property int $id
 * @property int $tindakan_tarif_pasien_id
 * @property int $layanan_id
 * @property int|null $unit_asal_id
 * @property string|null $tanggal
 * @property string|null $no_periksa
 * @property string|null $created_at
 * @property string|null $updated_at
 * @property string|null $deleted_at
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property int|null $deleted_by
 */
class LabelPemeriksaanPa extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'penunjang_2.label_pemeriksaan_pa';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db_postgre');
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['tindakan_tarif_pasien_id', 'layanan_id'], 'required'],
            [['tindakan_tarif_pasien_id', 'layanan_id', 'unit_asal_id', 'created_by', 'updated_by', 'deleted_by'], 'default', 'value' => null],
            [['tindakan_tarif_pasien_id', 'layanan_id', 'unit_asal_id', 'created_by', 'updated_by', 'deleted_by'], 'integer'],
            [['tanggal', 'created_at', 'updated_at', 'deleted_at'], 'safe'],
            [['no_periksa'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'tindakan_tarif_pasien_id' => 'Tindakan Tarif Pasien ID',
            'layanan_id' => 'Pasien ID',
            'unit_asal_id' => 'Unit Asal ID',
            'tanggal' => 'Tanggal',
            'no_periksa' => 'No Periksa',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'deleted_at' => 'Deleted At',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'deleted_by' => 'Deleted By',
        ];
    }
}
