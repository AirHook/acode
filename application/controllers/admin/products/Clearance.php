<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Clearance extends Admin_Controller {

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
		$this->load->helper('metronic/create_category_treelist');
		$this->load->library('products/product_details');
		$this->load->library('designers/designer_details');
		$this->load->library('categories/categories');
		$this->load->library('categories/categories_tree');
		$this->load->library('designers/designers_list');

		// let's grab the uri segments and process it for some item that is required
		$this->session->set_flashdata('thumbs_uri_string', $this->uri->uri_string());
		$uri_string = explode('/', $this->uri->uri_string());

		// let's remove the first series of segments from the resulting array
		$this->data['url_segs'] = $uri_string;
		array_shift($this->data['url_segs']); // admin
		array_shift($this->data['url_segs']); // products
		array_shift($this->data['url_segs']); // index/all/private/unpublished/instock/onorder/clearance/by_vendor
		array_shift($this->data['url_segs']); // index

		// we need a real variable to process some calculations
		$url_segs = $this->data['url_segs'];

		// check for and grab flashdata then set new flashdata
		$prev_url_segs = $this->session->flashdata('prev_url_segs') ? '/'.$this->session->flashdata('prev_url_segs') : '';
		$this->session->set_flashdata('prev_url_segs', implode('/', $url_segs));

		// check any previous url segs for unwanted designer slugs
		if ($this->webspace_details->options['site_type'] != 'hub_site')
		{
			// check any previous url segs for unwanted designer slugs
			if ($this->designer_details->initialize(array('designer.url_structure'=>$url_segs[0])))
			{
				if ($this->designer_details->slug != $this->webspace_details->slug)
				{
					// unset any prev_url_segs
					unset($_SESSION['prev_url_segs']);

					// reload page with new prev_url_segs
					redirect('admin/products/clearance', 'location');
				}
			}

		}

		// set category pre link
		$this->data['pre_link'] = implode('/', array_diff($uri_string, $url_segs));

		// set some variables
		$this->data['page'] = is_numeric(end($url_segs)) ? end($url_segs) : 1;
		$this->data['limit'] = 100;
		$this->data['offset'] = $this->data['page'] == '' ? 0 : ($this->data['page'] * 100) - 100;

		// get some data
		$this->data['designers'] = $this->designers_list->select();
		$this->data['view_as'] = $this->session->userdata('view_as') ?: 'products_list'; // products_grid, products_list, products_nestable_list
		$this->data['order_by'] = $this->session->userdata('order_by') ?: 'prod_date';

		// for categories, we check conditions of site type
		if ($this->webspace_details->options['site_type'] == 'hub_site')
		{
			$this->data['categories'] = $this->categories_tree->treelist(
				array(
					'with_products' => TRUE
				)
			);
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

		// get the last segment which will serve as the category_slug in reference for the product list
		if (count($url_segs) > 0)
		{
			// we need to check if browsing by designer/category through the first segment
			$first_seg = $url_segs[0];
			if ($this->designer_details->initialize(array('designer.url_structure'=>$first_seg)))
			{
				// use first segment designer_slug if present
				$this->data['active_designer'] = $this->designer_details->slug;
				// and set sessiong accordingly
				$this->session->set_userdata('active_designer', $this->designer_details->slug);
				unset($_SESSION['browse_by_category']);
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
				$this->session->set_userdata('browse_by_category', TRUE);
			}

			// last segment as category slug
			$this->data['active_category'] =
				is_numeric(end($url_segs))
				? $this->data['url_segs'][count($this->data['url_segs']) - 2]
				: end($url_segs)
			;
			$this->session->set_userdata('active_category', $this->data['active_category']);
		}
		else
		{
			// defauls to all dresses under womens apparel
			if (
				$this->webspace_details->options['site_type'] == 'hub_site'
				&& ! $this->session->browse_by_category
			)
			{
				$redirect_url =
					$prev_url_segs
					? 'admin/products/clearance/index'.$prev_url_segs
					: (
						$this->webspace_details->slug == 'shop7thavenue'
						? 'admin/products/clearance/index/basixblacklabel/womens_apparel/dresses/evening_dresses'
						: 'admin/products/clearance/index/womens_apparel'
					)
				;
			}
			else
			{
				$redirect_url =
					$prev_url_segs
					? 'admin/products/clearance/index'.$prev_url_segs
					: 'admin/products/clearance/index/womens_apparel'
				;
			}

			redirect($redirect_url);
		}

		// get respective active category ID for use on product list where condition
		$category_id = $this->categories_tree->get_id($this->data['active_category']);
		$this->data['active_category_id'] = $category_id;

		// set product list where condition
		if ($this->data['active_designer'] !== FALSE)
		{
			$where['designer.url_structure'] = $this->data['active_designer'];
			if ($category_id)
			{
				$where['tbl_product.categories LIKE'] = $category_id; // of last segment category
			}
		}
		else $where['tbl_product.categories LIKE'] = $category_id;

		$where['tbl_product.clearance'] = '3';
		$where['tbl_stock.options NOT LIKE'] = '"clearance_consumer_only":"1"';

		// get the products list and total count
		$params['with_stocks'] = FALSE; // Show all with and without stocks
		$params['group_products'] = TRUE; // group per product number or per variant
		$params['special_sale'] = TRUE; // special sale items only
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

		// need to show loading at start
		$this->data['show_loading'] = FALSE;
		$this->data['page_param'] = 'clearance';

		// enable pagination
		$this->_set_pagination($this->data['count_all'], $this->data['limit']);

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
	 * PRIVATE - Set pagination parameters
	 *
	 * @return	void
	 */
	private function _set_pagination($count_all = '', $per_page = '')
	{
		$this->load->library('pagination');

		$uri_string = explode('/', $this->uri->uri_string());
		if (is_numeric(end($uri_string))) array_pop($uri_string);

		$config['base_url'] = base_url().implode('/',$uri_string).'/';
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
		$config['first_url'] = site_url('admin/products/clearance/index/womens_apparel');
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
			// nestable list
			$this->data['page_level_styles_plugins'].= '
				<link href="'.$assets_url.'/assets/global/plugins/jquery-nestable/jquery.nestable.css" rel="stylesheet" type="text/css" />
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
			// nestable list
			$this->data['page_level_plugins'].= '
				<script src="'.$assets_url.'/assets/global/plugins/jquery-nestable/jquery.nestable.js" type="text/javascript"></script>
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
