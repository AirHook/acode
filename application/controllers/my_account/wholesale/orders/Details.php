<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Details extends Wholesale_user_Controller {

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
	public function index($order_id = '')
	{
		if ( ! $order_id)
		{
			// nothing more to do...
			// set flash data
			$this->session->set_flashdata('error', 'no_id_passed');

			// redirect user
			redirect('my_account/wholesale/orders');
		}

		// generate the plugin scripts and css
		$this->_create_plugin_scripts();

		// load pertinent library/model/helpers
		$this->load->library('designers/designer_details');
		$this->load->library('products/size_names');
		$this->load->library('products/product_details');
		$this->load->library('orders/order_details');
		$this->load->library('users/wholesale_user_details');
		$this->load->library('users/sales_user_details');
		$this->load->library('barcodes/upc_barcodes');

		// get order details
		$this->data['order_details'] =
			$this->order_details->initialize(
				array(
					'tbl_order_log.order_log_id' => $order_id
				)
			)
		;

		// billto shipto address
		$this->data['store_name'] = $this->wholesale_user_details->store_name;
		$this->data['firstname'] = $this->wholesale_user_details->firstname;
		$this->data['lastname'] = $this->wholesale_user_details->lastname;
		$this->data['address1'] = $this->wholesale_user_details->address1;
		$this->data['address2'] = $this->wholesale_user_details->address2;
		$this->data['city'] = $this->wholesale_user_details->city;
		$this->data['state'] = $this->wholesale_user_details->state;
		$this->data['country'] = $this->wholesale_user_details->country;
		$this->data['zipcode'] = $this->wholesale_user_details->zipcode;
		$this->data['telephone'] = $this->wholesale_user_details->telephone;
		$this->data['email'] = $this->wholesale_user_details->email;
		$this->data['sh_store_name'] = $this->order_details->store_name ?: $this->wholesale_user_details->store_name;
		$this->data['sh_firstname'] = $this->order_details->firstname ?: $this->wholesale_user_details->firstname;
		$this->data['sh_lastname'] = $this->order_details->lastname ?: $this->wholesale_user_details->lastname;
		$this->data['sh_address1'] = $this->order_details->ship_address1 ?: $this->wholesale_user_details->address1;
		$this->data['sh_address2'] = $this->order_details->ship_address2 ?: $this->wholesale_user_details->address2;
		$this->data['sh_city'] = $this->order_details->ship_city ?: $this->wholesale_user_details->city;
		$this->data['sh_state'] = $this->order_details->ship_state ?: $this->wholesale_user_details->state;
		$this->data['sh_country'] = $this->order_details->ship_country ?: $this->wholesale_user_details->country;
		$this->data['sh_zipcode'] = $this->order_details->ship_zipcode ?: $this->wholesale_user_details->zipcode;
		$this->data['sh_telephone'] = $this->order_details->telephone ?: $this->wholesale_user_details->telephone;
		$this->data['sh_email'] = $this->order_details->email ?: $this->wholesale_user_details->email;

		// other data
		$this->data['status'] = $this->order_details->status_text;
		$this->data['name'] =
			(
				@$this->wholesale_user_details->store_name
				?: $this->wholesale_user_details->firstname.' '.$this->wholesale_user_details->lastname
			).' (#'.$this->data['order_details']->user_id.')'
		;

		// need to show loading at start
		$this->data['show_loading'] = FALSE;

		// set data variables...
		$this->data['role'] = 'wholesale'; //userrole will be used for IF statements in template files
		$this->data['file'] = '../my_account/order_details';
		$this->data['page_title'] = 'Order Details';
		$this->data['page_description'] = 'Details of the order transaction';

		// load views...
		$this->load->view('metronic/template/template', $this->data);
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
