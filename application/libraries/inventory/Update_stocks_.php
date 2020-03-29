<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Update_stocks {

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
	 * @return	void
	 */
	public function __construct($params = array())
 	{
		$this->CI =& get_instance();

		// connect to database
		$this->DB = $this->CI->load->database('instyle', TRUE);

		log_message('info', 'Update Stocks Class Loaded');
 	}

	// --------------------------------------------------------------------

	/**
	 * Update - update product clicks for today
	 *
	 * @return	boolean
	 */
	public function po_completed($po_id = '')
	{
		if ($po_id == '')
		{
			// nothing more to do...
			return FALSE;
		}

		// load pertinent library/model/helpers
		$this->CI->load->library('purchase_orders/purchase_order_details');
		$this->CI->load->library('products/product_details');

		// initialize PO
		$this->CI->purchase_order_details->initialize(array('po_id'=>$po_id));

		foreach ($this->CI->purchase_order_details->items as $item => $size_qty)
		{
			// get product details
			$exp = explode('_', $item);
			$product = $this->CI->product_details->initialize(
				array(
					'tbl_product.prod_no' => $exp[0],
					'color_code' => $exp[1]
				)
			);

			if ($product)
			{
				unset($size_qty['color_name']);
				unset($size_qty['vendor_price']);

				// update size quantities
				$size_qty_to_udpate_available = $size_qty;
				$size_qty_to_udpate_physical = $size_qty;
				foreach ($size_qty as $key => $val)
				{
					$size_qty_to_udpate_available[$key] = $val + $product->$key;
					$exp = explode('_', $key);
					$new_key = 'physical_'.$exp[1];
					$size_qty_to_udpate_physical[$key] = $val + $product->$new_key;
				}

				// update records
				// available stocks
				$this->DB->where('st_id', $product->st_id);
				$this->DB->update('tbl_stock', $size_qty);

				// physical stocks
				$this->DB->where('st_id', $product->st_id);
				$this->DB->update('tbl_stock_physical', $size_qty);
			}
		}

		return TRUE;
	}

	// --------------------------------------------------------------------

}
// END Updatae Stocks Class

/* End of file Update_stocks.php */
/* Location: ./application/libraries/inventory/Update_stocks.php */
