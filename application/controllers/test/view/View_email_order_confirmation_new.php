<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/****************
 * Frontend Controller holds any general front end items
 *
 * Shop Controller are for items used for shop thumbs pages
 *
 */
class View_email_order_confirmation_new extends Frontend_Controller
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
	function index($id = '10302248')
	{
		// load pertinent library/model/helpers
		$this->load->library('users/wholesale_user_details');
		$this->load->library('users/consumer_user_details');
		$this->load->library('designers/designer_details');
		$this->load->library('products/product_details');
		$this->load->library('orders/order_details');
		$this->load->library('products/size_names');
		$this->load->library('email');

		// initialize...
		$this->data['order_details'] = $this->order_details->initialize(array('tbl_order_log.order_log_id'=>$id));

		// get user_id and role and designer group
		$user_role = $this->data['order_details']->c;
		$user_id = $this->data['order_details']->user_id;
		$designer_group = $this->data['order_details']->designer_group;
		$designer_slug = $this->data['order_details']->designer_slug;

		// initialize user details
		if ($user_role == 'ws')
		{
			// wholesale
			$this->data['user_details'] = $this->wholesale_user_details->initialize(array('user_id'=>$user_id));
		}
		else
		{
			// consumer
			$this->data['user_details'] = $this->consumer_user_details->initialize(array('user_id'=>$user_id));
		}

		// set company details via order designer
		if ($designer_group == 'Mixed Designers')
		{
			$this->data['company_name'] = $this->webspace_details->name;
			$this->data['company_address1'] = $this->webspace_details->address1;
			$this->data['company_address2'] = $this->webspace_details->address2;
			$this->data['company_city'] = $this->webspace_details->city;
			$this->data['company_state'] = $this->webspace_details->state;
			$this->data['company_zipcode'] = $this->webspace_details->zipcode;
			$this->data['company_country'] = $this->webspace_details->country;
			$this->data['company_telephone'] = $this->webspace_details->phone;
			$info_email = $this->webspace_details->email;
			$this->data['logo'] =
				@$this->webspace_details->options['logo']
				? $this->config->item('PROD_IMG_URL').$this->webspace_details->options['logo']
				: $this->config->item('PROD_IMG_URL').'assets/images/logo/logo-shop7thavenue.png'
			;
		}
		else
		{
			// initialize class
			$this->designer_details->initialize(
				array(
					'url_structure' => $designer_slug
				)
			);

			$this->data['company_name'] = $this->designer_details->designer;
			$this->data['company_address1'] = $this->designer_details->address1;
			$this->data['company_address2'] = $this->designer_details->address2;
			$this->data['company_city'] = $this->designer_details->city;
			$this->data['company_state'] = $this->designer_details->state;
			$this->data['company_zipcode'] = $this->designer_details->zipcode;
			$this->data['company_country'] = $this->designer_details->country;
			$this->data['company_telephone'] = $this->designer_details->phone;
			$info_email = $this->designer_details->info_email;
			$this->data['logo'] = $this->config->item('PROD_IMG_URL').$this->designer_details->logo;
		}

		// load the view
		$message = $this->load->view('templates/order_confirmation_new', $this->data, TRUE);

		/* *
		$email_subject = $this->data['company_name'].' - Product Order'.($user_role == 'ws' ? ' - Wholesale' : '');

		$this->email->clear();

		$this->email->from($info_email, $this->data['company_name']);

		$this->email->to('rsbgm@rcpixel.com');

		$this->email->subject($email_subject);
		$this->email->message($message);

		if ( ! $this->email->send())
		{
			// set error message
			$this->error = 'Unable to CI send to - "'.$user_details->email.'"<br />';
			exit;
		}
		// */

		// show html email message
		echo $message;
	}

	// --------------------------------------------------------------------

	/**
	 * Primary method - index
	 *
	 * @return	void
	 */
	function send($id = '')
	{
		// load pertinent library/model/helpers
		$this->load->library('products/product_details');
		$this->load->library('orders/order_details');
		$this->load->library('products/size_names');
		$this->load->library('orders/order_email_confirmation');
		$this->load->library('email');

		// initialize...
		$this->data['order_details'] = $this->order_details->initialize(array('tbl_order_log.order_log_id'=>$id));

		// set user_cat, user_id, order_id

		// initialize class
		$this->order_email_confirmation->initialize(
			array(
				'user_id' => '',
				'user_cat' => 'ws',
				'order_id' => $id
			)
		);

		// load the view
		$message = $this->load->view('templates/order_confirmation_new', $this->data, TRUE);
		$email_subject = $this->webspace_details->name.' Product Order'.($this->session->user_cat == 'wholesale' ? ' - Wholesale' : '');

		// send email
		exit;
	}

	// --------------------------------------------------------------------

}
