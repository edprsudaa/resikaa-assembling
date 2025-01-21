<?php

namespace app\models\medis;

/**
 * This is the ActiveQuery class for [[Dpjp]].
 *
 * @see Dpjp
 */
class DpjpQuery extends \yii\db\ActiveQuery
{
    public function init()
    {
        $this->andOnCondition([Dpjp::tableName().'.is_deleted'=>0]);
        parent::init();
    }

    /**
     * {@inheritdoc}
     * @return Dpjp[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Dpjp|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
