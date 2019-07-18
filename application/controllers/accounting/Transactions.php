<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
require_once(APPPATH."controllers/accounting/ERPController.php");
class Transactions extends ERPController{
	function __construct(){
		parent::__construct();
		if(!$this->isLoggedIn()){
			redirect('auth');
		}
		$this->load->model('transaction_model');
	}
	public function contraVoucher($type = null) {
		if($this->isLoggedIn()){
			if($type=='ng'){
			}else{
				$data['active']='Contra Voucher';
				$data['module']='accounting';
				$this->displayView('accounting/transactions/contra_voucher',$data,array(),array(
						'js'=>array(),
						'css'=>array(),
					));
			}
		}else{
			redirect('auth');
		}
	}
	public function paymentRegister($type = null) {
		if($this->isLoggedIn()){
			if($type=='ng'){
			}else{
				$data['active']='Payment Register';
				$data['module']='accounting';
				$this->displayView('accounting/transactions/paymentRegister',$data,array(),array(
						'js'=>array(),
						'css'=>array(),
					));
			}
		}else{
			redirect('auth');
		}
	}
	public function paymentVoucherlisting($type=null){
		if($this->isLoggedIn()){
			if($type=='ng'){
			}else{
				$data['active']='Payment Voucher';
				$data['module']='accounting';
				// $data['allData']=$this->transaction_model->getAll();
				$this->displayView('accounting/transactions/payment_voucher_listing',$data,array(),array(
						'js'=>array(),
						'css'=>array(),
					));
			}
		}else{
			redirect('auth');
		}
	}
	public function paymentVoucher($type = null) {
		if($this->isLoggedIn()){
			if($type=='ng'){
			}else{
				$data['active']='Payment Voucher';
				$data['module']='accounting';
				if($this->input->server('REQUEST_METHOD') === 'POST'){
					$dateActiveYear=date('Y-m-d',strtotime($this->input->post('date')));
				   $activeYear=$this->transaction_model->getOne('tbl_financialyear',array('isActive'=>1,'company_id'=>$this->session->userdata('company_id')));
				   	if(!empty($activeYear)){
				   	if($dateActiveYear >= $activeYear->fromDate && $dateActiveYear <= $activeYear->toDate){
					$formData=$this->input->post();
					$count_payment_vouchers = $this->transaction_model->countVoucherRecords(4);
					$next_voucher = (int)$count_payment_vouchers+1;
					$formData['voucherNo'] = 'PV-'.sprintf('%05d', $next_voucher);
					$date=date("Y-m-d H:i:s",strtotime($formData['date'].' '.date('H:i:s')));
					unset($formData['submit']);
					if(!empty($formData)){
						foreach($formData['payment'] as $values){
							$transaction = array(
								'company_id' => $this->company_id,
								'voucher_type_id' => 4,
								'voucher_no' => $formData['voucherNo'],
								'amount' => (float)$values['amount'],
								'cheque_no' => $values['chequeNo'],
								'cheque_date' => date('Y-m-d H:i:s',strtotime($values['chequeDate'].' '.date('H:i:s'))),
								'to_ledger_id' => $values['ledgerId'],
								'from_ledger_id' => $formData['main_ledger_id'],
								'created_on' => $date,
								'created_by' => $this->session->userdata('id')
							);


							$values['created_by'] = $this->session->userdata('id');
							$values['date']=$date;
							$values['voucherTypeId']=4;
							$values['voucherNo']=$formData['voucherNo'];
							$values['debit']=$values['amount'];
							unset($values['amount']);
							$values['credit']=0;
							$values['chequeDate']=date('Y-m-d',strtotime($values['chequeDate']));
							$values['yearId']=$this->getActiveYearId();
							$values['company_id']=$this->session->userdata('company_id');
							$saved=$this->transaction_model->add('tbl_ledgerposting',$values);
							$values['credit']=$values['debit'];
							$values['debit']=0;
							$values['ledgerId'] = $formData['main_ledger_id'];
							$saved=$this->transaction_model->add('tbl_ledgerposting',$values);

							$this->transaction_model->add('tbl_voucher_transactions', $transaction);
						}
						if(isset($formData['save_print']) && isset($formData['voucherNo'])) {
							$this->session->set_flashdata('print_payment_voucher', $formData['voucherNo']);
						}
						if($saved){
							$this->session->set_flashdata('success',con_lang('mass_addedd_successfully'));
							redirect($_SERVER['HTTP_REFERER']);
						}else{
							$this->session->set_flashdata('success',con_lang('mass_error_occurrs_try_later'));
							redirect($_SERVER['HTTP_REFERER']);
						}
					}
				}else{
					   	  		$this->session->set_flashdata('error',con_lang('mass_please_select_date_within_active_financial_year'));
		                        redirect($_SERVER['HTTP_REFERER']);
					   	  }
					   	}else{
					   		   $this->session->set_flashdata('error',con_lang('mass_please_set_financial_year'));
		                        redirect($_SERVER['HTTP_REFERER']);
					   	  }	
				}
				$count_payment_vouchers = $this->transaction_model->countVoucherRecords(4);
				$data['next_type'] = (int)$count_payment_vouchers+1;
				$this->displayView('accounting/transactions/payment_voucher',$data,array(),array(
						'js'=>array(),
						'css'=>array(),
					));
			}
		}else{
			redirect('auth');
		}
	}

	public function printPaymentVoucher($voucherNo = null) {
		if($voucherNo != null) {
			// $voucherNo = str_replace('_', '-', $voucherNo);
			$data['number'] = $voucherNo;
			$data['is_print'] = true;
		  	$data['title'] = 'Payment Voucher';

		  	$rows = $this->transaction_model->getVoucherDetail($voucherNo);

		  	if(isset($rows[0])) {
		  		$data['detail'] = $rows[0];
		  	}
		  	$data['products'] = $rows;

		  	$html = $this->displayView('accounting/transactions/voucher_report' ,$data,array('topbar', 'sidenav'),array(
							'js'=>array(),
							'css'=>array(),
						), true);
		   	echo $html;
		   	exit();
		}
	}
	public function printReceiptVoucher($voucherNo = null) {
		if($voucherNo != null) {
			// $voucherNo = str_replace('_', '-', $voucherNo);
			$data['number'] = $voucherNo;
			$data['is_print'] = true;
		  	$data['title'] = 'Receipt Voucher';

		  	$rows = $this->transaction_model->getVoucherDetail($voucherNo);

		  	if(isset($rows[0])) {
		  		$data['detail'] = $rows[0];
		  	}
		  	$data['products'] = $rows;
		  	
		  	$html = $this->displayView('accounting/transactions/voucher_report' ,$data,array('topbar', 'sidenav'),array(
							'js'=>array(),
							'css'=>array(),
						), true);
		   	echo $html;
		   	exit();
		}
	}
	
	public function getDataForpayment($type=null){
		if($this->isLoggedIn()){
			if($type=='ng'){
			}else{
				$company_id = $this->session->userdata('company_id');
				  $accountLedger=$this->transaction_model->getAll('tbl_accountledger', "company_id IS NULL OR company_id = $company_id");
				  $currency=$this->transaction_model->getAll('tbl_currency',array('company_id'=>$this->session->userdata('company_id')));
				  echo json_encode(array('ledger'=>$accountLedger,'currency'=>$currency));
				  exit();
			}
		}else{
			redirect('auth');
		}
	}
	public function journalVoucher($type = null){
		if($this->isLoggedIn()){
			if($type=='ng'){
			}else{
				$data['active']='Journal Voucher';
				$data['module']='accounting';
				if($this->input->server('REQUEST_METHOD') === 'POST'){
					 $dateActiveYear=date('Y-m-d',strtotime($this->input->post('deliveryDate')));
					   $activeYear=$this->transaction_model->getOne('tbl_financialyear',array('isActive'=>1,'company_id'=>$this->session->userdata('company_id')));
					   	if(!empty($activeYear)){
					   	if($dateActiveYear >= $activeYear->fromDate && $dateActiveYear <= $activeYear->toDate){
					$formData=$this->input->post();
					unset($formData['submit']);
					$voucherNo=$formData['voucherNo'];
					unset($formData['voucherNo']);
					if(!empty($formData['payment'])){
							foreach($formData['payment'] as $values){
								$amount=$values['amount'];
								$type=$values['type'];
								unset($values['type']);
								unset($values['amount']);
								$values['voucherTypeId']=6;
								$values['voucherNo']=$voucherNo;
								$values['yearId']=$this->getActiveYearId();
								$values['company_id']=$this->session->userdata('company_id');
								$values['date']=date("Y-m-d H:i:s",strtotime($formData['deliveryDate'].' '.date('H:i:s')));
								if($type == 'Cr'){
									$values['credit']=$amount;
									$saved=$this->transaction_model->add('tbl_ledgerposting',$values);
								}else if($type  == 'Dr'){
									$values['debit']=$amount;
									$saved=$this->transaction_model->add('tbl_ledgerposting',$values);
								}
							}
							if($saved){
								$this->session->set_flashdata('success',con_lang('mass_journal_voucher_created_successfully'));
								redirect($_SERVER['HTTP_REFERER']);
							}else{
								$this->session->set_flashdata('error',con_lang("mass_error_occurrs_try_later"));
								redirect($_SERVER['HTTP_REFERER']);
							}
						}
					}else{
					   	  		$this->session->set_flashdata('error',con_lang('mass_please_select_date_within_active_financial_year'));
		                        redirect($_SERVER['HTTP_REFERER']);
					   	  }
					   	}else{
					   		   $this->session->set_flashdata('error',con_lang('mass_please_set_financial_year'));
		                        redirect($_SERVER['HTTP_REFERER']);
					   	  }	
					
				}
				$this->displayView('accounting/transactions/journel_voucher',$data,array(),array(
						'js'=>array(),
						'css'=>array(),
					));
			}
		}else{
			redirect('auth');
		}
	}
	public function receiptVocher($type = null) {
		if($this->isLoggedIn()){
			if($type=='ng'){
			}else{
				$data['active']='Receipt Voucher';
				$data['module']='accounting';
				if($this->input->server('REQUEST_METHOD') === 'POST'){
					$dateActiveYear=date('Y-m-d',strtotime($this->input->post('date')));
				   $activeYear=$this->transaction_model->getOne('tbl_financialyear',array('isActive'=>1,'company_id'=>$this->session->userdata('company_id')));
				   	if(!empty($activeYear)){
				   	if($dateActiveYear >= $activeYear->fromDate && $dateActiveYear <= $activeYear->toDate){
					$formData=$this->input->post();
					$count_payment_vouchers = $this->transaction_model->countVoucherRecords(5);
					$next_voucher = (int)$count_payment_vouchers+1;
					$formData['voucherNo'] = 'RV-'.sprintf('%05d', $next_voucher);
					unset($formData['submit']);
					$voucherNo=$formData['voucherNo'];
					unset($formData['currency']);
					$date=date("Y-m-d H:i:s",strtotime($formData['date'].' '.date('H:i:s')));
					unset($formData['date']);
					foreach($formData['payment'] as $values){
						$transaction = array(
							'company_id' => $this->company_id,
							'voucher_type_id' => 5,
							'voucher_no' => $formData['voucherNo'],
							'amount' => (float)$values['amount'],
							'cheque_no' => $values['chequeNo'],
							'cheque_date' => date('Y-m-d H:i:s',strtotime($values['chequeDate'].' '.date('H:i:s'))),
							'to_ledger_id' => $values['ledgerId'],
							'from_ledger_id' => $formData['main_ledger_id'],
							'created_on' => $date,
							'created_by' => $this->session->userdata('id')
						);


						$values['date']=$date;
						$values['voucherTypeId']=5;
						$values['voucherNo']=$voucherNo;
						$values['credit']=$values['amount'];
						unset($values['amount']);
						$values['debit']=0;
						$values['chequeDate']=date('Y-m-d',strtotime($values['chequeDate']));
						$values['yearId']=$this->getActiveYearId();
						$values['company_id']=$this->session->userdata('company_id');
						$saved=$this->transaction_model->add('tbl_ledgerposting',$values);
						$values['debit']=$values['credit'];
						$values['credit']=0;
						$values['ledgerId'] = $formData['main_ledger_id'];
						$saved=$this->transaction_model->add('tbl_ledgerposting',$values);
						

						$this->transaction_model->add('tbl_voucher_transactions',$transaction);
					}
					if(isset($formData['save_print']) && isset($formData['voucherNo'])) {
						$this->session->set_flashdata('print_receipt_voucher', $formData['voucherNo']);
					}
					unset($formData['voucherNo']);
					if( $saved > 0){
						$this->session->set_flashdata('success',con_lang('mass_receipt_voucher_created_successfully'));
						redirect($_SERVER['HTTP_REFERER']);
					}else{
						$this->session->set_flashdata('error',con_lang('mass_error_occurrs_try_later'));
						redirect($_SERVER['HTTP_REFERER']);
					}
					} else{
					   	  		$this->session->set_flashdata('error',con_lang('mass_please_select_date_within_active_financial_year'));
		                        redirect($_SERVER['HTTP_REFERER']);
					   	  }
					   	}else{
					   		   $this->session->set_flashdata('error',con_lang('mass_please_set_financial_year'));
		                        redirect($_SERVER['HTTP_REFERER']);
					   	  }	
					
				}
				$count_payment_vouchers = $this->transaction_model->countVoucherRecords(5);
				$data['next_type'] = (int)$count_payment_vouchers+1;
				$this->displayView('accounting/transactions/receipt_voucher',$data,array(),array(
						'js'=>array(),
						'css'=>array(),
					));
			}
		}else{
			redirect('auth');
		}
	}
	public function bankConcilation($type = null) {
		if($this->isLoggedIn()){
			if($type=='ng'){
			}else{
				$data['active']='Bank Concilation';
				$data['module']='accounting';
				$yearId=$this->getActiveYearId();
				$yearId = ($yearId > 0) ? $yearId : -1;
				if($this->input->server('REQUEST_METHOD') === 'POST'){
						$formData=$this->input->post();
						unset($formData['submit']);
						$formData['fromDate']=date('Y-m-d',strtotime($formData['from_date']));
						unset($formData['from_date']);
						$formData['toDate']=date('Y-m-d',strtotime($formData['from_to']));
						unset($formData['from_to']);
						$activeYearDate=$this->getActiveYearDate();
						if($formData['fromDate'] >=$activeYearDate->fromDate && $formData['toDate'] <=$activeYearDate->toDate){
								$query="SELECT * FROM tbl_ledgerposting WHERE company_id =$this->company_id AND voucherTypeId = 28 AND yearId=$yearId";
					           $data['allData']=$this->transaction_model->universal($query)->result();
					           $data['model']=$this->input->post();
						}else{
							$this->session->set_flashdata('error',con_lang('mass_please_select_within_active_financial_year'));
						    $data['model']=$this->input->post();
						}
				}else{
					$query="SELECT * FROM tbl_ledgerposting WHERE company_id =$this->company_id AND voucherTypeId = 28 AND yearId=$yearId";
					$data['allData']=$this->transaction_model->universal($query)->result();
				}
				if($this->session->flashdata('error')!='')
					$data['error']=$this->session->flashdata('error');
				unset($_SESSION['error']);
				if($this->session->flashdata('success'))
					$data['success']=$this->session->flashdata('success');
				$this->displayView('accounting/transactions/bank_concillation',$data,array(),array(
						'js'=>array(),
						'css'=>array(),
					));
			}
		}else{
			redirect('auth');
		}
	}
	public function changeStatusPresented($id=null,$type=null){
		if($this->isLoggedIn()){
				if($type == 'ng'){
				}else{
					if($id!=null){
						$update=$this->transaction_model->update('tbl_ledgerposting',array('id'=>$id),array('status'=>1));
						if($update){
								$this->session->set_flashdata('success',con_lang('mass_update _successfully'));
						        redirect($_SERVER['HTTP_REFERER']);
						}else{
							$this->session->set_flashdata('error',con_lang('mass_error_occurrs_try_later'));
						    redirect($_SERVER['HTTP_REFERER']);
						}
					}
				}
		}else{
			redirect('auth');
		}
	}
	public function bankReconcilation($type = null) {
		if($this->isLoggedIn()){
			if($type=='ng'){
			}else{
				$data['active']='Bank Reconcilation';
				$data['module']='accounting';
				$yearId=$this->getActiveYearId();
				if($this->input->server('REQUEST_METHOD') === 'POST'){
						$formData=$this->input->post();
						unset($formData['submit']);
						$formData['fromDate']=date('Y-m-d',strtotime($formData['from_date']));
						unset($formData['from_date']);
						$formData['toDate']=date('Y-m-d',strtotime($formData['from_to']));
						unset($formData['from_to']);
						$activeYearDate=$this->getActiveYearDate();
						if($formData['fromDate'] >=$activeYearDate->fromDate && $formData['toDate'] <=$activeYearDate->toDate){
								$query="SELECT * FROM tbl_ledgerposting WHERE company_id =$this->company_id AND voucherTypeId = 28 AND yearId=$yearId AND status IS NULL";
					           $data['allData']=$this->transaction_model->universal($query)->result();
					           $data['model']=$this->input->post();
						}else{
							$this->session->set_flashdata('error',con_lang('mass_please_select_within_active_financial_year'));
						    $data['model']=$this->input->post();
						}
				}else{
					$query="SELECT * FROM tbl_ledgerposting WHERE company_id =$this->company_id AND voucherTypeId = 28 AND yearId=$yearId AND status IS NULL";
					$data['allData']=$this->transaction_model->universal($query)->result();
				}
				if($this->session->flashdata('error')!='')
					$data['error']=$this->session->flashdata('error');
				unset($_SESSION['error']);
				if($this->session->flashdata('success'))
					$data['success']=$this->session->flashdata('success');
				$this->displayView('accounting/transactions/bank_reconcillation',$data,array(),array(
						'js'=>array(),
						'css'=>array(),
					));
			}
		}else{
			redirect('auth');
		}
	}
	public function addReconcillationEntry($type=null){
		if($this->isLoggedIn()){
			if($type == 'ng'){
			}else{
				if($this->input->post('data')){
					$formData=$this->input->post('data');
					$id=$formData[0]['id'];
					$postingdata['date']=$formData[0]['date'];
					$postingdata['voucherNo']=$formData[0]['voucherNo'];
					$postingdata['voucherTypeId']=$formData[0]['voucherTypeId'];
					$postingdata['ledgerId'] = $formData[0]['ledgerId'];
					if($formData[0]['debits'] > 0){
						$postingdata['credit']=$formData[0]['debits'];
					}
					if($formData[0]['credits'] > 0){
						$postingdata['debit']=$formData[0]['credits'];
					}
					$postingdata['company_id'] = $this->company_id;
					$postingdata['yearId'] = $this->getActiveYearId();
					$postingdata['status']='reconsilled';
					$saved=$this->transaction_model->add('tbl_ledgerposting',$postingdata);
					if($saved){
							$update=$this->transaction_model->update('tbl_ledgerposting',array('id'=>$id),array('status'=>$postingdata['status']));
							if($update){
								$this->session->set_flashdata('success',con_lang('mass_update _successfully'));
								$result=1;
								echo json_encode($result);exit();
							}
						    
					}else{
						$this->session->set_flashdata('error',con_lang('mass_error_occurrs_try_later'));
						$result=0;
							echo json_encode($result);exit();
					}
					
				}
			}
		}else{
			redirect('auth');
		}
	}
	
}