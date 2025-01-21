<?php

namespace app\models\medis;

use Yii;
use app\models\pegawai\DmUnitPenempatan;

/**
 * This is the model class for table "medis.tarif_tindakan_unit".
 *
 * @property int $id
 * @property int $tarif_tindakan_id reff medis.tarif_tindakan.id
 * @property int $unit_id reff pegawai.dm_unit_penempatan.id
 * @property int $aktif
 * @property string $created_at
 * @property int $created_by
 * @property string|null $updated_at
 * @property int|null $updated_by
 * @property int $is_deleted
 */
class TarifTindakanUnit extends \yii\db\ActiveRecord
{
    public $tarif;

    public static function tableName()
    {
        return 'medis.tarif_tindakan_unit';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['tarif_tindakan_id', 'unit_id', 'created_by'], 'required'],
            [['tarif_tindakan_id', 'unit_id', 'aktif', 'created_by', 'updated_by', 'is_deleted'], 'default', 'value' => null],
            [['tarif_tindakan_id', 'unit_id', 'aktif', 'created_by', 'updated_by', 'is_deleted'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'tarif_tindakan_id' => 'Tarif Tindakan ID',
            'unit_id' => 'Unit ID',
            'aktif' => 'Aktif',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
            'is_deleted' => 'Is Deleted',
        ];
    }

    public static function find()
    {
        return new TarifTindakanUnitQuery(get_called_class());
    }
    function getTarifTindakan()
    {
        return $this->hasOne(TarifTindakan::className(), ['id' => 'tarif_tindakan_id']);
    }
    function getUnit()
    {
        return $this->hasOne(DmUnitPenempatan::className(), ['kode' => 'unit_id']);
    }
}
