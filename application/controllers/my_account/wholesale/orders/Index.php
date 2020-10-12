<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Index extends Wholesale_user_Controller {

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
	 * This method simply lists all sales pacakges
	 *
	 * @return	void
	 */
	public function index()
	{
		// generate the plugin scripts and css
		$this->_create_plugin_scripts();

		// load pertinent library/model/helpers
		$this->load->library('orders/orders_list');

		// set some variables
		// we need a real variable to process some calculations
		$url_segs = explode('/', $this->uri->uri_string());
		$this->data['page'] = is_numeric(end($url_segs)) ? end($url_segs) : 1;
		$this->data['limit'] = 100;
		$this->data['offset'] = $this->data['page'] == '' ? 0 : ($this->data['page'] * 100) - 100;
		$this->orders_list->pagination = $this->data['page'];

		// get data
		$where['tbl_order_log.c'] = 'ws';
		$where['tbl_order_log.user_id'] = $this->session->user_id;
		$where['tbl_order_log.status'] = '0';
		if (@$this->webspace_details->options['site_type'] != 'hub_site')
		{
			$where['tbl_order_log.webspace_id'] = @$this->webspace_details->id;
		}
		$this->data['orders'] = $this->orders_list->select(
			$where,
			array(), // order_by
			array($this->data['limit'], $this->data['offset']) // limit
		);
		$this->data['count_all'] = $this->orders_list->count_all;

		// enable pagination
		$this->_set_pagination($this->data['count_all'], $this->data['limit']);

		// need to show loading at start
		$this->data['show_loading'] = FALSE;
		$this->data['search'] = FALSE;

		// set data variables...
		$this->data['role'] = 'wholesale'; //userrole will be used for IF statements in template files
		$this->data['file'] = '../my_account/orders'; // using frontend gui
		$this->data['page_title'] = 'Wholesale Orders';
		$this->data['page_description'] = 'List of Wholesale Orders';

		// load views...
		$this->load->view('metronic/template/template', $this->data);
	}

	// ----------------------------------------------------------------------

	/**
	 * Details - order details
	 *
	 * Wholesale Order Details
	 *
	 * @return	void
	 */
	public function details($id = '')
	{
		if ( ! $id)
		{
			// nothing more to do...
			// set flash data
			$this->session->set_flashdata('error', 'no_id_passed');

			// redirect user
			redirect($this->config->slash_item('admin_folder').'orders');
		}

		// generate the plugin scripts and css
		$this->_create_plugin_scripts();

		// load pertinent library/model/helpers
		$this->load->library('products/product_details');
		$this->load->library('orders/order_details');

		// initialize...
		$this->order_details->initialize(array('tbl_order_log.order_log_id'=>$id));

		// set data variables...
		$this->data['role'] = 'wholesale'; //userrole will be used for IF statements in template files
		$this->data['file'] = '../my_account/orders_details';
		$this->data['page_title'] = 'Order Details';
		$this->data['page_description'] = 'Details of the order transaction';

		// load views...
		$this->load->view('metronic/template/template', $this->data);
	}

	// ----------------------------------------------------------------------

	/**
	 * PRIVATE - Set pagination parameters
	 *
	 * @return	void
	 */
	private function _set_pagination($count_all = '', $per_page = '')
	{
		$this->load->library('pagination');

		$config['base_url'] = base_url().'my_account/wholesale/orders/';
		$config['total_rows'] = $count_all;
		$config['per_page'] = $per_page;
		$config['num_links'] = 3;
		$config['use_page_numbers'] = TRUE;
		$config['full_tag_open'] = '<ul class="pagination pull-right" style="margin:0;">';
		$config['full_tag_close'] = '</ul>';
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';
		$config['cur_tag_open'] = '<li class="active"><a href="javascript:;">';
		$config['cur_tag_close'] = '</a></li>';
		$config['first_link'] = '<i class="fa fa-angle-double-left"></i>';
		$config['first_url'] = site_url('my_account/wholesale/orders');
		$config['first_tag_open'] = '<li>';
		$config['first_tag_close'] = '</li>';
		$config['last_link'] = '<i class="fa fa-angle-double-right"></i>';
		$config['last_tag_open'] = '<li>';
		$config['last_tag_close'] = '</li>';
		$config['prev_link'] = '<i class="fa fa-angle-left"></i>';
		$config['prev_tag_open'] = '<li>';
		$config['prev_tag_close'] = '</li>';
		$config['next_link'] = '<i class="fa fa-angle-right"></i>';
		$config['next_tag_open'] = '<li>';
		$config['next_tag_close'] = '</li>';

		$this->pagination->initialize($config);

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
