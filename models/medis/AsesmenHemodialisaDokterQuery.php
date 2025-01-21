<?php

namespace app\models\medis;

/**
 * This is the ActiveQuery class for [[AsesmenAwalNeonatus]].
 *
 * @see AsesmenAwalNeonatus
 */
class AsesmenHemodialisaDokterQuery extends \yii\db\ActiveQuery
{
    public function init()
    {
        $this->andOnCondition([AsesmenHemodialisaDokter::tableName().'.is_deleted'=>0]);
        parent::init();
    }
    public function batal()
    {
        return $this->andWhere([AsesmenHemodialisaDokter::tableName().'.batal'=>1]);
    }
    public function nobatal()
    {
        return $this->andWhere([AsesmenHemodialisaDokter::tableName().'.batal'=>0]);
    }
    public function draf()
    {
        return $this->andWhere([AsesmenHemodialisaDokter::tableName().'.draf'=>1]);
    }
    public function nodraf()
    {
        return $this->andWhere([AsesmenHemodialisaDokter::tableName().'.draf'=>0]);
    }

    /**
     * {@inheritdoc}
     * @return AsesmenHemodialisaDokter[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return AsesmenHemodialisaDokter|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
