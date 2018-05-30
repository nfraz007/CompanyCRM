<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Employee extends MY_Controller {

	public function __construct(){
		parent::__construct();
	}

	public function index(){
		$this->load->view("hr/employee/employee_view");
	}

	public function employee_add(){
		$this->load->view("hr/employee/employee_add");
	}
}