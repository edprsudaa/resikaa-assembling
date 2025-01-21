<?php

namespace app\models\medis;

/**
 * This is the ActiveQuery class for [[AsesmenAwalNeonatus]].
 *
 * @see AsesmenAwalNeonatus
 */
class RehabMedikQuery extends \yii\db\ActiveQuery
{
    public function init()
    {
        $this->andOnCondition([RehabMedik::tableName().'.is_deleted'=>0]);
        parent::init();
    }
    public function batal()
    {
        return $this->andWhere([RehabMedik::tableName().'.batal'=>1]);
    }
    public function nobatal()
    {
        return $this->andWhere([RehabMedik::tableName().'.batal'=>0]);
    }
    public function draf()
    {
        return $this->andWhere([RehabMedik::tableName().'.draf'=>1]);
    }
    public function nodraf()
    {
        return $this->andWhere([RehabMedik::tableName().'.draf'=>0]);
    }

    /**
     * {@inheritdoc}
     * @return RehabMedik[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return RehabMedik|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
