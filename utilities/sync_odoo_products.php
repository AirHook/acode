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

	define('MAIN_BODY_TITLE', 'Product Sync to Odoo');
	define('FILE_NAME_EXT', pathinfo(__FILE__, PATHINFO_BASENAME));
	define('FILE_NAME', str_replace('.php', '', pathinfo(__FILE__, PATHINFO_BASENAME)));

/*
| ---------------------------------------------------------------
| Script
*/
	echo 'Processing...<br />';

	// Get status
	$get_config = get_config($con);

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
			VALUES ('sync_products_to_odoo', '".$sync_status_j."')
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

	// get product list
	// we will implemnet a way to trim down product list by categories
    // so that process time is not affected (the shorter the better)
	// but for now, we do this manually

    $category_id =
        //'133'  // tops #14
        //'185'  // bottoms #15 with 2 errors SH4126, SH5949
        //'200'  // prom_dresses #9
        //'198'  // mother_of_bride_dresses #13
        //'197'  // wedding_dresses #27 with 1 error D9081LB
        //'196'  // cocktail_dresses #15 with 1 error D9279A
        '195'  // evening_dresses #610 not yet synced
    ;

	$list_prods = "
		SELECT
			`tbl_product`.`prod_id`, `tbl_product`.`prod_no`, `tbl_product`.`prod_name`, `tbl_product`.`prod_desc`, `tbl_product`.`prod_date`, `tbl_product`.`categories`,
			`tbl_product`.`less_discount`, `tbl_product`.`catalogue_price`, `tbl_product`.`wholesale_price`, `tbl_product`.`wholesale_price_clearance`, `designer`.`des_id`,
			`designer`.`designer`, `vendors`.`vendor_id`, `vendors`.`vendor_name`, `vendors`.`vendor_code`, `vendor_types`.`type`, `c2`.`category_name` AS `subcat_name`,
			`tblcolor`.`color_code`, `tblcolor`.`color_name`, `tbl_stock`.`st_id`, `tbl_stock`.`color_facets`, `tbl_stock`.`color_publish`, `tbl_stock`.`custom_order`,
			`tbl_stock`.`new_color_publish`, `tbl_stock`.`primary_color`, `size_0`, `size_2`, `size_4`, `size_6`, `size_8`, `size_10`, `size_12`, `size_14`, `size_16`, `size_18`, `size_20`,
			`size_22`, `size_ss`, `size_sm`, `size_sl`, `size_sxl`, `size_sxxl`, `size_sxl1`, `size_sxl2`, `tbl_product`.`size_mode`, `tbl_product`.`primary_img`,
			`tbl_product`.`primary_img_id`, `tbl_product`.`publish`, `tbl_product`.`public`, `tbl_product`.`view_status`, `tbl_product`.`styles`, `tbl_product`.`events`,
			`tbl_product`.`trends`, `tbl_product`.`materials`, `media_library_products`.`media_path`, `media_library_products`.`media_name`, `media_library_products`.`upload_version`,
			(CASE WHEN designer.url_structure = 'basix-black-label' THEN 'basixblacklabel' ELSE designer.url_structure END) AS d_url_structure,
			(CASE WHEN designer.url_structure = 'basix-black-label' THEN 'basixblacklabel' ELSE designer.url_structure END) AS folder, `c1`.`category_slug` as `c_url_structure`,
			(CASE WHEN c1.category_slug = 'apparel' THEN 'WMANSAPREL' ELSE c1.category_slug END) AS cat_folder,
			(CASE WHEN c2.category_slug = 'cocktail-dresses' THEN 'cocktail' WHEN c2.category_slug = 'evening-dresses' THEN 'evening' ELSE c2.category_slug END) AS sc_url_structure,
			(CASE WHEN c2.category_slug = 'cocktail-dresses' THEN 'cocktail' WHEN c2.category_slug = 'evening-dresses' THEN 'evening' ELSE c2.category_slug END) AS subcat_folder,
			(CASE WHEN tbl_stock.custom_order = '3' THEN tbl_product.catalogue_price ELSE tbl_product.less_discount END) AS net_price
		FROM
			`tbl_product`
			LEFT JOIN `designer` ON `designer`.`des_id` = `tbl_product`.`designer`
			LEFT JOIN `vendors` ON `vendors`.`vendor_id` = `tbl_product`.`vendor_id`
			LEFT JOIN `vendor_types` ON `vendor_types`.`id` = `vendors`.`vendor_type_id`
			LEFT JOIN `categories` `c1` ON `c1`.`category_id` = `tbl_product`.`cat_id`
			LEFT JOIN `categories` `c2` ON `c2`.`category_id` = `tbl_product`.`subcat_id`
			LEFT JOIN `tbl_stock` ON `tbl_stock`.`prod_no` = `tbl_product`.`prod_no`
			LEFT JOIN `media_library_products` ON `media_library_products`.`media_id` = `tbl_stock`.`image_url_path`
			LEFT JOIN `tblcolor` ON `tblcolor`.`color_name` = `tbl_stock`.`color_name`
		WHERE
			`tbl_product`.`categories` LIKE '%\"".$category_id."\"%' ESCAPE '!'
			AND (`tbl_product`.`public` = 'Y' OR `tbl_product`.`public` = 'N')
            AND `designer`.`url_structure` = 'basixblacklabel'
			AND `designer`.`view_status` = 'Y'
		ORDER BY
			`seque` ASC,
			`tbl_stock`.`primary_color` DESC
	";
	$q_list_prods = mysqli_query($con, $list_prods) or die(
		'You have a MySQLi error at "'.pathinfo(__FILE__, PATHINFO_BASENAME).'" line '.__LINE__.':'
		.mysqli_error($con).'<br />'
		.$list_prods
	);

	if (mysqli_num_rows($q_list_prods) > 0)
	{
		while ($row = mysqli_fetch_array($q_list_prods, MYSQLI_ASSOC))
		{
			// get the category slugs
			$categories = json_decode($row['categories'], TRUE);
			$category_slugs = array();
			foreach ($categories as $cat_id)
			{
				array_push($category_slugs, get_slug($con, $cat_id));
			}

			$post_ary_to_odoo['prod_id'] = $row['prod_id'];
			$post_ary_to_odoo['prod_no'] = $row['prod_no'];
			$post_ary_to_odoo['prod_name'] = $row['prod_name'];
			$post_ary_to_odoo['prod_date'] = $row['prod_date'];
			$post_ary_to_odoo['view_status'] = $row['view_status'];
			$post_ary_to_odoo['public'] = $row['public'];
			$post_ary_to_odoo['publish'] = $row['publish'];
			$post_ary_to_odoo['designer'] = $row['des_id'];
			$post_ary_to_odoo['designer_slug'] = $row['d_url_structure'];
			$post_ary_to_odoo['categories'] = $row['categories'];
			$post_ary_to_odoo['category_slugs'] = implode(',', $category_slugs); //json_encode($category_slugs);
			$post_ary_to_odoo['wholesale_price'] = $row['wholesale_price'];
			$post_ary_to_odoo['retail_price'] = $row['less_discount'];
			$post_ary_to_odoo['vendor_id'] = $row['vendor_id'];
			$post_ary_to_odoo['vendor_code'] = $row['vendor_code'];
			$post_ary_to_odoo['vendor_name'] = $row['vendor_name'];
			$post_ary_to_odoo['stock_id'] = $row['st_id'];
			$post_ary_to_odoo['color'] = $row['color_name'];
			$post_ary_to_odoo['color_code'] = $row['color_code'];
			$post_ary_to_odoo['primary_color'] = $row['primary_color'];
			$post_ary_to_odoo['image_url'] = 'https://www.shop7thavenue.com/'.$row['media_path'].$row['prod_no'].'_'.$row['color_code'].'_f.jpg';
			// sizes
			$post_ary_to_odoo['size_0'] = $row['size_0'];
			$post_ary_to_odoo['size_2'] = $row['size_2'];
			$post_ary_to_odoo['size_4'] = $row['size_4'];
			$post_ary_to_odoo['size_6'] = $row['size_6'];
			$post_ary_to_odoo['size_8'] = $row['size_8'];
			$post_ary_to_odoo['size_10'] = $row['size_10'];
			$post_ary_to_odoo['size_12'] = $row['size_12'];
			$post_ary_to_odoo['size_14'] = $row['size_14'];
			$post_ary_to_odoo['size_16'] = $row['size_16'];
			$post_ary_to_odoo['size_18'] = $row['size_18'];
			$post_ary_to_odoo['size_20'] = $row['size_20'];
			$post_ary_to_odoo['size_22'] = $row['size_22'];

			// pass to odoo
			$odoo_response = post_to_odoo($post_ary_to_odoo);

			// echo notice
			echo $row['prod_no'].' - posted<br />';
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
		$_curlopt_url = 'http://70.32.74.131:8069/api/create/single/product';

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

	function get_slug($con, $category_id = '')
	{
		$get_slug = "
			SELECT category_slug
			FROM categories
			WHERE category_id = '".$category_id."'
		";
		$q_get_slug = mysqli_query($con, $get_slug) or die(
			'You have a MySQLi error at "'.pathinfo(__FILE__, PATHINFO_BASENAME).'" line '.__LINE__.':'
			.mysqli_error($con).'<br />'
			.$get_slug
		);

		if (mysqli_num_rows($q_get_slug) > 0)
		{
			$row = mysqli_fetch_array($q_get_slug, MYSQLI_ASSOC);

			return $row['category_slug'];
		}
		else return FALSE;
	}

	function update_config($con, $params)
	{
		$upd_config = "
			UPDATE config
			SET config_value = '".$params."'
			WHERE config_name = 'sync_products_to_odoo'
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
			WHERE config_name = 'sync_products_to_odoo'
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
