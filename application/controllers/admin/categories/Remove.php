<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Remove extends Admin_Controller {

	/**
	 * Constructor
	 *
	 * @return	void
	 */
	public function __construct()
	{
		parent::__construct();
    }
	
	// ----------------------------------------------------------------------
	
	/**
	 * Index - Activate Item
	 *
	 * @return	void
	 */
	public function index($category_id = '', $designer = '')
	{
		if ( ! $category_id OR ! $designer)
		{
			// nothing more to do...
			echo 'no id...';
		}
		
		// load pertinent library/model/helpers
		$this->load->library('categories/category_details');
		$this->category_details->initialize(array('category_id' => $category_id));
		
		// Let us take some category details into an array
		$linked_designers = 
			is_array($this->category_details->linked_designers) 
			? $this->category_details->linked_designers 
			: explode(',', $this->category_details->linked_designers)
		;
		$icon_images = 
			is_array($this->category_details->icons) 
			? $this->category_details->icons 
			: explode(',', $this->category_details->icons)
		;
		
		// set the path of the uploaded file destination
		$targetDir = 'images/subcategory_icon/thumb/';
		
		// check if icons images is assoc
		$is_assoc = $this->_is_assoc($linked_designers);
		
		// since this is remove icon, designer is pressumably linked
		// get key of designer input post
		$key = array_search($designer, $linked_designers);
		
		// if no key, assume icon image is for general purposes
		if ($key !== FALSE)
		{
			if ($is_assoc)
			{
				$filename =  $icon_images[$key];
				$icon_images[$key] = '';
			}
			else
			{
				$filename =  $icon_images[$key + 1];
				$icon_images[$key + 1] = '';
			}
		}
		else
		{
			if ($is_assoc)
			{
				$filename =  $icon_images['general'];
				unset($icon_images['general']);
			}
			else
			{
				$filename =  $icon_images[0];
				$icon_images[0] = '';
			}
		}
		
		// remove file from server
		$targetFile = $targetDir.$filename;
		if (file_exists($targetFile)) unlink($targetFile);
		
		// reconstruct data
		$icon_image = $is_assoc ? json_encode($icon_images) : implode(',', $icon_images);
		
		// connect to database
		$DB = $this->load->database('instyle', TRUE);
		
		// update records
		$DB->set('icon_image', $icon_image);
		$DB->where('category_id', $category_id);
		$DB->update('categories');

		echo 'DONE!';
	}
	
	// ----------------------------------------------------------------------
	
	private function _is_assoc(array $arr)
	{
		if (array() === $arr) return false;
		return array_keys($arr) !== range(0, count($arr) - 1);
	}
	
	// ----------------------------------------------------------------------
	
}