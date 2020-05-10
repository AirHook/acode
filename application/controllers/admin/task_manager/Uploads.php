<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Uploads extends Admin_Controller {

	/**
	 * DB Object
	 *
	 * @var	object
	 */
	protected $DB;


	/**
	 * Constructor
	 *
	 * @return	void
	 */
	public function __construct()
	{
		parent::__construct();

		// connect to database
		$this->DB = $this->load->database('instyle', TRUE);
    }

	// ----------------------------------------------------------------------

	/**
	 * Index - default method
	 *
	 * Primary method to call when no other methods are found in url segment
	 * This method simply lists all sales pacakges
	 *
	 * @return	void
	 */
	public function index($task_id = '')
	{
		$this->output->enable_profiler(FALSE);

		if ( ! empty($_FILES))
		{
			/**
			 * Test input post
			 *
			header($_SERVER["SERVER_PROTOCOL"]." 400 Bad Request");
			echo 'FILE is present';
			exit;
			// */

			// let's grab the FILE array names
			$filehandle = $_FILES['file']['tmp_name'];
			$filename = $_FILES['file']['name'];
			$task_id = $this->input->post('task_id');

			// Check if image file is a actual image or fake image
			/* *
			$check = getimagesize($_FILES["file"]["tmp_name"]);
			if ($check === false)
			{
				// nothing more to do...
				header($_SERVER["SERVER_PROTOCOL"]." 400 Bad Request");
				echo 'Error reading image file. Please try uploading a new file.';
				exit;
			}
			// */

			// set configs and initialize product image upload class
			$config['tempFile'] = $_FILES['file']['tmp_name']; // this also stores file object into a temporary variable
			$config['filename'] = $_FILES['file']['name'];
			$config['attached_to'] = json_encode(array('task_manager'=>$task_id));
			$this->load->library('uploads/image_upload', $config);
			if ( ! $this->image_upload->upload())
			{
				// deinitialize class
				$this->image_upload->deinitialize();

				// send error...
				header($_SERVER["SERVER_PROTOCOL"]." 400 Bad Request");
				echo 'ERROR: '.$this->image_upload->error_message;
				exit;
			}
			else
			{
				// get records
				$this->DB->select('attachments');
				$q1 = $this->DB->get_where('tm_tasks', array('task_id'=>$task_id));
				$r1 = $q1->row();
				$attachments = $r1->attachments ? json_decode($r1->attachments, TRUE) : array();

				array_push($attachments, $this->image_upload->media_lib_id);

				// update records
				$this->DB->set('last_modified', $this_time);
				$this->DB->set('attachments', json_encode($attachments));
				$this->DB->where('task_id', $task_id);
				$q2 = $this->DB->update('tm_tasks');

				// set flashdata
				$this->session->set_flashdata('success', 'attach');

				// done
				exit;
			}
		}
		else
		{
			// send error...
			header($_SERVER["SERVER_PROTOCOL"]." 400 Bad Request");
			echo 'No FILE selected for upload';
			exit;
		}
	}

	// ----------------------------------------------------------------------

}
