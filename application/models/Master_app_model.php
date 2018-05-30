<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Master_app_model extends CI_model{

    function __construct(){
        parent::__construct();
    }

    public function get_app_by_constant($app_constant = ""){
    	$table = "master_app";
    	$params = [ "app_id", "app_name" ];
    	$filters = ["app_constant" => $app_constant];
    	$data = $this->model->get($table, $params, $filters);
    	return $data;
    }
}