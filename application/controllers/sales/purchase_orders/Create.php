<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Create extends Sales_Controller {

	/**
	 * DB Object
	 *
	 * @var	object
	 */
	protected $DB;

	/**
	 * Constructor
	 *
	 * @return	void
	 */
	public function __construct()
	{
		parent::__construct();

		// load pertinent library/model/helpers
		$this->load->helper('metronic/create_category_treelist');
		$this->load->library('products/size_names');
		$this->load->library('designers/designer_details');
		$this->load->library('users/vendor_users_list');
		$this->load->library('users/vendor_user_details');
		$this->load->library('categories/categories_tree');

		// check if sales user and session designer are not the same
		if (
			$this->session->po_des_url_structure
			&& $this->session->po_des_url_structure != $this->sales_user_details->designer
		)
		{
			// new po sales access
			unset($_SESSION['po_vendor_id']);
			unset($_SESSION['po_des_url_structure']);
			unset($_SESSION['po_items']);
			unset($_SESSION['po_size_qty']);
			unset($_SESSION['po_store_id']);

			// set flash data
			$this->session->set_flashdata('error', 'no_id_passed');

			// let's reload page
			redirect('sales/purchase_orders/create/step1', 'location');
		}

		// let's ensure that there are no sales session for po mod
		if ($this->session->po_mod_size_qty)
		{
			// new po sales access
			unset($_SESSION['po_vendor_id']);
			unset($_SESSION['po_des_url_structure']);
			unset($_SESSION['po_items']);
			unset($_SESSION['po_size_qty']);
			unset($_SESSION['po_store_id']);
			unset($_SESSION['po_edit_vendor_price']);
			// remove po mod details
			unset($_SESSION['po_mod_vendor_id']);
			unset($_SESSION['po_mod_des_url_structure']);
			unset($_SESSION['po_mod_items']);
			unset($_SESSION['po_mod_mod_size_qty']);
			unset($_SESSION['po_mod_store_id']);
			unset($_SESSION['po_mod_edit_vendor_price']);
		}

		// get the vendor data
		$this->data['vendors'] = $this->vendor_users_list->select(
			array(
				'vendors.reference_designer' => $this->sales_user_details->designer
			)
		);

		// let's remove the segments (up to controller class method/function)
		$this->data['url_segs'] = explode('/', $this->uri->uri_string());
		array_shift($this->data['url_segs']); // sales
		array_shift($this->data['url_segs']); // purchase_orders
		array_shift($this->data['url_segs']); // create
		array_shift($this->data['url_segs']); // step

		/*****
		 * Check for items in session
		 */
		// check for po items
		$this->data['po_items'] =
			$this->session->po_items
			? json_decode($this->session->po_items, TRUE)
			: array()
		;
		$po_items_count = 0;
		foreach ($this->data['po_items'] as $key => $val)
		{
			if (is_array($val))
			{
				$po_items_count += array_sum($val);
			}
			else $po_items_count += 1;
		}
		$this->data['po_items_count'] = $po_items_count;
		$this->data['po_size_qty'] =
			$this->session->po_size_qty
			? json_decode($this->session->po_size_qty, TRUE)
			: array()
		;

		// connect to database
		$this->DB = $this->load->database('instyle', TRUE);
    }

	// ----------------------------------------------------------------------

	/**
	 * Index - Edit Sales Package
	 *
	 * Edit selected sales pacakge or newly created sales package
	 *
	 * @return	void
	 */
	public function index()
	{
		// redirect user
		redirect('sales/purchase_orders/create/step1', 'location');
	}

	// ----------------------------------------------------------------------

	/**
	 * STEP 1 - Select vendor
	 *
	 * @return	void
	 */
	public function step1()
	{
		// generate the plugin scripts and css
		$this->_create_plugin_scripts();

		// load pertinent library/model/helpers
		$this->load->library('form_validation');

		// set validation rules
		$this->form_validation->set_rules('vendor_id', 'Vendor', 'trim|required');

		if ($this->form_validation->run() == FALSE)
		{
			// some necessary variables
			$this->data['steps'] = 1;

			// need to show loading at start
			$this->data['show_loading'] = FALSE;

			// set data variables...
			$this->data['file'] = 'create_purchase_order_step1';
			$this->data['page_title'] = 'Purchase Order';
			$this->data['page_description'] = 'Create Purchase Order';

			// load views...
			$this->load->view($this->data['sales_theme'].'/sales/template/template', $this->data);
		}
		else
		{
			// check for existing vendor id on session
			if ($this->session->po_vendor_id !== $this->input->post('vendor_id'))
			{
				// reset vendor id among others
				unset($_SESSION['po_vendor_id']);
				unset($_SESSION['po_items']);
				unset($_SESSION['po_size_qty']);
				unset($_SESSION['po_store_id']);
			}

			// set sessions for vendor id
			$this->session->set_userdata('po_vendor_id', $this->input->post('vendor_id'));
			// set sessions for des id
			$this->session->set_userdata('po_des_url_structure', $this->input->post('url_structure'));

			redirect('sales/purchase_orders/create/step2/womens_apparel', 'location');
		}
	}

	// ----------------------------------------------------------------------

	/**
	 * STEP 2 - Select product items via thumbs
	 *
	 * @return	void
	 */
	public function step2()
	{
		// generate the plugin scripts and css
		$this->_create_plugin_scripts();

		// load pertinent library/model/helpers
		$this->load->library('color_list');

		// get color list
		$this->data['colors'] = $this->color_list->select();

		// get vendor details
		$this->data['vendor'] = $this->vendor_user_details->initialize(
			array(
				'vendor_id' => $this->session->po_vendor_id
			)
		);
		if ( ! $this->data['vendor'])
		{
			// no vendor yet, let user selecct vendor
			// set flash data
			$this->session->set_flashdata('error', 'no_id_passed');

			// redirect user
			redirect('sales/purchase_orders/create/step1', 'location');
		}

		// last segment as category slug
		$this->data['active_category'] =
			$this->uri->segment(3) == 'create'
			? ((count($this->data['url_segs']) - 1) >= 0 ? $this->data['url_segs'][count($this->data['url_segs']) - 1] : 'womens_apparel')
			: 'womens_apparel'
		;

		// get respective active category ID for use on product list where condition
		$category_id = $this->categories_tree->get_id($this->data['active_category']);

		// let's do some defaults...
		// get the designer details for the sidebar
		$this->data['designer'] = $this->designer_details->initialize(array('url_structure'=>$this->session->po_des_url_structure));

 		// active designer selection
		$this->data['active_designer'] = $this->designer_details->url_structure;

		// set array for where condition of get product list
		if ($this->data['active_designer'])
		{
			$where = array(
				'designer.url_structure' => $this->data['active_designer'],
				'tbl_product.categories LIKE' => '%'.$category_id.'%',
				'tbl_product.vendor_id' => $this->session->po_vendor_id
			);
		}
		else
		{
			$where = array(
				'tbl_product.categories LIKE' => '%'.$category_id.'%',
				'tbl_product.vendor_id' => $this->session->po_vendor_id
			);
		}

		// get the products list
		$params['show_private'] = TRUE; // all items general public (Y) - N for private
		$params['view_status'] = 'ALL'; // ALL items view status (Y, Y1, Y2, N)
		$params['variant_publish'] = 'ALL'; // ALL variant level color publish (view status)
		$params['group_products'] = FALSE; // group per product number or per variant
		// show items even without stocks at all
		$params['with_stocks'] = FALSE;
		$this->load->library('products/products_list', $params);
		$this->data['products'] = $this->products_list->select(
			$where,
			array( // order conditions
				'seque' => 'desc',
				'tbl_product.prod_no' => 'desc'
			)
		);
		$this->data['products_count'] = $this->products_list->row_count;

		// some necessary variables and data
		$this->data['steps'] = 2;

		// need to show loading at start
		$this->data['show_loading'] = TRUE;
		$this->data['search_string'] = FALSE;

		// set data variables...
		$this->data['file'] = 'create_purchase_order_step2'; //'purchase_orders';
		$this->data['page_title'] = 'Purchase Order';
		$this->data['page_description'] = 'Create Purchase Orders';

		// load views...
		$this->load->view($this->data['sales_theme'].'/sales/template/template', $this->data);
	}

	// ----------------------------------------------------------------------

	/**
	 * STEP 3 - Refie purchase order options, ship to info, size and qty, etc...
	 *
	 * @return	void
	 */
	public function step3()
	{
		// generate the plugin scripts and css
		$this->_create_plugin_scripts();

		// load pertinent library/model/helpers
		$this->load->helper('state_country_helper');
		$this->load->library('form_validation');
		$this->load->library('products/product_details');
		$this->load->library('purchase_orders/purchase_orders_list');
		$this->load->library('users/wholesale_users_list');
		$this->load->library('users/wholesale_user_details');
		$this->load->library('users/sales_user_details');
		$this->load->library('designers/designer_details');

		// set validation rules
		$this->form_validation->set_rules('delivery_date', 'Deliver Data', 'trim|required');

		if ($this->form_validation->run() == FALSE)
		{
			// get user list for the edit ship to function
			$params = array(
				'tbluser_data_wholesale.admin_sales_email' => $this->sales_user_details->email
			);
			$this->data['users'] = $this->wholesale_users_list->select($params);

			// get vendor details
			// vendor id is always present at this time given create step1
			$this->data['vendor_details'] = $this->vendor_user_details->initialize(
				array(
					'vendor_id' => $this->session->po_vendor_id
				)
			);
			if ( ! $this->data['vendor_details'])
			{
				// no vendor yet, let user selecct vendor
				// set flash data
				$this->session->set_flashdata('error', 'no_id_passed');

				// redirect user
				redirect('sales/purchase_orders/create/step1', 'location');
			}

			// get store details if any
			if ($this->session->po_store_id)
			{
				$this->data['store_details'] = $this->wholesale_user_details->initialize(
					array(
						'user_id' => $this->session->po_store_id
					)
				);
			}
			else $this->data['store_details'] = $this->wholesale_user_details->deinitialize();

			// set author info for the summary view
			$this->data['author_name'] = $this->sales_user_details->fname.' '.$this->sales_user_details->lname;
			$this->data['author_email'] = $this->sales_user_details->email;

			// get designer id
			$this->designer_details->initialize(array('designer.url_structure'=>$this->session->po_des_url_structure));
			$this->data['des_id'] = $this->designer_details->des_id;

			// set po number
			$this->data['po_number'] = $this->purchase_orders_list->max_po_number() + 1;
			for($c = strlen($this->data['po_number']);$c < 6;$c++)
			{
				$this->data['po_number'] = '0'.$this->data['po_number'];
			}

			// get size names using des_id as reference
			$this->designer_details->initialize(array('designer.url_structure'=>$this->session->po_des_url_structure));
			$this->data['size_names'] = $this->size_names->get_size_names($this->designer_details->webspace_options['size_mode']);

			// set company information
			$this->data['company_name'] = $this->designer_details->company_name;
			$this->data['company_address1'] = $this->designer_details->address1;
			$this->data['company_address2'] = $this->designer_details->address2;
			$this->data['company_city'] = $this->designer_details->city;
			$this->data['company_state'] = $this->designer_details->state;
			$this->data['company_zipcode'] = $this->designer_details->zipcode;
			$this->data['company_country'] = $this->designer_details->country;
			$this->data['company_telephone'] = $this->designer_details->phone;
			$this->data['company_contact_person'] = $this->designer_details->owner;
			$this->data['company_contact_email'] = $this->designer_details->info_email;

			// some necessary variables
			$this->data['steps'] = 3;

			// need to show loading at start
			$this->data['show_loading'] = FALSE;

			// set data variables...
			$this->data['file'] = 'create_purchase_order_step3'; //'purchase_orders';
			$this->data['page_title'] = 'Purchase Order';
			$this->data['page_description'] = 'Create Purchase Order';

			$this->load->view($this->data['sales_theme'].'/sales/template/template', $this->data);
		}
		else
		{
			/***********
			 * Process the input data
			 */
			// input post data
			/* *
			Array
			(
			    [po_number] => 24591
			    [po_date] => 2019-05-09
			    [des_id] => 5
			    [delivery_date] => 2019-05-30
				[start_date] => 5
				[cancel_date] => 5
				[ship_via] => 5
				[fob] => 5
				[terms] => 5
			)
			// */

			// will need to insert other items as options array
			$options = array();
			if ($this->input->post('start_date')) $options['start_date'] = $this->input->post('start_date');
			if ($this->input->post('cancel_date')) $options['cancel_date'] = $this->input->post('cancel_date');
			if ($this->input->post('ship_via')) $options['ship_via'] = $this->input->post('ship_via');
			if ($this->input->post('fob')) $options['fob'] = $this->input->post('fob');
			if ($this->input->post('terms')) $options['terms'] = $this->input->post('terms');

			foreach ($this->input->post('options') as $key => $val)
			{
				$options[$key] = $val;
			}

			// check for ship to details
			// get store details if any
			if ($this->session->po_store_id) $options['po_store_id'] = $this->session->po_store_id;

			// initialize designer details
			$this->designer_details->initialize(array('designer.des_id'=>$this->input->post('des_id')));

			// to ensure that no doulbe entry on new po# when 2 users
			// coincidentally creates PO at the exact same time
			$po_number = $this->purchase_orders_list->max_po_number() + 1;
			for($c = strlen($po_number);$c < 6;$c++)
			{
				$po_number = '0'.$po_number;
			}

			// insert record
			// contents of a PO
			$post_ary['des_code'] = strtoupper($this->designer_details->des_code);
			$post_ary['po_number'] = $po_number;
			$post_ary['rev'] = '0';
			$post_ary['des_id'] = $this->input->post('des_id');
			$post_ary['vendor_id'] = $this->session->po_vendor_id;
			$post_ary['user_id'] = 0;
			$post_ary['po_date'] = strtotime($this->input->post('po_date'));
			$post_ary['delivery_date'] = strtotime($this->input->post('delivery_date'));
			$post_ary['author'] = $this->sales_user_details->admin_sales_id; // author
			$post_ary['c'] = '2'; // 1-admin,2-sales
			$post_ary['status'] = '0';
			$post_ary['options'] = json_encode($options);
			$post_ary['remarks'] = $this->input->post('remarks');

			// set items in the following format
			/* *
			array(
				'<prod_no>_<color_code>' = array(
					'color_name' => '<color_name>',
					'vendor_price' => '<vendor_price>',
					'<size names>' => '<qty',
					...,
					...
					// sizes not indicated defaults to zero
				)
			)
			// this is actually the $po_size_qty array plus the color name
			// */

			// grab $po_size_qty and iterate and set $po_items
			$po_size_qty = json_decode($this->session->po_size_qty, TRUE);
			foreach ($po_size_qty as $item => $size_qty)
			{
				// get product details
				$product = $this->product_details->initialize(
					array(
						'tbl_product.prod_no' => $item
					)
				);
				if ( ! $product)
				{
					$exp = explode('_', $item);
					$product = $this->product_details->initialize(
						array(
							'tbl_product.prod_no' => $exp[0],
							'color_code' => $exp[1]
						)
					);
				}

				// set color name
				if ($product)
				{
					$size_qty['color_name'] = $product->color_name;
					$size_qty['vendor_price'] = $product->vendor_price ?: ($product->wholesale_price / 3);
				}
				else
				{
					$size_qty['color_name'] = $this->product_details->get_color_name($exp[1]);
					$size_qty['vendor_price'] = @$size_qty['vendor_price'] ?: 0;
				}

				$po_items[$item] = $size_qty;
			}

			// set po items
			$post_ary['items'] = json_encode($po_items);

			/***********
			 * Save it to the database
			 */
			// connect to database
			$DB = $this->load->database('instyle', TRUE);
			$query = $DB->insert('purchase_orders', $post_ary);
			$this_po_id = $DB->insert_id();

			/***********
			 * Save pdf on a temp file
			 */
			// reload data
			// load pertinent library/model/helpers
			$this->load->library('products/product_details');
			$this->load->library('purchase_orders/purchase_order_details');
			$this->load->library('users/vendor_user_details');

			// initialize purchase order properties and items
			$this->data['po_details'] = $this->purchase_order_details->initialize(
				array(
					'po_id' => $this_po_id
				)
			);

			// get vendor details
			$this->data['vendor_details'] = $this->vendor_user_details->initialize(
				array(
					'vendor_id' => $this->purchase_order_details->vendor_id
				)
			);

			// other options
			$this->data['po_options'] = $this->purchase_order_details->options;

			// get ship to details
			if (isset($this->data['po_options']['po_store_id']))
			{
				$this->data['store_details'] = $this->wholesale_user_details->initialize(
					array(
						'user_id' => $this->data['po_options']['po_store_id']
					)
				);
			}
			else $this->data['store_details'] = $this->wholesale_user_details->deinitialize();

			// get PO author
			switch ($this->purchase_order_details->c)
			{
				case '2': //sales
					$this->data['author'] = $this->sales_user_details->initialize(
						array(
							'admin_sales_id' => $this->purchase_order_details->author
						)
					);
				break;
				case '1': //admin
				default:
					$this->data['author'] = $this->admin_user_details->initialize(
						array(
							'admin_id' => ($this->purchase_order_details->author ?: '1')
						)
					);
			}

			// po items
			$this->data['po_items'] = $this->purchase_order_details->items;

			// set company information
			$this->designer_details->initialize(array('designer.des_id'=>$this->purchase_order_details->des_id));
			$this->data['company_name'] = $this->designer_details->company_name;
			$this->data['company_address1'] = $this->designer_details->address1;
			$this->data['company_address2'] = $this->designer_details->address2;
			$this->data['company_city'] = $this->designer_details->city;
			$this->data['company_state'] = $this->designer_details->state;
			$this->data['company_zipcode'] = $this->designer_details->zipcode;
			$this->data['company_country'] = $this->designer_details->country;
			$this->data['company_telephone'] = $this->designer_details->phone;
			$this->data['company_contact_person'] = $this->designer_details->owner;
			$this->data['company_contact_email'] = $this->designer_details->info_email;

			// load the view as string
			$html = $this->load->view('templates/purchase_order_pdf', $this->data, TRUE);

			/* */
			// load pertinent library/model/helpers
			$this->load->library('m_pdf');

			// generate pdf
			$this->m_pdf->pdf->WriteHTML($html);

			// set filename and file path
			$pdf_file_path = 'assets/pdf/pdf_po_selected.pdf';

			// download it "D" - download, "I" - inline, "F" - local file, "S" - string
			//$this->m_pdf->pdf->Output(); // output to browser
			$this->m_pdf->pdf->Output($pdf_file_path, "F");
			// */

			/***********
			 * Send po email confirmation with PDF attachment
			 */
			$this->load->library('purchase_orders/purchase_order_sending');
	 		$this->purchase_order_sending->send($this_po_id);

			// once done, we now remove session items
			unset($_SESSION['po_vendor_id']);
			unset($_SESSION['po_des_url_structure']);
			unset($_SESSION['po_items']);
			unset($_SESSION['po_size_qty']);
			unset($_SESSION['po_store_id']);

			// set flash data
			$this->session->set_flashdata('success', 'add');
			//$this->session->set_flashdata('po_id', $DB->insert_id());

			// redirect user
			redirect('sales/purchase_orders/create/step4/'.$this_po_id, 'location');
		}
	}

	// ----------------------------------------------------------------------

	public function step4($po_id = '')
	{
		//if ( ! $this->session->flashdata('po_id'))
		if ( ! $po_id)
		{
			// nothing more to do...
			// set flash data
			$this->session->set_flashdata('error', 'no_id_passed');

			// redirect user
			redirect('sales/purchase_orders/create/step1', 'location');
		}

		// generate the plugin scripts and css
		$this->_create_plugin_scripts();

		// load pertinent library/model/helpers
		$this->load->library('products/product_details');
		$this->load->library('purchase_orders/purchase_order_details');
		$this->load->library('users/wholesale_user_details');
		$this->load->library('zend');
		$this->zend->load('Zend/Barcode');

		// initialize purchase order properties and items
		$this->data['po_details'] = $this->purchase_order_details->initialize(
			array(
				'po_id' => $po_id
			)
		);

		// get po items and other array stuff
		$this->data['po_number'] = $this->purchase_order_details->po_number;
		$this->data['po_items'] = $this->purchase_order_details->items;
		$this->data['po_options'] = $this->purchase_order_details->options;

		// get vendor details
		$this->data['vendor_details'] = $this->vendor_user_details->initialize(
			array(
				'vendor_id' => $this->purchase_order_details->vendor_id
			)
		);

		// get ship to details
		if (isset($this->data['po_options']['po_store_id']))
		{
			$this->data['store_details'] = $this->wholesale_user_details->initialize(
				array(
					'user_id' => $this->data['po_options']['po_store_id']
				)
			);
		}
		else $this->data['store_details'] = $this->wholesale_user_details->deinitialize();

		// get PO author
		switch ($this->purchase_order_details->c)
		{
			case '2': //sales
				$this->data['author'] = $this->sales_user_details->initialize(
					array(
						'admin_sales_id' => $this->purchase_order_details->author
					)
				);
			break;
			case '1': //admin
			default:
				$this->data['author'] = $this->admin_user_details->initialize(
					array(
						'admin_id' => ($this->purchase_order_details->author ?: '1')
					)
				);
		}

		// get size names using des_id as reference
		$this->designer_details->initialize(array('designer.des_id'=>$this->purchase_order_details->des_id));
		$this->data['size_names'] = $this->size_names->get_size_names($this->designer_details->webspace_options['size_mode']);

		// set company information
		$this->data['company_name'] = $this->designer_details->company_name;
		$this->data['company_address1'] = $this->designer_details->address1;
		$this->data['company_address2'] = $this->designer_details->address2;
		$this->data['company_city'] = $this->designer_details->city;
		$this->data['company_state'] = $this->designer_details->state;
		$this->data['company_zipcode'] = $this->designer_details->zipcode;
		$this->data['company_country'] = $this->designer_details->country;
		$this->data['company_telephone'] = $this->designer_details->phone;
		$this->data['company_contact_person'] = $this->designer_details->owner;
		$this->data['company_contact_email'] = $this->designer_details->info_email;

		// some necessary variables
		$this->data['steps'] = 4;

		// need to show loading at start
		$this->data['show_loading'] = FALSE;

		// set data variables...
		$this->data['file'] = 'create_purchase_order_step4';
		$this->data['page_title'] = 'Purchase Order';
		$this->data['page_description'] = 'Send Purchase Order';

		// load views...
		$this->load->view($this->data['sales_theme'].'/sales/template/template', $this->data);
	}

	// ----------------------------------------------------------------------

	public function send($po_id = '', $action = '')
	{
		if ($po_id == '')
		{
			// nothing more to do
			// set flash data
			$this->session->set_flashdata('error', 'no_id_passed');

			// redirect user
			redirect('sales/purchase_orders/create/step1', 'location');
		}

		// send PO
		$this->load->library('purchase_orders/purchase_order_sending');
		$this->purchase_order_sending->send($po_id);

		// set flash data
		$this->session->set_flashdata('success', 'add');

		if ($action === 'send')
		{
			// redirect user on step4
			redirect('sales/purchase_orders/create/step4/'.$po_id, 'location');
		}
		else
		{
			// redirect user
			redirect('sales/purchase_orders/details/index/'.$po_id, 'location');
		}
	}

	// ----------------------------------------------------------------------

	/**
	 * PRIVATE - Creaet Plugin Scripts and CSS for the page
	 *
	 * @return	void
	 */
	public function filter($id = '')
	{
		if ( ! $id)
		{
			// nothing more to do...
			// set flash data
			$this->session->set_flashdata('error', 'no_id_passed');

			// redirect user
			redirect($this->config->slash_item('admin_folder').'campaigns/sales_package/');
		}

		if ($this->input->post('designer')) $this->session->set_userdata('designer', $this->input->post('designer'));
		if ($this->input->post('category')) $this->session->set_userdata('category', $this->input->post('category'));
		if ($this->input->post('categories')) $this->session->set_userdata('categories', $this->input->post('categories'));
		if ($this->input->post('order_by')) $this->session->set_userdata('order_by', $this->input->post('order_by'));

		redirect($this->config->slash_item('admin_folder').'campaigns/sales_package/edit/index/'.$id);
	}

	// ----------------------------------------------------------------------

	/**
	 * Clear Recent User Edit List
	 *
	 * @return	void
	 */
	public function clear_recent()
	{
		// capture webspace details options
		$options = $this->webspace_details->options;

		// get the array of recent users and unset it
		if (
			isset($options['recent_sales_package'])
			&& ! empty($options['recent_sales_package'])
		) unset($options['recent_sales_package']);

		// udpate the sales package items...
		$this->DB->set('webspace_options', json_encode($options));
		$this->DB->where('webspace_id', $this->webspace_details->id);
		$q = $this->DB->update('webspaces');

		// set flash data
		$this->session->set_flashdata('clear_recent_sales_package', TRUE);

		// reload page
		redirect($_SERVER['HTTP_REFERER'], 'location');
	}

	// ----------------------------------------------------------------------

	/**
	 * PRIVATE - Creaet Plugin Scripts and CSS for the page
	 *
	 * @return	void
	 */
	public function reset_ship_to()
	{
		unset($_SESSION['po_store_id']);

		redirect('sales/purchase_orders/create/step3');
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
			// fancybox
			$this->data['page_level_styles_plugins'].= '
				<link href="'.$assets_url.'/assets/global/plugins/fancybox/source/jquery.fancybox.css" rel="stylesheet" type="text/css" media="screen" />
			';
			// summernote wysiwyg
			$this->data['page_level_styles_plugins'].= '
				<link href="'.$assets_url.'/assets/global/plugins/bootstrap-summernote/summernote.css" rel="stylesheet" type="text/css" />
			';
			// multi-select
			$this->data['page_level_styles_plugins'].= '
				<link href="'.$assets_url.'/assets/global/plugins/jquery-multi-select/css/multi-select.css" rel="stylesheet" type="text/css" />
			';
			// datepicker
			$this->data['page_level_styles_plugins'].= '
				<link href="'.$assets_url.'/assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css" rel="stylesheet" type="text/css" />
			';

		/****************
		 * page style sheets inserted at <head>
		 */
		$this->data['page_level_styles'] = '';

			// this is a work around so that the inline jquery ajax request to add and remove items from the sales package to work
			$this->data['page_level_styles'].= '
				<script src="'.$assets_url.'/assets/global/plugins/jquery.min.js" type="text/javascript"></script>
			';

		/****************
		 * page js plugins inserted at <bottom>
		 * after core plugins, before global scripts
		 */
		$this->data['page_level_plugins'] = '';

			// unveil - simple image lazy loading
			$this->data['page_level_plugins'].= '
				<script src="'.base_url().'assets/custom/js/jquery.unveil.js" type="text/javascript"></script>
			';
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
			// fancybox
			$this->data['page_level_plugins'].= '
				<script src="'.$assets_url.'/assets/global/plugins/fancybox/source/jquery.fancybox.pack.js" type="text/javascript"></script>
			';
			// summernote wysiwyg
			$this->data['page_level_plugins'].= '
				<script src="'.$assets_url.'/assets/global/plugins/bootstrap-summernote/summernote.min.js" type="text/javascript"></script>
			';
			// form wizard - jquery validate is needed for the wizard to function
			$this->data['page_level_plugins'].= '
				<script src="'.$assets_url.'/assets/global/plugins/jquery-validation/js/jquery.validate.min.js" type="text/javascript"></script>
				<script src="'.$assets_url.'/assets/global/plugins/bootstrap-wizard/jquery.bootstrap.wizard.min.js" type="text/javascript"></script>
			';
			// multi-select
			$this->data['page_level_plugins'].= '
				<script src="'.$assets_url.'/assets/global/plugins/jquery-multi-select/js/jquery.multi-select.js" type="text/javascript"></script>
			';
			// bootbox
			$this->data['page_level_plugins'].= '
				<script src="'.$assets_url.'/assets/global/plugins/bootbox/bootbox.min.js" type="text/javascript"></script>
			';
			// datetimepicker
			$this->data['page_level_plugins'].= '
				<script src="'.$assets_url.'/assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js" type="text/javascript"></script>
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
			// handle bootstrap select - make select class '.bs-select' a boostrap select picker
			$this->data['page_level_scripts'].= '
				<script src="'.$assets_url.'/assets/pages/scripts/components-bootstrap-select.min.js" type="text/javascript"></script>
			';
			// handle form wizard
			$this->data['page_level_scripts'].= '
				<script src="'.$assets_url.'/assets/pages/scripts/form-wizard.min.js" type="text/javascript"></script>
			';
			// jspdf
			$this->data['page_level_scripts'].= '
				<script src="'.base_url().'assets/custom/js/jspdf.min.js" type="text/javascript"></script>
			';
			// html2canvas
			$this->data['page_level_scripts'].= '
				<script src="'.base_url().'assets/custom/js/html2canvas/html2canvas.min.js" type="text/javascript"></script>
			';
			// handle summernote wysiwyg
			// and click scripts
			$this->data['page_level_scripts'].= '
				<script src="'.base_url().'assets/custom/js/metronic/pages/scripts/sales-purchase_orders-components.js" type="text/javascript"></script>
			';
			// handle multiSelect
			$this->data['page_level_scripts'].= '
				<script src="'.base_url().'assets/custom/js/metronic/pages/scripts/sales_package-send.js" type="text/javascript"></script>
			';
	}

	// ----------------------------------------------------------------------

}
