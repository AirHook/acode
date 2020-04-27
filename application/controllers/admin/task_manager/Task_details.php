<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Task_details extends Admin_Controller {

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
	 * Index Page for this controller.
	 */
	public function index($task_id = '')
	{
		if ($task_id == '')
		{
			// nothing more to do...
			// set flash data
			$this->session->set_flashdata('error', 'no_id_passed');

			// redirect user
			redirect('admin/task_manager/projects', 'location');
		}

		// generate the plugin scripts and css
		$this->_create_plugin_scripts();

		// lets check for status of webspace and account
		$this->load->library('task_manager/project_task_details');
		$this->load->library('task_manager/chats_list');
		$this->load->library('users/tm_users_list');

		// get the data
		$this->data['task_details'] = $this->project_task_details->initialize(
			array(
				'task_id' => $task_id
			)
		);
		$this->data['attachments'] = $this->project_task_details->attachments();
		$this->data['users'] = $this->tm_users_list->select();
		$this->data['chats'] = $this->chats_list->select(
			array(
				'task_id' => $task_id
			)
		);

		/* */
		// set data variables...
		$this->data['file'] = 'tm_task_details';
		$this->data['page_title'] = 'Task Manager';
		$this->data['page_description'] = 'Project Task Details';

		// load views...
		$this->load->view('admin/metronic/template/template', $this->data);
		// */
	}

	// ----------------------------------------------------------------------

	/**
	 * Method Complete
	 *
	 * @return	void
	 */
	public function complete($task_id = '')
	{
		if ($task_id == '')
		{
			// nothing more to do...
			// set flash data
			$this->session->set_flashdata('error', 'no_id_passed');

			// redirect user
			redirect('admin/task_manager/task_details/index/'.$task_id, 'location');
		}

		// connect to database
		$DB = $this->load->database('instyle', TRUE);

		// update records
		$DB->set('last_modified', time());
		$DB->set('status', '2'); // '2' for complete
		$DB->set('urgent', '0'); // retore urgent status to normal
		$DB->where('task_id', $task_id);
		$DB->update('tm_tasks');

		// notify admin of completion
		$this->_notify_admin($task_id, 'complete');

		// set flash data
		$this->session->set_flashdata('success', 'edit');

		// redirect user
		redirect('admin/task_manager/task_details/index/'.$task_id, 'location');
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
			// datepicker & date-time-pickers
			$this->data['page_level_styles_plugins'].= '
				<link href="'.$assets_url.'/assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css" rel="stylesheet" type="text/css" />
			';
			// summernote wysiwyg
			$this->data['page_level_styles_plugins'].= '
				<link href="'.$assets_url.'/assets/global/plugins/bootstrap-summernote/summernote.css" rel="stylesheet" type="text/css" />
			';
			// dropzone
			$this->data['page_level_styles_plugins'].= '
				<link href="'.$assets_url.'/assets/global/plugins/dropzone/dropzone.min.css" rel="stylesheet" type="text/css" />
				<link href="'.$assets_url.'/assets/global/plugins/dropzone/basic.min.css" rel="stylesheet" type="text/css" />
			';
			// fancybox
			$this->data['page_level_styles_plugins'].= '
				<link href="'.$assets_url.'/assets/global/plugins/fancybox/source/jquery.fancybox.css" rel="stylesheet" type="text/css" />
			';


		/****************
		 * page style sheets inserted at <head>
		 */
		$this->data['page_level_styles'] = '';

			// handle summernote wysiwyg
			$this->data['page_level_styles'].= '
				<link href="'.$assets_url.'/assets/apps/css/todo.min.css" rel="stylesheet" type="text/css" />
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
			// datepicker & date-time-pickers
			$this->data['page_level_plugins'].= '
				<script src="'.$assets_url.'/assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js" type="text/javascript"></script>
			';
			// summernote wysiwyg
			$this->data['page_level_plugins'].= '
				<script src="'.$assets_url.'/assets/global/plugins/bootstrap-summernote/summernote.min.js" type="text/javascript"></script>
			';
			// dropzone
			$this->data['page_level_plugins'].= '
				<script src="'.$assets_url.'/assets/global/plugins/dropzone/dropzone.min.js" type="text/javascript"></script>
			';
			// fancybox
			$this->data['page_level_plugins'].= '
				<script src="'.$assets_url.'/assets/global/plugins/fancybox/source/jquery.fancybox.pack.js" type="text/javascript"></script>
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
			// handle summernote wysiwyg
			$this->data['page_level_scripts'].= '
				<script src="'.base_url().'assets/custom/js/metronic/pages/scripts/components-task_manager.js" type="text/javascript"></script>
			';
	}

	// ----------------------------------------------------------------------

}
