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
class Image_upload
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
	public $image_width = '';
	public $image_height = '';

	/**
	 * Image Information
	 *
	 * @var	string
	 */
	public $image_url = '';
	public $image_path = '';

	/**
	 * Media Library ID
	 *
	 * @var	string
	 */
	public $media_lib_id = '';
	public $media_filename = '';

	/**
	 * This image is attached to?
	 *
	 * @var	string
	 */
	public $attached_to = '';


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
		if ( ! $this->filename)
		{
			$this->error_message = '"Upload file is missing."';

			// deinitialize class
			$this->deinitialize();

			// error intializing class, return false...
			return FALSE;
		}

		// set media filename
		$this->media_filename = $this->filename;

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

		// let us also get image dimensions
		list($this->image_width, $this->image_height) = getimagesize($this->tempFile);

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

		// if for some reason, image file name already exists
		// we rename targetFile and add suffix accordingly
		$i = 1;
		while (file_exists($targetFile))
		{
			$filename_parts = explode('.', $this->filename);
			$filename_parts[0] = $filename_parts[0].'_'.$i;

			// set new media filename as it is changed here
			$this->media_filename = implode('.', $filename_parts);

			$targetFile = $this->image_path.$this->media_filename;
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

		// let's save the info to media library
		$this->media_lib_id = $this->insert_to_media_lib();

		// everything went well
		return $this;
	}

	// ----------------------------------------------------------------------

	/**
	 * PUBLIC - insert to media libary and return media_lib_id
	 *
	 * @return	string/boolean FALSE
	 */
	public function insert_to_media_lib()
	{
		$data_ary = array(
			'media_url' => $this->image_url, // generated in this class
			'media_path' => $this->image_path, // generated in this class
			'media_filename' => $this->media_filename, // provide as params
			'media_dimensions' => ($this->image_width.' x '.$this->image_height), // provided as params
			'attached_to' => ($this->attached_to ?: ''), // provided as config and json ecoded
			'timestamp' => time()
		);
		$this->DB->insert('media_library', $data_ary);
		$this->media_lib_id = $this->DB->insert_id();

		return $this->media_lib_id;
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
		$this->image_width = '';
		$this->image_height = '';
		$this->image_url = '';
		$this->image_path = '';
		$this->media_lib_id = '';
		$this->attached_to = '';
		$this->error_message = '';
	}

	// --------------------------------------------------------------------

}
