<?php

namespace app\models\bedahsentral;

use app\models\pegawai\TbPegawai;
use app\models\sdm\Pegawai;
use Yii;

class PemberianObatPremedikasiAnestesi extends \yii\db\ActiveRecord
{
  /**
   * {@inheritdoc}
   */
  public static function tableName()
  {
    return 'bedah_sentral.pemberian_obat_premedikasi_anestesi';
  }

  /**
   * {@inheritdoc}
   */
  public function rules()
  {
    return [
      [['popa_nama_obat'], 'required'],
      [['popa_api_id', 'popa_pelaksana'], 'integer'],
      [['popa_nama_obat', 'popa_dosis'], 'string'],
      [['popa_jam', 'popa_created_at', 'popa_updated_at'], 'safe'],
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function attributeLabels()
  {
    return [
      'popa_id' => 'ID',
      'popa_api_id' => 'Api ID',
      'popa_nama_obat' => 'Nama Obat',
      'popa_dosis' => 'Dosis',
      'popa_jam' => 'Jam',
      'popa_pelaksana' => 'Pelaksana',
      'popa_created_at' => 'Created At',
      'popa_updated_at' => 'Updated At',
    ];
  }

  function getPegawai()
  {
    return $this->hasOne(TbPegawai::className(), ['pegawai_id' => 'popa_pelaksana']);
  }
}
