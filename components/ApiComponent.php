<?php

namespace app\components;

use linslin\yii2\curl\Curl;
use yii\base\Component;

class ApiComponent extends Component
{
    public $header, $setup, $response, $base_url, $url, $params;
    function __construct()
    {
        date_default_timezone_set('Asia/Jakarta');
        $this->header = [
            "User-Agent" => NULL,
            "Content-Type" => 'Application/x-www-form-urlencoded',
        ];
        $this->setup = [
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_SSL_CIPHER_LIST => 'DEFAULT:!DH'
        ];
    }

    public function run($url, $data)
    {
        $this->url = $url;
        if (isset($data)) {
            $this->params = $data;
        }

        $curl = new Curl();
        $curl->setHeaders($this->header);
        $curl->setOptions($this->setup);
        $curl->setPostParams($this->params);
        $response = json_decode($curl->post($this->url));
        return $response;
    }
}
