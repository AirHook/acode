<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends Admin_Controller {

	public function __construct()
	{
		parent::__construct();
    }

	// ----------------------------------------------------------------------

	public function index()
	{
		// generate the plugin scripts and css
		$this->_create_plugin_scripts();

		// load pertinent library/model/helpers
		$this->load->library('users/wholesale_users_list');
		$this->load->library('orders/orders_list');

		// get the orders
		$this->orders_list->pagination = 1;
		$where_orders = array();
		$having_des_group = FALSE;
		if (@$this->webspace_details->options['site_type'] == 'sal_site')
		{
			$where_orders['tbl_order_log.webspace_id'] = @$this->webspace_details->id;
		}
		elseif ($this->webspace_details->options['site_type'] == 'sat_site')
		{
			$having_des_group = $this->webspace_details->name;
		}
		// 0-new,1-complete,2-onhold,3-canclled,4-returned/refunded,5-shipment_pending,6-store_credit,7-payment_pending
		$where_orders['status'] = '0';
		// removing tempoparis on list for shop7
		if ($this->webspace_details->slug !== 'tempoparis')
		{
			$where_orders['condition'] = '(tbl_order_log.webspace_id != "4" AND tbl_order_log.webspace_id != "67")';
		}
		$this->data['orders'] = $this->orders_list->select(
			$where_orders,
			array(), // order_by
			array('10'), // limit, offset ... limiting 10 in list for dashboard
			$having_des_group // $having_des_group
		);
		$this->data['count_all_orders'] = $this->orders_list->count_all;

		//echo $this->orders_list->last_query; die();

		// get users
		if (@$this->webspace_details->options['site_type'] != 'hub_site')
		{
			$where_users['tbluser_data_wholesale.reference_designer'] = @$this->webspace_details->slug;
		}
		$where_users['tbluser_data_wholesale.is_active'] = '1';
		$this->data['users'] = $this->wholesale_users_list->select(
			$where_users,
			array(),
			array(($this->data['count_all_orders'] ?: '5'))
		);
		$this->data['count_all_users'] = $this->wholesale_users_list->count_all;

		// set data variables...
		$this->data['role'] = 'admin';
		$this->data['file'] = 'dashboard';
		$this->data['page_title'] = 'Dashboard';
		$this->data['page_description'] = 'A summary of recent activities';

		// load views...
		$this->load->view($this->config->slash_item('admin_folder').($this->config->slash_item('admin_template') ?: 'metronic/').'template/template', $this->data);
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

		/****************
		 * page style sheets inserted at <head>
		 */
		$this->data['page_level_styles'] = '';


		/****************
		 * page js plugins inserted at <bottom>
		 * after core plugins, before global scripts
		 */
		$this->data['page_level_plugins'] = '';

			// dashboard counter up boxes
			$this->data['page_level_plugins'].= '
				<script src="'.$assets_url.'/assets/global/plugins/counterup/jquery.waypoints.min.js" type="text/javascript"></script>
		        <script src="'.$assets_url.'/assets/global/plugins/counterup/jquery.counterup.min.js" type="text/javascript"></script>
			';

		/****************
		 * page scripts inserted at <bottom>
		 * after global scripts, before theme layout scripts
		 */
		$this->data['page_level_scripts'] = '';

			// handle dashboard
			$this->data['page_level_scripts'].= '
				<script src="'.$assets_url.'/assets/pages/scripts/dashboard.min.js" type="text/javascript"></script>
			';
	}
	// ----------------------------------------------------------------------
}
