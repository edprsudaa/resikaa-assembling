<?php

namespace app\models\medis;

/**
 * This is the ActiveQuery class for [[AsesmenAwalKebidananRiwayatKehamilan]].
 *
 * @see AsesmenAwalKebidananRiwayatKehamilan
 */
class AsesmenAwalKebidananRiwayatKehamilanQuery extends \yii\db\ActiveQuery
{
    public function init()
    {
        $this->andOnCondition([AsesmenAwalKebidananRiwayatKehamilan::tableName().'.is_deleted'=>0]);
        parent::init();
    }
    /**
     * {@inheritdoc}
     * @return AsesmenAwalKebidananRiwayatKehamilan[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return AsesmenAwalKebidananRiwayatKehamilan|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
