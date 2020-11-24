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
     * Checks for Facet Query String and Pagination if any
     * If pagination is present, set $num for product list query
     * If query string is present, set for product list query as well
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
				// new facet group, new page
				// let's clear out any pagination from the uri in cases where
				// referring uri is from a page other than 1
				$count_segments = count($this->uri->segment_array());
				if (is_numeric($this->uri->segment($count_segments)))
				{
                    // grab the uri segments
                    $segments_array = $this->uri->segment_array();
                    // remove the numeric segment
                    array_pop($segments_array);
					// redirect user to change the url
					redirect(site_url(implode('/', $segments_array)).'?'.http_build_query($_GET));
				}
				else $this->num = 1;
			}

			// as long as there is $_GET, set flashdata again
			$this->session->set_flashdata('faceting', $get);
		}
		else
		{
			// let's unset session 'faceting'
			$this->session->unset_userdata('faceting');
		}

        // check for pagination from url
        // we are alwasy starting at page 1
        // Default to the last segment number if one hasn't been defined.
        $count_segments = count($this->uri->segment_array());
        if (is_numeric($this->uri->segment($count_segments)))
        {
            $this->num = $this->uri->segment($count_segments);
        }
        else $this->num = 1;

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

        // set $where variable
        $where = array();

        // check for sales package where conditions
        if ($this->sales_package_items)
        {
            // set prod_no clause
            $con_prod_no_ary = '';

            // capture items that uses style no along with prod_no
            $in = 1;
            foreach ($this->sales_package_items as $style_no)
            {
                $exp = explode('_', $style_no);
                // used for Product_list.php class on where clause
                // checking if numerically indexed and set to ->or_where() function
                //array_push($where, $exp[0]);
                // Unfortunately, above array is not suitable due to succeeding where clauses
                // in which case, we separate each item instead

                if ($in == 1)
                {
                    $con_prod_no_ary.= "tbl_product.prod_no LIKE '%".$exp[0]."%' ESCAPE '!'";
                }
                else
                {
                    $con_prod_no_ary.= " OR tbl_product.prod_no LIKE '%".$exp[0]."%' ESCAPE '!'";
                }

                $in++;
            }

            // close condition clause
            //$con_prod_no_ary.= '';
            $where['condition'][] = $con_prod_no_ary;
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

            if ($this->category_id)
            {
                $where['tbl_product.categories LIKE'] = $this->category_id; // last segment of category
            }
        }

        /** *
         *
        show item conditions
        1. wholesale users gets to see everything except on sale items
            a. This is true for Basix items
            b. Not ture for Tempo items
        2. consumer to see items that has stock only
        3. consumer gets to see on sale items
        4. consumer gets to see consumer clearance items (only loggedin this time)
        5. consumer does not see private items
        overrides:
        1. private items only show for help@basixblacklabel.com ws users
        // */
        if (
            $this->session->userdata('user_role') != 'wholesale'
            && @$_GET['availability'] != 'onsale'
        )
        {
            $where_public = "(
				(
                    tbl_product.publish = '1'
                    OR tbl_product.publish = '11'
    				OR tbl_product.publish = '12'
                ) AND (
                    tbl_stock.new_color_publish = '1'
                    OR tbl_stock.new_color_publish = '11'
    				OR tbl_stock.new_color_publish = '12'
                ) AND (
                    tbl_stock.color_publish = 'Y'
                )
			)";
            $where['condition'][] = $where_public;

            /*********
        	 * Current custom conditions for consumers users
        	 */
            // only with stocks as of...
            //$where['HAVING with_stocks'] = '1';
            // show preorder as of 20201124
            // but still implement $695 price barrier
            $where['tbl_product.less_discount >='] = '695'; // alias for retail_price
        }
        else if (
            $this->session->userdata('user_role') == 'wholesale'
            && @$_GET['availability'] == 'onsale'
        )
        {
            // can only show non-basix onsale items
            $where['designer.url_structure !='] = 'basixblacklabel';
        }
        else if ($this->session->userdata('user_role') == 'wholesale')
        {
            // clearance cs only items is not for wholesale users
            $con_clearance_cs_only = 'tbl_stock.options NOT LIKE \'%"clearance_consumer_only":"1"%\' ESCAPE \'!\'';
            $where['condition'][] = $con_clearance_cs_only;

            /*********
        	 * Current custom conditions for wholesale users
        	 */
            // don't show clearance items to wholesale
            $con_clearance = "(tbl_stock.custom_order != '3' OR (tbl_stock.custom_order = '3' AND designer.url_structure != 'basixblacklabel'))";
            $where['condition'][] = $con_clearance;

            // special show private for ws users under help@basixblacklabel.com
            if ($this->wholesale_user_details->admin_sales_email != 'help@basixblacklabel.com')
            {
                $where_public_only = "(
                    (
                        tbl_product.publish = '1'
                        OR tbl_product.publish = '11'
        				OR tbl_product.publish = '12'
                    ) AND (
                        tbl_stock.new_color_publish = '1'
                        OR tbl_stock.new_color_publish = '11'
        				OR tbl_stock.new_color_publish = '12'
                    )
    			)";
                $where['condition'][] = $where_public_only;
            }
        }
        else if (
            $this->session->userdata('user_role') == 'consumer'
            && @$_GET['availability'] != 'onsale'
        )
        {
            $where_public = "(
                (
                    tbl_product.publish = '1'
                    OR tbl_product.publish = '11'
    				OR tbl_product.publish = '12'
                ) AND (
                    tbl_stock.new_color_publish = '1'
                    OR tbl_stock.new_color_publish = '11'
    				OR tbl_stock.new_color_publish = '12'
                ) AND (
                    tbl_stock.color_publish = 'Y'
                )
			)";
            $where['condition'][] = $where_public;

            /*********
        	 * Current custom conditions for consumers users
        	 */
            // only with stocks as of...
            //$where['HAVING with_stocks'] = '1';
            // show preorder as of 20201124
            // but still implement $695 price barrier
            $where['tbl_product.less_discount >='] = '695'; // alias for retail_price
        }

        // clearance_cs_only option
        // must show as a normal item
        //$con_clearance_cs_only = 'tbl_stock.options NOT LIKE \'%"clearance_consumer_only":"1"%\' ESCAPE \'!\'';
        //$where['condition'][] = $con_clearance_cs_only;

		// get the products list and total count based on parameters
        $params['private'] = FALSE;
		$params['wholesale'] = $this->session->userdata('user_role') == 'wholesale' ? TRUE : FALSE;
        // list all variants
        $params['group_products'] = FALSE;
		// show items with stocks only
        // NOTE: this also depends on 'group_products' params
        // if group products, must always be false to show primary color only
        // can only change the 'if no't result
		$params['with_stocks'] = $params['group_products'] ? FALSE : FALSE;
		// set facet searching if needed
		$params['facets'] = @$_GET ?: array();
		// user random listing for frontend 'all'/'womens_apparel' url segments
		$params['random_seed'] =
			(
				$this->uri->segment(2) == 'all'
				OR $this->uri->segment(2) == 'womens_apparel'
			)
			? TRUE
			: FALSE
		;
        // set pagination condition
		$params['pagination'] = $this->num;
        // initialize and get product list
		$this->load->library('products/products_list', $params);
		$this->products = $this->products_list->select(
			// where conditions
            $where,
			// sorting conditions
			(
                $sort_by ?:
                array(
                    'seque'=>'asc',
                    'tbl_product.prod_no' => 'desc'
                )
            ),
            // limits
			($this->session->view_list_number ?: '')
		);
		$product_count = $this->products_list->count_all;

        //echo $this->products_list->last_query; die();

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
        // tempoparis is a stand along wholesale site
        // we need to apply same conditions for tempo items at shop7
        // and not show tempo items in general pages
        // only when user is logged in
        if ($this->d_url_structure == '')
        {
            $wwhere['designer.url_structure <>'] = 'tempoparis';
        }
        else $wwhere['designer.url_structure'] = $this->d_url_structure;

        /** *
         *
        show item conditions
        1. wholesale users gets to see everything except on sale items
            a. This is true for Basix items
            b. Not ture for Tempo items
        2. consumer to see items that has stock only
        3. consumer gets to see on sale items
        4. consumer gets to see consumer clearance items (only loggedin this time)
        5. consumer does not see private items
        overrides:
        1. private items only show for help@basixblacklabel.com ws users
        // */
        if (
            $this->session->userdata('user_role') != 'wholesale'
            && @$_GET['availability'] != 'onsale'
        )
        {
            $wwhere_public = "(
				tbl_product.publish = '1'
				OR tbl_product.publish = '11'
				OR tbl_product.publish = '12'
			)";
            $wwhere['condition'][] = $wwhere_public;

            /*********
        	 * Current custom conditions for consumers users
        	 */
            // only with stocks as of...
            $wwhere['HAVING with_stocks'] = '1';
        }
        else if (
            $this->session->userdata('user_role') == 'wholesale'
            && @$_GET['availability'] == 'onsale'
        )
        {
            // can only show non-basix onsale items
            $wwhere['designer.url_structure !='] = 'basixblacklabel';
        }
        else if ($this->session->userdata('user_role') == 'wholesale')
        {
            // clearance cs only items is not for wholesale users
            $ccon_clearance_cs_only = 'tbl_stock.options NOT LIKE \'%"clearance_consumer_only":"1"%\' ESCAPE \'!\'';
            $wwhere['condition'][] = $ccon_clearance_cs_only;

            /*********
        	 * Current custom conditions for wholesale users
        	 */
            // don't show clearance items to wholesale
            $ccon_clearance = "(tbl_stock.custom_order != '3' OR (tbl_stock.custom_order = '3' AND designer.url_structure != 'basixblacklabel'))";
            $wwhere['condition'][] = $ccon_clearance;

            // special show private for ws users under help@basixblacklabel.com
            if ($this->wholesale_user_details->admin_sales_email != 'help@basixblacklabel.com')
            {
                $wwhere_public_only = "(
    				tbl_product.publish = '1'
    				OR tbl_product.publish = '11'
    				OR tbl_product.publish = '12'
    			)";
                $wwhere['condition'][] = $wwhere_public_only;
            }
        }
        else if (
            $this->session->userdata('user_role') == 'consumer'
            && @$_GET['availability'] != 'onsale'
        )
        {
            $wwhere_public = "(
				tbl_product.publish = '1'
				OR tbl_product.publish = '11'
				OR tbl_product.publish = '12'
			)";
            $wwhere['condition'][] = $wwhere_public;

            /*********
        	 * Current custom conditions for consumers users
        	 */
            // only with stocks as of...
            $wwhere['HAVING with_stocks'] = '1';
        }

        // get the products list and total count based on parameters
		$pparams['wholesale'] = $this->session->userdata('user_role') == 'wholesale' ? TRUE : FALSE;
        // list main color variant only
        $pparams['group_products'] = TRUE;
		// show items with stocks only
        // NOTE: this also depends on 'group_products' params
		$pparams['with_stocks'] = $pparams['group_products'] ? FALSE : TRUE;
		// set facet searching if needed
		$pparams['facets'] = @$_GET ?: array();
		// user random listing for frontend 'all'/'womens_apparel' url segments
		$pparams['random_seed'] =
			(
				$this->uri->segment(2) == 'all'
				OR $this->uri->segment(2) == 'womens_apparel'
			)
			? TRUE
			: FALSE
		;
        // set pagination condition
		$pparams['pagination'] = $this->num;

        // get products
		$this->products_list->initialize($pparams);
		$this->suggested_products = $this->products_list->select(
			// where conditions
            $wwhere,
			// sorting conditions
			array(),
			($this->session->view_list_number ?: '')
		);
		$product_count = $this->products_list->count_all;

        //echo $this->products_list->last_query; die();

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

        // remove page segment and capture uri string
		$uri_segments = explode('/', $this->uri->uri_string());
        if (is_numeric(end($uri_segments))) array_pop($uri_segments);

        // set get strings if nay
        if (@$_GET)
		{
			// remove empty $_GET array elements
			$_GET = array_filter($_GET, function($value) { return $value !== ''; });

			foreach ($_GET as $key => $val)
			{
				$this->filter_items_count += count(explode(',', $_GET[$key]));
			}

			$get = '?'.http_build_query($_GET);
        }
        else $get = '';

		$config['base_url'] 				= base_url(implode('/', $uri_segments)).'/';

		$config['total_rows'] 				= $product_count;
		$config['per_page'] 				= @$this->webspace_details->options['items_per_page'] ?: 99;

		$config['num_links'] 				= 4;
		$config['use_page_numbers'] 		= TRUE;
		$config['reuse_query_string'] 		= TRUE;
		$config['use_global_url_suffix'] 	= TRUE;

        /**********
         * New pagination (used for mobile and desktop)
         */
        $config['full_tag_open'] = '<ul class="pagination pagination-sm thumbs-pagination-mobile" style="margin:0;">';
		$config['full_tag_close'] = '</ul>';
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';
		$config['cur_tag_open'] = '<li class="active"><a href="javascript:;">';
		$config['cur_tag_close'] = '</a></li>';
		$config['first_link'] = '<i class="fa fa-angle-double-left"></i>';
		$config['first_url'] = site_url(implode('/', $uri_segments)).$get;
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

        /**********
         * Old pagination
         *
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
        // */

		$this->pagination->initialize($config);
	}

	// --------------------------------------------------------------------

}
