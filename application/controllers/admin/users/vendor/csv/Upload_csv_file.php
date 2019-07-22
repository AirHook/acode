<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Upload_csv_file extends MY_Controller {

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
		if (empty($_FILES))
		{
			// nothing more to do...
			// set flash data
			$this->session->set_flashdata('error', 'no_id_passed');
			
			// redirect user
			redirect($this->config->slash_item('admin_folder').'users/vendor/csv', 'location');
		}
		
		// load pertinent library/model/helpers
		$this->load->library('users/vendor_types_list');
		
		// let's grab the FILE array names
		$tempFile = $_FILES['file']['tmp_name']; // this also stores file object into a temporary variable
		$filename = $_FILES['file']['name'];
		
		if (empty($tempFile))
		{
			// nothing more to do...
			// set flash data
			$this->session->set_flashdata('error', 'no_id_passed');
			
			// redirect user
			redirect($this->config->slash_item('admin_folder').'users/vendor/csv', 'location');
		}
		
		// let's read the temp filefirst to get the csv headers and check for authenticity
		$lines = file($tempFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
		
		// set headers to the csv file
		// (no momre page break '\r\n' at the end because the file() function has ignored the read already)
		// these headers are set via controllers/admin/users/vendor/csv/Update_csv_file.php
		// user below carriage returned list to compare and count info
		/*
			Vendor ID,
			Vendor Name,
			Vendor Email,
			Vendor Code,
			Vendor Type Slug,
			Reference Designer Slug,
			Contact 1,
			Contact Email 1,
			Contact 2,
			Contact Email 2,
			Contact 3,
			Contact Email 3,
			Address1,
			Address2,
			City,
			State,
			Country,
			Zipcode,
			Telephone,
			Fax,
			Status
		*/
		$headers = "Vendor ID,Vendor Name,Vendor Email,Vendor Code,Vendor Type Slug,Reference Designer Slug,Contact 1,Contact Email 1,Contact 2,Contact Email 2,Contact 3,Contact Email 3,Address1,Address2,City,State,Country,Zipcode,Telephone,Fax,Status";
		
		// exact comparison to ensure the same headers
		if ($lines[0] !== $headers) 
		{
			// nothing more to do...
			// set flash data
			$this->session->set_flashdata('error', 'csv_headers_error');
			
			// redirect user
			redirect($this->config->slash_item('admin_folder').'users/vendor/csv');
		}
		
		// let us now set $key indeces as per database field names
		$fields = array('vendor_id', 'vendor_name', 'vendor_email', 'vendor_code', 'vendor_type_slug', 'reference_designer', 'contact_1', 'contact_email_1', 'contact_2', 'contact_email_2', 'contact_3', 'contact_email_3', 'address1', 'address2', 'city', 'state', 'country', 'zipcode', 'telephone', 'fax', 'is_active');
		
		// parse CSV file into array
		$csv_ary = array_map('str_getcsv', $lines);
		array_walk(
			$csv_ary, 
			function(&$ary_value) use ($fields) 
			{
				// in case data is corrupted, 
				// we only save rows with equal elements as fields
				if (count($fields) == count($ary_value))
				{
					$ary_value = array_combine($fields, $ary_value);
				}
			}
		);
		array_shift($csv_ary); # remove column header
		
		// let us do a table backup for restore purposes
		// create backup table with timestamp as suffix
		$new_table = 'vendors_bak_'.time();
		
		// manual db manipulation
		$username = ENVIRONMENT === 'development' ? 'root' : 'shopseven';
		$password = ENVIRONMENT === 'development' ? 'root' : '!@R00+@dm!N';
		$database = 'db_shopseven'; 
		$con = mysqli_connect("localhost", $username, $password, $database);
		// backup table
		mysqli_query($con, "CREATE TABLE ".$new_table." LIKE vendors"); // OR die(mysqli_error());
		mysqli_query($con, "INSERT INTO ".$new_table." SELECT * FROM vendors"); // OR die(mysqli_error());
		// if backup table count is more than 5, remove some
		$res = mysqli_query($con, "SHOW TABLES FROM db_shopseven WHERE Tables_in_db_shopseven LIKE '%vendors_bak_%'"); // OR die(mysqli_error());
		if (mysqli_num_rows($res) > 5)
		{
			$cnt = mysqli_num_rows($res) - 5;
			$i = 0;
			while ($row = mysqli_fetch_array($res))
			{
				//echo $row['Tables_in_db_shopseven'].'<br />';
				mysqli_query($con, "DROP TABLE ".$row['Tables_in_db_shopseven']); // OR die(mysqli_error());
				$i++;
				if ($i == $cnt) break;
			}
		}
		mysqli_close($con);
		
		// time to update records
		// connect to database
		$DB = $this->load->database('instyle', TRUE);
		
		foreach ($csv_ary as $user)
		{
			// we need to fix scientific notations for field 'telephone'
			// usually converted by exel software
			$user['telephone'] = $user['telephone'] - 0;
			
			// convert vendor type slug to vendor type id
			$user['vendor_type_id'] = $this->vendor_types_list->get_vendor_id($user['vendor_type_slug']);
			unset($user['vendor_type_slug']);
			
			if (trim($user['vendor_id']) != '')
			{
				// update record
				$DB->set($user);
				$DB->where('vendor_id', $user['vendor_id']);
				$DB->update('vendors');
			}
			else
			{
				// insert record
				if (trim($user['email']) != '')
				{
					// let's unset the field 'user_id' first
					unset($user['vendor_id']);
					$DB->set($user);
					$DB->insert('vendors');
				}
			}
		}
		
		// set flash data
		$this->session->set_flashdata('success', 'csv_upload_update');
		
		// redirect user
		redirect($this->config->slash_item('admin_folder').'users/vendor/csv', 'location');
	}
	
	// ----------------------------------------------------------------------
	
}
