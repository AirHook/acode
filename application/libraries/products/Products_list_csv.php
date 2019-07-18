<?php
if ( ! defined('BASEPATH')) exit('ERROR: 404 Not Found');

/**
 * Product List CSV Class
 *
 * This class' objective is to get the product for csv online editing
 *
 *
 *
 * @package		CodeIgniter
 * @subpackage	Custom Library
 * @category	Product, Product List
 * @author		WebGuy
 * @link
 */
class Products_list_csv
{
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
	public function __construct(array $params = array())
	{
		$this->CI =& get_instance();

		// connect to database
		$this->DB = $this->CI->load->database('instyle', TRUE);

		log_message('info', 'Product List CSV Class Loaded');
	}

	// --------------------------------------------------------------------

	/**
	 * Select and get the list
	 *
	 * List all products as per params intialized
	 *
	 * @return	Object List or FALSE on failure
	 */
	public function select($where = array(), $order_by = array())
	{
		// set $where custom conditions
		if ( ! empty($where))
		{
			foreach ($where as $key => $val)
			{
				if ($val !== '')
				{
					// we check if $key is part of an associate $where array
					if (is_string($key))
					{
						//$has_operand = preg_match('/(<|>|!|=|\sIS NULL|\sIS NOT NULL|\sEXISTS|\sBETWEEN|\sLIKE|\sIN\s*\(|\s)/i', trim($key));

						// OR is usually for a simple OR conditioin
						if (strpos($key, 'OR ') !== FALSE)
						{
							$key = ltrim($key, 'OR ');
							$this->DB->or_where($key, $val);
						}
						// we now add this LIKE condition for the new category tree system
						elseif (strpos($key, ' LIKE') !== FALSE)
						{
							$key = rtrim($key, ' LIKE');

							if ($key == 'tbl_product.categories')
							{
								$like_exp = "tbl_product.categories LIKE '%\"".$val."\"%'";
								$this->DB->where($like_exp);
							}
							else $this->DB->like($key, $val);
						}
						else
						{
							$this->DB->where($key, $val);
						}
					}
				}
			}
		}

		// set select items
		// product info
		$this->DB->select('tbl_product.*');
		// designer associations
		$this->DB->select('designer.url_structure AS d_url_structure');
		// vendor associations
		$this->DB->select('vendors.vendor_name');
		$this->DB->select('vendors.vendor_code');
		$this->DB->select('vendor_types.type');
		// categories associations
		$this->DB->select('c1.category_slug as c_url_structure');
		$this->DB->select('
			(CASE
				WHEN c2.category_slug = "cocktail-dresses" THEN "cocktail"
				WHEN c2.category_slug = "evening-dresses" THEN "evening"
				ELSE c2.category_slug
			END) AS sc_url_structure
		');
		// color info
		$this->DB->select('tblcolor.color_code');
		$this->DB->select('tblcolor.color_name');
		// stock info
		$this->DB->select('tbl_stock.st_id');
		$this->DB->select('tbl_stock.color_facets');
		$this->DB->select('tbl_stock.new_color_publish');
		$this->DB->select('tbl_stock.custom_order');
		$this->DB->select('tbl_stock.primary_color');
		$this->DB->select('tbl_stock.stock_date');
		$this->DB->select('
			size_0, size_2, size_4, size_6, size_8, size_10, size_12, size_14, size_16, size_18, size_20, size_22,
			size_ss, size_sm, size_sl, size_sxl, size_sxxl, size_sxl1, size_sxl2
		');

		// set joins
		$this->DB->join('designer', 'designer.des_id = tbl_product.designer', 'left');
		$this->DB->join('vendors', 'vendors.vendor_id = tbl_product.vendor_id', 'left');
		$this->DB->join('vendor_types', 'vendor_types.id = vendors.vendor_type_id', 'left');
		$this->DB->join('categories c1', 'c1.category_id = tbl_product.cat_id', 'left');
		$this->DB->join('categories c2', 'c2.category_id = tbl_product.subcat_id', 'left');
		$this->DB->join('tbl_stock', 'tbl_stock.prod_no = tbl_product.prod_no', 'left');
		$this->DB->join('tblcolor', 'tblcolor.color_name = tbl_stock.color_name', 'left');

		// order by
		$this->DB->order_by('tbl_product.prod_no', 'ASC');
		$this->DB->order_by('tbl_stock.primary_color', 'DESC');

		// limit request
		//$this->DB->limit(598);

		// get records
		$query = $this->DB->get('tbl_product');

		//echo $this->DB->last_query(); die();

		if ($query->num_rows() == 0)
		{
			// nothing more to do...
			return FALSE;
		}
		else
		{
			$this->row_count = $query->num_rows();

			// return the object
			return $query->result();
		}
	}

	// --------------------------------------------------------------------

}
