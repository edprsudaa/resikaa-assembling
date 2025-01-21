<?php

namespace app\models\medis;

use Yii;

/**
 * This is the model class for table "medis.tarif_kamar".
 *
 * @property int $id
 * @property int $kamar_id reff medis.kamar.id
 * @property int $sk_tarif_id reff medis.sk_tarif.id
 * @property int $biaya
 * @property string|null $created_at
 * @property int $created_by
 * @property string|null $updated_at
 * @property int|null $updated_by
 * @property int|null $is_deleted
 */
class TarifKamar extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'medis.tarif_kamar';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['kamar_id', 'sk_tarif_id', 'created_by'], 'required'],
            [['kamar_id', 'sk_tarif_id', 'biaya', 'created_by', 'updated_by', 'is_deleted'], 'default', 'value' => null],
            [['kamar_id', 'sk_tarif_id', 'biaya', 'created_by', 'updated_by', 'is_deleted'], 'integer'],
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
            'kamar_id' => 'Kamar ID',
            'sk_tarif_id' => 'Sk Tarif ID',
            'biaya' => 'Biaya',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
            'is_deleted' => 'Is Deleted',
        ];
    }

    /**
     * {@inheritdoc}
     * @return TarifKamarQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new TarifKamarQuery(get_called_class());
    }
    public function getKamar()
    {
        return $this->hasOne(Kamar::className(),['id'=>'kamar_id']);
    }
    public function getSkTarif()
    {
        return $this->hasOne(SkTarif::className(),['id'=>'sk_tarif_id']);
    }
}
