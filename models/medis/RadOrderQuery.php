<?php

namespace app\models\medis;

/**
 * This is the ActiveQuery class for [[RadOrder]].
 *
 * @see RadOrder
 */
class RadOrderQuery extends \yii\db\ActiveQuery
{
    public function init()
    {
        $this->andOnCondition([RadOrder::tableName().'.is_deleted'=>0]);
        parent::init();
    }

    /**
     * {@inheritdoc}
     * @return RadOrder[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return RadOrder|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
