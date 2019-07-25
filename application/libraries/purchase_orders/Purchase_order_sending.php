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
	public function send($po_id = '')
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

		// other options
		$data['po_options'] = $this->purchase_order_details->options;

		// get ship to details
		if (isset($data['po_options']['po_store_id']))
		{
			$data['store_details'] = $this->CI->wholesale_user_details->initialize(
				array(
					'user_id' => $data['po_options']['po_store_id']
				)
			);
		}
		else $data['store_details'] = $this->CI->wholesale_user_details->set_initial_state();

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
		$this->CI->designer_details->initialize(array('designer.des_id'=>$this->CI->purchase_order_details->des_id));

		// load email library class
		// set company information
		$this->data['company_name'] = $this->CI->designer_details->company_name;
		$this->data['company_address1'] = $this->CI->designer_details->address1;
		$this->data['company_address2'] = $this->CI->designer_details->address2;
		$this->data['company_city'] = $this->CI->designer_details->city;
		$this->data['company_state'] = $this->CI->designer_details->state;
		$this->data['company_zipcode'] = $this->CI->designer_details->zipcode;
		$this->data['company_country'] = $this->CI->designer_details->country;
		$this->data['company_telephone'] = $this->CI->designer_details->phone;
		$this->data['company_contact_person'] = $this->CI->designer_details->owner;
		$this->data['company_contact_email'] = $this->CI->designer_details->info_email;

		$this->CI->load->library('email');

		$this->CI->email->clear(TRUE);

		$this->CI->email->from($data['author']->email, $this->CI->designer_details->designer_name);
		$this->CI->email->reply_to($this->CI->webspace_details->info_email, $this->CI->designer_details->designer_name);
		//$this->CI->email->cc($this->CI->config->item('info_email'));
		$this->CI->email->bcc($this->CI->config->item('dev1_email'));

		$this->CI->email->subject('PO #'.$this->CI->purchase_order_details->po_number);

		//$this->CI->email->to($data['vendor_details']->vendor_email);
		$this->CI->email->to($this->CI->webspace_details->info_email);

		// let's get the message
		$message = $this->CI->load->view('templates/purchase_order_email', $data, TRUE);
		$this->CI->email->message($message);

		// attachment
		// set pdf path for attachment
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
			if ( ! $this->CI->email->send())
			{
				$this->error .= 'Unable to send to - "'.$email.'"<br />';
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
				die();
			}
			else
			{
				unset($_SESSION['dev_first_sending']);
			}
		}

		$this->CI->email->clear(TRUE);

		// set flashdata
		$this->CI->session->set_flashdata('success', 'pacakge_sent');

		return TRUE;
	}

	// --------------------------------------------------------------------

	/**
	 * Send Sales Package Email
	 *
	 * This sending is set to make any sales offer with more than 10 items
	 * send in separate emails of 10 items each upto 30 items
	 *
	 * @return	boolean
	 */
	public function send_30()
	{
		// load email library class
		// used on view file to set image paths
		// to access product details
		$this->CI->load->library('products/product_details');

		// load user details class
		// used during $users iteration
		// to get user details
		$this->CI->load->library('users/wholesale_user_details');

		// get and initialize the sales package
		$this->CI->load->library('sales_package/sales_package_details');
		$this->CI->sales_package_details->initialize(array('sales_package_id'=>$this->sales_package_id));

		// let's get the items, check number of items, divide by 3 for 3 emails where necessary
		$index = 0;	// key for the items array which will identify how many email to send (+1)
		$count_to_10 = 0; // counting items 1 - 10 only per email
		$items_ary = array();
		foreach($this->CI->sales_package_details->items as $item)
		{
			// next index after 10 items
			if ($count_to_10 == 10)
			{
				$count_to_10 = 0;
				$index++;
			}

			$items_ary[$index][$count_to_10] = $item;

			$count_to_10++;
		}

		// load email library class
		$this->CI->load->library('email');

		// for each user
		foreach ($this->users as $email)
		{
			if ( ! $this->CI->wholesale_user_details->initialize(array('email'=>$email)))
			{
				$this->error .= 'Invalid email address - "'.$email.'"<br />';
			}

			// lets prepare for the url hash tags for the session login of wholesale user
			// clicks through the sales package
			//$sa1 = md5($email);

			// lets set the hashed time code here so that the batched hold the same tc only
			$tc = md5(@date('Y-m-d', time()));

			$batch = 0;	// email batch sending
			for($batch = 0; $batch < ($index + 1); $batch++)
			{
				$data['username'] = ucwords(strtolower(trim($this->CI->wholesale_user_details->fname).' '.trim($this->CI->wholesale_user_details->lname)));
				$data['email_message'] = $this->CI->sales_package_details->email_message;

				$data['access_link'] = site_url(
					'sales_package/link/index/'
					.$this->CI->sales_package_details->sales_package_id.'/'
					.$this->CI->wholesale_user_details->user_id.'/'
					.$tc
				);

				$data['items'] = $items_ary[$batch];
				$data['email'] = $email;
				$data['w_prices'] = $this->w_prices;
				$data['w_images'] = $this->w_images;
				$data['linesheets_only'] = $this->linesheets_only;
				$data['sales_username'] = @$this->CI->sales_user_details->admin_sales_id ? ucwords(strtolower(trim($this->CI->sales_user_details->fname).' '.trim($this->CI->sales_user_details->lname))) : ucwords(strtolower(trim($this->CI->wholesale_user_details->admin_sales_user).' '.trim($this->CI->wholesale_user_details->admin_sales_lname)));
				$data['sales_ref_designer'] = @$this->CI->sales_user_details->admin_sales_id ? $this->CI->sales_user_details->designer_name : $this->CI->wholesale_user_details->designer;

				$this->CI->email->clear(TRUE);

				$this->CI->email->from((@$this->CI->sales_user_details->email ?: $this->CI->wholesale_user_details->designer_info_email), (@$this->CI->sales_user_details->designer_name ?: $this->CI->wholesale_user_details->designer));
				$this->CI->email->reply_to((@$this->CI->sales_user_details->email ?: $this->CI->wholesale_user_details->designer_info_email));
				//$this->CI->email->cc($this->CI->config->item('info_email'));
				$this->CI->email->bcc($this->CI->config->item('info_email').', '.$this->CI->config->item('dev1_email'));

				$this->CI->email->subject($this->CI->sales_package_details->email_subject);

				$this->CI->email->to($this->CI->wholesale_user_details->email);

				// let's get the message
				$message = $this->CI->load->view('templates/sales_package', $data, TRUE);
				$this->CI->email->message($message);

				// attachment
				if ($this->w_images === 'Y' OR $this->linesheets_only == 'Y')
				{
					foreach ($data['items'] as $product)
					{
						// get product details
						$this->CI->product_details->initialize(array('prod_no'=>$product));

						// set image paths
						$img_pre = 'product_assets/WMANSAPREL/'.$this->CI->product_details->d_folder.'/'.$this->CI->product_details->sc_folder.'/product_linesheet/';
						// the image filename (using 1 - 140x210)
						$image = $this->CI->product_details->prod_no.'_'.$this->CI->product_details->primary_img_id.'.jpg';

						$this->CI->email->attach($img_pre.$image);
					}
				}

				if (ENVIRONMENT === 'development')
				{
					// set flashdata
					$this->CI->session->set_flashdata('success', 'pacakge_sent'); return TRUE;

					if (@$this->CI->data['sales_theme'] == 'roden2') $this->CI->session->set_flashdata('success', 'sales_package_sent');
					else $this->CI->session->set_flashdata('success', 'pacakge_sent');
					echo 'Email batch - '.$batch.'<br />';
					echo $message;
					echo '<br />';
					echo '<br />';
					if ($this->send_from == 'front_end')
					{
						if ($this->CI->data['sales_theme'] == 'roden2') echo '<a href="'.site_url('sales/view/index/'.$this->sales_package_id).'">continue...</a>';
						if ($this->CI->data['sales_theme'] == 'default') echo '<a href="'.site_url('sales/sent').'">continue...</a>';
					}
					else echo '<a href="'.($this->CI->uri->segment(1) === 'sales' ? site_url('sales/wholesale') : site_url($this->CI->config->slash_item('admin_folder').'users/wholesale')).'">continue...</a>';
					echo '<br />';
					echo '<br />';
					//die();
					//echo $message;
					//die();
				}
				else
				{
					if ( ! $this->CI->email->send())
					{
						$this->error .= 'Unable to send to - "'.$email.'"<br />';
					}
				}
			}
		}

		$this->CI->email->clear(TRUE);

		// set flashdata
		$this->CI->session->set_flashdata('success', 'pacakge_sent');

		return TRUE;
	}

	// --------------------------------------------------------------------

}
