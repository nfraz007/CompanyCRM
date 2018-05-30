<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth_library {
	protected $CI;

	public function __construct() {
		$this->CI =& get_instance();
	}

	public function password_verify($password = "", $password_hash = ""){
		// $password = sha1(md5($password));
		$password = $password;
		if($password == $password_hash) return true;
		else return false;
	}
}