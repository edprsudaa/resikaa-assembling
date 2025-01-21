<?php

namespace app\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\db_lis\ResultHead;
use app\models\db_lis\ResultHead2;

/**
 * ResultHeadSearch represents the model behind the search form of `app\models\db_lis\ResultHead`.
 */
class ResultHeadSearch extends ResultHead
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['pid', 'apid', 'pname', 'sex', 'birth_dt', 'ono', 'lno', 'request_dt', 'source_cd', 'source_nm', 'clinician_cd', 'clinician_nm', 'priority', 'comment', 'visitno', 'data_api'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params, $tgl)
    {
        $query = ResultHead::find()->select([
            'id', 'pid', 'apid', 'pname', 'sex', 'ono', "request_dt", 'source_cd', 'source_nm', 'clinician_nm', 'priority'
        ])->where("pid != '00000009'");
        $query2 = ResultHead2::find()->select([
            'id', 'pid', 'apid', 'pname', 'sex', 'ono', "to_timestamp(request_dt , 'YYYYMMDDHH24MISS') as request_dt", 'source_cd', 'source_nm', 'clinician_nm', 'priority'
        ])->where("pid != '00000009'");

        if ($tgl != null) {
            $query->andWhere([
                'BETWEEN',
                'request_dt',
                date('Y-m-d', strtotime($tgl . " 00:00:00")),
                date('Y-m-d', strtotime($tgl . " 23:59:59"))
            ]);
            $query2->andWhere([
                'BETWEEN',
                'request_dt',
                date('Y-m-d', strtotime($tgl . " 00:00:00")),
                date('Y-m-d', strtotime($tgl . " 23:59:59"))
            ]);
        }

        $query->union($query2);

        $dataProvider = new ActiveDataProvider([
            'query' => ResultHead::find()->from(['result_head' => $query]),
            'pagination' => [
                'pageSize' => 6
            ],
            'sort' => ['defaultOrder' => ['request_dt' => SORT_DESC]],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
        ]);

        $query->andFilterWhere(['ilike', 'pid', $this->pid])
            ->andFilterWhere(['ilike', 'apid', $this->apid])
            ->andFilterWhere(['ilike', 'pname', $this->pname])
            ->andFilterWhere(['ilike', 'sex', $this->sex])
            ->andFilterWhere(['ilike', 'request_dt', $this->request_dt]);

        return $dataProvider;
    }
}
