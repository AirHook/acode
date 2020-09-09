<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Index extends Admin_Controller {

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
		$this->load->library('designers/designers_list');
		$this->load->library('sales_package/sales_package_list');
		$this->load->library('products/product_details');
		$this->load->library('users/wholesale_users_list');

		// get designer list for the dropdown filter
		$this->designers_list->initialize(array('with_products'=>TRUE));
		$this->data['designers'] = $this->designers_list->select();

		// set some variables
		// we need a real variable to process some calculations
		$url_segs = $this->uri->segment_array();
		$this->data['page'] = is_numeric(end($url_segs)) ? end($url_segs) : 1;
		$this->data['limit'] = 100;
		$this->data['offset'] = $this->data['page'] == '' ? 0 : ($this->data['page'] * 100) - 100;
		//$this->orders_list->pagination = $this->data['page'];

		// check for site type, and des_slug, and other data
		$this->data['des_slug'] = '';
		if (
			$this->webspace_details->options['site_type'] == 'sat_site'
			OR $this->webspace_details->options['site_type'] == 'sal_site'
		)
		{
			$this->data['des_slug'] = @$this->sales_user_details->designer ?: $this->webspace_details->slug;
			$where['sales_packages.options LIKE'] = '%'.$this->data['des_slug'].'%';
			$where['sales_packages.webspace_id'] = $this->webspace_details->id;
		}
		else
		{
			// for filtering packages to specific designer
			if ($des_slug)
			{
				$where['sales_packages.options LIKE'] = '%'.$des_slug.'%';
				$this->data['des_slug'] = $des_slug;
			}
		}
		$where['sales_package_id >'] = '2';

		// get the list
		$this->data['packages'] = $this->sales_package_list->select($where);

		// active user list
		$per_page = 300;
		// where clauses
		$where2['tbluser_data_wholesale.is_active'] = '1';
		$this->data['users'] = $this->wholesale_users_list->select(
			$where2, // where
			array( // order by
				'tbluser_data_wholesale.store_name' => 'asc'
			),
			array($per_page)
		);
		//$this->data['user_id'] = '';
		$this->data['users_per_page'] = $per_page;
		$this->data['total_users'] = $this->wholesale_users_list->count_all;
		$this->data['number_of_pages'] =
			$per_page > 0
			? ceil($this->data['total_users'] / $this->data['users_per_page'])
			: $this->data['total_users']
		;

		// set data variables...
		$this->data['role'] = 'admin';
		$this->data['file'] = 'sa_list';
		$this->data['page_title'] = 'Sales Package';
		$this->data['page_description'] = 'List of Sales Packages';

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
				<script src="'.base_url().'assets/custom/js/metronic/pages/scripts/table-datatables-sales_package_list.js" type="text/javascript"></script>
			';
	}

	// ----------------------------------------------------------------------

}
