<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Multiple_upload_images extends Admin_Controller {

	/**
	 * DB Reference
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
    }

	// ----------------------------------------------------------------------

	public function index()
	{
		// generate the plugin scripts and css
		$this->_create_plugin_scripts();

		// load pertinent library/model/helpers
		$this->load->helper('metronic/create_category_treelist');
		$this->load->library('products/product_details');
		$this->load->library('categories/categories');
		$this->load->library('categories/categories_tree');
		$this->load->library('categories/category_details');
		$this->load->library('designers/designers_list');
		$this->load->library('designers/designer_details');
		$this->load->library('facet_list');

		// get some data
		$this->data['designers'] = $this->designers_list->select();
		$this->data['categories'] = $this->categories_tree->treelist();

		// let's do some defaults...
		$this->data['active_designer'] =
			@$this->webspace_details->options['site_type'] === 'hub_site'
			? (
				@$this->webspace_details->options['primary_designer'] ?:
				$this->designers_list->first_row->url_structure
			)
			: ($this->webspace_details->slug ?: $this->config->item('site_slug')) // should default to the webspace slug for sat_sites
		;

		// initiate categories via select
		$this->categories_tree->select(array('d_url_structure LIKE'=>'%'.$this->data['active_designer'].'%'));

		// active category selection
		// changing active categories using id's in an array
		// from the old version using slugs
		$this->data['active_category'] =
			$this->session->userdata('active_category')
			?: $this->categories_tree->first_row->category_slug; // first category on list

		// active view default to front
		$this->data['select_product_view'] = $this->session->userdata('select_product_view') ?: 'front';

		// for tempo, get list of season facets and also get the default result season
		// will need to add these seasons to categories to accomodate tempo but will also
		// be availabe to other designers
		/*
		if (
			$this->webspace_details->slug == 'tempoparis'
			OR $this->data['active_designer'] == 'tempoparis'
		)
		{
			$this->data['seasons'] = $this->facet_list->get('events');
			$this->data['active_season'] = $this->session->userdata('active_season') ?: $this->facet_list->first_row->url_structure;
		}
		*/

		// set active details
		$this->data['active_designer_details'] = $this->designer_details->initialize(array('url_structure'=>$this->data['active_designer']));
		//$this->data['active_category_details'] = $this->category_details->initialize(array('category_slug'=>$this->data['active_category']));

		// de-initialize certain properties
		$this->product_details->deinitialize();

		// set page variables...
		$this->data['file'] = 'products_add_upload_images_new';
		$this->data['page_title'] = 'Add Multiple Product';
		$this->data['page_description'] = 'Add multiple new products by uploading images referencing the filenames';

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
			// dropzone
			$this->data['page_level_styles_plugins'].= '
				<link href="'.$assets_url.'/assets/global/plugins/dropzone/dropzone.min.css" rel="stylesheet" type="text/css" />
				<link href="'.$assets_url.'/assets/global/plugins/dropzone/basic.min.css" rel="stylesheet" type="text/css" />
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
			// dropzone
			$this->data['page_level_plugins'].= '
				<script src="'.$assets_url.'/assets/global/plugins/dropzone/dropzone.min.js" type="text/javascript"></script>
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

			// button spinners for ladda
			$this->data['page_level_scripts'].= '
				<script src="'.$assets_url.'/assets/pages/scripts/ui-buttons-spinners.min.js" type="text/javascript"></script>
			';
			// handle bootstrap select - make select class '.bs-select' a boostrap select picker
			$this->data['page_level_scripts'].= '
				<script src="'.$assets_url.'/assets/pages/scripts/components-bootstrap-select.min.js" type="text/javascript"></script>
			';
			// dropzone and form validation
			$this->data['page_level_scripts'].= '
				<script src="'.base_url().'assets/custom/js/metronic/pages/scripts/form-dropzone_products_add_mulitple_images.js" type="text/javascript"></script>
			';
	}

	// ----------------------------------------------------------------------

}
