<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Details extends Vendor_Controller {

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
	 * Purchase Order Details
	 *
	 * @return	void
	 */
	public function index($po_id = '')
	{
		if ( ! $po_id)
		{
			// nothing more to do...
			// set flash data
			$this->session->set_flashdata('error', 'no_id_passed');

			// redirect user
			redirect('my_account/vendors/orders');
		}

		// generate the plugin scripts and css
		$this->_create_plugin_scripts();

		// load pertinent library/model/helpers
		$this->load->library('designers/designer_details');
		$this->load->library('products/size_names');
		$this->load->library('products/product_details');
		$this->load->library('purchase_orders/purchase_order_details');
		$this->load->library('users/wholesale_user_details');
		$this->load->library('users/sales_user_details');
		$this->load->library('users/vendor_user_details');
		$this->load->library('barcodes/upc_barcodes');

		// initialize purchase order properties and items
		$this->data['po_details'] = $this->purchase_order_details->initialize(
			array(
				'po_id' => $po_id
			)
		);

		// fail safe check that the po selected is for the same vendor loggedin
		if ($this->purchase_order_details->vendor_id !== $this->session->vendor_id)
		{
			// nothing more to do...
			// set flash data
			$this->session->set_flashdata('error', 'no_id_passed');

			// redirect user
			redirect('my_account/vendors/orders');
		}

		// get po items and other array stuff
		$this->data['po_number'] = $this->purchase_order_details->po_number;
		$this->data['po_items'] = $this->purchase_order_details->items;
		$this->data['po_options'] = $this->purchase_order_details->options;

		// get vendor details
		$this->data['vendor_details'] = $this->vendor_user_details->initialize(
			array(
				'vendor_id' => $this->purchase_order_details->vendor_id
			)
		);

		// get ship to details
		if (isset($this->data['po_options']['po_store_id']))
		{
			$this->data['store_details'] = $this->wholesale_user_details->initialize(
				array(
					'user_id' => $this->data['po_options']['po_store_id']
				)
			);
		}
		else $this->data['store_details'] = $this->wholesale_user_details->deinitialize();

		// get PO author
		switch ($this->purchase_order_details->c)
		{
			case '2': //sales
				$this->data['author'] = $this->sales_user_details->initialize(
					array(
						'admin_sales_id' => $this->purchase_order_details->author
					)
				);
			break;
			case '1': //admin
			default:
				$this->data['author'] = $this->admin_user_details->initialize(
					array(
						'admin_id' => ($this->purchase_order_details->author ?: '1')
					)
				);
		}

		// get size names using des_id as reference
		$this->designer_details->initialize(array('designer.des_id'=>$this->purchase_order_details->des_id));

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

		// need to show loading at start
		$this->data['show_loading'] = FALSE;

		// set data variables...
		$this->data['file'] = 'po_details'; // purchase_orders_details
		$this->data['page_title'] = 'Purchase Order Details';
		$this->data['page_description'] = 'Details of the purchase order to vendor';

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
			// bootbox
			$this->data['page_level_plugins'].= '
				<script src="'.$assets_url.'/assets/global/plugins/bootbox/bootbox.min.js" type="text/javascript"></script>
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
				<script src="'.base_url().'assets/custom/js/metronic/pages/scripts/components-purchase_order_details.js" type="text/javascript"></script>
			';
	}

	// ----------------------------------------------------------------------

}
