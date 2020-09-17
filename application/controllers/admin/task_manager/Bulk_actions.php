<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Bulk_actions extends Admin_Controller {

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
	 * Index - Bulk Actions
	 *
	 * Execute actions selected on bulk action dropdown to multiple selected
	 * sales pakcages
	 *
	 * @return	void
	 */
	public function index()
	{
		echo 'Processing...';

		// connect to database
		$DB = $this->load->database('instyle', TRUE);

		// set database set clause based on bulk_action for activate and suspend
		switch ($this->input->post('bulk_action'))
		{
			case 'ac':
				$DB->set('status', '1');
			break;

			case 'de':
				$DB->set('status', '0');
			break;

			case 'ur':
				$DB->set('status', '2');
			break;
		}

		// iterate through the selected checkboxes and where clause
		foreach ($this->input->post('checkbox') as $key => $id)
		{
			if ($key === 0) $DB->where('project_id', $id);
			else $DB->or_where('project_id', $id);

			// iterate through each project if delete
			if ($this->input->post('bulk_action') === 'del')
			{
				// load pertinent library/model/helpers
				$this->load->library('task_manager/tasks_list');
				$this->load->library('task_manager/project_task_details');
				$this->load->library('uploads/image_unlink');

				// get the task list first
				$tasks = $this->tasks_list->select(
					array(
						'project_id' => $id
					)
				);

				// get attachments for each task
				foreach ($tasks as $task)
				{
					// get the data
					$task_details = $this->project_task_details->initialize(
						array(
							'task_id' => $task->task_id
						)
					);
					$attachments = $this->project_task_details->attachments();

					// unlink attachments first
					foreach ($attachments as $attachment)
					{
						// initialize class
						$params['media_lib_id'] = $attachment->media_id;
						$params['attached_to_key'] = 'task_manager';
						$params['attached_to_value'] = $task->task_id;
						$this->image_unlink->initialize($params);

						// remove file
						$this->image_unlink->delunlink();
					}

					// delete any chats link to task
					$this->DB->where('task_id', $task->task_id);
					$this->DB->delete('tm_chats');

					// finally, delete task record
					$this->DB->where('task_id', $task->task_id);
					$this->DB->delete('tm_tasks');
				}
			}
		}

		// update or delete items from database
		if ($this->input->post('bulk_action') === 'del')
		{
			// delete project
			$DB->delete('tm_projects');

			// set flash data
			$this->session->set_flashdata('success', 'delete');
		}
		else
		{
			$DB->update('tm_projects');

			// set flash data
			$this->session->set_flashdata('success', 'edit');
		}

		// redirect user
		redirect('admin/task_manager/projects');
	}

	// ----------------------------------------------------------------------

}
