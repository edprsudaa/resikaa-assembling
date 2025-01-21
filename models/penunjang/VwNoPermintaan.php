<?php

namespace app\models\penunjang;

use Yii;

/**
 * This is the model class for table "vw_NoPermintaan".
 *
 * @property string $NO_DAFTAR
 * @property string $NO_PASIEN
 * @property string $KD_INST
 * @property string|null $INSTALASI
 * @property string $NO_TRAN
 * @property string $TANGGAL
 */
class VwNoPermintaan extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'vw_NoPermintaan';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db_sql_server');
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['NO_DAFTAR', 'NO_PASIEN', 'KD_INST', 'NO_TRAN', 'TANGGAL'], 'required'],
            [['TANGGAL'], 'safe'],
            [['NO_DAFTAR', 'NO_TRAN'], 'string', 'max' => 10],
            [['NO_PASIEN'], 'string', 'max' => 8],
            [['KD_INST'], 'string', 'max' => 4],
            [['INSTALASI'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'NO_DAFTAR' => 'No Daftar',
            'NO_PASIEN' => 'No Pasien',
            'KD_INST' => 'Kd Inst',
            'INSTALASI' => 'Instalasi',
            'NO_TRAN' => 'No Tran',
            'TANGGAL' => 'Tanggal',
        ];
    }
}
