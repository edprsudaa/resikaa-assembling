<?php

namespace app\models\medis;

/**
 * This is the ActiveQuery class for [[SkTarif]].
 *
 * @see SkTarif
 */
class SkTarifQuery extends \yii\db\ActiveQuery
{
    // public function init()
    // {
    //     $this->andOnCondition([SkTarif::tableName().'.is_deleted'=>0]);
    //     parent::init();
    // }
    public function active()
    {
        return $this->andWhere([SkTarif::tableName().'.aktif'=>1]);
    }
    /**
     * {@inheritdoc}
     * @return SkTarif[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return SkTarif|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
