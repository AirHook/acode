<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
require_once(APPPATH."controllers/accounting/ERPController.php");
class Sales extends ERPController{
	function __construct(){
		parent::__construct();
		if(!$this->isLoggedIn()){
			redirect('auth');
		}
		$this->load->model('company_model');
		$this->load->model('settings_model');
		$this->load->model('sale_model');
	}
	public function pos($id=null,$type = null){
		if($this->isLoggedIn()){
			if($type == 'ng'){

			}else{
				$data['active']='Point of Sale';
				$data['full_view'] = true;
				$data['module']='accounting';
				$query="SELECT * FROM tbl_payment_methods WHERE is_active = 1 AND (company_id IS NULL OR company_id = ".$this->company_id.")";
				$data['payment_method']=$this->sale_model->universal($query)->result();
				$query="SELECT COUNT(id) AS TotalRecord FROM tbl_salesinvoicemaster WHERE company_id = $this->company_id";
				$data['totalInvoice']=$this->sale_model->universal($query)->row()->TotalRecord;
				$data['categories']=$this->sale_model->getAll('tbl_productgroup',array('company_id'=>$this->company_id),array('created_on','desc'));
				$apply_tax = $this->common_model->getOne('tbl_apply_taxes', array('company_id' => $this->company_id, 'voucher_type' => 'sale'));
				if(isset($apply_tax->taxes) && $apply_tax->taxes != '') {
					$data['product_taxes'] = $this->sale_model->getAll('tbl_accountledger', "product_bill = 'product' AND company_id = ".$this->company_id." AND id IN (".$apply_tax->taxes.")");
					$data['taxesOnBill'] = $this->sale_model->getAll('tbl_accountledger', "product_bill = 'bill' AND company_id = ".$this->company_id." AND id IN (".$apply_tax->taxes.")");
				}
				$data['products']=$this->sale_model->liveCheckStockFromProducts();
				$data['customers']=$this->sale_model->searchCustomers();
				$data['salesInvoiceNo']=$this->sale_model->getSaleInvoices();
				if($id!=null){
					$data['master']=$this->sale_model->getById('tbl_salesinvoicemaster',$id);
					if(!empty($data['master'])){
							if(isset($data['master']->salesInvoiceNo)){
									$data['details']=$this->sale_model->getAll('tbl_salesinvoicedetails',array('salesInvoiceNo'=>$data['master']->salesInvoiceNo, 'company_id' => $this->company_id));
									if(!empty($data['details'])){
										foreach ($data['details'] as $key => &$value){
											if(isset($value->tax_id)){
												$value->tax_detail=$this->sale_model->getOne('tbl_accountledger',array('id'=>$value->tax_id,'company_id'=>$this->company_id));
											}
											if(isset($value->product_id)){
													$query2="SELECT * FROM tbl_purchasepricelist WHERE productName = $value->product_id AND company_id=$this->company_id";
													$result['units_price']=$this->sale_model->universal($query2)->result();
													if(!empty($result['units_price'])){
														foreach($result['units_price'] as $key => &$units){
															if(isset($units->UOMId)){
																$units->units=$this->sale_model->getOne('tbl_uom',array('id'=>$units->UOMId));
													    }
													}
													$value->all_units=$result['units_price'];
												}
											}
								}
							}
							$data['payments']=$this->sale_model->getAll('add_payment',array('salesInvoiceNo'=>$data['master']->salesInvoiceNo, 'company_id' => $this->company_id));
							// debug($data['master']);
							$apply_tax = $this->common_model->getOne('tbl_apply_taxes', array('company_id' => $this->company_id, 'voucher_type' => 'sale'));
							$taxes = array();
							if(isset($apply_tax->taxes) && $apply_tax->taxes != '') {
								$data['taxes'] = $this->sale_model->getAll('tbl_accountledger', "product_bill = 'product' AND company_id = ".$this->company_id." AND id IN (".$apply_tax->taxes.")");
							}
						}
					}
				}
				// debug($data['model']);
				$this->displayView('accounting/sales/pos',$data,array(),array(
					'js'=>array(
						base_url('assets/erp/js/pos.js')
					),
					'css'=>array(
						base_url('assets/erp/css/pos.css')
					),
				));
			}
		}else{
			redirect('auth');
		}
	}
	public function saleQuotation($type = null){
		if($this->isLoggedIn()){
				if($type=='ng'){
				}else{
					$data['active']='Sales Quotation';
					$data['module']='accounting';
					$data['allData']=$this->sale_model->getAll('tbl_saleqoutationmaster',array('company_id'=>$this->session->userdata('company_id')), array('created_on', 'DESC'));
					$this->displayView('accounting/sales/sale_quotation_listing',$data,array(),array(
							'js'=>array(),
							'css'=>array(),
						));
				}
		}else{
			redirect('auth');
		}
	}
	public function AddSaleQuotation($qoutationNo=null,$type = null) {
		if($this->isLoggedIn()){
				if($type=='ng'){
				}else{
					$data['active']='Sales Quotation';
					$data['module']='accounting';
					 if($this->input->server('REQUEST_METHOD')==='POST'){
					 	$dateActiveYear=date('Y-m-d',strtotime($this->input->post('deliveryDate')));
					   	  $activeYear=$this->sale_model->getOne('tbl_financialyear',array('isActive'=>1,'company_id'=>$this->session->userdata('company_id')));
					   	  if(!empty($activeYear)){
					   	  if($dateActiveYear >= $activeYear->fromDate && $dateActiveYear <= $activeYear->toDate){
						  $saleQuotationMaster=array(
						  		'qoutationNo'=>$this->input->post('qoutationNo'),
						  		'customerId'=>$this->input->post('supplierId'),
						  		'company_id'=>$this->session->userdata('company_id'),
						  		'salesmanId'=>$this->input->post('salesmanId'),
						  		'currencyId'=>$this->input->post('currencyId'),
						  		'deliveryDate'=>date('Y-m-d',strtotime($this->input->post('deliveryDate'))),
						  		'status'=>0,
						  		'isApproved'=>1,
						  		'isPrintAfterSave'=>$this->input->post('purchaseOrderisprintAfterSave'),
						  		'subtotal'=>deformat_value($this->input->post('subtotal')),
						  		'discount'=>deformat_value($this->input->post('discount')),
						  		'freight'=>deformat_value($this->input->post('freight')),
						  		'tax'=>deformat_value($this->input->post('tax')),
						  		'total'=>deformat_value($this->input->post('total')),
						  		'narration'=>$this->input->post('narration'),
						  	);
						  $saleQuotationMaster['created_on'] =  date('Y-m-d H:i:s', strtotime($saleQuotationMaster['deliveryDate'].' '.date('H:i:s')));
						  $products=$this->input->post('product');
						  $savedInsaleQuotationMaster=$this->sale_model->add('tbl_saleqoutationmaster',$saleQuotationMaster);
						  if($savedInsaleQuotationMaster > 0){
							  	foreach($products as $values){
							  	 $values['rate']=deformat_value($values['rate']);
							  	 if(isset($values['discount_amount'])){
							  	 	$values['discount_amount']=deformat_value($values['discount_amount']);
							  	 }
							  	 $values['amount']=deformat_value($values['amount']);
							  	 $values['QuotationNumber']=$this->input->post('qoutationNo');
							  	 $values['company_id']=$this->session->userdata('company_id');
	                          	 $savedInSaleQuotationDetail=$this->sale_model->add('tbl_saleqoutationdetails',$values);
	                          }
	                           if($this->input->post('save_print')) {
							  		$qoutationNo = $this->input->post('qoutationNo');
							   		if(isset($qoutationNo) && $qoutationNo > 0) {
							   			$this->session->set_flashdata('print_sale_quoatation', $qoutationNo);
							   			// $this->printQuotation($qoutationNo);
							   		}
							   	}
	                          if($savedInSaleQuotationDetail > 0){
	                          	$this->session->set_flashdata('success',con_lang('mass_sales_quotation_added_successfully'));
	                          	redirect($_SERVER['HTTP_REFERER']);
	                          }else{
	                          		$this->session->set_flashdata('error',con_lang('mass_error_occurrs_try_later'));
	                             	redirect($_SERVER['HTTP_REFERER']);
	                          }
						  }else{
						  	     $this->session->set_flashdata('error',con_lang('mass_error_occurrs_try_later'));
	                          	  redirect($_SERVER['HTTP_REFERER']);
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
					if($qoutationNo!=null){
						$data['model']=(array)$this->sale_model->getByIdSaleQuotation(decode_uri($qoutationNo));
						$data['edit_sale'] = true;
						// debug($data['model']);
					}
					if($qoutationNo==null){
						$query="SELECT COUNT(id) AS TotalRecord FROM tbl_saleqoutationmaster";
						$data['totalQuotation']=$this->sale_model->universal($query)->row()->TotalRecord;
					}
					// $data['taxesOnBill']=$this->sale_model->getAll('tbl_accountledger',array('product_bill'=>'bill','company_id'=>$this->company_id, 'accountGroupId' => 20));
					$data['currency']=$this->sale_model->getCurrency();
					$apply_tax = $this->common_model->getOne('tbl_apply_taxes', array('company_id' => $this->company_id, 'voucher_type' => 'sale'));
					if(isset($apply_tax->taxes) && $apply_tax->taxes != '') {
						$data['product_taxes'] = $this->sale_model->getAll('tbl_accountledger', "product_bill = 'product' AND company_id = ".$this->company_id." AND id IN (".$apply_tax->taxes.")");
						$data['taxesOnBill'] = $this->sale_model->getAll('tbl_accountledger', "product_bill = 'bill' AND company_id = ".$this->company_id." AND id IN (".$apply_tax->taxes.")");
					}
					$this->displayView('accounting/sales/sale_quotation',$data,array(),array(
							'js'=>array(),
							'css'=>array(),
						));
				}
		}else{
			redirect('auth');
		}
	}
	public function editSaleQuotation($qoutationNo=null,$type=null){
				if($this->isLoggedIn()){
					if($type!=null){
					}else{
						if($this->input->server('REQUEST_METHOD')==='POST'){
							 $saleQuotationMaster=array(
						  		'customerId'=>$this->input->post('supplierId'),
						  		'salesmanId'=>$this->input->post('salesmanId'),
						  		'company_id'=>$this->session->userdata('company_id'),
						  		'currencyId'=>$this->input->post('currencyId'),
						  		'deliveryDate'=>date('Y-m-d',strtotime($this->input->post('deliveryDate'))),
						  		
						  		'isApproved'=>1,
						  		'isPrintAfterSave'=>$this->input->post('purchaseOrderisprintAfterSave'),
						  		'subtotal'=>deformat_value($this->input->post('subtotal')),
						  		'discount'=>deformat_value($this->input->post('discount')),
						  		'freight'=>deformat_value($this->input->post('freight')),
						  		'tax'=>deformat_value($this->input->post('tax')),
						  		'total'=>deformat_value($this->input->post('total')),
						  		'narration'=>$this->input->post('narration'),
						  	);
							  $products=$this->input->post('product');
							  $updateInsaleQuotationMaster=$this->sale_model->update('tbl_saleqoutationmaster',array('qoutationNo'=>$this->input->post('qoutationNo')),$saleQuotationMaster);
							  if($updateInsaleQuotationMaster){
							  		$product_selected = array();
								  	foreach($products as $values){
									  	$productsId=$values['id'];
									  	$values['rate']=deformat_value($values['rate']);
									  	if(isset($values['discount_amount'])){
									  	 	$values['discount_amount']=deformat_value($values['discount_amount']);
									  	}
									  	 $values['amount']=deformat_value($values['amount']);
									  	if(isset($values['id'])){
									  		array_push($product_selected, $productsId);
			                          	 $upodateInSaleQuotationDetail=$this->sale_model->update('tbl_saleqoutationdetails',array('QuotationNumber'=>$this->input->post('qoutationNo'),'id'=>$productsId),$values);
									  	}else if(isset($values['barcode']) && !empty($values['barcode'])){
									  		 $values['QuotationNumber']=$this->input->post('qoutationNo');
									  		 $values['company_id']=$this->session->userdata('company_id');
									  		 $savedInSaleQuotationDetail=$this->sale_model->add('tbl_saleqoutationdetails',$values);
									  		 array_push($product_selected, $savedInSaleQuotationDetail);
									  	}
		                          }
		                          if(!empty($product_selected)) {
		                          	$product_selected = implode(',', $product_selected);
		                          	$this->sale_model->delete('tbl_saleqoutationdetails', "id NOT IN (".$product_selected.") AND QuotationNumber = ".$this->input->post('qoutationNo')." AND company_id = ".$this->company_id);
		                          }
		                          if($this->input->post('save_print')) {
							  		$qoutationNo = $this->input->post('qoutationNo');
							   		if(isset($qoutationNo) && $qoutationNo > 0) {
							   			$this->session->set_flashdata('print_sale_quoatation', $qoutationNo);
							   			// $this->printQuotation($qoutationNo);
							   		}
							   	}
		                          if($upodateInSaleQuotationDetail){
		                          	$this->session->set_flashdata('success',con_lang('mass_sales_quotation_update_successfully'));
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
					}
				}else{
					redirect('auth');
				}
	}
	public function deleteQuotation($qoutationNo=null,$type=null){
		if($this->isLoggedIn()){
			if($type=='ng'){
			}else{
				$delete=$this->common_model->delete('tbl_saleqoutationmaster',array('qoutationNo'=>$qoutationNo));
				if($delete){
					$delete2=$this->common_model->delete('tbl_saleqoutationdetails',array('QuotationNumber'=>$qoutationNo));
					if($delete2){
						$result['message']=con_lang("mass_deleted_successfully");
						$result['response']=1;
					}
				}else{
					$result['message']=con_lang("mass_error_occurrs_try_later");
					$result['response']=0;
				}
				echo json_encode($result);exit();
			}
		}else{
			redirect('auth');
		}
	}
	public function saleOrder($type = null) {
		if($this->isLoggedIn()){
				if($type=='ng'){
				}else{
					$data['active']='Sales Orders';
					$data['module']='accounting';
					$data['allData']=$this->sale_model->getAll('tbl_saleordermaster',array('company_id'=>$this->session->userdata('company_id')), array('created_on', 'DESC'));
					$this->displayView('accounting/sales/sale_oreder_listing',$data,array(),array(
							'js'=>array(),
							'css'=>array(),
						));
				}
		}else{
			redirect('auth');
		}
	}
	public function addSaleOrder($saleOrderNo=null,$type = null) {
		if($this->isLoggedIn()){
				if($type=='ng'){
				}else{
					$data['active']='Sales Orders';
					$data['module']='accounting';
					 if($this->input->server('REQUEST_METHOD')==='POST'){
					 	$dateActiveYear=date('Y-m-d',strtotime($this->input->post('deliveryDate')));
					   	  $activeYear=$this->sale_model->getOne('tbl_financialyear',array('isActive'=>1,'company_id'=>$this->session->userdata('company_id')));
					   	  if(!empty($activeYear)){
					   	  if($dateActiveYear >= $activeYear->fromDate && $dateActiveYear <= $activeYear->toDate){
					 	$sale_quotation_no=$this->input->post('sale_quotation_no');
						  $saleQuotationMaster=array(
						  		'saleorderNo'=>$this->input->post('saleorderNo'),
						  		'company_id'=>$this->session->userdata('company_id'),
						  		'sale_quotation_no'=>$this->input->post('sale_quotation_no'),
						  		'customerId'=>$this->input->post('supplierId'),
						  		'salesmanId'=>$this->input->post('salesmanId'),
						  		'currencyId'=>$this->input->post('currencyId'),
						  		'saleOrderStatus'=>0,
						  		'deliveryDate'=>date('Y-m-d',strtotime($this->input->post('deliveryDate'))),
						  		'SaleOrderisApproved'=>1,
						  		'isPrintAfterSave'=>$this->input->post('isPrintAfterSave'),
						  		'subtotal'=>deformat_value($this->input->post('subtotal')),
						  		'percentDiscount'=>deformat_value($this->input->post('percentDiscount')),
						  		'freight'=>deformat_value($this->input->post('freight')),
						  		'tax'=>deformat_value($this->input->post('tax')),
						  		'total'=>deformat_value($this->input->post('total')),
						  		'narration'=>$this->input->post('narration'),
						  	);
						  $saleQuotationMaster['created_on'] =  date('Y-m-d H:i:s', strtotime($saleQuotationMaster['deliveryDate'].' '.date('H:i:s')));
						  $products=$this->input->post('product');
						  $savedInsaleQuotationMaster=$this->sale_model->add('tbl_saleordermaster',$saleQuotationMaster);
						  if($savedInsaleQuotationMaster > 0){
						  		$updateQuotationStatus=$this->sale_model->update('tbl_saleqoutationmaster',array('qoutationNo'=>$sale_quotation_no),array('status'=>1));
							  	foreach($products as $values){
							  		$values['rate']=deformat_value($values['rate']);
								  	 $values['amount']=deformat_value($values['amount']);
							  	 $values['saleOrderNo']=$this->input->post('saleorderNo');
							  	 $values['company_id']=$this->session->userdata('company_id');
	                          	 $savedInSaleQuotationDetail=$this->sale_model->add('tbl_saleorderdetails',$values);
	                          }
	                          if($this->input->post('save_print')) {
							  		$qoutationNo = $this->input->post('saleorderNo');
							   		if(isset($qoutationNo) && $qoutationNo > 0) {
							   			$this->session->set_flashdata('print_sale_order', $qoutationNo);
							   			// $this->printOrder($qoutationNo);
							   		}
							   	}
	                          if($savedInSaleQuotationDetail > 0){
	                          	$this->session->set_flashdata('success',con_lang('mass_sales_order_added_successfully'));
	                          	redirect($_SERVER['HTTP_REFERER']);
	                          }else{
	                          		$this->session->set_flashdata('error',con_lang('mass_error_occurrs_try_later'));
	                             	redirect($_SERVER['HTTP_REFERER']);
	                          }
						  }else{
						  	     $this->session->set_flashdata('error',con_lang('mass_error_occurrs_try_later'));
	                          	  redirect($_SERVER['HTTP_REFERER']);
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
					if($saleOrderNo!=null){
						$data['model']=(array)$this->sale_model->getByIdSaleOrder(decode_uri($saleOrderNo));
						$data['edit_sale'] = true;
					}
					if($saleOrderNo==null){
						$company_id=$this->session->userdata('company_id');
						$query="SELECT COUNT(id) AS TotalRecord FROM tbl_saleordermaster WHERE company_id =$company_id";
						$data['totalOrder']=$this->sale_model->universal($query)->row()->TotalRecord;
					}
					// $data['taxesOnBill']=$this->sale_model->getAll('tbl_accountledger',array('product_bill'=>'bill','company_id'=>$this->company_id, 'accountGroupId' => 20));
					$apply_tax = $this->common_model->getOne('tbl_apply_taxes', array('company_id' => $this->company_id, 'voucher_type' => 'sale'));
					if(isset($apply_tax->taxes) && $apply_tax->taxes != '') {
						$data['product_taxes'] = $this->sale_model->getAll('tbl_accountledger', "product_bill = 'product' AND company_id = ".$this->company_id." AND id IN (".$apply_tax->taxes.")");
						$data['taxesOnBill'] = $this->sale_model->getAll('tbl_accountledger', "product_bill = 'bill' AND company_id = ".$this->company_id." AND id IN (".$apply_tax->taxes.")");
					}
					$data['currency']=$this->sale_model->getCurrency();
					$this->displayView('accounting/sales/sale_order',$data,array(),array(
							'js'=>array(),
							'css'=>array(),
						));
				}
		}else{
			redirect('auth');
		}
	}
	public function editSaleOrder($qoutationNo=null,$type=null){
				if($this->isLoggedIn()){
					if($type!=null){
					}else{
						if($this->input->server('REQUEST_METHOD')==='POST'){
							 $saleOrderMaster=array(
						  		'customerId'=>$this->input->post('supplierId'),
						  		'salesmanId'=>$this->input->post('salesmanId'),
						  		'company_id'=>$this->session->userdata('company_id'),
						  		'currencyId'=>$this->input->post('currencyId'),
						  		'deliveryDate'=>date('Y-m-d',strtotime($this->input->post('deliveryDate'))),
						  		'SaleOrderisApproved'=>1,
						  		'isPrintAfterSave'=>$this->input->post('isPrintAfterSave'),
						  		'subtotal'=>deformat_value($this->input->post('subtotal')),
						  		'percentDiscount'=>deformat_value($this->input->post('percentDiscount')),
						  		'freight'=>deformat_value($this->input->post('freight')),
						  		'tax'=>deformat_value($this->input->post('tax')),
						  		'total'=>deformat_value($this->input->post('total')),
						  		'narration'=>$this->input->post('narration'),
						  	);
							  $products=$this->input->post('product');
							  $updateInsaleOrderMaster=$this->sale_model->update('tbl_saleordermaster',array('saleorderNo'=>$this->input->post('saleorderNo'), 'company_id' => $this->company_id),$saleOrderMaster);
							  if($updateInsaleOrderMaster){
							  		$product_selected = array();
								  	foreach($products as $values){
								  		$values['rate']=deformat_value($values['rate']);
								  		$values['amount']=deformat_value($values['amount']);
									  	$productsId=$values['id'];
									  	if(isset($values['id'])) {
										  	 array_push($product_selected, $productsId);
				                          	 $upodateInSaleOrderDetail=$this->sale_model->update('tbl_saleorderdetails',array('saleOrderNo'=>$this->input->post('saleorderNo'),'id'=>$productsId),$values);
									  	}else if(isset($values['barcode']) && !empty($values['barcode'])){
									  		 $values['saleOrderNo']=$this->input->post('saleorderNo');
									  		 $values['company_id']=$this->session->userdata('company_id');
									  		 $savedInSaleOrderDetail=$this->sale_model->add('tbl_saleorderdetails',$values);
									  		 array_push($product_selected, $savedInSaleOrderDetail);
									  	}
		                          }
		                          if(!empty($product_selected)) {
		                          	$product_selected = implode(',', $product_selected);
		                          	$this->sale_model->delete('tbl_saleorderdetails', "id NOT IN (".$product_selected.") AND saleOrderNo = ".$this->input->post('saleorderNo')." AND company_id = ".$this->company_id);
		                          }
		                          if($this->input->post('save_print')) {
							  		$qoutationNo = $this->input->post('saleorderNo');
							   		if(isset($qoutationNo) && $qoutationNo > 0) {
							   			$this->session->set_flashdata('print_sale_order', $qoutationNo);
							   			// $this->printOrder($qoutationNo);
							   		}
							   	}
		                          if($upodateInSaleOrderDetail){
		                          	$this->session->set_flashdata('success',con_lang('mass_sales_order_update_successfully'));
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
					}
				}else{
					redirect('auth');
				}
	}
	public function deleteOrder($saleorderNo=null,$type=null){
		if($this->isLoggedIn()){
			if($type=='ng'){
			}else{
				$delete=$this->common_model->delete('tbl_saleordermaster',array('saleorderNo'=>$saleorderNo));
				if($delete){
					$delete2=$this->common_model->delete('tbl_saleorderdetails',array('saleOrderNo'=>$saleorderNo));
					if($delete2){
						$result['message']=con_lang("mass_deleted_successfully");
						$result['response']=1;
					}
				}else{
					$result['message']=con_lang("mass_error_occurrs_try_later");
					$result['response']=0;
				}
				echo json_encode($result);exit();
			}
		}else{
			redirect('auth');
		}
	}
	public function saleInvoice($type = null) {
		if($this->isLoggedIn()){
				if($type=='ng'){
				}else{
					$data['active']='Sales Invoice';
					$data['module']='accounting';
					$data['allData']=$this->sale_model->getAll('tbl_salesinvoicemaster',array('company_id'=>$this->session->userdata('company_id'), 'is_deleted' => 0),array('created_on','desc'));
					$this->displayView('accounting/sales/sale_invoice_listing',$data,array(),array(
							'js'=>array(),
							'css'=>array(),
						));
				}
		}else{
			redirect('auth');
		}
	}
	public function getAvailableUnits() {
		if($this->input->post('product_id')) {
			$productId = $this->input->post('product_id');
			$this->load->model('sale_model');
			$company_id=$this->session->userdata('company_id');
			$result=$this->sale_model->getAll('tbl_uom', "id IN (SELECT UOMId FROM tbl_stockdetails WHERE company_id=$company_id AND product_id = $productId AND qty > 0) OR id IN (SELECT UOMId FROM tbl_purchasepricelist WHERE company_id = $company_id AND productName = $productId AND base_id IS NOT NULL AND base_id IN (SELECT UOMId FROM tbl_stockdetails WHERE company_id=$company_id AND product_id = $productId AND qty > 0))");
			echo '<option value="">Select Unit</option>';
			if(!empty($result)){
				foreach($result as $value){?>
				<option  value="<?php echo isset($value->id) ? $value->id :''; ?>">
					<?php  echo isset($value->UOMName) ? $value->UOMName :''; ?>
				</option> 
		<?php	} }
		}
	}
	public function addSaleInvoice($salesInvoiceNo=null,$type = null){
		error_reporting(0);
		if($this->isLoggedIn()){
				if($type=='ng'){
				}else{
					$data['active']='Sales Invoice';
					$data['module']='accounting';
					$data['is_invoice'] = true;
					 if($this->input->server('REQUEST_METHOD')==='POST'){
						 $dateActiveYear=date('Y-m-d',strtotime($this->input->post('deliveryDate')));
						 if($this->input->post('deliveryDate') == ''){
							 $dateActiveYear= date('Y-m-d');
						 }
						 // debug($this->input->post());
					   	  $activeYear=$this->sale_model->getOne('tbl_financialyear',array('isActive'=>1,'company_id'=>$this->session->userdata('company_id')));
					   	  if(!empty($activeYear)){
					   	  if($dateActiveYear >= $activeYear->fromDate && $dateActiveYear <= $activeYear->toDate){
					 	  $sale_order_no=$this->input->post('sale_order_no');
					 	$sale_invoice_number=$this->input->post('salesInvoiceNo');
					 	 if($salesInvoiceNo == null) {
						 	$company_id=$this->session->userdata('company_id');
							$query="SELECT COUNT(id) AS TotalRecord FROM tbl_salesinvoicemaster WHERE company_id =$company_id";
							$sale_invoice_number=(int)$this->sale_model->universal($query)->row()->TotalRecord;
							$sale_invoice_number = sprintf("%0".$this->voucher_number_length."d",$sale_invoice_number+1);
						} else {
							$sale = $this->sale_model->getByIdSaleInvoice(decode_uri($salesInvoiceNo));
							$sale_invoice_number = isset($sale->salesInvoiceNo) ? $sale->salesInvoiceNo : $sale_invoice_number;
						}
						  $saleInvoiceMaster=array(
						  		'salesInvoiceNo'=>$sale_invoice_number,
						  		'customerId'=>$this->input->post('supplierId'),
						  		'company_id'=>$this->company_id,
						  		'sale_order_no'=>$this->input->post('sale_order_no'),
						  		'salesmanId'=>$this->input->post('salesmanId'),
						  		'currencyId'=>$this->input->post('currencyId'),
						  		'deliveryDate'=>$dateActiveYear,
						  		'salesInvoiceIsPrintAfterSave'=>$this->input->post('salesInvoiceIsPrintAfterSave'),
						  		'subtotal'=>deformat_value($this->input->post('subtotal')),
						  		'discount'=>deformat_value($this->input->post('discount')),
						  		'freight'=>deformat_value($this->input->post('freight')),
						  		'tax'=>deformat_value($this->input->post('tax')),
						  		'total'=>deformat_value($this->input->post('total')),
						  		'narration'=>$this->input->post('narration'),
						  		'payment_receive' => deformat_value($this->input->post('payment_receive')),
						  		'indirect_expenses' => $this->input->post('ledgerId'),
						  		'payment_method' => $this->input->post('payment_method'),
						  		'created_by' => $this->session->userdata('id'),
							  	'created_on' => date('Y-m-d H:i:s')
							  );
						  $return_amount = 0;
						  if($saleInvoiceMaster['customerId'] == 1) {
						  	$saleInvoiceMaster['return_amount'] = (float)$saleInvoiceMaster['total'] - (float)$saleInvoiceMaster['payment_receive'];
						  	if($saleInvoiceMaster['return_amount'] < 0)
						  		$return_amount = $saleInvoiceMaster['return_amount'];
						  	$saleInvoiceMaster['payment_receive'] = $saleInvoiceMaster['total'];
						  }
						  $products=$this->input->post('product');
						  // debug($products);

						  if(!empty($products)) {
						  	foreach ($products as $product) {
						  		if(isset($product['UOMId']) && isset($product['product_id'])) {
						  			$stock = $this->common_model->getQtyByBase($product['product_id'], $product['UOMId']);
						  			$qty = (float)$product['qty'];
						  			if($qty > $stock) {
						  				$this->session->set_flashdata('error','You cannot sale more than available stock!');
	                             		redirect($_SERVER['HTTP_REFERER']);
						  			}
						  		}
						  	}
						  }
						  // debug($this->input->post());
						  if($this->input->post('add_payment')) {
						  	$this->add_payment($this->input->post('add_payment'), $saleInvoiceMaster['customerId'], $sale_invoice_number, $return_amount);
						  }
						  $savedInsaleInvoiceMaster=$this->sale_model->add('tbl_salesinvoicemaster',$saleInvoiceMaster);
	                      $this->set_barcode('SI-'.$sale_invoice_number);
						  if($savedInsaleInvoiceMaster > 0){
						  		$update=$this->sale_model->update('tbl_saleordermaster',array('saleorderNo'=>$sale_order_no),array('saleOrderStatus'=>1));
							  	foreach($products as $values){
						  		$values['rate']=deformat_value($values['rate']);
						  		if(isset($values['discount_amount'])){
						  			$values['discount_amount']=deformat_value($values['discount_amount']);
						  		}
						  		$values['amount']=deformat_value($values['amount']);
							  	 $values['salesInvoiceNo']=$sale_invoice_number;
							  	 $values['company_id']=$this->session->userdata('company_id');
							  	 $tax_amount = 0;
							  	 if(isset($values['tax_id']) && isset($values['rate']) && isset($values['qty'])) {
							  	 	$value_before_tax = (float)((float)deformat_value($values['qty'] * (float)$values['rate']));
							  	 	$tax_row = $this->sale_model->getById('tbl_accountledger', $values['tax_id']);
							  	 	if(isset($tax_row->tax_value)) {
								  	 	$tax_amount = (float)deformat_value($tax_row->tax_value);
		                          		if($tax_row->tax_symbal == '%') {
		                          			$tax_amount = (float)deformat_value(($tax_amount*(float)$value_before_tax)/100);
		                          		}
							  	 	}
							  	 }
							  	 $values['taxAmount'] = deformat_value($tax_amount);
							  	 $values['created_on'] = date('Y-m-d H:i:s');
	                          	 $savedInSaleInvoiceDetail=$this->sale_model->add('tbl_salesinvoicedetails',$values);
	                          	 if(isset($values['UOMId']) && $values['product_id']) {
									$update_where = array('UOMId' => $values['UOMId'], 'productName' => $values['product_id'], 'company_id' => $this->company_id);
	                          	 	$purchaseprice = $this->sale_model->getOne('tbl_purchasepricelist', $update_where);
	                          	 	if(isset($purchaseprice->base_id) && $purchaseprice->base_id) {
	                          	 		$derived_qty = (float)deformat_value($purchaseprice->base_qty * (float)$values['qty']);
	                          	 		$values['UOMId'] = $purchaseprice->base_id;
	                          	 		$values['qty'] = $derived_qty;
	                          	 	}
					            }
	                          	 $qtyy=$values['qty'];
	                          	 $productsId=$values['product_id'];
	                          	 $uomID=$values['UOMId'];
	                          	 $company_id=$this->session->userdata('company_id');
	                          	 $query="UPDATE tbl_stockdetails SET  qty=qty-$qtyy WHERE company_id=$company_id AND product_id=$productsId AND UOMId=$uomID ";
	                          	 $updateStock=$this->sale_model->universal($query);
	                          	 if(isset($values['qty']) && $values['qty'] > 0) {
	                          	 	$entry = array(
	                          	 		'product_id' => $values['product_id'],
	                          	 		'unit_id' => $values['UOMId'],
	                          	 		'voucher_type' => 'Sale Invoice',
	                          	 		'voucher_no' => 'SI-'.sprintf("%0".$this->voucher_number_length."d",$sale_invoice_number),
	                          	 		'credit' => $values['qty'],
	                          	 		'created_by' => $this->session->userdata('id'),
	                          	 		'company_id' => $this->company_id,
	                          	 		'created_on' => date('Y-m-d H:i:s')
	                          	 	);
	                          	 	$this->sale_model->add('tbl_stock_ledger_posting', $entry);
	                          	}
	                          }
	                          if($savedInSaleInvoiceDetail > 0){
	                          	$voucherNo='SI-'.sprintf("%0".$this->voucher_number_length."d",$sale_invoice_number);
	                          	$subtotal = (float)deformat_value($this->input->post('subtotal'));
	                          	$freight = (float)deformat_value($this->input->post('freight'));
	                          	$total_with_freight = deformat_value($subtotal + $freight);
	                          	$tax_id = (int)$this->input->post('tax');
	                          	$tax_row = $this->sale_model->getById('tbl_accountledger', $tax_id);
	                          	$tax_amount = 0;
	                          	if(isset($tax_row->tax_value)) {
	                          		$tax_amount = (float)deformat_value($tax_row->tax_value);
	                          		if($tax_row->tax_symbal == '%') {
	                          			$tax_amount = deformat_value(($tax_amount*$total_with_freight)/100);
	                          		}
	                          	}
	                          	$this->sale_model->update('tbl_salesinvoicemaster', array('salesInvoiceNo' => $sale_invoice_number, 'company_id' => $this->company_id), array('tax_amount' => $tax_amount));
	                          	$total_with_tax = deformat_value($total_with_freight + $tax_amount);
                          		$discount = (float)deformat_value($this->input->post('discount'));
                          		// $discount_type = $this->input->post('discount_type');
                          		// if($discount_type == '%') {
                          		// 	$discount = ($discount*$total_with_tax)/100;
                          		// }
                          		$discount=deformat_value($discount);
                          		$total_with_tax=deformat_value($total_with_tax);
                          		$total = $total_with_tax - $discount;
                          		$total=deformat_value($total);
	                          	if($discount > 0){
		                          	$ledgerpostingDiscount['voucherTypeId']=19;
		                          	$ledgerpostingDiscount['voucherNo']=$voucherNo;
		                          	$ledgerpostingDiscount['ledgerId']=9;
		                          	$ledgerpostingDiscount['debit']=$discount;
		                          	$ledgerpostingDiscount['yearId']=$this->getActiveYearId();
		                          	$ledgerpostingDiscount['invoiceNo']=$savedInsaleInvoiceMaster;
		                          	$ledgerpostingDiscount['date']=date("Y-m-d H:i:s");
		                          	$ledgerpostingDiscount['company_id']=$this->session->userdata('company_id');
		                          	$ledgerpostingDiscount=$this->sale_model->add('tbl_ledgerposting',$ledgerpostingDiscount);
		                          }
		                          if($this->input->post('supplierId') == 1){
		                          	$ledgerpostingSalesCredit['voucherTypeId']=19;
		                          	$ledgerpostingSalesCredit['voucherNo']=$voucherNo;
		                          	$ledgerpostingSalesCredit['ledgerId']=10;
		                          	$ledgerpostingSalesCredit['credit']=$total;
		                          	$ledgerpostingSalesCredit['yearId']=$this->getActiveYearId();
		                          	$ledgerpostingSalesCredit['invoiceNo']=$savedInsaleInvoiceMaster;
		                          	$ledgerpostingSalesCredit['date']=date("Y-m-d");
		                          	$ledgerpostingSalesCredit['company_id']=$this->session->userdata('company_id');
		                          	$ledgerpostingSalesCredit=$this->sale_model->add('tbl_ledgerposting',$ledgerpostingSalesCredit);
		                          	$ledgerpostingCashesDebit['voucherTypeId']=19;
		                          	$ledgerpostingCashesDebit['voucherNo']=$voucherNo;
		                          	$ledgerpostingCashesDebit['ledgerId']=$this->input->post('supplierId');
		                          	$ledgerpostingCashesDebit['debit']=$total;
		                          	$ledgerpostingCashesDebit['yearId']=$this->getActiveYearId();
		                          	$ledgerpostingCashesDebit['invoiceNo']=$savedInsaleInvoiceMaster;
		                          	$ledgerpostingCashesDebit['date']=date("Y-m-d H:i:s");
		                          	$ledgerpostingCashesDebit['company_id']=$this->session->userdata('company_id');
		                          	$ledgerpostingCashesDebit=$this->sale_model->add('tbl_ledgerposting',$ledgerpostingCashesDebit);
		                          } else {
		                          	if(deformat_value($this->input->post('payment_receive')) == 0){
		                          		$ledgerpostingCustomerDebit['voucherTypeId']=19;
			                          	$ledgerpostingCustomerDebit['voucherNo']=$voucherNo;
			                          	$ledgerpostingCustomerDebit['ledgerId']=$this->input->post('supplierId');
			                          	$ledgerpostingCustomerDebit['debit']=$total;
			                          	$ledgerpostingCustomerDebit['yearId']=$this->getActiveYearId();
			                          	$ledgerpostingCustomerDebit['invoiceNo']=$savedInsaleInvoiceMaster;
			                          	$ledgerpostingCustomerDebit['date']=date("Y-m-d H:i:s");
			                          	$ledgerpostingCustomerDebit['company_id']=$this->session->userdata('company_id');
			                          	$ledgerpostingtotal=$this->sale_model->add('tbl_ledgerposting',$ledgerpostingCustomerDebit);
			                          	$ledgerpostingSaleCredit['voucherTypeId']=19;
			                          	$ledgerpostingSaleCredit['voucherNo']=$voucherNo;
			                          	$ledgerpostingSaleCredit['ledgerId']=10;
			                          	$ledgerpostingSaleCredit['credit']=$total;
			                          	$ledgerpostingSaleCredit['yearId']=$this->getActiveYearId();
			                          	$ledgerpostingSaleCredit['invoiceNo']=$savedInsaleInvoiceMaster;
			                          	$ledgerpostingSaleCredit['date']=date("Y-m-d H:i:s");
			                          	$ledgerpostingSaleCredit['company_id']=$this->session->userdata('company_id');
			                          	$ledgerpostingSaleCredit=$this->sale_model->add('tbl_ledgerposting',$ledgerpostingSaleCredit);
		                          	}else if(deformat_value($this->input->post('payment_receive')) > 0 &&  $total > deformat_value($this->input->post('payment_receive')) ){
		                          		$ledgerpostingCustomerDebits['voucherTypeId']=19;
			                          	$ledgerpostingCustomerDebits['voucherNo']=$voucherNo;
			                          	$ledgerpostingCustomerDebits['ledgerId']=$this->input->post('supplierId');
			                          	$ledgerpostingCustomerDebits['debit']=$total;
			                          	$ledgerpostingCustomerDebits['yearId']=$this->getActiveYearId();
			                          	$ledgerpostingCustomerDebits['invoiceNo']=$savedInsaleInvoiceMaster;
			                          	$ledgerpostingCustomerDebits['date']=date("Y-m-d H:i:s");
			                          	$ledgerpostingCustomerDebits['company_id']=$this->session->userdata('company_id');
			                          	$ledgerpostingtotal=$this->sale_model->add('tbl_ledgerposting',$ledgerpostingCustomerDebits);
			                          	$ledgerpostingSaleCredits['voucherTypeId']=19;
			                          	$ledgerpostingSaleCredits['voucherNo']=$voucherNo;
			                          	$ledgerpostingSaleCredits['ledgerId']=10;
			                          	$ledgerpostingSaleCredits['credit']=$total;
			                          	$ledgerpostingSaleCredits['yearId']=$this->getActiveYearId();
			                          	$ledgerpostingSaleCredits['invoiceNo']=$savedInsaleInvoiceMaster;
			                          	$ledgerpostingSaleCredits['date']=date("Y-m-d H:i:s");
			                          	$ledgerpostingSaleCredits['company_id']=$this->session->userdata('company_id');
			                          	$ledgerpostingSaleCredits=$this->sale_model->add('tbl_ledgerposting',$ledgerpostingSaleCredits);
			                          	$ledgerpostingCashDebit['voucherTypeId']=19;
			                          	$ledgerpostingCashDebit['voucherNo']=$voucherNo;
			                          	$ledgerpostingCashDebit['ledgerId']=1;
			                          	$ledgerpostingCashDebit['debit']=deformat_value($this->input->post('payment_receive'));
			                          	$ledgerpostingCashDebit['yearId']=$this->getActiveYearId();
			                          	$ledgerpostingCashDebit['invoiceNo']=$savedInsaleInvoiceMaster;
			                          	$ledgerpostingCashDebit['date']=date("Y-m-d H:i:s");
			                          	$ledgerpostingCashDebit['company_id']=$this->session->userdata('company_id');
			                          	$ledgerpostingtotal=$this->sale_model->add('tbl_ledgerposting',$ledgerpostingCashDebit);
			                          	$ledgerpostingCustomerCredit['voucherTypeId']=19;
			                          	$ledgerpostingCustomerCredit['voucherNo']=$voucherNo;
			                          	$ledgerpostingCustomerCredit['ledgerId']=$this->input->post('supplierId');
			                          	$ledgerpostingCustomerCredit['credit']=deformat_value($this->input->post('payment_receive'));
			                          	$ledgerpostingCustomerCredit['yearId']=$this->getActiveYearId();
			                          	$ledgerpostingCustomerCredit['invoiceNo']=$savedInsaleInvoiceMaster;
			                          	$ledgerpostingCustomerCredit['date']=date("Y-m-d H:i:s");
			                          	$ledgerpostingCustomerCredit['company_id']=$this->session->userdata('company_id');
			                          	$ledgerpostingtotal=$this->sale_model->add('tbl_ledgerposting',$ledgerpostingCustomerCredit);
		                          	}else if($total == deformat_value($this->input->post('payment_receive'))){
		                          		$ledgerpostingCustomerDebits['voucherTypeId']=19;
			                          	$ledgerpostingCustomerDebits['voucherNo']=$voucherNo;
			                          	$ledgerpostingCustomerDebits['ledgerId']=$this->input->post('supplierId');
			                          	$ledgerpostingCustomerDebits['debit']=$total;
			                          	$ledgerpostingCustomerDebits['yearId']=$this->getActiveYearId();
			                          	$ledgerpostingCustomerDebits['invoiceNo']=$savedInsaleInvoiceMaster;
			                          	$ledgerpostingCustomerDebits['date']=date("Y-m-d H:i:s");
			                          	$ledgerpostingCustomerDebits['company_id']=$this->session->userdata('company_id');
			                          	$ledgerpostingtotal=$this->sale_model->add('tbl_ledgerposting',$ledgerpostingCustomerDebits);
			                          	$ledgerpostingSaleCreditss['voucherTypeId']=19;
			                          	$ledgerpostingSaleCreditss['voucherNo']=$voucherNo;
			                          	$ledgerpostingSaleCreditss['ledgerId']=10;
			                          	$ledgerpostingSaleCreditss['credit']=$total;
			                          	$ledgerpostingSaleCreditss['yearId']=$this->getActiveYearId();
			                          	$ledgerpostingSaleCreditss['invoiceNo']=$savedInsaleInvoiceMaster;
			                          	$ledgerpostingSaleCreditss['date']=date("Y-m-d H:i:s");
			                          	$ledgerpostingSaleCreditss['company_id']=$this->session->userdata('company_id');
			                          	$ledgerpostingSaleCreditss=$this->sale_model->add('tbl_ledgerposting',$ledgerpostingSaleCreditss);
			                          	$ledgerpostingCashDebits['voucherTypeId']=19;
			                          	$ledgerpostingCashDebits['voucherNo']=$voucherNo;
			                          	$ledgerpostingCashDebits['ledgerId']=1;
			                          	$ledgerpostingCashDebits['debit']=deformat_value($this->input->post('payment_receive'));
			                          	$ledgerpostingCashDebits['yearId']=$this->getActiveYearId();
			                          	$ledgerpostingCashDebits['invoiceNo']=$savedInsaleInvoiceMaster;
			                          	$ledgerpostingCashDebits['date']=date("Y-m-d H:i:s");
			                          	$ledgerpostingCashDebits['company_id']=$this->session->userdata('company_id');
			                          	$ledgerpostingtotal=$this->sale_model->add('tbl_ledgerposting',$ledgerpostingCashDebits);
			                          	// $ledgerpostingCustomersCash['voucherTypeId']=19;
			                          	// $ledgerpostingCustomersCash['voucherNo']=$voucherNo;
			                          	// $ledgerpostingCustomersCash['ledgerId']=$this->input->post('supplierId');
			                          	// $ledgerpostingCustomersCash['credit']=$this->input->post('payment_receive');
			                          	// $ledgerpostingCustomersCash['yearId']=$this->getActiveYearId();
			                          	// $ledgerpostingCustomersCash['invoiceNo']=$savedInsaleInvoiceMaster;
			                          	// $ledgerpostingCustomersCash['date']=date("Y-m-d");
			                          	// $ledgerpostingCustomersCash['company_id']=$this->session->userdata('company_id');
			                          	// $ledgerpostingtotal=$this->sale_model->add('tbl_ledgerposting',$ledgerpostingCustomersCash);
		                          	}
		                          }
	                          	if($this->input->post('ledgerId') > 0):
	                          	$ledgerpostingFreight['yearId']=$this->getActiveYearId();
	                          	$ledgerpostingFreight['voucherTypeId']=19;
	                          	$ledgerpostingFreight['voucherNo']=$voucherNo;
	                          	$ledgerpostingFreight['ledgerId']=$this->input->post('ledgerId');
	                          	$ledgerpostingFreight['date']=date("Y-m-d H:i:s");
	                          	$ledgerpostingFreight['company_id']=$this->session->userdata('company_id');
	                          	$ledgerpostingFreight['credit']=deformat_value($freight);
	                          	$ledgerpostingFreight['invoiceNo']=$savedInsaleInvoiceMaster;
	                          	$ledgerpostingFreight=$this->sale_model->add('tbl_ledgerposting',$ledgerpostingFreight);
	                          	endif;
	                          	if($tax_amount > 0):
	                          	$ledgerpostingTax['yearId']=$this->getActiveYearId();
	                          	$ledgerpostingTax['voucherTypeId']=19;
	                          	$ledgerpostingTax['voucherNo']=$voucherNo;
	                          	$ledgerpostingTax['ledgerId']=$this->input->post('tax');
	                          	$ledgerpostingTax['date']=date("Y-m-d H:i:s");
	                          	$ledgerpostingTax['company_id']=$this->session->userdata('company_id');
	                          	$ledgerpostingTax['credit']= $tax_amount;
	                          	$ledgerpostingTax['invoiceNo']=$savedInsaleInvoiceMaster;
	                          	$saved=$this->sale_model->add('tbl_ledgerposting',$ledgerpostingTax);
	                          	endif;
	                          	 if($this->input->post('print')) {
							  		$qoutationNo = $sale_invoice_number;
							   		if(isset($qoutationNo) && $qoutationNo > 0) {
							   			$this->session->set_flashdata('print_sale_invoice', $qoutationNo);
							   			// $this->printInvoice($qoutationNo);
							   		}
							   	} else if($this->input->post('complete_sale')) {
							  		$qoutationNo = $sale_invoice_number;
							   		if(isset($qoutationNo) && $qoutationNo > 0) {
							   			$this->session->set_flashdata('print_sale_invoice', $qoutationNo);
							   			// redirect('accounting/sales/printFullInvoice/'.$qoutationNo);
							   		}
							   	}
		                          		$this->session->set_flashdata('success',con_lang('mass_sales_invoice_added_successfully'));
		                          	   redirect($_SERVER['HTTP_REFERER']);
		                          
	                          }else{
	                          		$this->session->set_flashdata('error',con_lang('mass_error_occurrs_try_later'));
	                             	redirect($_SERVER['HTTP_REFERER']);
	                          }
						  }else{
						  	     $this->session->set_flashdata('error',con_lang('mass_error_occurrs_try_later'));
	                          	  redirect($_SERVER['HTTP_REFERER']);
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
					if($salesInvoiceNo!=null){
						$data['model']=(array)$this->sale_model->getByIdSaleInvoice(decode_uri($salesInvoiceNo));
						$data['edit_sale'] = true;
						// print_r($data['model']);die(); 
					}
					if($salesInvoiceNo==null){
						$company_id=$this->session->userdata('company_id');
						$query="SELECT COUNT(id) AS TotalRecord FROM tbl_salesinvoicemaster WHERE company_id =$company_id";
						$data['totalInvoice']=$this->sale_model->universal($query)->row()->TotalRecord;
					}
					// $data['taxesOnBill']=$this->sale_model->getAll('tbl_accountledger',array('product_bill'=>'bill','company_id'=>$this->company_id, 'accountGroupId' => 20));
					$data['currency']=$this->sale_model->getCurrency();
					$apply_tax = $this->common_model->getOne('tbl_apply_taxes', array('company_id' => $this->company_id, 'voucher_type' => 'sale'));
					if(isset($apply_tax->taxes) && $apply_tax->taxes != '') {
						$data['product_taxes'] = $this->sale_model->getAll('tbl_accountledger', "product_bill = 'product' AND company_id = ".$this->company_id." AND id IN (".$apply_tax->taxes.")");
						$data['taxesOnBill'] = $this->sale_model->getAll('tbl_accountledger', "product_bill = 'bill' AND company_id = ".$this->company_id." AND id IN (".$apply_tax->taxes.")");
					}
					$this->displayView('accounting/sales/sale_invoice',$data,array(),array(
							'js'=>array(),
							'css'=>array(),
						));
				}
		}else{
			redirect('auth');
		}
	}
	public function editSaleInvoice($qoutationNo=null,$type=null){
		if($this->isLoggedIn()){
			if($type!=null){
			}else{
				if($this->input->server('REQUEST_METHOD')==='POST'){

					$saleInvoiceMaster=array(
					  		'customerId'=>$this->input->post('supplierId'),
					  		'salesmanId'=>$this->input->post('salesmanId'),
					  		'currencyId'=>$this->input->post('currencyId'),
					  		'company_id'=>$this->session->userdata('company_id'),
					  		'deliveryDate'=>date('Y-m-d',strtotime($this->input->post('deliveryDate'))),
					  		'salesInvoiceIsPrintAfterSave'=>$this->input->post('salesInvoiceIsPrintAfterSave'),
					  		'subtotal'=>deformat_value($this->input->post('subtotal')),
					  		'discount'=>deformat_value($this->input->post('discount')),
					  		'freight'=>deformat_value($this->input->post('freight')),
					  		'tax'=>deformat_value($this->input->post('tax')),
					  		'total'=>deformat_value($this->input->post('total')),
					  		'narration'=>$this->input->post('narration'),
						  	'payment_receive' => deformat_value($this->input->post('payment_receive')),
							'indirect_expenses' => $this->input->post('ledgerId'),
							'payment_method' => $this->input->post('payment_method'),
					  	);
					
						  $return_amount = 0;
						  if($saleInvoiceMaster['customerId'] == 1) {
						  	$saleInvoiceMaster['return_amount'] = (float)$saleInvoiceMaster['total'] - (float)$saleInvoiceMaster['payment_receive'];
						  	if($saleInvoiceMaster['return_amount'] < 0)
						  		$return_amount = $saleInvoiceMaster['return_amount'];
						  	$saleInvoiceMaster['payment_receive'] = $saleInvoiceMaster['total'];
						  }
						if($this->input->post('add_payment')) {
						  	$this->add_payment($this->input->post('add_payment'), $saleInvoiceMaster['customerId'], $this->input->post('salesInvoiceNo'), $return_amount);
						}
					  $products=$this->input->post('product');
					  $updateInsaleInvoiceMaster=$this->sale_model->update('tbl_salesinvoicemaster',array('salesInvoiceNo'=>$this->input->post('salesInvoiceNo'), 'company_id' => $this->company_id),$saleInvoiceMaster);
					  if($updateInsaleInvoiceMaster){
					  		$product_selected = array();
						  	foreach($products as $values) {
						  		if(isset($values['rate']))
						  			$values['rate']=deformat_value($values['rate']);
						  		if(isset($values['discount_amount'])){
						  			$values['discount_amount']=deformat_value($values['discount_amount']);
						  		}
						  		$values['amount']=deformat_value($values['amount']);
							  	$productsId=isset($values['id']) ? $values['id'] : null;
							  	$qtyy=$values['qty'];
	                          	 $product_id=$values['product_id'];
	                          	 $uomID=$values['UOMId'];
	                          	 $company_id=$this->session->userdata('company_id');
							  	if(isset($productsId) && $productsId != null){
							  		array_push($product_selected, $productsId);
							  		$old_record = $this->sale_model->getById('tbl_salesinvoicedetails', $productsId);
							  		if(isset($old_record->qty)) {
							  			$qtyy = $old_record->qty - $qtyy;
							  			if(isset($values['UOMId']) && $values['product_id']) {
											$update_where = array('UOMId' => $values['UOMId'], 'productName' => $values['product_id'], 'company_id' => $this->company_id);
			                          	 	$purchaseprice = $this->sale_model->getOne('tbl_purchasepricelist', $update_where);
			                          	 	if(isset($purchaseprice->base_id) && $purchaseprice->base_id) {
			                          	 		$derived_qty = (float)$purchaseprice->base_qty * (float)$qtyy;
			                          	 		$uomID = $purchaseprice->base_id;
			                          	 		$qtyy = $derived_qty;
			                          	 	}
							            }
							  			$query="UPDATE tbl_stockdetails SET  qty=qty+$qtyy WHERE company_id=$company_id AND product_id=$product_id AND UOMId=$uomID ";
		                          	 	$updateStock=$this->sale_model->universal($query);
							  		}
	                          	 	$upodateInSaleOrderDetail=$this->sale_model->update('tbl_salesinvoicedetails',array('salesInvoiceNo'=>$this->input->post('salesInvoiceNo'),'id'=>$productsId),$values);
	                          	 
							  	}else if(isset($values['barcode']) && !empty($values['barcode'])){
							  		 $values['salesInvoiceNo']=$this->input->post('salesInvoiceNo');
							  		 $values['company_id']=$this->session->userdata('company_id');
							  		 $values['created_on'] = date('Y-m-d H:i:s');
							  		 $savedInSaleOrderDetail=$this->sale_model->add('tbl_salesinvoicedetails',$values);
							  		 array_push($product_selected, $savedInSaleOrderDetail);
							  		 if(isset($values['UOMId']) && $values['product_id']) {
										$update_where = array('UOMId' => $values['UOMId'], 'productName' => $values['product_id'], 'company_id' => $this->company_id);
		                          	 	$purchaseprice = $this->sale_model->getOne('tbl_purchasepricelist', $update_where);
		                          	 	if(isset($purchaseprice->base_id) && $purchaseprice->base_id) {
		                          	 		$derived_qty = (float)$purchaseprice->base_qty * (float)$qtyy;
		                          	 		$uomID = $purchaseprice->base_id;
		                          	 		$qtyy = $derived_qty;
		                          	 	}
						            }
		                          	 $query="UPDATE tbl_stockdetails SET  qty=qty-$qtyy WHERE company_id=$company_id AND product_id=$product_id AND UOMId=$uomID ";
		                          	 $updateStock=$this->sale_model->universal($query);
							  	}
							  	$values['qty'] = $qtyy;
							  	$values['UOMId'] = $uomID;
							  	if(isset($values['qty']) && $values['qty'] > 0) {
							  		$voucherNo='SI-'.sprintf("%0".$this->voucher_number_length."d",$this->input->post('salesInvoiceNo'));
							  		$existing = $this->sale_model->getOne('tbl_stock_ledger_posting', array('company_id' => $this->company_id, 'voucher_no' => $voucherNo, 'product_id' => $values['product_id'], 'unit_id' => $values['UOMId']));
							  		if(isset($existing->id)) {
							  			$this->sale_model->update('tbl_stock_ledger_posting', array('id' => $existing->id), array('credit' => $values['qty']));
							  		} else {
		                          	 	$entry = array(
		                          	 		'product_id' => $values['product_id'],
		                          	 		'unit_id' => $values['UOMId'],
		                          	 		'voucher_type' => 'Sale Invoice',
		                          	 		'voucher_no' => $voucherNo,
		                          	 		'credit' => $qtyy,
		                          	 		'created_by' => $this->session->userdata('id'),
		                          	 		'company_id' => $this->company_id,
		                          	 		'created_on' => date('Y-m-d H:i:s')
		                          	 	);
		                          	 	$this->sale_model->add('tbl_stock_ledger_posting', $entry);
	                          	 	}
	                          	}
                          }
                          if(!empty($product_selected)) {
                          	$product_selected = implode(',', $product_selected);
                          	$this->sale_model->delete('tbl_salesinvoicedetails', "id NOT IN (".$product_selected.") AND salesInvoiceNo = ".$this->input->post('salesInvoiceNo')." AND company_id = ".$this->company_id);
                          }
                          $invoice = $this->sale_model->getOne('tbl_salesinvoicemaster', array('salesInvoiceNo' => $this->input->post('salesInvoiceNo'), 'company_id' => $this->company_id));
                          
                          if(isset($invoice->id)) {
                          	if($this->sale_model->delete('tbl_ledgerposting', array('invoiceNo' => $invoice->id))) {
                          		$voucherNo='SI-'.sprintf("%0".$this->voucher_number_length."d",$this->input->post('salesInvoiceNo'));
                          		$subtotal = (float)deformat_value($this->input->post('subtotal'));
	                          	$freight = (float)deformat_value($this->input->post('freight'));
	                          	$total_with_freight = $subtotal + $freight;
	                          	$tax_id = (int)$this->input->post('tax');
	                          	$tax_row = $this->sale_model->getById('tbl_accountledger', $tax_id);
	                          	$tax_amount = 0;
	                          	if(isset($tax_row->tax_value)) {
	                          		$tax_amount = (float)deformat_value($tax_row->tax_value);
	                          		if($tax_row->tax_symbal == '%') {
	                          			$tax_amount = deformat_value(($tax_amount*$total_with_freight)/100);
	                          		}
	                          	}
	                          	$this->sale_model->update('tbl_salesinvoicemaster', array('salesInvoiceNo' => $this->input->post('salesInvoiceNo'), 'company_id' => $this->company_id), array('tax_amount' => $tax_amount));
	                          	$total_with_tax = $total_with_freight + $tax_amount;
                          		$discount = (float)deformat_value($this->input->post('discount'));
                          		// $discount_type = $this->input->post('discount_type');
                          		// if($discount_type == '%') {
                          		// 	$discount = ($discount*$total_with_tax)/100;
                          		// }
                          		$total = $total_with_tax - $discount;
	                          	if($discount > 0){
	                          		$entry = $this->sale_model->getOne('tbl_ledgerposting', array('ledgerId' => 9, 'voucherNo' => $voucherNo, 'company_id' => $this->company_id));
	                          		if(isset($entry->id)) {
			                          	$ledgerpostingDiscount['debit']=deformat_value($discount);
			                          	$ledgerpostingDiscount=$this->sale_model->update('tbl_ledgerposting', array('id' => $entry->id),$ledgerpostingDiscount);
	                          		} else {
			                          	$ledgerpostingDiscount['voucherTypeId']=19;
			                          	$ledgerpostingDiscount['voucherNo']=$voucherNo;
			                          	$ledgerpostingDiscount['ledgerId']=9;
			                          	$ledgerpostingDiscount['debit']=$discount;
			                          	$ledgerpostingDiscount['yearId']=$this->getActiveYearId();
			                          	$ledgerpostingDiscount['invoiceNo']=$invoice->id;
			                          	$ledgerpostingDiscount['date']=date("Y-m-d H:i:s");
			                          	$ledgerpostingDiscount['company_id']=$this->session->userdata('company_id');
			                          	$ledgerpostingDiscount=$this->sale_model->add('tbl_ledgerposting',$ledgerpostingDiscount);
			                        }
		                          }
		                          if($this->input->post('supplierId') == 1){
		                          	$entry = $this->sale_model->getOne('tbl_ledgerposting', array('ledgerId' => 10, 'voucherNo' => $voucherNo, 'company_id' => $this->company_id));
	                          		if(isset($entry->id)) {
			                          	$ledgerpostingSalesCredit['credit']=$total;
			                          	$ledgerpostingSalesCredit=$this->sale_model->update('tbl_ledgerposting', array('id' => $entry->id),$ledgerpostingSalesCredit);
	                          		} else {
			                          	$ledgerpostingSalesCredit['voucherTypeId']=19;
			                          	$ledgerpostingSalesCredit['voucherNo']=$voucherNo;
			                          	$ledgerpostingSalesCredit['ledgerId']=10;
			                          	$ledgerpostingSalesCredit['credit']=deformat_value($total);
			                          	$ledgerpostingSalesCredit['yearId']=$this->getActiveYearId();
			                          	$ledgerpostingSalesCredit['invoiceNo']=$invoice->id;
			                          	$ledgerpostingSalesCredit['date']=date("Y-m-d H:i:s");
			                          	$ledgerpostingSalesCredit['company_id']=$this->session->userdata('company_id');
			                          	$ledgerpostingSalesCredit=$this->sale_model->add('tbl_ledgerposting',$ledgerpostingSalesCredit);
			                        }
			                        $entry = $this->sale_model->getOne('tbl_ledgerposting', array('ledgerId' => $this->input->post('supplierId'), 'voucherNo' => $voucherNo, 'company_id' => $this->company_id));
	                          		if(isset($entry->id)) {
			                          	$ledgerpostingCashesDebit['debit']=deformat_value($total);
			                          	$ledgerpostingCashesDebit=$this->sale_model->update('tbl_ledgerposting', array('id' => $entry->id),$ledgerpostingCashesDebit);
	                          		} else {
			                          	$ledgerpostingCashesDebit['voucherTypeId']=19;
			                          	$ledgerpostingCashesDebit['voucherNo']=$voucherNo;
			                          	$ledgerpostingCashesDebit['ledgerId']=$this->input->post('supplierId');
			                          	$ledgerpostingCashesDebit['debit']=deformat_value($total);
			                          	$ledgerpostingCashesDebit['yearId']=$this->getActiveYearId();
			                          	$ledgerpostingCashesDebit['invoiceNo']=$invoice->id;
			                          	$ledgerpostingCashesDebit['date']=date("Y-m-d H:i:s");
			                          	$ledgerpostingCashesDebit['company_id']=$this->session->userdata('company_id');
			                          	$ledgerpostingCashesDebit=$this->sale_model->add('tbl_ledgerposting',$ledgerpostingCashesDebit);
			                        }
		                          } else {
		                          	if(deformat_value($this->input->post('payment_receive')) == 0){
		                          		$entry = $this->sale_model->getOne('tbl_ledgerposting', array('ledgerId' => $this->input->post('supplierId'), 'voucherNo' => $voucherNo, 'company_id' => $this->company_id));
		                          		if(isset($entry->id)) {
				                          	$ledgerpostingCustomerDebit['debit']=deformat_value($total);
				                          	$ledgerpostingCustomerDebit=$this->sale_model->update('tbl_ledgerposting', array('id' => $entry->id),$ledgerpostingCustomerDebit);
		                          		} else {
			                          		$ledgerpostingCustomerDebit['voucherTypeId']=19;
				                          	$ledgerpostingCustomerDebit['voucherNo']=$voucherNo;
				                          	$ledgerpostingCustomerDebit['ledgerId']=$this->input->post('supplierId');
				                          	$ledgerpostingCustomerDebit['debit']=deformat_value($total);
				                          	$ledgerpostingCustomerDebit['yearId']=$this->getActiveYearId();
				                          	$ledgerpostingCustomerDebit['invoiceNo']=$invoice->id;
				                          	$ledgerpostingCustomerDebit['date']=date("Y-m-d H:i:s");
				                          	$ledgerpostingCustomerDebit['company_id']=$this->session->userdata('company_id');
				                          	$ledgerpostingtotal=$this->sale_model->add('tbl_ledgerposting',$ledgerpostingCustomerDebit);
			                            }
			                            $entry = $this->sale_model->getOne('tbl_ledgerposting', array('ledgerId' => 10, 'voucherNo' => $voucherNo, 'company_id' => $this->company_id));
		                          		if(isset($entry->id)) {
				                          	$ledgerpostingSaleCredit['credit']=deformat_value($total);
				                          	$ledgerpostingSaleCredit=$this->sale_model->update('tbl_ledgerposting', array('id' => $entry->id),$ledgerpostingSaleCredit);
		                          		} else {
				                          	$ledgerpostingSaleCredit['voucherTypeId']=19;
				                          	$ledgerpostingSaleCredit['voucherNo']=$voucherNo;
				                          	$ledgerpostingSaleCredit['ledgerId']=10;
				                          	$ledgerpostingSaleCredit['credit']=deformat_value($total);
				                          	$ledgerpostingSaleCredit['yearId']=$this->getActiveYearId();
				                          	$ledgerpostingSaleCredit['invoiceNo']=$invoice->id;
				                          	$ledgerpostingSaleCredit['date']=date("Y-m-d H:i:s");
				                          	$ledgerpostingSaleCredit['company_id']=$this->session->userdata('company_id');
				                          	$ledgerpostingSaleCredit=$this->sale_model->add('tbl_ledgerposting',$ledgerpostingSaleCredit);
				                        }
		                          	}else if(deformat_value($this->input->post('payment_receive')) > 0 &&  deformat_value($total) > deformat_value($this->input->post('payment_receive')) ){
		                          		$entry = $this->sale_model->getOne('tbl_ledgerposting', array('ledgerId' => $this->input->post('supplierId'), 'voucherNo' => $voucherNo, 'company_id' => $this->company_id));
		                          		if(isset($entry->id)) {
				                          	$ledgerpostingCustomerDebits['debit']=deformat_value($total);
				                          	$ledgerpostingCustomerDebits=$this->sale_model->update('tbl_ledgerposting', array('id' => $entry->id),$ledgerpostingCustomerDebits);
		                          		} else {
			                          		$ledgerpostingCustomerDebits['voucherTypeId']=19;
				                          	$ledgerpostingCustomerDebits['voucherNo']=$voucherNo;
				                          	$ledgerpostingCustomerDebits['ledgerId']=$this->input->post('supplierId');
				                          	$ledgerpostingCustomerDebits['debit']=deformat_value($total);
				                          	$ledgerpostingCustomerDebits['yearId']=$this->getActiveYearId();
				                          	$ledgerpostingCustomerDebits['invoiceNo']=$invoice->id;
				                          	$ledgerpostingCustomerDebits['date']=date("Y-m-d H:i:s");
				                          	$ledgerpostingCustomerDebits['company_id']=$this->session->userdata('company_id');
				                          	$ledgerpostingtotal=$this->sale_model->add('tbl_ledgerposting',$ledgerpostingCustomerDebits);
				                        }
				                        $entry = $this->sale_model->getOne('tbl_ledgerposting', array('ledgerId' => 10, 'voucherNo' => $voucherNo, 'company_id' => $this->company_id));
		                          		if(isset($entry->id)) {
				                          	$ledgerpostingSaleCredits['credit']=deformat_value($total);
				                          	$ledgerpostingSaleCredits=$this->sale_model->update('tbl_ledgerposting', array('id' => $entry->id),$ledgerpostingSaleCredits);
		                          		} else {
				                          	$ledgerpostingSaleCredits['voucherTypeId']=19;
				                          	$ledgerpostingSaleCredits['voucherNo']=$voucherNo;
				                          	$ledgerpostingSaleCredits['ledgerId']=10;
				                          	$ledgerpostingSaleCredits['credit']=deformat_value($total);
				                          	$ledgerpostingSaleCredits['yearId']=$this->getActiveYearId();
				                          	$ledgerpostingSaleCredits['invoiceNo']=$invoice->id;
				                          	$ledgerpostingSaleCredits['date']=date("Y-m-d H:i:s");
				                          	$ledgerpostingSaleCredits['company_id']=$this->session->userdata('company_id');
				                          	$ledgerpostingSaleCredits=$this->sale_model->add('tbl_ledgerposting',$ledgerpostingSaleCredits);
				                        }
				                        $entry = $this->sale_model->getOne('tbl_ledgerposting', array('ledgerId' => 1, 'voucherNo' => $voucherNo, 'company_id' => $this->company_id));
		                          		if(isset($entry->id)) {
				                          	$ledgerpostingCashDebit['debit']=$this->input->post('payment_receive');
				                          	$ledgerpostingCashDebit=$this->sale_model->update('tbl_ledgerposting', array('id' => $entry->id),$ledgerpostingCashDebit);
		                          		} else {
				                          	$ledgerpostingCashDebit['voucherTypeId']=19;
				                          	$ledgerpostingCashDebit['voucherNo']=$voucherNo;
				                          	$ledgerpostingCashDebit['ledgerId']=1;
				                          	$ledgerpostingCashDebit['debit']=deformat_value($this->input->post('payment_receive'));
				                          	$ledgerpostingCashDebit['yearId']=$this->getActiveYearId();
				                          	$ledgerpostingCashDebit['invoiceNo']=$invoice->id;
				                          	$ledgerpostingCashDebit['date']=date("Y-m-d H:i:s");
				                          	$ledgerpostingCashDebit['company_id']=$this->session->userdata('company_id');
				                          	$ledgerpostingtotal=$this->sale_model->add('tbl_ledgerposting',$ledgerpostingCashDebit);
				                        }
				                        $entry = $this->sale_model->getOne('tbl_ledgerposting', array('ledgerId' => $this->input->post('supplierId'), 'voucherNo' => $voucherNo, 'company_id' => $this->company_id));
		                          		if(isset($entry->id)) {
				                          	$ledgerpostingCustomerCredit['credit']=deformat_value($this->input->post('payment_receive'));
				                          	$ledgerpostingCustomerCredit=$this->sale_model->update('tbl_ledgerposting', array('id' => $entry->id),$ledgerpostingCustomerCredit);
		                          		} else {
			                          	$ledgerpostingCustomerCredit['voucherTypeId']=19;
			                          	$ledgerpostingCustomerCredit['voucherNo']=$voucherNo;
			                          	$ledgerpostingCustomerCredit['ledgerId']=$this->input->post('supplierId');
			                          	$ledgerpostingCustomerCredit['credit']=deformat_value($this->input->post('payment_receive'));
			                          	$ledgerpostingCustomerCredit['yearId']=$this->getActiveYearId();
			                          	$ledgerpostingCustomerCredit['invoiceNo']=$invoice->id;
			                          	$ledgerpostingCustomerCredit['date']=date("Y-m-d H:i:s");
			                          	$ledgerpostingCustomerCredit['company_id']=$this->session->userdata('company_id');
			                          	$ledgerpostingtotal=$this->sale_model->add('tbl_ledgerposting',$ledgerpostingCustomerCredit);
			                          }
		                          	}else if($total == $this->input->post('payment_receive')){
		                          		$entry = $this->sale_model->getOne('tbl_ledgerposting', array('ledgerId' => $this->input->post('supplierId'), 'voucherNo' => $voucherNo, 'company_id' => $this->company_id));
		                          		if(isset($entry->id)) {
				                          	$ledgerpostingCustomerDebits['debit']=deformat_value($total);
				                          	$ledgerpostingCustomerDebits=$this->sale_model->update('tbl_ledgerposting', array('id' => $entry->id),$ledgerpostingCustomerDebits);
		                          		} else {
			                          		$ledgerpostingCustomerDebits['voucherTypeId']=19;
				                          	$ledgerpostingCustomerDebits['voucherNo']=$voucherNo;
				                          	$ledgerpostingCustomerDebits['ledgerId']=$this->input->post('supplierId');
				                          	$ledgerpostingCustomerDebits['debit']=deformat_value($total);
				                          	$ledgerpostingCustomerDebits['yearId']=$this->getActiveYearId();
				                          	$ledgerpostingCustomerDebits['invoiceNo']=$invoice->id;
				                          	$ledgerpostingCustomerDebits['date']=date("Y-m-d H:i:s");
				                          	$ledgerpostingCustomerDebits['company_id']=$this->session->userdata('company_id');
				                          	$ledgerpostingtotal=$this->sale_model->add('tbl_ledgerposting',$ledgerpostingCustomerDebits);
				                        }
				                        $entry = $this->sale_model->getOne('tbl_ledgerposting', array('ledgerId' => 10, 'voucherNo' => $voucherNo, 'company_id' => $this->company_id));
		                          		if(isset($entry->id)) {
				                          	$ledgerpostingSaleCreditss['credit']=deformat_value($total);
				                          	$ledgerpostingSaleCreditss=$this->sale_model->update('tbl_ledgerposting', array('id' => $entry->id),$ledgerpostingSaleCreditss);
		                          		} else {
				                          	$ledgerpostingSaleCreditss['voucherTypeId']=19;
				                          	$ledgerpostingSaleCreditss['voucherNo']=$voucherNo;
				                          	$ledgerpostingSaleCreditss['ledgerId']=10;
				                          	$ledgerpostingSaleCreditss['credit']=deformat_value($total);
				                          	$ledgerpostingSaleCreditss['yearId']=$this->getActiveYearId();
				                          	$ledgerpostingSaleCreditss['invoiceNo']=$invoice->id;
				                          	$ledgerpostingSaleCreditss['date']=date("Y-m-d H:i:s");
				                          	$ledgerpostingSaleCreditss['company_id']=$this->session->userdata('company_id');
				                          	$ledgerpostingSaleCreditss=$this->sale_model->add('tbl_ledgerposting',$ledgerpostingSaleCreditss);
				                        }
				                        $entry = $this->sale_model->getOne('tbl_ledgerposting', array('ledgerId' => 1, 'voucherNo' => $voucherNo, 'company_id' => $this->company_id));
		                          		if(isset($entry->id)) {
				                          	$ledgerpostingCashDebits['debit']=deformat_value($this->input->post('payment_receive'));
				                          	$ledgerpostingCashDebits=$this->sale_model->update('tbl_ledgerposting', array('id' => $entry->id),$ledgerpostingCashDebits);
		                          		} else {
				                          	$ledgerpostingCashDebits['voucherTypeId']=19;
				                          	$ledgerpostingCashDebits['voucherNo']=$voucherNo;
				                          	$ledgerpostingCashDebits['ledgerId']=1;
				                          	$ledgerpostingCashDebits['debit']=$this->input->post('payment_receive');
				                          	$ledgerpostingCashDebits['yearId']=$this->getActiveYearId();
				                          	$ledgerpostingCashDebits['invoiceNo']=$invoice->id;
				                          	$ledgerpostingCashDebits['date']=date("Y-m-d H:i:s");
				                          	$ledgerpostingCashDebits['company_id']=$this->session->userdata('company_id');
				                          	$ledgerpostingtotal=$this->sale_model->add('tbl_ledgerposting',$ledgerpostingCashDebits);
				                        }
				                        $entry = $this->sale_model->getOne('tbl_ledgerposting', array('ledgerId' => $this->input->post('supplierId'), 'voucherNo' => $voucherNo, 'company_id' => $this->company_id));
		                          		if(isset($entry->id)) {
				                          	$ledgerpostingCustomersCash['credit']=deformat_value($this->input->post('payment_receive'));
				                          	$ledgerpostingCustomersCash=$this->sale_model->update('tbl_ledgerposting', array('id' => $entry->id),$ledgerpostingCustomersCash);
		                          		} else {
				                          	$ledgerpostingCustomersCash['voucherTypeId']=19;
				                          	$ledgerpostingCustomersCash['voucherNo']=$voucherNo;
				                          	$ledgerpostingCustomersCash['ledgerId']=$this->input->post('supplierId');
				                          	$ledgerpostingCustomersCash['credit']=deformat_value($this->input->post('payment_receive'));
				                          	$ledgerpostingCustomersCash['yearId']=$this->getActiveYearId();
				                          	$ledgerpostingCustomersCash['invoiceNo']=$invoice->id;
				                          	$ledgerpostingCustomersCash['date']=date("Y-m-d H:i:s");
				                          	$ledgerpostingCustomersCash['company_id']=$this->session->userdata('company_id');
				                          	$ledgerpostingtotal=$this->sale_model->add('tbl_ledgerposting',$ledgerpostingCustomersCash);
				                        }
		                          	}
		                          }
	                          	if($this->input->post('ledgerId') > 0):
	                          	$entry = $this->sale_model->getOne('tbl_ledgerposting', array('ledgerId' => $this->input->post('ledgerId'), 'voucherNo' => $voucherNo, 'company_id' => $this->company_id));
                          		if(isset($entry->id)) {
		                          	$ledgerpostingFreight['credit']=deformat_value($freight);
		                          	$ledgerpostingFreight=$this->sale_model->update('tbl_ledgerposting', array('id' => $entry->id),$ledgerpostingFreight);
                          		} else {
		                          	$ledgerpostingFreight['yearId']=$this->getActiveYearId();
		                          	$ledgerpostingFreight['voucherTypeId']=19;
		                          	$ledgerpostingFreight['voucherNo']=$voucherNo;
		                          	$ledgerpostingFreight['ledgerId']=$this->input->post('ledgerId');
		                          	$ledgerpostingFreight['date']=date("Y-m-d H:i:s");
		                          	$ledgerpostingFreight['company_id']=$this->session->userdata('company_id');
		                          	$ledgerpostingFreight['credit']=deformat_value($freight);
		                          	$ledgerpostingFreight['invoiceNo']=$invoice->id;
		                          	$ledgerpostingFreight=$this->sale_model->add('tbl_ledgerposting',$ledgerpostingFreight);
		                        }
	                          	endif;
	                          	if(deformat_value($tax_amount) > 0):
	                          	$entry = $this->sale_model->getOne('tbl_ledgerposting', array('ledgerId' => $this->input->post('tax'), 'voucherNo' => $voucherNo, 'company_id' => $this->company_id));
                          		if(isset($entry->id)) {
		                          	$ledgerpostingTax['credit']=deformat_value($tax_amount);
		                          	$ledgerpostingTax=$this->sale_model->update('tbl_ledgerposting', array('id' => $entry->id),$ledgerpostingTax);
                          		} else {
		                          	$ledgerpostingTax['yearId']=$this->getActiveYearId();
		                          	$ledgerpostingTax['voucherTypeId']=19;
		                          	$ledgerpostingTax['voucherNo']=$voucherNo;
		                          	$ledgerpostingTax['ledgerId']=$this->input->post('tax');
		                          	$ledgerpostingTax['date']=date("Y-m-d H:i:s");
		                          	$ledgerpostingTax['company_id']=$this->session->userdata('company_id');
		                          	$ledgerpostingTax['credit']=deformat_value($tax_amount);
		                          	$ledgerpostingTax['invoiceNo']=$invoice->id;
		                          	$saved=$this->sale_model->add('tbl_ledgerposting',$ledgerpostingTax);
		                        }
	                          	endif;
                          	}
                          }
                       // Change to decide thermal print or simple print
                        if($this->input->post('print') || $this->input->post('complete_sale')) {
					  		$qoutationNo = $this->input->post('salesInvoiceNo');
					   		if(isset($qoutationNo) && $qoutationNo > 0) {
					   			$this->session->set_flashdata('print_sale_invoice', $qoutationNo);
					   			// redirect('accounting/sales/printInvoice/'.$qoutationNo);
					   		}
					   	}
                        elseif($this->input->post('thermal_print') == 1)
                        {
                        	$qoutationNo = $this->input->post('salesInvoiceNo');
						   	//if(isset($qoutationNo) && $qoutationNo > 0)
						   	
                        }
                          if($updateInsaleInvoiceMaster){
                          	$this->session->set_flashdata('success',con_lang('mass_sales_invoice_update_successfully'));
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
			}
		}else{
			redirect('auth');
		}
	}
	public function deleteSaleInvoice($salesInvoiceNo=null, $id = null,$type=null){
		echo $salesInvoiceNo;
		if($this->isLoggedIn()){
			if($type=='ng'){
			}else{
				$delete=$this->common_model->update('tbl_salesinvoicemaster',array('id'=>$id), array('is_deleted' => 1));
				if($delete){
					$items = $this->common_model->getAll('tbl_salesinvoicedetails', array('company_id' => $this->company_id, 'salesInvoiceNo' => $salesInvoiceNo));
					if(!empty($items)) {
						foreach ($items as $item) {
							$quantity=0;
							if(isset($item->product_id) && isset($item->UOMId)) {
								$quantity=(float)$item->qty;
								$query_return="SELECT SUM(qty) AS total_return_qty FROM tbl_salesreturndetails WHERE product_id = $item->product_id AND UOMId = $item->UOMId AND company_id = $this->company_id AND salesInvoiceNo = $salesInvoiceNo";
								$check_return_sale_invoices=$this->common_model->universal($query_return)->row();
								if(!empty($check_return_sale_invoices) && isset($check_return_sale_invoices->total_return_qty)){
									$quantity-=(float)$check_return_sale_invoices->total_return_qty;
								}
								$unit_id = $item->UOMId;
								$qty = $quantity;
								$update_where = array('UOMId' => $item->UOMId, 'productName' => $item->product_id, 'company_id' => $this->company_id);
                          	 	$purchaseprice = $this->sale_model->getOne('tbl_purchasepricelist', $update_where);
                          	 	if(isset($purchaseprice->base_id) && $purchaseprice->base_id) {
                          	 		$qty = (float)deformat_value($purchaseprice->base_qty * (float)$quantity);
                          	 		$unit_id = $purchaseprice->base_id;
                          	 	}
								// $quantity = (int)$item->qty;
								$this->common_model->universal("UPDATE tbl_stockdetails SET qty = qty + $qty WHERE company_id = ".$this->company_id." AND product_id = ".$item->product_id." AND UOMId = ".$unit_id);
								if($qty > 0) {
	                          	 	$entry = array(
	                          	 		'product_id' => $item->product_id,
	                          	 		'unit_id' => $unit_id,
	                          	 		'voucher_type' => 'Sale Invoice (Deleted)',
	                          	 		'invoice_no' => $salesInvoiceNo,
	                          	 		'voucher_no' => 'SI-'.sprintf("%0".$this->voucher_number_length."d",$salesInvoiceNo).'-Deleted',
	                          	 		'debit' => $qty,
	                          	 		'created_by' => $this->session->userdata('id'),
	                          	 		'company_id' => $this->company_id,
	                          	 		'created_on' => date('Y-m-d H:i:s')
	                          	 	);
	                          	 	$this->sale_model->add('tbl_stock_ledger_posting', $entry);
	                          	 }
							}
						}
					}
					// $delete2=$this->common_model->delete('tbl_salesinvoicedetails',array('salesInvoiceNo'=>$salesInvoiceNo));
					if($delete){
						$this->common_model->delete('tbl_ledgerposting',array('voucherTypeId'=>19, 'invoiceNo' => $id));
						$this->common_model->delete('add_payment',array('company_id'=>$this->company_id, 'salesInvoiceNo' => $salesInvoiceNo));
						$result['message']=con_lang("mass_deleted_successfully");
						$result['response']=1;
					}
				}else{
					$result['message']=con_lang("mass_error_occurrs_try_later");
					$result['response']=0;
				}
				echo json_encode($result);exit();
			}
		}else{
			redirect('auth');
		}
	}
	public function checkQtyInStock($type=null){
		if($this->isLoggedIn()){
			if($type == 'ng'){
			}else{
				if($this->input->post('productId')){
					$productId=$this->input->post('productId');
					$unitId=$this->input->post('unitId');
					$result=$this->sale_model->getOne('tbl_stockdetails',array('product_id'=>$productId,'UOMId'=>$unitId,'company_id'=>$this->session->userdata('company_id')));
					echo json_encode($result);exit();
				}
			}
		}else{
			redirect('auth');
		}
	}
	public function checkMaxQtyInStock($type=null){
		if($this->isLoggedIn()){
			if($type == 'ng'){
			}else{
				if($this->input->post('data')){
					$qty=$this->input->post('data');
					$productId=$this->input->post('productId');
					$unitId=$this->input->post('unitId');
					$company_id=$this->session->userdata('company_id');
					$result=$this->sale_model->getOne('tbl_stockdetails',array('product_id'=>$productId,'UOMId'=>$unitId,'company_id'=>$this->session->userdata('company_id')));
					 	echo json_encode($result);exit();
					
				}
			}
		}else{
			redirect('auth');
		}
	}
	public function searchProduct($type=null){
		if($this->isLoggedIn()){
				if($type=='ng'){
				}else{
					if($this->input->post('id')){
						$id= $this->input->post('id');
						$company_id=$this->session->userdata('company_id');
						$query="SELECT * FROM tbl_product WHERE (id=$id || barcode=$id) AND isActive = 1 AND company_id=$company_id";
					    $result=$this->sale_model->universal($query)->row();
						echo json_encode($result);
					}
				}
		}else{
			redirect('auth');
		}
	}
	public function searchProductForPos($type=null){
		if($this->isLoggedIn()){
				if($type=='ng'){
				}else{
					if($this->input->post('id')){
						$id= $this->input->post('id');
						$company_id=$this->session->userdata('company_id');
						$query="SELECT * FROM tbl_product WHERE (id=$id || barcode=$id) AND isActive = 1 AND company_id=$company_id";
						$result['product']=$this->sale_model->universal($query)->row();
						$query2="SELECT * FROM tbl_purchasepricelist WHERE productName = $id AND company_id=$company_id";
						$result['units_price']=$this->sale_model->universal($query2)->result();
						if(!empty($result['units_price'])){
							foreach($result['units_price'] as $key => &$value){
								if(isset($value->UOMId)){
									$units=$this->sale_model->getOne('tbl_uom',array('id'=>$value->UOMId));
									$value->units_name=isset($units->UOMName) ? $units->UOMName :'';
									$query = $this->sale_model->universal("SELECT * FROM tbl_promotions WHERE product_id = $id AND unit_id = $value->UOMId AND company_id=$company_id");
									if($query){
										$promotion = $query->row();
										$value->discount_amount=isset($promotion->discount_amount) ? $promotion->discount_amount :0;
									}
									$stock_detail=$this->sale_model->getOne('tbl_stockdetails',array('product_id'=>$id,'UOMId'=>$value->UOMId,'company_id'=>$this->session->userdata('company_id')));
									$value->stock=isset($stock_detail->qty) ? $stock_detail->qty :0;
								}
							}
						}
						// debug($result);
						$apply_tax = $this->common_model->getOne('tbl_apply_taxes', array('company_id' => $this->company_id, 'voucher_type' => 'sale'));
						$taxes = array();
						if(isset($apply_tax->taxes) && $apply_tax->taxes != '') {
							$result['taxes'] = $this->sale_model->getAll('tbl_accountledger', "product_bill = 'product' AND company_id = ".$this->company_id." AND id IN (".$apply_tax->taxes.")");
						}
						echo json_encode($result);exit();
					}
				}
		}else{
			redirect('auth');
		}
	}
	public function getPriceAccordingToUnits($type=null){
		if($this->isLoggedIn()){
				if($type=='ng'){
				}else{
					if($this->input->post('uomid')){
						$productId= $this->input->post('productId');
						$uomid= $this->input->post('uomid');
						$company_id=$this->session->userdata('company_id');
						$query="SELECT * FROM tbl_purchasepricelist WHERE productName=$productId AND UOMId = $uomid AND company_id=$company_id";
						$result=$this->sale_model->universal($query)->row();
						$query = $this->sale_model->universal("SELECT * FROM tbl_promotions WHERE product_id = $productId AND unit_id = $uomid AND company_id=$company_id");
						if($query) {
							$result->promotion = $query->row();
						}
				     	}
						echo json_encode($result);
				}
		}else{
			redirect('auth');
		}
	}
	public function searchSaleQuotation($type=null){
		if($this->isLoggedIn()){
			if($type=='ng'){
			}else{
				if($this->input->post('saleQuotationNo')){
					$saleQoutationId=$this->input->post('saleQuotationNo');
					$result=$this->sale_model->getSaleQuotationNo($saleQoutationId);
					if(isset($result->id) && $result->id > 0){
						 $array1=$this->sale_model->getAll('tbl_product',array('isActive' => 1,'company_id'=>$this->session->userdata('company_id')));
						 $array2=$this->sale_model->getAll('tbl_uom',array('company_id'=>$this->session->userdata('company_id')));
					     echo json_encode(array('result'=>$result,'products' => $array1, 'units' => $array2));exit();
					}
				}
			}
		}else{
			redirect('auth');
		}
	}
	public function searchBySaleorder($type=null){
		if($this->isLoggedIn()){
			if($type=='ng'){
			}else{
				if($this->input->post('OrderNo')){
					$OrderNo=$this->input->post('OrderNo');
					$array1=$this->sale_model->getAll('tbl_product', array('isActive' => 1,'company_id'=>$this->session->userdata('company_id')));
					$array2=$this->sale_model->getAll('tbl_uom',array('company_id'=>$this->session->userdata('company_id')));
					$result=$this->sale_model->getByOrderNo($OrderNo);
					echo json_encode(array('result'=>$result,'products' => $array1, 'units' => $array2));exit();
				}
			}
		}else{
			redirect('auth');
		}
	}
	public function getDataFromTwoTable($type=null){
		if($this->isLoggedIn()){
				if($type=='ng'){
				}else{
						$array1=$this->sale_model->getStockProducts();
						$array2=$this->sale_model->getAll('tbl_uom',array('company_id'=>$this->session->userdata('company_id')));
						$apply_tax = $this->common_model->getOne('tbl_apply_taxes', array('company_id' => $this->company_id, 'voucher_type' => 'purchase'));
						$taxes = array();
						if(isset($apply_tax->taxes) && $apply_tax->taxes != '') {
							$taxes = $this->sale_model->getAll('tbl_accountledger', "product_bill = 'product' AND company_id = ".$this->company_id." AND id IN (".$apply_tax->taxes.")");
						}
						echo json_encode(array('products' => $array1, 'units' => $array2, 'taxes' => $taxes));exit();
					}
				
		}else{
			redirect('auth');
		}
	}
	public function deleteByAjax($type=null){
		if($this->isLoggedIn()){
			if($type=='ng'){
			}else{
				if($this->input->post('id')){
					$table=$this->input->post('table');
					$id=$this->input->post('id');
					$amount=$this->input->post('amount');
					$delete=$this->sale_model->delete($table,array('id'=>$id));
					if($delete){
								$result['response']=1;
								echo json_encode($result);exit();
					}else{
								$result['response']=0;
							    echo json_encode($result);exit();
					}
				}
			}
		}else{
			redirect('auth');
		}
	}
	public function saleReturn($type=null){
		if($this->isLoggedIn()){
			if($type == 'ng'){
			}else{
				$data['active']='Sales Return';
				$data['module']='accounting';
				$data['taxesOnBill']=$this->sale_model->getAll('tbl_accountledger',array('product_bill'=>'bill','company_id'=>$this->company_id, 'accountGroupId' => 20));
				if($this->input->server('REQUEST_METHOD')==='POST'){
					$dateActiveYear=date('Y-m-d',strtotime($this->input->post('deliveryDate')));
					   	  $activeYear=$this->sale_model->getOne('tbl_financialyear',array('isActive'=>1, 'company_id' => $this->company_id));
					   	  if(!empty($activeYear)){
					   	  if($dateActiveYear >= $activeYear->fromDate && $dateActiveYear <= $activeYear->toDate){
					$sales_Invoice_No=$this->input->post('salesInvoiceNo');
					$customer_ledgerId=$this->input->post('supplierId');
						  $saleInvoiceMaster=array(
						  		'salesInvoiceNo'=>$this->input->post('salesInvoiceNo'),
						  		'customerId'=>$customer_ledgerId,
						  		'company_id'=>$this->session->userdata('company_id'),
						  		'salesmanId'=>$this->input->post('salesmanId'),
						  		'currencyId'=>$this->input->post('currencyId'),
						  		'deliveryDate'=>date('Y-m-d',strtotime($this->input->post('deliveryDate'))),
						  		'salesInvoiceIsPrintAfterSave'=>$this->input->post('salesInvoiceIsPrintAfterSave'),
						  		'subtotal'=>$this->input->post('subtotal'),
						  		'discount'=>$this->input->post('discount'),
						  		'freight'=>$this->input->post('freight'),
						  		'tax'=>$this->input->post('tax'),
						  		'tax_amount'=>$this->input->post('tax_return_amount'),
						  		'total'=>$this->input->post('total'),
						  		'narration'=>$this->input->post('narration'),
						  		'payment_return'=>$this->input->post('payment_return'),
						  	);
						  $saleInvoiceMaster['created_on'] =  date('Y-m-d H:i:s', strtotime($saleInvoiceMaster['deliveryDate'].' '.date('H:i:s')));
						  $products=$this->input->post('product');

						  if(isset($saleInvoiceMaster['payment_return']) && isset($saleInvoiceMaster['salesInvoiceNo'])) {
						  	$amount = (float)$saleInvoiceMaster['payment_return'];
						  	$payment = $this->sale_model->getOne('add_payment', array('company_id' => $this->company_id, 'salesInvoiceNo' => $saleInvoiceMaster['salesInvoiceNo'], 'method' => 'Cash'));
						  	// debug($payment);
						  	if(isset($payment->id)) {
						  		$this->sale_model->universal("UPDATE add_payment SET payment_value = payment_value - $amount WHERE id = ".$payment->id);
						  	} else {
						  		$method = $this->sale_model->getOne('tbl_payment_methods', array('company_id' => $this->company_id, 'is_default' => 1));
						  		$method = isset($method->id) ? $method->id : null;
						  		$payment = array (
						  			'company_id' => $this->company_id,
						  			'ledger_id' => $customer_ledgerId,
						  			'payment_value' => (-1)*$amount,
						  			'method' => 'Cash',
						  			'payment_method' => 'Cash (Return)',
						  			'salesInvoiceNo' => $saleInvoiceMaster['salesInvoiceNo'],
						  			'created_on' => date('Y-m-d H:i:s'),
						  			'method_id' => $method,
						  			'is_return' => 1
						  		);
						  		$this->sale_model->insert('add_payment', $payment);
						  	}
						  }
						  // exit();
						  // debug($products);
						  // $existing_record = $this->sale_model->universal("SELECT * FROM tbl_salesreturnmaster WHERE salesInvoiceNo = ".$saleInvoiceMaster['salesInvoiceNo']." AND company_id =".$this->company_id);
						  $existing_record = null;
						  $existing_record = ($existing_record) ? $existing_record->row() : null;
						  if(isset($existing_record->id)) {
						  	$savedInsaleInvoiceMaster=$this->sale_model->update('tbl_salesreturnmaster', array('id' => $existing_record->id),$saleInvoiceMaster);
						  	$savedInsaleInvoiceMaster = $existing_record->id;
						  } else {
						  	$savedInsaleInvoiceMaster=$this->sale_model->add('tbl_salesreturnmaster',$saleInvoiceMaster);
						  }
						  $can_return_more = false;
						  // $savedInsaleInvoiceMaster=$this->sale_model->add('tbl_salesreturnmaster',$saleInvoiceMaster);
						  if($savedInsaleInvoiceMaster > 0){
							  	foreach($products as $values){
							  	unset($values['purchaseInvoiceDetailId']);
							  	if(isset($values['qty']))
							  		$values['return_qty'] = $values['qty'];
							  	 $values['salesInvoiceNo']=$this->input->post('salesInvoiceNo');
							  	 $values['company_id']=$this->session->userdata('company_id');
							  	 if(isset($values['remaining_qty']) && isset($values['qty'])) {
									$diff = (float)$values['remaining_qty'] - (float)$values['qty'];
									if($diff > 0) {
										$can_return_more = true;
									}
									unset($values['remaining_qty']);
								}
								$existing_record = $this->sale_model->universal("SELECT * FROM tbl_salesreturndetails WHERE salesInvoiceNo = ".$values['salesInvoiceNo']." AND product_id = ".$values['product_id']." AND UOMId = ".$values['UOMId']." AND company_id =".$this->company_id);
									$existing_record = ($existing_record) ? $existing_record->row() : null;
									if(isset($existing_record->id)) {
										// $savedInSaleInvoiceDetail=$this->sale_model->update('tbl_salesreturndetails', array('id' => $existing_record->id),$values);
										$savedInSaleInvoiceDetail=$this->sale_model->universal("UPDATE tbl_salesreturndetails SET qty = qty+".$values['qty'].", return_qty = ".$values['qty'].", amount = ".$values['amount']." WHERE id = ".$existing_record->id);
									} else {
										$savedInSaleInvoiceDetail=$this->sale_model->add('tbl_salesreturndetails',$values);
									}
	                          	 // $savedInSaleInvoiceDetail=$this->sale_model->add('tbl_salesreturndetails',$values);
								if(isset($values['UOMId']) && $values['product_id']) {
									$update_where = array('UOMId' => $values['UOMId'], 'productName' => $values['product_id'], 'company_id' => $this->company_id);
	                          	 	$purchaseprice = $this->sale_model->getOne('tbl_purchasepricelist', $update_where);
	                          	 	if(isset($purchaseprice->base_id) && $purchaseprice->base_id) {
	                          	 		$derived_qty = (float)$purchaseprice->base_qty * (float)$values['qty'];
	                          	 		$values['UOMId'] = $purchaseprice->base_id;
	                          	 		$values['qty'] = $derived_qty;
	                          	 	}
					            }
	                          	 $qtyy=$values['qty'];
	                          	 $productsId=$values['product_id'];
	                          	 $uomID=$values['UOMId'];
	                          	 $company_id=$this->session->userdata('company_id');
	                          	 $query="UPDATE tbl_stockdetails SET  qty= qty +$qtyy WHERE company_id =$company_id  AND product_id=$productsId AND UOMId=$uomID";
	                          	 $updateStock=$this->sale_model->universal($query);
	                          	 if(isset($values['qty']) && $values['qty'] > 0) {
	                          	 	$entry = array(
	                          	 		'product_id' => $values['product_id'],
	                          	 		'unit_id' => $values['UOMId'],
	                          	 		'voucher_type' => 'Sale Return',
	                          	 		'voucher_no' => 'SR-'.sprintf("%0".$this->voucher_number_length."d",$this->input->post('salesInvoiceNo')),
	                          	 		'debit' => $values['qty'],
	                          	 		'created_by' => $this->session->userdata('id'),
	                          	 		'company_id' => $this->company_id,
	                          	 		'created_on' => date('Y-m-d H:i:s')
	                          	 	);
	                          	 	$this->sale_model->add('tbl_stock_ledger_posting', $entry);
	                          	}
	                          }
	                          if($savedInSaleInvoiceDetail > 0){
	                          	$voucherNo='SR-'.sprintf("%0".$this->voucher_number_length."d",$this->input->post('salesInvoiceNo'));

	                          	$subtotal = (float)$this->input->post('subtotal');
	                          	$freight = (float)$this->input->post('freight');
	                          	$total_with_freight = $subtotal + $freight;
	                          	$tax_id = (int)$this->input->post('tax_name');
	                          	$tax_row = $this->sale_model->getById('tbl_accountledger', $tax_id);
	                          	$tax_amount = 0;
	                          	if(isset($tax_row->tax_value)) {
	                          		$tax_amount = (float)$tax_row->tax_value;
	                          		if($tax_row->tax_symbal == '%') {
	                          			$tax_amount = ($tax_amount*$total_with_freight)/100;
	                          		}
	                          	}

	                          	$total_with_tax = $total_with_freight + $tax_amount;
                          		$discount = (float)$this->input->post('discount');
                          		// $discount_type = $this->input->post('discount_type');
                          		// if($discount_type == '%') {
                          		// 	$discount = ($discount*$total_with_tax)/100;
                          		// }
                          		$total = $total_with_tax - $discount;
                          		$payment = 0;
                          		if($this->input->post('payment_return')) {
                          			$payment = deformat_value($this->input->post('payment_return'));
                          		}
                          		$ledgerpostingDiscount = null;
                          		if($discount > 0):
		                          	$ledgerpostingDiscount['voucherTypeId']=13;
		                          	$ledgerpostingDiscount['voucherNo']=$voucherNo;
		                          	$ledgerpostingDiscount['ledgerId']=9;
		                          	$ledgerpostingDiscount['credit']=$discount;
		                          	$ledgerpostingDiscount['yearId']=$this->getActiveYearId();
		                          	$ledgerpostingDiscount['invoiceNo']=$savedInsaleInvoiceMaster;
		                          	$ledgerpostingDiscount['date']=date("Y-m-d H:i:s");
		                          	$ledgerpostingDiscount['company_id']=$this->session->userdata('company_id');
		                          	$ledgerpostingDiscount=$this->sale_model->add('tbl_ledgerposting',$ledgerpostingDiscount);
		                        endif;
		                        if($customer_ledgerId == 1){
		                          	$ledgerpostingTotal['voucherTypeId']=20;
		                          	$ledgerpostingTotal['voucherNo']=$voucherNo;
		                          	$ledgerpostingTotal['ledgerId']=$customer_ledgerId;
		                          	$ledgerpostingTotal['credit']=$total;
		                          	$ledgerpostingTotal['yearId']=$this->getActiveYearId();
		                          	$ledgerpostingTotal['invoiceNo']=$savedInsaleInvoiceMaster;
		                          	$ledgerpostingTotal['date']=date("Y-m-d H:i:s");
		                          	$ledgerpostingTotal['company_id']=$this->session->userdata('company_id');
		                          	$ledgerpostingtotal=$this->sale_model->add('tbl_ledgerposting',$ledgerpostingTotal);

		                          	$ledgerpostingTotal['voucherTypeId']=20;
		                          	$ledgerpostingTotal['voucherNo']=$voucherNo;
		                          	$ledgerpostingTotal['ledgerId']=10;
		                          	$ledgerpostingTotal['debit']=$total;
		                          	$ledgerpostingTotal['yearId']=$this->getActiveYearId();
		                          	$ledgerpostingTotal['invoiceNo']=$savedInsaleInvoiceMaster;
		                          	$ledgerpostingTotal['date']=date("Y-m-d H:i:s");
		                          	$ledgerpostingTotal['company_id']=$this->session->userdata('company_id');
		                          	$ledgerpostingtotal=$this->sale_model->add('tbl_ledgerposting',$ledgerpostingTotal);
		                        } else {
		                          	if($payment == 0){
		                          		$ledgerpostingTotal['voucherTypeId']=20;
			                          	$ledgerpostingTotal['voucherNo']=$voucherNo;
			                          	$ledgerpostingTotal['ledgerId']=10;
			                          	$ledgerpostingTotal['debit']=$total;
			                          	$ledgerpostingTotal['yearId']=$this->getActiveYearId();
			                          	$ledgerpostingTotal['invoiceNo']=$savedInsaleInvoiceMaster;
			                          	$ledgerpostingTotal['date']=date("Y-m-d H:i:s");
			                          	$ledgerpostingTotal['company_id']=$this->session->userdata('company_id');
			                          	$ledgerpostingtotal=$this->sale_model->add('tbl_ledgerposting',$ledgerpostingTotal);

			                          	$ledgerpostingTotal['voucherTypeId']=20;
			                          	$ledgerpostingTotal['voucherNo']=$voucherNo;
			                          	$ledgerpostingTotal['ledgerId']=$customer_ledgerId;
			                          	$ledgerpostingTotal['credit']=$total;
			                          	$ledgerpostingTotal['yearId']=$this->getActiveYearId();
			                          	$ledgerpostingTotal['invoiceNo']=$savedInsaleInvoiceMaster;
			                          	$ledgerpostingTotal['date']=date("Y-m-d H:i:s");
			                          	$ledgerpostingTotal['company_id']=$this->session->userdata('company_id');
			                          	$ledgerpostingtotal=$this->sale_model->add('tbl_ledgerposting',$ledgerpostingTotal);
		                          	}else if($total > $payment) {
		                          		$ledgerpostingTotal['voucherTypeId']=20;
			                          	$ledgerpostingTotal['voucherNo']=$voucherNo;
			                          	$ledgerpostingTotal['ledgerId']=10;
			                          	$ledgerpostingTotal['debit']=$total;
			                          	$ledgerpostingTotal['yearId']=$this->getActiveYearId();
			                          	$ledgerpostingTotal['invoiceNo']=$savedInsaleInvoiceMaster;
			                          	$ledgerpostingTotal['date']=date("Y-m-d H:i:s");
			                          	$ledgerpostingTotal['company_id']=$this->session->userdata('company_id');
			                          	$ledgerpostingtotal=$this->sale_model->add('tbl_ledgerposting',$ledgerpostingTotal);

			                          	$ledgerpostingTotal['voucherTypeId']=20;
			                          	$ledgerpostingTotal['voucherNo']=$voucherNo;
			                          	$ledgerpostingTotal['ledgerId']=$customer_ledgerId;
			                          	$ledgerpostingTotal['credit']=$total;
			                          	$ledgerpostingTotal['debit']=deformat_value($this->input->post('payment_return'));
			                          	$ledgerpostingTotal['yearId']=$this->getActiveYearId();
			                          	$ledgerpostingTotal['invoiceNo']=$savedInsaleInvoiceMaster;
			                          	$ledgerpostingTotal['date']=date("Y-m-d H:i:s");
			                          	$ledgerpostingTotal['company_id']=$this->session->userdata('company_id');
			                          	$ledgerpostingtotal=$this->sale_model->add('tbl_ledgerposting',$ledgerpostingTotal);

			                          	$ledgerpostingTotal['voucherTypeId']=20;
			                          	$ledgerpostingTotal['voucherNo']=$voucherNo;
			                          	$ledgerpostingTotal['ledgerId']=1;
			                          	$ledgerpostingTotal['credit']=$total;
			                          	$ledgerpostingTotal['yearId']=$this->getActiveYearId();
			                          	$ledgerpostingTotal['invoiceNo']=$savedInsaleInvoiceMaster;
			                          	$ledgerpostingTotal['date']=date("Y-m-d H:i:s");
			                          	$ledgerpostingTotal['company_id']=$this->session->userdata('company_id');
			                          	$ledgerpostingtotal=$this->sale_model->add('tbl_ledgerposting',$ledgerpostingTotal);
		                          	}else if($total == $payment) {
		                          		$ledgerpostingTotal['voucherTypeId']=20;
			                          	$ledgerpostingTotal['voucherNo']=$voucherNo;
			                          	$ledgerpostingTotal['ledgerId']=10;
			                          	$ledgerpostingTotal['debit']=$total;
			                          	$ledgerpostingTotal['yearId']=$this->getActiveYearId();
			                          	$ledgerpostingTotal['invoiceNo']=$savedInsaleInvoiceMaster;
			                          	$ledgerpostingTotal['date']=date("Y-m-d H:i:s");
			                          	$ledgerpostingTotal['company_id']=$this->session->userdata('company_id');
			                          	$ledgerpostingtotal=$this->sale_model->add('tbl_ledgerposting',$ledgerpostingTotal);

			                          	$ledgerpostingTotal['voucherTypeId']=20;
			                          	$ledgerpostingTotal['voucherNo']=$voucherNo;
			                          	$ledgerpostingTotal['ledgerId']=$customer_ledgerId;
			                          	$ledgerpostingTotal['credit']=$total;
			                          	$ledgerpostingTotal['debit']=deformat_value($this->input->post('payment_return'));
			                          	$ledgerpostingTotal['yearId']=$this->getActiveYearId();
			                          	$ledgerpostingTotal['invoiceNo']=$savedInsaleInvoiceMaster;
			                          	$ledgerpostingTotal['date']=date("Y-m-d H:i:s");
			                          	$ledgerpostingTotal['company_id']=$this->session->userdata('company_id');
			                          	$ledgerpostingtotal=$this->sale_model->add('tbl_ledgerposting',$ledgerpostingTotal);

			                          	$ledgerpostingTotal['voucherTypeId']=20;
			                          	$ledgerpostingTotal['voucherNo']=$voucherNo;
			                          	$ledgerpostingTotal['ledgerId']=1;
			                          	$ledgerpostingTotal['credit']=deformat_value($this->input->post('payment_return'));
			                          	$ledgerpostingTotal['yearId']=$this->getActiveYearId();
			                          	$ledgerpostingTotal['invoiceNo']=$savedInsaleInvoiceMaster;
			                          	$ledgerpostingTotal['date']=date("Y-m-d H:i:s");
			                          	$ledgerpostingTotal['company_id']=$this->session->userdata('company_id');
			                          	$ledgerpostingtotal=$this->sale_model->add('tbl_ledgerposting',$ledgerpostingTotal);
		                        	}
		                        }
	                          	// $ledgerpostingDedit['voucherTypeId']=20;
	                          	// $ledgerpostingDedit['voucherNo']=$voucherNo;
	                          	// $ledgerpostingDedit['ledgerId']=$customer_ledgerId;
	                          	// $ledgerpostingDedit['debit']=$total-$discount;
	                          	// $ledgerpostingDedit['yearId']=$this->getActiveYearId();
	                          	// $ledgerpostingDedit['invoiceNo']=$savedInsaleInvoiceMaster;
	                          	// $ledgerpostingDedit['date']=date("Y-m-d H:i:s");
	                          	// $ledgerpostingDedit['company_id']=$this->session->userdata('company_id');
	                          	// $ledgerpostingDedit=$this->sale_model->add('tbl_ledgerposting',$ledgerpostingDedit);
	                          	// No Freight Return
	                          	// if($this->input->post('ledgerId') > 0):
	                          	// $ledgerpostingFreight['yearId']=$this->getActiveYearId();
	                          	// $ledgerpostingFreight['voucherTypeId']=19;
	                          	// $ledgerpostingFreight['voucherNo']=$voucherNo;
	                          	// $ledgerpostingFreight['ledgerId']=$this->input->post('ledgerId');
	                          	// $ledgerpostingFreight['date']=date("Y-m-d");
	                          	// $ledgerpostingFreight['company_id']=$this->session->userdata('company_id');
	                          	// $ledgerpostingFreight['debit']=$freight;
	                          	// $ledgerpostingFreight['invoiceNo']=$savedInsaleInvoiceMaster;
	                          	// $ledgerpostingFreight=$this->sale_model->add('tbl_ledgerposting',$ledgerpostingFreight);
	                          	// endif;
	                          	$ledgerpostingTaxCheck = 0;
	                          	if($tax_amount > 0):
	                          	$ledgerpostingTax['yearId']=$this->getActiveYearId();
	                          	$ledgerpostingTax['voucherTypeId']=13;
	                          	$ledgerpostingTax['voucherNo']=$voucherNo;
	                          	$ledgerpostingTax['ledgerId']=$this->input->post('tax_name');
	                          	$ledgerpostingTax['date']=date("Y-m-d H:i:s");
	                          	$ledgerpostingTax['company_id']=$this->session->userdata('company_id');
	                          	$ledgerpostingTax['credit']=$tax_amount;
	                          	$ledgerpostingTax['invoiceNo']=$savedInpurchaseReturnMaster;
	                          	$ledgerpostingTaxCheck=$this->sale_model->add('tbl_ledgerposting',$ledgerpostingTax);
	                          	endif;
                          		if(!$can_return_more) {
                          			$update=$this->sale_model->update('tbl_salesinvoicemaster',array('salesInvoiceNo'=>$sales_Invoice_No),array('isReturn'=>1));
                          		}
                          		$update=$this->sale_model->update('tbl_salesinvoicemaster',array('salesInvoiceNo'=>$sales_Invoice_No),array('can_edit'=>0));
	                          	// if($ledgerpostingtotal > 0 && $ledgerpostingTaxCheck>0 && $ledgerpostingDiscount>0 && $ledgerpostingDedit >0){
	                          		 if($this->input->post('save_print')) {
								   		if(isset($savedInsaleInvoiceMaster) && $savedInsaleInvoiceMaster > 0) {
								   			$this->session->set_flashdata('print_sale_return', $savedInsaleInvoiceMaster);
								   			// $this->printReturn($savedInsaleInvoiceMaster);
								   		}
								   	}
		                          		$this->session->set_flashdata('success',con_lang('mass_sales_return_added_successfully'));
		                          	   redirect($_SERVER['HTTP_REFERER']);
		                           // }
	                          }else{
	                          		$this->session->set_flashdata('error',con_lang('mass_error_occurrs_try_later'));
	                             	redirect($_SERVER['HTTP_REFERER']);
	                          }
						  }else{
						  	     $this->session->set_flashdata('error',con_lang('mass_error_occurrs_try_later'));
	                          	  redirect($_SERVER['HTTP_REFERER']);
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
				   $this->displayView('accounting/sales/sale_return',$data,array(),array(
						'js'=>array(),
						'css'=>array(),
					));
			}
		}else{
			redirect('auth');
		}
	}
	public function searchByInvoiceNo($type=null){
		if($this->isLoggedIn()){
			if($type=='ng'){
			}else{
				if($this->input->post('invoiceNo')){
					$invoiceNo=$this->input->post('invoiceNo');
					$company_id=$this->session->userdata('company_id');
					$result=$this->sale_model->getByinvoiceNo($invoiceNo);
					if(isset($result->id) && $result->id > 0){
						 $array1=$this->sale_model->getAll('tbl_product',array('isActive' => 1,'company_id'=>$this->session->userdata('company_id')));
						 $array2=$this->sale_model->getAll('tbl_uom',array('company_id'=>$this->session->userdata('company_id')));
					     echo json_encode(array('result'=>$result,'products' => $array1, 'units' => $array2));exit();
					}
				}
			}
		}else{
			redirect('auth');
		}
	}
	public function printReturn($id = null) {
		if($id != null) {
			$this->load->model('reports_model');
			$this->load->model('sale_model');
			$model = (object)$this->sale_model->getOne('tbl_salesreturnmaster', array('id' => $id, 'company_id' => $this->company_id));
			// if(isset($model->payment_return))
			// 	$modal
			// if(isset($model->tax) && $model->tax > 0){
   //              $taxesOnBill=$this->sale_model->getOne('tbl_accountledger',array('id'=>$model->tax));
   //              if(isset($taxesOnBill->tax_symbal) && $taxesOnBill->tax_symbal == '%')
   //              	$model->tax_amount = $model->total + (float)($model->total/100 * $taxesOnBill->tax_value);
   //              else
   //              	$model->tax_amount = $model->total + (float)($taxesOnBill->tax_value);
   //          }
			if(isset($model->supplierId)){
				$data['ledger'] = $this->sale_model->getOne('tbl_accountledger', array('id' => $model->supplierId));
			}
			if(isset($model->salesInvoiceNo)){
				$data['products'] = $this->sale_model->getAll('tbl_salesreturndetails', array('salesInvoiceNo' => $model->salesInvoiceNo, 'company_id' => $this->company_id));
				if(!empty($data['products'])){
					foreach ($data['products'] as &$key){
						if(isset($key->tax_id)){
							$tax_amount=0;
							$texes_data=$this->sale_model->getOne('tbl_accountledger',array('id'=>$key->tax_id));
							if(isset($texes_data->tax_symbal) && isset($key->rate) && isset($texes_data->tax_value) &&  $texes_data->tax_symbal == '%'){
								$tax_amount=(float)($key->rate/100 * $texes_data->tax_value);
								$tax_amount=isset($tax_amount) ? $tax_amount :0;
							}else{
								$tax_amount=isset($texes_data->tax_value) ? $texes_data->tax_value:0;
							}
							$key->taxAmount=$tax_amount;
						}
						if(isset($key->UOMId)) {
							$key->unit = $this->sale_model->getById('tbl_uom', $key->UOMId);
						}
						if(isset($key->product_id)){
							$products_detail=$this->sale_model->getOne('tbl_product',array('id'=>$key->product_id));
							$key->productName=isset($products_detail->productName) ? $products_detail->productName :'';
						}
					}
				}
			}
			$data['currency'] = 'USD';
			$currencyName=$this->reports_model->getOne('tbl_currency',array('company_id'=>$this->company_id));
            if(!empty($currencyName)){
               $data['currency'] =$currencyName->currency_code;
            }
			$data['number'] = sprintf('%04d', $id);
			$data['model'] = $model;
			$data['form_title'] = 'Return';
			$data['is_print'] = true;
			$data['is_sale'] = true;
		  	$data['title'] = 'Sale Return';
		   	$html = $this->displayView('accounting/purchases/purchase_report' ,$data,array('topbar', 'sidenav'),array(
							'js'=>array(),
							'css'=>array(),
						), true);
		   	echo $html;
		   	exit();
			$this->load->helper(array('mpdf', 'file'));
		   	$filename = 'assets/pdf/SaleReturn_'.$id.'.pdf';
		  	if(file_exists($filename))
		  		unlink($filename);
		   	pdf_create($html, $filename, true);
		   	redirect(base_url($filename));
		}
		return false;
	}
	public function viewInvoice($id = null){
		if($id != null){
			$data['active']='';
			$this->load->model('reports_model');
			$this->load->model('sale_model');
			$model = (object)$this->sale_model->getOne('tbl_salesinvoicemaster', array('salesInvoiceNo' => $id, 'company_id' => $this->company_id));
			if(isset($model->supplierId)) {
				$data['ledger'] = $this->sale_model->getOne('tbl_accountledger', array('id' => $model->supplierId));
			}
			if(isset($model->salesInvoiceNo)) {
				$data['products'] = $this->sale_model->getAll('tbl_salesinvoicedetails', array('salesInvoiceNo' => $model->salesInvoiceNo, 'company_id' => $this->company_id));
				if(!empty($data['products'])) {
					foreach ($data['products'] as &$key) {
						if(isset($key->tax_id)) {
							$key->tax = $this->sale_model->getById('tbl_accountledger', $key->tax_id);
						}
						if(isset($key->UOMId)) {
							$key->unit = $this->sale_model->getById('tbl_uom', $key->UOMId);
						}
					}
				}
			}
			$data['currency'] = 'USD';
			$currencyName=$this->reports_model->getOne('tbl_currency',array('company_id'=>$this->company_id));
            if(!empty($currencyName)){
               $data['currency'] =$currencyName->currency_code;
            }
			$data['number'] = isset($model->salesInvoiceNo) ? $model->salesInvoiceNo : null;
			$data['model'] = $model;
			$data['is_preview'] = true;
		  	$data['title'] = 'Sale Invoice';
		  	$data['is_sale'] = true;
			$data['controller_name'] = 'sales';
			$data['barcode']='SI-'.$id.'.png';
			// debug($data);
		   	$this->displayView('accounting/purchases/purchase_report' ,$data,array(),array(
							'js'=>array(),
							'css'=>array(),
						));
		}
	}
	public function printInvoice($id = null, $print = null){
		if($id != null){
			$data['active']='';
			$this->load->model('reports_model');
			$this->load->model('sale_model');
			$model = (object)$this->sale_model->getOne('tbl_salesinvoicemaster', array('salesInvoiceNo' => $id, 'company_id' => $this->company_id));
			if(isset($model->supplierId)) {
				$data['ledger'] = $this->sale_model->getOne('tbl_accountledger', array('id' => $model->supplierId));
			}
			if(isset($model->salesInvoiceNo)) {
				$data['products'] = $this->sale_model->getAll('tbl_salesinvoicedetails', array('salesInvoiceNo' => $model->salesInvoiceNo, 'company_id' => $this->company_id));
				if(!empty($data['products'])) {
					foreach ($data['products'] as &$key) {
						if(isset($key->tax_id)) {
							$key->tax = $this->sale_model->getById('tbl_accountledger', $key->tax_id);
						}
						if(isset($key->UOMId)) {
							$key->unit = $this->sale_model->getById('tbl_uom', $key->UOMId);
						}
					}
				}
			}
			$data['currency'] = 'USD';
			$currencyName=$this->reports_model->getOne('tbl_currency',array('company_id'=>$this->company_id));
            if(!empty($currencyName)){
               $data['currency'] =$currencyName->currency_code;
            }
			$data['number'] = isset($model->salesInvoiceNo) ? $model->salesInvoiceNo : null;
			$data['model'] = $model;
			$data['is_preview'] = true;
		  	$data['title'] = 'Sale Invoice';
		  	$data['active']='Sales Invoice';
		  	$data['is_sale'] = true;
		  	if($print)
		  		$data['is_print'] = true;
			$data['controller_name'] = 'sales';
			$data['barcode']='SI-'.$id.'.png';
			// echo $data['barcode'];
			// exit();
			// debug($data);
			if($print == null) {
				$html = $this->displayView('accounting/purchases/purchase_report' ,$data,array(),array(
							'js'=>array(),
							'css'=>array(),
						), true);
			} else {
		   		$html = $this->displayView('accounting/purchases/purchase_report' ,$data,array('topbar', 'sidenav'),array(
							'js'=>array(),
							'css'=>array(),
						), true);
		   	}
		   	echo $html;
		   	exit();
		 //   	echo $html;die();
			// $this->load->helper(array('mpdf', 'file'));
		 //   	$filename = 'assets/pdf/SaleInvoice_'.$id.'.pdf';
		 //  	if(file_exists($filename))
		 //  		unlink($filename);
		 //   	pdf_create($html, $filename, true);
		 //   	redirect(base_url($filename));
		}
	}
	public function printFullInvoice($id = null) {
		if($this->isLoggedIn()) {
			$data['print'] = true;
			$data['is_print'] = true;
			$data['is_preview'] = true;
			$data['title'] = 'Invoice';
			$id = ($this->input->post('id')) ? $this->input->post('id') : $id;
			$this->load->model('reports_model');
			$this->load->model('sale_model');
			$model = (object)$this->sale_model->getOne('tbl_salesinvoicemaster', array('salesInvoiceNo' => $id, 'company_id' => $this->company_id));
			if(isset($model->supplierId)) {
				$data['ledger'] = $this->sale_model->getOne('tbl_accountledger', array('id' => $model->supplierId));
			}
			$data['currency'] = 'USD';
			$currencyName=$this->reports_model->getOne('tbl_currency',array('company_id'=>$this->company_id));
            if(!empty($currencyName)){
               $data['currency'] =$currencyName->currency_code;
            }
			if(isset($model->salesInvoiceNo)) {
				$data['products'] = $this->sale_model->getAll('tbl_salesinvoicedetails', array('salesInvoiceNo' => $model->salesInvoiceNo, 'company_id' => $this->company_id));
				if(!empty($data['products'])) {
					foreach ($data['products'] as &$key) {
						if(isset($key->tax_id)) {
							$key->tax = $this->sale_model->getById('tbl_accountledger', $key->tax_id);
						}
						if(isset($key->UOMId)) {
							$key->unit = $this->sale_model->getById('tbl_uom', $key->UOMId);
						}
					}
				}
			}
			$data['currency'] = 'USD';
			$currencyName=$this->reports_model->getOne('tbl_currency',array('company_id'=>$this->company_id));
            if(!empty($currencyName)){
               $data['currency'] =$currencyName->currency_code;
            }
			$data['number'] = $model->salesInvoiceNo;
			$data['model'] = $model;
			$data['controller_name'] = 'sales';
			// debug($data);
			$data['is_sale']=true;
			$data['barcode']='SI-'.$id.'.png';
			$invoice  =  $this->displayView('accounting/purchases/purchase_report',$data,array('sidenav', 'topbar'),array(
				'js'=>array(),
				'css'=>array(),
			), true);

			echo $invoice;
			exit();
		}
	}
	public function printMiniReceipt() {
		if($this->isLoggedIn()) {
			$data['print'] = true;
			$data['is_print'] = true;
			$data['title'] = 'Invoice';
			$id = $this->input->post('id');
			$this->load->model('reports_model');
			$this->load->model('sale_model');
			$model = (object)$this->sale_model->getOne('tbl_salesinvoicemaster', array('salesInvoiceNo' => $id, 'company_id' => $this->company_id));
			if(isset($model->supplierId)) {
				$data['ledger'] = $this->sale_model->getOne('tbl_accountledger', array('id' => $model->supplierId));
			}
			$data['currency'] = 'USD';
			$currencyName=$this->reports_model->getOne('tbl_currency',array('company_id'=>$this->company_id));
            if(!empty($currencyName)){
               $data['currency'] =$currencyName->currency_code;
            }
			if(isset($model->salesInvoiceNo)) {
				$data['products'] = $this->sale_model->getAll('tbl_salesinvoicedetails', array('salesInvoiceNo' => $model->salesInvoiceNo, 'company_id' => $this->company_id));
				if(!empty($data['products'])) {
					foreach ($data['products'] as &$key) {
						if(isset($key->tax_id)) {
							$key->tax = $this->sale_model->getById('tbl_accountledger', $key->tax_id);
						}
						if(isset($key->UOMId)) {
							$key->unit = $this->sale_model->getById('tbl_uom', $key->UOMId);
						}
					}
				}
			}
			$data['currency'] = 'USD';
			$currencyName=$this->reports_model->getOne('tbl_currency',array('company_id'=>$this->company_id));
            if(!empty($currencyName)){
               $data['currency'] =$currencyName->currency_code;
            }
			$data['number'] = $model->salesInvoiceNo;
			$data['model'] = $model;
			// debug($data);
			$invoice  =  $this->displayView('accounting/purchases/purchase_receipt',$data,array('sidenav', 'topbar'),array(
				'js'=>array(),
				'css'=>array(),
			), true);
			echo $invoice;
			exit();
		}
	}
	public function printOrder($id = null) {
		if($id != null) {
			$this->load->model('reports_model');
			$this->load->model('sale_model');
			$model = (object)$this->sale_model->getOne('tbl_saleordermaster', array('saleorderNo' => $id, 'company_id' => $this->company_id));
			if(isset($model->supplierId)) {
				$data['ledger'] = $this->sale_model->getOne('tbl_accountledger', array('id' => $model->supplierId));
			}
			if(isset($model->saleorderNo)) {
				$data['products'] = $this->sale_model->getAll('tbl_saleorderdetails', array('saleOrderNo' => $model->saleorderNo, 'company_id' => $this->company_id));
				if(!empty($data['products'])) {
					foreach ($data['products'] as &$key) {
						if(isset($key->tax_id)) {
							$key->tax = $this->sale_model->getById('taxes', $key->tax_id);
						}
						if(isset($key->UOMId)) {
							$key->unit = $this->sale_model->getById('tbl_uom', $key->UOMId);
						}
					}
				}
			}
			$data['currency'] = 'USD';
			$currencyName=$this->reports_model->getOne('tbl_currency',array('company_id'=>$this->company_id));
            if(!empty($currencyName)){
               $data['currency'] =$currencyName->currency_code;
            }
			$data['number'] = $model->saleorderNo;
			$data['model'] = $model;
			$data['is_print'] = true;
			$data['form_title'] = 'Order';
		  	$data['title'] = 'Sale Order';
		  	$data['is_sale'] = true;
			$data['controller_name'] = 'sales';
		   	$html = $this->displayView('accounting/purchases/purchase_report' ,$data,array('topbar', 'sidenav'),array(
							'js'=>array(),
							'css'=>array(),
						), true);
		   	echo $html;
		   	exit();
			$this->load->helper(array('mpdf', 'file'));
		   	$filename = 'assets/pdf/SaleOrder_'.$id.'.pdf';
		  	if(file_exists($filename))
		  		unlink($filename);
		   	pdf_create($html, $filename, true);
		   	redirect(base_url($filename));
		}
		return false;
	}
	public function printQuotation($id = null) {
		if($id != null) {
			$this->load->model('reports_model');
			$this->load->model('sale_model');
			$model = (object)$this->sale_model->getOne('tbl_saleqoutationmaster', array('qoutationNo' => $id, 'company_id' => $this->company_id));
			if(isset($model->supplierId)) {
				$data['ledger'] = $this->sale_model->getOne('tbl_accountledger', array('id' => $model->supplierId));
			}
			if(isset($model->qoutationNo)) {
				$data['products'] = $this->sale_model->getAll('tbl_saleqoutationdetails', array('QuotationNumber' => $model->qoutationNo, 'company_id' => $this->company_id));
				if(!empty($data['products'])) {
					foreach ($data['products'] as &$key) {
						if(isset($key->tax_id)) {
							$key->tax = $this->sale_model->getById('taxes', $key->tax_id);
						}
						if(isset($key->UOMId)) {
							$key->unit = $this->sale_model->getById('tbl_uom', $key->UOMId);
						}
					}
				}
			}
			$data['currency'] = 'USD';
			$currencyName=$this->reports_model->getOne('tbl_currency',array('company_id'=>$this->company_id));
            if(!empty($currencyName)){
               $data['currency'] =$currencyName->currency_code;
            }
			$data['number'] = $model->qoutationNo;
			$data['form_title'] = 'Quotation';
			$data['is_sale'] = true;
			$data['model'] = $model;
			$data['is_print'] = true;
			$data['controller_name'] = 'sales';
		  	$data['title'] = 'Purchase Quotation';
		  	// $html = $this->load->view('accounting/purchases/purchase_report', $data, true);
		   	$html = $this->displayView('accounting/purchases/purchase_report' ,$data,array( 'topbar', 'sidenav'),array(
							'js'=>array(),
							'css'=>array(),
						), true);
		   	echo $html;
		   	exit();
			$this->load->helper(array('mpdf', 'file'));
		   	$filename = 'assets/pdf/PurchaseQuotation_'.$id.'.pdf';
		  	if(file_exists($filename))
		  		unlink($filename);
		   	pdf_create($html, $filename, true);
		   	redirect(base_url($filename));
		}
		return false;
	}
	public function getProducts($id=null){
		if($id!=null){
			$data=$this->sale_model->getStockFromProducts($id);
			if(!empty($data)){
				echo json_encode($data);exit();
			}
		}
	}
	public function getLiveCustomers(){
		if(!empty($this->input->get("q"))){
			$data=$this->sale_model->searchCustomers($this->input->get("q"));
			echo json_encode($data);exit();
		}
	}
	public function getLiveProducts(){
		// if(!empty($this->input->get("q"))){
		// 	$data=$this->sale_model->liveCheckStockFromProducts($this->input->get("q"));
		// 	echo json_encode($data);exit();
		// }

	}
	public function add_payment($addPayment=array(), $ledgerId = null, $invoiceNo = null, $return_amount = 0){
		$this->sale_model->delete('add_payment', array('company_id' => $this->company_id, 'salesInvoiceNo' => $invoiceNo));
		if(!empty($addPayment)){
			$return_payment = null;
			foreach ($addPayment as $key => $value) {
				$value['company_id']=$this->company_id;
				if($ledgerId != null)
					$value['ledger_id'] = $ledgerId;
				if($invoiceNo != null)
					$value['salesInvoiceNo'] = $invoiceNo;
				if($key == 0) {
					$return_payment = $value;
				}
				$this->sale_model->add('add_payment',$value);
				if(isset($value['method']) && $value['method'] == 'Gift Card') {
					if(isset($value['card_id']) && $value['card_id'] > 0) {
						$payment = (float)$value['payment_value'];
						$this->sale_model->universal("UPDATE tbl_gift_cards SET value = value - $payment WHERE id = ".$value['card_id']);
					}
				}
			}
			if($return_payment != null && $return_amount != 0) {
				unset($return_payment['card_id']);
				$return_payment['is_return'] = 1;
				$return_payment['payment_value'] = (float)$return_amount;
				$method = $this->sale_model->getOne('tbl_payment_methods', array('company_id' => $this->company_id, 'name' => 'Cash'));
				if(isset($method->id)) {
					$return_payment['method_id'] = $method->id;
					$return_payment['method'] = $method->name;
					$return_payment['payment_method'] = $method->name.' (Return)';
				}
				$this->sale_model->add('add_payment',$return_payment);
			}
			// $addPayment['payment_value']=$this->input->post('payment_value');
			// $addPayment['sale_invoice_no']=$this->input->post('sale_invoice_no');
			// $addPayment['customer_id']=$this->input->post('customer_id');
			// $addPayment['payment_method']=$this->input->post('payment_method');
			// $addPayment['company_id']=$this->company_id;
		}
	}
	public function getSaleInvoiceNumber($customer_id=null){
		if($customer_id!=null){
			$query="SELECT salesInvoiceNo FROM tbl_salesinvoicemaster WHERE customerId = $customer_id AND company_id=".$this->company_id;
			$data=$this->sale_model->universal($query)->result();
			if(!empty($data)){
				echo json_encode($data);exit();
			}
		}
	}
	public function get_pos_invoices(){
		if(!empty($this->input->get("q"))){
			$data=$this->sale_model->getSaleInvoices($this->input->get("q"));
			echo json_encode($data);exit();
		}
	}
}