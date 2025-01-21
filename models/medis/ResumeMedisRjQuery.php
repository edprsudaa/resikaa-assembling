<?php

namespace app\models\medis;

/**
 * This is the ActiveQuery class for [[ResumeMedisRi]].
 *
 * @see ResumeMedisRi
 */
class ResumeMedisRjQuery extends \yii\db\ActiveQuery
{
    public function init()
    {
        $this->andOnCondition([ResumeMedisRj::tableName().'.is_deleted'=>0]);
        parent::init();
    }
    public function batal()
    {
        return $this->andWhere([ResumeMedisRj::tableName().'.batal'=>1]);
    }
    public function nobatal()
    {
        return $this->andWhere([ResumeMedisRj::tableName().'.batal'=>0]);
    }
    public function draf()
    {
        return $this->andWhere([ResumeMedisRj::tableName().'.draf'=>1]);
    }
    public function nodraf()
    {
        return $this->andWhere([ResumeMedisRj::tableName().'.draf'=>0]);
    }
    /**
     * {@inheritdoc}
     * @return ResumeMedisRi[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return ResumeMedisRi|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
