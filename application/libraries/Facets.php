<?php
if ( ! defined('BASEPATH')) exit('ERROR: 404 Not Found');

/**
 * Facet Class
 *
 * This class does all methods relating to faceting
 *
 * @package		CodeIgniter
 * @subpackage	Custom Libraries
 * @category	Facets
 * @author		WebGuy
 * @link
 */
class Facets
{
	/**
	 * Facet - size, color, events(occassion), materials, trends, styles(default)
	 *
	 * @var	string
	 */
	public $facet = 'styles';

	/**
	 * Category ID
	 *
	 * Note that we will eventually remove main cat apparel and treat it as one
	 * of the multi-level categories
	 *
	 * @var	string
	 */
	public $category_id = '';

	/**
	 * Designer ID
	 *
	 * @var	string
	 */
	public $designer_id = '';

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
	 * Show Pending Parameter
	 *
	 * Set to TRUE to when dates are current or past already
	 * Set to TRUE to show items at admin
	 *
	 * @var	boolean
	 */
	protected $show_pending = FALSE;

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
	 * Special Sale Parameter
	 *
	 * Show special sale items only
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
	 * Category based parameters
	 *
	 * @var	boolean
	 */
	protected $d_url_structure = '';
	protected $c1_url_structure = '';
	protected $c2_url_structure = '';


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
	public function __construct(array $param = array())
	{
		$this->CI =& get_instance();

		// connect to database
		$this->DB = $this->CI->load->database('instyle', TRUE);

		$this->initialize($param);
		log_message('info', 'Facets Class Initialized');
	}

	// --------------------------------------------------------------------

	/**
	 * Initialize Preferences
	 *
	 * @param	array	$param	Initialization parameter - the item id
	 *					where admin_sales_email = $param
	 * @return	Page_details
	 */
	public function initialize(array $params)
	{
		if (empty($params))
		{
			// nothing more to do...
			return FALSE;
		}

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
	 * Generate the facets list (by categories / by designer / by new arrival/clearance filer)
	 *
	 * @access	public
	 * @params	string
	 * @return	object
	 */
	public function get($facet = '')
	{
		if (empty($facet))
		{
			// nothing more to do...
			return FALSE;
		}

		// facet related query builder classes
		switch ($facet)
		{
			case 'color_facets':
				$this->DB->select('color_facets');
				$this->DB->from('tbl_product');
				$this->DB->group_by('tbl_stock.color_facets');
			break;

			case 'styles':
				$this->DB->distinct();
				$this->DB->select('styles');
				$this->DB->from('tbl_product');
				$this->DB->join('tblstyle','tblstyle.style_name = tbl_product.styles','left');
				$this->DB->group_by('styles');
			break;

			case 'events':
				$this->DB->distinct();
				$this->DB->select('events');
				$this->DB->from('tbl_product');
				$this->DB->join('tblevent','tblevent.event_name = tbl_product.events','left');
				$this->DB->group_by('events');
			break;

			case 'materials':
				$this->DB->distinct();
				$this->DB->select('materials');
				$this->DB->from('tbl_product');
				$this->DB->join('tblmaterial','tblmaterial.material_name = tbl_product.materials','left');
				$this->DB->group_by('materials');
			break;

			case 'trends':
				$this->DB->distinct();
				$this->DB->select('trends');
				$this->DB->from('tbl_product');
				$this->DB->join('tbltrend','tbltrend.trend_name = tbl_product.trends','left');
				$this->DB->group_by('trends');
			break;

			case 'seasons':
				$this->DB->distinct();
				$this->DB->select('seasons');
				$this->DB->from('tbl_product');
				$this->DB->join('tblseason','tblseason.season_name = tbl_product.seasons','left');
				$this->DB->group_by('seasons');
			break;

			case 'size':
				$this->DB->select('
					size_mode,
					size_0, size_2, size_4, size_6, size_8, size_10, size_12, size_14, size_16, size_18, size_20, size_22,
					size_ss, size_sm, size_sl, size_sxl, size_sxxl, size_sxl1, size_sxl2,
					size_ssm, size_sml, size_sprepack1221, size_sonesizefitsall
				'
				);
				$this->DB->from('tbl_product');
				$this->DB->group_by('
					tbl_product.prod_id,
					size_0, size_2, size_4, size_6, size_8, size_10, size_12, size_14, size_16, size_18, size_20, size_22,
					size_ss, size_sm, size_sl, size_sxl, size_sxxl, size_sxl1, size_sxl2,
					size_ssm, size_sml, size_sprepack1221, size_sonesizefitsall
				');
			break;
		}

		// is item public or private
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

			// we will need to use custome query string for facets
			$facet_where = '';

			if (isset($this->facets['size']) AND $this->facets['size'] !== 'all')
			{
				// check size facet mode by value
				$size_mode_1 = array('0','2','4','6','8','10','12','14','16','18','20','22');
				$size_mode_0 = array('s','m','l','xl','xxl','xl1','xl2');
				$size_mode_2 = array('prepack1221');
				$size_mode_3 = array('sm','ml');
				$size_mode_4 = array('onesizefitsall');

				$size_mode_w_s = array_merge($size_mode_0, $size_mode_2, $size_mode_3, $size_mode_4);

				$url_sizes = explode(',', $this->facets['size']);
				foreach ($url_sizes as $key => $size)
				{
					if (in_array($size, $size_mode_1))
					{
						$facet_where .= " OR tbl_stock.size_".$size." != '0'";
						//if ($key == 0) $this->DB->where('tbl_stock.size_'.$size.' !=', '0');
						//else $this->DB->or_where('tbl_stock.size_'.$size.' !=', '0');
					}
					if (in_array($size, $size_mode_w_s))
					{
						$facet_where .= " OR tbl_stock.size_s".$size." != '0'";
						//if ($key == 0) $this->DB->where('tbl_stock.size_s'.$size.' !=', '0');
						//else $this->DB->or_where('tbl_stock.size_s'.$size.' !=', '0');
					}
				}
				$faceted = TRUE;
			}

			if (isset($this->facets['color']) AND $this->facets['color'] !== 'all')
			{
				$url_colors = explode(',', $this->facets['color']);
				foreach ($url_colors as $key => $color)
				{
					$facet_where .= " OR (tbl_stock.color_facets LIKE '%".$color."%' OR tbl_stock.color_name LIKE '%".$color."%')";
					//$color_facet_filter = "(tbl_stock.color_facets LIKE '%".$color."%' OR tbl_stock.color_name LIKE '%".$color."%')";
					//if ($key == 0) $this->DB->where($color_facet_filter);
					//else $this->DB->or_where($color_facet_filter);
				}
				$faceted = TRUE;
			}

			if (isset($this->facets['occassion']) AND $this->facets['occassion'] !== 'all')
			{
				$url_occassions = explode(',', $this->facets['occassion']);
				foreach ($url_occassions as $key => $occassion)
				{
					$facet_where .= " OR tbl_product.events LIKE '%".$occassion."%'";
					//if ($key == 0) $this->DB->like('tbl_product.events', $occassion, 'both');
					//else $this->DB->or_like('tbl_product.events', $occassion, 'both');
				}
				$faceted = TRUE;
			}

			if (isset($this->facets['style']) AND $this->facets['style'] !== 'all')
			{
				$url_styles = explode(',', $this->facets['style']);
				foreach ($url_styles as $key => $style)
				{
					$facet_where .= " OR tbl_product.styles LIKE '%".$style."%'";
					//if ($key == 0) $this->DB->like('tbl_product.styles', $style, 'both');
					//else $this->DB->or_like('tbl_product.styles', $style, 'both');
				}
				$faceted = TRUE;
			}

			if (isset($this->facets['material']) AND $this->facets['material'] !== 'all')
			{
				$url_materials = explode(',', $this->facets['material']);
				foreach ($url_materials as $key => $material)
				{
					$facet_where .= " OR tbl_product.materials LIKE '%".$material."%'";
					//if ($key == 0) $this->DB->like('tbl_product.materials', $material, 'both');
					//else $this->DB->or_like('tbl_product.materials', $material, 'both');
				}
				$faceted = TRUE;
			}

			if (isset($this->facets['trend']) AND $this->facets['trend'] !== 'all')
			{
				$url_trends = explode(',', $this->facets['trend']);
				foreach ($url_trends as $key => $trend)
				{
					$facet_where .= " OR tbl_product.trends LIKE '%".$trend."%'";
					//if ($key == 0) $this->DB->like('tbl_product.trends', $trend, 'both');
					//else $this->DB->or_like('tbl_product.trends', $trend, 'both');
				}
				$faceted = TRUE;
			}

			if (isset($this->facets['season']) AND $this->facets['season'] !== 'all')
			{
				$url_seasons = explode(',', $this->facets['season']);
				foreach ($url_seasons as $key => $season)
				{
					$facet_where .= " OR tbl_product.seasons LIKE '%".$season."%'";
					//if ($key == 0) $this->DB->like('tbl_product.trends', $trend, 'both');
					//else $this->DB->or_like('tbl_product.trends', $trend, 'both');
				}
				$faceted = TRUE;
			}

			if (isset($this->facets['availability']) AND $this->facets['availability'] !== 'all')
			{
				switch ($this->facets['availability'])
				{
					case 'onsale':
						$facet_where .= " OR tbl_stock.custom_order = '3'";
						//$this->DB->where('tbl_stock.custom_order', '3');
					break;

					case 'preorder':
						$facet_where .= " OR (tbl_product.size_mode = '1' AND (size_0 = '0' AND size_2 = '0' AND size_4 = '0' AND size_6 = '0' AND size_8 = '0' AND size_10 = '0' AND size_12 = '0' AND size_14 = '0' AND size_16 = '0' AND size_18 = '0' AND size_20 = '0' AND size_22 = '0') OR tbl_product.size_mode = '0' AND (size_ss = '0' AND size_sm = '0' AND size_sl = '0' AND size_sxl = '0' AND size_sxxl = '0' AND size_sxl1 = '0' AND size_sxl2 = '0') OR tbl_product.size_mode = '2' AND (size_sprepack1221 = '0') OR tbl_product.size_mode = '3' AND (size_ssm = '0' AND size_sml = '0') OR tbl_product.size_mode = '4' AND (size_sonesizefitsall = '0'))";
						//$preorder = "(tbl_product.size_mode = '1' AND (size_0 = '0' AND size_2 = '0' AND size_4 = '0' AND size_6 = '0' AND size_8 = '0' AND size_10 = '0' AND size_12 = '0' AND size_14 = '0' AND size_16 = '0' AND size_18 = '0' AND size_20 = '0' AND size_22 = '0') OR tbl_product.size_mode = '0' AND (size_ss = '0' AND size_sm = '0' AND size_sl = '0' AND size_sxl = '0' AND size_sxxl = '0' AND size_sxl1 = '0' AND size_sxl2 = '0') OR tbl_product.size_mode = '2' AND (size_sprepack1221 = '0') OR tbl_product.size_mode = '3' AND (size_ssm = '0' AND size_sml = '0') OR tbl_product.size_mode = '4' AND (size_sonesizefitsall = '0'))";
						//$this->DB->where($preorder);
					break;

					case 'instock':
						$facet_where .= " OR (tbl_product.size_mode = '1' AND (size_0 > '0' OR size_2 > '0' OR size_4 > '0' OR size_6 > '0' OR size_8 > '0' OR size_10 > '0' OR size_12 > '0' OR size_14 > '0' OR size_16 > '0' OR size_18 > '0' OR size_20 > '0' OR size_22 > '0') OR tbl_product.size_mode = '0' AND (size_ss > '0' OR size_sm > '0' OR size_sl > '0' OR size_sxl > '0' OR size_sxxl > '0' OR size_sxl1 > '0' OR size_sxl2 > '0') OR tbl_product.size_mode = '2' AND (size_sprepack1221 > '0') OR tbl_product.size_mode = '3' AND (size_ssm > '0' AND size_sml > '0') OR tbl_product.size_mode = '4' AND (size_sonesizefitsall > '0'))";
						//$instock = "(tbl_product.size_mode = '1' AND (size_0 > '0' OR size_2 > '0' OR size_4 > '0' OR size_6 > '0' OR size_8 > '0' OR size_10 > '0' OR size_12 > '0' OR size_14 > '0' OR size_16 > '0' OR size_18 > '0' OR size_20 > '0' OR size_22 > '0') OR tbl_product.size_mode = '0' AND (size_ss > '0' OR size_sm > '0' OR size_sl > '0' OR size_sxl > '0' OR size_sxxl > '0' OR size_sxl1 > '0' OR size_sxl2 > '0') OR tbl_product.size_mode = '2' AND (size_sprepack1221 > '0') OR tbl_product.size_mode = '3' AND (size_ssm > '0' AND size_sml > '0') OR tbl_product.size_mode = '4' AND (size_sonesizefitsall > '0'))";
						//$this->DB->where($instock);
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

			// close the where close
			$facet_where = ltrim($facet_where, ' OR ');
			$facet_where = '('.$facet_where.')';
			$this->DB->where($facet_where);

		}

		// check for categorization
		//if ($this->category_id != '') $this->DB->where('tbl_product.subcat_id', $this->category_id);
		if ($this->designer_id != '') $this->DB->where('tbl_product.designer', $this->designer_id);

		// set joins
		$this->DB->join('designer', 'designer.des_id = tbl_product.designer', 'left');
		$this->DB->join('categories c1', 'c1.category_id = tbl_product.cat_id', 'left'); // old category system (can stay even if not needed)
		$this->DB->join('categories c2', 'c2.category_id = tbl_product.subcat_id', 'left'); // old category system (can stay even if not needed)
		$this->DB->join('tbl_stock', 'tbl_stock.prod_no = tbl_product.prod_no', 'left');
		$this->DB->join('tblcolor', 'tblcolor.color_name = tbl_stock.color_name', 'left');

		// check for categorization parameters
		if ($this->d_url_structure) $this->DB->where('designer.url_structure', $this->d_url_structure);

		// old category system (for depracation)
		//if ($this->c1_url_structure) $this->DB->where('c1.category_slug', $this->c1_url_structure);
		//if ($this->c2_url_structure) $this->DB->where('c2.category_slug', $this->c2_url_structure);
		// new category system
		if ($this->category_id) $this->DB->like('tbl_product.categories', '"'.$this->category_id.'"');

		// order by
		/*
		if ($this->random_seed)
		{
			$this->DB->order_by('RAND(8)');
		}
		*/

		// group by to fix sql strick only_full_group_by poblicy
		//$this->DB->group_by('trends');

		$query = $this->DB->get();

		//echo $this->DB->last_query(); die();

		if ($query && $query->num_rows() > 0)
		{
			return $query;
		}
		else
		{
			return FALSE;
		}
	}

	// --------------------------------------------------------------------

	/**
	 * Get all facets
	 *
	 * @return	void
	 */
	public function get_all($facet = '')
	{
		if (empty($facet))
		{
			// nothing more to do...
			return FALSE;
		}

		// facet related query builder classes
		switch ($facet)
		{
			case 'color_facets':
				$table = 'tblcolors';
				$this->DB->order_by('color_name', 'asc');
			break;

			case 'styles':
				$table = 'tblstyle';
				$this->DB->order_by('style_name', 'asc');
			break;

			case 'events':
				$table = 'tblevent';
				$this->DB->order_by('event_name', 'asc');
			break;

			case 'materials':
				$table = 'tblmaterial';
				$this->DB->order_by('material_name', 'asc');
			break;

			case 'trends':
				$table = 'tbltrend';
				$this->DB->order_by('trend_name', 'asc');
			break;

			case 'seasons':
				$table = 'tblseason';
				$this->DB->order_by('season_name', 'asc');
			break;
		}

		$query = $this->DB->get($table);

		//echo $this->DB->last_query(); die();

		if ($query->num_rows() > 0)
		{
			return $query;
		}
		else
		{
			return FALSE;
		}
	}

	// --------------------------------------------------------------------

}
