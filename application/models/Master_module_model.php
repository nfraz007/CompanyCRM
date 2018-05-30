<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Master_module_model extends CI_model{

    function __construct(){
        parent::__construct();
    }

    public function get_module_by_url($module_url = ""){
    	$table = "master_module";
    	$params = [ 
            "master_module" => ["master_module.module_id", "master_module.module_name"],
            "master_app" => ["master_app.app_id", "master_app.app_name"],
        ];
    	$filters = ["master_module.module_url" => $module_url];
    	$data = $this->model->gets($table, $params, $filters);
    	return reset($data);
    }
}