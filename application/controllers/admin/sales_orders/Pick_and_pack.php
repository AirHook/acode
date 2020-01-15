<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pick_and_pack extends Admin_Controller {

	/**
	 * Constructor
	 *
	 * @return	void
	 */
	public function __construct()
	{
		parent::__construct();
    }

	// ----------------------------------------------------------------------

	/**
	 * Index - default method
	 *
	 * Primary method to call when no other methods are found in url segment
	 * This method simply shows order details
	 *
	 * @return	void
	 */
	public function index($id = '')
	{
		if ( ! $id)
		{
			// nothing more to do...
			// set flash data
			$this->session->set_flashdata('error', 'no_id_passed');

			// redirect user
			redirect($this->config->slash_item('admin_folder').'sales_orders');
		}

		// generate the plugin scripts and css
		$this->_create_plugin_scripts();

		// let's ensure that there are no admin session for so create
		if ($this->session->admin_so_items)
		{
			// new po mod details
			unset($_SESSION['admin_so_mod_so_id']);
			unset($_SESSION['admin_so_mod_items']);
			// remove so admin so create
			unset($_SESSION['admin_so_user_id']); // store or consumer and 0 for manual input
			unset($_SESSION['admin_so_user_cat']); // ws, cs
			unset($_SESSION['admin_so_slug_segs']);
			unset($_SESSION['admin_so_dely_date']);
			unset($_SESSION['admin_so_items']);
		}

		// load pertinent library/model/helpers
		$this->load->library('products/size_names');
		$this->load->library('sales_orders/sales_order_details');
		$this->load->library('users/vendor_user_details');
		$this->load->library('users/wholesale_user_details');
		$this->load->library('users/consumer_user_details');
		$this->load->library('users/sales_user_details');
		$this->load->library('products/product_details');
		$this->load->library('barcodes/upc_barcodes');

		// initialize... and get so details
		$this->data['so_details'] = $this->sales_order_details->initialize(
			array(
				'sales_orders.sales_order_id' => $id
			)
		);

		// set session for mod
		$this->session->set_userdata('admin_so_mod_so_id', $id);
		$this->session->set_userdata(
			'admin_so_mod_items',
			json_encode($this->sales_order_details->items)
		);

		// get the author
		switch ($this->sales_order_details->c)
		{
			case '2': //sales
				$this->data['author'] = $this->sales_user_details->initialize(
					array(
						'admin_sales_id' => $this->sales_order_details->author
					)
				);
			break;
			case '1': //admin
			default:
				$this->data['author'] = $this->admin_user_details->initialize(
					array(
						'admin_id' => ($this->sales_order_details->author ?: '1')
					)
				);
		}

		// get store details
		// check for user cat to fill out bill to/ship to address
		if ($this->sales_order_details->user_cat)
		{
			if ($this->sales_order_details->user_cat == 'ws')
			{
				$this->data['store_details'] = $this->wholesale_user_details->initialize(
					array(
						'user_id' => $this->sales_order_details->user_id
					)
				);
			}

			if ($this->sales_order_details->user_cat == 'cs')
			{
				$this->data['store_details'] = $this->consumer_user_details->initialize(
					array(
						'user_id' => $this->sales_order_details->user_id
					)
				);
			}
		}

		// we need to get designer details general size mode for those
		// items added that is not on product list
		$this->data['designer_details'] = $this->designer_details->initialize(
			array(
				'des_id' => $this->sales_order_details->des_id
			)
		);

		// set THE items
		$this->data['so_items'] = $this->sales_order_details->items;
		$this->data['so_date'] = $this->sales_order_details->so_date;
		$this->data['so_number'] = $this->sales_order_details->so_number;
		$this->data['so_options'] = $this->sales_order_details->options;
		for($c = strlen($this->data['so_number']);$c < 6;$c++)
		{
			$this->data['so_number'] = '0'.$this->data['so_number'];
		}

		// set data variables...
		$this->data['file'] = 'so_pick_and_pack'; // sales_orders_details
		$this->data['page_title'] = 'Sales Order Details Pick and Pack';
		$this->data['page_description'] = 'Pick and Pack items for the Sales Orer to finally ship to customer';

		// load views...
		$this->load->view($this->config->slash_item('admin_folder').($this->config->slash_item('admin_template') ?: 'metronic/').'template/template', $this->data);
	}

	// ----------------------------------------------------------------------

	/**
	 * PRIVATE - Create Plugin Scripts and CSS for the page
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
			// handle page scripts
			$this->data['page_level_scripts'].= '
				<script src="'.base_url().'assets/custom/js/metronic/pages/scripts/admin-so_pick_and_pack-components.js" type="text/javascript"></script>
			';
	}

	// ----------------------------------------------------------------------

}
