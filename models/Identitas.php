<?php

namespace app\models;

use app\models\Sesi;
use app\models\sso\AksesUnit;
use Yii;
use yii\base\Model;
use yii\web\IdentityInterface;


class Identitas extends Model implements IdentityInterface
{

    public $id;
    public $idSesi;
    public $idData;
    public $idProfil;
    public $idProfilR;

    public $nama;
    public $roles;
    public $rolesText;

    public $status;
    public $statusText;

    public $tanggalBuat;
    public $tanggalBuatText;
    public $batasWaktu;
    public $batasWaktuText;
    public $kodeSesi;
    public $kodeAkun;

    private $_sesi = false;

    public function __construct($config)
    {
        if ($config instanceof Sesi) {
            parent::__construct([]);
            $this->_sesi = $config;
            $this->idProfilR = $config->getAkun()->getUserid();
            $this->id = $config->getAkun()->getUserid();
            $this->idSesi = $config->getId();
            $this->idData = $config->getAkun()->getIdPegawai();
            $this->idProfil = $config->getAkun()->getIdPegawai();
            $this->nama = $config->getAkun()->getNama();
            $this->roles = $config->getAkun()->getRole();
            $this->status = $config->getAkun()->getStatus();
            $this->tanggalBuat = $config->getAkun()->getTanggalPendaftaran();
            $this->batasWaktu = $config->getBatasSesi();
            $this->kodeSesi = $config->getKodeSesi();
            $this->kodeAkun = $config->getAkun()->getUsername();
        } elseif (is_array($config)) {
            $this->_sesi = null;
            parent::__construct($config);
        } else {
            $this->_sesi = null;
        }
    }

    public function fields()
    {
        return [
            'id' => function () {
                return $this->getId();
            },
            'idSesi' => function () {
                return $this->getIdSesi();
            },
            'idData' => function () {
                return $this->getIdData();
            },
            'idProfil' => function () {
                return $this->getIdProfil();
            },
            'nama' => function () {
                return $this->getNama();
            },
            'roles' => function () {
                return $this->roles;
            },
            'rolesText' => function () {
                return $this->getRolesText();
            },
            'status' => function () {
                return $this->getStatus();
            },
            'statusText' => function () {
                return $this->getStatusText();
            },
            'tanggalBuat' => function () {
                return $this->getTanggalBuat();
            },
            'tanggalBuatText' => function () {
                return $this->getTanggalBuatText();
            },
            'batasWaktu' => function () {
                return $this->getBatasWaktu();
            },
            'batasWaktuText' => function () {
                return $this->getBatasWaktuText();
            },
            'kodeSesi' => function () {
                return $this->getKodeSesi();
            },
            'kodeAkun' => function () {
                return $this->getKodeAkun();
            },
        ];
    }

    public static function findIdentity($id)
    {
        $sesi = Sesi::find()->where([
            'ida' => $id,
            'ipa' => Yii::$app->request->getUserIP(),
            'inf' => Yii::$app->request->getUserAgent(),
            'isk' => 0
        ])->orderBy('tgb DESC')
            ->limit(1)
            ->one();
        //        var_dump($sesi);
        //        exit();
        if (is_null($sesi)) {
            //            Yii::$app->session->setFlash('warning', 'Sesi tidak ditemukan.');
            Yii::$app->user->logout(true);
            return null;
        } elseif (!$sesi->cekStatus()) {
            //            Yii::$app->session->setFlash('warning', $sesi->getErrors());
            Yii::$app->user->logout(true);
            return null;
        } else {
            return new self($sesi);
        }
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        $sesi = Sesi::find()
            ->where([
                'kds' => $token,
                'isk' => '0',
            ])
            ->orderBy('tgb DESC')
            ->limit(1)
            ->one();
        if (is_null($sesi)) {
            Yii::trace('Sesi tidak ditemukan', 'affandes');
            return null;
        } elseif (!$sesi->cekStatus()) {
            return null;
        } else {
            return new self($sesi);
        }
    }

    public function getId()
    {
        // TODO: Implement getId() method.
        return $this->id;
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->getKodeSesi();
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->authKey === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return $this->password === $password;
    }

    /**
     * @return \yii\db\ActiveQuery
     */

    /**
     * @return mixed
     */
    public function getIdSesi()
    {
        return $this->idSesi;
    }

    /**
     * @param mixed $idSesi
     */
    public function setIdSesi($idSesi)
    {
        $this->idSesi = $idSesi;
    }

    /**
     * @return mixed
     */
    public function getIdData()
    {
        return $this->idData;
    }

    /**
     * @param mixed $idData
     */
    public function setIdData($idData)
    {
        $this->idData = $idData;
    }

    /**
     * @return mixed
     */
    public function getIdProfil()
    {
        return $this->idProfil;
    }

    /**
     * @param mixed $idProfil
     */
    public function setIdProfil($idProfil)
    {
        $this->idProfil = $idProfil;
    }

    /**
     * @return mixed
     */
    public function getNama()
    {
        return $this->nama;
    }

    /**
     * @param mixed $nama
     */
    public function setNama($nama)
    {
        $this->nama = $nama;
    }

    /**
     * @return mixed
     */
    public function getRoles()
    {
        return $this->roles;
    }

    /**
     * @param mixed $roles
     */
    public function setRoles($roles)
    {
        $this->roles = $roles;
    }

    /**
     * @return mixed
     */
    public function getRolesText()
    {
        return $this->rolesText;
    }

    /**
     * @param mixed $rolesText
     */
    public function setRolesText($rolesText)
    {
        $this->rolesText = $rolesText;
    }


    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param mixed $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * @return mixed
     */
    public function getStatusText()
    {
        return $this->statusText;
    }

    /**
     * @param mixed $statusText
     */
    public function setStatusText($statusText)
    {
        $this->statusText = $statusText;
    }

    /**
     * @return mixed
     */
    public function getTanggalBuat()
    {
        return $this->tanggalBuat;
    }

    /**
     * @param mixed $tanggalBuat
     */
    public function setTanggalBuat($tanggalBuat)
    {
        $this->tanggalBuat = $tanggalBuat;
    }

    /**
     * @return mixed
     */
    public function getTanggalBuatText()
    {
        return $this->tanggalBuatText;
    }

    /**
     * @param mixed $tanggalBuatText
     */
    public function setTanggalBuatText($tanggalBuatText)
    {
        $this->tanggalBuatText = $tanggalBuatText;
    }

    /**
     * @return mixed
     */
    public function getBatasWaktu()
    {
        return $this->batasWaktu;
    }

    /**
     * @param mixed $batasWaktu
     */
    public function setBatasWaktu($batasWaktu)
    {
        $this->batasWaktu = $batasWaktu;
    }

    /**
     * @return mixed
     */
    public function getBatasWaktuText()
    {
        return $this->batasWaktuText;
    }

    /**
     * @param mixed $batasWaktuText
     */
    public function setBatasWaktuText($batasWaktuText)
    {
        $this->batasWaktuText = $batasWaktuText;
    }

    /**
     * @return mixed
     */
    public function getKodeSesi()
    {
        return $this->kodeSesi;
    }

    /**
     * @param mixed $kodeSesi
     */
    public function setKodeSesi($kodeSesi)
    {
        $this->kodeSesi = $kodeSesi;
    }

    /**
     * @return mixed
     */
    public function getKodeAkun()
    {
        return $this->kodeAkun;
    }

    /**
     * @param mixed $kodeAkun
     */
    public function setKodeAkun($kodeAkun)
    {
        $this->kodeAkun = $kodeAkun;
    }

    public function getSesi()
    {
        return $this->_sesi;
    }

    public function getAkun()
    {
        $sesi = $this->getSesi();
        if (is_null($sesi)) {
            return null;
        } else {
            return $sesi->getAkun();
        }
    }
    public static function find()
    {
        return AkunAknUser::find();
        // $sesi = $this->getSesi();
        // if (is_null($sesi)) {
        //     return null;
        // } else {
        //     return $sesi->getAkun();
        // }
    }
    public function getAksesUnit()
    {
        return AksesUnit::getUserAksesUnit($this->getId());
    }

    public function getIdPegawai()
    {
        return self::find()->alias('u')
            ->select(['u.id_pegawai', 'kode_dokter_maping_simrs'])
            ->innerJoin('pegawai.tb_pegawai tp', 'tp.pegawai_id=u.id_pegawai')
            ->where(['u.userid' => $this->getId()])->asArray()->one();
    }
}
