<?php

namespace app\models\medis;

/**
 * This is the ActiveQuery class for [[AsesmenHemodialisis]].
 *
 * @see AsesmenHemodialisis
 */
class AsesmenHemodialisisQuery extends \yii\db\ActiveQuery
{
    public function init()
    {
        $this->andOnCondition([AsesmenHemodialisis::tableName().'.is_deleted'=>0]);
        parent::init();
    }
    public function batal()
    {
        return $this->andWhere([AsesmenHemodialisis::tableName().'.batal'=>1]);
    }
    public function nobatal()
    {
        return $this->andWhere([AsesmenHemodialisis::tableName().'.batal'=>0]);
    }
    public function draf()
    {
        return $this->andWhere([AsesmenHemodialisis::tableName().'.draf'=>1]);
    }
    public function nodraf()
    {
        return $this->andWhere([AsesmenHemodialisis::tableName().'.draf'=>0]);
    }
    /**
     * {@inheritdoc}
     * @return AsesmenHemodialisis[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return AsesmenHemodialisis|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
