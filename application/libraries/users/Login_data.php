<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login_data {

	var $login_data_use_database	= TRUE;
	var $login_data_table_name		= 'tbl_login_detail_wholesale';
	var $time_reference				= 'time';
	
	// Private variables.  Do not change!
	var $now;
	var $login_data;
	
	/**
	 * DB Object
	 *
	 * @return	object
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
	
		// Set the "now" time.  Can either be GMT or server time, based on the
		// config prefs.  We use this to set the "last activity" time
		$this->now = $this->_get_time();
		
		// connect to database
		$this->DB = $this->CI->load->database('instyle', TRUE);
		
		log_message('info', 'Product List Class Loaded and Initialized');
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Store Login Data
	 *
	 * @return	void
	 */
	public function login_data_store($user_email, $logindata = '')
	{
		// if no logindata, nothing to do anymore...
		if ( ! $logindata) return;
		
		// get last login details
		$last_login = $this->get_last_login(array('email' => $user_email));
		
		// is there current logindata... 
		// NOTE: if with login on same day, current logindata will read the data
		if ($last_login->logindata)
		{
			if ($this->_isJSON($last_login->logindata))
			{
				$curr_logindata = json_decode($last_login->logindata, TRUE);
			}
			else $curr_logindata = $this->_unserialize($last_login->logindata);
			
			// add new lodindata if not yet in array
			// page visits
			if ($logindata['page_visits'] && ! in_array($logindata['page_visits'], $curr_logindata['page_visits'])) 
			{
				array_push($curr_logindata['page_visits'], $logindata['page_visits']);
			}
			
			// product clicks
			if ($logindata['product_clicks']) 
			{
				array_push($curr_logindata['product_clicks'], $logindata['product_clicks']);
			}
			
			// set to new logindata
			$new_logindata['page_visits'] = $curr_logindata['page_visits'];
			$new_logindata['product_clicks'] = $curr_logindata['product_clicks'];
		}
		else
		{
			// set new logindata
			$new_logindata['page_visits'] = array($logindata['page_visits']);
			$new_logindata['product_clicks'] = $logindata['product_clicks'] ? array($logindata['product_clicks']) : array();
		}

		// phasing out serializing of data
		// and using json_encode instead
		/*
		// serialize new login data
		$this->login_data = array(
			'logindata'	=> $this->_serialize($new_logindata)
		);
		*/
		$this->login_data = array(
			'logindata'	=> json_encode($new_logindata)
		);
		
		// Save the data to the DB if needed
		if ($this->login_data_use_database === TRUE)
		{
			$this->DB->query($this->DB->update_string($this->login_data_table_name, $this->login_data, "log_id = '".$last_login->log_id."'"));
		}
	}

	// --------------------------------------------------------------------

	/**
	 * Get user number of visits (wholesale)
	 *
	 * Uses:
	 * wholesale/authenticated
	 * @return	object
	 */
	public function get_number_of_visits($email = '')
	{
		if ( ! $email) return FALSE;
		
		$this->DB->select('email');
		$this->DB->from('tbl_login_detail_wholesale');
		$this->DB->where('email', $email);
		$this->DB->group_by('email');
		$q = $this->DB->count_all_results();
		
		return $q;
	}
	
	// --------------------------------------------------------------------

	/**
	 * Get last login details (wholesale)
	 *
	 * Uses:
	 * login_data
	 * @return	object/boolean false
	 */
	public function get_last_login($params)
	{
		$this->DB->select('*');
		$this->DB->from('tbl_login_detail_wholesale');
		foreach($params as $key => $val)
		{
			$this->DB->where($key, $val);
		}
		$this->DB->order_by('create_date', 'desc');
		$this->DB->order_by('create_time', 'desc');
		$q = $this->DB->get();
		
		if (count($params) >= 1) return $q->row();
		else if ($q->num_rows() > 0) return $q->result();
		else return FALSE;
	}
	
	// --------------------------------------------------------------------

	/**
	 * Serialize an array
	 *
	 * This function first converts any slashes found in the array to a temporary
	 * marker, so when it gets unserialized the slashes will be preserved
	 *
	 * @access	private
	 * @param	array
	 * @return	string
	 */
	private function _serialize($data)
	{
		if (is_array($data))
		{
			foreach ($data as $key => $val)
			{
				if (is_string($val))
				{
					$data[$key] = str_replace('\\', '{{slash}}', $val);
				}
			}
		}
		else
		{
			if (is_string($data))
			{
				$data = str_replace('\\', '{{slash}}', $data);
			}
		}

		return serialize($data);
	}

	// --------------------------------------------------------------------

	/**
	 * Unserialize
	 *
	 * This function unserializes a data string, then converts any
	 * temporary slash markers back to actual slashes
	 *
	 * @access	private
	 * @param	array
	 * @return	string
	 */
	private function _unserialize($data)
	{
		if ( ! $data) return FALSE; // nothing do anymore...
		
		$this->CI->load->helper('string');
		
		$data = @unserialize(strip_slashes($data));
		
		if ( ! $data) return FALSE;

		if (is_array($data))
		{
			foreach ($data as $key => $val)
			{
				if (is_string($val))
				{
					$data[$key] = str_replace('{{slash}}', '\\', $val);
				}
			}

			return $data;
		}

		return (is_string($data)) ? str_replace('{{slash}}', '\\', $data) : $data;
	}

	// --------------------------------------------------------------------

	/**
	 * Get the "now" time
	 *
	 * @access	private
	 * @return	string
	 */
	private function _get_time()
	{
		if (strtolower($this->time_reference) == 'gmt')
		{
			$now = time();
			$time = mktime(gmdate("H", $now), gmdate("i", $now), gmdate("s", $now), gmdate("m", $now), gmdate("d", $now), gmdate("Y", $now));
		}
		else
		{
			$time = time();
		}

		return $time;
	}

	// --------------------------------------------------------------------

	/**
	 * Check for JSON string
	 *
	 * @access	private
	 * @return	string
	 */
	private function _isJSON($string)
	{
		return is_string($string) && is_array(json_decode($string, true)) && (json_last_error() == JSON_ERROR_NONE) ? TRUE : FALSE;
	}

	// --------------------------------------------------------------------

}
// END Mycookie Class

/* End of file Mycookie.php */
/* Location: ./application/libraries/Mycookie.php */