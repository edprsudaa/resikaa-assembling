<?php

/*
 * @Author: Dicky Ermawan S., S.T., MTA 
 * @Email: wanasaja@gmail.com 
 * @Web: dickyermawan.github.io 
 * @Linkedin: linkedin.com/in/dickyermawan 
 * @Date: 2020-04-20 00:41:18 
 * @Last Modified by: Dicky Ermawan S., S.T., MTA
 * @Last Modified time: 2021-01-11 15:24:43
 */

namespace app\models\sip;

use yii\helpers\ArrayHelper;
use yii\httpclient\Client;


/**
 * This is the ActiveQuery class for [[\app\models\pegawai\Unit]].
 *
 * @see \app\models\pegawai\Unit
 */
class PegawaiQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return \app\models\pegawai\Unit[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return \app\models\pegawai\Unit|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }


    public function select2()
    {
        $result = $this->all();
        return ArrayHelper::map($result, 'id_nip_nrp', 'nama_lengkap');
    }
    public function select2Edp()
    {
        $idEdp = [
            '1471062008970021',
            '1403092308940009',
            '1472012108970004',
            '1401036407990002',
            '1471046109990001',
            '1471021105990021',
            '1471080201900021',
            '1401020907180001',
            '1471102605960025',
            '1403092401942287',
            '1408100401930004',
            '1472011801850001',
            '1471083105900001',
            '1304130806930001',
            '1471082312920021',
            '1401071109920002',
            '1401192504930002',
            '1471102811980022',
            '1471076405790041',
            '1471096004830001',
            '1471091107770022',
            '196911181994031004',
        ];

        $result = $this
            ->where([
                'id_nip_nrp' => $idEdp,
            ])
            ->all();
        return ArrayHelper::map($result, 'id_nip_nrp', 'nama_lengkap');
    }
}
