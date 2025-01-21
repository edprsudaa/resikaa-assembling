<?php

namespace app\models\medis;

/**
 * This is the ActiveQuery class for [[Icd10cm]].
 *
 * @see Icd10cm
 */
class Icd10cmv2Query extends \yii\db\ActiveQuery
{
    public function init()
    {
        $this->andOnCondition([Icd10cmv2::tableName().'.is_deleted'=>0]);
        parent::init();
    }

    /**
     * {@inheritdoc}
     * @return Icd10cm[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Icd10cm|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
