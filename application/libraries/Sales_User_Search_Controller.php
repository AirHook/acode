<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sales_User_Search_Controller extends Sales_user_Controller {

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
		//$this->load->library('products/product_details');

		// get the designer slug
		// helps filter the top nav for non-hub sites
		// helps filter the side nav on browse by designer
		// if not hub sites, we use the webspace slug
		$this->d_url_structure =
			(
				$this->webspace_details->options['site_type'] == 'sat_site'
				OR $this->webspace_details->options['site_type'] == 'sal_site'
			)
			? (
				$this->webspace_details->slug == 'basix-black-label'
				? 'basixblacklabel'
				: $this->webspace_details->slug
			)
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

		// get the products list and total count based on parameters
        $params['show_private'] = 'ALL';
        $params['view_status'] = 'ALL';
        $params['variant_publish'] = 'ALL';
		// show items even without stocks at all
		$params['with_stocks'] = FALSE;
		$params['group_products'] = FALSE;
		// others
		$params['pagination'] = $this->num;
		$this->load->library('products/products_list', $params);
		$this->products = $this->products_list->select(
			array( // where conditions
				'tbl_product.prod_no' => $search_string,
				'tbl_product.prod_name' => $search_string,
				'tbl_product.prod_desc' => $search_string,
				//'tbl_product.colors' => $search_string,
				//'tbl_product.colornames' => $search_string,
				'tbl_product.materials' => $search_string,
				'tbl_product.trends' => $search_string,
				'tbl_product.events' => $search_string,
				'tbl_product.styles' => $search_string,
				'c1.category_slug' => $search_string,
				'c2.category_slug' => $search_string,
				'tbl_stock.color_name' => $search_string,
				'tbl_stock.color_facets' => $search_string,
				'designer.url_structure' => (
					$this->webspace_details->options['site_type'] == 'hub_site'
					? $search_string
					: $this->d_url_structure
				)
			),
			array( // order conditions
				'seque'=>'asc'
			),
			0,
			'SEARCH'
		);
		$product_count = $this->products_list->count_all;

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
