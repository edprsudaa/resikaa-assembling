<?php

namespace app\models\pengolahandata;


use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\pengolahandata\KualifikasiPendidikan;

/**
 * KualifikasiPendidikanSearch represents the model behind the search form of `app\models\KualifikasiPendidikan`.
 */
class KualifikasiPendidikanSearch extends KualifikasiPendidikan
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'parent_id', 'aktif', 'created_by', 'updated_by', 'deleted_by'], 'integer'],
            [['uraian', 'created_at', 'updated_at', 'deleted_at'], 'safe'],
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
    public function search($params)
    {
        $query = KualifikasiPendidikan::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'parent_id' => $this->parent_id,
            'aktif' => $this->aktif,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            'updated_at' => $this->updated_at,
            'updated_by' => $this->updated_by,
            'deleted_at' => $this->deleted_at,
            'deleted_by' => $this->deleted_by,
        ]);

        $query->andFilterWhere(['ilike', 'uraian', $this->uraian]);

        return $dataProvider;
    }
}
