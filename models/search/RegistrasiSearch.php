<?php

namespace app\models\search;

use app\components\HelperSpesialClass;
use app\models\pendaftaran\Layanan;
use app\models\pendaftaran\Pasien;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\pendaftaran\Registrasi;
use app\models\pengolahandata\AnalisaDokumen;
use app\models\pengolahandata\MasterJenisAnalisaDetail;
use Yii;
use yii\db\Expression;

/**
 * RegistrasiSearch represents the model behind the search form of `app\models\pendaftaran\Registrasi`.
 */
class RegistrasiSearch extends Registrasi
{
    public $unit;
    public $pasien;
    public $tgl_awal, $tgl_akhir;
    public $status;
    public $nama;
    public $ibu_nama;
    public $ayah_nama;
    public $tgl_lahir;




    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['kode', 'pasien_kode', 'tgl_masuk', 'tgl_keluar', 'kiriman_detail_kode', 'debitur_detail_kode', 'created_by', 'created_at', 'updated_by', 'updated_at', 'deleted_at', 'no_sep', 'is_print', 'lambar', 'old_kiriman_detail_kode', 'old_debitur_detail_kode', 'is_analisa'], 'safe'],
            [['deleted_by'], 'integer'],
            [['pasien', 'unit', 'ibu_nama', 'ayah_nama', 'tgl_lahir', 'nama'], 'safe'],
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
    function searchRegistrasi($id, $params)
    {
        $query = Registrasi::find()->alias('r')
            ->joinWith([
                'pasien ps',
                'layananone' => function ($q) {
                    $q->joinWith(['unit u'], false);
                    if (HelperSpesialClass::isMpp()) {
                        if (Yii::$app->params['mpp'][Yii::$app->user->identity->idProfil]['unit'] != NULL) {
                            $q->andWhere(['in', 'unit_kode', Yii::$app->params['mpp'][Yii::$app->user->identity->idProfil]['unit']]);
                        }
                    }
                }
            ], false)->where('r.deleted_at is null')->orderBy(['r.tgl_masuk' => SORT_DESC]);
        if ($id != NULL) {
            $query->andWhere(['r.pasien_kode' => $id]);
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        $this->load($params);
        if (!$this->validate()) {
            return $dataProvider;
        }
        $query->andFilterWhere([
            'r.debitur_detail_kode' => $this->debitur_detail_kode,
        ]);
        $query->andFilterWhere(['ilike', 'r.kode', $this->kode])
            ->andFilterWhere(['ilike', 'r.pasien_kode', $this->pasien_kode])
            ->andFilterWhere(['ilike', "TO_CHAR(r.tgl_masuk :: DATE,'YYYY-MM-DD')", $this->tgl_masuk != NULL ? date('Y-m-d', strtotime($this->tgl_masuk)) : NULL])
            ->andFilterWhere(['ilike', "TO_CHAR(r.tgl_keluar :: DATE,'YYYY-MM-DD')", $this->tgl_keluar != NULL ? date('Y-m-d', strtotime($this->tgl_keluar)) : NULL]);
        return $dataProvider;
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

        $query = Registrasi::find();
        $query->joinWith([
            'pasien',
            'layanan',
            'analisaDokumen'
        ]);

        // ->where(['not',['pendaftaran.registrasi.tgl_keluar'=>null]]);
        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);
        $dataProvider->sort->attributes['tgl_masuk'] = [
            'asc' => [self::tableName() . '.tgl_masuk' => SORT_ASC],
            'desc' => [self::tableName() . '.tgl_masuk' => SORT_DESC],
        ];

        $dataProvider->sort->attributes['is_analisa'] = [
            'asc' => [self::tableName() . '.is_analisa' => SORT_ASC],
            'desc' => [self::tableName() . '.is_analisa' => SORT_DESC],
        ];

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        if (!$this->tgl_masuk) {
            $this->tgl_masuk = date('Y-m-d');
            // $this->tgl_masuk='2021-01-04';
        }
        if ($this->tgl_masuk) {
            $query->andFilterWhere(['between', Registrasi::tableName() . '.tgl_masuk', Yii::$app->formatter->asDate($this->tgl_masuk . ' 00:00:01', 'php:Y-m-d H:i:s'), Yii::$app->formatter->asDate($this->tgl_masuk . ' 23:59:59', 'php:Y-m-d H:i:s')]);
        }

        if ($this->tgl_keluar) {
            $query->andFilterWhere(['between', Registrasi::tableName() . '.tgl_keluar', Yii::$app->formatter->asDate($this->tgl_keluar . ' 00:00:01', 'php:Y-m-d H:i:s'), Yii::$app->formatter->asDate($this->tgl_keluar . ' 23:59:59', 'php:Y-m-d H:i:s')]);
        }

        // if(!empty($params['RegistrasiSearch']['tgl_awal'])){
        //     $query->andFilterWhere(['>=', new Expression('date (' . AnalisaDokumen::tableName() . '.created_at)'), $params['RegistrasiSearch']['tgl_awal']]);
        // }

        $registrasiId = Registrasi::find()->select(['kode'])->where(['date (tgl_masuk)' => $this->tgl_masuk])->all();

        if (!is_null($this->is_analisa)) {
            $query->andFilterWhere(['is_analisa' => $this->is_analisa]);
        }


        $query->andFilterWhere([
            'or',
            ['ilike', Pasien::tableName() . '.kode', $this->pasien],
            ['ilike', Pasien::tableName() . '.nama', $this->pasien],
        ]);

        $query->andFilterWhere(['ilike', 'kode', $this->kode])
            ->andFilterWhere(['ilike', 'pasien_kode', $this->pasien_kode])
            ->andFilterWhere(['ilike', 'kiriman_detail_kode', $this->kiriman_detail_kode])
            ->andFilterWhere(['ilike', 'debitur_detail_kode', $this->debitur_detail_kode])
            ->andFilterWhere(['ilike', 'created_by', $this->created_by])
            ->andFilterWhere(['ilike', 'updated_by', $this->updated_by])
            ->andFilterWhere(['ilike', 'no_sep', $this->no_sep])
            ->andFilterWhere(['ilike', 'is_print', $this->is_print])
            ->andFilterWhere(['ilike', 'lambar', $this->lambar]);
        $query->groupBy('registrasi.kode');
        return $dataProvider;
    }

    public function searchPasien($params)
    {
        $query = Pasien::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
        if ($this->kode) {
            $query->andFilterWhere(['ilike', Pasien::tableName() . '.kode', $this->kode]);
        }
        if ($this->nama) {
            $query->andFilterWhere(['ilike', Pasien::tableName() . '.nama', $this->nama]);
        }
        if ($this->tgl_lahir) {
            $query->andFilterWhere([Pasien::tableName() . '.tgl_lahir' => $this->tgl_lahir]);
        }
        if ($this->ibu_nama) {
            $query->andFilterWhere(['ilike', Pasien::tableName() . '.ibu_nama', $this->ibu_nama]);
        }
        if ($this->ayah_nama) {
            $query->andFilterWhere(['ilike', Pasien::tableName() . '.ayah_nama', $this->ayah_nama]);
        }
        $query->andFilterWhere(['ilike', Pasien::tableName() . '.kode', $this->kode])
            ->andFilterWhere(['ilike', Pasien::tableName() . '.nama', $this->nama])
            ->andFilterWhere(['ilike', 'created_by', $this->created_by])
            ->andFilterWhere(['ilike', 'updated_by', $this->updated_by])
            ->groupBy('kode');

        return $dataProvider;
    }
    public function searchLaporan($params)
    {
        $query = Registrasi::find();
        $query->joinWith([
            'pasien',
            'layanan',
            'analisaDokumen'
        ])->where(['not', ['pendaftaran.registrasi.tgl_keluar' => null]]);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,

        ]);
        $dataProvider->sort->attributes['tgl_masuk'] = [
            'asc' => [self::tableName() . '.tgl_masuk' => SORT_ASC],
            'desc' => [self::tableName() . '.tgl_masuk' => SORT_DESC],
        ];

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
        if ($this->tgl_masuk) {
            $query->andFilterWhere(['between', Registrasi::tableName() . '.tgl_masuk', Yii::$app->formatter->asDate($this->tgl_masuk . ' 00:00:01', 'php:Y-m-d H:i:s'), Yii::$app->formatter->asDate($this->tgl_masuk . ' 23:59:59', 'php:Y-m-d H:i:s')]);
        }

        if ($this->tgl_keluar) {
            $query->andFilterWhere(['between', Registrasi::tableName() . '.tgl_keluar', Yii::$app->formatter->asDate($this->tgl_keluar . ' 00:00:01', 'php:Y-m-d H:i:s'), Yii::$app->formatter->asDate($this->tgl_keluar . ' 23:59:59', 'php:Y-m-d H:i:s')]);
        }

        if (!empty($params['RegistrasiSearch']['tgl_awal'])) {
            $query->andFilterWhere(['>=', new Expression('date (' . AnalisaDokumen::tableName() . '.created_at)'), $params['RegistrasiSearch']['tgl_awal']]);
        }
        if (!empty($params['RegistrasiSearch']['tgl_akhir'])) {
            $query->andFilterWhere(['<=', new Expression('date (' . AnalisaDokumen::tableName() . '.created_at)'), $params['RegistrasiSearch']['tgl_akhir']]);
        }

        $query->andFilterWhere([
            'or',
            ['ilike', Pasien::tableName() . '.kode', $this->pasien],
            ['ilike', Pasien::tableName() . '.nama', $this->pasien],
        ]);

        $query->andFilterWhere(['ilike', 'kode', $this->kode])
            ->andFilterWhere(['ilike', 'pasien_kode', $this->pasien_kode])
            ->andFilterWhere(['ilike', 'kiriman_detail_kode', $this->kiriman_detail_kode])
            ->andFilterWhere(['ilike', 'debitur_detail_kode', $this->debitur_detail_kode])
            ->andFilterWhere(['ilike', 'created_by', $this->created_by])
            ->andFilterWhere(['ilike', 'updated_by', $this->updated_by])
            ->andFilterWhere(['ilike', 'no_sep', $this->no_sep])
            ->andFilterWhere(['ilike', 'is_print', $this->is_print])
            ->andFilterWhere(['ilike', 'lambar', $this->lambar]);

        return $dataProvider;
    }
}
