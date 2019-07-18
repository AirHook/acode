<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Size_names {

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
	public function __construct()
	{
		// Set the super object to a local variable for use throughout the class
		$this->CI =& get_instance();

		// connect to database
		$this->DB = $this->CI->load->database('instyle', TRUE);

		log_message('info', 'Size Names Class Loaded');
	}

	// --------------------------------------------------------------------

	/**
	 * Update - update product clicks for today
	 *
	 * @return	array()
	 */
	public function get_size_names($size_mode = '')
	{
		if ($size_mode != '')
		{
			$this->DB->where('size_mode', $size_mode);
		}

		// get data
		$query = $this->DB->get('tblsize');

		$array = array();
		foreach ($query->result() as $row)
		{
			switch ($row->size_name)
			{
				case ('S'):
				case ('M'):
				case ('L'):
				case ('XL'):
				case ('XXL'):
				case ('XL1'):
				case ('XL2'):
				case ('S-M'):
				case ('M-L'):
				case ('ONE-SIZE-FITS-ALL'):
				case ('PRE-PACK-1221'):
					$array['size_s'.strtolower(str_replace('-', '', $row->size_name))] = $row->size_name;
				break;
				default:
					$array['size_'.strtolower(str_replace('-', '', $row->size_name))] = $row->size_name;
			}
		}

		return $array;
	}

	// --------------------------------------------------------------------

}
// END Size_names Class

/* End of file Size_name.php */
/* Location: ./application/libraries/products/Size_names.php */
