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
		$this->load->library('sales_orders/sales_order_details');
		$this->load->library('users/admin_user_details');
		$this->load->library('users/sales_user_details');
		$this->load->library('users/wholesale_user_details');
		$this->load->library('users/consumer_user_details');
		$this->load->library('designers/designer_details');
		$this->load->library('barcodes/upc_barcodes');

		// initialize sales order properties and items
		$data['so_details'] = $this->sales_order_details->initialize(
			array(
				'sales_order_id' => $id
			)
		);

		// get the author
		switch ($this->sales_order_details->c)
		{
			case '2': //sales
				$data['author'] = $this->sales_user_details->initialize(
					array(
						'admin_sales_id' => $this->sales_order_details->author
					)
				);
			break;
			case '1': //admin
			default:
				$data['author'] = $this->admin_user_details->initialize(
					array(
						'admin_id' => ($this->sales_order_details->author ?: '1')
					)
				);
		}

		// get store details
		// check for user cat to fill out bill to/ship to address
		if ($this->sales_order_details->user_cat)
		{
			if ($this->sales_order_details->user_cat == 'ws')
			{
				$data['store_details'] = $this->wholesale_user_details->initialize(
					array(
						'user_id' => $this->sales_order_details->user_id
					)
				);
			}

			if ($this->sales_order_details->user_cat == 'cs')
			{
				$data['store_details'] = $this->consumer_user_details->initialize(
					array(
						'user_id' => $this->sales_order_details->user_id
					)
				);
			}
		}

		// we need to get designer details general size mode for those
		// items added that is not on product list
		$this->data['designer_details'] = $this->designer_details->initialize(
			array(
				'des_id' => $this->sales_order_details->des_id
			)
		);

		// set THE items
		$data['so_items'] = $this->sales_order_details->items;
		$data['so_date'] = $this->sales_order_details->so_date;
		$data['so_number'] = $this->sales_order_details->so_number;
		$data['so_options'] = $this->sales_order_details->options;
		for($c = strlen($data['so_number']);$c < 6;$c++)
		{
			$data['so_number'] = '0'.$data['so_number'];
		}

		$html = $this->load->view('templates/sales_order_packing_list_pdf', $data, TRUE);

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
