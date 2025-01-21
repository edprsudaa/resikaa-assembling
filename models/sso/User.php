<?php

namespace app\models\sso;

use yii\base\NotSupportedException;

class User extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface
{
    const STATUS_ACTIVE = 0;
    const STATUS_INACTIVE = 1;

    public static function tableName()
    {
        return 'sso.akn_user';
    }
    public static function getDb()
    {
        return \Yii::$app->db_sso;
    }
    public static function findIdentity($id)
    {
        return static::findOne(['userid' => $id]);
    }
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username]);
    }
    public function getId()
    {
        return $this->getPrimaryKey();
    }
    public function getAuthKey()
    {
        return false;
    }
    public function validateAuthKey($authKey)
    {
        return true;
    }
    public function validatePassword($password)
    {
        return $this->password === md5($password);
    }
}
