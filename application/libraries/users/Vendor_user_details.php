<?php
if ( ! defined('BASEPATH')) exit('ERROR: 404 Not Found');

/**
 * Vendor User Details Class
 *
 * @package		CodeIgniter
 * @subpackage	Custom Libraries
 * @category	Users, Vendor User Details
 * @author		WebGuy
 * @link
 */
class Vendor_user_details
{
	/**
	 * Vendor User info
	 *
	 * @var	strings
	 */
	public $vendor_id = '';
	public $vendor_name = '';
	public $vendor_email = '';
	public $vendor_code = '';

	public $contact_1 = '';
	public $contact_email_1 = '';
	public $contact_2 = '';
	public $contact_email_2 = '';
	public $contact_3 = '';
	public $contact_email_3 = '';

	public $address1 = '';
	public $address2 = '';
	public $city = '';
	public $country = '';
	public $state = '';
	public $zipcode = '';
	public $telephone = '';
	public $fax = '';

	public $vendor_type_id = '';
	public $vendor_type = '';
	public $vendor_type_slug = '';

	public $reference_designer = '';
	public $designer = '';

	public $options = array();

	/**
	 * Is Active
	 *
	 * @var	boolean
	 */
	public $status = 0;


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
	 * @param	array	$param	Initialization parameter - the item id
	 *					where admin_sales_email = $param
	 * @return	void
	 */
	public function __construct($param = array())
	{
		$this->CI =& get_instance();

		// connect to database
		$this->DB = $this->CI->load->database('instyle', TRUE);

		$this->initialize($param);
		log_message('info', 'Page Details Class Initialized');
	}

	// --------------------------------------------------------------------

	/**
	 * Initialize Preferences
	 *
	 * @param	array	$param	Initialization parameter - the item id
	 *					where email = $param
	 * @return	Page_details
	 */
	public function initialize(array $params = array())
	{
		if ( ! empty($params))
		{
			foreach ($params as $key => $val)
			{
				if ($val !== '')
				{
					$this->DB->where($key, $val);
				}
			}
		}
		// nothing more to do...
		else return FALSE;

		// selects
		$this->DB->select('vendors.*');
		$this->DB->select('
			designer.designer,
			designer.url_structure
		');
		$this->DB->select('vendor_types.id, vendor_types.type, vendor_types.slug');

		// joins
		$this->DB->join('designer', 'designer.folder = vendors.reference_designer', 'left');
		$this->DB->join('vendor_types', 'vendor_types.id = vendors.vendor_type_id', 'left');

		// order by
		$this->DB->order_by('vendors.vendor_name', 'ASC');

		// get records
		$query = $this->DB->get('vendors');

		//echo $this->DB->last_query(); die('<br />DIED');

		$row = $query->row();

		// return object or FALSE on failure
		if (isset($row))
		{
			// initialize properties
			$this->vendor_id = $row->vendor_id;
			$this->vendor_name = $row->vendor_name;
			$this->vendor_email = $row->vendor_email;
			$this->vendor_password = $row->password;
			$this->vendor_code = $row->vendor_code;

			$this->contact_1 = $row->contact_1;
			$this->contact_email_1 = $row->contact_email_1;
			$this->contact_2 = $row->contact_2;
			$this->contact_email_2 = $row->contact_email_2;
			$this->contact_3 = $row->contact_3;
			$this->contact_email_3 = $row->contact_email_3;

			$this->address1 = $row->address1;
			$this->address2 = $row->address2;
			$this->city = $row->city;
			$this->country = $row->country;
			$this->state = $row->state;
			$this->zipcode = $row->zipcode;
			$this->telephone = $row->telephone;
			$this->fax = $row->fax;

			$this->vendor_type_id = $row->id;
			$this->vendor_type = $row->type;
			$this->vendor_type_slug = $row->slug;

			$this->reference_designer = $row->reference_designer;	// slug
			$this->designer = $row->designer;	// designer name

			$this->status = $row->is_active;

			$this->options = $row->options != '' ? json_decode($row->options , TRUE) : array();

			return $this;
		}
		else
		{
			return FALSE;
		}
	}

	// --------------------------------------------------------------------

	/**
	 * Reset Password when forgotten
	 *
	 * @return	string
	 */
	public function reset_password($password = '')
	{
		if ( ! $password)
		{
			// nothing more to do...
			return FALSE;
		}

		// get recrods
		$this->DB->set('password', $password);
		$this->DB->where('vendor_email', $this->email);
		$query = $this->DB->update('vendors');

		return $this->DB->affected_rows();
	}

	// --------------------------------------------------------------------

	/**
	 * Universally SET Admin Sales only session
	 *
	 * @return	void
	 */
	public function set_session()
	{
		// this is legacy method and redundancy method
		$sesdata = array(
			'vendor_loggedin'			=> TRUE,
			'vendor_id'					=> $this->vendor_id
		);
		$this->CI->session->set_userdata($sesdata);

		// forward compatibility
		$_SESSION['vendor_loggedin'] = TRUE;
		$_SESSION['vendor_id'] = $this->vendor_id;
	}

	// --------------------------------------------------------------------

	/**
	 * Universally Unset Admin Sales only and related session
	 *
	 * @return	void
	 */
	public function unset_session()
	{
		if (CI_VERSION < '3')
		{
			// this is here for backwards compatibility
			$sesdata = array(
				'vendor_loggedin'			=> FALSE,
				'vendor_id'					=> '',
				'vendor_login_time'			=> ''		// related to session_lapse property
			);
			$this->CI->session->unset_userdata($sesdata);
		}
		else
		{
			// this is legacy method and redundancy method
			$sesdata = array(
				'vendor_loggedin',
				'vendor_id',
				'vendor_login_time'
			);
			$this->CI->session->unset_userdata($sesdata);
		}

		// for redundancy purposes...
		// and forward compatibility
		if (isset($_SESSION['vendor_loggedin'])) unset($_SESSION['vendor_loggedin']);
		if (isset($_SESSION['vendor_id'])) unset($_SESSION['vendor_id']);
		if (isset($_SESSION['vendor_login_time'])) unset($_SESSION['vendor_login_time']);
	}

	// --------------------------------------------------------------------

	/**
	 * Forcefully activate current user
	 *
	 * A short method to force activation of a user like in a case where user
	 * is inactive and yet clicked on a sales package campaign received from
	 * his email
	 *
	 * @return	void
	 */
	public function activate_user()
	{
		$this->DB->set('is_active', '1');
		$this->DB->where('vendor_id', $this->vendor_id);
		$query = $this->DB->update('vendors');

		$this->status = '1';
	}

	// --------------------------------------------------------------------

	/**
	 * Set Initial State of Class Properties
	 *
	 * @return	void
	 */
	public function set_initial_state()
	{
		// reset properties to default
		$this->vendor_id = '';
		$this->vendor_name = '';
		$this->vendor_email = '';

		$this->contact_1 = '';
		$this->contact_email_1 = '';
		$this->contact_2 = '';
		$this->contact_email_2 = '';
		$this->contact_3 = '';
		$this->contact_email_3 = '';

		$this->address1 = '';
		$this->address2 = '';
		$this->city = '';
		$this->country = '';
		$this->state = '';
		$this->zipcode = '';
		$this->telephone = '';
		$this->fax = '';

		$this->vendor_type_id = '';
		$this->vendor_type = '';
		$this->vendor_type_slug = '';

		$this->reference_designer = '';
		$this->designer = '';

		$this->status = 0;
		$this->options = array();
	}

	// --------------------------------------------------------------------

}
