<?php

namespace app\models\medis;

/**
 * This is the ActiveQuery class for [[AsesmenHemodialisaDetail]].
 *
 * @see AsesmenHemodialisaDetail
 */
class AsesmenHemodialisaDetailQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/
    public function init()
    {
        $this->andOnCondition([AsesmenHemodialisaDetail::tableName().'.is_deleted'=>0]);
        parent::init();
    }
    /**
     * {@inheritdoc}
     * @return AsesmenHemodialisaDetail[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return AsesmenHemodialisaDetail|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
