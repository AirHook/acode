<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class ERPController extends CI_Controller {
	protected $app_id=null;
	public $app=null;
	public $current_user = null;
	public $current_guest = null;
	private $currency_list = null;
	public $upload_path = null;
	public $theme_css_path = null;
	protected $theme_name = null;
	protected $template = array();
	public $rs_path = null;
	public $js_path = null;
	public $css_path = null;
	public $company_id=null;
	public $currency = null;
	private $current_user_role = null;
	public $voucher_number_length = 5;
	public function __construct() {
		parent::__construct();
		$this->load_erp_package();
		date_default_timezone_set('Asia/Karachi');
		$this->load->helper('urlencode_helper');
		$this->load->helper('general_helper');
		$this->rs_path = base_url().'assets/erp/';
		$this->js_path = base_url().'assets/erp/js/';
		$this->css_path = base_url().'assets/erp/css/';
		// $this->theme_name = 'basic_theme';
		$this->theme_name = 'insapinia_theme';
		$this->theme_css_path = base_url().'assets/erp/'.$this->theme_name.'/';
		$this->theme_js_path = base_url().'assets/erp/'.$this->theme_name.'/';
		$this->company_id=$this->session->userdata('company_id');
		$this->company = null;
		$uri_param = $this->uri->segment(2);
		$controller_name = $this->uri->segment(1);
		if($this->company_id && !in_array($uri_param, array('company')) && !in_array($controller_name, array('auth'))) {
			$company = $this->common_model->getOne('tbl_company', array('companyId' => $this->company_id));
			$this->company = $company;
			$this->currency = $this->common_model->getOne('tbl_currency', array('company_id' => $this->company_id));
			if(isset($this->company->time_zone) && $this->company->time_zone != '')
				date_default_timezone_set($this->company->time_zone);
			if(isset($company->activated) && $company->activated == 0) {
				$this->session->set_flashdata('warning', 'Please Complete your company profile!');
				redirect('accounting/company');
			}
		}
		if($this->session->userdata('id')) {
			$userID = $this->session->userdata('id');
			$user = $this->common_model->getOne('tbl_users', array('id' => $userID));
			if(isset($user->role)) {
				$this->current_user_role = $user->role;
			}
		}
		$this->load->driver('session');
	}
	public function priceValue($amount) {
		$amount = (float)$amount;
		$amount = number_format($amount, 2);
		if(isset($this->currency->prefix))
			$amount = '<span class="prefix">'.$this->currency->prefix.'</span>'.$amount;
		if(isset($this->currency->suffix))
			$amount .= '<span class="suffix">'.$this->currency->suffix.'</span>';

		return $amount;
	}
	public function getEmailShortCodes(){
		return array(
			'[SENDER_NAME]' => 'Sender Name',
			'[SENDER_EMAIL]' => 'Sender Email',
			'[RECEIVER_NAME]' => 'Receiver Name',
			'[RECEIVER_EMAIL]'=> 'Receiver Email',
			'[INVOICE_NO]'=> 'Invoice No.',
			'[TICKET_NO]'=> 'Ticket No.',
			'[ITEMS]'=> 'Items List'
		);
	}
	public function getSMSShortCodes() {
		return array(
			'[SENDER_NAME]' => 'Sender Name',
			'[SENDER_EMAIL]' => 'Sender Email',
			'[RECEIVER_NAME]' => 'Receiver Name',
			'[RECEIVER_EMAIL]'=> 'Receiver Email',
			'[INVOICE_NO]'=> 'Invoice No.',
			'[TICKET_NO]'=> 'Ticket No.',
		);
	}
	public function isLoggedIn() {
		$userID = $this->session->userdata('id');
		if($userID != null && $userID > 0) {
			return true;
		} else {
			return false;
		}
	}
	public function isSuperAdmin() {
		return ($this->current_user_role == 'super_admin') ? true : false;
	}
	public function isAdmin() {
		return ($this->current_user_role == 'admin') ? true : false;
	}
	public function has_access_of($role_name) {
		if($this->isAdmin() || $this->isSuperAdmin()) return true;
		$group_id = $this->current_user_role;
		if($group_id == null) return false;

		$role = $this->common_model->getRoleIDByName($role_name);
		if($role == null) return false;
		$userRoles = $this->common_model->getOne('tbl_user_roles', array('id' => $group_id));
		$userRoles = isset($userRoles->permissions) ? explode(',', $userRoles->permissions) : array();
		if(in_array($role, $userRoles))
			return true;
		else
			return false;
	}
	public function upload_file($fieldName) {
		$config['upload_path']          = 'resources/user_upload/';
        $config['allowed_types']        = 'gif|jpg|png';
        $config['max_size']             = 100;
        $config['max_width']            = 1024;
        $config['max_height']           = 768;
        $this->load->library('upload', $config);
        if(! $this->upload->do_upload($fieldName))
        	return false;
        else
        	return $this->upload->data();
	}
	public function custom_upload_file($file) {
		$name = time().'_'.$file['name'];
		$path = $this->upload_path.$name;
		if(file_exists($path))
			unlink($path);
		if(move_uploaded_file($file['tmp_name'], $path) === false)
			return false;
		else
			return $name;
	}
	public function showItemRow($id, $quantity = 0, $max = false) {
		$this->load->model('inventory_model');
		$item = $this->inventory_model->getById($id);
		$max = ($max) ? $item->quantity : 0;
		$item->quantity = ($quantity == 0) ? 1 : $quantity;
		if($item->quantity > $max && $max > 0)
			$item->quantity = $max;
		echo '<tr class="'.$id.'"><input class="id" type="hidden" value="'.$item->id.'" name="items['.$id.'][item_id]" /><td><input name="items['.$id.']" type="checkbox" class="i-checks select-single" /></td><td style="width: 150px;">'.$item->name.'</td> <td style="width: 330px;">'.$item->description.'</td> <td style="width: 90px;"><input name="items['.$id.'][quantity]" type="number" min="1" ';
		if($max > 0)
			echo ' max="'.$max.'" ';
		echo ' class="form-control quantity" value="'.$item->quantity.'"/></td> <td>$<span class="price">'.number_format($item->price_retail,2).'</span></td><td>$<span class="subtotal">'.number_format(($item->quantity * $item->price_retail),2).'</span></td> <td><a href="#" class="remove-current-item"><i class="fa fa-trash-o"></i></a></td> </tr>';
	}
	public function getProjectScripts() {
		return array(
			$this->js_path.'accounting.js'
		);
	}
	public function getProjectStyles() {
		return array(
			$this->css_path.'custom.css'
		);
	}
	public function getSideNav() {
		$sidenav = array(
			array('title'=> 'Dashboard', 'link'=> 'accounting/dashboard', 'modules' => array('accounting'), 'role' => 'view_dashboard'),
			array('title'=> 'Manage Users', 'modules' => array('accounting') , 'children' => array(
					array('title' => 'All Users', 'link' => 'accounting/admin/allUser', 'role' => 'view_users'),
					array('title'=>'User Creation','link'=>'accounting/admin/userCreation', 'role' => 'add_users'),
					
				)),
			// array('title'=> 'Company', 'modules' => array('accounting'),'children'=>array(
			// 		array('title'=>'Company Detail','link'=>'accounting/company', 'role' => 'view_company'),
			// 		// array('title'=>'Change Password','link'=>'accounting/company/changePassword'),
			// 	)),
			// array('title'=> 'Master', 'modules' => array('accounting') , 'children' => array(
			// 		array('title' => 'Customer', 'link' => 'accounting/customers', 'role' => 'view_customers'),
			// 		array('title' => 'Supplliers', 'link' => 'accounting/suppliers', 'role' => 'view_suppliers'),
			// 		array('title' => 'Account Groups', 'link' => 'accounting/account', 'role' => 'view_account_groups'),
			// 		array('title' => 'Account Ledger', 'link' => 'accounting/account/accountLedger', 'role' => 'view_account_ledgers'),
			// 		array('title' => 'Voucher Type', 'link' => 'accounting/account/voucherType', 'role' => 'view_voucher_type'),
			// 		array('title' => 'Currency', 'link' => 'accounting/account/addCurrency', 'role' => 'view_currency'),
			// 		array('title' => 'Payment Methods', 'link' => 'accounting/account/paymentMethods', 'role' => ''),
			// 		array('title' => 'Gift Cards', 'link' => 'accounting/account/giftCards', 'role' => ''),
			// 		array('title'=>'Chart Of Account','link'=>'accounting/financial/chartOfAccount', 'role' => 'view_chart_of_account'),
			// 		array('title' => 'Promotions', 'link' => 'accounting/products/promotion', 'role' => 'view_promotions')
			// 	)),
			array('title'=>'Inventory', 'modules' => array('accounting') ,'children'=>array(
					// array('title'=> 'Product Categories' , 'link'=>'accounting/products/category', 'role' => 'view_product_category'),
					array('title'=> 'Products' , 'link'=>'accounting/products/products', 'role' => 'view_product_creation'),
					// array('title'=> 'Brands' , 'link'=>'accounting/products/brands', 'role' => 'view_brand'),
					// array('title'=> 'Units' , 'link'=>'accounting/products/units', 'role' => 'view_units'),
					// array('title'=> 'Taxes' , 'link'=>'accounting/products/taxes', 'role' => 'view_taxes'),
					// array('title'=> 'Apply Taxes' , 'link'=>'accounting/products/getAppliedTaxes', 'role' => 'view_apply_tax'),
					// array('title'=> 'Stock Count' , 'link'=>'accounting/products/stockInvoices', 'role' => ''),
					// array('title'=> 'Purchase Price list' , 'link'=>'accounting/products/purchasePriceListing'),
				)),
			array('title'=> 'Purchases', 'modules' => array('accounting'),'children'=>array(
					array('title'=>'Purchase Quotation','link'=>'accounting/purchases/purchaseQuotation', 'role' => 'view_purchase_quotation'),
					array('title'=>'Purchase Orders','link'=>'accounting/purchases/purchaseOrder', 'role' => 'view_purchase_order'),
					array('title'=>'Purchase Invoice','link'=>'accounting/purchases/purchaseInvoice', 'role' => 'view_purchase_invoice'),
					array('title'=>'Purchase Return','link'=>'accounting/purchases/purchaseReturn', 'role' => 'view_purchase_return'),
				)),
			array('title'=> 'Sales', 'modules' => array('accounting'),'children'=>array(
					array('title'=>'Point of Sale','link'=>'accounting/sales/pos', 'role' => 'view_pos'),
					array('title'=>'Sales Quotation','link'=>'accounting/sales/saleQuotation', 'role' => 'view_sale_quotation'),
					array('title'=>'Sales Orders','link'=>'accounting/sales/saleOrder', 'role' => 'view_sale_order'),
					array('title'=>'Sales Invoice','link'=>'accounting/sales/saleInvoice', 'role' => 'view_sale_invoice'),
					array('title'=>'Sales Return','link'=>'accounting/sales/saleReturn', 'role' => 'view_sale_return'),
				)),
				// //	array('title'=>'Bank Concilation','link'=>'accounting/transactions/bankConcilation', 'role' => 'view_bank_concilation'),
				// //	array('title'=>'Bank Reconcilation','link'=>'accounting/transactions/bankReconcilation', 'role' => 'view_bank_reconcilation'),
				// 	array('title'=>'Journal Voucher','link'=>'accounting/transactions/journalVoucher', 'role' => 'view_journal_voucher'),
			array('title'=> 'Transactions', 'modules' => array('accounting'),'children'=>array(
					array('title'=>'Payment Voucher','link'=>'accounting/transactions/paymentVoucher', 'role' => 'view_payment_voucher'),
					array('title'=>'Receipt Voucher','link'=>'accounting/transactions/receiptVocher', 'role' => 'view_receipt_voucher'),
				)),
			// array('title'=> 'Financial Statements','modules'=>array('accounting'),'children'=>array(
			// 		array('title'=>'Balance Sheet','link'=>'accounting/financial/balanceSheet', 'role' => 'view_balance_sheet'),
			// 		array('title'=>'Profit and Loss','link'=>'accounting/financial/profitAndLoss', 'role' => 'view_profit_loss'),
					
			// 	)),
			array('title'=> 'Reports', 'modules' => array('accounting'),'children'=>array(
					array('title'=>'Account Ledger Report','link'=>'accounting/reports/accountLedgerReports', 'role' => 'view_account_ledger_report'),
					// array('title'=>'Journal Report','link'=>'accounting/reports/journalVoucherReports', 'role' => 'view_journal_voucher_report'),
					array('title'=>'Payments Voucher','link'=>'accounting/reports/paymentReports', 'role' => 'view_payment_voucher_report'),
					array('title'=>'Receipt Voucher Report','link'=>'accounting/reports/receiptReports', 'role' => 'view_receipt_voucher_report'),
					array('title'=>'Purchase Invoice Report','link'=>'accounting/reports/purchaseInvoiceReports', 'role' => 'view_purchase_invoice_report'),
					array('title'=>'Purchase Return Report','link'=>'accounting/reports/purchaseReturnReports', 'role' => 'view_purchase_return_report'),
					array('title'=>'Deleted Purchase Invoice Report','link'=>'accounting/reports/deletedPurchaseInvoiceReports', 'role' => 'view_purchase_invoice_report'),
					array('title'=>'Sale Invoice Report','link'=>'accounting/reports/saleInvoiceReports', 'role' => 'view_sale_invoice_report'),
					array('title'=>'Sale Analysis Report', 'link'=> 'accounting/reports/salesReport', 'role' => 'view_sale_invoice_report'),
					array('title'=> 'Detailed Sale Report', 'link' => 'accounting/reports/saleInvoiceDetailReport', 'role' => 'view_sale_invoice_report'),
					array('title'=>'Sale Return Report','link'=>'accounting/reports/saleReturnReports', 'role' => 'view_sale_return_report'),
					array('title'=>'Deleted Sale Invoice Report','link'=>'accounting/reports/deletedSaleInvoiceReports', 'role' => 'view_sale_invoice_report'),
					array('title'=>'Stock Ledger Report','link'=>'accounting/reports/stockLedgerReport', 'role' => 'view_stock_report'),
					array('title'=>'Stock Report','link'=>'accounting/reports/stockReport', 'role' => 'view_stock_report'),
					// array('title'=>'Cash Book','link'=>'accounting/reports/accountLedgerReports/27', 'role' => 'view_cash_report'),
					// array('title'=>'Taxes Report','link'=>'accounting/reports/accountLedgerReports/20', 'role' => 'view_taxes_report'),
					// array('title'=>'Supplliers Ledger Report','link'=>'accounting/reports/accountLedgerReports/22/all/last30Days', 'role' => 'view_account_ledger_report'),
					// array('title'=>'Customers Ledger Report','link'=>'accounting/reports/accountLedgerReports/26/all/last30Days', 'role' => 'view_account_ledger_report'),
					// array('title'=>'Cheque Report','link'=>'accounting/reports/checkReport'),
					// array('title'=>'Day Book','link'=>'accounting/reports/dayBook'),
				)),
			// array('title'=> 'Settings', 'modules' => array('accounting'),'children'=>array(
			// 		array('title'=>'General Settings','link'=>'accounting/settings/general', 'role' => 'view_general_settings'),
			// 		array('title'=>'Financial Year','link'=>'accounting/settings/financialYear', 'role' => 'view_taxes_report'),
			// 		array('title'=>'Countries','link'=>'accounting/settings/countries', 'role' => 'view_countries'),
			// 		array('title'=>'User Roles', 'link' => 'accounting/roles', 'role' => 'view_user_roles'),
			// 		array('title'=>'User Permissions', 'link' => 'accounting/roles/permissions', 'role' => 'view_user_permissions'),
			// 		array('title'=>'Import/Export Tables', 'link' => 'accounting/settings/import_export', 'role' => 'import_export'),
			// 	)),
		);

		
		if(!empty($sidenav)) {
			foreach ($sidenav as $index => &$nav) {
				if(isset($nav['children']) && !empty($nav['children'])) {
					foreach ($nav['children'] as $key => $value) {
						if(isset($value['role'])) {
							if(!$this->has_access_of($value['role'])) {
								unset($nav['children'][$key]);
								continue;
							}
						}
					}
					if(empty($nav['children'])) {
						unset($sidenav[$index]);
					}
				} else {
					if(isset($nav['role'])) {
						if(!$this->has_access_of($nav['role'])) {
							unset($sidenav[$index]);
							continue;
						}
					}
				}
			}
		}
		// echo '<pre>',print_r($sidenav),'</pre>';exit();
		return $sidenav;
	}
	public function generate_timezone_list() {
	    static $regions = array(
	        DateTimeZone::AFRICA,
	        DateTimeZone::AMERICA,
	        DateTimeZone::ANTARCTICA,
	        DateTimeZone::ASIA,
	        DateTimeZone::ATLANTIC,
	        DateTimeZone::AUSTRALIA,
	        DateTimeZone::EUROPE,
	        DateTimeZone::INDIAN,
	        DateTimeZone::PACIFIC,
	    );
	    $timezones = array();
	    foreach( $regions as $region )
	    {
	        $timezones = array_merge( $timezones, DateTimeZone::listIdentifiers( $region ) );
	    }
	    $timezone_offsets = array();
	    foreach( $timezones as $timezone )
	    {
	        $tz = new DateTimeZone($timezone);
	        $timezone_offsets[$timezone] = $tz->getOffset(new DateTime);
	    }
	    // sort timezone by offset
	    asort($timezone_offsets);
	    $timezone_list = array();
	    foreach( $timezone_offsets as $timezone => $offset )
	    {
	        $offset_prefix = $offset < 0 ? '-' : '+';
	        $offset_formatted = gmdate( 'H:i', abs($offset) );
	        $pretty_offset = "UTC${offset_prefix}${offset_formatted}";
	        $timezone_list[$timezone] = "(${pretty_offset}) $timezone";
	    }
	    return $timezone_list;
	}
	public function getBarCodeImage($text = '', $code = null, $index) {
		require_once(FCPATH.'modules/admin/plugins/libraries/barcode/BarCode.php');
		$barcode = new BarCode();
		$path = 'resources/imagetemp'.$index.'.png';
		$barcode->barcode($path, $text);
		return $path;
	}
	public function generateBarCode($id) {
		$num1 = mt_rand(100000,999999);
		$num2 = mt_rand(100000,999999);
		return $num1.$num2;
		// return sprintf("%012s", $id.time());
	}
	public function displayView($view = null, $data, $exclude = array(), $resources = array(), $return = false) {
		$data['resources'] = $resources;
		$data['side_nav'] = $this->getSideNav();
		if(isset($data['active']) && $data['active'] != 'Point of Sale'){
			$project_js_files = $this->getProjectScripts();
			if(isset($resources['js'])){
				foreach($resources['js'] as $js){
					array_push($project_js_files, $js);
				}
			}
		}
		if(isset($data['active']) && $data['active'] != 'Point of Sale'){
			$data['resources']['js'] = $project_js_files;
		}
		$project_css_files = $this->getProjectStyles();
		if(isset($resources['css'])){
			foreach($resources['css'] as $css){
				array_push($project_css_files, $css);
			}
		}
		$data['resources']['css'] = $project_css_files;
		if(file_exists(FCPATH.'views/accounting/admin/themes/'.$this->theme_name.'/header.php') && !in_array('header', $exclude))
			$this->template['header'] = $this->load->view('accounting/admin/themes/'.$this->theme_name.'/header', $data, true);
		if(file_exists(FCPATH.'views/accounting/admin/themes/'.$this->theme_name.'/topbar.php') && !in_array('topbar', $exclude))
			$this->template['topbar'] = $this->load->view('accounting/admin/themes/'.$this->theme_name.'/topbar', $data, true);
		if(file_exists(FCPATH.'views/accounting/admin/themes/'.$this->theme_name.'/sidenav.php') && !in_array('sidenav', $exclude))
			$this->template['sidenav'] = $this->load->view('accounting/admin/themes/'.$this->theme_name.'/sidenav', $data, true);
		if($view != null) {
			if(is_array($view)) {
				$content = '';
				foreach ($view as $key => $value){
					$content .= $this->load->view($value, $data, true);
				}
				$this->template['content'] = $content;
			} else {
				$this->template['content'] = $this->load->view($view, $data, true);
			}
		}
		if(file_exists(FCPATH.'views/accounting/admin/themes/'.$this->theme_name.'/footer.php') && !in_array('footer', $exclude))
			$this->template['footer'] = $this->load->view('accounting/admin/themes/'.$this->theme_name.'/footer', $data, true);
		if($return)
			return $this->load->view('accounting/admin/themes/'.$this->theme_name.'/index', $this->template, true);
		else
			$this->load->view('accounting/admin/themes/'.$this->theme_name.'/index', $this->template);
	}
	public function displayHeader($data) {
		if(file_exists(FCPATH.'views/accounting/admin/themes/'.$this->theme_name.'/header.php'))
			$this->load->view('accounting/admin/themes/'.$this->theme_name.'/header', $data);
	}
	public function displayFooter($data) {
		if(file_exists(FCPATH.'views/accounting/admin/themes/'.$this->theme_name.'/footer.php'))
			$this->load->view('accounting/admin/themes/'.$this->theme_name.'/footer', $data);
	}
	public function pageNotFound() {
		if(file_exists(FCPATH.'views/accounting/admin/themes/'.$this->theme_name.'/header.php'))
			$this->load->view('accounting/admin/themes/'.$this->theme_name.'/header');
		if(file_exists(FCPATH.'views/accounting/admin/themes/'.$this->theme_name.'/404.php'))
			$this->load->view('accounting/admin/themes/'.$this->theme_name.'/404');
		else
			$this->load->view('admin/404');
		if(file_exists(FCPATH.'views/accounting/admin/themes/'.$this->theme_name.'/footer.php'))
			$this->load->view('accounting/admin/themes/'.$this->theme_name.'/footer');
	}
	public function getReports(){
		$reports = array(
			array('title' => 'Ledger Reports', 'link' => 'accountLedgerReports'),
			array('title' => 'Payment Vouchers Report', 'link' => 'paymentReports'),
			array('title' => 'Receipt Voucher Report', 'link' => 'receiptReports'),
			array('title' => 'Journal Report', 'link' => 'journalVoucherReports'),
			array('title' => 'Purchase Invoice Report', 'link' => 'purchaseInvoiceReports'),
			array('title' => 'Purchase Return Report', 'link' => 'purchaseReturnReports'),
			array('title' => 'Sale Invoice Report', 'link' => 'saleInvoiceReports'),
			array('title' => 'Sale Return Report', 'link' => 'saleReturnReports'),
			array('title' => 'Stock Report', 'link' => 'stockReport'),
			array('title'=>'Cash/Bank Book','link'=>'cashBook'),
			array('title'=>'Tax Report','link'=>'taxReport'),
			array('title'=>'Cheque Report','link'=>'checkReport'),
			array('title'=>'Day Book','link'=>'dayBook'),
			
		);
		return $reports;
	}
	public function sendEmail($to = null, $from = null, $subject = null, $data = array()) {
		if($to != null) {
			$config = Array(   
	            'protocol' => 'mail',
	            'smtp_host' => 'hostifire.net',
	            'smtp_port' => 587,
	            'smtp_user' => 'developer@itvision.com.pk',
	            'smtp_pass' => 'Global1122',
	            'smtp_timeout' => '7',
	            'mailtype'  => 'html', 
	        );
	        if($from == null)
	        	$from = 'info@hotelapp.com';
			$this->load->library('email');
			 $this->email->initialize($config);
	        $this->email->from($from);
	        $this->email->to($to);
	        $this->email->subject($subject);
	        $body = $this->load->view('accounting/admin/emails/email_templates/action.php',$data,TRUE);
	        $this->email->message($body);  
	        // $this->email->set_alt_message('Alternative message');
	        /*echo $body;
	        exit();*/
	       
	        return $this->email->send();
        }
        return false;
	}
	private function initializeCurrencyList(){
		$this->currency_list = array(
		    'AED' => '&#1583;.&#1573;', // ?
		    'AFN' => '&#65;&#102;',
		    'ALL' => '&#76;&#101;&#107;',
		    'AMD' => '',
		    'ANG' => '&#402;',
		    'AOA' => '&#75;&#122;', // ?
		    'ARS' => '&#36;',
		    'AUD' => '&#36;',
		    'AWG' => '&#402;',
		    'AZN' => '&#1084;&#1072;&#1085;',
		    'BAM' => '&#75;&#77;',
		    'BBD' => '&#36;',
		    'BDT' => '&#2547;', // ?
		    'BGN' => '&#1083;&#1074;',
		    'BHD' => '.&#1583;.&#1576;', // ?
		    'BIF' => '&#70;&#66;&#117;', // ?
		    'BMD' => '&#36;',
		    'BND' => '&#36;',
		    'BOB' => '&#36;&#98;',
		    'BRL' => '&#82;&#36;',
		    'BSD' => '&#36;',
		    'BTN' => '&#78;&#117;&#46;', // ?
		    'BWP' => '&#80;',
		    'BYR' => '&#112;&#46;',
		    'BZD' => '&#66;&#90;&#36;',
		    'CAD' => '&#36;',
		    'CDF' => '&#70;&#67;',
		    'CHF' => '&#67;&#72;&#70;',
		    'CLF' => '', // ?
		    'CLP' => '&#36;',
		    'CNY' => '&#165;',
		    'COP' => '&#36;',
		    'CRC' => '&#8353;',
		    'CUP' => '&#8396;',
		    'CVE' => '&#36;', // ?
		    'CZK' => '&#75;&#269;',
		    'DJF' => '&#70;&#100;&#106;', // ?
		    'DKK' => '&#107;&#114;',
		    'DOP' => '&#82;&#68;&#36;',
		    'DZD' => '&#1583;&#1580;', // ?
		    'EGP' => '&#163;',
		    'ETB' => '&#66;&#114;',
		    'EUR' => '&#8364;',
		    'FJD' => '&#36;',
		    'FKP' => '&#163;',
		    'GBP' => '&#163;',
		    'GEL' => '&#4314;', // ?
		    'GHS' => '&#162;',
		    'GIP' => '&#163;',
		    'GMD' => '&#68;', // ?
		    'GNF' => '&#70;&#71;', // ?
		    'GTQ' => '&#81;',
		    'GYD' => '&#36;',
		    'HKD' => '&#36;',
		    'HNL' => '&#76;',
		    'HRK' => '&#107;&#110;',
		    'HTG' => '&#71;', // ?
		    'HUF' => '&#70;&#116;',
		    'IDR' => '&#82;&#112;',
		    'ILS' => '&#8362;',
		    'INR' => '&#8377;',
		    'IQD' => '&#1593;.&#1583;', // ?
		    'IRR' => '&#65020;',
		    'ISK' => '&#107;&#114;',
		    'JEP' => '&#163;',
		    'JMD' => '&#74;&#36;',
		    'JOD' => '&#74;&#68;', // ?
		    'JPY' => '&#165;',
		    'KES' => '&#75;&#83;&#104;', // ?
		    'KGS' => '&#1083;&#1074;',
		    'KHR' => '&#6107;',
		    'KMF' => '&#67;&#70;', // ?
		    'KPW' => '&#8361;',
		    'KRW' => '&#8361;',
		    'KWD' => '&#1583;.&#1603;', // ?
		    'KYD' => '&#36;',
		    'KZT' => '&#1083;&#1074;',
		    'LAK' => '&#8365;',
		    'LBP' => '&#163;',
		    'LKR' => '&#8360;',
		    'LRD' => '&#36;',
		    'LSL' => '&#76;', // ?
		    'LTL' => '&#76;&#116;',
		    'LVL' => '&#76;&#115;',
		    'LYD' => '&#1604;.&#1583;', // ?
		    'MAD' => '&#1583;.&#1605;.', //?
		    'MDL' => '&#76;',
		    'MGA' => '&#65;&#114;', // ?
		    'MKD' => '&#1076;&#1077;&#1085;',
		    'MMK' => '&#75;',
		    'MNT' => '&#8366;',
		    'MOP' => '&#77;&#79;&#80;&#36;', // ?
		    'MRO' => '&#85;&#77;', // ?
		    'MUR' => '&#8360;', // ?
		    'MVR' => '.&#1923;', // ?
		    'MWK' => '&#77;&#75;',
		    'MXN' => '&#36;',
		    'MYR' => '&#82;&#77;',
		    'MZN' => '&#77;&#84;',
		    'NAD' => '&#36;',
		    'NGN' => '&#8358;',
		    'NIO' => '&#67;&#36;',
		    'NOK' => '&#107;&#114;',
		    'NPR' => '&#8360;',
		    'NZD' => '&#36;',
		    'OMR' => '&#65020;',
		    'PAB' => '&#66;&#47;&#46;',
		    'PEN' => '&#83;&#47;&#46;',
		    'PGK' => '&#75;', // ?
		    'PHP' => '&#8369;',
		    'PKR' => '&#8360;',
		    'PLN' => '&#122;&#322;',
		    'PYG' => '&#71;&#115;',
		    'QAR' => '&#65020;',
		    'RON' => '&#108;&#101;&#105;',
		    'RSD' => '&#1044;&#1080;&#1085;&#46;',
		    'RUB' => '&#1088;&#1091;&#1073;',
		    'RWF' => '&#1585;.&#1587;',
		    'SAR' => '&#65020;',
		    'SBD' => '&#36;',
		    'SCR' => '&#8360;',
		    'SDG' => '&#163;', // ?
		    'SEK' => '&#107;&#114;',
		    'SGD' => '&#36;',
		    'SHP' => '&#163;',
		    'SLL' => '&#76;&#101;', // ?
		    'SOS' => '&#83;',
		    'SRD' => '&#36;',
		    'STD' => '&#68;&#98;', // ?
		    'SVC' => '&#36;',
		    'SYP' => '&#163;',
		    'SZL' => '&#76;', // ?
		    'THB' => '&#3647;',
		    'TJS' => '&#84;&#74;&#83;', // ? TJS (guess)
		    'TMT' => '&#109;',
		    'TND' => '&#1583;.&#1578;',
		    'TOP' => '&#84;&#36;',
		    'TRY' => '&#8356;', // New Turkey Lira (old symbol used)
		    'TTD' => '&#36;',
		    'TWD' => '&#78;&#84;&#36;',
		    'TZS' => '',
		    'UAH' => '&#8372;',
		    'UGX' => '&#85;&#83;&#104;',
		    'USD' => '&#36;',
		    'UYU' => '&#36;&#85;',
		    'UZS' => '&#1083;&#1074;',
		    'VEF' => '&#66;&#115;',
		    'VND' => '&#8363;',
		    'VUV' => '&#86;&#84;',
		    'WST' => '&#87;&#83;&#36;',
		    'XAF' => '&#70;&#67;&#70;&#65;',
		    'XCD' => '&#36;',
		    'XDR' => '',
		    'XOF' => '',
		    'XPF' => '&#70;',
		    'YER' => '&#65020;',
		    'ZAR' => '&#82;',
		    'ZMK' => '&#90;&#75;', // ?
		    'ZWL' => '&#90;&#36;',
		);
	}
	public function showFlash(){
		  $error = $this->session->flashdata('error');
		  $success = $this->session->flashdata('success');
		  $warning = $this->session->flashdata('warning');
		  if(isset($error)) {
			      echo '<div class="alert alert-danger alert-dismissable"> ';
		          echo '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>';
		          print_r($error);
		          echo '</span>';
		          echo'</div>';
		  } else if(isset($success)) {
		          echo '<div class="alert alert-success alert-dismissable"> ';
                  echo '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>';
                  print_r($success);
                  echo '</span>';
                  echo'</div>';
		  } 
		  if(isset($warning)) {
		          echo '<div class="alert alert-warning alert-dismissable"> ';
                  echo '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>';
                  print_r($warning);
                  echo '</span>';
                  echo'</div>';
		  }
	}
	public function deleteWhere($field = null, $id=null,$table=null){
		if($this->isLoggedIn()){
			$this->load->model('common_model');
			$delete=$this->common_model->delete($table,array($field=>$id));
			if($delete){
				$result['message']="Deleted successfully";
				$result['response']=1;
			}else{
				$result['message']="Error occurred try later";
				$result['response']=0;
			}
			echo json_encode($result);exit();
		}else{
			redirect('auth');
		}
	}
	public function delete($id=null,$table=null){
		if($this->isLoggedIn()){
			$this->load->model('common_model');
			$delete=$this->common_model->delete($table,array('id'=>$id));
			if($table == 'tbl_mcustomers') {
				$this->common_model->delete('tbl_accountledger', array('customer_id' => $id));
			} else if($table == 'tbl_suppliers') {
				$this->common_model->delete('tbl_accountledger', array('supplier_id' => $id));
			}
			if($delete){
				$result['message']="Deleted successfully";
				$result['response']=1;
			}else{
				$result['message']="Error occurred try later";
				$result['response']=0;
			}
			echo json_encode($result);exit();
		}else{
			redirect('auth');
		}
	}
	public function universaldelete($id=null,$table=null){
		if($this->isLoggedIn()){
			$this->load->model('common_model');
			$delete=$this->common_model->delete($table,array('id'=>$id));
			if($delete){
				$this->session->set_flashdata('success','Deleted successfully');
			}else{
				$this->session->set_flashdata('success','Erro try later');
			}
			redirect($_SERVER['HTTP_REFERER']);
		}else{
			redirect('auth');
		}
	}
	public function getActiveYearId(){
		$company_id = $this->session->userdata('company_id');
		if($this->isLoggedIn()){
			$this->load->model('common_model');
			$result=$this->common_model->getOne('tbl_financialyear',array('isActive'=>1, 'company_id' => $company_id));
			if(isset($result->id)){
				return $result->id;
			}
		}else{
			redirect('auth');
		}
	}
	public function getActiveYearDate(){
		if($this->isLoggedIn()){
			$company_id = $this->session->userdata('company_id');
			$this->load->model('common_model');
			$result=$this->common_model->getOne('tbl_financialyear',array('isActive'=>1,'company_id' => $company_id));
			if(!empty($result)){
				return $result;
			}
		}else{
			redirect('auth');
		}
	}
	public function getActiveYear(){
		if($this->isLoggedIn()){
			$this->load->model('common_model');
			if($this->input->post('date')){
				$dateActiveYear=date('Y-m-d',strtotime($this->input->post('date')));
				// echo $dateActiveYear;die();
				   $activeYear=$this->transaction_model->getOne('tbl_financialyear',array('isActive'=>1));
					  if(!empty($activeYear)){
					   if($dateActiveYear >= $activeYear->fromDate && $dateActiveYear <= $activeYear->toDate){
					  	 // echo "<prev>",print_r($activeYear),'</pre>';exit();
					   			$result['response']='matched';
					   			echo json_encode($result);exit();
					   }else{
					   		$result['response']='notmatched';
					   		echo json_encode($result);exit();
					   }	
					}else{
						$result['response']='empty';
						echo json_encode($result);exit();
					}
				 }
		}else{
			redirect('auth');
		}
	}
	public function checkActiveYear(){
		if($this->isLoggedIn()){
			$this->load->model('common_model');
				   $activeYear=$this->transaction_model->getOne('tbl_financialyear',array('isActive'=>1));
					  if(empty($activeYear)){
						$result['response']='empty';
						echo json_encode($result);exit();
					}else{
						$result['response']='ok';
						echo json_encode($result);exit();
					}
				 
		}else{
			redirect('auth');
		}
	}
	public function clearTables(){
		if($this->isLoggedIn()){
				$this->load->model('common_model');
				$this->common_model->clearTables();
		        redirect('accounting/purchases/purchaseQuotation');
		}else{
			redirect('auth');
		}
	}
	public function countriesList(){
		$countryArray = array(
								'AD'=>array('name'=>'ANDORRA','code'=>'376'),
								'AE'=>array('name'=>'UNITED ARAB EMIRATES','code'=>'971'),
								'AF'=>array('name'=>'AFGHANISTAN','code'=>'93'),
								'AG'=>array('name'=>'ANTIGUA AND BARBUDA','code'=>'1268'),
								'AI'=>array('name'=>'ANGUILLA','code'=>'1264'),
								'AL'=>array('name'=>'ALBANIA','code'=>'355'),
								'AM'=>array('name'=>'ARMENIA','code'=>'374'),
								'AN'=>array('name'=>'NETHERLANDS ANTILLES','code'=>'599'),
								'AO'=>array('name'=>'ANGOLA','code'=>'244'),
								'AQ'=>array('name'=>'ANTARCTICA','code'=>'672'),
								'AR'=>array('name'=>'ARGENTINA','code'=>'54'),
								'AS'=>array('name'=>'AMERICAN SAMOA','code'=>'1684'),
								'AT'=>array('name'=>'AUSTRIA','code'=>'43'),
								'AU'=>array('name'=>'AUSTRALIA','code'=>'61'),
								'AW'=>array('name'=>'ARUBA','code'=>'297'),
								'AZ'=>array('name'=>'AZERBAIJAN','code'=>'994'),
								'BA'=>array('name'=>'BOSNIA AND HERZEGOVINA','code'=>'387'),
								'BB'=>array('name'=>'BARBADOS','code'=>'1246'),
								'BD'=>array('name'=>'BANGLADESH','code'=>'880'),
								'BE'=>array('name'=>'BELGIUM','code'=>'32'),
								'BF'=>array('name'=>'BURKINA FASO','code'=>'226'),
								'BG'=>array('name'=>'BULGARIA','code'=>'359'),
								'BH'=>array('name'=>'BAHRAIN','code'=>'973'),
								'BI'=>array('name'=>'BURUNDI','code'=>'257'),
								'BJ'=>array('name'=>'BENIN','code'=>'229'),
								'BL'=>array('name'=>'SAINT BARTHELEMY','code'=>'590'),
								'BM'=>array('name'=>'BERMUDA','code'=>'1441'),
								'BN'=>array('name'=>'BRUNEI DARUSSALAM','code'=>'673'),
								'BO'=>array('name'=>'BOLIVIA','code'=>'591'),
								'BR'=>array('name'=>'BRAZIL','code'=>'55'),
								'BS'=>array('name'=>'BAHAMAS','code'=>'1242'),
								'BT'=>array('name'=>'BHUTAN','code'=>'975'),
								'BW'=>array('name'=>'BOTSWANA','code'=>'267'),
								'BY'=>array('name'=>'BELARUS','code'=>'375'),
								'BZ'=>array('name'=>'BELIZE','code'=>'501'),
								'CA'=>array('name'=>'CANADA','code'=>'1'),
								'CC'=>array('name'=>'COCOS (KEELING) ISLANDS','code'=>'61'),
								'CD'=>array('name'=>'CONGO, THE DEMOCRATIC REPUBLIC OF THE','code'=>'243'),
								'CF'=>array('name'=>'CENTRAL AFRICAN REPUBLIC','code'=>'236'),
								'CG'=>array('name'=>'CONGO','code'=>'242'),
								'CH'=>array('name'=>'SWITZERLAND','code'=>'41'),
								'CI'=>array('name'=>'COTE D IVOIRE','code'=>'225'),
								'CK'=>array('name'=>'COOK ISLANDS','code'=>'682'),
								'CL'=>array('name'=>'CHILE','code'=>'56'),
								'CM'=>array('name'=>'CAMEROON','code'=>'237'),
								'CN'=>array('name'=>'CHINA','code'=>'86'),
								'CO'=>array('name'=>'COLOMBIA','code'=>'57'),
								'CR'=>array('name'=>'COSTA RICA','code'=>'506'),
								'CU'=>array('name'=>'CUBA','code'=>'53'),
								'CV'=>array('name'=>'CAPE VERDE','code'=>'238'),
								'CX'=>array('name'=>'CHRISTMAS ISLAND','code'=>'61'),
								'CY'=>array('name'=>'CYPRUS','code'=>'357'),
								'CZ'=>array('name'=>'CZECH REPUBLIC','code'=>'420'),
								'DE'=>array('name'=>'GERMANY','code'=>'49'),
								'DJ'=>array('name'=>'DJIBOUTI','code'=>'253'),
								'DK'=>array('name'=>'DENMARK','code'=>'45'),
								'DM'=>array('name'=>'DOMINICA','code'=>'1767'),
								'DO'=>array('name'=>'DOMINICAN REPUBLIC','code'=>'1809'),
								'DZ'=>array('name'=>'ALGERIA','code'=>'213'),
								'EC'=>array('name'=>'ECUADOR','code'=>'593'),
								'EE'=>array('name'=>'ESTONIA','code'=>'372'),
								'EG'=>array('name'=>'EGYPT','code'=>'20'),
								'ER'=>array('name'=>'ERITREA','code'=>'291'),
								'ES'=>array('name'=>'SPAIN','code'=>'34'),
								'ET'=>array('name'=>'ETHIOPIA','code'=>'251'),
								'FI'=>array('name'=>'FINLAND','code'=>'358'),
								'FJ'=>array('name'=>'FIJI','code'=>'679'),
								'FK'=>array('name'=>'FALKLAND ISLANDS (MALVINAS)','code'=>'500'),
								'FM'=>array('name'=>'MICRONESIA, FEDERATED STATES OF','code'=>'691'),
								'FO'=>array('name'=>'FAROE ISLANDS','code'=>'298'),
								'FR'=>array('name'=>'FRANCE','code'=>'33'),
								'GA'=>array('name'=>'GABON','code'=>'241'),
								'GB'=>array('name'=>'UNITED KINGDOM','code'=>'44'),
								'GD'=>array('name'=>'GRENADA','code'=>'1473'),
								'GE'=>array('name'=>'GEORGIA','code'=>'995'),
								'GH'=>array('name'=>'GHANA','code'=>'233'),
								'GI'=>array('name'=>'GIBRALTAR','code'=>'350'),
								'GL'=>array('name'=>'GREENLAND','code'=>'299'),
								'GM'=>array('name'=>'GAMBIA','code'=>'220'),
								'GN'=>array('name'=>'GUINEA','code'=>'224'),
								'GQ'=>array('name'=>'EQUATORIAL GUINEA','code'=>'240'),
								'GR'=>array('name'=>'GREECE','code'=>'30'),
								'GT'=>array('name'=>'GUATEMALA','code'=>'502'),
								'GU'=>array('name'=>'GUAM','code'=>'1671'),
								'GW'=>array('name'=>'GUINEA-BISSAU','code'=>'245'),
								'GY'=>array('name'=>'GUYANA','code'=>'592'),
								'HK'=>array('name'=>'HONG KONG','code'=>'852'),
								'HN'=>array('name'=>'HONDURAS','code'=>'504'),
								'HR'=>array('name'=>'CROATIA','code'=>'385'),
								'HT'=>array('name'=>'HAITI','code'=>'509'),
								'HU'=>array('name'=>'HUNGARY','code'=>'36'),
								'ID'=>array('name'=>'INDONESIA','code'=>'62'),
								'IE'=>array('name'=>'IRELAND','code'=>'353'),
								'IL'=>array('name'=>'ISRAEL','code'=>'972'),
								'IM'=>array('name'=>'ISLE OF MAN','code'=>'44'),
								'IN'=>array('name'=>'INDIA','code'=>'91'),
								'IQ'=>array('name'=>'IRAQ','code'=>'964'),
								'IR'=>array('name'=>'IRAN, ISLAMIC REPUBLIC OF','code'=>'98'),
								'IS'=>array('name'=>'ICELAND','code'=>'354'),
								'IT'=>array('name'=>'ITALY','code'=>'39'),
								'JM'=>array('name'=>'JAMAICA','code'=>'1876'),
								'JO'=>array('name'=>'JORDAN','code'=>'962'),
								'JP'=>array('name'=>'JAPAN','code'=>'81'),
								'KE'=>array('name'=>'KENYA','code'=>'254'),
								'KG'=>array('name'=>'KYRGYZSTAN','code'=>'996'),
								'KH'=>array('name'=>'CAMBODIA','code'=>'855'),
								'KI'=>array('name'=>'KIRIBATI','code'=>'686'),
								'KM'=>array('name'=>'COMOROS','code'=>'269'),
								'KN'=>array('name'=>'SAINT KITTS AND NEVIS','code'=>'1869'),
								'KP'=>array('name'=>'KOREA DEMOCRATIC PEOPLES REPUBLIC OF','code'=>'850'),
								'KR'=>array('name'=>'KOREA REPUBLIC OF','code'=>'82'),
								'KW'=>array('name'=>'KUWAIT','code'=>'965'),
								'KY'=>array('name'=>'CAYMAN ISLANDS','code'=>'1345'),
								'KZ'=>array('name'=>'KAZAKSTAN','code'=>'7'),
								'LA'=>array('name'=>'LAO PEOPLES DEMOCRATIC REPUBLIC','code'=>'856'),
								'LB'=>array('name'=>'LEBANON','code'=>'961'),
								'LC'=>array('name'=>'SAINT LUCIA','code'=>'1758'),
								'LI'=>array('name'=>'LIECHTENSTEIN','code'=>'423'),
								'LK'=>array('name'=>'SRI LANKA','code'=>'94'),
								'LR'=>array('name'=>'LIBERIA','code'=>'231'),
								'LS'=>array('name'=>'LESOTHO','code'=>'266'),
								'LT'=>array('name'=>'LITHUANIA','code'=>'370'),
								'LU'=>array('name'=>'LUXEMBOURG','code'=>'352'),
								'LV'=>array('name'=>'LATVIA','code'=>'371'),
								'LY'=>array('name'=>'LIBYAN ARAB JAMAHIRIYA','code'=>'218'),
								'MA'=>array('name'=>'MOROCCO','code'=>'212'),
								'MC'=>array('name'=>'MONACO','code'=>'377'),
								'MD'=>array('name'=>'MOLDOVA, REPUBLIC OF','code'=>'373'),
								'ME'=>array('name'=>'MONTENEGRO','code'=>'382'),
								'MF'=>array('name'=>'SAINT MARTIN','code'=>'1599'),
								'MG'=>array('name'=>'MADAGASCAR','code'=>'261'),
								'MH'=>array('name'=>'MARSHALL ISLANDS','code'=>'692'),
								'MK'=>array('name'=>'MACEDONIA, THE FORMER YUGOSLAV REPUBLIC OF','code'=>'389'),
								'ML'=>array('name'=>'MALI','code'=>'223'),
								'MM'=>array('name'=>'MYANMAR','code'=>'95'),
								'MN'=>array('name'=>'MONGOLIA','code'=>'976'),
								'MO'=>array('name'=>'MACAU','code'=>'853'),
								'MP'=>array('name'=>'NORTHERN MARIANA ISLANDS','code'=>'1670'),
								'MR'=>array('name'=>'MAURITANIA','code'=>'222'),
								'MS'=>array('name'=>'MONTSERRAT','code'=>'1664'),
								'MT'=>array('name'=>'MALTA','code'=>'356'),
								'MU'=>array('name'=>'MAURITIUS','code'=>'230'),
								'MV'=>array('name'=>'MALDIVES','code'=>'960'),
								'MW'=>array('name'=>'MALAWI','code'=>'265'),
								'MX'=>array('name'=>'MEXICO','code'=>'52'),
								'MY'=>array('name'=>'MALAYSIA','code'=>'60'),
								'MZ'=>array('name'=>'MOZAMBIQUE','code'=>'258'),
								'NA'=>array('name'=>'NAMIBIA','code'=>'264'),
								'NC'=>array('name'=>'NEW CALEDONIA','code'=>'687'),
								'NE'=>array('name'=>'NIGER','code'=>'227'),
								'NG'=>array('name'=>'NIGERIA','code'=>'234'),
								'NI'=>array('name'=>'NICARAGUA','code'=>'505'),
								'NL'=>array('name'=>'NETHERLANDS','code'=>'31'),
								'NO'=>array('name'=>'NORWAY','code'=>'47'),
								'NP'=>array('name'=>'NEPAL','code'=>'977'),
								'NR'=>array('name'=>'NAURU','code'=>'674'),
								'NU'=>array('name'=>'NIUE','code'=>'683'),
								'NZ'=>array('name'=>'NEW ZEALAND','code'=>'64'),
								'OM'=>array('name'=>'OMAN','code'=>'968'),
								'PA'=>array('name'=>'PANAMA','code'=>'507'),
								'PE'=>array('name'=>'PERU','code'=>'51'),
								'PF'=>array('name'=>'FRENCH POLYNESIA','code'=>'689'),
								'PG'=>array('name'=>'PAPUA NEW GUINEA','code'=>'675'),
								'PH'=>array('name'=>'PHILIPPINES','code'=>'63'),
								'PK'=>array('name'=>'PAKISTAN','code'=>'92'),
								'PL'=>array('name'=>'POLAND','code'=>'48'),
								'PM'=>array('name'=>'SAINT PIERRE AND MIQUELON','code'=>'508'),
								'PN'=>array('name'=>'PITCAIRN','code'=>'870'),
								'PR'=>array('name'=>'PUERTO RICO','code'=>'1'),
								'PT'=>array('name'=>'PORTUGAL','code'=>'351'),
								'PW'=>array('name'=>'PALAU','code'=>'680'),
								'PY'=>array('name'=>'PARAGUAY','code'=>'595'),
								'QA'=>array('name'=>'QATAR','code'=>'974'),
								'RO'=>array('name'=>'ROMANIA','code'=>'40'),
								'RS'=>array('name'=>'SERBIA','code'=>'381'),
								'RU'=>array('name'=>'RUSSIAN FEDERATION','code'=>'7'),
								'RW'=>array('name'=>'RWANDA','code'=>'250'),
								'SA'=>array('name'=>'SAUDI ARABIA','code'=>'966'),
								'SB'=>array('name'=>'SOLOMON ISLANDS','code'=>'677'),
								'SC'=>array('name'=>'SEYCHELLES','code'=>'248'),
								'SD'=>array('name'=>'SUDAN','code'=>'249'),
								'SE'=>array('name'=>'SWEDEN','code'=>'46'),
								'SG'=>array('name'=>'SINGAPORE','code'=>'65'),
								'SH'=>array('name'=>'SAINT HELENA','code'=>'290'),
								'SI'=>array('name'=>'SLOVENIA','code'=>'386'),
								'SK'=>array('name'=>'SLOVAKIA','code'=>'421'),
								'SL'=>array('name'=>'SIERRA LEONE','code'=>'232'),
								'SM'=>array('name'=>'SAN MARINO','code'=>'378'),
								'SN'=>array('name'=>'SENEGAL','code'=>'221'),
								'SO'=>array('name'=>'SOMALIA','code'=>'252'),
								'SR'=>array('name'=>'SURINAME','code'=>'597'),
								'ST'=>array('name'=>'SAO TOME AND PRINCIPE','code'=>'239'),
								'SV'=>array('name'=>'EL SALVADOR','code'=>'503'),
								'SY'=>array('name'=>'SYRIAN ARAB REPUBLIC','code'=>'963'),
								'SZ'=>array('name'=>'SWAZILAND','code'=>'268'),
								'TC'=>array('name'=>'TURKS AND CAICOS ISLANDS','code'=>'1649'),
								'TD'=>array('name'=>'CHAD','code'=>'235'),
								'TG'=>array('name'=>'TOGO','code'=>'228'),
								'TH'=>array('name'=>'THAILAND','code'=>'66'),
								'TJ'=>array('name'=>'TAJIKISTAN','code'=>'992'),
								'TK'=>array('name'=>'TOKELAU','code'=>'690'),
								'TL'=>array('name'=>'TIMOR-LESTE','code'=>'670'),
								'TM'=>array('name'=>'TURKMENISTAN','code'=>'993'),
								'TN'=>array('name'=>'TUNISIA','code'=>'216'),
								'TO'=>array('name'=>'TONGA','code'=>'676'),
								'TR'=>array('name'=>'TURKEY','code'=>'90'),
								'TT'=>array('name'=>'TRINIDAD AND TOBAGO','code'=>'1868'),
								'TV'=>array('name'=>'TUVALU','code'=>'688'),
								'TW'=>array('name'=>'TAIWAN, PROVINCE OF CHINA','code'=>'886'),
								'TZ'=>array('name'=>'TANZANIA, UNITED REPUBLIC OF','code'=>'255'),
								'UA'=>array('name'=>'UKRAINE','code'=>'380'),
								'UG'=>array('name'=>'UGANDA','code'=>'256'),
								'US'=>array('name'=>'UNITED STATES','code'=>'1'),
								'UY'=>array('name'=>'URUGUAY','code'=>'598'),
								'UZ'=>array('name'=>'UZBEKISTAN','code'=>'998'),
								'VA'=>array('name'=>'HOLY SEE (VATICAN CITY STATE)','code'=>'39'),
								'VC'=>array('name'=>'SAINT VINCENT AND THE GRENADINES','code'=>'1784'),
								'VE'=>array('name'=>'VENEZUELA','code'=>'58'),
								'VG'=>array('name'=>'VIRGIN ISLANDS, BRITISH','code'=>'1284'),
								'VI'=>array('name'=>'VIRGIN ISLANDS, U.S.','code'=>'1340'),
								'VN'=>array('name'=>'VIET NAM','code'=>'84'),
								'VU'=>array('name'=>'VANUATU','code'=>'678'),
								'WF'=>array('name'=>'WALLIS AND FUTUNA','code'=>'681'),
								'WS'=>array('name'=>'SAMOA','code'=>'685'),
								'XK'=>array('name'=>'KOSOVO','code'=>'381'),
								'YE'=>array('name'=>'YEMEN','code'=>'967'),
								'YT'=>array('name'=>'MAYOTTE','code'=>'262'),
								'ZA'=>array('name'=>'SOUTH AFRICA','code'=>'27'),
								'ZM'=>array('name'=>'ZAMBIA','code'=>'260'),
								'ZW'=>array('name'=>'ZIMBABWE','code'=>'263')
							);
		return $countryArray;
	}
	public function convert_number_to_words($number) {

			    $hyphen      = '-';
			    $conjunction = ' and ';
			    $separator   = ', ';
			    $negative    = 'negative ';
			    $decimal     = ' point ';
			    $dictionary  = array(
			        0                   => 'zero',
			        1                   => 'one',
			        2                   => 'two',
			        3                   => 'three',
			        4                   => 'four',
			        5                   => 'five',
			        6                   => 'six',
			        7                   => 'seven',
			        8                   => 'eight',
			        9                   => 'nine',
			        10                  => 'ten',
			        11                  => 'eleven',
			        12                  => 'twelve',
			        13                  => 'thirteen',
			        14                  => 'fourteen',
			        15                  => 'fifteen',
			        16                  => 'sixteen',
			        17                  => 'seventeen',
			        18                  => 'eighteen',
			        19                  => 'nineteen',
			        20                  => 'twenty',
			        30                  => 'thirty',
			        40                  => 'fourty',
			        50                  => 'fifty',
			        60                  => 'sixty',
			        70                  => 'seventy',
			        80                  => 'eighty',
			        90                  => 'ninety',
			        100                 => 'hundred',
			        1000                => 'thousand',
			        1000000             => 'million',
			        1000000000          => 'billion',
			        1000000000000       => 'trillion',
			        1000000000000000    => 'quadrillion',
			        1000000000000000000 => 'quintillion'
			    );

			    if (!is_numeric($number)) {
			        return false;
			    }

			    if (($number >= 0 && (int) $number < 0) || (int) $number < 0 - PHP_INT_MAX) {
			        // overflow
			        trigger_error(
			            'convert_number_to_words only accepts numbers between -' . PHP_INT_MAX . ' and ' . PHP_INT_MAX,
			            E_USER_WARNING
			        );
			        return false;
			    }

			    if ($number < 0) {
			        return $negative . $this->convert_number_to_words(abs($number));
			    }

			    $string = $fraction = null;

			    if (strpos($number, '.') !== false) {
			        list($number, $fraction) = explode('.', $number);
			    }

			    switch (true) {
			        case $number < 21:
			            $string = $dictionary[$number];
			            break;
			        case $number < 100:
			            $tens   = ((int) ($number / 10)) * 10;
			            $units  = $number % 10;
			            $string = $dictionary[$tens];
			            if ($units) {
			                $string .= $hyphen . $dictionary[$units];
			            }
			            break;
			        case $number < 1000:
			            $hundreds  = $number / 100;
			            $remainder = $number % 100;
			            $string = $dictionary[$hundreds] . ' ' . $dictionary[100];
			            if ($remainder) {
			                $string .= $conjunction . $this->convert_number_to_words($remainder);
			            }
			            break;
			        default:
			            $baseUnit = pow(1000, floor(log($number, 1000)));
			            $numBaseUnits = (int) ($number / $baseUnit);
			            $remainder = $number % $baseUnit;
			            $string = $this->convert_number_to_words($numBaseUnits) . ' ' . $dictionary[$baseUnit];
			            if ($remainder) {
			                $string .= $remainder < 100 ? $conjunction : $separator;
			                $string .= $this->convert_number_to_words($remainder);
			            }
			            break;
			    }

			    if (null !== $fraction && is_numeric($fraction)) {
			        $string .= $decimal;
			        $words = array();
			        foreach (str_split((string) $fraction) as $number) {
			            $words[] = $dictionary[$number];
			        }
			        $string .= implode(' ', $words);
			    }

			    return $string;
			}

	public function set_barcode($code){
		$this->load->add_package_path(APPPATH.'third_party/erp');
		$this->load->library('zend');
		$this->zend->load('Zend/Barcode');
		$barcodeOptions = array('text' => $code, 'barHeight' => 30);
		$file = Zend_Barcode::draw('code128', 'image', $barcodeOptions , array());
		$store_image = imagepng($file,"assets/erp/barcodes/{$code}.png");
		return $code.'.png';
	}
	public function load_erp_package()
	{
		$this->load->add_package_path(APPPATH.'third_party/erp');
		$this->load->database();
		$this->lang->load('english_labels_lang', 'english');
		$this->load->model('common_model');
		$this->load->model('admin_model');
	}
}