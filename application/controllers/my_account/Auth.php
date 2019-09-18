<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Auth extends MY_account_Controller{
	function _construct(){
		parent::__construct();
	}
	public function index(){
		if($this->input->server('REQUEST_METHOD') === 'POST'){
			$this->load->model('my_account/auth_model');
			$formData=$this->input->post();
			$data=$this->auth_model->login(); 
			// debug($data);
			if(!empty($data) > 0){
				foreach($data[0] as $key => $value){
					$userData[$key]=$value;
				}
				unset($data[0]);
				$this->session->set_userdata($userData);
				redirect('my_account/dashboard');
			}else{
				$this->session->set_userdata('errors','Invalid username or password');
				redirect($_SERVER['HTTP_REFERER']);
			}
		}
		$this->load->view('my_account/login');
	}
	public function logout(){
		if($this->isLoggedIn()){
			$allUserdata=$this->session->all_userdata();
			$this->session->unset_userdata($allUserdata);
			$this->session->sess_destroy();
			redirect('my_account/auth');
		}
	}
}