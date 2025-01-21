<?php

namespace app\models\medis;

/**
 * This is the ActiveQuery class for [[AsesmenAwalKeperawatanNeonatus]].
 *
 * @see AsesmenAwalKeperawatanNeonatus
 */
class AsesmenAwalKeperawatanNeonatusQuery extends \yii\db\ActiveQuery
{
    public function init()
    {
        $this->andOnCondition([AsesmenAwalKeperawatanNeonatus::tableName().'.is_deleted'=>0]);
        parent::init();
    }
    public function batal()
    {
        return $this->andWhere([AsesmenAwalKeperawatanNeonatus::tableName().'.batal'=>1]);
    }
    public function nobatal()
    {
        return $this->andWhere([AsesmenAwalKeperawatanNeonatus::tableName().'.batal'=>0]);
    }
    public function draf()
    {
        return $this->andWhere([AsesmenAwalKeperawatanNeonatus::tableName().'.draf'=>1]);
    }
    public function nodraf()
    {
        return $this->andWhere([AsesmenAwalKeperawatanNeonatus::tableName().'.draf'=>0]);
    }

    /**
     * {@inheritdoc}
     * @return AsesmenAwalKeperawatanNeonatus[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return AsesmenAwalKeperawatanNeonatus|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
