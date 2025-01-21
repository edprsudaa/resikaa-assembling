<?php

namespace app\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\medis\TarifTindakanFix;
use app\models\pegawai\DmUnitPenempatan;

/**
 * TarifTindakanFixSearch represents the model behind the search form of `app\models\medis\TarifTindakanFix`.
 */
class TarifTindakanFixSearch extends TarifTindakanFix
{
    public $kode_jenis;
    public function rules()
    {
        return [
            [['id', 'tindakan_id', 'sk_tarif_id', 'created_by', 'updated_by', 'is_deleted'], 'integer'],
            [['kelas_rawat_kode', 'created_at', 'updated_at'], 'safe'],
            [['js_adm', 'js_sarana', 'js_bhp', 'js_dokter_operator', 'js_dokter_lainya', 'js_dokter_anastesi', 'js_penata_anastesi', 'js_paramedis', 'js_lainya', 'js_adm_cto', 'js_sarana_cto', 'js_bhp_cto', 'js_dokter_operator_cto', 'js_dokter_lainya_cto', 'js_dokter_anastesi_cto', 'js_penata_anastesi_cto', 'js_paramedis_cto', 'js_lainya_cto'], 'number'],
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
    public function search($params, $unit, $kelas)
    {
        $query = TarifTindakanFix::find()->alias('tt')->select([
            'tt.id',
            'tt.tindakan_id',
            'tt.kelas_rawat_kode',
            'kr.nama AS kelas_nama',
            '(tt.js_adm + tt.js_sarana + tt.js_bhp + tt.js_dokter_operator + tt.js_dokter_lainya + tt.js_dokter_anastesi + tt.js_penata_anastesi + tt.js_paramedis + tt.js_lainya) as tarif',
            't.deskripsi as nama_tindakan',
            't.kode_jenis'
        ])
            ->innerJoin('medis.tindakan t', 't.id=tt.tindakan_id')
            ->leftJoin('pendaftaran.kelas_rawat kr', 'kr.kode=tt.kelas_rawat_kode');

        if ($kelas == null) {
            $query->andWhere(['tt.kelas_rawat_kode' => '003']);
        } else {
            $query->andWhere(['tt.kelas_rawat_kode' => $kelas]);
        }
        $cek = DmUnitPenempatan::cekAkses($unit);
        if ($cek == 'pk') {
            $query->andWhere(['t.parent_id' => 2219]);
        } elseif ($cek == 'pa') {
            $query->andWhere(['t.parent_id' => 3846]);
        } elseif ($cek == 'rad') {
            $query->andWhere(['t.parent_id' => 4107]);
        }
        // print_r($query->asArray()->all());
        // die();
        // return TarifTindakanFix::find()->count();

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
            'tindakan_id' => $this->tindakan_id,
            'sk_tarif_id' => $this->sk_tarif_id,
            'js_adm' => $this->js_adm,
            'js_sarana' => $this->js_sarana,
            'js_bhp' => $this->js_bhp,
            'js_dokter_operator' => $this->js_dokter_operator,
            'js_dokter_lainya' => $this->js_dokter_lainya,
            'js_dokter_anastesi' => $this->js_dokter_anastesi,
            'js_penata_anastesi' => $this->js_penata_anastesi,
            'js_paramedis' => $this->js_paramedis,
            'js_lainya' => $this->js_lainya,
            'js_adm_cto' => $this->js_adm_cto,
            'js_sarana_cto' => $this->js_sarana_cto,
            'js_bhp_cto' => $this->js_bhp_cto,
            'js_dokter_operator_cto' => $this->js_dokter_operator_cto,
            'js_dokter_lainya_cto' => $this->js_dokter_lainya_cto,
            'js_dokter_anastesi_cto' => $this->js_dokter_anastesi_cto,
            'js_penata_anastesi_cto' => $this->js_penata_anastesi_cto,
            'js_paramedis_cto' => $this->js_paramedis_cto,
            'js_lainya_cto' => $this->js_lainya_cto,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            'updated_at' => $this->updated_at,
            'updated_by' => $this->updated_by,
            'is_deleted' => $this->is_deleted,
        ]);

        $query->andFilterWhere(['ilike', 'kelas_rawat_kode', $this->kelas_rawat_kode]);

        return $dataProvider;
    }
}
