<?php 
if ( ! defined('BASEPATH')) exit('ERROR: 404 Not Found');

/**
 * Odoo Class
 *
 * @package		CodeIgniter
 * @subpackage	Custom Library
 * @category	Colors, Color List
 * @author		WebGuy
 * @link		
 */
class Odoo
{
	/**
	 * Odoo API Key
	 *
	 * One server, one API Key from Odoo
	 *
	 * @var	string
	 */
	public $api_key = 'uv2_Mqc0mLXgNIlqeZoGv4vncaOs0O2QVdVvjtYkurrthciGUsnL1ohDEvbQh2sFbWe8BSqJ5qf';
	
	/**
	 * Odoo API Url's
	 *
	 * @var	string
	 */
	public $api_url_add_product = 'http://70.32.74.131:8069/api/create/single/product';
	public $api_url_edit_product = 'http://70.32.74.131:8069/api/update/product/';
	public $api_url_del_product = 'http://70.32.74.131:8069/api/delete/product/';
	
	public $api_url_add_vendor = 'http://70.32.74.131:8069/api/create/vendors';
	public $api_url_edit_vendor = 'http://70.32.74.131:8069/api/update/vendor/';
	public $api_url_del_vendor = 'http://70.32.74.131:8069/api/delete/vendor/';
	
	//public $api_url_add_ws = 'http://70.32.74.131:8069/api/create/wholesale_user';
	//public $api_url_edit_ws = 'http://70.32.74.131:8069/api/update/wholesale_user/';
	//public $api_url_del_ws = 'http://70.32.74.131:8069/api/delete/wholesale_user/';
	public $api_url_add_ws = 'http://70.32.74.131:8069/api/create/customers';
	public $api_url_edit_ws = 'http://70.32.74.131:8069/api/update/customers/';
	public $api_url_del_ws = 'http://70.32.74.131:8069/api/delete/customers/';
	
	public $api_url_add_cs = 'http://70.32.74.131:8069/api/create/consumers';
	public $api_url_edit_cs = 'http://70.32.74.131:8069/api/update/consumers/';
	public $api_url_del_cs = 'http://70.32.74.131:8069/api/delete/consumers/';
	
	public $api_url_add_sales = 'http://70.32.74.131:8069/api/create/sales_users';
	public $api_url_edit_sales = 'http://70.32.74.131:8069/api/update/sales_users/';
	public $api_url_del_sales = 'http://70.32.74.131:8069/api/delete/sales_users/';
	
	public $api_url_create_po = 'http://70.32.74.131:8069/api/create/purchase_order';
	public $api_url_update_po = 'http://70.32.74.131:8069/api/udpate/purchase_order/';
	public $api_url_del_po = 'http://70.32.74.131:8069/api/delete/purchase_order/';
	
	//public $api_url_create_so = 'http://70.32.74.131:8069/api/create/sales_order';
	//public $api_url_update_so = 'http://70.32.74.131:8069/api/udpate/sales_order/';
	public $api_url_create_so = 'http://70.32.74.131:8069/api/create/sale_order';
	public $api_url_update_so = 'http://70.32.74.131:8069/api/udpate/sale_order/';
	
	/**
	 * Erro message
	 *
	 * @var	string
	 */
	public $error_message = '';
	
	/**
	 * This Class database object holder
	 *
	 * @var	object
	 */
	protected $DB = '';
	
	/**
	 * CI Singleton
	 *
	 * @var	object
	 */
	protected $CI;

	// --------------------------------------------------------------------

	/**
	 * Constructor
	 *
	 * 
	 * @return	void
	 */
	public function __construct()
	{
		$this->CI =& get_instance();
		
		// connect to database
		$this->DB = $this->CI->load->database('instyle', TRUE);
		
		log_message('info', 'Odoo Class Loaded');
	}

	// --------------------------------------------------------------------

	/**
	 * Add Product To Odoo
	 *
	 * @return	void
	 */
	//public function post_data(array $data = array(), $type = '', $add = TRUE)
	public function post_data(array $data = array(), $type = '', $process = 'add')
	{
		if (empty($data))
		{
			$this->error_message = 'Empty $data for Odoo->post_data.';
			
			// nothing more to do...
			return FALSE;
		}
		
		if ($type == '')
		{
			$this->error_message = 'Empty $type for Odoo->post_data.';
			
			// nothing more to do...
			return FALSE;
		}
		
		//
		// A very simple PHP example that sends a HTTP POST to a remote site
		// 
		// set CURLOPT_URL
		switch ($process) {
			case 'add':
				if ($type === 'products') $_curlopt_url = $this->api_url_add_product;
				if ($type === 'vendors') $_curlopt_url = $this->api_url_add_vendor;
				if ($type === 'wholesale_users') $_curlopt_url = $this->api_url_add_ws;
				if ($type === 'sales_users') $_curlopt_url = $this->api_url_add_sales;
				if ($type === 'consumer_users') $_curlopt_url = $this->api_url_add_cs;
				
				if ($type === 'purchase_order') $_curlopt_url = $this->api_url_create_po;
				if ($type === 'sales_order') $_curlopt_url = $this->api_url_create_so;
			break;
			case 'edit':
				if ($type === 'products') $_curlopt_url = $this->api_url_edit_product.$data['prod_id'];
				if ($type === 'vendors') $_curlopt_url = $this->api_url_edit_vendor.$data['vendor_id'];
				if ($type === 'wholesale_users') $_curlopt_url = $this->api_url_edit_ws.$data['user_id'];
				if ($type === 'sales_users') $_curlopt_url = $this->api_url_edit_sales.$data['user_id'];
				if ($type === 'consumer_users') $_curlopt_url = $this->api_url_edit_cs.$data['user_id'];
				
				if ($type === 'purchase_order') $_curlopt_url = $this->api_url_update_po.$data['po_id'];
				if ($type === 'sales_order') $_curlopt_url = $this->api_url_update_so.$data['sales_order_id'];
			break;
			case 'del':
				if ($type === 'products') $_curlopt_url = $this->api_url_del_product.$data['prod_id'];
				if ($type === 'vendors') $_curlopt_url = $this->api_url_del_vendor.$data['vendor_id'];
				if ($type === 'wholesale_users') $_curlopt_url = $this->api_url_del_ws.$data['user_id'];
				if ($type === 'sales_users') $_curlopt_url = $this->api_url_del_sales.$data['user_id'];
				if ($type === 'consumer_users') $_curlopt_url = $this->api_url_del_cs.$data['user_id'];
				// no delete for purchase_order
			break;
		}
		
		// add api_key to data
		$data['client_api_key'] = $this->api_key;
		
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
		
		// check for response errors
		if($response === false)
		{
			$this->error_message = 'Curl error: ' . curl_error($ch);
		}

		// close the connection, release resources used
		curl_close ($ch);
		
		// for debuggin purposes
		//echo $_curlopt_url;
		//echo '<br />';
		//var_dump($response);
		//echo $response;
		//die('<br />died at odoo<br />');
		
		return $response;
	}
	
	// --------------------------------------------------------------------

}
