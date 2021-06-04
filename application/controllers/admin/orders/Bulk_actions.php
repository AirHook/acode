<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Bulk_actions extends Admin_Controller {

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
	 * Index - Bulk Actions
	 *
	 * Execute actions selected on bulk action dropdown to multiple selected
	 * sales pakcages
	 *
	 * @return	void
	 */
	public function index()
	{
		echo 'Processing bulk...';

		// connect to database
		$DB = $this->load->database('instyle', TRUE);

		// set database set clause based on bulk_action for activate and suspend
		switch ($this->input->post('bulk_action'))
		{
			case 'pe':
				$DB->set('status', '0');
				$DB->set('remarks', '0');
			break;
			case 'ho':
				$DB->set('status', '2');
				$DB->set('remarks', '0');
			break;
			case 'ca':
				// process inventory count
				// return stocks
				$DB->set('status', '3');
				$DB->set('remarks', '0');
			break;
			case 're':
				// process inventory count
				// return stocks
				$DB->set('status', '4');
				$DB->set('remarks', '0');
			break;
			case 'ac':
				// to acknowledge an order is to indicate it is shipment_pending
				// this will send an email to user about the order pending shipment
				$DB->set('status', '5');
				$DB->set('remarks', '0');
			break;
			case 'cr':
				// process inventory count
				// return stocks
				$DB->set('status', '6');
				$DB->set('remarks', '0');
			break;
			case 'co':
				// this will process inventory count
				$DB->set('status', '1');
				$DB->set('remarks', '0');
			break;
		}

		// update or delete items from database
		if ($this->input->post('bulk_action') === 'del')
		{
			// iterate through the selected checkboxes and where clause
			foreach ($this->input->post('checkbox') as $key => $id)
			{
				if ($key === 0) $DB->where('order_log_id', $id);
				else $DB->or_where('order_log_id', $id);
			}

			// delete main order log
			$DB->delete('tbl_order_log');

			// iterate through the selected checkboxes and where clause
			foreach ($this->input->post('checkbox') as $key => $id)
			{
				if ($key === 0) $DB->where('order_log_id', $id);
				else $DB->or_where('order_log_id', $id);
			}

			// we need to delete the transaction records as well
			$DB->delete('tbl_order_log_details');

			// set flash data
			$this->session->set_flashdata('success', 'delete');
		}
		else
		{
			// iterate through the selected checkboxes
			foreach ($this->input->post('checkbox') as $key => $id)
			{
				if ($key === 0) $DB->where('order_log_id', $id);
				else $DB->or_where('order_log_id', $id);
			}

			// update main order log
			$DB->update('tbl_order_log');

			// this iteration is for updating stocks
			// we need to separate from above iteration
			// to avoid db cross processing conflict
			// setting a time to start this where previous orders will not affect stocks
			if (time() > strtotime('2020-02-28'))
			{
				foreach ($this->input->post('checkbox') as $key => $id)
				{
					if ($this->input->post('bulk_action') == 'ac') $this->_send_order_acknowledgement($id);
					if ($this->input->post('bulk_action') == 'co')
					{
						$this->_remove_stocks($id);
						// send order complete notification
						$this->_send_order_complete_notification($id);
					}
					if (
						$this->input->post('bulk_action') == 'ca'
						OR $this->input->post('bulk_action') == 're'
						OR $this->input->post('bulk_action') == 'cr'
					)
					{
						// return stocks
						$this->_return_stocks($id, $this->input->post('bulk_action'));
					}
				}
			}

			// set flash data
			$this->session->set_flashdata('success', 'edit');
		}

		// redirect user
		if ($this->input->post('status'))
		{
			redirect('admin/orders/'.$this->input->post('status'), 'location');
		}
		else redirect($this->config->slash_item('admin_folder').'orders', 'location');
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

		//modified by _noel(20210529)
		foreach ($order->items() as $item)
		//foreach ($order->order_items as $item)
		{
			$item_options = json_decode($item->options, TRUE);
			// process inventory by removing from onorder and physical
			// items needed are prod_no, color_code, size, qty
			$this->load->library('inventory/update_stocks');
			$config['prod_sku'] = $item->prod_sku;
			$config['size'] = $item->size;
			$config['qty'] = $item->qty;
			$config['order_id'] = $order_id;
			if (array_key_exists('admin_stocks_only',$item_options))
				$config['admin_stocks'] = $item_options['admin_stocks_only'];
			$this->update_stocks->initialize($config);
			$this->update_stocks->return();
		}

		// turning OFF notifications for now
		/* *
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
		// */
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
		//modified by _noel(20210529)
		foreach ($order->items() as $item)
		//foreach ($order->order_items as $item)
		{
			// process inventory by removing from onorder and physical
			// items needed are prod_no, color_code, size, qty
			$item_options = json_decode($item->options, TRUE);
			$this->load->library('inventory/update_stocks');
			$config['prod_sku'] = $item->prod_sku;
			$config['size'] = $item->size;
			$config['qty'] = $item->qty;
			$config['order_id'] = $order_id;
			if (array_key_exists('admin_stocks_only',$item_options))
				$config['admin_stocks'] = $item_options['admin_stocks_only'];
			$this->update_stocks->initialize($config);
			$this->update_stocks->remove();
		}

		// turning OFF notifications for now
		/* *
		$store_name = $order->store_name ?: '';
		$username = ucwords(strtolower($order->firstname.' '.$order->lastname));

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
		// */
	}

	// --------------------------------------------------------------------

	/**
	 * Send Order Ancknowledgement Email
	 *
	 * @return	void
	 */
	public function _send_order_acknowledgement($order_id)
	{
		// load pertinent library/model/helpers
		$this->load->library('orders/order_details');
		$this->load->library('email');

		// initialize...
		$order = $this->order_details->initialize(array('tbl_order_log.order_log_id'=>$order_id));

		// turning OFF notifications for now
		/* *
		$store_name = $order->store_name ?: '';
		$username = ucwords(strtolower($order->firstname.' '.$order->lastname));

		$email_message = '
			Dear '.$username.',
			<br /><br />
			This is to acknowledge your order with reference ID#: '.$order_id.'
			<br /><br />
			Your order is being processed pending shipment.<br />
			We\'ll get back to you once ready for shipment.
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
			//exit;
		}
		else @$this->email->send();
		// */
	}

	// --------------------------------------------------------------------

	/**
	 * Send Order Ancknowledgement Email
	 *
	 * @return	void
	 */
	private function _send_order_complete_notification($order_id)
	{
		// load pertinent library/model/helpers
		$this->load->library('orders/order_details');
		$this->load->library('email');
		$this->load->library('users/wholesale_user_details');
		$this->load->library('users/consumer_user_details');

		// initialize...
		$order = $this->order_details->initialize(array('tbl_order_log.order_log_id'=>$order_id));

		// based on order details, get user details
		if ($order->c == 'ws')
		{
			$user_details =
				$this->wholesale_user_details->initialize(
					array(
						'user_id' => $order->user_id
					)
				)
			;
		}
		else
		{
			$user_details =
				$this->consumer_user_details->initialize(
					array(
						'user_id' => $order->user_id
					)
				)
			;
		}

		if ($this->webspace_details->slug == 'tempoparis')
		{
			// notify user
			/* */
			$store_name = @$order->store_name ?: '';
			$username = ucwords(strtolower(@$order->firstname.' '.@$order->lastname));

			// check for tracking number
			$tracking_number =  @$order->options['tracking_number'] ?: '';
			$courier = @$order->courier ?: '';

			$email_message = '
				Dear '.$username.',
				<br /><br />
				Your order with reference ORDER ID#: '.$order_id.' has been SHIPPED!'
				.($tracking_number ? '<br />Tracking #: '.$tracking_number : '')
				.($courier ? '<br />Courier: '.$courier : '')
				.'<br /><br />
				<br /><br />
				<br />
				Best Regards<br />
				<br><br>
			';

			// send to email - user
			// but for tempo, we send to rafi only for now
			if ($this->webspace_details->slug == 'tempoparis')
			{
				$send_to_email = $this->webspace_details->info_email;
				$cc_email = '';
			}
			else
			{
				$send_to_email = $user_details->email;
				$cc_email = $this->webspace_details->info_email;
			}

			// send email to admin
			$this->email->from($this->webspace_details->info_email, $this->webspace_details->name);
			$this->email->to($send_to_email);
			if ($cc_email) $this->email->cc($cc_email);
			$this->email->bcc($this->config->item('dev1_email')); // --> for debuggin purposes

			$this->email->subject('Your ORDER# '.$order_id.' has SHIPPED');
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
			// */
		}
	}

	// ----------------------------------------------------------------------

}
