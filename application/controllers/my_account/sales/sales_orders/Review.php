<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/****************
 * Frontend Controller holds any general front end items
 *
 * Shop Controller are for items used for shop thumbs pages
 *
 */
class Review extends Sales_user_Controller
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
		$this->load->library('form_validation');
		$this->load->library('sales_orders/sales_orders_list');
		$this->load->library('designers/designer_details');
		$this->load->library('users/vendor_user_details');
		$this->load->library('users/wholesale_user_details');
		$this->load->library('users/sales_user_details');
		$this->load->library('products/product_details');
		$this->load->library('products/size_names');

		// get designer details
		$this->data['designer_details'] = $this->designer_details->initialize(
			array(
				'designer.url_structure' => $this->session->so_designer
			)
		);
		// get vendor details
		// vendor id is always present at this time given create step1
		$this->data['vendor_details'] = $this->vendor_user_details->initialize(
			array(
				'vendor_id' => $this->session->so_vendor_id
			)
		);
		// get store details
		// same with store
		if ($this->session->so_store_id)
		{
			$this->data['store_details'] = $this->wholesale_user_details->initialize(
				array(
					'user_id' => $this->session->so_store_id
				)
			);
		}
		else $this->data['store_details'] = $this->wholesale_user_details->deinitialize();

		if (
			! $this->data['vendor_details']
			OR ! $this->data['designer_details']
			OR ! $this->data['store_details']
		)
		{
			// no vendor yet, let user selecct vendor
			// set flash data
			$this->session->set_flashdata('error', 'no_id_passed');

			// redirect user
			redirect('admin/sales_orders/create', 'location');
		}

		// set author info for the summary view
		// set the author
		$this->data['author'] = $this->sales_user_details->initialize(
			array(
				'admin_sales_email' => $this->webspace_details->info_email
			)
		);

		// get designer id and size names
		$this->data['des_id'] = $this->designer_details->des_id;
		$this->data['size_names'] = $this->size_names->get_size_names($this->designer_details->webspace_options['size_mode']);

		// set po number
		$this->data['so_number'] = $this->sales_orders_list->max_so_number() + 1;
		for($c = strlen($this->data['so_number']);$c < 6;$c++)
		{
			$this->data['so_number'] = '0'.$this->data['so_number'];
		}

		// get so items
		$this->data['so_items'] =
			$this->session->so_items
			? json_decode($this->session->so_items, TRUE)
			: array()
		;

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

		// set validation rules
		$this->form_validation->set_rules('so_number', 'SO Number', 'trim|required');

		if ($this->form_validation->run() == FALSE)
		{
			// need to show loading at start
			$this->data['show_loading'] = FALSE;

			// set data variables...
			$this->data['role'] = 'sales';
			$this->data['file'] = 'so_review'; //'purchase_orders';
			$this->data['page_title'] = 'Sales Order';
			$this->data['page_description'] = 'Create Sales Order';

			$this->load->view('admin/'.($this->config->slash_item('admin_template') ?: 'metronic/').'template_my_template/template', $this->data);
		}
		else
		{
			/* *
			Post is received as
			Array
			(
			    [so_number] => 000001
			    [so_date] => 2019-08-16
			    [des_id] => 5
			    [vendor_id] => 22
			    [store_id] => 6854
				[author] => 1
			    [ship_via] =>
			    [fob] =>
			    [terms] =>
			    [reference_po] =>
			    [reference_po_date] =>
			    [our_order] =>
			    [remarks] =>
			    [files] =>
			)
			// */

			// grab the post data
			$post_ary['sales_order_number'] = $this->input->post('so_number');
			$post_ary['sales_order_date'] = strtotime($this->input->post('so_date'));
			$post_ary['des_id'] = $this->input->post('des_id');
			$post_ary['vendor_id'] = $this->input->post('vendor_id');
			$post_ary['user_id'] = $this->input->post('store_id');
			$post_ary['author'] = $this->input->post('author');
			$post_ary['remarks'] = $this->input->post('remarks');

			// and then some
			$post_ary['c'] = '1'; // 1-admin,2-sales
			$post_ary['items'] = $this->session->so_items;

			// set options data
			$options = array();
			if ($this->input->post('ship_via')) $options['ship_via'] = $this->input->post('ship_via');
			if ($this->input->post('fob')) $options['fob'] = $this->input->post('fob');
			if ($this->input->post('terms')) $options['terms'] = $this->input->post('terms');
			if ($this->input->post('reference_po')) $options['reference_po'] = $this->input->post('reference_po');
			if ($this->input->post('reference_po_date')) $options['reference_po_date'] = $this->input->post('reference_po_date');
			if ($this->input->post('our_order')) $options['our_order'] = $this->input->post('our_order');
			// ergo
			$post_ary['options'] = json_encode($options);

			// store details
			$post_ary['store_name'] = $this->wholesale_user_details->store_name;
			$post_ary['firstname'] = $this->wholesale_user_details->fname;
			$post_ary['lastname'] = $this->wholesale_user_details->lname;
			$post_ary['email'] = $this->wholesale_user_details->email;
			$post_ary['telephone'] = $this->wholesale_user_details->telephone;
			$post_ary['ship_address1'] = $this->wholesale_user_details->address1;
			$post_ary['ship_address2'] = $this->wholesale_user_details->address2;
			$post_ary['ship_city'] = $this->wholesale_user_details->city;
			$post_ary['ship_state'] = $this->wholesale_user_details->state;
			$post_ary['ship_country'] = $this->wholesale_user_details->country;
			$post_ary['ship_zipcode'] = $this->wholesale_user_details->zipcode;
			$post_ary['bill_address1'] = $this->wholesale_user_details->address1;
			$post_ary['bill_address2'] = $this->wholesale_user_details->address2;
			$post_ary['bill_city'] = $this->wholesale_user_details->city;
			$post_ary['bill_state'] = $this->wholesale_user_details->state;
			$post_ary['bill_country'] = $this->wholesale_user_details->country;
			$post_ary['bill_zipcode'] = $this->wholesale_user_details->zipcode;

			/***********
			 * Save it to the database
			 */
			// connect to database
			$DB = $this->load->database('instyle', TRUE);
			$query = $DB->insert('sales_orders', $post_ary);
			$this_so_id = $DB->insert_id();

			/***********
			 * Save pdf on a temp file
			 */
			// some data needing for PDF printout
			$this->data['so_number'] = $this->input->post('so_number');
			$this->data['so_date'] = $this->input->post('so_date');
			$this->data['remarks'] = $this->input->post('remarks');
			$this->data['so_options'] = $options;

			// load the view as string
			$html = $this->load->view('templates/sales_order_pdf', $this->data, TRUE);

			/* */
			// load pertinent library/model/helpers
			$this->load->library('m_pdf');

			// generate pdf
			$this->m_pdf->pdf->WriteHTML($html);

			// set filename and file path
			$pdf_file_path = 'assets/pdf/pdf_so_selected.pdf';

			// download it "D" - download, "I" - inline, "F" - local file, "S" - string
			//$this->m_pdf->pdf->Output(); // output to browser
			$this->m_pdf->pdf->Output($pdf_file_path, "F"); // output to file
			// */

			/***********
			 * Send po email confirmation with PDF attachment
			 */
			$this->load->library('sales_orders/sales_order_sending');
	 		$this->sales_order_sending->send($this_so_id);

			// once done, we now remove session items
			unset($_SESSION['so_designer']);
			unset($_SESSION['so_vendor_id']);
			unset($_SESSION['so_store_id']);
			unset($_SESSION['so_author']);
			unset($_SESSION['so_dely_date']);
			unset($_SESSION['so_items']);
			unset($_SESSION['so_slug_segs']);

			// set flash data
			$this->session->set_flashdata('success', 'add');

			// redirect user
			redirect('admin/sales_orders/details/index/'.$this_so_id, 'location');
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
				<script src="'.base_url().'assets/custom/js/metronic/pages/scripts/admin-so-components.js" type="text/javascript"></script>
			';
	}

	// --------------------------------------------------------------------

}
