<?php

namespace app\models\medis;

/**
 * This is the ActiveQuery class for [[AsesmenAwalKebidanan]].
 *
 * @see AsesmenAwalKebidanan
 */
class AsesmenAwalKebidananQuery extends \yii\db\ActiveQuery
{
    public function init()
    {
        $this->andOnCondition([AsesmenAwalKebidanan::tableName().'.is_deleted'=>0]);
        parent::init();
    }
    public function batal()
    {
        return $this->andWhere([AsesmenAwalKebidanan::tableName().'.batal'=>1]);
    }
    public function nobatal()
    {
        return $this->andWhere([AsesmenAwalKebidanan::tableName().'.batal'=>0]);
    }
    public function draf()
    {
        return $this->andWhere([AsesmenAwalKebidanan::tableName().'.draf'=>1]);
    }
    public function nodraf()
    {
        return $this->andWhere([AsesmenAwalKebidanan::tableName().'.draf'=>0]);
    }

    /**
     * {@inheritdoc}
     * @return AsesmenAwalKebidanan[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return AsesmenAwalKebidanan|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
