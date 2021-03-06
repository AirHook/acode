<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Search extends Sales_User_Search_Controller
{
	/**
	 * DB Object
	 *
	 * @return	object
	 */
	protected $DB;


	/**
	 * Constructor
	 *
	 * @return	void
	 */
	function __Construct()
	{
		parent::__Construct();

		// connect to database for use by model
		$this->DB = $this->load->database('instyle', TRUE);
	}

	// --------------------------------------------------------------------

	/**
	 * Primary method - index
	 *
	 * @return	void
	 */
	function index()
	{
		// generate the plugin scripts and css
		$this->_create_plugin_scripts();

		// load pertinent library/model/helpers
		$this->load->library('categories/categories_tree');

		// now, get the product items
		$this->search_products($this->input->post('style_no'));

		// if no search result, send to search results page with other recommendations
		if ($this->products_list->row_count == 0)
		{
			// set flash data
			$_SESSION['error'] = 'zero_search_result';
			$this->session->mark_as_flash('error');

			redirect('my_account/sales/products', 'location');
		}

		// some data used by admin/products that we may need to set here to use the same vewi file
		$this->data['products'] = $this->products;
		$this->data['products_count'] = $this->products_list->row_count;
		$this->data['search_string'] = $this->input->post('style_no');

		$this->data['view_as'] = 'sales_products_grid'; // products_grid, products_list, products_nestable_list
		$this->data['order_by'] = 'prod_date';
		$this->data['active_designer'] = $this->sales_user_details->designer;

		// for categories, user sales user reference designer
		$this->data['categories'] = $this->categories_tree->treelist(
			array(
				'with_products' => TRUE,
				'd_url_structure' => $this->sales_user_details->designer
			)
		);
		$this->data['number_of_categories'] = $this->categories_tree->row_count;
		$this->data['pre_link'] = 'my_account/sales/products/instock/index';

		// need to show loading at start
		$this->data['show_loading'] = FALSE;
		$this->data['search'] = TRUE;

		// breadcrumbs
		$this->data['page_breadcrumb'] = array(
			'products' => 'Products',
			'serach' => 'Search'
		);

		// set data variables...
		$this->data['role'] = 'sales';
		$this->data['file'] = 'sales_products'; // options - 'products_search'
		$this->data['page_title'] = 'Products Search';
		$this->data['page_description'] = 'List of search results';

		// load views...
		$this->load->view('admin/metronic/template_my_account/template', $this->data);
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
			// search css
			$this->data['page_level_styles_plugins'].= '
				<link href="'.$assets_url.'/assets/pages/css/search.min.css" rel="stylesheet" type="text/css" />
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
		$this->data['page_level_styles'] = '';

		/****************
		 * page js plugins inserted at <bottom>
		 * after core plugins, before global scripts
		 */
		$this->data['page_level_plugins'] = '';

			// unveil - lazy script for images
			$this->data['page_level_plugins'] = '
				<script src="'.base_url().'assets/custom/js/jquery.unveil.js" type="text/javascript"></script>
			';
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
			// form validation
			$this->data['page_level_plugins'].= '
				<script src="'.$assets_url.'/assets/global/plugins/jquery-validation/js/jquery.validate.min.js" type="text/javascript"></script>
				<script src="'.$assets_url.'/assets/global/plugins/jquery-validation/js/additional-methods.min.js" type="text/javascript"></script>
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
			// handle datatable and form validation
			$this->data['page_level_scripts'].= '
				<script src="'.base_url().'assets/custom/js/metronic/pages/scripts/table-datatables-product_list_search.js" type="text/javascript"></script>
			';
	}

	// --------------------------------------------------------------------

}
