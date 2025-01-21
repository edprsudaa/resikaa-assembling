<?php

namespace app\models\pengolahandata;

/**
 * This is the ActiveQuery class for [[AsetKodefikasi]].
 *
 * @see AsetKodefikasi
 */
class KualifikasiPendidikanQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return KualifikasiPendidikan[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return KualifikasiPendidikan|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
