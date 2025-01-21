<?php

namespace app\models\medis;

/**
 * This is the ActiveQuery class for [[Icd10cmPasien]].
 *
 * @see Icd10cmPasien
 */
class Icd10cmv2PasienQuery extends \yii\db\ActiveQuery
{
    public function init()
    {
        $this->andOnCondition([Icd10cmv2Pasien::tableName().'.is_deleted'=>0]);
        parent::init();
    }
    public function batal()
    {
        return $this->andWhere([Icd10cmv2Pasien::tableName().'.batal'=>1]);
    }
    public function nobatal()
    {
        return $this->andWhere([Icd10cmv2Pasien::tableName().'.batal'=>0]);
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
