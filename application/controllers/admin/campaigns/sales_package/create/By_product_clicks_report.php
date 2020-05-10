<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class By_product_clicks_report extends Admin_Controller {

	/**
	 * DB Object
	 *
	 * @return	object
	 */
	protected $DB;

	// --------------------------------------------------------------------

	/**
	 * Constructor
	 *
	 * @return	void
	 */
	public function __construct()
	{
		parent::__construct();

		// connect to database for use by model
		$this->DB = $this->load->database('instyle', TRUE);
    }

	// ----------------------------------------------------------------------

	/**
	 * Index - Sales Package View
	 *
	 * Open and view existing sales package for edit/sending
	 *
	 * @return	void
	 */
	public function index()
	{
		$this->output->enable_profiler(FALSE);

		if ( ! $this->input->get('date') OR ! $this->input->get('user'))
		{
			// nothing more to do...
			echo 'no data';
			die();
		}

		// get user details
		$this->DB->query('SET SESSION group_concat_max_len = 1000000');
		$this->DB->select('GROUP_CONCAT(tbl_login_detail_wholesale.logindata) AS logindata');
		$this->DB->select('tbluser_data_wholesale.*');
		$this->DB->select('
			tbladmin_sales.admin_sales_id,
			tbladmin_sales.admin_sales_user,
			tbladmin_sales.admin_sales_lname
		');
		$this->DB->from('tbl_login_detail_wholesale');
		$this->DB->join(
			'tbluser_data_wholesale',
			'tbluser_data_wholesale.email = tbl_login_detail_wholesale.email',
			'left'
		);
		$this->DB->join(
			'tbladmin_sales',
			'tbladmin_sales.admin_sales_email = tbluser_data_wholesale.admin_sales_email',
			'left'
		);
		$this->DB->where('tbl_login_detail_wholesale.create_date', $this->input->get('date'));
		$this->DB->where('tbl_login_detail_wholesale.email', $this->input->get('user'));
		$q1 = $this->DB->get();

		//echo $this->DB->last_query(); die();

		$user_details = $q1->row();

		// decode and combine $logindata into one array
		// usual contents of $logindata are: 'active_time', 'page_visist', 'product_clicks'
		// finally, get the 'product_clicks'
		// sample combined/not combined product cliks array:
		/* *
		Array
		{
			[product_clicks] => Array
		        (
		            [5706P] => Array
		                (
		                    [0] => 1
		                    [1] => 1
		                )

		            [5565N] => Array
		                (
		                    [0] => 1
		                    [1] => 1
		                )

		            [1384N] => 1
		            [1154V] => 1
		            [4444P] => 1
		            [2546K] => 1
		            [8141F] => 1
		            [8488A] => 1
		            [1381A] => 1
		        )
		}
		// */
		$json_str = str_replace('},{', '}|{', $user_details->logindata);
		$json_arys = explode('|', $json_str);
		$logindata = array();
		foreach ($json_arys as $json)
		{
			$temp_ary = json_decode($json, TRUE);
			$logindata = is_array($temp_ary) ? array_merge_recursive($logindata, $temp_ary) : array_merge_recursive($logindata);
		}

		$sa_items = array();
		if ( ! empty(@$logindata['product_clicks']))
		{
			foreach ($logindata['product_clicks'] as $key => $val)
			{
				if ( ! is_int($key) OR ! in_array($key, $sa_items))
				{
					array_push($sa_items, $key);
				}
			}
		}

		// set data and insert into records
		$this_time = time();
		$post_ary['date_create'] = $this_time;
		$post_ary['last_modified'] = $this_time;
		$post_ary['sales_package_name'] = 'Product Clicks by '.$user_details->store_name;
		$post_ary['email_subject'] = 'Products of Interests';
		$post_ary['email_message'] = 'Here are designs that are now available. Review them for your store.';
		$post_ary['sales_user'] = $user_details->admin_sales_id;
		$post_ary['author'] = $user_details->admin_sales_user.' '.$user_details->admin_sales_lname;
		$options = array(
			'w_prices' => 'Y',
			'w_images' => 'N',
			'linesheets_only' => 'N',
			'des_slug' => $user_details->reference_designer
		);
		$post_ary['options'] = json_encode($options);
		$post_ary['sales_package_items'] = json_encode($sa_items);

		// update records
		$this->DB->set($post_ary);
		$q = $this->DB->insert('sales_packages');
		$insert_id = $this->DB->insert_id();

		// set flash data
		$this->session->set_flashdata('success', 'add');

		// redirect user
		redirect($this->config->slash_item('admin_folder').'campaigns/sales_package/send/index/'.$insert_id.'/'.$user_id, 'location');
	}

	// ----------------------------------------------------------------------

}
