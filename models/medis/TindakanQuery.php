<?php

namespace app\models\medis;

/**
 * This is the ActiveQuery class for [[Tindakan]].
 *
 * @see Tindakan
 */
class TindakanQuery extends \yii\db\ActiveQuery
{
    // public function init()
    // {
    //     $this->andOnCondition([Tindakan::tableName().'.is_deleted'=>0]);
    //     parent::init();
    // }
    public function active()
    {
        return $this->andWhere([Tindakan::tableName().'.aktif'=>1]);
    }
    /**
     * {@inheritdoc}
     * @return Tindakan[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Tindakan|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
