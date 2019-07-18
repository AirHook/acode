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
		$this->load->library('users/vendor_user_details');
		$this->load->library('users/sales_user_details');
		$this->load->library('users/wholesale_user_details');

		// initialize purchase order properties and items
		$data['so_details'] = $this->sales_order_details->initialize(
			array(
				'sales_order_id' => $id
			)
		);

		// get vendor details
		$data['vendor_details'] = $this->vendor_user_details->initialize(
			array(
				'vendor_id' => $this->sales_order_details->vendor_id
			)
		);

		// get the author
		if ($this->sales_order_details->c != '2')
		{
			// aahhh... you are an admin user
			$data['author'] = $this->admin_user_details->initialize(
				array(
					'admin_id' => $this->sales_order_details->author
				)
			);
		}
		else
		{
			// sales user
			$data['author'] = $this->sales_user_details->initialize(
				array(
					'admin_sales_id' => $this->sales_order_details->author
				)
			);
		}

		// so items
		$data['so_items'] = $this->sales_order_details->items;

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
