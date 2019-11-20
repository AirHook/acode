<?php
if ( ! defined('BASEPATH')) exit('ERROR: 404 Not Found');

/**
 * Designers List Class
 *
 * This class' objective is to get the designers list based
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

	// no params needed for this list

 *
 * @package		CodeIgniter
 * @subpackage	Custom Library
 * @category	Product, Product List
 * @author		WebGuy
 * @link
 */
class Designers_list
{
	/**
	 * With Product property
	 *
	 * @var		boolean
	 */
	public $with_products = FALSE;

	/**
	 * Current num_row count of object
	 *
	 * @var		integer
	 */
	public $row_count = 0;

	/**
	 * Get the first row of the result set
	 *
	 * @var		object
	 */
	public $first_row = '';


	/**
	 * This Class database object holder
	 *
	 * @var		object
	 */
	protected $DB = '';

	/**
	 * CI Singleton
	 *
	 * @var		object
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
	public function __construct($param = array())
	{
		$this->CI =& get_instance();

		// connect to database
		$this->DB = $this->CI->load->database('instyle', TRUE);

		$this->initialize($param);
		log_message('info', 'Designers List Class Loaded and Initialized');
	}

	// --------------------------------------------------------------------

	/**
	 * Initialize Preferences
	 *
	 * @param	array	$param	Initialization parameter
	 *
	 * @return	Page_details
	 */
	public function initialize(array $params)
	{
		if (empty($params))
		{
			// nothing more to do...
			return FALSE;
		}

		foreach ($params as $key => $val)
		{
			if ($val)
			{
				$this->$key = $val;
			}
		}

		return $this;
	}

	// --------------------------------------------------------------------

	/**
	 * Select and get the list
	 *
	 * List all items as per params
	 *
	 * @return	Object List or FALSE on failure
	 */
	public function select(array $where = array())
	{
		// set $where custom conditions
		if ( ! empty($where))
		{
			foreach ($where as $key => $val)
			{
				if ($val !== '')
				{
					$this->DB->where($key, $val);
				}
			}
		}

		// select items
		$this->DB->select('*');
		$this->DB->select('
			(CASE
				WHEN logo != ""
					AND icon != ""
					AND designer.domain_name != ""
					AND designer_site_domain != ""
					AND designer_address1 != ""
					AND designer_phone != ""
					AND designer_info_email != ""
					AND designer.webspace_id != "0"
				THEN "0"
				ELSE "1"
			END) AS complete_info_status
		');
		$this->DB->select('
			(CASE
				WHEN EXISTS (SELECT * FROM tbl_product WHERE tbl_product.designer = designer.des_id)
				THEN "1"
				ELSE "0"
			END) AS with_products
		');
		$this->DB->select('webspace_options AS options');

		// joins
		$this->DB->join('webspaces', 'webspaces.webspace_id = designer.webspace_id', 'left');
		$this->DB->join('accounts', 'accounts.account_id = webspaces.account_id', 'left');

		// with product?
		if ($this->with_products)
		{
			$this->DB->where('EXISTS (SELECT * FROM tbl_product WHERE tbl_product.designer = designer.des_id)');
		}

		// order by
		$this->DB->order_by('view_status', 'desc');
		$this->DB->order_by('designer', 'asc');

		// get records
		$query = $this->DB->get('designer');

		//echo '<pre>'; echo $this->DB->last_query(); die('<br />DIED');

		if ($query->num_rows() == 0)
		{
			// nothing more to do...
			return FALSE;
		}
		else
		{
			$this->row_count = $query->num_rows();
			$this->first_row = $query->first_row();

			// return the object
			return $query->result();
		}
	}

	// --------------------------------------------------------------------

	/**
	 * Get the list
	 *
	 * @return	array
	 */
	public function get()
	{
		// select items
		$this->DB->select('url_structure');

		// order by
		$this->DB->order_by('view_status', 'desc');
		$this->DB->order_by('designer', 'asc');

		// get records
		$query = $this->DB->get('designer');

		//echo $this->DB->last_query(); die('<br />DIED');

		if ($query->num_rows() == 0)
		{
			// nothing more to do...
			return FALSE;
		}
		else
		{
			$array = array();
			foreach ($query->result() as $row)
			{
				array_push($array, $row->url_structure);
			}

			// return the array
			if ( ! empty($array)) return $array;
			else return FALSE;
		}
	}

	// --------------------------------------------------------------------

	/**
	 * Check if any or the specified designer has products already
	 *
	 * @params	string		a specific designer slug or empty for all
	 * @return	boolean
	 */
	public function with_products($param = '')
	{
		// set $where custom conditions
		if ($param)
		{
			$this->DB->where('designer.url_structure', $param);
		}

		// where product exists for designer
		$where_exists = "(EXISTS (SELECT * FROM tbl_product WHERE tbl_product.designer = designer.des_id))";
		$this->DB->where($where_exists);

		// get records
		$query = $this->DB->get('designer');

		//echo $this->DB->last_query(); die('<br />DIED');

		if ($query->num_rows() > 0)
		{
			// there is at least a designer with products
			return TRUE;
		}
		else return FALSE;
	}

	// --------------------------------------------------------------------

	/**
	 * Get the designer slug using single param
	 *
	 * @return	string
	 */
	public function get_des_slug($param = array())
	{
		if (empty($param))
		{
			// nothing more to do...
			return FALSE;
		}

		// select items
		$this->DB->select('url_structure');

		// where
		$this->DB->where($param);

		// get record
		$query = $this->DB->get('designer');

		//echo $this->DB->last_query(); die('<br />DIED');

		if ($query->num_rows() == 0)
		{
			// nothing more to do...
			return FALSE;
		}
		else
		{
			$row = $query->row();
			return $row->url_structure;
		}
	}

	// --------------------------------------------------------------------

	/**
	 * Get the designer slug using single param
	 *
	 * @return	string
	 */
	public function get_des_name($param = array())
	{
		if (empty($param))
		{
			// nothing more to do...
			return FALSE;
		}

		// select items
		$this->DB->select('designer');

		// where
		$this->DB->where($param);

		// get record
		$query = $this->DB->get('designer');

		//echo $this->DB->last_query(); die('<br />DIED');

		if ($query->num_rows() == 0)
		{
			// nothing more to do...
			return FALSE;
		}
		else
		{
			$row = $query->row();
			return $row->designer;
		}
	}

	// --------------------------------------------------------------------

}
