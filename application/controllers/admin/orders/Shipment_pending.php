<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Shipment_pending extends Admin_Controller {

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
	public function index($list = 'all', $des_slug = '')
	{
		// generate the plugin scripts and css
		$this->_create_plugin_scripts();

		// load pertinent library/model/helpers
		$this->load->library('orders/orders_list');
		$this->load->library('designers/designer_details');
		$this->load->library('designers/designers_list');

		// get designer list for the dropdown filter
		$this->designers_list->initialize(array('with_products'=>TRUE));
		$this->data['designers'] = $this->designers_list->select();

		// set some variables
		// we need a real variable to process some calculations
		$url_segs = explode('/', $this->uri->uri_string());
		$this->data['page'] = is_numeric(end($url_segs)) ? end($url_segs) : 1;
		$this->data['limit'] = 100;
		$this->data['offset'] = $this->data['page'] == '' ? 0 : ($this->data['page'] * 100) - 100;
		$this->orders_list->pagination = $this->data['page'];

		// get data
		$where = array();
		$having_des_group = FALSE;
		if (@$this->webspace_details->options['site_type'] == 'sal_site')
		{
			$where['tbl_order_log.webspace_id'] = @$this->webspace_details->id;
		}
		elseif ($this->webspace_details->options['site_type'] == 'sat_site')
		{
			$having_des_group = $this->webspace_details->name;
		}
		else
		{
			if ($des_slug && !is_numeric($des_slug))
			{
				$designer_details = $this->designer_details->initialize(array('designer.url_structure'=>$des_slug));
				if ($designer_details)
				{
					$having_des_group =
						$designer_details->url_structure == $this->webspace_details->slug
						? 'Mixed Designers'
						: $designer_details->designer
					;
					$this->data['des_slug'] = $designer_details->url_structure;
				}
			}
		}
		if ($list != 'all')
		{
			if ($list == 'cs')
			{
				$where['tbl_order_log.c'] = $list;
				$where['OR tbl_order_log.c'] = 'guest';
			}
			else $where['tbl_order_log.c'] = $list;
		}
		// 0-new,1-complete,2-onhold,3-canclled,4-returned/refunded,5-shipment_pending,6-store_credit
		$where['status'] = '5';
		// removing tempoparis on list for shop7
		if ($this->webspace_details->slug !== 'tempoparis')
		{
			$where['condition'] = '(tbl_order_log.webspace_id != "4" AND tbl_order_log.webspace_id != "67")';
		}
		// check for date ranges in uri query strings
		$this->data['from_date'] = @$_GET['from_date'] ?: '';
		$this->data['to_date'] = @$_GET['to_date'] ?: '';
		if ($this->data['to_date'] && $this->data['from_date'])
		{
			// convert dates to timestamp
			$from_date = strtotime($this->data['from_date']);
			$to_date = strtotime($this->data['to_date']);
			$where['tbl_order_log.order_date >='] = $from_date;
			$where['tbl_order_log.order_date <='] = $to_date;
		}
		// get the orders
		$this->data['orders'] = $this->orders_list->select(
			$where,
			array(), // order_by
			array($this->data['limit'], $this->data['offset']), // limit
			$having_des_group
		);
		$this->data['count_all'] = $this->orders_list->count_all;

		// other data
		$this->data['list'] = $list;
		$this->data['status'] = 'shipment_pending';

		// enable pagination
		$this->_set_pagination($this->data['count_all'], $this->data['limit'], $list, $des_slug);

		// need to show loading at start
		$this->data['show_loading'] = FALSE;
		$this->data['search'] = FALSE;

		// set data variables...
		$this->data['file'] = 'orders_new_orders';
		$this->data['page_title'] = 'Shipment Pending';
		$this->data['page_description'] = 'Order Logs';

		// load views...
		$this->load->view($this->config->slash_item('admin_folder').($this->config->slash_item('admin_template') ?: 'metronic/').'template/template', $this->data);
	}

	// ----------------------------------------------------------------------

	/**
	 * PRIVATE - Set pagination parameters
	 *
	 * @return	void
	 */
	private function _set_pagination($count_all = '', $per_page = '', $list, $des_slug)
	{
		$this->load->library('pagination');

		if ($des_slug && !is_numeric($des_slug))
		{
			$ref_uri = 'admin/orders/shipment_pending/index/'.$list.'/'.$des_slug;
		}
		else $ref_uri = $list == 'all' ? 'admin/orders/shipment_pending' : 'admin/orders/shipment_pending/index/'.$list;

		$config['base_url'] = base_url().'admin/orders/shipment_pending/index/'.($list ? $list.'/' : '').(($des_slug && !is_numeric($des_slug)) ? $des_slug.'/' : '');
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
		$config['first_url'] = site_url($ref_uri);
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
			// datepicker & date-time-pickers
			$this->data['page_level_styles_plugins'].= '
				<link href="'.$assets_url.'/assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css" rel="stylesheet" type="text/css" />
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
			// datepicker & date-time-pickers
			$this->data['page_level_plugins'].= '
				<script src="'.$assets_url.'/assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js" type="text/javascript"></script>
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
				<script src="'.base_url().'assets/custom/js/metronic/pages/scripts/components-admin_orders.js" type="text/javascript"></script>
			';
	}

	// ----------------------------------------------------------------------

}
