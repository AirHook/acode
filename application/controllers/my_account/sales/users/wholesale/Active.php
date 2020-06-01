<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Active extends Sales_user_Controller {

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
	public function index($des_slug = '')
	{
		// generate the plugin scripts and css
		$this->_create_plugin_scripts();

		// load pertinent library/model/helpers
		$this->load->library('users/admin_users_list');
		$this->load->library('users/consumer_users_list');
		$this->load->library('users/sales_users_list');
		$this->load->library('users/vendor_users_list');
		$this->load->library('users/wholesale_users_list');
		$this->load->library('designers/designers_list');

		// get designer list for the dropdown filter
		$this->data['designers'] = $this->designers_list->select(
			array(
				'designer.url_structure' =>$this->sales_user_details->designer
			)
		);

		// initialize sales package
		// check if there is a default sales package - set_as_default as '1'
		// used for sending recent items sales package under action column
		$this->load->library('sales_package/sales_package_details');
		$this->data['default_sales_package'] = $this->sales_package_details->initialize(array('set_as_default'=>'1'));

		// set some variables
		// we need a real variable to process some calculations
		$url_segs = $this->uri->segment_array();
		$this->data['page'] = is_numeric(end($url_segs)) ? end($url_segs) : 1;
		$this->data['limit'] = 100;
		$this->data['offset'] = $this->data['page'] == '' ? 0 : ($this->data['page'] * 100) - 100;
		$this->wholesale_users_list->pagination = $this->data['page'];

		// set active items
		$this->data['des_slug'] = '';
		$this->data['status'] = 'active';

		// get data
		$custom_where = ''; // handles mixed designer or no designer query
		if (@$this->webspace_details->options['site_type'] != 'hub_site')
		{
			$where['tbluser_data_wholesale.reference_designer'] = $this->webspace_details->slug;
		}
		else
		{
			if ($this->data['des_slug'] == $this->webspace_details->slug)
			{
				$custom_where = "(
					tbluser_data_wholesale.reference_designer IS NULL
					OR tbluser_data_wholesale.reference_designer = ''
					OR tbluser_data_wholesale.reference_designer = 'instylenewyork'
					OR tbluser_data_wholesale.reference_designer = '".$this->data['des_slug']."'
				)";
			}
			else $where['tbluser_data_wholesale.reference_designer'] = $this->data['des_slug'] ?: '';
		}
		$where['tbluser_data_wholesale.is_active'] = '1';
		$where['tbluser_data_wholesale.admin_sales_email'] = $this->sales_user_details->email;
		$this->data['users'] = $this->wholesale_users_list->select(
			$where,
			array(),
			array($this->data['offset'], $this->data['limit']),
			$custom_where
		);
		$this->data['count_all'] = $this->wholesale_users_list->count_all;

		// enable pagination
		$this->_set_pagination($this->data['count_all'], $this->data['limit'], $this->data['des_slug']);

		// need to show loading at start
		$this->data['show_loading'] = FALSE;
		$this->data['search'] = FALSE;

		// breadcrumbs
		$this->data['page_breadcrumb'] = array(
			'users/wholesale/active' => 'Active Wholesale Users'
		);

		// set data variables...
		$this->data['role'] = 'sales';
		$this->data['file'] = 'users_wholesale';
		$this->data['page_title'] = 'Wholesale Users';
		$this->data['page_description'] = 'List of whooesale users';

		// load views...
		$this->load->view('admin/metronic/template_my_account/template', $this->data);
	}

	// ----------------------------------------------------------------------

	/**
	 * PRIVATE - Set pagination parameters
	 *
	 * @return	void
	 */
	private function _set_pagination($count_all = '', $per_page = '', $des_slug = '')
	{
		$this->load->library('pagination');

		$url = 'admin/users/wholesale/active';

		$config['base_url'] = base_url().$url.'/index/'.($des_slug ? $des_slug.'/' : '');
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
		$config['first_url'] = site_url($url.($des_slug ? '/index/'.$des_slug : ''));
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
				<script src="'.base_url().'assets/custom/js/metronic/pages/scripts/table-datatables-users_wholesale_list.js" type="text/javascript"></script>
			';
	}

	// ----------------------------------------------------------------------

}
