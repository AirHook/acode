<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
require_once(APPPATH."controllers/accounting/ERPController.php");
class Account extends ERPController{
	function __construct(){
		parent::__construct();
		if(!$this->isLoggedIn()){
			redirect('auth');
		}
		$this->load->model('account_model');
	}
	public function index($type=null){
		if($this->isLoggedIn()){
			if($type=='ng'){
				
			}else{
				$data['active']='Account Groups';
				$data['module']='accounting';
				$query="SELECT * FROM tbl_accountgroup WHERE (company_id IS NULL OR company_id = ".$this->company_id.")";
				$data['accountGroups']=$this->account_model->universal($query)->result();
				$data['allData']=$this->account_model->getAll('tbl_accountgroup',array('company_id'=>$this->session->userdata('company_id')));
				 // debug($data);
				$this->displayView('accounting/account/accountGroup',$data,array(),array(
					'js'=>array(),
					'css'=>array(),
				));
			}
		}else{
			redirect('auth');
		}
	}
	public function paymentMethods($type=null){
		if($this->isLoggedIn()){
			if($type=='ng'){
				
			}else{
				$data['active']='Payment Methods';
				$data['module']='accounting';
				$query="SELECT * FROM tbl_payment_methods WHERE (company_id IS NULL OR company_id = ".$this->company_id.")";
				$data['payment_methods']=$this->account_model->universal($query)->result();
				 // debug($data);
				$this->displayView('accounting/account/payment_methods',$data,array(),array(
					'js'=>array(),
					'css'=>array(),
				));
			}
		}else{
			redirect('auth');
		}
	}
	public function giftCards($type=null){
		if($this->isLoggedIn()){
			if($type=='ng'){
				
			}else{
				$data['active']='Gift Cards';
				$data['module']='accounting';
				$query="SELECT * FROM tbl_gift_cards WHERE (company_id IS NULL OR company_id = ".$this->company_id.")";
				$data['payment_methods']=$this->account_model->universal($query)->result();
				 // debug($data);
				$this->displayView('accounting/account/gift_cards',$data,array(),array(
					'js'=>array(),
					'css'=>array(),
				));
			}
		}else{
			redirect('auth');
		}
	}
	public function addGiftCard($id=null,$type=null){
		if($this->isLoggedIn()){
				if($type=='ng'){
				}else{
					$data['active']='Gift Cards';
					$data['module']='accounting';
					if(isset($data['customer_id']) && $data['customer_id'] == '-1')
						unset($data['customer_id']);
					if($this->input->server('REQUEST_METHOD') === 'POST'){
						$formData=$this->input->post();
						$formData['company_id']=$this->session->userdata('company_id');
						unset($formData['submit']);
						if(isset($formData['id']) && !empty($formData['id'])){
							$existing = $this->account_model->getOne('tbl_gift_cards', "company_id = ".$this->company_id." AND id != ".$formData['id']." AND number = '".$formData['number']."'");
							if(isset($existing->id)) {
								$this->session->set_flashdata('error',con_lang('gift_number_already_exists'));
								redirect($_SERVER['HTTP_REFERER']);
							}
							$update=$this->account_model->update('tbl_gift_cards',array('id'=>$formData['id']),$formData);
							if($update){
								$this->session->set_flashdata('success',con_lang('gift_card_saved_successfully'));
								redirect($_SERVER['HTTP_REFERER']);
							}else{
								$this->session->set_flashdata('error',con_lang('mass_error_occurrs_try_later'));
								redirect($_SERVER['HTTP_REFERER']);
							}
						}else{
							$existing = $this->account_model->getOne('tbl_gift_cards', "company_id = ".$this->company_id."  AND number = '".$formData['number']."'");
							if(isset($existing->id)) {
								$this->session->set_flashdata('error',con_lang('gift_number_already_exists'));
								redirect($_SERVER['HTTP_REFERER']);
							}
							$saved=$this->account_model->add('tbl_gift_cards',$formData);
							if($saved){
								$this->session->set_flashdata('success',con_lang('gift_card_saved_successfully'));
								redirect($_SERVER['HTTP_REFERER']);
							}else{
								$this->session->set_flashdata('error',con_lang('mass_error_occurrs_try_later'));
								redirect($_SERVER['HTTP_REFERER']);
							}
							
						}
					}
					if(isset($id) && $id!=null){
						$data['model']=(array)$this->account_model->getById('tbl_gift_cards',$id);
					}
					$data['customers'] = $this->account_model->getAll('tbl_accountledger', array('company_id' => $this->company_id, 'accountGroupId'=>26,'id >'=>12));
					$this->displayView('accounting/account/add_gift_card',$data,array(),array(
							'js'=>array(),
							'css'=>array(),
						));
				}
			}else{
				redirect('auth');
			}
	}
	public function verifyGiftCardNumber() {
		if($this->input->post('number')) {
			$number = $this->input->post('number');
			$customer_id = $this->input->post('customer_id');
			$customer_id = ($customer_id) ? $customer_id : -1;
			$gift = $this->account_model->getOne('tbl_gift_cards', "company_id = ".$this->company_id." AND (customer_id IS NULL OR customer_id = ".$customer_id.") AND number = '".$number."' AND is_active = 1");
			if(isset($gift->value)) {
				echo json_encode($gift);
			}
			exit();
		}
	}
	public function addAccountGroup($id=null,$type=null){
		if($this->isLoggedIn()){
				if($type=='ng'){
				}else{
					$data['active']='Account Groups';
					$data['module']='accounting';
					if($this->input->server('REQUEST_METHOD') === 'POST'){
						$formData=$this->input->post();
						$formData['company_id']=$this->session->userdata('company_id');
						unset($formData['submit']);
						if(isset($formData['id']) && !empty($formData['id'])){
							$update=$this->account_model->update('tbl_accountgroup',array('id'=>$formData['id']),$formData);
							if($update){
								$this->session->set_flashdata('success',con_lang('mess_account_group_updated_successfully'));
								redirect($_SERVER['HTTP_REFERER']);
							}else{
								$this->session->set_flashdata('error',con_lang('mass_error_occurrs_try_later'));
								redirect($_SERVER['HTTP_REFERER']);
							}
						}else{
						       
								$saved=$this->account_model->add('tbl_accountgroup',$formData);
								if($saved){
									$this->session->set_flashdata('success',con_lang('mess_account_group_created_successfully'));
									redirect($_SERVER['HTTP_REFERER']);
								}else{
									$this->session->set_flashdata('error',con_lang('mass_error_occurrs_try_later'));
									redirect($_SERVER['HTTP_REFERER']);
								}
							
						}
					}
					if(isset($id) && $id!=null){
						$data['model']=(array)$this->account_model->getById('tbl_accountgroup',decode_uri($id));
					}
					$query="SELECT * FROM tbl_accountgroup WHERE company_id IS NULL";
					$data['accountGroups']=$this->account_model->universal($query)->result();
					$this->displayView('accounting/account/add_account_group',$data,array(),array(
							'js'=>array(),
							'css'=>array(),
						));
				}
			}else{
				redirect('auth');
			}
	}
	public function addPaymentMethod($id=null,$type=null){
		if($this->isLoggedIn()){
				if($type=='ng'){
				}else{
					$data['active']='Payment Methods';
					$data['module']='accounting';
					if($this->input->server('REQUEST_METHOD') === 'POST'){
						$formData=$this->input->post();
						$formData['company_id']=$this->session->userdata('company_id');
						unset($formData['submit']);
						if(isset($formData['id']) && !empty($formData['id'])){
							$update=$this->account_model->update('tbl_payment_methods',array('id'=>$formData['id']),$formData);
							if($update){
								$this->session->set_flashdata('success',con_lang('payment_method_saved_successfully'));
								redirect($_SERVER['HTTP_REFERER']);
							}else{
								$this->session->set_flashdata('error',con_lang('mass_error_occurrs_try_later'));
								redirect($_SERVER['HTTP_REFERER']);
							}
						}else{
							$saved=$this->account_model->add('tbl_payment_methods',$formData);
							if($saved){
								$this->session->set_flashdata('success',con_lang('payment_method_saved_successfully'));
								redirect($_SERVER['HTTP_REFERER']);
							}else{
								$this->session->set_flashdata('error',con_lang('mass_error_occurrs_try_later'));
								redirect($_SERVER['HTTP_REFERER']);
							}
							
						}
					}
					if(isset($id) && $id!=null){
						$data['model']=(array)$this->account_model->getById('tbl_payment_methods',$id);
					}
					$this->displayView('accounting/account/add_payment_method',$data,array(),array(
							'js'=>array(),
							'css'=>array(),
						));
				}
			}else{
				redirect('auth');
			}
	}
	public function accountLedger($type=null){
		if($this->isLoggedIn()){
				if($type=='ng'){
				}else{
					  $data['active']="Account Ledger";
					  $data['module']="accounting";
					  $query="SELECT * FROM tbl_accountledger WHERE (company_id IS NULL OR company_id = ".$this->company_id.")";
					  $data['accountLedger']=$this->account_model->universal($query)->result();
					  // debug($data['accountLedger']);
					  // $data['allData']=$this->account_model->getAll('tbl_accountledger',array('company_id'=>$this->session->userdata('company_id')));
					   $this->displayView('accounting/account/account_ledger',$data,array(),array(
						'js'=>array(),
						'css'=>array(),
					));
				}
		}else{
			redirect('auth');
		}
	}
	public function addAccountLedger($id=null,$type=null){
		if($this->isLoggedIn()){
				if($type=='ng'){
				}else{
					$data['active']='Account Ledger';
					$data['module']='accounting';
					if($this->input->server('REQUEST_METHOD') === 'POST'){
						$formData=$this->input->post();
						$formData['company_id']=$this->session->userdata('company_id');
						$formData['editable'] = 0;
						unset($formData['submit']);
						if(isset($formData['id']) && !empty($formData['id'])){
							$update=$this->account_model->update('tbl_accountledger',array('id'=>$formData['id']),$formData);
							if($update){
								$this->session->set_flashdata('success',con_lang('mess_account_ledger_updated_successfully'));
								redirect($_SERVER['HTTP_REFERER']);
							}else{
								$this->session->set_flashdata('error',con_lang('mass_error_occurrs_try_later'));
								redirect($_SERVER['HTTP_REFERER']);
							}
						}else{

						       // echo '<pre>',print_r($formData),'</pre>',exit();
								$saved=$this->account_model->add('tbl_accountledger',$formData);
								if($saved){
									if(isset($formData['accountGroupId']) && $formData['accountGroupId'] == 26) { // customer
										// $this->customer_model->add('tbl_mcustomers',$cus);
									} else if(isset($formData['accountGroupId']) && $formData['accountGroupId'] == 22) { // supplier

									}
									$this->session->set_flashdata('success',con_lang('mess_account_ledger_created_successfully'));
									redirect($_SERVER['HTTP_REFERER']);
								}else{
									$this->session->set_flashdata('error',con_lang('mass_error_occurrs_try_later'));
									redirect($_SERVER['HTTP_REFERER']);
								}
							
						}
					}
					if(isset($id) && $id!=null){
						$data['model']=(array)$this->account_model->getById('tbl_accountledger',$id);
					}
					$this->displayView('accounting/account/add_account_ledger',$data,array(),array(
							'js'=>array(),
							'css'=>array(),
						));
				}
			}else{
				redirect('auth');
			}
	}
	public function voucherType($type=null){
		if($this->isLoggedIn()){
				if($type=='ng'){
				}else{
					  $data['active']="Voucher Type";
					  $data['module']="accounting";
					  $query="SELECT * FROM tbl_vouchertype WHERE company_id IS NULL";
					  $data['voucherType']=$this->account_model->universal($query)->result();
					  $data['allData']=$this->account_model->getAll('tbl_vouchertype',array('company_id'=>$this->session->userdata('company_id')));
					   $this->displayView('accounting/account/voucher_type',$data,array(),array(
						'js'=>array(),
						'css'=>array(),
					));
				}
		}else{
			redirect('auth');
		}
	}
	public function addVoucherType($id=null,$type=null){
		if($this->isLoggedIn()){
				if($type=='ng'){
				}else{
					$data['active']='Voucher Type';
					$data['module']='accounting';
					if($this->input->server('REQUEST_METHOD') === 'POST'){
						$formData=$this->input->post();
						$formData['company_id']=$this->session->userdata('company_id');
						unset($formData['submit']);
					    if(isset($formData['isActive'])){
					    	$formData['isActive']=1;
					    }else{
					    	$formData['isActive']=0;
					    }
						if(isset($formData['id']) && !empty($formData['id'])){
							$id = $formData['id'];
							unset($formData['id']);
							$update=$this->account_model->update('tbl_vouchertype',array('voucherTypeId'=>$id),$formData);
							if($update){
								$this->session->set_flashdata('success',con_lang('mess_voucher_updated_successfully'));
								redirect($_SERVER['HTTP_REFERER']);
							}else{
								$this->session->set_flashdata('error',con_lang('mass_error_occurrs_try_later'));
								redirect($_SERVER['HTTP_REFERER']);
							}
						}else{
								$saved=$this->account_model->add('tbl_vouchertype',$formData);
								if($saved){
									$this->session->set_flashdata('success',con_lang('mess_voucher_created_successfully'));
									redirect($_SERVER['HTTP_REFERER']);
								}else{
									$this->session->set_flashdata('error',con_lang('mass_error_occurrs_try_later'));
									redirect($_SERVER['HTTP_REFERER']);
								}
							
						}
					}
					if(isset($id) && $id!=null){
						$this->load->model('common_model');
						$data['model']=(array)$this->common_model->getById('tbl_vouchertype',"voucherTypeId = ".decode_uri($id));
					}
					$this->displayView('accounting/account/add_voucher_type',$data,array(),array(
							'js'=>array(),
							'css'=>array(),
						));
				}
			}else{
				redirect('auth');
			}
	}
	public function currency($type=null){
		if($this->isLoggedIn()){
				if($type=='ng'){
				}else{
					  $data['active']="Currency";
					  $data['module']="accounting";
					  $data['allData']=$this->account_model->getAll('tbl_currency',array('company_id'=>$this->session->userdata('company_id')));
					   $this->displayView('accounting/account/currency',$data,array(),array(
						'js'=>array(),
						'css'=>array(),
					));
				}
		}else{
			redirect('auth');
		}
	}
	public function addCurrency($id=null,$type=null){
		if($this->isLoggedIn()){
				if($type=='ng'){
				}else{
					$data['active']='Currency';
					$data['module']='accounting';
					if($this->input->server('REQUEST_METHOD') === 'POST'){
						$formData=$this->input->post();
						unset($formData['submit']);
						$formData['company_id']=$this->session->userdata('company_id');
						if(isset($formData['id']) && !empty($formData['id'])){
							$update=$this->account_model->update('tbl_currency',array('id'=>$formData['id']),$formData);
							if($update){
								$this->session->set_flashdata('success',con_lang('mess_currency_updated_successfully'));
								redirect($_SERVER['HTTP_REFERER']);
							}else{
								$this->session->set_flashdata('error',con_lang('mass_error_occurrs_try_later'));
								redirect($_SERVER['HTTP_REFERER']);
							}
						}else{
								$saved=$this->account_model->add('tbl_currency',$formData);
								if($saved){
									$this->session->set_flashdata('success',con_lang('mess_currency_created_successfully'));
									redirect($_SERVER['HTTP_REFERER']);
								}else{
									$this->session->set_flashdata('error',con_lang('mass_error_occurrs_try_later'));
									redirect($_SERVER['HTTP_REFERER']);
								}
							
						}
					}
					$data['model']=(array)$this->account_model->getOne('tbl_currency',array('company_id'=>$this->session->userdata('company_id')));
					$this->displayView('accounting/account/add_currency',$data,array(),array(
							'js'=>array(),
							'css'=>array(),
						));
				}
			}else{
				redirect('auth');
			}
	}
}