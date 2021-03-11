<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/****************
 *
 *
 */
class View_invoice extends Admin_Controller
{
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
	function __Construct()
	{
		parent::__Construct();

		// connect to database
		$this->DB = $this->load->database('instyle', TRUE);
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
			// set flash data
			$this->session->set_flashdata('error', 'no_id_passed');

			// redirect user
			redirect('admin/orders', 'location');
		}

		// load pertinent library/model/helpers
		$this->load->library('users/wholesale_user_details');
		$this->load->library('users/consumer_user_details');
		$this->load->library('products/product_details');
		$this->load->library('orders/order_details');
		$this->load->library('products/size_names');
		$this->load->library('m_pdf');

		// get order details
		$this->data['order_details'] =
			$this->order_details->initialize(
				array(
					'tbl_order_log.order_log_id'=>$order_id
				)
			)
		;

		// check, get, and set invoice id
		if ( ! $this->data['order_details']->invoice_id)
		{
			$max_invoice_id = $this->order_details->max_invoice_id();
			$invoice_id = $max_invoice_id ? $max_invoice_id + 1 : '97104';
			$this->DB->set('invoice_id', $invoice_id);
			$this->DB->where('order_log_id', $order_id);
			$this->DB->update('tbl_order_log');
			// re-initialize order details
			$this->data['order_details'] =
				$this->order_details->initialize(
					array(
						'tbl_order_log.order_log_id'=>$order_id
					)
				)
			;
		}

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
		$this->data['view_params'] = 'invoice_pdf';
		$this->data['status'] = $this->order_details->status_text;
		//$this->data['order_items'] = $this->order_details->items();

		// iterate through the designer based items
		$i = 1;
		foreach ($this->order_details->items() as $designer => $items)
		{
			// set the order items
			$this->data['order_items'] = $items;

			// we need to get the size mode and other details based even on the first item only
			foreach ($items as $item)
			{
				$des_options = json_decode($item->webspace_options, TRUE);

				// other details
				$this->data['d_designer'] = $designer;
				$this->data['d_address1'] = $item->designer_address1;
				$this->data['d_address2'] = $item->designer_address2;
				$this->data['d_telephone'] = $item->designer_phone;
				$this->data['d_info_email'] = $item->designer_info_email;
				$this->data['d_logo'] =
					$item->logo ?: (
						$item->url_structure
						? base_url().'assets/images/logo/logo-'.$item->url_structure.'.png'
						: ''
					)
				;

				break;
			}
			$this->data['size_mode'] = $des_options['size_mode'];
			$this->data['size_names'] = $this->size_names->get_size_names($des_options['size_mode']);

			// load the view
			$html = $this->load->view('templates/invoice', $this->data, TRUE);

			if ($i > 1)
			{
				$this->m_pdf->pdf->WriteHTML('<pagebreak>');
			}

			// generate pdf
			$this->m_pdf->pdf->WriteHTML($html);

			// set filename and file path
			$pdf_file_path = 'assets/pdf/pdf_invoice_'.$designer.'.pdf';

			$i++;
		}

		// download it "D" - download, "I" - inline, "F" - local file, "S" - string
		$this->m_pdf->pdf->Output(); // output to browser
		//$this->m_pdf->pdf->Output($pdf_file_path, "F");

		exit;
	}

	// --------------------------------------------------------------------

}
