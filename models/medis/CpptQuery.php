<?php

namespace app\models\medis;

/**
 * This is the ActiveQuery class for [[Cppt]].
 *
 * @see Cppt
 */
class CpptQuery extends \yii\db\ActiveQuery
{
    public function init()
    {
        $this->andOnCondition([Cppt::tableName().'.is_deleted'=>0]);
        parent::init();
    }
    public function batal()
    {
        return $this->andWhere([Cppt::tableName().'.batal'=>1]);
    }
    public function nobatal()
    {
        return $this->andWhere([Cppt::tableName().'.batal'=>0]);
    }
    public function draf()
    {
        return $this->andWhere([Cppt::tableName().'.draf'=>1]);
    }
    public function nodraf()
    {
        return $this->andWhere([Cppt::tableName().'.draf'=>0]);
    }
    /**
     * {@inheritdoc}
     * @return Cppt[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Cppt|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
