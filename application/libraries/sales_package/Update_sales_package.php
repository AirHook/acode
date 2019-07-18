<?php
if ( ! defined('BASEPATH')) exit('ERROR: 404 Not Found');

/**
 * Update Sales Package
 *
 * This class' objective is to update sales package details
 *
 * This part of the update sales package details is being used
 * elsewhere from the application hence its own libray
 *
 * @package		CodeIgniter
 * @subpackage	Custom Libraries
 * @category	Products, Sales Pacakge
 * @author		WebGuy
 * @link
 */
class Update_sales_package
{
	/**
	 * Is Modified
	 *
	 * @var	boolean
	 */
	public $is_modified = FALSE;

	/**
	 * Pre page view
	 *
	 * @var	integer (defaults to 100)
	 */
	public $front_per_page = 48;
	public $admin_per_page = 100;

	/**
	 * Themes
	 *
	 * @var	string
	 */
	public $front_theme = '';
	public $admin_theme = '';

	/**
	 * List
	 *
	 * @var	object
	 */
	private $list = FALSE;


	/**
	 * DB Reference
	 *
	 * @var	object
	 */
	protected $DB;

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
	 * @param	array	$param	Initialization parameter
	 *
	 * @return	void
	 */
	public function __construct()
	{
		$this->CI =& get_instance();

		// load pertinent library/model/helpers
		//$this->CI->load->library('sales_package/sales_package_details');

		// connect to database
		$this->DB = $this->CI->load->database('instyle', TRUE);

		log_message('info', 'Page Details Class Loaded');
	}

	// --------------------------------------------------------------------

	/**
	 * Class Update Recent Items Sales Package
	 * (General items for hubsite and designer items for satellite site)
	 *
	 * @param	string - the product number with primary color code
	 * @return	void
	 */
	public function update_recent_items()
	{
		// check conditions
		if ($this->CI->webspace_details->options['site_type'] == 'hub_site')
		{
			$where_conditions = array();
		}
		else
		{
			$where_conditions = array('designer.url_structure'=>$this->CI->webspace_details->slug);
		}

		// let's get the recent products
		$params['show_private'] = TRUE; // all items general public (Y) - N for private
		$params['group_products'] = TRUE; // group per product number or per variant
		$params['with_stocks'] = FALSE;
		$this->CI->load->library('products/products_list', $params);
		$products = $this->CI->products_list->select(
			$where_conditions, // where conditions
			array( // order conditions
				'tbl_product.seque'=>'desc',
				'tbl_product.prod_date'=>'desc',
				'tbl_product.prod_no'=>'desc'
			),
			30
		);

		// in case the list did not yield any products...
		if ($this->CI->products_list->row_count == 0) return FALSE;

		$items_array = array();
		foreach ($products as $product)
		{
			array_push($items_array, $product->prod_no);
		}

		// udpate the sales package items...
		$this->DB->set('sales_package_items', json_encode($items_array));
		$this->DB->set('last_modified', time());
		$this->DB->where('sales_package_id', '1');
		$this->DB->update('sales_packages');

		return TRUE;
	}

	// --------------------------------------------------------------------

	/**
	 * Class Update Recent Items Sales Package on a per designer basis
	 * This is specifically for sales_package_id #2
	 *
	 * @param	string - the product number with primary color code
	 * @return	void
	 */
	public function update_designer_recent_items($des_id = '')
	{
		if ($des_id == '') return FALSE;

		// set where clause
		if (is_numeric($des_id)) $where_conditions = array('designer.des_id'=>$des_id);
		else $where_conditions = array('designer.url_structure'=>$des_id);

		// let's get the recent products
		$params['show_private'] = TRUE; // all items general public (Y) - N for private
		$params['group_products'] = TRUE; // group per product number or per variant
		$params['with_stocks'] = FALSE;
		$this->CI->load->library('products/products_list', $params);
		$products = $this->CI->products_list->select(
			$where_conditions, // where conditions
			array( // order conditions
				'tbl_product.seque'=>'desc',
				'tbl_product.prod_date'=>'desc',
				'tbl_product.prod_no'=>'desc'
			),
			30
		);

		// in case the list did not yield any products...
		if ($this->CI->products_list->row_count == 0) return FALSE;

		$items_array = array();
		foreach ($products as $product)
		{
			array_push($items_array, $product->prod_no);
		}

		// udpate the sales package items...
		$this->DB->set('sales_package_items', json_encode($items_array));
		$this->DB->set('last_modified', time());
		$this->DB->where('sales_package_id', '2');
		$this->DB->update('sales_packages');

		// redirect user
		return TRUE;
	}

	// --------------------------------------------------------------------

}
