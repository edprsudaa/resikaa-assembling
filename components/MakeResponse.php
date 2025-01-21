<?php
namespace app\components;
class MakeResponse
{
    public static function create($status, $msg = null, $data = null)
	{
		$_res = new \stdClass();
		$_res->status = $status == true ? true : false;
		$_res->msg = $msg;
		$_res->data = $data;
		\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
		return $_res;
	}
	public static function createNotJson($status, $msg = null, $data = null)
	{
		$_res = new \stdClass();
		$_res->status = $status == true ? true : false;
		$_res->msg = $msg;
		$_res->data = $data;
		return $_res;
	}
}
?>