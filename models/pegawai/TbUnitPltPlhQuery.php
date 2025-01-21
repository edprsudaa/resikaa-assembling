<?php

namespace app\models\pegawai;

/**
 * This is the ActiveQuery class for [[TbUnitPltPlh]].
 *
 * @see TbUnitPltPlh
 */
class TbUnitPltPlhQuery extends \yii\db\ActiveQuery
{
    public function active()
    {
        return $this->andWhere([TbUnitPltPlh::tableName().'.status'=>1]);
    }

    /**
     * {@inheritdoc}
     * @return TbUnitPltPlh[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return TbUnitPltPlh|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
