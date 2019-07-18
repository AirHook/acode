<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Create extends Sales_Controller {

	/**
	 * Constructor
	 *
	 * @return	void
	 */
	public function __construct()
	{
		parent::__construct();

		$this->DB = $this->load->database('instyle', TRUE);
    }

	// ----------------------------------------------------------------------

	/**
	 * Index - Add New Account
	 *
	 * @return	void
	 */
	public function index()
	{
		// generate the plugin scripts and css
		$this->_create_plugin_scripts();

		// load pertinent library/model/helpers
		$this->load->library('form_validation');
		$this->load->library('users/sales_users_list');
		$this->load->library('designers/designers_list');
		$this->load->library('users/wholesale_users_list');
		$this->load->library('users/vendor_users_list');
		$this->load->library('color_list');
		$this->load->model('get_sizes_by_mode');
		$this->load->model('get_shipmethod');
		$this->load->library('odoo');
		$this->load->library('sales_orders/sales_orders_list');
		$this->load->library('users/sales_user_details');
		$this->load->library('categories/categories_tree');

		// get some data
		// NOTE: currently defaulting to basixblacklabel only
		$this->data['sales'] = $this->sales_users_list->select(array('admin_sales_id'=>$this->sales_user_details->admin_sales_id));
		$this->data['designers'] =
			$this->designers_list->select(
				array(
					'designer.url_structure' => $this->sales_user_details->designer
				)
			)
		;
		$this->data['vendors'] = $this->vendor_users_list->select(array('reference_designer'=>'basixblacklabel'));
		$this->data['users'] = $this->wholesale_users_list->select(
			array(
				'tbluser_data_wholesale.reference_designer' => $this->sales_user_details->designer
			)
		);
		$this->data['colors'] = $this->color_list->select();
		$this->data['sizes'] = $this->get_sizes_by_mode->get_sizes('1'); // manually set first due to default basix
		$this->data['shipmethod'] = $this->get_shipmethod->get_shipmethod();

		// get some data
		$this->data['categories'] = $this->categories_tree->treelist(array('with_products'=>TRUE));

		// autogenerate PO#
		$max_sales_order_number = $this->sales_orders_list->max_sales_order_number() ?: '911991';
		$this->data['sales_order_number'] = $max_sales_order_number + 1;

		// set validation rules
		$this->form_validation->set_rules('sales_order_number', 'Sales Order Number', 'trim|required');
		$this->form_validation->set_rules('sales_order_date', 'Sales Order Date', 'trim|required');
		$this->form_validation->set_rules('admin_sales_id', 'Sales User', 'trim|required');
		$this->form_validation->set_rules('des_id', 'Designer', 'trim|required');
		$this->form_validation->set_rules('user_id', 'Store Name', 'trim|required');
		//$this->form_validation->set_rules('vendor_id', 'Vendor', 'trim|required');
		$this->form_validation->set_rules('courier', 'Courier', 'trim|required');

		/*
		$this->form_validation->set_rules('ship_address1', 'Ship To Address1', 'trim|required');
		$this->form_validation->set_rules('ship_city', 'Ship To City', 'trim|required');
		$this->form_validation->set_rules('ship_state', 'Ship To State', 'trim|required');
		$this->form_validation->set_rules('ship_country', 'Ship To Country', 'trim|required');
		$this->form_validation->set_rules('ship_zipcode', 'Ship To Zipcode', 'trim|required');
		$this->form_validation->set_rules('bill_address1', 'Bill To Address1', 'trim|required');
		$this->form_validation->set_rules('bill_city', 'Bill To City', 'trim|required');
		$this->form_validation->set_rules('bill_state', 'Bill To State', 'trim|required');
		$this->form_validation->set_rules('bill_country', 'Bill To Country', 'trim|required');
		$this->form_validation->set_rules('bill_zipcode', 'Bill To Zipcode', 'trim|required');
		*/

		$this->form_validation->set_rules('prod_no[]', 'Prod Number', 'trim|required', array('required'=>'Please select a product'));
		$this->form_validation->set_rules('color_code[]', 'Color', 'trim|required', array('required'=>'Product must have color'));
		$this->form_validation->set_rules('size[]', 'Size', 'trim|required', array('required'=>'Select a size to order'));
		$this->form_validation->set_rules('qty[]', 'Qty', 'trim|required', array('required'=>'Set a qty to order'));

		if ($this->form_validation->run() == FALSE)
		{
			// get some data
			$this->data['active_sales_user'] =
				$this->session->admin_sales_id // current logged in sales user
				?: '1' // house/super sales user
			;
			// initialize sales user details
			$this->sales_user_details->initialize(array('admin_sales_id'=>$this->data['active_sales_user']));

			// set data variables...
			$this->data['file'] = 'sales_orders_add';
			$this->data['page_title'] = 'Create Sales Orders';
			$this->data['page_description'] = 'Create New Sales Orders';

			// load views...
			//$this->load->view('admin/'.($this->config->slash_item('admin_template') ?: 'metronic/').'template/template', $this->data);
			$this->load->view($this->data['sales_theme'].'/sales/template/template', $this->data);
		}
		else
		{
			//echo '<pre>';
			//print_r($this->input->post());
			//die();

			// insert record
			$post_ary = $this->input->post();
			// set necessary variables
			// status - 1 - complete, 2 - hold, 3 - return, 4 - pending
			$post_ary['status'] = '4';

			/*
			// ensuer that prod_no are all capitalized
			for ($i = 0; $i < sizeof($post_ary['items']); $i++)
			{
				$post_ary['items'][$i]['prod_no'] = strtoupper($post_ary['items'][$i]['prod_no']);
				$post_ary['items'][$i]['color_code'] = strtoupper($post_ary['items'][$i]['color_code']);
				$post_ary['items'][$i]['color_name'] = strtoupper($post_ary['items'][$i]['color_name']);
			}
			*/

			// create a single array "items" to hold product list on order
			$number_of_items = count($post_ary['prod_no']);
			for($inx = 0; $inx < $number_of_items; $inx++)
			{
				$post_ary['items'][$inx]['prod_no'] = strtoupper($post_ary['prod_no'][$inx]);
				$post_ary['items'][$inx]['color_code'] = strtoupper($post_ary['color_code'][$inx]);
				$post_ary['items'][$inx]['color_name'] = strtoupper($post_ary['color_name'][$inx]);
				$post_ary['items'][$inx]['image_url_path'] = $post_ary['image_url_path'][$inx];
				$post_ary['items'][$inx]['size'] = $post_ary['size'][$inx];
				$post_ary['items'][$inx]['qty'] = $post_ary['qty'][$inx];
				$post_ary['items'][$inx]['wholesale_price'] = $post_ary['wholesale_price'][$inx];
			}
			$post_ary['items'] = json_encode($post_ary['items']);
			$post_ary['sales_order_date'] = strtotime($post_ary['sales_order_date']);
			$post_ary['amount'] = array_sum($post_ary['ext_price']);

			// save array to $post_to_odoo
			$post_to_odoo = $post_ary;

			// unset unneeded variables
			unset($post_ary['admin_sales_email']);
			unset($post_ary['designer_slug']);
			unset($post_ary['prod_no']);
			unset($post_ary['color_code']);
			unset($post_ary['color_name']);
			unset($post_ary['image_url_path']);
			unset($post_ary['size']);
			unset($post_ary['qty']);
			unset($post_ary['wholesale_price']);
			unset($post_ary['ext_price']);

			unset($post_to_odoo['prod_no']);
			unset($post_to_odoo['color_code']);
			unset($post_to_odoo['color_name']);
			unset($post_to_odoo['image_url_path']);
			unset($post_to_odoo['size']);
			unset($post_to_odoo['qty']);
			unset($post_to_odoo['wholesale_price']);
			unset($post_to_odoo['ext_price']);
			unset($post_to_odoo['amount']);

			// insert to database
			$query = $this->DB->insert('sales_orders', $post_ary);
			$insert_id = $this->DB->insert_id();

			// additional items to pass to odoo
			$post_to_odoo['sales_order_id'] = $insert_id;
			$post_to_odoo['sales_order_date'] = $this->input->post('sales_order_date');

			// unset unneeded variables
			//unset($post_to_odoo['des_code']);
			//unset($post_to_odoo['po_number']);

			if (
				ENVIRONMENT !== 'development'
				&& @$post_to_odoo['des_id'] === '5' // for basix
			)
			{
				// pass to odoo
				$odoo_response = $this->odoo->post_data($post_to_odoo, 'sales_order', 'add');
			}

			//echo '<pre>';
			//print_r($post_to_odoo);
			//echo $odoo_response;
			//die();

			// set flash data
			$this->session->set_flashdata('success', 'add');

			// redirect user
			redirect('sales/sales_orders/details/index/'.$insert_id);
		}
	}

	// ----------------------------------------------------------------------

	/**
	 * PRIVATE - Callback function to check on submitted domain name
	 * if it exists already or not
	 *
	 * @return	boolean
	 */
	public function check_domain_name($str)
	{
		// let's check if the domain name exists already
		$query = $this->DB->get_where('webspaces', array('domain_name'=>$str));
		if ($query->num_rows() == 1)
		{
			// domain_name exists
			$this->form_validation->set_message('check_domain_name', 'The {field} field already exists.');
			return FALSE;
		}

		// let's validate the domain name
		$domain = $str;

		// remove the http protocol
		if(stripos($domain, 'http://') === 0)
		{
			$domain = str_replace('http://', '', $domain);
		}

		// remove the www prefix to be able to manipulate the domain name
		if(stripos($domain, 'www.') === 0)
		{
			$domain = str_replace('www.', '', $domain);
		}

		// Not even a single . this will eliminate things like abcd, since http://abcd is reported valid
		if( ! substr_count($domain, '.'))
		{
			// no dot at all
			$this->form_validation->set_message('check_domain_name', 'The {field} is not a domain.');
			return false;
		}

		// check for TLD validity
		$valid_tlds = array('com', 'net');
		$exp = explode('.', $domain);
		$tld = $exp[count($exp) - 1];
		if ( ! in_array($tld, $valid_tlds))
		{
			// not the correct tld
			$this->form_validation->set_message('check_domain_name', 'The {field} has an invalid TLD.');
			return false;
		}

		$again = 'http://' . $domain;
		if ( ! filter_var($again, FILTER_VALIDATE_URL))
		{
			// invalid domain
			$this->form_validation->set_message('check_domain_name', 'The {field} is invalid');
			return false;
		}
		return TRUE;
	}

	// --------------------------------------------------------------------

	/**
	 * Form Validation Callback Functions
	 *
	 * @return	boolean
	 */
	function validate_email($str)
	{
		if ($str == '')
		{
			$this->form_validation->set_message('validate_email', 'Please enter an email address of the Email field.');
			return FALSE;
		}
		else
		{
			if ( ! filter_var($str, FILTER_VALIDATE_EMAIL))
			{
				$this->form_validation->set_message('validate_email', 'The Email field must contain a valid email address.');
				return FALSE;
			}
			else return TRUE;
		}
	}

	// ----------------------------------------------------------------------

	/**
	 * PRIVATE - Creaet Plugin Scripts and CSS for the page
	 *
	 * @return	void
	 */
	private function _create_plugin_scripts()
	{
		$assets_url = base_url('assets/metronic');

		/****************
		 * page styles plugins inserted at <head>
		 * after global mandatory styles, before theme global styles
		 */
		$this->data['page_level_styles_plugins'] = '';

			// ladda - show loading or progress bar on buttons
			$this->data['page_level_styles_plugins'].= '
				<link href="'.$assets_url.'/assets/global/plugins/ladda/ladda-themeless.min.css" rel="stylesheet" type="text/css" />
			';
			// bootstrap select
			$this->data['page_level_styles_plugins'].= '
				<link href="'.$assets_url.'/assets/global/plugins/bootstrap-select/css/bootstrap-select.css" rel="stylesheet" type="text/css" />
			';
			// datepicker & date-time-pickers
			$this->data['page_level_styles_plugins'].= '
				<link href="'.$assets_url.'/assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css" rel="stylesheet" type="text/css" />
			';

		/****************
		 * page style sheets inserted at <head>
		 */
		$this->data['page_level_styles'] = '';

		/****************
		 * page js plugins inserted at <bottom>
		 * after core plugins, before global scripts
		 */
		$this->data['page_level_plugins'] = '';

			// ladda - show loading or progress bar on buttons
			$this->data['page_level_plugins'].= '
				<script src="'.$assets_url.'/assets/global/plugins/ladda/spin.min.js" type="text/javascript"></script>
				<script src="'.$assets_url.'/assets/global/plugins/ladda/ladda.min.js" type="text/javascript"></script>
			';
			// bootstrap select
			$this->data['page_level_plugins'].= '
				<script src="'.$assets_url.'/assets/global/plugins/bootstrap-select/js/bootstrap-select.min.js" type="text/javascript"></script>
			';
			// form validation
			$this->data['page_level_plugins'].= '
				<script src="'.$assets_url.'/assets/global/plugins/jquery-validation/js/jquery.validate.min.js" type="text/javascript"></script>
				<script src="'.$assets_url.'/assets/global/plugins/jquery-validation/js/additional-methods.min.js" type="text/javascript"></script>
			';
			// datepicker & date-time-pickers
			$this->data['page_level_plugins'].= '
				<script src="'.$assets_url.'/assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js" type="text/javascript"></script>
			';
			// input repeater
			$this->data['page_level_plugins'].= '
				<script src="'.$assets_url.'/assets/global/plugins/jquery-repeater/jquery.repeater.js" type="text/javascript"></script>
			';

		/****************
		 * page scripts inserted at <bottom>
		 */
		$this->data['page_level_scripts'] = '';

			// button spinners for ladda
			$this->data['page_level_scripts'].= '
				<script src="'.$assets_url.'/assets/pages/scripts/ui-buttons-spinners.min.js" type="text/javascript"></script>
			';
			// handle bootstrap select - make select class '.bs-select' a boostrap select picker
			$this->data['page_level_scripts'].= '
				<script src="'.$assets_url.'/assets/pages/scripts/components-bootstrap-select.min.js" type="text/javascript"></script>
			';
			// handle form validation, datepickers, and scripts
			$this->data['page_level_scripts'].= '
				<script src="'.base_url().'assets/custom/js/metronic/pages/scripts/form-validation-sales_orders_create.js" type="text/javascript"></script>
			';
	}

	// ----------------------------------------------------------------------

}
