<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Submit extends CI_Controller {

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
	
	public function index()
	{
		// connect to database
		$DB = $this->load->database('instyle', TRUE);
		
		// process record
		$acc_post_ary = $this->input->post();
		$web_post_ary = $this->input->post();
		$admin_post_ary = $this->input->post();
		// set necessary variables
		$acc_post_ary['last_modified'] = time();
		// unset unneeded variables
		unset($acc_post_ary['webspace_name']);
		unset($acc_post_ary['domain_name']);
		unset($acc_post_ary['webspace_slug']);
		unset($acc_post_ary['info_email']);
		unset($acc_post_ary['rpassword']);
		unset($acc_post_ary['site_type']);
		
		// add records
		$DB->set($acc_post_ary);
		$q = $DB->insert('accounts');
		$insert_id = $DB->insert_id();
		
		// set necessary variables
		$web_post_ary['account_id'] = $insert_id;
		$web_post_ary['webspace_status'] = '1';
		$web_post_ary['site_title'] = $web_post_ary['webspace_name'];
		$web_post_ary['site_tagline'] = $web_post_ary['webspace_name'];
		$web_post_ary['site_keywords'] = $web_post_ary['webspace_name'];
		$web_post_ary['site_description'] = $web_post_ary['webspace_name'];
		$web_post_ary['site_alttags'] = $web_post_ary['webspace_name'];
		$web_post_ary['site_footer'] = $web_post_ary['webspace_name'];
		$wbspace_options['last_modified'] = time();
		$wbspace_options['site_type'] = $web_post_ary['site_type'];
		$web_post_ary['webspace_options'] = json_encode($wbspace_options);
		// unset unneeded variables
		unset($web_post_ary['industry']);
		unset($web_post_ary['account_status']);
		unset($web_post_ary['company_name']);
		unset($web_post_ary['owner_name']);
		unset($web_post_ary['owner_email']);
		unset($web_post_ary['address1']);
		unset($web_post_ary['address2']);
		unset($web_post_ary['city']);
		unset($web_post_ary['state']);
		unset($web_post_ary['country']);
		unset($web_post_ary['zip']);
		unset($web_post_ary['phone']);
		unset($web_post_ary['password']);
		unset($web_post_ary['rpassword']);
		unset($web_post_ary['site_type']);
		
		// add records
		$DB->set($web_post_ary);
		$q = $DB->insert('webspaces');
		
		// set necessary variables
		$admin_post_ary['admin_name'] = 'admin';
		$admin_post_ary['admin_password'] = $admin_post_ary['password'];
		$admin_post_ary['admin_email'] = $admin_post_ary['owner_email'];
		$exp = explode(' ', $admin_post_ary['owner_name']);
		$admin_post_ary['fname'] = $exp[0];
		$admin_post_ary['lname'] = @$exp[1] ?: $exp[0];
		$admin_post_ary['account_id'] = $insert_id;
		$admin_post_ary['is_active'] = '1';
		$admin_post_ary['access_level'] = '1';
		// unset unneeded variables
		unset($admin_post_ary['industry']);
		unset($admin_post_ary['account_status']);
		unset($admin_post_ary['company_name']);
		unset($admin_post_ary['owner_name']);
		unset($admin_post_ary['owner_email']);
		unset($admin_post_ary['address1']);
		unset($admin_post_ary['address2']);
		unset($admin_post_ary['city']);
		unset($admin_post_ary['state']);
		unset($admin_post_ary['country']);
		unset($admin_post_ary['zip']);
		unset($admin_post_ary['phone']);
		unset($admin_post_ary['password']);
		unset($admin_post_ary['rpassword']);
		unset($admin_post_ary['webspace_name']);
		unset($admin_post_ary['domain_name']);
		unset($admin_post_ary['webspace_slug']);
		unset($admin_post_ary['info_email']);
		unset($admin_post_ary['site_type']);
		
		// in anticipation of cross webspace/website admin user especially
		// super admin, we add new 'admin' user if not existing
		$this->load->library('users/admin_user_details');
		if ( ! $this->admin_user_details->initialize(array('admin_name'=>'admin','admin_email'=>$admin_post_ary['admin_email'])))
		{
			// add records
			$DB->set($admin_post_ary);
			$q = $DB->insert('tbladmin');
		}
		
		/***********
		 * At this point, we either auto login the user to the admin so they can be
		 * notified with the things that need be done to complete setup of website.
		 * Or, simply redirect to main website that should still be in a 
		 * Coming Soon page.
		 */
		redirect(site_url());
		//redirect($this->config->item('admin_folder'));
	}
	
	// ----------------------------------------------------------------------
	
}
