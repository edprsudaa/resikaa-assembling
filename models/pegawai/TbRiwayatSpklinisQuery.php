<?php

namespace app\models\pegawai;

/**
 * This is the ActiveQuery class for [[TbRiwayatSpklinis]].
 *
 * @see TbRiwayatSpklinis
 */
class TbRiwayatSpklinisQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return TbRiwayatSpklinis[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return TbRiwayatSpklinis|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
