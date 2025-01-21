<?php

namespace app\models\medis;

/**
 * This is the ActiveQuery class for [[AsesmenResikoDekubitus]].
 *
 * @see AsesmenResikoDekubitus
 */
class AsesmenResikoDekubitusQuery extends \yii\db\ActiveQuery
{
    public function init()
    {
        $this->andOnCondition([AsesmenResikoDekubitus::tableName().'.is_deleted'=>0]);
        parent::init();
    }
    public function batal()
    {
        return $this->andWhere([AsesmenResikoDekubitus::tableName().'.batal'=>1]);
    }
    public function nobatal()
    {
        return $this->andWhere([AsesmenResikoDekubitus::tableName().'.batal'=>0]);
    }

    /**
     * {@inheritdoc}
     * @return AsesmenResikoDekubitus[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return AsesmenResikoDekubitus|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
