<?php

namespace app\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\pendaftaran\Layanan2;
use app\models\pendaftaran\Pasien;
use app\models\medis\Pjp;
use Yii;
/**
 * LayananRjSearch represents the model behind the search form of `app\models\pendaftaran\Layanan`.
 */
class LayananRj2Search extends Layanan2
{
    public $pasien;
    public $pjp;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'jenis_layanan', 'unit_kode', 'nomor_urut', 'panggil_perawat', 'dipanggil_perawat', 'created_by', 'updated_by', 'deleted_by', 'panggil_dokter', 'dipanggil_dokter'], 'integer'],
            [['registrasi_kode', 'tgl_masuk', 'tgl_keluar', 'kamar_id', 'kelas_rawat_kode', 'unit_asal_kode', 'unit_tujuan_kode', 'cara_masuk_unit_kode', 'cara_keluar_kode', 'status_keluar_kode', 'keterangan', 'created_at', 'updated_at', 'deleted_at'], 'safe'],
            [['pasien'], 'safe'],
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
    public function search($params,$user)
    {
        $query = Layanan2::find();
        $query->innerjoinWith([
            'registrasi'=>function($q){
                $q->joinWith(['pasien']);
            }
            ]);
		$query->joinWith([
		'pjp'
		]);
        $query->andWhere([
            Pjp::tableName() . '.pegawai_id'=> $user['pegawai_id']
        ]);
        // add conditions that should always apply here
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => [
					'nomor_urut' => SORT_ASC
                ]
            ],
            'pagination' => false
        ]);
        $dataProvider->sort->attributes['tgl_masuk'] = [
            'asc' => [self::tableName() . '.tgl_masuk' => SORT_ASC],
            'desc' => [self::tableName() . '.tgl_masuk' => SORT_DESC],
        ];
        $dataProvider->sort->attributes['nomor_urut'] = [
            'asc' => [self::tableName() . '.nomor_urut' => SORT_ASC],
            'desc' => [self::tableName() . '.nomor_urut' => SORT_DESC],
        ];
        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
        // $this->jenis_layanan=self::RJ;
        if(!$this->tgl_masuk){
            $this->tgl_masuk=date('Y-m-d');
            // $this->tgl_masuk='2021-01-04';
        }
        // grid filtering conditions
        $query->andFilterWhere([
            Layanan2::tableName() . '.jenis_layanan' => $this->jenis_layanan,
            Layanan2::tableName() . '.unit_kode' => $this->unit_kode,
            Layanan2::tableName() . '.panggil_perawat' => $this->panggil_perawat,
            Layanan2::tableName() . '.panggil_dokter' => $this->panggil_dokter,
            ]);
        if($this->tgl_masuk){
            $query->andFilterWhere(['between', Layanan2::tableName() . '.tgl_masuk', Yii::$app->formatter->asDate($this->tgl_masuk.' 00:00:01', 'php:Y-m-d H:i:s'), Yii::$app->formatter->asDate($this->tgl_masuk.' 23:59:59', 'php:Y-m-d H:i:s')]);
        }
        $query->andFilterWhere([
                'or',
                ['ilike', Pasien::tableName() . '.kode', $this->pasien],
                ['ilike', Pasien::tableName() . '.nama', $this->pasien],
                ['ilike', Layanan2::tableName() . '.registrasi_kode', $this->pasien]
            ]); 
        return $dataProvider;
    }
}
