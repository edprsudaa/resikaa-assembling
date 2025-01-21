<?php

namespace app\models\medis;

/**
 * This is the ActiveQuery class for [[ItemPemeriksaanPenunjang]].
 *
 * @see ItemPemeriksaanPenunjang
 */
class ItemPemeriksaanPenunjangQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return ItemPemeriksaanPenunjang[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return ItemPemeriksaanPenunjang|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
