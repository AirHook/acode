<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/****************
 * Frontend Controller holds any general front end items
 *
 * Shop Controller are for items used for shop thumbs pages
 *
 */
class Customer_info extends Frontend_Controller
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
		// cart emtpy...
		if ($this->cart->total_items() == 0)
		{
			// nothing to do... return to cart basket.
			redirect('cart', 'location');
		}

		// if coming from confirm order page...
		if ($this->session->userdata('confirm_order') == TRUE)
		{
			$this->session->unset_userdata('confirm_order');
			$this->session->set_flashdata('flashRegMsg', '<div class="errorMsg">Your check out was interrupted in the process. Please review your shopping cart contents again.</div>');
			redirect('cart', 'location');
		}

		// if url is intentionally typed, let ensure that it is https
		if ( ! isset($_SERVER['HTTPS']))
		{
			redirect('cart/customer_info', 'location');
		}

		// load pertinent library/model/helpers
		$this->load->model('login_details');
		$this->load->model('shipping_methods');
		$this->load->helper('state_country_helper');
		$this->load->library('users/consumer_user_details');
		$this->load->library('form_validation');

		$this->form_validation->set_rules('email', 'Email', 'trim|required|callback_validate_email');
		$this->form_validation->set_rules('firstname', 'First Name', 'trim|required');
		$this->form_validation->set_rules('lastname', 'Last Name', 'trim|required');
		$this->form_validation->set_rules('phone', 'Telephone', 'trim|required');
		$this->form_validation->set_rules('country', 'Country', 'trim|required');
		$this->form_validation->set_rules('address1', 'Address 1', 'trim|required');
		$this->form_validation->set_rules('city', 'City', 'trim|required');
		$this->form_validation->set_rules('state', 'State', 'trim|required');
		$this->form_validation->set_rules('zip', 'Zip Code', 'trim|required');

		if ($this->input->post('country') == 'United States')
		{
			// for US only
			$this->form_validation->set_rules('us-states', 'State', 'trim|required');
			$this->form_validation->set_rules('shipmethod', 'Shipping Options', 'trim|required|callback_check_shipmethod');
		}
		else
		{
			// non-US
			$this->form_validation->set_rules('non-us-states', 'State', 'trim|required');
		}


		if ($this->form_validation->run() == FALSE) // *** ---> load form (default and on error validate)
		{
			//$jscript = $this->set->jquery().$this->set->autocomplete();

			// some data
			$this->data['ship_methods'] = $this->shipping_methods->get_methods();

			// set data variables to pass to view file
			$this->data['file'] 						= 'customer_info';
			$this->data['left_nav_sql'] 				= @$subcats;
			$this->data['jscript'] 						= @$jscript;
			$this->data['site_title']					= $this->config->item('site_title');
			$this->data['site_keywords']				= $this->config->item('site_keywords');
			$this->data['site_description']				= $this->config->item('site_description');
			$this->data['footer_text']					= $this->config->item('site_name').' Checkout Step 2';

			// load the view
			$this->load->view($this->webspace_details->options['theme'].'/template', $this->data);
		}
		else
		{
			$email				= $this->input->post('email');
			$firstname			= $this->input->post('firstname');
			$lastname			= $this->input->post('lastname');
			$telephone			= $this->input->post('phone');
			$country			= $this->input->post('country');
			$address1			= $this->input->post('address1');
			$address2			= $this->input->post('address2');
			$city				= $this->input->post('city');
			$state_input		= $this->input->post('non-us-states');
			$state_dd			= $this->input->post('us-states');
			$zipcode			= $this->input->post('zip');
			$howhearabout		= '';
			$receive_productupd	= $this->input->post('sendEmailUpdates');
			$shipping_id		= $this->input->post('shipmethod');

			$default_password = 'instyle2011';
			$state = $country == 'United States' ? $state_dd : $state_input;

			// prep user data
			$data = array(
				'email'					=> $email,
				'password'				=> $default_password,
				'firstname'				=> $firstname,
				'lastname'				=> $lastname,
				'telephone'				=> $telephone,
				'address1'				=> $address1,
				'address2'				=> $address2,
				'country'				=> $country,
				'city'					=> $city,
				'state_province'		=> $state,
				'zip_postcode'			=> $zipcode,
				'how_hear_about'		=> $howhearabout,
				'receive_productupd'	=> $receive_productupd,
				'admin_sales_email'		=> 'help@'.$this->webspace_details->slug.'.com',
				'reference_designer'	=> 'instylenewyork'
			);

			// check if user is on record already
			if ( ! $this->consumer_user_details->initialize(array('email'=>$email)))
			{
				// insert user to database
				$this->DB->insert('tbluser_data', $data);

				// first time consumer
				$this->session->set_userdata('user_c', 'guest');

				// reinitialize user info
				$this->consumer_user_details->initialize(array('email'=>$email));
			}
			else
			{
				// update user records
				$this->DB->where('email', $email);
				$this->DB->update('tbluser_data', $data);
				$this->session->set_userdata('user_c', 'cs');
			}

			// set user session
			$this->session->set_userdata('user_id', $this->consumer_user_details->user_id);
			$this->session->set_userdata('user_cat', 'consumer');

			// Set session data for shipping info
			$this->session->set_userdata('shipping_id', $shipping_id);

			// Enter info on tbl_login_detail
			$this->login_details->update($this->consumer_user_details->user_id, 'consumer');

			// special sale prefix
			$special_sale_prefix = $this->uri->segment(1) === 'special_sale' ? 'special_sale/' : '';

			// redirect user
			redirect($special_sale_prefix.'cart/confirm_order', 'location');
		}
	}

	// --------------------------------------------------------------------

	/**
	 * Form Validation Callback Functions
	 *
	 * @return	boolean
	 */
	function check_shipmethod($str)
	{
		if ($str == '')
		{
			$this->form_validation->set_message('check_shipmethod', 'Please select shipping option for USA country.');
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
			if ( ! filter_var($str, FILTER_VALIDATE_EMAIL))
			{
				$this->form_validation->set_message('validate_email', 'The Email field must contain a valid email address.');
				return FALSE;
			}
			else return TRUE;
		}
	}

	// --------------------------------------------------------------------

}
