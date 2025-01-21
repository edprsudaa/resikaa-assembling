<?php

namespace app\models\medis;

/**
 * This is the ActiveQuery class for [[Dpjpri]].
 *
 * @see Dpjpri
 */
class DpjpriQuery extends \yii\db\ActiveQuery
{
    public function init()
    {
        $this->andOnCondition([Dpjpri::tableName().'.is_deleted'=>0]);
        parent::init();
    }

    /**
     * {@inheritdoc}
     * @return Dpjpri[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Dpjpri|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
