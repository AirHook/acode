<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tasks_add extends Admin_Controller {

	/**
	 * DB Reference
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
	 * Index - Activate Account
	 *
	 * @return	void
	 */
	public function index($project_id = '')
	{
		echo 'Processing...';

		if (
			! $this->input->post('title')
			&& ! $this->input->post('description')
			&& ! $this->input->post('due_date')
			&& ! $this->input->post('user_id')
		)
		{
			$this->session->set_flashdata('error', 'edit');

			// redirect user
			redirect('admin/task_manager/tasks/index/'.$project_id, 'location');
		}

		// insert record
		$post_ary = $this->input->post();
		// set necessary variables
		//$post_ary['account_status'] = '1';
		// process some variables
		$post_ary['project_id'] = $project_id;
		$post_ary['date_start'] = time();
		$post_ary['date_end_target'] = strtotime($this->input->post('due_date'));
		// unset unneeded variables
		unset($post_ary['due_date']);

		$query = $this->DB->insert('tm_tasks', $post_ary);

		// set flash data
		if ($query)
		{
			$this->session->set_flashdata('success', 'add');
		}
		else
		{
			$this->session->set_flashdata('error', 'add');
		}

		// redirect user
		redirect('admin/task_manager/tasks/index/'.$project_id, 'location');
	}

	// ----------------------------------------------------------------------

}
