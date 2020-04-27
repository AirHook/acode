<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Projects_edit extends Admin_Controller {

	/**
	 * This Class database object holder
	 *
	 * @var	object
	 */
	protected $DB = '';

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

		// load pertinent library/model/helpers
		$this->load->library('designers/designers_list');
		$this->load->library('webspaces/webspaces_list');
		$this->load->library('users/tm_users_list');
		$this->load->library('form_validation');
		$this->load->library('task_manager/project_details');

		// set validation rules
		$this->form_validation->set_rules('status', 'Status', 'trim|required');
		$this->form_validation->set_rules('name', 'Project Name', 'trim|required');
		$this->form_validation->set_rules('description', 'Project Description', 'trim|required');

		if ($this->form_validation->run() == FALSE)
		{
			// get data
			// get the data
			$this->data['project_details'] = $this->project_details->initialize(
				array(
					'project_id' => $project_id
				)
			);
			$this->data['webspaces'] = $this->webspaces_list->select();

			// set data variables...
			$this->data['file'] = 'tm_projects_edit';
			$this->data['page_title'] = 'Task Manager';
			$this->data['page_description'] = 'Edit project';

			// load views...
			$this->load->view($this->config->slash_item('admin_folder').($this->config->slash_item('admin_template') ?: 'metronic/').'template/template', $this->data);
		}
		else
		{
			// grab post data
			$post_ary = $this->input->post();

			// process some post data
			$post_ary['webspace_id'] = $this->input->post('webspace_id') ?: '0';

			// update record
			$this->DB->where('project_id', $project_id);
			$query = $this->DB->update('tm_projects', $post_ary);

			// set flash data
			$this->session->set_flashdata('success', 'edit');

			// redirect user
			redirect('admin/task_manager/projects_edit/index/'.$project_id, 'location');
		}
	}

	// ----------------------------------------------------------------------

	/**
	 * Constructor
	 *
	 * @return	void
	 */
	public function status($project_id = '', $status = '')
	{
		if ($project_id == '' OR $status == '')
		{
			// nothing more to do...
			// set flash data
			$this->session->set_flashdata('error', 'no_id_passed');

			// redirect user
			redirect('admin/task_manager/projects', 'location');
		}

		$this->DB->set('status', $status);
		$this->DB->where('project_id', $project_id);
		$this->DB->update('tm_projects');

		// set flash data
		$this->session->set_flashdata('success', 'edit');

		// redirect user
		redirect('admin/task_manager/projects', 'location');
    }

	// ----------------------------------------------------------------------

	/**
	 * Constructor
	 *
	 * @return	void
	 */
	public function delete($project_id = '')
	{
		if ($project_id == '')
		{
			// nothing more to do...
			// set flash data
			$this->session->set_flashdata('error', 'no_id_passed');

			// redirect user
			redirect('admin/task_manager/projects', 'location');
		}

		$this->DB->where('project_id', $project_id);
		$this->DB->delete('tm_projects');

		// set flash data
		$this->session->set_flashdata('success', 'delete');

		// redirect user
		redirect('admin/task_manager/projects', 'location');
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
