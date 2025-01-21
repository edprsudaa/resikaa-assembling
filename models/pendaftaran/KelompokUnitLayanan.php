<?php

namespace app\models\pendaftaran;

use Yii;
use app\models\pegawai\DmUnitPenempatan;
/**
 * This is the model class for table "pendaftaran.kelompok_unit_layanan".
 *
 * @property int $id
 * @property int $unit_id fk ke pegawaqi.dm_unit_penepatan
 * @property int $type 1=> IGD; 2=> RJ REGULER;3=>RJ UTAMA;4=>RAWATINAP;5=>PENUNJANG
 * @property string $created_at
 * @property int $created_by
 * @property string|null $updated_at
 * @property int|null $updated_by
 * @property int|null $is_deleted
 */
class KelompokUnitLayanan extends \yii\db\ActiveRecord
{
    const IGD=1;
    const RJ=2;
    const RI=3;
    const PENUNJANG=4;
    const RJUTAMA = 5;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'pendaftaran.kelompok_unit_layanan';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['unit_id', 'type', 'created_by'], 'required'],
            [['unit_id', 'type', 'created_by', 'updated_by','deleted_by'], 'default', 'value' => null],
            [['unit_id', 'type', 'created_by', 'updated_by','deleted_by' ], 'integer'],
            [['created_at', 'updated_at','deleted_at'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'unit_id' => 'Unit ID',
            'type' => 'Type',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
            'deleted_at' => 'deleted At',
            'deleted_by' => 'deleted By',
        ];
    }

    /**
     * {@inheritdoc}
     * @return KelompokUnitLayananQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new KelompokUnitLayananQuery(get_called_class());
    }
    function getUnit()
    {
        return $this->hasOne(DmUnitPenempatan::className(),['kode'=>'unit_id']);
    }
}
