<?php

namespace app\models\medis;

/**
 * This is the ActiveQuery class for [[JawabanKonsultasi]].
 *
 * @see JawabanKonsultasi
 */
class JawabanKonsultasiQuery extends \yii\db\ActiveQuery
{
    public function init()
    {
        $this->andOnCondition([JawabanKonsultasi::tableName().'.is_deleted'=>0]);
        parent::init();
    }

    /**
     * {@inheritdoc}
     * @return JawabanKonsultasi[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return JawabanKonsultasi|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
