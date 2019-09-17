<?php
if ( ! defined('BASEPATH')) exit('ERROR: 404 Not Found');

/**
 * Wholesale Activation Email Sending Class
 *
 * This class' objective is send out the sales package via email
 *
 * @package		CodeIgniter
 * @subpackage	Custom Libraries
 * @category	Sales Package, Sales Package Sending
 * @author		WebGuy
 * @link
 */
class Wholesale_activation_email_sending
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
		$this->users = $params['users'];

		return $this;
	}

	// --------------------------------------------------------------------

	/**
	 * Send Wholesale User Activation Email
	 *
	 * @return	boolean
	 */
	public function send()
	{
		// load pertinent library/model/helpers
		$this->CI->load->library('email');
		$this->CI->load->library('users/wholesale_user_details');
		$this->CI->load->library('products/product_details');

		// connect to database
		$DB = $this->CI->load->database('instyle', TRUE);
		// get privay Policy
		$DB->select('text');
		$DB->where('title_code', 'wholesale_privacy_notice');
		$q = $DB->get('pages')->row();
		$data['privacy_policy'] = $q->text;

		// for each user
		foreach ($this->users as $email)
		{
			if ( ! $this->CI->wholesale_user_details->initialize(array('email'=>$email)))
			{
				$this->error .= 'Invalid email address - "'.$email.'"<br />';

				return FALSE;
			}

			// set emailtracker_id
			$data['emailtracker_id'] =
				$this->CI->wholesale_user_details->user_id
				.'wi0010t'
				.time()
			;

			// get product list
			$data['instock_products'] = $this->_get_thumbs('instock');
			$data['preorder_products'] = $this->_get_thumbs('preorder');
			$data['onsale_products'] = ''; //$this->_get_thumbs('onsale');

			$this->CI->email->clear();

			$this->CI->email->from($this->CI->wholesale_user_details->designer_info_email, $this->CI->wholesale_user_details->designer);
			$this->CI->email->cc($this->CI->webspace_details->info_email);
			$this->CI->email->bcc($this->CI->config->item('dev1_email'));

			$this->CI->email->subject('Welcome to '.$this->CI->wholesale_user_details->designer.' Wholesale Order System');

			$this->CI->email->to($this->CI->wholesale_user_details->email);

			// let's set some data and get the message template
			$data['username'] = ucwords(strtolower(trim($this->CI->wholesale_user_details->fname).' '.trim($this->CI->wholesale_user_details->lname)));
			$data['email'] = $this->CI->wholesale_user_details->email;
			$data['password'] = $this->CI->wholesale_user_details->password;
			$data['user_id'] = $this->CI->wholesale_user_details->user_id;
			$data['admin_sales_id'] = $this->CI->wholesale_user_details->admin_sales_id;
			$data['sales_rep'] = ucwords(strtolower(trim($this->CI->wholesale_user_details->admin_sales_user).' '.trim($this->CI->wholesale_user_details->admin_sales_lname)));
			$data['reference_designer'] = $this->CI->wholesale_user_details->reference_designer;
			$data['designer'] = $this->CI->wholesale_user_details->designer;
			$data['designer_site_domain'] = $this->CI->wholesale_user_details->designer_site_domain;
			$data['designer_address1'] = $this->CI->wholesale_user_details->designer_address1;
			$data['designer_address2'] = $this->CI->wholesale_user_details->designer_address2;
			$data['designer_phone'] = $this->CI->wholesale_user_details->designer_phone;

			$message = $this->CI->load->view('templates/activation_email_v1', $data, TRUE);
			$this->CI->email->message($message);

			if (ENVIRONMENT === 'development')
			{
				$this->CI->session->set_flashdata('success', 'acivation_email_sent');
				echo 'Dev <br />';
				echo '<br />';
				echo $message;
				echo '<br />';
				echo '<br />';
				echo '<a href="'.($this->CI->uri->segment(1) === 'sales' ? site_url('sales/wholesale') : site_url($this->CI->config->slash_item('admin_folder').'users/wholesale')).'">continue...</a>';
				echo '<br />';
				echo '<br />';
				die();
			}
			else
			{
				$sendby = @$this->CI->webspace_details->options['email_send_by'] ?: 'mailgun'; // options: mailgun, default (CI native emailer)

				if ($sendby == 'mailgun')
				{
					// load pertinent library/model/helpers
					$this->CI->load->library('mailgun/mailgun');
					$this->CI->mailgun->from = $this->CI->wholesale_user_details->designer.' <'.$this->CI->wholesale_user_details->designer_info_email.'>';
					$this->CI->mailgun->to = $this->CI->wholesale_user_details->email;
					$this->CI->mailgun->cc = $this->CI->webspace_details->info_email;
					$this->CI->mailgun->bcc = $this->CI->config->item('dev1_email');
					$this->CI->mailgun->subject = 'Welcome to '.$this->CI->wholesale_user_details->designer.' Wholesale Order System';
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
					if ( ! @$this->CI->email->send())
					{
						$this->error .= 'Unable to send to - "'.$email.'"<br />';

						return FALSE;
					}
				}
			}
		}

		$this->CI->session->set_flashdata('success', 'acivation_email_sent');

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
		$params['with_stocks'] = $params == 'instock' ? TRUE : FALSE;
		$params['group_products'] = TRUE;
		// others
		$this->CI->products_list->initialize($params);
		$products = $this->CI->products_list->select(
			array(
				'designer.url_structure' => $this->CI->wholesale_user_details->reference_designer,
				'tbl_product.categories LIKE' => '195'	// evening dresses for activation email
			),
			array( // order conditions
				'seque' => 'asc',
				'tbl_product.prod_no' => 'desc'
			),
			12
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
