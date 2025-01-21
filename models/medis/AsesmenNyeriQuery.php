<?php

namespace app\models\medis;

/**
 * This is the ActiveQuery class for [[AsesmenNyeri]].
 *
 * @see AsesmenNyeri
 */
class AsesmenNyeriQuery extends \yii\db\ActiveQuery
{
    public function init()
    {
        $this->andOnCondition([AsesmenNyeri::tableName().'.is_deleted'=>0]);
        parent::init();
    }
    public function batal()
    {
        return $this->andWhere([AsesmenNyeri::tableName().'.batal'=>1]);
    }
    public function nobatal()
    {
        return $this->andWhere([AsesmenNyeri::tableName().'.batal'=>0]);
    }

    /**
     * {@inheritdoc}
     * @return AsesmenNyeri[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return AsesmenNyeri|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
