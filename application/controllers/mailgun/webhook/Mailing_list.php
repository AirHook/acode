<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mailing_list extends MY_Controller {

	/**
	 * Mailgun API Key
	 *
	 * @var	string
	 */
	protected $key;

    /**
	 * Mailgun API Domain
	 *
	 * @var	string
	 */
	protected $domain;


	/**
	 * DB Object
	 *
	 * @var	object
	 */
	protected $DB;

	// ----------------------------------------------------------------------

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

		// set some default properties
		$this->domain = $this->config->item('mailgun_domain');
		$this->key = $this->config->item('mailgun_api');
    }

	// ----------------------------------------------------------------------

	/**
	 * Index - default method
	 *
	 * Create a Mailing List via API
	 *
	 * @return	void
	 */
	public function index()
	{
		// set main email header params accordingly
        //$params['address'] = 'test@mg.shop7thavenue.com';
        //$params['description'] = 'Test Mailing List';
		//$params['address'] = 'consumers@mg.shop7thavenue.com';
        //$params['description'] = 'Consumer Users';
		$params['address'] = 'wholesale_users@mg.shop7thavenue.com';
        $params['description'] = 'Wholesale Users';

		// let do the curl to create a mailing with above params
        $csess = curl_init('https://api.mailgun.net/v3/lists');

        // set settings
        curl_setopt($csess, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($csess, CURLOPT_USERPWD, 'api:'.$this->key);
        curl_setopt($csess, CURLOPT_POST, true);
        curl_setopt($csess, CURLOPT_POSTFIELDS, $params);
        curl_setopt($csess, CURLOPT_HEADER, false);
        //curl_setopt($csess, CURLOPT_HTTPHEADER, array('Content-Type: multipart/form-data')); // used for attachments
        curl_setopt($csess, CURLOPT_ENCODING, 'UTF-8');
        curl_setopt($csess, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($csess, CURLOPT_SSL_VERIFYPEER, false);

        // get response
        $response = curl_exec($csess);

        // close curl
        curl_close($csess);

        // convert to array
        $results = json_decode($response, true);

		echo '<pre>';
		print_r($results);
		echo '<br />';
		echo 'done';
	}

	// ----------------------------------------------------------------------

	/**
	 * Add User member to mailing list
	 *
	 * @return	void
	 */
	public function array_of_sent_clearance_thumbs()
	{
		$thumbs = array(
			'D9869L','D9855A','D9841L','D9811L','D9776L','D9776A','D9761A','D9755LX','D9685L','D9684L',
			'D9659L','D9655L','D9646L','D9624A','D9620L','D9618L','D9582L','D9558A','D9554L','D9536L',
			'D9534A','D9533L','D9525L',
			'D9954L','D9915L','D9904L','D9814L','D9696L','D9541L','D9521L','D9512L','D9505L','D9503L',
			'D9502L','D9497L','D9483L','D9482L','D9418L','D9416L','D9412L','D9411L','D9405L','D9404L',
			'D9400L','D9395L','D9390L','D9387L','D9378L','D9375L','D9372L','D9345L','D9321LM','D9318L'
		);

		$this->DB->set('config_value', json_encode($thumbs));
		$this->DB->set('options', '');
		$this->DB->where('config_name', 'special_sale_thumbs_sent');
		$this->DB->update('config');

		echo $this->DB->affected_rows();
	}

	// ----------------------------------------------------------------------

	/**
	 * Add User member to mailing list
	 *
	 * @return	void
	 */
	public function get_array_of_sent_clearance_thumbs()
	{
		$this->DB->select('config_value');
		$this->DB->where('config_name', 'special_sale_thumbs_sent');
		$q = $this->DB->get('config');
		$row = $q->row();

		if (isset($row))
		{
			$thumbs = json_decode($row->config_value, TRUE);
			echo count($thumbs).'<br />';

			foreach ($thumbs as $thumb)
			{
				echo $thumb.'<br />';
			}
		}
		else
		{
			echo 'No records found.';
		}
	}

	// ----------------------------------------------------------------------

	/**
	 * Add User member to mailing list
	 *
	 * @return	void
	 */
	public function add_users()
	{
		// load pertinent library/model/helpers
		$this->load->library('mailgun/validate_email');

		//echo '500<br />';
		//echo '500, 500<br />';
		//echo '500, 1000<br />';
		//echo '500, 1500<br />';
		//echo '500, 2000<br />';
		//echo '500, 2500<br />';
		//echo '500, 3000<br />';
		//echo '500, 3500<br />';
		//echo '500, 4000<br />';
		//echo '500, 4500<br />';
		//echo '500, 5000<br />';
		//echo '500, 5500<br />';
		//echo '500, 6000<br />';
		//echo '500, 6500<br />';
		//echo '500, 7000<br />';
		//echo '500, 7500<br />';
		//echo '500, 8000<br />';
		//echo '500, 8500<br />';
		//echo '500, 9000<br />';
		//echo '500, 9500<br />';
		//echo '500, 10000<br />';
		//echo '500, 10500<br />';
		//echo '500, 11500<br />';
		//echo '500, 12000<br />';
		//echo '500, 12500<br />';
		//echo '500, 13000<br />';
		//echo '500, 13500<br />';
		//echo '500, 14000<br />';
		//echo '500, 14500<br />';
		//echo '500, 15000<br />';
		//echo '500, 15500<br />';
		//echo '500, 16000<br />';
		//echo '500, 16500<br />';
		echo '500, 17000<br />';

		$this->DB->limit(500, 17000); // 500, 500 ...
		$query = $this->DB->get('tbluser_data');

		if ($query->num_rows() == 0)
		{
			// nothing more to do...
			echo 'No records found.';
			exit;
		}
		else
		{
			$undeliverable = array();
			$users_ary = array();
			foreach ($query->result() as $row)
			{
				// initialize and validate email
				$this->validate_email->initialize(array('email'=>$row->email));
				$is_valid_email = $this->validate_email->validate();

				if ($is_valid_email == 'deliverable')
				{
					// set params to pass to mailgun on export
					$user['subscribed'] = TRUE;
					$user['description'] = 'Consumer User';
					$user['address'] = $row->email;
					$user['name'] = ucwords($row->firstname.' '.$row->lastname);

					array_push($users_ary, $user);
				}
				else
				{
					// set undeliverable emails status to 3
					$this->DB->set('is_active', '3');
					$this->DB->where('user_id', $row->user_id);
					$this->DB->update('tbluser_data');

					// collate undeliverable emails and their reasons
					$undeliverable[$row->email] = $this->validate_email->reason;
				}

				$this->validate_email->clear();
			}

			// set main email header params accordingly
			$params['upsert'] = TRUE;
			$params['members'] = json_encode($users_ary);

			// set vars per user to be able to access it as %recipient.yourvars%
			//$params['vars'] = '{"designer":"Basix Black Labe",...}'

			// let do the curl
			$csess = curl_init('https://api.mailgun.net/v3/lists/consumers@mg.shop7thavenue.com/members.json');

			// set settings
			curl_setopt($csess, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
			curl_setopt($csess, CURLOPT_USERPWD, 'api:'.$this->key);
			curl_setopt($csess, CURLOPT_POST, true);
			curl_setopt($csess, CURLOPT_POSTFIELDS, $params);
			curl_setopt($csess, CURLOPT_HEADER, false);
			//curl_setopt($csess, CURLOPT_HTTPHEADER, array('Content-Type: multipart/form-data')); // used for attachments
			curl_setopt($csess, CURLOPT_ENCODING, 'UTF-8');
			curl_setopt($csess, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($csess, CURLOPT_SSL_VERIFYPEER, false);

			// get response
			$response = curl_exec($csess);

			// close curl
			curl_close($csess);

			// convert to array
			$results = json_decode($response, true);
		}

		echo '<pre>';
		print_r($results);
		echo '<br />';
		print_r($undeliverable);
		echo '<br />';
		echo 'done';
	}

	// ----------------------------------------------------------------------

	/**
	 * Add User member to mailing list
	 * Or update mailing with current active wholesale users
	 * Does not remove from mialgun list those that are not in server list
	 *
	 * @return	void
	 */
	public function add_wholesale_users()
	{
		// load pertinent library/model/helpers
		$this->load->library('mailgun/validate_email');

		//echo '250<br />';
		//echo '250, 250<br />';
		//echo '250, 500<br />';
		//...
		//echo '500, 17000<br />';

		$this->DB->join('designer', 'designer.url_structure = tbluser_data_wholesale.reference_designer');
		$this->DB->where('is_active', '1');
		$this->DB->where('admin_sales_email', 'help@basixblacklabel.com');
		$this->DB->where('reference_designer', 'basixblacklabel');
		$this->DB->where('user_id', '14519');
		$this->DB->or_where('user_id', '15019');
		//$this->DB->limit(250, 250); // 250, 250 ...
		$query = $this->DB->get('tbluser_data_wholesale');

		//echo $query->num_rows();
		//echo '<br />';

		if ($query->num_rows() == 0)
		{
			// nothing more to do...
			echo 'No records found.';
			exit;
		}
		else
		{
			$i = 1;
			$members = '[';
			foreach ($query->result() as $row)
			{
				// unable to use json encoded array as the "vars" are formatted differently
				// create the json data manually
				$members.= '{"address":"'.$row->email.'","subscribed":true,"name":"'.ucwords($row->firstname.' '.$row->lastname).'","vars":{"designer":"'.$row->designer.'","designer_slug":"'.$row->reference_designer.'","store_name":"'.$row->store_name.'"}}';

				if ($i < $query->num_rows())
				{
					$members.= ',';
				}

				$i++;
			}
			$members.= ']';

			// set main email header params accordingly
			$params['upsert'] = TRUE;
			$params['members'] = $members;

			echo '<pre>';
			print_r($params);
			die();

			// set vars per user to be able to access it as %recipient.yourvars%
			//$params['vars'] = '{"designer":"Basix Black Labe",...}'
			//$response = '{}';

			// let do the curl
			/* */
			$csess = curl_init('https://api.mailgun.net/v3/lists/wholesale_users@mg.shop7thavenue.com/members.json');

			// set settings
			curl_setopt($csess, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
			curl_setopt($csess, CURLOPT_USERPWD, 'api:'.$this->key);
			curl_setopt($csess, CURLOPT_POST, true);
			curl_setopt($csess, CURLOPT_POSTFIELDS, $params);
			curl_setopt($csess, CURLOPT_HEADER, false);
			//curl_setopt($csess, CURLOPT_HTTPHEADER, array('Content-Type: multipart/form-data')); // used for attachments
			curl_setopt($csess, CURLOPT_ENCODING, 'UTF-8');
			curl_setopt($csess, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($csess, CURLOPT_SSL_VERIFYPEER, false);

			// get response
			$response = curl_exec($csess);

			// close curl
			curl_close($csess);
			// */

			// convert to array
			$results = json_decode($response, true);
		}

		echo '<pre>';
		print_r($results);
		echo '<br />';
		echo 'done';
	}

	// ----------------------------------------------------------------------

	/**
	 * Request to validate all emails of the mailing list
	 *
	 * @return	void
	 */
	public function validate($email = '')
	{
		if ( ! $email)
		{
			// nothing more to do...
			return FALSE;
		}

		// load pertinent library/model/helpers
		$this->load->library('mailgun/validate_email');

		// initialize and validate email
		$this->validate_email->initialize(array('email'=>$email));
		$result = $this->validate_email->validate();

		return $result;
	}

	// ----------------------------------------------------------------------

	/**
	 * Request to validate all emails of the mailing list
	 *
	 * @return	void
	 */
	public function validate_email($email = '')
	{
		// set list name
		//$email = 'xasdfs@asdlkjsad.com';
		//$email = 'rsbgm@rcpixel.com';

		// set url
		//$url = 'https://api.mailgun.net/v3/lists/'.$list_name.'/validate';
		$url = 'https://api.mailgun.net/v4/address/validate?address='.$email;

		// let do the curl
		$csess = curl_init($url);

        // set settings
        curl_setopt($csess, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($csess, CURLOPT_USERPWD, 'api:'.$this->key);
        //curl_setopt($csess, CURLOPT_POST, true);
        //curl_setopt($csess, CURLOPT_POSTFIELDS, $params);
        curl_setopt($csess, CURLOPT_HEADER, false);
        //curl_setopt($csess, CURLOPT_HTTPHEADER, array('Content-Type: multipart/form-data'));
        curl_setopt($csess, CURLOPT_ENCODING, 'UTF-8');
        curl_setopt($csess, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($csess, CURLOPT_SSL_VERIFYPEER, false);

        // get response
        $response = curl_exec($csess);

        // close curl
        curl_close($csess);

        // convert to array
        $results = json_decode($response, true);

		// sample return results
		/*
		print_r($results);
		Array
		(
		    [address] => xasdfs@asdlkjsad.com
		    [is_disposable_address] =>
		    [is_role_address] =>
		    [reason] => Array
		        (
		            [0] => No MX records found for domain 'asdlkjsad.com'
		        )

		    [result] => undeliverable
		    [risk] => high
		)
		return $results['result'];
		// */

		echo '<pre>';
		print_r($results);
		echo '<br />';
		echo 'done';
	}

	// ----------------------------------------------------------------------

	/**
	 * Get Validate Status
	 *
	 * @return	void
	 */
	public function get_validate_status()
	{
		/*
		Actual response
		Array
		(
		    [created_at] => 1582041946
		    [download_url] => Array
		        (
		            [csv] => https://use1-mg-validation.s3.amazonaws.com/...
		            [json] => https://use1-mg-validation.s3.amazonaws.com/...
		        )

		    [id] => test@mg.shop7thavenue.com
		    [quantity] => 3
		    [records_processed] => 3
		    [status] => uploaded
		    [summary] => Array
		        (
		            [result] => Array
		                (
		                    [deliverable] => 3
		                    [do_not_send] => 0
		                    [undeliverable] => 0
		                    [unknown] => 0
		                )

		            [risk] => Array
		                (
		                    [high] => 0
		                    [low] => 0
		                    [medium] => 3
		                    [unknown] => 0
		                )

		        )

		)
		Downloaded data
		[
		    {"risk": "medium", "is_role_address": false, "reason": ["unknown_provider"], "result": "deliverable", "address": "joe@rcpixel.com", "is_disposable_address": false},
		    {"risk": "medium", "is_role_address": false, "reason": ["unknown_provider"], "result": "deliverable", "address": "john@doe.com", "is_disposable_address": false},
		    {"risk": "medium", "is_role_address": false, "reason": ["unknown_provider"], "result": "deliverable", "address": "rsbgm@instylenewyork.com", "is_disposable_address": false}
		]
		*/

		// set url
		$list_name = 'consumers@mg.shop7thavenue.com';
		$url = 'https://api.mailgun.net/v4/address/validate/bulk/'.$list_name; // specific list
		//$url = 'https://api.mailgun.net/v4/address/validate/bulk'; // all validation jobs

		// let do the curl
		$csess = curl_init($url);

        // set settings
        curl_setopt($csess, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($csess, CURLOPT_USERPWD, 'api:'.$this->key);
        //curl_setopt($csess, CURLOPT_POST, true);
        //curl_setopt($csess, CURLOPT_POSTFIELDS, $params);
        curl_setopt($csess, CURLOPT_HEADER, false);
        //curl_setopt($csess, CURLOPT_HTTPHEADER, array('Content-Type: multipart/form-data')); // used for attachments
        curl_setopt($csess, CURLOPT_ENCODING, 'UTF-8');
        curl_setopt($csess, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($csess, CURLOPT_SSL_VERIFYPEER, false);

        // get response
        $response = curl_exec($csess);

        // close curl
        curl_close($csess);

        // convert to array
        $results = json_decode($response, true);

		echo '<pre>';
		print_r($results);
		echo '<br />';
		echo 'done';
	}

	// ----------------------------------------------------------------------

	/**
	 * Request to validate all emails of the mailing list
	 *
	 * @return	void
	 */
	public function test_send()
	{
		echo 'Processing...<br />';

		// load pertinent library/model/helpers
		$this->load->library('email');
		$this->load->library('products/product_details');

		// get privay Policy
		$this->DB->select('text');
		$this->DB->where('title_code', 'wholesale_privacy_notice');
		$q = $this->DB->get('pages')->row();
		$data['privacy_policy'] = str_replace(
			array('help@shop7thavenue.com', 'shop7thavenue.com'),
			array('help@basixblacklabel.com', 'basixblacklabel.com'),
			$q->text
		);

		// let's get some thumbs
		$data['onsale_products'] = $this->_get_thumbs('onsale');

		$data['name'] = '';
		$data['designer'] = '';
		//$data['reference_designer'] = $this->CI->consumer_user_details->reference_designer ?: $this->CI->webspace_details->slug;

		// grab template and infuse data and set message
		$message = $this->load->view('templates/consumer_special_sale_invite_mg1', $data, TRUE);

		// load pertinent library/model/helpers
		$this->load->library('mailgun/mailgun');

		// set up properties
		$this->mailgun->vars = array("designer" => "Basix Black Label", "des_slug" => "basixblacklabel");
		$this->mailgun->o_tag = 'Consumer Special Sale Invite';
		$this->mailgun->from = 'Basix Black Label <help@basixblacklabel.com>';
		$this->mailgun->to = 'consumers@mg.shop7thavenue.com';
		//$this->mailgun->cc = $this->webspace_details->info_email;
		//$this->mailgun->bcc = $this->CI->config->item('dev1_email');
		$this->mailgun->subject = 'BASIX BLACK LABEL SPECIAL SALE';
		$this->mailgun->message = $message;

		if ( ! $this->mailgun->Send())
		{
			$error = 'Unable to send.<br />';
			$error .= $this->mailgun->error_message;

			echo $error;
			exit;
		}

		$this->mailgun->clear();

		echo 'Done<br />';
	}

	// ----------------------------------------------------------------------

	/**
	 * Delete User member from mailing list
	 *
	 * @return	void
	 */
	public function del_user()
	{
		// set main email header params accordingly
		$params['subscribed'] = TRUE;
		$params['description'] = 'Consumer User';
        //$params['address'] = 'rsbgm@instylenewyork.com';
		//$params['name'] = 'Rey Millares';
		//$params['address'] = 'joe@rcpixel.com';
		//$params['name'] = 'Joe Taveras';
		$params['address'] = 'rsbgm@instylenewyork.com';
		$params['name'] = 'John Doe';

		// set vars per user to be able to access it as %recipient.yourvars%
		//$params['vars'] = '{"designer":"Basix Black Labe",...}'

		// let do the curl
        $csess = curl_init('https://api.mailgun.net/v3/lists/test@mg.shop7thavenue.com/members/'.$params['address']);

        // set settings
        curl_setopt($csess, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($csess, CURLOPT_USERPWD, 'api:'.$this->key);
        //curl_setopt($csess, CURLOPT_POST, true);
        curl_setopt($csess, CURLOPT_CUSTOMREQUEST, "DELETE");
        curl_setopt($csess, CURLOPT_HEADER, false);
        //curl_setopt($csess, CURLOPT_HTTPHEADER, array('Content-Type: multipart/form-data')); // used for attachments
        curl_setopt($csess, CURLOPT_ENCODING, 'UTF-8');
        curl_setopt($csess, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($csess, CURLOPT_SSL_VERIFYPEER, false);

        // get response
        $response = curl_exec($csess);

        // close curl
        curl_close($csess);

        // convert to array
        $results = json_decode($response, true);

		echo '<pre>';
		print_r($results);
		echo '<br />';
		echo 'done';
	}

	// --------------------------------------------------------------------

	/**
	 * Get activation emai product thumbs suggestion
	 *
	 * @params	string
	 * @return	array
	 */
	private function _get_thumbs($str)
	{
		// load pertinent library/model/helpers
		$this->load->library('products/products_list');

		// primary item that is changed for the preset salespackages
    	$params['facets'] = array('availability'=>$str);

		// get the products list
		$params['show_private'] = TRUE; // all items general public (Y) - N for private
		$params['view_status'] = 'ALL'; // ALL items view status (Y, Y1, Y2, N)
		$params['variant_publish'] = 'ALL'; // ALL variant level color publish (view status)
		$params['group_products'] = FALSE; // group per product number or per variant
		// show items even without stocks at all
		$params['with_stocks'] = TRUE;	// FALSE for including no stock items
		$params['group_products'] = FALSE; // FALSE for all variants
		// others
		$this->products_list->initialize($params);
		$products = $this->products_list->select(
			array(
				'designer.url_structure' => 'basixblacklabel'
			),
			array( // order conditions
				'seque' => 'asc',
				'tbl_product.prod_no' => 'desc'
			),
			30
		);

		// capture product numbers and set items array
		if ($products)
		{
			$cnt = 0;
			$items_array = array();
			foreach ($products as $product)
			{
				array_push($items_array, $product->prod_no.'_'.$product->color_code);
			}

			return $items_array;
		}
		else return FALSE;
	}

	// ----------------------------------------------------------------------

}
