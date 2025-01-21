<?php

namespace app\models\pegawai;

/**
 * This is the ActiveQuery class for [[TbPegawai]].
 *
 * @see TbPegawai
 */
class TbPegawaiQuery extends \yii\db\ActiveQuery
{
    public function active($status=1)
    {
        return $this->andOnCondition([TbPegawai::tableName().'.status_aktif_pegawai' => $status]);
    }

    /**
     * {@inheritdoc}
     * @return TbPegawai[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return TbPegawai|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
