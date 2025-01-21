<?php

namespace app\models\medis;

/**
 * This is the ActiveQuery class for [[TriasePasien]].
 *
 * @see TriasePasien
 */
class TriasePasienQuery extends \yii\db\ActiveQuery
{
    public function init()
    {
        $this->andOnCondition([TriasePasien::tableName().'.is_deleted'=>0]);
        parent::init();
    }
    public function batal()
    {
        return $this->andWhere([TriasePasien::tableName().'.batal'=>1]);
    }
    public function nobatal()
    {
        return $this->andWhere([TriasePasien::tableName().'.batal'=>0]);
    }
    /**
     * {@inheritdoc}
     * @return TriasePasien[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return TriasePasien|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
