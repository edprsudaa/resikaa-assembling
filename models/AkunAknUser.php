<?php

namespace app\models;

use app\components\StatusAkun;
use app\models\pegawai\TbPegawai;
use Yii;

/**
 * This is the model class for table "akun.akn_user".
 *
 * @property int $userid
 * @property int $id_pegawai
 * @property string $username
 * @property string $password
 * @property string|null $nama
 * @property string|null $tanggal_pendaftaran
 * @property string|null $role enum('root','pegawai','dokter')
 * @property string|null $token_aktivasi
 * @property int|null $status 0 = pending  1 = aktif 2 = non aktif
 */
class AkunAknUser extends \yii\db\ActiveRecord
{
    /**
     * @return int
     */
    public function getUserid()
    {
        return $this->userid;
    }

    /**
     * @param int $userid
     */
    public function setUserid($userid)
    {
        $this->userid = $userid;
    }

    /**
     * @return int
     */
    public function getIdPegawai()
    {
        return $this->id_pegawai;
    }

    /**
     * @param int $id_pegawai
     */
    public function setIdPegawai($id_pegawai)
    {
        $this->id_pegawai = $id_pegawai;
    }

    /**
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param string $username
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * @return string|null
     */
    public function getNama()
    {
        return $this->nama;
    }

    /**
     * @param string|null $nama
     */
    public function setNama($nama)
    {
        $this->nama = $nama;
    }

    /**
     * @return string|null
     */
    public function getTanggalPendaftaran()
    {
        return $this->tanggal_pendaftaran;
    }

    /**
     * @param string|null $tanggal_pendaftaran
     */
    public function setTanggalPendaftaran($tanggal_pendaftaran)
    {
        $this->tanggal_pendaftaran = $tanggal_pendaftaran;
    }

    /**
     * @return string|null
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
     * @param string|null $role
     */
    public function setRole($role)
    {
        $this->role = $role;
    }

    /**
     * @return string|null
     */
    public function getTokenAktivasi()
    {
        return $this->token_aktivasi;
    }

    /**
     * @param string|null $token_aktivasi
     */
    public function setTokenAktivasi($token_aktivasi)
    {
        $this->token_aktivasi = $token_aktivasi;
    }

    /**
     * @return int|null
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param int|null $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }




    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'sso.akn_user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_pegawai', 'username', 'password'], 'required'],
            [['id_pegawai', 'status'], 'default', 'value' => null],
            [['id_pegawai', 'status'], 'integer'],
            [['tanggal_pendaftaran'], 'safe'],
            [['token_aktivasi'], 'string'],
            [['username', 'nama', 'role'], 'string', 'max' => 50],
            [['password'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'userid' => 'Userid',
            'id_pegawai' => 'Kode Pegawai',
            'username' => 'Username',
            'password' => 'Password',
            'nama' => 'Nama',
            'tanggal_pendaftaran' => 'Tanggal Pendaftaran',
            'role' => 'Role',
            'token_aktivasi' => 'Token Aktivasi',
            'status' => 'Status',
        ];
    }

    public static function getOneKodeAkun($kodeAkun, $includeDeleted = false)
    {
        if (is_null($kodeAkun)) {
            return null;
        } else {
            if ($includeDeleted) {
                return self::findOne([
                    'username' => $kodeAkun,
                ]);
            } else {
                return self::findOne([
                    'username' => $kodeAkun,
                    'status' => '0',
                ]);
            }
        }
    }

    public function isBelumAktifasi()
    {
        return $this->sta == StatusAkun::TERDAFTAR;
    }

    public function isSudahAktif()
    {
        return $this->sta == StatusAkun::AKTIF;
    }

    public function isSedangDiblokir()
    {
        return $this->sta == StatusAkun::BLOKIR;
    }

    public function getPegawai()
    {
        return $this->hasOne(TbPegawai::className(), ['pegawai_id' => 'id_pegawai']);
    }
    //ADD NEW RBAC
    /**
     * @return int|null
     */
    public function getFoto()
    {
        return $this->foto;
    }

    /**
     * @param int|null $foto
     */
    public function setFoto($foto)
    {
        $this->foto = $foto;
    }
}
