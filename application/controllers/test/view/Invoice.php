<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/****************
 *
 *
 */
class Invoice extends MY_Controller
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
	function index($order_id = '')
	{
		if ( ! $order_id)
		{
			// nothing more to do...
			echo 'An order ID# is needed...';
			exit;
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
		$this->data['view_params'] = 'invoice_email';
		$this->data['status'] = $this->order_details->status_text;
		//$this->data['order_items'] = $this->order_details->items();

		// create access link to payment options
		$this->data['access_link'] = site_url(
			'my_account/wholesale/orders/link/index/'
			.$order_id.'/'
			.$this->data['order_details']->user_id.'/'
			.md5(@date('Y-m-d', time()))	// $ts = md5 hashed timestamp
		);

		foreach ($this->order_details->items() as $designer => $items)
		{
			// set the order items
			$this->data['order_items'] = $items;

			// we need to get the size mode and size names array
			foreach ($items as $item)
			{
				$des_options = json_decode($item->webspace_options, TRUE);
				break;
			}
			$this->data['size_mode'] = $des_options['size_mode'];
			$this->data['size_names'] = $this->size_names->get_size_names($des_options['size_mode']);
			$this->data['designer'] = $designer;

			// load the view
			$message = $this->load->view('templates/invoice', $this->data, TRUE);

			echo $message;
		}

		exit;
	}

	// --------------------------------------------------------------------

}
