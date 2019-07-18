<?php 
if ( ! defined('BASEPATH')) exit('ERROR: 404 Not Found');

/**
 * Product List Class
 *
 * This class' objective is to get the product list based
 * on paramater input
 *
 * Default parameters yields the general list of products
 *
 * A config file is also available located at the 
 * application/config folder (application/config/product_list.php)
 * You can initialize this class using any config settings
 * available at the config while, or, you can create one
 * yourself
 *
 * Following are the initialization parameters:
 
	$params['wholesale'] = FALSE; // set to TRUE for wholesale users
	$params['show_private'] = FALSE; // don't show private items
	$params['view_status'] = TRUE; // as per field tbl_product.view_status Y/N
	$params['view_at_hub'] = TRUE; // as per field tbl_product.view_status Y1
	$params['view_at_satellite'] = TRUE; // as per field tbl_product.view_status Y2
	$params['variant_publish'] = TRUE; // as per field tbl_stock.color_publish Y/N
	$params['variant_view_at_hub'] = TRUE; // as per field tbl_stock.color_publish Y1
	$params['variant_view_at_satellite'] = TRUE; // as per field tbl_stock.color_publish Y2
	$params['with_stocks'] = TRUE;
	$params['group_products'] = FALSE;
	$params['special_sale'] = FALSE;
	$params['facets'] = array(); // facets parameter
	$params['random_seed'] = FALSE; // Repeateble Randomize Query Parameter (order by RAND(<value>))
	$params['pagination'] = 0;
	$params['active_designers'] = TRUE;
	
 * 
 * @package		CodeIgniter
 * @subpackage	Custom Library
 * @category	Product, Product List
 * @author		WebGuy
 * @link		
 */
class Products_list_search
{
	/**
	 * Wholesale Parameter
	 *
	 * Set to TRUE to show to public
	 *
	 * @var	boolean
	 */
	protected $wholesale = FALSE; 
	
	/**
	 * Show Private Parameter
	 *
	 * Set to TRUE to show to public
	 *
	 * @var	boolean
	 */
	protected $show_private = FALSE; 
	
	/**
	 * View Status Parameters
	 *
	 * Vewi Status is always true because we want items that are set to publish to show
	 * on front end. View status has a sub item that which shows items at hub site or
	 * at satellite site only.
	 * Set to 'ALL' to show both active and suspended items
	 *
	 * @var	boolean
	 */
	protected $view_status = TRUE; 
	protected $view_at_hub = TRUE; 
	protected $view_at_satellite = TRUE; 
	
	/**
	 * Variant View Status Parameters
	 *
	 * Variant Vewi Status is always true because we want items that are set to publish 
	 * to show on front end. View status has a sub item that which shows items at hub 
	 * site or at satellite site only.
	 *
	 * However, this item is only applicable for product display of invidivual variants
	 * as oppose to grouped items showing only primary image
	 *
	 * @var	boolean
	 */
	protected $variant_publish = TRUE; 
	protected $variant_view_at_hub = TRUE; 
	protected $variant_view_at_satellite = TRUE; 
	
	/**
	 * With Stocks Parameter
	 *
	 * Show items only with stocks
	 *
	 * @var	boolean
	 */
	protected $active_designers = TRUE;
	
	/**
	 * With Stocks Parameter
	 *
	 * Show items only with stocks
	 *
	 * @var	boolean
	 */
	protected $with_stocks = TRUE;
	
	/**
	 * Group query by product SKU
	 *
	 * Works for simply product queries like sales packages
	 * Thumbs is complex due to grouping is done first before
	 * order_by primary_color and primary colors of products
	 * are not necessarily top of the group which results to
	 * a problem with the thumb
	 *
	 * @var	boolean
	 */
	protected $group_products = FALSE;
	
	/**
	 * Repeateble Randomize Query Parameter
	 *
	 * @var	boolean
	 */
	protected $special_sale = FALSE;
	
	
	/**
	 * Facets Parameter
	 *
	 * Filter items per facets - size, color, event/occassion, material, style, trend,
	 *							 price, availability
	 * and filter - new-arrival or clearance
	 *
	 * @var	array
	 */
	protected $facets = array();
	
	/**
	 * Repeateble Randomize Query Parameter
	 *
	 * @var	boolean
	 */
	protected $random_seed = FALSE;
	
	/**
	 * Pagination Parameter
	 *
	 * Used to be able to get the total number of records while getting only
	 * the number of items as per pagination limmits
	 *
	 * @var	boolean
	 */
	protected $pagination = 0;
	
	/**
	 * Records count returned without the limit
	 * SQL FOUND_ROWS() or simply the general count
	 *
	 * @var	integer
	 */
	public $count_all = 0;

	/**
	 * Current num_row count of object
	 * With or without limits
	 *
	 * @var	integer
	 */
	public $row_count = 0;
	
	/**
	 * This Class database object holder
	 *
	 * @var	object
	 */
	protected $DB = '';
	
	
	/**
	 * CI Singleton
	 *
	 * @var	object
	 */
	protected $CI;

	// --------------------------------------------------------------------

	/**
	 * Constructor
	 *
	 * @param	array	$param	Initialization parameter - the item id
	 * 
	 * @return	void
	 */
	public function __construct($params = array())
	{
		$this->CI =& get_instance();
		
		// connect to database
		$this->DB = $this->CI->load->database('instyle', TRUE);
		
		$this->initialize($params);
		log_message('info', 'Product List Class Loaded and Initialized');
	}

	// --------------------------------------------------------------------

	/**
	 * Initialize Preferences
	 *
	 * @param	array	$param	Initialization parameter - the item id
	 *					where admin_sales_email = $param
	 * @return	Page_details
	 */
	public function initialize(array $params = array())
	{
		// set properties where necessary
		foreach ($params as $key => $val)
		{
			if ($val !== '')
			{
				if (property_exists($this, $key))
				{
					$this->$key = $val;
				}
			}
		}
		
		return $this;
	}
	
	// --------------------------------------------------------------------

	/**
	 * Select and get the list
	 *
	 * List all products as per params intialized
	 *
	 * @return	Object List or FALSE on failure
	 */
	public function select($where = array(), $order_by = array(), $limit = 35, $_search = NULL)
	{
		// set $where custom conditions
		if ( ! empty($where))
		{
			// used for search queries
			$search_where = '';
			
			foreach ($where as $key => $val)
			{
				if ($val !== '')
				{
					// we check if $key is part of an associative $where array
					if (is_string($key))
					{
						if ($_search)
						{
							if ($key == 'designer.url_structure')
							{
								if ($this->CI->webspace_details->options['site_type'] == 'hub_site')
								{
									// this OR_WHERE item is used for search strings
									// on the associative $where array
									$search_where .= "OR ".$key." LIKE '%".$val."%' ESCAPE '!' ";
								}
								else $this->DB->where($key, $val);
							}
							else 
							{
								// this OR_WHERE item is used for search strings
								// on the associative $where array
								$search_where .= "OR ".$key." LIKE '%".$val."%' ESCAPE '!' ";
							}
						}
						else $this->DB->where($key, $val);
					}
					else // else, it's a integer key for a simple $where array of prod_no
					{
						// we need an OR WHERE for sales package prod_no items
						// or any search query for prod numbers
						$this->DB->or_where('tbl_product.prod_no', $val);
					}
				}
			}
			
			// let's encompass search OR LIKE clause inside parenthesis
			if ($search_where)
			{
				$search_where = "(".ltrim($search_where, 'OR').")";
				
				$this->DB->where($search_where);
			}
		}
		
		// show public or both public and private
		if ($this->show_private)
		{
			$where_private = "(tbl_product.public = 'Y' OR tbl_product.public = 'N')";
			$this->DB->where($where_private);
		}
		else $this->DB->where('tbl_product.public', 'Y');
		
		// view status
		if ($this->view_status)
		{
			if ($this->view_status !== 'ALL')
			{
				// items must show a hub site only
				if ($this->view_at_hub && ! $this->view_at_satellite)
				{
					$where_view_status = "(tbl_product.view_status = 'Y' OR tbl_product.view_status = 'Y1')";
					$this->DB->where($where_view_status);
				}
				// items must show a satellite site only
				elseif ( ! $this->view_at_hub && $this->view_at_satellite)
				{
					$where_view_status = "(tbl_product.view_status = 'Y' OR tbl_product.view_status = 'Y2')";
					$this->DB->where($where_view_status);
				}
				elseif ($this->view_at_hub && $this->view_at_satellite)
				{
					$where_view_status = "(tbl_product.view_status = 'Y' OR tbl_product.view_status = 'Y1' OR tbl_product.view_status = 'Y2')";
					$this->DB->where($where_view_status);
				}
			}
		}
		else $this->DB->where('tbl_product.view_status', 'N');

		// variant publish
		if ($this->variant_publish)
		{
			if ($this->variant_publish !== 'ALL')
			{
				// items must publish a hub site only
				if ($this->variant_view_at_hub && ! $this->variant_view_at_satellite)
				{
					if ($this->show_private) $where_publish = "(tbl_stock.color_publish = 'Y' OR tbl_stock.color_publish = 'Y1' OR tbl_stock.color_publish = 'P')";
					else $where_publish = "(tbl_stock.color_publish = 'Y' OR tbl_stock.color_publish = 'Y1')";
					$this->DB->where($where_publish);
				}
				// items must publish a satellite site only
				elseif ( ! $this->variant_view_at_hub && $this->variant_view_at_satellite)
				{
					if ($this->show_private) $where_publish = "(tbl_stock.color_publish = 'Y' OR tbl_stock.color_publish = 'Y2' OR tbl_stock.color_publish = 'P')";
					else $where_publish = "(tbl_stock.color_publish = 'Y' OR tbl_stock.color_publish = 'Y2')";
					$this->DB->where($where_publish);
				}
				elseif ($this->variant_view_at_hub && $this->variant_view_at_satellite)
				{
					if ($this->show_private) $where_publish = "(tbl_stock.color_publish = 'Y' OR tbl_stock.color_publish = 'Y1' OR tbl_stock.color_publish = 'Y2' OR tbl_stock.color_publish = 'P')";
					else $where_publish = "(tbl_stock.color_publish = 'Y' OR tbl_stock.color_publish = 'Y1' OR tbl_stock.color_publish = 'Y2')";
					$this->DB->where($where_publish);
				}
			}
		}
		else $this->DB->where('tbl_stock.color_publish', 'N');
		
		// active designers
		if ($this->active_designers)
		{
			$this->DB->where('designer.view_status', 'Y');
		}
		
		// on sale
		if ($this->special_sale)
		{
			$this->DB->where('tbl_stock.custom_order', '3');
		}
		
		// set with stocks where condition
		if ($this->with_stocks)
		{
			$where_with_stocks = "(tbl_product.size_mode = '1' AND (size_0 > '0' OR size_2 > '0' OR size_4 > '0' OR size_6 > '0' OR size_8 > '0' OR size_10 > '0' OR size_12 > '0' OR size_14 > '0' OR size_16 > '0' OR size_18 > '0' OR size_20 > '0' OR size_22 > '0') OR tbl_product.size_mode = '0' AND (size_ss > '0' OR size_sm > '0' OR size_sl > '0' OR size_sxl > '0' OR size_sxxl > '0' OR size_sxl1 > '0' OR size_sxl2 > '0'))";
			$this->DB->where($where_with_stocks);
		}
		
		// set where clause for facet filtering
		$faceted = FALSE;
		if ( ! empty($this->facets))
		{
			// NOTE: about $faceted
			// we need to let the class know that query is based on facet filter 
			// indicating that the uri has query strings 
			
			if (isset($this->facets['size']) AND $this->facets['size'] !== 'all')
			{
				// check size facet mode by value
				$size_mode_0 = array('0','2','4','6','8','10','12','14','16','18','20','22');
				$size_mode_1 = array('s','m','l','xl','xxl','xl1','xl2');
				if (in_array($this->facets['size'], $size_mode_0))
				{
					//$facet_filter .= "AND tbl_stock.size_".$this->facets['size']." != '0' ";
					$this->DB->where('tbl_stock.size_'.$this->facets['size'].' !=', '0');
					$faceted = TRUE;
				}
				if (in_array($this->facets['size'], $size_mode_1))
				{
					//$facet_filter .= "AND tbl_stock.size_s".$this->facets['size']." != '0' ";
					$this->DB->where('tbl_stock.size_s'.$this->facets['size'].' !=', '0');
					$faceted = TRUE;
				}
			}
			
			if (isset($this->facets['color']) AND $this->facets['color'] !== 'all')
			{
				$color_facet_filter = "(tbl_stock.color_facets LIKE '%".$this->facets['color']."%' OR tbl_stock.color_name LIKE '%".$this->facets['color']."%')";
				$this->DB->where($color_facet_filter);
				$faceted = TRUE;
			}
			
			if (isset($this->facets['occasion']) AND $this->facets['occasion'] !== 'all')
			{
				//$facet_filter .= "AND tbl_product.events LIKE '%".$this->facets['occasion']."%' ";
				$this->DB->like('tbl_product.events', $this->facets['occasion'], 'both');
				$faceted = TRUE;
			}
			
			if (isset($this->facets['style']) AND $this->facets['style'] !== 'all')
			{
				//$facet_filter .= "AND tbl_product.styles LIKE '%".$this->facets['style']."%' ";
				$this->DB->like('tbl_product.styles', $this->facets['style'], 'both');
				$faceted = TRUE;
			}
			
			if (isset($this->facets['material']) AND $this->facets['material'] !== 'all')
			{
				//$facet_filter .= "AND tbl_product.materials LIKE '%".$this->facets['material']."%' ";
				$this->DB->like('tbl_product.materials', $this->facets['material'], 'both');
				$faceted = TRUE;
			}
			
			if (isset($this->facets['trend']) AND $this->facets['trend'] !== 'all')
			{
				//$facet_filter .= "AND tbl_product.materials LIKE '%".$this->facets['trend']."%' ";
				$this->DB->like('tbl_product.trends', $this->facets['trend'], 'both');
				$faceted = TRUE;
			}
			
			if (isset($this->facets['availability']) AND $this->facets['availability'] !== 'all')
			{
				switch ($this->facets['availability'])
				{
					case 'onsale':
						$this->DB->where('tbl_stock.custom_order', '3');
					break;
					
					case 'preorder':
						$preorder = "(tbl_product.size_mode = '1' AND (size_0 = '0' AND size_2 = '0' AND size_4 = '0' AND size_6 = '0' AND size_8 = '0' AND size_10 = '0' AND size_12 = '0' AND size_14 = '0' AND size_16 = '0' AND size_18 = '0' AND size_20 = '0' AND size_22 = '0') OR tbl_product.size_mode = '0' AND (size_ss = '0' AND size_sm = '0' AND size_sl = '0' AND size_sxl = '0' AND size_sxxl = '0' AND size_sxl1 = '0' AND size_sxl2 = '0'))";
						$this->DB->where($preorder);
					break;
					
					case 'instock':
						$instock = "(tbl_product.size_mode = '1' AND (size_0 > '0' OR size_2 > '0' OR size_4 > '0' OR size_6 > '0' OR size_8 > '0' OR size_10 > '0' OR size_12 > '0' OR size_14 > '0' OR size_16 > '0' OR size_18 > '0' OR size_20 > '0' OR size_22 > '0') OR tbl_product.size_mode = '0' AND (size_ss > '0' OR size_sm > '0' OR size_sl > '0' OR size_sxl > '0' OR size_sxxl > '0' OR size_sxl1 > '0' OR size_sxl2 > '0'))";
						$this->DB->where($instock);
					break;
				}
			}
			
			// A special filer - price
			if (isset($this->facets['price']) AND $this->facets['price'] !== 'default')
			{
				if (
					isset($this->facets['availability']) 
					AND $this->facets['availability'] === 'onsale'
				)
				{
					if ($this->wholesale) $this->DB->order_by('tbl_product.wholesale_price_clearance', $this->facets['price']);
					else $this->DB->order_by('tbl_product.catalogue_price', $this->facets['price']);
				}
				else $this->DB->order_by('net_price', $this->facets['price']); // as part of select column alias line 520
				//else $this->DB->order_by('tbl_product.less_discount', $this->facets['price']);
			}
			
			// filter products
			if (isset($this->facets['filter']) AND $this->facets['filter'] !== '')
			{
				if ($this->facets['filter'] == 'new-arrival')
				{
					$and_filter = "AND (p.new_arrival='Yes' OR p.new_arrival='yes' OR p.new_arrival='y' OR p.new_arrival='Y' OR p.new_arrival='New Arrival')";
					$this->DB->where($and_filter);
					$faceted = TRUE;
				}
				
				if ($this->facets['filter'] == 'clearance')
				{
					$and_filter = "AND (p.clearance='Yes' OR p.clearance='yes' OR p.clearance='y' OR p.clearance='Y' OR p.clearance='Clearance')";
					$this->DB->where($and_filter);
					$faceted = TRUE;
				}
			}
		}
		
		// set limits if pagination is used
		// $this->pagination is the page 1, 2, etc...
		if ($this->pagination > 0)
		{
			// we use SQL_CALC_FOUND_ROWS to calculate for entire record set
			$this->DB->select('SQL_CALC_FOUND_ROWS tbl_product.prod_id', FALSE);
			
			// limit <limits>, <offset>
			if (
				isset($this->CI->webspace_details->options['items_per_page'])
				&& $this->CI->webspace_details->options['items_per_page'] > 0
			)
			{
				$items_per_page = $this->CI->webspace_details->options['items_per_page'] ?: 99;
			}
			else $items_per_page = $this->CI->config->item('items_per_page') ?: 99;
			
			$this->DB->limit($items_per_page, (($this->pagination - 1) * $items_per_page));
		}
		//else $this->DB->select('tbl_product.prod_id');
		
		// set select items
		$this->DB->select('tbl_product.prod_no');
		$this->DB->select('tbl_product.prod_name');
		$this->DB->select('tbl_product.prod_desc');
		$this->DB->select('tbl_product.colors');
		//$this->DB->select('tbl_product.colornames');
		$this->DB->select('tbl_product.materials');
		$this->DB->select('tbl_product.trends');
		$this->DB->select('tbl_product.events');
		$this->DB->select('tbl_product.styles');
		$this->DB->select('c1.category_slug');
		$this->DB->select('c2.category_slug');
		$this->DB->select('designer.url_structure');
		$this->DB->select('tbl_stock.color_name');
		//$this->DB->select('tbl_stock.color_facets');
		
		// set joins
		$this->DB->join('designer', 'designer.des_id = tbl_product.designer', 'left');
		$this->DB->join('categories c1', 'c1.category_id = tbl_product.cat_id', 'left');
		$this->DB->join('categories c2', 'c2.category_id = tbl_product.subcat_id', 'left');
		$this->DB->join('tbl_stock', 'tbl_stock.prod_no = tbl_product.prod_no', 'left');
		
		// group products by prod_no
		if ($this->group_products)
		{
			$this->DB->group_by('tbl_product.prod_no');
			
			if ($faceted)
			{
				$this->DB->join('tblcolor', 'tblcolor.color_name = tbl_stock.color_name', 'left');
			}
			else
			{
				$this->DB->join('tblcolor', 'tblcolor.color_code = tbl_product.primary_img_id', 'left');
			}
		}
		else
		{
			$this->DB->join('tblcolor', 'tblcolor.color_name = tbl_stock.color_name', 'left');
		}
		
		// order by
		// set $order_by custom conditions
		if ( ! empty($order_by))
		{
			foreach ($order_by as $key => $val)
			{
				if ($val !== '')
				{
					$this->DB->order_by($key, $val);
				}
			}
		}
		
		/*
		if ($this->random_seed)
		{
			$this->DB->order_by('RAND(8)');
		}
		else $this->DB->order_by('tbl_product.prod_no', 'asc');
		
		$this->DB->order_by('tbl_stock.primary_color', 'desc');
		*/
		
		$this->DB->order_by('RAND(8)');
		
		// limits
		if ($limit) $this->DB->limit($limit);
		
		// get records
		$query = $this->DB->get('tbl_product');
		
		//echo $this->DB->last_query(); die();
		
		// when pagination is used
		if ($this->pagination > 0)
		{
			// get total count without limits...
			$q = $this->DB->query('SELECT FOUND_ROWS()')->row_array();
			$this->count_all = $q['FOUND_ROWS()'];
		}
		
		if ($query->num_rows() == 0)
		{
			// nothing more to do...
			return FALSE;
		}
		else
		{
			$this->row_count = $query->num_rows();
			
			// return the object
			return $query->result_array();
		}
	}
	
	// --------------------------------------------------------------------

}
