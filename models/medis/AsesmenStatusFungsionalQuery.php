<?php

namespace app\models\medis;

/**
 * This is the ActiveQuery class for [[AsesmenStatusFungsional]].
 *
 * @see AsesmenStatusFungsional
 */
class AsesmenStatusFungsionalQuery extends \yii\db\ActiveQuery
{
    public function init()
    {
        $this->andOnCondition([AsesmenStatusFungsional::tableName().'.is_deleted'=>0]);
        parent::init();
    }
    public function batal()
    {
        return $this->andWhere([AsesmenStatusFungsional::tableName().'.batal'=>1]);
    }
    public function nobatal()
    {
        return $this->andWhere([AsesmenStatusFungsional::tableName().'.batal'=>0]);
    }

    /**
     * {@inheritdoc}
     * @return AsesmenStatusFungsional[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return AsesmenStatusFungsional|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
