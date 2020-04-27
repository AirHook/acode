<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Task_edit extends Admin_Controller {

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
	 * Index - Add New Account
	 *
	 * @return	void
	 */
	public function index()
	{
		echo 'Processing...<br />';

		if (
			! $this->input->post('title')
			OR ! $this->input->post('description')
			OR ! $this->input->post('task_id')
		)
		{
			$this->session->set_flashdata('error', 'edit');

			// redirect user
			redirect('admin/task_manager/task_details/index/'.$this->input->post('task_id'), 'location');
		}

		// update record
		$post_ary = $this->input->post();
		// set necessary variables
		//$post_ary['account_status'] = '1';
		// process some variables
		$post_ary['last_modified'] = time();
		// unset unneeded variables
		unset($post_ary['task_id']);

		$this->DB->where('task_id', $this->input->post('task_id'));
		$query = $this->DB->update('tm_tasks', $post_ary);

		//echo $this->DB->last_query(); die();

		// set flash data
		if ($query)
		{
			$this->session->set_flashdata('success', 'edit');
		}
		else
		{
			$this->session->set_flashdata('error', 'edit');
		}

		// redirect user
		redirect('admin/task_manager/task_details/index/'.$this->input->post('task_id'), 'location');
	}

	// ----------------------------------------------------------------------

	/**
	 * Constructor
	 *
	 * @return	void
	 */
	public function seque()
	{
		$this->output->enable_profiler(FALSE);

		foreach ($this->input->post('list_json') as $key => $value)
		{
			$this->DB->set('last_modified', time());
			$this->DB->set('seque', $key + 1);
			$this->DB->where('task_id', $value['task_id']);
			$this->DB->update('tm_tasks');
		}

		echo 'done';
    }

	// ----------------------------------------------------------------------

	/**
	 * Method Status
	 *
	 * @return	void
	 */
	public function status($task_id = '', $project_id = '', $status = '')
	{
		if ($task_id == '' OR $project_id == '' OR $status == '')
		{
			// nothing more to do...
			// set flash data
			$this->session->set_flashdata('error', 'no_id_passed');

			// redirect user
			if ($project_id)
			{
				redirect('admin/task_manager/tasks/index/'.$project_id, 'location');
			}
			else
			{
				redirect('admin/task_manager/projects', 'location');
			}
		}

		// update records
		$this->DB->set('last_modified', time());
		$this->DB->set('status', $status);
		$this->DB->where('task_id', $task_id);
		$this->DB->update('tm_tasks');

		// set flash data
		$this->session->set_flashdata('success', 'edit');

		// redirect user
		redirect('admin/task_manager/tasks/index/'.$project_id, 'location');
    }

	// ----------------------------------------------------------------------

	/**
	 * Method Accept
	 *
	 * @return	void
	 */
	public function urgent($task_id = '', $project_id = '', $urgent = '')
	{
		if (
			$task_id == ''
			OR $project_id == ''
			OR $urgent == ''
		)
		{
			// nothing more to do...
			// set flash data
			$this->session->set_flashdata('error', 'no_id_passed');

			// redirect user
			if ($project_id)
			{
				redirect('admin/task_manager/tasks/index/'.$project_id, 'location');
			}
			else
			{
				redirect('admin/task_manager/projects', 'location');
			}
		}

		if ($urgent)
		{
			$this->DB->set('urgent', '1');
		}
		else
		{
			$this->DB->set('urgent', '0');
		}

		// update records
		$this->DB->set('last_modified', time());
		$this->DB->where('task_id', $task_id);
		$this->DB->update('tm_tasks');

		// set flash data
		$this->session->set_flashdata('success', 'edit');

		// redirect user
		redirect('admin/task_manager/tasks/index/'.$project_id, 'location');
    }

	// ----------------------------------------------------------------------

	/**
	 * Method Delete
	 *
	 * @return	void
	 */
	public function delete($task_id = '', $project_id = '')
	{
		if (
			$task_id == ''
			OR $project_id == ''
		)
		{
			// nothing more to do...
			// set flash data
			$this->session->set_flashdata('error', 'no_id_passed');

			// redirect user
			if ($project_id)
			{
				redirect('admin/task_manager/tasks/index/'.$project_id, 'location');
			}
			else
			{
				redirect('admin/task_manager/projects', 'location');
			}
		}

		// update records
		$this->DB->where('task_id', $task_id);
		$this->DB->delete('tm_tasks');

		// set flash data
		$this->session->set_flashdata('success', 'delete');

		// redirect user
		redirect('admin/task_manager/tasks/index/'.$project_id, 'location');
    }

	// ----------------------------------------------------------------------

	/**
	 * Method Accept
	 *
	 * @return	void
	 */
	public function unaccept($task_id = '', $project_id = '')
	{
		if (
			$task_id == ''
			OR $project_id == ''
		)
		{
			// nothing more to do...
			// set flash data
			$this->session->set_flashdata('error', 'no_id_passed');

			// redirect user
			if ($project_id)
			{
				redirect('admin/task_manager/tasks/index/'.$project_id, 'location');
			}
			else
			{
				redirect('admin/task_manager/projects', 'location');
			}
		}

		// notify admin of accept
		$this->_notify_admin($task_id, 'unaccept');

		// update records
		$this->DB->set('last_modified', time());
		$this->DB->set('status', '0');
		$this->DB->set('date_end_target', '0');
		$this->DB->set('user_id', '0');
		$this->DB->where('task_id', $task_id);
		$this->DB->update('tm_tasks');

		// set flash data
		$this->session->set_flashdata('success', 'edit');

		// redirect user
		redirect('admin/task_manager/tasks/index/'.$project_id, 'location');
    }

	// ----------------------------------------------------------------------

	/**
	 * Method Accept
	 *
	 * @return	void
	 */
	public function accept($task_id = '', $project_id = '', $user_id = '')
	{
		if (
			$task_id == ''
			OR $project_id == ''
			OR $user_id == ''
		)
		{
			// response
			echo 'error - no_id_passed';
			exit;
		}

		// update records
		$this->DB->set('last_modified', time());
		$this->DB->set('status', '1');
		$this->DB->set('user_id', $user_id);
		$this->DB->where('task_id', $task_id);
		$this->DB->update('tm_tasks');

		// notify admin of accept
		$this->_notify_admin($task_id, 'accept');

		// set flash data
		$this->session->set_flashdata('success', 'edit');

		// response
		echo 'success';
		exit;
    }

	// ----------------------------------------------------------------------

	/**
	 * Method Complete
	 *
	 * @return	void
	 */
	public function complete($task_id = '', $project_id = '')
	{
		if (
			$task_id == ''
			OR $project_id == ''
		)
		{
			// nothing more to do...
			// set flash data
			$this->session->set_flashdata('error', 'no_id_passed');

			// redirect user
			if ($project_id)
			{
				redirect('admin/task_manager/tasks/index/'.$project_id, 'location');
			}
			else
			{
				redirect('admin/task_manager/projects', 'location');
			}
		}

		// update records
		$this->DB->set('last_modified', time());
		$this->DB->set('status', '2'); // '2' for complete
		$this->DB->set('urgent', '0'); // retore urgent status to normal
		$this->DB->where('task_id', $task_id);
		$this->DB->update('tm_tasks');

		// notify admin of completion
		$this->_notify_admin($task_id, 'complete');

		// set flash data
		$this->session->set_flashdata('success', 'edit');

		// redirect user
		redirect('admin/task_manager/tasks/index/'.$project_id, 'location');
    }

	// ----------------------------------------------------------------------

	/**
	 * Method Assign
	 *
	 * @return	void
	 */
	public function assign($user_id = '')
	{
		if (
			$user_id == ''
			OR ! $this->input->post()
		)
		{
			// response
			echo 'error - no_id_passed';
			exit;
		}

		// update records
		$this->DB->set('last_modified', time());
		$this->DB->set('status', '1');
		$this->DB->set('user_id', $user_id);
		$this->DB->where('task_id', $this->input->post('task_id'));
		$this->DB->update('tm_tasks');

		// notify admin of accept
		$this->_notify_admin($this->input->post('task_id'), 'accept');

		// response
		echo 'success';
		exit;
    }

	// ----------------------------------------------------------------------

	/**
	 * Method Assign
	 *
	 * @return	void
	 */
	public function due_date()
	{
		if ( ! $this->input->post())
		{
			// response
			echo 'error - no_id_passed';
			exit;
		}

		$task_id = $this->input->post('task_id');
		$date_end_target = $this->input->post('date_end_target');

		// update records
		$this->DB->set('last_modified', time());
		$this->DB->set('date_end_target', strtotime($date_end_target));
		$this->DB->where('task_id', $task_id);
		$this->DB->update('tm_tasks');

		// response
		echo 'success';
		exit;
    }

	// ----------------------------------------------------------------------

	/**
	 * Method Accept
	 *
	 * @return	void
	 */
	public function _notify_admin($task_id = '', $status = '')
	{
		if (
			$task_id == ''
			OR $status == ''
		)
		{
			return FALSE;
		}

		// load pertinent library/model/helpers
		$this->load->library('email');
		$this->load->library('task_manager/project_task_details');

		// get the data
		$task_details = $this->project_task_details->initialize(
			array(
				'task_id' => $task_id
			)
		);

		// start building message body
		$message = 'Dear Team,';
		$message.= '<br /><br />';

		// set status message
		switch ($status)
		{
			case 'unaccept':
				$message.= $task_details->fname.' '.$task_details->lname;
				$message.= '... has unaccepted the task below:';
			break;
			case 'accept':
				$message.= $task_details->fname.' '.$task_details->lname;
				$message.= '... has accepted the task below:';
			break;
			case 'complete':
				$message.= 'Below task is already complete:';
			break;
		}

		$message.= '<br /><br />';
		$message.= 'TASK: '.$task_details->title;
		$message.= '<br />';
		$message.= 'DESC: '.$task_details->description;
		$message.= '<br /><br />';
		$message.= site_url('admin/task_manager/projects');
		$message.= '<br /><br />';
		$message.= '<br /><br />';
		$message.= 'Admin';

		$this->email->from($this->webspace_details->info_email, $this->webspace_details->name);
		$this->email->to($this->webspace_details->info_email);
		$this->email->bcc($this->config->item('dev1_email'));

		$this->email->subject('Task Manager Action - '.strtoupper($status));
		$this->email->message($message);

		$this->email->send();
		if (ENVIRONMENT === 'development' && $status != 'unaccept' && $status != 'accept')
		{
			echo 'Dev <br />';
			echo '<br />';
			echo $message;
			echo '<br />';
			die();
		}
		else
		{
			if ( ! @$this->email->send())
			{
				if ($status != 'unaccept' && $status != 'accept') echo 'Unable to CI send Task Manager Status Email<br />';
				return FALSE;
			}
		}
    }

	// ----------------------------------------------------------------------

	/**
	 * PRIVATE - Creaet Plugin Scripts and CSS for the page
	 *
	 * @return	void
	 */
	private function _create_plugin_scripts()
	{
		$assets_url = base_url('assets/metronic');

		/****************
		 * page styles plugins inserted at <head>
		 * after global mandatory styles, before theme global styles
		 */
		$this->data['page_level_styles_plugins'] = '';

			// bootstrap select
			$this->data['page_level_styles_plugins'].= '
				<link href="'.$assets_url.'/assets/global/plugins/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
				<link href="'.$assets_url.'/assets/global/plugins/select2/css/select2-bootstrap.min.css" rel="stylesheet" type="text/css" />
				<link href="'.$assets_url.'/assets/global/plugins/bootstrap-select/css/bootstrap-select.min.css" rel="stylesheet" type="text/css" />
			';

		/****************
		 * page style sheets inserted at <head>
		 */
		$this->data['page_level_styles'] = '
		';

		/****************
		 * page js plugins inserted at <bottom>
		 * after core plugins, before global scripts
		 */
		$this->data['page_level_plugins'] = '';

			// bootstrap select
			$this->data['page_level_plugins'].= '
				<script src="'.$assets_url.'/assets/global/plugins/select2/js/select2.full.min.js" type="text/javascript"></script>
				<script src="'.$assets_url.'/assets/global/plugins/bootstrap-select/js/bootstrap-select.min.js" type="text/javascript"></script>
			';
			// form validation
			$this->data['page_level_plugins'].= '
				<script src="'.$assets_url.'/assets/global/plugins/jquery-validation/js/jquery.validate.min.js" type="text/javascript"></script>
				<script src="'.$assets_url.'/assets/global/plugins/jquery-validation/js/additional-methods.min.js" type="text/javascript"></script>
			';

		/****************
		 * page scripts inserted at <bottom>
		 * after global scripts, before theme layout scripts
		 */
		$this->data['page_level_scripts'] = '';

			// handle bootstrap select - make select class '.bs-select' a boostrap select picker
			$this->data['page_level_scripts'].= '
				<script src="'.$assets_url.'/assets/pages/scripts/components-bootstrap-select.min.js" type="text/javascript"></script>
			';
			// handle page scripts
			$this->data['page_level_scripts'].= '
				<script src="'.base_url().'assets/custom/js/metronic/pages/scripts/components-task_manager.js" type="text/javascript"></script>
			';
	}

	// ----------------------------------------------------------------------

}
