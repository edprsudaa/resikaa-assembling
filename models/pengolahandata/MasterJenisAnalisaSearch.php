<?php

namespace app\models\pengolahandata;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\pengolahandata\MasterJenisAnalisa;

/**
 * MasterJenisAnalisaSearch represents the model behind the search form of `app\models\pengolahandata\MasterJenisAnalisa`.
 */
class MasterJenisAnalisaSearch extends MasterJenisAnalisa
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['jenis_analisa_id', 'jenis_analisa_aktif', 'jenis_analisa_created_by', 'jenis_analisa_updated_by', 'jenis_analisa_deleted_by'], 'integer'],
            [['jenis_analisa_uraian', 'jenis_analisa_created_at', 'jenis_analisa_updated_at', 'jenis_analisa_deleted_at'], 'safe'],
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
        $query = MasterJenisAnalisa::find();

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
            'jenis_analisa_id' => $this->jenis_analisa_id,
            'jenis_analisa_aktif' => $this->jenis_analisa_aktif,
            'jenis_analisa_created_at' => $this->jenis_analisa_created_at,
            'jenis_analisa_created_by' => $this->jenis_analisa_created_by,
            'jenis_analisa_updated_at' => $this->jenis_analisa_updated_at,
            'jenis_analisa_updated_by' => $this->jenis_analisa_updated_by,
            'jenis_analisa_deleted_at' => $this->jenis_analisa_deleted_at,
            'jenis_analisa_deleted_by' => $this->jenis_analisa_deleted_by,
        ]);

        $query->andFilterWhere(['ilike', 'jenis_analisa_uraian', $this->jenis_analisa_uraian]);

        return $dataProvider;
    }
}
