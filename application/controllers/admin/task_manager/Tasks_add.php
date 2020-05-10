<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tasks_add extends Admin_Controller {

	/**
	 * DB Reference
	 *
	 * @var	object
	 */
	protected $DB;

	// ----------------------------------------------------------------------

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
	public function index()
	{
		echo 'Processing...';

		if (
			! $this->input->post('title')
			OR ! $this->input->post('description')
			OR ! $this->input->post('project_id')
		)
		{
			$this->session->set_flashdata('error', 'edit');

			// redirect user
			if ($this->input->post('project_id'))
			{
				redirect('admin/task_manager/tasks/index/'.$this->input->post('project_id'), 'location');
			}
			else
			{
				redirect('admin/task_manager', 'location');
			}
		}

		// lets check for status of webspace and account
		$this->load->library('task_manager/tasks_list');

		// insert record
		$post_ary = $this->input->post();
		// set necessary variables
		//$post_ary['account_status'] = '1';
		// process some variables
		$post_ary['seque'] = $this->tasks_list->max_seque($this->input->post('project_id')) + 1;
		$post_ary['date_created'] = time();
		$post_ary['date_end_target'] = $this->input->post('due_date') ? strtotime($this->input->post('due_date')) : '0';
		$post_ary['user_id'] = $this->input->post('user_id') ?: NULL;
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
		redirect('admin/task_manager/tasks/index/'.$this->input->post('project_id'), 'location');
	}

	// ----------------------------------------------------------------------

}
