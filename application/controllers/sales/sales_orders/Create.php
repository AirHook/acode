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
		//$this->load->library('form_validation');
		//$this->load->library('users/sales_users_list');
		$this->load->library('designers/designers_list');
		$this->load->library('users/wholesale_users_list');
		$this->load->library('users/wholesale_user_details');
		//$this->load->library('users/vendor_users_list');
		//$this->load->library('color_list');
		//$this->load->library('sales_orders/sales_orders_list');
		//$this->load->library('users/sales_user_details');
		$this->load->library('designers/designer_details');
		$this->load->library('categories/categories_tree');
		$this->load->library('categories/sidebar_categories');
		$this->load->library('products/product_details');
		$this->load->library('products/size_names');

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
		$this->data['items_count'] = $so_items_count;
		/* */
		$this->data['so_size_qty'] =
			$this->session->so_size_qty
			? json_decode($this->session->so_size_qty, TRUE)
			: array()
		;
		// */

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
			unset($_SESSION['so_store_id']);
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
	 * STEP 3 - Refine order
	 *
	 * @return	void
	 */
	public function step2()
	{
		// generate the plugin scripts and css
		$this->_create_plugin_scripts();

		// load pertinent library/model/helpers
		$this->load->helper('state_country_helper');
		$this->load->library('form_validation');
		$this->load->library('users/wholesale_users_list');
		$this->load->library('sales_orders/sales_orders_list');

		// set validation rules
		$this->form_validation->set_rules('delivery_date', 'Deliver Data', 'trim|required');

		if ($this->form_validation->run() == FALSE)
		{
			// get user list for the edit ship to function
			$params = array(
				'tbluser_data_wholesale.admin_sales_email' => $this->sales_user_details->email
			);
			$this->data['users'] = $this->wholesale_users_list->select($params);

			// get store details if any
			if ($this->session->so_store_id)
			{
				$this->data['store_details'] = $this->wholesale_user_details->initialize(
					array(
						'user_id' => $this->session->so_store_id
					)
				);
			}
			else $this->data['store_details'] = $this->wholesale_user_details->deinitialize();

			// get designer id
			$this->designer_details->initialize(array('designer.url_structure'=>$this->sales_user_details->designer));
			$this->data['des_id'] = $this->designer_details->des_id;

			// set po number
			$this->data['so_number'] = $this->sales_orders_list->max_sales_order_number() + 1;

			// get size names
			$this->data['size_names'] = $this->size_names->get_size_names($this->designer_details->webspace_options['size_mode']);

			// some necessary variables
			$this->data['steps'] = 2;

			// need to show loading at start
			$this->data['show_loading'] = FALSE;

			// set data variables...
			$this->data['file'] = 'so_create_steps'; //'purchase_orders';
			$this->data['page_title'] = 'Purchase Order';
			$this->data['page_description'] = 'Create Purchase Order';

			$this->load->view($this->data['sales_theme'].'/sales/template/template', $this->data);
		}
		else
		{

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
				<link href="'.$assets_url.'/assets/global/plugins/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
				<link href="'.$assets_url.'/assets/global/plugins/select2/css/select2-bootstrap.min.css" rel="stylesheet" type="text/css" />
				<link href="'.$assets_url.'/assets/global/plugins/bootstrap-select/css/bootstrap-select.min.css" rel="stylesheet" type="text/css" />
			';
			// fancybox
			$this->data['page_level_styles_plugins'].= '
				<link href="'.$assets_url.'/assets/global/plugins/fancybox/source/jquery.fancybox.css" rel="stylesheet" type="text/css" media="screen" />
			';
			// summernote wysiwyg
			$this->data['page_level_styles_plugins'].= '
				<link href="'.$assets_url.'/assets/global/plugins/bootstrap-summernote/summernote.css" rel="stylesheet" type="text/css" />
			';
			// multi-select
			$this->data['page_level_styles_plugins'].= '
				<link href="'.$assets_url.'/assets/global/plugins/jquery-multi-select/css/multi-select.css" rel="stylesheet" type="text/css" />
			';
			// datepicker
			$this->data['page_level_styles_plugins'].= '
				<link href="'.$assets_url.'/assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css" rel="stylesheet" type="text/css" />
			';

		/****************
		 * page style sheets inserted at <head>
		 */
		$this->data['page_level_styles'] = '';

			// this is a work around so that the inline jquery ajax request to add and remove items from the sales package to work
			$this->data['page_level_styles'].= '
				<script src="'.$assets_url.'/assets/global/plugins/jquery.min.js" type="text/javascript"></script>
			';

		/****************
		 * page js plugins inserted at <bottom>
		 * after core plugins, before global scripts
		 */
		$this->data['page_level_plugins'] = '';

			// unveil - simple image lazy loading
			$this->data['page_level_plugins'].= '
				<script src="'.base_url().'assets/custom/js/jquery.unveil.js" type="text/javascript"></script>
			';
			// ladda - show loading or progress bar on buttons
			$this->data['page_level_plugins'].= '
				<script src="'.$assets_url.'/assets/global/plugins/ladda/spin.min.js" type="text/javascript"></script>
				<script src="'.$assets_url.'/assets/global/plugins/ladda/ladda.min.js" type="text/javascript"></script>
			';
			// bootstrap select
			$this->data['page_level_plugins'].= '
				<script src="'.$assets_url.'/assets/global/plugins/select2/js/select2.full.min.js" type="text/javascript"></script>
				<script src="'.$assets_url.'/assets/global/plugins/bootstrap-select/js/bootstrap-select.min.js" type="text/javascript"></script>
			';
			// fancybox
			$this->data['page_level_plugins'].= '
				<script src="'.$assets_url.'/assets/global/plugins/fancybox/source/jquery.fancybox.pack.js" type="text/javascript"></script>
			';
			// summernote wysiwyg
			$this->data['page_level_plugins'].= '
				<script src="'.$assets_url.'/assets/global/plugins/bootstrap-summernote/summernote.min.js" type="text/javascript"></script>
			';
			// form wizard - jquery validate is needed for the wizard to function
			$this->data['page_level_plugins'].= '
				<script src="'.$assets_url.'/assets/global/plugins/jquery-validation/js/jquery.validate.min.js" type="text/javascript"></script>
				<script src="'.$assets_url.'/assets/global/plugins/bootstrap-wizard/jquery.bootstrap.wizard.min.js" type="text/javascript"></script>
			';
			// multi-select
			$this->data['page_level_plugins'].= '
				<script src="'.$assets_url.'/assets/global/plugins/jquery-multi-select/js/jquery.multi-select.js" type="text/javascript"></script>
			';
			// datetimepicker
			$this->data['page_level_plugins'].= '
				<script src="'.$assets_url.'/assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js" type="text/javascript"></script>
			';

		/****************
		 * page scripts inserted at <bottom>
		 * after global scripts, before theme layout scripts
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
			// jspdf
			$this->data['page_level_scripts'].= '
				<script src="'.base_url().'assets/custom/js/jspdf.min.js" type="text/javascript"></script>
			';
			// html2canvas
			$this->data['page_level_scripts'].= '
				<script src="'.base_url().'assets/custom/js/html2canvas/html2canvas.min.js" type="text/javascript"></script>
			';
			// handle summernote wysiwyg
			// and click scripts
			$this->data['page_level_scripts'].= '
				<script src="'.base_url().'assets/custom/js/metronic/pages/scripts/components-sales-sales_orders_create.js" type="text/javascript"></script>
			';
	}

	// ----------------------------------------------------------------------

}
