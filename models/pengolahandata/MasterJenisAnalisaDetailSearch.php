<?php

namespace app\models\pengolahandata;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\pengolahandata\MasterJenisAnalisaDetail;

/**
 * MasterJenisAnalisaDetailSearch represents the model behind the search form of `app\models\pengolahandata\MasterJenisAnalisaDetail`.
 */
class MasterJenisAnalisaDetailSearch extends MasterJenisAnalisaDetail
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['jenis_analisa_detail_id', 'jenis_analisa_detail_aktif', 'jenis_analisa_detail_created_by', 'jenis_analisa_detail_updated_by', 'jenis_analisa_detail_deleted_by'], 'integer'],
            [['jenis_analisa_detail_jenis_analisa_id', 'jenis_analisa_detail_item_analisa_id', 'jenis_analisa_detail_created_at', 'jenis_analisa_detail_updated_at', 'jenis_analisa_detail_deleted_at'], 'safe'],
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
        $query = MasterJenisAnalisaDetail::find()->orderBy(['jenis_analisa_detail_urutan' => SORT_ASC]);

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
            'jenis_analisa_detail_id' => $this->jenis_analisa_detail_id,
            'jenis_analisa_detail_aktif' => $this->jenis_analisa_detail_aktif,
            'jenis_analisa_detail_created_at' => $this->jenis_analisa_detail_created_at,
            'jenis_analisa_detail_created_by' => $this->jenis_analisa_detail_created_by,
            'jenis_analisa_detail_updated_at' => $this->jenis_analisa_detail_updated_at,
            'jenis_analisa_detail_updated_by' => $this->jenis_analisa_detail_updated_by,
            'jenis_analisa_detail_deleted_at' => $this->jenis_analisa_detail_deleted_at,
            'jenis_analisa_detail_deleted_by' => $this->jenis_analisa_detail_deleted_by,
        ]);

        $query->andFilterWhere(['=', 'jenis_analisa_detail_jenis_analisa_id', $this->jenis_analisa_detail_jenis_analisa_id])
            ->andFilterWhere(['=', 'jenis_analisa_detail_item_analisa_id', $this->jenis_analisa_detail_item_analisa_id]);

        return $dataProvider;
    }
}
