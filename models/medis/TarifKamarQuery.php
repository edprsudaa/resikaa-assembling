<?php

namespace app\models\medis;

/**
 * This is the ActiveQuery class for [[TarifKamar]].
 *
 * @see TarifKamar
 */
class TarifKamarQuery extends \yii\db\ActiveQuery
{
    public function init()
    {
        $this->andOnCondition([TarifKamar::tableName().'.is_deleted'=>0]);
        parent::init();
    }

    /**
     * {@inheritdoc}
     * @return TarifKamar[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return TarifKamar|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
