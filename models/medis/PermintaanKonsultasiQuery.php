<?php

namespace app\models\medis;

/**
 * This is the ActiveQuery class for [[PermintaanKonsultasi]].
 *
 * @see PermintaanKonsultasi
 */
class PermintaanKonsultasiQuery extends \yii\db\ActiveQuery
{
    public function init()
    {
        $this->andOnCondition([PermintaanKonsultasi::tableName().'.is_deleted'=>0]);
        parent::init();
    }
    public function batal()
    {
        return $this->andWhere([PermintaanKonsultasi::tableName().'.batal'=>1]);
    }
    public function nobatal()
    {
        return $this->andWhere([PermintaanKonsultasi::tableName().'.batal'=>0]);
    }
    /**
     * {@inheritdoc}
     * @return PermintaanKonsultasi[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return PermintaanKonsultasi|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
