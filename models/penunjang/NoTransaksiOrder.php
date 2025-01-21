<?php

namespace app\models\penunjang;

use Yii;

/**
 * This is the model class for table "no_transaksi_order".
 *
 * @property int $no_tran
 * @property int $layanan_id
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property int|null $deleted_by
 * @property string|null $created_at
 * @property string|null $updated_at
 * @property string|null $deleted_at
 * @property string|null $tanggal_masuk
 */
class NoTransaksiOrder extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'penunjang_2.no_transaksi_order';
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
            [['layanan_id'], 'required'],
            [['layanan_id', 'created_by', 'updated_by', 'deleted_by', 'dokter_id'], 'default', 'value' => null],
            [['layanan_id', 'created_by', 'updated_by', 'deleted_by'], 'integer'],
            [['created_at', 'updated_at', 'deleted_at', 'tanggal_masuk', 'dokter_id'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'no_tran' => 'No Tran',
            'layanan_id' => 'Layanan ID',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'deleted_by' => 'Deleted By',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'deleted_at' => 'Deleted At',
            'tanggal_masuk' => 'Tanggal Masuk',
            'dokter_id' => 'ID Dokter'
        ];
    }

    public static function makeNoTran($tgl)
    {
        $data = self::find()->select(['no_tran'])
            ->andWhere([
                'BETWEEN',
                'tanggal_masuk',
                date('Y-m-d', strtotime($tgl)) . " 00:00:00",
                date('Y-m-d', strtotime($tgl)) . " 23:59:59"
            ])->orderBy(['tanggal_masuk' => SORT_DESC])->limit(1)->asArray()->all();

        if (count($data) > 0) {
            $kode = (int) $data[0]['no_tran'];
            $kode = $kode + 1;
        } else {
            $kode = date('ymd') . '0000';
        }

        return $kode;
    }
}
