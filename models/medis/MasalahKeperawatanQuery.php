<?php

namespace app\models\medis;

/**
 * This is the ActiveQuery class for [[MasalahKeperawatan]].
 *
 * @see MasalahKeperawatan
 */
class MasalahKeperawatanQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return MasalahKeperawatan[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return MasalahKeperawatan|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
