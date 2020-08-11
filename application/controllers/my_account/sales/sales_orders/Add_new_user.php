<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Add_new_user extends MY_Controller {

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
	public function index()
	{
		$this->output->enable_profiler(FALSE);

		// load pertinent library/model/helpers
		$this->load->library('users/sales_user_details');

		// get sales user login details
		if ($this->session->admin_sales_loggedin)
		{
			$this->sales_user_details->initialize(
				array(
					'admin_sales_id' => $this->session->admin_sales_id
				)
			);
		}
		else
		{
			echo 'loggedout';
			exit;
		}

		/*
		Array
		(
		    [user_cat] => ws / cs
		    [reference_designer] => shop7thavenue
		    [admin_sales_email] => help@shop7thavenue.com
		    [admin_sales_id] => 1 (not present in cs)
		    [email] =>
		    [firstname] =>
		    [lastname] =>
		    [store_name] => /company
		    [fed_tax_id] => (not present in cs)
		    [telephone] =>
		    [address1] =>
		    [address2] =>
		    [city] =>
		    [state] => /state_province
		    [country] =>
		    [zipcode] => /zip_postcode
		)
		*/

		// grab post data
		$post_ary = array_filter($this->input->post());

		// process some fields
		$user_cat = $post_ary['user_cat'];
		unset($post_ary['user_cat']);
		$post_ary['create_date'] = date('Y-m-d', time());
		$post_ary['is_active'] = '1';
		$post_ary['active_date'] = date('Y-m-d', time());
		if ($user_cat == 'ws')
		{
			$db_table = 'tbluser_data_wholesale';
			$store_company_name = @$post_ary['store_name'];
			$post_ary['pword'] = 'shop7th';
			$state = $post_ary['state'];
			$zipcode = $post_ary['zipcode'];
		}
		if ($user_cat == 'cs')
		{
			$db_table = 'tbluser_data';
			$store_company_name =
				@$post_ary['company']
				?: $post_ary['firstname'].' '.$post_ary['lastname']
			;
			$post_ary['password'] = 'shop7th';
			$state = $post_ary['state_province'];
			$zipcode = $post_ary['zip_postcode'];
		}

		// connect and add record to database
		$DB = $this->load->database('instyle', TRUE);
		$query = $DB->insert($db_table, $post_ary);
		$insert_id = $DB->insert_id();

		$html = $store_company_name
			.'<br />'
			.$post_ary['address1']
			.'<br />'
			.(@$post_ary['address2'] ? $post_ary['address2'].'<br />' : '')
			.$post_ary['city'].', '.$state.' '.$zipcode
			.'<br />'
			.$post_ary['country']
			.'<br />'
			.$post_ary['telephone']
			.'<br />ATTN: '
			.$post_ary['firstname'].' '.$post_ary['lastname']
			.' ('.$post_ary['email'].')'
		;

		// set session
		$this->session->set_userdata('so_user_id', $insert_id);
		$this->session->set_userdata('so_user_cat', $user_cat);

		echo $html;
		exit;
	}

	// ----------------------------------------------------------------------

}
