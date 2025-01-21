<?php

namespace app\models\medis;

/**
 * This is the ActiveQuery class for [[AsesmenAwalNeonatus]].
 *
 * @see AsesmenAwalNeonatus
 */
class AsesmenHemodialisaDokterLanjutanQuery extends \yii\db\ActiveQuery
{
    public function init()
    {
        $this->andOnCondition([AsesmenHemodialisaDokterLanjutan::tableName().'.is_deleted'=>0]);
        parent::init();
    }
    public function batal()
    {
        return $this->andWhere([AsesmenHemodialisaDokterLanjutan::tableName().'.batal'=>1]);
    }
    public function nobatal()
    {
        return $this->andWhere([AsesmenHemodialisaDokterLanjutan::tableName().'.batal'=>0]);
    }
    public function draf()
    {
        return $this->andWhere([AsesmenHemodialisaDokterLanjutan::tableName().'.draf'=>1]);
    }
    public function nodraf()
    {
        return $this->andWhere([AsesmenHemodialisaDokterLanjutan::tableName().'.draf'=>0]);
    }

    /**
     * {@inheritdoc}
     * @return AsesmenHemodialisaDokterLanjutan[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return AsesmenHemodialisaDokterLanjutan|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
