<?php

/**
 * RSUDAA
 * Copyright (c) 2020 by Ahmadfauzirahman
 * e: ahmadfauzirahman99[at]gmail[dot]com
 */

namespace app\models;


use Yii;
use yii\base\InvalidValueException;
use yii\web\IdentityInterface;

class User extends \yii\web\User
{
    protected function getIdentityAndDurationFromCookie()
    {
        Yii::info('Lihat jumlah Cookie => ' . Yii::$app->getRequest()->getCookies()->getCount(), __METHOD__);

        $value = Yii::$app->getRequest()->getCookies()->getValue($this->identityCookie['name']);
        //var_dump(Yii::$app->getRequest()->getCookies());
        //exit();
        if ($value === null) {
            //            echo 'asdadas';
            return null;
        }


        //        exit();
        Yii::info('Cookie ditemukan.', __METHOD__);

        $data = json_decode($value, true);
        if (count($data) == 3) {
            list($id, $authKey, $duration) = $data;
            $class = $this->identityClass;
            Yii::info('Cek Identity ke API dengan authKey = ' . $authKey . ' pake class ' . $class, __METHOD__);
            /* @var $class IdentityInterface */
            $identity = $class::findIdentityByAccessToken($authKey);
            if ($identity !== null) {
                if (!$identity instanceof IdentityInterface) {
                    Yii::info('Format Identity tidak bukan IdentityInterface.', __METHOD__);
                    throw new InvalidValueException("$class::findIdentity() must return an object implementing IdentityInterface.");
                } elseif ($identity->getId() != $id) {
                    Yii::info('AuthKey tidak sesuai.', __METHOD__);
                    Yii::warning("Invalid auth key attempted for user '$id': $authKey", __METHOD__);
                } else {
                    Yii::info('Identity ditemukan dengan durasi ' . $duration, __METHOD__);
                    return ['identity' => $identity, 'duration' => $duration];
                }
            }
            Yii::info('Identity Tidak ditemukan di API.', __METHOD__);
        }

        return null;
    }

    protected function renewAuthStatus()
    {
        $session = Yii::$app->getSession();
        $id = $session->getHasSessionId() || $session->getIsActive() ? $session->get($this->idParam) : null;

        Yii::info('Mulai Renew Status.', __METHOD__);

        if ($id === null) {
            Yii::info('Session Id = NULL', __METHOD__);
            $identity = null;
        } else {
            Yii::info('Cek Session, Id = ' . $id, __METHOD__);
            /* @var $class IdentityInterface */
            $class = $this->identityClass;
            $identity = $class::findIdentity($id);
            Yii::info('Identity diambil dari Session Id', __METHOD__);
        }

        $this->setIdentity($identity);

        if ($identity !== null && ($this->authTimeout !== null || $this->absoluteAuthTimeout !== null)) {
            Yii::info('Identity dari Session ditemukan', __METHOD__);
            $expire = $this->authTimeout !== null ? $session->get($this->authTimeoutParam) : null;
            $expireAbsolute = $this->absoluteAuthTimeout !== null ? $session->get($this->absoluteAuthTimeoutParam) : null;
            if ($expire !== null && $expire < time() || $expireAbsolute !== null && $expireAbsolute < time()) {
                Yii::info('Identity Logout', __METHOD__);
                $this->logout(false);
            } elseif ($this->authTimeout !== null) {
                Yii::info('Identity Renew Auth Status.', __METHOD__);
                $session->set($this->authTimeoutParam, time() + $this->authTimeout);
            }
        }

        if ($this->enableAutoLogin) {
            Yii::info('Enable Auto Login = True', __METHOD__);
            if ($this->getIsGuest()) {
                Yii::info('Login dengan Cookie.', __METHOD__);
                $this->loginByCookie();
            } elseif ($this->autoRenewCookie) {
                Yii::info('Auto Renew Cookie.', __METHOD__);
                $this->renewIdentityCookie();
            }
        }
    }

    protected function loginByCookie()
    {
        $data = $this->getIdentityAndDurationFromCookie();
        if (isset($data['identity'], $data['duration'])) {
            $identity = $data['identity'];
            $duration = $data['duration'];
            Yii::info('Precek Cookie.', __METHOD__);
            if ($this->beforeLogin($identity, true, $duration)) {
                $this->switchIdentity($identity, $this->autoRenewCookie ? $duration : 0);
                $id = $identity->getId();
                $ip = Yii::$app->getRequest()->getUserIP();
                Yii::info("User '$id' logged in from $ip via cookie.", __METHOD__);
                $this->afterLogin($identity, true, $duration);
            }
        }
    }

    public function switchIdentity($identity, $duration = 0)
    {
        $this->setIdentity($identity);
        Yii::info('Set identity', 'afdhal');
        if (!$this->enableSession) {
            Yii::info('Session disabled', 'afdhal');
            return;
        }

        /* Ensure any existing identity cookies are removed. */
        if ($this->enableAutoLogin) {

            Yii::info('Remove identity cookie', 'afdhal');
            $this->removeIdentityCookie();
        }

        $session = Yii::$app->getSession();
        /*if (!YII_ENV_TEST) {
            $session->regenerateID(true);
        }*/
        $session->remove($this->idParam);
        $session->remove($this->authTimeoutParam);

        if ($identity) {
            $session->set($this->idParam, $identity->getId());
            if ($this->authTimeout !== null) {
                $session->set($this->authTimeoutParam, time() + $this->authTimeout);
            }
            if ($this->absoluteAuthTimeout !== null) {
                $session->set($this->absoluteAuthTimeoutParam, time() + $this->absoluteAuthTimeout);
            }
            if ($duration > 0 && $this->enableAutoLogin) {
                $this->sendIdentityCookie($identity, $duration);
            }
        }
    }
}
