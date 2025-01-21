<?php

namespace app\models\pegawai;

/**
 * This is the ActiveQuery class for [[TbRiwayatPenempatan]].
 *
 * @see TbRiwayatPenempatan
 */
class TbRiwayatPenempatanQuery extends \yii\db\ActiveQuery
{
    public function active()
    {
        return $this->andWhere([TbRiwayatPenempatan::tableName().'.status_aktif'=>1]);
    }

    /**
     * {@inheritdoc}
     * @return TbRiwayatPenempatan[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return TbRiwayatPenempatan|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }    
}
