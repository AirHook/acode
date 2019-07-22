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
			redirect($this->config->slash_item('admin_folder').'users/sales/csv', 'location');
		}
		
		// load pertinent library/model/helpers
		
		// let's grab the FILE array names
		$tempFile = $_FILES['file']['tmp_name']; // this also stores file object into a temporary variable
		$filename = $_FILES['file']['name'];
		
		if (empty($tempFile))
		{
			// nothing more to do...
			// set flash data
			$this->session->set_flashdata('error', 'no_id_passed');
			
			// redirect user
			redirect($this->config->slash_item('admin_folder').'users/sales/csv', 'location');
		}
		
		// let's read the temp filefirst to get the csv headers and check for authenticity
		$lines = file($tempFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
		
		// set headers to the csv file
		// (no momre page break '\r\n' at the end because the file() function has ignored the read already)
		// these headers are set via controllers/admin/users/sales/csv/Update_csv_file.php
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
		$headers = "Sales User ID,First Name,Last Name,Sales User Email,Reference Designer Slug,Access Level,Status";
		
		// exact comparison to ensure the same headers
		if ($lines[0] !== $headers) 
		{
			// nothing more to do...
			// set flash data
			$this->session->set_flashdata('error', 'csv_headers_error');
			
			// redirect user
			redirect($this->config->slash_item('admin_folder').'users/sales/csv');
		}
		
		// let us now set $key indeces as per database field names
		$fields = array('admin_sales_id', 'admin_sales_user', 'admin_sales_lname', 'admin_sales_email', 'admin_sales_designer', 'access_level', 'is_active');
		
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
		$new_table = 'tbladmin_sales_bak_'.time();
		
		// manual db manipulation
		$username = ENVIRONMENT === 'development' ? 'root' : 'shopseven';
		$password = ENVIRONMENT === 'development' ? 'root' : '!@R00+@dm!N';
		$database = 'db_shopseven'; 
		$con = mysqli_connect("localhost", $username, $password, $database);
		// backup table
		mysqli_query($con, "CREATE TABLE ".$new_table." LIKE tbladmin_sales"); // OR die(mysqli_error());
		mysqli_query($con, "INSERT INTO ".$new_table." SELECT * FROM tbladmin_sales"); // OR die(mysqli_error());
		// if backup table count is more than 5, remove some
		$res = mysqli_query($con, "SHOW TABLES FROM db_shopseven WHERE Tables_in_db_shopseven LIKE '%tbladmin_sales_bak_%'"); // OR die(mysqli_error());
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
			if (trim($user['admin_sales_id']) != '')
			{
				// update record
				$DB->set($user);
				$DB->where('admin_sales_id', $user['admin_sales_id']);
				$DB->update('tbladmin_sales');
			}
			else
			{
				// insert record
				if (trim($user['admin_sales_email']) != '')
				{
					// let's unset the field 'user_id' first
					unset($user['admin_sales_id']);
					$DB->set($user);
					$DB->insert('tbladmin_sales');
				}
			}
		}
		
		// set flash data
		$this->session->set_flashdata('success', 'csv_upload_update');
		
		// redirect user
		redirect($this->config->slash_item('admin_folder').'users/sales/csv', 'location');
	}
	
	// ----------------------------------------------------------------------
	
}
