<?php

namespace app\models;

use app\components\StatusAkun;
use yii\db\Expression;
use yii\helpers\Html;
use Yii;

/**
 * This is the model class for table "akun.akn_session".
 *
 * @property int $id
 * @property string $tgb Tanggal buat session
 * @property string $bts Tanggal Batas Habis Sesi
 * @property string $kds Kode Sesi / Token
 * @property int $ida Id Akun
 * @property string $ipa IP Address
 * @property string $inf Info Sesi
 * @property string $tat Tanggal akses terakhir
 * @property string $isk Sudah Keluar
 */
class Sesi extends \yii\db\ActiveRecord
{

    private $_akun = false;
    const SCENARIO_AUTHENTICATE = 'auth';

    public function getAkun()
    {
        if ($this->_akun === false) {
            $this->_akun = AkunAknUser::findOne([
                'userid' => $this->ida,
                'status' => '0',
            ]);
        }
        return $this->_akun;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getTanggalBuat()
    {
        return $this->tgb;
    }

    /**
     * @param string $tgb
     */
    public function setTanggalBuat($value = null)
    {
        if (is_null($value)) {
            $this->tgb = date('Y-m-d H:i:s');
        } else {
            $this->tgb = $value;
        }
    }

    /**
     * @return string
     */
    public function getBatasSesi()
    {
        return $this->bts;
    }

    /**
     * @param string $bts
     */
    public function setBatasSesi($durasi = 3600)
    {
        if (!is_null($durasi) && is_numeric($durasi)) {
            $this->bts = date('Y-m-d H:i:s', strtotime('+' . $durasi . ' seconds'));
        } else {
            $this->addError('o', 'Parameter durasi tidak sesuai.');
        }
    }

    /**
     * @return string
     */
    public function getKodeSesi()
    {
        return Html::encode($this->kds);
    }

    /**
     * @param string $kds
     */
    public function setKodeSesi()
    {
        $this->kds = Yii::$app->security->generateRandomString();
    }

    /**
     * @return int
     */
    public function getIdAkun()
    {
        return $this->ida;
    }

    /**
     * @param int $ida
     */
    public function setIdAkun($ida)
    {
        $this->ida = $ida;
    }

    /**
     * @return string
     */
    public function getIpAddress()
    {
        return $this->ipa;
    }

    /**
     * @param string $ipa
     */
    public function setIpAddress($ipa)
    {
        $this->ipa = $ipa;
    }

    /**
     * @return string
     */
    public function getInformasi()
    {
        return $this->inf;
    }

    public function getIpAkun()
    {
        return Html::encode($this->ipa);
    }

    public function getInfo()
    {
        return Html::encode($this->inf);
    }

    /**
     * @param string $inf
     */
    public function setInformasi($inf)
    {
        $this->inf = $inf;
    }

    /**
     * @return string
     */
    public function getTanggalAkses()
    {
        if (empty($this->tat)) {
            return '';
        } elseif (is_array($this->tat) || $this->tat instanceof Expression) {
            return date('Y-m-d H:i:s');
        } else {
            return $this->tat;
        }
    }

    /**
     * @param string $tat
     */
    public function setTanggalAksess($value = null)
    {
        if (is_null($value)) {
            $this->tgb = date('Y-m-d H:i:s');
        } else {
            $this->tgb = $value;
        }
    }

    /**
     * @return string
     */
    public function getIsKeluar()
    {
        return $this->isk;
    }

    /**
     * @param string $isk
     */
    public function setIsKeluar($isk)
    {
        $this->isk = $isk;
    }

    // /**
    //  * @return \yii\db\Connection the database connection used by this AR class.
    //  */
    // public static function getDb()
    // {
    //     return Yii::$app->get('dbSso');
    // }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'sso.akn_session';
    }

    public function isKeluar()
    {
        return $this->isk == '1';
    }

    public function cekStatus()
    {
        if ($this->isKeluar()) {
            return false;
        } elseif (!$this->save()) {
            return false;
        } else {
            return true;
        }
    }

    public function isBerlaku()
    {
        return strtotime($this->bts) > time();
    }

    public function validasiIdAkun()
    {
        if (!$this->hasErrors()) {
            $akun = $this->getAkun();
            if (is_null($akun)) {
                $this->addError('o', 'Akun tidak ditemukan.');
            } elseif ($akun->isBelumAktifasi()) {
                $this->addError('o', 'Akun belum aktif.');
            } elseif ($akun->isSedangDiblokir()) {
                $this->addError('o', 'Akun sedang diblokir.');
            }
        }
    }

    public function setBatasSesiHabis()
    {
        if ($this->isKeluar()) {
            $this->addError('o', 'Akun ini sudah keluar.');
        } else {
            $this->bts = date('Y-m-d H:i:s', strtotime('-3600 seconds'));
        }
    }

    public function keluar()
    {
        if (!$this->validate()) {
            return false;
        } else {
            $this->isk = '1';
            $this->setBatasSesiHabis();
            return $this->save(true);
        }
    }


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['tgb', 'bts', 'kds', 'ida', 'ipa', 'inf', 'tat'], 'safe'],
            [['tgb', 'bts', 'tat'], 'safe'],
            [['ida'], 'default', 'value' => null],
            [['ida'], 'integer'],
            [['inf'], 'string'],
            [['kds'], 'string', 'max' => 64],
            [['ipa'], 'string', 'max' => 30],
            [['isk'], 'string', 'max' => 1],
            [['ida'], 'validasiIdAkun', 'on' => self::SCENARIO_AUTHENTICATE],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'tgb' => 'Tgb',
            'bts' => 'Bts',
            'kds' => 'Kds',
            'ida' => 'Ida',
            'ipa' => 'Ipa',
            'inf' => 'Inf',
            'tat' => 'Tat',
            'isk' => 'Isk',
        ];
    }
}
