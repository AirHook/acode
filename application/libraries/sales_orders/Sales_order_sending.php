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
class Sales_order_sending
{
	/**
	 * PO id
	 *
	 * @var	string
	 */
	public $so_id = '';

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
		log_message('info', 'Sales Order Invoice Sending Class Initialized');
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
	public function send($so_id = '')
	{
		// load pertinent library/model/helpers
		$this->CI->load->library('products/product_details');
		$this->CI->load->library('products/size_names');
		$this->CI->load->library('sales_orders/sales_order_details');
		$this->CI->load->library('users/admin_user_details');
		$this->CI->load->library('users/wholesale_user_details');
		$this->CI->load->library('users/consumer_user_details');
		$this->CI->load->library('users/sales_user_details');

		// initialize sales order properties and items
		$data['so_details'] = $this->CI->sales_order_details->initialize(
			array(
				'sales_order_id' => $so_id
			)
		);

		// get the author
		switch ($this->CI->sales_order_details->c)
		{
			case '2': //sales
				$data['author'] = $this->CI->sales_user_details->initialize(
					array(
						'admin_sales_id' => $this->CI->sales_order_details->author
					)
				);
			break;
			case '1': //admin
			default:
				$data['author'] = $this->CI->admin_user_details->initialize(
					array(
						'admin_id' => ($this->CI->sales_order_details->author ?: '1')
					)
				);
		}

		// get store details
		// check for user cat to fill out bill to/ship to address
		if ($this->CI->sales_order_details->user_cat)
		{
			if ($this->CI->sales_order_details->user_cat == 'ws')
			{
				$data['store_details'] = $this->CI->wholesale_user_details->initialize(
					array(
						'user_id' => $this->CI->sales_order_details->user_id
					)
				);
			}

			if ($this->CI->sales_order_details->user_cat == 'cs')
			{
				$data['store_details'] = $this->CI->consumer_user_details->initialize(
					array(
						'user_id' => $this->CI->sales_order_details->user_id
					)
				);
			}
		}

		// set THE items
		$data['so_items'] = $this->CI->sales_order_details->items;
		$data['so_date'] = $this->CI->sales_order_details->so_date;
		$data['so_number'] = $this->CI->sales_order_details->so_number;
		$data['so_options'] = $this->CI->sales_order_details->options;
		for($c = strlen($data['so_number']);$c < 6;$c++)
		{
			$data['so_number'] = '0'.$data['so_number'];
		}

		$this->CI->load->library('email');

		$this->CI->email->clear(TRUE);

		$this->CI->email->from($data['author']->email, $this->CI->designer_details->designer_name);
		$this->CI->email->reply_to($this->CI->webspace_details->info_email, $this->CI->designer_details->designer_name);
		//$this->CI->email->cc($this->CI->config->item('info_email'));
		$this->CI->email->bcc($this->CI->config->item('dev1_email'));

		$this->CI->email->subject('SO #'.$data['so_number']);

		//$this->CI->email->to($data['vendor_details']->vendor_email);
		$this->CI->email->to($this->CI->webspace_details->info_email);

		// let's get the message
		$message = $this->CI->load->view('templates/sales_order_email', $data, TRUE);
		$this->CI->email->message($message);

		// attachment
		// load the view as string
		$html = $this->CI->load->view('templates/sales_order_pdf', $data, TRUE);
		// load pertinent library/model/helpers
		$this->CI->load->library('m_pdf');
		// generate pdf
		$this->CI->m_pdf->pdf->WriteHTML($html);
		// set filename and file path
		$pdf_file_path = 'assets/pdf/pdf_so_selected.pdf';
		// download it "D" - download, "I" - inline, "F" - local file, "S" - string
		//$this->m_pdf->pdf->Output(); // output to browser
		$this->CI->m_pdf->pdf->Output($pdf_file_path, "F");

		$pdf_attachment = 'assets/pdf/pdf_so_selected.pdf';
		$this->CI->email->attach($pdf_attachment);

		if (ENVIRONMENT !== 'development')
		{
			if ( ! $this->CI->email->send())
			{
				$this->error .= 'Unable to send to - "'.$email.'"<br />';
				exit;
				return FALSE;
			}
		}
		else
		{
			// if first sending
			if ( ! $this->CI->session->dev_first_sending)
			{
				// show sending
				echo $message;
				$this->CI->session->set_userdata('dev_first_sending', TRUE);
			}
			else
			{
				unset($_SESSION['dev_first_sending']);
			}
		}

		$this->CI->email->clear(TRUE);

		// set flashdata
		$this->CI->session->set_flashdata('success', 'sent');
		return TRUE;
	}

	// --------------------------------------------------------------------

}
