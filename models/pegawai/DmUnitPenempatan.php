<?php

namespace app\models\pegawai;

use Yii;

/**
 * This is the model class for table "pegawai.dm_unit_penempatan".
 *
 * @property int $kode
 * @property string $nama
 * @property int $unit_rumpun
 * @property string|null $kode_unitsub_maping_simrs
 * @property int|null $aktif
 * @property string|null $created_at
 * @property string|null $created_by
 * @property string|null $updated_at
 * @property string|null $updated_by
 * @property int|null $is_deleted
 */
class DmUnitPenempatan extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'pegawai.dm_unit_penempatan';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nama', 'unit_rumpun'], 'required'],
            [['unit_rumpun', 'aktif', 'is_deleted'], 'default', 'value' => null],
            [['unit_rumpun', 'aktif', 'is_deleted'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['created_by', 'updated_by'], 'string'],
            [['nama'], 'string', 'max' => 120],
            [['kode_unitsub_maping_simrs'], 'string', 'max' => 6],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'kode' => 'Kode',
            'nama' => 'Nama',
            'unit_rumpun' => 'Unit Rumpun',
            'kode_unitsub_maping_simrs' => 'Kode Unitsub Maping Simrs',
            'aktif' => 'Aktif',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
            'is_deleted' => 'Is Deleted',
        ];
    }
}
