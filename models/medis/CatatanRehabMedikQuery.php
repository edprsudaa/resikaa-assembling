<?php

namespace app\models\medis;

/**
 * This is the ActiveQuery class for [[AsesmenAwalNeonatus]].
 *
 * @see AsesmenAwalNeonatus
 */
class CatatanRehabMedikQuery extends \yii\db\ActiveQuery
{
    public function init()
    {
        $this->andOnCondition([CatatanRehabMedik::tableName().'.is_deleted'=>0]);
        parent::init();
    }
    public function batal()
    {
        return $this->andWhere([CatatanRehabMedik::tableName().'.batal'=>1]);
    }
    public function nobatal()
    {
        return $this->andWhere([CatatanRehabMedik::tableName().'.batal'=>0]);
    }
    public function draf()
    {
        return $this->andWhere([CatatanRehabMedik::tableName().'.draf'=>1]);
    }
    public function nodraf()
    {
        return $this->andWhere([CatatanRehabMedik::tableName().'.draf'=>0]);
    }

    /**
     * {@inheritdoc}
     * @return CatatanRehabMedik[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return CatatanRehabMedik|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
