<?php

namespace app\models\db_lis;

use Yii;

/**
 * This is the model class for table "result_head2".
 *
 * @property int $id
 * @property string|null $pid
 * @property string|null $apid
 * @property string|null $pname
 * @property string|null $sex
 * @property string|null $birth_dt
 * @property string|null $ono
 * @property string|null $lno
 * @property string|null $request_dt
 * @property string|null $source_cd
 * @property string|null $source_nm
 * @property string|null $clinician_cd
 * @property string|null $clinician_nm
 * @property string|null $priority
 * @property string|null $comment
 * @property string|null $visitno
 * @property string|null $data_api
 * @property string|null $age
 * @property string|null $address
 */
class ResultHead2 extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'result_head_backup';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db_perantara_lis');
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['birth_dt', 'request_dt'], 'safe'],
            [['data_api'], 'string'],
            [['pid'], 'string', 'max' => 13],
            [['apid'], 'string', 'max' => 16],
            [['pname', 'source_nm', 'clinician_nm'], 'string', 'max' => 50],
            [['sex', 'priority'], 'string', 'max' => 1],
            [['ono', 'lno', 'visitno'], 'string', 'max' => 20],
            [['source_cd'], 'string', 'max' => 6],
            [['clinician_cd'], 'string', 'max' => 9],
            [['comment'], 'string', 'max' => 300],
            [['age'], 'string', 'max' => 100],
            [['address'], 'string', 'max' => 500],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'pid' => 'Pid',
            'apid' => 'Apid',
            'pname' => 'Pname',
            'sex' => 'Sex',
            'birth_dt' => 'Birth Dt',
            'ono' => 'Ono',
            'lno' => 'Lno',
            'request_dt' => 'Request Dt',
            'source_cd' => 'Source Cd',
            'source_nm' => 'Source Nm',
            'clinician_cd' => 'Clinician Cd',
            'clinician_nm' => 'Clinician Nm',
            'priority' => 'Priority',
            'comment' => 'Comment',
            'visitno' => 'Visitno',
            'data_api' => 'Data Api',
            'age' => 'Age',
            'address' => 'Address',
        ];
    }
}
