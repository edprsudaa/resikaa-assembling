<?php

namespace app\models\medis;

/**
 * This is the ActiveQuery class for [[JadwalDokterKlinik]].
 *
 * @see JadwalDokterKlinik
 */
class JadwalDokterKlinikQuery extends \yii\db\ActiveQuery
{
    public function init()
    {
        $this->andOnCondition([JadwalDokterKlinik::tableName().'.is_deleted'=>0]);
        parent::init();
    }

    /**
     * {@inheritdoc}
     * @return JadwalDokterKlinik[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return JadwalDokterKlinik|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
