<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
require_once(APPPATH."controllers/accounting/ERPController.php");
class Purchases extends ERPController{
	function __construct(){
		parent::__construct();
		if(!$this->isLoggedIn()){
			redirect('auth');
		}
		$this->load->model('company_model');
		$this->load->model('settings_model');
		$this->load->model('purchase_model');
		$this->load->library('products/products_list');
		$this->load->library('color_list');
	}
	public function searchProduct($type=null){
		if($this->isLoggedIn()){
				if($type=='ng'){
				}else{
					if($this->input->post('id')){
						$id= $this->input->post('id');
						$company_id=$this->session->userdata('company_id');
						$query="SELECT * FROM tbl_product WHERE company_id = $company_id AND  (id='".$id."' OR barcode='".$id."') AND isActive = 1";
					    $result=$this->purchase_model->universal($query)->row();
					    // if(isset($result->id)){
					    // 	$result->units = $this->purchase_model->universal("SELECT * FROM tbl_uom WHERE id IN(SELECT UOMId FROM tbl_purchasepricelist WHERE company_id = $company_id AND productName = $result->id)")->result();
					    // }
					    if(isset($result->size_mode))
					    {
					    	if($result->size_mode == 1)
					    	{
					    		$result->size=array('0','2','4','6','8','10','12','14','16','18','20','22');
					    	}
					    	if($result->size_mode == 0)
					    	{
					    		$result->size=array('s','m','l','xl','xxl','xl1','xl2');
					    	}
					    	if($result->size_mode == 2)
					    	{
					    		$result->size=array('prepack1221');
					    	}
					    	if($result->size_mode == 3)
					    	{
					    		$size_mode_3 = array('sm','ml');
					    	}
					    	if($result->size_mode == 4)
					    	{
					    		$size_mode_4 = array('onesizefitsall');
					    	}

					    }
						echo json_encode($result);
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
						$query="SELECT * FROM tbl_purchasepricelist WHERE company_id = $company_id AND productName=$productId AND UOMId = $uomid";
						$result=$this->purchase_model->universal($query)->row();
						echo json_encode($result);
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
						$product_id=$this->input->post('product_id');
						$array1=$this->purchase_model->getAll('tbl_product',array('isActive' => 1,'company_id'=>$this->session->userdata('company_id')));
						if($product_id > 0){
							$query="SELECT * FROM tbl_uom WHERE company_id=$this->company_id AND id NOT IN (SELECT UOMId FROM tbl_purchasepricelist WHERE productName=$product_id)";
							$array2=$this->common_model->universal($query)->result();

						}else{
							$array2=$this->purchase_model->getAll('tbl_uom',array('company_id' => $this->company_id));
						}
						$apply_tax = $this->common_model->getOne('tbl_apply_taxes', array('company_id' => $this->company_id, 'voucher_type' => 'purchase'));
						$taxes = array();
						if(isset($apply_tax->taxes) && $apply_tax->taxes != '') {
							$taxes = $this->purchase_model->getAll('tbl_accountledger', "product_bill = 'product' AND company_id = ".$this->company_id." AND id IN (".$apply_tax->taxes.")");
						}
						echo json_encode(array('products' => $array1, 'units' => $array2, 'taxes' => $taxes));exit();
					}
				
		}else{
			redirect('auth');
		}
	}
	public function purchaseQuotation($type = null) {
		if($this->isLoggedIn()){
				if($type=='ng'){
				}else{
					$data['active']='Purchase Quotation';
					$data['module']='accounting';
					$data['purchaseQuotationMaster']=$this->purchase_model->getAll('tbl_purchaseqoutationmaster',array('company_id'=>$this->session->userdata('company_id')), array('created_on','desc'));
					$this->displayView('accounting/purchases/purchase_quotation_listing',$data,array(),array(
							'js'=>array(),
							'css'=>array(),
						));
				}
		}else{
			redirect('auth');
		}
	}
	public function addPurchaseQuotation($qoutationNo=null,$type = null){
		if($this->isLoggedIn()){
				if($type=='ng'){
				}else{
					   $data['active']='Purchase Quotation';
					   $data['module']='accounting';
					   if($this->input->server('REQUEST_METHOD')==='POST'){
					   	  $dateActiveYear=date('Y-m-d',strtotime($this->input->post('deliveryDate')));
					   	  $activeYear=$this->purchase_model->getOne('tbl_financialyear',array('isActive'=>1,'company_id'=>$this->session->userdata('company_id')));
					   	  if(!empty($activeYear)){
					   	  if($dateActiveYear >= $activeYear->fromDate && $dateActiveYear <= $activeYear->toDate){
					   	  	  $company_id=$this->session->userdata('company_id');
						   	  $query="SELECT COUNT(id) AS total FROM tbl_purchaseqoutationmaster WHERE company_id = $company_id";
						   	  $quotationNo=$this->purchase_model->universal($query)->row()->total;
						   	  $quotationNo=sprintf("%0".$this->voucher_number_length."d",$quotationNo+1);
							  $purchaseQuotationMaster=array(
							  		'qoutationNo'=>$quotationNo,
							  		'company_id'=>$company_id,
							  		'supplierId'=>$this->input->post('supplierId'),
							  		'salesmanId'=>$this->input->post('salesmanId'),
							  		'currencyId'=>$this->input->post('currencyId'),
							  		'deliveryDate'=>date('Y-m-d',strtotime($this->input->post('deliveryDate'))),
							  		'status'=>0,
							  		'isApproved'=>1,
							  		'printAfterSave'=>$this->input->post('purchaseOrderisprintAfterSave'),
							  		'subtotal'=>deformat_value($this->input->post('subtotal')),
							  		'discount'=>deformat_value($this->input->post('discount')),
							  		'discount_type'=>$this->input->post('discount_type'),
							  		'freight'=>deformat_value($this->input->post('freight')),
							  		'tax'=>$this->input->post('tax'),
							  		'total'=>deformat_value($this->input->post('total')),
							  		'narration'=>$this->input->post('narration'),
							  	);
							  $purchaseQuotationMaster['created_on'] =  date('Y-m-d H:i:s', strtotime($purchaseQuotationMaster['deliveryDate'].' '.date('H:i:s')));
							  $products=$this->input->post('product');
							  $savedInpurchaseQuotationmaster=$this->purchase_model->add('tbl_purchaseqoutationmaster',$purchaseQuotationMaster);
							  if($savedInpurchaseQuotationmaster > 0){
								  	foreach($products as $values){
								  		if(isset($values['unit_discount']))
									  	 	$values['unit_discount'] = deformat_value($values['unit_discount']);
									  	 if(isset($values['rate']))
									  	 	$values['rate'] = deformat_value($values['rate']);
									  	 if(isset($values['amount']))
									  	 	$values['amount'] = deformat_value($values['amount']);
								  	 $values['qoutationNo']=$quotationNo;
								  	 $values['company_id']=$this->session->userdata('company_id');
		                          	 $savedInpurchaseQuotationDetail=$this->purchase_model->add('tbl_purchaseqoutationdetails',$values);
		                          }
		                          if($this->input->post('save_print')) {
								   		if(isset($quotationNo) && $quotationNo > 0) {
								   			$this->session->set_flashdata('print_purchase_quotation', $quotationNo);
								   			// $this->printQuotation($quotationNo);
								   		}
								   	}	
		                          if($savedInpurchaseQuotationDetail > 0){
		                          	$this->session->set_flashdata('success', con_lang('mass_purchase_quotation_added_sccessfully'));
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
						$data['model']=(array)$this->purchase_model->getByIdPurchaseQuotation(decode_uri($qoutationNo)); 
						$data['edit_purchase'] = true;
					}
					$company_id=$this->session->userdata('company_id');
					$data['company_id']	= $company_id;
					if($qoutationNo==null){
						$query="SELECT COUNT(id) AS TotalRecord FROM tbl_purchaseqoutationmaster WHERE company_id = $company_id";
						$data['totalQuotation']=$this->purchase_model->universal($query)->row()->TotalRecord+1;
					}
					// $data['taxesOnBill']=$this->purchase_model->getAll('tbl_accountledger',array('product_bill'=>'bill','company_id'=>$this->company_id, 'accountGroupId' => 20));
					$apply_tax = $this->common_model->getOne('tbl_apply_taxes', array('company_id' => $this->company_id, 'voucher_type' => 'purchase'));
					if(isset($apply_tax->taxes) && $apply_tax->taxes != '') {
						$data['product_taxes'] = $this->purchase_model->getAll('tbl_accountledger', "product_bill = 'product' AND company_id = ".$this->company_id." AND id IN (".$apply_tax->taxes.")");
						$data['taxesOnBill'] = $this->purchase_model->getAll('tbl_accountledger', "product_bill = 'bill' AND company_id = ".$this->company_id." AND id IN (".$apply_tax->taxes.")");
					}
				    $this->displayView('accounting/purchases/purchase_quotation',$data,array(),array(
						'js'=>array(),
						'css'=>array(),
					));
				}
		}else{
			redirect('auth');
		}
	}
	public function printReturn($id = null) {
		if($id != null) {
			$this->load->model('reports_model');
			$this->load->model('purchase_model');
			$model = (object)$this->purchase_model->getOne('tbl_purchasereturnmaster', array('id' => $id, 'company_id' => $this->company_id));
			if(isset($model->supplierId)) {
				$data['ledger'] = $this->purchase_model->getOne('tbl_accountledger', array('id' => $model->supplierId));
			}
			if(isset($model->purchaseInvoiceNo)) {
				$data['products'] = $this->purchase_model->getAll('tbl_purchasereturndetail', array('purchaseInvoiceId' => $model->purchaseInvoiceNo, 'company_id' => $this->company_id));
				if(!empty($data['products'])) {
					foreach ($data['products'] as &$key) {
						if(isset($key->tax_id)) {
							$tax_amount=0;
							$texes_data=$this->purchase_model->getOne('tbl_accountledger',array('id'=>$key->tax_id));
							if(isset($texes_data->tax_symbal) && isset($key->rate) && isset($texes_data->tax_value) &&  $texes_data->tax_symbal == '%'){
								$tax_amount=(float)($key->rate/100 * $texes_data->tax_value);
								$tax_amount=isset($tax_amount) ? $tax_amount :0;
							}else{
								$tax_amount=isset($texes_data->tax_value) ? $texes_data->tax_value:0;
							}
							$key->taxAmount=$tax_amount;
						}
						if(isset($key->UOMId)) {
							$key->unit = $this->purchase_model->getById('tbl_uom', $key->UOMId);
						}
						if(isset($key->product_id)){
							$products_detail=$this->purchase_model->getOne('tbl_product',array('id'=>$key->product_id));
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
			$data['is_print'] = true;
		  	$data['title'] = 'Purchase Return';
		  	$data['form_title'] = 'Return';
		  	$data['controller_name'] = 'purchases';
		   	$html = $this->displayView('accounting/purchases/purchase_report' ,$data,array('topbar', 'sidenav'),array(
							'js'=>array(),
							'css'=>array(),
						), true);
		   	echo $html;
		   	exit();
			$this->load->helper(array('mpdf', 'file'));
		   	$filename = 'assets/pdf/PurchaseReturn_'.$id.'.pdf';
		  	if(file_exists($filename))
		  		unlink($filename);

		   	pdf_create($html, $filename, true);
		   	redirect(base_url($filename));
		}
		return false;
	}
	public function printInvoice($id = null, $print = null) {
		if($id != null) {
			$this->load->model('reports_model');
			$this->load->model('purchase_model');
			$model = (object)$this->purchase_model->getOne('tbl_purchaseinvoicemaster', array('purchaseInvoiceNo' => $id, 'company_id' => $this->company_id));
			if(isset($model->supplierId)) {
				$data['ledger'] = $this->purchase_model->getOne('tbl_accountledger', array('id' => $model->supplierId));
			}
			if(isset($model->purchaseInvoiceNo)) {
				$data['products'] = $this->purchase_model->getAll('tbl_purchaseinvoicedetails', array('purchaseInvoiceId' => $model->purchaseInvoiceNo, 'company_id' => $this->company_id));
				if(!empty($data['products'])) {
					foreach ($data['products'] as &$key) {
						if(isset($key->tax_id)) {
							$key->tax = $this->purchase_model->getById('tbl_accountledger', $key->tax_id);
						}
						if(isset($key->UOMId)) {
							$key->unit = $this->purchase_model->getById('tbl_uom', $key->UOMId);
						}
					}
				}
			}
			$data['active']='Purchase Invoice';
			$data['currency'] = 'USD';
			$data['controller_name'] = 'purchases';
			$currencyName=$this->reports_model->getOne('tbl_currency',array('company_id'=>$this->company_id));
            if(!empty($currencyName)){
               $data['currency'] =$currencyName->currency_code;
            }
			$data['number'] = $id;
			$data['model'] = $model;
			$data['is_preview'] = true;
			if($print)
		  		$data['is_print'] = true;
		  	$data['title'] = 'Purchase Invoice';
			$data['barcode']='PI-'.sprintf("%0".$this->voucher_number_length."d",$id).'.png';
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
			$this->load->helper(array('mpdf', 'file'));
		   	$filename = 'assets/erp/pdf/PurchaseInvoice_'.$id.'.pdf';
		  	if(file_exists($filename))
		  		unlink($filename);

		   	pdf_create($html, $filename, true);
		   	redirect(base_url($filename));
		}
		return false;
	}
	public function printFullInvoice() {
		if($this->isLoggedIn()) {
			$data['print'] = true;
			$data['is_preview'] = true;
			$data['is_print'] = true;
			$data['title'] = 'Invoice';
			$id = $this->input->post('id');
			$this->load->model('reports_model');
			$this->load->model('purchase_model');
			$model = (object)$this->purchase_model->getOne('tbl_purchaseinvoicemaster', array('purchaseInvoiceNo' => $id, 'company_id' => $this->company_id));
			if(isset($model->supplierId)) {
				$data['ledger'] = $this->purchase_model->getOne('tbl_accountledger', array('id' => $model->supplierId));
			}
			$data['currency'] = 'USD';
			$currencyName=$this->reports_model->getOne('tbl_currency',array('company_id'=>$this->company_id));
            if(!empty($currencyName)){
               $data['currency'] =$currencyName->currency_code;
            }
			if(isset($model->purchaseInvoiceNo)) {
				$data['products'] = $this->purchase_model->getAll('tbl_purchaseinvoicedetails', array('purchaseInvoiceId' => $model->purchaseInvoiceNo, 'company_id' => $this->company_id));
				if(!empty($data['products'])) {
					foreach ($data['products'] as &$key) {
						if(isset($key->tax_id)) {
							$key->tax = $this->purchase_model->getById('tbl_accountledger', $key->tax_id);
						}
						if(isset($key->UOMId)) {
							$key->unit = $this->purchase_model->getById('tbl_uom', $key->UOMId);
						}
					}
				}
			}
			$data['currency'] = 'USD';
			$currencyName=$this->reports_model->getOne('tbl_currency',array('company_id'=>$this->company_id));
            if(!empty($currencyName)){
               $data['currency'] =$currencyName->currency_code;
            }
			$data['number'] = $model->purchaseInvoiceNo;
			$data['model'] = $model;
			$data['controller_name'] = 'purchases';
			$data['barcode']='PI-'.sprintf("%0".$this->voucher_number_length."d",$id).'.png';
			$invoice  =  $this->displayView('accounting/purchases/purchase_report',$data,array('sidenav', 'topbar'),array(
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
			$this->load->model('purchase_model');
			$model = (object)$this->purchase_model->getOne('tbl_purchaseordermaster', array('purchaseOrderNo' => $id, 'company_id' => $this->company_id));
			if(isset($model->supplierId)) {
				$data['ledger'] = $this->purchase_model->getOne('tbl_accountledger', array('id' => $model->supplierId));
			}
			if(isset($model->purchaseOrderNo)) {
				$data['products'] = $this->purchase_model->getAll('tbl_purchaseorderdetails', array('purchaseOrderId' => $model->purchaseOrderNo, 'company_id' => $this->company_id));
				if(!empty($data['products'])) {
					foreach ($data['products'] as &$key) {
						if(isset($key->tax_id)) {
							$key->tax = $this->purchase_model->getById('taxes', $key->tax_id);
						}
						if(isset($key->UOMId)) {
							$key->unit = $this->purchase_model->getById('tbl_uom', $key->UOMId);
						}
					}
				}
			}
			$data['currency'] = 'USD';
			$currencyName=$this->reports_model->getOne('tbl_currency',array('company_id'=>$this->company_id));
            if(!empty($currencyName)){
               $data['currency'] =$currencyName->currency_code;
            }
			$data['number'] = $model->purchaseOrderNo;
			$data['model'] = $model;
			$data['is_print'] = true;
		  	$data['title'] = 'Purchase Order';
		  	$data['form_title'] = 'Order';
		  	$data['controller_name'] = 'purchases';
		   	$html = $this->displayView('accounting/purchases/purchase_report' ,$data,array('topbar', 'sidenav'),array(
							'js'=>array(),
							'css'=>array(),
						), true);
		   	echo $html;
		   	exit();
			$this->load->helper(array('mpdf', 'file'));
		   	$filename = 'assets/pdf/PurchaseOrder_'.$id.'.pdf';
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
			$this->load->model('purchase_model');
			$model = (object)$this->purchase_model->getOne('tbl_purchaseqoutationmaster', array('qoutationNo' => $id, 'company_id' => $this->company_id));
			if(isset($model->supplierId)) {
				$data['ledger'] = $this->purchase_model->getOne('tbl_accountledger', array('id' => $model->supplierId));
			}
			if(isset($model->qoutationNo)) {
				$data['products'] = $this->purchase_model->getAll('tbl_purchaseqoutationdetails', array('qoutationNo' => $model->qoutationNo, 'company_id' => $this->company_id));
				if(!empty($data['products'])) {
					foreach ($data['products'] as &$key) {
						if(isset($key->tax_id)) {
							$key->tax = $this->purchase_model->getById('taxes', $key->tax_id);
						}
						if(isset($key->UOMId)) {
							$key->unit = $this->purchase_model->getById('tbl_uom', $key->UOMId);
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
			$data['model'] = $model;
			$data['is_print'] = true;
		  	$data['title'] = 'Purchase Quotation';
		  	$data['form_title'] = 'Quotation';
		  	$data['controller_name'] = 'purchases';
		   	$html = $this->displayView('accounting/purchases/purchase_report' ,$data,array('topbar', 'sidenav'),array(
							'js'=>array(),
							'css'=>array(),
						), true);
		  	echo $html;
		  	exit();
		   	// echo $html;exit();
			$this->load->helper(array('mpdf', 'file'));
		   	$filename = 'assets/pdf/PurchaseQuotation_'.$id.'.pdf';

		  	if(file_exists($filename))
		  		unlink($filename);
		   	// pdf_create($html, $filename, true);
		   	// redirect(base_url($filename));
		}
		return false;
	}
	public function deleteQuotation($qoutationNo=null,$type=null){
		if($this->isLoggedIn()){
			if($type=='ng'){
			}else{
				$delete=$this->common_model->delete('tbl_purchaseqoutationmaster',array('qoutationNo'=>$qoutationNo));
				if($delete){
					$delete2=$this->common_model->delete('tbl_purchaseqoutationdetails',array('qoutationNo'=>$qoutationNo));
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
	public function editPurchaseQuotation($qoutationNo=null,$type=null){
				if($this->isLoggedIn()){
					if($type!=null){
					}else{
						if($this->input->server('REQUEST_METHOD')==='POST'){
							 $purchaseQuotationMaster=array(
						  		'qoutationNo'=>$this->input->post('qoutationNo'),
						  		'company_id'=>$this->session->userdata('company_id'),
						  		'supplierId'=>$this->input->post('supplierId'),
						  		'salesmanId'=>$this->input->post('salesmanId'),
						  		'currencyId'=>$this->input->post('currencyId'),
						  		'deliveryDate'=>date('Y-m-d',strtotime($this->input->post('deliveryDate'))),
						  		'status'=>$this->input->post('purchaseOrderstatus'),
						  		'isApproved'=>1,
						  		'printAfterSave'=>$this->input->post('purchaseOrderisprintAfterSave'),
						  		'subtotal'=>deformat_value($this->input->post('subtotal')),
						  		'discount'=>deformat_value($this->input->post('discount')),
						  		'discount_type'=>$this->input->post('discount_type'),
						  		'freight'=>deformat_value($this->input->post('freight')),
						  		'tax'=>$this->input->post('tax'),
						  		'total'=>deformat_value($this->input->post('total')),
						  		'narration'=>$this->input->post('narration'),
						  	);
							  $products=$this->input->post('product');
							   // debug($products);
							  $updateInpurchaseQuotationmaster=$this->purchase_model->update('tbl_purchaseqoutationmaster',array('qoutationNo'=>$this->input->post('qoutationNo')),$purchaseQuotationMaster);
							  if($updateInpurchaseQuotationmaster){
								  	foreach($products as $values){
								  		if(isset($values['unit_discount']))
									  	 	$values['unit_discount'] = deformat_value($values['unit_discount']);
									  	 if(isset($values['rate']))
									  	 	$values['rate'] = deformat_value($values['rate']);
									  	 if(isset($values['amount']))
									  	 	$values['amount'] = deformat_value($values['amount']);
									  	$productsId=isset($values['id']) ? $values['id'] :'';
									  	if($productsId!=''){
			                          	 $upodateInpurchaseQuotationDetail=$this->purchase_model->update('tbl_purchaseqoutationdetails',array('qoutationNo'=>$this->input->post('qoutationNo'),'id'=>$productsId),$values);
									  	}else{
									  		 $values['qoutationNo']=$this->input->post('qoutationNo');
									  		 $values['company_id']=$this->session->userdata('company_id');
									  		 $savedInpurchaseQuotationDetail=$this->purchase_model->add('tbl_purchaseqoutationdetails',$values);
									  	}
		                          }
		                          if($this->input->post('save_print')) {
							  	$savedInpurchaseQuotationmaster = $this->input->post('qoutationNo');
							   		if(isset($savedInpurchaseQuotationmaster) && $savedInpurchaseQuotationmaster > 0) {
							   			$this->session->set_flashdata('print_purchase_quotation', $savedInpurchaseQuotationmaster);
							   			// $this->printQuotation($savedInpurchaseQuotationmaster);
							   		}
							   	}	
		                          if($upodateInpurchaseQuotationDetail){
		                          	$this->session->set_flashdata('success',con_lang('mass_purchase_quotation_update_successfully'));
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
	public function purchaseOrder($type = null){
		if($this->isLoggedIn()){
				if($type=='ng'){
				}else{
					$data['active']='Purchase Orders';
					$data['module']='accounting';
					$data['purchaseOrderMaster']=$this->purchase_model->getAll('tbl_purchaseordermaster',array('company_id'=>$this->session->userdata('company_id')),  array('created_on','desc'));
					$this->displayView('accounting/purchases/purchase_order_listing',$data,array(),array(
							'js'=>array(),
							'css'=>array(),
						));
				}
		}else{
			redirect('auth');
		}
	}
	public function addPurchaseOrder($purchaseOrderNo=null,$type = null){
		if($this->isLoggedIn()){
				if($type=='ng'){
				}else{
					   $data['active']='Purchase Orders';
					   $data['module']='accounting';
					   $data['all_products']=$this->products_list->select();
					   if(!empty($data['all_products']))
					   {
						   	foreach($data['all_products'] as $key=>$prod)
						   	{
						   		if(isset($prod->st_id))
						   		{
						   			$check_product=$this->common_model->getOne('tbl_product',array('prod_id'=>$prod->st_id));
					   				$product_data['prod_id']=$prod->st_id;
					   				$product_data['company_id']=$this->session->userdata('company_id');
					   				$product_data['productCode']=isset($prod->prod_no) ? $prod->prod_no:'';
					   				$product_data['productName']=isset($prod->prod_name) ? $prod->prod_name:'';
					   				$product_data['product_code']=isset($prod->prod_no) ? $prod->prod_no:'';
					   				$product_data['size_mode']=isset($prod->size_mode) ? $prod->size_mode:'';
					   				$product_data['vendor_code']=isset($prod->vendor_code) ? $prod->vendor_code:'';
					   				$product_data['vendor_name']=isset($prod->vendor_name) ? $prod->vendor_name:'';
					   				$product_data['color_code']=isset($prod->color_code) ? $prod->color_code:'';
					   				$product_data['purchaseRate']=isset($prod->wholesale_price) ? (float)($prod->wholesale_price/3):'';
					   				$product_data['salesRate']=isset($prod->wholesale_price) ? $prod->wholesale_price:'';
					   				$barcode_code='';
                                    if(isset($prod->prod_no))
                                    {
                                        $barcode_code.=$prod->prod_no;
                                    }
                                    if(isset($prod->color_code))
                                    {
                                        $barcode_code.='_'.$prod->color_code;
                                    }
                                    if(isset($prod->vendor_code))
                                    {
                                        $barcode_code.='_'.$prod->vendor_code;
                                    }
                                    if(isset($barcode_code) && $barcode_code){
                                    	$product_data['barcode']=$barcode_code;
                                    }
						   			if(empty($check_product))
						   			{
						   				$this->common_model->add('tbl_product',$product_data);
						   			}
						   			else
						   			{
						   				$this->common_model->update('tbl_product',array('id'=>$check_product->id),$product_data);
						   			}
						   		}
						   	}
					   }
					   // debug($data['all_products']);
					   if($this->input->server('REQUEST_METHOD') === 'POST'){
					   	$dateActiveYear=date('Y-m-d',strtotime($this->input->post('deliveryDate')));

					   	  $activeYear=$this->purchase_model->getOne('tbl_financialyear',array('isActive'=>1, 'company_id' => $this->company_id));
	
					   	  if(!empty($activeYear)){
					   	  if($dateActiveYear >= $activeYear->fromDate && $dateActiveYear <= $activeYear->toDate){
					   	$purchase_quotation=$this->input->post('purchase_quotation');
						  $purchaseOrderMaster=array(
						  		'purchaseOrderNo'=>sprintf("%0".$this->voucher_number_length."d",$this->input->post('purchaseOrderNo')),
						  		'company_id'=>$this->session->userdata('company_id'),
						  		'purchase_quotation'=>$this->input->post('purchase_quotation'),
						  		'supplierId'=>$this->input->post('supplierId'),
						  		'salesmanId'=>$this->input->post('salesmanId'),
						  		'currencyId'=>$this->input->post('currencyId'),
						  		'deliveryDate'=>date('Y-m-d',strtotime($this->input->post('deliveryDate'))),
						  		'purchaseOrderstatus'=>0,
						  		'purchaseOrderisApproved'=>$this->input->post('isApproved'),
						  		'purchaseOrderisprintAfterSave'=>$this->input->post('purchaseOrderisprintAfterSave'),
						  		'subtotal'=>deformat_value($this->input->post('subtotal')),
						  		'discount'=>deformat_value($this->input->post('discount')),
						  		'discount_type' => $this->input->post('discount_type'),
						  		'freight'=>deformat_value($this->input->post('freight')),
						  		'tax'=>$this->input->post('tax'),
						  		'total'=>deformat_value($this->input->post('total')),
						  		'purchaseOrderNarration'=>$this->input->post('narration'),
						  	);
						  $purchaseOrderMaster['created_on'] =  date('Y-m-d H:i:s', strtotime($purchaseOrderMaster['deliveryDate'].' '.date('H:i:s')));
						  $products=$this->input->post('product');
						  $savedInpurchaseOrderMaster=$this->purchase_model->add('tbl_purchaseordermaster',$purchaseOrderMaster);
						  if($savedInpurchaseOrderMaster > 0){
						  		$update=$this->purchase_model->update('tbl_purchaseqoutationmaster',array('qoutationNo'=>$purchase_quotation),array('status'=>1));
							  	foreach($products as $values){
							  		unset($values['color_code']);
							  		unset($values['vendor_code']);
							  		unset($values['size']);
							  	 if(isset($values['unit_discount']))
							  	 	$values['unit_discount'] = deformat_value($values['unit_discount']);
							  	 if(isset($values['rate']))
							  	 	$values['rate'] = deformat_value($values['rate']);
							  	 if(isset($values['amount']))
							  	 	$values['amount'] = deformat_value($values['amount']);
							  	 $values['purchaseOrderId']=sprintf("%0".$this->voucher_number_length."d",$this->input->post('purchaseOrderNo'));
							  	 $values['company_id']=$this->session->userdata('company_id');
	                          	 $savedInpurchaseOrderDetail=$this->purchase_model->add('tbl_purchaseorderdetails',$values);
	                          }
	                        if($this->input->post('save_print')) {
	                        	$orderNo = $this->input->post('purchaseOrderNo');
						   		if(isset($orderNo) && $orderNo > 0) {
						   			$this->session->set_flashdata('print_purchase_order', $orderNo);
						   			// $this->printOrder($orderNo);
						   		}
						   	}
	                          if($savedInpurchaseOrderDetail > 0){
	                          	$this->session->set_flashdata('success',con_lang('mass_purchase_order_added_successfully'));
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
					if($purchaseOrderNo!=null){
						$data['model']=(array)$this->purchase_model->getByIdPurchaseOrder(decode_uri($purchaseOrderNo));
						$data['edit_purchase'] = true;
						// debug($data['model']);
					}
					$company_id=$this->session->userdata('company_id');
					$data['company_id'] = $company_id;
					if($purchaseOrderNo==null){
						$query="SELECT COUNT(id) AS TotalRecord FROM tbl_purchaseordermaster WHERE company_id=$company_id";
						$data['totalPurchaseOrders']=$this->purchase_model->universal($query)->row()->TotalRecord+1;
						
					}
					$apply_tax = $this->common_model->getOne('tbl_apply_taxes', array('company_id' => $this->company_id, 'voucher_type' => 'purchase'));
					if(isset($apply_tax->taxes) && $apply_tax->taxes != '') {
						$data['product_taxes'] = $this->purchase_model->getAll('tbl_accountledger', "product_bill = 'product' AND company_id = ".$this->company_id." AND id IN (".$apply_tax->taxes.")");
						$data['taxesOnBill'] = $this->purchase_model->getAll('tbl_accountledger', "product_bill = 'bill' AND company_id = ".$this->company_id." AND id IN (".$apply_tax->taxes.")");
					}
					$data['currency']=$this->purchase_model->getCurrency();
					// $data['taxesOnBill']=$this->purchase_model->getAll('tbl_accountledger',array('product_bill'=>'bill','company_id'=>$this->company_id, 'accountGroupId' => 20));
				    $this->displayView('accounting/purchases/purchase_order',$data,array(),array(
						'js'=>array(),
						'css'=>array(),
					));
				}
		}else{
			redirect('auth');
		}
	}
	public function editPurchaseOrder($purchaseOrderNo=null,$type=null){
				if($this->isLoggedIn()){
					if($type!=null){
					}else{
						if($this->input->server('REQUEST_METHOD')==='POST'){
							 $purchaseOrderMaster=array(
						  		'purchaseOrderNo'=>$this->input->post('purchaseOrderNo'),
						  		'purchase_quotation'=>$this->input->post('purchase_quotation'),
						  		'company_id'=>$this->session->userdata('company_id'),
						  		'supplierId'=>$this->input->post('supplierId'),
						  		'salesmanId'=>$this->input->post('salesmanId'),
						  		'currencyId'=>$this->input->post('currencyId'),
						  		'deliveryDate'=>date('Y-m-d',strtotime($this->input->post('deliveryDate'))),
						  		'purchaseOrderstatus'=>$this->input->post('purchaseOrderstatus'),
						  		'purchaseOrderisApproved'=>$this->input->post('isApproved'),
						  		'purchaseOrderisprintAfterSave'=>$this->input->post('purchaseOrderisprintAfterSave'),
						  		'subtotal'=>deformat_value($this->input->post('subtotal')),
						  		'discount'=>deformat_value($this->input->post('discount')),
						  		'discount_type'=>$this->input->post('discount_type'),
						  		'freight'=>deformat_value($this->input->post('freight')),
						  		'tax'=>$this->input->post('tax'),
						  		'total'=>deformat_value($this->input->post('total')),
						  		'purchaseOrderNarration'=>$this->input->post('narration'),
						  	);
							 
							  $products=$this->input->post('product');
							  $updateInpurchaseOrdermaster=$this->purchase_model->update('tbl_purchaseordermaster',array('purchaseOrderNo'=>$this->input->post('purchaseOrderNo')),$purchaseOrderMaster);
							  if($updateInpurchaseOrdermaster){
								  	foreach($products as $values){
								  		unset($values['color_code']);
								  		unset($values['vendor_code']);
								  		unset($values['size']);
								  		if(isset($values['unit_discount']))
									  	 	$values['unit_discount'] = deformat_value($values['unit_discount']);
									  	 if(isset($values['rate']))
									  	 	$values['rate'] = deformat_value($values['rate']);
									  	 if(isset($values['amount']))
									  	 	$values['amount'] = deformat_value($values['amount']);
									  	$productsId=isset($values['id']) ? $values['id']:'';
									  	if($productsId!=''){
			                          	 $upodateInpurchaseOrderDetail=$this->purchase_model->update('tbl_purchaseorderdetails',array('purchaseOrderId'=>$this->input->post('purchaseOrderNo'),'id'=>$productsId),$values);
									  	}else{
									  		$values['company_id']=$this->session->userdata('company_id');
									  		 $values['purchaseOrderId']=$this->input->post('purchaseOrderNo');
									  		 $savedInpurchaseOrderDetail=$this->purchase_model->add('tbl_purchaseorderdetails',$values);
									  	}
		                          }
		                          if($this->input->post('save_print')){
			                        	$orderNo = $this->input->post('purchaseOrderNo');
								   		if(isset($orderNo) && $orderNo > 0) {
								   			$this->session->set_flashdata('print_purchase_order', $orderNo);
								   			// $this->printOrder($orderNo);
								   		}
								  }
		                          if($upodateInpurchaseOrderDetail){
		                          	$this->session->set_flashdata('success',con_lang('mass_purchase_order_update_successfully'));
		                          	redirect($_SERVER['HTTP_REFERER']);
		                          }else{
		                          		$this->session->set_flashdata('error',con_lang('mass_error_occurrs_try_later'));
		                             	redirect($_SERVER['HTTP_REFERER']);
		                          }
							  }else{
							  	    $this->session->set_flashdata('error',con_lang('mass_error_occurrs_try_later'));	                          	redirect($_SERVER['HTTP_REFEcon_lang(RER']);
							  }
						}
					}
				}else{
     			redirect('auth');
				}
	}
	public function searchByQuotation($type=null){
		if($this->isLoggedIn()){
			if($type=='ng'){
			}else{
				if($this->input->post('quotationNo')){
					$qoutationId=$this->input->post('quotationNo');
					$result=$this->purchase_model->getByQuotationNo($qoutationId);
						if(isset($result->id) && $result->id > 0){
						 $array1=$this->purchase_model->getAll('tbl_product', array('isActive' => 1,'company_id'=>$this->session->userdata('company_id')));
						 $array2=$this->purchase_model->getAll('tbl_uom',"id IN (SELECT UOMId FROM tbl_purchasepricelist WHERE company_id = $this->company_id) AND company_id = $this->company_id");
					     echo json_encode(array('result'=>$result,'products' => $array1, 'units' => $array2));exit();
					}
				}
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
					$result=$this->purchase_model->getByinvoiceNo($invoiceNo);
					if(isset($result->id) && $result->id > 0){
						 $array1=$this->purchase_model->getAll('tbl_product',array('isActive' => 1,'company_id'=>$this->session->userdata('company_id')));
						 $array2=$this->purchase_model->getAll('tbl_uom',"id IN (SELECT UOMId FROM tbl_purchasepricelist WHERE company_id = $this->company_id) AND company_id = $this->company_id");
					     echo json_encode(array('result'=>$result,'products' => $array1, 'units' => $array2));exit();
					}
				}
			}
		}else{
			redirect('auth');
		}
	}
	public function deletePurchaseOrder($id=null,$type=null){
		if($this->isLoggedIn()){
			if($type=='ng'){
			}else{
				$delete=$this->common_model->delete('tbl_purchaseordermaster',array('purchaseOrderNo'=>$id));
				if($delete){
					$delete2=$this->common_model->delete('tbl_purchaseorderdetails',array('purchaseOrderId'=>$id));
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
	public function deleteByAjax($type=null){
		if($this->isLoggedIn()){
			if($type=='ng'){
			}else{
				if($this->input->post('id')){
					$table=$this->input->post('table');
					$id=$this->input->post('id');
					$amount=$this->input->post('amount');
					$delete=$this->purchase_model->delete($table,array('id'=>$id));
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
	public function purchaseInvoice($type = null){
		if($this->isLoggedIn()){
				if($type=='ng'){
				}else{
					$data['active']='Purchase Invoice';
					$data['module']='accounting';
					$data['purchaseInvoiceMaster']=$this->purchase_model->getAll('tbl_purchaseinvoicemaster',array('company_id'=>$this->session->userdata('company_id'), 'is_deleted' => 0),array('created_on','desc'));
					$this->displayView('accounting/purchases/purchase_invoice_listing',$data,array(),array(
							'js'=>array(),
							'css'=>array(),
						));
				}
		}else{
			redirect('auth');
		}
	}
	public function printMiniReceipt() {
		if($this->isLoggedIn()) {
			$data['print'] = true;
			$data['is_print'] = true;
			$invoice  =  $this->displayView('accounting/purchases/purchase_receipt',$data,array('sidenav', 'topbar'),array(
				'js'=>array(),
				'css'=>array(),
			), true);
			echo $invoice;
			exit();
		}
	}
	public function addPurchaseInvoice($purchaseInvoiceNo=null,$type = null){
		if($this->isLoggedIn()){
				if($type=='ng'){
				}else{
					$data['active']='Purchase Invoice';
					$data['module']='accounting';
					  if($this->input->server('REQUEST_METHOD')==='POST'){
					  	$dateActiveYear=date('Y-m-d',strtotime($this->input->post('deliveryDate')));
					   	  $activeYear=$this->purchase_model->getOne('tbl_financialyear',array('isActive'=>1,'company_id'=>$this->session->userdata('company_id')));
					   	  if(!empty($activeYear)){
					   	  if($dateActiveYear >= $activeYear->fromDate && $dateActiveYear <= $activeYear->toDate){
					  	$purchase_order=$this->input->post('purchase_order_no');
						  $purchaseInvoiceMaster=array(
						  		'purchaseInvoiceNo'=>sprintf("%0".$this->voucher_number_length."d",$this->input->post('purchaseInvoiceNo')),
						  		'supplierId'=>$this->input->post('supplierId'),
						  		'company_id'=>$this->session->userdata('company_id'),
						  		'salesmanId'=>$this->input->post('salesmanId'),
						  		'purchase_order_no'=>$this->input->post('purchase_order_no'),
						  		'currencyId'=>$this->input->post('currencyId'),
						  		'deliveryDate'=>date('Y-m-d',strtotime($this->input->post('deliveryDate'))),
						  		'purchaseInvoiceStatus'=>'1',
						  		'purchaseInvoiceIsPrintAfterSave'=>$this->input->post('purchaseOrderisprintAfterSave'),
						  		'subtotal'=>deformat_value($this->input->post('subtotal')),
						  		'discount'=>deformat_value($this->input->post('discount')),
						  		'discount_type'=>$this->input->post('discount_type'),
						  		'freight'=>deformat_value($this->input->post('freight')),
						  		'indirect_expenses'=>$this->input->post('ledgerId'),
						  		'tax'=>$this->input->post('tax'),
						  		'tax_symbal'=>$this->input->post('tax_symbal'),
						  		'tax_name'=>$this->input->post('tax_name'),
						  		'total'=>deformat_value($this->input->post('total')),
						  		'purchaseInvoiceNarration'=>$this->input->post('narration'),
						  		'payment_receive' => deformat_value($this->input->post('payment_receive')),
						  		'created_by' => $this->session->userdata('id'),
							  	'created_on' => date('Y-m-d H:i:s',strtotime($this->input->post('deliveryDate')))
						  	);
						  $purchaseInvoiceMaster['created_on'] =  date('Y-m-d H:i:s', strtotime($purchaseInvoiceMaster['deliveryDate'].' '.date('H:i:s')));
						  $products=$this->input->post('product');
						  $savedInpurchaseInvoiceMaster=$this->purchase_model->add('tbl_purchaseinvoicemaster',$purchaseInvoiceMaster);
						  if($savedInpurchaseInvoiceMaster > 0){
						  		$update=$this->purchase_model->update('tbl_purchaseordermaster',array('purchaseOrderNo'=>$purchase_order),array('purchaseOrderstatus'=>1));
							  	foreach($products as $values){
							  	 if(isset($values['unit_discount']))
							  	 	$values['unit_discount'] = deformat_value($values['unit_discount']);
							  	 if(isset($values['rate']))
							  	 	$values['rate'] = deformat_value($values['rate']);
							  	 if(isset($values['amount']))
							  	 	$values['amount'] = deformat_value($values['amount']);
							  	 $values['purchaseInvoiceId']=sprintf("%0".$this->voucher_number_length."d",$this->input->post('purchaseInvoiceNo'));
							  	 $values['company_id']=$this->session->userdata('company_id');
							  	 $tax_amount = 0;
							  	 if(isset($values['tax_id']) && isset($values['rate']) && isset($values['qty'])) {
							  	 	$value_before_tax = (float)((int)$values['qty'] * (float)$values['rate']);
							  	 	$tax_row = $this->purchase_model->getById('tbl_accountledger', $values['tax_id']);
							  	 	if(isset($tax_row->tax_value)) {
								  	 	$tax_amount = (float)$tax_row->tax_value;
		                          		if($tax_row->tax_symbal == '%') {
		                          			$tax_amount = (float)($tax_amount*(float)$value_before_tax)/100;
		                          		}
							  	 	}
							  	 }
							  	 $values['taxAmount'] = $tax_amount;
							  	 $values['created_on'] = date('Y-m-d H:i:s');
	                          	 $savedInpurchaseInvoiceDetail=$this->purchase_model->add('tbl_purchaseinvoicedetails',$values);
	                          	 $update_price = array('purchaseRate' => $values['rate']);
	                          	 if(isset($values['UOMId'])){
	                          		 $update_where = array('UOMId' => $values['UOMId'], 'productName' => $values['product_id'], 'company_id' => $this->company_id);
	                          	 	$this->purchase_model->update('tbl_purchasepricelist', $update_where, $update_price);
	                          	 }
	                          	 unset($values['rate']);
	                          	 unset($values['amount']);
	                          	 unset($values['taxAmount']);
	                          	 unset($values['purchaseInvoiceId']);
	                          	 $values['purchaseInvoiceMasterId']=sprintf("%0".$this->voucher_number_length."d",$this->input->post('purchaseInvoiceNo'));
	                          	 $values['purchaseInvoiceDetailId']=$savedInpurchaseInvoiceDetail;
	                          	 $values['yearId'] = $this->getActiveYearId();
	                          	 unset($values['unit_discount']);

	                          	 if(isset($values['UOMId']) && $values['product_id']) {
	                          	 	$purchaseprice = $this->purchase_model->getOne('tbl_purchasepricelist', $update_where);
	                          	 	if(isset($purchaseprice->base_id) && $purchaseprice->base_id) {
	                          	 		$derived_qty = (int)$purchaseprice->base_qty * (int)$values['qty'];
	                          	 		$values['UOMId'] = $purchaseprice->base_id;
	                          	 		$values['qty'] = $derived_qty;
	                          	 	}
	                          	 }
	                          	 $savedInStock=$this->purchase_model->addStock($values);
	                          	 $this->update_stocks($values['st_id'],$values['qty'],$values['size']);
	                          	 if(isset($values['qty']) && $values['qty'] > 0) {
	                          	 	$entry = array(
	                          	 		'product_id' => $values['product_id'],
	                          	 		'unit_id' => isset($values['UOMId']) ? $values['UOMId']:'',
	                          	 		'voucher_type' => 'Purchase Invoice',
	                          	 		'invoice_no' => $savedInpurchaseInvoiceMaster,
	                          	 		'voucher_no' => 'PI-'.sprintf("%0".$this->voucher_number_length."d",$this->input->post('purchaseInvoiceNo')),
	                          	 		'debit' => $values['qty'],
	                          	 		'created_by' => $this->session->userdata('id'),
	                          	 		'created_on' => date('Y-m-d H:i:s'),
	                          	 		'company_id' => $this->company_id
	                          	 	);
	                          	 	$this->purchase_model->add('tbl_stock_ledger_posting', $entry);
	                          	 }
	                          }
	                          $this->set_barcode(sprintf("%0".$this->voucher_number_length."d",$this->input->post('purchaseInvoiceNo')));
	                          if($savedInpurchaseInvoiceDetail > 0 && $savedInStock > 0){
	                          	$voucherNo='PI-'.sprintf("%0".$this->voucher_number_length."d",$this->input->post('purchaseInvoiceNo'));
	                          	$subtotal = (float)deformat_value($this->input->post('subtotal'));
	                          	$freight = (float)deformat_value($this->input->post('freight'));
	                          	$total_with_freight = $subtotal + $freight;
	                          	$tax_id = (int)$this->input->post('tax');
	                          	$tax_row = $this->purchase_model->getById('tbl_accountledger', $tax_id);
	                          	$tax_amount = 0;
	                          	if(isset($tax_row->tax_value)) {
	                          		$tax_amount = (float)$tax_row->tax_value;
	                          		if($tax_row->tax_symbal == '%') {
	                          			$tax_amount = (float)($tax_amount*$total_with_freight)/100;
	                          		}
	                          	}
	                          	$this->purchase_model->update('tbl_purchaseinvoicemaster', array('purchaseInvoiceNo' => $this->input->post('purchaseInvoiceNo'), 'company_id' => $this->company_id), array('tax_amount' => $tax_amount));
	                          	$total_with_tax = $total_with_freight + $tax_amount;
                          		$discount = (float)deformat_value($this->input->post('discount'));
                          		$discount_type = $this->input->post('discount_type');
                          		if($discount_type == '%') {
                          			$discount = ($discount*$total_with_tax)/100;
                          		}
                          		$total = $total_with_tax - $discount;
                          	
	                          	if($discount > 0):
		                          	$ledgerpostingDiscount['voucherTypeId']=13;
		                          	$ledgerpostingDiscount['voucherNo']=$voucherNo;
		                          	$ledgerpostingDiscount['ledgerId']=9;
		                          	$ledgerpostingDiscount['credit']=$discount;
		                          	$ledgerpostingDiscount['yearId']=$this->getActiveYearId();
		                          	$ledgerpostingDiscount['invoiceNo']=$savedInpurchaseInvoiceMaster;
		                          	$ledgerpostingDiscount['date']=date("Y-m-d H:i:s");
		                          	$ledgerpostingDiscount['company_id']=$this->session->userdata('company_id');
		                          	$ledgerpostingDiscount=$this->purchase_model->add('tbl_ledgerposting',$ledgerpostingDiscount);
	                          	endif;
	                          	if($this->input->post('supplierId') == 1){
	                          		$ledgerpostingCash['voucherTypeId']=13;
		                          	$ledgerpostingCash['voucherNo']=$voucherNo;
		                          	$ledgerpostingCash['credit']=$total;
		                          	$ledgerpostingCash['ledgerId']=1;
		                          	$ledgerpostingCash['yearId']=$this->getActiveYearId();
		                          	$ledgerpostingCash['invoiceNo']=$savedInpurchaseInvoiceMaster;
		                          	$ledgerpostingCash['date']=date("Y-m-d H:i:s");
		                          	$ledgerpostingCash['company_id']=$this->session->userdata('company_id')
;		                          	$ledgerpostingCash=$this->purchase_model->add('tbl_ledgerposting',$ledgerpostingCash);

		                          	$ledgerpostingPurchase['voucherTypeId']=13;
		                          	$ledgerpostingPurchase['voucherNo']=$voucherNo;
		                          	$ledgerpostingPurchase['debit']=$total;
		                          	$ledgerpostingPurchase['ledgerId']=11;
		                          	$ledgerpostingPurchase['yearId']=$this->getActiveYearId();
		                          	$ledgerpostingPurchase['invoiceNo']=$savedInpurchaseInvoiceMaster;
		                          	$ledgerpostingPurchase['date']=date("Y-m-d H:i:s");
		                          	$ledgerpostingPurchase['company_id']=$this->session->userdata('company_id');
		                          	$ledgerpostingPurchase=$this->purchase_model->add('tbl_ledgerposting',$ledgerpostingPurchase);
	                          	} else {
		                          	if($this->input->post('payment_receive') == 0){
			                            $ledgerpostingPurchaseDebit['voucherTypeId']=13;
			                          	$ledgerpostingPurchaseDebit['voucherNo']=$voucherNo;
			                          	$ledgerpostingPurchaseDebit['debit']=$total;
			                          	$ledgerpostingPurchaseDebit['ledgerId']=11;
			                          	$ledgerpostingPurchaseDebit['yearId']=$this->getActiveYearId();
			                          	$ledgerpostingPurchaseDebit['invoiceNo']=$savedInpurchaseInvoiceMaster;
			                          	$ledgerpostingPurchaseDebit['date']=date("Y-m-d H:i:s");
			                          	$ledgerpostingPurchaseDebit['company_id']=$this->session->userdata('company_id');
			                          	$ledgerpostingPurchaseDebit=$this->purchase_model->add('tbl_ledgerposting',$ledgerpostingPurchaseDebit);

			                          	$ledgerpostingSuppliersCredit['voucherTypeId']=13;
			                          	$ledgerpostingSuppliersCredit['voucherNo']=$voucherNo;
			                          	$ledgerpostingSuppliersCredit['credit']=$total;
			                          	$ledgerpostingSuppliersCredit['ledgerId']=$this->input->post('supplierId');
			                          	$ledgerpostingSuppliersCredit['yearId']=$this->getActiveYearId();
			                          	$ledgerpostingSuppliersCredit['invoiceNo']=$savedInpurchaseInvoiceMaster;
			                          	$ledgerpostingSuppliersCredit['date']=date("Y-m-d H:i:s");
			                          	$ledgerpostingSuppliersCredit['company_id']=$this->session->userdata('company_id');
			                          	$ledgerpostingSuppliersCredit=$this->purchase_model->add('tbl_ledgerposting',$ledgerpostingSuppliersCredit);

		                          }else if($total > deformat_value($this->input->post('payment_receive'))) {
		                          		$ledgerpostingPurchaseDebit['voucherTypeId']=13;
			                          	$ledgerpostingPurchaseDebit['voucherNo']=$voucherNo;
			                          	$ledgerpostingPurchaseDebit['debit']=$total;
			                          	$ledgerpostingPurchaseDebit['ledgerId']=11;
			                          	$ledgerpostingPurchaseDebit['yearId']=$this->getActiveYearId();
			                          	$ledgerpostingPurchaseDebit['invoiceNo']=$savedInpurchaseInvoiceMaster;
			                          	$ledgerpostingPurchaseDebit['date']=date("Y-m-d H:i:s");
			                          	$ledgerpostingPurchaseDebit['company_id']=$this->session->userdata('company_id');
			                          	$ledgerpostingPurchaseDebit=$this->purchase_model->add('tbl_ledgerposting',$ledgerpostingPurchaseDebit);

			                          	$ledgerpostingSupllierCredit['voucherTypeId']=13;
			                          	$ledgerpostingSupllierCredit['voucherNo']=$voucherNo;
			                          	$ledgerpostingSupllierCredit['credit']=$total;
			                          	$ledgerpostingSupllierCredit['ledgerId']=$this->input->post('supplierId');
			                          	$ledgerpostingSupllierCredit['yearId']=$this->getActiveYearId();
			                          	$ledgerpostingSupllierCredit['invoiceNo']=$savedInpurchaseInvoiceMaster;
			                          	$ledgerpostingSupllierCredit['date']=date("Y-m-d H:i:s");
			                          	$ledgerpostingSupllierCredit['company_id']=$this->session->userdata('company_id');
			                          	$ledgerpostingSupllierCredit['debit']=deformat_value($this->input->post('payment_receive'));
			                          	$ledgerpostingSupllierCredit=$this->purchase_model->add('tbl_ledgerposting',$ledgerpostingSupllierCredit);

			                          	// $ledgerpostingSupplerDebit['voucherTypeId']=13;
			                          	// $ledgerpostingSupplerDebit['voucherNo']=$voucherNo;
			                          	// $ledgerpostingSupplerDebit['debit']=$this->input->post('payment_receive');
			                          	// $ledgerpostingSupplerDebit['ledgerId']=$this->input->post('supplierId');
			                          	// $ledgerpostingSupplerDebit['yearId']=$this->getActiveYearId();
			                          	// $ledgerpostingSupplerDebit['invoiceNo']=$savedInpurchaseInvoiceMaster;
			                          	// $ledgerpostingSupplerDebit['date']=date("Y-m-d");
			                          	// $ledgerpostingSupplerDebit['company_id']=$this->session->userdata('company_id');
			                          	// $ledgerpostingSupplerDebit=$this->purchase_model->add('tbl_ledgerposting',$ledgerpostingSupplerDebit);

			                          	$ledgerpostingCashCredits['voucherTypeId']=13;
			                          	$ledgerpostingCashCredits['voucherNo']=$voucherNo;
			                          	$ledgerpostingCashCredits['credit']=deformat_value($this->input->post('payment_receive'));
			                          	$ledgerpostingCashCredits['ledgerId']=1;
			                          	$ledgerpostingCashCredits['yearId']=$this->getActiveYearId();
			                          	$ledgerpostingCashCredits['invoiceNo']=$savedInpurchaseInvoiceMaster;
			                          	$ledgerpostingCashCredits['date']=date("Y-m-d H:i:s");
			                          	$ledgerpostingCashCredits['company_id']=$this->session->userdata('company_id');
			                          	$ledgerpostingCashCredits=$this->purchase_model->add('tbl_ledgerposting',$ledgerpostingCashCredits);

		                          }else if($total == deformat_value($this->input->post('payment_receive'))){
		                          	    $ledgerpostingPurchaseDebit['voucherTypeId']=13;
			                          	$ledgerpostingPurchaseDebit['voucherNo']=$voucherNo;
			                          	$ledgerpostingPurchaseDebit['debit']=$total;
			                          	$ledgerpostingPurchaseDebit['ledgerId']=11;
			                          	$ledgerpostingPurchaseDebit['yearId']=$this->getActiveYearId();
			                          	$ledgerpostingPurchaseDebit['invoiceNo']=$savedInpurchaseInvoiceMaster;
			                          	$ledgerpostingPurchaseDebit['date']=date("Y-m-d H:i:s");
			                          	$ledgerpostingPurchaseDebit['company_id']=$this->session->userdata('company_id');
			                          	$ledgerpostingPurchaseDebit=$this->purchase_model->add('tbl_ledgerposting',$ledgerpostingPurchaseDebit);

			                          	$ledgerpostingSupllierCredit['voucherTypeId']=13;
			                          	$ledgerpostingSupllierCredit['voucherNo']=$voucherNo;
			                          	$ledgerpostingSupllierCredit['credit']=$total;
			                          	$ledgerpostingSupllierCredit['ledgerId']=$this->input->post('supplierId');
			                          	$ledgerpostingSupllierCredit['yearId']=$this->getActiveYearId();
			                          	$ledgerpostingSupllierCredit['invoiceNo']=$savedInpurchaseInvoiceMaster;
			                          	$ledgerpostingSupllierCredit['date']=date("Y-m-d H:i:s");
			                          	$ledgerpostingSupllierCredit['company_id']=$this->session->userdata('company_id');
			                          	$ledgerpostingSupllierCredit['debit']=deformat_value($this->input->post('payment_receive'));
			                          	$ledgerpostingSupllierCredit=$this->purchase_model->add('tbl_ledgerposting',$ledgerpostingSupllierCredit);

			                          	// $ledgerpostingSupplerDebit['voucherTypeId']=13;
			                          	// $ledgerpostingSupplerDebit['voucherNo']=$voucherNo;
			                          	// $ledgerpostingSupplerDebit['debit']=$this->input->post('payment_receive');
			                          	// $ledgerpostingSupplerDebit['ledgerId']=$this->input->post('supplierId');
			                          	// $ledgerpostingSupplerDebit['yearId']=$this->getActiveYearId();
			                          	// $ledgerpostingSupplerDebit['invoiceNo']=$savedInpurchaseInvoiceMaster;
			                          	// $ledgerpostingSupplerDebit['date']=date("Y-m-d");
			                          	// $ledgerpostingSupplerDebit['company_id']=$this->session->userdata('company_id');
			                          	// $ledgerpostingSupplerDebit=$this->purchase_model->add('tbl_ledgerposting',$ledgerpostingSupplerDebit);

			                          	$ledgerpostingCashCredits['voucherTypeId']=13;
			                          	$ledgerpostingCashCredits['voucherNo']=$voucherNo;
			                          	$ledgerpostingCashCredits['credit']=deformat_value($this->input->post('payment_receive'));
			                          	$ledgerpostingCashCredits['ledgerId']=1;
			                          	$ledgerpostingCashCredits['yearId']=$this->getActiveYearId();
			                          	$ledgerpostingCashCredits['invoiceNo']=$savedInpurchaseInvoiceMaster;
			                          	$ledgerpostingCashCredits['date']=date("Y-m-d H:i:s");
			                          	$ledgerpostingCashCredits['company_id']=$this->session->userdata('company_id');
			                          	$ledgerpostingCashCredits=$this->purchase_model->add('tbl_ledgerposting',$ledgerpostingCashCredits);
		                          }
		                      }

	                          	if($this->input->post('ledgerId') > 0):
		                          	$ledgerpostingFreight['voucherTypeId']=13;
		                          	$ledgerpostingFreight['voucherNo']=$voucherNo;
		                          	$ledgerpostingFreight['yearId']=$this->getActiveYearId();
		                          	$ledgerpostingFreight['ledgerId']=$this->input->post('ledgerId');
		                          	$ledgerpostingFreight['date']=date("Y-m-d H:i:s");
		                          	$ledgerpostingFreight['company_id']=$this->session->userdata('company_id');
		                          	$ledgerpostingFreight['debit']=$freight;
		                          	$ledgerpostingFreight['invoiceNo']=$savedInpurchaseInvoiceMaster;
		                          	$ledgerpostingFreight=$this->purchase_model->add('tbl_ledgerposting',$ledgerpostingFreight);
		                         endif;
		                        if($tax_amount > 0):
	                          	$ledgerpostingTax['voucherTypeId']=13;
	                          	$ledgerpostingTax['voucherNo']=$voucherNo;
	                          	$ledgerpostingTax['yearId']=$this->getActiveYearId();
	                          	$ledgerpostingTax['ledgerId']=$this->input->post('tax');
	                          	$ledgerpostingTax['date']=date("Y-m-d H:i:s");
	                          	$ledgerpostingTax['company_id']=$this->session->userdata('company_id');
	                          	$ledgerpostingTax['debit']=$tax_amount;
	                          	$ledgerpostingTax['invoiceNo']=$savedInpurchaseInvoiceMaster;
	                          	$ledgerpostingTax=$this->purchase_model->add('tbl_ledgerposting',$ledgerpostingTax);
	                          	endif;
	                          	if($this->input->post('save_print')) {
		                        	$invoiceNo = $this->input->post('purchaseInvoiceNo');
							   		if(isset($invoiceNo) && $invoiceNo > 0) {
							   			$this->session->set_flashdata('print_purchase_invoice', $invoiceNo);
							   			// $this->printInvoice($invoiceNo);
							   		}
							   	}
	                          	$this->session->set_flashdata('success',con_lang('mass_purchase_invoice_added_successfully'));
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
					if($purchaseInvoiceNo!=null){
						$data['model']=(array)$this->purchase_model->getByIdPurchaseInvoice(decode_uri($purchaseInvoiceNo));
						$data['edit_purchase'] = true;
						// debug($data['model']);
					}
						$company_id=$this->session->userdata('company_id');
						$data['company_id'] = $company_id;
					if($purchaseInvoiceNo==null){
						$query="SELECT COUNT(id) AS total FROM tbl_purchaseinvoicemaster WHERE company_id =$company_id";
						$data['totalPurchaseInvoice']=$this->purchase_model->universal($query)->row()->total;
					}
					$data['currency']=$this->purchase_model->getCurrency();
					// $data['taxesOnBill']=$this->purchase_model->getAll('tbl_accountledger',array('product_bill'=>'bill','company_id'=>$this->company_id, 'accountGroupId' => 20));
					$apply_tax = $this->common_model->getOne('tbl_apply_taxes', array('company_id' => $this->company_id, 'voucher_type' => 'purchase'));
					if(isset($apply_tax->taxes) && $apply_tax->taxes != '') {
						$data['product_taxes'] = $this->purchase_model->getAll('tbl_accountledger', "product_bill = 'product' AND company_id = ".$this->company_id." AND id IN (".$apply_tax->taxes.")");
						$data['taxesOnBill'] = $this->purchase_model->getAll('tbl_accountledger', "product_bill = 'bill' AND company_id = ".$this->company_id." AND id IN (".$apply_tax->taxes.")");
					}
					$this->displayView('accounting/purchases/purchase_invoice',$data,array(),array(
							'js'=>array(),
							'css'=>array(),
						));
				}
		}else{
			   redirect('auth');
		}
	}
	public function update_stocks($st_id=null,$qty=0,$size=null,$is_edit=null)
	{
		if($st_id!=null)
		{
			$size='size_'.$size;
			if($is_edit!=null)
			{
				$this->products_list->updateStocks($st_id,$qty,$size,$is_edit);
			}
			else
			{
				$this->products_list->updateStocks($st_id,$qty,$size);
			}
		}
	}
	public function editPurchaseInvoice($id=null,$type=null){
				if($this->isLoggedIn()){
					if($type!=null){
					}else{
						if($this->input->server('REQUEST_METHOD')==='POST'){
							 $purchaseInvoiceMaster=array(
						  		'purchaseInvoiceNo'=>$this->input->post('purchaseInvoiceId'),
						  		'supplierId'=>$this->input->post('supplierId'),
						  		'company_id'=>$this->session->userdata('company_id'),
						  		'salesmanId'=>$this->input->post('salesmanId'),
						  		'currencyId'=>$this->input->post('currencyId'),
						  		'deliveryDate'=>date('Y-m-d',strtotime($this->input->post('deliveryDate'))),
						  		'purchaseInvoiceStatus'=>'1',
						  		'purchaseInvoiceIsPrintAfterSave'=>$this->input->post('purchaseOrderisprintAfterSave'),
						  		'subtotal'=>deformat_value($this->input->post('subtotal')),
						  		'discount'=>deformat_value($this->input->post('discount')),
						  		'discount_type'=>$this->input->post('discount_type'),
						  		'freight'=>deformat_value($this->input->post('freight')),
						  		'tax'=>$this->input->post('tax'),
						  		'total'=>deformat_value($this->input->post('total')),
						  		'purchaseInvoiceNarration'=>$this->input->post('narration'),
						  		'payment_receive' => deformat_value($this->input->post('payment_receive')),
						  	);
							  $products=$this->input->post('product');
							  // echo '<pre>',print_r($purchaseInvoiceMaster),'</pre>';
							  // debug($products);
							  $updateInpurchaseInvoiceMaster=$this->purchase_model->update('tbl_purchaseinvoicemaster',array('purchaseInvoiceNo'=>$this->input->post('purchaseInvoiceId'),'company_id'=>$this->company_id),$purchaseInvoiceMaster);
							  if($updateInpurchaseInvoiceMaster){
							  		$product_selected = array();
							  		if(!empty($products)){
							  			$company_id = $this->company_id;
									  	foreach($products as $values) {
									  		// unset($values['color_code']);
									  		// unset($values['vendor_code']);
									  		// unset($values['size']);
									  		if(isset($values['unit_discount']))
										  	 	$values['unit_discount'] = deformat_value($values['unit_discount']);
										  	 if(isset($values['rate']))
										  	 	$values['rate'] = deformat_value($values['rate']);
										  	 if(isset($values['amount']))
										  	 	$values['amount'] = deformat_value($values['amount']);
										  	 
										  	$productsId=isset($values['id']) ? $values['id']:'';
										  	$qtyy = $values['qty'];
										  		$update_where = array('UOMId' => $values['UOMId'], 'productName' => $values['product_id'], 'company_id' => $this->company_id);
					                        $voucherNo = 'PI-'.sprintf("%0".$this->voucher_number_length."d",$this->input->post('purchaseInvoiceId'));
										  	if(isset($productsId) && $productsId!=''){
											   unset($values['purchaseInvoiceId']);
											   $product_id=$values['product_id'];
											   array_push($product_selected, $productsId);
	                          	 				$uomID=$values['UOMId'];
											   $old_record = $this->purchase_model->getById('tbl_purchaseinvoicedetails', $productsId);
				                          	 $upodateInpurchaseInvoiceDetail=$this->purchase_model->update('tbl_purchaseinvoicedetails',array('purchaseInvoiceId'=>$this->input->post('purchaseInvoiceId'),'id'=>$productsId),$values);
										  		if(isset($old_record->qty)) {
										  			$qtyy = $qtyy - $old_record->qty;
										  			
												  	if(isset($values['UOMId']) && $values['product_id']) {
						                          	 	$purchaseprice = $this->purchase_model->getOne('tbl_purchasepricelist', $update_where);
						                          	 	if(isset($purchaseprice->base_id) && $purchaseprice->base_id) {
						                          	 		$derived_qty = (int)$purchaseprice->base_qty * (int)$qtyy;
						                          	 		$values['UOMId'] = $purchaseprice->base_id;
						                          	 		$values['qty'] = $derived_qty;
						                          	 		$qtyy = $values['qty'];
						                          	 		$uomID = $values['UOMId'];
						                          	 	}
						                          	 }
										  			$query="UPDATE tbl_stockdetails SET  qty=qty+$qtyy WHERE company_id=$company_id AND product_id=$product_id AND UOMId=$uomID ";
					                          	 	$updateInStock=$this->purchase_model->universal($query);
					                          	 	$this->update_stocks($values['st_id'],$values['qty'],$values['size'],1);
											  		$existing = $this->purchase_model->getOne('tbl_stock_ledger_posting', array('company_id' => $this->company_id, 'voucher_no' => $voucherNo, 'product_id' => $values['product_id'], 'unit_id' => $values['UOMId']));
											  		if(isset($existing->id)) {
											  			$this->purchase_model->universal("UPDATE tbl_stock_ledger_posting SET debit = debit + $qtyy WHERE id = $existing->id");
											  		} else {
						                          	 	$entry = array(
						                          	 		'product_id' => $values['product_id'],
						                          	 		'unit_id' => $values['UOMId'],
						                          	 		'voucher_type' => 'Purchase Invoice',
						                          	 		'invoice_no' => $this->input->post('purchaseInvoiceId'),
						                          	 		'voucher_no' => $voucherNo,
						                          	 		'debit' => $qtyy,
						                          	 		'created_by' => $this->session->userdata('id'),
		                          	 						'created_on' => date('Y-m-d H:i:s'),
						                          	 		'company_id' => $this->company_id
						                          	 	);
						                          	 	$this->purchase_model->add('tbl_stock_ledger_posting', $entry);
					                          	 	}
										  		}
				                          	 // $updateInStock=$this->purchase_model->update('tbl_stockdetails',array('purchaseInvoiceDetailId'=>$productsId,'purchaseInvoiceMasterId'=>$this->input->post('purchaseInvoiceId')),$values);
										  	}else if(isset($values['barcode']) && !empty($values['barcode'])){
										  		 $values['purchaseInvoiceId']=$this->input->post('purchaseInvoiceId');
										  		 $values['company_id']=$this->session->userdata('company_id');
										  		 $values['created_on'] = date('Y-m-d H:i:s');
										  		 $savedInpurchaseInvoiceDetail=$this->purchase_model->add('tbl_purchaseinvoicedetails',$values);
										  		 array_push($product_selected, $savedInpurchaseInvoiceDetail);
										  		 unset($values['rate']);
					                          	 unset($values['created_on']);
					                          	 unset($values['amount']);
												   unset($values['purchaseInvoiceId']);
					                          	 $values['purchaseInvoiceMasterId']=sprintf("%0".$this->voucher_number_length."d",$this->input->post('purchaseInvoiceId'));
					                          	 $values['purchaseInvoiceDetailId']=$savedInpurchaseInvoiceDetail;
					                          	 $values['company_id']=$this->session->userdata('company_id');
												   unset($values['unit_discount']);
												   if(isset($values['UOMId']) && $values['product_id']) {
						                          	 	$purchaseprice = $this->purchase_model->getOne('tbl_purchasepricelist', $update_where);
						                          	 	if(isset($purchaseprice->base_id) && $purchaseprice->base_id) {
						                          	 		$derived_qty = (int)$purchaseprice->base_qty * (int)$values['qty'];
						                          	 		$values['UOMId'] = $purchaseprice->base_id;
						                          	 		$values['qty'] = $derived_qty;
						                          	 	}
						                          	 }
					                          	 $savedInStock=$this->purchase_model->add('tbl_stockdetails',$values);

					                          	 $existing = $this->purchase_model->getOne('tbl_stock_ledger_posting', array('company_id' => $this->company_id, 'voucher_no' => $voucherNo, 'product_id' => $values['product_id'], 'unit_id' => $values['UOMId']));
										  		if(isset($existing->id)) {
										  			$this->purchase_model->universal("UPDATE tbl_stock_ledger_posting SET debit = $derived_qty WHERE id = $existing->id");
										  		} else {
					                          	 	$entry = array(
					                          	 		'product_id' => $values['product_id'],
					                          	 		'unit_id' => $values['UOMId'],
					                          	 		'voucher_type' => 'Purchase Invoice',
					                          	 		'invoice_no' => $this->input->post('purchaseInvoiceId'),
					                          	 		'voucher_no' => $voucherNo,
					                          	 		'debit' => $derived_qty,
					                          	 		'created_by' => $this->session->userdata('id'),
	                          	 						'created_on' => date('Y-m-d H:i:s'),
					                          	 		'company_id' => $this->company_id
					                          	 	);
					                          	 	$this->purchase_model->add('tbl_stock_ledger_posting', $entry);
				                          	 	}
										  	}

				                          	 unset($values['rate']);
				                          	 unset($values['amount']);
											   unset($values['unit_discount']);
			                          }
			                        }
			                        if(!empty($product_selected)) {
			                          	$product_selected = implode(',', $product_selected);
			                          	
			                          	$items = $this->purchase_model->getAll('tbl_purchaseinvoicedetails', "id NOT IN (".$product_selected.") AND purchaseInvoiceId = ".$this->input->post('purchaseInvoiceId')." AND company_id = ".$this->company_id);
			                          	if(!empty($items)) {
			                          		foreach ($items as $item) {
			                          			if(isset($item->product_id) && isset($item->UOMId) && isset($item->qty)) {
			                          				$update_where = array('UOMId' => $item->UOMId, 'productName' => $item->product_id, 'company_id' => $this->company_id);
			                          				$qty = $item->qty;
			                          				$unit_id = $item->UOMId;
			                          				$purchaseprice = $this->purchase_model->getOne('tbl_purchasepricelist', $update_where);
					                          	 	if(isset($purchaseprice->base_id) && $purchaseprice->base_id) {
					                          	 		$qty = (float)$purchaseprice->base_qty * (float)$item->qty;
					                          	 		$unit_id = $purchaseprice->base_id;
					                          	 	}
					                          	 	$query="UPDATE tbl_stockdetails SET  qty=qty - $qty WHERE company_id=".$this->company_id." AND product_id=".$item->product_id." AND UOMId=$unit_id ";
					                          	 	$updateInStock=$this->purchase_model->universal($query);
			                          				$this->purchase_model->universal("UPDATE tbl_stock_ledger_posting SET debit = debit - $qty WHERE company_id=".$this->company_id." AND voucher_no = '".$voucherNo."' AND product_id = ".$item->product_id." AND unit_id = ".$unit_id);
			                          			}
			                          		}
			                          	}

			                          	$this->purchase_model->delete('tbl_purchaseinvoicedetails', "id NOT IN (".$product_selected.") AND purchaseInvoiceId = ".$this->input->post('purchaseInvoiceId')." AND company_id = ".$this->company_id);
			                        }

		                          // removing all ledger entries for current invoice
		                          // and add new one
		                          $invoice = $this->purchase_model->getOne('tbl_purchaseinvoicemaster', array('purchaseInvoiceNo' => $this->input->post('purchaseInvoiceId'), 'company_id' => $this->company_id));
		                          
		                          if(isset($invoice->id)) {
		                          	if($this->purchase_model->delete('tbl_ledgerposting', array('invoiceNo' => $invoice->id))) {
		                          	$voucherNo='PI-'.sprintf("%0".$this->voucher_number_length."d",$this->input->post('purchaseInvoiceId'));
		                          	$subtotal = (float)deformat_value($this->input->post('subtotal'));
		                          	$freight = (float)deformat_value($this->input->post('freight'));
		                          	$total_with_freight = $subtotal + $freight;
		                          	$tax_id = (int)$this->input->post('tax');
		                          	$tax_row = $this->purchase_model->getById('tbl_accountledger', $tax_id);
		                          	$tax_amount = 0;
		                          	if(isset($tax_row->tax_value)) {
		                          		$tax_amount = (float)$tax_row->tax_value;
		                          		if($tax_row->tax_symbal == '%') {
		                          			$tax_amount = (float)($tax_amount*$total_with_freight)/100;
		                          		}
		                          	}
		                          	$this->purchase_model->update('tbl_purchaseinvoicemaster', array('purchaseInvoiceNo' => $this->input->post('purchaseInvoiceId'), 'company_id' => $this->company_id), array('tax_amount' => $tax_amount));
		                          	$total_with_tax = $total_with_freight + $tax_amount;
	                          		$discount = (float)deformat_value($this->input->post('discount'));
	                          		$discount_type = $this->input->post('discount_type');
	                          		if($discount_type == '%') {
	                          			$discount = ($discount*$total_with_tax)/100;
	                          		}
	                          		$total = $total_with_tax - $discount;
		                          	if($discount > 0):
		                          		$entry = $this->purchase_model->getOne('tbl_ledgerposting', array('ledgerId' => 9, 'voucherNo' => $voucherNo, 'company_id' => $this->company_id));
		                          		if(isset($entry->id)) {
				                          	$ledgerpostingDiscount['credit']=$discount;
				                          	$ledgerpostingDiscount=$this->purchase_model->update('tbl_ledgerposting', array('id' => $entry->id),$ledgerpostingDiscount);
		                          		} else {
				                          	$ledgerpostingDiscount['voucherTypeId']=13;
				                          	$ledgerpostingDiscount['credit']=$discount;
				                          	$ledgerpostingDiscount['yearId']=$this->getActiveYearId();
				                          	$ledgerpostingDiscount['ledgerId']=9;
				                          	$ledgerpostingDiscount['date']=date("Y-m-d H:i:s");
				                          	$ledgerpostingDiscount['voucherNo']=$voucherNo;
				                          	$ledgerpostingDiscount['invoiceNo']=$invoice->id;
				                          	$ledgerpostingDiscount['company_id']=$this->session->userdata('company_id');
				                          	$ledgerpostingDiscount=$this->purchase_model->add('tbl_ledgerposting',$ledgerpostingDiscount);
		              
		                          		}
		                          	else:
		                          		$this->purchase_model->delete('tbl_ledgerposting', array('ledgerId' => 9, 'voucherNo' => $voucherNo, 'company_id' => $this->company_id));
		                          	endif;
		                          	if($this->input->post('supplierId') == 1){
		                          		$entry = $this->purchase_model->getOne('tbl_ledgerposting', array('ledgerId' => 1, 'voucherNo' => $voucherNo, 'company_id' => $this->company_id));
		                          		if(isset($entry->id)) {
				                          	$ledgerpostingCash['credit']=$total;
				                          	$ledgerpostingCash=$this->purchase_model->update('tbl_ledgerposting', array('id' => $entry->id),$ledgerpostingCash);
		                          		} else {
			                          		$ledgerpostingCash['voucherTypeId']=13;
				                          	$ledgerpostingCash['voucherNo']=$voucherNo;
				                          	$ledgerpostingCash['credit']=$total;
				                          	$ledgerpostingCash['ledgerId']=1;
				                          	$ledgerpostingCash['yearId']=$this->getActiveYearId();
				                          	$ledgerpostingCash['invoiceNo']=$invoice->id;
				                          	$ledgerpostingCash['date']=date("Y-m-d H:i:s");
				                          	$ledgerpostingCash['company_id']=$this->session->userdata('company_id');
				                          	$ledgerpostingCash=$this->purchase_model->add('tbl_ledgerposting',$ledgerpostingCash);
				                        }


				                        $entry = $this->purchase_model->getOne('tbl_ledgerposting', array('ledgerId' => 11, 'voucherNo' => $voucherNo, 'company_id' => $this->company_id));
		                          		if(isset($entry->id)) {
				                          	$ledgerpostingPurchase['debit']=$total;
				                          	$ledgerpostingPurchase=$this->purchase_model->update('tbl_ledgerposting', array('id' => $entry->id),$ledgerpostingPurchase);
		                          		} else {
				                          	$ledgerpostingPurchase['voucherTypeId']=13;
				                          	$ledgerpostingPurchase['voucherNo']=$voucherNo;
				                          	$ledgerpostingPurchase['debit']=$total;
				                          	$ledgerpostingPurchase['ledgerId']=11;
				                          	$ledgerpostingPurchase['yearId']=$this->getActiveYearId();
				                          	$ledgerpostingPurchase['invoiceNo']=$invoice->id;
				                          	$ledgerpostingPurchase['date']=date("Y-m-d H:i:s");
				                          	$ledgerpostingPurchase['company_id']=$this->session->userdata('company_id');
				                          	$ledgerpostingPurchase=$this->purchase_model->add('tbl_ledgerposting',$ledgerpostingPurchase);
				                        }
		                          	} else {
			                          	if(deformat_value($this->input->post('payment_receive')) == 0){
			                          		$entry = $this->purchase_model->getOne('tbl_ledgerposting', array('ledgerId' => 11, 'voucherNo' => $voucherNo, 'company_id' => $this->company_id));
			                          		if(isset($entry->id)) {
					                          	$ledgerpostingPurchaseDebit['debit']=$total;
					                          	$ledgerpostingPurchaseDebit=$this->purchase_model->update('tbl_ledgerposting', array('id' => $entry->id),$ledgerpostingPurchaseDebit);
			                          		} else {
					                            $ledgerpostingPurchaseDebit['voucherTypeId']=13;
					                          	$ledgerpostingPurchaseDebit['voucherNo']=$voucherNo;
					                          	$ledgerpostingPurchaseDebit['debit']=$total;
					                          	$ledgerpostingPurchaseDebit['ledgerId']=11;
					                          	$ledgerpostingPurchaseDebit['yearId']=$this->getActiveYearId();
					                          	$ledgerpostingPurchaseDebit['invoiceNo']=$invoice->id;
					                          	$ledgerpostingPurchaseDebit['date']=date("Y-m-d H:i:s");
					                          	$ledgerpostingPurchaseDebit['company_id']=$this->session->userdata('company_id');
					                          	$ledgerpostingPurchaseDebit=$this->purchase_model->add('tbl_ledgerposting',$ledgerpostingPurchaseDebit);
					                        }

					                        $entry = $this->purchase_model->getOne('tbl_ledgerposting', array('ledgerId' => $this->input->post('supplierId'), 'voucherNo' => $voucherNo, 'company_id' => $this->company_id));
			                          		if(isset($entry->id)) {
					                          	$ledgerpostingSuppliersCredit['credit']=$total;
					                          	$ledgerpostingSuppliersCredit=$this->purchase_model->update('tbl_ledgerposting', array('id' => $entry->id),$ledgerpostingSuppliersCredit);
			                          		} else {
					                          	$ledgerpostingSuppliersCredit['voucherTypeId']=13;
					                          	$ledgerpostingSuppliersCredit['voucherNo']=$voucherNo;
					                          	$ledgerpostingSuppliersCredit['credit']=$total;
					                          	$ledgerpostingSuppliersCredit['ledgerId']=$this->input->post('supplierId');
					                          	$ledgerpostingSuppliersCredit['yearId']=$this->getActiveYearId();
					                          	$ledgerpostingSuppliersCredit['invoiceNo']=$invoice->id;
					                          	$ledgerpostingSuppliersCredit['date']=date("Y-m-d H:i:s");
					                          	$ledgerpostingSuppliersCredit['company_id']=$this->session->userdata('company_id');
					                          	$ledgerpostingSuppliersCredit=$this->purchase_model->add('tbl_ledgerposting',$ledgerpostingSuppliersCredit);
					                        }

			                          }else if($total > deformat_value($this->input->post('payment_receive'))) {
			                          		$entry = $this->purchase_model->getOne('tbl_ledgerposting', array('ledgerId' => 11, 'voucherNo' => $voucherNo, 'company_id' => $this->company_id));
			                          		if(isset($entry->id)) {
					                          	$ledgerpostingPurchaseDebit['debit']=$total;
					                          	$ledgerpostingPurchaseDebit=$this->purchase_model->update('tbl_ledgerposting', array('id' => $entry->id),$ledgerpostingPurchaseDebit);
			                          		} else {
				                          		$ledgerpostingPurchaseDebit['voucherTypeId']=13;
					                          	$ledgerpostingPurchaseDebit['voucherNo']=$voucherNo;
					                          	$ledgerpostingPurchaseDebit['debit']=$total;
					                          	$ledgerpostingPurchaseDebit['ledgerId']=11;
					                          	$ledgerpostingPurchaseDebit['yearId']=$this->getActiveYearId();
					                          	$ledgerpostingPurchaseDebit['invoiceNo']=$invoice->id;
					                          	$ledgerpostingPurchaseDebit['date']=date("Y-m-d H:i:s");
					                          	$ledgerpostingPurchaseDebit['company_id']=$this->session->userdata('company_id');
					                          	$ledgerpostingPurchaseDebit=$this->purchase_model->add('tbl_ledgerposting',$ledgerpostingPurchaseDebit);
					                        }

					                        $entry = $this->purchase_model->getOne('tbl_ledgerposting', array('ledgerId' => $this->input->post('supplierId'), 'voucherNo' => $voucherNo, 'company_id' => $this->company_id));
			                          		if(isset($entry->id)) {
					                          	$ledgerpostingSupllierCredit['credit']=$total;
					                          	$ledgerpostingSupllierCredit=$this->purchase_model->update('tbl_ledgerposting', array('id' => $entry->id),$ledgerpostingSupllierCredit);
			                          		} else {
					                          	$ledgerpostingSupllierCredit['voucherTypeId']=13;
					                          	$ledgerpostingSupllierCredit['voucherNo']=$voucherNo;
					                          	$ledgerpostingSupllierCredit['credit']=$total;
					                          	$ledgerpostingSupllierCredit['debit']=deformat_value($this->input->post('payment_receive'));
					                          	$ledgerpostingSupllierCredit['ledgerId']=$this->input->post('supplierId');
					                          	$ledgerpostingSupllierCredit['yearId']=$this->getActiveYearId();
					                          	$ledgerpostingSupllierCredit['invoiceNo']=$invoice->id;
					                          	$ledgerpostingSupllierCredit['date']=date("Y-m-d H:i:s");
					                          	$ledgerpostingSupllierCredit['company_id']=$this->session->userdata('company_id');
					                          	$ledgerpostingSupllierCredit=$this->purchase_model->add('tbl_ledgerposting',$ledgerpostingSupllierCredit);
					                        }

				                          	// $ledgerpostingSupplerDebit['voucherTypeId']=13;
				                          	// $ledgerpostingSupplerDebit['voucherNo']=$voucherNo;
				                          	// $ledgerpostingSupplerDebit['debit']=$this->input->post('payment_receive');
				                          	// $ledgerpostingSupplerDebit['ledgerId']=$this->input->post('supplierId');
				                          	// $ledgerpostingSupplerDebit['yearId']=$this->getActiveYearId();
				                          	// $ledgerpostingSupplerDebit['invoiceNo']=$invoice->id;
				                          	// $ledgerpostingSupplerDebit['date']=date("Y-m-d");
				                          	// $ledgerpostingSupplerDebit['company_id']=$this->session->userdata('company_id');
				                          	// $ledgerpostingSupplerDebit=$this->purchase_model->add('tbl_ledgerposting',$ledgerpostingSupplerDebit);
					                        $entry = $this->purchase_model->getOne('tbl_ledgerposting', array('ledgerId' => 1, 'voucherNo' => $voucherNo, 'company_id' => $this->company_id));
			                          		if(isset($entry->id)) {
					                          	$ledgerpostingCashCredits['credit']=deformat_value($this->input->post('payment_receive'));
					                          	$ledgerpostingCashCredits=$this->purchase_model->update('tbl_ledgerposting', array('id' => $entry->id),$ledgerpostingCashCredits);
			                          		} else {
					                          	$ledgerpostingCashCredits['voucherTypeId']=13;
					                          	$ledgerpostingCashCredits['voucherNo']=$voucherNo;
					                          	$ledgerpostingCashCredits['credit']=deformat_value($this->input->post('payment_receive'));
					                          	$ledgerpostingCashCredits['ledgerId']=1;
					                          	$ledgerpostingCashCredits['yearId']=$this->getActiveYearId();
					                          	$ledgerpostingCashCredits['invoiceNo']=$invoice->id;
					                          	$ledgerpostingCashCredits['date']=date("Y-m-d H:i:s");
					                          	$ledgerpostingCashCredits['company_id']=$this->session->userdata('company_id');
					                          	$ledgerpostingCashCredits=$this->purchase_model->add('tbl_ledgerposting',$ledgerpostingCashCredits);
					                        }

			                          }else if($total == $this->input->post('payment_receive')){
			                          		$entry = $this->purchase_model->getOne('tbl_ledgerposting', array('ledgerId' => 11, 'voucherNo' => $voucherNo, 'company_id' => $this->company_id));
			                          		if(isset($entry->id)) {
					                          	$ledgerpostingPurchaseDebit['debit']=$total;
					                          	$ledgerpostingPurchaseDebit=$this->purchase_model->update('tbl_ledgerposting', array('id' => $entry->id),$ledgerpostingPurchaseDebit);
			                          		} else {
				                          	    $ledgerpostingPurchaseDebit['voucherTypeId']=13;
					                          	$ledgerpostingPurchaseDebit['voucherNo']=$voucherNo;
					                          	$ledgerpostingPurchaseDebit['debit']=$total;
					                          	$ledgerpostingPurchaseDebit['ledgerId']=11;
					                          	$ledgerpostingPurchaseDebit['yearId']=$this->getActiveYearId();
					                          	$ledgerpostingPurchaseDebit['invoiceNo']=$invoice->id;
					                          	$ledgerpostingPurchaseDebit['date']=date("Y-m-d H:i:s");
					                          	$ledgerpostingPurchaseDebit['company_id']=$this->session->userdata('company_id');
					                          	$ledgerpostingPurchaseDebit=$this->purchase_model->add('tbl_ledgerposting',$ledgerpostingPurchaseDebit);
					                        }

					                        $entry = $this->purchase_model->getOne('tbl_ledgerposting', array('ledgerId' => $this->input->post('supplierId'), 'voucherNo' => $voucherNo, 'company_id' => $this->company_id));
			                          		if(isset($entry->id)) {
			                          			$ledgerpostingSupllierCredit['credit']=$total;
					                          	$ledgerpostingSupllierCredit['debit']=deformat_value($this->input->post('payment_receive'));
					                          	$ledgerpostingSupllierCredit=$this->purchase_model->update('tbl_ledgerposting', array('id' => $entry->id),$ledgerpostingSupllierCredit);
			                          		} else {
					                          	$ledgerpostingSupllierCredit['voucherTypeId']=13;
					                          	$ledgerpostingSupllierCredit['voucherNo']=$voucherNo;
					                          	$ledgerpostingSupllierCredit['credit']=$total;
					                          	$ledgerpostingSupllierCredit['debit']=deformat_value($this->input->post('payment_receive'));
					                          	$ledgerpostingSupllierCredit['ledgerId']=$this->input->post('supplierId');
					                          	$ledgerpostingSupllierCredit['yearId']=$this->getActiveYearId();
					                          	$ledgerpostingSupllierCredit['invoiceNo']=$invoice->id;
					                          	$ledgerpostingSupllierCredit['date']=date("Y-m-d H:i:s");
					                          	$ledgerpostingSupllierCredit['company_id']=$this->session->userdata('company_id');
					                          	$ledgerpostingSupllierCredit=$this->purchase_model->add('tbl_ledgerposting',$ledgerpostingSupllierCredit);
					                        }

				                          	// $ledgerpostingSupplerDebit['voucherTypeId']=13;
				                          	// $ledgerpostingSupplerDebit['voucherNo']=$voucherNo;
				                          	// $ledgerpostingSupplerDebit['debit']=$this->input->post('payment_receive');
				                          	// $ledgerpostingSupplerDebit['ledgerId']=$this->input->post('supplierId');
				                          	// $ledgerpostingSupplerDebit['yearId']=$this->getActiveYearId();
				                          	// $ledgerpostingSupplerDebit['invoiceNo']=$invoice->id;
				                          	// $ledgerpostingSupplerDebit['date']=date("Y-m-d");
				                          	// $ledgerpostingSupplerDebit['company_id']=$this->session->userdata('company_id');
				                          	// $ledgerpostingSupplerDebit=$this->purchase_model->add('tbl_ledgerposting',$ledgerpostingSupplerDebit);

					                        $entry = $this->purchase_model->getOne('tbl_ledgerposting', array('ledgerId' => 1, 'voucherNo' => $voucherNo, 'company_id' => $this->company_id));
			                          		if(isset($entry->id)) {
					                          	$ledgerpostingCashCredits['credit']=deformat_value($this->input->post('payment_receive'));
					                          	$ledgerpostingCashCredits=$this->purchase_model->update('tbl_ledgerposting', array('id' => $entry->id),$ledgerpostingCashCredits);
			                          		} else {
					                          	$ledgerpostingCashCredits['voucherTypeId']=13;
					                          	$ledgerpostingCashCredits['voucherNo']=$voucherNo;
					                          	$ledgerpostingCashCredits['credit']=deformat_value($this->input->post('payment_receive'));
					                          	$ledgerpostingCashCredits['ledgerId']=1;
					                          	$ledgerpostingCashCredits['yearId']=$this->getActiveYearId();
					                          	$ledgerpostingCashCredits['invoiceNo']=$invoice->id;
					                          	$ledgerpostingCashCredits['date']=date("Y-m-d H:i:s");
					                          	$ledgerpostingCashCredits['company_id']=$this->session->userdata('company_id');
					                          	$ledgerpostingCashCredits=$this->purchase_model->add('tbl_ledgerposting',$ledgerpostingCashCredits);
					                        }
			                          }
			                      }

		                          	if($this->input->post('ledgerId') > 0):
		                          			$entry = $this->purchase_model->getOne('tbl_ledgerposting', array('ledgerId' => $this->input->post('ledgerId'), 'voucherNo' => $voucherNo, 'company_id' => $this->company_id));
			                          		if(isset($entry->id)) {
					                          	$ledgerpostingFreight['debit']=$freight;
					                          	$ledgerpostingFreight=$this->purchase_model->update('tbl_ledgerposting', array('id' => $entry->id),$ledgerpostingFreight);
			                          		} else {
					                          	$ledgerpostingFreight['voucherTypeId']=13;
					                          	$ledgerpostingFreight['voucherNo']=$voucherNo;
					                          	$ledgerpostingFreight['yearId']=$this->getActiveYearId();
					                          	$ledgerpostingFreight['ledgerId']=$this->input->post('ledgerId');
					                          	$ledgerpostingFreight['date']=date("Y-m-d H:i:s");
					                          	$ledgerpostingFreight['company_id']=$this->session->userdata('company_id');
					                          	$ledgerpostingFreight['debit']=$freight;
					                          	$ledgerpostingFreight['invoiceNo']=$invoice->id;
					                          	$ledgerpostingFreight=$this->purchase_model->add('tbl_ledgerposting',$ledgerpostingFreight);
					                        }
					                 else:
		                          		$this->purchase_model->delete('tbl_ledgerposting', array('ledgerId' => $this->input->post('ledgerId'), 'voucherNo' => $voucherNo, 'company_id' => $this->company_id));
			                         endif;
			                        if($tax_amount > 0):
			                        	$entry = $this->purchase_model->getOne('tbl_ledgerposting', array('ledgerId' => $this->input->post('tax'), 'voucherNo' => $voucherNo, 'company_id' => $this->company_id));
		                          		if(isset($entry->id)) {
				                          	$ledgerpostingTax['debit']=$tax_amount;
				                          	$ledgerpostingTax=$this->purchase_model->update('tbl_ledgerposting', array('id' => $entry->id),$ledgerpostingTax);
		                          		} else {
				                          	$ledgerpostingTax['voucherTypeId']=13;
				                          	$ledgerpostingTax['voucherNo']=$voucherNo;
				                          	$ledgerpostingTax['yearId']=$this->getActiveYearId();
				                          	$ledgerpostingTax['ledgerId']=$this->input->post('tax');
				                          	$ledgerpostingTax['date']=date("Y-m-d H:i:s");
				                          	$ledgerpostingTax['company_id']=$this->session->userdata('company_id');
				                          	$ledgerpostingTax['debit']=$tax_amount;
				                          	$ledgerpostingTax['invoiceNo']=$invoice->id;
				                          	$ledgerpostingTax=$this->purchase_model->add('tbl_ledgerposting',$ledgerpostingTax);
				                        }
				                    else:
		                          		$this->purchase_model->delete('tbl_ledgerposting', array('ledgerId' => $this->input->post('tax'), 'voucherNo' => $voucherNo, 'company_id' => $this->company_id));
		                          	endif;
		                          	}
		                          	
		                          }
		                          if($this->input->post('save_print')) {
			                        	$invoiceNo = $this->input->post('purchaseInvoiceId');
								   		if(isset($invoiceNo) && $invoiceNo > 0) {
								   			$this->session->set_flashdata('print_purchase_invoice', $invoiceNo);
								   			// $this->printInvoice($invoiceNo);
								   		}
								   	}
		                          if(isset($upodateInpurchaseInvoiceDetail) && $upodateInpurchaseInvoiceDetail){
		                          	$this->session->set_flashdata('success',con_lang('mass_purchase_invoice_update_successfully'));
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
	public function searchByInvoice($type=null){
		if($this->isLoggedIn()){
			if($type=='ng'){
			}else{
				if($this->input->post('OrderNo')){
					$OrderNo=$this->input->post('OrderNo');
					$array1=$this->purchase_model->getAll('tbl_product',array('isActive' => 1,'company_id'=>$this->session->userdata('company_id')));
					$array2=$this->purchase_model->getAll('tbl_uom',"id IN (SELECT UOMId FROM tbl_purchasepricelist WHERE company_id = $this->company_id) AND company_id = $this->company_id");
					$result=$this->purchase_model->getByOrderNo($OrderNo);
					// debug($result);
					echo json_encode(array('result'=>$result,'products' => $array1, 'units' => $array2));exit();
				}
			}
		}else{
			redirect('auth');
		}
	}
	public function deletePurchaseInvoice($purchaseInvoiceNo=null, $id = null,$type=null){
		if($this->isLoggedIn()){
			if($type=='ng'){
			}else{
				$delete=$this->common_model->update('tbl_purchaseinvoicemaster',array('id'=>$id), array('is_deleted' => 1));
				if($delete){
					$items = $this->common_model->getAll('tbl_purchaseinvoicedetails', array('company_id' => $this->company_id, 'purchaseInvoiceId' => $purchaseInvoiceNo));
					if(!empty($items)) {
						foreach ($items as $item) {
							if(isset($item->product_id) && isset($item->UOMId)) {
								$quantity = (float)$item->qty;
								$query_return="SELECT SUM(qty) AS total_return_qty FROM tbl_purchasereturndetail WHERE product_id = $item->product_id AND UOMId = $item->UOMId AND company_id = $this->company_id AND purchaseInvoiceId = $purchaseInvoiceNo";
								$check_return_sale_invoices=$this->common_model->universal($query_return)->row();
								if(!empty($check_return_sale_invoices) && isset($check_return_sale_invoices->total_return_qty)){
									$quantity-=(float)$check_return_sale_invoices->total_return_qty;
								}
								$unit_id = $item->UOMId;
								$qty = $quantity;
								$update_where = array('UOMId' => $item->UOMId, 'productName' => $item->product_id, 'company_id' => $this->company_id);
                          	 	$purchaseprice = $this->purchase_model->getOne('tbl_purchasepricelist', $update_where);
                          	 	if(isset($purchaseprice->base_id) && $purchaseprice->base_id) {
                          	 		$qty = (float)deformat_value($purchaseprice->base_qty * (float)$quantity);
                          	 		$unit_id = $purchaseprice->base_id;
                          	 	}

								$this->common_model->universal("UPDATE tbl_stockdetails SET qty = qty - $quantity WHERE company_id = ".$this->company_id." AND product_id = ".$item->product_id." AND UOMId = ".$item->UOMId);

								if($quantity > 0) {
	                          	 	$entry = array(
	                          	 		'product_id' => $item->product_id,
	                          	 		'unit_id' => $item->UOMId,
	                          	 		'voucher_type' => 'Purchase Invoice (Deleted)',
	                          	 		'invoice_no' => $purchaseInvoiceNo,
	                          	 		'voucher_no' => 'PI-'.sprintf("%0".$this->voucher_number_length."d",$purchaseInvoiceNo).'-Deleted',
	                          	 		'credit' => $quantity,
	                          	 		'created_by' => $this->session->userdata('id'),
	                          	 		'created_on' => date('Y-m-d H:i:s'),
	                          	 		'company_id' => $this->company_id
	                          	 	);
	                          	 	$this->purchase_model->add('tbl_stock_ledger_posting', $entry);
	                          	 }
							}
						}
					}
					// $delete2=$this->common_model->delete('tbl_purchaseinvoicedetails',array('purchaseInvoiceId'=>$purchaseInvoiceNo));
					if($delete){
						$this->common_model->delete('tbl_ledgerposting',array('voucherTypeId'=>13, 'invoiceNo' => $id));
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
	public function getTaxvalue($type=null){
		if($this->isLoggedIn()){
			if($type == 'ng'){
			}else{
				if($this->input->post('data')){
					$taxid=$this->input->post('data');
					$result=$this->purchase_model->getById('tbl_accountledger',$taxid);
					if(!empty($result)){
						echo json_encode($result);exit();
					}
				}
			}
		}else{
			redirect('auth');
		}
	}
	public function purchaseReturn($id = null, $type=null){
		if($this->isLoggedIn()){
			if($type == 'ng'){
			}else{
				$data['active']='Purchase Return';
				$data['module']='accounting';
				$data['taxesOnBill']=$this->purchase_model->getAll('tbl_accountledger',array('product_bill'=>'bill','company_id'=>$this->company_id, 'accountGroupId' => 20));
				if($this->input->server('REQUEST_METHOD') === 'POST'){
				}
				$data['edit_return'] = $id;
				$this->displayView('accounting/purchases/purchase_return',$data,array(),array(
						'js'=>array(),
						'css'=>array(),
					));
			}
		}else{	
			redirect('auth');
		}
	}
	public function addPurchaseReturn($purchaseInvoiceNo=null,$type = null){
		if($this->isLoggedIn()){
				if($type=='ng'){
				}else{
					$data['active']='Purchase Invoice';
					$data['module']='accounting';
					  if($this->input->server('REQUEST_METHOD')==='POST'){
					  	$purchase_Invoice_No=$this->input->post('purchaseInvoiceNo');
						  $purchaseReturnMaster=array(
						  		'purchaseInvoiceNo'=>$this->input->post('purchaseInvoiceNo'),
						  		'supplierId'=>$this->input->post('supplierId'),
						  		'company_id'=>$this->session->userdata('company_id'),
						  		'salesmanId'=>$this->input->post('salesmanId'),
						  		'currencyId'=>$this->input->post('currencyId'),
						  		'deliveryDate'=>date('Y-m-d',strtotime($this->input->post('deliveryDate'))),
						  		'purchaseInvoiceStatus'=>$this->input->post('purchaseInvoiceStatus'),
						  		'purchaseInvoiceIsPrintAfterSave'=>$this->input->post('purchaseOrderisprintAfterSave'),
						  		'subtotal'=>deformat_value($this->input->post('subtotal')),
						  		'discount'=>deformat_value($this->input->post('discount')),
						  		'freight'=>deformat_value($this->input->post('freight')),
						  		'indirect_expenses'=>$this->input->post('ledgerId'),
						  		'tax'=>$this->input->post('tax_name'),
						  		'tax_amount'=>$this->input->post('tax_return_amount'),
						  		'tax_symbal'=>$this->input->post('tax_symbal'),
						  		'tax_name'=>$this->input->post('tax_name'),
						  		'total'=>deformat_value($this->input->post('total')),
						  		'purchaseInvoiceNarration'=>$this->input->post('narration'),
						  		'payment_return' => deformat_value($this->input->post('payment_return')),
						  	);
						  $purchaseReturnMaster['created_on'] =  date('Y-m-d H:i:s', strtotime($purchaseReturnMaster['deliveryDate'].' '.date('H:i:s')));
						  $products=$this->input->post('product');

						  if(!empty($products)) {
						  	foreach ($products as $product) {
						  		if(isset($product['remaining_qty']) && isset($product['qty'])) {
						  			if((int)$product['qty'] > (int)$product['remaining_qty']) {
						  				$this->session->set_flashdata('error','You cannot return more than its value');
	                             		redirect($_SERVER['HTTP_REFERER']);
						  			}
						  		}
						  	}
						  }
						  $existing_record = $this->purchase_model->universal("SELECT * FROM tbl_purchasereturnmaster WHERE purchaseInvoiceNo = ".$purchaseReturnMaster['purchaseInvoiceNo']." AND company_id =".$this->company_id);
						  $existing_record = ($existing_record) ? $existing_record->row() : null;
						  if(isset($existing_record->id)) {
						  	$savedInpurchaseReturnMaster=$this->purchase_model->update('tbl_purchasereturnmaster', array('id' => $existing_record->id),$purchaseReturnMaster);
						  	$savedInpurchaseReturnMaster = $existing_record->id;
						  } else {
						  	$savedInpurchaseReturnMaster=$this->purchase_model->add('tbl_purchasereturnmaster',$purchaseReturnMaster);
						  }
						  $can_return_more = false;
						  if($savedInpurchaseReturnMaster > 0){
							  	foreach($products as $values){
							  		if(isset($values['qty']))
							  			$values['return_qty'] = $values['qty'];
							  		if(isset($values['unit_discount']))
								  	 	$values['unit_discount'] = deformat_value($values['unit_discount']);
								  	 if(isset($values['rate']))
								  	 	$values['rate'] = deformat_value($values['rate']);
								  	 if(isset($values['amount']))
								  	 	$values['amount'] = deformat_value($values['amount']);
									$values['purchaseInvoiceId']=$this->input->post('purchaseInvoiceNo');
									$abidkhanID['purchaseInvoiceDetailId']=$values['purchaseInvoiceDetailId'];
									unset($values['purchaseInvoiceDetailId']);
									$values['company_id']=$this->session->userdata('company_id');
									if(isset($values['remaining_qty']) && isset($values['qty'])) {
										$diff = (int)$values['remaining_qty'] - (int)$values['qty'];
										if($diff > 0) {
											$can_return_more = true;
										}
										unset($values['remaining_qty']);
									}
									$existing_record = $this->purchase_model->universal("SELECT * FROM tbl_purchasereturndetail WHERE purchaseInvoiceId = ".$values['purchaseInvoiceId']." AND product_id = ".$values['product_id']." AND UOMId = ".$values['UOMId']." AND company_id =".$this->company_id);
									$existing_record = ($existing_record) ? $existing_record->row() : null;
									if(isset($existing_record->id)) {
										$savedInpurchaseReturnDetail=$this->purchase_model->universal("UPDATE tbl_purchasereturndetail SET qty = qty+".$values['qty'].", return_qty = ".$values['return_qty'].", amount = ".$values['amount']." WHERE id = ".$existing_record->id);
										// unset($values['qty']);
										// $savedInpurchaseReturnDetail=$this->purchase_model->update('tbl_purchasereturndetail', array('id' => $existing_record->id),$values);
									} else {
										$savedInpurchaseReturnDetail=$this->purchase_model->add('tbl_purchasereturndetail',$values);
									}
									unset($values['rate']);
									unset($values['amount']);
									unset($values['purchaseInvoiceId']);
									$values['purchaseInvoiceDetailId']=$abidkhanID['purchaseInvoiceDetailId'];
									unset($abidkhanID['purchaseInvoiceDetailId']);
									$purchaseInvoiceMasterId=$this->input->post('purchaseInvoiceNo');
									$where=array('purchaseInvoiceMasterId'=>$purchaseInvoiceMasterId,'purchaseInvoiceDetailId'=>$values['purchaseInvoiceDetailId']);
									// $updateInStock=$this->purchase_model->update('tbl_stockdetails',$where,$values);
									if(isset($values['UOMId']) && $values['product_id']) {
										$update_where = array('UOMId' => $values['UOMId'], 'productName' => $values['product_id'], 'company_id' => $this->company_id);
		                          	 	$purchaseprice = $this->purchase_model->getOne('tbl_purchasepricelist', $update_where);
		                          	 	if(isset($purchaseprice->base_id) && $purchaseprice->base_id) {
		                          	 		$derived_qty = (int)$purchaseprice->base_qty * (int)$values['qty'];
		                          	 		$values['UOMId'] = $purchaseprice->base_id;
		                          	 		$values['qty'] = $derived_qty;
		                          	 	}
						            }
									$qtyy=$values['qty'];
									$productsId=$values['product_id'];
									$uomID=$values['UOMId'];
									$company_id=$this->session->userdata('company_id');
									$query="UPDATE tbl_stockdetails SET  qty= qty -$qtyy WHERE company_id =$company_id  AND product_id=$productsId AND UOMId=$uomID";
									$updateStock=$this->purchase_model->universal($query);
									// echo $query;die();
									// $delete_query="DELETE FROM tbl_purchaseinvoicedetails WHERE id=$values['purchaseInvoiceDetailId'] AND qty <= 0 ";
									$this->purchase_model->delete('tbl_purchaseinvoicedetails',array('id'=>$values['purchaseInvoiceDetailId'],'qty<='=>0));
									if(isset($values['qty']) && $values['qty'] > 0) {
		                          	 	$entry = array(
		                          	 		'product_id' => $values['product_id'],
		                          	 		'unit_id' => $values['UOMId'],
		                          	 		'voucher_type' => 'Purchase Return',
		                          	 		'invoice_no' => $this->input->post('purchaseInvoiceNo'),
		                          	 		'voucher_no' => 'PR-'.sprintf("%0".$this->voucher_number_length."d",$this->input->post('purchaseInvoiceNo')),
		                          	 		'credit' => $values['qty'],
		                          	 		'created_by' => $this->session->userdata('id'),
	                          	 			'created_on' => date('Y-m-d H:i:s'),
		                          	 		'company_id' => $this->company_id
		                          	 	);
		                          	 	$this->purchase_model->add('tbl_stock_ledger_posting', $entry);
		                          	}
	                          }
	                          if($savedInpurchaseReturnDetail > 0 && $updateStock > 0){
	                          	$voucherNo=$voucherNo='PR-'.sprintf("%0".$this->voucher_number_length."d",$this->input->post('purchaseInvoiceNo'));

	                          	$subtotal = (float)deformat_value($this->input->post('subtotal'));
	                          	$freight = (float)deformat_value($this->input->post('freight'));
	                          	$total_with_freight = $subtotal + $freight;
	                          	$tax_id = (int)$this->input->post('tax_name');
	                          	$tax_row = $this->purchase_model->getById('tbl_accountledger', $tax_id);
	                          	$tax_amount = 0;
	                          	if(isset($tax_row->tax_value)) {
	                          		$tax_amount = (float)$tax_row->tax_value;
	                          		if($tax_row->tax_symbal == '%') {
	                          			$tax_amount = ($tax_amount*$total_with_freight)/100;
	                          		}
	                          	}

	                          	$total_with_tax = $total_with_freight + $tax_amount;
                          		$discount = (float)deformat_value($this->input->post('discount'));
                          		$discount_type = $this->input->post('discount_type');
                          		if($discount_type == '%') {
                          			$discount = ($discount*$total_with_tax)/100;
                          		}
                          		$total = $total_with_tax - $discount;

                          		$ledgerpostingDiscountCheck = 0;
	                          	if($discount > 0):
		                          	$ledgerpostingDiscount['voucherTypeId']=14;
		                          	$ledgerpostingDiscount['voucherNo']=$voucherNo;
		                          	$ledgerpostingDiscount['ledgerId']=9;
		                          	$ledgerpostingDiscount['debit']=$discount;
		                          	$ledgerpostingDiscount['yearId']=$this->getActiveYearId();
		                          	$ledgerpostingDiscount['invoiceNo']=$savedInpurchaseReturnMaster;
		                          	$ledgerpostingDiscount['date']=date("Y-m-d H:i:s");
		                          	$ledgerpostingDiscount['company_id']=$this->session->userdata('company_id');
		                          	$ledgerpostingDiscountCheck=$this->purchase_model->add('tbl_ledgerposting',$ledgerpostingDiscount);
		                        endif;
		                        if($this->input->post('supplierId') == 1){
	                          		$ledgerpostingCash['voucherTypeId']=14;
		                          	$ledgerpostingCash['voucherNo']=$voucherNo;
		                          	$ledgerpostingCash['debit']=$total;
		                          	$ledgerpostingCash['ledgerId']=1;
		                          	$ledgerpostingCash['yearId']=$this->getActiveYearId();
		                          	$ledgerpostingCash['invoiceNo']=$savedInpurchaseReturnMaster;
		                          	$ledgerpostingCash['date']=date("Y-m-d H:i:s");
		                          	$ledgerpostingCash['company_id']=$this->session->userdata('company_id')
;		                          	$ledgerpostingCash=$this->purchase_model->add('tbl_ledgerposting',$ledgerpostingCash);

		                          	$ledgerpostingPurchase['voucherTypeId']=14;
		                          	$ledgerpostingPurchase['voucherNo']=$voucherNo;
		                          	$ledgerpostingPurchase['credit']=$total;
		                          	$ledgerpostingPurchase['ledgerId']=11;
		                          	$ledgerpostingPurchase['yearId']=$this->getActiveYearId();
		                          	$ledgerpostingPurchase['invoiceNo']=$savedInpurchaseReturnMaster;
		                          	$ledgerpostingPurchase['date']=date("Y-m-d H:i:s");
		                          	$ledgerpostingPurchase['company_id']=$this->session->userdata('company_id');
		                          	$ledgerpostingPurchase=$this->purchase_model->add('tbl_ledgerposting',$ledgerpostingPurchase);
	                          	} else {
		                          	if(deformat_value($this->input->post('payment_return')) == 0){
			                            $ledgerpostingPurchaseDebit['voucherTypeId']=14;
			                          	$ledgerpostingPurchaseDebit['voucherNo']=$voucherNo;
			                          	$ledgerpostingPurchaseDebit['credit']=$total;
			                          	$ledgerpostingPurchaseDebit['ledgerId']=11;
			                          	$ledgerpostingPurchaseDebit['yearId']=$this->getActiveYearId();
			                          	$ledgerpostingPurchaseDebit['invoiceNo']=$savedInpurchaseReturnMaster;
			                          	$ledgerpostingPurchaseDebit['date']=date("Y-m-d H:i:s");
			                          	$ledgerpostingPurchaseDebit['company_id']=$this->session->userdata('company_id');
			                          	$ledgerpostingPurchaseDebit=$this->purchase_model->add('tbl_ledgerposting',$ledgerpostingPurchaseDebit);

			                          	$ledgerpostingSuppliersCredit['voucherTypeId']=14;
			                          	$ledgerpostingSuppliersCredit['voucherNo']=$voucherNo;
			                          	$ledgerpostingSuppliersCredit['debit']=$total;
			                          	$ledgerpostingSuppliersCredit['ledgerId']=$this->input->post('supplierId');
			                          	$ledgerpostingSuppliersCredit['yearId']=$this->getActiveYearId();
			                          	$ledgerpostingSuppliersCredit['invoiceNo']=$savedInpurchaseReturnMaster;
			                          	$ledgerpostingSuppliersCredit['date']=date("Y-m-d H:i:s");
			                          	$ledgerpostingSuppliersCredit['company_id']=$this->session->userdata('company_id');
			                          	$ledgerpostingSuppliersCredit=$this->purchase_model->add('tbl_ledgerposting',$ledgerpostingSuppliersCredit);

		                            }else if($total > deformat_value($this->input->post('payment_return'))) {
		                          		$ledgerpostingPurchaseDebit['voucherTypeId']=14;
			                          	$ledgerpostingPurchaseDebit['voucherNo']=$voucherNo;
			                          	$ledgerpostingPurchaseDebit['credit']=$total;
			                          	$ledgerpostingPurchaseDebit['ledgerId']=11;
			                          	$ledgerpostingPurchaseDebit['yearId']=$this->getActiveYearId();
			                          	$ledgerpostingPurchaseDebit['invoiceNo']=$savedInpurchaseReturnMaster;
			                          	$ledgerpostingPurchaseDebit['date']=date("Y-m-d H:i:s");
			                          	$ledgerpostingPurchaseDebit['company_id']=$this->session->userdata('company_id');
			                          	$ledgerpostingPurchaseDebit=$this->purchase_model->add('tbl_ledgerposting',$ledgerpostingPurchaseDebit);

			                          	$ledgerpostingSupllierCredit['voucherTypeId']=14;
			                          	$ledgerpostingSupllierCredit['voucherNo']=$voucherNo;
			                          	$ledgerpostingSupllierCredit['debit']=$total;
			                          	$ledgerpostingSupllierCredit['credit']=deformat_value($this->input->post('payment_return'));
			                          	$ledgerpostingSupllierCredit['ledgerId']=$this->input->post('supplierId');
			                          	$ledgerpostingSupllierCredit['yearId']=$this->getActiveYearId();
			                          	$ledgerpostingSupllierCredit['invoiceNo']=$savedInpurchaseReturnMaster;
			                          	$ledgerpostingSupllierCredit['date']=date("Y-m-d H:i:s");
			                          	$ledgerpostingSupllierCredit['company_id']=$this->session->userdata('company_id');
			                          	$ledgerpostingSupllierCredit=$this->purchase_model->add('tbl_ledgerposting',$ledgerpostingSupllierCredit);

			                          	// $ledgerpostingSupplerDebit['voucherTypeId']=13;
			                          	// $ledgerpostingSupplerDebit['voucherNo']=$voucherNo;
			                          	// $ledgerpostingSupplerDebit['credit']=$this->input->post('payment_return');
			                          	// $ledgerpostingSupplerDebit['ledgerId']=$this->input->post('supplierId');
			                          	// $ledgerpostingSupplerDebit['yearId']=$this->getActiveYearId();
			                          	// $ledgerpostingSupplerDebit['invoiceNo']=$savedInpurchaseReturnMaster;
			                          	// $ledgerpostingSupplerDebit['date']=date("Y-m-d");
			                          	// $ledgerpostingSupplerDebit['company_id']=$this->session->userdata('company_id');
			                          	// $ledgerpostingSupplerDebit=$this->purchase_model->add('tbl_ledgerposting',$ledgerpostingSupplerDebit);

			                          	$ledgerpostingCashCredits['voucherTypeId']=14;
			                          	$ledgerpostingCashCredits['voucherNo']=$voucherNo;
			                          	$ledgerpostingCashCredits['debit']=deformat_value($this->input->post('payment_return'));
			                          	$ledgerpostingCashCredits['ledgerId']=1;
			                          	$ledgerpostingCashCredits['yearId']=$this->getActiveYearId();
			                          	$ledgerpostingCashCredits['invoiceNo']=$savedInpurchaseReturnMaster;
			                          	$ledgerpostingCashCredits['date']=date("Y-m-d H:i:s");
			                          	$ledgerpostingCashCredits['company_id']=$this->session->userdata('company_id');
			                          	$ledgerpostingCashCredits=$this->purchase_model->add('tbl_ledgerposting',$ledgerpostingCashCredits);

		                            }else if($total == deformat_value($this->input->post('payment_return'))) {
		                          	    $ledgerpostingPurchaseDebit['voucherTypeId']=14;
			                          	$ledgerpostingPurchaseDebit['voucherNo']=$voucherNo;
			                          	$ledgerpostingPurchaseDebit['credit']=$total;
			                          	$ledgerpostingPurchaseDebit['ledgerId']=11;
			                          	$ledgerpostingPurchaseDebit['yearId']=$this->getActiveYearId();
			                          	$ledgerpostingPurchaseDebit['invoiceNo']=$savedInpurchaseReturnMaster;
			                          	$ledgerpostingPurchaseDebit['date']=date("Y-m-d H:i:s");
			                          	$ledgerpostingPurchaseDebit['company_id']=$this->session->userdata('company_id');
			                          	$ledgerpostingPurchaseDebit=$this->purchase_model->add('tbl_ledgerposting',$ledgerpostingPurchaseDebit);

			                          	$ledgerpostingSupllierCredit['voucherTypeId']=14;
			                          	$ledgerpostingSupllierCredit['voucherNo']=$voucherNo;
			                          	$ledgerpostingSupllierCredit['debit']=$total;
			                          	$ledgerpostingSupllierCredit['credit']=deformat_value($this->input->post('payment_return'));
			                          	$ledgerpostingSupllierCredit['ledgerId']=$this->input->post('supplierId');
			                          	$ledgerpostingSupllierCredit['yearId']=$this->getActiveYearId();
			                          	$ledgerpostingSupllierCredit['invoiceNo']=$savedInpurchaseReturnMaster;
			                          	$ledgerpostingSupllierCredit['date']=date("Y-m-d H:i:s");
			                          	$ledgerpostingSupllierCredit['company_id']=$this->session->userdata('company_id');
			                          	$ledgerpostingSupllierCredit=$this->purchase_model->add('tbl_ledgerposting',$ledgerpostingSupllierCredit);

			                          	// $ledgerpostingSupplerDebit['voucherTypeId']=13;
			                          	// $ledgerpostingSupplerDebit['voucherNo']=$voucherNo;
			                          	// $ledgerpostingSupplerDebit['credit']=$this->input->post('payment_return');
			                          	// $ledgerpostingSupplerDebit['ledgerId']=$this->input->post('supplierId');
			                          	// $ledgerpostingSupplerDebit['yearId']=$this->getActiveYearId();
			                          	// $ledgerpostingSupplerDebit['invoiceNo']=$savedInpurchaseReturnMaster;
			                          	// $ledgerpostingSupplerDebit['date']=date("Y-m-d");
			                          	// $ledgerpostingSupplerDebit['company_id']=$this->session->userdata('company_id');
			                          	// $ledgerpostingSupplerDebit=$this->purchase_model->add('tbl_ledgerposting',$ledgerpostingSupplerDebit);

			                          	$ledgerpostingCashCredits['voucherTypeId']=14;
			                          	$ledgerpostingCashCredits['voucherNo']=$voucherNo;
			                          	$ledgerpostingCashCredits['debit']=deformat_value($this->input->post('payment_return'));
			                          	$ledgerpostingCashCredits['ledgerId']=1;
			                          	$ledgerpostingCashCredits['yearId']=$this->getActiveYearId();
			                          	$ledgerpostingCashCredits['invoiceNo']=$savedInpurchaseReturnMaster;
			                          	$ledgerpostingCashCredits['date']=date("Y-m-d H:i:s");
			                          	$ledgerpostingCashCredits['company_id']=$this->session->userdata('company_id');
			                          	$ledgerpostingCashCredits=$this->purchase_model->add('tbl_ledgerposting',$ledgerpostingCashCredits);
		                            }
		                        }
	                          	// $ledgerpostingTotal['voucherTypeId']=13;
	                          	// $ledgerpostingTotal['voucherNo']=$voucherNo;
	                          	// $ledgerpostingTotal['ledgerId']=$this->input->post('supplierId');
	                          	// $ledgerpostingTotal['debit']=$total;
	                          	// $ledgerpostingTotal['yearId']=$this->getActiveYearId();
	                          	// $ledgerpostingTotal['invoiceNo']=$savedInpurchaseReturnMaster;
	                          	// $ledgerpostingTotal['date']=date("Y-m-d");
	                          	// $ledgerpostingTotal['company_id']=$this->session->userdata('company_id');
	                          	// $ledgerpostingtotal=$this->purchase_model->add('tbl_ledgerposting',$ledgerpostingTotal);
	                          	
	                          	
	                          	// $ledgerpostingDedit['voucherTypeId']=13;
	                          	// $ledgerpostingDedit['voucherNo']=$voucherNo;
	                          	// $ledgerpostingDedit['ledgerId']=11;
	                          	// $ledgerpostingDedit['credit']=$total;
	                          	// $ledgerpostingDedit['yearId']=$this->getActiveYearId();
	                          	// $ledgerpostingDedit['invoiceNo']=$savedInpurchaseReturnMaster;
	                          	// $ledgerpostingDedit['date']=date("Y-m-d");
	                          	// $ledgerpostingDedit['company_id']=$this->session->userdata('company_id');
	                          	// $ledgerpostingDedit=$this->purchase_model->add('tbl_ledgerposting',$ledgerpostingDedit);
	                          	// $ledgerpostingFreightCheck = 0;
	                          	// if($this->input->post('ledgerId') > 0):
		                          // 	$ledgerpostingFreight['yearId']=$this->getActiveYearId();
		                          // 	$ledgerpostingFreight['voucherTypeId']=13;
		                          // 	$ledgerpostingFreight['voucherNo']=$voucherNo;
		                          // 	$ledgerpostingFreight['ledgerId']=$this->input->post('ledgerId');
		                          // 	$ledgerpostingFreight['date']=date("Y-m-d");
		                          // 	$ledgerpostingFreight['company_id']=$this->session->userdata('company_id');
		                          // 	$ledgerpostingFreight['credit']=$freight;
		                          // 	$ledgerpostingFreight['invoiceNo']=$savedInpurchaseReturnMaster;
		                          // 	$ledgerpostingFreightCheck=$this->purchase_model->add('tbl_ledgerposting',$ledgerpostingFreight);
	                          	// endif;
	                          	$ledgerpostingTaxCheck = 0;
	                          	if($tax_amount > 0):
	                          	$ledgerpostingTax['yearId']=$this->getActiveYearId();
	                          	$ledgerpostingTax['voucherTypeId']=14;
	                          	$ledgerpostingTax['voucherNo']=$voucherNo;
	                          	$ledgerpostingTax['ledgerId']=$this->input->post('tax_name');
	                          	$ledgerpostingTax['date']=date("Y-m-d H:i:s");
	                          	$ledgerpostingTax['company_id']=$this->session->userdata('company_id');
	                          	$ledgerpostingTax['credit']=$tax_amount;
	                          	$ledgerpostingTax['invoiceNo']=$savedInpurchaseReturnMaster;
	                          	$ledgerpostingTaxCheck=$this->purchase_model->add('tbl_ledgerposting',$ledgerpostingTax);
	                          	endif;
                          		if(!$can_return_more) {
                          			$update=$this->purchase_model->update('tbl_purchaseinvoicemaster',array('purchaseInvoiceNo'=>$purchase_Invoice_No),array('isReturn'=>1));
                          		}
                          		$update=$this->purchase_model->update('tbl_purchaseinvoicemaster',array('purchaseInvoiceNo'=>$purchase_Invoice_No),array('can_edit'=>0));
	                          	// if($ledgerpostingDiscountCheck > 0 && $ledgerpostingTaxCheck>0){
		                          	if($this->input->post('save_print')) {
								   		if(isset($savedInpurchaseReturnMaster) && $savedInpurchaseReturnMaster > 0) {
								   			$this->session->set_flashdata('print_purchase_return', $savedInpurchaseReturnMaster);
								   			// $this->printReturn($savedInpurchaseReturnMaster);
								   		}
								   	}
		                          	$this->session->set_flashdata('success',con_lang('mass_purchase_return_added_successfully'));
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
					}
					if($purchaseInvoiceNo!=null){
						$data['model']=(array)$this->purchase_model->getByIdPurchaseInvoice(decode_uri($purchaseInvoiceNo));
					}
					$data['taxesOnBill']=$this->purchase_model->getAll('tbl_accountledger',array('product_bill'=>'bill','company_id'=>$this->company_id, 'accountGroupId' => 20));
					$data['currency']=$this->purchase_model->getCurrency();
					$this->displayView('accounting/purchases/purchase_return',$data,array(),array(
							'js'=>array(),
							'css'=>array(),
						));
				}
		}else{
			redirect('auth');
		}
	}
	public function getAppliedTaxesOnProduct($type = null){
		if($this->isLoggedIn()){
			if($type == 'ng'){

			}else{
				if($this->input->post('productID')){
					$company_id=$this->session->userdata('company_id');
					$result=$this->purchase_model->getAppliedTaxOnProduct($this->input->post('productID'));
					if(!empty($result)){
						$query="SELECT * FROM tbl_accountledger WHERE company_id=$company_id AND id IN ($result->taxes) AND product_bill='product'";
						$taxes =$this->purchase_model->universal($query)->result();
						 echo json_encode($taxes);exit();
						
					}
					
				}
			}

		}else{
			redirect('auth');
		}
	}
	public function getPQRegardingSupplier($type = null){
		if($this->isLoggedIn()){
			if($type == 'ng'){

			}else{
				if($this->input->post('supplierID')){
					$supplierID=$this->input->post('supplierID');
					$query="SELECT qoutationNo FROM tbl_purchaseqoutationmaster WHERE supplierId =$supplierID AND status=0 AND company_id=$this->company_id";
					 $result=$this->purchase_model->universal($query)->result();
					 echo json_encode($result);exit();
				}
			}

		}else{
			redirect('auth');
		}
	}

	public function invoice($id = null)
	{
		if($this->isLoggedIn()){
			 $data['active']='Purchase Quotation';
					$data['module']='accounting';
			$this->load->model('reports_model');
			$this->load->model('purchase_model');
			$model = (object)$this->purchase_model->getOne('tbl_purchaseinvoicemaster', array('purchaseInvoiceNo' => $id, 'company_id' => $this->company_id));
			if(isset($model->supplierId)) {
				$data['ledger'] = $this->purchase_model->getOne('tbl_accountledger', array('id' => $model->supplierId));
			}
			if(isset($model->purchaseInvoiceNo)) {
				$data['products'] = $this->purchase_model->getAll('tbl_purchaseinvoicedetails', array('purchaseInvoiceId' => $model->purchaseInvoiceNo, 'company_id' => $this->company_id));
				if(!empty($data['products'])) {
					foreach ($data['products'] as &$key) {
						if(isset($key->tax_id)) {
							$key->tax = $this->purchase_model->getById('taxes', $key->tax_id);
						}
						if(isset($key->UOMId)) {
							$key->unit = $this->purchase_model->getById('tbl_uom', $key->UOMId);
						}
					}
				}
			}
			$data['currency'] = 'USD';
			$currencyName=$this->reports_model->getOne('tbl_currency',array('company_id'=>$this->company_id));
            if(!empty($currencyName)){
               $data['currency'] =$currencyName->currency_code;
            }
			$data['number'] = $model->purchaseInvoiceNo;
			$data['model'] = $model;
			$data['is_print'] = true;
		  	$data['title'] = 'Purchase Invoice';
		   	$this->displayView('accounting/purchases/purchase_report' ,$data,array(),array(
							'js'=>array(),
							'css'=>array(),
						));

		}else{
			redirect('auth');
		}
	}
	public function getPurchaseInvoiceNumber($supplierId=null){
		if($supplierId!=null){
			$query="SELECT purchaseInvoiceNo FROM tbl_purchaseinvoicemaster WHERE supplierId = $supplierId AND company_id = ".$this->company_id;
			$data=$this->purchase_model->universal($query)->result();
			echo json_encode($data);exit();
		}
	}
}