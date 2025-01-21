<?php

namespace app\models\pegawai;

/**
 * This is the ActiveQuery class for [[TbRiwayatStr]].
 *
 * @see TbRiwayatStr
 */
class TbRiwayatStrQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return TbRiwayatStr[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return TbRiwayatStr|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
