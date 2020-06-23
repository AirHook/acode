<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/****************
 * Frontend Controller holds any general front end items
 *
 * Shop Controller are for items used for shop thumbs pages
 *
 */
class New_order extends Sales_user_Controller
{
	/**
	 * Constructor
	 *
	 * @return	void
	 */
	function __Construct()
	{
		parent::__Construct();
	}

	// --------------------------------------------------------------------

	/**
	 * Primary method - index
	 *
	 * @return	void
	 */
	function index()
	{
		// generate the plugin scripts and css
		$this->_create_plugin_scripts();

		// load pertinent library/model/helpers
		$this->load->model('shipping_methods');
		$this->load->helper('state_country_helper');
		$this->load->helper('metronic/create_category_treelist');
		$this->load->library('form_validation');
		$this->load->library('orders/orders_list');
		$this->load->library('orders/order_details');
		$this->load->library('designers/designers_list');
		$this->load->library('users/wholesale_users_list');
		$this->load->library('users/wholesale_user_details');
		$this->load->library('users/consumer_user_details');
		$this->load->library('users/sales_user_details');
		$this->load->library('categories/categories_tree');
		$this->load->library('products/product_details');
		$this->load->library('products/size_names');
		$this->load->library('color_list');

		// set validation rules
		$this->form_validation->set_rules('user_id', 'Store Data', 'trim|required');
		//$this->form_validation->set_rules('shipmethod', 'Shipping Method', 'trim|required');

		if ($this->form_validation->run() == FALSE)
		{
			// sales orders are checkout orders made by sales or admin for the wholesale users' call in or PO
			// anticipation for consumer is just a catch all thing
			// orders (sales or checkout) can no longer be modified
			// it is either confirmed or cancelled

			// get color list for the add product not in list
			$this->data['colors'] = $this->color_list->select();

			// shipping methods
			$this->data['ship_methods'] = $this->shipping_methods->get_methods();

			// get ws user list for the select store button
			// NOTE: consider sales resource login
			$this->data['users'] = $this->wholesale_users_list->select(
				array(
					'tbluser_data_wholesale.admin_sales_email' => $this->sales_user_details->email
				)
			);

			// select designer on/off
			// and get the designers list for the category list
			// - general admin shows all designer category tree
			// - satellite and stand-alone sites defaults to it's designer category tree
			// - sales users default to it's reference designer category tree
			if (
				$this->webspace_details->options['site_type'] == 'sat_site'
				OR $this->webspace_details->options['site_type'] == 'sal_site'
				OR $this->session->admin_sales_loggedin
			)
			{
				$this->data['select_designer'] = FALSE;
				$this->data['des_slug'] = @$this->sales_user_details->designer ?: $this->webspace_details->slug;
				$this->data['designers'] = $this->designers_list->select(
					array(
						'url_structure' => $this->data['des_slug']
					)
				);
				$this->session->so_des_slug = $this->data['des_slug'];
			}
			else
			{
				$this->data['select_designer'] = TRUE;
				$this->designers_list->initialize(array('with_products'=>TRUE));
				$this->data['designers'] = $this->designers_list->select();
			}

			// get some data if a designer has been previously selected
			if ($this->session->so_des_slug)
			{
				// get designer details
				$this->data['designer_details'] = $this->designer_details->initialize(
					array(
						'url_structure' => $this->session->so_des_slug
					)
				);
				$this->data['des_id'] = $this->designer_details->des_id;

				// get the designer category tree
				$this->data['des_subcats'] = $this->categories_tree->treelist(
					array(
						'd_url_structure' => $this->session->so_des_slug,
						'with_products' => TRUE
					)
				);
				$this->data['row_count'] = $this->categories_tree->row_count;
				$this->data['max_level'] = $this->categories_tree->max_category_level;
				$this->data['primary_subcat'] = $this->categories_tree->get_primary_subcat($this->session->so_des_slug);

				// get last category slug if slug_segs is present
				if ($this->session->so_slug_segs)
				{
					$this->data['slug_segs'] = json_decode($this->session->so_slug_segs, TRUE);
					$category_slug = end($this->data['slug_segs']);
					$category_id = $this->categories_tree->get_id($category_slug);
					$where_more['tbl_product.categories LIKE'] = $category_id;
				}
				else
				{
					$category_slug = $this->data['primary_subcat'];
					$category_id = $this->categories_tree->get_id($category_slug);
					$where_more['tbl_product.categories LIKE'] = $category_id;
				}

				// there will always be one des_slug to maintain one designer SO system
				$where_more['designer.url_structure'] = $this->session->so_des_slug;

				// don't show clearance cs only items for level 2 users
	            $con_clearance_cs_only = 'tbl_stock.options NOT LIKE \'%"clearance_consumer_only":"1"%\' ESCAPE \'!\'';
	            $where_more['condition'] = $con_clearance_cs_only;

				// get the products list for the thumbs grid view
				$params['show_private'] = TRUE; // all items general public (Y) - N for private
				//$params['view_status'] = 'ALL'; // all items view status (Y, Y1, Y2, N)
				//$params['view_at_hub'] = TRUE; // all items general public at hub site
				//$params['view_at_satellite'] = TRUE; // all items publis at satellite site
				//$params['variant_publish'] = 'ALL'; // all items at variant level publish (view status)
				//$params['variant_view_at_hub'] = TRUE; // variant level public at hub site
				//$params['variant_view_at_satellite'] = TRUE; // varian level public at satellite site

				// level 2 users show only items with stocks
				$params['with_stocks'] = TRUE; // TRUE shows instock items only

				$params['group_products'] = FALSE; // group per product number or per variant
				$params['special_sale'] = FALSE; // special sale items only
				$this->load->library('products/products_list', $params);
				$this->data['products'] = $this->products_list->select(
					$where_more,
					array( // order conditions
						'seque' => 'asc',
						'tbl_product.prod_no' => 'desc'
					)
				);
				$this->data['products_count'] = $this->products_list->row_count;
			}

			// with posibly designer details set, set company information as well
			// otherise, defaults to websapce details
			$this->data['company_name'] = $this->designer_details->company_name ?: $this->webspace_details->name;
			$this->data['company_address1'] = $this->designer_details->address1 ?: $this->webspace_details->address1;
			$this->data['company_address2'] = $this->designer_details->address2 ?: $this->webspace_details->address2;
			$this->data['company_city'] = $this->designer_details->city ?: $this->webspace_details->city;
			$this->data['company_state'] = $this->designer_details->state ?: $this->webspace_details->state;
			$this->data['company_zipcode'] = $this->designer_details->zipcode ?: $this->webspace_details->zipcode;
			$this->data['company_country'] = $this->designer_details->country ?: $this->webspace_details->country;
			$this->data['company_telephone'] = $this->designer_details->phone ?: $this->webspace_details->phone;
			$this->data['company_contact_person'] = $this->designer_details->owner ?: $this->webspace_details->owner;
			$this->data['company_contact_email'] = $this->designer_details->info_email ?: $this->webspace_details->info_email;

			// check for user id session to fill out bill to/ship to address
			if ($this->session->so_user_id)
			{
				// let's put session data into variables so we can user at frontend
				$this->data['user_id'] = $this->session->so_user_id;
				$this->data['user_cat'] = $this->session->so_user_cat;

				if ($this->data['user_cat'] == 'ws')
				{
					$this->data['store_details'] = $this->wholesale_user_details->initialize(
						array(
							'user_id' => $this->data['user_id']
						)
					);
				}
				else // defaults to 'cs' or guest
				{
					$this->data['store_details'] = $this->consumer_user_details->initialize(
						array(
							'user_id' => $this->data['user_id']
						)
					);
				}
			}
			else
			{
				// initial state since this controller is for sales who handles the wholesale user
				$this->data['user_cat'] = 'ws';
			}

			// set po number
			$this->data['so_number'] = $this->orders_list->max_order_number() + 1;
			for($c = strlen($this->data['so_number']);$c < 6;$c++)
			{
				$this->data['so_number'] = '0'.$this->data['so_number'];
			}

			/*****
			 * Check for items in session
			 */
			// check for po items
			$this->data['so_items'] =
				$this->session->so_items
				? json_decode($this->session->so_items, TRUE)
				: array()
			;
			// let's count how many items on per size lable basis
			$items_count = 0;
			foreach ($this->data['so_items'] as $item => $options)
			{
				if (is_array($options))
				{
					// count all sizes of the item
					$items_count += count($options);
				}
				else $items_count += 1; // count the item as one
			}
			$this->data['items_count'] = $items_count;

			// set author to 1 for Inhouse or set logged in admin sales user
			if ($this->session->admin_sales_loggedin)
			{
				$this->sales_user_details->initialize(
					array(
						'admin_sales_id' => $this->session->admin_sales_id
					)
				);

				$this->data['author_name'] = $this->sales_user_details->fname.' '.$this->sales_user_details->lname;
				$this->data['author'] = $this->data['author_name'];
				$this->data['author_email'] = $this->sales_user_details->email;
				$this->data['author_id'] = $this->sales_user_details->admin_sales_id;
			}
			else
			{
				$this->data['author_name'] = 'In-House';
				$this->data['author'] = 'admin'; // admin/system
				$this->data['author_email'] = $this->webspace_details->info_email;
				$this->data['author_id'] = $this->session->admin_id;
			}

			// need to show loading at start
			$this->data['show_loading'] = TRUE;
			$this->data['search_string'] = FALSE;

			// breadcrumbs
			$this->data['page_breadcrumb'] = array(
				'sales_orders/create' => 'Create Sales Orders'
			);

			$this->data['role'] = 'sales';
			$this->data['file'] = 'so_create';
			$this->data['page_title'] = 'Sales Order Create';
			$this->data['page_description'] = 'Create a Sales Order';

			// load views...
			$this->load->view('admin/metronic/template_my_account/template', $this->data);
		}
		else
		{
			if ( ! $this->session->so_items)
			{
				// nothing more to do...
				// set flash data
				$this->session->set_flashdata('error', 'no_id_passed');

				// redirect user
				redirect('my_account/sales/orders', 'location');
			}

			/***********
			 * Process the input data
			 */
			// input post data
			/* *
			Array
			(
			    [so_number] => 10302249 -----> not needed as this will be set before insertion to db
			    [so_date] => 2020-06-11 -----> not needed as this will be set before insertion to db
			    [options] => Array
			        (
			            [sales_order] => 1
			            [ref_so_no] =>
			            [payment_method] => Credit Card
			            [ref_checkout_no] =>
			        )
			    [c] => ws
			    [shipmethod] => 0
			    [user_id] => 14519
			    [author] => 90 -----> defaults to '1' for admin
			    [subtotal] => 490 -----> last item's subtotal
				[overall_qty] => 5
			    [overall_total] => 710
			    [remarks] =>
			    [files] =>
			)
			[so_items] => $this->session->so_items
				--> the items sample: {"D9776L_RED1":{"size_4":["1",0,"1"]},"D9998L_BLAC1":{"size_2":["2",0,"2"]}}
					use size index 0 for the qty
			// */

			// initialize user details
			if ($this->input->post('c') == 'ws')
			{
				$user_details = $this->wholesale_user_details->initialize(
					array(
						'user_id' => $this->input->post('user_id')
					)
				);
			}
			else
			{
				$user_details = $this->consumer_user_details->initialize(
					array(
						'user_id' => $this->input->post('user_id')
					)
				);
			}

			// decode shipping method
			if ($this->input->post('shipmethod'))
			{
				if ($this->input->post('shipmethod') == '0')
				{
					// International shipping, using DHL only for now...
					$courier = 'DHL International (DHL rates apply)';
					$shipping_fee = 0;
				}
				else
				{
					// USA uses UPC
					$ship_methods = $this->shipping_methods->get_method($this->input->post('shipmethod'));
					$courier = $ship_methods->courier;
					$shipping_fee = $ship_methods->fix_fee;
				}
			}
			else
			{
				$courier = 'TBD';
				$shipping_fee = 0;
			}

			// summarize options
			$post_options = $this->input->post('options');
			$options = array_filter($post_options, 'strlen');

			// set user details
			/*
			$user_array['store_name'] 		= $user_details->store_name;
			$user_array['agree_policy'] 	= NULL;
			$user_array['p_first_name'] 	= $user_details->fname;
			$user_array['p_last_name'] 		= $user_details->lname;
			$user_array['p_email'] 			= $user_details->email;
			$user_array['p_telephone'] 		= $user_details->telephone;
			$user_array['p_store_name'] 	= $user_details->store_name;
			$user_array['sh_address1']		= $user_details->address1;
			$user_array['sh_address2']		= $user_details->address2;
			$user_array['sh_city']			= $user_details->city;
			$user_array['sh_state']			= $user_details->state;
			$user_array['sh_country']		= $user_details->country;
			$user_array['sh_zipcode']		= $user_details->zipcode;
			$user_array['shipping_fee']		= $user_details->fix_fee;
			$user_array['shipping_courier']	= $user_details->courier;
			*/

			// insert user and shipping data to order log
			$log_data = array(
				'user_id'			=> $this->input->post('user_id'),
				'c'					=> $this->input->post('c'),
				'date_ordered'		=> @date('d, F Y - h:i',time()), // --> for depracation
				'order_date'		=> time(), // --> replaces 'date_ordered'

				'courier'			=> $courier,
				'shipping_fee'		=> $shipping_fee,
				'amount'			=> $this->input->post('overall_total'),

				'store_name'		=> $user_details->store_name,
				'firstname'			=> $user_details->fname,
				'lastname'			=> $user_details->lname,
				'email'				=> $user_details->email,
				'telephone'			=> $user_details->telephone,

				'ship_address1'		=> $user_details->address1,
				'ship_address2'		=> $user_details->address2,
				'ship_country'		=> $user_details->country,
				'ship_state'		=> $user_details->state,
				'ship_city'			=> $user_details->city,
				'ship_zipcode'		=> $user_details->zipcode,

				'webspace_id'		=> $this->sales_user_details->webspace_id,

				'agree_policy'		=> NULL,
				'options'			=> json_encode($options)
				// 'status' defaults to '0' for new orders or pending orders
			);

			// connect to database
			$DB = $this->load->database('instyle', TRUE);
			$DB->insert('tbl_order_log', $log_data);
			$order_log_id = $DB->insert_id();
			//$order_log_id = '12341234';

			$this->load->helper('string');
			$random_code = strtoupper(random_string('alnum', 16)); // ----> randon_string() - a CI string helper function.

			// get the items
			$so_items = json_decode($this->session->so_items, TRUE);

			$i = 1;
			foreach ($so_items as $item => $size_qty)
			{
				// --> the items sample: {"D9776L_RED1":{"size_4":["1",0,"1"]},"D9998L_BLAC1":{"size_2":["2",0,"2"]}}

				// just a catch all error suppression
				if ( ! $item) continue;

				// get product details
				// NOTE: some items may not be in product list
				$exp = explode('_', $item);
				$product = $this->product_details->initialize(
					array(
						'tbl_product.prod_no' => $exp[0],
						'color_code' => $exp[1]
					)
				);

				// set some data
				$prod_no = $exp[0];
				$color_code = $exp[1];
				$color_name = $product->color_name;

				// price can be...
				// onsale price (retail_sale_price or wholesale_price_clearance)
				// regular price (retail_price or wholesale_price)
				// new pricing scheme
				$orig_price =
					$this->input->post('c') == 'ws'
					? $product->wholesale_price
					: $product->retail_price
				;
				$price =
					$product->custom_order == '3'
					? (
						$this->input->post('c') == 'ws'
						? $product->wholesale_price_clearance
						: $product->retail_sale_price
					)
					: $orig_price
				;

				// image src
				$img_front_new = $this->config->item('PROD_IMG_URL').$product->media_path.$item.'_f3.jpg';

				// get size names
				$size_label = array_key_first($size_qty);
				$size_names = $this->size_names->get_size_names($product->size_mode);
				$size = $size_names[$size_label];
				$qty = $size_qty[$size_label][0];

				// for calculate]ion of available stocks
				if ($product->$size_label == '0')
				{
					// preorder
					$preorder = TRUE;
					$partial_stock = FALSE;
					$custom_order = '1';
				}
				elseif ($size_qty[$size_label][0] <= $product->$size_label)
				{
					// instock
					$preorder = FALSE;
					$partial_stock = FALSE;
					$custom_order = '0';
				}
				elseif ($size_qty[$size_label][0] > $product->$size_label)
				{
					// partial
					$preorder = TRUE;
					$partial_stock = TRUE;
					$custom_order = '4'; // --> new for partial stock, not recognized yet
				}
				else
				{
					$preorder = FALSE;
					$partial_stock = FALSE;
					$custom_order = $product->custom_order;
				}

				// override other customer order code if on sale
				if ($product->custom_order == '3') $custom_order = '3';

				// insert cart/order details to order log detail
				$log_detail_data = array(
					'order_log_id'			=> $order_log_id,
					'transaction_code'		=> $random_code, // for deprecation
					'image'					=> $img_front_new,
					'prod_sku'				=> $item,
					'prod_no'				=> $prod_no,
					'prod_name'				=> $product->prod_name,
					'color'					=> $color_name,
					'size'					=> $size,
					'designer'				=> $product->designer_name,
					'qty'					=> $qty,
					'unit_price'			=> $price,
					'subtotal'				=> $this->input->post('overall_total'),
					// custom_order = 0-instock, 1-preorer, 3-instock/clearance
					'custom_order'			=> $custom_order,
					'options'				=> json_encode(
												array(
													'orig_price' => $orig_price
												)
											)
				);
				$DB->insert('tbl_order_log_details', $log_detail_data);

				// process inventory by deducting from available and putting to onorder unless preorder
				// items needed are prod_no, color_code, size, qty
				if ($custom_order != '1')
				{
					$this->load->library('inventory/update_stocks');
					$config['prod_sku'] = $item;
					$config['size'] = $size;
					$config['qty'] = $qty;
					$config['order_id'] = $order_log_id;
					$this->update_stocks->initialize($config);
					$this->update_stocks->reserve();
				}

				$i++;
			}

			// let's start email sending
			/* */
			$email_subject = $this->webspace_details->name.' Product Order'.($this->input->post('c') == 'ws' ? ' - Wholesale' : '');
			$message = $this->load->view('templates/order_confirmation', @$email_data, TRUE);

				/**********
				 * New Order Confirmation Layout
				 * Uses most of the above items but needs to add a few things to make the new
				 * HTML layout work
				 * - this overrides above order details, email subject, and html message
				*/
				// initialize...
				$this->data['order_details'] = $this->order_details->initialize(array('tbl_order_log.order_log_id'=>$order_log_id));

				// get user_id and role and designer group
				$user_role = $this->data['order_details']->c;
				$user_id = $this->data['order_details']->user_id;
				$designer_group = $this->data['order_details']->designer_group;
				$designer_slug = $this->data['order_details']->designer_slug;

				// initialize user details based on above initialization
				$this->data['user_details'] = $user_details;

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

				// set email subject
				$email_subject = $this->sales_user_details->designer_name.' - Product Order'.($user_role == 'ws' ? ' - Wholesale' : '');

				// --> send to user
				$this->email->clear();

				// load the view
				$message = $this->load->view('templates/order_confirmation_new', $this->data, TRUE);

				$this->email->from($this->webspace_details->info_email, $this->webspace_details->name);

				$this->email->to($user_array['p_email']);

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

				// send to admin
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
			// */

			// unset some session variables
			unset($_SESSION['so_user_id']); // remove remembered ws user
			unset($_SESSION['so_des_slug']); // remove des_slug
			unset($_SESSION['so_items']); // remove the items

			// set flash data
			$this->session->set_flashdata('success', 'add');

			// redirect user
			redirect('my_account/sales/orders/details/index/'.$order_log_id, 'location');
		}
	}

	// ----------------------------------------------------------------------

	/**
	 * PRIVATE - Creaet Plugin Scripts and CSS for the page
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

			// ladda - show loading or progress bar on buttons
			$this->data['page_level_styles_plugins'].= '
				<link href="'.$assets_url.'/assets/global/plugins/ladda/ladda-themeless.min.css" rel="stylesheet" type="text/css" />
			';
			// bootstrap select
			$this->data['page_level_styles_plugins'].= '
				<link href="'.$assets_url.'/assets/global/plugins/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
				<link href="'.$assets_url.'/assets/global/plugins/select2/css/select2-bootstrap.min.css" rel="stylesheet" type="text/css" />
				<link href="'.$assets_url.'/assets/global/plugins/bootstrap-select/css/bootstrap-select.min.css" rel="stylesheet" type="text/css" />
			';
			// datepicker & date-time-pickers
			$this->data['page_level_styles_plugins'].= '
				<link href="'.$assets_url.'/assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css" rel="stylesheet" type="text/css" />
			';
			// summernote wysiwyg
			$this->data['page_level_styles_plugins'].= '
				<link href="'.$assets_url.'/assets/global/plugins/bootstrap-summernote/summernote.css" rel="stylesheet" type="text/css" />
			';
			// fancybox
			$this->data['page_level_styles_plugins'].= '
				<link href="'.$assets_url.'/assets/global/plugins/fancybox/source/jquery.fancybox.css" rel="stylesheet" type="text/css" media="screen" />
				<link href="'.$assets_url.'/assets/global/plugins/fancybox/source/helpers/jquery.fancybox-buttons.css" rel="stylesheet" type="text/css" media="screen" />
			';
			// toaster notification
			$this->data['page_level_styles_plugins'].= '
				<link href="'.$assets_url.'/assets/global/plugins/bootstrap-toastr/toastr.min.css" rel="stylesheet" type="text/css" />
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
				<script src="'.$assets_url.'/assets/global/plugins/bootstrap-select/js/bootstrap-select.min.js" type="text/javascript"></script>
			';
			// bootbox
			$this->data['page_level_plugins'].= '
				<script src="'.$assets_url.'/assets/global/plugins/bootbox/bootbox.min.js" type="text/javascript"></script>
			';
			// form validation
			$this->data['page_level_plugins'].= '
				<script src="'.$assets_url.'/assets/global/plugins/jquery-validation/js/jquery.validate.min.js" type="text/javascript"></script>
				<script src="'.$assets_url.'/assets/global/plugins/jquery-validation/js/additional-methods.min.js" type="text/javascript"></script>
			';
			// datepicker & date-time-pickers
			$this->data['page_level_plugins'].= '
				<script src="'.$assets_url.'/assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js" type="text/javascript"></script>
			';
			// unveil - lazy script for images
			$this->data['page_level_plugins'].= '
				<script src="'.base_url().'assets/custom/js/jquery.unveil.js" type="text/javascript"></script>
			';
			// summernote wysiwyg
			$this->data['page_level_plugins'].= '
				<script src="'.$assets_url.'/assets/global/plugins/bootstrap-summernote/summernote.min.js" type="text/javascript"></script>
			';
			// fancybox
			$this->data['page_level_plugins'].= '
				<script src="'.$assets_url.'/assets/global/plugins/fancybox/source/jquery.fancybox.pack.js" type="text/javascript"></script>
				<script src="'.$assets_url.'/assets/global/plugins/fancybox/source/helpers/jquery.fancybox-buttons.js" type="text/javascript"></script>
				<script src="'.$assets_url.'/assets/global/plugins/fancybox/source/helpers/jquery.fancybox-media.js" type="text/javascript"></script>
			';
			// jquery loading
			$this->data['page_level_plugins'].= '
			<script src="'.base_url().'assets/custom/jscript/jquery-loading/jquery.loading.min.js" type="text/javascript"></script>
			';
			// toaster notification
			$this->data['page_level_plugins'].= '
				<script src="'.$assets_url.'/assets/global/plugins/bootstrap-toastr/toastr.min.js" type="text/javascript"></script>
			';

		/****************
		 * page scripts inserted at <bottom>
		 */
		$this->data['page_level_scripts'] = '';

			// button spinners for ladda
			$this->data['page_level_scripts'].= '
				<script src="'.$assets_url.'/assets/pages/scripts/ui-buttons-spinners.min.js" type="text/javascript"></script>
			';
			// handle bootstrap select - make select class '.bs-select' a boostrap select picker
			$this->data['page_level_scripts'].= '
				<script src="'.$assets_url.'/assets/pages/scripts/components-bootstrap-select.min.js" type="text/javascript"></script>
			';
			// handle form validation, datepickers, and scripts
			$this->data['page_level_scripts'].= '
				<script src="'.base_url().'assets/custom/js/metronic/pages/scripts/sales-new-so-components.js" type="text/javascript"></script>
			';
	}

	// --------------------------------------------------------------------

}
