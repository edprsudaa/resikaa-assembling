<?php

namespace app\models\medis;

/**
 * This is the ActiveQuery class for [[AsesmenAwalNeonatus]].
 *
 * @see AsesmenAwalNeonatus
 */
class PenjadwalanRehabMedikQuery extends \yii\db\ActiveQuery
{
    public function init()
    {
        $this->andOnCondition([PenjadwalanRehabMedik::tableName().'.is_deleted'=>0]);
        parent::init();
    }
    public function batal()
    {
        return $this->andWhere([PenjadwalanRehabMedik::tableName().'.batal'=>1]);
    }
    public function nobatal()
    {
        return $this->andWhere([PenjadwalanRehabMedik::tableName().'.batal'=>0]);
    }
    public function draf()
    {
        return $this->andWhere([PenjadwalanRehabMedik::tableName().'.draf'=>1]);
    }
    public function nodraf()
    {
        return $this->andWhere([PenjadwalanRehabMedik::tableName().'.draf'=>0]);
    }

    /**
     * {@inheritdoc}
     * @return PenjadwalanRehabMedik[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return PenjadwalanRehabMedik|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
