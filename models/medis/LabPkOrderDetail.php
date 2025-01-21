<?php

namespace app\models\medis;

use Yii;

/**
 * This is the model class for table "medis.lab_pk_order_detail".
 *
 * @property int $id
 * @property int $lab_pk_order_id reff medis.lab_pk_order.id
 * @property int $item_pemeriksaan_penunjang_id reff medis.item_pemeriksaan_penunjang.id
 * @property string $created_at
 * @property int $created_by
 * @property string|null $updated_at
 * @property int|null $updated_by
 * @property string|null $log_data
 * @property int|null $is_deleted
 */
class LabPkOrderDetail extends BaseModelAR
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'medis.lab_pk_order_detail';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['item_pemeriksaan_penunjang_id'], 'required'],
            [['lab_pk_order_id', 'item_pemeriksaan_penunjang_id', 'created_by', 'updated_by', 'is_deleted'], 'default', 'value' => null],
            [['lab_pk_order_id', 'item_pemeriksaan_penunjang_id', 'created_by', 'updated_by', 'is_deleted'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['log_data', 'catatan'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'lab_pk_order_id' => 'Lab Pk Order ID',
            'item_pemeriksaan_penunjang_id' => 'Item Pemeriksaan Penunjang ID',
            'catatan' => 'Catatan',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
            'log_data' => 'Log Data',
            'is_deleted' => 'Is Deleted',
        ];
    }

    public function getItemPemeriksaan()
    {
        return $this->hasOne(ItemPemeriksaanPenunjang::className(), ['id' => 'item_pemeriksaan_penunjang_id'])->alias('item_penunjang');
    }

    public static function getPemeriksaanDetail($id)
    {
        $data = self::find()->alias('pd')
            ->select([
                'pd.item_pemeriksaan_penunjang_id',
                'pd.catatan',
                'ip.id',
                'ip.deskripsi',
            ])
            ->leftJoin('medis.item_pemeriksaan_penunjang ip', 'ip.id=pd.item_pemeriksaan_penunjang_id')
            ->where([
                'pd.lab_pk_order_id' => $id,
                'pd.is_deleted' => 0
            ])->asArray()->all();

        return $data;
    }
}
