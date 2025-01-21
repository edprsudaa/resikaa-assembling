<?php

namespace app\models\medis;

/**
 * This is the ActiveQuery class for [[AsesmenDownScoreIpn]].
 *
 * @see AsesmenDownScoreIpn
 */
class AsesmenDownScoreIpnQuery extends \yii\db\ActiveQuery
{
    public function init()
    {
        $this->andOnCondition([AsesmenDownScoreIpn::tableName().'.is_deleted'=>0]);
        parent::init();
    }
    public function batal()
    {
        return $this->andWhere([AsesmenDownScoreIpn::tableName().'.batal'=>1]);
    }
    public function nobatal()
    {
        return $this->andWhere([AsesmenDownScoreIpn::tableName().'.batal'=>0]);
    }

    /**
     * {@inheritdoc}
     * @return AsesmenDownScoreIpn[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return AsesmenDownScoreIpn|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
