<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
require_once(APPPATH."controllers/accounting/ERPController.php");
class Users extends ERPController{
	function __construct(){
		parent::__construct();
		if(!$this->isLoggedIn()){
			redirect('auth');
		}
		$this->load->model('common_model');
		$this->load->model('user_model');

	}
	public function index($type=null){
		if($type=='ng'){
			$data['allUsers']=$this->user_model->getAll('users');
			echo json_encode($data['allUsers']);exit();
		}else{
			
			$data['active']='Customer';
			$data['module']='accounting';
			$data['allUsers']=$this->user_model->getAll('users');
			$this->displayView('accounting/customers/customer_view_list',$data,array(),array(
					'js'=>array(),
					'css'=>array(),
				));
		}
	}
	public function addUser($id=null){
		$data['active']='Customer';
		$data['module']='accounting';
		if($this->input->server('REQUEST_METHOD') === 'POST'){
			$formData=$this->input->post();
			unset($formData['submit']);
			$formData['dob']=date('Y-m-d',strtotime($formData['dob']));
			$formData['password']=md5($formData['password']);
			if(isset($formData['id']) && !empty($formData['id'])){
				$update=$this->user_model->update('users',array('id'=>$formData['id']),$formData);
				if($update){
					$this->session->set_flashdata('success',con_lang('mass_record_updated_successfully'));
					redirect($_SERVER['HTTP_REFERER']);
				}else{
					$this->session->set_flashdata('error',con_lang('mass_error_occurrs_try_later'));
					redirect($_SERVER['HTTP_REFERER']);
				}
			}else{
				$result=$this->user_model->getOne('users',array('email'=>$formData['email']));
				if(isset($result->email) && !empty($result->email)){
					$this->session->set_flashdata('error',con_lang('mass_email_already_exist'));
					$data['model']=$this->input->post();
				}else{
					$saved=$this->user_model->add('users',$formData);
					if($saved){
						$this->session->set_flashdata('success',con_lang('mass_record_added_successfully'));
						redirect($_SERVER['HTTP_REFERER']);
					}else{
						$this->session->set_flashdata('error',con_lang('mass_error_occurrs_try_later'));
						redirect($_SERVER['HTTP_REFERER']);
					}
				}
			}
		}
		if(isset($id) && $id!=null){
			$data['model']=(array)$this->user_model->getById('users',$id);
		}
		$this->displayView('accounting/customers/add_customer',$data,array(),array(
				'js'=>array(),
				'css'=>array(),
			));
	}
}