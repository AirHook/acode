<?php
if ( ! defined('BASEPATH')) exit('ERROR: 404 Not Found');

/**
 * General Images Upload Class
 *
 * This class' objective is to the following:
 *
 * 		1. 	Instanciate properties.
 * 		2.	Upload image with original $filename to uploads directory.
 *				Using ./yr/mo/ folder structure
 * 		3. 	Add suffix to filename to avoid duplications.
 *		4.	Save image on image library database
 *
 * @package		CodeIgniter
 * @subpackage	Custom Libraries
 * @category	Uploads, Product Image Upload
 * @author		WebGuy
 * @link
 */
class Image_unlink
{
	/**
	 * Media Library ID
	 *
	 * @var	string
	 */
	public $media_lib_id = '';

	/**
	 * This image is attached to where?
	 *
	 * @var	string
	 */
	public $attached_to_key = '';
	public $attached_to_value = '';

	/**
	 * Image Information
	 *
	 * @var	string
	 */
	public $image_url = '';

	/**
	 * Attache to - array of key -> value(id)
	 * of where image is attached to
	 *
	 * @var	string
	 */
	public $attached_to = [];


	/**
	 * Erro message
	 *
	 * @var	string
	 */
	public $error_message = '';


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

		// load pertinent library/model/helpers
		//$this->CI->load->library('image_lib');

		$this->initialize($params);
		log_message('info', 'Documentation Image Upload Class Initialized');
	}

	// --------------------------------------------------------------------

	/**
	 * Initialize Preferences
	 *
	 * This class must initialize the following:
	 *		$this->filename		=> Upload filename
	 *
	 * @param	array	$param	Initialization parameters
	 * @return	Page_details
	 */
	public function initialize(array $params)
	{
		if (empty($params))
		{
			// nothing more to do...
			return FALSE;
		}

		// initialize properties
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

		// a primary requirement for initialization to complete
		if ( ! $this->media_lib_id)
		{
			$this->error_message = "Media Lib ID missing.";

			// deinitialize class
			$this->deinitialize();

			// error intializing class, return false...
			return FALSE;
		}

		// get media details
		$this->DB->where('media_id', $this->media_lib_id);
		$q = $this->DB->get('media_library');
		$r = $q->row();

		// get media options to check for key and value pairs
		// indicating where the image is attached to
		$this->attached_to = json_decode($r->attached_to, TRUE);

		// get the media url
		$this->image_url = $r->media_url;

		return $this;
	}

	// --------------------------------------------------------------------

	/**
	 * PUBLIC - Unlink Image and remove from folder
	 *
	 * @return	boolean
	 */
	public function delunlink()
	{
		// unset attached to params if present
		if (
			isset($this->attached_to[$this->attached_to_key])
			&& $this->attached_to[$this->attached_to_key] == $this->attached_to_value
		)
		{
			unset($this->attached_to[$this->attached_to_key]);
		}

		// update records where necessary
		$this->DB->set('attached_to', json_encode($this->attached_to));
		$this->DB->where('media_id', $this->media_lib_id);
		$this->DB->update('media_library');

		// check are any other items using image?
		if (count($this->attached_to) == 0)
		{
			// if not, unlink image and remove from directory
			if (file_exists($this->image_url))
			{
				unlink($this->image_url);
			}

			// remove media lib details if there is no use anymore
			$this->DB->where('media_id', $this->media_lib_id);
			$this->DB->delete('media_library');

			// deinitialize class
			$this->deinitialize();
		}
	}

	// --------------------------------------------------------------------

	/**
	 * De-Initialize Preferences
	 *
	 * @param	array	$param	Initialization parameter - the item id
	 *					where admin_sales_email = $param
	 * @return	Page_details
	 */
	public function deinitialize()
	{
		$this->media_lib_id = '';
		$this->attached_to_key = '';
		$this->attached_to_value = '';
		$this->image_url = '';
		$this->attached_to = [];
		$this->error_message = '';
	}

	// --------------------------------------------------------------------

}
