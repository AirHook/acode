<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/****************
 * Frontend Controller holds any general front end items
 *
 * Shop Controller are for items used for shop thumbs pages
 *
 */
class Submit_order extends Frontend_Controller
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

		$previous_url		= $this->input->post('current_url');

		$email_data['p_card_type']		= $this->input->post('payment_card_type');
		$email_data['p_card_num']		= $this->input->post('payment_card_num');
		$email_data['p_exp_date']		= $this->webspace_details->options['theme'] == 'roden2' ? $this->input->post('creditCardExpirationMonth').'/'.$this->input->post('creditCardExpirationYear') : $this->input->post('payment_exp_date');
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

		// check for NY sales tax
		$email_data['add_ny_sales_tax'] = $email_data['sh_state'] === 'New York' ? $this->cart->format_number($this->webspace_details->options['ny_sales_tax'] * $this->cart->total()) : 0;

		// compute grand total
		$email_data['grand_total'] = $this->cart->total() + $email_data['add_ny_sales_tax'];

		// log order
		$user_array['agree_policy'] = NULL;

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

		$user_array['shipping_fee']		= '';
		$user_array['shipping_courier']	= '';

		$email_data['order_log_id'] = $this->min_order_required($user_array); //for wholesale

		// get sales user details
		$this->load->library('users/sales_user_details');
		$sa_usr_det = $this->sales_user_details->initialize(array('admin_sales_email'=>$this->wholesale_user_details->admin_sales_email));

		// let's start email sending
		$email_subject = $this->webspace_details->name.' Product Order - Wholesale';

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
				'shipping_courier'	=> '',
				'shipping_fee'		=> '',
				'shipping_id'		=> ''
			);
			$this->session->unset_userdata($data);

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
			'shipping_courier'	=> '',
			'shipping_fee'		=> '',
			'shipping_id'		=> ''
		);
		$this->session->unset_userdata($data);

		// redirect user to order sent success page
		redirect('cart/order_sent/index/'.$email_data['order_log_id'], 'location');
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

	function _log_order($user_array)
	{
		// insert user and shipping data to order log
		$log_data = array(
			'user_id'			=> $this->wholesale_user_details->user_id,
			'c'					=> 'ws',

			'date_ordered'		=> @date('d, F Y - h:i',time()),
			'order_date'		=> time(),
			
			'courier'			=> $user_array['shipping_courier'],
			'shipping_fee'		=> $user_array['shipping_fee'] ? (int)$user_array['shipping_fee'] : 0,
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
				'image'					=> (
											(isset($items['options']['prod_image_url']) && ! empty($items['options']['prod_image_url']))
											? $items['options']['prod_image_url']
											: $items['options']['prod_image']
										),
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

}
