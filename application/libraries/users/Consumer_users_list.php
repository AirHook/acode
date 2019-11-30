<?php
if ( ! defined('BASEPATH')) exit('ERROR: 404 Not Found');

/**
 * Consumer Users List Class
 *
 * This class' objective is to get the consumer user list based
 * on paramater input
 *
 * Default parameters yields the general list of products
 *
 *
 * @package		CodeIgniter
 * @subpackage	Custom Library
 * @category	Product, Product List
 * @author		WebGuy
 * @link
 */
class Consumer_users_list
{
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
	public function __construct(array $params = array())
	{
		$this->CI =& get_instance();

		// connect to database
		$this->DB = $this->CI->load->database('instyle', TRUE);

		// some initializations
		$this->_count_all();

		log_message('info', 'Product List Class Loaded and Initialized');
	}

	// --------------------------------------------------------------------

	/**
	 * Select and get the list
	 *
	 * List all items as per params intialized
	 *
	 * @return	Object List or FALSE on failure
	 */
	public function select(
		$where = array(),
		$order_by = array(),
		$limits = array(),
		$custom_where = ''
	)
	{
		// set where conditions
		$where_clause = '';
		if ( ! empty($where))
		{
			$w = 0;
			$where_clause = "WHERE";
			foreach ($where as $key => $val)
			{
				$has_operand = preg_match('/(<|>|!|=|\sIS NULL|\sIS NOT NULL|\sEXISTS|\sBETWEEN|\sLIKE|\sIN\s*\(|\s)/i', trim($key));

				if ($val !== '')
				{
					if ($w == 0) $where_clause.= " ".$key.($has_operand ? " '" : " = '").$val."'";
					else $where_clause.= " AND ".$key.($has_operand ? " '" : " = '").$val."'";

					$w++;
				}
			}
		}

		// set custom string where clauses
		if ($custom_where !== '')
		{
			if ($where_clause !== '') $where_clause.= " AND ";
			else $where_clause = "WHERE ";

			$where_clause.= $custom_where;
		}

		// set custom order conditions
		$order_clause = '';
		if ( ! empty($order_by))
		{
			$o = 0;
			$order_clause = 'ORDER BY';
			foreach ($order_by as $key => $val)
			{
				if ($val !== '')
				{
					if ($o == 0) $order_clause.= ' '.$key.' '.$val;
					else $order_clause.= ', AND '.$key.' '.$val;
				}

				$o++;
			}
		}

		// set limits
		$limits_cluase = '';
		if ( ! empty($limits))
		{
			$limits_cluase = 'LIMIT '.$limits[0].', '.$limits[1];
		}

		/*********
		 * Will have to use string queries due to CI inherent adding of back ticks to database
		 * tables and fields which cannot be disabled when using CASE WHEN THEN ELSE END on
		 * JOIN clause. CI has the ability to disable it only on SELECT clauses only.
		 */
		$query_string = "
			SELECT
				tbluser_data.*,

				designer.designer,

				tbladmin_sales.admin_sales_id,
				tbladmin_sales.admin_sales_user,
				tbladmin_sales.admin_sales_lname,
				tbladmin_sales.admin_sales_email,

				xdate
			FROM
				tbluser_data
				LEFT JOIN designer ON (
					CASE
						WHEN tbluser_data.reference_designer = 'basixblacklabel'
						THEN designer.folder = tbluser_data.reference_designer
						ELSE designer.url_structure = tbluser_data.reference_designer
					END
				)
				LEFT JOIN tbladmin_sales ON tbladmin_sales.admin_sales_email = tbluser_data.admin_sales_email
				LEFT JOIN (
					SELECT
						email, max(create_date) as xdate
					FROM
						tbl_login_detail
					WHERE logindata = 'special_sale_visit'
					GROUP BY
						email
				) as ld on ld.email = tbluser_data.email
			".$where_clause."
			".($order_clause ?: 'ORDER BY xdate DESC')."
			".$limits_cluase."
		";

		// get records
		$query = $this->DB->query($query_string);

		//echo '<pre>'; echo $this->DB->last_query(); die('<br />DIED');

		if ($query->num_rows() == 0)
		{
			// nothing more to do...
			return FALSE;
		}
		else
		{
			$this->row_count = $query->num_rows();

			return $query->result();
		}
	}

	// --------------------------------------------------------------------

	/**
	 * Private Count All Records
	 *
	 * @return	void
	 */
	private function _count_all()
	{
		$this->count_all = $this->DB->count_all('tbluser_data');
	}

	// --------------------------------------------------------------------

}
