<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Onorder extends Admin_Controller {

	public function __construct()
	{
		parent::__construct();
    }

	// ----------------------------------------------------------------------

	public function index()
	{
		// generate the plugin scripts and css
		$this->_create_plugin_scripts();

		// load pertinent library/model/helpers
		$this->load->helper('metronic/create_category_treelist');
		$this->load->library('designers/designer_details');
		$this->load->library('categories/categories_tree');
		$this->load->library('designers/designers_list');
		$this->load->library('products/size_names');

		// for categories, we check conditions of site type
		if ($this->webspace_details->options['site_type'] == 'hub_site')
		{
			$this->data['designers'] = $this->designers_list->select();
			$this->data['categories'] = $this->categories_tree->treelist(array('with_products' => TRUE));
		}
		else
		{
			$this->data['designers'] = $this->designers_list->select(
				array(
					'url_structure' => $this->webspace_details->slug
				)
			);
			$this->data['categories'] = $this->categories_tree->treelist(
				array(
					'with_products' => TRUE,
					'd_url_structure' => $this->webspace_details->slug
				)
			);
		}
		$this->data['number_of_categories'] = $this->categories_tree->row_count;

		// let's grab the uri segments
		$this->session->set_flashdata('inventory_uri_string', $this->uri->uri_string());
		$this->data['url_segs'] = $this->uri->segment_array();

		// let's remove the first 2 segments (admin/products) from the resulting array
		array_shift($this->data['url_segs']); // admin
		array_shift($this->data['url_segs']); // inventory
		array_shift($this->data['url_segs']); // onorder
		array_shift($this->data['url_segs']); // index

		// set some variables for pagination purposes
		$this->data['page'] = is_numeric(end($this->data['url_segs'])) ? end($this->data['url_segs']) : 1;
		$this->data['limit'] = 100;
		$this->data['offset'] = $this->data['page'] == '' ? 0 : ($this->data['page'] * 100) - 100;

		// get the last segment which will serve as the category_slug in reference for the inventory list
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
				$this->data['size_mode'] = $this->designer_details->webspace_options['size_mode'];
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

				// default (just as a precaution)
				$this->data['size_mode'] = '1';
			}

			// get the size names
			$this->data['size_names'] = $this->size_names->get_size_names($this->data['size_mode']);

			// last segment as category slug
			if (is_numeric(end($this->data['url_segs']))) array_pop($this->data['url_segs']);
			$this->data['active_category'] = end($this->data['url_segs']);

			// and set sessiong accordingly
			$this->session->set_userdata('active_category', $this->data['active_category']);
		}
		else
		{
			if ( ! $this->input->post('search_string'))
			{
				// defauls to all dresses under womens apparel
				if ($this->webspace_details->options['site_type'] == 'hub_site')
				{
					redirect($this->config->slash_item('admin_folder').'inventory/onorder/index/basixblacklabel/womens_apparel/dresses/evening_dresses');
				}
				else
				{
					redirect($this->config->slash_item('admin_folder').'inventory/onorder/index/'.$this->webspace_details->slug);
				}
			}
		}

		if ($this->input->post('search_string'))
		{
			$this->data['search_string'] = $this->input->post('search_string');
			$where = array('tbl_product.prod_no LIKE' => $this->input->post('search_string'));
		}
		else
		{
			$this->data['search_string'] = '';

			// get respective active category ID for use on product list where condition
			$category_id = @$this->categories_tree->get_id($this->data['active_category']);

			// set product list where condition
			if (@$this->data['active_designer'] !== FALSE)
			{
				if ($category_id)
				{
					$where = array(
						'designer.url_structure' => @$this->data['active_designer'],
						'tbl_product.categories LIKE' => $category_id // last segment of category
					);
				}
				else $where = array('designer.url_structure' => @$this->data['active_designer']);
			}
			else $where = array('tbl_product.categories LIKE' => $category_id);
		}

		// get the products list and total count
		$params['show_private'] = TRUE; // all items general public (Y) - N for private
		$params['view_status'] = 'ALL'; // all items view status (Y, Y1, Y2, N)
		$params['view_at_hub'] = TRUE; // all items general public at hub site
		$params['view_at_satellite'] = TRUE; // all items publis at satellite site
		$params['variant_publish'] = 'ALL'; // all items at variant level publish (view status)
		$params['variant_view_at_hub'] = TRUE; // variant level public at hub site
		$params['variant_view_at_satellite'] = TRUE; // varian level public at satellite site
		$params['with_stocks'] = FALSE; // Show all with and without stocks
		$params['group_products'] = FALSE; // group per product number or per variant
		$params['special_sale'] = FALSE; // special sale items only
		$params['pagination'] = @$this->data['page'] ?: '0'; // '0' get all in one query
		$this->load->library('products/products_list', $params);
		$this->data['products'] = $this->products_list->select(
			$where,
			array( // order conditions
				'tbl_product.prod_no'=>'desc',
				'color_name'=>'asc'
			),
			$this->data['limit']
		);
		$this->data['count_all'] = $this->products_list->count_all;
		$this->data['products_count'] = $this->products_list->row_count;

		// get the size names
		if ($this->input->post('search_string'))
		{
			$this->data['size_mode'] = $this->products_list->first_row->size_mode;
			$this->data['size_names'] = $this->size_names->get_size_names($this->data['size_mode']);
		}

		// enable pagination
		$this->_set_pagination($this->data['count_all'], @$this->data['limit']);

		// need to show loading at start
		$this->data['search'] = $this->input->post('search_string');
		$this->data['show_loading'] = TRUE;
		$this->data['inv_prefix'] = 'onorder';

		// set data variables...
		$this->data['file'] = 'inventory';
		$this->data['page_title'] = 'Inventory On-order';
		$this->data['page_description'] = 'Stock Inventory of Items';

		// load views...
		$this->load->view($this->config->slash_item('admin_folder').($this->config->slash_item('admin_template') ?: 'metronic/').'template/template', $this->data);
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

		$uri_string = $this->uri->segment_array();
		if (is_numeric(end($uri_string))) array_pop($uri_string);

		$config['base_url'] = base_url().implode('/',$uri_string).'/';
		$config['total_rows'] = $count_all;
		$config['per_page'] = $per_page;
		$config['num_links'] = 3;
		$config['use_page_numbers'] = TRUE;
		$config['full_tag_open'] = '<ul class="pagination pagination-sm pull-right" style="margin:0;">';
		$config['full_tag_close'] = '</ul>';
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';
		$config['cur_tag_open'] = '<li class="active"><a href="javascript:;">';
		$config['cur_tag_close'] = '</a></li>';
		$config['first_link'] = '<i class="fa fa-angle-double-left"></i>';
		$config['first_url'] = site_url(implode('/',$uri_string));
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
			// tabledit
			$this->data['page_level_plugins'].= '
				<script src="'.base_url().'/assets/custom/jscript/tabledit/jquery-tabledit-1.2.3/jquery.tabledit.min.js" type="text/javascript"></script>
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
				<script src="'.base_url().'assets/custom/js/metronic/pages/scripts/tabledit-inventory.js?z='.time().'" type="text/javascript"></script>
			';
	}

	// ----------------------------------------------------------------------

}
