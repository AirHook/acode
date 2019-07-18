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
	public function index($des_id = '')
	{
		/**
		// This controller is called by file upload jquery script dropzone
		// which uses ajax call making any flash data and redirects no bearing
		*/

		if ( ! empty($_FILES))
		{
			// let's grab the FILE array variables and process it
			$tempFile = $_FILES['file']['tmp_name']; // this also store file object into a temporary variable
			$filename = basename($_FILES['file']['name']);

			// set configs and initialize image upload class
			$config['tempFile'] = $tempFile;
			$config['filename'] = $filename;
			$config['attached_to'] = json_encode(array('designer'=>$des_id));
			$this->load->library('uploads/image_upload', $config);
			if ( ! $this->image_upload->upload())
			{
				// deinitialize library
				$this->image_upload->deinitialize();

				header($_SERVER["SERVER_PROTOCOL"]." 400 Bad Request");
				echo 'Upload Error';
				exit;

			}
			else
			{
				// upload succesful
				// let process data
				if ($this->input->post('field') == 'logo_light')
				{
					$post_ary['logo_image'] = $this->image_upload->image_url;
				}
				if ($this->input->post('field') == 'logo')
				{
					$post_ary['logo'] = $this->image_upload->image_url;
				}
				if ($this->input->post('field') == 'icon')
				{
					$post_ary['icon'] = $this->image_upload->image_url;
				}

				// update records
				if ( ! empty($post_ary))
				{
					// connect to database
					$DB = $this->load->database('instyle', TRUE);
					$DB->where('des_id', $des_id);
					$query = $DB->update('designer', $post_ary);
				}
				else
				{
					header($_SERVER["SERVER_PROTOCOL"]." 400 Bad Request");
					echo 'ERROR on data entry';
					exit;
				}
			}
		}
	}

	// ----------------------------------------------------------------------

}
