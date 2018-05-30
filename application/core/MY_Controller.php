<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// this is core controller, all login data will come here
class MY_Controller extends CI_Controller {

	// for storing user data after verifiing token
	public $user = array();
	public $app = array();

	public function __construct(){
		parent::__construct();

		// set default time zone
		date_default_timezone_set("Asia/Kolkata");

		// load my custom library
		// check whether request is for api or web
		if($this->uri->segment(1) == "api"){
			if(isset($_GET["api_token"])) {
				$app_name = $this->uri->segment(2);
				$module_name = $this->uri->segment(3);
				$this->app = $this->master_module_model->get_module_by_url(implode("/", [$app_name, $module_name]));
			}

			$this->check_api_token("api");
		}else{
			if(isset($_GET["api_token"])) {
				$app_name = $this->uri->segment(1);
				$module_name = $this->uri->segment(2);
				$this->app = $this->master_module_model->get_module_by_url(implode("/", [$app_name, $module_name]));
			}

			$this->check_api_token("web");
			$this->load_header($this->user);
		}
	}

	public function load_header($data) {
        $this->load->view("include/header", $data);
	}

	public function check_api_token($type = "") {
		//Can user see this page
		$api_token = (isset($_GET["api_token"])) ? $_GET["api_token"] : "";
		$data = $this->token_library->verify_api_token($api_token);
		if($data["status"]){
			$this->user = $data["user"];
			$this->user["permissions"] = $this->user_model->get_user_permissions($this->user["user_id"]);
			$this->user["apps"] = $this->user_model->get_user_app($this->user["user_id"]);
			$this->user["modules"] = $this->user_model->get_user_module($this->user["user_id"]);
		}else{
			// $this->load->view("auth/login");
			if($type == "web") redirect(base_url());
			elseif($type == "api"){
				echo json_encode($data);
				die;
			}
		}
    }

    public function get_full_uri(){
    	$uri = "";

    	if($this->uri->segment(1)) $uri = $uri . $this->uri->segment(1);
    	if($this->uri->segment(2)) $uri = $uri ."/". $this->uri->segment(2);
    	if($this->uri->segment(3)) $uri = $uri ."/". $this->uri->segment(3);
    	if($this->uri->segment(4)) $uri = $uri ."/". $this->uri->segment(4);
    	if($this->uri->segment(5)) $uri = $uri ."/". $this->uri->segment(5);

    	return $uri;
    }

    public function get_url_data(){
    	return ["base_url" => base_url(), "full_uri" => $this->get_full_uri(), "full_url" => base_url($this->get_full_uri())];
    }
}