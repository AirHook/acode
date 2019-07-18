<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
require_once(APPPATH."controllers/accounting/ERPController.php");
class Admin extends ERPController{
	function __construct(){
		parent::__construct();
		if(!$this->isLoggedIn()){
			redirect('auth');
		}
		// $current_user_company=$this->session->userdata('company_id');
		$this->load->model('admin_model');
	}
	public function index($type=null){
		if($this->isLoggedIn()){
			if($type == 'ng'){
			}else{
				$data['active']='All Users';
				$data['module']='accounting';
				// $data['allData']=$this->admin_model->getAll('tbl_users',array('role'=>'admin'));
				$data['allData'] = $this->db->query("SELECT * FROM tbl_users INNER JOIN tbl_company ON tbl_users.company_id = tbl_company.companyId WHERE tbl_users.role = 'admin'")->result();
				$this->displayView('accounting/users/admin_user',$data,array(),array(
						'js'=>array(),
						'css'=>array(),
					));
			}
		}else{
			redirect('auth');
		}
	}
	public function delete($id = null, $table = null) {
		if($id != null) {
			$this->load->model('admin_model');
			$delete = $this->admin_model->deleteCompany($id);
			if($delete){
				$result['message']="Deleted successfully";
				$result['response']=1;
			}else{
				$result['message']="Error occurred try later";
				$result['response']=0;
			}
			echo json_encode($result);exit();
		}
	}
	public function editAdmin($id=null,$type=null){
		if($this->isLoggedIn()){
			if($type == 'ng'){
			}else{
				$data['active']='Create User';
				$data['module']='accounting';
				if($this->input->server('REQUEST_METHOD') === 'POST'){
					$formData=$this->input->post();
					unset($formData['submit']);
					$formData['password']=md5($formData['password']);
					if(isset($formData['id']) && !empty($formData['id'])){
						$update=$this->admin_model->update('tbl_users',array('id'=>$formData['id']),$formData);
							if($update){
								$this->session->set_flashdata('success',con_lang('mass_record_updated_successfully'));
								redirect($_SERVER['HTTP_REFERER']);
							}else{
								$this->session->set_flashdata('error',con_lang('mass_error_occurrs_try_later'));
								redirect($_SERVER['HTTP_REFERER']);
							}
						}else{
							$result=$this->admin_model->getOne('tbl_users',array('email'=>$formData['email']));
							if(isset($result->email) && !empty($result->email)){
								$this->session->set_flashdata('error',con_lang('mass_email_already_exist'));
								$data['model']=$this->input->post();
							}else{
									$saved=$this->admin_model->add(' tbl_users',$formData);
									if($saved){
										$this->session->set_flashdata('success',con_lang("mess_user_created_successfully"));
										redirect($_SERVER['HTTP_REFERER']);
									}else{
										$this->session->set_flashdata('error',con_lang("'mass_error_occurrs_try_later"));
										redirect($_SERVER['HTTP_REFERER']);
									}
								}
								
							}
						}
					if($id!=null){
						$data['model']=(array)$this->admin_model->getById('tbl_users',decode_uri($id));
						
					}
				$this->displayView('accounting/users/register_admin',$data,array(),array(
						'js'=>array(),
						'css'=>array(),
					));
			}
		}else{
			redirect('auth');
		}
	}
	public function allUser($type=null){
		if($this->isLoggedIn()){
			if($type == 'ng'){
			}else{
				$data['active']='All Users';
				$data['module']='accounting';
				$data['allData']=$this->admin_model->getAll('tbl_users',array('role!='=>'admin','company_id'=>$this->session->userdata('company_id')));
				$this->displayView('accounting/users/user',$data,array(),array(
						'js'=>array(),
						'css'=>array(),
					));
			}
		}else{
			redirect('auth');
		}
	}
	public function createUser($id=null,$type=null){
		if($this->isLoggedIn()){
			if($type == 'ng'){
			}else{
				$data['active']='Create User';
				$data['module']='accounting';
				if($this->input->server('REQUEST_METHOD') === 'POST'){
					$formData=$this->input->post();
					unset($formData['submit']);
					$formData['role']='user';
					$formData['password']=md5($formData['password']);
					$formData['company_id']=$this->session->userdata('company_id');
					if(isset($formData['id']) && !empty($formData['id'])){
						$update=$this->admin_model->update('tbl_users',array('id'=>$formData['id']),$formData);
						if($update){
							$this->session->set_flashdata('success',con_lang('mass_record_updated_successfully'));
							redirect($_SERVER['HTTP_REFERER']);
						}else{
							$this->session->set_flashdata('error',con_lang('mass_error_occurrs_try_later'));
							redirect($_SERVER['HTTP_REFERER']);
						}
					}else{
						$result=$this->admin_model->getOne('tbl_users',array('email'=>$formData['email'], 'company_id' => $this->company_id));
						if(isset($result->email) && !empty($result->email)){
							$this->session->set_flashdata('error',con_lang('mass_email_already_exist'));
							$data['model']=$this->input->post();
						}else{
							$saved=$this->admin_model->add(' tbl_users',$formData);
							if($saved){
								$this->session->set_flashdata('success',con_lang("mess_user_created_successfully"));
								redirect($_SERVER['HTTP_REFERER']);
							}else{
								$this->session->set_flashdata('error',con_lang("'mass_error_occurrs_try_later"));
								redirect($_SERVER['HTTP_REFERER']);
							}
						}
					}
					}
					if($id!=null){
						$data['model']=(array)$this->admin_model->getById('tbl_users',decode_uri($id));
						
					}
				$this->displayView('accounting/users/create_user',$data,array(),array(
						'js'=>array(),
						'css'=>array(),
					));
			}
		}else{
			redirect('auth');
		}
	}
	public function userCreation($id=null,$profile=null,$type=null){
		if($this->isLoggedIn()){
				if($type=='ng'){
				}else{
					if(isset($profile) && $profile == 'profile'){
						$data['active']='';
					}else{
						$data['active']='User Creation';
					}
					$data['module']='accounting';
					if($this->input->server('REQUEST_METHOD') === 'POST'){
						$formData=$this->input->post();
						$formData['company_id']=$this->company_id;
						unset($formData['submit']);
						    	if(isset($formData['id']) && !empty($formData['id'])){
						    		// debug($formData);
						    		unset($formData['role']);
						    		$checkEmail=$this->admin_model->getOne('tbl_users',array('email'=>$formData['email'], 'company_id' => $this->company_id, 'id!=' => $formData['id']));
						    		if(empty($checkEmail)) {
										$update=$this->admin_model->update('tbl_users',array('id'=>$formData['id']),$formData);
										if($update){
											$this->session->set_flashdata('success',con_lang('mess_user_updated_successfully'));
											redirect($_SERVER['HTTP_REFERER']);
										}else{
											$this->session->set_flashdata('error',con_lang('mass_error_occurrs_try_later'));
											redirect($_SERVER['HTTP_REFERER']);
										}
									} else {
										$this->session->set_flashdata('error',con_lang('mess_user_name_aleardy_exist'));
								    	$data['model']=$this->input->post();
									}
								}else{
									$checkEmail=$this->admin_model->getOne('tbl_users',array('email'=>$formData['email'], 'company_id' => $this->company_id));
									if(empty($checkEmail)){
										if(isset($formData['password']) && isset($formData['repassword']) && $formData['password']== $formData['repassword']){
										unset($formData['repassword']);
										$formData['password']=md5($formData['password']);
										$saved=$this->admin_model->add('tbl_users',$formData);
										if($saved){
											$this->session->set_flashdata('success',con_lang('mess_user_created_successfully'));
											redirect($_SERVER['HTTP_REFERER']);
										}else{
											$this->session->set_flashdata('error',con_lang('mass_error_occurrs_try_later'));
											redirect($_SERVER['HTTP_REFERER']);
										}
									}else{
								    	$this->session->set_flashdata('error',con_lang('mess_password_Not_matched_with_Retype_Password'));
								    	$data['model']=$this->input->post();
								    }
								}else{
									$this->session->set_flashdata('error',con_lang('mess_user_name_aleardy_exist'));
								    $data['model']=$this->input->post();
							    }
						    }
					}
					if(isset($id) && $id!=null){
						$data['model']=(array)$this->admin_model->getById('tbl_users',decode_uri($id));
					}
					if(isset($id) && $id!=null && isset($profile) && $profile == 'profile'){
						$data['model']=(array)$this->admin_model->getById('tbl_users',decode_uri($id));
						$data['profile']='profile';
					}
					$data['roles']=$this->admin_model->getAll('tbl_user_roles', array('company_id' => $this->company_id));
					$this->displayView('accounting/users/user_creation',$data,array(),array(
							'js'=>array(),
							'css'=>array(),
						));
				}
		}else{
			redirect('auth');
		}
	}
	public function profile($type=null){
		if($this->isLoggedIn()){
			if($type == 'ng'){

			}else{
					$data['active']='';
					$data['module']='accounting';
					$data['model']=(array)$this->admin_model->getById('tbl_users',$this->session->userdata('id'));
					$this->displayView('accounting/users/user_creation',$data,array(),array(
							'js'=>array(),
							'css'=>array(),
						));
			}
		}else{
			redirect('auth');
		}
	}
}