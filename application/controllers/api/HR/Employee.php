<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Employee extends MY_Controller {

    public function __construct(){
        parent::__construct();
    }

	public function index(){sleep(5);
		try{
            // $this->form_validation->set_rules('username', 'Username', 'trim|required|alpha_numeric|max_length[255]');
            // $this->form_validation->set_rules('password', 'Password', 'trim|required|alpha_numeric|max_length[255]');

            // if($this->form_validation->run() == false){
            // 	$error_array = $this->form_validation->error_array();
            //     throw new Exception(reset($error_array));
            // }

            // $username = trim($_POST["username"]);
            // $password = trim($_POST["password"]);
            $table = "user";
            $params = [
                "user" => ["user.user_id", "user.user_name", "user.email", "user.phone", "user.user_status", "user.created_at"],
                "master_department" => ["master_department.department_id", "master_department.department_name"],
                "master_role" => ["master_role.role_id", "master_role.role_name"],
            ];
            $filters = [];

            $users = $this->model->gets($table, $params, $filters);

            echo $this->json_library->success([ "users" => $users ], "Successfully fetch.");
            
        }catch(Exception $e){
            echo $this->json_library->error($e->getmessage());
        }
	}
}