<?php

namespace app\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\pendaftaran\Layanan;
use app\models\pendaftaran\Pasien;
use app\models\pegawai\TbPegawai;
use app\models\medis\Pjp;
use app\components\HelperSpesialClass;
use Yii;
/**
 * LayananIgdSearch represents the model behind the search form of `app\models\pendaftaran\Layanan`.
 */
class LayananIgdSearch extends Layanan
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
            [['pasien','pjp'], 'safe'],
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
        $query = Layanan::find();
        $query->joinWith([
            'registrasi.pasien',
            'pjp.pegawai'
            ]);
        if($user['akses_level']==HelperSpesialClass::LEVEL_DOKTER){
            $query->andWhere([
                Pjp::tableName() . '.pegawai_id'=> $user['pegawai_id']
            ]);
        }else{
            $akses_pengguna=HelperSpesialClass::getListIGDAksesPegawai(false,$user);
            if(!$akses_pengguna['unit_akses']){
                $akses_pengguna['unit_akses']=[0];
            }
            $query->andWhere(parent::tableName().'.unit_kode IN ('.implode(',',$akses_pengguna['unit_akses']).')');
        }
        // echo'<pre/>';print_r($user);die();
        // echo'<pre/>';print_r($query->asArray()->all());die();
        // add conditions that should always apply here
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => [
                    'tgl_masuk' => SORT_DESC
                ]
                // ,'defaultOrder' => []
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
            return $dataProvider;
        }
        // $this->jenis_layanan=self::IGD;
        if(!$this->tgl_masuk){
            $this->tgl_masuk=date('Y-m-d');
            // $this->tgl_masuk='2021-01-04';
        }
        // grid filtering conditions
        $query->andFilterWhere([
            Layanan::tableName() . '.jenis_layanan' => $this->jenis_layanan,
            Layanan::tableName() . '.unit_kode' => $this->unit_kode,
            ]);
        if($this->tgl_masuk){
            $query->andFilterWhere(['between', Layanan::tableName() . '.tgl_masuk', Yii::$app->formatter->asDate($this->tgl_masuk.' 00:00:01', 'php:Y-m-d H:i:s'), Yii::$app->formatter->asDate($this->tgl_masuk.' 23:59:59', 'php:Y-m-d H:i:s')]);
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
