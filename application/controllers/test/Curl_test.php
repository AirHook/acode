<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Curl_test extends CI_Controller {

	/**
	 * DB Reference
	 *
	 * @var	object
	 */
	protected $DB;

	
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
	}
	
	// ----------------------------------------------------------------------
	
	/**
	 * Index Page for this controller.
	 *
	 * @return	void
	 */
	public function index()
	{
		echo 'Crunching...';
		
		$this->DB->set('cat_id', '2');
		$this->DB->where('id', '1');
		$this->DB->update('tbl_update_images');
		
		/*
		// create a new cURL resource
		$ch = curl_init();

		// set URL and other appropriate options
		curl_setopt($ch, CURLOPT_URL, site_url('test/curl_test/crunch_go'));
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

		// grab URL and pass it to the browser
		curl_exec($ch);

		// close cURL resource, and free up system resources
		curl_close($ch);
		*/
		
		// grab URL 
		//$handle = file_get_contents(site_url('test/curl_test/crunch_go'));
		
		//$exec = exec('php C:\Users\Bongbong\Documents\Websites\acode\application\controllers\test\curl_test.php >> /dev/null 2>&1 &');
		//$exec = exec('php /var/www/vhosts/shop7thavenue.com/application/controllers/test/curl_test.php >> /dev/null 2>&1 &');
		
		echo '<br />';
		echo 'Done';
		
		// set flashdata
		//$_SESSION['success'] = 'crunching';
		//$this->session->mark_as_flash('success');
		
		//redirect('test/curl_test/done');
	}
	
	// ----------------------------------------------------------------------
	
	/**
	 * Crunch Go function
	 *
	 * @return	void
	 */
	public function crunch_go()
	{
		echo 'Crunching...';
		
		$this->DB->set('cat_id', '200');
		$this->DB->where('id', '1');
		$this->DB->update('tbl_update_images');
		
		// load pertinent library/model/helpers
		//$this->load->library('products/product_list');
		
	}
	
	// ----------------------------------------------------------------------
	
	/**
	 * Crunch Go function
	 *
	 * @return	void
	 */
	public function done()
	{
		echo $this->session->success;
		echo '<br />';
		echo 'Done';
		
		// load pertinent library/model/helpers
		//$this->load->library('products/product_list');
		
	}
	
	// ----------------------------------------------------------------------
	
}
