<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * MY ACCOUNT Wholesale Orders Link Class
 *
 * This controller is accessed by a PAYMENT OPTIONS link provided in the
 * email sending of invoice to wholesale user so that when they click the
 * PAYMENT OPTIONS link in the email, the user is processed here,
 * authenticated, auto-loggedin, and then sent to the Orders Payment
 * Options page.
 *
 * @package		CodeIgniter
 * @subpackage	Controllers
 * @category	Wholesale My Account
 * @author		WebGuy
 * @link
 */
class Link extends Frontend_Controller
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
	 * Link
	 *
	 * Show the sales package items as thumbs page
	 */
	function index($order_id = '', $wholesale_user_id = '', $ts = '')
	{
		/* *
		Access Link looks like this:
		$data['access_link'] = site_url(
			'my_account/wholesale/orders/link/'
			.$order_id.'/'
			.$user_id.'/'
			.$ts	// md5 hashed timestamp
		);
		// */

		if (
			! $order_id
			OR ! $wholesale_user_id
			OR ! $ts
		)
		{
			// nothing more to do...
			// set flash data
			$this->session->set_flashdata('error', 'no_id_passed');

			// redirect user
			redirect('account', 'location');
		}

		// load pertinent library/model/helpers
		$this->load->library('user_agent');
		$this->load->library('sales_package/sales_package_details');
		$this->load->library('users/wholesale_user_details');
		$this->load->library('designers/designer_details');
		$this->load->library('categories/category_details');
		$this->load->helpers('metronic/create_category_treelist_helper');

		/****************
		 * Lets get the wholesale user details
		 */
		// check for logged in users and verify link user id
		if ($this->session->user_loggedin && $this->session->user_role === 'wholesale')
		{
			// logged in user
			// check if same user
			if ($this->session->user_id != $wholesale_user_id)
			{
				// set flash notice
				$this->session->set_flashdata('error', 'sa_diff_user_loggedin');

				// nothing more to do...
				redirect('account', 'location');
			}
		}
		else
		{
			// not logged in user
			// authenticate wholesale user
			if (
				! $this->wholesale_user_details->initialize(array('user_id'=>$wholesale_user_id))
			)
			{
				// set flash notice
				$this->session->set_flashdata('error', 'invalid_credentials');

				// nothing more to do...
				redirect('account', 'location');
			}
		}

		// global catch all for inactive wholeslae users
		if (@$this->wholesale_user_details->status != '1')
		{
			// set flash notice
			$this->session->set_flashdata('error', 'status_inactive');

			// send to request for activation page
			redirect('account/request/activation', 'location');
		}

		// auto sign in user if not already signed in
		// do notifications where necessary
		if ( ! $this->session->this_login_id)
		{
			// auto activate user if he clicks on the sales package
			//if ($this->wholesale_user_details->status != '1') $this->wholesale_user_details->activate_user();
			// set wholesale user session
			$this->wholesale_user_details->set_session();
			// record login details
			$this->wholesale_user_details->record_login_detail();

			if (ENVIRONMENT !== 'development')
			{
				// notify sales user
				$this->wholesale_user_details->notify_sales_user_online();
				// notify admin user is online
				$this->wholesale_user_details->notify_admin_user_online();
			}
		}

		// send user to payment options page
		redirect('my_account/wholesale/orders/payment_options/index/'.$order_id, 'location');
	}

	// --------------------------------------------------------------------

}
