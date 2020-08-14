<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Modify extends Sales_user_Controller {

	/**
	 * DB Object
	 *
	 * @var	object
	 */
	protected $DB;

	/**
	 * Constructor
	 *
	 * @return	void
	 */
	public function __construct()
	{
		parent::__construct();

		// connect to database
		$this->DB = $this->load->database('instyle', TRUE);

		// load pertinent library/model/helpers
		$this->load->model('shipping_methods');
		$this->load->helper('state_country_helper');
		$this->load->library('users/wholesale_user_details');
		$this->load->library('users/consumer_user_details');
		$this->load->library('products/product_details');
		$this->load->library('orders/order_details');
		$this->load->library('products/size_names');
		$this->load->library('barcodes/upc_barcodes');
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
	public function index($order_id = '')
	{
		if ( ! $order_id)
		{
			// nothing more to do...
			// set flash data
			$this->session->set_flashdata('error', 'no_id_passed');

			// redirect user
			redirect('my_account/sales/orders', 'location');
		}

		// generate the plugin scripts and css
		$this->_create_plugin_scripts();

		// get order details
		$this->data['order_details'] =
			$this->order_details->initialize(
				array(
					'tbl_order_log.order_log_id'=>$order_id
				)
			)
		;

		// based on order details, get user details
		if ($this->data['order_details']->c == 'ws')
		{
			$this->data['user_details'] =
				$this->wholesale_user_details->initialize(
					array(
						'user_id' => $this->data['order_details']->user_id
					)
				)
			;
		}
		else
		{
			$this->data['user_details'] =
				$this->consumer_user_details->initialize(
					array(
						'user_id' => $this->data['order_details']->user_id
					)
				)
			;
		}

		// other data
		$this->data['status'] = $this->order_details->status_text;

		// need to show loading at start
		$this->data['show_loading'] = FALSE;
		$this->data['search'] = FALSE;

		// breadcrumbs
		$this->data['page_breadcrumb'] = array(
			'orders/details' => 'Orders',
			'details' => 'Modify'
		);

		// set data variables...
		$this->data['role'] = 'sales';
		$this->data['file'] = 'orders_modify';
		$this->data['page_title'] = 'Modify Order';
		$this->data['page_description'] = 'Edit order details';

		// load views...
		$this->load->view('my_account/sales/metronic/template/template', $this->data);
	}

	// ----------------------------------------------------------------------

	/**
	 * PUBLIC - Edit Store Details / Wholesale User Details
	 *
	 * @return	void
	 */
	public function edit_store_details($order_id = '')
	{
		if ( ! $order_id)
		{
			// nothing more to do...
			// set flash data
			$this->session->set_flashdata('error', 'no_id_passed');

			// redirect user
			redirect('my_account/sales/orders/modify/index/'.$order_id, 'location');
		}

		// grab input post
		$post_ary = array_filter($this->input->post(), 'strlen');

		// unset items
		unset($post_ary['user_id']);

		// update records
		$this->DB->set($post_ary);
		$this->DB->where('user_id', $this->input->post('user_id'));
		$this->DB->update('tbluser_data_wholesale');

		// return to modify order page
		redirect('my_account/sales/orders/modify/index/'.$order_id, 'location');
	}

	// ----------------------------------------------------------------------

	/**
	 * PUBLIC - Edit Order Ship To Address
	 *
	 * @return	void
	 */
	public function edit_ship_to($order_id = '')
	{
		if ( ! $order_id)
		{
			// nothing more to do...
			// set flash data
			$this->session->set_flashdata('error', 'no_id_passed');

			// redirect user
			redirect('my_account/sales/orders/modify/index/'.$order_id, 'location');
		}

		// grab input post
		$post_ary = array_filter($this->input->post(), 'strlen');

		// update records
		$this->DB->set($post_ary);
		$this->DB->where('order_log_id', $order_id);
		$this->DB->update('tbl_order_log');

		// return to modify order page
		redirect('my_account/sales/orders/modify/index/'.$order_id, 'location');
	}

	// ----------------------------------------------------------------------

	/**
	 * PUBLIC - Edit User Details for Consumers
	 *
	 * @return	void
	 */
	public function edit_user_details($order_id = '')
	{
		if ( ! $order_id)
		{
			// nothing more to do...
			// set flash data
			$this->session->set_flashdata('error', 'no_id_passed');

			// redirect user
			redirect('amy_account/salesdmin/orders/modify/index/'.$order_id, 'location');
		}

		// grab input post
		$post_ary = array_filter($this->input->post(), 'strlen');

		// unset items
		unset($post_ary['user_id']);

		// update records
		$this->DB->set($post_ary);
		$this->DB->where('user_id', $this->input->post('user_id'));
		$this->DB->update('tbluser_data');

		// return to modify order page
		redirect('my_account/sales/orders/modify/index/'.$order_id, 'location');
	}

	// ----------------------------------------------------------------------

	/**
	 * PUBLIC - Remove an item from the order
	 *
	 * @return	void
	 */
	public function remove_item($order_id = '')
	{
		if ( ! $order_id)
		{
			// nothing more to do...
			// set flash data
			$this->session->set_flashdata('error', 'no_id_passed');

			// redirect user
			redirect('my_account/sales/orders/modify/index/'.$order_id, 'location');
		}

		// update records
		$this->DB->where('order_log_detail_id', $this->input->post('order_log_detail_id'));
		$this->DB->delete('tbl_order_log_details');

		// return to modify order page
		redirect('my_account/sales/orders/modify/index/'.$order_id, 'location');
	}

	// ----------------------------------------------------------------------

	/**
	 * PUBLIC - Remove an item from the order
	 *
	 * @return	void
	 */
	public function edit_item_qty($order_id = '')
	{
		if ( ! $order_id)
		{
			// nothing more to do...
			// set flash data
			$this->session->set_flashdata('error', 'no_id_passed');

			// redirect user
			redirect('admin/orders/modify/index/'.$order_id, 'location');
		}

		// update records
		$this->DB->set('qty', $this->input->post('qty'));
		$this->DB->where('order_log_detail_id', $this->input->post('order_log_detail_id'));
		$this->DB->update('tbl_order_log_details');

		// return to modify order page
		redirect('my_account/sales/orders/modify/index/'.$order_id, 'location');
	}

	// ----------------------------------------------------------------------

	/**
	 * PUBLIC - Remove an item from the order
	 *
	 * @return	void
	 */
	public function edit_item_price($order_id = '')
	{
		if ( ! $order_id)
		{
			// nothing more to do...
			// set flash data
			$this->session->set_flashdata('error', 'no_id_passed');

			// redirect user
			redirect('my_account/sales/orders/modify/index/'.$order_id, 'location');
		}

		// update records
		$this->DB->set('unit_price', $this->input->post('unit_price'));
		$this->DB->where('order_log_detail_id', $this->input->post('order_log_detail_id'));
		$this->DB->update('tbl_order_log_details');

		// return to modify order page
		redirect('my_account/sales/orders/modify/index/'.$order_id, 'location');
	}

	// ----------------------------------------------------------------------

	/**
	 * PUBLIC - Remove an item from the order
	 *
	 * @return	void
	 */
	public function edit_remarks($order_id = '')
	{
		if ( ! $order_id)
		{
			// nothing more to do...
			// set flash data
			$this->session->set_flashdata('error', 'no_id_passed');

			// redirect user
			redirect('admin/orders', 'location');
		}

		// update records
		$this->DB->set('remarks', $this->input->post('remarks'));
		$this->DB->where('order_log_id', $order_id);
		$this->DB->update('tbl_order_log');

		// return to modify order page
		redirect('my_account/sales/orders/modify/index/'.$order_id, 'location');
	}

	// ----------------------------------------------------------------------

	/**
	 * PUBLIC - Remove an item from the order
	 *
	 * @return	void
	 */
	public function add_discount($order_id = '')
	{
		if ( ! $order_id)
		{
			// nothing more to do...
			// set flash data
			$this->session->set_flashdata('error', 'no_id_passed');

			// redirect user
			redirect('my_account/sales/orders/modify/index/'.$order_id, 'location');
		}

		// get order details
		$order_details =
			$this->order_details->initialize(
				array(
					'tbl_order_log.order_log_id'=>$order_id
				)
			)
		;

		// get order options
		$options = $order_details->options;

		// add/edit/remove options for discount
		if ($this->input->post('discount') === '0')
		{
			unset($options['discount']);
		}
		else
		{
			$options['discount'] = $this->input->post('discount');
		}

		// update records
		$this->DB->set('options', json_encode($options));
		$this->DB->where('order_log_id', $order_id);
		$this->DB->update('tbl_order_log');

		// return to modify order page
		redirect('my_account/sales/orders/modify/index/'.$order_id, 'location');
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

			// bootstrap select
			$this->data['page_level_styles_plugins'].= '
				<link href="'.$assets_url.'/assets/global/plugins/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
				<link href="'.$assets_url.'/assets/global/plugins/select2/css/select2-bootstrap.min.css" rel="stylesheet" type="text/css" />
				<link href="'.$assets_url.'/assets/global/plugins/bootstrap-select/css/bootstrap-select.min.css" rel="stylesheet" type="text/css" />
			';
			// summernote wysiwyg
			$this->data['page_level_styles_plugins'].= '
				<link href="'.$assets_url.'/assets/global/plugins/bootstrap-summernote/summernote.css" rel="stylesheet" type="text/css" />
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

			// bootstrap select
			$this->data['page_level_plugins'].= '
				<script src="'.$assets_url.'/assets/global/plugins/select2/js/select2.full.min.js" type="text/javascript"></script>
				<script src="'.$assets_url.'/assets/global/plugins/bootstrap-select/js/bootstrap-select.min.js" type="text/javascript"></script>
			';
			// summernote wysiwyg
			$this->data['page_level_plugins'].= '
				<script src="'.$assets_url.'/assets/global/plugins/bootstrap-summernote/summernote.min.js" type="text/javascript"></script>
			';
			// form validation
			$this->data['page_level_plugins'].= '
				<script src="'.$assets_url.'/assets/global/plugins/jquery-validation/js/jquery.validate.min.js" type="text/javascript"></script>
				<script src="'.$assets_url.'/assets/global/plugins/jquery-validation/js/additional-methods.min.js" type="text/javascript"></script>
			';

		/****************
		 * page scripts inserted at <bottom>
		 * after global scripts, before theme layout scripts
		 */
		$this->data['page_level_scripts'] = '';

			// handle bootstrap select - make select class '.bs-select' a boostrap select picker
			$this->data['page_level_scripts'].= '
				<script src="'.$assets_url.'/assets/pages/scripts/components-bootstrap-select.min.js" type="text/javascript"></script>
			';
			// handle datatable
			$this->data['page_level_scripts'].= '
				<script src="'.base_url().'assets/custom/js/metronic/pages/scripts/sales-orders-modify.js" type="text/javascript"></script>
			';
	}

	// ----------------------------------------------------------------------

}
