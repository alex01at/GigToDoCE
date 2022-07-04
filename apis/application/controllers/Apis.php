<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Apis extends MY_Controller{
	// api to login Validate/Check login credential of the ("admin","doctor","pateint","nurse") 
	public function login(){
		$this->Db->login();
	}

	// api to register
	public function register(){
		if(empty($this->input->post())){
			echo "invalid";
		}else{
			$this->Db->register();
		}
	}

	// api to forgot password
	public function forgot(){
		if(empty($this->input->post())){
			echo "invalid";
		}else{
			$this->Db->forgot();
		}
	}

	// Get All Tables Data, Get All Tables Single/Row Data
	public function data($table,$id=""){
		$this->Db->data($table,$id);
	}
}