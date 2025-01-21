<?php

namespace app\models\pendaftaran;

class LayananQuery extends \yii\db\ActiveQuery
{
    public function init()
    {
        // $this->andOnCondition(Layanan::tableName().'.deleted_at is null');
        parent::init();
    }
    public function all($db = null)
    {
        return parent::all($db);
    }
    public function one($db = null)
    {
        return parent::one($db);
    }
}
