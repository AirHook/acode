<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Add extends Admin_Controller {

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
	 * Index - Add New Account
	 *
	 * @return	void
	 */
	public function index()
	{
		// generate the plugin scripts and css
		$this->_create_plugin_scripts();

		// load pertinent library/model/helpers
		$this->load->helper('state_country');
		$this->load->library('users/wholesale_user_details');
		$this->load->library('users/sales_users_list');
		$this->load->library('designers/designers_list');
		$this->load->library('odoo');
		$this->load->library('form_validation');

		// set validation rules
		$this->form_validation->set_rules('is_active', 'Status', 'trim|required');
		$this->form_validation->set_rules('reference_designer', 'Reference Designer', 'trim|required');
		$this->form_validation->set_rules('admin_sales_email', 'Sales User Association', 'trim|required|callback_validate_email');
		$this->form_validation->set_rules('email', 'Email', 'trim|required|callback_validate_email');

		$this->form_validation->set_rules('firstname', 'First Name', 'trim|required');
		$this->form_validation->set_rules('lastname', 'Last Name', 'trim|required');
		$this->form_validation->set_rules('store_name', 'Store Name', 'trim|required');
		$this->form_validation->set_rules('telephone', 'Telephone', 'trim|required');
		$this->form_validation->set_rules('address1', 'Address1', 'trim|required');
		$this->form_validation->set_rules('city', 'City', 'trim|required');
		$this->form_validation->set_rules('state', 'State', 'required');
		$this->form_validation->set_rules('country', 'Country', 'required');
		$this->form_validation->set_rules('zipcode', 'Zip Code', 'trim|required');

		$this->form_validation->set_rules('pword', 'Password', 'trim|required');
		$this->form_validation->set_rules('passconf', 'Confirm Password', 'trim|required|matches[pword]');

		if ($this->form_validation->run() == FALSE)
		{
			// some pertinent data
			if (@$this->webspace_details->options['site_type'] != 'hub_site')
			{
				$this->data['designers'] = $this->designers_list->select(
					array(
						'designer.url_structure' => @$this->webspace_details->slug
					)
				);
				$this->data['sales'] = $this->sales_users_list->select(
					array(
						'tbladmin_sales.admin_sales_designer' => @$this->webspace_details->slug
					)
				);
			}
			else
			{
				$this->data['designers'] = $this->designers_list->select();
				$this->data['sales'] = $this->sales_users_list->select();
			}

			// set data variables...
			$this->data['file'] = 'users_wholesale_add';
			$this->data['page_title'] = 'Wholesale User Add';
			$this->data['page_description'] = 'Add new wholesale user';

			// load views...
			$this->load->view($this->config->slash_item('admin_folder').($this->config->slash_item('admin_template') ?: 'metronic/').'template/template', $this->data);
		}
		else
		{
			if ($this->wholesale_user_details->initialize(array('email' => $this->input->post('email'))))
			{
				// user already exists
				// set flash data
				$this->session->set_flashdata('error', 'user_exists');

				// redirect user
				redirect('admin/users/wholesale/add', 'locagtion');
			}

			// insert record
			$post_ary = $this->input->post();

			// set necessary variables
			$post_ary['create_date'] = date('Y-m-d', time());
			if ($this->input->post('is_active') == '1')
			{
				$post_ary['active_date'] = date('Y-m-d', time());
			}
			$post_ary['alt_address'] = json_encode($post_ary['alt_address']);

			// restructure options if any
			if (@$post_ary['options']['patron_discount'])
			{
				$post_ary['options'] = json_encode($post_ary['options']);
			}
			else unset($post_ary['options']);

			// unset unneeded variables
			unset($post_ary['passconf']);
			unset($post_ary['send_activation_email']);

			// since email2 to email6 are options only,
			// we need to verify them if present
			if ( ! $this->validate_email($post_ary['email2'])) unset($post_ary['email2']);
			if ( ! $this->validate_email($post_ary['email3'])) unset($post_ary['email3']);
			if ( ! $this->validate_email($post_ary['email4'])) unset($post_ary['email4']);
			if ( ! $this->validate_email($post_ary['email5'])) unset($post_ary['email5']);
			if ( ! $this->validate_email($post_ary['email6'])) unset($post_ary['email6']);

			// if active, add user to mailgun list
			if ($this->input->post('is_active') == '1')
			{
				// add user to mailgun list
				// no need to validate email as these are stores
				// force add users to mailgun
				// use input fields to capture any updates
				switch ($this->input->post('reference_designer'))
				{
					case 'tempoparis':
						$list_name = 'ws_tempo@mg.shop7thavenue.com';
						$designer_name = 'Tempo Paris';
					break;
					case 'basixblacklabel':
						$list_name = 'wholesale_users@mg.shop7thavenue.com';
						$designer_name = 'Basix Black Label';
					break;
					case 'chaarmfurs':
						$list_name = 'wholesale_users@mg.shop7thavenue.com';
						$designer_name = 'Chaarm Furs';
					break;
					case 'issueny':
						$list_name = 'wholesale_users@mg.shop7thavenue.com';
						$designer_name = 'Issue New York';
					break;
					default:
						$list_name = 'wholesale_users@mg.shop7thavenue.com';
						$designer_name = $this->webspace_details->name;
				}

				if ($list_name)
				{
					$params['address'] = $this->input->post('email');
					$params['fname'] = $this->input->post('firstname');
					$params['lname'] = $this->input->post('lastname');
					$params_vars = array(
						'designer' => $designer_name,
						'designer_slug' => $this->input->post('reference_designer'),
						'store_name' => $this->input->post('store_name')
					);
					$params['vars'] = json_encode($params_vars);
					$params['description'] = 'Wholesale User';
					$params['list_name'] = $list_name;
					$this->load->library('mailgun/list_member_add', $params);
					$res = $this->list_member_add->add();
					$this->list_member_add->clear();
				}
			}

			// add record to database
			$DB = $this->load->database('instyle', TRUE);
			$query = $DB->insert('tbluser_data_wholesale', $post_ary);
			$insert_id = $DB->insert_id();

			// do we send out activation email?
			if ($this->input->post('send_activation_email') === '1')
			{
				// load and initialize wholesale activation email sending library
				$this->load->library('users/wholesale_activation_email_sending');
				$this->wholesale_activation_email_sending->initialize(
					array(
						'users' => array(
							$this->input->post('email')
						)
					)
				);

				if ( ! $this->wholesale_activation_email_sending->send())
				{
					echo $this->wholesale_activation_email_sending->error;
					$this->session->set_flashdata('error', 'added_but_error_sending_activation_email');
					$this->session->set_flashdata('error_message', $this->wholesale_activation_email_sending->error);

					// redirect user
					redirect($this->config->slash_item('admin_folder').'users/wholesale/edit/index/'.$insert_id);
				}

			}

			// set flash data
			$this->session->set_flashdata('success', 'add');

			redirect($this->config->slash_item('admin_folder').'users/wholesale/edit/index/'.$insert_id);
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
			$this->form_validation->set_message('validate_email', 'Please enter an email address on the Email field.');
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
				<script src="'.base_url().'assets/custom/js/metronic/pages/scripts/form-validation-users_wholesale_add.js" type="text/javascript"></script>
			';
	}

	// ----------------------------------------------------------------------

}
