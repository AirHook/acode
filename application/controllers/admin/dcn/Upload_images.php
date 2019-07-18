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
		// disable profiler
		$this->output->enable_profiler(FALSE);

		// upload the image
		if ( ! empty($_FILES))
		{
			/**
			 * Test input post
			 *
			header($_SERVER["SERVER_PROTOCOL"]." 400 Bad Request");
			echo '<pre>';
			print_r($_FILES);
			die();
			// */

			// load pertinent library/model/helpers
			$this->load->model('media_library');
			$this->load->library('uploads/dcn_image_upload');

			// Check if image file is a actual image or fake image
			$check = getimagesize($_FILES["image"]["tmp_name"]);
			if($check === false)
			{
				header($_SERVER["SERVER_PROTOCOL"]." 400 Image File Error");
				echo 'Error reading image file. Please try uploading a new file.';
				exit;
			}

			// set params
			$config['tempFile'] = $_FILES['image']['tmp_name'];
			$config['filename'] = $_FILES['image']['name'];

			if ($this->dcn_image_upload->initialize($config))
			{
				/* */
				// upload image
				$upload = $this->dcn_image_upload->upload();
				// return on error upload
				if ( ! $upload)
				{
					// deinitialize class
					$this->dcn_image_upload->deinitialize();

					// send error...
					header($_SERVER["SERVER_PROTOCOL"]." 400 Bad Request");
					echo $this->dcn_image_upload->error_message;
					exit;
				}
				// */

				echo base_url().$this->dcn_image_upload->image_url;
			}
		}
		else
		{
			// send error...
			header($_SERVER["SERVER_PROTOCOL"]." 400 No FILES");
			echo 'No FILE selected for upload';
			exit;
		}
	}

	// ----------------------------------------------------------------------

}
