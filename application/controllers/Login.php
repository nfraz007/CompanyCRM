<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends MY_Controller {

	public function login(){
		$this->load->view("login");
	}
}