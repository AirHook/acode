<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require '/var/www/html/mysite/mailgun/vendor/autoload.php';
use Mailgun\Mailgun;
class Test extends Frontend_Controller {
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
			$this->load->library('Mailgun\Mailgun');
			$mg = Mailgun::create('39f733fa0bb3e120eab364505ae06692-afab6073-9c4e4342');
			print_r($mg);
			echo "here";
		}
	}
}