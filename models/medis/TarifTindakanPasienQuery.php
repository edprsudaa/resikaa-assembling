<?php

namespace app\models\medis;

/**
 * This is the ActiveQuery class for [[TarifTindakanPasien]].
 *
 * @see TarifTindakanPasien
 */
class TarifTindakanPasienQuery extends \yii\db\ActiveQuery
{
    public function init()
    {
        $this->andOnCondition([TarifTindakanPasien::tableName().'.is_deleted'=>0]);
        parent::init();
    }

    /**
     * {@inheritdoc}
     * @return TarifTindakanPasien[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return TarifTindakanPasien|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
