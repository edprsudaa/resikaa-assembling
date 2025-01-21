<?php

namespace app\models\pengolahandata;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\pengolahandata\MasterUserAccessPeminjaman;

class MasterUserAccessPeminjamanSearch extends MasterUserAccessPeminjaman
{

    public $nama_lengkap;
    public $ip_address;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'aktif', 'created_by', 'updated_by', 'deleted_by'], 'integer'],
            [['ip_id', 'ip_address', 'nama_lengkap', 'created_at', 'updated_at', 'deleted_at'], 'safe'],
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
        $query = MasterUserAccessPeminjaman::find()->joinWith(['pegawai']);

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
            'aktif' => $this->aktif,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            'updated_at' => $this->updated_at,
            'updated_by' => $this->updated_by,
            'deleted_at' => $this->deleted_at,
            'deleted_by' => $this->deleted_by,
        ]);

        $query->andFilterWhere(['ilike', 'ip_id', $this->ip_id]);
        // Menambahkan filter untuk nama lengkap pegawai
        $query->andFilterWhere(['ilike', 'pegawai.nama_lengkap', $this->nama_lengkap]);
        $query->andFilterWhere(['ilike', 'ipPeminjaman.ip_address', $this->ip_address]);


        return $dataProvider;
    }
}
