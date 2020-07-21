<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Wholesale_special_sale_email_carousel extends MY_Controller {

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
	public function index()
	{
		//echo 'Processing...<br />';
		//echo 'Not done...';
		//die();

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
		// returned as items in an array (<prod_no>_<color_code>)
		// currently equivalent to https://www.shop7thavenue.com/shop/basixblacklabel/womens_apparel.html
		$data['onsale_products'] = $this->_get_thumbs('instock');
		$data['items_csv'] = implode(',', $data['onsale_products']);

		// lets set the hashed time code used for the access_link so that the batched hold the same tc only
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
		$subject_key = $r2->config_value == '3' ? 0 : $r2->config_value + 1;

		// save new random ket on record
		$this->DB->set('config_value', $subject_key);
		$this->DB->set('options', NULL);
		$this->DB->where('config_name', 'wholesale_special_sale_subjects_key');
		$this->DB->update('config');

		// subjects:
		$subject = $subjects[$subject_key];

		// start the email sending
		// load pertinent library/model/helpers
		$this->load->library('mailgun/mailgun');

		// set up properties
		/* */
		$this->mailgun->vars = array("designer" => "Basix Black Label", "des_slug" => "basixblacklabel");
		$this->mailgun->o_tag = 'Wholesale Email Carousel';
		$this->mailgun->from = 'Basix Black Label <help@basixblacklabel.com>';

		//$this->mailgun->to = 'test@mg.shop7thavenue.com';
		$this->mailgun->to = 'wholesale_users@mg.shop7thavenue.com';

		//$this->mailgun->cc = $this->webspace_details->info_email;
		//$this->mailgun->bcc = $this->CI->config->item('dev1_email');
		//$this->mailgun->subject = $subjects[$rand_key];
		$this->mailgun->subject = $subject;
		$this->mailgun->message = $message;

		if ( ! $this->mailgun->Send())
		{
			$error = 'Unable to send.<br />';
			$error .= $this->mailgun->error_message;

			echo $error;
			exit;
		}

		$this->mailgun->clear();
		// */

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

		if ($number_of_items_previous_sent > 0)
		{
			$thumbs_csv = "'".@implode("','", $thumbs)."'";
			$where['condition'][] = "tbl_product.prod_no NOT IN (".$thumbs_csv.")";
		}

		// others
		$where['designer.url_structure'] = 'basixblacklabel';

		// primary param
    	if ($str) $params['facets'] = array('availability'=>$str);

		// get the products list
		// show items even without stocks at all
		$params['with_stocks'] = TRUE;	// FALSE for including no stock items
		$params['group_products'] = TRUE; // FALSE for all variants
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

		// this 'if' condition only means that we have used all items for sending
		// thus, we need to reset the 'special_sale_thumbs_sent' to empty
		if ($list_count == 0)
		{
			// reset $thumbs
			$thumbs = array();

			// reset $thumbs record
			/* */
			$this->DB->set('config_value', json_encode($thumbs));
			$this->DB->set('options', NULL);
			$this->DB->where('config_name', 'wholesale_special_sale_thumbs_sent');
			$this->DB->update('config');
			// */

			// redo query
			$this->products_list->initialize($params);
			$products = $this->products_list->select(
				// where conditions
				array(
					'designer.url_structure' => 'basixblacklabel'
				),
				// sorting conditions
				array(
					'seque' => 'asc',
					'tbl_product.prod_no' => 'desc'
				)
			);
		}

		// capture product numbers and set items array
		if ($products)
		{
			$cnt = 0;
			$items_array = array();
			foreach ($products as $product)
			{
				if ( ! in_array($product->prod_no, $thumbs))
				{
					array_push($items_array, $product->prod_no.'_'.$product->color_code);
					array_push($thumbs, $product->prod_no);
					$cnt++;
				}

				if ($cnt == 30) break;
			}

			// update previous thumbs sent
			/* */
			$this->DB->set('config_value', json_encode($thumbs));
			$this->DB->set('options', '');
			$this->DB->where('config_name', 'wholesale_special_sale_thumbs_sent');
			$this->DB->update('config');
			// */

			return $items_array;
		}
		else return FALSE;
	}

	// ----------------------------------------------------------------------

}
