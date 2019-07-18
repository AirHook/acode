<?php
/**
 * This script sends out recent new items.
 * It is triggered when the number of new items added for a specific designer
 * reaches 10 via the add product / edit product detail admin program.
 * Thus, only one email of 10 new items (per designer basis) is sent out.
 */
 
/*
| ---------------------------------------------------------------
| Load core items and set some defaults
*/

	/*
	| ------------------------------------------------------------------------------
	| Shell command doesn't use the Global Variable like $_SERVER[]
	|
	| ----------------------------------
	| This serves as a class on its own
	| ----------------------------------
	*/
	
	ob_implicit_flush(); // ---> for debuggin purposes
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);
	//phpinfo();

	echo 'Start...<br />';
	$time_x = @time();
	
	if ($_SERVER['SERVER_NAME'] === 'localhost')
	{
		$host 	  = 'localhost';
		$username = 'shopseven';
		$password = '!@R00+@dm!N';
		$database = 'db_shopseven';
		
		define('SITE_URL','http://localhost/www/joetaveras/milan/');
		$host = $_SERVER['HTTP_HOST'];
		define('IMG_REPO_URL', "http://$host/www/joetaveras/milan/");
		define('IMG_REPO_URL_VAR', "../../milan/");
	}
	else
	{
		$host 	  = 'localhost';
		$username = 'shopseven';
		$password = '!@R00+@dm!N';
		$database = 'db_shopseven';
		
		define('SITE_URL','https://www.shop7thavenue.com/');
	}
	
	/*
	| ------------------------------------------------------------------------------
	| Connet to db
	*/
	echo 'Connect to database... ';
	$con = mysqli_connect($host, $username, $password, $database);
	// Check connection
	if (mysqli_connect_errno())
	{
		echo "Failed to connect to MySQL: " . mysqli_connect_error();
	}
	echo 'connected.<br />';
	
	/*
	| ------------------------------------------------------------------------------
	| Global constants
	*/
	define('SITE_NAME','Shop 7th Avanue');
	define('SITE_DOMAIN','www.shop7thavenue.com');
	define('INFO_EMAIL','help@shop7thavenue.com');
	define('DEV1_EMAIL','rsbgm@rcpixel.com');
	
	define('SINGLE_DESIGNER_SITE',FALSE); // ---> set TRUE for manufacturer sites
	define('DESIGNER',''); // ---> set designer name for url purposes when single_designer_site
	
	define('MAIN_BODY_TITLE', 'Users Sync to Odoo');
	define('FILE_NAME_EXT', pathinfo(__FILE__, PATHINFO_BASENAME));
	define('FILE_NAME', str_replace('.php', '', pathinfo(__FILE__, PATHINFO_BASENAME)));

/*
| ---------------------------------------------------------------
| Script
*/
	echo 'Processing...<br />';
	
	// Get status
	$get_config = get_config($con);
	$config_item = 'sync_wholesale_users_to_odoo';
	
	if ($get_config)
	{
		$sync_status = json_decode($get_config['config_value'], TRUE);
	}
	else
	{
		$sync_status = array(
			'status' => 0, // 0-incomplete, 1-complete, 2-pending
			'last_sync' => 0 // 0-begining, time()-as per time
		);
		$sync_status_j = json_encode($sync_status);
		
		$ins_config = "
			INSERT INTO config (config_name, config_value) 
			VALUES ('".$config_item."', '".$sync_status_j."')
		";
		$q_ins_config = mysqli_query($con, $ins_config) or die(
			'You have a MySQLi error at "'.pathinfo(__FILE__, PATHINFO_BASENAME).'" line '.__LINE__.':'
			.mysqli_error($con).'<br />'
			.$ins_config
		);
	}
	
	// at start of scipt, we set status to pending - 2
	$sync_status['status'] = 2;
	update_config($con, json_encode($sync_status));
	
	// get wholesale users list
	$list = "
		SELECT tbluser_data_wholesale.*, designer.designer, tbladmin_sales.admin_sales_id, tbladmin_sales.admin_sales_user, tbladmin_sales.admin_sales_lname, tbladmin_sales.admin_sales_email, xdate, visits FROM tbluser_data_wholesale LEFT JOIN designer ON ( CASE WHEN tbluser_data_wholesale.reference_designer = 'basixblacklabel' THEN designer.folder = tbluser_data_wholesale.reference_designer ELSE designer.url_structure = tbluser_data_wholesale.reference_designer END ) LEFT JOIN tbladmin_sales ON tbladmin_sales.admin_sales_email = tbluser_data_wholesale.admin_sales_email LEFT JOIN (select email, max(create_date) as xdate from tbl_login_detail_wholesale group by email) as ld on ld.email = tbluser_data_wholesale.email LEFT JOIN (SELECT email, COUNT(email) AS visits FROM tbl_login_detail_wholesale GROUP BY email) AS ldw on ldw.email = tbluser_data_wholesale.email ORDER BY xdate DESC
	";
	$q_list = mysqli_query($con, $list) or die(
		'You have a MySQLi error at "'.pathinfo(__FILE__, PATHINFO_BASENAME).'" line '.__LINE__.':'
		.mysqli_error($con).'<br />'
		.$list
	);
	
	if (mysqli_num_rows($q_list) > 0)
	{
		while ($row = mysqli_fetch_array($q_list, MYSQLI_ASSOC))
		{
			$post_ary_to_odoo['is_active'] = $row['is_active'];
			$post_ary_to_odoo['reference_designer'] = $row['reference_designer'];
			$post_ary_to_odoo['admin_sales_email'] = $row['admin_sales_email'];
			$post_ary_to_odoo['email'] = $row['email'];
			$post_ary_to_odoo['firstname'] = $row['firstname'];
			$post_ary_to_odoo['lastname'] = $row['lastname'];
			$post_ary_to_odoo['store_name'] = $row['store_name'];
			$post_ary_to_odoo['fed_tax_id'] = $row['fed_tax_id'];
			$post_ary_to_odoo['telephone'] = $row['telephone'];
			$post_ary_to_odoo['address1'] = $row['address1'];
			$post_ary_to_odoo['address2'] = $row['address2'];
			$post_ary_to_odoo['city'] = $row['city'];
			$post_ary_to_odoo['state'] = $row['state'];
			$post_ary_to_odoo['country'] = $row['country'];
			$post_ary_to_odoo['zipcode'] = $row['zipcode'];
			$post_ary_to_odoo['comments'] = $row['comments'];
			$post_ary_to_odoo['pword'] = $row['pword'];
			$post_ary_to_odoo['user_id'] = $row['user_id'];
			
			// pass to odoo
			$odoo_response = post_to_odoo($post_ary_to_odoo);
			
			// echo notice
			echo $row['store_name'].' - posted<br />';
			//echo '<pre>';
			//print_r($post_ary_to_odoo);
			//echo '</pre><br />';
			echo 'odoo response - '.$odoo_response.'<br />';
		}
		
		$list_processed = TRUE;
	}
	else $list_processed = FALSE;
	
	if ($list_processed)
	{
		// complete
		$sync_status['status'] = 1;
		update_config($con, json_encode($sync_status));
		echo 'Complete!<br />';
	}
	else echo 'Nothing processed...<br />';
	
/*
| ---------------------------------------------------------------
| Function details
*/
	function post_to_odoo(array $data = array())
	{
		// api url
		$_curlopt_url = 'http://70.32.74.131:8069/api/create/customers';

		// add api_key to data
		$data['client_api_key'] = 'uv2_Mqc0mLXgNIlqeZoGv4vncaOs0O2QVdVvjtYkurrthciGUsnL1ohDEvbQh2sFbWe8BSqJ5qf';
		
		// set post fields
		$post = $data;
		
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $_curlopt_url);
		curl_setopt($ch, CURLOPT_POST, TRUE);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
		// receive server response ...
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

		// execute
		$response = curl_exec($ch);
		$http_code = curl_getinfo($ch, CURLINFO_RESPONSE_CODE);
		
		// check for response errors
		if($response === false)
		{
			// check for internal server error
			if ($http_code == 500)
			{
				$this->error_message = 'Curl error: Internal Server Error';
				$response = 'Curl error: Internal Server Error';
			}
			else $this->error_message = 'Curl error: ' . curl_error($ch);
		}

		// close the connection, release resources used
		curl_close ($ch);
		
		return $response;
	}

	function update_config($con, $params)
	{
		$upd_config = "
			UPDATE config
			SET config_value = '".$params."'
			WHERE config_name = 'sync_vendor_users_to_odoo'
		";
		$q_upd_config = mysqli_query($con, $upd_config) or die(
			'You have a MySQLi error at "'.pathinfo(__FILE__, PATHINFO_BASENAME).'" line '.__LINE__.':'
			.mysqli_error($con).'<br />'
			.$upd_config
		);
		
		return;
	}
	
	function get_config($con)
	{
		$get_config = "
			SELECT *
			FROM config
			WHERE config_name = 'sync_vendor_users_to_odoo'
		";
		$q_get_config = mysqli_query($con, $get_config) or die(
			'You have a MySQLi error at "'.pathinfo(__FILE__, PATHINFO_BASENAME).'" line '.__LINE__.':'
			.mysqli_error($con).'<br />'
			.$get_config
		);
		
		if (mysqli_num_rows($q_get_config) > 0)
		{
			return mysqli_fetch_array($q_get_config, MYSQLI_ASSOC);
		}
		else return FALSE;
	}
	
	echo '<br />Done.';
	exit;