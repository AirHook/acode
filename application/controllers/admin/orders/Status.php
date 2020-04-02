<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Status extends Admin_Controller {

	/**
	 * Constructor
	 *
	 * @return	void
	 */
	public function __construct()
	{
		parent::__construct();
    }

	// ----------------------------------------------------------------------

	/**
	 * Index - default method
	 *
	 * Primary method to call when no other methods are found in url segment
	 * This method simply lists all sales pacakges
	 *
	 * @return	void
	 */
	public function index($id = '', $status = '', $referrer = '')
	{
		echo 'Processing single...<br />';

		if ( ! $id OR ! $status)
		{
			// nothing more to do...
			// set flash data
			$this->session->set_flashdata('error', 'no_id_passed');

			// redirect user
			redirect($this->config->slash_item('admin_folder').'orders/new_orders');
		}

		// connect to database
		$DB = $this->load->database('instyle', TRUE);

		// set db data
		switch ($status)
		{
			// 0-new,1-complete,2-onhold,3-canclled,4-returned/refunded,5-shipment_pending,6-store_credit
			case 'pending':
				$DB->set('status', '0');
			break;
			case 'on_hold':
			case 'onhold':
				$DB->set('status', '2');
			break;
			case 'cancel':
				$DB->set('status', '3');
			break;
			case 'return':
			case 'refunded':
				$DB->set('status', '4');
			break;
			case 'acknowledge':
				$DB->set('status', '5');
			break;
			case 'store_credit':
				$DB->set('status', '6');
			break;
			case 'complete':
				$DB->set('status', '1');
			break;
		}

		// update records
		$DB->set('remarks', '0');
		$DB->where('order_log_id', $id);
		$DB->update('tbl_order_log');

		// process stocks, etc...
		// setting a time to start this where previous orders will not affect stocks
		if (time() > strtotime('2020-02-28'))
		{
			switch ($status)
			{
				case 'cancel':
				case 'return':
				case 'refunded':
				case 'store_credit':
					// return stocks
					$this->_return_stocks($id, $status);
				break;
				case 'acknowledge':
					// send order acknowledgement email
					$this->_send_order_acknowledgement($id);
				break;
				case 'complete':
					// process inventory count
					$this->_remove_stocks($id);
				break;
			}
		}

		// set flash data
		$this->session->set_flashdata('success', 'edit');

		// redirect user
		if ($referrer)
		{
			if ($referrer == 'details')
			{
				redirect('admin/orders/'.$referrer.'/index/'.$id, 'location');
			}
			else redirect('admin/orders/'.$referrer, 'location');
		}
		else redirect('admin/orders/new_orders', 'location');
	}

	// --------------------------------------------------------------------

	/**
	 * Process Stock Count for Returned Orders (Cancelled, Refended, Store Credit)
	 *
	 * @return	void
	 */
	private function _return_stocks($order_id, $status)
	{
		switch ($status)
		{
			case 're':
				$txt = 'for return/refund';
			break;
			case 'cr':
				$txt = 'for store credit';
			break;
			case 'ca':
			default:
				$txt = 'cancelled';
		}

		// load reserve stock class
		$this->load->library('inventory/update_stocks');
		$this->load->library('orders/order_details');
		$this->load->library('email');

		// get order details to get the items ordered
		$order = $this->order_details->initialize(array('tbl_order_log.order_log_id'=>$order_id));

		foreach ($order->items() as $item)
		{
			// process inventory by removing from onorder and physical
			// items needed are prod_no, color_code, size, qty
			$this->load->library('inventory/update_stocks');
			$config['prod_sku'] = $item->prod_sku;
			$config['size'] = $item->size;
			$config['qty'] = $item->qty;
			$config['order_id'] = $order_id;
			$this->update_stocks->initialize($config);
			$this->update_stocks->return();
		}

		$store_name = $order->store_name ?: '';
		$username = ucwords(strtolower($order->firstname.' '.$order->lastname));

		$email_message = '
			Dear '.$username.',
			<br /><br />
			Reference ID#: '.$order_id.'
			<br /><br />
			Your order is now '.$txt.'.<br />
			Thank you very much.
			<br /><br />
			<br />
			Best Regards<br />
			<br><br>
		';

		// send email to admin
		$this->email->from($this->webspace_details->info_email, $this->webspace_details->name);
		$this->email->to($order->email);
		$this->email->cc($this->webspace_details->info_email);
		$this->email->bcc($this->config->item('dev1_email')); // --> for debuggin purposes

		$this->email->subject('Your ORDER# '.$order_id);
		$this->email->message($email_message);

		if (ENVIRONMENT == 'development') // ---> used for development purposes
		{
			// we are unable to send out email in our dev environment
			// so we check on the email template instead.
			// just don't forget to comment these accordingly
			echo 'FROM: '.$this->webspace_details->info_email.'<br />';
			echo 'TO: '.$order->email.'<br />';
			echo 'SUBJECT: '.'Your ORDER# '.$order_id.'<br /><br />';
			echo $email_message;
			echo '<br /><br />';

			//echo '<a href="'.site_url('shop/designers/'.$this->reference_designer).'">Continue...</a>';
			echo '<br /><br />';
			exit;
		}
		else @$this->email->send();
	}

	// --------------------------------------------------------------------

	/**
	 * Process Stock Count for Complete Orders
	 *
	 * @return	void
	 */
	private function _remove_stocks($order_id)
	{
		// load reserve stock class
		$this->load->library('inventory/update_stocks');
		$this->load->library('orders/order_details');
		$this->load->library('email');

		// get order details to get the items ordered
		$order = $this->order_details->initialize(array('tbl_order_log.order_log_id'=>$order_id));

		foreach ($order->items() as $item)
		{
			// process inventory by removing from onorder and physical
			// items needed are prod_no, color_code, size, qty
			$this->load->library('inventory/update_stocks');
			$config['prod_sku'] = $item->prod_sku;
			$config['size'] = $item->size;
			$config['qty'] = $item->qty;
			$config['order_id'] = $order_id;
			$this->update_stocks->initialize($config);
			$this->update_stocks->remove();
		}

		$store_name = @$order->store_name ?: '';
		$username = ucwords(strtolower(@$order->firstname.' '.@$order->lastname));

		$email_message = '
			Dear '.$username.',
			<br /><br />
			Reference ID#: '.$order_id.'
			<br /><br />
			Your order is complete.<br />
			Thank you very much.
			<br /><br />
			<br />
			Best Regards<br />
			<br><br>
		';

		// send email to admin
		$this->email->from($this->webspace_details->info_email, $this->webspace_details->name);
		$this->email->to(@$order->email);
		$this->email->cc($this->webspace_details->info_email);
		$this->email->bcc($this->config->item('dev1_email')); // --> for debuggin purposes

		$this->email->subject('Your ORDER# '.$order_id);
		$this->email->message($email_message);

		if (ENVIRONMENT == 'development') // ---> used for development purposes
		{
			// we are unable to send out email in our dev environment
			// so we check on the email template instead.
			// just don't forget to comment these accordingly
			echo 'FROM: '.$this->webspace_details->info_email.'<br />';
			echo 'TO: '.@$order->email.'<br />';
			echo 'SUBJECT: '.'Your ORDER# '.$order_id.'<br /><br />';
			echo $email_message;
			echo '<br /><br />';

			//echo '<a href="'.site_url('shop/designers/'.$this->reference_designer).'">Continue...</a>';
			echo '<br /><br />';
			exit;
		}
		else @$this->email->send();
	}

	// --------------------------------------------------------------------

	/**
	 * Send Order Ancknowledgement Email
	 *
	 * @return	void
	 */
	private function _send_order_acknowledgement($order_id)
	{
		// load pertinent library/model/helpers
		$this->load->library('orders/order_details');
		$this->load->library('email');

		// initialize...
		$order = $this->order_details->initialize(array('tbl_order_log.order_log_id'=>$order_id));

		$store_name = @$order->store_name ?: '';
		$username = ucwords(strtolower(@$order->firstname.' '.@$order->lastname));

		$email_message = '
			Dear '.$username.',
			<br /><br />
			This is to acknowledge your order with reference ID#: '.$order_id.'
			<br /><br />
			Your order is being processed pending shipment.<br />
			We\'ll get back to you on concerns or when items are ready for shipment.
			<br /><br />
			<br />
			Best Regards<br />
			<br><br>
		';

		// send email to admin
		$this->email->from($this->webspace_details->info_email, $this->webspace_details->name);
		$this->email->to(@$order->email);
		$this->email->cc($this->webspace_details->info_email);
		$this->email->bcc($this->config->item('dev1_email')); // --> for debuggin purposes

		$this->email->subject('Your ORDER# '.$order_id);
		$this->email->message($email_message);

		if (ENVIRONMENT == 'development') // ---> used for development purposes
		{
			// we are unable to send out email in our dev environment
			// so we check on the email template instead.
			// just don't forget to comment these accordingly
			echo 'FROM: '.$this->webspace_details->info_email.'<br />';
			echo 'TO: '.@$order->email.'<br />';
			echo 'SUBJECT: '.'Your ORDER# '.$order_id.'<br /><br />';
			echo $email_message;
			echo '<br /><br />';

			//echo '<a href="'.site_url('shop/designers/'.$this->reference_designer).'">Continue...</a>';
			echo '<br /><br />';
			exit;
		}
		else @$this->email->send();
	}

	// ----------------------------------------------------------------------

}
