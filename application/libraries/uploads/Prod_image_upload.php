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
class Prod_image_upload
{
	/**
	 * FILE
	 *
	 * @var	string
	 */
	public $tempFile = '';
	public $filename = '';
	public $targetFile = '';
	public $endfilename = '';

	/**
	 * View
	 *	-	All images are now treated as a gallery for products.
	 * 	 	However, thie $view identifies image view as Front (_f) for main image,
	 *		Back (_b) for hover image, Side (_s) for alternate hove image,
	 *		Others (_o) for other gallery views.
	 *
	 * @var	string
	 */
	public $view = '';

	/**
	 * Designer ID
	 * Set via passed params/config settins
	 *
	 * @var	string
	 */
	public $des_id = '';

	/**
	 * Filename Parts
	 *
	 * @var	string
	 */
	public $prod_no = '';
	public $color_code = '';
	public $wholesale_price = FALSE;
	public $vendor_code = FALSE;

	/**
	 * Vendor ID
	 *
	 * @var	string
	 */
	public $vendor_id = FALSE;
	public $vendor_name = FALSE;

	/**
	 * Color Name
	 *
	 * @var	string
	 */
	public $color_name = '';

	/**
	 * Image Name - the <prod_no>_<color_code> filename structure
	 *
	 * @var	string
	 */
	public $img_name = '';

	/**
	 * Image URL and Path and Dimensions
	 *
	 * @var	string
	 */
	public $image_url = '';
	public $image_path = '';
	public $image_width = '';
	public $image_height = '';

	/**
	 * Filename Segment Count
	 *
	 * @var	int
	 */
	private $count_filename_segments = 0;

	/**
	 * Media upload version
	 // upload version is for depracation
	 // #3 of each view should suffice for the $endfilename_thumb
	 *
	 * @var	int
	 */
	private $upload_ver = 0;

	/**
	 * Media Libary Insert ID
	 *
	 * @var	string
	 */
	public $media_lib_id = '';

	/**
	 * Thumb sizes
	 *
	 * @var	array
	 */
	private $size = array(
		'1' => array(140, 210),
		'2' => array(60, 90),
		'3' => array(340, 510)
		//'4' => array(800, 1200)
	);

	/**
	 * This image is attached to?
	 * We will be setting this to $des_id
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
		$this->CI->load->library('image_lib');
		$this->CI->load->model('media_library');

		$this->initialize($params);
		log_message('info', 'Product Image Upload Class Initialized');
	}

	// --------------------------------------------------------------------

	/**
	 * Initialize Preferences
	 *
	 * This class must initialize the following:
	 *		$this->filename		=> Upload filename
	 *		$this->prod_no		=> The prod number taken from the filename
	 *		$this->color_code	=> The color code taken from the filename
	 *		$this->color_name	=> upon validating color code
	 *		$this->image_name
	 *		$this->wholesale_price
	 *		$this->vendor_code	=> taken from the filename
	 *		$this->vendor_id	=> upon validating vendor_code
	 *		$this->image_path
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

		// custom filename conventions
		// seg 1	- style number (prod_no)
		// seg 2	- color code (color_code)
		// seg 3	- wholesale price (wholesale_price)
		// seg 4	- vendor code (vendor_code)
		// seg 5	- currently is the camera shot sequence
		//			  can be used for other items in future
		$filename_parts = explode('.', $this->filename);
		$exp = explode('_', $filename_parts[0]);
		$this->count_filename_segments = count($exp);

		// set prod_no
		$this->prod_no = strtoupper(trim($exp[0]));

		// validate and set color_code which also sets color_name
		if (isset($exp[1]))
		{
			if ( ! $this->_get_color_name(strtoupper(trim($exp[1]))))
			{
				$this->error_message = '"Color Code is invalid."';

				// deinitialize class
				$this->deinitialize();

				// error intializing class, return false...
				return FALSE;
			}

			$this->color_code = strtoupper(trim($exp[1]));
		}

		// set image name
		$this->img_name = $this->prod_no.'_'.$this->color_code;

		// set wholesale_price
		if (isset($exp[2]))
		{
			$this->wholesale_price = strlen(trim($exp[2])) < 6 ? trim($exp[2]) : '0';
		}

		// validate and set vendor_code
		if (isset($exp[3]))
		{
			$vendor = $this->_get_vendor_id(trim($exp[3]));

			if ( ! $vendor)
			{
				$this->error_message = 'Vendor Code is invalid.';

				// deinitialize class
				$this->deinitialize();

				// error intializing class, return false...
				return FALSE;
			}

			$this->vendor_id = $vendor->vendor_id;
			$this->vendor_code = $vendor->vendor_code;
			$this->vendor_name = $vendor->vendor_name;
		}

		// set end filename and add suffix view
		$this->endfilename = $this->img_name.'_'.strtolower($this->view[0]).'.jpg';

		// we now know can surmise the image src url
		$this->image_url =
			$this->CI->config->item('PROD_IMG_URL')
			.$this->image_path
			.$this->endfilename
		;

		// at this point, we can now set image_url
		//$yr = @date('Y', time());
		//$mo = @date('m', time());
		//$this->image_path = 'uploads/products/'.$yr.'/'.$mo.'/';

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

		// set targetFile
		$this->targetFile = $this->image_path.$this->endfilename;

		return $this;
	}

	// --------------------------------------------------------------------

	/**
	 * PUBLIC - Upload Image (just upload media)
	 *
	 * This methods involve the following processes:
	 *		Setting $targetFile and $this->endfilename especially when $this->filename exists
	 *			adding a suffix '_u1' which signifies upload version serial no.
	 *		Then uploads the end $targetFile. The suffix helps indicate product image
	 *			version which is the latest.
	 *		After upload, we then create the images and thumbs for the product image:
	 *			- crop the center of the image a size of 40x40 for the coloricon
	 *			- the main image preserving size and with simple suffix _f, _b, _s, _o
	 *			  which is essentially the $this->image_url for the view (gallery)
	 *			- the different thumb size to use for uploading pages maximizing correct
	 *			  image size for the frontend image placeholder size
	 *			- the linesheet
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

		/**
		// UPLOAD
		// upload original file with origianl filename
		// use the suffix-ed filename to not overwrite previous uploads
		//
		// NOTICE: If the destination file already exists, it will be overwritten.
		*/
		if ( ! move_uploaded_file($this->tempFile, $this->targetFile))
		{
			$this->error_message = 'Error uploading of "'.$this->tempFile.'.';

			// deinitialize class
			$this->deinitialize();

			// nothing more to do...
			return FALSE;
		}
		// */

		/**
		 * Run Image Creation
		 *
		 *	main image (the standard <prod_no>_<color_code>_<f,b,s> with view suffix)
		 *	coloricon - <prod_no>_<color_code>_c.jpg
		 *  view thumbs - <prod_no>_<color_code>_f1[2,3,4].jpg
		 */

		// get image info
		$img = @GetImageSize($this->targetFile);
		if ( ! $img)
		{
			// catch errors
			$this->error_message = 'ERROR: Unable to read image.';

			// deinitialize class
			$this->deinitialize();

			// nothing more to do...
			return FALSE;
		}

		// let's grab the image dimension
		$this->image_width = $img[0];
		$this->image_height = $img[1];

		/**
		// COLORICON
		// crop the center of the image to create a coloricon
		// this is done for front view images only
		*/
		if ($this->view == 'front')
		{
			$config['image_library']	= 'gd2';
			$config['quality']			= '100%';
			$config['source_image'] 	= $this->targetFile;
			$config['new_image'] 		= $this->image_path.$this->img_name.'_c.jpg';
			$config['maintain_ratio'] 	= FALSE;
			$config['x_axis']         	= ($img[0] / 2) - 50; //20;
			$config['y_axis']       	= ($img[1] / 2) - 50; //20;
			$config['width']         	= 100;
			$config['height']       	= 100;
			$this->CI->image_lib->initialize($config);
			if ( ! $this->CI->image_lib->crop())
			{
				// catch errors
				//$this->error_message = $this->CI->image_lib->display_errors().' L361';
				$this->error_message = 'ERROR: Unable to create coloricon.';

				// deinitialize class
				$this->deinitialize();

				// nothing more to do...
				return FALSE;
			}
			$this->CI->image_lib->clear();
		}
		// */

		/**
		// THUMB
		// create the uploaded image thumb for medai library grid view use

		// #3 of each view should suffice for the $endfilename_thumb
		*
		$config['image_library']	= 'gd2';
		$config['quality']			= '100%';
		$config['source_image'] 	= $this->targetFile;
		$config['new_image'] 		= $this->image_path.$endfilename_thumb;
		$config['maintain_ratio'] 	= TRUE;
		$config['width']         	= 340;
		$config['height']       	= 510;
		$this->CI->image_lib->initialize($config);
		if ( ! $this->CI->image_lib->resize())
		{
			// catch errors
			//$this->error_message = $this->CI->image_lib->display_errors().' L385';
			$this->error_message = 'ERROR: Unable to main view image.';

			// deinitialize class
			$this->deinitialize();

			// nothing more to do...
			return FALSE;
		}
		$this->CI->image_lib->clear();
		// */

		/**
		// MAIN VIEW IMAGE (for view types)
		// create the main view image

		// MAIN VIEW is essentially created upon upload using $this->endfilename
		*
		$config['image_library']	= 'gd2';
		$config['quality']			= '100%';
		$config['source_image'] 	= $this->targetFile;
		$config['new_image'] 		= $this->image_path.$this->img_name.'_'.strtolower($this->view[0]).'.jpg';
		$config['maintain_ratio'] 	= TRUE;
		$config['width']         	= $img[0];
		$config['height']       	= $img[1];
		$this->CI->image_lib->initialize($config);
		if ( ! $this->CI->image_lib->resize())
		{
			// catch errors
			//$this->error_message = $this->CI->image_lib->display_errors().' L385';
			$this->error_message = 'ERROR: Unable to main view image.';

			// deinitialize class
			$this->deinitialize();

			// nothing more to do...
			return FALSE;
		}
		$this->CI->image_lib->clear();
		// */

		/**
		// GALLERY THUMBS
		// crunch the image
		*/
		foreach ($this->size as $key => $val)
		{
			$config['image_library']	= 'gd2';
			$config['quality']			= '100%';
			$config['source_image'] 	= $this->targetFile;
			$config['new_image'] 		= $this->image_path.$this->img_name.'_'.strtolower($this->view[0]).$key.'.jpg';
			$config['maintain_ratio'] 	= TRUE;
			$config['width']         	= $val[0];
			$config['height']       	= $val[1];
			$this->CI->image_lib->initialize($config);
			if ( ! $this->CI->image_lib->resize())
			{
				// catch errors
				//$this->error_message = $this->CI->image_lib->display_errors().' L411';
				$this->error_message = 'An error occurred crunching images.';

				// deinitialize class
				$this->deinitialize();

				// nothing more to do...
				return FALSE;
			}
			$this->CI->image_lib->clear();
		}
		// */

		/**
		 * LINESHEETS
		 */

		/**
		// get designer logo image and resize it where necessary
		*/
		$this->DB->where('des_id', $this->des_id);
		$query = $this->DB->get('designer')->row();
		if (isset($query))
		{
			// assuming roden theme assets
			//$des_logo = 'assets/roden_assets/images/'.$query->logo_image;

			// $query->logo_image is now used to save logo light for dark backgrounds
			$temp_logo = $query->logo_image;
			if (file_exists($query->logo_image))
			{
				$des_logo = $query->logo_image;
			}
			else $des_logo = $query->logo;
			$exp1 = explode('/', $des_logo);
			$logo_image_file = $exp1[count($exp1) - 1];

		}

		// we set the linesheet path at the top level directory to minimize
		// number of copies of temp images...
		$linesheet_temp_dir = 'uploads/linesheet_temp/';

		// and, create folder where necessary
		if ( ! file_exists($linesheet_temp_dir))
		{
			$old = umask(0);
			if ( ! mkdir($linesheet_temp_dir, 0777, TRUE))
			{
				$this->error_message = 'ERROR: Unable to create "'.$linesheet_temp_dir.'" folder.';

				// deinitialize class
				$this->deinitialize();

				// nothing more to do...
				return FALSE;
			}
			umask($old);
		}

		$config['image_library']	= 'gd2';
		$config['quality']			= '100%';
		$config['source_image'] 	= $des_logo;
		$config['new_image'] 		= $linesheet_temp_dir.$logo_image_file;
		$config['maintain_ratio'] 	= TRUE;
		$config['width']         	= 292;
		$config['height']       	= 47;
		$this->CI->image_lib->initialize($config);
		if ( ! $this->CI->image_lib->resize())
		{
			// catch errors
			//$this->error_message = $this->CI->image_lib->display_errors().' L577';
			$this->error_message = 'ERROR: Logo regeneration error.';

			// deinitialize class
			$this->deinitialize();

			// nothing more to do...
			return FALSE;
		}
		$this->CI->image_lib->clear();
		// */

		/**
		// create linesheet
		*/
		$this->CI->load->helper('create_linesheet');
		if ($img)
		{
			$create = create_linesheet_2(
				$img,
				$this->prod_no,
				$linesheet_temp_dir,
				$this->image_path,
				$this->img_name,
				$linesheet_temp_dir.$logo_image_file,
				$this->wholesale_price,
				$this->color_name
			);

			if ( ! $create)
			{
				// catch errors
				$this->error_message = 'Error in creating linesheet.';

				// deinitialize class
				$this->deinitialize();

				// nothing more to do...
				return FALSE;
			}
		}
		// */

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
			'media_url' => $this->image_url,
			'media_path' => $this->image_path,
			'media_dimensions' => $this->image_width.' x '.$this->image_height,
			'media_filename' => $this->endfilename,
			'media_name' => $this->img_name,
			'media_view' => $this->view,
			'upload_version' => ($this->upload_ver != 0 ? $this->upload_ver : ''),
			'attached_to' => $this->attached_to,
			'timestamp' => time()
		);
		$this->media_lib_id = $this->CI->media_library->insert_products($data_ary);

		return $this->media_lib_id;
	}

	// ----------------------------------------------------------------------

	/**
	 * PUBLIC - insert to media libary and return media_lib_id
	 *
	 * @return	string/boolean FALSE
	 */
	public function update_media_lib($media_id = '')
	{
		if ( ! $media_id)
		{
			// nothing more to do...
			return FALSE;
		}

		$data_ary = array(
			'media_url' => $this->image_url,
			'media_path' => $this->image_path,
			'media_dimensions' => $this->image_width.' x '.$this->image_height,
			'media_filename' => $this->endfilename,
			'media_name' => $this->img_name,
			'media_view' => $this->view,
			'upload_version' => ($this->upload_ver != 0 ? $this->upload_ver : ''),
			'attached_to' => $this->attached_to,
			'timestamp' => time()
		);
		$update = $this->CI->media_library->udpate_media_details($data_ary, $media_id);

		return $media_id;
	}

	// ----------------------------------------------------------------------

	/**
	 * PUBLIC - insert to media libary and return media_lib_id
	 *
	 * @return	string/boolean FALSE
	 */
	public function get_media_id()
	{
		$data_ary = array(
			'media_path' => $this->image_path,
			'media_filename' => $this->endfilename
		);
		$q = $this->CI->media_library->get_media_details($data_ary);

		if ($q)
		{
			$this->media_lib_id = $q->media_id;
			return $this->media_lib_id;
		}
		else return FALSE;
	}

	// ----------------------------------------------------------------------

	/**
	 * PRIVATE - Get vendor id given vendor code
	 *
	 * @params	string
	 * @return	string/boolean FALSE
	 */
	private function _get_vendor_id($str)
	{
		// get recrods
		$this->DB->where('vendor_code', $str);
		$q = $this->DB->get('vendors');

		if ($q->num_rows() > 0)
		{
			return $q->row();
		}
		else return FALSE;
	}

	// ----------------------------------------------------------------------

	/**
	 * PRIVATE - Get color name given color code
	 *
	 * @params	string
	 * @return	string/boolean FALSE
	 */
	private function _get_color_name($str)
	{
		// get recrods
		$this->DB->where('color_code', $str);
		$q = $this->DB->get('tblcolor');

		if ($q->num_rows() > 0)
		{
			$this->color_name = $q->row()->color_name;

			return $this;
		}
		else return FALSE;
	}

	// --------------------------------------------------------------------

	/**
	 * Initialize Preferences
	 *
	 * @param	array	$param	Initialization parameter - the item id
	 *					where admin_sales_email = $param
	 * @return	Page_details
	 */
	public function deinitialize()
	{
		$this->tempFile = '';
		$this->filename = '';
		$this->endfilename = '';
		$this->view = '';
		$this->des_id = '';
		$this->prod_no = '';
		$this->color_code = '';
		$this->color_name = '';
		$this->img_name = '';
		$this->image_url = '';
		$this->count_filename_segments = 0;
		$this->media_lib_id = '';
		$this->wholesale_price = FALSE;
		$this->vendor_code = FALSE;
		$this->vendor_id = '';
		$this->upload_ver = 0;
	}

	// --------------------------------------------------------------------

}
