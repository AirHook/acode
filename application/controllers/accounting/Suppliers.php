<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once(APPPATH."controllers/accounting/ERPController.php");
class Suppliers extends ERPController {
	function __construct(){
		parent::__construct();
		$this->load->model('supplier_model');
		$this->load->model('customer_model');
	}
	public function index($type = null){
		if($this->isloggedIn()){
			if($type=='ng'){
			}else{
				$this->load->model('supplier_model');
				$data['suppliers']=$this->supplier_model->getAll('tbl_suppliers',array('company_id'=>$this->session->userdata('company_id')));
				$data['active'] = 'Supplliers';
				$data['module'] = 'accounting';
				if($type == 'ng') {
					echo json_encode($data['suppliers']);
					exit();
				} else{
					$this->displayView('accounting/suppliers/list_view', $data, array(), array(
						'js'	=> array(
						),
						'css'	=> array(
						)
					));
				}
			}
		} else {
			redirect('auth');
		}
	}
	public function add($id=null,$type=null) {
		if($this->isloggedIn()) {
			if($type=='ng'){
			}else{
			       $data['active']='Supplliers';
					$data['module']='accounting';
					if($this->input->server('REQUEST_METHOD') === 'POST'){
						$formData=$this->input->post();
						unset($formData['submit']);
						$formData['company_id']=$this->session->userdata('company_id');
						if(isset($formData['id']) && !empty($formData['id'])){
							$update=$this->supplier_model->update('tbl_suppliers',array('id'=>$formData['id']),$formData);
							if($update){
								$email=$formData['email'];
								$openingBalanceForLedger=$formData['opening_balance'];
								if(isset($formData['crOrDr']))
								    $creditDebit = $formData['crOrDr'];
								else
									$creditDebit='';
								unset($formData);
								$update_ledger=$this->customer_model->update('tbl_accountledger',array('email'=>$email),array('openingBalance'=>$openingBalanceForLedger, 'crOrDr' => $creditDebit, 'editable' => 0));
								$this->session->set_flashdata('success',con_lang('mass_record_updated_successfully'));
								redirect($_SERVER['HTTP_REFERER']);
							}else{
								$this->session->set_flashdata('error',con_lang('mass_error_occurrs_try_later'));
								redirect($_SERVER['HTTP_REFERER']);
							}
						}else{
							$result=$this->supplier_model->getOne('tbl_suppliers',array('email'=>$formData['email']));
							if(isset($result->email) && !empty($result->email)){
								$this->session->set_flashdata('error',con_lang('mass_email_already_exist'));
								$data['model']=$this->input->post();
							}else{
						        // echo  '<pre>',print_r($formData),'</pre>';exit();
								$saved=$this->supplier_model->add('tbl_suppliers',$formData);
								$formData['accountGroupId']=22;
								$formData['supplier_id'] = $saved;
								$formData['openingBalance']=$formData['opening_balance'];
								unset($formData['opening_balance']);
								unset($formData['supplierCode']);
								$formData['ledgerName']=$formData['supplierName'];
								unset($formData['supplierName']);
								$formData['editable'] = 0;
								$saved1=$this->supplier_model->add('tbl_accountledger',$formData);
								if($saved > 0 && $saved1 > 0){
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
						$data['model']=(array)$this->supplier_model->getById('tbl_suppliers',decode_uri($id));
						
					}
					$max_row = $this->common_model->getMaximumRow('tbl_suppliers');
					$code = 1;
					if(isset($max_row->id)) {
						$code = (int)$max_row->id + 1;
					}
					$data['customer_code'] = sprintf('%05d', $code);
					$this->displayView('accounting/suppliers/add_supplier',$data,array(),array(
							'js'=>array(),
							'css'=>array(),
						));
				}
		 }else {
			redirect('auth');
		}
	}
	
}
