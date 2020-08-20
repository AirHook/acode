<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Payment_options extends Wholesale_user_Controller {

	/**
	 * DB Object
	 *
	 * @var	object
	 */
	protected $DB;

	/**
	 * Constructor
	 *
	 * @return	void
	 */
	public function __construct()
	{
		parent::__construct();

		// connect to database
		$this->DB = $this->load->database('instyle', TRUE);

		// load pertinent library/model/helpers
		$this->load->library('designers/designer_details');
		$this->load->library('products/size_names');
		$this->load->library('products/product_details');
		$this->load->library('orders/order_details');
		$this->load->library('users/wholesale_user_details');
		$this->load->library('users/sales_user_details');
		$this->load->library('barcodes/upc_barcodes');
    }

	// ----------------------------------------------------------------------

	/**
	 * Index - default method
	 *
	 * Purchase Order Details
	 *
	 * @return	void
	 */
	public function index($order_id = '')
	{
		if ( ! $order_id)
		{
			// nothing more to do...
			// set flash data
			$this->session->set_flashdata('error', 'no_id_passed');

			// redirect user
			redirect('my_account/wholesale/orders');
		}

		// generate the plugin scripts and css
		$this->_create_plugin_scripts();

		// get order details
		$this->data['order_details'] =
			$this->order_details->initialize(
				array(
					'tbl_order_log.order_log_id' => $order_id
				)
			)
		;

		// other data
		$this->data['status'] = $this->order_details->status_text;

		// need to show loading at start
		$this->data['show_loading'] = FALSE;

		// set data variables...
		$this->data['role'] = 'wholesale'; //userrole will be used for IF statements in template files
		$this->data['file'] = '../my_account/order_payment_options';
		$this->data['page_title'] = 'Order Details';
		$this->data['page_description'] = 'Details of the order transaction';

		// load views...
		$this->load->view('metronic/template/template', $this->data);
	}

	// ----------------------------------------------------------------------

	/**
	 * Set Payment Option to PAYPAL
	 *
	 * @return	void
	 */
	public function paypal($order_id = '')
	{
		if ( ! $order_id)
		{
			// nothing more to do...
			// set flash data
			$this->session->set_flashdata('error', 'no_id_passed');

			// redirect user
			redirect('my_account/wholesale/orders', 'location');
		}

		// get order details
		$order_details =
			$this->order_details->initialize(
				array(
					'tbl_order_log.order_log_id' => $order_id
				)
			)
		;

		// get the order options
		$options = $order_details->options;

		// set/modify payment_method
		$options['payment_method'] = 'Paypal';
		$options['payment_option'] = 'pp';

		// update records
		$this->DB->set('options', json_encode($options));
		$this->DB->set('status', '7');
		$this->DB->where('order_log_id', $order_id);
		$this->DB->update('tbl_order_log');

		// notify admin
		$this->_notify_admin('pp', $order_id);

		// set flash data
		$this->session->set_flashdata('success', 'paypal_payment_option');

		// redirect user
		redirect('my_account/wholesale/orders/payment_options/index/'.$order_id, 'location');
	}

	// ----------------------------------------------------------------------

	/**
	 * Set Payment Option to PAYPAL
	 *
	 * @return	void
	 */
	public function credit_card($order_id = '')
	{
		if ( ! $order_id)
		{
			// nothing more to do...
			// set flash data
			$this->session->set_flashdata('error', 'no_id_passed');

			// redirect user
			redirect('my_account/wholesale/orders', 'location');
		}

		// get order details
		$order_details =
			$this->order_details->initialize(
				array(
					'tbl_order_log.order_log_id' => $order_id
				)
			)
		;

		// get the order options
		$options = $order_details->options;

		// set/modify payment_method
		$options['payment_method'] = 'Credit Card';
		$options['payment_option'] = 'cc';

		// update records
		$this->DB->set('options', json_encode($options));
		$this->DB->set('status', '7');
		$this->DB->where('order_log_id', $order_id);
		$this->DB->update('tbl_order_log');

		// notify admin
		$this->_notify_admin('cc', $order_id);

		// set flash data
		$this->session->set_flashdata('success', 'paypal_payment_option');

		// redirect user
		redirect('my_account/wholesale/orders/payment_options/index/'.$order_id, 'location');
	}

	// ----------------------------------------------------------------------

	/**
	 * Set Payment Option to WIRE TRANSFER
	 *
	 * @return	void
	 */
	public function wire_transfer($order_id = '')
	{
		if ( ! $order_id)
		{
			// nothing more to do...
			// set flash data
			$this->session->set_flashdata('error', 'no_id_passed');

			// redirect user
			redirect('my_account/wholesale/orders');
		}

		// get order details
		$order_details =
			$this->order_details->initialize(
				array(
					'tbl_order_log.order_log_id' => $order_id
				)
			)
		;

		// get the order options
		$options = $order_details->options;

		// set/modify payment_method
		$options['payment_method'] = 'Wire Transfer';
		$options['payment_option'] = 'wt';

		// update records
		$this->DB->set('options', json_encode($options));
		$this->DB->set('status', '7');
		$this->DB->where('order_log_id', $order_id);
		$this->DB->update('tbl_order_log');

		// notify admin
		$this->_notify_admin('wt', $order_id);

		// set flash data
		$this->session->set_flashdata('success', 'wire_transfer_payment_option');

		// redirect user
		redirect('my_account/wholesale/orders/payment_options/index/'.$order_id, 'location');
	}

	// ----------------------------------------------------------------------

	/**
	 * PRIVATE - Notify Admin of Payment Option
	 *
	 * @return	void
	 */
	public function _notify_admin($payment_option_code, $order_id)
	{
		/* */
		switch ($payment_option_code)
		{
			case 'pp':
				$opt = 'PAYPAL';
				$txt = 'Please send user a Paypal Invoice.';
				$det = FALSE;
			break;
			case 'wt':
				$opt = 'WIRE TRANSFER';
				$txt = 'Please send user the Bank Details for the wire transfer.';
				$det = FALSE;
			break;
			case 'cc':
				$opt = 'CREDIT CARD';
				$txt = 'Details:<br />'
					.'Credit Card Type: '.$this->input->post('creditCardType').'<br />'
					.'Credit Card Number: '.$this->input->post('creditCardNumber').'<br />'
					.'Credit Card Expiration: '.$this->input->post('creditCardExpirationMonth').'/'.$this->input->post('creditCardExpirationYear').'<br />'
					.'Credit Card Security Code: '.$this->input->post('creditCardSecurityCode')
				;
				$det = TRUE;
			break;
		}

		$email_message = '
			Dear Admin,
			<br /><br />
			Reference ORDER#: '.$order_id.'
			<br /><br />
			Payment Option: '
			.$opt
			.'<br /><br />'
			.$txt
		;

		// send email to admin
		$this->load->library('email');
		$this->email->from($this->wholesale_user_details->email, $this->wholesale_user_details->store_name);
		$this->email->to($this->webspace_details->info_email);
		$this->email->bcc($this->config->item('dev1_email')); // --> for debuggin purposes

		$this->email->subject('Payment Option for ORDER# '.$order_id);
		$this->email->message($email_message);

		if (ENVIRONMENT == 'development') // ---> used for development purposes
		{
			// we are unable to send out email in our dev environment
			// so we check on the email template instead.
			// just don't forget to comment these accordingly
			echo 'FROM: ('.$this->wholesale_user_details->email.') '.$this->wholesale_user_details->store_name.'<br />';
			echo 'TO: '.$this->webspace_details->info_email.'<br />';
			echo 'SUBJECT: '.'Payment Option for ORDER# '.$order_id.'<br /><br />';
			echo $email_message;
			echo '<br /><br />';

			echo '<a href="'.site_url('my_account/wholesale/orders/details/index/'.$order_id).'">Continue...</a>';
			echo '<br /><br />';
			exit;
		}
		else @$this->email->send();
		// */
	}

	// ----------------------------------------------------------------------

	/**
	 * PRIVATE - Create Plugin Scripts and CSS for the page
	 *
	 * @return	void
	 */
	private function _create_plugin_scripts()
	{
		$assets_url = base_url('assets/metronic');

		/****************
		 * page styles plugins inserted at <head>
		 * after global mandatory styles, before theme global styles
		 */
		$this->data['page_level_styles_plugins'] = '';

			// ladda - show loading or progress bar on buttons
			$this->data['page_level_styles_plugins'].= '
				<link href="'.$assets_url.'/assets/global/plugins/ladda/ladda-themeless.min.css" rel="stylesheet" type="text/css" />
			';
			// bootstrap select
			$this->data['page_level_styles_plugins'].= '
				<link href="'.$assets_url.'/assets/global/plugins/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
				<link href="'.$assets_url.'/assets/global/plugins/select2/css/select2-bootstrap.min.css" rel="stylesheet" type="text/css" />
				<link href="'.$assets_url.'/assets/global/plugins/bootstrap-select/css/bootstrap-select.min.css" rel="stylesheet" type="text/css" />
			';

		/****************
		 * page style sheets inserted at <head>
		 */
		$this->data['page_level_styles'] = '
		';

		/****************
		 * page js plugins inserted at <bottom>
		 * after core plugins, before global scripts
		 */
		$this->data['page_level_plugins'] = '';

			// ladda - show loading or progress bar on buttons
			$this->data['page_level_plugins'].= '
				<script src="'.$assets_url.'/assets/global/plugins/ladda/spin.min.js" type="text/javascript"></script>
				<script src="'.$assets_url.'/assets/global/plugins/ladda/ladda.min.js" type="text/javascript"></script>
			';
			// bootstrap select
			$this->data['page_level_plugins'].= '
				<script src="'.$assets_url.'/assets/global/plugins/select2/js/select2.full.min.js" type="text/javascript"></script>
				<script src="'.$assets_url.'/assets/global/plugins/bootstrap-select/js/bootstrap-select.min.js" type="text/javascript"></script>
			';
			// form validation
			$this->data['page_level_plugins'].= '
				<script src="'.$assets_url.'/assets/global/plugins/jquery-validation/js/jquery.validate.min.js" type="text/javascript"></script>
				<script src="'.$assets_url.'/assets/global/plugins/jquery-validation/js/additional-methods.min.js" type="text/javascript"></script>
			';

		/****************
		 * page scripts inserted at <bottom>
		 * after global scripts, before theme layout scripts
		 */
		$this->data['page_level_scripts'] = '';

			// button spinners for ladda
			$this->data['page_level_scripts'].= '
				<script src="'.$assets_url.'/assets/pages/scripts/ui-buttons-spinners.min.js" type="text/javascript"></script>
			';
			// handle bootstrap select - make select class '.bs-select' a boostrap select picker
			$this->data['page_level_scripts'].= '
				<script src="'.$assets_url.'/assets/pages/scripts/components-bootstrap-select.min.js" type="text/javascript"></script>
			';
			// handle page scripts
			$this->data['page_level_scripts'].= '
				<script src="'.base_url().'assets/custom/js/metronic/pages/scripts/wholesale-payment-options.js" type="text/javascript"></script>
			';
	}

	// ----------------------------------------------------------------------

}
