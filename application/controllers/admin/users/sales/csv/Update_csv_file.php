<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Update_csv_file extends MY_Controller {

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
	 * Index Page for this controller.
	 *
	 * @return	void
	 */
	public function index()
	{
		// update csv file
		$this->csv();
		
		// set flash data
		$_SESSION['success'] = 'csv_update';
		$this->session->mark_as_flash('success');
		
		// redirect user
		redirect('admin/users/sales/csv');
	}
	
	// ----------------------------------------------------------------------
	
	/**
	 * Index Page for this controller.
	 *
	 * @return	void
	 */
	public function csv()
	{
		// load pertinent library/model/helpers
		$this->load->library('users/sales_users_list_csv');

		// get data
		// check if not hub site, just get satellite or stand alone site's list of users
		// else, get all
		if (
			@$this->webspace_details->options['site_type'] == 'sat_site'
			OR @$this->webspace_details->options['site_type'] == 'sal_site'
		)
		{
			$params = array(
				'tbladmin_sales.admin_sales_designer' => $this->webspace_details->slug
			);
			$filename_suffix = $this->webspace_details->slug;
		}
		else 
		{
			$params = array();
			$filename_suffix = $this->webspace_details->slug.'_hub_site';
		}
		$users = $this->sales_users_list_csv->select($params, array('admin_sales_id'=>'ASC'));
		
		// get vital info for path purposes
		$path = './csv/users/';
		$filename = 'users_sales_'.$filename_suffix;
		$file = $path.$filename.'.csv';
		
		// craete directory where necessary
		if ( ! file_exists($path))
		{
			$old = umask(0);
			if ( ! mkdir($path, 0777, TRUE)) 
			{
				echo 'Unable to create "'.$path.'" folder.<br />';
				exit;
			}
			umask($old);
		}
		
		if ($this->sales_users_list_csv->row_count > 0)
		{
			// set headers to the csv file
			// (note the page break '\r\n' at the end is important!)
			// user below carriage returned list to compare and count info
			/*
				Sales User ID,
				First Name,
				Last Name,
				Sales User Email,
				Reference Designer Slug,
				Access Level,
				Status
			*/
			$content = "Sales User ID,First Name,Last Name,Sales User Email,Reference Designer Slug,Access Level,Status\r\n";
			
			// write the contents to the end of the file
			$file_handle = @fopen($file, 'wb');
			fwrite($file_handle, $content);
			fclose($file_handle);
			
			foreach ($users as $user)
			{
				// set content and append to the csv file
				// we need to convert the object to array
				$content = array(
					$user->admin_sales_id, 
					$user->admin_sales_user, 
					$user->admin_sales_lname, 
					$user->admin_sales_email, 
					$user->admin_sales_designer, 
					$user->access_level, 
					$user->is_active
				);
				
				// write the contents to the end of the file
				$file_handle = @fopen($file, 'a');
				fputcsv($file_handle, $content);
			}
		}
		
		fclose($file_handle);
	}
	
	// ----------------------------------------------------------------------
	
}
