<?php defined('BASEPATH') OR exit('No direct script access allowed');
require_once(APPPATH."controllers/accounting/ERPController.php");
class Auth extends ERPController{
	function _construct(){
		parent::__construct();
	}
	public function index(){
		if($this->input->server('REQUEST_METHOD') === 'POST'){
			$this->load->model('auth_model');
			$data=$this->auth_model->login(); 
			if(sizeof($data) > 0){
					foreach($data[0] as $key => $value){
						$userData[$key]=$value;
					}
					unset($data[0]);
					$this->session->set_userdata($userData);
			
					if($this->session->userdata('role') == 'super_admin'){
						redirect('accounting/admin');
					} else if($this->session->userdata('active') == 1){
					   redirect('accounting/dashboard');
					} else{
						$this->session->set_flashdata('error', con_lang('mass_login_error'));
				        redirect($_SERVER['HTTP_REFERER']);
					}
			}else{
				$this->session->set_flashdata('error',con_lang('mass_invalid_error'));
				redirect($_SERVER['HTTP_REFERER']);
			}
		}
		$this->load->view('accounting/login-signup');
	}
	public function signup(){
		if($this->input->server('REQUEST_METHOD') === 'POST'){
			$formData=$this->input->post();
			$this->load->model('auth_model');
			unset($formData['submit']);
			$email=$this->auth_model->getById('tbl_users',array('email'=>$formData['email']));
			$companyNames=$this->auth_model->getById('tbl_company',array('companyName'=>$formData['company_name']));
			if(isset($companyNames->companyName) && $companyNames->companyName){
				$this->session->set_flashdata('error',con_lang('mass_company_already_exist'));
				redirect($_SERVER['HTTP_REFERER']);
			}else if(isset($email->email) && !empty($email->email)){
				   $this->session->set_flashdata('error',con_lang('mass_email_already_exist'));
					redirect($_SERVER['HTTP_REFERER']);
			}else{
				$userData['first_name']=$formData['first_name'];
				unset($formData['first_name']);
				$userData['last_name']=$formData['last_name'];
				unset($formData['last_name']);
				$userData['email']=$formData['email'];
				$compayData['emailId']=$formData['email'];
				unset($formData['email']);
				$formData['password']=md5($formData['password']);
				$userData['password']=$formData['password'];
				unset($formData['password']);
				$userData['role']='admin';
				$compayData['companyName']=$formData['company_name'];
				unset($formData['company_name']);
				$compayData['address']=$formData['company_address'];
				unset($formData['company_address']);

				$saved_company=$this->auth_model->add('tbl_company',$compayData);
				if($saved_company){
					$userData['company_id']=$saved_company;
				    $saved=$this->auth_model->add('tbl_users',$userData);
					if($saved){
						// adding default settings
						$payment_method = array(
							'name' => 'Cash',
							'is_active' => 1,
							'is_default' => 1,
							'company_id' => $saved_company
						);
						$this->auth_model->add('tbl_payment_methods', $payment_method);
						$payment_method['name'] = 'Gift Card';
						$this->auth_model->add('tbl_payment_methods', $payment_method);
						$this->session->set_flashdata('success',con_lang('mass_register_successfully'));
						redirect($_SERVER['HTTP_REFERER']);
					}else{
						$this->session->set_flashdata('error',con_lang('mass_error_occurrs_try_later'));
						redirect($_SERVER['HTTP_REFERER']);
					}
				}else{
					$this->session->set_flashdata('error',con_lang('mass_error_occurrs_try_later'));
					redirect($_SERVER['HTTP_REFERER']);
				}
			}
		}else{
			$this->load->view('erp/register');
		}
	}
	public function logout(){
		if($this->isLoggedIn()){
			$allUserdata=$this->session->all_userdata();
			$this->session->unset_userdata($allUserdata);
			$this->session->sess_destroy();
			redirect('accounting/auth');
		}
	}
	public function verifiedUser($id=null,$status=null){
		if($this->isLoggedIn()){
				$this->load->model('common_model');
				if(isset($id)){
					if(isset($status) && $status == 'verify'){
						$update=$this->common_model->update('tbl_users',array('id'=>$id),array('active'=>1));
						if($update){
							$this->session->set_flashdata('success',con_lang('mass_user_activated_successfully'));
							redirect($_SERVER['HTTP_REFERER']);
						}else{
							$this->session->set_flashdata('error',con_lang('mass_error_occurrs_try_later'));
							redirect($_SERVER['HTTP_REFERER']);
						}
					}else if(isset($status) && $status == 'notverified'){
						$update=$this->common_model->update('tbl_users',array('id'=>$id),array('active'=>0));
						if($update){
							$this->session->set_flashdata('success',con_lang('mass_user_deactivated_successfully'));
							redirect($_SERVER['HTTP_REFERER']);
						}else{
							$this->session->set_flashdata('error',con_lang('mass_error_occurrs_try_later'));
							redirect($_SERVER['HTTP_REFERER']);
						}
					}
				}
		}else{
			redirect('accounting/auth');
		}
	}
}