<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/****************
 * Frontend Controller holds any general front end items
 *
 * Shop Controller are for items used for shop thumbs pages
 *
 */
class Address extends Frontend_Controller
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

		// generate the plugin scripts and css
		$this->_create_plugin_scripts();

		// load pertinent library/model/helpers
		$this->load->helper('state_country_helper');
		$this->load->model('login_details');
		$this->load->model('shipping_methods');
		$this->load->model('get_pages');
		$this->load->library('users/consumer_user_details');
		$this->load->library('form_validation');

		// set validation rules
		$this->form_validation->set_rules('b_email', 'Email', 'trim|required|callback_validate_email');
		$this->form_validation->set_rules('b_firstname', 'First Name', 'trim|required');
		$this->form_validation->set_rules('b_lastname', 'Last Name', 'trim|required');
		$this->form_validation->set_rules('b_phone', 'Telephone', 'trim|required');
		$this->form_validation->set_rules('b_country', 'Country', 'trim|required');
		$this->form_validation->set_rules('b_address1', 'Address 1', 'trim|required');
		$this->form_validation->set_rules('b_city', 'City', 'trim|required');
		$this->form_validation->set_rules('b_state', 'State', 'trim|required');
		$this->form_validation->set_rules('b_zip', 'Zip Code', 'trim|required');
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

			// check for consumer login
			if ($this->session->user_loggedin && $this->session->user_role == 'consumer')
			{
				// get user details
				$this->consumer_user_details->initialize(array('user_id'=>$this->session->user_id));
			}

			if ($this->session->user_role != 'wholesale')
			{
				// set addresses session data
				$newdata = array(
					'ny_tax' 				=> $this->data['ny_tax'],
					'same_shipping_address'	=> '1',
					'store_name'			=> $this->consumer_user_details->store_name,
					'b_email' 				=> $this->consumer_user_details->email,
					'b_firstname'			=> $this->consumer_user_details->fname,
					'b_lastname'			=> $this->consumer_user_details->lname,
					'b_phone'				=> $this->consumer_user_details->telephone,
					'b_address1'			=> $this->consumer_user_details->address1,
					'b_address2'			=> $this->consumer_user_details->address2,
					'b_country'				=> $this->consumer_user_details->country,
					'b_city'				=> $this->consumer_user_details->city,
					'b_state'				=> $this->consumer_user_details->state,
					'b_zip'					=> $this->consumer_user_details->zipcode,
					'sh_email' 				=> ($this->session->sh_email ?: $this->consumer_user_details->email),
					'sh_firstname'			=> ($this->session->sh_firstname ?: $this->consumer_user_details->fname),
					'sh_lastname'			=> ($this->session->sh_lastname ?: $this->consumer_user_details->lname),
					'sh_phone'				=> ($this->session->sh_phone ?: $this->consumer_user_details->telephone),
					'sh_address1'			=> ($this->session->sh_address1 ?: $this->consumer_user_details->address1),
					'sh_address2'			=> ($this->session->sh_address2 ?: $this->consumer_user_details->address2),
					'sh_country'			=> ($this->session->sh_country ?: $this->consumer_user_details->country),
					'sh_city'				=> ($this->session->sh_city ?: $this->consumer_user_details->city),
					'sh_state'				=> ($this->session->sh_state ?: $this->consumer_user_details->state),
					'sh_zip'				=> ($this->session->sh_zip ?: $this->consumer_user_details->zipcode),
					'agree_to_policy'		=> '1'
				);
				$this->session->set_userdata($newdata);
			}

			// set data variables...
			$this->data['file'] = 'checkout_address';
			$this->data['step'] = 'address';
			$this->data['stepi'] = '1';
			$this->data['page_title'] = $this->webspace_details->name;
			$this->data['page_description'] = $this->webspace_details->site_description;

			// load views...
			//$this->load->view($this->webspace_details->options['theme'].'/template', $this->data);
			$this->load->view('metronic/template/template', $this->data);
		}
		else
		{
			//echo '<pre>';
			//print_r($this->input->post());
			//die();

			// at first, wholesale users doesn't go through this step
			// now, we allow them to be able to edit address per order for cases
			// where ws has multiple stores, etc...
			if (
				$this->session->user_loggedin
				&& $this->session->user_role == 'wholesale'
			)
			{
				// this should only happen when they click on edit address
				// and needed a different shipping address (for ws with multiple store destination)
				// set addresses session data
				$newdata = array(
					'sh_email' 				=> ($this->input->post('sh_email') ?: $this->input->post('b_email')),
					'sh_firstname'			=> ($this->input->post('sh_firstname') ?: $this->input->post('b_firstname')),
					'sh_lastname'			=> ($this->input->post('sh_lastname') ?: $this->input->post('b_lastname')),
					'sh_phone'				=> ($this->input->post('sh_phone') ?: $this->input->post('b_phone')),
					'sh_address1'			=> ($this->input->post('sh_address1') ?: $this->input->post('b_address1')),
					'sh_address2'			=> ($this->input->post('sh_address2') ?: $this->input->post('b_address2')),
					'sh_country'			=> ($this->input->post('sh_country') ?: $this->input->post('b_country')),
					'sh_city'				=> ($this->input->post('sh_city') ?: $this->input->post('b_city')),
					'sh_state'				=> ($this->input->post('sh_state') ?: $this->input->post('b_state')),
					'sh_zip'				=> ($this->input->post('sh_zip') ?: $this->input->post('b_zip'))
				);
				$this->session->set_userdata($newdata);
			}
			else
			{
				if (
					$this->session->user_loggedin
					&& $this->session->user_role == 'consumer'
				)
				{
					// code here....
					// but there's nothing to do here for now
				}
				else
				{
					// save (or update if existing) the guest user onto database tbluser_data
					// then set and get consumer_user_details
					// continue with delivery options
					if ( ! $this->consumer_user_details->initialize(array('email'=>$this->input->post('b_email'))))
					{
						// insert new user
						$data = array(
							'email' 				=> $this->input->post('b_email'),
							'password'				=> 'shop72018',
							'firstname'				=> $this->input->post('b_firstname'),
							'lastname'				=> $this->input->post('b_lastname'),
							'telephone'				=> $this->input->post('b_phone'),
							'address1'				=> $this->input->post('b_address1'),
							'address2'				=> $this->input->post('b_address2'),
							'country'				=> $this->input->post('b_country'),
							'city'					=> $this->input->post('b_city'),
							'state_province'		=> $this->input->post('b_state'),
							'zip_postcode'			=> $this->input->post('b_zip'),
							'how_hear_about'		=> '',
							'receive_productupd'	=> '1',
							'admin_sales_email'		=> $this->webspace_details->info_email,
							'reference_designer'	=> 'shop7thavenue',
							'create_date'			=> date('Y-m-d', time()),
							'is_active'				=> '1'
						);
						$this->DB->insert('tbluser_data', $data);

						// add user to mailgun mailing list
						// shop7 makes user also for Basix Black Label
						$params['address'] = $this->input->post('b_email');
						$params['fname'] = $this->input->post('b_firstname');
						$params['lname'] = $this->input->post('b_lastname');
						$params['description'] = 'Basix Black Label Consumer User';
						$params['list_name'] = 'consumers@mg.shop7thavenue.com';
						$params['vars'] = '{"designer":"Basix Black Label"}';
						$this->load->library('mailgun/list_member_add', $params);
						$res = $this->list_member_add->add();
					}
					else
					{
						// capture any changes to data by simply updating user data as is
						$data = array(
							'email' 				=> $this->input->post('b_email'),
							//'password'				=> 'shop72018',
							'firstname'				=> $this->input->post('b_firstname'),
							'lastname'				=> $this->input->post('b_lastname'),
							'telephone'				=> $this->input->post('b_phone'),
							'address1'				=> $this->input->post('b_address1'),
							'address2'				=> $this->input->post('b_address2'),
							'country'				=> $this->input->post('b_country'),
							'city'					=> $this->input->post('b_city'),
							'state_province'		=> $this->input->post('b_state'),
							'zip_postcode'			=> $this->input->post('b_zip'),
							//'how_hear_about'		=> '',
							//'receive_productupd'	=> '1',
							//'admin_sales_email'		=> $this->webspace_details->into_email,
							//'reference_designer'	=> 'shop7thavenue'
							'is_active'				=> '1'
						);
						$this->DB->where('email', $this->input->post('b_email'));
						$this->DB->update('tbluser_data', $data);

						// add user to mailgun mailing list
						// shop7 makes user also for Basix Black Label
						$params['address'] = $this->input->post('b_email');
						$params['fname'] = $this->input->post('b_firstname');
						$params['lname'] = $this->input->post('b_lastname');
						$params['description'] = 'Basix Black Label Consumer User';
						$params['list_name'] = 'consumers@mg.shop7thavenue.com';
						$params['vars'] = '{"designer":"Basix Black Label"}';
						$this->load->library('mailgun/list_member_update', $params);
						$res = $this->list_member_update->add();
					}

					// initialize user details
					$this->consumer_user_details->initialize(array('email'=>$this->input->post('b_email')));
					// set sessions
					// but unset the user_loggedin session first so as not to confuse system
					unset($_SESSION['user_loggedin']);
					$this->consumer_user_details->set_session();
				}

				// set addresses session data
				$newdata = array(
					'ny_tax' 				=> $this->input->post('ny_tax') ?: '0',
					'same_shipping_address'	=> $this->input->post('same_shipping_address') ?: '0',
					'b_email' 				=> $this->input->post('b_email'),
					'b_firstname'			=> $this->input->post('b_firstname'),
					'b_lastname'			=> $this->input->post('b_lastname'),
					'b_phone'				=> $this->input->post('b_phone'),
					'b_address1'			=> $this->input->post('b_address1'),
					'b_address2'			=> $this->input->post('b_address2'),
					'b_country'				=> $this->input->post('b_country'),
					'b_city'				=> $this->input->post('b_city'),
					'b_state'				=> $this->input->post('b_state'),
					'b_zip'					=> $this->input->post('b_zip'),
					'sh_email' 				=> ($this->input->post('same_shipping_address') ? $this->input->post('b_email') : ($this->input->post('sh_email') ?: $this->input->post('b_email'))),
					'sh_firstname'			=> ($this->input->post('same_shipping_address') ? $this->input->post('b_firstname') : ($this->input->post('sh_firstname') ?: $this->input->post('b_firstname'))),
					'sh_lastname'			=> ($this->input->post('same_shipping_address') ? $this->input->post('b_lastname') : ($this->input->post('sh_lastname') ?: $this->input->post('b_lastname'))),
					'sh_phone'				=> ($this->input->post('same_shipping_address') ? $this->input->post('b_phone') : ($this->input->post('sh_phone') ?: $this->input->post('b_phone'))),
					'sh_address1'			=> ($this->input->post('same_shipping_address') ? $this->input->post('b_address1') : ($this->input->post('sh_address1') ?: $this->input->post('b_address1'))),
					'sh_address2'			=> ($this->input->post('same_shipping_address') ? $this->input->post('b_address2') : ($this->input->post('sh_address2') ?: $this->input->post('b_address2'))),
					'sh_country'			=> ($this->input->post('same_shipping_address') ? $this->input->post('b_country') : ($this->input->post('sh_country') ?: $this->input->post('b_country'))),
					'sh_city'				=> ($this->input->post('same_shipping_address') ? $this->input->post('b_city') : ($this->input->post('sh_city') ?: $this->input->post('b_city'))),
					'sh_state'				=> ($this->input->post('same_shipping_address') ? $this->input->post('b_state') : ($this->input->post('sh_state') ?: $this->input->post('b_state'))),
					'sh_zip'				=> ($this->input->post('same_shipping_address') ? $this->input->post('b_zip') : ($this->input->post('sh_zip') ?: $this->input->post('b_zip'))),
					'agree_to_policy'		=> $this->input->post('agree_to_policy')
				);
				$this->session->set_userdata($newdata);

				// this snippet checks for ship countries other than USA
				if ($this->session->sh_country != 'United States')
				{
					$fix_fee = $this->_get_fix_fee_for_consumers($this->session->sh_country);
					$this->session->set_userdata('fix_fee', $fix_fee);
				}
			}

			redirect('checkout/delivery', 'location');
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

	// --------------------------------------------------------------------

	/**
	 * Get shipping fix fee for consumers
	 *
	 * @return	string
	 */
	private function _get_fix_fee_for_consumers($str)
	{
		$city_fee = array(
			// All Middle East - $95
			'Bahrain' => '95',
			'Cyprus' => '95',
			'Egypt' => '95',
			'Iran' => '95',
			'Iraq' => '95',
			'Israel' => '95',
			'Jordan' => '95',
			'Kuwait' => '95',
			'Lebanon' => '95',
			'Oman' => '95',
			'Qatar' => '95',
			'Saudi Arabia' => '95',
			'Syria' => '95',
			'Turkey' => '95',
			'United Arab Emirates' => '95',
			'Yemen' => '95',
			// All Europe - $75
			'Albania' => '75',
			'Andorra' => '75',
			'Austria' => '75',
			'Belarus' => '75',
			'Belgium' => '75',
			'Bosnia and Herzegowina' => '75',
			'Bulgaria' => '75',
			'Croatia' => '75',
			'Czech Republic' => '75',
			'Denmark' => '75',
			'Estonia' => '75',
			'Finland' => '75',
			'France' => '75',
			'Germany' => '75',
			'Greece' => '75',
			'Holy See' => '75',
			'Hungary' => '75',
			'Iceland' => '75',
			'Ireland' => '75',
			'Italy' => '75',
			'Latvia' => '75',
			'Liechtenstein' => '75',
			'Lithuania' => '75',
			'Luxembourg' => '75',
			'Malta' => '75',
			'Moldova' => '75',
			'Monaco' => '75',
			'Montenegro' => '75',
			'Netherlands' => '75',
			'Macedonia, The Former Yugoslav Republic of' => '75',
			'North Macedonia' => '75',
			'Norway' => '75',
			'Poland' => '75',
			'Portugal' => '75',
			'Romania' => '75',
			'Russia' => '75',
			'San Marino' => '75',
			'Serbia' => '75',
			'Slovakia' => '75',
			'Slovakia (Slovak Republic)' => '75',
			'Slovenia' => '75',
			'Spain' => '75',
			'Sweden' => '75',
			'Switzerland' => '75',
			'Ukraine' => '75',
			'United Kingdom' => '75',
			// Asia
			'Australia' => '125',
			'Japan' => '125',
			'Korea' => '125',
			'Afghanistan' => '125',
			'Armenia' => '125',
			'Azerbaijan' => '125',
			'Bangladesh' => '125',
			'Bhutan' => '125',
			'Brunei' => '125',
			'Cambodia' => '125',
			'China' => '125',
			'Georgia' => '125',
			'India' => '125',
			'Indonesia' => '125',
			'Kazakhstan' => '125',
			'Kyrgyzstan' => '125',
			'Laos' => '125',
			'Malaysia' => '125',
			'Maldives' => '125',
			'Mongolia' => '125',
			'Myanmar' => '125',
			'Nepal' => '125',
			'North Korea' => '125',
			"Korea, Democratic People's Republic of" => '125',
			'South Korea' => '125',
			'Korea, Republic of' => '125',
			'Pakistan' => '125',
			'Philippines' => '125',
			'Singapore' => '125',
			'Sri Lanka' => '125',
			'State of Palestine' => '125',
			'Tajikistan' => '125',
			'Thailand' => '125',
			'Timor-Leste' => '125',
			'Turkmenistan' => '125',
			'Uzbekistan' => '125',
			'Vietnam' => '125',
			// South America  - 85
			'Argentina' => '85',
			'Bolivia' => '85',
			'Brazil' => '85',
			'Chile' => '85',
			'Colombia' => '85',
			'Ecuador' => '85',
			'Falkland Islands' => '85',
			'Falkland Islands (Malvinas)' => '85',
			'French Guiana' => '85',
			'Guyana' => '85',
			'Paraguay' => '85',
			'Peru' => '85',
			'Suriname' => '85',
			'Uruguay' => '85',
			'Venezuela' => '85',
			// Others
			'Mexico' => '75',
			'Canada' => '65'
		);

		if (isset($city_fee[$str]))
		{
			return $city_fee[$str];
		}
		else return '125';
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
				<script src="'.base_url().'assets/custom/js/metronic/pages/scripts/components-frontend-checkout-address.js" type="text/javascript"></script>
			';
	}

	// --------------------------------------------------------------------

}
