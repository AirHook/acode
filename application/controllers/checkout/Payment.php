<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/****************
 * Frontend Controller holds any general front end items
 *
 * Shop Controller are for items used for shop thumbs pages
 *
 */
class Payment extends Frontend_Controller
{
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
	function __Construct()
	{
		parent::__Construct();

		// connect to database for use by model
		$this->DB = $this->load->database('instyle', TRUE);
	}

	// --------------------------------------------------------------------

	/**
	 * Primary method - index
	 *
	 * @return	void
	 */
	function index()
	{
		// catch user session error
		if ( ! $this->session->user_id)
		{
			// set flash data
			$this->session->set_flashdata('error', 'missing_user_details');

			// nothing more to do...
			redirect('checkout/address');
		}

		// generate the plugin scripts and css
		$this->_create_plugin_scripts();

		// load pertinent library/model/helpers
		$this->load->model('get_pages');
		$this->load->library('users/consumer_user_details');
		$this->load->library('form_validation');

		// set validation rules
		if ($this->input->post('ws_payment_options'))
		{
			// 1-use card on file,2-add a card,3-paypal invoice,4-bill account,5-wire request
			$this->form_validation->set_rules('ws_payment_options', 'Select Option', 'trim|required');
		}
		else
		{
			$this->form_validation->set_rules('creditCardNumber', 'Card Number', 'trim|required');
			$this->form_validation->set_rules('creditCardExpirationMonth', 'Month', 'trim|required');
			$this->form_validation->set_rules('creditCardExpirationYear', 'Year', 'trim|required');
			$this->form_validation->set_rules('creditCardSecurityCode', 'Security Code', 'trim|required');
			$this->form_validation->set_rules('agree_to_policy', 'Agree To Policy', 'trim|required');
		}

		if ($this->form_validation->run() == FALSE)
		{
			// check for NY state session variable
			if (
				$this->session->sh_state == 'New York'
				OR $this->session->b_state == 'New York'
			)
			{
				$this->data['ny_tax'] = '1';
			}
			else $this->data['ny_tax'] = '';

			// initialize consumer user details if the user isn't a wholesale user
			// otherwise, use would have been loggedin and initialized
			if ($this->session->user_cat == 'consumer')
			{
				$this->consumer_user_details->initialize(array('user_id'=>$this->session->user_id));
			}

			// set data variables...
			$this->data['file'] = 'checkout_payment';
			$this->data['step'] = 'payment';
			$this->data['stepi'] = '3';
			$this->data['page_title'] = $this->webspace_details->name;
			$this->data['page_description'] = $this->webspace_details->site_description;

			// load views...
			//$this->load->view($this->webspace_details->options['theme'].'/template', $this->data);
			$this->load->view('metronic/template/template', $this->data);
		}
		else
		{
			if ($this->session->user_role == 'wholesale')
			{
				// check for options
				$this->session->set_userdata('ws_payment_options', $this->input->post('ws_payment_options'));
			}

			// simply add session data for credit card info where available
			// generally set for consumer and guests, but, set for wholesale only when chosen
			if ($this->input->post('creditCardType')) $this->session->set_flashdata('cc_type', $this->input->post('creditCardType'));
			if ($this->input->post('creditCardNumber')) $this->session->set_flashdata('cc_number', $this->input->post('creditCardNumber'));
			if ($this->input->post('creditCardExpirationMonth')) $this->session->set_flashdata('cc_expmo', $this->input->post('creditCardExpirationMonth'));
			if ($this->input->post('creditCardExpirationYear')) $this->session->set_flashdata('cc_expyy', $this->input->post('creditCardExpirationYear'));
			if ($this->input->post('creditCardSecurityCode')) $this->session->set_flashdata('cc_code', $this->input->post('creditCardSecurityCode'));

			redirect('checkout/review', 'location');
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
		$this->data['page_level_styles'] = '';

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
			// handle scripts
			$this->data['page_level_scripts'].= '
				<script src="'.base_url().'assets/custom/js/metronic/pages/scripts/components-frontend-checkout-payment.js" type="text/javascript"></script>
			';
	}

	// --------------------------------------------------------------------

}
