<?php

namespace app\models\medis;

/**
 * This is the ActiveQuery class for [[Resep]].
 *
 * @see Resep
 */
class ResepQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/
    public function init()
    {
        $this->andOnCondition([Resep::tableName().'.is_deleted'=>0]);
        parent::init();
    }
    /**
     * {@inheritdoc}
     * @return Resep[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Resep|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
