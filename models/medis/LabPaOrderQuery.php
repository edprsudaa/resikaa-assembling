<?php

namespace app\models\medis;

/**
 * This is the ActiveQuery class for [[LabPaOrder]].
 *
 * @see LabPaOrder
 */
class LabPaOrderQuery extends \yii\db\ActiveQuery
{
    public function init()
    {
        $this->andOnCondition([LabPaOrder::tableName().'.is_deleted'=>0]);
        parent::init();
    }

    /**
     * {@inheritdoc}
     * @return LabPaOrder[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return LabPaOrder|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
