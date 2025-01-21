<?php

namespace app\models\medis;

/**
 * This is the ActiveQuery class for [[ResepDetail]].
 *
 * @see ResepDetail
 */
class ResepDetailQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/
    public function init()
    {
        $this->andOnCondition([ResepDetail::tableName().'.is_deleted'=>0]);
        parent::init();
    }
    /**
     * {@inheritdoc}
     * @return ResepDetail[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return ResepDetail|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
