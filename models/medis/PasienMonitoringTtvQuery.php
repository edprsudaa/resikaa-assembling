<?php

namespace app\models\medis;

/**
 * This is the ActiveQuery class for [[AsesmenAwalNeonatus]].
 *
 * @see 
 */
class PasienMonitoringTtvQuery extends \yii\db\ActiveQuery
{
    public function init()
    {
        $this->andOnCondition([PasienMonitoringTtv::tableName() . '.is_deleted' => 0]);
        parent::init();
    }
    public function batal()
    {
        return $this->andWhere([PasienMonitoringTtv::tableName() . '.batal' => 1]);
    }
    public function nobatal()
    {
        return $this->andWhere([PasienMonitoringTtv::tableName() . '.batal' => 0]);
    }
    public function draf()
    {
        return $this->andWhere([PasienMonitoringTtv::tableName() . '.draf' => 1]);
    }
    public function nodraf()
    {
        return $this->andWhere([PasienMonitoringTtv::tableName() . '.draf' => 0]);
    }

    /**
     * {@inheritdoc}
     * @return PasienMonitoringTtv[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return PasienMonitoringTtv|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
