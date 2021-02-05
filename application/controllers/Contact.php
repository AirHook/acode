<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Contact extends Frontend_Controller {

	/**
	 * Constructor
	 *
	 * @return	void
	 */
	public function __construct()
	{
		parent::__construct();
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
		$this->load->helper('state_country');
		$this->load->library('form_validation');

		// set validation rules
		$this->form_validation->set_rules('fname', 'Frist Name', 'trim|alpha_numeric_spaces|required');
		$this->form_validation->set_rules('lname', 'Last Name', 'trim|alpha|differs[fname]|required');
		$this->form_validation->set_rules('state', 'State', 'trim|required');
		$this->form_validation->set_rules('country', 'Country', 'trim|required');
		$this->form_validation->set_rules('telephone', 'Telephone', 'required');
		$this->form_validation->set_rules('email', 'Email Address', 'trim|required|callback_validate_email');
		$this->form_validation->set_rules('comments', 'Comments', 'trim|callback_validate_comments');

		if ($this->form_validation->run() == FALSE)
		{
			// set data variables...
			$this->data['file'] = 'page';
			$this->data['page'] = 'contact';
			$this->data['view'] = 'contact_form';
			$this->data['page_title'] = $this->webspace_details->name;
			$this->data['page_description'] = $this->webspace_details->site_description;

			// load views...
			//$this->load->view($this->webspace_details->options['theme'].'/template', $this->data);
			$this->load->view('metronic/template/template', $this->data);
		}
		else
		{
			// create message
			$message = '
				<strong>Name:</strong> '.$this->input->post('fname').' '.$this->input->post('lname').'<br />
				<strong>Email:</strong> '.$this->input->post('email').'<br />
				<strong>State:</strong> '.$this->input->post('state').'<br />
				<strong>Country:</strong> '.$this->input->post('country').'<br />
				<strong>Telephone:</strong> '.$this->input->post('telephone').'<br />
				<br />
				<strong>Questions/Comments:</strong><br />'.$this->input->post('comments').'<br />
				<br /><br />
				<p style="font-size:0.8em;"><em>This email is generated from '.$this->webspace_details->site.' contacts page.</em></p>
			';

			if (ENVIRONMENT == 'development') // ---> used for development purposes
			{
				// we are unable to send out email in our dev environment
				// so we check on the email template instead.
				// just don't forget to comment these accordingly
				echo $message;
				echo '<br /><br />';

				echo '<a href="'.site_url('contact/sent').'">Continue...</a>';
				echo '<br /><br />';
				exit;
			}
			else
			{
				// let's send the email
				// load email library
				$this->load->library('email');

				// notify admin
				$this->email->clear();

				$this->email->from($this->webspace_details->info_email, $this->webspace_details->name);

				$this->email->to($this->webspace_details->info_email);
				$this->email->cc($this->config->item('dev1_email'));

				$this->email->subject($this->webspace_details->name.' - Contact Us Inquiry');
				$this->email->message($message);

				// email class has a security error
				// "idn_to_ascii(): INTL_IDNA_VARIANT_2003 is deprecated"
				// using the '@' sign to supress this
				// must resolve pending update of CI
				@$this->email->send();

				// redirect user
				redirect('contact/sent', 'location');
			}
		}
	}

	// --------------------------------------------------------------------

	/**
	 * Method Sent
	 *
	 * @return	boolean
	 */
	function sent()
	{
		// set data variables...
		$this->data['file'] = 'page';
		$this->data['page'] = 'contact';
		$this->data['view'] = 'sent';
		$this->data['page_title'] = $this->webspace_details->name;
		$this->data['page_description'] = $this->webspace_details->site_description;

		// load views...
		//$this->load->view($this->webspace_details->options['theme'].'/template', $this->data);
		$this->load->view('metronic/template/template', $this->data);
	}

	// --------------------------------------------------------------------

	/**
	 * Form Validation Callback Functions
	 *
	 * @return	boolean
	 */
	function validate_comments($str)
	{
		// regular expression filter
		//$reg_exUrl = "%^((https?://)|(www\.))([a-z0-9-].?)+(:[0-9]+)?(/.*)?$%i";
			// problem with above filter is texts before
			// and/or after links causes the links to pass
			// using below reg_ex to check of links within a text
		$reg_exUrl = "/(http|https|ftp|ftps)\:\/\/[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}(\/\S*)?/";

		// check...
		if (preg_match($reg_exUrl, $str))
		{
			$this->form_validation->set_message('validate_comments', 'Invalid characters found in COMMENTS field.');
			return FALSE;
		}
		else return TRUE;
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
			if (in_array($str, $this->config->item('email_blacklist')))
			{
				$this->form_validation->set_message('validate_email', 'The Email address enetered seems to be invalid. Please contact us directly by phone instead.');
				return FALSE;
			}

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
	}

	// ----------------------------------------------------------------------

}
