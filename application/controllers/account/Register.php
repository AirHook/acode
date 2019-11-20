<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Register extends Frontend_Controller {

	/**
	 * DB Object
	 *
	 * @return	object
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

		// connect to database for use by model
		$this->DB = $this->load->database('instyle', TRUE);
	}

	// --------------------------------------------------------------------

	/**
	 * Index Page for this controller.
	 *
	 * @return	void
	 */
	public function index()
	{
		// generate the plugin scripts and css
		$this->_create_plugin_scripts();

		// load pertinent library/model/helpers
		$this->load->helper('state_country_helper');
		$this->load->library('users/wholesale_user_details');
		$this->load->library('users/consumer_user_details');
		$this->load->library('users/sales_user_details');
		$this->load->library('form_validation');

		// set validation rules
		if ($this->input->post('user_type') == 'wholesale')
		{
			$this->form_validation->set_rules('store_name', 'Store Name', 'trim|required');
			$this->form_validation->set_rules('pword', 'Password', 'trim|required');
			$this->form_validation->set_rules('confpassword', 'Confirm Password', 'trim|required|matches[pword]');
			$this->form_validation->set_rules('zipcode', 'Zip Code', 'trim|required');
			$this->form_validation->set_rules('state', 'State', 'trim|required');
		}
		else
		{
			$this->form_validation->set_rules('password', 'Password', 'trim|required');
			$this->form_validation->set_rules('passconf', 'Confirm Password', 'trim|required|matches[password]');
			$this->form_validation->set_rules('zip_postcode', 'Zip Code', 'trim|required');
			$this->form_validation->set_rules('state_province', 'State', 'trim|required');
		}
		$this->form_validation->set_rules('firstname', 'First Name', 'trim|required');
		$this->form_validation->set_rules('lastname', 'Last Name', 'trim|required');
		$this->form_validation->set_rules('email', 'Email', 'trim|required|callback_validate_email');
		$this->form_validation->set_rules('address1', 'Address 1', 'trim|required');
		$this->form_validation->set_rules('city', 'City', 'trim|required');
		$this->form_validation->set_rules('country', 'Country', 'trim|required');
		$this->form_validation->set_rules('telephone', 'Telephone', 'trim|required');

		if ($this->form_validation->run() == FALSE)
		{
			// set data variables...
			$this->data['view'] = 'form';

			// set data variables...
			$this->data['file'] = 'account_register';
			$this->data['page_title'] = $this->webspace_details->name;
			$this->data['page_description'] = $this->webspace_details->site_description;

			// load views...
			//$this->load->view($this->webspace_details->options['theme'].'/template', $this->data);
			$this->load->view('metronic/template/template', $this->data);
		}
		else
		{
			// check if user exists in any record
			if (
				$this->wholesale_user_details->initialize(array('email' => $this->input->post('email')))
				OR $this->consumer_user_details->initialize(array('email' => $this->input->post('email')))
			)
			{
				// set flash notice
				$this->session->set_flashdata('error', 'user_exists');

				// user exists, nothing more to do...
				redirect('account/register');
			}

			// if user is inactive or suspended
			if (
				$this->wholesale_user_details->status === '2'
				OR $this->wholesale_user_details->status === '0'
				OR $this->consumer_user_details->status === '0'
			)
			{
				// set flash notice
				$this->session->set_flashdata('error', 'status_inactive');

				// send to request for activation page
				redirect('account/request/activation');
			}

			// get sales user details
			$this->sales_user_details->initialize(array('admin_sales_email'=>$this->webspace_details->info_email));

			// set post array
			$post_ary = $this->input->post();
			// and then add some
			$post_ary['create_date'] = @date('Y-m-d', time());
			$post_ary['active_date'] = @date('Y-m-d', time());
			$post_ary['is_active'] = $this->input->post('user_type') == 'wholesale' ? '0' : '1';
			$post_ary['admin_sales_email'] = $this->sales_user_details->email;
			$post_ary['reference_designer'] = $this->webspace_details->slug;
			// unset some
			if (isset($post_ary['user_type'])) unset($post_ary['user_type']);
			if (isset($post_ary['passconf'])) unset($post_ary['passconf']);
			if (isset($post_ary['confpassword'])) unset($post_ary['confpassword']);

			// insert user
			if ($this->input->post('user_type') == 'wholesale')
			{
				$this->DB->insert('tbluser_data_wholesale', $post_ary);
			}
			else
			{
				$this->DB->insert('tbluser_data', $post_ary);
			}
			$insert_id = $this->DB->insert_id();

			// notify admin
			// ------------------------
			// notification to admin - begin email to admin
				$email_message_to_admin = '
					The following just registered for '.$this->input->post('user_type').' info at '.$this->webspace_details->name.'
					<br /><br />
					<table border="0" cellspacing="0" cellpadding="5">
						<tr><td>Reference Designer:</td><td>'.$this->sales_user_details->designer_name.'</td></tr>
						<tr><td>Assigned Sales User:</td><td>'.$this->sales_user_details->fname.' '.$this->sales_user_details->lname.'</td></tr>
						<tr><td colspan="2">&nbsp;</td></tr>
						<tr><td>Username:</td><td>'.$this->input->post('email').'</td></tr>
						<tr><td>Name:</td><td>'.$this->input->post('firstname').' '.$this->input->post('lastname').'</td></tr>
						'.($this->input->post('user_type') == 'wholesale' ? '<tr><td>Store Name:</td><td>'.$this->input->post('store_name').'</td></tr>' : '').'
					</table>
					<br />
					Click <a href="'.site_url('admin/users/'.$this->input->post('user_type').'/edit/index/'.$insert_id).'">here</a> to see his profile and activate or deny.
					<br /><br />
					Details are as follows:
					<table border="0" cellspacing="0" cellpadding="5">
		<tr><td>Email:</td><td>'.$this->input->post('email').'</td></tr>
						<tr><td>Password:</td><td>'.($this->input->post('user_type') == 'wholesale' ? $this->input->post('pword') : $this->input->post('password')).'</td></tr>
						'.($this->input->post('user_type') == 'wholesale' ? '<tr><td>Store Name:</td><td>'.$this->input->post('store_name').'</td></tr>' : '').'
						<tr><td>First & Lat Names:</td><td>'.$this->input->post('firstname').' '.$this->input->post('lastname').'</td></tr>
						'.($this->input->post('user_type') == 'wholesale' ? '<tr><td>Federal Tax ID:</td><td>'.$this->input->post('fed_tax_id').'</td></tr>' : '').'
						<tr><td>Address 1:</td><td>'.$this->input->post('address1').'</td></tr>
						<tr><td>Address 2:</td><td>'.$this->input->post('address2').'</td></tr>
						<tr><td>City:</td><td>'.$this->input->post('city').'</td></tr>
						<tr><td>Country:</td><td>'.$this->input->post('country').'</td></tr>
						'.($this->input->post('user_type') == 'wholesale' ? '<tr><td>State:</td><td>'.$this->input->post('state').'</td></tr>' : '<tr><td>State:</td><td>'.$this->input->post('state_province').'</td></tr>').'
						'.($this->input->post('user_type') == 'wholesale' ? '<tr><td>Zipcode:</td><td>'.$this->input->post('zipcode').'</td></tr>' : '<tr><td>Zipcode:</td><td>'.$this->input->post('zip_postcode').'</td></tr>').'
						<tr><td>Telephone:</td><td>'.$this->input->post('telephone').'</td></tr>
						'.($this->input->post('user_type') == 'wholesale' ? '<tr><td>Fax:</td><td>'.$this->input->post('fax').'</td></tr>' : '').'
					</table>
				';

				$this->load->library('email');

			// ------------------------
			// begin send email info, response to admin
				// send email to admin
				$this->email->from($this->webspace_details->info_email, $this->webspace_details->name);
				$this->email->to($this->webspace_details->info_email);
				$this->email->bcc($this->config->item('dev1_email')); // --> for debuggin purposes

				$this->email->subject(ucfirst($this->input->post('user_type')).' Registration At '.$this->webspace_details->name);
				$this->email->message($email_message_to_admin);

				$this->email->send();
			// end send email info

			// set data variables...
			$this->data['view'] = 'success-notice';

			// set data variables...
			$this->data['file'] = 'account_register';
			$this->data['page_title'] = $this->webspace_details->name;
			$this->data['page_description'] = $this->webspace_details->site_description;

			// load views...
			//$this->load->view($this->webspace_details->options['theme'].'/template', $this->data);
			$this->load->view('metronic/template/template', $this->data);
		}
	}

	// --------------------------------------------------------------------

	/**
	 * Consumer Function
	 *
	 * @return	void
	 */
	public function consumer()
	{
		// generate the plugin scripts and css
		$this->_create_plugin_scripts();

		// load pertinent library/model/helpers
		$this->load->helper('state_country_helper');
		$this->load->library('users/consumer_user_details');
		$this->load->library('users/sales_user_details');
		$this->load->library('form_validation');

		// set validation rules
		$this->form_validation->set_rules('password', 'Password', 'trim|required');
		$this->form_validation->set_rules('passconf', 'Confirm Password', 'trim|required|matches[password]');
		$this->form_validation->set_rules('zip_postcode', 'Zip Code', 'trim|required');
		$this->form_validation->set_rules('state_province', 'State', 'trim|required');
		$this->form_validation->set_rules('firstname', 'First Name', 'trim|required');
		$this->form_validation->set_rules('lastname', 'Last Name', 'trim|required');
		$this->form_validation->set_rules('email', 'Email', 'trim|required|callback_validate_email');
		$this->form_validation->set_rules('address1', 'Address 1', 'trim|required');
		$this->form_validation->set_rules('city', 'City', 'trim|required');
		$this->form_validation->set_rules('country', 'Country', 'trim|required');
		$this->form_validation->set_rules('telephone', 'Telephone', 'trim|required');

		if ($this->form_validation->run() == FALSE)
		{
			// set data variables...
			$this->data['view'] = 'form';

			// set data variables...
			$this->data['file'] = 'account_register_consumer';
			$this->data['page_title'] = $this->webspace_details->name;
			$this->data['page_description'] = $this->webspace_details->site_description;

			// load views...
			//$this->load->view($this->webspace_details->options['theme'].'/template', $this->data);
			$this->load->view('metronic/template/template', $this->data);
		}
		else
		{
			// check if user exists in any record
			if ($this->consumer_user_details->initialize(array('email' => $this->input->post('email'))))
			{
				// set flash notice
				$this->session->set_flashdata('error', 'user_exists');

				// user exists, nothing more to do...
				redirect('account/register');
			}

			// if user is inactive or suspended
			if ($this->consumer_user_details->status === '0')
			{
				// set flash notice
				$this->session->set_flashdata('error', 'status_inactive');

				// send to request for activation page
				redirect('account/request/activation');
			}

			// get sales user details
			$this->sales_user_details->initialize(array('admin_sales_email'=>$this->webspace_details->info_email));

			// set post array
			$post_ary = $this->input->post();
			// and then add some
			$post_ary['create_date'] = @date('Y-m-d', time());
			$post_ary['active_date'] = @date('Y-m-d', time());
			$post_ary['is_active'] = '1';
			$post_ary['admin_sales_email'] = $this->sales_user_details->email;
			$post_ary['reference_designer'] = $this->webspace_details->slug;
			// unset some
			if (isset($post_ary['user_type'])) unset($post_ary['user_type']);
			if (isset($post_ary['passconf'])) unset($post_ary['passconf']);
			if (isset($post_ary['confpassword'])) unset($post_ary['confpassword']);

			$this->DB->insert('tbluser_data', $post_ary);
			$insert_id = $this->DB->insert_id();

			// notify admin
			$this->_notify_admin($insert_id);

			// set data variables...
			$this->data['view'] = 'success-notice';

			// set data variables...
			$this->data['file'] = 'account_register_consumer';
			$this->data['page_title'] = $this->webspace_details->name;
			$this->data['page_description'] = $this->webspace_details->site_description;

			// load views...
			//$this->load->view($this->webspace_details->options['theme'].'/template', $this->data);
			$this->load->view('metronic/template/template', $this->data);
		}
	}

	// --------------------------------------------------------------------

	/**
	 * Wholesale Function
	 *
	 * @return	void
	 */
	public function wholesale()
	{
		// generate the plugin scripts and css
		$this->_create_plugin_scripts();

		// load pertinent library/model/helpers
		$this->load->helper('state_country_helper');
		$this->load->library('users/wholesale_user_details');
		$this->load->library('users/sales_user_details');
		$this->load->library('form_validation');

		// set validation rules
		$this->form_validation->set_rules('store_name', 'Store Name', 'trim|required');
		$this->form_validation->set_rules('pword', 'Password', 'trim|required');
		$this->form_validation->set_rules('confpassword', 'Confirm Password', 'trim|required|matches[pword]');
		$this->form_validation->set_rules('zipcode', 'Zip Code', 'trim|required');
		$this->form_validation->set_rules('state', 'State', 'trim|required');
		$this->form_validation->set_rules('firstname', 'First Name', 'trim|required');
		$this->form_validation->set_rules('lastname', 'Last Name', 'trim|required');
		$this->form_validation->set_rules('email', 'Email', 'trim|required|callback_validate_email');
		$this->form_validation->set_rules('address1', 'Address 1', 'trim|required');
		$this->form_validation->set_rules('city', 'City', 'trim|required');
		$this->form_validation->set_rules('country', 'Country', 'trim|required');
		$this->form_validation->set_rules('telephone', 'Telephone', 'trim|required');

		if ($this->form_validation->run() == FALSE)
		{
			// set data variables...
			$this->data['view'] = 'form';

			// set data variables...
			$this->data['file'] = 'account_register_wholesale';
			$this->data['page_title'] = $this->webspace_details->name;
			$this->data['page_description'] = $this->webspace_details->site_description;

			// load views...
			//$this->load->view($this->webspace_details->options['theme'].'/template', $this->data);
			$this->load->view('metronic/template/template', $this->data);
		}
		else
		{
			// check if user exists in any record
			if ($this->wholesale_user_details->initialize(array('email' => $this->input->post('email'))))
			{
				// set flash notice
				$this->session->set_flashdata('error', 'user_exists');

				// user exists, nothing more to do...
				redirect('account/register');
			}

			// if user is inactive or suspended
			if (
				$this->wholesale_user_details->status === '2'
				OR $this->wholesale_user_details->status === '0'
			)
			{
				// set flash notice
				$this->session->set_flashdata('error', 'status_inactive');

				// send to request for activation page
				redirect('account/request/activation');
			}

			// get sales user details
			$this->sales_user_details->initialize(array('admin_sales_email'=>$this->webspace_details->info_email));

			// set post array
			$post_ary = $this->input->post();
			// and then add some
			$post_ary['create_date'] = @date('Y-m-d', time());
			$post_ary['active_date'] = @date('Y-m-d', time());
			$post_ary['is_active'] = '0';
			$post_ary['admin_sales_email'] = $this->sales_user_details->email;
			$post_ary['reference_designer'] = $this->webspace_details->slug;
			// unset some
			if (isset($post_ary['user_type'])) unset($post_ary['user_type']);
			if (isset($post_ary['passconf'])) unset($post_ary['passconf']);
			if (isset($post_ary['confpassword'])) unset($post_ary['confpassword']);

			// insert user
			$this->DB->insert('tbluser_data_wholesale', $post_ary);
			$insert_id = $this->DB->insert_id();

			// notify admin
			$this->_notify_admin($insert_id);

			// set data variables...
			$this->data['view'] = 'success-notice';

			// set data variables...
			$this->data['file'] = 'account_register_wholesale';
			$this->data['page_title'] = $this->webspace_details->name;
			$this->data['page_description'] = $this->webspace_details->site_description;

			// load views...
			//$this->load->view($this->webspace_details->options['theme'].'/template', $this->data);
			$this->load->view('metronic/template/template', $this->data);
		}
	}

	// --------------------------------------------------------------------

	/**
	 * Notify Admin
	 *
	 * @return	boolean
	 */
	private function _notify_admin($insert_id)
	{
		// ------------------------
		// notification to admin - begin email to admin
			$email_message_to_admin = '
				The following just registered for '.$this->input->post('user_type').' info at '.$this->webspace_details->name.'
				<br /><br />
				<table border="0" cellspacing="0" cellpadding="5">
					<tr><td>Reference Designer:</td><td>'.$this->sales_user_details->designer_name.'</td></tr>
					<tr><td>Assigned Sales User:</td><td>'.$this->sales_user_details->fname.' '.$this->sales_user_details->lname.'</td></tr>
					<tr><td colspan="2">&nbsp;</td></tr>
					<tr><td>Username:</td><td>'.$this->input->post('email').'</td></tr>
					<tr><td>Name:</td><td>'.$this->input->post('firstname').' '.$this->input->post('lastname').'</td></tr>
					'.($this->input->post('user_type') == 'wholesale' ? '<tr><td>Store Name:</td><td>'.$this->input->post('store_name').'</td></tr>' : '').'
				</table>
				<br />
				Click <a href="'.site_url('admin/users/'.$this->input->post('user_type').'/edit/index/'.$insert_id).'">here</a> to see his profile and activate or deny.
				<br /><br />
				Details are as follows:
				<table border="0" cellspacing="0" cellpadding="5">
					<tr><td>Email:</td><td>'.$this->input->post('email').'</td></tr>
					<tr><td>Password:</td><td>'.($this->input->post('user_type') == 'wholesale' ? $this->input->post('pword') : $this->input->post('password')).'</td></tr>
					'.($this->input->post('user_type') == 'wholesale' ? '<tr><td>Store Name:</td><td>'.$this->input->post('store_name').'</td></tr>' : '').'
					<tr><td>First & Lat Names:</td><td>'.$this->input->post('firstname').' '.$this->input->post('lastname').'</td></tr>
					'.($this->input->post('user_type') == 'wholesale' ? '<tr><td>Federal Tax ID:</td><td>'.$this->input->post('fed_tax_id').'</td></tr>' : '').'
					<tr><td>Address 1:</td><td>'.$this->input->post('address1').'</td></tr>
					<tr><td>Address 2:</td><td>'.$this->input->post('address2').'</td></tr>
					<tr><td>City:</td><td>'.$this->input->post('city').'</td></tr>
					<tr><td>Country:</td><td>'.$this->input->post('country').'</td></tr>
					'.($this->input->post('user_type') == 'wholesale' ? '<tr><td>State:</td><td>'.$this->input->post('state').'</td></tr>' : '<tr><td>State:</td><td>'.$this->input->post('state_province').'</td></tr>').'
					'.($this->input->post('user_type') == 'wholesale' ? '<tr><td>Zipcode:</td><td>'.$this->input->post('zipcode').'</td></tr>' : '<tr><td>Zipcode:</td><td>'.$this->input->post('zip_postcode').'</td></tr>').'
					<tr><td>Telephone:</td><td>'.$this->input->post('telephone').'</td></tr>
					'.($this->input->post('user_type') == 'wholesale' ? '<tr><td>Fax:</td><td>'.$this->input->post('fax').'</td></tr>' : '').'
				</table>
			';

			$this->load->library('email');

		// ------------------------
		// begin send email info, response to admin
			// send email to admin
			$this->email->from($this->webspace_details->info_email, $this->webspace_details->name);
			$this->email->to($this->webspace_details->info_email);
			$this->email->bcc($this->config->item('dev1_email')); // --> for debuggin purposes

			$this->email->subject(ucfirst($this->input->post('user_type')).' Registration At '.$this->webspace_details->name);
			$this->email->message($email_message_to_admin);

			$this->email->send();
		// end send email info
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
	 * PRIVATE - Create Plugin Scripts and CSS for the page
	 *
	 * This section is theme based.
	 * We will eventually need to come up with a system to load specific
	 * styles and scripts for each page as per selected theme
	 *
	 * @return	void
	 */
	private function _create_plugin_scripts()
	{
		//$assets_url = base_url('assets/themes/'.@$this->webspace_details->options['theme']);
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
			';

		/****************
		 * page style sheets inserted at <head>
		 */
		$this->data['page_level_styles'] = '';

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
			// handle bootstrap select2
			$this->data['page_level_scripts'].= '
				<script src="'.base_url().'/assets/custom/js/metronic/pages/scripts/components-select2.js" type="text/javascript"></script>
			';
			// handle form validation
			$this->data['page_level_scripts'].= '
				<script src="'.base_url().'assets/custom/js/metronic/pages/scripts/form-validation-account_register.js" type="text/javascript"></script>
			';
	}

	// ----------------------------------------------------------------------

}
