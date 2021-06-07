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
		$this->load->library('cart/cart_memory');

		// initialize consumer details
		//$this->consumer_user_details->initialize(array('user_id'=>$this->session->user_id));

		// log order (tbl_order_log items)
		// note: ship to address is saved on this order log
		// user bill to address is saved at or taken from user details
		// order details is also taken care at the _log_order() private method
		// stocks data update is also done in the _log_order() private method
		if ($this->session->user_role == 'wholesale') $user_array['store_name'] 	= $this->session->store_name;
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

		/**********
		 * New Order Confirmation Layout
		 * Uses most of the above items but needs to add a few things to make the new
		 * HTML layout work
		 * - this overrides above order details, email subject, and html message
		*/
		// we need to set some data to pass to view file before sending
		// order confirmation
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

			// remove from memory
			if ($this->session->user_loggedin && $this->session->user_role == 'wholesale')
			{
				// set user details before updating cart memory
				$this->cart_memory->user_details = array(
					'user_id' => $this->wholesale_user_details->user_id,
					'options' => $this->wholesale_user_details->options
				);
				// remove from memory
				$this->cart_memory->unset_ws();
			}
			else
			{
				// this part of the code is an anticipation for guest cart session
				// save to cookie as memory which is part of the wholesale cart session
				// memory saving program. something is wrong with the setcookie.
				// deferring this anticipation at the moment - _rey 20200604
				// remove from memory
				//$this->cart_memory->unset_cookie();
			}

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
			$shop7 =
				(
					$this->webspace_details->info_email == 'help@shop7thavenue.com'
					OR $this->webspace_details->slug == 'tempoparis'
				)
				? ''
				: ', help@shop7thavenue.com'
			;
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

		// remove from memory
		if ($this->session->user_loggedin && $this->session->user_role == 'wholesale')
		{
			// set user details before updating cart memory
			$this->cart_memory->user_details = array(
				'user_id' => $this->wholesale_user_details->user_id,
				'options' => $this->wholesale_user_details->options
			);
			// remove from memory
			$this->cart_memory->unset_ws();
		}
		else
		{
			// this part of the code is an anticipation for guest cart session
			// save to cookie as memory which is part of the wholesale cart session
			// memory saving program. something is wrong with the setcookie.
			// deferring this anticipation at the moment - _rey 20200604
			// remove from memory
			//$this->cart_memory->unset_cookie();
		}

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
		foreach ($this->cart->contents() as $item)
		{
			// insert cart/order details to order log detail
			$log_detail_data['order_log_id'] = $order_log_id;
			$log_detail_data['transaction_code'] = $random_code; // for deprecation;
			$log_detail_data['image'] =
				(isset($item['options']['prod_image_url']) && ! empty($item['options']['prod_image_url']))
				? $item['options']['prod_image_url']
				: $item['options']['prod_image']
			;
			$log_detail_data['prod_sku'] = $item['id'];
			$log_detail_data['prod_no'] = $item['options']['prod_no'];
			$log_detail_data['prod_name'] = $item['name'];
			$log_detail_data['color'] = $item['options']['color'];
			$log_detail_data['size'] = $item['options']['size'];
			$log_detail_data['designer'] = $item['options']['designer'];
			$log_detail_data['qty'] = $item['qty'];
			$log_detail_data['unit_price'] = $item['price'];
			$log_detail_data['subtotal'] = $item['subtotal'];
			$log_detail_data['custom_order'] = $item['options']['custom_order'] ?: '0'; // custom_order = 0-instock, 1-preorer, 3-instock/clearance
				$this_log_options['orig_price'] = @$item['options']['orig_price'] ?: $item['price'];
				$this_log_options['product_details_link'] = $item['options']['current_url'];
				if (@$item['options']['admin_stocks_only'])
				{
					$this_log_options['admin_stocks_only'] = $item['options']['admin_stocks_only']; // '1','0'
				}
			$log_detail_data['options'] = json_encode($this_log_options);
			$this->DB->insert('tbl_order_log_details', $log_detail_data);

			// process inventory by deducting from available and putting to onorder unless preorder
			// items needed are prod_no, color_code, size, qty
			if ($log_detail_data['custom_order'] != '1')
			{
				$config['prod_sku'] = $item['id'];
				$config['size'] = $item['options']['size'];
				$config['qty'] = $item['qty'];
				$config['order_id'] = $order_log_id;
				$config['admin_stocks'] = $item['options']['admin_stocks_only'];
				//if (@$item['options']['admin_stocks']) $config['admin_stocks'] = $item['options']['admin_stocks'];
				$this->update_stocks->initialize($config);
				$this->update_stocks->reserve();

				// check for post to google and delete where necessary
				// on stocks zero count
				// get product details
				$exp = explode('_', $item['id']);
				$product_details = $this->product_details->initialize(
					array(
						'tbl_product.prod_no' => @$exp[0],
						'color_code' => @$exp[1]
					)
				);

				// get stocks options particularly ['post_to_goole']
				$stocks_options = $product_details->stocks_options;
				if (@$stocks_optionsp['post_to_goole'])
				{
					// check for available stocks
					// load library and get available sizes
					$this->load->model('get_sizes_by_mode');
					$get_size = $this->get_sizes_by_mode->get_sizes($product_details->size_mode);
					$this->load->model('get_product_stocks');
					$check_stock = $this->get_product_stocks->get_stocks($product_details->prod_no, $product_details->color_name);
					$available_sizes = array();
					foreach ($get_size as $size)
					{
						// we need to set the prefix for the size lable
						if($size->size_name == 'XS' || $size->size_name == 'S' || $size->size_name == 'M' || $size->size_name == 'L' || $size->size_name == 'XL' || $size->size_name == 'XXL' || $size->size_name == 'XL1' || $size->size_name == 'XL2' || $size->size_name == 'S-M' || $size->size_name == 'M-L' || $size->size_name == 'ONE-SIZE-FITS-ALL')
						{
							$size_stock = 'available_s'.strtolower($size->size_name);
							$admin_size_stock = 'admin_s'.strtolower($size->size_name);
						}
						else
						{
							$size_stock = 'available_'.$size->size_name;
							$admin_size_stock = 'admin_'.$size->size_name;
						}
						$max_available =
							(
								@$product_details->stocks_options['clearance_consumer_only'] == '1'
								OR @$product_details->stocks_options['admin_stocks_only'] == '1'
							)
							? $check_stock[$size_stock] + $check_stock[$admin_size_stock]
							: $check_stock[$size_stock]
						;

						if ($max_available > 0) array_push($available_sizes, $size->size_name);
					}

					if (empty($available_sizes))
					{
						// load library and remove from google
						$this->load->library('api/google/delete');
						$this->delete->initialize(
							array(
								'prod_no' => $product_details->prod_no,
								'color_code' => $product_details->color_code
							)
						);
						$response = $this->delete->go($stocks_options['post_to_goole']);

						// unset any previous ['post_to_goole']
						unset($stocks_options['post_to_goole']);

						// set new options data in json form
						$post_ary['options'] = json_encode($stocks_options);

						// update stock record
						$this->DB->set($post_ary);
						$this->DB->where('st_id', $product_details->st_id);
						$q = $this->DB->update('tbl_stock');
					}
					else
					{
						// simply update google product data
						// load library and post to google
						$this->load->library('api/google/upsert');
						$this->upsert->initialize(
							array(
								'prod_no' => $product_details->prod_no,
								'color_code' => $product_details->color_code
							)
						);
						$response = $this->upsert->go();
					}
				}
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
