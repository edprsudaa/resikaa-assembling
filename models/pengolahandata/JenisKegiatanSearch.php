<?php

namespace app\models\pengolahandata;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\pengolahandata\JenisKegiatan;

/**
 * AsetkodeSearch represents the model behind the search form of `app\models\Asetkode`.
 */
class JenisKegiatanSearch extends JenisKegiatan
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['jenis_kegiatan_id', 'jenis_kegiatan_parent_id', 'jenis_kegiatan_aktif', 'jenis_kegiatan_created_by', 'jenis_kegiatan_updated_by', 'jenis_kegiatan_deleted_by'], 'integer'],
            [['jenis_kegiatan_jenis', 'jenis_kegiatan_uraian', 'jenis_kegiatan_dasar', 'jenis_kegiatan_created_at', 'jenis_kegiatan_updated_at', 'jenis_kegiatan_deleted_at'], 'safe'],
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
        $query = JenisKegiatan::find();

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
            'jenis_kegiatan_id' => $this->jenis_kegiatan_id,
            'jenis_kegiatan_parent_id' => $this->jenis_kegiatan_parent_id,
            'jenis_kegiatan_aktif' => $this->jenis_kegiatan_aktif,
            'jenis_kegiatan_created_at' => $this->jenis_kegiatan_created_at,
            'jenis_kegiatan_created_by' => $this->jenis_kegiatan_created_by,
            'jenis_kegiatan_updated_at' => $this->jenis_kegiatan_updated_at,
            'jenis_kegiatan_updated_by' => $this->jenis_kegiatan_updated_by,
            'jenis_kegiatan_deleted_at' => $this->jenis_kegiatan_deleted_at,
            'jenis_kegiatan_deleted_by' => $this->jenis_kegiatan_deleted_by,
        ]);

        $query
            ->andFilterWhere(['like', 'jenis_kegiatan_uraian', $this->jenis_kegiatan_uraian]);

        return $dataProvider;
    }
}
