<?php

namespace app\models\medis;

/**
 * This is the ActiveQuery class for [[Kamar]].
 *
 * @see Kamar
 */
class KamarQuery extends \yii\db\ActiveQuery
{
    public function init()
    {
        $this->andOnCondition([Kamar::tableName().'.is_deleted'=>0]);
        parent::init();
    }

    /**
     * {@inheritdoc}
     * @return Kamar[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Kamar|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
