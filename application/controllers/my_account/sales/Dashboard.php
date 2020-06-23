<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends Sales_user_Controller {

	/**
	 * Constructor
	 *
	 * @return	void
	 */
	public function __construct()
	{
		parent::__construct();
    }

	// ----------------------------Redirect to Salesuser Orders Page------------------------------------------

	public function index()
	{
		// generate the plugin scripts and css
		$this->_create_plugin_scripts();

		// adding these line to identify controlls for sales users
		$des_slug = $this->sales_user_details->designer;
		$designer_name = $this->sales_user_details->designer_name;
		$list = 'ws'; // --> sales users is always working for their wholesale users

		// load pertinent library/model/helpers
		$this->load->library('users/wholesale_users_list');
		$this->load->library('orders/orders_list');

		// get the orders
		// 0-new,1-complete,2-onhold,3-canclled,4-returned/refunded,5-shipment_pending,6-store_credit
		$where_orders['status'] = '0';
		$where_orders['tbl_order_log.c'] = 'ws';
		$where_orders['tbluser_data_wholesale.admin_sales_email'] = $this->sales_user_details->email;
		$this->data['orders'] = $this->orders_list->select(
			$where_orders,
			array(), // order_by
			array('10'), // limit, offset
			$designer_name // $having_des_group
		);
		$this->data['count_all_orders'] = $this->orders_list->count_all;

		// get users
		$where_users['tbluser_data_wholesale.reference_designer'] = $des_slug;
		$where_users['tbluser_data_wholesale.is_active'] = '1';
		$where_users['tbluser_data_wholesale.admin_sales_email'] = $this->sales_user_details->email;
		$this->data['users'] = $this->wholesale_users_list->select(
			$where_users,
			array(),
			array('5')
		);
		$this->data['count_all_users'] = $this->wholesale_users_list->count_all;

		// breadcrumbs
		// dashboard serves as home page so no need to set breadcrumbs
		$this->data['page_breadcrumb'] = array();

		// set data variables...
		$this->data['role'] = 'sales'; //userrole will be used for IF statements in template files
		$this->data['file'] = 'sales_dashboard'; // sales orders
		$this->data['page_title'] = 'Dashboard';
		$this->data['page_description'] = 'Sales User Dashboard';

		// load views...
		$this->load->view('admin/metronic/template_my_account/template', $this->data);
	}

	// ----------------------------------------------------------------------

	/**
	 * PRIVATE - Create Plugin Scripts and CSS for the page
	 *
	 * @return	void
	 */
	private function _create_plugin_scripts()
	{
		$assets_url = base_url('/assets/metronic');
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
			// datatable
			$this->data['page_level_styles_plugins'].= '
				<link href="'.$assets_url.'/assets/global/plugins/datatables/datatables.min.css" rel="stylesheet" type="text/css" />
				<link href="'.$assets_url.'/assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css" rel="stylesheet" type="text/css" />
			';

		/****************
		 * page style sheets inserted at <head>
		 */
		$this->data['page_level_styles'] = '
		';

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
				<script src="'.$assets_url.'/assets/global/plugins/select2/js/select2.full.min.js" type="text/javascript"></script>
				<script src="'.$assets_url.'/assets/global/plugins/bootstrap-select/js/bootstrap-select.min.js" type="text/javascript"></script>
			';
			// datatable
			$this->data['page_level_plugins'].= '
				<script src="'.$assets_url.'/assets/global/scripts/datatable.js" type="text/javascript"></script>
				<script src="'.$assets_url.'/assets/global/plugins/datatables/datatables.min.js" type="text/javascript"></script>
				<script src="'.$assets_url.'/assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js" type="text/javascript"></script>
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
			// handle datatable
			$this->data['page_level_scripts'].= '
				<script src="'.base_url().'assets/custom/js/metronic/pages/scripts/table-datatables-purchase_orders.js" type="text/javascript"></script>
			';
	}

	// ----------------------------------------------------------------------
}
