<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Details extends Admin_Controller {

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

		// load pertinent library/model/helpers
		$this->load->library('products/size_names');
		$this->load->library('sales_orders/sales_order_details');
		$this->load->library('designers/designer_details');
		$this->load->library('users/vendor_user_details');
		$this->load->library('users/wholesale_user_details');
		$this->load->library('users/sales_user_details');
		$this->load->library('products/product_details');
		$this->load->library('barcodes/upc_barcodes');
		$this->load->library('zend');
		$this->zend->load('Zend/Barcode');

		// initialize...
		$this->data['so_details'] = $this->sales_order_details->initialize(
			array(
				'sales_orders.sales_order_id' => $id
			)
		);

		// get the author
		$this->data['author'] = $this->sales_user_details->initialize(
			array(
				'admin_sales_id' => $this->sales_order_details->author
			)
		);

		// get designer details
		$this->data['designer_details'] = $this->designer_details->initialize(
			array(
				'designer.des_id' => $this->sales_order_details->des_id
			)
		);

		// get vendor details
		// vendor id is always present at this time given create step1
		$this->data['vendor_details'] = $this->vendor_user_details->initialize(
			array(
				'vendor_id' => $this->sales_order_details->vendor_id
			)
		);

		// get store details
		$this->data['store_details'] = $this->wholesale_user_details->initialize(
			array(
				'user_id' => $this->sales_order_details->user_id
			)
		);

		// get designer id and size names
		$this->data['des_id'] = $this->sales_order_details->des_id;
		$this->data['size_names'] = $this->size_names->get_size_names($this->designer_details->webspace_options['size_mode']);

		// set the items
		$this->data['so_items'] = $this->sales_order_details->items;
		$this->data['so_date'] = $this->sales_order_details->so_date;
		$this->data['so_number'] = $this->sales_order_details->so_number;
		for($c = strlen($this->data['so_number']);$c < 6;$c++)
		{
			$this->data['so_number'] = '0'.$this->data['so_number'];
		}
		$this->data['so_options'] = $this->sales_order_details->options;

		// set company information
		$this->data['company_name'] = $this->designer_details->company_name;
		$this->data['company_address1'] = $this->designer_details->address1;
		$this->data['company_address2'] = $this->designer_details->address2;
		$this->data['company_city'] = $this->designer_details->city;
		$this->data['company_state'] = $this->designer_details->state;
		$this->data['company_zipcode'] = $this->designer_details->zipcode;
		$this->data['company_country'] = $this->designer_details->country;
		$this->data['company_telephone'] = $this->designer_details->phone;
		$this->data['company_contact_person'] = $this->designer_details->owner;
		$this->data['company_contact_email'] = $this->designer_details->info_email;

		// set data variables...
		$this->data['file'] = 'so_details_v2'; // sales_orders_details
		$this->data['page_title'] = 'Sales Order Details';
		$this->data['page_description'] = 'Details of the sales order from sales for wholesale user';

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
				<script src="'.base_url().'assets/custom/js/metronic/pages/scripts/components-sales_order_details.js" type="text/javascript"></script>
			';
	}

	// ----------------------------------------------------------------------

}
