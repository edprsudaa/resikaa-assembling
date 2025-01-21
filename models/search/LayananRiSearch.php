<?php

namespace app\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\pendaftaran\Layanan;
use app\models\pendaftaran\Registrasi;

use app\models\pendaftaran\Pasien;
use app\models\pegawai\TbPegawai;
use app\models\medis\PjpRi;
use app\components\HelperSpesialClass;
use Yii;

/**
 * LayananRiSearch represents the model behind the search form of `app\models\pendaftaran\Layanan`.
 */
class LayananRiSearch extends Layanan
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
            [['registrasi_kode', 'tgl_masuk', 'tgl_keluar', 'kamar_id', 'kelas_rawat_kode', 'dokter_kode', 'unit_asal_kode', 'unit_tujuan_kode', 'cara_masuk_unit_kode', 'cara_keluar_kode', 'status_keluar_kode', 'keterangan', 'created_at', 'updated_at', 'deleted_at'], 'safe'],
            [['pasien', 'pjp'], 'safe'],
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
    public function search($params, $user)
    {
        $query = Layanan::find();
        $query->joinWith([
            'registrasi' => function ($q) {
                $q->joinWith(['pjpRi', 'pasien']);
            }, 'catatanMpp'
        ]);
        if ($user['akses_level'] == HelperSpesialClass::LEVEL_DOKTER) {
            $query->andWhere([
                PjpRi::tableName() . '.pegawai_id' => $user['pegawai_id']
            ]);
        } else {
            $akses_pengguna = HelperSpesialClass::getListRIAksesPegawai(false, $user);
            if (!$akses_pengguna['unit_akses']) {
                $akses_pengguna['unit_akses'] = [0];
            }
            //$query->andWhere(parent::tableName().'.unit_kode IN ('.implode(',',$akses_pengguna['unit_akses']).')');
            $query->andWhere(['in', parent::tableName() . '.unit_kode', $akses_pengguna['unit_akses']]);
        }
        // add conditions that should always apply here
        // echo'<pre/>';print_r($query->asArray()->all());die();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => [
                    'tgl_masuk' => SORT_DESC
                ]
            ],
            'pagination' => [
                'pageSize' => 10
            ]
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
        $this->jenis_layanan = self::RI;
        // grid filtering conditions
        $query->andFilterWhere([
            Layanan::tableName() . '.jenis_layanan' => $this->jenis_layanan,
            Layanan::tableName() . '.unit_kode' => $this->unit_kode,
        ]);
        if ($this->tgl_masuk) {
            $query->andFilterWhere(['between', Layanan::tableName() . '.tgl_masuk', Yii::$app->formatter->asDate($this->tgl_masuk . ' 00:00:01', 'php:Y-m-d H:i:s'), Yii::$app->formatter->asDate($this->tgl_masuk . ' 23:59:59', 'php:Y-m-d H:i:s')]);
        }
        if ($this->tgl_keluar) {
            $query->andFilterWhere(['between', Layanan::tableName() . '.tgl_keluar', Yii::$app->formatter->asDate($this->tgl_keluar . ' 00:00:01', 'php:Y-m-d H:i:s'), Yii::$app->formatter->asDate($this->tgl_keluar . ' 23:59:59', 'php:Y-m-d H:i:s')]);
        }
        $query->andFilterWhere([
            'or',
            ['ilike', Pasien::tableName() . '.kode', $this->pasien],
            ['ilike', Pasien::tableName() . '.nama', $this->pasien],
            ['ilike', Layanan::tableName() . '.registrasi_kode', $this->pasien]
        ]);
        $query->andFilterWhere([
            'ilike', TbPegawai::tableName() . '.nama_lengkap', $this->pjp
        ]);
        $query->groupBy([Layanan::tableName() . '.id', Layanan::tableName() . '.jenis_layanan', Layanan::tableName() . '.unit_kode', Layanan::tableName() . '.tgl_masuk', Layanan::tableName() . '.tgl_keluar']);
        return $dataProvider;
    }
    public function searchMpp($params, $user)
    {
        $query = Layanan::find();
        $query->innerJoinWith([
            'registrasi' => function ($q) {
                $q->joinWith(['pjpRi', 'pasien']);
            }
        ])->joinWith(['catatanMpp', 'resumemedisri']);
        if ($user['akses_level'] == HelperSpesialClass::LEVEL_DOKTER) {
            $query->andWhere([
                PjpRi::tableName() . '.pegawai_id' => $user['pegawai_id']
            ]);
        } else {
            $akses_pengguna = HelperSpesialClass::getListRIAksesPegawai(false, $user);
            if (!$akses_pengguna['unit_akses']) {
                $akses_pengguna['unit_akses'] = [0];
            }
            if (!empty(HelperSpesialClass::isMppUnit())) {
                $unit = HelperSpesialClass::isMppUnit();
            } else {
                $unit = ['0'];
            }
            $unit =
                //$query->andWhere(parent::tableName().'.unit_kode IN ('.implode(',',$akses_pengguna['unit_akses']).')');
                $query->andWhere(['in', parent::tableName() . '.unit_kode', $unit]);
        }
        // add conditions that should always apply here
        // echo'<pre/>';print_r($query->asArray()->all());die();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => [
                    'tgl_masuk' => SORT_DESC
                ]
            ],
            'pagination' => [
                'pageSize' => 20
            ]
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
        $this->jenis_layanan = self::RI;
        // grid filtering conditions
        $query->andFilterWhere([
            Layanan::tableName() . '.jenis_layanan' => $this->jenis_layanan,
            Layanan::tableName() . '.unit_kode' => $this->unit_kode,
        ]);

        if ($this->tgl_masuk) {
            $query->andFilterWhere(['between', Layanan::tableName() . '.tgl_masuk', Yii::$app->formatter->asDate($this->tgl_masuk . ' 00:00:01', 'php:Y-m-d H:i:s'), Yii::$app->formatter->asDate($this->tgl_masuk . ' 23:59:59', 'php:Y-m-d H:i:s')]);
        }
        if ($this->tgl_keluar) {
            $query->andFilterWhere(['between', Layanan::tableName() . '.tgl_keluar', Yii::$app->formatter->asDate($this->tgl_keluar . ' 00:00:01', 'php:Y-m-d H:i:s'), Yii::$app->formatter->asDate($this->tgl_keluar . ' 23:59:59', 'php:Y-m-d H:i:s')]);
        }
        $query->andWhere([
            Registrasi::tableName() . '.tgl_keluar' => null,
            Layanan::tableName() . '.tgl_keluar' => null


        ]);
        $query->andFilterWhere([
            'or',
            ['ilike', Pasien::tableName() . '.kode', $this->pasien],
            ['ilike', Pasien::tableName() . '.nama', $this->pasien],
            ['ilike', Layanan::tableName() . '.registrasi_kode', $this->pasien]
        ]);
        $query->andFilterWhere([
            'ilike', TbPegawai::tableName() . '.nama_lengkap', $this->pjp
        ]);
        $query->groupBy([Layanan::tableName() . '.id', Layanan::tableName() . '.jenis_layanan', Layanan::tableName() . '.unit_kode', Layanan::tableName() . '.tgl_masuk', Layanan::tableName() . '.tgl_keluar']);
        return $dataProvider;
    }
    public function searchLayanan($params, $user)
    {
        $query = Layanan::find();
        $query->innerjoinWith([
            'registrasi' => function ($q) {
                $q->joinWith(['pjpRi', 'pasien']);
            }
        ]);
        $query->andWhere([parent::tableName() . '.tgl_keluar' => null]);
        // $query->andWhere(['not', [parent::tableName().'.tgl_keluar' => null]]);
        if ($user['akses_level'] == HelperSpesialClass::LEVEL_DOKTER) {
            $query->andWhere([
                PjpRi::tableName() . '.pegawai_id' => $user['pegawai_id']
            ]);
            $query->andWhere([PjpRi::tableName() . '.tanggal_akhir' => null]);
            // $query->andWhere(['not', [PjpRi::tableName().'.tanggal_akhir' => null]]);
        } else {

            $akses_pengguna = HelperSpesialClass::getListRIAksesPegawai(false, $user);
            if (!$akses_pengguna['unit_akses']) {
                $akses_pengguna['unit_akses'] = [0];
            }
            //$query->andWhere(parent::tableName().'.unit_kode IN ('.implode(',',$akses_pengguna['unit_akses']).')');
            $query->andWhere(['in', parent::tableName() . '.unit_kode', $akses_pengguna['unit_akses']]);
        }
        // add conditions that should always apply here
        // echo'<pre/>';print_r($query->asArray()->all());die();
        //$query->asArray()->all();
        //echo'<pre/>';print_r($query->createCommand()->getRawSql());die();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => [
                    'tgl_masuk' => SORT_DESC
                ]
            ],
            'pagination' => [
                'pageSize' => 10
            ]
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
        $this->jenis_layanan = self::RI;
        // grid filtering conditions
        $query->andFilterWhere([
            Layanan::tableName() . '.jenis_layanan' => $this->jenis_layanan,
        ]);
        $query->andFilterWhere(['in', Layanan::tableName() . '.unit_kode', HelperSpesialClass::isMppUnit()]);
        if ($this->tgl_masuk) {
            $query->andFilterWhere(['between', Layanan::tableName() . '.tgl_masuk', Yii::$app->formatter->asDate($this->tgl_masuk . ' 00:00:01', 'php:Y-m-d H:i:s'), Yii::$app->formatter->asDate($this->tgl_masuk . ' 23:59:59', 'php:Y-m-d H:i:s')]);
        }
        if ($this->tgl_keluar) {
            $query->andFilterWhere(['between', Layanan::tableName() . '.tgl_keluar', Yii::$app->formatter->asDate($this->tgl_keluar . ' 00:00:01', 'php:Y-m-d H:i:s'), Yii::$app->formatter->asDate($this->tgl_keluar . ' 23:59:59', 'php:Y-m-d H:i:s')]);
        }
        $query->andFilterWhere([
            'or',
            ['ilike', Pasien::tableName() . '.kode', $this->pasien],
            ['ilike', Pasien::tableName() . '.nama', $this->pasien],
            ['ilike', Layanan::tableName() . '.registrasi_kode', $this->pasien]
        ]);
        $query->andFilterWhere([
            'ilike', TbPegawai::tableName() . '.nama_lengkap', $this->pjp
        ]);
        return $dataProvider;
    }
}
