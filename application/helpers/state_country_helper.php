<?php 
if ( ! defined('BASEPATH')) exit('ERROR: 404 Not Found');

/**
 * State & Country 
 *
 * Just list out states & countries for dropdown element
 *
 * @package		CodeIgniter
 * @subpackage	Custom Helpers
 * @category	Country, List Countries
 * @author		WebGuy
 * @link		
 */
 
// ------------------------------------------------------------------------

/**
 * List State
 *
 * List states as an object
 *
 * @access	public
 * @param	
 * @return	object
 */
	if ( ! function_exists('list_states'))
	{
		function list_states()
		{
			$CI =& get_instance();
			
			// connect to database
			$DB = $CI->load->database('instyle', TRUE);
			
			// get recrods
			$DB->order_by('state_id', 'ASC');
			return $DB->get('tblstates')->result();
		}
	}

// ------------------------------------------------------------------------

/**
 * List Country
 *
 * List countries as an object
 *
 * @access	public
 * @param	
 * @return	object
 */
	if ( ! function_exists('list_countries'))
	{
		function list_countries()
		{
			$CI =& get_instance();
			
			// connect to database
			$DB = $CI->load->database('instyle', TRUE);
			
			// get recrods
			$DB->order_by('seq', 'DESC');
			$DB->order_by('countries_name', 'ASC');
			return $DB->get('tblcountry')->result();
		}
	}


/* End of file Sate_country_helper.php */
/* Location: ./application/helpers/Sate_country_helper.php */