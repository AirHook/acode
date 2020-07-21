<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Instock extends Sales_user_Controller {

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
		// generate the plugin scripts and css
		$this->_create_plugin_scripts();

		// load pertinent library/model/helpers
		$this->load->library('categories/categories_tree');
		$this->load->helper('metronic/create_category_treelist');
		$this->load->library('products/product_details');
		$this->load->library('designers/designer_details');
		$this->load->library('categories/categories');
		$this->load->library('designers/designers_list');

		// let's remove the first series of segment array
		$uri_string = $this->uri->segment_array();
		$this->data['url_segs'] = $this->uri->segment_array();
		array_shift($this->data['url_segs']); // my_account
		array_shift($this->data['url_segs']); // sales
		array_shift($this->data['url_segs']); // products
		array_shift($this->data['url_segs']); // index/all/private/unpublished/instock/onorder/clearance/by_vendor
		array_shift($this->data['url_segs']); // index

		// we need a real variable to process some calculations
		$url_segs = $this->data['url_segs'];

		if (empty($url_segs))
		{
			// defauls to all dresses under womens apparel
			redirect('my_account/sales/products/instock/index/womens_apparel');
		}

		// set category pre link
		$this->data['pre_link'] = implode('/', array_diff($uri_string, $url_segs));

		// set some variables
		$this->data['page'] = is_numeric(end($url_segs)) ? end($url_segs) : 1;
		$this->data['limit'] = 100;
		$this->data['offset'] = $this->data['page'] == '' ? 0 : ($this->data['page'] * 100) - 100;
		$this->data['view_as'] = 'sales_products_grid'; // products_grid, products_list -> default to grid for sales
		$this->data['active_designer'] = $this->sales_user_details->designer;

		// get categories
		$this->data['categories'] = $this->categories_tree->treelist(
			array(
				'with_products' => TRUE,
				'd_url_structure' => $this->sales_user_details->designer // used by my_account sales
			)
		);
		$this->data['number_of_categories'] = $this->categories_tree->row_count;

		// get designer primary subcat as default subcat for initial page load
		$category_slug = end($url_segs);
		$category_id = $this->categories_tree->get_id($category_slug);
		$where['tbl_product.categories LIKE'] = $category_id;

		// there will always be one des_slug on sales product listing
		$where['designer.url_structure'] = $this->sales_user_details->designer;

		// get the products list for the thumbs grid view
		$params['show_private'] = TRUE; // all items general public (Y) - N for private
		$params['view_status'] = 'ALL'; // all items view status (Y, Y1, Y2, N)
		$params['view_at_hub'] = TRUE; // all items general public at hub site
		$params['view_at_satellite'] = TRUE; // all items publis at satellite site
		$params['variant_publish'] = 'ALL'; // all items at variant level publish (view status)
		$params['variant_view_at_hub'] = TRUE; // variant level public at hub site
		$params['variant_view_at_satellite'] = TRUE; // varian level public at satellite site
		$params['with_stocks'] = TRUE; // Show all with and without stocks
		$params['group_products'] = FALSE; // group per product number or per variant
		$params['special_sale'] = FALSE; // special sale items only
		$params['pagination'] = $this->data['page']; // get all in one query
		$this->load->library('products/products_list', $params);
		$this->data['products'] = $this->products_list->select(
			$where,
			array( // order conditions
				'seque' => 'asc',
				'tbl_product.prod_no' => 'desc'
			),
			$this->data['limit']
		);
		$this->data['count_all'] = $this->products_list->count_all;
		$this->data['products_count'] = $this->products_list->row_count;

		// enable pagination
		$this->_set_pagination($this->data['count_all'], $this->data['limit'], implode('/', $url_segs));

		// need to show loading at start
		$this->data['show_loading'] = FALSE;

		// breadcrumbs
		$this->data['page_breadcrumb'] = array(
			'products' => 'Products',
			'in_stock' => 'In Stock'
		);

		// set data variables...
		$this->data['role'] = 'sales';
		$this->data['file'] = 'sales_products';
		$this->data['page_title'] = 'Products';
		$this->data['page_description'] = 'List of products';

		// load views...
		$this->load->view('admin'.($this->config->slash_item('admin_template') ?: 'metronic/').'template_my_account/template', $this->data);
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
	 * PRIVATE - Set pagination parameters
	 *
	 * @return	void
	 */
	private function _set_pagination($count_all = '', $per_page = '', $uri_string = '')
	{
		$this->load->library('pagination');

		$url = 'my_account/sales/products/all';

		$config['base_url'] = base_url().$url.'/index/'.($uri_string ? $uri_string.'/' : '');
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
		$config['first_url'] = site_url($url.'/index/womens_apparel');
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
