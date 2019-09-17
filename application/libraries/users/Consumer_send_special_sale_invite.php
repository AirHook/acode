<?php
if ( ! defined('BASEPATH')) exit('ERROR: 404 Not Found');

/**
 * Consumer Special Sale Email Invite Sending Class
 *
 * This class' objective is send out the sales package via email
 *
 * @package		CodeIgniter
 * @subpackage	Custom Libraries
 * @category	Sales Package, Sales Package Sending
 * @author		WebGuy
 * @link
 */
class Consumer_send_special_sale_invite
{
	/**
	 * Wholesale Users
	 *
	 * @var	array
	 */
	public $users = array();

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
	 * @param	array	$param	Initialization parametera
	 *
	 * @return	void
	 */
	public function __construct($params = array())
	{
		$this->CI =& get_instance();

		$this->initialize($params);
		log_message('info', 'Wholesale Activation Email Sending Class Initialized');
	}

	// --------------------------------------------------------------------

	/**
	 * Initialize Preferences
	 *
	 * @param	array	$param	Initialization parameters
	 *
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
		$this->users = $params;

		return $this;
	}

	// --------------------------------------------------------------------

	/**
	 * Send Consumer User Special Sale Email
	 *
	 * @return	boolean
	 */
	public function send()
	{
		// load pertinent library/model/helpers
		$this->CI->load->library('email');
		$this->CI->load->library('users/consumer_user_details');
		$this->CI->load->library('products/product_details');

		// for each user
		foreach ($this->users as $user_id)
		{
			if ( ! $this->CI->consumer_user_details->initialize(array('user_id'=>$user_id)))
			{
				$this->error .= 'Invalid user information.<br />';
			}

			// set emailtracker_id
			$data['emailtracker_id'] =
				$this->CI->consumer_user_details->user_id
				.'ci0015t'	// 0015 code for special sale invite (onsale products)
				.time()
			;

			// let's get some thumbs
			$data['onsale_products'] = $this->_get_thumbs('onsale');

			$this->CI->email->clear();

			// do the email headers
			$this->CI->email->from($this->CI->webspace_details->info_email, $this->CI->webspace_details->name);
			//$this->CI->email->cc($this->CI->config->item('info_email'));
			//$this->CI->email->bcc($this->CI->webspace_details->info_email.', '.$this->CI->config->item('dev1_email'));

			// let's set some data
			//$date_hash = sha1(@date('Y-m-d', @time()));
			//$se = sha1($this->CI->consumer_user_details->email);
			//$query_string_hash = '?ue='.$se.'&td='.$date_hash;
			//$data['link'] = str_replace('https', 'http', base_url()).'special_sale/apparel.html'.$query_string_hash;
			//$data['unsublink'] = str_replace('https', 'http', base_url()).'special_sale/unsubscribe.html'.$query_string_hash;
			$data['name'] = ucwords(strtolower(trim($this->CI->consumer_user_details->fname).' '.trim($this->CI->consumer_user_details->lname)));
			$data['designer'] = $this->CI->consumer_user_details->designer ?: $this->CI->webspace_details->name;
			$data['reference_designer'] = $this->CI->consumer_user_details->reference_designer ?: $this->CI->webspace_details->slug;

			// to and subject
			$this->CI->email->subject(strtoupper($data['designer']).' SPECIAL SALE');
			$this->CI->email->to($this->CI->consumer_user_details->email);

			// grab template and infuse data and set message
			$message = $this->CI->load->view('templates/consumer_special_sale_invite_v3', $data, TRUE);
			$this->CI->email->message($message);

			// send email
			if (ENVIRONMENT === 'development')
			{
				$params['special_sale_invite'] = time();
				$this->CI->consumer_user_details->update_options($params);
				$this->CI->session->set_flashdata('success', 'consumer_send_special_sale_invite');
				echo 'Dev <br />';
				echo $message;
				echo '<br />';
				echo '<br />';
				echo '<a href="'.site_url($this->CI->config->slash_item('admin_folder').'users/consumer').'">continue...</a>';
				echo '<br />';
				echo '<br />';
				echo '<pre>';
				print_r($data);
				die();
			}
			else
			{
				$sendby = @$this->CI->webspace_details->options['email_send_by'] ?: 'mailgun'; // options: mailgun, default (CI native emailer)

				if ($sendby == 'mailgun')
				{
					// load pertinent library/model/helpers
					$this->CI->load->library('mailgun/mailgun');
					$this->CI->mailgun->from = $this->CI->consumer_user_details->designer.' <'.$this->CI->consumer_user_details->designer_info_email.'>';
					$this->CI->mailgun->to = $this->CI->consumer_user_details->email;
					$this->CI->mailgun->cc = $this->CI->webspace_details->info_email;
					//$this->CI->mailgun->bcc = $this->CI->config->item('dev1_email');
					$this->CI->mailgun->subject = strtoupper($this->CI->consumer_user_details->designer).' SPECIAL SALE';
					$this->CI->mailgun->message = $message;

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

			$params['special_sale_invite'] = time();
			$this->CI->consumer_user_details->update_options($params);
		}

		return TRUE;
	}

	// --------------------------------------------------------------------

	/**
	 * Get activation emai product thumbs suggestion
	 *
	 * @params	string
	 * @return	array
	 */
	private function _get_thumbs($str)
	{
		// load pertinent library/model/helpers
		$this->CI->load->library('products/products_list');

		// primary item that is changed for the preset salespackages
    	$params['facets'] = array('availability'=>$str);

		// get the products list
		$params['show_private'] = TRUE; // all items general public (Y) - N for private
		$params['view_status'] = 'ALL'; // ALL items view status (Y, Y1, Y2, N)
		$params['variant_publish'] = 'ALL'; // ALL variant level color publish (view status)
		$params['group_products'] = FALSE; // group per product number or per variant
		// show items even without stocks at all
		$params['with_stocks'] = TRUE;	// FALSE for including no stock items
		$params['group_products'] = FALSE; // FALSE for all variants
		// others
		$this->CI->products_list->initialize($params);
		$products = $this->CI->products_list->select(
			array(
				'designer.url_structure' => $this->CI->consumer_user_details->reference_designer
			),
			array( // order conditions
				'seque' => 'asc',
				'tbl_product.prod_no' => 'desc'
			),
			30
		);

		// capture product numbers and set items array
		if ($products)
		{
			$cnt = 0;
			$items_array = array();
			foreach ($products as $product)
			{
				array_push($items_array, $product->prod_no.'_'.$product->color_code);
			}

			return $items_array;
		}
		else return FALSE;
	}

	// --------------------------------------------------------------------

}
