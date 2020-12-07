<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Search_Controller extends Frontend_Controller {

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
	 * Num - Property
	 *
	 * For pagination purposes on product thubms
	 *
	 * @return	int
	 */
    public $num = 0;

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
		$this->load->library('products/product_details');

		// get the designer slug
		// helps filter the top nav for non-hub sites
		// helps filter the side nav on browse by designer
		// if not hub sites, we use the webspace slug
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
	 * Grab the product list to poppulate the thumbs pages
	 *
	 * @access	public
	 * @return	object
	 */
	public function search_products($search_string = NULL)
	{
		if ( ! $search_string)
		{
			// nothing more to do...
			return FALSE;
		}

        // set $where conditions
        $where['tbl_product.prod_no'] = $search_string;
        $where['tbl_product.prod_name'] = $search_string;
        $where['tbl_product.prod_desc'] = $search_string;
        //$where['tbl_product.colors'] = $search_string;
        //$where['tbl_product.colornames'] = $search_string;
        $where['tbl_product.materials'] = $search_string;
        $where['tbl_product.trends'] = $search_string;
        $where['tbl_product.events'] = $search_string;
        $where['tbl_product.styles'] = $search_string;
        $where['c1.category_slug'] = $search_string;
        $where['c2.category_slug'] = $search_string;
        $where['tbl_stock.color_name'] = $search_string;
        $where['tbl_stock.color_facets'] = $search_string;
        $where['designer.url_structure'] =
            $this->webspace_details->options['site_type'] == 'hub_site'
            ? $search_string
            : $this->d_url_structure
        ;

        // some show item conditions
        // 1. wholesale users gets to see everything except on sale items
        //      a. This is true for Basix
        //      b. Not ture for Tempo
        // 2. consumer to see items that has stock only
        // 3. consumer gets to see on sale items
        /* */
        if (
            $this->session->userdata('user_role') == 'wholesale'
            && @$_GET['availability'] == 'onsale'
        )
        {
            // can only show non-basix items
            $where['designer.url_structure !='] = 'basixblacklabel';
        }
        else if ($this->session->userdata('user_role') == 'wholesale')
        {
            // don't show clearance cs only items
            $con_clearance_cs_only = 'tbl_stock.options NOT LIKE \'%"clearance_consumer_only":"1"%\' ESCAPE \'!\'';
            $where['condition'][] = $con_clearance_cs_only;

            /*********
        	 * Current custom conditions for wholesale users
        	 */
            // don't show clearance items
            $con_clearance = "(tbl_stock.custom_order != '3' OR (tbl_stock.custom_order = '3' AND designer.url_structure != 'basixblacklabel'))";
            $where['condition'][] = $con_clearance;

            // special show private for ws users under help@basixblacklabel.com
            if ($this->wholesale_user_details->admin_sales_email != 'help@basixblacklabel.com')
            {
                $where_public_only = "(
    				tbl_product.publish = '1'
    				OR tbl_product.publish = '11'
    				OR tbl_product.publish = '12'
    			)";
                $where['condition'][] = $where_public_only;
            }
        }
        else if (
            $this->session->userdata('user_role') != 'wholesale'
            && @$_GET['availability'] != 'onsale'
        )
        {
            $where_public = "(
				tbl_product.publish = '1'
				OR tbl_product.publish = '11'
				OR tbl_product.publish = '12'
			)";
            $where['condition'][] = $where_public;

            $where_variant_public = "(
				tbl_stock.new_color_publish = '1'
				OR tbl_stock.new_color_publish = '11'
				OR tbl_stock.new_color_publish = '12'
			)";
            $where['condition'][] = $where_variant_public;

            /*********
        	 * Current custom conditions for consumers users
        	 */
            // only with stocks as of...
            //$where['HAVING with_stocks'] = '1';
            // show preorder as of 20201124
            // but still implement $695 price barrier
            $with_stocks_and_high_priced_preorder = "(
                ((tbl_product.size_mode = '1'
                    AND (tsav.size_0 > '0'
                        OR tsav.size_2 > '0'
                        OR tsav.size_4 > '0'
                        OR tsav.size_6 > '0'
                        OR tsav.size_8 > '0'
                        OR tsav.size_10 > '0'
                        OR tsav.size_12 > '0'
                        OR tsav.size_14 > '0'
                        OR tsav.size_16 > '0'
                        OR tsav.size_18 > '0'
                        OR tsav.size_20 > '0'
                        OR tsav.size_22 > '0'))
                OR (tbl_product.size_mode = '0'
                    AND (tsav.size_sxs > '0'
                        OR tsav.size_ss > '0'
                        OR tsav.size_sm > '0'
                        OR tsav.size_sl > '0'
                        OR tsav.size_sxl > '0'
                        OR tsav.size_sxxl > '0'
                        OR tsav.size_sxl1 > '0'
                        OR tsav.size_sxl2 > '0'))
                OR (tbl_product.size_mode = '2' AND (tsav.size_sprepack1221 > '0'))
                OR (tbl_product.size_mode = '3' AND (tsav.size_ssm > '0' AND tsav.size_sml > '0'))
                OR (tbl_product.size_mode = '4' AND (tsav.size_sonesizefitsall > '0')))
                OR (
                    ((tbl_product.size_mode = '1'
                        AND (tsav.size_0 = '0'
                            OR tsav.size_2 = '0'
                            OR tsav.size_4 = '0'
                            OR tsav.size_6 = '0'
                            OR tsav.size_8 = '0'
                            OR tsav.size_10 = '0'
                            OR tsav.size_12 = '0'
                            OR tsav.size_14 = '0'
                            OR tsav.size_16 = '0'
                            OR tsav.size_18 = '0'
                            OR tsav.size_20 = '0'
                            OR tsav.size_22 = '0'))
                    OR (tbl_product.size_mode = '0'
                        AND (tsav.size_sxs = '0'
                            OR tsav.size_ss = '0'
                            OR tsav.size_sm = '0'
                            OR tsav.size_sl = '0'
                            OR tsav.size_sxl = '0'
                            OR tsav.size_sxxl = '0'
                            OR tsav.size_sxl1 = '0'
                            OR tsav.size_sxl2 = '0'))
                    OR (tbl_product.size_mode = '2' AND (tsav.size_sprepack1221 = '0'))
                    OR (tbl_product.size_mode = '3' AND (tsav.size_ssm > '0' AND tsav.size_sml = '0'))
                    OR (tbl_product.size_mode = '4' AND (tsav.size_sonesizefitsall = '0')))
                    AND tbl_product.less_discount >= '695'
                )
			)";
            $where['condition'][] = $with_stocks_and_high_priced_preorder;
        }
        // */

        // clearance_cs_only option
        // must show as a normal item
        //$con_clearance_cs_only = 'tbl_stock.options NOT LIKE \'%"clearance_consumer_only":"1"%\' ESCAPE \'!\'';
        //$where['condition'][] = $con_clearance_cs_only;

		// get the products list and total count based on parameters
		$params['wholesale'] = $this->session->userdata('user_cat') == 'wholesale' ? TRUE : FALSE;
		$params['show_private'] = $this->session->userdata('user_cat') == 'wholesale' ? TRUE : FALSE;
		if ($this->webspace_details->options['site_type'] != 'hub_site') $params['view_at_hub'] = FALSE;
		if ($this->webspace_details->options['site_type'] == 'hub_site') $params['view_at_satellite'] = FALSE;
		// show items even without stocks at all
        $params['group_products'] = FALSE;
		$params['with_stocks'] = $params['group_products'] ? FALSE : FALSE;
		// others
		$params['pagination'] = $this->num ?: TRUE;
		$this->load->library('products/products_list', $params);
		$this->products = $this->products_list->select(
            // where conditions
            $where,
            // sorting conditions
			array(
				//'seque'=>'asc'
			),
            // limits
			0,
            // search switch
			'SEARCH'
		);
		$product_count = $this->products_list->count_all;

        //echo $this->products_list->last_query; die();

		// using the same parameters, initialize facets
		$params['d_url_structure'] = $this->d_url_structure;

		// set product items grouped as one primary image
		$this->data['grouped_products'] = FALSE;

		// Include the pagination class
		//$this->_include_pagination($product_count);
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

		if ($this->webspace_details->options['theme'] === 'roden2')
		{
			switch ($this->webspace_details->slug)
			{
				case 'instylenewyork':
				case 'basix-black-label':
				case 'basixprom':
				case 'junnieleigh':
				case 'chaarmfurs':
				case 'shop7thavenue':
				case 'inssueny':
				case 'storybookknits':
				case 'andrewoutfitter':
				case 'salesuser':
					$color = '#846921';	// --> goldish
				break;

				case 'tempoparis':
					$color = '#707070';	// --> darkgray
				break;

				default:
					$color = '#e0b2aa';	// --> pink (roden original)
			}

			$config['base_url'] 				=
				$this->uri->uri_string() == 'shop/all'
				? base_url('shop/all').'/'
				: (
					$this->browse_by == 'categories'
					? base_url($this->uri->segment(1).'/'.$this->uri->segment(2)).'/'
					: base_url($this->uri->segment(1).'/'.$this->uri->segment(2).'/'.$this->uri->segment(3)).'/'
				)
			;
			$config['total_rows'] 				= $product_count;
			$config['per_page'] 				= @$this->webspace_details->options['items_per_page'] ?: 99;
			$config['num_links'] 				= 4;
			$config['use_page_numbers'] 		= TRUE;
			$config['reuse_query_string'] 		= TRUE;
			$config['use_global_url_suffix'] 	= TRUE;
			$config['full_tag_open'] 			= '<ul class="pagination">';
			$config['full_tag_close'] 			= '</ul>';

			$config['first_link'] 				= FALSE;
			$config['first_tag_open'] 			= '<li class="txt hidden-on-mobile" title="First of '.ceil($product_count/$config['per_page']).'" style="margin-right:15px;"><span class="ico"></span>';
			$config['first_tag_close'] 			= '</li>';

			$config['last_link'] 				= FALSE;
			$config['last_tag_open'] 			= '<li class="txt hidden-on-mobile" title="Last of '.ceil($product_count/$config['per_page']).'" style="margin-left:15px;"><span class="ico"></span>';
			$config['last_tag_close'] 			= ' &nbsp; of &nbsp; '.ceil($product_count/$config['per_page']).'</li>';

			$config['cur_tag_open'] 			= '<li class="txt current prev" style="background-color:'.$color.';"><span class="txt"><a href="javascript:void(0);" style="text-decoration:none;color:white;">';
			$config['cur_tag_close'] 			= '</a></span></li>';
			$config['num_tag_open'] 			= '<li class="txt pages prev"><span class="ico"></span>';
			$config['num_tag_close'] 			= '</li>';

			$config['prev_link'] 				= '<i class="fa fa-caret-left"></i><span class="visually-hidden">&laquo; Previous</span>';
			$config['prev_tag_open'] 			= '<li class="txt pages prev" title="Previous" style="margin-right:10px;">';
			$config['prev_tag_close'] 			= '</li>';
			$config['next_link'] 				= '<i class="fa fa-caret-right"></i><span class="visually-hidden">Next &raquo;</span>';
			$config['next_tag_open'] 			= '<li class="txt pages next" title="Next" style="margin-left:0px;margin-right:5px;">';
			$config['next_tag_close']			= '</li>';
		}
		else
		{
			// this pagination config is for depracated "Default" theme
			// this has not yet been changed since
			$config['base_url'] 				= base_url($this->uri->segment(1).'/'.$this->uri->segment(2)).'/';
			$config['total_rows'] 				= $product_count;
			$config['per_page'] 				= @$this->webspace_details->options[''] ?: 99;
			$config['num_links'] 				= 3;
			$config['first_link'] 				= false;
			$config['last_link'] 				= false;
			$config['full_tag_open']			= '<div class="pagination">';
			$config['full_tag_close'] 			= '</div>';
			$config['cur_tag_open'] 			= '<span class="current" style="background:#AA0000;">';
			$config['cur_tag_close'] 			= '</span>';
			$config['prev_link'] 				= '&laquo; previous';
			$config['next_link'] 				= 'next &raquo;';
		}

		$this->pagination->initialize($config);
	}

	// --------------------------------------------------------------------

}
