<?php

namespace app\models\pendaftaran;

use Yii;

/**
 * This is the model class for table "pendaftaran.sep".
 *
 * @property int $id
 * @property string $registrasi_kode
 * @property string $no_sep
 * @property string $no_rujukan
 * @property string $no_kartu
 * @property string $tgl_rujukan
 * @property string $tgl_sep
 * @property string $asal_rujukan_kode
 * @property int $jenis_pelayanan 1=rawatinap,2=rawatjalan
 * @property int $kelas 1,2,3
 * @property string|null $poli_kode
 * @property string|null $poli_nama
 * @property string|null $diagnosa_kode
 * @property string|null $diagnosa_nama
 * @property int|null $is_kontrol_post_ri 0=N,1=Y
 * @property int|null $is_bridging 0=manual,1=bridging
 * @property int $created_by
 * @property string $created_at
 * @property int|null $updated_by
 * @property string|null $updated_at
 * @property int|null $is_deleted
 * @property string|null $pasien_kode
 * @property int|null $tingkat_faskes
 * @property int|null $is_cob
 * @property int|null $is_katarak
 * @property string|null $asal_rujukan_lama
 * @property int|null $is_poli_eksekutif
 * @property string|null $skdp_no_surat
 * @property string|null $dpjp_kode
 * @property string|null $dpjp_nama
 */
class Sep extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'pendaftaran.sep';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['registrasi_kode', 'no_sep', 'no_rujukan', 'no_kartu', 'tgl_rujukan', 'tgl_sep', 'asal_rujukan_kode', 'jenis_pelayanan', 'kelas', 'created_by', 'created_at'], 'required'],
            [['tgl_rujukan', 'tgl_sep', 'created_at', 'updated_at'], 'safe'],
            [['jenis_pelayanan', 'kelas', 'is_kontrol_post_ri', 'is_bridging', 'created_by', 'updated_by', 'is_deleted', 'tingkat_faskes', 'is_cob', 'is_katarak', 'is_poli_eksekutif'], 'default', 'value' => null],
            [['jenis_pelayanan', 'kelas', 'is_kontrol_post_ri', 'is_bridging', 'created_by', 'updated_by', 'is_deleted', 'tingkat_faskes', 'is_cob', 'is_katarak', 'is_poli_eksekutif'], 'integer'],
            [['registrasi_kode', 'asal_rujukan_kode', 'poli_kode', 'diagnosa_kode', 'pasien_kode'], 'string', 'max' => 10],
            [['no_sep', 'no_rujukan'], 'string', 'max' => 100],
            [['no_kartu', 'skdp_no_surat', 'dpjp_kode'], 'string', 'max' => 50],
            [['poli_nama', 'diagnosa_nama', 'asal_rujukan_lama', 'dpjp_nama'], 'string', 'max' => 255],
            [['registrasi_kode'], 'exist', 'skipOnError' => true, 'targetClass' => PendaftaranRegistrasi::className(), 'targetAttribute' => ['registrasi_kode' => 'no_daftar']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'registrasi_kode' => 'Registrasi Kode',
            'no_sep' => 'No Sep',
            'no_rujukan' => 'No Rujukan',
            'no_kartu' => 'No Kartu',
            'tgl_rujukan' => 'Tgl Rujukan',
            'tgl_sep' => 'Tgl Sep',
            'asal_rujukan_kode' => 'Asal Rujukan Kode',
            'jenis_pelayanan' => 'Jenis Pelayanan',
            'kelas' => 'Kelas',
            'poli_kode' => 'Poli Kode',
            'poli_nama' => 'Poli Nama',
            'diagnosa_kode' => 'Diagnosa Kode',
            'diagnosa_nama' => 'Diagnosa Nama',
            'is_kontrol_post_ri' => 'Is Kontrol Post Ri',
            'is_bridging' => 'Is Bridging',
            'created_by' => 'Created By',
            'created_at' => 'Created At',
            'updated_by' => 'Updated By',
            'updated_at' => 'Updated At',
            'is_deleted' => 'Is Deleted',
            'pasien_kode' => 'Pasien Kode',
            'tingkat_faskes' => 'Tingkat Faskes',
            'is_cob' => 'Is Cob',
            'is_katarak' => 'Is Katarak',
            'asal_rujukan_lama' => 'Asal Rujukan Lama',
            'is_poli_eksekutif' => 'Is Poli Eksekutif',
            'skdp_no_surat' => 'Skdp No Surat',
            'dpjp_kode' => 'Dpjp Kode',
            'dpjp_nama' => 'Dpjp Nama',
        ];
    }
}
