<?php

namespace app\models\medis;

use Yii;
use app\components\HelperSpesialClass;
use app\models\farmasi\Barang;
/**
 * This is the model class for table "medis.resep_detail".
 *
 * @property int $id
 * @property int $resep_id reff medis.resep.id
 * @property int|null $obat_id reff farmasi.master_barang.id_barang
 * @property int $jumlah
 * @property string|null $dosis
 * @property string|null $aturan
 * @property string $created_at
 * @property int $created_by
 * @property string|null $updated_at
 * @property int|null $updated_by
 * @property int $is_deleted
 */
class ResepDetail extends BaseModelAR
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'medis.resep_detail';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['obat_id', 'jumlah','dosis'], 'required'],
            [['resep_id', 'obat_id', 'jumlah', 'created_by', 'updated_by', 'is_deleted'], 'integer'],
            [['dosis', 'catatan','log_data'], 'string'],
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
            'resep_id' => 'Resep',
            'obat_id' => 'Obat',
            'jumlah' => 'Jumlah',
            'dosis' => 'Dosis',
            'Catatan' => 'Catatan',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
            'log_data' => 'Log Data',
            'is_deleted' => 'Is Deleted',
        ];
    }
    // public function beforeSave($insert)
    // {
    //     if($insert){
    //         $this->created_at   = date('Y-m-d H:i:s');
    //         $this->created_by = HelperSpesialClass::getUserLogin();
    //         $this->is_deleted=0;
    //     }else{
    //         $this->updated_at   = date('Y-m-d H:i:s');
    //         $this->updated_by = HelperSpesialClass::getUserLogin();
    //     }
    //     return parent::beforeSave($insert); // TODO: Change the autogenerated stub
    // }
    public function beforeSave($insert) {
        if ($insert) {
            $this->is_deleted = 0;
        }
        return parent::beforeSave($insert); // TODO: Change the autogenerated stub
    }
    /**
     * {@inheritdoc}
     * @return ResepDetailQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ResepDetailQuery(get_called_class());
    }
	function getResep()
	{
		return $this->hasOne(Resep::class,['id'=>'resep_id']);
	}
    function getObat()
    {
        return $this->hasOne(Barang::className(),['id_barang'=>'obat_id']);
    }
}