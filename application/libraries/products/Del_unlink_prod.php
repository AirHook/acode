<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Delete Product and Unlink Product Images Class
 *
 * This class deletes and entire product item and all it's variants
 * and unlink all related product images
 *
 *
 * @package		CodeIgniter
 * @subpackage	Custom Libraries
 * @category	Products
 * @author		WebGuy
 * @link
 */
class Del_unlink_prod extends Admin_Controller {

	/**
	 * Product ID
	 *
	 * @var	string
	 */
	public $prod_id = '';

	/**
	 * Stock ID
	 * For deleting only one variant of an entire product
	 *
	 * @var	string
	 */
	public $st_id = '';


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
	public function initialize(array $params = array())
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
	 * Delete Items and Unlink Images
	 *
	 * @return	void
	 */
	public function delunlink()
	{
		if ( ! $this->prod_id)
		{
			// nothing more to do...
			return FALSE;
		}

		// load pertinent library/model/helpers
		$this->CI->load->library('products/product_details');
		$this->CI->load->library('products/products_list');

		// initialize product details
		$params['tbl_product.prod_id'] = $this->prod_id;
		if ($this->st_id) $params['tbl_stock.st_id'] = $this->st_id;
		$this->CI->product_details->initialize($params);

		// set path to images
		// to do this, get category slugs, designer slug, and image path
		// $this->product_details->category_slugs - array of category slugs
		$category_slugs = implode('/', $this->CI->product_details->category_slugs);
		$designer_slug = $this->CI->product_details->designer_slug;
		$image_path = 'uploads/products/'.$designer_slug.'/'.$category_slugs;

		// process variants
		if ($this->st_id)
		{
			$image_name = $this->CI->product_details->prod_no.'_'.$this->CI->product_details->color_code;

			$this->_unlink_images($image_path, $image_name);

			// delete onorder and physical stocks
			$this->DB->delete('tbl_stock', array('st_id' => $this->st_id));
			$this->DB->delete('tbl_stock_onorder', array('st_id' => $this->st_id));
			$this->DB->delete('tbl_stock_physical', array('st_id' => $this->st_id));
		}
		else
		{
			if ($this->CI->product_details->available_colors())
			{
				foreach ($this->CI->product_details->available_colors() as $color)
				{
					$image_name = $this->CI->product_details->prod_no.'_'.$color->color_code;

					$this->_unlink_images($image_path, $image_name);

					// delete onorder and physical stocks
					$this->DB->delete('tbl_stock_onorder', array('st_id' => $color->st_id));
					$this->DB->delete('tbl_stock_physical', array('st_id' => $color->st_id));
				}
			}

			$this->DB->delete('tbl_stock', array('prod_no' => $this->CI->product_details->prod_no));
			$this->DB->delete('tbl_product', array('prod_no' => $this->CI->product_details->prod_no));
		}

		// deinitialize properties
		$this->CI->product_details->deinitialize();

		return TRUE;
	}

	// ----------------------------------------------------------------------

	/**
	 * Unlink Image
	 *
	 * @return	void
	 */
	private function _unlink_images($image_path, $image_name)
	{
		// unlink product images
		foreach (array('f','b','s','c') as $view)
		{
			if (file_exists($image_path.'/'.$image_name.'_'.$view.'.jpg'))
				unlink($image_path.'/'.$image_name.'_'.$view.'.jpg');
			if (file_exists($image_path.'/'.$image_name.'_'.$view.'1.jpg'))
				unlink($image_path.'/'.$image_name.'_'.$view.'1.jpg');
			if (file_exists($image_path.'/'.$image_name.'_'.$view.'2.jpg'))
				unlink($image_path.'/'.$image_name.'_'.$view.'2.jpg');
			if (file_exists($image_path.'/'.$image_name.'_'.$view.'3.jpg'))
				unlink($image_path.'/'.$image_name.'_'.$view.'3.jpg');
			if (file_exists($image_path.'/'.$image_name.'_'.$view.'4.jpg'))
				unlink($image_path.'/'.$image_name.'_'.$view.'4.jpg');
		}

		// unlink linesheet
		if (file_exists($image_path.'/'.$image_name.'_linesheet.jpg'))
			unlink($image_path.'/'.$image_name.'_linesheet.jpg');
	}

	// ----------------------------------------------------------------------

}
