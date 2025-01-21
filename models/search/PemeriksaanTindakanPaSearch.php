<?php

namespace app\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\penunjang\PemeriksaanTindakanPa;

/**
 * PemeriksaanTindakanPaSearch represents the model behind the search form of `app\models\penunjang\PemeriksaanTindakanPa`.
 */
class PemeriksaanTindakanPaSearch extends PemeriksaanTindakanPa
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'tindakan_id', 'pemeriksaan_pa_id', 'created_by', 'updated_by', 'deleted_by'], 'integer'],
            [['created_at', 'updated_at', 'deleted_at'], 'safe'],
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
        $query = PemeriksaanTindakanPa::find()->where(['deleted_by' => null]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'tindakan_id' => $this->tindakan_id,
            'pemeriksaan_pa_id' => $this->pemeriksaan_pa_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'deleted_at' => $this->deleted_at,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'deleted_by' => $this->deleted_by,
        ]);

        return $dataProvider;
    }
}
