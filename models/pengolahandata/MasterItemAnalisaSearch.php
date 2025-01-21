<?php

namespace app\models\pengolahandata;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\pengolahandata\MasterItemAnalisa;

/**
 * MasterItemAnalisaSearch represents the model behind the search form of `app\models\pengolahandata\MasterItemAnalisa`.
 */
class MasterItemAnalisaSearch extends MasterItemAnalisa
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['item_analisa_id', 'item_analisa_aktif', 'item_analisa_created_by', 'item_analisa_updated_by', 'item_analisa_deleted_by'], 'integer'],
            [['item_analisa_uraian', 'item_analisa_created_at', 'item_analisa_updated_at', 'item_analisa_deleted_at'], 'safe'],
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
        $query = MasterItemAnalisa::find();

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
            'item_analisa_id' => $this->item_analisa_id,
            'item_analisa_aktif' => $this->item_analisa_aktif,
            'item_analisa_created_at' => $this->item_analisa_created_at,
            'item_analisa_created_by' => $this->item_analisa_created_by,
            'item_analisa_updated_at' => $this->item_analisa_updated_at,
            'item_analisa_updated_by' => $this->item_analisa_updated_by,
            'item_analisa_deleted_at' => $this->item_analisa_deleted_at,
            'item_analisa_deleted_by' => $this->item_analisa_deleted_by,
        ]);

        $query->andFilterWhere(['ilike', 'item_analisa_uraian', $this->item_analisa_uraian]);

        return $dataProvider;
    }
}
