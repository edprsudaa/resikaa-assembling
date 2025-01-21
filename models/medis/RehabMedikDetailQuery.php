<?php

namespace app\models\medis;

/**
 * This is the ActiveQuery class for [[RehabMedikDetail]].
 *
 * @see RehabMedikDetail
 */
class RehabMedikDetailQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/
    public function init()
    {
        $this->andOnCondition([RehabMedikDetail::tableName().'.is_deleted'=>0]);
        parent::init();
    }
    /**
     * {@inheritdoc}
     * @return RehabMedikDetail[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return RehabMedikDetail|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
