<?php

namespace app\models\medis;

/**
 * This is the ActiveQuery class for [[PenjadwalanRehabMedikDetail]].
 *
 * @see PenjadwalanRehabMedikDetail
 */
class PenjadwalanRehabMedikDetailQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/
    public function init()
    {
        // $this->andOnCondition([PenjadwalanRehabMedikDetail::tableName().'.is_deleted'=>0]);
        parent::init();
    }
    public function batal()
    {
        return $this->andWhere([PenjadwalanRehabMedikDetail::tableName().'.is_deleted'=>1]);
    }
    public function nobatal()
    {
        return $this->andWhere([PenjadwalanRehabMedikDetail::tableName().'.is_deleted'=>0]);
    }
   
    /**
     * {@inheritdoc}
     * @return PenjadwalanRehabMedikDetail[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return PenjadwalanRehabMedikDetail|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
