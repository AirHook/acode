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
		// defauls to all dresses under womens apparel
		redirect('admin/products/all', 'location');

		// generate the plugin scripts and css
		$this->_create_plugin_scripts();

		// load pertinent library/model/helpers
		$this->load->add_package_path(APPPATH.'erp');
		$this->load->helper('metronic/create_category_treelist');
		$this->load->library('products/product_details');
		$this->load->library('designers/designer_details');
		$this->load->library('categories/categories');
		$this->load->library('categories/categories_tree');
		$this->load->library('designers/designers_list');

		// get some data
		$this->data['designers'] = $this->designers_list->select();
		$this->data['view_as'] = $this->session->userdata('view_as') ?: 'products_list'; // products_grid, products_list, products_nestable_list
		$this->data['order_by'] = $this->session->userdata('order_by') ?: 'prod_date';

		// for categories, we check conditions of site type
		if ($this->webspace_details->options['site_type'] == 'hub_site')
		{
			$this->data['categories'] = $this->categories_tree->treelist(array('with_products' => TRUE));
		}
		else
		{
			$this->data['categories'] = $this->categories_tree->treelist(
				array(
					'with_products' => TRUE,
					'd_url_structure' => $this->webspace_details->slug
				)
			);
		}
		$this->data['number_of_categories'] = $this->categories_tree->row_count;

		// let's grab the uri segments
		$this->session->set_flashdata('thumbs_uri_string', $this->uri->uri_string());
		$this->data['url_segs'] = explode('/', $this->uri->uri_string());

		// let's remove the first 2 segments (admin/products) from the resulting array
		array_shift($this->data['url_segs']); // admin
		array_shift($this->data['url_segs']); // products
		array_shift($this->data['url_segs']); // index

		// get the last segment which will serve as the category_slug in reference for the product list
		if (count($this->data['url_segs']) > 0)
		{
			// we need to check if browsing by designer/category through the first segment
			$first_seg = $this->data['url_segs'][0];
			if ($this->designer_details->initialize(array('designer.url_structure'=>$first_seg)))
			{
				// use first segment designer_slug if present
				$this->data['active_designer'] = $this->designer_details->slug;
				// and set sessiong accordingly
				$this->session->set_userdata('active_designer', $this->designer_details->slug);
			}
			else
			{
				// check for session first, otherwise, go browse by category only
				$this->data['active_designer'] =
					$this->webspace_details->options['site_type'] == 'hub_site'
					? FALSE
					: $this->webspace_details->slug
				;
				unset($_SESSION['active_designer']);
			}

			// last segment as category slug
			$this->data['active_category'] = $this->data['url_segs'][count($this->data['url_segs']) - 1];
		}
		else
		{
			// defauls to all dresses under womens apparel
			redirect('admin/products/index/womens_apparel');
			//$this->data['active_designer'] = FALSE;
			//$this->data['active_category'] = 'womens_apparel';
		}

		// get respective active category ID for use on product list where condition
		$category_id = $this->categories_tree->get_id($this->data['active_category']);

		// set product list where condition
		if ($this->data['active_designer'] !== FALSE)
		{
			if ($category_id)
			{
				$where = array(
					'designer.url_structure' => $this->data['active_designer'],
					'tbl_product.categories LIKE' => $category_id // last segment of category
				);
			}
			else $where = array('designer.url_structure' => $this->data['active_designer']);
		}
		else $where = array('tbl_product.categories LIKE' => $category_id);

		// get the products list and total count
		$params['show_private'] = TRUE; // all items general public (Y) - N for private
		$params['view_status'] = 'ALL'; // all items view status (Y, Y1, Y2, N)
		$params['view_at_hub'] = TRUE; // all items general public at hub site
		$params['view_at_satellite'] = TRUE; // all items publis at satellite site
		$params['variant_publish'] = 'ALL'; // all items at variant level publish (view status)
		$params['variant_view_at_hub'] = TRUE; // variant level public at hub site
		$params['variant_view_at_satellite'] = TRUE; // varian level public at satellite site
		$params['with_stocks'] = FALSE; // Show all with and without stocks
		$params['group_products'] = TRUE; // group per product number or per variant
		$params['special_sale'] = FALSE; // special sale items only
		$params['pagination'] = 0; // get all in one query
		$this->load->library('products/products_list', $params);
		$this->data['products'] = $this->products_list->select(
			$where,
			array( // order conditions
				'seque'=>'asc'
			)
		);
		$this->data['products_count'] = $this->products_list->row_count;

		// need to show loading at start
		$this->data['show_loading'] = TRUE;

		// set data variables...
		$this->data['file'] = 'products';
		$this->data['page_title'] = 'Products';
		$this->data['page_description'] = 'List of products';

		// load views...
		$this->load->view($this->config->slash_item('admin_folder').($this->config->slash_item('admin_template') ?: 'metronic/').'template/template', $this->data);
	}

	// ----------------------------------------------------------------------

	/**
	 * PUBLIC - Generate barcode labels
	 *
	 * @return	void
	 */
	public function barcodes($code=null)
	{
		if ($code != null)
		{
			// $this->load->library('barcode');
			// $data['barcode_code']=$this->barcode->generate_barcode($code);
			$this->data['barcode_code'] = $code;
			echo '<pre>',print_r($data),'</pre>';exit();
			$this->load->view($this->config->slash_item('admin_folder').'metronic/barcodes/print_barcode',$this->data);
		}
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
				<script src="'.base_url().'assets/custom/js/metronic/pages/scripts/table-datatables-product_list.js" type="text/javascript"></script>
			';
	}

	// ----------------------------------------------------------------------

}
