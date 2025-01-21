<?php

namespace app\models\medis;

/**
 * This is the ActiveQuery class for [[PjpRi]].
 *
 * @see PjpRi
 */
class PjpRiQuery extends \yii\db\ActiveQuery
{
    public function init()
    {
        $this->andOnCondition([PjpRi::tableName().'.is_deleted'=>0]);
        parent::init();
    }

    /**
     * {@inheritdoc}
     * @return PjpRi[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return PjpRi|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
