<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Class Reserve Stocks
 *
 * Reserve stocks sets a stock quantity from available to onorder
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
	 * @return	Order_details
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

		$qty = $this->qty;

		// set the order id accordingly
		$stocks_options = $product->stocks_options;
		$stocks['onorder'] = @$stocks_options['onorder'] ?: array();
		array_push($stocks['onorder'], $this->order_id);
		$stocks_options['onorder'] = $stocks['onorder'];

		// get current stock and update accordingly
		$availabe_stock = $product->$size_label;
		$final_available_stock = ($availabe_stock - $qty) < 0 ? 0 : $availabe_stock - $qty;

		// get on order stock and update accordingly
		$onorder_label = 'onorder_'.$size_suffix;
		$onorder_stock = $product->$onorder_label;
		$final_onorder_stock = $onorder_stock + $qty;

		// update records
		$this->DB->where('st_id', $product->st_id);

		// available stocks
		$this->DB->update(
			'tbl_stock',
			array(
				$size_label => $final_available_stock,
				'options' => json_encode($stocks_options)
			)
		);
		// onorder stocks
		$this->DB->update('tbl_stock_onorder', array($size_label => $final_onorder_stock));

		return TRUE;
	}

	// --------------------------------------------------------------------

	/**
	 * Reserve
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

		// remove from onorder stock
		$onorder_label = 'onorder_'.$size_suffix;
		$onorder_stock = $product->$onorder_label;
		$final_onorder_stock = ($onorder_stock - $qty) < 0 ? 0 : $onorder_stock - $qty;

		// remove from physical stock
		$physical_label = 'physical_'.$size_suffix;
		$physical_stock = $product->$physical_label;
		$final_physical_stock = ($physical_stock - $qty) < 0 ? 0 : $physical_stock - $qty;

		// check if necessary changes are required for final availabe stock
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
		$this->DB->where('st_id', $product->st_id);

		// available stocks
		$this->DB->update('tbl_stock', array('options'=>json_encode($stocks_options)));
		// onorder stocks
		$this->DB->update('tbl_stock_onorder', array($size_label=>$final_onorder_stock));
		// physical stocks
		$this->DB->update('tbl_stock_physical', array($size_label=>$final_physical_stock));

		return TRUE;
	}

	// --------------------------------------------------------------------

	/**
	 * Reserve
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

		// remove the order id on cancelled orders
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
			$final_onorder_stock = ($onorder_stock - $qty) <= 0 ? 0 : $onorder_stock - $qty;
			$final_physical_stock = $physical_stock;
		}
		else
		{
			// return - add to physical
			$final_onorder_stock = $onorder_stock;
			$final_physical_stock = $physical_stock + $qty;
		}

		// set final availabe stock
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
			// since, this condition is positive already, remove any flag stock=>insufficient
			if (isset($stocks_options['stock'])) unset($stocks_options['stock']);
		}

		// update records
		$this->DB->where('st_id', $product->st_id);

		// available stocks
		$this->DB->update(
			'tbl_stock',
			array(
				$size_label => $final_available_stock,
				'options' => json_encode($stocks_options)
			)
		);
		// onorder stocks
		$this->DB->update('tbl_stock_onorder', array($size_label => $final_onorder_stock));
		// physical stocks
		$this->DB->update('tbl_stock_physical', array($size_label => $final_physical_stock));

		return TRUE;
	}

	// --------------------------------------------------------------------

}
// END Updatae Stocks Class

/* End of file Update_stocks.php */
/* Location: ./application/libraries/inventory/Update_stocks.php */
