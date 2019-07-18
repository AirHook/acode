<?php
if ( ! defined('BASEPATH')) exit('ERROR: 404 Not Found');

/**
 * Wholesale Users List Class
 *
 * This class' objective is to get the wholesale user list based
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
class Wholesale_users_list
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
	public function select(array $where = array(), array $order_by = array())
	{
		// set custom where conditions
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
				}

				$w++;
			}
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

		/*********
		 * Will have to use string queries due to CI inherent adding of backticks to database
		 * tables and fields which cannot be disabled when using CASE WHEN THEN ELSE END on
		 * JOIN clause. CI has the ability to disable it only on SELECT clauses only.
		 */
		$query_string = "
			SELECT
				tbluser_data_wholesale.*,

				designer.designer,

				tbladmin_sales.admin_sales_id,
				tbladmin_sales.admin_sales_user,
				tbladmin_sales.admin_sales_lname,
				tbladmin_sales.admin_sales_email,

				xdate,
				visits,
				visits_after_activation
			FROM
				tbluser_data_wholesale
				LEFT JOIN designer ON (
					CASE
						WHEN tbluser_data_wholesale.reference_designer = 'basixblacklabel'
						THEN designer.folder = tbluser_data_wholesale.reference_designer
						ELSE designer.url_structure = tbluser_data_wholesale.reference_designer
					END
				)
				LEFT JOIN tbladmin_sales ON tbladmin_sales.admin_sales_email = tbluser_data_wholesale.admin_sales_email
				LEFT JOIN (select email, max(create_date) as xdate from tbl_login_detail_wholesale group by email) as ld on ld.email = tbluser_data_wholesale.email
				LEFT JOIN (SELECT email, COUNT(email) AS visits FROM tbl_login_detail_wholesale GROUP BY email) AS ldw on ldw.email = tbluser_data_wholesale.email
				LEFT JOIN (
					SELECT tbl_login_detail_wholesale.email, tbluser_data_wholesale.active_date, COUNT(tbl_login_detail_wholesale.email) AS visits_after_activation
					FROM tbl_login_detail_wholesale
					LEFT JOIN tbluser_data_wholesale ON tbluser_data_wholesale.email = tbl_login_detail_wholesale.email
					WHERE tbl_login_detail_wholesale.create_date >= tbluser_data_wholesale.active_date
					GROUP BY tbl_login_detail_wholesale.email
				) AS ldwa on ldwa.email = tbluser_data_wholesale.email
			".$where_clause."
			".($order_clause ?: 'ORDER BY xdate DESC')."
		";

		// get records
		$query = $this->DB->query($query_string);

		//echo $this->DB->last_query(); die('<br />DIED');

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
