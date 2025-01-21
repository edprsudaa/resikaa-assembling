<?php

namespace app\models\pendaftaran;

/**
 * This is the ActiveQuery class for [[KelasRawat]].
 *
 * @see KelasRawat
 */
class KelasRawatQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/
    public function active()
    {
        return $this->andWhere([KelasRawat::tableName().'.aktif'=>1]);
    }
    /**
     * {@inheritdoc}
     * @return KelasRawat[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return KelasRawat|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
