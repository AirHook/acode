<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Product_clicks {

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
	 * @return	void
	 */
	public function __construct()
	{
		// Set the super object to a local variable for use throughout the class
		$this->CI =& get_instance();
	
		log_message('info', 'Product List Class Loaded and Initialized');
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Update - update product clicks for today
	 *
	 * @return	boolean
	 */
	public function update($prod_no = '', $designer = '', $wholesale = FALSE)
	{
		if ( ! $prod_no OR ! $designer)
		{
			// nothing more to do...
			return FALSE;
		}
		
		// load pertinent library/model/helpers
		$this->CI->load->model('get_product_clicks');
	
		// get todays product clicks
		$today = @date('Y-m-d', strtotime('today'));
		$product_clicks = $this->CI->get_product_clicks->daily($today);
		
		if ($product_clicks) // function daily returns only one row
		{
			foreach ($product_clicks as $row)
			{
				// grab the click data
				$clicks = $row->click_data != '' ? json_decode($row->click_data , TRUE) : array();
				
				// add a click for same key elements
				if (array_key_exists($prod_no, $clicks))
				{
					// add the clicks
					$clicks[$prod_no][0] += ($wholesale ? 0 : 1); // consumer clicks
					$clicks[$prod_no][1] += ($wholesale ? 1 : 0); // wholesale clicks
					$clicks[$prod_no][2] = $designer;
					
					// adding these info for debuggin purposes
					$clicks[$prod_no][3] = current_url();
					$clicks[$prod_no][4] = $_SERVER['HTTP_REFERER'];
					
					// fix array to remove numeric indexes
					array_values($clicks[$prod_no]);
				}
				else
				{
					// new key element, set the clicks
					$clicks[$prod_no] = array(
						($wholesale ? 0 : 1), // consumer clicks
						($wholesale ? 1 : 0), // wholesale clicks
						$designer, 
						current_url(), 
						$_SERVER['HTTP_REFERER']
					);
				}
			}
		}
		else
		{
			// first record of the day
			$clicks[$prod_no] = array(
				($wholesale ? 0 : 1), // consumer clicks
				($wholesale ? 1 : 0), // wholesale clicks
				$designer, 
				current_url(), 
				$_SERVER['HTTP_REFERER']
			);
		}
		
		// update clicks
		$this->CI->get_product_clicks->update($clicks);

		return TRUE;
	}

	// --------------------------------------------------------------------

}
// END Product_clicks Class

/* End of file Product_clicks.php */
/* Location: ./application/libraries/Product_clicks.php */