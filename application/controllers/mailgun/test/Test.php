<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//require '/var/www/html/mysite/mailgun/vendor/autoload.php';
//use Mailgun\Mailgun;
class Test extends CI_Controller {
	/**
	 * Constructor
	 *
	 * @return	void
	 */
	function __Construct()
	{
		parent::__Construct();
	}
	function index()
	{
		$this->load->view('test/test');
	}
	function sendmail(){
		if(isset($_POST)){
			//Load library and send mail.
			$this->load->library('mailgun/mailgun');
			$to = 	array('developer.ranjan88@gmail.com');
			$this->mailgun->to =implode(',', $to);
			$this->mailgun->subject = "Welcome to Basix Black Label Wholesale Order System";
			$data = $this->_GetData();

			$this->mailgun->message = $this->load->view('templates/activation_email_v1_test', $data, TRUE);

			echo 'before sending...<br />';

			$this->mailgun->Send();

			echo 'after sending...';

			$this->mailgun->clear();
		}
	}
	function SendMailToMailingList(){
		$this->load->library('mailgun/mailgun');
		$this->mailgun->to ="devs@mg.shop7thavenue.com";
		$this->mailgun->subject = "Welcome to Basix Black Label Wholesale Order System";
		$data = $this->_GetData();
			//echo "<pre>";
			//print_r($data);
		$this->mailgun->message = $this->load->view('templates/activation_email_v1_test', $data, TRUE);
		$this->mailgun->Send();
		$this->mailgun->clear();

	}
	function CreateMailingList(){
		if(isset($_POST)){
			$this->load->library('mailgun/mailgun_maillist');
			$this->mailgun_maillist->mailing_list_address = "devs@mg.shop7thavenue.com";
			$this->mailgun_maillist->mailing_list_name = "Developers";
			$this->mailgun_maillist->mailing_list_description = "Developers Testing Mailing List";
			$this->mailgun_maillist->Create_MailingList();
		}
	}
	function GetMailingList(){
		if(isset($_POST)){
			$this->load->library('mailgun/mailgun_maillist');
			$this->mailgun_maillist->GetMailingList();
		}
	}

	function AddMembersToMailingList(){
		if(isset($_POST)){
			$this->load->library('mailgun/mailgun_maillist');//'joe@rcpixel.com','rsbgm@instylenewyork.com','rsbgm@rcpixel.com'
			$this->mailgun_maillist->mailing_list_address = "devs@mg.shop7thavenue.com";
			$this->mailgun_maillist->member_list = '[{"name":"Joe","address": "Joe <joe@rcpixel.com>"},{"name": "Ray", "address": "Ray <rsbgm@instylenewyork.com>"},{"Name":"Ray 1","address":"Ray1<rsbgm@rcpixel.com>"},{"Name":"Hardeep","address":"Harddep<developer.ranjan88@gmail.com>"}]';
			$this->mailgun_maillist->AddMembers();
		}

	}
	private function _GetData(){
		$this->load->library('users/wholesale_user_details');
		$this->load->library('products/product_details');

		// connect to database
		$DB = $this->load->database('instyle', TRUE);
		// get privay Policy
		$DB->select('text');
		$DB->where('title_code', 'wholesale_privacy_notice');
		$q = $DB->get('pages')->row();
		$data['privacy_policy'] = $q->text;
		$data['instock_products'] = $this->_get_thumbs('instock');
		$data['preorder_products'] = $this->_get_thumbs('preorder');
		$data['onsale_products'] = $this->_get_thumbs('onsale');


		// let's set some data and get the message
		$data['username'] = ucwords('Hardeep Kumar');
		$data['email'] = 'expertcoder04@gmail.com';
		$data['password'] = '1234';
		$data['user_id'] = '1';//$this->wholesale_user_details->user_id;
		$data['admin_sales_id'] = '1234';//$this->CI->wholesale_user_details->admin_sales_id;
		$data['sales_rep'] = ucwords('Rey Millares');
		$data['reference_designer'] = 'shop7thavenue';
		$data['designer'] = 'Basix Black Label';
		//$data['designer_site_domain'] = $this->CI->wholesale_user_details->designer_site_domain;
		$data['designer_address1'] = '';
		$data['designer_address2'] = '';
		$data['designer_phone'] = '';
		return $data;
	}

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
		$params['with_stocks'] = $params == 'instock' ? TRUE : FALSE;
		$params['group_products'] = TRUE;
		// others
		$this->products_list->initialize($params);
		$products = $this->products_list->select(
			array(
				'designer.url_structure' => ''
			),
			array( // order conditions
				'seque' => 'asc',
				'tbl_product.prod_no' => 'desc'
			),
			12
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

}
