<?php

namespace app\models\farmasi;
use app\models\farmasi\Barang;
use yii\db\Expression;
/**
 * This is the ActiveQuery class for [[Barang]].
 *
 * @see Barang
 */
class BarangQuery extends \yii\db\ActiveQuery
{
    public function active()
    {
        return $this->andWhere([Barang::tableName().'.is_active'=>true]);
    }
    public function bpjs()
    {
        return $this->andWhere(['&&', Barang::tableName().'.id_kelompok', new Expression('array[' .Kelompok::ID_BPJS. ']')]);
    }
    public function init()
    {
        $this->andOnCondition([Barang::tableName().'.is_deleted'=>0]);
        parent::init();
    }
    /**
     * {@inheritdoc}
     * @return Barang[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Barang|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
    public function searchItem($q=null,$bpjs=true){
        if($bpjs){
            return $this->andWhere(['like', 'LOWER(nama_barang)', strtolower($q)])->orderBy([Barang::tableName().'.nama_barang'=>SORT_ASC])->active()->bpjs();
        }else{
            return $this->andWhere(['like', 'LOWER(nama_barang)', strtolower($q)])->orderBy([Barang::tableName().'.nama_barang'=>SORT_ASC])->active();
        }
    }
}
