<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tasks extends Admin_Controller {

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
	public function index($project_id = '')
	{
		if ($project_id == '')
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
		$this->load->library('task_manager/project_details');
		$this->load->library('task_manager/tasks_list');
		$this->load->library('users/tm_users_list');

		// get the data
		$this->data['project_details'] = $this->project_details->initialize(
			array(
				'project_id' => $project_id
			)
		);
		$this->data['tasks'] = $this->tasks_list->select(
			array(
				'project_id' => $project_id
			)
		);
		$this->data['users'] = $this->tm_users_list->select();

		/* */
		// set data variables...
		$this->data['file'] = 'tm_tasks';
		$this->data['page_title'] = 'Task Manager';
		$this->data['page_description'] = 'Project Tasks';

		// load views...
		$this->load->view('admin/metronic/template/template', $this->data);
		// */
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
			// nestable list
			$this->data['page_level_styles_plugins'].= '
				<link href="'.$assets_url.'/assets/global/plugins/jquery-nestable/jquery.nestable.css" rel="stylesheet" type="text/css" />
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
			// nestable list
			$this->data['page_level_plugins'].= '
				<script src="'.$assets_url.'/assets/global/plugins/jquery-nestable/jquery.nestable.js" type="text/javascript"></script>
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
				<script src="'.base_url().'assets/custom/js/metronic/pages/scripts/dcn-create.js" type="text/javascript"></script>
			';
			// handle page scripts
			$this->data['page_level_scripts'].= '
				<script src="'.base_url().'assets/custom/js/metronic/pages/scripts/components-task_manager.js" type="text/javascript"></script>
			';
	}

	// ----------------------------------------------------------------------

}
