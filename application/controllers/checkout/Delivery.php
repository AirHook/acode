<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/****************
 * Frontend Controller holds any general front end items
 *
 * Shop Controller are for items used for shop thumbs pages
 *
 */
class Delivery extends Frontend_Controller
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
		// catch cart contents
		if ( ! $this->cart->contents())
		{
			// nothing more to do...
			redirect('cart');
		}

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
		$this->load->helper('state_country_helper');
		$this->load->model('shipping_methods');
		$this->load->model('get_pages');
		$this->load->library('users/consumer_user_details');
		$this->load->library('form_validation');

		// set validation rules
		$this->form_validation->set_rules('shipmethod', 'Deliver Method', 'trim|required');
		$this->form_validation->set_rules('agree_to_policy', 'Agree To Policy', 'trim|required');

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

			// check as a register user
			// initialize user details
			if ($this->session->user_loggedin)
			{
				if ($this->session->user_role == 'wholesale')
				{
					if ($this->wholesale_user_details->state == 'New York')
					{
						$this->data['ny_tax'] = '1';
					}
					else $this->data['ny_tax'] = '';

					// set addresses session data
					$newdata = array(
						'ny_tax' 				=> $this->data['ny_tax'],
						'same_shipping_address'	=> '1',
						'store_name'			=> $this->wholesale_user_details->store_name,
						'b_email' 				=> $this->wholesale_user_details->email,
						'b_firstname'			=> $this->wholesale_user_details->fname,
						'b_lastname'			=> $this->wholesale_user_details->lname,
						'b_phone'				=> $this->wholesale_user_details->telephone,
						'b_address1'			=> $this->wholesale_user_details->address1,
						'b_address2'			=> $this->wholesale_user_details->address2,
						'b_country'				=> $this->wholesale_user_details->country,
						'b_city'				=> $this->wholesale_user_details->city,
						'b_state'				=> $this->wholesale_user_details->state,
						'b_zip'					=> $this->wholesale_user_details->zipcode,
						'sh_email' 				=> ($this->session->sh_email ?: $this->wholesale_user_details->email),
						'sh_firstname'			=> ($this->session->sh_firstname ?: $this->wholesale_user_details->fname),
						'sh_lastname'			=> ($this->session->sh_lastname ?: $this->wholesale_user_details->lname),
						'sh_phone'				=> ($this->session->sh_phone ?: $this->wholesale_user_details->telephone),
						'sh_address1'			=> ($this->session->sh_address1 ?: $this->wholesale_user_details->address1),
						'sh_address2'			=> ($this->session->sh_address2 ?: $this->wholesale_user_details->address2),
						'sh_country'			=> ($this->session->sh_country ?: $this->wholesale_user_details->country),
						'sh_city'				=> ($this->session->sh_city ?: $this->wholesale_user_details->city),
						'sh_state'				=> ($this->session->sh_state ?: $this->wholesale_user_details->state),
						'sh_zip'				=> ($this->session->sh_zip ?: $this->wholesale_user_details->zipcode),
						'agree_to_policy'		=> '1'
					);
					$this->session->set_userdata($newdata);
				}
				else
				{
					// it already assumed that user is consumer
					// and has come from ./address which has set session already
					// we just initialize the user details class
					$this->consumer_user_details->initialize(array('user_id'=>$this->session->user_id));
				}
			}
			else
			{
				// else process as guest
				$this->consumer_user_details->initialize(array('user_id'=>$this->session->user_id));
			}

			// some data
			$this->data['ship_methods'] = $this->shipping_methods->get_methods();

			// set data variables...
			$this->data['file'] = 'checkout_delivery';
			$this->data['step'] = 'delivery';
			$this->data['stepi'] = '2';
			$this->data['page_title'] = $this->webspace_details->name;
			$this->data['page_description'] = $this->webspace_details->site_description;

			// load views...
			//$this->load->view($this->webspace_details->options['theme'].'/template', $this->data);
			$this->load->view('metronic/template/template', $this->data);
		}
		else
		{
			// add session data
			$shippingdata = array(
				'shipmethod'	=> $this->input->post('shipmethod'),
				'courier'		=> $this->input->post('courier'),
				'fix_fee'		=> $this->input->post('fix_fee')
			);
			$this->session->set_userdata($shippingdata);

			// we need to put back the payment page for wholesale
			// and ask them for their options
			/* */
			if ($this->session->user_role == 'wholesale')
			{
				redirect('checkout/review');
			}
			else redirect('checkout/payment');
			// */
			//redirect('checkout/payment', 'location');
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
				<script src="'.base_url().'assets/custom/js/metronic/pages/scripts/components-frontend-checkout-delivery.js" type="text/javascript"></script>
			';
	}

	// --------------------------------------------------------------------

}
