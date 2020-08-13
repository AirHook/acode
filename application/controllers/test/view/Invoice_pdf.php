<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/****************
 *
 *
 */
class Invoice_pdf extends MY_Controller
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
	function index($order_id = '')
	{
		if ( ! $order_id)
		{
			// nothing more to do...
			echo 'An order ID# is needed...';
			exit;
		}

		// load pertinent library/model/helpers
		$this->load->library('users/wholesale_user_details');
		$this->load->library('users/consumer_user_details');
		$this->load->library('products/product_details');
		$this->load->library('orders/order_details');
		$this->load->library('products/size_names');

		// get order details
		$this->data['order_details'] =
			$this->order_details->initialize(
				array(
					'tbl_order_log.order_log_id'=>$order_id
				)
			)
		;

		// based on order details, get user details
		if ($this->data['order_details']->c == 'ws')
		{
			$this->data['user_details'] =
				$this->wholesale_user_details->initialize(
					array(
						'user_id' => $this->data['order_details']->user_id
					)
				)
			;
		}
		else
		{
			$this->data['user_details'] =
				$this->consumer_user_details->initialize(
					array(
						'user_id' => $this->data['order_details']->user_id
					)
				)
			;
		}

		// other data
		$this->data['status'] = $this->order_details->status_text;
		$this->data['order_items'] = $this->order_details->items();

		// load the view
		$html = $this->load->view('templates/invoice', $this->data, TRUE);

		// load pertinent library/model/helpers
		$this->load->library('m_pdf');

		// generate pdf
		$this->m_pdf->pdf->WriteHTML($html);

		// set filename and file path
		$pdf_file_path = 'assets/pdf/pdf_invoice.pdf';

		// download it "D" - download, "I" - inline, "F" - local file, "S" - string
		$this->m_pdf->pdf->Output(); // output to browser

		exit;
	}

	// --------------------------------------------------------------------

}
