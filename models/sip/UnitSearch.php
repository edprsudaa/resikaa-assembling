<?php

namespace app\models\sip;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\sip\Unit;

/**
 * UnitSearch represents the model behind the search form of `app\models\sip\Unit`.
 */
class UnitSearch extends Unit
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['kode', 'unit_rumpun'], 'integer'],
            [['nama'], 'safe'],
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
    public function search($params, $tab = null)
    {
        $query = Unit::find();

        if (!$tab)
            $query = $query->where(['=', 'unit_rumpun', 38]);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => [
                    'kode' => SORT_ASC
                ]
            ]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'kode' => $this->kode,
            'unit_rumpun' => $this->unit_rumpun,
        ]);

        $query->andFilterWhere(['ilike', 'nama', $this->nama]);

        return $dataProvider;
    }
}
