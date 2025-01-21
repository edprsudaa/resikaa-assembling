<?php

namespace app\models\medis;

/**
 * This is the ActiveQuery class for [[TarifTindakan]].
 *
 * @see TarifTindakan
 */
class TarifTindakanQuery extends \yii\db\ActiveQuery
{
    // public function init()
    // {
    //     $this->andOnCondition([TarifTindakan::tableName().'.is_deleted'=>0]);
    //     parent::init();
    // }
    /**
     * {@inheritdoc}
     * @return TarifTindakan[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return TarifTindakan|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
