<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Model extends CI_model{

    function __construct(){
        parent::__construct();
    }

    // this function is for update the table
    public function update($table_main = "", $params = array(), $filters = array()){
    	return $this->db->where($filters)->update($table_main, $params);
    }

    // this function is for geting single data within the table
    public function get($table_main = "", $params_main = array(), $filters = array()){
    	$params[$table_main] = $params_main;
    	$specials["single"] = true;
    	return $this->gets($table_main, $params, $filters, $specials);
    }

    // this function is for getting multiple data within any table
    public function gets($table_main = "", $params = array(), $filters = array(), $specials = array()){
    	$this->db->from($table_main);
    	switch ($table_main){
		    case "master_app":
    			$primary_key = "app_id";
    			foreach ($params as $table => $param) {
		            switch ($table) {
		                case $table_main:
		                    $this->db->select($param);
		                    break;
		                case "master_module":
		                    $this->db->select($param);
		                    $this->db->join("master_module", "master_module.app_id = $table_main.$primary_key","left");
		                    break;
		            }
		        }
		        break;
		    case "master_module":
    			$primary_key = "module_id";
    			foreach ($params as $table => $param) {
		            switch ($table) {
		                case $table_main:
		                    $this->db->select($param);
		                    break;
		                case "master_app":
		                    $this->db->select($param);
		                    $this->db->join("master_app", "master_app.app_id = $table_main.app_id","left");
		                    break;
		            }
		        }
		        break;
		    case "master_permission":
    			$primary_key = "permission_id";
    			foreach ($params as $table => $param) {
		            switch ($table) {
		                case $table_main:
		                    $this->db->select($param);
		                    break;
		                case "master_app":
		                    $this->db->select($param);
		                    $this->db->join("master_app", "master_app.app_id = $table_main.app_id","left");
		                    break;
		                case "master_module":
		                    $this->db->select($param);
		                    $this->db->join("master_module", "master_module.module_id = $table_main.module_id","left");
		                    break;
		            }
		        }
		        break;
		    case "user":
    			$primary_key = "user_id";
    			foreach ($params as $table => $param) {
		            switch ($table) {
		                case $table_main:
		                    $this->db->select($param);
		                    break;
		                case "user_detail":
		                    $this->db->select($param);
		                    $this->db->join("user_detail", "user_detail.user_id = $table_main.$primary_key","left");
		                    break;
		                case "user_permission":
		                    $this->db->select($param);
		                    $this->db->join("user_permission", "user_permission.user_id = $table_main.$primary_key","left");
		                    break;
		                case "master_department":
		                    $this->db->select($param);
		                    $this->db->join("master_department", "master_department.department_id = $table_main.department_id","left");
		                    break;
		                case "master_role":
		                    $this->db->select($param);
		                    $this->db->join("master_role", "master_role.role_id = $table_main.role_id","left");
		                    break;
		            }
		        }
		        break;
		    case "user_permission":
    			$primary_key = "user_permission_id";
    			foreach ($params as $table => $param) {
		            switch ($table) {
		                case $table_main:
		                    $this->db->select($param);
		                    break;
		                case "user":
		                    $this->db->select($param);
		                    $this->db->join("user", "user.user_id = $table_main.user_id","left");
		                    break;
		                case "master_permission":
		                    $this->db->select($param);
		                    $this->db->join("master_permission", "master_permission.permission_id = $table_main.permission_id","left");
		                    break;
		                case "master_app":
		                    $this->db->select($param);
		                    $this->db->join("master_app", "master_app.app_id = $table_main.app_id","left");
		                    break;
		                case "master_module":
		                    $this->db->select($param);
		                    $this->db->join("master_module", "master_module.module_id = $table_main.module_id","left");
		                    break;
		            }
		        }
		        break;
    	}

        if(array_key_exists('filters_or', $specials)){
            $filters_or = $specials['filters_or'];
            if(count($filters_or) > 0) {
                $this->db->or_where($filters_or);
            }
        }

        if(array_key_exists('filters_in', $specials)){
            $filters_in = $specials['filters_in'];
            if(count($filters_in) > 0) {
                foreach ($filters_in as $column => $arrayValues) {
                    $this->db->group_start();
                    $chunks = array_chunk($arrayValues, 25);
                    foreach ($chunks as $chunk) {
                        $this->db->or_where_in($column, $chunk);
                    }
                    $this->db->group_end();
                }
            }
        }

        // Code for And Clause
        if($filters != "" || count($filters) > 0) {
            $this->db->where($filters);
        } 


        // Group By Clause
        if(array_key_exists('group_by', $specials)){
            $group_by = $specials['group_by'];
            if($group_by != "") {
                $this->db->group_by($group_by);
            }
        }

        // If there are any like queries
        if(array_key_exists('like', $specials)){
            $like = $specials['like'];
            if(count($like) > 0) {
                $this->db->like($like);
            }
        }


        // If there are search keys
        if(array_key_exists('search_key', $specials)){
            $search_key = $specials['search_key'];
            $search_in = $specials['search_in'];
            if(count($search_in) > 0) {
                    $this->db->group_start();
                    foreach($search_in as $key => $value){
                        $this->db->or_like($value,$search_key);
                    }
                    $this->db->group_end();
            }
        }
        
        // Order By Clause
        if(array_key_exists('order_by', $specials)){
            $order_by = $specials['order_by'];
            $order_type = $specials['order_type'];
            if($order_by != "") {
                $this->db->order_by($order_by, $order_type);
            }
        }

        if(array_key_exists('limit', $specials)){
            $limit = $specials['limit'];
             if($limit != null) {
                $this->db->limit($limit);
            }
        }

        if(array_key_exists('offset', $specials)){
            $offset = $specials['offset'];
            if($offset != null) {
                $this->db->offset($offset);
            }
        }

        if(array_key_exists('single', $specials)){
        	$single = $specials["single"];
        	if($single){
        		return $this->db->get()->row_array();
        	}
        }

        return $this->db->get()->result_array();//echo $this->db->last_query();die;
    }
}