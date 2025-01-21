<?php

namespace app\models\pendaftaran;
use yii\helpers\ArrayHelper;
use app\models\pegawai\DmUnitPenempatan;
/**
 * This is the ActiveQuery class for [[KelompokUnitLayanan]].
 *
 * @see KelompokUnitLayanan
 */
class KelompokUnitLayananQuery extends \yii\db\ActiveQuery
{
    public function init()
    {
        $this->andOnCondition(KelompokUnitLayanan::tableName().'.deleted_at is null');
        parent::init();
    }
    public function kel_igd()
    {
        return $this->andWhere([KelompokUnitLayanan::tableName().'.type'=>KelompokUnitLayanan::IGD]);
    }
    public function kel_rj()
    {
        return $this->andWhere([KelompokUnitLayanan::tableName().'.type'=>KelompokUnitLayanan::RJ]);
    }
    public function kel_ri()
    {
        return $this->andWhere([KelompokUnitLayanan::tableName().'.type'=>KelompokUnitLayanan::RI]);
    }
    public function kel_penunjang()
    {
        return $this->andWhere([KelompokUnitLayanan::tableName().'.type'=>KelompokUnitLayanan::PENUNJANG]);
    }
    public function kel_rjutama()
    {
        return $this->andWhere([KelompokUnitLayanan::tableName().'.type'=>KelompokUnitLayanan::RJUTAMA]);
    }
    public function kel_rj_all()
    {
        return $this->andWhere(['or',
            [KelompokUnitLayanan::tableName().'.type'=>KelompokUnitLayanan::RJ],
            [KelompokUnitLayanan::tableName().'.type'=>KelompokUnitLayanan::RJUTAMA],
        ]);
    }
    public function kel_analisa()
    {
        return $this->andWhere(['or',
            [KelompokUnitLayanan::tableName().'.type'=>KelompokUnitLayanan::RJ],
            [KelompokUnitLayanan::tableName().'.type'=>KelompokUnitLayanan::RI],
            [KelompokUnitLayanan::tableName().'.type'=>KelompokUnitLayanan::IGD],
        ]);
    }
    /**
     * {@inheritdoc}
     * @return KelompokUnitLayanan[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }
    /**
     * {@inheritdoc}
     * @return KelompokUnitLayanan|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
