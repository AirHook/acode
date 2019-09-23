<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/****************
 * Back end search engine for suggestions to searhc input boxes
 *
 * @return	json
 */
class Suggestions extends Frontend_Controller
{
	/**
	 * Designer Url - Property
	 *
	 * @return	string
	 */
    public $d_url_structure = '';

	/**
	 * Search String
	 *
	 * @return	string
	 */
	public $search_string = '';

	/**
	 * DB Object
	 *
	 * @return	object
	 */
	protected $DB;


	/**
	 * Constructor
	 *
	 * @return	void
	 */
	function __Construct()
	{
		parent::__Construct();

		// connect to database for use by model
		$this->DB = $this->load->database('instyle', TRUE);

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
	 * Primary method - index
	 *
	 * @return	void
	 */
	function index($search_string)
	{
		$this->search_string = $search_string;

		$results = array();

		if ($this->search_string)
		{
			// get the products list and total count based on parameters
			$params['wholesale'] = $this->session->userdata('user_cat') == 'wholesale' ? TRUE : FALSE;
			$params['show_private'] = $this->session->userdata('user_cat') == 'wholesale' ? TRUE : FALSE;
			if ($this->webspace_details->options['site_type'] != 'hub_site') $params['view_at_hub'] = FALSE;
			if ($this->webspace_details->options['site_type'] == 'hub_site') $params['view_at_satellite'] = FALSE;
			// show items even without stocks at all
			$params['with_stocks'] = FALSE;
			$params['group_products'] = TRUE;
			// go and search
			$this->load->library('products/products_list_search', $params);
			$products = $this->products_list_search->select(
				array( // where conditions
					'tbl_product.prod_no' => $this->search_string,
					'tbl_product.prod_name' => $this->search_string,
					'tbl_product.prod_desc' => $this->search_string,
					'tbl_product.colors' => $this->search_string,
					'tbl_product.colornames' => $this->search_string,
					'tbl_product.materials' => $this->search_string,
					'tbl_product.trends' => $this->search_string,
					'tbl_product.events' => $this->search_string,
					'tbl_product.styles' => $this->search_string,
					'c1.category_slug' => $this->search_string,
					'c2.category_slug' => $this->search_string,
					'tbl_stock.color_name' => $this->search_string,
					'tbl_stock.color_facets' => $this->search_string,
					'designer.url_structure' => (
						$this->webspace_details->options['site_type'] == 'hub_site'
						? $this->search_string
						: $this->d_url_structure
					)
				),
				array( // order conditions
					'seque'=>'asc'
				),
				0,
				'SEARCH'
			);

			// filter the array of elements that does not have the search_string
			function array_filter_by_search_string($v)
			{
				$CI =& get_instance();
				if (stripos($v, $CI->search_string) !== FALSE)
				{
					return $v;
				}
				else return FALSE;
			}

			if ($products)
			{
				// iterate through the result object
				foreach ($products as $res)
				{
					foreach ($res as $key => $val)
					{
						if ($key == 'colors')
						{
							//$search_string_pos = stripos($val, $search_string);
							//$right_dash_pos = stripos($val, '-', $search_string_pos);

							$exploded_val = explode('-', $val);

							$filtered_val = array_filter($exploded_val, 'array_filter_by_search_string');

							$val = implode('-', $filtered_val);
						}

						// lets preg_match $val to $search_string
						if (preg_match('/'.$this->search_string.'/i', $val))
						{
							// put in array if not already there
							if ( ! in_array($val, $results))
							{
								array_push($results, $val);
							}
						}
					}
				}
			}

			// let's sort array according to search_string
			function sort_search_string($a, $b)
			{
				$CI =& get_instance();

				// get the search_string position
				$aa = stripos($a, $CI->search_string);
				$bb = stripos($b, $CI->search_string);

				// check search_string position to be at beggining
				if ($aa == $bb)
				{
					if (strlen($a) == strlen($b)) return 0;
					if (strlen($a) > strlen($b)) return 1;
					else return -1;
				}
				//return ($aa < $bb) ? -1 : 1;
				if ($aa > $bb) return 1;
				if (strlen($a) > strlen($b)) return 1;
				else return -1;
			}

			usort($results, 'sort_search_string');
		}

		echo json_encode($results);
	}

	// --------------------------------------------------------------------

}
