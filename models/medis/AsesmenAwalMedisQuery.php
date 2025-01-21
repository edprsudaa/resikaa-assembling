<?php

namespace app\models\medis;

/**
 * This is the ActiveQuery class for [[AsesmenAwalMedis]].
 *
 * @see AsesmenAwalMedis
 */
class AsesmenAwalMedisQuery extends \yii\db\ActiveQuery
{
    public function init()
    {
        $this->andOnCondition([AsesmenAwalMedis::tableName().'.is_deleted'=>0]);
        parent::init();
    }
    public function batal()
    {
        return $this->andWhere([AsesmenAwalMedis::tableName().'.batal'=>1]);
    }
    public function nobatal()
    {
        return $this->andWhere([AsesmenAwalMedis::tableName().'.batal'=>0]);
    }
    public function draf()
    {
        return $this->andWhere([AsesmenAwalMedis::tableName().'.draf'=>1]);
    }
    public function nodraf()
    {
        return $this->andWhere([AsesmenAwalMedis::tableName().'.draf'=>0]);
    }
    /**
     * {@inheritdoc}
     * @return AsesmenAwalMedis[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return AsesmenAwalMedis|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
