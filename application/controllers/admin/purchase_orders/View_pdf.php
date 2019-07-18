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
		$this->load->library('products/size_names');
		$this->load->library('products/product_details');
		$this->load->library('purchase_orders/purchase_order_details');
		$this->load->library('users/vendor_user_details');
		$this->load->library('users/sales_user_details');
		$this->load->library('users/wholesale_user_details');

		// initialize purchase order properties and items
		$data['po_details'] = $this->purchase_order_details->initialize(
			array(
				'po_id' => $po_id
			)
		);

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

		// po items
		$data['po_items'] = $this->purchase_order_details->items;

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
