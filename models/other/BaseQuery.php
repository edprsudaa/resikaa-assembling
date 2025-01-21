<?php
namespace app\models\other;
use Yii;
class BaseQuery extends \yii\db\ActiveQuery
{
    public function deleted()
    {
        return $this->andWhere('is_deleted=1');
    }
    public function not_deleted()
    {
        return $this->andWhere('is_deleted=0');
    }
    public function active()
    {
        return $this->andWhere("is_active=1");
    }
    public function not_active()
    {
        return $this->andWhere("is_active=0");
    }
    public function cancel()
    {
        return $this->andWhere("is_cancel=0");
    }
    public function not_cancel()
    {
        return $this->andWhere("is_cancel=1");
    }
    public function final()
    {
        return $this->andWhere("is_final=1");
    }
    public function not_final()
    {
        return $this->andWhere("is_final=0");
    }
    public function all($db = null)
    {
        return parent::all($db);
    }
    public function one($db = null)
    {
        return parent::one($db);
    }
    // public function init()
    // {
    //     $this->andOnCondition(['deleted' => false]);
    //     parent::init();
    // }

    // // ... add customized query methods here ...

    // public function active($state = true)
    // {
    //     return $this->andOnCondition(['active' => $state]);
    // }
}