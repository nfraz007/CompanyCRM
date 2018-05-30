<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Token_library {
	protected $CI;
	protected $api_token_expiry = 60*60*24; // 5 sec

	public function __construct() {
		$this->CI =& get_instance();
	}

	public function generate_api_token($user_id = ""){
		$now = time();
		$data = $user_id."///".$now;
		$api_token = $this->CI->encrypt->encode($data);

		// lets update in db
		$this->CI->model->update("user", [ "api_token" => $api_token ], [ "user_id" => $user_id]);

		$api_token = strtr($api_token, '+/=', '-_,');
		return $api_token;
	}

	public function verify_api_token($api_token = ""){
		try{
			if(!$api_token) throw new Exception("Api token required.");

			$now = time();
			$api_token = strtr($api_token, '-_,', '+/=');
			$data = $this->CI->encrypt->decode($api_token);

			if(!$data) throw new Exception("Incorrect Api Token..");
			
			$data = explode("///", $data);
			$user_id = $data[0];
			$time = $data[1];

			if(!$user_id || !$time) throw new Exception("Incorrect Api Token.");
			if($now - $time > $this->api_token_expiry) throw new Exception("Api Token Expired.");
			$user = $this->CI->model->get("user", [ "user_id", "user_name", "salute", "first_name", "last_name", "email", "phone", "department_id", "role_id", "user_status", "api_token" ], [ "user.user_id" => $user_id, "user.api_token" => $api_token ]);
			if(!$user) throw new Exception("Invalid Api Token.");
			
			return json_decode($this->CI->json_library->success([ "user" => $user ], "Token verification successfull."), true);
		}catch(Exception $e){
			return json_decode($this->CI->json_library->error($e->getMessage(), 401), true);
		}
	}
}