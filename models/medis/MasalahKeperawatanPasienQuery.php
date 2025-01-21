<?php

namespace app\models\medis;

/**
 * This is the ActiveQuery class for [[MasalahKeperawatanPasien]].
 *
 * @see MasalahKeperawatanPasien
 */
class MasalahKeperawatanPasienQuery extends \yii\db\ActiveQuery
{
    public function init()
    {
        $this->andOnCondition([MasalahKeperawatanPasien::tableName().'.is_deleted'=>0]);
        parent::init();
    }
    public function batal()
    {
        return $this->andWhere([MasalahKeperawatanPasien::tableName().'.batal'=>1]);
    }
    public function nobatal()
    {
        return $this->andWhere([MasalahKeperawatanPasien::tableName().'.batal'=>0]);
    }

    /**
     * {@inheritdoc}
     * @return MasalahKeperawatanPasien[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return MasalahKeperawatanPasien|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
