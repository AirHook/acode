<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
require_once(APPPATH."controllers/accounting/ERPController.php");
class Reports extends ERPController{
	function __construct(){
		parent::__construct();
		if(!$this->isLoggedIn()){
			redirect('auth');
		}
		$this->load->model('common_model');
		$this->load->model('reports_model');
	}
	public function salesReport($start=null,$end=null,$type=null){
		if($this->isLoggedIn()){
			if($type == 'ng'){
			} else {
				$data['active']='Sale Analysis Report';
				$data['module']='accounting';
				$data['reports'] = $this->getReports();
				$data['selected'] = 'salesReport';
				$result = $this->getReportValues($start, $end);
				$data = array_merge($data, $result);
				$start_date=$data['start'];
				
				$end_date=$data['end'];
				$active_yearID=$this->getActiveYearId();
				$company_id = $this->company_id;
				$where = "(company_id = $company_id OR company_id IS NULL)";
				$data['title'] = $data['active'];


				$data['print_url'] = base_url('accounting/reports/salesReport/'.$start_date.'/'.$end_date.'/print');
				$data['active_year'] = $this->getActiveYearDate();
				$data['payment_methods'] = $this->reports_model->getPaymentMethodsReport($start_date, $end_date);
				$data['cashier_sales'] = $this->reports_model->getSalesReportByCashier($start_date, $end_date);
						
				
				if($type == 'print') {
					$this->printPDF('sales_analysis_report', $data);
				} else {
					$data['content'] = $this->load->view('accounting/reports/reports/sales_analysis_report', $data, true);
					$this->displayView(array(
						'accounting/reports/report_header',
						'accounting/reports/report_content',
						'accounting/reports/report_footer',
					), $data);
				}
			}
		}else{
			redirect('auth');
		}
	}
	public function stockLedgerReport($product_id = null, $unit_id = null, $start=null,$end=null,$type=null){
		if($this->isLoggedIn()){
			if($type == 'ng'){
			} else {
				$data['active']='Stock Ledger Report';
				$data['module']='accounting';
				$data['reports'] = $this->getReports();
				$data['selected'] = 'stockLedgerReport';
				$result = $this->getReportValues($start, $end);
				$data = array_merge($data, $result);
				$start_date=$data['start'];
				
				$end_date=$data['end'];
				$active_yearID=$this->getActiveYearId();
				$company_id = $this->company_id;
				$data['unit_id'] = $unit_id;
				$data['product_id'] = $product_id;
				$where = "(company_id = $company_id OR company_id IS NULL)";
				$data['title'] = 'Stock Ledger Report';

				$data['has_product_filter'] = true;
				$data['has_unit_filter'] = true;
				$data['products'] = $this->reports_model->getAll('tbl_product', array('company_id' => $this->company_id));
				// $data['units'] = $this->reports_model->getAll('tbl_uom', array('company_id' => $this->company_id));
				$data['units'] = array();

				$data['print_url'] = base_url('accounting/reports/stockLedgerReport/'.$product_id.'/'.$unit_id.'/'.$start_date.'/'.$end_date.'/print');
				$data['active_year'] = $this->getActiveYearDate();

				if($product_id != null) {
					$query = $this->reports_model->universal("
						SELECT * FROM tbl_uom WHERE id IN (SELECT UOMId FROM tbl_purchasepricelist WHERE base_id IS NULL AND productName = $product_id AND company_id =".$this->company_id.")
					");
					$data['units'] = ($query) ? $query->result() : array();
				}

				if($unit_id != null && $product_id != null) {
					$rows = $this->reports_model->getStockLedgerReports($product_id, $unit_id, $start_date, $end_date);
					$data['ledgerReorts'] = $rows;
					$data['product_detail'] = $this->reports_model->getProductDetail($product_id, $unit_id);
				} 
						
				if($type == 'print') {
					$this->printPDF('stock_ledger_report', $data);
				} else {
					$data['content'] = $this->load->view('accounting/reports/reports/stock_ledger_report', $data, true);
					$this->displayView(array(
						'accounting/reports/report_header',
						'accounting/reports/report_content',
						'accounting/reports/report_footer',
					), $data);
				}
			}
		}else{
			redirect('auth');
		}
	}
	public function accountLedgerReports($group = 'all', $ledger = 'all', $start=null,$end=null,$type=null){
		if($this->isLoggedIn()){
			if($type == 'ng'){
			} else {
				$data['active']='Account Ledger Report';
				$data['module']='accounting';
				$data['reports'] = $this->getReports();
				$data['selected'] = 'ledgerReorts';
				$result = $this->getReportValues($start, $end);
				$data = array_merge($data, $result);
				$start_date=$data['start'];
				
				$end_date=$data['end'];
				$active_yearID=$this->getActiveYearId();
				$company_id = $this->company_id;
				$data['group'] = $group;
				$data['ledger_id'] = $ledger;
				$where = "(company_id = $company_id OR company_id IS NULL)";
				$data['account_groups'] =  $this->reports_model->getAll('tbl_accountgroup', $where);
				$data['title'] = 'Ledger Report';
				if($group != 'all') {
					$where .= " AND accountGroupId = $group";
					$data['account_ledgers'] =  $this->reports_model->getAll('tbl_accountledger', $where);
					$selected_group = $this->reports_model->getById('tbl_accountgroup', $group);
					if(isset($selected_group->accountGroupName))
						$data['title'] = $selected_group->accountGroupName;
				}
				$data['print_url'] = base_url('accounting/reports/accountLedgerReports/'.$group.'/'.$ledger.'/'.$start_date.'/'.$end_date.'/print');
				$data['active_year'] = $this->getActiveYearDate();
				if($ledger != 'all') {
					$data['single_report'] = true;
					$this->load->model('account_model');
					$data['ledger'] = (object)$this->account_model->getById('tbl_accountledger',$ledger);
					$rows = array();
					$row = $data['ledger'];
					$opening_blnce = $data['ledger']->openingBalance;
					$dbt_crdt = $data['ledger']->crOrDr;
					
					$rows = $this->reports_model->getAccountLedgerDetailReport($start_date, $end_date, $row->accountGroupId, $row->id, $opening_blnce, $dbt_crdt);
					
					$data['ledgerReorts'] = $rows;
					// echo '<pre>',print_r($data['ledgerReorts']),'</pre>';die();
				} else {
					$where = "(company_id = $company_id OR company_id IS NULL)";
					if($group != 'all'){
						$where .= " AND accountGroupId = $group ";
					}
					// echo '<pre>',print_r($where),'</pre>';die();
					$all_ledgers = $this->reports_model->getAll('tbl_accountledger', $where);
					if(!empty($all_ledgers)) {
						foreach ($all_ledgers as &$obj){
							$report = $this->reports_model->getAccountLedgerReport($start_date, $end_date, $obj->accountGroupId, $obj->id, $obj->openingBalance, $obj->crOrDr);
							// echo '<pre>',print_r($report),'</pre>';
							$obj = (array)$obj;
							if(!empty($report)){
								$obj = array_merge($obj, (array)$report);
							}else {
								$opening = (float)$obj['openingBalance'];
								$drcr = (isset($obj['crOrDr']) && ($obj['crOrDr'] == 'Debit' || $obj['crOrDr'] == 'Dr')) ? 'Dr' : 'Cr';
								$obj['Opening'] = number_format($opening, 2).' '.$drcr;
								$obj['debit1'] = number_format(0.00, 2);
								$obj['credit1'] = number_format(0.00, 2);
								$obj['closing'] = number_format($opening, 2).' '.$drcr;
							}
							$obj = (object)$obj;
						}
					}
					$data['ledgerReorts'] = $all_ledgers;
					// echo '<pre>',print_r($data['ledgerReorts']),'</pre>';die();
				}
				// die();
						
				if($type == 'print') {
					$this->printPDF('ledger_report', $data);
				} else {
				$data['content'] = $this->load->view('accounting/reports/reports/ledger_report', $data, true);
					$this->displayView(array(
						'accounting/reports/ledger_header',
						'accounting/reports/report_content',
						'accounting/reports/report_footer',
					), $data);
				}
			}
		}else{
			redirect('auth');
		}
	}
	
	public function getLedgersByGroup() {
		if($this->input->post('group')) {
			$group = $this->input->post('group');
			$company_id = $this->company_id;
			$where = "(company_id = $company_id OR company_id IS NULL) AND accountGroupId = $group";
			$ledgers =  $this->reports_model->getAll('tbl_accountledger', $where);
			echo json_encode($ledgers);
			exit();
		}
	}
	public function paymentReports($start=null,$end=null,$type=null){
		if($this->isLoggedIn()){
			if($type == 'ng'){
			}else{
				$data['active']='Payments Voucher';
				$data['module']='accounting';
				$data['reports'] = $this->getReports();
				$data['selected'] = 'paymentReports';
				$result = $this->getReportValues($start, $end);
				$data = array_merge($data, $result);
				$start_date=$data['start'];
				$end_date=$data['end'];
				if(isset($start_date)){
					$data['title'] = 'Payment Voucer Report';
					$query="DATE_FORMAT(created_on ,'%Y-%m-%d') >= '$start_date' AND DATE_FORMAT(created_on ,'%Y-%m-%d') <= '$end_date' AND company_id ='$this->company_id' ";
					 $paymentReorts = $this->reports_model->getPaymentReports($query);
					 $data['paymentReports'] = $paymentReorts;
				 }		
				$data['print_url'] = base_url('accounting/reports/paymentReports/'.$start_date.'/'.$end_date.'/print');
				if($type == 'print') {
					$this->printPDF('payment_voucher_report', $data);
				} else {
					$data['content'] = $this->load->view('accounting/reports/reports/payment_voucher_report', $data, true);
					$this->displayView(array(
						'accounting/reports/report_header',
						'accounting/reports/report_content',
						'accounting/reports/report_footer',
					), $data);
				}
			}
		}else{
			redirect('auth');
		}
	}
	public function receiptReports($start=null,$end=null,$type=null){
		if($this->isLoggedIn()){
			if($type == 'ng'){
			}else{
				$data['active']='Receipt Voucher Report';
				$data['module']='accounting';
				$data['reports'] = $this->getReports();
				$data['selected'] = 'receiptReports';
				$result = $this->getReportValues($start, $end);
				$data = array_merge($data, $result);
				$start_date=$data['start'];
				$end_date=$data['end'];
				if(isset($start_date)){
					$data['title'] = 'Receipt Voucher Report';
					$query="DATE_FORMAT(created_on ,'%Y-%m-%d') >= '$start_date' AND DATE_FORMAT(created_on ,'%Y-%m-%d') <= '$end_date' AND company_id ='$this->company_id' ";
					 $receiptReorts = $this->reports_model->getReceiptReports($query);
					 $data['receiptReports'] = $receiptReorts;	
					
				 }		
				$data['print_url'] = base_url('accounting/reports/receiptReports/'.$start_date.'/'.$end_date.'/print');
				if($type == 'print') {
					$this->printPDF('receipt_voucher_report', $data);
				} else {
					$data['content'] = $this->load->view('accounting/reports/reports/receipt_voucher_report', $data, true);
					$this->displayView(array(
						'accounting/reports/report_header',
						'accounting/reports/report_content',
						'accounting/reports/report_footer',
					), $data);
				}
			}
		}else{
			redirect('auth');
		}
	}
	
	public function purchaseInvoiceReports($start=null,$end=null,$type=null){
		if($this->isLoggedIn()){
			if($type == 'ng'){
			}else{
				$data['active']='Purchase Invoice Report';
				$data['module']='accounting';
				$data['reports'] = $this->getReports();
				$data['selected'] = 'purchaseInvoiceReports';
				$result = $this->getReportValues($start, $end);
				$data = array_merge($data, $result);
				$start_date=$data['start'];
				$end_date=$data['end'];
				if(isset($start_date)){
					$data['title'] = 'Purchase Invoice Report';
					$query="DATE_FORMAT(created_on ,'%Y-%m-%d') >= '$start_date' AND DATE_FORMAT(created_on ,'%Y-%m-%d') <= '$end_date' AND company_id ='$this->company_id'  AND is_deleted = 0";
					 $purchaseInvoiceReports = $this->reports_model->getPurchaseInvoiceReports($query);
					 $data['purchaseInvoiceReports'] = $purchaseInvoiceReports;	

				 }		
				$data['print_url'] = base_url('accounting/reports/purchaseInvoiceReports/'.$start_date.'/'.$end_date.'/print');
				if($type == 'print') {
					$this->printPDF('purchase_invoice_report', $data);
				} else {
					$data['content'] = $this->load->view('accounting/reports/reports/purchase_invoice_report', $data, true);
					$this->displayView(array(
						'accounting/reports/report_header',
						'accounting/reports/report_content',
						'accounting/reports/report_footer',
					), $data);
				}
			}
		}else{
			redirect('auth');
		}
	}
	public function deletedPurchaseInvoiceReports($start=null,$end=null,$type=null){
		if($this->isLoggedIn()){
			if($type == 'ng'){
			}else{
				$data['active']='Deleted Purchase Invoice Report';
				$data['module']='accounting';
				$data['reports'] = $this->getReports();
				$data['selected'] = 'deletedPurchaseInvoiceReports';
				$result = $this->getReportValues($start, $end);
				$data = array_merge($data, $result);
				$start_date=$data['start'];
				$end_date=$data['end'];
				if(isset($start_date)){
					$data['title'] = $data['active'];
					$query="DATE_FORMAT(created_on ,'%Y-%m-%d') >= '$start_date' AND DATE_FORMAT(created_on ,'%Y-%m-%d') <= '$end_date' AND company_id ='$this->company_id' AND is_deleted = 1";
					 $purchaseInvoiceReports = $this->reports_model->getPurchaseInvoiceReports($query);
					 $data['purchaseInvoiceReports'] = $purchaseInvoiceReports;	

				 }		
				$data['print_url'] = base_url('accounting/reports/deletedPurchaseInvoiceReports/'.$start_date.'/'.$end_date.'/print');
				if($type == 'print') {
					$this->printPDF('purchase_invoice_report', $data);
				} else {
					$data['content'] = $this->load->view('accounting/reports/reports/purchase_invoice_report', $data, true);
					$this->displayView(array(
						'accounting/reports/report_header',
						'accounting/reports/report_content',
						'accounting/reports/report_footer',
					), $data);
				}
			}
		}else{
			redirect('auth');
		}
	}
	public function purchaseReturnReports($start=null,$end=null,$type=null){
		if($this->isLoggedIn()){
			if($type == 'ng'){
			}else{
				$data['active']='Purchase Return Report';
				$data['module']='accounting';
				$data['reports'] = $this->getReports();
				$data['selected'] = 'purchaseReturnReports';
				$result = $this->getReportValues($start, $end);
				$data = array_merge($data, $result);
				$start_date=$data['start'];
				$end_date=$data['end'];
				if(isset($start_date)){
					$data['title'] = 'Purchase Return Report';
					$query="DATE_FORMAT(created_on ,'%Y-%m-%d') >= '$start_date' AND DATE_FORMAT(created_on ,'%Y-%m-%d') <= '$end_date' AND company_id = ".$this->company_id;
					 $purchaseReturnReports = $this->reports_model->purchaseReturnReports($query);
					 $data['purchaseReturnReports'] = $purchaseReturnReports;	
					 foreach($data['purchaseReturnReports'] as $key => &$value){
					 	if(isset($value->product_id)){
					 		$products_detail=$this->reports_model->getOne('tbl_product',array('id'=>$value->product_id));
					 		$value->products_name=isset($products_detail->productName) ? $products_detail->productName :'';
					 	}
					 }
				 }
				 $data['print_url'] = base_url('accounting/reports/purchaseReturnReports/'.$start_date.'/'.$end_date.'/print');
				if($type == 'print') {
					$this->printPDF('purchase_return_report', $data);
				}else{
					$data['content'] = $this->load->view('accounting/reports/reports/purchase_return_report', $data, true);
						$this->displayView(array(
							'accounting/reports/report_header',
							'accounting/reports/report_content',
							'accounting/reports/report_footer',
						), $data);
				}		
			}
		}else{
			redirect('auth');
		}
	}
	public function saleInvoiceReports($start=null,$end=null,$type=null, $cashier = null, $payment_method = null){
		if($this->isLoggedIn()){
			if($type == 'ng'){
			}else{
				$data['active']='Sale Invoice Report';
				$data['module']='accounting';
				$data['reports'] = $this->getReports();
				$data['selected'] = 'saleInvoiceReports';
				$result = $this->getReportValues($start, $end);
			
				$data = array_merge($data, $result);
				
				$start_date=$data['start'];
				$end_date=$data['end'];

				if(isset($start_date)){
					$data['title'] = 'Sale Invoice Report';
					$query="DATE_FORMAT(created_on ,'%Y-%m-%d') >= '$start_date' AND DATE_FORMAT(created_on ,'%Y-%m-%d') <= '$end_date' AND company_id ='$this->company_id'  AND is_deleted = 0";
					if($cashier > 0) {
						$query .= " AND created_by = $cashier ";
					}
					if($payment_method > 0) {
						$query .= " AND salesInvoiceNo IN (SELECT salesInvoiceNo FROM add_payment WHERE method_id = ".$payment_method.")";
					}
					 $saleInvoiceReports = $this->reports_model->getSaleInvoiceReports($query);
					 $data['saleInvoiceReports'] = $saleInvoiceReports;	
				 }		
				$data['has_cashier_filter'] = true;
				$data['cashier'] = $cashier;
				$data['has_payment_method_filter'] = true;
				$data['payment_method'] = $payment_method;
				$data['users'] = $this->common_model->getAll('tbl_users', array('company_id' => $this->company_id));
				$data['payment_methods'] = $this->common_model->getAll('tbl_payment_methods', array('company_id' => $this->company_id));
				$cashier = ($cashier == '') ? 'null' : $cashier;
				$payment_method = ($payment_method == '') ? 'null' : $payment_method;
				$data['print_url'] = base_url('accounting/reports/saleInvoiceReports/'.$start_date.'/'.$end_date.'/print/'.$cashier.'/'.$payment_method);
				if($type == 'print') {
					$this->printPDF('sale_invoice_report', $data);
				} else {
					$data['content'] = $this->load->view('accounting/reports/reports/sale_invoice_report', $data, true);
					$this->displayView(array(
						'accounting/reports/report_header',
						'accounting/reports/report_content',
						'accounting/reports/report_footer',
					), $data);
				}
			}
		}else{
			redirect('auth');
		}
	}
	public function deletedSaleInvoiceReports($start=null,$end=null,$type=null, $cashier = null, $payment_method = null){
		if($this->isLoggedIn()){
			if($type == 'ng'){
			}else{
				$data['active']='Deleted Sale Invoice Report';
				$data['module']='accounting';
				$data['reports'] = $this->getReports();
				$data['selected'] = 'deletedSaleInvoiceReports';
				$result = $this->getReportValues($start, $end);
			
				$data = array_merge($data, $result);
				
				$start_date=$data['start'];
				$end_date=$data['end'];
				if(isset($start_date)){
					$data['title'] = 'Deleted Sale Invoice Report';
					$query="DATE_FORMAT(created_on ,'%Y-%m-%d') >= '$start_date' AND DATE_FORMAT(created_on ,'%Y-%m-%d') <= '$end_date' AND company_id ='$this->company_id' AND is_deleted = 1";
					if($cashier > 0) {
						$query .= " AND created_by = $cashier ";
					}
					if($payment_method > 0) {
						$query .= " AND salesInvoiceNo IN (SELECT salesInvoiceNo FROM add_payment WHERE method_id = ".$payment_method.")";
					}
					 $saleInvoiceReports = $this->reports_model->getSaleInvoiceReports($query);
					 $data['saleInvoiceReports'] = $saleInvoiceReports;	
				 }		
				$data['has_cashier_filter'] = true;
				$data['cashier'] = $cashier;
				$data['has_payment_method_filter'] = true;
				$data['payment_method'] = $payment_method;
				$data['users'] = $this->common_model->getAll('tbl_users', array('company_id' => $this->company_id));
				$data['payment_methods'] = $this->common_model->getAll('tbl_payment_methods', array('company_id' => $this->company_id));
				$cashier = ($cashier == '') ? 'null' : $cashier;
				$payment_method = ($payment_method == '') ? 'null' : $payment_method;
				$data['print_url'] = base_url('accounting/reports/deletedSaleInvoiceReports/'.$start_date.'/'.$end_date.'/print/'.$cashier.'/'.$payment_method);
				if($type == 'print') {
					$this->printPDF('sale_invoice_report', $data);
				} else {
					$data['content'] = $this->load->view('accounting/reports/reports/sale_invoice_report', $data, true);
					$this->displayView(array(
						'accounting/reports/report_header',
						'accounting/reports/report_content',
						'accounting/reports/report_footer',
					), $data);
				}
			}
		}else{
			redirect('auth');
		}
	}
	public function saleInvoiceDetailReport($start=null,$end=null,$type=null, $cashier = null, $payment_method = null){
		if($this->isLoggedIn()){
			if($type == 'ng'){
			}else{
				$data['active']='Detailed Sale Report';
				$data['module']='accounting';
				$data['reports'] = $this->getReports();
				$data['selected'] = 'saleInvoiceDetailReport';
				$result = $this->getReportValues($start, $end);
				$data = array_merge($data, $result);
				$start_date=$data['start'];
				$end_date=$data['end'];
				if(isset($start_date)){
					$data['title'] = 'Detailed Sale Report';
					$query="DATE_FORMAT(tbl_salesinvoicemaster.created_on ,'%Y-%m-%d') >= '$start_date' AND DATE_FORMAT(tbl_salesinvoicemaster.created_on ,'%Y-%m-%d') <= '$end_date' AND tbl_salesinvoicemaster.company_id ='$this->company_id' AND tbl_salesinvoicemaster.is_deleted = 0 ";
					if($cashier > 0) {
						$query .= " AND tbl_salesinvoicemaster.created_by = $cashier ";
					}
					if($payment_method > 0) {
						$query .= " AND tbl_salesinvoicemaster.salesInvoiceNo IN (SELECT salesInvoiceNo FROM add_payment WHERE method_id = ".$payment_method.")";
					}
					 $saleInvoiceReports = $this->reports_model->getSaleInvoiceDetailReports($query);
					 $data['saleInvoiceReports'] = $saleInvoiceReports;	
				 }	
				 $data['has_cashier_filter'] = true;
				$data['cashier'] = $cashier;
				 $data['has_payment_method_filter'] = true;
				$data['payment_method'] = $payment_method;
				$data['users'] = $this->common_model->getAll('tbl_users', array('company_id' => $this->company_id));	
				$data['payment_methods'] = $this->common_model->getAll('tbl_payment_methods', array('company_id' => $this->company_id));
				$data['print_url'] = base_url('accounting/reports/saleInvoiceDetailReport/'.$start_date.'/'.$end_date.'/print/'.$cashier.'/'.$payment_method);
				if($type == 'print') {
					$this->printPDF('sale_invoice_detail_report', $data);
				} else {
					$data['content'] = $this->load->view('accounting/reports/reports/sale_invoice_detail_report', $data, true);
					$this->displayView(array(
						'accounting/reports/report_header',
						'accounting/reports/report_content',
						'accounting/reports/report_footer',
					), $data);
				}
			}
		}else{
			redirect('auth');
		}
	}
	// public function purchaseReturnReport($start=null,$end=null,$type=null){
	// 	if($this->isLoggedIn()){
	// 		if($type == 'ng'){
	// 		}else{
	// 			$data['active']='Purchase Return  Report';
	// 			$data['module']='accounting';
	// 			$data['reports'] = $this->getReports();
	// 			$data['selected'] = 'purchaseReturnReport';
	// 			$result = $this->getReportValues($start, $end);
	// 			$data = array_merge($data, $result);
	// 			$start_date=$data['start'];
	// 			$end_date=$data['end'];
	// 			if(isset($start_date)){
	// 				$data['title'] = 'Purchase Return  Report';
	// 				$query="DATE_FORMAT(deliveryDate ,'%Y-%m-%d') >= '$start_date' AND DATE_FORMAT(deliveryDate ,'%Y-%m-%d') <= '$end_date' AND company_id ='$this->company_id' ";
	// 				 $purchaseReturnReport = $this->reports_model->purchaseReturnReport($query);
	// 				 debug($purchaseReturnReport);
	// 				 $data['purchaseReturnReport'] = $purchaseReturnReport;	
	// 			 }		
	// 			$data['print_url'] = base_url('accounting/reports/purchaseReturnReport/'.$start_date.'/'.$end_date.'/print');
	// 			if($type == 'print') {
	// 				$this->printPDF('return_invoice_report', $data);
	// 			} else {
	// 				$data['content'] = $this->load->view('accounting/reports/reports/purchase_return_report', $data, true);
	// 				$this->displayView(array(
	// 					'reports/report_header',
	// 					'reports/report_content',
	// 					'reports/report_footer',
	// 				), $data);
	// 			}
	// 		}
	// 	}else{
	// 		redirect('auth');
	// 	}
	// }
	public function saleReturnReports($start=null,$end=null,$type=null){
		if($this->isLoggedIn()){
			if($type == 'ng'){
			}else{
				$data['active']='Sale Return Report';
				$data['module']='accounting';
				$data['reports'] = $this->getReports();
				$data['selected'] = 'saleReturnReports';
				$result = $this->getReportValues($start, $end);
				$data = array_merge($data, $result);
				$start_date=$data['start'];
				$end_date=$data['end'];
				if(isset($start_date)){
					$data['title'] = 'Sale Return Report';
					$query="DATE_FORMAT(created_on ,'%Y-%m-%d') >= '$start_date' AND DATE_FORMAT(created_on ,'%Y-%m-%d') <= '$end_date' AND company_id = ".$this->company_id;
					 $saleReturnReports = $this->reports_model->getSaleReturnReports($query);
					 $data['saleReturnReports'] = $saleReturnReports;	
					  // echo '<pre>',print_r($data['saleReturnReports']),'</pre>',exit();
				 }
				 $data['print_url'] = base_url('accounting/reports/saleReturnReports/'.$start_date.'/'.$end_date.'/print');
				if($type == 'print') {
					$this->printPDF('sale_return_report', $data);
				}else{
					$data['content'] = $this->load->view('accounting/reports/reports/sale_return_report', $data, true);
						$this->displayView(array(
							'accounting/reports/report_header',
							'accounting/reports/report_content',
							'accounting/reports/report_footer',
						), $data);
				}		
			}
		}else{
			redirect('auth');
		}
	}
	// public function 
	public function stockReport($start=null,$end=null,$type=null){
		// die();
		if($this->isLoggedIn()){
			if($type == 'ng'){
			}else{
				$data['active']='Stock Report';
				$data['module']='accounting';
				$data['reports'] = $this->getReports();
				$data['selected'] = 'stockReport';
				$result = $this->getReportValues($start, $end);
				$data = array_merge($data, $result);
				$start_date=$data['start'];
				$end_date=$data['end'];
				if(isset($start_date)){
					$data['title'] = 'Stock Report';
					$query="DATE_FORMAT(created_on ,'%Y-%m-%d') >= '$start_date' AND DATE_FORMAT(created_on ,'%Y-%m-%d') <= '$end_date' AND company_id = $this->company_id";
					 $stockReports = $this->reports_model->getStockReports($query);
					 $data['stockReports'] = $stockReports;	
					  // echo '<pre>',print_r($data['stockReports']),'</pre>',exit();
				 }	
				$data['print_url'] = base_url('accounting/reports/stockReport/'.$start_date.'/'.$end_date.'/print');	
				if($type == 'print') {
					$this->printPDF('stock_report', $data);
				}else{
					$data['content'] = $this->load->view('accounting/reports/reports/stock_report', $data, true);
						$this->displayView(array(
							'accounting/reports/report_header',
							'accounting/reports/report_content',
							'accounting/reports/report_footer',
						), $data);
				}
			}
		}else{
			redirect('auth');
		}
	}

	public function cashBook($start=null,$end=null,$type=null){
		if($this->isLoggedIn()){
			if($type == 'ng'){
			}else{
				$data['active']='Cash/Bank Book';
				$data['module']='accounting';
				$data['reports'] = $this->getReports();
				$data['selected'] = 'cashBook';
				$result = $this->getReportValues($start, $end);
				$data = array_merge($data, $result);
				$start_date=$data['start'];
				$end_date=$data['end'];
				$data['title'] = $data['active'];
				$query="DATE_FORMAT(created_on ,'%Y-%m-%d') >= '$start_date' AND DATE_FORMAT(created_on ,'%Y-%m-%d') <= '$end_date'";
				 $data['ledgerReorts'] = $this->reports_model->getAccountLedgerReportByGroup("A.accountGroupId = 27 OR A.accountGroupId = 28", $start_date, $end_date);
						
				$data['content'] = $this->load->view('accounting/reports/reports/ledger_report', $data, true);
					$this->displayView(array(
						'accounting/reports/report_header',
						'accounting/reports/report_content',
						'accounting/reports/report_footer',
					), $data);
			}
		}else{
			redirect('auth');
		}
	}
	public function taxReport($start=null,$end=null,$type=null){
		if($this->isLoggedIn()){
			if($type == 'ng'){
			}else{
				$data['active']='Tax Report';
				$data['module']='accounting';
				$data['reports'] = $this->getReports();
				$data['selected'] = 'taxReport';
				$result = $this->getReportValues($start, $end);
				$data = array_merge($data, $result);
				$start_date=$data['start'];
				$end_date=$data['end'];
				$data['title'] = $data['active'];
				$query="DATE_FORMAT(created_on ,'%Y-%m-%d') >= '$start_date' AND DATE_FORMAT(created_on ,'%Y-%m-%d') <= '$end_date'";
				 $data['ledgerReorts'] = $this->reports_model->getAccountLedgerReportByGroup("A.accountGroupId = 20", $start_date, $end_date);
						
				$data['content'] = $this->load->view('accounting/reports/reports/ledger_report', $data, true);
					$this->displayView(array(
						'accounting/reports/report_header',
						'accounting/reports/report_content',
						'accounting/reports/report_footer',
					), $data);
			}
		}else{
			redirect('auth');
		}
	}
	public function checkReport($start=null,$end=null,$type=null){
		if($this->isLoggedIn()){
			if($type == 'ng'){
			}else{
				$data['active']='Cheque Report';
				$data['module']='accounting';
				$data['reports'] = $this->getReports();
				$data['selected'] = 'checkReport';
				$result = $this->getReportValues($start, $end);
				$data = array_merge($data, $result);
				$start_date=$data['start'];
				$end_date=$data['end'];
				$data['title'] = $data['active'];
				$query="DATE_FORMAT(created_on ,'%Y-%m-%d') >= '$start_date' AND DATE_FORMAT(created_on ,'%Y-%m-%d') <= '$end_date'";
				 $data['ledgerReorts'] = $this->reports_model->getAccountLedgerReportByGroup("A.accountGroupId = 28", $start_date, $end_date);
						
				$data['content'] = $this->load->view('accounting/reports/reports/ledger_report', $data, true);
					$this->displayView(array(
						'accounting/reports/report_header',
						'accounting/reports/report_content',
						'accounting/reports/report_footer',
					), $data);
			}
		}else{
			redirect('auth');
		}
	}
	public function dayBook($start=null,$end=null,$type=null){
		if($this->isLoggedIn()){
			if($type == 'ng'){
			}else{
				$data['active']='Day Book';
				$data['module']='accounting';
				$data['reports'] = $this->getReports();
				$data['selected'] = 'dayBook';
				$result = $this->getReportValues($start, $end);
				$data = array_merge($data, $result);
				$start_date=$data['start'];
				$end_date=$data['end'];
				$data['title'] = $data['active'];
				$query="DATE_FORMAT(created_on ,'%Y-%m-%d') >= '$start_date' AND DATE_FORMAT(created_on ,'%Y-%m-%d') <= '$end_date'";
				 $data['ledgerReorts'] = $this->reports_model->getAccountLedgerReportByGroup(null, $start_date, $end_date);
						
				$data['content'] = $this->load->view('accounting/reports/reports/ledger_report', $data, true);
					$this->displayView(array(
						'accounting/reports/report_header',
						'accounting/reports/report_content',
						'accounting/reports/report_footer',
					), $data);
			}
		}else{
			redirect('auth');
		}
	}
	public function journalVoucherReports($start=null,$end=null,$type=null){
		if($this->isLoggedIn()){
			if($type=='ng'){

			}else{
				$data['active']='Journal Report';
				$data['module']='accounting';
				$data['reports'] = $this->getReports();
				$data['selected'] = 'journalVoucherReports';
				$result = $this->getReportValues($start, $end);
				$data = array_merge($data, $result);
				$start_date=$data['start'];
				$end_date=$data['end'];
				$data['title'] = 'Journal Voucher Report';
				$activeYear=$this->getActiveYearId();
				$query="DATE_FORMAT(created_on ,'%Y-%m-%d') >= '$start_date' AND DATE_FORMAT(created_on ,'%Y-%m-%d') <= '$end_date' AND voucherTypeId = 6 AND company_id ='$this->company_id'";
				$data['journalReports']=$this->reports_model->getAll('tbl_ledgerposting',$query);
				$data['print_url'] = base_url('accounting/reports/journalVoucherReports/'.$start_date.'/'.$end_date.'/print');
				if($type == 'print') {
					$this->printPDF('journal_voucher_report', $data);
				} else {
					$data['content'] = $this->load->view('accounting/reports/reports/journal_voucher_report', $data, true);
					$this->displayView(array(
						'accounting/reports/report_header',
						'accounting/reports/report_content',
						'accounting/reports/report_footer',
					), $data);
				}
			}
		}else{
			redirect('auth');
		}
	}
	private function printPDF($name = '', $data = array()) {
		$this->load->helper(array('mpdf', 'file'));
		$data['is_print'] = true;
		$data['content'] = $this->load->view('accounting/reports/reports/'.$name, $data, true);
	    $html = $this->displayView('accounting/reports/report_content' ,$data,array('topbar', 'sidenav'),array(
						'js'=>array(),
						'css'=>array(),
					), true);
	   $filename = $name;
	  	echo $html;
	  	exit();
	   // pdf_create($html, $filename.'.pdf');
	}
	public function saleInvoicesReports($type=null){
		if($this->isLoggedIn()){
			if($type=='ng'){

			}else{
				$data['active']='Sale Invoice Report';
				$data['module']='accounting';
				$activeYear=$this->getActiveYearId();
				$data['saleInvoiceReport']=$this->reports_model->getSaleReports($activeYear);
				// debug($data['saleInvoiceReport']);
				$this->displayView('accounting/reports/sale_invoice_report',$data,array(),array(
						'js'=>array(),
						'css'=>array(),
					));
			}
		}else{
			redirect('auth');
		}
	}
	public function cashBookReports($type=null){
		if($this->isLoggedIn()){
			if($type=='ng'){

			}else{
				$data['active']='Cash Book';
				$data['module']='accounting';
				$this->displayView('accounting/reports/report_view',$data,array(),array(
						'js'=>array(),
						'css'=>array(),
					));
			}
		}else{
			redirect('auth');
		}
	}
	public function taxesReport($type=null){
		if($this->isLoggedIn()){
			if($type=='ng'){

			}else{
				$data['active']='Taxes Report';
				$data['module']='accounting';
				$activeYear=$this->getActiveYearId();
				$data['taxReport']=$this->reports_model->getAll('tbl_ledgerposting',array('yearId'=>$activeYear,'voucherTypeId'=>5, 'company_id' => $this->company_id));
				// debug($data['taxReport']);
				$this->displayView('accounting/reports/report_view',$data,array(),array(
						'js'=>array(),
						'css'=>array(),
					));
			}
		}else{
			redirect('auth');
		}
	}
	private function getReportValues($start = null, $end = null){
		$data = array();
		$start = ($start == 'null') ? null : $start;
		$end = ($end == 'null') ? null : $end;
		$date_range = -30;
		if($start == 'last30Days' || $start == null) {
			$start = date('Y-m-d', strtotime('-30 days'));
		} else if($start == 'last15Days') {
			$date_range = -15;
			$start = date('Y-m-d', strtotime('-15 days'));
		} else if($start == 'lastWeek') {
			$date_range = -7;
			$start = date('Y-m-d', strtotime('-7 days'));
		}  else if($start == 'today') {
			$date_range = '0';
			$start = date('Y-m-d');
		}  else if($start == 'active_year') {
			$date_range = 'active_year';
			$active_year = $this->getActiveYearDate();
			// print_r($active_year);die();
			$start = $active_year->fromDate;
			$end = $active_year->toDate;
		} else {
			$date_range = '';
		}
		if($end == null)
			$end = date('Y-m-d');
		$data['date_range'] = $date_range;
		$data['start'] = date('Y-m-d', strtotime($start));
		$data['end'] = date('Y-m-d', strtotime($end));
		return $data;
	}
}