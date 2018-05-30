<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

	public function login(){
		try{
            $this->form_validation->set_rules('username', 'Username', 'trim|required|alpha_numeric|max_length[255]');
            $this->form_validation->set_rules('password', 'Password', 'trim|required|alpha_numeric|max_length[255]');

            if($this->form_validation->run() == false){
            	$error_array = $this->form_validation->error_array();
                throw new Exception(reset($error_array));
            }

            $username = trim($_POST["username"]);
            $password = trim($_POST["password"]);

            $user = $this->model->get("user", [ "user.user_id", "user.password", "user.email", "user.phone", "user.user_status" ], [ "user.user_name" => $username ]);

            if(!$user) throw new Exception("Incorrect username.");
            if($user["user_status"] == -1) throw new Exception("You are blocked.");
            if($user["user_status"] == 0) throw new Exception("You are inactive. Please wait for activation.");
            if(!$this->auth_library->password_verify($password, $user["password"])) throw new Exception("Incorrect Password.");

            // creadential is fine, lets login. gengerate a token and return the token in json, also store in db
            $api_token = $this->token_library->generate_api_token($user["user_id"]);

            echo $this->json_library->success([ "api_token" => $api_token ], "Login successful.");
            
        }catch(Exception $e){
            echo $this->json_library->error($e->getmessage());
        }
	}
}