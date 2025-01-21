<?php

namespace app\models\medis;

/**
 * This is the ActiveQuery class for [[AsesmenAwalKeperawatanGeneral]].
 *
 * @see AsesmenAwalKeperawatanGeneral
 */
class AsesmenAwalKeperawatanGeneralQuery extends \yii\db\ActiveQuery
{
    public function init()
    {
        $this->andOnCondition([AsesmenAwalKeperawatanGeneral::tableName().'.is_deleted'=>0]);
        parent::init();
    }
    public function batal()
    {
        return $this->andWhere([AsesmenAwalKeperawatanGeneral::tableName().'.batal'=>1]);
    }
    public function nobatal()
    {
        return $this->andWhere([AsesmenAwalKeperawatanGeneral::tableName().'.batal'=>0]);
    }
    public function draf()
    {
        return $this->andWhere([AsesmenAwalKeperawatanGeneral::tableName().'.draf'=>1]);
    }
    public function nodraf()
    {
        return $this->andWhere([AsesmenAwalKeperawatanGeneral::tableName().'.draf'=>0]);
    }

    /**
     * {@inheritdoc}
     * @return AsesmenAwalKeperawatanGeneral[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return AsesmenAwalKeperawatanGeneral|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
