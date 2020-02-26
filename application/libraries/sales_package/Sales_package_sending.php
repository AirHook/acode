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
class Sales_package_sending
{
	/**
	 * Sales Package id
	 *
	 * @var	string
	 */
	public $sales_package_id = '';

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
	public function send()
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

			//$batch = 0;	// email batch sending
			//for($batch = 0; $batch < ($index + 1); $batch++)
			//{
				$data['username'] = ucwords(strtolower(trim($this->CI->wholesale_user_details->fname).' '.trim($this->CI->wholesale_user_details->lname)));
				$data['email_message'] = $this->CI->sales_package_details->email_message;

				$data['access_link'] = site_url(
					'sales_package/link/index/'
					.$this->CI->sales_package_details->sales_package_id.'/'
					.$this->CI->wholesale_user_details->user_id.'/'
					.$tc
				);

				//$data['items'] = $items_ary[$batch];
				$data['items'] = $this->CI->sales_package_details->items;
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
				$this->CI->email->bcc($this->CI->config->item('info_email').', '.$this->CI->config->item('dev1_email').', help@shop7thavenue.com');

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
						$this->CI->product_details->initialize(array('tbl_product.prod_no'=>$product));

						// set image paths
						/*
						$img_pre = 'product_assets/WMANSAPREL/'.$this->CI->product_details->d_folder.'/'.$this->CI->product_details->sc_folder.'/product_linesheet/';
						// the image filename (using 1 - 140x210)
						$image = $this->CI->product_details->prod_no.'_'.$this->CI->product_details->primary_img_id.'.jpg';
						*/

						// new image path
						$linesheet = $this->CI->config->item('PROD_IMG_URL').$this->CI->product_details->media_path.$this->CI->product_details->prod_no.'_'.$this->CI->product_details->primary_img_id.'_linesheet.jpg';

						$this->CI->email->attach($linesheet);
					}
				}

				if (ENVIRONMENT === 'development')
				{
					// set flashdata
					//$this->CI->session->set_flashdata('success', 'pacakge_sent'); return TRUE;

					/* */
					if (@$this->CI->data['sales_theme'] == 'roden2') $this->CI->session->set_flashdata('success', 'sales_package_sent');
					else $this->CI->session->set_flashdata('success', 'pacakge_sent');
					echo 'Email batch - '.@$batch.'<br />';
					echo $message;
					echo '<br />';
					echo '<br />';
					if ($this->send_from == 'front_end')
					{
						if ($this->CI->data['sales_theme'] == 'roden2') echo '<a href="'.site_url('sales/view/index/'.$this->sales_package_id).'">continue...</a>';
						if ($this->CI->data['sales_theme'] == 'default') echo '<a href="'.site_url('sales/sent').'">continue...</a>';
					}
					else echo '<a href="'.($this->CI->uri->segment(2) === 'sales' ? site_url('my_account/sales/users/wholesale') : site_url($this->CI->config->slash_item('admin_folder').'users/wholesale')).'">continue...</a>';
					echo '<br />';
					echo '<br />';
					die();
					// */

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
			//}
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
