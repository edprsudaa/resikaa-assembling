<?php

namespace app\models\sip;

use app\models\AkunAknUser;
use Yii;
use yii\helpers\Url;

class Pegawai extends \yii\db\ActiveRecord
{

    public static function getDb()
    {
        return Yii::$app->get('db_pegawai');
    }

    public static function tableName()
    {
        return 'pegawai.tb_pegawai';
    }

    public function getNama()
    {
        return ($this->gelar_sarjana_depan ? $this->gelar_sarjana_depan . ' ' : null) . $this->nama_lengkap . ($this->gelar_sarjana_belakang ? ', ' . $this->gelar_sarjana_belakang : null);
    }
    public function getNip()
    {
        $batas = " ";
        $nip = trim($this->id_nip_nrp, " ");
        $sub[] = substr($nip, 0, 8); // tanggal lahir
        $sub[] = substr($nip, 8, 6); // tanggal pengangkatan
        $sub[] = substr($nip, 14, 1); // jenis kelamin
        $sub[] = substr($nip, 15, 17); // nomor urut

        return $sub[0] . $batas . $sub[1] . $batas . $sub[2] . $batas . $sub[3];
    }
    public function getNipNikPegawai()
    {
        return $this->id_nip_nrp ?? null;
    }
    public function getFotoPegawai()
    {
        $iconPerson = $this->jenis_kelamin == 'Laki-Laki' ? 'person-man.svg' : 'person-woman-hijab.svg';
        // return $this->photo ? 'http://sip.simrs.aa/fotoprofil/' . $this->photo : Url::to('@web/img/' . $iconPerson);
        return $this->photo ? $this->photo : Url::to('@web/img/' . $iconPerson);
    }

    public function getRiwayatPenempatan()
    {
        return $this->hasOne(RiwayatPenempatan::className(), ['id_nip_nrp' => 'id_nip_nrp'])
            ->orderBy(['id' => SORT_DESC]);
    }

    public function getRiwayatKepangkatan()
    {
        return $this->hasOne(RiwayatKepangkatan::className(), ['nip' => 'id_nip_nrp'])
            ->orderBy(['sk_tanggal_pangkat' => SORT_DESC]);
    }

    public function getUser()
    {
        return $this->hasOne(AkunAknUser::className(), ['username' => 'id_nip_nrp']);
    }

    public function getIs_direktur()
    {
        return $this->nip == '19640202 198912 1 002';
    }

    public function getJabatan()
    {
        return $this->riwayatPenempatan->unitSubPenempatan->nama;
    }

    /**
     * {@inheritdoc}
     * @return \app\models\pegawai\PegawaiQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\sip\PegawaiQuery(get_called_class());
    }
}
