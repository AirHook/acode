<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Modify extends Admin_Controller {

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
		$this->load->library('users/vendor_users_list');
		$this->load->library('users/vendor_user_details');
		$this->load->library('categories/categories_tree');

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
	public function index($po_id = '')
	{
		if ($po_id == '')
		{
			// nothing more to do...
			// set flash data
			$this->session->set_flashdata('error', 'no_id_passed');

			// redirect user
			redirect('admin/purchase_orders', 'location');
		}

		// let's ensure that there are no admin session for po create
		if ($this->session->admin_po_items)
		{
			// new po modify access
			unset($_SESSION['admin_po_vendor_id']);
			unset($_SESSION['admin_po_des_url_structure']);
			unset($_SESSION['admin_po_items']);
			unset($_SESSION['admin_po_size_qty']);
			unset($_SESSION['admin_po_store_id']);
			// unset mod session as well
			unset($_SESSION['admin_po_mod_po_id']);
			unset($_SESSION['admin_po_mod_size_qty']);
			unset($_SESSION['admin_po_mod_edit_vendor_price']);
		}

		// generate the plugin scripts and css
		$this->_create_plugin_scripts();

		// load pertinent library/model/helpers
		$this->load->helper('state_country_helper');
		$this->load->library('form_validation');
		$this->load->library('products/size_names');
		$this->load->library('products/product_details');
		$this->load->library('purchase_orders/purchase_order_details');
		$this->load->library('users/wholesale_users_list');
		$this->load->library('users/wholesale_user_details');
		$this->load->library('users/sales_user_details');
		$this->load->library('designers/designer_details');

		// initialize purchase order properties and items
		$this->data['po_details'] = $this->purchase_order_details->initialize(
			array(
				'po_id' => $po_id
			)
		);
		if ( ! $this->data['po_details'])
		{
			// set flash data
			$this->session->set_flashdata('error', 'no_id_passed');

			// redirect user
			redirect('admin/purchase_orders', 'location');
		}

		// for check purposes, set admin_po_mod_po_id session
		$this->session->set_userdata('admin_po_mod_po_id', $this->purchase_order_details->po_id);

		// set validation rules
		$this->form_validation->set_rules('delivery_date', 'Deliver Data', 'trim|required');

		if ($this->form_validation->run() == FALSE)
		{
			// get vendor details
			$this->data['vendor_details'] = $this->vendor_user_details->initialize(
				array(
					'vendor_id' => $this->purchase_order_details->vendor_id
				)
			);
			if ( ! $this->data['vendor_details'])
			{
				// no vendor yet, let user selecct vendor
				// set flash data
				$this->session->set_flashdata('error', 'no_id_passed');

				// redirect user
				redirect('admin/purchase_orders', 'location');
			}

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

			// get po items and other array stuff
			$this->data['po_number'] = $this->purchase_order_details->po_number;
			$this->data['po_options'] = $this->purchase_order_details->options;

			// get the po items and count
			// if session is present, then modify has already started
			$this->data['po_items'] = $this->purchase_order_details->items;
			// each time this page loads, this set session
			$this->session->set_userdata('admin_po_mod_size_qty', json_encode($this->data['po_items']));
			$po_items_count = 0;
			foreach ($this->data['po_items'] as $key => $val)
			{
				if (is_array($val))
				{
					unset($val['color_name']);
					unset($val['vendor_price']);
					$po_items_count += array_sum($val);
				}
				else $po_items_count += 1;
			}
			$this->data['po_items_count'] = $po_items_count;

			// get size names using des_id as reference
			$this->designer_details->initialize(array('designer.des_id'=>$this->purchase_order_details->des_id));
			$this->data['size_names'] = $this->size_names->get_size_names($this->designer_details->webspace_options['size_mode']);

			// get user list for the edit ship to function
			$this->data['users'] = $this->wholesale_users_list->select();

			// need to show loading at start
			$this->data['show_loading'] = FALSE;

			// set data variables...
			$this->data['file'] = 'po_modify'; //'purchase_orders';
			$this->data['page_title'] = 'Purchase Order Modify';
			$this->data['page_description'] = 'Modify Certain Items In Purchase Order';

			$this->load->view('admin/'.($this->config->slash_item('admin_template') ?: 'metronic/').'template/template', $this->data);
			//$this->load->view($this->data['sales_theme'].'/sales/template/template', $this->data);
		}
		else
		{
			// input post data
			// index indeces are not needed
			/* *
			Array
			(
			    [action] => modify
			    [start_date] => 2019-05-17
			    [cancel_date] => 2019-05-31
			    [delivery_date] => 2019-05-29
			    [ship_via] => UPS
			    [fob] => China
			    [terms] => Net 15
				    [size_0] => 0
				    [size_2] => 3
				    [size_4] => 0
				    [size_6] => 6
				    [size_8] => 0
				    [size_10] => 3
				    [size_12] => 0
				    [size_14] => 0
				    [size_16] => 0
				    [size_18] => 0
				    [size_20] => 0
				    [size_22] => 0
				    [vendor_price-D9388L_REDBLAC1] => 109
				    [subtotal] => 588
				    [vendor_price-SH4114_GOLD1] => 49
			    [remarks] =>
			    	[files] =>
			)
			// */

			// set options
			$options = $this->purchase_order_details->options;

			/***********
			 * Process the input data
			 */
			// will need to update any changesto some options data
			if ($this->input->post('start_date')) $options['start_date'] = $this->input->post('start_date');
			if ($this->input->post('cancel_date')) $options['cancel_date'] = $this->input->post('cancel_date');
			if ($this->input->post('ship_via')) $options['ship_via'] = $this->input->post('ship_via');
			if ($this->input->post('fob')) $options['fob'] = $this->input->post('fob');
			if ($this->input->post('terms')) $options['terms'] = $this->input->post('terms');

			// check for changes ship to details
			// get store details if any
			//if ($this->session->admin_po_store_id) $options['po_store_id'] = $this->session->admin_po_store_id;

			// update record
			// contents of a PO
			// indented and commented items are not to be touched
				//$post_ary['des_code'] = 'BAX';
				//$post_ary['po_number'] = $this->admin_user_details->po_number;
				//$post_ary['rev'] = '0'; // set below
				//$post_ary['des_id'] = $this->input->post('des_id');
				//$post_ary['vendor_id'] = $this->session->admin_po_vendor_id;
				//$post_ary['user_id'] = $this->admin_user_details->admin_id;
				//$post_ary['po_date'] = strtotime($this->input->post('po_date'));
			$post_ary['delivery_date'] = strtotime($this->input->post('delivery_date'));
				//$post_ary['author'] = $this->admin_user_details->admin_id;
				//$post_ary['c'] = '1'; // 1-admin,2-sales
				//$post_ary['status'] = '0';
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
			$po_size_qty = json_decode($this->session->admin_po_mod_size_qty, TRUE);
			foreach ($po_size_qty as $item => $size_qty)
			{
				unset($size_qty['color_name']);
				unset($size_qty['vendor_price']);

				if (array_sum($size_qty) != 0)
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
			}

			// set po items`
			$post_ary['items'] = json_encode($po_items);

			// set revision #
			$post_ary['rev'] = $this->purchase_order_details->rev + 1;

			/***********
			 * Update database
			 */
			// connect to database
			$this->DB->where('po_id', $po_id);
			$this->DB->update('purchase_orders', $post_ary);

			// once done, we now remove session items
			unset($_SESSION['admin_po_mod_po_id']);
			unset($_SESSION['admin_po_mod_size_qty']);
			unset($_SESSION['admin_po_mod_edit_vendor_price']);

			// set flash data
			$this->session->set_flashdata('success', 'edit');

			// redirect user
			redirect('admin/purchase_orders/details/index/'.$po_id, 'location');
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
				<script src="'.base_url().'assets/custom/js/metronic/pages/scripts/admin-purchase_orders-components.js" type="text/javascript"></script>
			';
			// handle multiSelect
			$this->data['page_level_scripts'].= '
				<script src="'.base_url().'assets/custom/js/metronic/pages/scripts/sales_package-send.js" type="text/javascript"></script>
			';
	}

	// ----------------------------------------------------------------------

}
