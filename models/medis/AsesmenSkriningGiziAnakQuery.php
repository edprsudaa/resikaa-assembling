<?php

namespace app\models\medis;

/**
 * This is the ActiveQuery class for [[AsesmenSkriningGiziAnak]].
 *
 * @see AsesmenSkriningGiziAnak
 */
class AsesmenSkriningGiziAnakQuery extends \yii\db\ActiveQuery
{
    public function init()
    {
        $this->andOnCondition([AsesmenSkriningGiziAnak::tableName().'.is_deleted'=>0]);
        parent::init();
    }
    public function batal()
    {
        return $this->andWhere([AsesmenSkriningGiziAnak::tableName().'.batal'=>1]);
    }
    public function nobatal()
    {
        return $this->andWhere([AsesmenSkriningGiziAnak::tableName().'.batal'=>0]);
    }

    /**
     * {@inheritdoc}
     * @return AsesmenSkriningGiziAnak[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return AsesmenSkriningGiziAnak|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
