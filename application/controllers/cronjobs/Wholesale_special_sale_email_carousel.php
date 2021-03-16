<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Wholesale_special_sale_email_carousel extends MY_Controller {

	/**
	 * Test Param
	 *
	 * @var	boolean
	 */
	protected $test = FALSE;

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
	 * Primary method to call when no other methods are found in url segment
	 * This method simply lists all sales pacakges
	 *
	 * @return	void
	 */
	public function index($test = '')
	{
		//echo 'Processing...<br />';
		//echo 'Not done...';
		//die();

		if ($test)
		{
			$this->test = TRUE;
		}

		// check if this carousel is turned on
		$this->DB->where('config_name', 'wholesale_special_sale_email_carousel');
		$q1 = $this->DB->get('config');
		$r1 = $q1->row();

		if (isset($r1))
		{
			$carousel_switch = $r1->config_value;
		}
		else $carousel_switch = '0';

		if ($carousel_switch == '0')
		{
			echo 'Nothing to process. Goodbye.';
			exit;
		}

		echo 'Processing...'.PHP_EOL;

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

		// info debugger
		echo 'Getting the 30 thumbs using parameter "onsale"...'.PHP_EOL;

		// let's get some thumbs
		// returned as items in an array (<prod_no>_<color_code>)
		//$data['instock_products'] = $this->_get_thumbs('instock');
		//$data['preorder_products'] = $this->_get_thumbs('preorder');
		$data['availability'] = 'onsale'; // availability params used on url for landing page button
		$data['onsale_products'] = $this->_get_thumbs('onsale');
		// check _get_thumbs() as passed properties are not used at this time

		// info debugger
		echo 'Continuing...'.PHP_EOL;

		// record proudct into a csv format for use on url
		$data['items_csv'] = implode(',', $data['onsale_products']);

		// lets set the hashed time code used for the access_link so that the batch holds the same tc only
		$data['tc'] = md5(@date('Y-m-d', time()));

		$data['name'] = '';
		$data['designer'] = '';

		// grab template and infuse data and set message
		$template = 'wholesale_instock_carousel';
		$message = $this->load->view('templates/'.$template, $data, TRUE);

		// we need to rotate on a list of email subjects
		// get record
		$this->DB->where('config_name', 'wholesale_special_sale_subjects');
		$q1 = $this->DB->get('config');
		$r1 = $q1->row();
		$subjects = json_decode($r1->config_value, TRUE);

		// check last used subject using index key
		$this->DB->where('config_name', 'wholesale_special_sale_subjects_key');
		$q2 = $this->DB->get('config');
		$r2 = $q2->row();
		$key_to_use = $r2->config_value + 1;
		$subject_key = $key_to_use >= count($subjects) ? 0 : $key_to_use;

		if ( ! $this->test)
		{
			// save new random key on record
			/* */
			$this->DB->set('config_value', $subject_key);
			$this->DB->set('options', NULL);
			$this->DB->where('config_name', 'wholesale_special_sale_subjects_key');
			$this->DB->update('config');
			// */
		}

		// subjects:
		$subject = $subjects[$subject_key];

		// info debugger
		echo 'Sending to mailgun for mass mailing...'.PHP_EOL;

		if (ENVIRONMENT != 'development')
		{
			// start the email sending
			// load pertinent library/model/helpers
			$this->load->library('mailgun/mailgun');

			// set up properties
			/* */
			$this->mailgun->vars = array("designer" => "Basix Black Label", "des_slug" => "basixblacklabel");
			$this->mailgun->o_tag = 'Wholesale Email Carousel';
			$this->mailgun->from = 'Basix Black Label <help@basixblacklabel.com>';

			if ($this->test)
			{
				$this->mailgun->to = 'test@mg.shop7thavenue.com';
			}
			else
			{
				//$this->mailgun->to = 'test@mg.shop7thavenue.com';
				$this->mailgun->to = 'wholesale_users@mg.shop7thavenue.com';
			}

			//$this->mailgun->cc = $this->webspace_details->info_email;
			//$this->mailgun->bcc = $this->CI->config->item('dev1_email');
			$this->mailgun->subject = $subject;
			$this->mailgun->message = $message;

			// mail send via mailgun
			/* */
			if ( ! $this->mailgun->Send())
			{
				$error = 'Unable to send.'.PHP_EOL;
				$error .= $this->mailgun->error_message;

				echo $error;
				exit;
			}

			$this->mailgun->clear();
			// */
		}
		else
		{
			echo 'SUBJECT: '.$subject;
			echo '<br /><br />';
			echo 'MESSAGE: <br />';
			echo $message;

		}

		echo 'Done<br />';
	}

	// --------------------------------------------------------------------

	/**
	 * Get activation emai product thumbs suggestion
	 *
	 * @params	string
	 * @return	array
	 */
	private function _get_thumbs($str = '')
	{
		// info debugger
		echo 'Get recorded Thumbs Sent Set...'.PHP_EOL;

		// get previous thumbs sent
		$this->DB->select('config_value');
		$this->DB->where('config_name', 'wholesale_special_sale_thumbs_sent');
		$q = $this->DB->get('config');
		$row = $q->row();

		if (isset($row))
		{
			$thumbs = ($row->config_value && ! is_null($row->config_value)) ? json_decode($row->config_value, TRUE) : array();
			$number_of_items_previous_sent = count($thumbs);
		}
		else
		{
			$thumbs = array();
			$number_of_items_previous_sent = 0;
		}

		// info debugger
		echo 'Initial Thumbs Set count - '.count($thumbs).PHP_EOL;
		echo 'Get product list...'.PHP_EOL;

		if ($number_of_items_previous_sent > 0)
		{
			$thumbs_csv = "'".@implode("','", $thumbs)."'";
			$where['condition'][] = "tbl_product.prod_no NOT IN (".$thumbs_csv.")";
		}

		// others
		$where['designer.url_structure'] = 'basixblacklabel';

		// primary param
    	//if ($str) $params['facets'] = array('availability'=>$str);
		//$where['tbl_product.clearance'] = '3';
		$where['tbl_stock.custom_order'] = '3';

		// do not show cs clearance items
		//$con_clearance_cs_only = 'tbl_stock.options NOT LIKE \'%"clearance_consumer_only":"1"%\' ESCAPE \'!\'';
        //$where['condition'][] = $con_clearance_cs_only;

		// PUBLISH PUBLIC
		$where_public = "(
			(
				tbl_product.publish = '1'
				OR tbl_product.publish = '11'
				OR tbl_product.publish = '12'
				OR tbl_product.publish = '2'
			) AND (
				tbl_stock.new_color_publish = '1'
				OR tbl_stock.new_color_publish = '11'
				OR tbl_stock.new_color_publish = '12'
				OR tbl_stock.new_color_publish = '2'
			)
		)";
		$where['condition'][] = $where_public;

		// get the products list
		// show items even without stocks at all
		$params['with_stocks'] = TRUE;	// FALSE for including no stock items
		$params['group_products'] = FALSE; // FALSE for all variants
		// load and initialize class
		$this->load->library('products/products_list');
		$this->products_list->initialize($params);
		$products = $this->products_list->select(
			// where conditions
			$where,
			// sorting conditions
			array(
				'seque' => 'asc',
				'tbl_product.prod_no' => 'desc'
			)
		);
		$list_count = $this->products_list->row_count;

		//echo $this->products_list->last_query; die();

		// info debugger
		echo 'Prodct list query count - '.$list_count.PHP_EOL;

		// capture product numbers and set items array
		if ($products)
		{
			// info debugger
			echo 'Settings items array...'.PHP_EOL;

			$cnt = 0;
			$items_array = array();
			foreach ($products as $product)
			{
				if ( ! in_array($product->prod_no.'_'.$product->color_code, $thumbs))
				{
					array_push($items_array, $product->prod_no.'_'.$product->color_code);
					array_push($thumbs, $product->prod_no.'_'.$product->color_code);
					$cnt++;
				}

				if ($cnt == 30) break;
			}
		}
		else
		{
			// info debugger
			echo 'No product queried. Nothing more to do...'.PHP_EOL;
			return FALSE;
		}

		// info debugger
		echo 'Final Thumbs Set count with new item array included - '.count($thumbs).PHP_EOL;
		echo 'Checking counts and items array...'.PHP_EOL;

		if ($list_count <= count($thumbs))
		{
			// info debugger
			echo 'Product list is equal and lower to items array...'.PHP_EOL;
			echo 'Reset recorded items array...'.PHP_EOL;

			if ( ! $this->test)
			{
				// update previous thumbs sent
				/* */
				$this->DB->set('config_value', NULL);
				$this->DB->set('options', NULL);
				$this->DB->where('config_name', 'wholesale_special_sale_thumbs_sent');
				$this->DB->update('config');
				// */
			}
		}
		else
		{
			// info debugger
			echo 'Saved new items array...'.PHP_EOL;

			if ( ! $this->test)
			{
				// update previous thumbs sent
				/* */
				$this->DB->set('config_value', json_encode($thumbs));
				$this->DB->set('options', NULL);
				$this->DB->where('config_name', 'wholesale_special_sale_thumbs_sent');
				$this->DB->update('config');
				// */
			}
		}

		// info debugger
		echo 'Items array saved...'.PHP_EOL;

		return $items_array;
	}

	// ----------------------------------------------------------------------

}
