<?php

namespace app\models\sip;

use Yii;
use yii\httpclient\Client;

class UnitSubPenempatan extends \yii\db\ActiveRecord
{

    public static function getDb()
    {
        return Yii::$app->get('db_simpeg');
    }

    public static function tableName()
    {
        return 'pegawai.dm_unit_sub_penempatan';
    }

    // /**
    //  * {@inheritdoc}
    //  * @return \app\models\pegawai\UnitQuery the active query used by this AR class.
    //  */
    // public static function find()
    // {
    //     return new \app\models\sip\UnitQuery(get_called_class());
    // }
    
}
