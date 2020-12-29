<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Special_sale_clearance extends MY_Controller {

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
		//$template = 'consumer_special_sale_invite_mg1'; // send Feb 28, 2020
		$template = 'consumer_special_sale_invite_mg2'; // send Mar 06, 2020
		$message = $this->load->view('templates/'.$template, $data, TRUE);

		// load pertinent library/model/helpers
		$this->load->library('mailgun/mailgun');

		// set up properties
		$this->mailgun->vars = array("designer" => "Basix Black Label", "des_slug" => "basixblacklabel");
		$this->mailgun->o_tag = 'Consumer Special Sale Invite';
		$this->mailgun->from = 'Basix Black Label <help@basixblacklabel.com>';
		$this->mailgun->to = 'consumers@mg.shop7thavenue.com';
		//$this->mailgun->cc = $this->webspace_details->info_email;
		//$this->mailgun->bcc = $this->CI->config->item('dev1_email');
		//$this->mailgun->subject = 'BASIX BLACK LABEL SPECIAL SALE'; // mg1
		$this->mailgun->subject = 'BASIX NEW ARRIVALS ON CLEARANCE SALE'; // mg2
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
			)
		);

		// get previous thumbs sent
		$this->DB->select('config_value');
		$this->DB->where('config_name', 'special_sale_thumbs_sent');
		$q = $this->DB->get('config');
		$row = $q->row();
		$thumbs = json_decode($row->config_value, TRUE);

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
			$this->DB->where('config_name', 'special_sale_thumbs_sent');
			$this->DB->update('config');
			// */

			return $items_array;
		}
		else return FALSE;
	}

	// ----------------------------------------------------------------------

}
