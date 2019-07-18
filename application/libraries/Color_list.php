<?php 
if ( ! defined('BASEPATH')) exit('ERROR: 404 Not Found');

/**
 * Color List Model Class
 *
 * This class lists all colors
 *
 * @package		CodeIgniter
 * @subpackage	Custom Library
 * @category	Colors, Color List
 * @author		WebGuy
 * @link		
 */
class Color_list
{
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
	public function __construct()
	{
		$this->CI =& get_instance();
		
		// connect to database
		$this->DB = $this->CI->load->database('instyle', TRUE);
		
		log_message('info', 'Facets Class Initialized');
	}

	// --------------------------------------------------------------------

	/**
	 * General color list
	 *
	 * @return	Object List or FALSE on failure
	 */
	public function select(array $param = array())
	{
		if ( ! empty($param))
		{
			$this->DB->where($param);
		}
		
		// order by
		$this->DB->order_by('color_name', 'asc');
		
		// get records
		$query = $this->DB->get('tblcolor');
		
		if ($query->num_rows() == 0)
		{
			// nothing more to do...
			return FALSE;
		}
		else
		{
			// return the object
			return $query->result();
		}
	}
	
	// --------------------------------------------------------------------

}
