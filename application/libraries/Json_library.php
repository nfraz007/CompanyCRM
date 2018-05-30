<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Json_library {
	protected $CI;

	public function __construct() {
		$this->CI =& get_instance();
	}

	public function success($data = array(), $message = "", $code = 200){
		// code 200 is for success
		$data["message"] = $message;
		$data["status"] = true;
		$data["code"] = $code;
		return json_encode($data);
	}

	public function error($message = "", $code = 400){
		// code 400 for bad request or error
		// code 401 for unauthorize or when token get expire/invalid
		$data = [ "message" => $message, "status" => false, "code" => $code];
		return json_encode($data);
	}
}