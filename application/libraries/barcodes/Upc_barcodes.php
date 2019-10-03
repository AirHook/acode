<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * UPC Barcodes
 *
 * This class generates barcode based on items on the list on a
 * per size basis using the stock id 'st_id' as a reference item number
 *
 * Exisintg products and with sizes withtin size 0 to size 18 (size mode A/1)
 * to which also encompases other size labels, we do not record it on the
 * upc_item_numbers db table... only custom item number assigned to
 * any of the following:
 *
 *		1.	Items not existing on product list
 *		2.	Items existing but with size label 20 and 22
 *
 * Helpful links on how-to's for UPC code:
 * https://electronics.howstuffworks.com/gadgets/high-tech-gadgets/upc.htm
 *
 *
 	NOTE:
	There is a need to do a function to clean up upc_item_numbers custom item numbers
	for those items that initially is not in the product list to give way on those
	item numbers for use on other items...
 *
 *
 * @package		CodeIgniter
 * @subpackage	Custom Libraries
 * @category	Barcodes UPC
 * @author		WebGuy
 * @link
 */
class Upc_barcodes
{
	/**
	 * UPC Prefix - company assigned 6-digit prefix number
	 *
	 * @var	string
	 */
	public $upc_prefix = '';

	/**
	 * Stock ID - item number first part
	 *
	 * @var	string
	 */
	public $st_id = '';

	/**
	 * Size Label - for item number last part
	 * Size Mode - for size specifity on validation
	 *
	 * @var	string
	 */
	public $size_label = '';
	public $size_mode = '';

	/**
	 * Prod Number - esp when item is not yet uploaded to product list
	 * <prod_no>
	 *
	 * @var	string
	 */
	public $prod_no = '';

	/**
	 * Max st_id - threshold for item numbers
	 *
	 * @var	string
	 */
	public $max_st_id = '';

	/**
	 * Lowest custom item number
	 *
	 * @var	string
	 */
	public $min_custom_item_number = '';


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
	 * @params	array	$params	Initialization parameter - the item id
	 *					where prod_id = $params
	 * @return	void
	 */
	public function __construct($params = array())
	{
		$this->CI =& get_instance();

		// connect to database
		$this->DB = $this->CI->load->database('instyle', TRUE);

		// set the company prefix
		$this->upc_prefix = $this->CI->config->item('upc_prefix');

		// set max st_id
		$this->_max_st_id();

		// set availalbe lowest custom item number
		$this->_min_custom_item_number();

		$this->initialize($params);
		log_message('info', 'Delete and Unlink Product Class Initialized');
	}

	// --------------------------------------------------------------------

	/**
	 * Initialize Properties
	 *
	 * @param	array	$param	Initialization parameter - the item id
	 *					where admin_sales_email = $param
	 * @return	Page_details
	 */
	public function initialize($params = array())
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

	// ----------------------------------------------------------------------

	/**
	 * Generate Shop7 valid UPC barcode number
	 *
	 * @return	void
	 */
	public function generate()
	{
		// process the stock id by adding zeros in front for length less than 4
		if ($this->st_id != '')
		{
			for ($c = strlen($this->st_id);$c < 4;$c++)
			{
				$this->st_id = '0'.$this->st_id;
			}
		}

		// process the size_label
		switch ($this->size_label)
		{
			case 'size_0':
			case 'size_ss':
			case 'size_ssm':
			case 'size_sprepack1221':
			case 'size_sonesizefitsall':
				$size_index = '0';
			break;
			case 'size_2':
			case 'size_sm':
			case 'size_sml':
				$size_index = '1';
			break;
			case 'size_4':
			case 'size_sl':
				$size_index = '2';
			break;
			case 'size_6':
			case 'size_sxl':
				$size_index = '3';
			break;
			case 'size_8':
			case 'size_sxxl':
				$size_index = '4';
			break;
			case 'size_10':
			case 'size_sxl1':
				$size_index = '5';
			break;
			case 'size_12':
			case 'size_sxl2':
				$size_index = '6';
			break;
			case 'size_14':
				$size_index = '7';
			break;
			case 'size_16':
				$size_index = '8';
			break;
			case 'size_18':
				$size_index = '9';
			break;
			case 'size_20':
			case 'size_22':
				$size_index = '-';
			break;
		}

		// set the item number...
		// by default, item number is a max 4-digit stock id
		// and a 5th digit identifying the respective size
		// in increments from smallest to largest and 0-9 respectively
		// unfortunately, size mode A has siz 20 and 22 out of the 0-9
		// reference. we then assign a 6 digit item number going down
		// starting from 99999 assigning it to that specifc stock number
		// and size label, e.g., 99999 - st_id# 1234, size_20. reuse item
		// number when stock level is zero
		if ($size_index != '-' && $this->st_id != '')
		{
			// default
			$item_number = $this->st_id.$size_index;
		}
		else $item_number = $this->_get_item_number(); // custom item number

		// set the 11 digit product code
		$digits11 = $this->upc_prefix.$item_number;

		// let's get the check digit
		$check_digit = $this->_check_digit($digits11);

		// complet the upc number code
		$upc_barcode = $digits11.$check_digit;

		return $upc_barcode;
	}

	// --------------------------------------------------------------------

	/**
	 * PRIVATE - Get Custom Item Number for Sizes 20 and 22 and non-existing items
	 *
	 * @return	string numeric
	 */
	private function _get_item_number()
	{
		if ( ! $this->min_custom_item_number)
		{
			// first time setting custom item number
			$first_custom_item_number = '99999';
			$data = array(
				'item_number' => $first_custom_item_number,
				'prod_no' => $this->prod_no,
				'st_id' => $this->st_id, // including empty st_id (non existing product)
				'size_label' => $this->size_label
			);
			$q1 = $this->DB->insert('upc_item_numbers', $data);

			return $first_custom_item_number;
		}

		// check for existing assigned item number
		$this->DB->select('item_number');
		$this->DB->from('upc_item_numbers');
		$this->DB->where('prod_no', $this->prod_no);
		$this->DB->where('st_id', $this->st_id);
		$this->DB->where('size_label', $this->size_label);
		$q2 = $this->DB->get();
		$r2 = $q2->row();

		if (isset($r2))
		{
			$existing_item_number = $r2->item_number;
			return $existing_item_number;
		}

		/*
		Conditions:
		1. existing products with size 20 or 22
		2. non-existing product
			a. non-existing product with size 20 or 22
			b. non-existing product with encompassing size label
		*/

		// get highest assigned item number from existing custom item numbers
		// focusing on size 20 and 22 that is no longer used due to no stock
		// see NOTE on start comment of the this class
		$this->DB->select('item_number');
		$this->DB->select('
			(CASE
				WHEN upc_item_numbers.size_label="size_20" THEN tbl_stock.size_20
				WHEN upc_item_numbers.size_label="size_22" THEN tbl_stock.size_20
			END) AS size_stock
		');
		$this->DB->from('upc_item_numbers');
		$this->DB->join('tbl_stock', 'tbl_stock.st_id = upc_item_numbers.st_id', 'left');
		$this->DB->having('size_stock', '0');
		$this->DB->order_by('item_number', 'DESC');
		$q3 = $this->DB->get();
		$r3 = $q3->row(); // we need the first row only

		if (isset($r3))
		{
			$new_assignment = $r3->item_number;

			// update the assignment with new info
			$this->DB->set('prod_no', $this->prod_no);
			$this->DB->set('st_id', $this->st_id);
			$this->DB->set('size_label', $this->size_label);
			$this->DB->where('item_number', $new_assignment);
			$q4 = $this->DB->udpate('upc_item_numbers');

			return $new_assignment;
		}

		// if all else fails, set new lowest item number
		$new_low = $this->min_custom_item_number - 1;
		$data = array(
			'item_number' => $new_low,
			'prod_no' => $this->prod_no,
			'st_id' => $this->st_id,
			'size_label' => $this->size_label
		);
		$q5 = $this->DB->insert('upc_item_numbers', $data);

		// update property
		$this->_min_custom_item_number();

		return $new_low;
	}

	// --------------------------------------------------------------------

	/**
	 * Validate Shop7 UPC Barcode Number
	 *
	 * @return	boolean
	 */
	public function validate($barcode)
	{
		// validate $barcode as numbers only
		if (
			strlen($barcode) != 12
			OR ! preg_match ('/^[0-9]*$/', $barcode)
		)
		{
			return FALSE;
		}

		// let's get the check digit
		$check_digit = $this->_check_digit($barcode);

		// verify and return
		if ($check_digit == $barcode[11])
		{
			// set some properties
			$this->_is_custom_item_no($barcode);

			return TRUE;
		}
		else return FALSE;
	}

	// --------------------------------------------------------------------

	/**
	 * Validate Shop7 UPC Barcode Number
	 *
	 * @return	boolean
	 */
	public function _is_custom_item_no($barcode)
	{
		$x_st_id = ltrim($barcode[6].$barcode[7].$barcode[8].$barcode[9], '0');

		$this->DB->where('item_number', $x_st_id.$barcode[10]);
		$q6 = $this->DB->get('upc_item_numbers');
		$r6 = $q6->row();

		// set st_id and/or size_label
		if (isset($r6))
		{
			// custom item properties
			$this->st_id = $r6->st_id;
			$this->size_label = $r6->size_label;
		}
		else
		{
			// real product properties
			$this->st_id = $x_st_id;

			// determine size label using barcode[10] and product size mode
			$this->CI->load->library('products/product_details');

			// get product details
			$product = $this->CI->product_details->initialize(
				array(
					'tbl_stock.st_id' => $x_st_id
				)
			);

			$this->size_mode = $product->size_mode;

			// get size lable
			switch ($barcode[10])
			{
				//case 'size_0':  ->  size mode 1
				//case 'size_ss':  ->  size mode 0
				//case 'size_ssm':  ->  size mode 3
				//case 'size_sprepack1221':  ->  size mode 2
				//case 'size_sonesizefitsall':  ->  size mode 4

				case '0':
					if ($this->size_mode == '1') $this->size_label = 'size_0';
					if ($this->size_mode == '0') $this->size_label = 'size_ss';
					if ($this->size_mode == '3') $this->size_label = 'size_ssm';
					if ($this->size_mode == '2') $this->size_label = 'size_sprepack1221';
					if ($this->size_mode == '4') $this->size_label = 'size_sonesizefitsall';
				break;
				case '1':
					if ($this->size_mode == '1') $this->size_label = 'size_2';
					if ($this->size_mode == '0') $this->size_label = 'size_sm';
					if ($this->size_mode == '3') $this->size_label = 'size_sml';
				break;
				case '2':
					if ($this->size_mode == '1') $this->size_label = 'size_4';
					if ($this->size_mode == '0') $this->size_label = 'size_sl';
				break;
				case '3':
					if ($this->size_mode == '1') $this->size_label = 'size_6';
					if ($this->size_mode == '0') $this->size_label = 'size_sxl';
				break;
				case '4':
					if ($this->size_mode == '1') $this->size_label = 'size_8';
					if ($this->size_mode == '0') $this->size_label = 'size_sxxl';
				break;
				case '5':
					if ($this->size_mode == '1') $this->size_label = 'size_10';
					if ($this->size_mode == '0') $this->size_label = 'size_sxl1';
				break;
				case '6':
					if ($this->size_mode == '1') $this->size_label = 'size_12';
					if ($this->size_mode == '0') $this->size_label = 'size_sxl2';
				break;
				case '7':
					if ($this->size_mode == '1') $this->size_label = 'size_14';
				break;
				case '8':
					if ($this->size_mode == '1') $this->size_label = 'size_16';
				break;
				case '9':
					if ($this->size_mode == '1') $this->size_label = 'size_18';
				break;
			}
		}

		return;
	}

	// --------------------------------------------------------------------

	/**
	 * PRIVATE - Get/Set check digit
	 *
	 * @return	string numeric
	 */
	private function _check_digit($code)
	{
		// do this process on the first 11 digits of the code
		// add together the value of all of the digits in odd positions
		$odds = $code[0]
			+ $code[2]
			+ $code[4]
			+ $code[6]
			+ $code[8]
			+ $code[10]
		;
		// multiply that by 3
		$three = $odds * 3;
		// add together the value of all of the digits in even positions
		$evens = $code[1]
			+ $code[3]
			+ $code[5]
			+ $code[7]
			+ $code[9]
		;
		// add it to the value of $three
		$threeplus = $three + $evens;
		$check_digit = ($threeplus % 10) > 0 ? 10 - ($threeplus % 10) : ($threeplus % 10);

		return $check_digit;
	}

	// --------------------------------------------------------------------

	/**
	 * PRIVATE - Get max st_id on record as threshold for barcode item number
	 *
	 * @return	string object
	 */
	private function _max_st_id()
	{
		$this->DB->select('MAX(st_id) AS max_st_id');
		$this->DB->from('tbl_stock');
		$q7 = $this->DB->get();
		$r7 = $q7->row();
		if (isset($r7))
		{
			$this->max_st_id = $r7->max_st_id;
		}
		else $this->max_st_id = FALSE;
	}

	// --------------------------------------------------------------------

	/**
	 * PRIVATE - Get minimum custom item number on record
	 * Setting custom item number starts from 99999 downwards
	 * both for items with sizes 20 and 22 (size mode A/1)
	 * and for items on PO that is not existing in product list
	 *
	 * @return	string object
	 */
	private function _min_custom_item_number()
	{
		$this->DB->select('MIN(item_number) AS min_custom_item_number');
		$this->DB->from('upc_item_numbers');
		$q8 = $this->DB->get();

		//$q8 = $this->DB->query("SELECT MIN(item_number) AS min_custom_item_number FROM upc_item_numbers");

		$r8 = $q8->row();
		if (isset($r8))
		{
			$this->min_custom_item_number = $r8->min_custom_item_number;
		}
		else $this->min_custom_item_number = FALSE;
	}

	// ----------------------------------------------------------------------

}
