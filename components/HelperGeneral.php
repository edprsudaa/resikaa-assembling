<?php

namespace app\components;

use Yii;
use NumberFormatter;
use yii\base\Security;

class HelperGeneral
{
    public static function hashData($data)
    {
        $s = new Security();
        return $s->hashData($data, Yii::$app->params['other']['keys'] . date('Y-m-d'));
    }

    public static function hashDataCustom($data, $key)
    {
        $s = new Security();
        return $s->hashData($data, $key . date('Y-m-d'));
    }


    public static function validateData($data)
    {
        $s = new Security();
        return $s->validateData($data, Yii::$app->params['other']['keys'] . date('Y-m-d'));
    }
    public static function highlightKeyword($text, $words)
    {
        preg_match_all('~\w+~', $words, $m);
        if (!$m)
            return $text;
        $re = '~(' . implode('|', $m[0]) . ')~i';
        return preg_replace($re, '<span style="background-color: #0168fa; color: #ffffff;">$0</span>', $text);
    }

    public static function getDateFormatToIndo($date, $full = true)
    {
        if ($full) {
            $month = [1 =>   'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
        } else {
            $month = [1 =>   'Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
        }
        $date = date('Y-m-d', strtotime($date));
        $exp = explode('-', $date);
        return $exp[2] . '/' . $month[(int)$exp[1]] . '/' . $exp[0];
    }
    public static function getUmur($birthday, $today = null)
    {
        if (!$today) {
            $today == date('Y-m-d');
        }
        $biday = new \DateTime($birthday);
        $today = new \DateTime($today);
        $diff = $today->diff($biday);
        return [
            'th' => $diff->y,
            'bl' => $diff->m,
            'hr' => $diff->d
        ];
    }
    public static function convertLayananId($id)
    {
        if (!is_numeric($id)) {
            $id = self::validateData($id);
        }
        if ($id) {
            return $id;
        }
        return null;
    }
    public static function getValueCustomRadio($data, $val)
    {
        if (!in_array($val, $data) && !empty($val)) {
            return ['v' => $val, 'c' => 'checked'];
        } else {
            return ['v' => null, 'c' => null];
        }
    }
    // public static function getNumberCountMap($min,$max){
    //     $arrayMap=[];
    //     for ($i=$min; $i <= $max; $i++) { 
    //         array_push($arrayMap,[$i=>$i]);
    //     }
    //     return $arrayMap;
    // }
}
