<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
require_once(APPPATH."controllers/accounting/ERPController.php");
class Company extends ERPController{
	function __construct(){
		parent::__construct();
		if(!$this->isLoggedIn()){
			redirect('auth');
		}
		$this->load->model('company_model');
	}
	public function index($type=null){
		if($this->isLoggedIn()){
				if($type=='ng'){
				}else{
					$countryList=$this->countriesList();
					if(!empty($countryList)){
						foreach ($countryList as $code => $country) {
							$countryName = ucwords(strtolower($country["name"]));
							$checkCoutnry=$this->company_model->getOne('tbl_country',array('country_name'=>$countryName));
							if(empty($checkCoutnry)){
								$this->company_model->add('tbl_country',array('country_name'=>$countryName));
							}
						}
					}
					// echo '<pre>',print_r($coutreyList),'</pre>';
					$data['active']='Company Detail';
					$data['module']='accounting';
					$data['model']=(array)$this->company_model->getOne(' tbl_company',array('companyId'=>$this->session->userdata('company_id')));
					$data['countriesList']=$this->company_model->getAll('tbl_country');
					$this->displayView('accounting/company/add_company_detail',$data,array(),array(
							'js'=>array(),
							'css'=>array(),
						));
				}
		}else{
			redirect('auth');
		}
	}
	public function addCompanyDetail($type=null){
		if($this->isLoggedIn()){
			if($type=='ng'){
			}else{
				if($this->input->server('REQUEST_METHOD') === 'POST'){
					$formData=$this->input->post();
					unset($formData['submit']);
					if(isset($formData['financialYearFrom'])) {
						$formData['financialYearFrom'] = date('Y-m-d', strtotime($formData['financialYearFrom']));
						$formData['financialYearTo'] = date('Y-m-d', strtotime($formData['financialYearTo']));
						$f_year['fromDate']=date("Y-m-d",strtotime($formData['financialYearFrom']));
						$f_year['toDate']=date("Y-m-d",strtotime($formData['financialYearTo']));
						$f_year['isActive']=1;
						$f_year['company_id'] = $this->company_id;
						$result=$this->company_model->getOne('tbl_financialyear',array('company_id'=>$this->company_id));
						if(empty($result)){
							$update=$this->company_model->update('tbl_financialyear',array('isActive'=>1, 'company_id' => $this->company_id),array('isActive'=>0));
							$this->company_model->add('tbl_financialyear',$f_year);
						}
					}
					if(isset($formData['booksBeginingFrom']))
						$formData['booksBeginingFrom'] = date('Y-m-d', strtotime($formData['booksBeginingFrom']));
					if(isset($formData['currentDate']))
						$formData['currentDate'] = date('Y-m-d', strtotime($formData['currentDate']));
					$formData['activated'] = 1;
					if(isset($formData['companyId']) && !empty($formData['companyId'])){
						$update=$this->company_model->update('tbl_company',array('companyId'=>$formData['companyId']),$formData);
						if($update){
							$this->session->set_flashdata('success',con_lang('mess_company_detail_updated_successfully'));
							redirect($_SERVER['HTTP_REFERER']);
						}else{
							$this->session->set_flashdata('error',con_lang('mass_error_occurrs_try_later'));
							redirect($_SERVER['HTTP_REFERER']);
						}
					}else{
						$saved=$this->company_model->add('tbl_company',$formData);
						if($saved){
							$this->session->set_flashdata('success',con_lang('mess_company_detail_added_successfully'));
							redirect($_SERVER['HTTP_REFERER']);
						}else{
							$this->session->set_flashdata('error',con_lang('mass_error_occurrs_try_later'));
							redirect($_SERVER['HTTP_REFERER']);
						}
					}
				}
				// echo '<pre>',print_r($formData),'</pre>';exit();
			}
		}else{
			redirect('auth');
		}
	}
	public function changePassword($type=null){
		if($this->isLoggedIn()){
			if($type=='ng'){
			}else{
				$data['active']='Change Password' ;
				$data['module']='accounting';
				if($this->input->post('submit')){
					$formData= $this->input->post();
					unset($formData['submit']);
					if(md5($formData['old_password'])!=$this->session->userdata('password')){
						$this->session->set_flashdata('error',con_lang("mess_incorect_old_password"));
						redirect($_SERVER['HTTP_REFERER']);
					}else if($formData['password']!=$formData['cpassword']){
						$this->session->set_flashdata('error',con_lang("mess_new_password_not_matched_with_confirm_password"));
						redirect($_SERVER['HTTP_REFERER']);
					}else{
						$formData['password']=md5($formData['password']);
						unset($formData['old_password']);
						unset($formData['cpassword']);
						$update=$this->company_model->update('tbl_users',array('id'=>$this->session->userdata('id')),array('password'=>$formData['password']));
						if($update){
							$this->session->set_flashdata('success',con_lang("mess_password_changed_successfully"));
						    redirect($_SERVER['HTTP_REFERER']);
						}else{
							$this->session->set_flashdata('error',con_lang("mass_error_occurrs_try_later"));
						    redirect($_SERVER['HTTP_REFERER']);
						}
					}
				}
				$this->displayView('company/change_password',$data,array(),array(
						'js'=>array(),
						'css'=>array(),
					));
			}
		}else{
			redirect('auth');
		}
	}
}