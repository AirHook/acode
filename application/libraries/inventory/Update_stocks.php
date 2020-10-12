<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Class Update Stocks By Orders
 *
 * Reserve stocks sets a stock quantity from available to onorder upon ordering
 * Remove stocks sets a stock quantity from physical stocks usually upon order complete
 * Return stocks returns stock quantity to available
 *
 */
class Update_stocks {

	/**
	 * Prod No
	 *
	 * @var	string
	 */
	public $prod_no = '';

	/**
	 * Color Code
	 *
	 * @var	string
	 */
	public $color_code = '';

	/**
	 * Prod Sku
	 *
	 * @var	string
	 */
	public $prod_sku = '';

	/**
	 * Special Stocks
	 *
	 * @var	boolean
	 */
	public $admin_stocks = FALSE;

	/**
	 * Size
	 *
	 * @var	numeric
	 */
	public $size = '';

	/**
	 * Qty
	 *
	 * @var	numeric
	 */
	public $qty = '';

	/**
	 * Order Number
	 *
	 * @var	string
	 */
	public $order_id = '';


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
	 * @params	array	$params	Initialization parameter
	 *
	 * @return	void
	 */
	public function __construct($params = array())
 	{
		$this->CI =& get_instance();

		// connect to database
		$this->DB = $this->CI->load->database('instyle', TRUE);

		log_message('info', 'Reserve Stocks Class Loaded');
 	}

	// --------------------------------------------------------------------

	/**
	 * Initialize Preferences
	 *
	 * @return	properties
	 */
	public function initialize(array $params)
	{
		// set properties where necessary
		foreach ($params as $key => $val)
		{
			if ($val !== '')
			{
				if (property_exists($this, $key))
				{
					$this->$key = trim($val);
				}
			}
		}

		return $this;
	}

	// --------------------------------------------------------------------

	/**
	 * Reserve
	 *
	 * Reserve stocks from available to onorder while the order is in process
	 * This is done on checkout submit, and for admin sales order generation
	 *
	 * On combined regular and admin stocks, deduct from regular stocks first
	 * before resorting to admin stocks
	 *
	 * @return	boolean
	 */
	public function reserve()
	{
		if ( ! $this->prod_no && ! $this->color_code && ! $this->prod_sku && ! $this->size && ! $this->order_id)
		{
			// nothing more to do...
			return FALSE;
		}

		// load pertinent library/model/helpers
		$this->CI->load->library('products/product_details');
		$this->CI->load->library('products/size_names');

		// get product details
		if ($this->prod_sku)
		{
			$exp = explode('_', $this->prod_sku);
			$this->prod_no = $exp[0];
			$this->color_code = $exp[1];
		}
		$product = $this->CI->product_details->initialize(
			array(
				'tbl_product.prod_no' => $this->prod_no,
				'color_code' => $this->color_code
			)
		);

		// get size label
		$size = $this->size;
		$size_names = $this->CI->size_names->get_size_names($product->size_mode);
		$size_label = array_search($size, $size_names);
		$exp = explode('_', $size_label);
		$size_suffix = $exp[1];

		// set qty
		$qty = $this->qty;

		// set the order id as options['onorder'] value indicating which orders
		// are ordring the stock
		$stocks_options = $product->stocks_options;
		$stocks['onorder'] = @$stocks_options['onorder'] ?: array();
		array_push($stocks['onorder'], $this->order_id);
		$stocks_options['onorder'] = $stocks['onorder'];

		// first we need to determine if item is regular item only
		// or, may involve admin stocks
		if ($this->admin_stocks)
		{

		}

		// regardless, if there is available stock,
		// deduct from available stock
		// get on order stock and update accordingly
		$available_label = 'available_'.$size_suffix;
		$available_stock = $product->$available_label;
		$final_available_stock =
			($available_stock - $qty) < 0
			? 0
			: $available_stock - $qty
		;

		// get current stock and update accordingly
		// this is now regardless if stock is 'admin_stocks_only'
		// we update regular stock first before admin stocks
		// get available stock
		$available_label = 'available_'.$size_suffix;
		$available_stock = $product->$available_label;
		$final_available_stock = $available_stock; // assume initial stock
		$admin_available_label = 'admin_available_'.$size_suffix;
		$admin_available_stock = $product->$admin_available_label;
		$final_admin_available_stock = $admin_available_stock; // assume initial stock
		$regular_qty = $qty;
		$admin_qty = 0;

		// update final available stocks
		if ($available_stock > 0)
		{
			// we take from regular stock first
			if (($available_stock - $qty) <= 0)
			{
				// if ending regular stock is zero or less, calculate...
				$regular_qty = $available_stock;
				$admin_qty = $qty - $admin_available_stock;
				$final_available_stock = 0;
				$final_admin_available_stock =
					($admin_available_stock - $admin_qty) < 0
					? 0
					: $admin_available_stock - $admin_qty
				;
			}
			else
			{
				// otherwise, simply...
				$final_available_stock = $available_stock - $qty;
			}
		}
		else
		{
			// finally, get from admin stocks
			$final_admin_available_stock =
				($admin_available_stock - $qty) < 0
				? 0
				: $admin_available_stock - $qty
			;
		}

		// get on order stock and update accordingly
		$onorder_label = 'onorder_'.$size_suffix;
		$onorder_stock = $product->$onorder_label;
		$final_onorder_stock = $onorder_stock + $regular_qty;
		$admin_onorder_label = 'admin_onorder_'.$size_suffix;
		$admin_onorder_stock = $product->$admin_onorder_label;
		$final_admin_onorder_stock = $admin_onorder_stock + $admin_qty;

		// update available stocks
		$this->DB->where('st_id', $product->st_id);
		$this->DB->update(
			'tbl_stock_available',
			array(
				$size_label => $final_available_stock
			)
		);

		// update admin available stocks
		$this->DB->where('st_id', $product->st_id);
		$this->DB->update(
			'tbl_stock_admin',
			array(
				$size_label => $final_admin_available_stock
			)
		);

		// update onorder stocks, or insert where necessary
		if ($product->onorder_st_id)
		{
			$this->DB->where('st_id', $product->st_id);
			$this->DB->update('tbl_stock_onorder', array($size_label => $final_onorder_stock));
		}
		else
		{
			$this->DB->set('st_id', $product->st_id);
			$this->DB->set($size_label, $final_onorder_stock);
			$this->DB->insert('tbl_stock_onorder');
		}

		// update admin onorder stocks, or insert where necessary
		if ($product->admin_onorder_st_id)
		{
			$this->DB->where('st_id', $product->st_id);
			$this->DB->update('tbl_stock_admin_onorder', array($size_label => $final_admin_onorder_stock));
		}
		else
		{
			$this->DB->set('st_id', $product->st_id);
			$this->DB->set($size_label, $final_admin_onorder_stock);
			$this->DB->insert('tbl_stock_admin_onorder');
		}

		// update records
		$this->DB->where('st_id', $product->st_id);
		$this->DB->update(
			'tbl_stock',
			array(
				'options' => json_encode($stocks_options)
			)
		);

		return TRUE;
	}

	// --------------------------------------------------------------------

	/**
	 * Remove
	 *
	 * Remove stocks ultimately from physical stocks upon completion of order
	 * This in turn remove any reserved stocks on onorder
	 *
	 * @return	boolean
	 */
	public function remove()
	{
		if ( ! $this->prod_no && ! $this->color_code && ! $this->prod_sku && ! $this->size && ! $this->order_id)
		{
			// nothing more to do...
			return FALSE;
		}

		// load pertinent library/model/helpers
		$this->CI->load->library('products/product_details');
		$this->CI->load->library('products/size_names');

		// get product details
		if ($this->prod_sku)
		{
			$exp = explode('_', $this->prod_sku);
			$this->prod_no = $exp[0];
			$this->color_code = $exp[1];
		}
		$product = $this->CI->product_details->initialize(
			array(
				'tbl_product.prod_no' => $this->prod_no,
				'color_code' => $this->color_code
			)
		);

		// get size label
		$size = $this->size;
		$size_names = $this->CI->size_names->get_size_names($product->size_mode);
		$size_label = array_search($size, $size_names);
		$exp = explode('_', $size_label);
		$size_suffix = $exp[1];

		$qty = $this->qty;

		// since order is complete, remove reference to order id
		$stocks_options = $product->stocks_options;
		$stocks['onorder'] = @$stocks_options['onorder'] ?: array();
		$okey = array_search($this->order_id, $stocks['onorder']);
		if ($okey !== FALSE) unset($stocks['onorder'][$okey]);
		if (!empty($stocks['onorder'])) $stocks_options['onorder'] = $stocks['onorder'];
		else unset($stocks_options['onorder']);

		// update stocks
		// this is now regardless if stock is 'admin_stocks_only'
		// we update regular stock first before admin stocks
		// get available stock

		// get onorder stocks
		$onorder_label = 'onorder_'.$size_suffix;
		$onorder_stock = $product->$onorder_label;
		$final_onorder_stock = $onorder_stock; // assume initial stock
		$admin_onorder_label = 'admin_onorder_'.$size_suffix;
		$admin_onorder_stock = $product->$admin_onorder_label;
		$final_admin_onorder_stock = $admin_onorder_stock; // assume initial stock
		$regular_qty = $qty;
		$admin_qty = 0;

		// set variable to update final onorder stocks
		if ($onorder_stock > 0)
		{
			// we take from regular stock first
			if (($onorder_stock - $qty) <= 0)
			{
				// if ending regular stock is zero or less, calculate...
				$regular_qty = $onorder_stock;
				$admin_qty = $qty - $admin_onorder_stock;
				$final_onorder_stock = 0;
				$final_admin_onorder_stock =
					($admin_onorder_stock - $admin_qty) < 0
					? 0
					: $admin_onorder_stock - $admin_qty
				;
			}
			else
			{
				// otherwise, simply...
				$final_onorder_stock = $onorder_stock - $qty;
			}
		}
		else
		{
			// finally, get from admin stocks
			$final_admin_onorder_stock =
				($admin_onorder_stock - $qty) < 0
				? 0
				: $admin_onorder_stock - $qty
			;
		}

		// get physical stocks
		$physical_stock = $product->$size_label;
		$final_physical_stock = $physical_stock; // assume initial stock
		$admin_physical_label = 'admin_physical_'.$size_suffix;
		$admin_physical_stock = $product->$admin_physical_label;
		$final_admin_physical_stock = $admin_physical_stock; // assume initial stock
		$regular_physical_qty = $qty;
		$admin_physical_qty = 0;

		// set variable to update final physical stocks
		if ($physical_stock > 0)
		{
			// we take from regular stock first
			if (($physical_stock - $qty) <= 0)
			{
				// if ending regular stock is zero or less, calculate...
				$regular_physical_qty = $physical_stock;
				$admin_physical_qty = $qty - $admin_physical_stock;
				$final_physical_stock = 0;
				$final_admin_physical_stock =
					($admin_physical_stock - $admin_physical_qty) < 0
					? 0
					: $admin_physical_stock - $admin_physical_qty
				;
			}
			else
			{
				// otherwise, simply...
				$final_physical_stock = $physical_stock - $qty;
			}
		}
		else
		{
			// finally, get from admin stocks
			$final_admin_physical_stock =
				($admin_physical_stock - $qty) < 0
				? 0
				: $admin_physical_stock - $qty
			;
		}

		// check if necessary changes are required for final available stock
		// set or remove flag - stock => insufficient where necessary
		if (($final_admin_physical_stock - $final_admin_onorder_stock) <= 0)
		{
			$final_admin_available_stock = 0;
			if (isset($stocks_options['onorder'])) $stocks_options['stock'] = 'insufficient';
		}
		else
		{
			$final_admin_available_stock = $final_admin_physical_stock - $final_admin_onorder_stock;
		}

		// admin onorder stocks
		if ($product->admin_onorder_st_id)
		{
			$this->DB->where('st_id', $product->st_id);
			$this->DB->update('tbl_stock_admin_onorder', array($size_label => $final_admin_onorder_stock));
		}
		else
		{
			$this->DB->set('st_id', $product->st_id);
			$this->DB->set($size_label, $final_admin_onorder_stock);
			$this->DB->insert('tbl_stock_admin_onorder');
		}

		// admin physical stocks
		if ($product->admin_physical_st_id)
		{
			$this->DB->where('st_id', $product->st_id);
			$this->DB->update('tbl_stock_admin_physical', array($size_label => $final_admin_physical_stock));
		}
		else
		{
			$this->DB->set('st_id', $product->st_id);
			$this->DB->set($size_label, $final_admin_physical_stock);
			$this->DB->insert('tbl_stock_admin_physical');
		}

		// admin available stocks
		if ($product->admin_st_id)
		{
			$this->DB->where('st_id', $product->st_id);
			$this->DB->update('tbl_stock_admin', array($size_label => $final_admin_available_stock));
		}
		else
		{
			$this->DB->set('st_id', $product->st_id);
			$this->DB->set($size_label, $final_admin_available_stock);
			$this->DB->insert('tbl_stock_admin');
		}

		// check if necessary changes are required for final available stock
		// set or remove flag - stock => insufficient where necessary
		if (($final_physical_stock - $final_onorder_stock) <= 0)
		{
			$final_available_stock = 0;
			if (isset($stocks_options['onorder'])) $stocks_options['stock'] = 'insufficient';
		}
		else
		{
			$final_available_stock = $final_physical_stock - $final_onorder_stock;
			// all onorders are accounted by $stocks_options['onorder']
			// since, this condition is positive already, remove any flag stock=>insufficient
			if (isset($stocks_options['stock'])) unset($stocks_options['stock']);
		}

		// update records
		// stocks options and physical stocks
		$this->DB->where('st_id', $product->st_id);
		$this->DB->update(
			'tbl_stock',
			array(
				'options' => json_encode($stocks_options),
				$size_label => $final_physical_stock
			)
		);
		// onorder stocks
		if ($product->onorder_st_id)
		{
			$this->DB->where('st_id', $product->st_id);
			$this->DB->update('tbl_stock_onorder', array($size_label => $final_onorder_stock));
		}
		else
		{
			$this->DB->set('st_id', $product->st_id);
			$this->DB->set($size_label, $final_onorder_stock);
			$this->DB->insert('tbl_stock_onorder');
		}
		// available stocks
		if ($product->available_st_id)
		{
			$this->DB->where('st_id', $product->st_id);
			$this->DB->update('tbl_stock_available', array($size_label => $final_available_stock));
		}
		else
		{
			$this->DB->set('st_id', $product->st_id);
			$this->DB->set($size_label, $final_available_stock);
			$this->DB->insert('tbl_stock_available');
		}

		return TRUE;
	}

	// --------------------------------------------------------------------

	/**
	 * Return
	 *
	 * Returns stocks to available when orders are cancelled or returned
	 * Cancelled means to return from onorder to available
	 * Returned means to return to physical and available
	 *
	 * @return	boolean
	 */
	public function return()
	{
		if ( ! $this->prod_no && ! $this->color_code && ! $this->prod_sku && ! $this->size && ! $this->order_id)
		{
			// nothing more to do...
			return FALSE;
		}

		// load pertinent library/model/helpers
		$this->CI->load->library('products/product_details');
		$this->CI->load->library('products/size_names');

		// get product details
		if ($this->prod_sku)
		{
			$exp = explode('_', $this->prod_sku);
			$this->prod_no = $exp[0];
			$this->color_code = $exp[1];
		}
		$product = $this->CI->product_details->initialize(
			array(
				'tbl_product.prod_no' => $this->prod_no,
				'color_code' => $this->color_code
			)
		);

		// get size label
		$size = $this->size;
		$size_names = $this->CI->size_names->get_size_names($product->size_mode);
		$size_label = array_search($size, $size_names);
		$exp = explode('_', $size_label);
		$size_suffix = $exp[1];

		$qty = $this->qty;

		// remove reference to order id
		$is_for_cancel = FALSE; // false means item is return (refunded or store_credit)
		$stocks_options = $product->stocks_options;
		$stocks['onorder'] = @$stocks_options['onorder'] ?: array();
		$okey = array_search($this->order_id, $stocks['onorder']);
		if ($okey !== FALSE)
		{
			// since order_id is still noted as onorder meaning not yet shipped
			// thus, order is being cancelled
			unset($stocks['onorder'][$okey]);
			$is_for_cancel = TRUE;
		}
		if (!empty($stocks['onorder'])) $stocks_options['onorder'] = $stocks['onorder'];
		else unset($stocks_options['onorder']);

		// update stocks
		// this is now regardless if stock is 'admin_stocks_only'
		// we update regular stock first before admin stocks
		// in this case, add to regular stocks only
		// joe will update admin stocks where necessary

		// get physical stock and onorder stock
		$physical_label = 'physical_'.$size_suffix;
		$physical_stock = $product->$physical_label;
		$onorder_label = 'onorder_'.$size_suffix;
		$onorder_stock = $product->$onorder_label;

		// set final onorder stock
		// set final physical stock
		if ($is_for_cancel === TRUE)
		{
			// cancel - remove from onorder
			// return to available stock
			$final_onorder_stock = ($onorder_stock - $qty) <= 0 ? 0 : $onorder_stock - $qty;
			$final_physical_stock = $physical_stock;
		}
		else
		{
			// return - add to physical and available
			$final_onorder_stock = $onorder_stock;
			$final_physical_stock = $physical_stock + $qty;
		}

		// set final available stock
		// set or remove flag - stock => insufficient
		if (($final_physical_stock - $final_onorder_stock) <= 0)
		{
			$final_available_stock = 0;
			$stocks_options['stock'] = 'insufficient';
		}
		else
		{
			$final_available_stock = $final_physical_stock - $final_onorder_stock;
			// all onorders are accounted by $stocks_options['onorder']
			// since this condition is positive, remove any flag stock=>insufficient
			if (isset($stocks_options['stock'])) unset($stocks_options['stock']);
		}

		// update records

		// available stocks
		$this->DB->where('st_id', $product->st_id);
		$this->DB->update(
			'tbl_stock',
			array(
				$size_label => $final_available_stock,
				'options' => json_encode($stocks_options)
			)
		);
		// onorder stocks
		if ($product->onorder_st_id)
		{
			$this->DB->where('st_id', $product->st_id);
			$this->DB->update('tbl_stock_onorder', array($size_label => $final_onorder_stock));
		}
		else
		{
			$this->DB->set('st_id', $product->st_id);
			$this->DB->set($size_label, $final_onorder_stock);
			$this->DB->insert('tbl_stock_onorder');
		}
		// available stocks
		if ($product->physical_st_id)
		{
			$this->DB->where('st_id', $product->st_id);
			$this->DB->update('tbl_stock_physical', array($size_label => $final_physical_stock));
		}
		else
		{
			$this->DB->set('st_id', $product->st_id);
			$this->DB->set($size_label, $final_physical_stock);
			$this->DB->insert('tbl_stock_physical');
		}

		return TRUE;
	}

	// --------------------------------------------------------------------

}
// END Updatae Stocks Class

/* End of file Update_stocks.php */
/* Location: ./application/libraries/inventory/Update_stocks.php */
