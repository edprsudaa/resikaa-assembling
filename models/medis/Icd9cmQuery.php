<?php

namespace app\models\medis;

/**
 * This is the ActiveQuery class for [[Icd10cm]].
 *
 * @see Icd10cm
 */
class Icd9cmQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return Icd10cm[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Icd10cm|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
