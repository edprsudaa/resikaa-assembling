<?php

namespace app\models\pegawai;

/**
 * This is the ActiveQuery class for [[TbRiwayatSipp]].
 *
 * @see TbRiwayatSipp
 */
class TbRiwayatSippQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return TbRiwayatSipp[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return TbRiwayatSipp|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
