<?php

namespace app\models;

use app\models\DateHelper;
use penunjang\widgets\FilterHeaderWidget;
use yii\base\Model;

class FilterHeader extends Model
{
    const PARAM_TANGGAL = 'TGL';
    const PARAM_UNIT    = 'UNT';
    const PARAM_DOKTER  = 'DKT';

    public $headerTanggal;
    public $headerUnit;
    public $headerDokter;

    public function rules()
    {
        return [
            ['headerTanggal', 'string'],
            ['headerUnit', 'string'],
            ['headerDokter', 'string']
        ];
    }

    public function __construct(array $config = [])
    {
        $this->headerTanggal = \Yii::$app->session->get(\Yii::$app->id . DIRECTORY_SEPARATOR . self::PARAM_TANGGAL, date('Y-m-d H:i:s'));
        $this->headerUnit = \Yii::$app->session->get(\Yii::$app->id . DIRECTORY_SEPARATOR . self::PARAM_UNIT, Null);
        //$this->headerUnit = \Yii::$app->session->get(\Yii::$app->id.DIRECTORY_SEPARATOR.self::PARAM_UNIT);
        $this->headerDokter = \Yii::$app->session->get(\Yii::$app->id . DIRECTORY_SEPARATOR . self::PARAM_DOKTER);
    }

    public function setTanggal($tgl)
    {
        $tanggal = date('Y-m-d H:i:s', strtotime($tgl));
        \Yii::$app->session->set(\Yii::$app->id . DIRECTORY_SEPARATOR . self::PARAM_TANGGAL, $tanggal);
        $this->headerTanggal = $tanggal;
    }

    public function setUnit($unit)
    {
        \Yii::$app->session->set(\Yii::$app->id . DIRECTORY_SEPARATOR . self::PARAM_UNIT, $unit);
        $this->headerUnit = $unit;
    }

    public function setDokter($dokter)
    {
        \Yii::$app->session->set(\Yii::$app->id . DIRECTORY_SEPARATOR . self::PARAM_DOKTER, $dokter);
        $this->headerDokter = $dokter;
    }


    public function getTanggal()
    {
        return $this->headerTanggal;
    }

    public function getUnit()
    {
        return $this->headerUnit;
    }

    public function getDokter()
    {
        return $this->headerDokter;
    }

    public function save()
    {

        $this->setTanggal(date('Y-m-d H:i:s', strtotime(str_replace('/', '-', $this->headerTanggal))));

        $this->setUnit($this->headerUnit);
        if (empty($this->getUnit())) {
            $this->setDokter(null);
        } else {
            $this->setDokter((($this->headerDokter == ' ') or ($this->headerDokter == '+')) ? '0000' : $this->headerDokter);
        }
    }
}
