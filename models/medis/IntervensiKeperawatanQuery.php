<?php

namespace app\models\medis;

/**
 * This is the ActiveQuery class for [[IntervensiKeperawatan]].
 *
 * @see IntervensiKeperawatan
 */
class IntervensiKeperawatanQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return IntervensiKeperawatan[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return IntervensiKeperawatan|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
