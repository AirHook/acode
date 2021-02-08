<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Edit extends Admin_Controller {

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
	 * Index - Edit User
	 *
	 * Edit selected user
	 *
	 * @return	void
	 */
	public function index($id = '')
	{
		if ( ! $id)
		{
			// nothing more to do...
			// set flash data
			$this->session->set_flashdata('error', 'no_id_passed');

			// redirect user
			redirect($this->config->slash_item('admin_folder').'users/sales');
		}

		// generate the plugin scripts and css
		$this->_create_plugin_scripts();

		// load pertinent library/model/helpers
		$this->load->library('users/sales_user_details');
		$this->load->library('designers/designers_list');
		$this->load->library('form_validation');

		// set validation rules
		$this->form_validation->set_rules('is_active', 'Status', 'trim|required');
		$this->form_validation->set_rules('admin_sales_designer', 'Reference Desginer', 'trim|required');
		$this->form_validation->set_rules('admin_sales_email', 'Email', 'trim|required|callback_validate_email');
		$this->form_validation->set_rules('access_level', 'Access Level', 'trim|required');

		if ($this->input->post('change-password'))
		{
			$this->form_validation->set_rules('admin_sales_password', 'Password', 'trim');
			$this->form_validation->set_rules('passconf', 'Confirm Password', 'trim|matches[admin_sales_password]');
		}

		if ($this->form_validation->run() == FALSE)
		{
			// initialize properties
			if ( ! $this->sales_user_details->initialize(array('admin_sales_id' => $id)))
			{
				// set flash data
				$this->session->set_flashdata('error', 'user_not_found');

				redirect($this->config->slash_item('admin_folder').'users/sales');
			}

			if ( ! $this->session->flashdata('clear_recent_sales'))
			{
				// update recent list for admin users edited
				$this->webspace_details->update_recent_users(array(
					'user_type' => 'sales_users',
					'user_id' => $this->sales_user_details->admin_sales_id,
					'user_name' => $this->sales_user_details->fname.' '.$this->sales_user_details->lname
				));
			}

			// some pertinent data
			if (@$this->webspace_details->options['site_type'] != 'hub_site')
			{
				$this->data['designers'] = $this->designers_list->select(
					array(
						'designer.url_structure' => @$this->webspace_details->slug
					)
				);
			}
			else $this->data['designers'] = $this->designers_list->select();

			// set data variables...
			$this->data['file'] = 'users_sales_edit';
			$this->data['page_title'] = 'Sales User Edit';
			$this->data['page_description'] = 'Edit Sales User Details';

			// load views...
			$this->load->view($this->config->slash_item('admin_folder').($this->config->slash_item('admin_template') ?: 'metronic/').'template/template', $this->data);
		}
		else
		{
			// insert record
			$post_ary = $this->input->post();
			// set necessary variables
			//$post_ary['account_status'] = '1';
			// process/add some variables
			if (@$post_ary['admin_sales_password'] == '') unset($post_ary['admin_sales_password']);
			// unset unneeded variables
			unset($post_ary['passconf']);
			unset($post_ary['change-password']);

			// update record
			$this->DB->where('admin_sales_id', $id);
			$query = $this->DB->update('tbladmin_sales', $post_ary);

			// set flash data
			$this->session->set_flashdata('success', 'edit');

			redirect($this->config->slash_item('admin_folder').'users/sales/edit/index/'.$id, 'location');
		}
	}

	// --------------------------------------------------------------------

	/**
	 * Form Validation Callback Functions
	 *
	 * @return	boolean
	 */
	function validate_email($str)
	{
		if ($str == '')
		{
			$this->form_validation->set_message('validate_email', 'Please enter an email address of the Email field.');
			return FALSE;
		}
		else
		{
			if ( ! filter_var($str, FILTER_VALIDATE_EMAIL))
			{
				$this->form_validation->set_message('validate_email', 'The Email field must contain a valid email address.');
				return FALSE;
			}
			else return TRUE;
		}
	}

	// ----------------------------------------------------------------------

	/**
	 * Clear Recent User Edit List
	 *
	 * @return	void
	 */
	public function clear_recent()
	{
		// capture sales user options
		$options = $this->webspace_details->options;

		// get the array of recent users and unset it
		if (
			isset($options['recent_sales_users'])
			&& ! empty($options['recent_sales_users'])
		) unset($options['recent_sales_users']);

		// udpate the sales package items...
		$this->DB->set('webspace_options', json_encode($options));
		$this->DB->where('webspace_id', $this->webspace_details->id);
		$q = $this->DB->update('webspaces');

		// set flash data
		$this->session->set_flashdata('clear_recent_sales', TRUE);

		// reload page
		redirect($_SERVER['HTTP_REFERER'], 'location');
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

			// ladda - show loading or progress bar on buttons
			$this->data['page_level_styles_plugins'].= '
				<link href="'.$assets_url.'/assets/global/plugins/ladda/ladda-themeless.min.css" rel="stylesheet" type="text/css" />
			';
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

			// ladda - show loading or progress bar on buttons
			$this->data['page_level_plugins'].= '
				<script src="'.$assets_url.'/assets/global/plugins/ladda/spin.min.js" type="text/javascript"></script>
				<script src="'.$assets_url.'/assets/global/plugins/ladda/ladda.min.js" type="text/javascript"></script>
			';
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

			// button spinners for ladda
			$this->data['page_level_scripts'].= '
				<script src="'.$assets_url.'/assets/pages/scripts/ui-buttons-spinners.min.js" type="text/javascript"></script>
			';
			// handle bootstrap select - make select class '.bs-select' a boostrap select picker
			$this->data['page_level_scripts'].= '
				<script src="'.$assets_url.'/assets/pages/scripts/components-bootstrap-select.min.js" type="text/javascript"></script>
			';
			// handle datatable
			$this->data['page_level_scripts'].= '
				<script src="'.base_url().'assets/custom/js/metronic/pages/scripts/form-validation-users_sales_edit.js" type="text/javascript"></script>
			';
	}

	// ----------------------------------------------------------------------

}
