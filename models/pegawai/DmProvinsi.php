<?php

namespace app\models\pegawai;

use Yii;

/**
 * This is the model class for table "pegawai.dm_provinsi".
 *
 * @property int $kode
 * @property string|null $nama
 * @property int|null $aktif
 * @property string|null $created_at
 * @property string|null $created_by
 * @property string|null $updated_at
 * @property string|null $updated_by
 * @property int|null $is_deleted
 */
class DmProvinsi extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'pegawai.dm_provinsi';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['aktif', 'is_deleted'], 'default', 'value' => null],
            [['aktif', 'is_deleted'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['created_by', 'updated_by'], 'string'],
            [['nama'], 'string', 'max' => 50],
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
            'aktif' => 'Aktif',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
            'is_deleted' => 'Is Deleted',
        ];
    }
    public function getKabupaten()
    {
        return $this->hasMany(DmKabupaten::className(), ['kode_prov' => 'kode']);
    }
}
