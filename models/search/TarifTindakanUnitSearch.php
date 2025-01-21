<?php

namespace app\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\medis\TarifTindakanUnit;

/**
 * TarifTindakanUnitSearch represents the model behind the search form of `app\models\postgre\TarifTindakanUnit`.
 */
class TarifTindakanUnitSearch extends TarifTindakanUnit
{
    public $kode_jenis;
    public $deskripsi;
    public $parent_tindakan;
    public $kelas;
    public $tarif;

    public function rules()
    {
        return [
            [['id', 'tarif_tindakan_id', 'unit_id', 'aktif', 'created_by', 'updated_by', 'is_deleted'], 'integer'],
            [['created_at', 'updated_at', 'kode_jenis', 'deskripsi', 'parent_tindakan', 'kelas', 'tarif'], 'safe'],
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

    public function search($params, $unit, $kelas)
    {
        $query = TarifTindakanUnit::find()->alias('tu')->select([
            'tu.id',
            'tu.tarif_tindakan_id',
            'tt.id',
            'tt.tindakan_id',
            'tt.kelas_rawat_kode',
            '(tt.js_adm + tt.js_sarana + tt.js_bhp + tt.js_dokter_operator + tt.js_dokter_lainya + tt.js_dokter_anastesi + tt.js_penata_anastesi + tt.js_paramedis + tt.js_lainya) as tarif',
            't.deskripsi as nama_tindakan',
            't2.deskripsi as parent_tindakan'
        ])
            ->leftJoin('medis.tarif_tindakan tt', 'tt.id=tu.tarif_tindakan_id')
            ->leftJoin('medis.tindakan t', 't.id=tt.tindakan_id')
            ->leftJoin('medis.tindakan t2', 't2.id=t.parent_id');

        if ($kelas == '000') {
            $query->where(['tu.aktif' => 1, 'tu.unit_id' => $unit]);
        } else {
            $query->where(['tu.aktif' => 1, 'tu.unit_id' => $unit, 'tt.kelas_rawat_kode' => $kelas]);
        }

        // return $query->asArray()->all();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 500,
            ],
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
            // 'tarif_tindakan_id' => $this->tarif_tindakan_id,
            // 'unit_id' => $this->unit_id,
            // 'aktif' => $this->aktif,
            // 'created_at' => $this->created_at,
            // 'created_by' => $this->created_by,
            // 'updated_at' => $this->updated_at,
            // 'updated_by' => $this->updated_by,
            // 'is_deleted' => $this->is_deleted,
        ]);

        return $dataProvider;
    }
}
