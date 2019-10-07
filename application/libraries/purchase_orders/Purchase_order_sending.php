<?php
if ( ! defined('BASEPATH')) exit('ERROR: 404 Not Found');

/**
 * Sales Package Sending Class
 *
 * This class' objective is send out the sales package via email
 *
 * @package		CodeIgniter
 * @subpackage	Custom Libraries
 * @category	Sales Package, Sales Package Sending
 * @author		WebGuy
 * @link
 */
class Purchase_order_sending
{
	/**
	 * PO id
	 *
	 * @var	string
	 */
	public $po_id = '';

	/**
	 * Other pertinent items
	 *
	 * @var	string
	 */
	public $w_prices = 'Y';
	public $w_images = 'N';
	public $linesheets_only = 'N';

	/**
	 * Wholesale Users
	 *
	 * @var	array
	 */
	public $users = array();

	/**
	 * Send From - which part of the program is executing this sending
	 *
	 * @var	array
	 */
	public $send_from = 'admin';

	/**
	 * Error Message
	 *
	 * @var	string
	 */
	public $error = '';


	/**
	 * CI Singleton
	 *
	 * @var	object
	 */
	protected $CI;

	// --------------------------------------------------------------------

	/**
	 * Constructor
	 *
	 * @param	array	$param	Initialization parameter - the item id
	 *
	 * @return	void
	 */
	public function __construct($params = array())
	{
		$this->CI =& get_instance();

		$this->initialize($params);
		log_message('info', 'Sales Package Sending Class Initialized');
	}

	// --------------------------------------------------------------------

	/**
	 * Initialize Preferences
	 *
	 * @param	array	$param	Initialization parameter - the item id
	 *					where admin_sales_email = $param
	 * @return	Page_details
	 */
	public function initialize(array $params)
	{
		if (empty($params))
		{
			// nothing more to do...
			return FALSE;
		}

		// initialize properties
		foreach ($params as $key => $val)
		{
			if ($val !== '')
			{
				if (property_exists($this, $key))
				{
					$this->$key = $val;
				}
			}
		}

		return $this;
	}

	// --------------------------------------------------------------------

	/**
	 * Send Sales Package Email
	 *
	 * This sending is set to make any sales offer with more than 15 items
	 * send in an email with a LOAD MORE button at the bottom of the items
	 *
	 * @return	boolean
	 */
	public function send($po_id = '', $send_to = '')
	{
		// load pertinent library/model/helpers
		$this->CI->load->library('designers/designer_details');
		$this->CI->load->library('webspaces/webspace_details');
		$this->CI->load->library('products/size_names');
		$this->CI->load->library('products/product_details');
		$this->CI->load->library('purchase_orders/purchase_order_details');
		$this->CI->load->library('users/wholesale_user_details');
		$this->CI->load->library('users/vendor_user_details');
		$this->CI->load->library('users/sales_user_details');
		$this->CI->load->library('users/admin_user_details');
		$this->CI->load->library('designers/designer_details');

		// initialize purchase order properties and items
		$data['po_details'] = $this->CI->purchase_order_details->initialize(
			array(
				'po_id' => $po_id
			)
		);

		// get po items and other array stuff
		$data['po_number'] = $this->CI->purchase_order_details->po_number;
		$data['po_items'] = $this->CI->purchase_order_details->items;
		$data['po_options'] = $this->CI->purchase_order_details->options;

		// get vendor details
		$data['vendor_details'] = $this->CI->vendor_user_details->initialize(
			array(
				'vendor_id' => $this->CI->purchase_order_details->vendor_id
			)
		);

		// get ship to details
		if (isset($data['po_options']['po_store_id']))
		{
			$data['store_details'] = $this->CI->wholesale_user_details->initialize(
				array(
					'user_id' => $data['po_options']['po_store_id']
				)
			);
		}

		// get PO author
		switch ($this->CI->purchase_order_details->c)
		{
			case '2': //sales
				$data['author'] = $this->CI->sales_user_details->initialize(
					array(
						'admin_sales_id' => $this->CI->purchase_order_details->author
					)
				);
			break;
			case '1': //admin
			default:
				$data['author'] = $this->CI->admin_user_details->initialize(
					array(
						'admin_id' => ($this->CI->purchase_order_details->author ?: '1')
					)
				);
		}

		// get designer details
		$data['designer_details'] = $this->CI->designer_details->initialize(array('designer.des_id'=>$this->CI->purchase_order_details->des_id));

		// load email library class
		// set company information
		$data['company_name'] = $this->CI->designer_details->company_name;
		$data['company_address1'] = $this->CI->designer_details->address1;
		$data['company_address2'] = $this->CI->designer_details->address2;
		$data['company_city'] = $this->CI->designer_details->city;
		$data['company_state'] = $this->CI->designer_details->state;
		$data['company_zipcode'] = $this->CI->designer_details->zipcode;
		$data['company_country'] = $this->CI->designer_details->country;
		$data['company_telephone'] = $this->CI->designer_details->phone;
		$data['company_contact_person'] = $this->CI->designer_details->owner;
		$data['company_contact_email'] = $this->CI->designer_details->info_email;

		// set emailtracker_id
		if ($send_to != 'admin')
		{
			$data['emailtracker_id'] =
				$this->CI->purchase_order_details->vendor_id
				.'vi0017t'
				.time()
				.'&vpo='
				.$this->CI->purchase_order_details->vendor_id
			;
		}

		$this->CI->load->library('email');

		$this->CI->email->clear(TRUE);

		$this->CI->email->from($data['author']->email, $this->CI->designer_details->designer_name);
		$this->CI->email->reply_to($this->CI->webspace_details->info_email, $this->CI->designer_details->designer_name);
		$this->CI->email->bcc($this->CI->config->item('dev1_email'));

		$this->CI->email->subject('PO #'.$this->CI->purchase_order_details->po_number.('admin' ? ' - for approval' : ''));

		if ($send_to == 'admin')
		{
			$to = $this->CI->webspace_details->info_email;
		}
		else
		{
			//$to = $data['vendor_details']->vendor_email;
			$to = $this->CI->config->item('info_email');
			$this->CI->email->cc($this->CI->config->item('dev1_email'));
		}
		$this->CI->email->to($to);

		// let's get the message
		$template = $send_to == 'admin' ? 'po_email_for_approval' : 'purchase_order_email';
		$message = $this->CI->load->view('templates/'.$template, $data, TRUE);
		$this->CI->email->message($message);

		// attachment
		// load the view as string
		$html = $this->CI->load->view('templates/purchase_order_pdf', $data, TRUE);
		// load pertinent library/model/helpers
		$this->CI->load->library('m_pdf');
		// generate pdf
		$this->CI->m_pdf->pdf->WriteHTML($html);
		// set filename and file path
		$pdf_file_path = 'assets/pdf/pdf_po_selected.pdf';
		// download it "D" - download, "I" - inline, "F" - local file, "S" - string
		//$this->m_pdf->pdf->Output(); // output to browser
		$this->CI->m_pdf->pdf->Output($pdf_file_path, "F");

		$pdf_attachment = 'assets/pdf/pdf_po_selected.pdf';
		$this->CI->email->attach($pdf_attachment);

		if (ENVIRONMENT !== 'development')
		{
			$sendby = @$this->CI->webspace_details->options['email_send_by'] ?: 'mailgun'; // options: mailgun, default (CI native emailer)

			if ($sendby == 'mailgun')
			{
				// load pertinent library/model/helpers
				$this->CI->load->library('mailgun/mailgun');
				$this->CI->mailgun->from = $this->CI->wholesale_user_details->designer.' <'.$data['author']->email.'>';
				$this->CI->mailgun->to = $to;
				$this->CI->mailgun->cc = $this->CI->webspace_details->info_email;
				$this->CI->mailgun->bcc = $this->CI->config->item('dev1_email');
				$this->CI->mailgun->subject = 'PO #'.$this->CI->purchase_order_details->po_number.('admin' ? ' - for approval' : '');
				$this->CI->mailgun->message = $message;

				$this->CI->mailgun->attachment = curl_file_create($pdf_file_path, 'application/pdf', 'pdf_po_selected.pdf');

				if ( ! $this->CI->mailgun->Send())
				{
					$this->error .= 'Unable to send to - "'.$email.'"<br />';
					$this->error .= $this->CI->mailgun->error_message;

					return FALSE;
				}

				$this->CI->mailgun->clear();
			}
			else
			{
				if ( ! $this->CI->email->send())
				{
					$this->error .= 'Unable to send to - "'.$email.'"<br />';
					return FALSE;
				}
			}
		}
		else
		{
			// show email
			echo $message;
			die();
		}

		$this->CI->email->clear(TRUE);

		// set flashdata
		$this->CI->session->set_flashdata('success', 'pacakge_sent');

		return TRUE;
	}

	// --------------------------------------------------------------------

}
