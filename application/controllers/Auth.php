<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

	public function login(){
		// echo 1;
		$this->load->view("auth/login");
	}
}