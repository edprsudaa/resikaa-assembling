<?php

namespace app\models\pegawai;

use Yii;

/**
 * This is the model class for table "pegawai.dm_pendidikan".
 *
 * @property int $id
 * @property string $pendidikan_terakhir
 * @property string|null $kode_max_gol
 */
class DmPendidikan extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'pegawai.dm_pendidikan';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'pendidikan_terakhir'], 'required'],
            [['id'], 'default', 'value' => null],
            [['id'], 'integer'],
            [['pendidikan_terakhir'], 'string', 'max' => 50],
            [['kode_max_gol'], 'string', 'max' => 5],
            [['id'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'pendidikan_terakhir' => 'Pendidikan Terakhir',
            'kode_max_gol' => 'Kode Max Gol',
        ];
    }
}
