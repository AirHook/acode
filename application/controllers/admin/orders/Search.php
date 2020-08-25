<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Search extends Admin_Controller {

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
	 * This method searches for either Order# or Customer/Store Name from order log
	 *
	 * @return	void
	 */
	public function index()
	{
		if ( ! $this->input->post())
		{
			// nothing more to do...
			// set flash data
			$this->session->set_flashdata('error', 'no_id_passed');

			// redirect user
			redirect('admin/orders', 'location');
		}

		// generate the plugin scripts and css
		$this->_create_plugin_scripts();

		// load pertinent library/model/helpers
		$this->load->library('orders/orders_list');
		$this->load->library('designers/designer_details');
		$this->load->library('designers/designers_list');

		// get designer list for the dropdown filter
		$this->designers_list->initialize(array('with_products'=>TRUE));
		$this->data['designers'] = $this->designers_list->select();

		// process main search string
		$search_string = $this->input->post('search_string');
		$search_where = '(';
		$search_where.= "tbl_order_log.order_log_id LIKE '%".$search_string."%'";
		$search_where.= " OR tbl_order_log.firstname LIKE '%".$search_string."%'";
		$search_where.= " OR tbl_order_log.lastname LIKE '%".$search_string."%'";
		$search_where.= " OR tbl_order_log.store_name LIKE '%".$search_string."%'";
		$exp_search_string = explode(' ', $search_string);
		foreach ($exp_search_string as $string)
		{
			$search_where.= " OR tbl_order_log.order_log_id LIKE '%".$string."%'";
			$search_where.= " OR tbl_order_log.firstname LIKE '%".$string."%'";
			$search_where.= " OR tbl_order_log.lastname LIKE '%".$string."%'";
			$search_where.= " OR tbl_order_log.store_name LIKE '%".$string."%'";
		}
		$search_where.= ')';
		$where['condition'] = $search_where;

		// get data
		$having_des_group = FALSE;
		if (@$this->webspace_details->options['site_type'] == 'sal_site')
		{
			$where['tbl_order_log.webspace_id'] = @$this->webspace_details->id;
		}
		elseif ($this->webspace_details->options['site_type'] == 'sat_site')
		{
			$having_des_group = $this->webspace_details->name;
		}
		$this->data['orders'] = $this->orders_list->select(
			$where,
			array(), // order_by
			array(), // limit
			$having_des_group
		);
		$this->data['count_all'] = $this->orders_list->count_all;

		// need to show loading at start
		$this->data['show_loading'] = FALSE;
		$this->data['search'] = TRUE;
		$this->data['search_string'] = $this->input->post('search_string');

		// set data variables...
		$this->data['role'] = 'admin';
		$this->data['file'] = 'orders_new_orders';
		$this->data['page_title'] = 'Order Logs';
		$this->data['page_description'] = 'List of orders';

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
				<script src="'.base_url().'assets/custom/js/metronic/pages/scripts/table-datatables-orders.js" type="text/javascript"></script>
			';
	}

	// ----------------------------------------------------------------------

}
