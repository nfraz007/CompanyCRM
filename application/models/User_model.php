<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class User_model extends CI_model{

    function __construct(){
        parent::__construct();
    }

    // function will return all user permissions
    public function get_user_permissions($user_id = ""){
    	$table = "user_permission";
    	$params = [ 
    		"user_permission" => ["user_permission.user_id"], 
    		"master_permission" => ["master_permission.permission_id", "master_permission.permission_constant"],
    	];
    	$filters = ["user_permission.user_id" => $user_id];
    	$data = $this->model->gets($table, $params, $filters);
    	return $data;
    }

    // function will return user app_module tree
    public function get_user_app($user_id = ""){
    	$master = array();
    	$table = "user_permission";
    	$params = [ 
    		"user_permission" => ["user_permission.user_id"], 
    		"master_permission" => ["master_permission.app_id"],
    	];
    	$filters = ["user_permission.user_id" => $user_id];
    	$specials["group_by"] = "master_permission.app_id";
    	$user_permissions = $this->model->gets($table, $params, $filters, $specials);
    	foreach($user_permissions as $user_permission){
    		$table = ""; $params = array(); $filters = array(); $specials = array();
    		$table = "master_permission";
	    	$params = [ 
	    		"master_permission" => [""],
	    		"master_app" => ["master_app.app_id", "master_app.app_name"],
	    		// "master_module" => ["master_module.module_url"]
	    	];
	    	$filters = ["master_permission.app_id" => $user_permission["app_id"]];
	    	$specials["group_by"] = "master_app.app_id";
	    	$master_permission = $this->model->gets($table, $params, $filters, $specials);
	    	$master_permission = reset($master_permission);

	    	$table = ""; $params = array(); $filters = array(); $specials = array();
    		$table = "master_permission";
	    	$params = [ 
	    		"master_permission" => [""],
	    		"master_app" => ["master_app.app_id", "master_app.app_name"],
	    		"master_module" => ["master_module.module_id", "master_module.module_name", "master_module.module_url"],
	    	];
	    	$filters = ["master_permission.app_id" => $master_permission["app_id"]];
	    	$specials = ["group_by" => "master_module.module_id", "order_by" => "master_module.module_sort_order", "order_type" => "asc"];
	    	$master_permission["module"] = $this->model->gets($table, $params, $filters, $specials);
	    	// $master_permission = reset($master_permission);
	    	$master[] = $master_permission;
    	}
    	return $master;
    }

    // function will return user module based on app
    public function get_user_module($user_id = ""){
    	$table = "master_permission";
    	$params = [ 
    		"master_permission" => [""],
    		"master_app" => [""],
    		"master_module" => ["master_module.module_id", "master_module.module_name", "master_module.module_url"],
    	];
    	$filters = ["master_permission.app_id" => $this->app["app_id"]];
    	$specials = ["group_by" => "master_module.module_id", "order_by" => "master_module.module_sort_order", "order_type" => "asc"];
    	$master_permission = $this->model->gets($table, $params, $filters, $specials);
    	
    	return $master_permission;
    }
}