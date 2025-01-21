<?php

namespace app\models\medis;

/**
 * This is the ActiveQuery class for [[Icd10cmPasien]].
 *
 * @see Icd10cmPasien
 */
class Icd10cmPasienQuery extends \yii\db\ActiveQuery
{
    public function init()
    {
        $this->andOnCondition([Icd10cmPasien::tableName().'.is_deleted'=>0]);
        parent::init();
    }

    /**
     * {@inheritdoc}
     * @return Icd10cmPasien[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Icd10cmPasien|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
