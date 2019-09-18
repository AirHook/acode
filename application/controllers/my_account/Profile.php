<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
class Profile extends MY_account_Controller{
	function __construct(){
		parent::__construct();
		if(!$this->isLoggedIn()){
			redirect('my_account/auth');
		}
		$this->load->model('my_account/common_model');
	}
	public function index(){
		$data['active']='profile';
		if($this->input->post())
		{
			$formData=$this->input->post();
			$update=$this->common_model->update('tbladmin_sales',array('admin_sales_id'=>$this->session->userdata('admin_sales_id')),$formData);
			if($update)
			{
				$this->session->set_userdata('success','Profile updated successfully');
			}
			else
			{
				$this->session->set_userdata('errors','Error occurred try later!');
			}
			redirect($_SERVER['HTTP_REFERER']);
		}
		$data['profiledata']=$this->common_model->getOne('tbladmin_sales',array('admin_sales_id'=>$this->session->userdata('admin_sales_id')));
		$this->displayView('my_account/profile',$data);
	}
}