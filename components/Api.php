<?php
namespace app\components;
class Api
{
    public static function writeResponse($condition, $msg = null, $data = null)
	{
		$_res = new \stdClass();
		$_res->con = $condition == true ? true : false;
		$_res->msg = $msg;
		$_res->data = $data;
		return $_res;
	}
}
?>