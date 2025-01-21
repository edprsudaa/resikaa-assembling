<?php

namespace app\models\medis;

/**
 * This is the ActiveQuery class for [[LabPkOrderDetail]].
 *
 * @see LabPkOrderDetail
 */
class LabPkOrderDetailQuery extends \yii\db\ActiveQuery
{
    public function init()
    {
        $this->andOnCondition([LabPkOrderDetail::tableName().'.is_deleted'=>0]);
        parent::init();
    }

    /**
     * {@inheritdoc}
     * @return LabPkOrderDetail[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return LabPkOrderDetail|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
