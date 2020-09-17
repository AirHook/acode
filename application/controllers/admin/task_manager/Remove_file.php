<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Remove_file extends Admin_Controller {

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
	public function index($media_id = '', $task_id = '')
	{
		$this->output->enable_profiler(FALSE);

		// load pertinent library/model/helpers
		$this->load->library('uploads/image_unlink');

		// initialize class
		$params['media_lib_id'] = $media_id;
		$params['attached_to_key'] = 'task_manager';
		$params['attached_to_value'] = $task_id;
		$this->image_unlink->initialize($params);

		// remove file
		$this->image_unlink->delunlink();

		// redirect user back to task details page
		redirect('admin/task_manager/task_details/index/'.$task_id, 'location');
	}

	// ----------------------------------------------------------------------

}
