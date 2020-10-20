<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class view_packing_list extends MY_Controller
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
		$this->load->library('orders/order_details');
		$this->load->library('barcodes/upc_barcodes');

		// initialize...
		$this->data['order_details'] =
			$this->order_details->initialize(
				array(
					'tbl_order_log.order_log_id' => $id
				)
			)
		;

		// other data
		$this->data['status'] = $this->order_details->status_text;

		// set THE items
		$data['order_items'] = $this->order_details->order_items;
		$data['order_date'] = $this->order_details->order_date;
		$data['order_number'] = $this->order_details->order_id;
		$data['order_options'] = $this->order_details->options;

		$html = $this->load->view('templates/checkout_order_packing_list_pdf', $data, TRUE);

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
