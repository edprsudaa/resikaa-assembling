<?php

namespace app\models\sqlServer;

use Yii;

/**
 * This is the model class for table "LIS_ORDER".
 *
 * @property string $ID
 * @property string $MESSAGE_ID
 * @property string $MESSAGE_DT
 * @property string $ORDER_CONTROL
 * @property string $PID
 * @property string|null $APID
 * @property string $PNAME
 * @property string|null $ADDRESS
 * @property string $PTYPE
 * @property string $BIRTH_DT
 * @property string $SEX
 * @property string $ONO
 * @property string|null $LNO
 * @property string $REQUEST_DT
 * @property string|null $SOURCE
 * @property string|null $CLINICIAN
 * @property string|null $ROOM_NO
 * @property string|null $PRIORITY
 * @property string|null $P_STATUS
 * @property string|null $COMMENT
 * @property string|null $VISITNO
 * @property string|null $ORDER_TESTID
 * @property string|null $INSURER
 * @property string|null $RUJUKANDR
 * @property string|null $STATUS
 */
class LISORDER extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'LIS_ORDER';
    }

    public static function getDb()
    {
        return Yii::$app->get('db_sql_server');
    }

    public function rules()
    {
        return [
            [['ID', 'MESSAGE_ID', 'MESSAGE_DT', 'ORDER_CONTROL', 'PID', 'PNAME', 'PTYPE', 'BIRTH_DT', 'SEX', 'ONO', 'REQUEST_DT'], 'required'],
            [['ORDER_TESTID'], 'string'],
            [['ID'], 'string', 'max' => 12],
            [['MESSAGE_ID'], 'string', 'max' => 3],
            [['MESSAGE_DT', 'BIRTH_DT', 'REQUEST_DT'], 'string', 'max' => 14],
            [['ORDER_CONTROL', 'PTYPE'], 'string', 'max' => 2],
            [['PID'], 'string', 'max' => 13],
            [['APID'], 'string', 'max' => 16],
            [['PNAME'], 'string', 'max' => 50],
            [['ADDRESS'], 'string', 'max' => 200],
            [['SEX', 'PRIORITY', 'P_STATUS', 'STATUS'], 'string', 'max' => 1],
            [['ONO', 'LNO', 'VISITNO'], 'string', 'max' => 20],
            [['SOURCE', 'CLINICIAN', 'INSURER', 'RUJUKANDR'], 'string', 'max' => 56],
            [['ROOM_NO'], 'string', 'max' => 6],
            [['COMMENT'], 'string', 'max' => 300],
            [['ID'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'MESSAGE_ID' => 'Message ID',
            'MESSAGE_DT' => 'Message Dt',
            'ORDER_CONTROL' => 'Order Control',
            'PID' => 'Pid',
            'APID' => 'Apid',
            'PNAME' => 'Pname',
            'ADDRESS' => 'Address',
            'PTYPE' => 'Ptype',
            'BIRTH_DT' => 'Birth Dt',
            'SEX' => 'Sex',
            'ONO' => 'Ono',
            'LNO' => 'Lno',
            'REQUEST_DT' => 'Request Dt',
            'SOURCE' => 'Source',
            'CLINICIAN' => 'Clinician',
            'ROOM_NO' => 'Room No',
            'PRIORITY' => 'Priority',
            'P_STATUS' => 'P Status',
            'COMMENT' => 'Comment',
            'VISITNO' => 'Visitno',
            'ORDER_TESTID' => 'Order Testid',
            'INSURER' => 'Insurer',
            'RUJUKANDR' => 'Rujukandr',
            'STATUS' => 'Status',
        ];
    }
}
