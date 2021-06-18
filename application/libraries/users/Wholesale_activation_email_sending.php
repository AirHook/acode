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
	 * Custom Message
	 *
	 * @var	string
	 */
	public $custom_message = '';

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

		// set timestamp
		$tc = time();

		// connect to database
		$DB = $this->CI->load->database('instyle', TRUE);
		// get privay Policy
		$DB->select('text');
		$DB->where('title_code', 'wholesale_privacy_notice');
		$q = $DB->get('pages')->row();
		$data['privacy_policy'] = str_replace(
			array('help@shop7thavenue.com', 'shop7thavenue.com'),
			array($this->CI->webspace_details->info_email, $this->CI->webspace_details->site),
			$q->text
		);

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
				.$tc
			;

			// get product list
			if ($this->CI->webspace_details->slug == 'chaarmfurs')
			{
				$data['instock_products'] = $this->_get_thumbs('instock');
			}
			else
			{
				//$data['instock_products'] = $this->_get_thumbs('instock');
				//$data['preorder_products'] = $this->_get_thumbs('preorder');
				$data['onsale_products'] = $this->_get_thumbs('onsale');
			}

			$this->CI->email->clear();

			$this->CI->email->from($this->CI->wholesale_user_details->designer_info_email, $this->CI->wholesale_user_details->designer);
			$this->CI->email->cc($this->CI->webspace_details->info_email);
			$this->CI->email->bcc($this->CI->config->item('dev1_email'));

			$this->CI->email->subject('Welcome to '.$this->CI->wholesale_user_details->designer.' Wholesale Order System');

			$this->CI->email->to($this->CI->wholesale_user_details->email);

			// let's set some data and get the message template
			$data['tc'] = md5(@date('Y-m-d', $tc));
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
			$data['designer_info_email'] = $this->CI->wholesale_user_details->designer_info_email;
			$data['custom_message'] = $this->custom_message;
			$data['ws_access_level'] = $this->CI->wholesale_user_details->access_level;

			$message = $this->CI->load->view('templates/activation_email', $data, TRUE);
			$this->CI->email->message($message);

			if (ENVIRONMENT === 'development')
			{
				$this->CI->session->set_flashdata('success', 'acivation_email_sent');
				echo 'Dev <br />';
				echo '<br />';
				echo $message;
				echo '<br />';
				echo '<br />';
				echo '<a href="'.($this->CI->uri->segment(2) === 'sales' ? site_url('my_account/sales/users/wholesale') : site_url('admin/users/wholesale')).'">continue...</a>';
				echo '<br />';
				echo '<br />';
				die();
			}
			else
			{
				$sendby = @$this->CI->webspace_details->options['email_send_by'] ?: 'default'; // options: mailgun, default (CI native emailer)

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
						$this->error .= 'Unable to MG send to - "'.$email.'"<br />';
						$this->error .= '-'.$this->CI->mailgun->error_message;

						return FALSE;
					}

					$this->CI->mailgun->clear();
				}
				else
				{
					if ( ! @$this->CI->email->send())
					{
						$this->error .= 'Unable to CI send to - "'.$email.'"<br />';

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

		// collection params
    	//$params['facets'] = array('availability'=>$str);
		if ($str == 'onsale')
		{
			$where['tbl_stock.custom_order'] = '3';
		}

		// set refernce designer
		if ($this->CI->wholesale_user_details->reference_designer == 'tempoparis')
		{
			$category = '199';
		}
		else $category = '195';

		if (
			$this->CI->wholesale_user_details->reference_designer == 'shop7thavenue'
			OR $this->CI->wholesale_user_details->reference_designer == 'instylenewyork'
		)
		{
			$where['designer.url_structure'] = 'basixblacklabel';
		}
		else $where['designer.url_structure'] = $this->CI->wholesale_user_details->reference_designer;

		// set reference category
		if ($this->CI->wholesale_user_details->reference_designer != 'chaarmfurs')
		{
			$where['tbl_product.categories LIKE'] = $category;
		}

		// PUBLISH PUBLIC
		$where_public = "(
			(
				tbl_product.publish = '1'
				OR tbl_product.publish = '11'
				OR tbl_product.publish = '12'
			) AND (
				tbl_stock.new_color_publish = '1'
				OR tbl_stock.new_color_publish = '11'
				OR tbl_stock.new_color_publish = '12'
			) AND (
				tbl_stock.color_publish = 'Y'
			)
		)";
		$where['condition'][] = $where_public;

		// get the products list
		$params['show_private'] = TRUE; // all items general public (Y) - N for private
		$params['view_status'] = 'ALL'; // ALL items view status (Y, Y1, Y2, N)
		$params['variant_publish'] = 'ALL'; // ALL variant level color publish (view status)
		// show items even without stocks at all
		$params['with_stocks'] = TRUE;
		$params['group_products'] = FALSE;
		// others
		$this->CI->products_list->initialize($params);
		$products = $this->CI->products_list->select(
			$where,
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
