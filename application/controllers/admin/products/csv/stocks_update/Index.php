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
	 * @return	void
	 */
	public function index()
	{
		// check for stocks_update_csv_uri_string and load it instead
		// revert to defaul where necessary
		if ($this->uri->uri_string() == $this->config->slash_item('admin_folder').'products/csv/stocks_update')
		{
			if ($this->session->stocks_update_csv_uri_string) redirect ($this->session->stocks_update_csv_uri_string, 'location');
			else redirect($this->config->slash_item('admin_folder').'products/csv/stocks_update/index/basixblacklabel/womens_apparel/dresses/evening_dresses');
		}
		else
		{
			if (
				$this->session->stocks_update_csv_uri_string
				&& $this->session->stocks_update_csv_uri_string == $this->uri->uri_string()
			)
			{
				// keep the stocks_update_csv_uri_string session again
				$this->session->keep_flashdata('stocks_update_csv_uri_string');
			}
			else $this->session->set_flashdata('stocks_update_csv_uri_string', $this->uri->uri_string());
		}

		// generate the plugin scripts and css
		$this->_create_plugin_scripts();

		// load pertinent library/model/helpers
		$this->load->helper('metronic/create_category_treelist');
		$this->load->library('products/products_list_csv');
		$this->load->library('categories/categories_tree');
		$this->load->library('categories/category_details');
		$this->load->library('designers/designers_list');
		$this->load->library('designers/designer_details');

		// get some data
		$this->data['designers'] = $this->designers_list->select();
		$this->data['categories'] = $this->categories_tree->treelist(array('with_products'=>TRUE));

		// let's grab the uri segments for processiong
		$this->data['url_segs'] = explode('/', $this->uri->uri_string());

		// let's remove the following segments from the resulting array
		array_shift($this->data['url_segs']); // admin
		array_shift($this->data['url_segs']); // products
		array_shift($this->data['url_segs']); // csv
		array_shift($this->data['url_segs']); // stocks_update
		array_shift($this->data['url_segs']); // index

		/**********
		 * While this code much like the product listings index file where we check if
		 * page is listing items per general categories or designer categories, this csv
		 * manage page will have to be designer specific due to potential differences in
		 * designer size modes. Hence, url will always indicate designer slug, ergo,
		 * $active_designer will never be false.
		 */

		// there is a page at admin that uses active_category but as an array of category id's
		// like admin/products/add/multiple_image_upload we will need to treat it as void
		// and use a default 'womens_apparel' top tier category
		if (is_array($this->session->active_category)) unset($_SESSION['active_category']);

		// above code on stocks_update_csv_uri_string loop alleviates needing to check for active designer and category
		// we use the url segments to determing the product listing requested
		if (count($this->data['url_segs']) > 0)
		{
			// we need to check if browsing by designer/category through the first segment
			$first_seg = $this->data['url_segs'][0];
			if ($this->designer_details->initialize(array('designer.url_structure'=>$first_seg)))
			{
				// set active designer
				$this->data['active_designer'] = $this->designer_details->slug;
				$this->data['designer'] = $this->designer_details->name;
				// and set session accordingly
				$this->session->set_userdata('active_designer', $this->designer_details->slug);
			}
			else
			{
				$this->data['active_designer'] = FALSE;
				unset($_SESSION['active_designer']);
			}

			// putting a check if active_category is a category
			$last_seg = $this->data['url_segs'][count($this->data['url_segs']) - 1];
			if ($this->category_details->initialize(array('category_slug'=>$last_seg)))
			{
				// set active category
				$this->data['active_category'] = $this->category_details->category_slug;
				$this->data['category'] = $this->category_details->category_name;
				// and set session accordingly
				$this->session->set_userdata('active_category', $this->category_details->category_slug);
			}
			else
			{
				$this->data['active_category'] = FALSE;
				unset($_SESSION['active_category']);
			}
		}
		else
		{
			// defauls to all dresses under basixblacklabel womens apparel
			redirect($this->config->slash_item('admin_folder').'products/csv/stocks_update/index/basixblacklabel/womens_apparel/dresses/evening_dresses');
		}

		// we get the size mode necessary for the table and script requirements
		$this->data['size_mode'] = $this->webspace_details->get_size_mode(array('webspace_slug'=>$this->data['active_designer']));

		// initiate categories via select
		//$this->categories_tree->select(array('d_url_structure LIKE'=>$this->data['active_designer']));

		// get respective active category ID for use on view file
		$this->data['category_id'] = $this->categories_tree->get_id($this->data['active_category']);

		// need to show loading at start
		$this->data['show_loading'] = TRUE;

		// set data variables...
		$this->data['file'] = 'products_stocks_csv';
		$this->data['page_title'] = 'Products Stocks CSV Update';
		$this->data['page_description'] = 'CSV Manage Products Stocks';

		// load views...
		$this->load->view($this->config->slash_item('admin_folder').($this->config->slash_item('admin_template') ?: 'metronic/').'template/template', $this->data);
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
			// bootstrap select
			$this->data['page_level_styles_plugins'].= '
				<link href="'.$assets_url.'/assets/global/plugins/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
				<link href="'.$assets_url.'/assets/global/plugins/select2/css/select2-bootstrap.min.css" rel="stylesheet" type="text/css" />
				<link href="'.$assets_url.'/assets/global/plugins/bootstrap-select/css/bootstrap-select.min.css" rel="stylesheet" type="text/css" />
			';
			// bootstrap fileinput
			$this->data['page_level_styles_plugins'].= '
				<link href="'.$assets_url.'/assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css" rel="stylesheet" type="text/css" />
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
			// bootstrap fileinput
			$this->data['page_level_plugins'].= '
				<script src="'.$assets_url.'/assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js" type="text/javascript"></script>
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
				<script src="'.base_url().'assets/custom/js/metronic/pages/scripts/components-csv_stocks_update.js" type="text/javascript"></script>
			';
	}

	// ----------------------------------------------------------------------

}
