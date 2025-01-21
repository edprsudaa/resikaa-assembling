<?php

namespace app\models\medis;

/**
 * This is the ActiveQuery class for [[AsesmenAwalNeonatus]].
 *
 * @see AsesmenAwalNeonatus
 */
class AsesmenHemodialisaQuery extends \yii\db\ActiveQuery
{
    public function init()
    {
        $this->andOnCondition([AsesmenHemodialisa::tableName().'.is_deleted'=>0]);
        parent::init();
    }
    public function batal()
    {
        return $this->andWhere([AsesmenHemodialisa::tableName().'.batal'=>1]);
    }
    public function nobatal()
    {
        return $this->andWhere([AsesmenHemodialisa::tableName().'.batal'=>0]);
    }
    public function draf()
    {
        return $this->andWhere([AsesmenHemodialisa::tableName().'.draf'=>1]);
    }
    public function nodraf()
    {
        return $this->andWhere([AsesmenHemodialisa::tableName().'.draf'=>0]);
    }

    /**
     * {@inheritdoc}
     * @return AsesmenHemodialisa[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return AsesmenHemodialisa|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
