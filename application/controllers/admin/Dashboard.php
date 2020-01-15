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
		// set data variables...
		$this->load->library('purchase_orders/purchase_orders_list');
		$this->load->library('sales_orders/sales_orders_list');

		//$this->data['purchase_orders'] = $this->purchase_orders_list->select(array(), '10');
		//$this->data['sale_orders'] = $this->sales_orders_list->select(array(), '10');
		//$this->data['sale_orders_length'] = $this->sales_orders_list->select();
		//$this->data['purchase_orders_length'] = $this->purchase_orders_list->select();
		// echo '<pre>',print_r($this->data['orders']),'</pre>';exit();

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
