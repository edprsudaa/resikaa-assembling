<?php

namespace app\models\db_lis;

use Yii;

/**
 * This is the model class for table "result_detail".
 *
 * @property int $id
 * @property string|null $ono
 * @property string|null $test_cd
 * @property string|null $test_nm
 * @property string|null $data_typ
 * @property string|null $result_value
 * @property string|null $result_ft
 * @property string|null $unit
 * @property string|null $flag
 * @property string|null $ref_range
 * @property string|null $status
 * @property string|null $test_comment
 * @property string|null $validate_by
 * @property string|null $validate_on
 * @property string|null $disp_seq
 * @property string|null $order_testid
 * @property string|null $order_testnm
 * @property string|null $test_group
 * @property string|null $item_parent
 */
class ResultDetail extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'result_detail';
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
            [['ono', 'test_cd', 'test_group'], 'string', 'max' => 20],
            [['test_nm', 'ref_range', 'order_testnm'], 'string', 'max' => 30],
            [['data_typ', 'flag'], 'string', 'max' => 2],
            [['result_value'], 'string', 'max' => 40],
            [['result_ft'], 'string', 'max' => 8000],
            [['unit', 'disp_seq'], 'string', 'max' => 15],
            [['status'], 'string', 'max' => 1],
            [['test_comment'], 'string', 'max' => 1500],
            [['validate_by'], 'string', 'max' => 60],
            [['validate_on'], 'string', 'max' => 14],
            [['order_testid', 'item_parent'], 'string', 'max' => 6],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'ono' => 'Ono',
            'test_cd' => 'Test Cd',
            'test_nm' => 'Test Nm',
            'data_typ' => 'Data Typ',
            'result_value' => 'Result Value',
            'result_ft' => 'Result Ft',
            'unit' => 'Unit',
            'flag' => 'Flag',
            'ref_range' => 'Ref Range',
            'status' => 'Status',
            'test_comment' => 'Test Comment',
            'validate_by' => 'Validate By',
            'validate_on' => 'Validate On',
            'disp_seq' => 'Disp Seq',
            'order_testid' => 'Order Testid',
            'order_testnm' => 'Order Testnm',
            'test_group' => 'Test Group',
            'item_parent' => 'Item Parent',
        ];
    }
}
