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
	function index($po_id = '')
	{
		// load pertinent library/model/helpers
		$this->load->library('designers/designer_details');
		$this->load->library('webspaces/webspace_details');
		$this->load->library('products/size_names');
		$this->load->library('products/product_details');
		$this->load->library('purchase_orders/purchase_order_details');
		$this->load->library('users/vendor_user_details');
		$this->load->library('users/sales_user_details');
		$this->load->library('users/admin_user_details');
		$this->load->library('users/wholesale_user_details');

		// initialize purchase order properties and items
		$data['po_details'] = $this->purchase_order_details->initialize(
			array(
				'po_id' => $po_id
			)
		);

		// get po items and other array stuff
		$data['po_number'] = $this->purchase_order_details->po_number;
		$data['po_items'] = $this->purchase_order_details->items;
		$data['po_options'] = $this->purchase_order_details->options;

		// get vendor details
		$data['vendor_details'] = $this->vendor_user_details->initialize(
			array(
				'vendor_id' => $this->purchase_order_details->vendor_id
			)
		);

		// other options
		$data['po_options'] = $this->purchase_order_details->options;

		// get ship to details
		if (isset($data['po_options']['po_store_id']))
		{
			$data['store_details'] = $this->wholesale_user_details->initialize(
				array(
					'user_id' => $data['po_options']['po_store_id']
				)
			);
		}
		else $data['store_details'] = $this->wholesale_user_details->deinitialize();

		// get PO author
		switch ($this->purchase_order_details->c)
		{
			case '2': //sales
				$data['author'] = $this->sales_user_details->initialize(
					array(
						'admin_sales_id' => $this->purchase_order_details->author
					)
				);
			break;
			case '1': //admin
			default:
				$data['author'] = $this->admin_user_details->initialize(
					array(
						'admin_id' => ($this->purchase_order_details->author ?: '1')
					)
				);
		}

		// get size names using des_id as reference
		$this->designer_details->initialize(array('designer.des_id'=>$this->purchase_order_details->des_id));

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
		$html = $this->load->view('templates/purchase_order_pdf', $data, TRUE);

		// load pertinent library/model/helpers
		$this->load->library('m_pdf');

		// generate pdf
		$this->m_pdf->pdf->WriteHTML($html);

		// set filename and file path
		$pdf_file_path = 'assets/pdf/pdf_po_selected.pdf';

		// download it "D" - download, "I" - inline, "F" - local file, "S" - string
		$this->m_pdf->pdf->Output(); // output to browser
		//$this->m_pdf->pdf->Output($pdf_file_path, "F");

		exit;
	}

	// --------------------------------------------------------------------

}
