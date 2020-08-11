<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/****************
 * Frontend Controller holds any general front end items
 *
 * Shop Controller are for items used for shop thumbs pages
 *
 */
class Submit extends Frontend_Controller
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
		if ($this->cart->total_items() == 0)
		{
			// set flash data
			$this->session->set_flashdata('error', 'no_id_passed');

			// nothing to do... return to cart basket.
			redirect('cart', 'location');
		}

		// load pertinent library/model/helpers
		$this->load->library('users/wholesale_user_details');
		$this->load->library('users/consumer_user_details');
		$this->load->library('designers/designer_details');
		$this->load->library('products/product_details');
		$this->load->library('orders/order_details');
		$this->load->library('products/size_names');

		// initialize consumer details
		$this->consumer_user_details->initialize(array('user_id'=>$this->session->user_id));

		// log order
		if ($this->session->user_cat == 'wholesale') $user_array['store_name'] 	= $this->session->store_name;
		$user_array['agree_policy'] 	= NULL;
		$user_array['p_first_name'] 	= $this->session->sh_firstname;
		$user_array['p_last_name'] 		= $this->session->sh_lastname;
		$user_array['p_email'] 			= $this->session->sh_email;
		$user_array['p_telephone'] 		= $this->session->sh_phone;
		$user_array['p_store_name'] 	= $this->session->store_name ?: '';
		$user_array['sh_address1']		= $this->session->sh_address1;
		$user_array['sh_address2']		= $this->session->sh_address2;
		$user_array['sh_city']			= $this->session->sh_city;
		$user_array['sh_state']			= $this->session->sh_state;
		$user_array['sh_country']		= $this->session->sh_country;
		$user_array['sh_zipcode']		= $this->session->sh_zip;
		$user_array['shipping_fee']		= $this->session->fix_fee;
		$user_array['shipping_courier']	= $this->session->courier;

		//if ($this->session->user_cat == 'wholesale') $email_data['order_log_id'] = $this->min_order_required($user_array); //for wholesale
		//else $email_data['order_log_id'] = $this->_log_order($user_array);
		if ($this->session->user_cat == 'wholesale') $order_log_id = $this->min_order_required($user_array); //for wholesale
		else $order_log_id = $this->_log_order($user_array);

		// use the logged order data to poppulate the email confirmation
		// to use the designer setting
		// initialize order details
		//$email_data = $this->order_details->initialize(array('tbl_order_log.order_log_id'=>$order_log_id));

		// we will just use the flashdata session directly on the view file
		// to show the cc details...
		//$email_data['p_card_type']		= $this->session->flashdata('cc_type');
		//$email_data['p_card_num']		= $this->session->flashdata('cc_number');
		//$email_data['p_exp_date']		= $this->session->flashdata('cc_expmo').'/'.$this->session->flashdata('cc_expyy');
		//$email_data['p_card_code']		= $this->session->flashdata('cc_code');

		// keeping this here for now
		//$email_data['p_first_name']		= $this->session->sh_firstname;
		//$email_data['p_last_name']		= $this->session->sh_lastname;
		//$email_data['p_email']			= $this->session->sh_email;
		//$email_data['p_telephone']		= $this->session->sh_phone;
		//$email_data['p_store_name']		= $this->session->store_name ?: '';
		//$email_data['sh_address1']		= $this->session->sh_address1;
		//$email_data['sh_address2']		= $this->session->sh_address2;
		//$email_data['sh_city']			= $this->session->sh_city;
		//$email_data['sh_state']			= $this->session->sh_state;
		//$email_data['sh_country']		= $this->session->sh_country;
		//$email_data['sh_zipcode']		= $this->session->sh_zip;
		//$email_data['shipping_fee']		= $this->session->fix_fee;
		//$email_data['shipping_courier']	= $this->session->courier;
		//$email_data['add_ny_sales_tax']	= $this->session->ny_tax ? $this->cart->format_number($this->webspace_details->options['ny_sales_tax'] * $this->cart->total()) : 0;

		// compute grand total
		//$email_data['grand_total'] = $this->cart->total() + $email_data['add_ny_sales_tax'] + $email_data['shipping_fee'];

		// let's start email sending
		//$email_subject = $this->webspace_details->name.' Product Order'.($this->session->user_cat == 'wholesale' ? ' - Wholesale' : '');
		//$message = $this->load->view('templates/order_confirmation', $email_data, TRUE);

			/**********
			 * New Order Confirmation Layout
			 * Uses most of the above items but needs to add a few things to make the new
			 * HTML layout work
			 * - this overrides above order details, email subject, and html message
			*/
			// initialize...
			$this->data['order_details'] =
				$this->order_details->initialize(
					array(
						'tbl_order_log.order_log_id'=>$order_log_id
					)
				)
			;

			// get user_id and role and designer group
			$user_role = $this->data['order_details']->c;
			$user_id = $this->data['order_details']->user_id;
			$designer_group = $this->data['order_details']->designer_group;
			$designer_slug = $this->data['order_details']->designer_slug;

			// initialize user details
			if ($user_role == 'ws')
			{
				// wholesale
				$this->data['user_details'] =
					$this->wholesale_user_details->initialize(
						array(
							'user_id'=>$user_id
						)
					)
				;
			}
			else
			{
				// consumer
				$this->data['user_details'] =
					$this->consumer_user_details->initialize(
						array(
							'user_id'=>$user_id
						)
					)
				;
			}

			// set company details via order designer
			if ($designer_group == 'Mixed Designers')
			{
				$this->data['company_name'] = $this->webspace_details->name;
				$this->data['company_address1'] = $this->webspace_details->address1;
				$this->data['company_address2'] = $this->webspace_details->address2;
				$this->data['company_city'] = $this->webspace_details->city;
				$this->data['company_state'] = $this->webspace_details->state;
				$this->data['company_zipcode'] = $this->webspace_details->zipcode;
				$this->data['company_country'] = $this->webspace_details->country;
				$this->data['company_telephone'] = $this->webspace_details->phone;
				$info_email = $this->webspace_details->info_email;
				$this->data['logo'] =
					@$this->webspace_details->options['logo']
					? $this->config->item('PROD_IMG_URL').$this->webspace_details->options['logo']
					: $this->config->item('PROD_IMG_URL').'assets/images/logo/logo-shop7thavenue.png'
				;
			}
			else
			{
				// initialize class
				$this->designer_details->initialize(
					array(
						'url_structure' => $designer_slug
					)
				);

				$this->data['company_name'] = $this->designer_details->designer;
				$this->data['company_address1'] = $this->designer_details->address1;
				$this->data['company_address2'] = $this->designer_details->address2;
				$this->data['company_city'] = $this->designer_details->city;
				$this->data['company_state'] = $this->designer_details->state;
				$this->data['company_zipcode'] = $this->designer_details->zipcode;
				$this->data['company_country'] = $this->designer_details->country;
				$this->data['company_telephone'] = $this->designer_details->phone;
				$info_email = $this->designer_details->info_email;
				$this->data['logo'] = $this->config->item('PROD_IMG_URL').$this->designer_details->logo;
			}

			// set email subject
			$email_subject = $this->data['company_name'].' - Product Order'.($user_role == 'ws' ? ' - Wholesale' : '');

			// load the view
			$message = $this->load->view('templates/order_confirmation_new', $this->data, TRUE);

		if (ENVIRONMENT == 'development') // ---> used for development purposes
		{
			// we are unable to send out email in our dev environment
			// so we check on the email template instead.
			// just don't forget to comment these accordingly

			// load the view (user copy)
			$message = $this->load->view('templates/order_confirmation_new', $this->data, TRUE);

			echo $message;
			echo '<br /><br />';

			// load the view (admin copy)
			$this->data['sending_to_admin'] = TRUE; //$this->order_details->c == 'ws' ? FALSE : TRUE;
			$message = $this->load->view('templates/order_confirmation_new', $this->data, TRUE);

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

			echo '<a href="'.site_url('checkout/receipt/index/'.$order_log_id).'">Continue...</a>';
			echo '<br /><br />';
			exit;
		}
		else
		{
			// let's send the email
			// load pertinent library/model/helpers
			$this->load->library('email');
			$this->load->library('mailgun/mailgun');

			$sendby = @$this->webspace_details->options['email_send_by'] ?: 'default'; // options: mailgun, default (CI native emailer)

			// --> send to user
			$this->email->clear();

			$this->email->from($this->webspace_details->info_email, $this->webspace_details->name);

			$this->email->to($user_array['p_email']);
			$this->email->bcc('help@shop7thavenue.com');

			$this->email->subject($email_subject);
			$this->email->message($message);

			if ($sendby == 'mailgun')
			{
				$this->mailgun->from = $this->webspace_details->name.' <'.$this->webspace_details->info_email.'>';
				$this->mailgun->to = $user_array['p_email'];
				$this->mailgun->subject = $email_subject;
				$this->mailgun->message = $message;

				if ( ! $this->mailgun->Send())
				{
					// capturing error but the error message it not captured from MG class
					// the return info is still a bug to fix
					$error = 'Unable to MG send to - "'.$email.'"<br />';
					$error .= '-'.$this->mailgun->error_message;
				}

				$this->mailgun->clear();
			}
			else
			{
				// email class has a security error
				// "idn_to_ascii(): INTL_IDNA_VARIANT_2003 is deprecated"
				// using the '@' sign to supress this
				// must resolve pending update of CI
				if ( ! @$this->email->send())
				{
					$error = 'Unable to CI send to - "'.$email.'"<br />';
				}
			}
			//$this->email->send();

			// --> send to admin
			$this->email->clear();

			// load the view
			$this->data['sending_to_admin'] = $this->order_details->c == 'ws' ? FALSE : TRUE;
			$message = $this->load->view('templates/order_confirmation_new', $this->data, TRUE);

			$this->email->from($this->webspace_details->info_email, $this->webspace_details->name);
			$this->email->reply_to($user_array['p_email']);

			// copies
			$shop7 = $this->webspace_details->info_email == 'help@shop7thavenue.com' ? '' : ', help@shop7thavenue.com';
			$this->email->bcc($this->config->item('dev1_email').$shop7);

			$this->email->to($this->webspace_details->info_email);

			$this->email->subject($email_subject);
			$this->email->message($message);

			if ($sendby == 'mailgun')
			{
				$this->mailgun->from = $this->webspace_details->name.' <'.$this->webspace_details->info_email.'>';
				$this->mailgun->to = $this->webspace_details->info_email;
				$this->mailgun->cc = 'help@instylenewyork.com';
				$this->mailgun->bcc = $this->config->item('dev1_email');
				$this->mailgun->subject = $email_subject;
				$this->mailgun->message = $message;

				if ( ! $this->mailgun->Send())
				{
					// capturing error but the error message it not captured from MG class
					// the return info is still a bug to fix
					$error = 'Unable to MG send to - "'.$email.'"<br />';
					$error .= '-'.$this->mailgun->error_message;
				}

				$this->mailgun->clear();
			}
			else
			{
				// email class has a security error
				// "idn_to_ascii(): INTL_IDNA_VARIANT_2003 is deprecated"
				// using the '@' sign to supress this
				// must resolve pending update of CI
				if ( ! @$this->email->send())
				{
					$error = 'Unable to CI send to - "'.$email.'"<br />';
				}
			}
			//$this->email->send();
		}

		// mark session data as flash for one last use on the
		// receipt page
		$markdata = array(
			'ny_tax',
			'same_shipping_address',
			'store_name',
			'b_email',
			'b_firstname',
			'b_lastname',
			'b_phone',
			'b_address1',
			'b_address2',
			'b_country',
			'b_city',
			'b_state',
			'b_zip',
			'sh_email',
			'sh_firstname',
			'sh_lastname',
			'sh_phone',
			'sh_address1',
			'sh_address2',
			'sh_country',
			'sh_city',
			'sh_state',
			'sh_zip',
			'shipmethod',
			'courier',
			'fix_fee',
			'cc_type',
			'cc_number',
			'cc_expmo',
			'cc_expyy',
			'cc_code',
			'agree_to_policy'
		);
		$this->session->mark_as_flash($markdata);

		// destroy cart
		$this->cart->destroy();

		// send user to order receipt page
		redirect('checkout/receipt/index/'.$order_log_id);
	}

	// --------------------------------------------------------------------

	function min_order_required($user_array)
	{
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
			// set flash data
			$this->session->set_flashdata('error', 'minimum_order_required');

			// nothing to do... return to cart basket.
			redirect('cart', 'location');
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
		// set order options
		$order_options = array();
		if ($this->session->ws_payment_options) $order_options['ws_payment_options'] = $this->session->ws_payment_options;

		// insert user and shipping data to order log
		$log_data = array(
			'user_id'			=> $this->session->user_id,
			'c'					=> @$user_array['store_name'] ? 'ws' : 'guest',
			'date_ordered'		=> @date('d, F Y - h:i',time()),
			'order_date'		=> time(),

			'courier'			=> $user_array['shipping_courier'],
			'shipping_fee'		=> $user_array['shipping_fee'] ? (int)$user_array['shipping_fee'] : 0,
			//'amount'			=> $this->cart->total() + (int)$user_array['shipping_fee'],
			'amount'			=> $this->cart->total(),

			'store_name'		=> (@$user_array['store_name'] ?: ''),
			'firstname'			=> $user_array['p_first_name'],
			'lastname'			=> $user_array['p_last_name'],
			'email'				=> $user_array['p_email'],
			'telephone'			=> $user_array['p_telephone'],

			'ship_address1'		=> $user_array['sh_address1'],
			'ship_address2'		=> $user_array['sh_address2'],
			'ship_country'		=> $user_array['sh_country'],
			'ship_state'		=> $user_array['sh_state'],
			'ship_city'			=> $user_array['sh_city'],
			'ship_zipcode'		=> $user_array['sh_zipcode'],

			'webspace_id'		=> $this->webspace_details->id,

			'agree_policy'		=> $user_array['agree_policy'],
			'options'			=> json_encode($order_options)
			// 'status' defaults to '0' for new orders or pending orders
		);
		$this->DB->insert('tbl_order_log', $log_data);
		$order_log_id = $this->DB->insert_id();

		$this->load->helper('string');
		$random_code = strtoupper(random_string('alnum', 16)); // ----> randon_string() - a CI string helper function.

		// load reserve stock class
		$this->load->library('inventory/update_stocks');

		$i = 1;
		foreach ($this->cart->contents() as $items)
		{
			// insert cart/order details to order log detail
			$log_detail_data = array(
				'order_log_id'			=> $order_log_id,
				'transaction_code'		=> $random_code, // for deprecation
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
				// custom_order = 0-instock, 1-preorer, 3-instock/clearance
				'custom_order'			=> ($items['options']['custom_order'] ?: '0'),
				'options'				=> json_encode(
											array(
												'orig_price' => (@$items['options']['orig_price'] ?: $items['price']),
												'product_details_link' => $items['options']['current_url']
											)
										)
			);
			$this->DB->insert('tbl_order_log_details', $log_detail_data);

			// process inventory by deducting from available and putting to onorder unless preorder
			// items needed are prod_no, color_code, size, qty
			if ($log_detail_data['custom_order'] != '1')
			{
				$config['prod_sku'] = $items['id'];
				$config['size'] = $items['options']['size'];
				$config['qty'] = $items['qty'];
				$config['order_id'] = $order_log_id;
				$this->update_stocks->initialize($config);
				$this->update_stocks->reserve();
			}

			$i++;
		}

		return $order_log_id;
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
			// bootstrap tagsinput
			$this->data['page_level_styles_plugins'].= '
				<link href="'.$assets_url.'/assets/global/plugins/bootstrap-tagsinput/bootstrap-tagsinput.css" rel="stylesheet" type="text/css" />
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

			// unveil - lazy script for images
			$this->data['page_level_plugins'] = '
				<script src="'.base_url().'assets/custom/js/jquery.unveil.js" type="text/javascript"></script>
			';
			// bootstrap select
			$this->data['page_level_plugins'].= '
				<script src="'.$assets_url.'/assets/global/plugins/select2/js/select2.full.min.js" type="text/javascript"></script>
				<script src="'.$assets_url.'/assets/global/plugins/bootstrap-select/js/bootstrap-select.min.js" type="text/javascript"></script>
			';
			// bootstrap tagsinput
			$this->data['page_level_plugins'].= '
				<script src="'.$assets_url.'/assets/global/plugins/bootstrap-tagsinput/bootstrap-tagsinput.min.js" type="text/javascript"></script>
			';
			// matchheight
			$this->data['page_level_plugins'].= '
				<script src="'.base_url().'assets/custom/jscript/matchheight/jquery.matchHeight.min.js" type="text/javascript"></script>
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
				<script src="'.base_url().'assets/custom/js/metronic/pages/scripts/components-frontend-product_thumbs-scripts.js" type="text/javascript"></script>
			';
	}

	// --------------------------------------------------------------------

}
