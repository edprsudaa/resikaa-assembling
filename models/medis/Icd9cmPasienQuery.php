<?php

namespace app\models\medis;

/**
 * This is the ActiveQuery class for [[Icd9cmPasien]].
 *
 * @see Icd9cmPasien
 */
class Icd9cmPasienQuery extends \yii\db\ActiveQuery
{
    public function init()
    {
        $this->andOnCondition([Icd9cmPasien::tableName().'.is_deleted'=>0]);
        parent::init();
    }

    /**
     * {@inheritdoc}
     * @return Icd9cmPasien[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Icd9cmPasien|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
