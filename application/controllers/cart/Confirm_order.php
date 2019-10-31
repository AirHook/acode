<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/****************
 * Frontend Controller holds any general front end items
 *
 * Shop Controller are for items used for shop thumbs pages
 *
 */
class Confirm_order extends Frontend_Controller
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
		// special sale prefix
		$special_sale_prefix = $this->uri->segment(1) === 'special_sale' ? 'special_sale/' : '';

		if ($this->cart->total_items() == 0)
		{
			// nothing to do... return to cart basket.
			redirect($special_sale_prefix.'cart', 'location');
		}

		// if url is intentionally typed, let ensure that it is https
		if ( ! isset($_SERVER['HTTPS']))
		{
			redirect($special_sale_prefix.'cart/confirm_order', 'location');
		}

		// setting session that user is already confirming order so that if user presses back button on browser,
		// send the suer to cart basket instead
		$this->session->set_userdata('confirm_order', TRUE);

		// load pertinent library/model/helpers
		$this->load->model('shipping_methods');
		$this->load->helper('state_country_helper');
		$this->load->library('users/consumer_user_details');
		$this->load->library('users/wholesale_user_details');
		$this->load->library('users/sales_user_details');
		$this->load->library('form_validation');

		// get shipping data
		if ($this->session->userdata('shipping_id')) $ship_method = $this->shipping_methods->get_method($this->session->userdata('shipping_id'));
		else $ship_method = '';

		// validation rules
		$this->form_validation->set_rules('payment_card_type', 'Credite Card Type', 'trim|callback_check_payment_details');
		$this->form_validation->set_rules('payment_card_num', 'Credit Card Number', 'trim|callback_check_payment_details');
		if ($this->webspace_details->options['theme'] == 'roden2')
		{
			$exp_date = $this->input->post('creditCardExpirationMonth').'-'.$this->input->post('creditCardExpirationYear');
			$this->form_validation->set_rules('payment_exp_date', 'Credit Card Expiration', 'trim|callback_check_expiration_date['.$exp_date.']');
		}
		else
		{
			$this->form_validation->set_rules('payment_exp_date', 'Credit Card Expiration', 'trim|callback_check_payment_details');
		}
		$this->form_validation->set_rules('payment_card_code', 'CCV', 'trim|callback_check_payment_details');
		if ($this->session->userdata('user_cat') !== 'wholesale')
		{
			$this->form_validation->set_rules('agree_to_return_policy', 'Agree to Reutrn Policy', 'trim|callback_check_radio_policy');
		}
		$this->form_validation->set_rules('shipping_address1', 'Shipping Address 1', 'trim|callback_check_shipping_details');
		$this->form_validation->set_rules('shipping_city', 'Shipping City', 'trim|callback_check_shipping_details');
		$this->form_validation->set_rules('shipping_state', 'Shipping State', 'trim|callback_check_shipping_details');
		$this->form_validation->set_rules('shipping_country', 'Shipping Country', 'trim|callback_check_shipping_details');
		$this->form_validation->set_rules('shipping_zipcode', 'Shipping Zip Code', 'trim|callback_check_shipping_details');

		if ($this->form_validation->run() == FALSE) // *** ---> load form (default and on error validate)
		{
			/*$jscript = $this->set->jquery().$this->set->autocomplete().'
				<link type="text/css" href="'.base_url().'jscript/themes/base/jquery.ui.all.css" rel="stylesheet" />
				<script type="text/javascript" src="'.base_url().'jscript/external/jquery.bgiframe-2.1.1.js"></script>
				<script type="text/javascript" src="'.base_url().'jscript/ui/jquery.ui.core.js"></script>
				<script type="text/javascript" src="'.base_url().'jscript/ui/jquery.ui.widget.js"></script>
				<script type="text/javascript" src="'.base_url().'jscript/ui/jquery.ui.mouse.js"></script>
				<script type="text/javascript" src="'.base_url().'jscript/ui/jquery.ui.button.js"></script>
				<script type="text/javascript" src="'.base_url().'jscript/ui/jquery.ui.draggable.js"></script>
				<script type="text/javascript" src="'.base_url().'jscript/ui/jquery.ui.position.js"></script>
				<script type="text/javascript" src="'.base_url().'jscript/ui/jquery.ui.dialog.js"></script>*/
			$jscript = '
				<script>
					// increase the default animation speed to exaggerate the effect
					$.fx.speeds._default = 1000;
					$(function() {
						$( "#dialog_return_policy_agree" ).dialog({
							autoOpen: false,
							show: "blind",
							hide: "explode",
							width: 800,
							position: "center",
							zIndex: 9999
						});

						$( "#return_policy_agree" ).click(function() {
							$( "#dialog_return_policy_agree" ).dialog( "open" );
							return false;
						});
					});
				</script>
			';

			// get user data
			if ($this->session->userdata('user_cat') == 'wholesale')
			{
				$q_user_info = $this->wholesale_user_details->initialize(array('user_id'=>$this->session->userdata('user_id')));
			}
			else
			{
				$q_user_info = $this->consumer_user_details->initialize(array('user_id'=>$this->session->userdata('user_id')));
			}

			// set data variables to pass to view file
			$this->data['file'] 						= 'confirm_order';
			$this->data['left_nav_sql'] 				= @$subcats;
			$this->data['jscript'] 						= @$jscript;
			$this->data['ship_method'] 					= @$ship_method;
			$this->data['cur_user_info'] 				= @$q_user_info;
			$this->data['site_title']					= $this->config->item('site_title');
			$this->data['site_keywords']				= $this->config->item('site_keywords');
			$this->data['site_description']				= $this->config->item('site_description');
			$this->data['footer_text']					= 'Order Confirmation For '.$this->webspace_details->site;

			// load the view
			$this->load->view($this->webspace_details->options['theme'].'/template', $this->data);
		}
		else
		{
			$email_data['p_card_type']		= $this->input->post('payment_card_type');
			$email_data['p_card_num']			= $this->input->post('payment_card_num');
			$email_data['p_exp_date']			= $this->webspace_details->options['theme'] == 'roden2' ? $this->input->post('creditCardExpirationMonth').'/'.$this->input->post('creditCardExpirationYear') : $this->input->post('payment_exp_date');
			$email_data['p_card_code']		= $this->input->post('payment_card_code');

			$email_data['p_first_name']		= $this->input->post('payment_first_name');
			$email_data['p_last_name']		= $this->input->post('payment_last_name');
			$email_data['p_email']			= $this->input->post('email');
			$email_data['p_telephone']		= $this->input->post('payment_telephone');
			$email_data['p_store_name']		= $this->input->post('payment_storename') ? $this->input->post('payment_storename') : '';

			$p_address_1		= $this->input->post('payment_address_1');
			$p_address_2		= $this->input->post('payment_address_2');
			$p_city				= $this->input->post('payment_city');
			$p_state			= $this->input->post('payment_state');
			$p_country			= $this->input->post('payment_country');
			$p_zip				= $this->input->post('payment_zip');

			$email_data['sh_address1']		= $this->input->post('shipping_address1');
			$email_data['sh_address2']		= $this->input->post('shipping_address2');
			$email_data['sh_city']			= $this->input->post('shipping_city');
			$email_data['sh_state']			= $this->input->post('shipping_state');
			$email_data['sh_country']		= $this->input->post('shipping_country');
			$email_data['sh_zipcode']		= $this->input->post('shipping_zipcode');

			if ($this->session->userdata('user_cat') === 'consumer')
			{
				$agree_to_return_policy = $this->input->post('agree_to_return_policy');
				$user_array['agree_policy'] = $agree_to_return_policy  == 'aye' ? TRUE : FALSE;
			}
			else $user_array['agree_policy'] = NULL;

			$user_array['p_first_name'] 	= $email_data['p_first_name'];
			$user_array['p_last_name'] 		= $email_data['p_last_name'];
			$user_array['p_email'] 			= $email_data['p_email'];
			$user_array['p_telephone'] 		= $email_data['p_telephone'];
			$user_array['p_store_name'] 	= $email_data['p_store_name'];

			$user_array['sh_address1']		= $email_data['sh_address1'];
			$user_array['sh_address2']		= $email_data['sh_address2'];
			$user_array['sh_city']			= $email_data['sh_city'];
			$user_array['sh_state']			= $email_data['sh_state'];
			$user_array['sh_country']		= $email_data['sh_country'];
			$user_array['sh_zipcode']		= $email_data['sh_zipcode'];

			$email_data['add_ny_sales_tax'] = $email_data['sh_state'] === 'New York' ? $this->cart->format_number($this->webspace_details->options['ny_sales_tax'] * $this->cart->total()) : 0;

			// check shipping method
			if ($ship_method)
			{
				$email_data['shipping_fee'] = $ship_method->fix_fee;
				$email_data['shipping_courier'] = $ship_method->courier;
				$email_data['shipping_method'] = $ship_method->courier.' ('.$ship_method->fee.')';
				$email_data['ship_method'] = TRUE;
			}
			else
			{
				$email_data['shipping_fee'] = '';
				$email_data['shipping_courier'] = 'DHL rate apply';
				$email_data['shipping_method'] = '';
				$email_data['ship_method'] = FALSE;
			}

			$user_array['shipping_fee']			= $email_data['shipping_fee'];
			$user_array['shipping_courier']		= $email_data['shipping_courier'];

			// compute grand total
			if ($this->session->userdata('user_cat') === 'consumer')
			{
				$email_data['grand_total'] = $this->cart->format_number($this->cart->total() + (int)$email_data['shipping_fee'] + $email_data['add_ny_sales_tax']);
			}
			else $email_data['grand_total'] = $this->cart->total() + $email_data['add_ny_sales_tax'];

			// Log order
			if ($this->session->userdata('user_cat') === 'consumer')
			{
				$email_data['order_log_id'] = $this->_log_order($user_array); //for retail
				$email_subject = $this->webspace_details->name.' Product Order'.($this->uri->segment(1) === 'special_sale' ? ' - SPECIAL SALE' : '');
			}
			elseif ($this->session->userdata('user_cat') === 'wholesale')
			{
				$email_data['order_log_id'] = $this->min_order_required($user_array); //for wholesale
				$email_subject = $this->webspace_details->name.' Product Order - Wholesale';

				// get sales user details
				$sa_usr_det = $this->sales_user_details->initialize(array('admin_sales_email'=>$this->wholesale_user_details->admin_sales_email));
			}

			$message = $this->load->view('templates/order_confirmation', $email_data, TRUE);

			if (ENVIRONMENT == 'development') // ---> used for development purposes
			{
				// we are unable to send out email in our dev environment
				// so we check on the email template instead.
				// just don't forget to comment these accordingly
				echo $message;
				echo '<br /><br />';

				// destroy cart and some sessions
				$this->cart->destroy();
				$data = array(
					'shipping_courier',
					'shipping_fee',
					'shipping_id',
					'confirm_order'
				);
				$this->session->unset_userdata($data);
				// current way to do and for redundancy purposes
				unset(
					$_SESSION['shipping_courier'],
					$_SESSION['shipping_fee'],
					$_SESSION['shipping_id'],
					$_SESSION['confirm_order']
				);

				echo '<a href="'.site_url('cart/order_sent/index/'.$email_data['order_log_id']).'">Continue...</a>';
				echo '<br /><br />';
				exit;
			}
			else
			{
				// let's send the email
				// load email library
				$this->load->library('email');

				// send to user
				$this->email->clear();

				$this->email->from($this->webspace_details->info_email, $this->webspace_details->name);

				$this->email->to($user_array['p_email']);

				$this->email->subject($email_subject);
				$this->email->message($message);

				$this->email->send();

				// send to admin
				$this->email->clear();

				$this->email->from($this->webspace_details->info_email, $this->webspace_details->name);
				$this->email->bcc($this->config->item('dev1_email'));
				$this->email->reply_to($user_array['p_email']);

				$this->email->to($this->webspace_details->info_email);

				$this->email->subject($email_subject);
				$this->email->message($message);

				$this->email->send();
			}

			// destroy cart and some sessions
			$this->cart->destroy();
			$data = array(
				'shipping_courier',
				'shipping_fee',
				'shipping_id',
				'confirm_order'
			);
			$this->session->unset_userdata($data);
			// current way to do and for redundancy purposes
			unset(
				$_SESSION['shipping_courier'],
				$_SESSION['shipping_fee'],
				$_SESSION['shipping_id'],
				$_SESSION['confirm_order']
			);

			// redirect user to order sent success page
			redirect('cart/order_sent/index/'.$email_data['order_log_id'], 'location');
		}
	}

	// --------------------------------------------------------------------

	function _log_order($user_array)
	{
		// insert user and shipping data to order log
		$log_data = array(
			'user_id'			=> $this->session->userdata('user_id'),
			'c'					=> $this->session->userdata('user_c'),

			'date_ordered'		=> @date('d, F Y - h:i',time()),
			'order_date'		=> time(),
			
			'courier'			=> $this->session->userdata('user_cat') === 'wholesale' ? $this->session->userdata('shipping_courier') : $user_array['shipping_courier'],
			'shipping_fee'		=> @$user_array['shipping_fee'] ? (int)$user_array['shipping_fee'] : 0,
			'amount'			=> $this->cart->total() + (int)$user_array['shipping_fee'],

			'firstname'			=> $user_array['p_first_name'],
			'lastname'			=> $user_array['p_last_name'],
			'email'				=> $user_array['p_email'],
			'telephone'			=> $user_array['p_telephone'],
			'store_name'		=> $user_array['p_store_name'],

			'ship_address1'		=> $user_array['sh_address1'],
			'ship_address2'		=> $user_array['sh_address2'],
			'ship_country'		=> $user_array['sh_country'],
			'ship_state'		=> $user_array['sh_state'],
			'ship_city'			=> $user_array['sh_city'],
			'ship_zipcode'		=> $user_array['sh_zipcode'],

			'agree_policy'		=> $user_array['agree_policy']
		);
		$this->DB->insert('tbl_order_log', $log_data);
		$order_log_id	= $this->DB->insert_id();

		$this->load->helper('string');
		$random_code	= strtoupper(random_string('alnum', 16)); // ----> randon_string() - a CI string helper function.

		// insert cart/order details to order log detail
		$i = 1;
		foreach ($this->cart->contents() as $items)
		{
			$log_detail_data = array(
				'order_log_id'			=> $order_log_id,
				'transaction_code'		=> $random_code,
				'image'					=> (@$items['options']['prod_image_url'] ? $items['options']['prod_image_url'] : $items['options']['prod_image']),
				'prod_sku'				=> $items['id'],
				'prod_no'				=> $items['options']['prod_no'],
				'prod_name'				=> $items['name'],
				'color'					=> $items['options']['color'],
				'size'					=> $items['options']['size'],
				'designer'				=> $items['options']['designer'],
				'qty'					=> $items['qty'],
				'unit_price'			=> $items['price'],
				'subtotal'				=> $items['subtotal'],
				'custom_order'			=> $items['options']['custom_order']
			);
			$this->DB->insert('tbl_order_log_details', $log_detail_data);
			$i++;
		}

		return $order_log_id;
	}

	// --------------------------------------------------------------------

	function min_order_required($user_array)
	{
		// special sale prefix
		$special_sale_prefix = $this->uri->segment(1) === 'special_sale' ? 'special_sale/' : '';

		/*
		| ------------------------------------------------------------------------------
		| This function check if the wholesale user has previous orders if not
		| it will require minimum order qty set
		*/
		$min_order = 0; // ---> ser minimum order requirement
		$totqty = 0;
		$user_id = $this->session->userdata('user_id');

		//$check = $this->query_product->check_first_order($user_id);
		$this->DB->select_sum('tbl_order_log_details.qty');
		$this->DB->from('tbluser_data_wholesale');
		$this->DB->join('tbl_order_log','tbl_order_log.user_id = tbluser_data_wholesale.user_id');
		$this->DB->join('tbl_order_log_details','tbl_order_log_details.order_log_id = tbl_order_log.order_log_id');
		$this->DB->where('tbluser_data_wholesale.user_id', intval($user_id));
		$this->DB->where('tbl_order_log.store_name !=' , '');
		$check = $this->DB->get();

		//count cart items
		foreach ($this->cart->contents() as $items)
		{
			$totqty += $items['qty'];
		}

		if ($check->row()->qty < $min_order && $totqty < $min_order)
		{
			$this->session->set_flashdata('flashRegMsg','<div class="errorMsg">Minimun First Order 15 Units. Please add more items to cart.</div>');
			redirect($special_sale_prefix.'cart', 'location');
		}
		else
		{
			$order_log_id = $this->_log_order($user_array);
		}

		return $order_log_id;
	}

	// --------------------------------------------------------------------

	/**
	 * Form Validation Callback Functions
	 *
	 * @return	boolean
	 */
	function check_payment_details($str)
	{
		if ($str == '')
		{
			$this->form_validation->set_message('check_payment_details', 'False paymnet details');
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
	function check_expiration_date($str, $exp_date)
	{
		if ($exp_date == '')
		{
			$this->form_validation->set_message('check_payment_details', 'False paymnet details');
			return FALSE;
		}
		else
		{
			$exp = explode('-', $exp_date);

			if ($exp[0] == '' OR $exp[1] == '')
			{
				$this->form_validation->set_message('check_payment_details', 'False paymnet details');
				return FALSE;
			}
			else return TRUE;
		}
	}

	// --------------------------------------------------------------------

	/**
	 * Form Validation Callback Functions
	 *
	 * @return	boolean
	 */
	function check_radio_policy($str)
	{
		if ($str == '')
		{
			$this->form_validation->set_message('check_radio_policy', 'False radio policy');
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
	function check_shipping_details($str)
	{
		if ($str == '')
		{
			$this->form_validation->set_message('check_shipping_details', 'False shipping details');
			return FALSE;
		}
		else return TRUE;
	}

	// --------------------------------------------------------------------

}
