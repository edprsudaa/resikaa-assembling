<?php

namespace app\models\medis;

/**
 * This is the ActiveQuery class for [[DietPasien]].
 *
 * @see DietPasien
 */
class DietPasienQuery extends \yii\db\ActiveQuery
{
    public function init()
    {
        $this->andOnCondition([DietPasien::tableName().'.is_deleted'=>0]);
        parent::init();
    }
    public function batal()
    {
        return $this->andWhere([DietPasien::tableName().'.batal'=>1]);
    }
    public function nobatal()
    {
        return $this->andWhere([DietPasien::tableName().'.batal'=>0]);
    }
    /**
     * {@inheritdoc}
     * @return DietPasien[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return DietPasien|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
