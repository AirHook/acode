<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Upload_images extends Admin_Controller {

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
	 * Index - default method
	 *
	 * @return	void
	 */
	public function index()
	{
		/**
		// This controller is called by file upload jquery script dropzone
		// which uses ajax call making any flash data and redirects no bearing
		*/

		// -----------------------------------------
		// ---> All Views
		if ( ! empty($_FILES))
		{
			// let's grab the FILE array variables and process it
			$tempFile = $_FILES['file']['tmp_name']; // this also store file object into a temporary variable
			$filename = basename($_FILES['file']['name']);

			// set the path of the uploaded file destination
			$targetDir = 'images/subcategory_icon/thumb/';
			$targetFile = $targetDir.$filename;

			// Check if file already exists
			// will need to rename to avoid dups
			if (file_exists($targetFile))
			{
				// let us rename the file being upload by adding a suffix
				$path_parts = pathinfo($targetFile);
				$i = 1;
				$temp1 = $targetFile;
				while (file_exists($temp1))
				{
					$filename_portion = basename($targetFile, '.'.$path_parts['extension']);
					$new_file = $filename_portion.'-'.$i.'.'.$path_parts['extension'];
					$temp1 = $targetDir . $new_file;
					$i++;
				}
				$targetFile = $temp1;
			}

			// move upload file to destination
			move_uploaded_file($tempFile, $targetFile);

			// let's grab the posts
			$category_id = $this->input->post('category_id');
			$designer =	$this->input->post('designer');

			// load pertinent library/model/helpers
			$this->load->library('categories/category_details');
			$this->category_details->initialize(array('category_id' => $category_id));

			// Let us take some category details into an array
			//$linked_designers = explode(',', $this->category_details->designers);
			//$icon_images = explode(',', $this->category_details->icons);
			$linked_designers =
				is_array($this->category_details->linked_designers)
				? $this->category_details->linked_designers
				: explode(',', $this->category_details->linked_designers)
			;
			$icon_images =
				is_array($this->category_details->icons)
				? $this->category_details->icons
				: ($this->category_details->icons ? explode(',', $this->category_details->icons) : array())
			;

			// check if icons images is assoc
			$is_assoc = $this->_is_assoc($linked_designers);

			// get key of designer input post
			// if no key, assume icon image is for general purposes
			// then set the icon image to respective array key element
			$key = $designer != '' ? array_search($designer, $linked_designers) : FALSE;

			// NOTE: the assumption is that when the linked designers is still a csv string
			// we still save the icon images in the old csv string data which follows the
			// order of the designer slugs in the linked_designers variable.
			// By the time linked_designers is converted into assoc array, icon images
			// would have been converted too. If not, it will be converted at the next
			// edit category details page which will still follow the order of the linked_designers
			// in the initial process.

			// if designer is linked...
			if ($key !== FALSE)
			{
				// check if $key from an assoc array
				if ($is_assoc)
				{
					$key = $designer;
				}
				else $key += 1;
			}
			else
			{
				if ($is_assoc)
				{
					$key = 'general';
				}
				else $key = 0;
			}

			// set the icon image to array element
			$icon_images[$key] = @$new_file ? $new_file : $filename;

			// we used to set data as csv string
			// but now we start saving it on json format
			if ($is_assoc) $icon_image = json_encode($icon_images);
			else $icon_image = implode(',', $icon_images);

			// connect to database
			$DB = $this->load->database('instyle', TRUE);

			// update records
			$DB->set('icon_image', $icon_image);
			$DB->where('category_id', $category_id);
			$DB->update('categories');
		}
	}

	// ----------------------------------------------------------------------

	private function _is_assoc(array $arr)
	{
		if (array() === $arr) return false;
		return array_keys($arr) !== range(0, count($arr) - 1);
	}

	// ----------------------------------------------------------------------

}
