<?php

namespace app\models\medis;

/**
 * This is the ActiveQuery class for [[AsesmenResikoJatuh]].
 *
 * @see AsesmenResikoJatuh
 */
class AsesmenResikoJatuhQuery extends \yii\db\ActiveQuery
{
    public function init()
    {
        $this->andOnCondition([AsesmenResikoJatuh::tableName().'.is_deleted'=>0]);
        parent::init();
    }
    public function batal()
    {
        return $this->andWhere([AsesmenResikoJatuh::tableName().'.batal'=>1]);
    }
    public function nobatal()
    {
        return $this->andWhere([AsesmenResikoJatuh::tableName().'.batal'=>0]);
    }

    /**
     * {@inheritdoc}
     * @return AsesmenResikoJatuh[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return AsesmenResikoJatuh|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
