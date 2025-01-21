<?php

namespace app\models\medis;

/**
 * This is the ActiveQuery class for [[LabPkOrder]].
 *
 * @see LabPkOrder
 */
class LabPkOrderQuery extends \yii\db\ActiveQuery
{
    public function init()
    {
        $this->andOnCondition([LabPkOrder::tableName().'.is_deleted'=>0]);
        parent::init();
    }

    /**
     * {@inheritdoc}
     * @return LabPkOrder[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return LabPkOrder|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
