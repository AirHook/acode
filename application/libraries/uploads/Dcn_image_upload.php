<?php
if ( ! defined('BASEPATH')) exit('ERROR: 404 Not Found');

/**
 * Product Image Upload Class
 *
 * This class' objective is to the following:
 *
 * 		1. 	Instanciate properties.
 * 		2.	Upload main prod image with original $filenme to uploads directory.
 * 		3. 	Disect $filename different segments and process each item and
 *			assign to respective properties.
 * 		4.	Generate different images, thumbs, coloricon, and linesheets
 *		5.	Save image on image library database
 * 		6.	Add to product database records (this can be done by the controller)
 *		7.  Pass data to doo (use another library for this)
 *
 * @package		CodeIgniter
 * @subpackage	Custom Libraries
 * @category	Uploads, Product Image Upload
 * @author		WebGuy
 * @link
 */
class Dcn_image_upload
{
	/**
	 * FILE
	 *
	 * @var	string
	 */
	public $tempFile = '';
	public $filename = '';

	/**
	 * Image Path and source URL
	 *
	 * @var	string
	 */
	public $image_url = '';
	public $image_path = '';


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

		// currently no database involved in dcn image insertion
		// connect to database
		//$this->DB = $this->CI->load->database('instyle', TRUE);

		// load pertinent library/model/helpers
		$this->CI->load->library('image_lib');

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
		if ( ! $this->filename)
		{
			$this->error_message = '"Upload file is missing."';

			// deinitialize class
			$this->deinitialize();

			// error intializing class, return false...
			return FALSE;
		}

		// at this point, we can now set image_url
		$yr = @date('Y', time());
		$mo = @date('m', time());
		$this->image_path = 'uploads/'.$yr.'/'.$mo.'/';

		// and, create folder where necessary
		if ( ! file_exists($this->image_path))
		{
			$old = umask(0);
			if ( ! mkdir($this->image_path, 0777, TRUE))
			{
				$this->error_message = 'ERROR: Unable to create "'.$this->image_path.'" folder.';

				// deinitialize class
				$this->deinitialize();

				// nothing more to do...
				return FALSE;
			}
			umask($old);
		}

		return $this;
	}

	// --------------------------------------------------------------------

	/**
	 * PUBLIC - Upload Image
	 *
	 * @return	boolean
	 */
	public function upload()
	{
		// if tempFile has gone empty, return FALSE
		if ( ! $this->tempFile)
		{
			$this->error_message = 'Upload file is missing.';

			// deinitialize class
			$this->deinitialize();

			// nothing more to do...
			return FALSE;
		}

		// set target file (still original upload filename)
		$targetFile = $this->image_path.$this->filename;

		// if for some reason, image file name is existing already
		// we rename targetFile and add suffix accordingly
		$i = 1;
		while (file_exists($targetFile))
		{
			$filename_parts = explode('.', $this->filename);
			$filename_parts[0] = $filename_parts[0].'_'.$i;
			$targetFile = $this->image_path.(implode('.', $filename_parts));
			$i++;
		}

		/**
		// UPLOAD
		// upload original file with origianl filename
		// use the suffix-ed filename to not overwrite previous uploads
		*/
		if ( ! move_uploaded_file($this->tempFile, $targetFile))
		{
			$this->error_message = 'Error uploading of "'.$this->tempFile.'.';

			// deinitialize class
			$this->deinitialize();

			// nothing more to do...
			return FALSE;
		}
		// */

		$this->image_url = $targetFile;

		// everything went well
		return $this;
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
		$this->tempFile = '';
		$this->filename = '';
		$this->image_url = '';
		$this->image_path = '';
		$this->error_message = '';
	}

	// --------------------------------------------------------------------

}
