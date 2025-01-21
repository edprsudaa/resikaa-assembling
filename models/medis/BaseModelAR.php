<?php
namespace app\models\medis;
use app\models\AkunAknUser;
use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\helpers\Json;
class BaseModelAR extends \yii\db\ActiveRecord
{
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'value' => date('Y-m-d H:i:s'),
            ],
            BlameableBehavior::className(),
        ];
    }

    public function attributeLabels()
    {
        return [
            'created_at' => 'Dibuat Pada',
            'updated_at' => 'Diubah Pada',
            'created_by' => 'Dibuat Oleh',
            'updated_by' => 'Diubah Oleh',
        ];
    }
    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);
        if ($insert) {
            $newRow = $this->attributes;
            unset($newRow['log_data']);
            $oldRiwayat = [];
            array_push($oldRiwayat, $newRow);
            $this->log_data = Json::encode($oldRiwayat, JSON_PRETTY_PRINT);
            $this->updateAttributes(['log_data']);
        } else {
            $this->updated_by = Yii::$app->user->id;
            $this->updateAttributes(['updated_by']);
            if (count($changedAttributes) > 0) {
                $newRow = $this->attributes;
                unset($newRow['log_data']);
                $oldRiwayat = [];
                if($this->log_data){
                    $oldRiwayat = Json::decode($this->log_data);
                }
                array_push($oldRiwayat, $newRow);
                $this->log_data = Json::encode($oldRiwayat, JSON_PRETTY_PRINT);
                $this->updateAttributes(['log_data']);
            }
        }
    }
    public function getCreatedByTeks()
    {
        return $this->hasOne(AkunAknUser::className(), ['userid' => 'created_by']);
    }
    public function getUpdatedByTeks()
    {
        return $this->hasOne(AkunAknUser::className(), ['userid' => 'updated_by']);
    }
}
