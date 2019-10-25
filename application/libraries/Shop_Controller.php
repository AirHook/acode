<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Shop_Controller extends Frontend_Controller {

	/**
	 * Designer/Subcategory Url - Property
	 *
	 * Holds the designer/subcat specific url info for use on different
	 * data queries and equations. This is when the website is
	 * designer based (satellite or stand alone sites), and, when
	 * browsing by designer thumbs products
	 *
	 * @return	string
	 */
    public $d_url_structure = '';
    public $sc_url_structure = '';
    public $category_id = '';

	/**
	 * Sales package items
	 *
	 * For wholesale users landing on sales package offers
	 *
	 * @return	int
	 */
    public $sales_package_items = '';

    /**
	 * Num - Property
	 *
	 * For pagination purposes on product thubms
	 *
	 * @return	int
	 */
    public $num = 0;

	/**
	 * Filter properties
	 *
	 * @return	various
	 */
    public $filter_items_count = 0;

	/**
	 * Sort By - thumbs sorting
	 *
	 *		default			- by seque field
	 *		newest			- by recently uploaded products
	 *		price			- 'low-high'/'high-low' per se
	 *		on_sale			- on sale or clearance items
	 *		featured		- not yet available
	 *		best_sellers	- not yet available
	 *		top_rated		- not yet available
	 *
	 * @return	various
	 */
    public $sort_by = 'default';

	/**
	 * Misc... Properties
	 *
	 * @return	various
	 */
    public $browse_by = '';		// determines whether thumbs page is browse by general categories or by designer
	public $products = '';		// object that hold the product list after query


	/**
	 * Core Controller for Shop things of the frontend
	 *
	 * @return	void
	 */
	public function __construct()
	{
		parent::__construct();

		// load pertinent library/model/helpers
		$this->load->library('user_agent');
		$this->load->model('thumbs_footer_text_model');
		$this->load->library('products/product_details');

		// get the designer slug
		// helps filter the top nav for non-hub sites (roden)
		// helps filter the side nav on browse by designer (roden)
		// if not hub sites, we use the webspace slug
		// helps filter the products
		$this->d_url_structure =
			(
				$this->webspace_details->options['site_type'] == 'sat_site'
				OR $this->webspace_details->options['site_type'] == 'sal_site'
			)
			? $this->webspace_details->slug
			: '';
    }

	// --------------------------------------------------------------------

	/**
	 * Check Facet Query String Method
	 *
	 * @return	object
	 */
	public function check_facet_query_string()
	{
		if (@$_GET)
		{
			// remove empty $_GET array elements
			$_GET = array_filter($_GET, function($value) { return $value !== ''; });

			foreach ($_GET as $key => $val)
			{
				$this->filter_items_count += count(explode(',', $_GET[$key]));
			}

			$get = http_build_query($_GET);

			// get pagination number where it should be
			// and set corresponding page number for pagination
			if (
				$this->session->flashdata('faceting')
				&& $this->session->flashdata('faceting') == $get
			)
			{
				// same group and check for pagination
				// check for pagination from url
				// we are always starting at page 1
				// Default to the last segment number if one hasn't been defined.
				$count_segments = count($this->uri->segment_array());
				if (is_numeric($this->uri->segment($count_segments)))
				{
					$this->num = $this->uri->segment($count_segments);
				}
				else $this->num = 1;
			}
			else
			{
				// new group, new page
				// let's clear out any pagination from the uri in cases where
				// referring uri is from a page other than 1
				$count_segments = count($this->uri->segment_array());
				if (is_numeric($this->uri->segment($count_segments)))
				{
					// redirect user to change the url
					redirect(site_url($this->uri->uri_string()).'?'.http_build_query($_GET));
				}
				else $this->num = 1;
			}

			// as long as there is $_GET, set flashdata again
			$this->session->set_flashdata('faceting', $get);
		}
		else
		{
			// check for pagination from url
			// we are alwasy starting at page 1
			// Default to the last segment number if one hasn't been defined.
			$count_segments = count($this->uri->segment_array());
			if (is_numeric($this->uri->segment($count_segments)))
			{
				$this->num = $this->uri->segment($count_segments);
			}
			else $this->num = 1;

			// let's unset session 'faceting'
			$this->session->unset_userdata('faceting');
		}

		return $this;
	}

	// --------------------------------------------------------------------

	/**
	 * Grab the product list to poppulate the thumbs pages
	 *
	 * @access	public
	 * @return	object
	 */
	public function get_products()
	{
		// soring conditions
		switch($this->sort_by)
		{
			case 'featured':
				$sort_by = array('seque'=>'desc');
			break;
			case 'best_sellers':
				$sort_by = array('seque'=>'desc');
			break;
			case 'top_rated':
				$sort_by = array('seque'=>'desc');
			break;
			case 'newest':
				$sort_by = array('prod_date'=>'desc', 'prod_id'=>'desc');
			break;
			case 'low-high':
				$sort_by = '';
				$_GET['price'] = 'asc';
			break;
			case 'high-low':
				$sort_by = '';
				$_GET['price'] = 'desc';
			break;
			case 'onsale':
				$sort_by = array('tbl_stock.custom_order'=>'desc');
			break;
			default:
				$sort_by = array('seque'=>'asc', 'tbl_product.prod_no' => 'desc');
		}

        // check for sales package where conditions
        if ($this->sales_package_items)
        {
            $where = array();

            // capture items that uses style no along with prod_no
            foreach ($this->sales_package_items as $style_no)
            {
                $exp = explode('_', $style_no);
                array_push($where, $exp[0]);
            }
        }
        else
        {
            // tempoparis is a stand along wholesale site
            // we need to apply same conditions for tempo items at shop7
            // and not show tempo items in general pages
            // only when user is logged in
            if ($this->d_url_structure == '')
            {
                $where['designer.url_structure <>'] = 'tempoparis';
            }
            else $where['designer.url_structure'] = $this->d_url_structure;
            $where['tbl_product.categories LIKE'] = $this->category_id; // last segment of category
        }

        // show item conditions
        // 1. wholesale users gets to see everything except on sale items
        // 2. consumer to see items that has stock only
        // 5. consumer gets to see on sale items
        if (
            $this->session->userdata('user_cat') != 'wholesale'
            OR @$_GET['availability'] != 'onsale'
        )
        {
            // commenting this custom where clause for future use...
            //$condition = "(less_discount >= 695 OR (less_discount < 695 AND (tbl_product.size_mode = '1' AND (tbl_stock.size_0 > '0' OR tbl_stock.size_2 > '0' OR tbl_stock.size_4 > '0' OR tbl_stock.size_6 > '0' OR tbl_stock.size_8 > '0' OR tbl_stock.size_10 > '0' OR tbl_stock.size_12 > '0' OR tbl_stock.size_14 > '0' OR tbl_stock.size_16 > '0' OR tbl_stock.size_18 > '0' OR tbl_stock.size_20 > '0' OR tbl_stock.size_22 > '0') OR tbl_product.size_mode = '0' AND (tbl_stock.size_ss > '0' OR tbl_stock.size_sm > '0' OR tbl_stock.size_sl > '0' OR tbl_stock.size_sxl > '0' OR tbl_stock.size_sxxl > '0' OR tbl_stock.size_sxl1 > '0' OR tbl_stock.size_sxl2 > '0'))))";
            //$where['condition'] = $condition;

            $where['HAVING with_stocks'] = '1';
        }
        if (
            $this->session->userdata('user_cat') == 'wholesale'
            && @$_GET['availability'] == 'onsale'
        )
        {
            // setting condition to prod_id = '0' make query result to zero
            $where['tbl_product.prod_id'] = '0';
        }

		// get the products list and total count based on parameters
		$params['wholesale'] = $this->session->userdata('user_cat') == 'wholesale' ? TRUE : FALSE;
		$params['show_private'] = $this->session->userdata('user_cat') == 'wholesale' ? TRUE : FALSE;
		if ($this->webspace_details->options['site_type'] != 'hub_site') $params['view_at_hub'] = FALSE;
		if ($this->webspace_details->options['site_type'] == 'hub_site') $params['view_at_satellite'] = FALSE;
		// show items even without stocks at all
		$params['with_stocks'] = FALSE;
		$params['group_products'] = FALSE;
		// set facet searching if needed
		$params['facets'] = @$_GET ?: array();
		// others
		$params['random_seed'] =
			(
				$this->uri->segment(2) == 'all'
				OR $this->uri->segment(2) == 'womens_apparel'
			)
			? TRUE
			: FALSE
		;
		$params['random_seed'] = FALSE;
		$params['pagination'] = $this->num;
		$this->load->library('products/products_list', $params);
		$this->products = $this->products_list->select(
			// where conditions
            $where,
			// sorting conditions
			($sort_by ?: array('seque'=>'asc', 'tbl_product.prod_no' => 'desc')),
            // limits
			($this->session->view_list_number ?: '')
		);
		$product_count = $this->products_list->count_all;

		// using the same parameters, initialize facets
		$params['d_url_structure'] = $this->d_url_structure;
		$params['c1_url_structure'] = $this->uri->segment(2) == 'all' ? '' : 'apparel';
		$params['c2_url_structure'] = $this->sc_url_structure ?: '';
		$params['category_id'] = $this->category_id ?: '1'; // the default 1 is for all womens apparel
		$this->load->library('facets', $params);
		$this->load->helper('facets');

		// some pre calculations for filter dropdowns/tags
		$this->data['size_array'] = extract_facets($this->facets->get('size'), 'size');
		$this->data['color_array'] = extract_facets($this->facets->get('color_facets'), 'color_facets');
		$this->data['occassion_array'] = extract_facets($this->facets->get('events'), 'events');
		$this->data['styles_array'] = extract_facets($this->facets->get('styles'), 'styles');
		$this->data['materials_array'] = extract_facets($this->facets->get('materials'), 'materials');
        $this->data['seasons_array'] = extract_facets($this->facets->get('seasons'), 'seasons');

		// finally, get product items grouped as one primary image
		$this->data['grouped_products'] = $params['group_products'];

		// Include the pagination class
		$this->_include_pagination($product_count);
	}

	// --------------------------------------------------------------------

	/**
	 * Grab the product list to poppulate the thumbs pages
	 *
	 * @access	public
	 * @return	object
	 */
	public function get_suggested_products()
	{
		// get the products list and total count based on parameters
		$pparams['wholesale'] = $this->session->userdata('user_cat') == 'wholesale' ? TRUE : FALSE;
		$pparams['show_private'] = $this->session->userdata('user_cat') == 'wholesale' ? TRUE : FALSE;
		if ($this->webspace_details->options['site_type'] != 'hub_site') $pparams['view_at_hub'] = FALSE;
		if ($this->webspace_details->options['site_type'] == 'hub_site') $pparams['view_at_satellite'] = FALSE;
		// show items even without stocks at all
		$pparams['with_stocks'] = FALSE;
		$pparams['group_products'] = TRUE;
		// clear facets
		$pparams['facets'] = array();
		// others
		$pparams['special_sale'] = FALSE;
		$pparams['random_seed'] = TRUE;
		$pparams['pagination'] = $this->num;
		$this->products_list->initialize($pparams);
		$this->suggested_products = $this->products_list->select(
			// where conditions
			array(
				'designer.url_structure' => $this->d_url_structure
			),
			// sorting conditions
			array(),
			($this->session->view_list_number ?: '')
		);
		$product_count = $this->products_list->count_all;

		// finally, get product items grouped as one primary image
		$this->data['grouped_products'] = TRUE;

		// Include the pagination class
		$this->_include_pagination($product_count);
	}

	// --------------------------------------------------------------------

	/**
	 * Generate the pagiantion config items (common to all product thumbs list)
	 *
	 * @access	private
	 * @params	string
	 * @return	string
	 */
	private function _include_pagination($product_count)
	{
		// Prep pagination for the page along with the set style
		$this->load->library('pagination');

		$uri_segments = explode('/', $this->uri->uri_string());
		if (is_numeric($uri_segments[count($uri_segments) - 1]))
		{
			array_pop($uri_segments);
		}

		$config['base_url'] 				= base_url(implode('/', $uri_segments)).'/';

		$config['total_rows'] 				= $product_count;
		$config['per_page'] 				= @$this->webspace_details->options['items_per_page'] ?: 99;

		$config['num_links'] 				= 4;
		$config['use_page_numbers'] 		= TRUE;
		$config['reuse_query_string'] 		= TRUE;
		$config['use_global_url_suffix'] 	= TRUE;

		$config['full_tag_open'] 			= '<ul class="list-inline thumbs-pagintaion-ci" style="display:inline-block;">';
		$config['full_tag_close'] 			= '</ul>';

		$config['first_link'] 				= FALSE;
		$config['first_tag_open'] 			= '<li>';
		$config['first_tag_close'] 			= '</li>';

		$config['last_link'] 				= FALSE;
		$config['last_tag_open'] 			= '<li>';
		$config['last_tag_close'] 			= '</li>';

		$config['cur_tag_open'] 			= '<li class="active">';
		$config['cur_tag_close'] 			= '</li>';
		$config['num_tag_open'] 			= '<li>';
		$config['num_tag_close'] 			= '</li>';

		$config['prev_link'] 				= '&lt;';
		$config['prev_tag_open'] 			= '<li>';
		$config['prev_tag_close'] 			= '</li>';
		$config['next_link'] 				= '&gt;';
		$config['next_tag_open'] 			= '<li>';
		$config['next_tag_close']			= '</li>';

		$this->pagination->initialize($config);
	}

	// --------------------------------------------------------------------

}
