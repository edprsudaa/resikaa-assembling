<?php

namespace app\models\medis;

/**
 * This is the ActiveQuery class for [[Pjp]].
 *
 * @see Pjp
 */
class PjpQuery extends \yii\db\ActiveQuery
{
    public function init()
    {
        $this->andOnCondition([Pjp::tableName().'.is_deleted'=>0]);
        parent::init();
    }

    /**
     * {@inheritdoc}
     * @return Pjp[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Pjp|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
