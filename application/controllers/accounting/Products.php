<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
require_once(APPPATH."controllers/accounting/ERPController.php");
class Products extends ERPController{
	function __construct(){
		parent::__construct();
		if(!$this->isLoggedIn()){
			redirect('auth');
		}
		$this->load->model('common_model');
		$this->load->model('product_model');
		$this->load->library('products/products_list');
		$this->load->library('color_list');
		$this->load->library('barcode');
	}
	public function category(){
		$data['active']='Product Categories';
		$data['module']='accounting';
		$data['catagories']=$this->product_model->getAll('tbl_productgroup',array('company_id'=>$this->session->userdata('company_id')));
		$this->displayView('accounting/catagories/list_view',$data,array(),array(
				'js'=>array(),
				'css'=>array(),
			));
	}
	public function promotion() {
		$data['active']='Promotion';
		$data['module']='accounting';
		$data['products']=$this->product_model->getAll('tbl_product',array('company_id'=>$this->session->userdata('company_id')));
		$query="SELECT * FROM tbl_productgroup WHERE tbl_productgroup.id IN (SELECT groupId FROM tbl_product) AND status='active' AND company_id=$this->company_id";
		$data['product_groups']=$this->product_model->universal($query)->result();
		$this->displayView('accounting/products/apply_promotion',$data,array(),array(
				'js'=>array(),
				'css'=>array(),
			));
	}
	public function stockInvoices() {
		$data['active']='Stock Count';
		$data['module']='accounting';
		$data['invoices']=$this->product_model->getAll('tbl_stock_invoices',array('company_id'=>$this->session->userdata('company_id')));
		$this->displayView('accounting/stock/invoices',$data,array(),array(
				'js'=>array(),
				'css'=>array(),
			));
	}
	public function viewStockInvoice($id = null, $print = null) {
		$data['active']='Stock Count';
		$data['module']='accounting';
		if($print == 'print') {
			$data['is_print'] = true;
		}
		if($id!=null){
			$data['model']=$this->product_model->getStockInvoiceById($id);
			if(isset($data['model']->id)) {
				$query = $this->product_model->universal("
					SELECT
					tbl_product.productName as product_name,
					tbl_uom.UOMName as unit_name,
					tbl_product.product_code as code,
					tbl_purchasepricelist.saleRate as sale_price,
					tbl_purchasepricelist.purchaseRate as cost_price,
					tbl_stock_invoice_items.expected_qty as expected_qty,
					tbl_stock_invoice_items.counted_qty as counted_qty,
					(tbl_stock_invoice_items.counted_qty - tbl_stock_invoice_items.expected_qty) as difference,
					((tbl_stock_invoice_items.counted_qty - tbl_stock_invoice_items.expected_qty) * tbl_purchasepricelist.purchaseRate) as total_cost_price,
					((tbl_stock_invoice_items.counted_qty - tbl_stock_invoice_items.expected_qty) * tbl_purchasepricelist.saleRate) as total_sale_price
					FROM tbl_stock_invoice_items
					LEFT JOIN tbl_purchasepricelist ON ( tbl_purchasepricelist.productName = tbl_stock_invoice_items.product_id AND tbl_purchasepricelist.UOMId = tbl_stock_invoice_items.unit_id AND tbl_purchasepricelist.company_id = tbl_stock_invoice_items.company_id)
					LEFT JOIN tbl_product ON (tbl_stock_invoice_items.product_id = tbl_product.id AND tbl_stock_invoice_items.company_id = tbl_product.company_id)
					LEFT JOIN tbl_uom ON (tbl_stock_invoice_items.unit_id = tbl_uom.id AND tbl_stock_invoice_items.company_id = tbl_uom.company_id)
					WHERE tbl_stock_invoice_items.invoice_id = ".$data['model']->id);
				if($query) {
					$data['items'] = $query->result();
				}
			}
		} else {
			redirect($_SERVER['HTTP_REFERER']);
		}
		if($print == 'print') {
			$this->displayView('accounting/stock/view_stock_count',$data,array('topbar', 'sidenav'),array(
				'js'=>array(),
				'css'=>array(),
			));
		} else {
			$this->displayView('accounting/stock/view_stock_count',$data,array(),array(
				'js'=>array(),
				'css'=>array(),
			));
		}
	}
	public function createStockInvoice($id=null){
		$data['active']='Stock Count';
		$data['module']='accounting';
		if($this->input->server('REQUEST_METHOD') === 'POST'){
			$formData=$this->input->post();
			if(!isset($formData['items']))
				redirect($_SERVER['HTTP_REFERER']);
			$items = $formData['items'];

			$next_invoice = (int)$this->product_model->countRecords('tbl_stock_invoices', array('company_id' => $this->company_id));
			$next_invoice++;
			$voucherNo = 'SO-'.sprintf('%05d', $next_invoice);
			$invoice = array(
				'company_id' => $this->company_id,
				'invoice_no' => $voucherNo,
				'created_by' => $this->session->userdata('id')
			);
			$invoice_id = $this->product_model->add('tbl_stock_invoices', $invoice);
			if(!empty($items)) {
				$records = array();
				foreach ($items as $item) {
					if(!isset($item['counted_qty']) || $item['counted_qty'] === '')
						continue;
					$existing_item = $this->product_model->getOne('tbl_stock_invoice_items', array('company_id' => $this->company_id, 'product_id' => $item['product_id'], 'unit_id' => $item['unit_id'], 'invoice_id' => $invoice_id));
					if($this->input->post('apply_inventory')) {
						$item['is_applied'] = 1;
						$item['applied_date'] = date('Y-m-d H:i:s');
						if(isset($item['product_id']) && isset($item['unit_id'])) {
							$where = array('product_id' => $item['product_id'], 'UOMId' => $item['unit_id'], 'company_id' => $this->company_id);
							$this->product_model->update('tbl_stockdetails', $where, array('qty' => $item['counted_qty']));
						}

						if(isset($item['counted_qty']) && $item['counted_qty'] > 0) {
							$diff = (int)$item['counted_qty'] - (int)$item['expected_qty'];
							$key = ($diff > 0) ? 'debit' : 'credit';
					  		$existing = $this->product_model->getOne('tbl_stock_ledger_posting', array('company_id' => $this->company_id,  'product_id' => $item['product_id'], 'unit_id' => $item['unit_id'], 'voucher_no' => $voucherNo));
					  		if(isset($existing->id)) {
					  			$this->product_model->update('tbl_stock_ledger_posting', array('id' => $existing->id), array($key => abs($diff)));
					  		} else {
                          	 	$entry = array(
                          	 		'product_id' => $item['product_id'],
                          	 		'unit_id' => $item['unit_id'],
                          	 		'voucher_type' => 'Stock Adjustment',
                          	 		'voucher_no' => $voucherNo,
                          	 		$key => abs($diff),
                          	 		'created_by' => $this->session->userdata('id'),
                          	 		'company_id' => $this->company_id
                          	 	);
                          	 	$this->product_model->add('tbl_stock_ledger_posting', $entry);
                      	 	}
                      	}
                      	$ledgerpostingCash = array();
                      	if($diff > 0) {
	                      	$ledgerpostingCash['voucherTypeId']=34;
	                      	$ledgerpostingCash['voucherNo']=$voucherNo;
	                      	$ledgerpostingCash['debit']=$diff * (float)$item['cost_price'];
	                      	$ledgerpostingCash['ledgerId']=11;
	                      	$ledgerpostingCash['yearId']=$this->getActiveYearId();
	                      	$ledgerpostingCash['invoiceNo']=$invoice_id;
	                      	$ledgerpostingCash['date']=date("Y-m-d");
	                      	$ledgerpostingCash['company_id']=$this->session->userdata('company_id');
	   		                $this->product_model->add('tbl_ledgerposting',$ledgerpostingCash);
						} else if($diff < 0) {
							$ledgerpostingCash['voucherTypeId']=34;
	                      	$ledgerpostingCash['voucherNo']=$voucherNo;
	                      	$ledgerpostingCash['credit']=abs($diff) * (float)$item['sale_price'];
	                      	$ledgerpostingCash['ledgerId']=10;
	                      	$ledgerpostingCash['yearId']=$this->getActiveYearId();
	                      	$ledgerpostingCash['invoiceNo']=$invoice_id;
	                      	$ledgerpostingCash['date']=date("Y-m-d");
	                      	$ledgerpostingCash['company_id']=$this->session->userdata('company_id');
	   		                $this->product_model->add('tbl_ledgerposting',$ledgerpostingCash);
						}
					}
					unset($item['cost_price']);
					unset($item['sale_price']);
					if(isset($existing_item->id)) {
						array_push($records, $existing_item->id);
						$this->product_model->update('tbl_stock_invoice_items', array('id' => $existing_item->id), $item);
					} else {
						$item['invoice_id'] = $invoice_id;
						$item['company_id'] = $this->company_id;
						$record_id = $this->product_model->add('tbl_stock_invoice_items', $item);
						array_push($records, $record_id);
					}
				}
			}
			if(isset($formData['print'])) {
				$this->session->set_flashdata('print_stock_count', $invoice_id);
				// redirect('accounting/products/viewStockInvoice/'.$invoice_id.'/print');
			}
			$this->session->set_flashdata('success', 'Invoice Saved Successfully!');
			redirect($_SERVER['HTTP_REFERER']);
		}
		if(isset($id) && $id!=null){
			$data['model']=$this->product_model->getById('tbl_stock_invoices',$id);
			if(isset($data['model']->id)) {
				$query = $this->product_model->universal("
					SELECT
					tbl_stock_invoice_items.product_id as product_id,
					tbl_stock_invoice_items.unit_id as unit_id,
					tbl_product.product_code as code,
					tbl_stock_invoice_items.expected_qty as expected_qty,
					tbl_stock_invoice_items.counted_qty as counted_qty,
					(tbl_stock_invoice_items.counted_qty - tbl_stock_invoice_items.expected_qty) as difference
					FROM tbl_stock_invoice_items
					LEFT JOIN tbl_product
					ON tbl_stock_invoice_items.product_id = tbl_product.id
					WHERE tbl_stock_invoice_items.invoice_id = ".$data['model']->id);
				if($query) {
					$data['items'] = $query->result();
				}
			}
		}
		$data['products']=$this->product_model->getAll('tbl_product',array('company_id'=>$this->session->userdata('company_id')));
		$data['units']=$this->product_model->getAll('tbl_uom',array('company_id'=>$this->session->userdata('company_id')));
		$this->displayView('accounting/stock/add_stock_invoice',$data,array(),array(
				'js'=>array(),
				'css'=>array(),
			));
	}
	public function addCatagory($id=null){
		$data['active']='Product Categories';
		$data['module']='accounting';
		if($this->input->server('REQUEST_METHOD') === 'POST'){
			$formData=$this->input->post();
			unset($formData['submit']);
			$formData['company_id']=$this->session->userdata('company_id');
			if(isset($formData['id']) && !empty($formData['id'])){
				$update=$this->product_model->update('tbl_productgroup',array('id'=>$formData['id']),$formData);
				if($update){
					$this->session->set_flashdata('success',con_lang('mass_catagory_updated_successfully'));
					redirect($_SERVER['HTTP_REFERER']);
				}else{
					$this->session->set_flashdata('error',con_lang('mass_error_occurrs_try_later'));
					redirect($_SERVER['HTTP_REFERER']);
				}
			}else{
				unset($formData['id']);
				$saved=$this->product_model->add('tbl_productgroup',$formData);
				if($saved){
					$this->session->set_flashdata('success',con_lang('mass_catagory_added_successfully'));
					redirect($_SERVER['HTTP_REFERER']);
				}else{
					$this->session->set_flashdata('error',con_lang('mass_error_occurrs_try_later'));
					redirect($_SERVER['HTTP_REFERER']);
				}
			}
		}
		if(isset($id) && $id!=null){
			$data['model']=(array)$this->product_model->getById('tbl_productgroup',$id);
		}
		$this->displayView('accounting/catagories/add_product_catagory',$data,array(),array(
				'js'=>array(),
				'css'=>array(),
			));
	}
	public function products(){
		$data['active']='Products';
		$data['module']='accounting';
		$data['all_products']=$this->products_list->select();
		// echo '<pre>',print_r($data['all_products']),'</pre>';exit();
		$data['products']=$this->product_model->getAll('tbl_product',array('company_id'=>$this->session->userdata('company_id')));
		$this->displayView('accounting/products/list_view',$data,array(),array(
				'js'=>array(),
				'css'=>array(),
			));
	}
	public function all_categories($cate_id=null)
	{
		$data['active']='barcode_label';
		$data['module']='accounting';
		$this->load->library('categories/categories');
		$data['all_categories']=$this->categories->select();
		if($cate_id!=null)
		{
			$this->session->set_userdata('cate_id',$cate_id);
			$data['category_id']=$cate_id;
			$data['all_products']=$this->products_list->select(array('tbl_product.categories LIKE' =>$cate_id),array('prod_id'=>'desc'),null,null,1);
			// debug($data['all_products']);
		}
		$this->displayView('accounting/products/barcode_labels',$data,array(),array(
				'js'=>array(),
				'css'=>array(),
			));
	}
	public function barcode_label($prod_no = null)
	{
		$data['active']='barcode_label';
		$data['module']='accounting';
		$this->load->library('categories/categories');
		$this->load->library('categories/categories_tree');
		$data['category_id']=$this->session->userdata('cate_id');
		$data['all_products']=$this->products_list->select(array('tbl_product.categories LIKE' =>$data['category_id']),array('prod_id'=>'desc'),null,null,1);
		$data['all_categories']=$this->categories->select();
		if($prod_no!=null)
		{
			$data['product_by_prod_no']=$this->products_list->select(array($prod_no));
			if(!empty($data['product_by_prod_no']))
			{
				$in_array_vendor_code=array();
				$in_array_color_code=array();
				foreach($data['product_by_prod_no'] as $key => &$value) {
					if(isset($value->color_code))
					{
						if(!in_array($value->color_code, $in_array_color_code)){
							$value->colorcodes=$this->color_list->select(array('color_code'=>$value->color_code))[0];
						}
						array_push($in_array_color_code, $value->color_code);
					}
					if(isset($value->vendor_id))
					{
						if(!in_array($value->vendor_id, $in_array_vendor_code)){
							$value->vendorcodes=$this->products_list->select_vendor(array('vendor_id'=>$value->vendor_id))[0];
						}
						array_push($in_array_vendor_code, $value->vendor_id);
					}
				}
			}
			$data['prod_no']=$prod_no;
		}
		if($this->input->post())
		{
			$formData=$this->input->post();
			// debug($formData);
			$data['prod_no']=isset($formData['prod_no']) ? $formData['prod_no'] :'';
			$data['product_by_prod_no']=$this->products_list->select(array($data['prod_no']));
			if(!empty($data['product_by_prod_no']))
			{
				$in_array_vendor_code=array();
				$in_array_color_code=array();
				foreach($data['product_by_prod_no'] as $key => &$value) {
					if(isset($value->color_code))
					{
						if(!in_array($value->color_code, $in_array_color_code)){
							$value->colorcodes=$this->color_list->select(array('color_code'=>$value->color_code))[0];
						}
						array_push($in_array_color_code, $value->color_code);
					}
					if(isset($value->vendor_id))
					{
						if(!in_array($value->vendor_id, $in_array_vendor_code)){
							$value->vendorcodes=$this->products_list->select_vendor(array('vendor_id'=>$value->vendor_id))[0];
						}
						array_push($in_array_vendor_code, $value->vendor_id);
					}
				}
			}
			$data['color_code']=isset($formData['color_code']) ? $formData['color_code'] :'';
			$data['vendor_code']=isset($formData['vendor_code']) ? $formData['vendor_code'] :'';
			$data['size']=isset($formData['size']) ? $formData['size'] :'';
			if(isset($formData['prod_no']) && $formData['prod_no']!='')
			{
				$data['code']=$data['prod_no'];
			}
			if(isset($formData['color_code']) && $formData['color_code']!='')
			{
				$data['code'].='_'.$formData['color_code'];
			}
			// $data['code'].='_'.$data['whole_sale_price'];
			if(isset($formData['vendor_code']) && $formData['vendor_code']!='')
			{
				$data['code'].='_'.$formData['vendor_code'];
			}
			if(isset($formData['size']) && $formData['size']!='')
			{
				$data['code'].='_'.$formData['size'];
			}
			if(isset($data['category']) && $data['category']!='')
			{
				$data['code'].='_'.$data['category'];
			}
			$data['barcode_code']=$this->barcode->generate_barcode($data['code']);
			$vendor_id=$this->products_list->select_vendor(array('vendor_code'=>$data['vendor_code']))[0]->vendor_id;
			$colors=$this->color_list->select(array('color_code'=>$data['color_code']))[0]->color_name;
			$where=array('prod_no'=>$data['prod_no'],'vendor_id'=>$vendor_id,'colors'=>$colors);
			// debug($where);
			$this->products_list->update_product('tbl_product',$where,array('product_barcode'=>$data['code']));
			
		}
		$this->displayView('accounting/products/barcode_labels',$data,array(),array(
				'js'=>array(),
				'css'=>array(),
			));
	}
	public function barcodes($code=null)
	{
		if($code!=null)
		{
			$data['barcode_code']=$this->barcode->generate_barcode($code);
			$data['code']=$code;
			$this->load->view('accounting/products/print_barcode',$data);
		}
	}
	public function barcodesprint($code=null)
	{
		if($code!=null)
		{
			$this->session->set_flashdata('print_product_barcode',$code);
			redirect($_SERVER['HTTP_REFERER']);
		}
	}
	public function printbarcode($code=null)
	{
		if($code!=null)
		{
			$data['barcode_code']=$this->barcode->generate_barcode($code);
			$data['code']=$code;
			$this->load->view('accounting/products/print_label',$data);
		}
	}
	public function addProduct($id=null){
		$data['active']='Products';
		$data['module']='accounting';
		if($this->input->server('REQUEST_METHOD') === 'POST'){
			$formData=$this->input->post();
			unset($formData['submit']);
			unset($formData['status']);
			// debug($formData);
			if(isset($formData['taxes']))
				$formData['taxes'] = implode(',', $formData['taxes']);
			$pirceProdcutList=$formData['product'];
			$formData['company_id']=$this->session->userdata('company_id');
			unset($formData['product']);
			$formData['expiry_date']=date('Y-m-d',strtotime($formData['expiry_date']));
			if(isset($formData['id']) && !empty($formData['id'])){
				$update=$this->product_model->update('tbl_product',array('id'=>$formData['id']),$formData);
				if($update){
					$saved=null;
					$this->product_model->delete('tbl_stockdetails', array('product_id' => $formData['id']));
					if(!empty($pirceProdcutList)) {
						foreach($pirceProdcutList as $abidzarrii){
							if(isset($abidzarrii['opening_stock_qty']))
								$abidzarrii['opening_stock'] = ($abidzarrii['opening_stock_qty'] * $abidzarrii['purchaseRate']);
							$abidzarrii['productName']=$formData['id'];
							$abidzarrii['barcode']=$formData['barcode'];
							$abidzarrii['company_id']=$this->session->userdata('company_id');
							if(isset($abidzarrii['id']) && $abidzarrii['id'] > 0){
								$update=$this->product_model->update('tbl_purchasepricelist', array('id' => $abidzarrii['id']),$abidzarrii);
							}else{
								$abidzarrii['created_by'] = $this->session->userdata('id');
								$saved=$this->product_model->add('tbl_purchasepricelist',$abidzarrii);
							}
							if(isset($abidzarrii['base_id']) && $abidzarrii['base_id'] > 0)
								continue;
							$stock_entry = array(
								'company_id' => $this->company_id,
								'yearId' => $this->getActiveYearId(),
								'barcode' => $formData['barcode'],
								'productName' => $formData['productName'],
								'product_id' => $formData['id'],
								'UOMId' => $abidzarrii['UOMId'],
								'qty' => $abidzarrii['opening_stock_qty'],
							);
							$existing_stock = $this->product_model->getOne('tbl_stockdetails', array('product_id' => $formData['id'], 'UOMId' => $abidzarrii['UOMId'], 'company_id' => $this->company_id));
							if(isset($existing_stock->id)) {
								$this->product_model->update('tbl_stockdetails', array('id' => $existing_stock->id), $stock_entry);
							} else {
								$this->product_model->add('tbl_stockdetails', $stock_entry);
							}
						}
					}
					$this->session->set_flashdata('success',con_lang('mass_product_updated_successfully'));
					redirect($_SERVER['HTTP_REFERER']);
				}else{
					$this->session->set_flashdata('error',con_lang('mass_error_occurrs_try_later'));
					redirect($_SERVER['HTTP_REFERER']);
				}
			}else{
				if(isset($formData['barcode'])) {
					$product = $this->product_model->getOne('tbl_product', array('barcode' =>  $formData['barcode']));
					if(isset($product->id)) {
						$this->session->set_flashdata('error', 'Barcode already exists!');
						redirect($_SERVER['HTTP_REFERER']);
					}
				}
				$saved=$this->product_model->add('tbl_product',$formData);
				if($saved>0){
					foreach($pirceProdcutList as $abidzarrii){
						if(isset($abidzarrii['opening_stock_qty']))
							$abidzarrii['opening_stock'] = ($abidzarrii['opening_stock_qty'] * $abidzarrii['purchaseRate']);
						$abidzarrii['productName']=$saved;
						$abidzarrii['barcode']=$formData['barcode'];
						$abidzarrii['company_id']=$this->session->userdata('company_id');
						$abidzarrii['created_by'] = $this->session->userdata('id');
						$saved1=$this->product_model->add('tbl_purchasepricelist',$abidzarrii);
						if(isset($abidzarrii['base_id']) && $abidzarrii['base_id'] > 0)
								continue;
						$stock_entry = array(
							'company_id' => $this->company_id,
							'yearId' => $this->getActiveYearId(),
							'barcode' => $formData['barcode'],
							'productName' => $formData['productName'],
							'product_id' => $saved,
							'UOMId' => $abidzarrii['UOMId'],
							'qty' => $abidzarrii['opening_stock_qty'],
						);
						$this->product_model->add('tbl_stockdetails', $stock_entry);
					}
					if($saved1){
						$this->session->set_flashdata('success',con_lang('mess_product_added_successfully'));
						redirect($_SERVER['HTTP_REFERER']);
					}
				}else{
					$this->session->set_flashdata('error',con_lang('mass_error_occurrs_try_later'));
					redirect($_SERVER['HTTP_REFERER']);
				}
			}
		}
		if(isset($id) && $id!=null){
			$data['model']=$this->product_model->getById('tbl_product',decode_uri($id));
			if(isset($data['model']->id)) {
				$where=array('productName'=>$data['model']->id, 'company_id' => $this->company_id);
				$data['pricing_list'] = $this->product_model->getAll('tbl_purchasepricelist', $where);
			}
		}
		$max_row = $this->common_model->getMaximumRow('tbl_product');

		$code = 1;
		if(isset($max_row->id)) {
			$code = (int)$max_row->id + 1;
		}
		$random = $code.rand(10000000000, 99999999999);
		$data['bar_code'] = substr($random, 0, 12);
		$data['code'] = sprintf('%04d', $code);
		// debug($data['pricing_list']);
		$data['product_groups'] = $this->product_model->getAll('tbl_productgroup', array('status' => 'active','company_id'=>$this->session->userdata('company_id')));
		$data['product_brands'] = $this->product_model->getAll('tbl_brand', array('status' => 'active','company_id'=>$this->session->userdata('company_id')));
		$data['taxes'] = $this->product_model->getAll('taxes', array('status' => 'active','company_id'=>$this->session->userdata('company_id')));
		$data['units'] = $this->product_model->getAll('tbl_uom',array('company_id'=>$this->session->userdata('company_id')));
		$this->displayView('accounting/products/add_product',$data,array(),array(
				'js'=>array(),
				'css'=>array(),
			));
	}
	public function units(){
		$data['active']='Units';
		$data['module']='accounting';
		$data['units']=$this->product_model->getAll('tbl_uom',array('company_id'=>$this->session->userdata('company_id')));
		// debug($data['units']);
		$this->displayView('accounting/units/list_view',$data,array(),array(
				'js'=>array(),
				'css'=>array(),
			));
	}
	public function addUnits(){
				$units['UOMName']=$this->input->post('unit_name');
				$units['company_id']=$this->session->userdata('company_id');
				$unit_id=$this->input->post('unit_id');
						if(isset($unit_id) && $unit_id!=''){
							$update=$this->product_model->update('tbl_uom',array('id'=>$unit_id),$units);
							if($update){
										$result['message']=con_lang("mess_units_updated_successfully");
										$result['response']=1;
							}else{
								$result['message']=con_lang("mess_error_occurred");
								$result['response']=0;
								
							}
						}else{
								$results=$this->product_model->getOne('tbl_uom',array('UOMName'=>$units['UOMName'],'company_id'=>$units['company_id']));
								if(!empty($results)){
										$result['message']=con_lang("mess_this_unit_is_already_exist");
										$result['response']=0;
								}else{
									$saved=$this->product_model->add('tbl_uom',$units);
									if($saved){
											$result['message']=con_lang("mess_units_added_successfully");
											$result['response']=1;
											$result['id']=$saved;
									}else{
										$result['message']=con_lang("mess_error_occurred");
										$result['response']=0;
										
									}
							}
					}
				  echo json_encode($result);exit();
	}
	public function brands(){
		$data['active']='Brands';
		$data['module']='accounting';
		$data['brands']=$this->product_model->getAll('tbl_brand',array('company_id'=>$this->session->userdata('company_id')));
		$this->displayView('accounting/brands/list_view',$data,array(),array(
				'js'=>array(),
				'css'=>array(),
			));
	}
	public function addBrands($id=null){
		$data['active']='Brands';
		$data['module']='accounting';
		if($this->input->server('REQUEST_METHOD') === 'POST'){
			$formData=$this->input->post();
			unset($formData['submit']);
			$formData['company_id']=$this->session->userdata('company_id');
			if(isset($formData['id']) && !empty($formData['id'])){
				$update=$this->product_model->update('tbl_brand',array('id'=>$formData['id']),$formData);
				if($update){
					$this->session->set_flashdata('success',con_lang('mess_brands_updated_successfully'));
					redirect($_SERVER['HTTP_REFERER']);
				}else{
					$this->session->set_flashdata('error',con_lang('mass_error_occurrs_try_later'));
					redirect($_SERVER['HTTP_REFERER']);
				}
			}else{
				$saved=$this->product_model->add('tbl_brand',$formData);
				if($saved){
					$this->session->set_flashdata('success',con_lang('mess_brands_added_successfully'));
					redirect($_SERVER['HTTP_REFERER']);
				}else{
					$this->session->set_flashdata('error',con_lang('mass_error_occurrs_try_later'));
					redirect($_SERVER['HTTP_REFERER']);
				}
			}
		}
		if(isset($id) && $id!=null){
			$data['model']=(array)$this->product_model->getById('tbl_brand',decode_uri($id));
		}
		$this->displayView('accounting/brands/add_brands',$data,array(),array(
				'js'=>array(),
				'css'=>array(),
			));
	}
	public function taxes(){
		$data['active']='Taxes';
		$data['module']='accounting';
		$data['taxes']=$this->product_model->getAll('tbl_accountledger',array('accountGroupId'=>20,'company_id'=>$this->session->userdata('company_id')));
		$data['currency']=$this->product_model->getOne('tbl_currency',array('company_id'=>$this->company_id));
		$this->displayView('accounting/taxes/list_view',$data,array(),array(
				'js'=>array(),
				'css'=>array(),
			));
	}
	public function addTaxes($id=null){
		$data['active']='Taxes';
		$data['module']='accounting';
		if($this->input->server('REQUEST_METHOD') === 'POST'){
			$formData=$this->input->post();
			unset($formData['submit']);
			$formData['company_id']=$this->session->userdata('company_id');
			if(isset($formData['id']) && !empty($formData['id'])){
				$tax_id = $formData['tax_id'];
				unset($formData['tax_id']);
				$update=$this->product_model->update('taxes',array('id'=>$tax_id),$formData);
				$ledger_data = array(
					'ledgerName' => $formData['title'],
					'tax_symbal' => $formData['tax_type'],
					'tax_value' => $formData['tax_value'],
					'product_bill' => $formData['product_bill'],
				);
				$update=$this->product_model->update('tbl_accountledger',array('id'=>$formData['id']),$ledger_data);
				if($update){
					$this->session->set_flashdata('success',con_lang('mess_taxes_updated_successfully'));
					redirect($_SERVER['HTTP_REFERER']);
				}else{
					$this->session->set_flashdata('error',con_lang('mass_error_occurrs_try_later'));
					redirect($_SERVER['HTTP_REFERER']);
				}
			}else{
				// debug($formData);
				$result=$this->product_model->getOne('taxes',array('title'=>$formData['title'],'tax_type'=>$formData['tax_type'],'product_bill'=>$formData['product_bill'],'company_id'=>$this->company_id));
				if(isset($result->title) && !empty($result->title)){
					$this->session->set_flashdata('error',con_lang('mess_this_taxes_already_exist'));
					$data['model']=$this->input->post();
				}else{
					$saved=$this->product_model->add('taxes',$formData);
					if($saved){
						unset($formData['status']);
						$accountledger['accountGroupId']=20;
						$accountledger['ledgerName']=$formData['title'];
						unset($formData['title']);
						$accountledger['tax_symbal']=$formData['tax_type'];
						unset($formData['tax_type']);
						$accountledger['tax_value']=$formData['tax_value'];
						unset($formData['tax_value']);
						$accountledger['tax_id'] = $saved;
						$accountledger['product_bill']=$formData['product_bill'];
						$accountledger['company_id']=$this->session->userdata('company_id');
						$savedInAccountLedger= $this->product_model->add('tbl_accountledger',$accountledger);
						if($savedInAccountLedger > 0){
							$this->session->set_flashdata('success',con_lang('mess_taxes_added_successfully'));
							redirect($_SERVER['HTTP_REFERER']);
						}
					}else{
						$this->session->set_flashdata('error',con_lang('mass_error_occurrs_try_later'));
						redirect($_SERVER['HTTP_REFERER']);
					}
				}
			}
		}
		if(isset($id) && $id!=null){
			$data['model']=(array)$this->product_model->getById('tbl_accountledger',decode_uri($id));
		}
		$this->displayView('accounting/taxes/add_taxes',$data,array(),array(
				'js'=>array(),
				'css'=>array(),
			));
	}
	public function stock(){
		$data['active']='Stock Entry';
		$data['module']='accounting';
		$data['stockItems']=$this->product_model->getAll('stock',array('company_id'=>$this->session->userdata('company_id')));
		$this->displayView('accounting/stock/list_view',$data,array(),array(
				'js'=>array(),
				'css'=>array(),
			));
	}
	public function addStock($id=null){
		$data['active']='Stock Entry';
		$data['module']='accounting';
		if($this->input->server('REQUEST_METHOD') === 'POST'){
			$formData=$this->input->post();
			unset($formData['submit']);
			$formData['company_id']=$this->session->userdata('company_id');
			if(isset($formData['id']) && !empty($formData['id'])){
				$update=$this->product_model->update('stock',array('id'=>$formData['id']),$formData);
				if($update){
					$this->session->set_flashdata('success',con_lang('Stock Updated Successfully'));
					redirect($_SERVER['HTTP_REFERER']);
				}else{
					$this->session->set_flashdata('error',con_lang('mass_error_occurrs_try_later'));
					redirect($_SERVER['HTTP_REFERER']);
				}
			}else{
			       $i=0;
					foreach($formData as $value){
						$formData['product_id']=$formData['product_id'][$i];
						$formData['quantity']=$formData['quantity'][$i];
						$formData['price']=$formData['price'][$i];
						$saved=$this->product_model->add('stock',$formData);
						$i++;
					}
					if($saved){
						$this->session->set_flashdata('success',con_lang('mess_stock_added_successfully'));
						redirect($_SERVER['HTTP_REFERER']);
					}else{
						$this->session->set_flashdata('error',con_lang('mass_error_occurrs_try_later'));
						redirect($_SERVER['HTTP_REFERER']);
					}
			}
		}
		if(isset($id) && $id!=null){
			$data['model']=(array)$this->product_model->getById('stock',decode_uri($id));
		}
		$this->displayView('accounting/stock/add_stock',$data,array(),array(
				'js'=>array(),
				'css'=>array(),
			));
	}
	public function searchProducts(){
		if($this->input->post('text')){
			$text=trim($this->input->post('text'));
			$company_id=$this->session->userdata('company_id');
			$query="SELECT * FROM tbl_product WHERE company_id =$company_id AND title LIKE '$text%' OR title LIKE '% $text%'";
			$result=$this->product_model->universal($query)->result();
			echo json_encode($result);exit();
		}
	}
	public function purchasePriceListing($type=null){
		if($this->isLoggedIn()){
			if($type!=null){
			}else{
				$data['active']='Purchase Price list';
				$data['module']='accounting';
				$data['allData']=$this->product_model->getAll('tbl_product',array('company_id'=>$this->session->userdata('company_id')));
				$this->displayView('accounting/products/purchase_price_listing',$data,array(),array(
						'js'=>array(),
						'css'=>array(),
					));
			}
		}else{
			redirect('auth');
		}
	}
	public function addPurchasePriceUom($id=null,$type=null){
		if($this->isLoggedIn()){
				$data['active']='Purchase Price list';
				$data['module']='accounting';
				if($this->input->server('REQUEST_METHOD') == 'POST'){
					$formData=$this->input->post();
					unset($formData['submit']);
					// debug($formData);
					if(isset($formData['id']) && !empty($formData['id'])){
						foreach($formData['product'] as $purchaseRate){
							$purchaseRate['barcode']=$formData['barcode'];
							$purchaseRate['opening_stock'] = ($purchaseRate['opening_stock_qty'] * $purchaseRate['purchaseRate']);
							if(isset($formData['productName'])){
							    $purchaseRate['productName']=$formData['productName'];
							}
							$purchaseRate['company_id']=$this->session->userdata('company_id');
							if(isset($purchaseRate['id'])){
							$updatePurchasePrice=$this->product_model->update('tbl_purchasepricelist ',array('id'=>$purchaseRate['id'],'productName'=>$purchaseRate['productName']),$purchaseRate);
							}else{
							    $savedPurchasePrice=$this->product_model->add('tbl_purchasepricelist ',$purchaseRate);
							}
							if($updatePurchasePrice || $savedPurchasePrice > 0){
									$productsData=$this->product_model->getOne('tbl_product',array('id'=>$formData['productName'],'company_id'=>$this->company_id));
									$stock_entry = array(
										'company_id' => $this->company_id,
										'yearId' => $this->getActiveYearId(),
										'barcode' => $formData['barcode'],
										'product_id' => $formData['productName'],
										'productName' => $productsData->productName,
										'UOMId' => $purchaseRate['UOMId'],
										'qty' => $purchaseRate['opening_stock_qty'],
									);
								$existing_stock = $this->product_model->getOne('tbl_stockdetails', array('product_id' => $formData['productName'], 'UOMId' => $purchaseRate['UOMId'], 'company_id' => $this->company_id));
								if(isset($existing_stock->id)) {
									$this->product_model->update('tbl_stockdetails', array('id' => $existing_stock->id), $stock_entry);
								} else {
									$this->product_model->add('tbl_stockdetails', $stock_entry);
								}
							}
						}
						if($updatePurchasePrice > 0 || $savedPurchasePrice > 0){
							$this->session->set_flashdata('success',con_lang('mess_purchase_price_for_UOM_updated'));
							redirect($_SERVER['HTTP_REFERER']);
						}else{
							$this->session->set_flashdata('error',con_lang('mass_error_occurrs_try_later'));
							redirect($_SERVER['HTTP_REFERER']);
						}
					}else{
						foreach($formData['product'] as $purchaseRate){
							$purchaseRate['qty']=$purchaseRate['opening_stock_qty'];
							$purchaseRate['opening_stock'] = ($purchaseRate['opening_stock_qty'] * $purchaseRate['purchaseRate']);
							$purchaseRate['barcode']=$formData['barcode'];
							$purchaseRate['productName']=$formData['productName'];
							$purchaseRate['company_id']=$this->session->userdata('company_id');
							$savedPurchasePrice=$this->product_model->add('tbl_purchasepricelist ',$purchaseRate);
							if($savedPurchasePrice){
								$productsData=$this->product_model->getOne('tbl_product',array('id'=>$formData['productName'],'company_id'=>$this->company_id));
									$stock_entry = array(
										'company_id' => $this->company_id,
										'yearId' => $this->getActiveYearId(),
										'barcode' => $formData['barcode'],
										'product_id' => $formData['productName'],
										'productName' => $productsData->productName,
										'UOMId' => $purchaseRate['UOMId'],
										'qty' => $purchaseRate['opening_stock_qty'],
									);
									$this->product_model->add('tbl_stockdetails', $stock_entry);
							}
						}
						if($savedPurchasePrice){
							$this->session->set_flashdata('success',con_lang('mess_purchase_price_for_UOM_addedd'));
							redirect($_SERVER['HTTP_REFERER']);
						}else{
							$this->session->set_flashdata('error',con_lang('mass_error_occurrs_try_later'));
							redirect($_SERVER['HTTP_REFERER']);
						}
					}
					
				}
				if($id!=null){
					$data['model']=$this->product_model->getAll('tbl_purchasepricelist',array('productName'=>decode_uri($id)));
				}
				// debug($data['model']);
				$this->displayView('accounting/products/purchase_price_uom',$data,array(),array(
						'js'=>array(),
						'css'=>array(),
					));
		}else{
			redirect('auth');
		}
	}
	public function getAppliedTaxes($type=null){
		if($this->isLoggedIn()){
				if($type == 'ng'){

				}else{
					$data['module']='accounting';
				    $data['active']='Apply Taxes';
				    $data['allData']=$this->product_model->getAll('tbl_apply_taxes',array('company_id'=>$this->session->userdata('company_id')));
				 // debug($data['allData']);
				    $this->displayView('accounting/products/applied_tax_listing',$data,array(),array(
						'js'=>array(),
						'css'=>array(),
					));
				}
		}else{
			redirect('auth');
		}
	}
	public function applyTaxes($id=null,$type =null){
		if($this->isLoggedIn()){
			if($type == 'ng'){

			}else{

				$data['module']='accounting';
				$data['active']='Apply Taxes';
				if($this->input->server('REQUEST_METHOD') === 'POST'){
					$formData=$this->input->post();
					$company_id=$this->session->userdata('company_id');
					// if(isset($formData['product_id']) && isset($formData['tax_id'])){
					// 	$formData['taxes']=implode(',',$formData['tax_id']);
					// 	$update=$this->product_model->update('tbl_product',array('id'=>$formData['product_id']),array('taxes'=>$formData['taxes']));
					// 	if($update){
					// 			$this->session->set_flashdata('success','Taxes Apply Successfully');
					// 			redirect($_SERVER['HTTP_REFERER']);
					// 	}else{
					// 		$this->session->set_flashdata('error','mass_error_occurrs_try_later');
					// 		redirect($_SERVER['HTTP_REFERER']);
					// 	}
					// }
					if(isset($formData['voucher_type']) && isset($formData['tax_id'])){
						$formData['taxes']=implode(',',$formData['tax_id']);
						$apply_tax = $this->product_model->getOne('tbl_apply_taxes', array('company_id' => $company_id, 'voucher_type' => $formData['voucher_type']));
						$update = false;
						if(isset($apply_tax->id)) {
							$update=$this->product_model->update('tbl_apply_taxes',array('id'=>$apply_tax->id),array('taxes'=>$formData['taxes']));
						} else {
							$update=$this->product_model->add('tbl_apply_taxes',array('taxes'=>$formData['taxes'], 'voucher_type' => $formData['voucher_type'], 'company_id' => $company_id));
						}
						
						if($update){
							$this->session->set_flashdata('success',con_lang('mess_taxes_apply_successfully'));
							redirect($_SERVER['HTTP_REFERER']);
						}else{
							$this->session->set_flashdata('error',con_lang('mass_error_occurrs_try_later'));
							redirect($_SERVER['HTTP_REFERER']);
						}
					}
				}
				if($id!=null){
					$data['model']=$this->product_model->getAppliedTax(decode_uri($id));
					
				}
				$this->displayView('accounting/products/apply_tax',$data,array(),array(
						'js'=>array(),
						'css'=>array(),
					));
			}
		}else{
			redirect('auth');
		}
	}
	public function getTaxesByVoucherType() {
		if($this->input->post('type')) {
			$type = $this->input->post('type');
			$apply_tax = $this->product_model->getOne('tbl_apply_taxes', array('company_id' => $this->company_id, 'voucher_type' => $type));

			if(isset($apply_tax->taxes)) {
				echo $apply_tax->taxes;
			}
		}
	}
	public function getTaxesvalue($type=null){
		if($this->isLoggedIn()){
			if($type=='ng'){

			}else{
				if($this->input->post('taxesID')){
					$result=$this->product_model->getOne('tbl_accountledger',array('id'=>$this->input->post('taxesID')));
					if(!empty($result)){
						echo json_encode($result);exit();
					}
				}
			}
		}else{	
			redirect('auth');
		}
	}
	public function deleteApplyTax($id = null) {
		if($id != null) {
			$delete = $this->common_model->delete('tbl_apply_taxes', array('id' => $id));
			if($delete){
				$result['message']=con_lang("mass_deleted_successfully");
				$result['response']=1;
			}else{
				$result['message']=con_lang("mass_error_occurrs_try_later");
				$result['response']=0;
			}
			echo json_encode($result);exit();
		}
	}
	public function deleteTax($id = null) {
		if($id != null) {
			$delete = $this->common_model->delete('taxes', array('id' => $id));
			$delete = $this->common_model->delete('tbl_accountledger', array('tax_id' => $id));
			if($delete){
				$result['message']=con_lang("mass_deleted_successfully");
				$result['response']=1;
			}else{
				$result['message']=con_lang("mass_error_occurrs_try_later");
				$result['response']=0;
			}
			echo json_encode($result);exit();
		}
	}
	//please check it by sakhi
	public function deleted($id=null,$product_id=null,$UOMId=null){
		if($id!=null){
			$company_id=$this->company_id;
			$opening_stock=$this->product_model->getOne('tbl_purchasepricelist',array('id'=>$id));
			$where=array('product_id'=>$opening_stock->productName,'UOMId'=>$opening_stock->UOMId,'company_id'=>$company_id);
			$deleted=$this->product_model->delete('tbl_purchasepricelist',array('id'=>$id));
			if($deleted){
				$stock=$this->product_model->update('tbl_stockdetails',$where, array('qty' => $opening_stock->opening_stock_qty));
				$stock = $this->product_model->universal("UPDATE tbl_stockdetails SET qty = qty - ".$opening_stock->opening_stock_qty." WHERE product_id = ".$opening_stock->productName." AND UOMId = ".$opening_stock->UOMId." AND company_id = ".$company_id);
				$stock = $this->product_model->getOne('tbl_stockdetails',$where);
				if(isset($stock->qty) && $stock->qty <= 0) {
					$stock = $this->product_model->delete('tbl_stockdetails', array('id' => $stock->id));
				}
				if(!empty($stock)){
						$result['message']=con_lang("mass_deleted_successfully");
						$result['response']=1;
					}else{
						$result['message']=con_lang("mass_error_occurrs_try_later");
						$result['response']=0;
					}
				echo json_encode($result);
					exit();
			}
		}
	}

	public function getProductsByCategory() {
		if($this->input->post('category')) {
			$category = $this->input->post('category');
			$where = array('groupId' => $category, 'company_id' => $this->company_id, 'isActive' => 1);
			$where = "tbl_product.company_id = ".$this->company_id." AND tbl_product.isActive = 1 AND tbl_product.groupId = ".$category;
			$product_id = (int)$this->input->post('product');
			if($product_id > 0) {
				$where .= " AND tbl_product.id = ".$product_id;
			}
			$products = $this->product_model->universal("SELECT tbl_product.id, tbl_product.productName, tbl_product.product_code, tbl_purchasepricelist.saleRate as price, tbl_purchasepricelist.UOMId as unit_id, tbl_uom.UOMName, tbl_promotions.discount as discount, tbl_promotions.discount_amount as discount_amount, DATE_FORMAT(tbl_promotions.from_date, '%M %d %Y') as from_date, DATE_FORMAT(tbl_promotions.to_date, '%M %d %Y') as to_date FROM tbl_product INNER JOIN tbl_purchasepricelist ON tbl_product.id = tbl_purchasepricelist.productName LEFT JOIN tbl_uom ON tbl_uom.id = tbl_purchasepricelist.UOMId LEFT JOIN tbl_promotions ON (tbl_purchasepricelist.productName = tbl_promotions.product_id AND tbl_purchasepricelist.UOMId = tbl_promotions.unit_id AND tbl_promotions.company_id = tbl_purchasepricelist.company_id) WHERE $where");
			if($products)
				$products = $products->result();
			if(!empty($products))
				echo json_encode($products);
			exit();
		}
	}

	public function apply_promotion() {
		if($this->input->post('submit')) {
			$products = $this->input->post('products');
			if(!empty($products)) {
				foreach ($products as $product) {
					$product['company_id'] = $this->company_id;
					if(isset($product['from_date']))
						$product['from_date'] = date('Y-m-d H:i:s', strtotime($product['from_date']));
					if(isset($product['to_date']))
						$product['to_date'] = date('Y-m-d H:i:s', strtotime($product['to_date']));
					$promotion = $this->product_model->getOne('tbl_promotions', array('product_id' => $product['product_id'], 'unit_id' => $product['unit_id']));
					if(isset($promotion->id)) {
						$this->product_model->update('tbl_promotions', array('id' => $promotion->id), $product);
					} else {
						$this->product_model->add('tbl_promotions', $product);
					}
				}
				$this->session->set_flashdata('success', 'Record Saved successfully');
			}
			redirect($_SERVER['HTTP_REFERER']);
		}
	}

	public function getStockInfoByProductUnit() {
		$product_id = $this->input->post('product_id');
		$unit_id = $this->input->post('unit_id');
		if($product_id > 0 && $unit_id > 0) {
			$query = "
			SELECT 
			tbl_product.product_code as code,
			tbl_stockdetails.qty as expected
			FROM tbl_purchasepricelist
			LEFT JOIN tbl_product
			ON tbl_product.id = tbl_purchasepricelist.productName
			LEFT JOIN tbl_stockdetails
			ON (tbl_purchasepricelist.productName = tbl_stockdetails.product_id AND tbl_purchasepricelist.UOMId = tbl_stockdetails.UOMId)
			WHERE tbl_purchasepricelist.productName = $product_id AND tbl_purchasepricelist.UOMId = $unit_id
			";
			$query = $this->db->query($query);
			if($query) {
				$row = $query->row();
				echo json_encode($row);
				exit();
			}
		}
	}
	public function generate_barcode(){
		$data['active']='Product Creation';
		$data['module']='accounting';
		if($_GET['products_ids']){
			$products_ids=$_GET['products_ids'];
			$exploded_id=explode(',',$products_ids);
			$this->load->library('barcode');
			foreach($exploded_id as $key => $value){
				$data['products_detail'][$key]=$this->product_model->getProductById($value);
				$product_barcode=isset($data['products_detail'][$key]->barcode) ? $data['products_detail'][$key]->barcode :'';
				$data['barcode'][$key]=$this->barcode->generate_barcode($product_barcode);
			}	
		}
		if(isset($_GET['print'])) {
			$data['print'] = true;
		}
		$this->load->view('accounting/products/barcode_label',$data);
	}
	public function getStockProductsHtml() {
		if($this->input->post('product')) {
			$product_id = $this->input->post('product');
			$is_adding = $this->input->post('add');
			$date = $this->input->post('date');
			$length = (int)$this->input->post('length');
			$products = $this->product_model->getProductsForStockCount($product_id, $date);
			if(!empty($products)) {
				foreach ($products as $key => $product) {
					$key = $key + $length;
					?>
					<tr>
						<td>
							<input type="hidden" name="items[<?php echo $key; ?>][product_id]" value="<?php echo $product->product_id; ?>">
							<?php echo $product->product_name; ?>
							<input type="hidden" name="items[<?php echo $key; ?>][cost_price]" value="<?php echo $product->cost_price; ?>">
							<input type="hidden" name="items[<?php echo $key; ?>][sale_price]" value="<?php echo $product->sale_price; ?>">
						</td>
						<td><?php echo $product->product_code; ?></td>
						<td>
							<input type="hidden" name="items[<?php echo $key; ?>][unit_id]" value="<?php echo $product->unit_id; ?>">
							<?php echo $product->unit_name; ?>
						</td>
						<td class="cost_price"><?php echo $product->cost_price; ?></td>
						<td class="sale_price"><?php echo $product->sale_price; ?></td>
						<td><input type="text" class="form-control expected_qty" readonly="true" name="items[<?php echo $key; ?>][expected_qty]" value="<?php echo ($is_adding) ? $product->stock_qty : $product->expected_qty; ?>"></td>
						<td><input type="number" class="form-control counted_qty" <?php echo (isset($product->can_apply) && $product->can_apply == 0 && !$is_adding) ? 'readonly="true"' : 'name="items['.$key.'][counted_qty]"'; ?> value="<?php echo $product->counted_qty; ?>"></td>
						<td class="difference"><?php echo ($product->difference > 0) ? '+' : ''; ?><?php echo $product->difference; ?></td>
						<td class="cost_sum"><?php echo ($product->total_cost_price > 0) ? '+' : ''; ?><?php echo $product->total_sale_price; ?></td>
						<td class="sale_sum"><?php echo ($product->total_sale_price > 0) ? '+' : ''; ?><?php echo $product->total_sale_price; ?></td>
						<td>
							<a href="#" class="btn btn-danger remove-stock-row"><i class="fa fa-minus"></i></a>
						</td>
					</tr>
					<?php
				}
			}
		}
	}

	public function getUnitsByProduct() {
		if($this->input->post('product_id')) {
			$id = $this->input->post('product_id');
			$query = $this->product_model->universal("
				SELECT * FROM tbl_uom WHERE id IN (SELECT UOMId FROM tbl_purchasepricelist WHERE base_id IS NULL AND productName = $id AND company_id =".$this->company_id.")
			");
			echo ($query) ? json_encode($query->result()) : null;
		}
	}

}