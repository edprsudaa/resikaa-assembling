<?php

namespace app\models\medis;

/**
 * This is the ActiveQuery class for [[IntervensiKeperawatanPasien]].
 *
 * @see IntervensiKeperawatanPasien
 */
class IntervensiKeperawatanPasienQuery extends \yii\db\ActiveQuery
{
    public function init()
    {
        $this->andOnCondition([IntervensiKeperawatanPasien::tableName().'.is_deleted'=>0]);
        parent::init();
    }
    public function batal()
    {
        return $this->andWhere([IntervensiKeperawatanPasien::tableName().'.batal'=>1]);
    }
    public function nobatal()
    {
        return $this->andWhere([IntervensiKeperawatanPasien::tableName().'.batal'=>0]);
    }
    /**
     * {@inheritdoc}
     * @return IntervensiKeperawatanPasien[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return IntervensiKeperawatanPasien|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
