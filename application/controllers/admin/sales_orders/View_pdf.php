<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class View_pdf extends CI_Controller
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
	function index($id = '')
	{
		// load pertinent library/model/helpers
		$this->load->library('products/product_details');
		$this->load->library('products/size_names');
		$this->load->library('sales_orders/sales_order_details');
		$this->load->library('designers/designer_details');
		$this->load->library('users/vendor_user_details');
		$this->load->library('users/sales_user_details');
		$this->load->library('users/wholesale_user_details');

		// initialize purchase order properties and items
		$data['so_details'] = $this->sales_order_details->initialize(
			array(
				'sales_order_id' => $id
			)
		);

		// get the author
		$data['author'] = $this->sales_user_details->initialize(
			array(
				'admin_sales_id' => $this->sales_order_details->author
			)
		);

		// get designer details
		$data['designer_details'] = $this->designer_details->initialize(
			array(
				'designer.des_id' => $this->sales_order_details->des_id
			)
		);

		// get vendor details
		$data['vendor_details'] = $this->vendor_user_details->initialize(
			array(
				'vendor_id' => $this->sales_order_details->vendor_id
			)
		);

		// get store details
		$data['store_details'] = $this->wholesale_user_details->initialize(
			array(
				'user_id' => $this->sales_order_details->user_id
			)
		);

		// get designer id and size names
		$data['des_id'] = $this->sales_order_details->des_id;
		$data['size_names'] = $this->size_names->get_size_names($this->designer_details->webspace_options['size_mode']);

		// set the items
		$data['so_items'] = $this->sales_order_details->items;
		$data['so_number'] = $this->sales_order_details->so_number;
		for($c = strlen($data['so_number']);$c < 6;$c++)
		{
			$data['so_number'] = '0'.$data['so_number'];
		}
		$data['so_options'] = $this->sales_order_details->options;

		// set company information
		$data['company_name'] = $this->designer_details->company_name;
		$data['company_address1'] = $this->designer_details->address1;
		$data['company_address2'] = $this->designer_details->address2;
		$data['company_city'] = $this->designer_details->city;
		$data['company_state'] = $this->designer_details->state;
		$data['company_zipcode'] = $this->designer_details->zipcode;
		$data['company_country'] = $this->designer_details->country;
		$data['company_telephone'] = $this->designer_details->phone;
		$data['company_contact_person'] = $this->designer_details->owner;
		$data['company_contact_email'] = $this->designer_details->info_email;

		// load the view as string
		$html = $this->load->view('templates/sales_order_pdf', $data, TRUE);

		// load pertinent library/model/helpers
		$this->load->library('m_pdf');

		// generate pdf
		$this->m_pdf->pdf->WriteHTML($html);

		// set filename and file path
		$pdf_file_path = 'assets/pdf/pdf_so_selected.pdf';

		// download it "D" - download, "I" - inline, "F" - local file, "S" - string
		$this->m_pdf->pdf->Output(); // output to browser
		//$this->m_pdf->pdf->Output($pdf_file_path, "F");

		exit;
	}

	// --------------------------------------------------------------------

}
