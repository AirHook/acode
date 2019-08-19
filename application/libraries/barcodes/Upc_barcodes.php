<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * UPC Barcodes
 *
 * This class generates barcode based on items on the list on a
 * per size basis using the stock id 'st_id' as a reference item number
 *
 * Helpful links on how-to's for UPC code:
 * https://electronics.howstuffworks.com/gadgets/high-tech-gadgets/upc.htm
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
	 * Stock ID - item number
	 *
	 * @var	string
	 */
	public $st_id = '';

	/**
	 * Stock ID - item number
	 *
	 * @var	string
	 */
	public $size_label = '';


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
					$this->$key = $val;
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
		if ( ! $this->upc_prefix)
		{
			// nothing more to do...
			//return FALSE;
		}

		// process the stock id
		for ($c = strlen($this->st_id);$c < 4;$c++)
		{
			$this->st_id = '0'.$this->st_id;
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
			case 'size_sl':
				$size_index = '3';
			break;
			case 'size_8':
			case 'size_sxl':
				$size_index = '4';
			break;
			case 'size_10':
			case 'size_sxxl':
				$size_index = '5';
			break;
			case 'size_12':
			case 'size_sxl1':
				$size_index = '6';
			break;
			case 'size_14':
			case 'size_sxl2':
				$size_index = '7';
			break;
			case 'size_16':
				$size_index = '8';
			break;
			case 'size_18':
				$size_index = '9';
			break;
		}

		$this->upc_prefix = $this->CI->config->item('upc_prefix');
		$digits11 = $this->upc_prefix.$this->st_id.$size_index;

		// let's get the check digit
		// add together the value of all of the digits in odd positions
		$odds = $digits11[0]
			+ $digits11[2]
			+ $digits11[4]
			+ $digits11[6]
			+ $digits11[8]
			+ $digits11[10]
		;
		// multiply that by 3
		$three = $odds * 3;
		// add together the value of all of the digits in even positions
		$evens = $digits11[1]
			+ $digits11[3]
			+ $digits11[5]
			+ $digits11[7]
			+ $digits11[9]
		;
		// add it to the value of $three
		$threeplus = $three + $evens;
		$check_digit = ($threeplus % 10) > 0 ? 10 - ($threeplus % 10) : ($threeplus % 10);
		$upc_barcode = $digits11.$check_digit;

		return $upc_barcode;
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
		// add together the value of all of the digits in odd positions
		$odds = $barcode[0]
			+ $barcode[2]
			+ $barcode[4]
			+ $barcode[6]
			+ $barcode[8]
			+ $barcode[10]
		;
		// multiply that by 3
		$three = $odds * 3;
		// add together the value of all of the digits in even positions
		$evens = $barcode[1]
			+ $barcode[3]
			+ $barcode[5]
			+ $barcode[7]
			+ $barcode[9]
		;
		// add it to the value of $three
		$threeplus = $three + $evens;
		$check_digit = ($threeplus % 10) > 0 ? 10 - ($threeplus % 10) : ($threeplus % 10);

		if ($check_digit == $barcode[11]) return TRUE;
		else return FALSE;
	}

	// ----------------------------------------------------------------------

}
