<?php 

namespace app\models\sip;
use Yii;

class Golongan extends \yii\db\ActiveRecord
{

    public static function getDb()
    {
        return Yii::$app->get('db_simpeg');
    }

    public static function tableName()
    {
        return 'pegawai.dm_golongan';
    }
}