<?php

namespace app\models;

use yii\db\ActiveRecord;

class DateHelper extends ActiveRecord
{
    public static function tableName()
    {
        return '{{DATE_KONFIG}}';
    }
    public static function getDate($format = 'Y-m-d H:i:s')
    {
        $dateList = self::find()->where([
            'dkUserID' => self::getUID(),
            'dkIsActive' => 1,
            'dkIPAddress' => \Yii::$app->getRequest()->getUserIP(),
            'convert(varchar,dkDateActive,103)' => date('d/m/Y'),
        ])->orderBy(['dkCreateDate' => SORT_DESC])->one();
        if ($dateList) {
            if (date('Y-m-d', strtotime($dateList->dkDateTarget)) < date('Y-m-d', strtotime(\Yii::$app->params['local.max_tgl_mundur'] . ' days', strtotime(date('Y-m-d'))))) {
                if (!in_array(self::getUID(), \Yii::$app->params['local.userid_free_max_tgl_mundur'])) {
                    $dateList->dkIsActive = 0;
                    $dateList->dkModifyDate = date('Y-m-d H:i:s');
                    $dateList->dkModifyUserID = self::getUID();
                    $dateList->save();
                    return date($format);
                }
            }
            return date($format, strtotime($dateList->dkDateTarget));
        } else {
            return date($format);
        }
    }
    private static function getUID()
    {
        return \Yii::$app->user->id;
    }

    public static function getDayIndonesianName($date = null)
    {
        if (empty($date)) {
            $date = date('Y-m-d');
        }
        $day = date('D', strtotime($date));
        $dayList = array(
            'Sun' => 'Minggu',
            'Mon' => 'Senin',
            'Tue' => 'Selasa',
            'Wed' => 'Rabu',
            'Thu' => 'Kamis',
            'Fri' => 'Jumat',
            'Sat' => 'Sabtu'
        );
        return $dayList[$day];
    }
}
