<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Create extends Sales_Controller {

	/**
	 * SO stock ordering status whether instock or preorder
	 * Ordering is separate
	 * 		0 - start (default)
	 *		1 - instock
	 *		2 - preorder
	 *
	 * @return	void
	 */
	public $so_stocstat = 0;


	/**
	 * Constructor
	 *
	 * @return	void
	 */
	public function __construct()
	{
		parent::__construct();

		// load pertinent library/model/helpers
		$this->load->library('form_validation');
		$this->load->library('users/sales_users_list');
		$this->load->library('designers/designers_list');
		$this->load->library('users/wholesale_users_list');
		$this->load->library('users/vendor_users_list');
		$this->load->library('color_list');
		$this->load->library('sales_orders/sales_orders_list');
		$this->load->library('users/sales_user_details');
		$this->load->library('designers/designer_details');
		$this->load->library('categories/categories_tree');
		$this->load->library('categories/sidebar_categories');
		$this->load->library('products/size_names');

		// let's remove the segments (up to controller class method/function)
		// for category sidebar links to work
		$this->data['url_segs'] = explode('/', $this->uri->uri_string());
		array_shift($this->data['url_segs']); // admin/sales
		array_shift($this->data['url_segs']); // sales_orders
		array_shift($this->data['url_segs']); // create
		array_shift($this->data['url_segs']); // step

		/*****
		 * Check for items in session
		 */
		// check for po items
		$this->data['so_items'] =
			$this->session->so_items
			? json_decode($this->session->so_items, TRUE)
			: array()
		;
		$so_items_count = 0;
		foreach ($this->data['so_items'] as $key => $val)
		{
			if (is_array($val))
			{
				$so_items_count += array_sum($val);
			}
			else $so_items_count += 1;
		}
		$this->data['so_items_count'] = $so_items_count;
		$this->data['so_size_qty'] =
			$this->session->so_size_qty
			? json_decode($this->session->so_size_qty, TRUE)
			: array()
		;

		// instock/preorder ordering session switch
		$this->so_stocstat = $this->session->so_stocstat ?: '0';

		// connect to database
		$this->DB = $this->load->database('instyle', TRUE);
    }

	// ----------------------------------------------------------------------

	/**
	 * Index - Primary function
	 *
	 * @return	void
	 */
	public function index()
	{
		// redirect user to use url segs
		redirect('sales/sales_orders/create/step1', 'location');
	}

	// ----------------------------------------------------------------------

	/**
	 * Step 1 - select items
	 *
	 * @return	void
	 */
	public function step1()
	{
		// generate the plugin scripts and css
		$this->_create_plugin_scripts();

		// let's ensure that there are no sessions for so mod
		if ($this->session->so_mod)
		{
			// new so sales access
			unset($_SESSION['so_items']);
			unset($_SESSION['so_size_qty']);
			unset($_SESSION['so_stocstat']);
			// remove so mod details
			unset($_SESSION['so_mod']);
		}

		// last segment as category slug
		$this->data['active_category'] =
			$this->uri->segment(3) == 'create'
			? ((count($this->data['url_segs']) - 1) >= 0 ? $this->data['url_segs'][count($this->data['url_segs']) - 1] : 'womens_apparel')
			: 'womens_apparel'
		;

		// get respective active category ID for use on product list where condition
		$category_id = $this->categories_tree->get_id($this->data['active_category']);

		// let's do some defaults...
		// sales user have one designer only
		// get the designer details for the sidebar
		$this->data['designer'] = $this->designer_details->initialize(array('url_structure'=>$this->sales_user_details->designer));
		$this->data['size_names'] = $this->size_names->get_size_names($this->designer_details->webspace_options['size_mode']);

 		// active designer selection
 		$this->data['active_designer'] = $this->designer_details->url_structure;

		// set array for where condition of get product list
		if ($this->data['active_designer'])
		{
			$where = array(
				'designer.url_structure' => $this->sales_user_details->designer,
				'tbl_product.categories LIKE' => '%'.$category_id.'%'
			);
		}
		else
		{
			$where = array(
				'tbl_product.categories LIKE' => '%'.$category_id.'%'
			);
		}

		// get the products list
		$params['show_private'] = TRUE; // all items general public (Y) - N for private
		$params['view_status'] = 'ALL'; // ALL items view status (Y, Y1, Y2, N)
		$params['variant_publish'] = 'ALL'; // ALL variant level color publish (view status)
		$params['group_products'] = FALSE; // group per product number or per variant
		// show items even without stocks at all
		$params['with_stocks'] = FALSE;
		$this->load->library('products/products_list', $params);
		$this->data['products'] = $this->products_list->select(
			$where,
			array( // order conditions
				'seque' => 'desc',
				'tbl_product.prod_no' => 'desc'
			)
		);
		$this->data['products_count'] = $this->products_list->row_count;

		// some necessary variables and data
		$this->data['steps'] = 1;

		// need to show loading at start
		$this->data['show_loading'] = TRUE;
		$this->data['search_string'] = FALSE;

		// set data variables...
		$this->data['file'] = 'so_create_steps'; //'purchase_orders';
		$this->data['page_title'] = 'Sales Order Create';
		$this->data['page_description'] = 'Create Sales Orders';

		// load views...
		$this->load->view($this->data['sales_theme'].'/sales/template/template', $this->data);
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
			// form wizard - jquery validate is needed for the wizard to function
			$this->data['page_level_plugins'].= '
				<script src="'.$assets_url.'/assets/global/plugins/jquery-validation/js/jquery.validate.min.js" type="text/javascript"></script>
				<script src="'.$assets_url.'/assets/global/plugins/bootstrap-wizard/jquery.bootstrap.wizard.min.js" type="text/javascript"></script>
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
			// handle form wizard
			$this->data['page_level_scripts'].= '
				<script src="'.$assets_url.'/assets/pages/scripts/form-wizard.min.js" type="text/javascript"></script>
			';
			// handle form validation, datepickers, and scripts
			$this->data['page_level_scripts'].= '
				<script src="'.base_url().'assets/custom/js/metronic/pages/scripts/components-sales-sales_orders_create.js" type="text/javascript"></script>
			';
	}

	// ----------------------------------------------------------------------

}
