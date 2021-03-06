<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/****************
 *
 *
 */
class Send_invoice extends Sales_user_Controller
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
			redirect('my_account/sales/orders', 'location');
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
		$this->data['status'] = $this->order_details->status_text;
		$this->data['order_items'] = $this->order_details->items();

		// create access link to payment options
		$this->data['access_link'] = site_url(
			'my_account/wholesale/orders/link/index/'
			.$order_id.'/'
			.$this->data['order_details']->user_id.'/'
			.md5(@date('Y-m-d', time()))	// $ts = md5 hashed timestamp
		);

		// load the view
		$html = $this->load->view('templates/invoice', $this->data, TRUE);

		/**
		 * Create PDF
		 */
		// load pertinent library/model/helpers
 		$this->load->library('m_pdf');
		$this->load->library('email');

 		// generate pdf
 		$this->m_pdf->pdf->WriteHTML($html);

 		// set filename and file path
 		$pdf_file_path = 'assets/pdf/pdf_invoice.pdf';

		// download it "D" - download, "I" - inline, "F" - local file, "S" - string
		//$this->m_pdf->pdf->Output(); // output to browser
		$this->m_pdf->pdf->Output($pdf_file_path, "F");

		/**
		 * Send the email
		 */
		// let start composing the email
		$email_subject = $this->webspace_details->name.' Order Invoice #'.$this->data['order_details']->invoice_id;

		$this->email->from($this->webspace_details->info_email, $this->webspace_details->name);

		$this->email->to($this->data['user_details']->email);
		$this->email->bcc('help@shop7thavenue.com');
		//$this->email->to('rsbgm@rcpixel.com');

		$this->email->attach(base_url().$pdf_file_path);
		$this->email->subject($email_subject);
		$this->email->message($html);

		if (ENVIRONMENT == 'development') // ---> used for development purposes
		{
			// we are unable to send out email in our dev environment
			// so we check on the email template instead.
			// just don't forget to comment these accordingly
			echo 'SUBJECT: '.$email_subject;
			echo '<br /><br />';
			echo $html;
			echo '<br /><br />';
			echo '<a href="'.site_url('my_account/sales/orders/details/index/'.$order_id).'">Continue...</a>';
			exit;
		}
		else
		{
			if ( ! $this->email->send())
			{
				// set error message
				$this->error = 'Unable to CI send to - "'.$user_details->email.'"<br />';

				return FALSE;
			}
		}

		// set flash data
		$this->session->set_flashdata('success', 'invoice_sent');

		// redirect user
		redirect('my_account/sales/orders/details/index/'.$order_id, 'location');
	}

	// --------------------------------------------------------------------

}
