<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends Sales_Controller {

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
	 *
	 * @return	void
	 */
	public function index()
	{
		// generate the plugin scripts and css
		$this->_create_plugin_scripts();

		// load pertinent library/model/helpers
		$this->load->library('categories/categories');
		$this->load->library('categories/categories_tree');
		$this->load->library('sales_package/sales_package_list');
		$this->load->library('users/wholesale_users_list');

		// get some data
		// used for wizard steps
		$this->data['steps'] = 1;

		// used for setting active_category_id
		$this->categories->select(array('d_url_structure LIKE'=>'%'.($this->sales_user_details->designer == 'basixblacklabel' ? 'basix-black-label' : $this->sales_user_details->designer).'%'));
		$this->data['active_category_id'] =
			$this->session->userdata('active_category_id')
			?: @$this->categories->first_row->category_id; // first category on list

		// used for sidebar categories and main icon links
		//$this->data['categories'] = $this->categories_tree->treelist(array('d_url_structure'=>($this->sales_user_details->designer == 'basixblacklabel' ? 'basix-black-label' : $this->sales_user_details->designer),'with_products'=>TRUE));


		// used by roden2
		$this->data['packages'] = $this->sales_package_list->select(array('sales_user'=>$this->sales_user_details->admin_sales_id));
		$this->data['wholesale_users'] = $this->wholesale_users_list->select(array('tbluser_data_wholesale.admin_sales_email'=>$this->sales_user_details->email));

		// set data variables...
		$this->data['file']				= 'dashboard';
		$this->data['page_title'] 		= 'Dashboard';
		$this->data['page_description'] = 'Admin Sales Dashboard';
		$this->data['site_title']		= 'Sales Package';
		$this->data['site_keywords']	= '';
		$this->data['site_description']	= '';
		$this->data['footer_text']		= '';

		// load views...
		$this->load->view($this->data['sales_theme'].'/sales/template/template', $this->data);
	}

	// ----------------------------------------------------------------------

	/**
	 * PRIVATE - Creaet Plugin Scripts and CSS for the page
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
			// cubeportfolio
			$this->data['page_level_styles_plugins'].= '
				<link href="'.$assets_url.'/assets/global/plugins/cubeportfolio/css/cubeportfolio.css" rel="stylesheet" type="text/css" />
			';
			// bootstrap select
			$this->data['page_level_styles_plugins'].= '
				<link href="'.$assets_url.'/assets/global/plugins/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
				<link href="'.$assets_url.'/assets/global/plugins/select2/css/select2-bootstrap.min.css" rel="stylesheet" type="text/css" />
				<link href="'.$assets_url.'/assets/global/plugins/bootstrap-select/css/bootstrap-select.css" rel="stylesheet" type="text/css" />
			';

		/****************
		 * page style sheets inserted at <head>
		 */
		$this->data['page_level_styles'] = '';

			// portfolio styles
			$this->data['page_level_styles'].= '
				<link href="'.$assets_url.'/assets/pages/css/portfolio.min.css" rel="stylesheet" type="text/css" />
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
			// cubeportfolio
			$this->data['page_level_plugins'].= '
				<script src="'.$assets_url.'/assets/global/plugins/cubeportfolio/js/jquery.cubeportfolio.min.js" type="text/javascript"></script>
			';
			// form wizard - jquery validate is needed for the wizard to function
			$this->data['page_level_plugins'].= '
				<script src="'.$assets_url.'/assets/global/plugins/jquery-validation/js/jquery.validate.min.js" type="text/javascript"></script>
				<script src="'.$assets_url.'/assets/global/plugins/bootstrap-wizard/jquery.bootstrap.wizard.min.js" type="text/javascript"></script>
			';

		/****************
		 * page scripts inserted at <bottom>
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
			// handle portfolio
			$this->data['page_level_scripts'].= '
				<script src="'.base_url().'assets/custom/js/metronic/pages/scripts/sales-dashboard_grid.js" type="text/javascript"></script>
			';
			// handle form wizard
			$this->data['page_level_scripts'].= '
				<script src="'.$assets_url.'/assets/pages/scripts/form-wizard.min.js" type="text/javascript"></script>
			';


		/****************
		 * page scripts for DEFAULT theme
		 */
		$this->data['jscript'] = '
			<style>
				/* The Modal (background) */
				.modal {
					display: none; /* Hidden by default */
					position: fixed; /* Stay in place */
					z-index: 10000; /* Sit on top */
					left: 0;
					top: 0;
					width: 100%; /* Full width */
					height: 100%; /* Full height */
					overflow: auto; /* Enable scroll if needed */
					background-color: rgb(0,0,0); /* Fallback color */
					background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
				}

				/* Modal Content/Box */
				.modal-content {
					background-color: #fefefe;
					margin: 5% auto; /* 15% from the top and centered */
					padding: 20px;
					border: 1px solid #888;
					width: 740px; /* Could be more or less, depending on screen size (or in precentage) */
				}
				.modal-header h1 {
					margin: 0;
					padding-bottom: 10px;
					border-bottom: 1px solid #dedede;
				}
				.modal-body {
					padding: 10px 0;
				}

				/* The Close Button */
				.close {
					color: #aaa;
					float: right;
					font-size: 20px;
					font-weight: bold;
				}

				.close:hover,
				.close:focus {
					color: black;
					text-decoration: none;
					cursor: pointer;
				}
			</style>
			'.$this->search_autocomplete_scripts().'
		';
	}

	// ----------------------------------------------------------------------

}
